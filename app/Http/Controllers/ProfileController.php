<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\EloHistory;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $gamesPlayed = Game::where('player1_id', $user->id)
            ->orWhere('player2_id', $user->id)
            ->count();


        $wins = Game::where('winner_id', $user->id)
            ->count();

        $losses = $gamesPlayed - $wins;

        $previousGames = Game::where(function ($query) use ($user) {
            $query->where('player1_id', $user->id)
                ->orWhere('player2_id', $user->id);
        })

            ->where('status', 'finished')
            ->paginate(5);

        $eloHistory = EloHistory::where('user_id', $user->id)
            ->orderBy('created_at')
            ->get();

        return view('profile', [
            'gamesPlayed' => $gamesPlayed,
            'wins' => $wins,
            'losses' => $losses,
            'previousGames' => $previousGames,
            'eloHistory' => $eloHistory
        ]);
    }






    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        //validates the image file to ensure it is an image and meets the specified requirements.
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');
        //stores the uploaded image in the 'profile-pictures' directory within the public storage disk and returns the path to the stored file.
        $user = auth()->user();

        $user->profile_picture = $path;

        $user->save();

        return redirect()->route('profile');


    }





















}
