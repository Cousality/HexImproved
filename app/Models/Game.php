<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'player1_id',
        'player2_id',
        'board',
        'current_turn',
        'winner_id',
        'status',
    ];

    protected $casts = [
        'board' => 'array',
    ];

    // ---------------------------------------------------------------
    // Relationships
    // ---------------------------------------------------------------

    public function player1()
    {
        return $this->belongsTo(User::class, 'player1_id');
    }

    public function player2()
    {
        return $this->belongsTo(User::class, 'player2_id');
    }

    public function currentTurn()
    {
        return $this->belongsTo(User::class, 'current_turn');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    // ---------------------------------------------------------------
    // Creation helper
    // ---------------------------------------------------------------

    /**
     * Start a new game with the given user as player1, sitting in
     * the 'waiting' status until someone takes the player2 slot.
     */
    public static function createForPlayer(int $player1Id, int $boardSize = 7): self
    {
        return self::create([
            'player1_id' => $player1Id,
            'board' => self::emptyBoard($boardSize),
            'current_turn' => $player1Id,
            'status' => 'waiting',
        ]);
    }

    public static function emptyBoard(int $boardSize): array
    {
        $board = [];

        for ($row = 0; $row < $boardSize; $row++) {
            for ($column = 0; $column < $boardSize; $column++) {
                $board[] = [
                    'row' => $row,
                    'column' => $column,
                    'owner' => null,
                ];
            }
        }

        return $board;
    }

    // ---------------------------------------------------------------
    // Role helpers — translate a raw user id into its role in THIS game
    // ---------------------------------------------------------------

    /**
     * 'player1', 'player2', or null if this user isn't in the game.
     */
    public function playerNumber(int $userId): ?string
    {
        if ($userId === $this->player1_id) {
            return 'player1';
        }

        if ($userId === $this->player2_id) {
            return 'player2';
        }

        return null;
    }

    public function userIdForRole(string $role): ?int
    {
        return $role === 'player1' ? $this->player1_id : $this->player2_id;
    }

    public function opponentId(int $userId): ?int
    {
        if ($userId === $this->player1_id) {
            return $this->player2_id;
        }

        if ($userId === $this->player2_id) {
            return $this->player1_id;
        }

        return null;
    }

    public function isFull(): bool
    {
        return $this->player1_id !== null && $this->player2_id !== null;
    }

    public function boardSize(): int
    {
        return (int) sqrt(count($this->board));
    }
}
    //fillable lists the columns Laravel is allowed to fill when creating a game.
