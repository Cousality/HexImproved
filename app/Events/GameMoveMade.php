<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameMoveMade implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $gameId;

    public int $row;

    public int $column;

    public string $role;

    public ?string $nextRole;

    public string $status;

    public ?string $winner;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        Game $game,
        int $row,
        int $column,
        string $role,
        bool $won
    ) {
        $this->gameId = $game->id;
        $this->row = $row;
        $this->column = $column;
        $this->role = $role;
        $this->nextRole = $won ? null : $game->playerNumber($game->current_turn);
        $this->status = $game->status;
        $this->winner = $won ? $role : null;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('games.'.$this->gameId);
    }
}
