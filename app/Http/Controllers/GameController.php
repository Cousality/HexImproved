<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public $BoardSize = 7;

    public $Board = [];

    public function show()
    {
        $this->Board = $this->createBoard();

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

    public function move(Request $request)
    {
        $validated = $request->validate([
            'row' => 'required|integer|min:0|max:' . ($this->BoardSize - 1),
            'column' => 'required|integer|min:0|max:' . ($this->BoardSize - 1),
            'player' => 'required|in:player1,player2',
        ]);

        // Process the validated move

        $row = $validated['row'];
        $column = $validated['column'];
        $player = $validated['player'];

        return response()->json([
            'message' => 'Move processed successfully',
            'row' => $row,
            'column' => $column,
            'player' => $player,
        ]);
    }

    
}
