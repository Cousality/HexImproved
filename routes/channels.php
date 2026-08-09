<?php

use App\Models\Game;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('games.{game}', function ($user, Game $game) {
    return (int) $user->id === (int) $game->player1_id
        || (int) $user->id === (int) $game->player2_id;
});
