<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $gamesPlayed =  Game::where('player1_id', $user->id)
            ->orWhere('player2_id', $user->id)
            ->count();


            $wins = Game::where('winner_id', $user->id) 
            ->count();
            
            $losses = $gamesPlayed - $wins;
            
            return view('profile', [ 'gamesPlayed' => $gamesPlayed, 'wins' => $wins, 'losses' => $losses, ]);
    }
}
