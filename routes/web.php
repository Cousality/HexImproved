<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', [AuthController::class, 'showloginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Lobby: list open games waiting for an opponent + a "new game" button.
    Route::get('/game', [GameController::class, 'lobby'])->name('game.lobby');

    // Create a new game; current user becomes player1.
    Route::post('/game', [GameController::class, 'create'])->name('game.create');

    // Fill the player2 slot on an open game.
    Route::post('/game/{game}/join', [GameController::class, 'join'])->name('game.join');

    // {game} is route-model-bound to App\Models\Game via its id.
    Route::get('/game/{game}', [GameController::class, 'show'])->name('game.show');
    Route::post('/game/{game}/move', [GameController::class, 'move'])->name('game.move');
    Route::post('/game/{game}/reset', [GameController::class, 'reset'])->name('game.reset');

    Route::post('/game/ai', [GameController::class, 'createAi'])
        ->name('game.ai.create');
});

Route::get('/profile', [ProfileController::class, 'show'])
    ->name('profile');

Route::post('/profile/picture', [ProfileController::class, 'updatePicture'])
    ->name('profile.picture');

Route::get('/test-dijkstra', [GameController::class, 'testDijkstra']);
