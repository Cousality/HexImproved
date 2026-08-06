<?php

namespace App\Http\Controllers;

use App\Events\GameMoveMade;
use App\Events\GamePlayerJoined;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public $BoardSize = 7;

    public function create(Request $request)
    {
        $game = Game::createForPlayer($request->user()->id, $this->BoardSize);

        return redirect()->route('game.show', $game);
    }

    public function join(Request $request, Game $game)
    {
        // Ignore if already full, or the visitor is already player1.
        if ($game->isFull() || $game->player1_id === $request->user()->id) {
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

        return view('game', [
            'game' => $game,
            'board' => $game->board,
            'boardSize' => $game->boardSize(),
            'role' => $role, // Null is Not player
            'isMyTurn' => $game->status === 'active' && $game->current_turn === $userId,
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

            if ($neighbourRow >= 0 && $neighbourRow < $boardSize &&
                $neighbourColumn >= 0 && $neighbourColumn < $boardSize) {
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

        $game->board = $board;

        $won = $this->checkWin($board, $boardSize, $role);

        if ($won) {
            $game->status = 'finished';
            $game->winner_id = $userId;
        } else {
            $game->current_turn = $game->opponentId($userId);
        }

        $game->save();

        broadcast(new GameMoveMade(
            $game,
            $validated['row'],
            $validated['column'],
            $role,
            $won
        ));

        return response()->json([
            'row' => $validated['row'],
            'column' => $validated['column'],
            'role' => $role,
            'winner' => $won,
        ]);
    }

    public function reset(Request $request, Game $game)
    {
        if ($game->player1_id !== $request->user()->id && $game->player2_id !== $request->user()->id) {
            abort(403);
        }

        $game->board = Game::emptyBoard($game->boardSize());
        $game->current_turn = $game->player1_id;
        $game->status = $game->isFull() ? 'active' : 'waiting';
        $game->winner_id = null;
        $game->save();

        return response()->json(['message' => 'Game reset']);
    }
}
