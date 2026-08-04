<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', [AuthController::class, 'showloginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/game', [GameController::class, 'show'])->name('game');
Route::post('/game/move', [GameController::class, 'move'])->name('game.move');
Route::post('/game/reset', [GameController::class, 'reset'])->name('game.reset');

Route::get('/profile', [ProfileController::class, 'show'])
    ->name('profile');

Route::post('/profile/picture', [ProfileController::class, 'updatePicture'])
    ->name('profile.picture');