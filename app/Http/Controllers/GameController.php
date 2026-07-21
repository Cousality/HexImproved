<?php

namespace App\Http\Controllers;

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
    }
}
