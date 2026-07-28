<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public $BoardSize = 7;

    public $Board = [];

    public function show(Request $request)
{
    if (!$request->session()->has('board')) {
        $request->session()->put('board', $this->createBoard());
    }

    $this->Board = $request->session()->get('board');

    return view('game', [
        'board' => $this->Board,
        'boardSize' => $this->BoardSize,
    ]);
}

    private function createBoard()
    {
        $board = [];

        for ($row = 0; $row < $this->BoardSize; $row++) {
            for ($column = 0; $column < $this->BoardSize; $column++) {
                $board[] = [
                    'row' => $row,
                    'column' => $column,
                    'owner' => null,
                ];
            }
        }

        return $board;
    }
    private function neighbours(int $row, int $column): array {
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
                
                if ( $neighbourRow >= 0 && $neighbourRow < $this->BoardSize &&
                    $neighbourColumn >= 0 && $neighbourColumn < $this->BoardSize ) {
                        $neighbours[] = ['row' => $neighbourRow,'column' => $neighbourColumn, ];
                        }
                        }
                        return $neighbours;
    }

private function checkWin(string $player): bool
{
    $tilesToCheck = [];
    $visited = [];

    if ($player === 'player1') {
        foreach ($this->Board as $tile) {
            if ($tile['row'] === 0 && $tile['owner'] === $player) {
                $tilesToCheck[] = $tile;
            }
        }
    } else {
        foreach ($this->Board as $tile) {
            if ($tile['column'] === 0 && $tile['owner'] === $player) {
                $tilesToCheck[] = $tile;
            }
        }
    }

    while (!empty($tilesToCheck)) {
        $currentTile = array_pop($tilesToCheck);

        $key = $currentTile['row'] . '-' . $currentTile['column'];

        if (in_array($key, $visited)) {
            continue;
        }

        $visited[] = $key;

        if (
            $player === 'player1' &&
            $currentTile['row'] === $this->BoardSize - 1
        ) {
            return true;
        }

        if (
            $player === 'player2' &&
            $currentTile['column'] === $this->BoardSize - 1
        ) {
            return true;
        }

        foreach ($this->neighbours(
            $currentTile['row'],
            $currentTile['column']
        ) as $neighbour) {
            foreach ($this->Board as $tile) {
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




    public function move(Request $request)
    {
        $this->Board = $request->session()->get('board', $this->createBoard());
        $validated = $request->validate([
            'row' => 'required|integer|min:0|max:' . ($this->BoardSize - 1),
            'column' => 'required|integer|min:0|max:' . ($this->BoardSize - 1),
            'player' => 'required|in:player1,player2',
        ]);

        // Process the validated move

        $row = $validated['row'];
        $column = $validated['column'];
        $player = $validated['player'];

        foreach ($this->Board as &$tile) {
        if ($tile['row'] === $row && $tile['column'] === $column) {
        $tile['owner'] = $player;
        break;
    }
}

unset($tile);

$request->session()->put('board', $this->Board);

$winner = $this->checkWin($player);

        return response()->json([
    'message' => 'Move processed successfully',
    'row' => $row,
    'column' => $column,
    'player' => $player,
    'winner' => $winner,
            ]);
    }

    public function reset(Request $request)
{
    $request->session()->forget('board');

    return response()->json([
        'message' => 'Game reset',
    ]);
}

    
}
