<?php

namespace App\Http\Controllers;

use App\Events\GameMoveMade;
use App\Events\GamePlayerJoined;
use App\Models\EloHistory;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public $BoardSize = 7;

    public function create(Request $request)
    {
        $game = Game::createForPlayer($request->user()->id, $this->BoardSize);

        return redirect()->route('game.show', $game);
    }

    public function createAi(Request $request)
    {
        $game = Game::create([
            'player1_id' => $request->user()->id,
            'player2_id' => null,
            'board' => Game::emptyBoard($this->BoardSize),
            'status' => 'active',
            'current_turn' => $request->user()->id,
            'mode' => 'ai',
        ]);

        return redirect()->route('game.show', $game);
    }

    public function join(Request $request, Game $game)
    {
        // AI games never accept a second human player.
        if ($game->mode === 'ai' || $game->isFull() || $game->player1_id === $request->user()->id) {
            return redirect()->route('game.show', $game);
        }

        $game->player2_id = $request->user()->id;
        $game->status = 'active';
        $game->save();

        broadcast(new GamePlayerJoined($game));

        return redirect()->route('game.show', $game);
    }

    public function show(Request $request, Game $game)
    {
        $userId = $request->user()->id;
        $role = $game->playerNumber($userId);
        $isReady = $game->mode === 'ai' || $game->isFull();

        return view('game', [
            'game' => $game,
            'board' => $game->board,
            'boardSize' => $game->boardSize(),
            'role' => $role,
            'isReady' => $isReady,
            'isMyTurn' => $game->status === 'active'
                && $game->current_turn === $userId,
        ]);
    }

    private function neighbours(int $row, int $column, int $boardSize): array
    {
        $directions = [
            [-1, 0],
            [-1, 1],
            [0, -1],
            [0, 1],
            [1, -1],
            [1, 0],
        ];

        $neighbours = [];

        foreach ($directions as $direction) {
            $neighbourRow = $row + $direction[0];
            $neighbourColumn = $column + $direction[1];

            if (
                $neighbourRow >= 0 && $neighbourRow < $boardSize &&
                $neighbourColumn >= 0 && $neighbourColumn < $boardSize
            ) {
                $neighbours[] = ['row' => $neighbourRow, 'column' => $neighbourColumn];
            }
        }

        return $neighbours;
    }

    private function checkWin(array $board, int $boardSize, string $player): bool
    {
        $tilesToCheck = [];
        $visited = [];

        if ($player === 'player1') {
            foreach ($board as $tile) {
                if ($tile['row'] === 0 && $tile['owner'] === $player) {
                    $tilesToCheck[] = $tile;
                }
            }
        } else {
            foreach ($board as $tile) {
                if ($tile['column'] === 0 && $tile['owner'] === $player) {
                    $tilesToCheck[] = $tile;
                }
            }
        }

        while (! empty($tilesToCheck)) {
            $currentTile = array_pop($tilesToCheck);

            $key = $currentTile['row'].'-'.$currentTile['column'];

            if (in_array($key, $visited)) {
                continue;
            }

            $visited[] = $key;

            if ($player === 'player1' && $currentTile['row'] === $boardSize - 1) {
                return true;
            }

            if ($player === 'player2' && $currentTile['column'] === $boardSize - 1) {
                return true;
            }

            foreach ($this->neighbours($currentTile['row'], $currentTile['column'], $boardSize) as $neighbour) {
                foreach ($board as $tile) {
                    if (
                        $tile['row'] === $neighbour['row'] &&
                        $tile['column'] === $neighbour['column'] &&
                        $tile['owner'] === $player
                    ) {
                        $tilesToCheck[] = $tile;
                        break;
                    }
                }
            }
        }

        return false;
    }

    private function chooseAiMove(array $board): ?array
    {
        if (empty($board)) {
            return null;
        }

        $boardSize = max(array_column($board, 'row')) + 1;
        $bestMove = null;
        $bestCost = PHP_INT_MAX;

        foreach ($board as $index => $tile) {
            if ($tile['owner'] !== null) {
                continue;
            }

            $testBoard = $board;
            $testBoard[$index]['owner'] = 'player2';

            $cost = $this->shortestPathCost($testBoard, $boardSize);

            if ($cost < $bestCost) {
                $bestCost = $cost;

                $bestMove = [
                    'row' => $tile['row'],
                    'column' => $tile['column'],
                ];
            }
        }

        return $bestMove;
    }

    private function shortestPathCost(array $board, int $boardSize): int
    {
        $distances = [];
        $queue = [];

        foreach ($board as $tile) {
            if ($tile['column'] == 0 && $tile['owner'] != 'player1') {
                $id = $tile['row'].','.$tile['column'];

                $cost = $tile['owner'] == 'player2' ? 0 : 1;

                $distances[$id] = $cost;

                $queue[] = [
                    'row' => $tile['row'],
                    'column' => $tile['column'],
                    'cost' => $cost,
                ];
            }
        }

        while (! empty($queue)) {
            usort($queue, fn ($a, $b) => $a['cost'] <=> $b['cost']);

            $current = array_shift($queue);

            $row = $current['row'];
            $column = $current['column'];
            $cost = $current['cost'];

            if ($column == $boardSize - 1) {
                return $cost;
            }

            foreach ($this->neighbours($row, $column, $boardSize) as $neighbour) {
                $neighbourTile = collect($board)->first(function ($tile) use ($neighbour) {
                    return $tile['row'] == $neighbour['row']
                        && $tile['column'] == $neighbour['column'];
                });

                if ($neighbourTile['owner'] == 'player1') {
                    continue;
                }

                $id = $neighbour['row'].','.$neighbour['column'];

                $stepCost = $neighbourTile['owner'] == 'player2' ? 0 : 1;

                $newCost = $cost + $stepCost;

                if (! isset($distances[$id]) || $newCost < $distances[$id]) {
                    $distances[$id] = $newCost;

                    $queue[] = [
                        'row' => $neighbour['row'],
                        'column' => $neighbour['column'],
                        'cost' => $newCost,
                    ];
                }
            }
        }

        return 999;
    }

    public function move(Request $request, Game $game)
    {
        $userId = $request->user()->id;
        $role = $game->playerNumber($userId);

        if ($role === null) {
            abort(403, 'You are not a player in this game.');
        }

        if ($game->status !== 'active') {
            abort(422, 'This game is not active.');
        }

        if ($game->current_turn !== $userId) {
            abort(422, "It's not your turn.");
        }

        $boardSize = $game->boardSize();

        $validated = $request->validate([
            'row' => 'required|integer|min:0|max:'.($boardSize - 1),
            'column' => 'required|integer|min:0|max:'.($boardSize - 1),
        ]);

        $board = $game->board;
        $found = false;

        foreach ($board as &$tile) {
            if ($tile['row'] === $validated['row'] && $tile['column'] === $validated['column']) {
                if ($tile['owner'] !== null) {
                    abort(422, 'That tile is already taken.');
                }

                $tile['owner'] = $role;
                $found = true;
                break;
            }
        }
        unset($tile);

        if (! $found) {
            abort(422, 'Invalid tile.');
        }

        $isAiGame = $game->mode === 'ai';
        $humanWon = $this->checkWin($board, $boardSize, $role);
        $winnerRole = null;
        $aiMove = null;
        $moves = [[
            'row' => $validated['row'],
            'column' => $validated['column'],
            'role' => $role,
        ]];

        if ($humanWon) {
            $game->status = 'finished';
            $game->winner_id = $userId;
            $winnerRole = $role;

            if (! $isAiGame) {
                $loserId = $game->opponentId($userId);
                $winner = User::findOrFail($userId);
                $loser = User::findOrFail($loserId);

                // Calculate new Elo ratings for multiplayer games only.
                $k = 32;
                $expectedWinner = 1 / (1 + pow(10, (($loser->elo - $winner->elo) / 400)));
                $expectedLoser = 1 / (1 + pow(10, (($winner->elo - $loser->elo) / 400)));
                $winner->elo = round($winner->elo + $k * (1 - $expectedWinner));
                $loser->elo = round($loser->elo + $k * (0 - $expectedLoser));
                $winner->save();
                $loser->save();

                EloHistory::create([
                    'user_id' => $winner->id,
                    'game_id' => $game->id,
                    'elo' => $winner->elo,
                ]);
                EloHistory::create([
                    'user_id' => $loser->id,
                    'game_id' => $game->id,
                    'elo' => $loser->elo,
                ]);
            }
        } elseif ($isAiGame) {
            $aiMove = $this->chooseAiMove($board);

            if ($aiMove === null) {
                $game->status = 'finished';
                $game->winner_id = null;
                $winnerRole = 'player2';
            } else {
                foreach ($board as &$tile) {
                    if ($tile['row'] === $aiMove['row'] && $tile['column'] === $aiMove['column']) {
                        $tile['owner'] = 'player2';
                        break;
                    }
                }
                unset($tile);

                $moves[] = [
                    'row' => $aiMove['row'],
                    'column' => $aiMove['column'],
                    'role' => 'player2',
                ];

                if ($this->checkWin($board, $boardSize, 'player2')) {
                    $game->status = 'finished';
                    $game->winner_id = null;
                    $winnerRole = 'player2';
                } else {
                    $game->current_turn = $userId;
                }
            }
        } else {
            $game->current_turn = $game->opponentId($userId);
        }

        $game->board = $board;
        $game->save();

        if (! $isAiGame) {
            broadcast(new GameMoveMade(
                $game,
                $validated['row'],
                $validated['column'],
                $role,
                $humanWon
            ));
        }

        return response()->json([
            'moves' => $moves,
            'winner' => $winnerRole,
        ]);
    }

    public function reset(Request $request, Game $game)
    {
        if ($game->player1_id !== $request->user()->id && $game->player2_id !== $request->user()->id) {
            abort(403);
        }

        $game->board = Game::emptyBoard($game->boardSize());
        $game->current_turn = $game->player1_id;
        $game->status = ($game->mode === 'ai' || $game->isFull()) ? 'active' : 'waiting';
        $game->winner_id = null;
        $game->save();

        return response()->json(['message' => 'Game reset']);
    }
}
