<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EloHistory extends Model
{
    use HasFactory;

    protected $table = 'elo_history';

    protected $fillable = [
        'user_id',
        'game_id',
        'elo',
    ];
}
