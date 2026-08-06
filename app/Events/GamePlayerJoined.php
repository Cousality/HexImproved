<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GamePlayerJoined implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public int $gameId;

    public function __construct(Game $game)
    {
        $this->gameId = $game->id;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('games.'.$this->gameId),
        ];
    }
}
