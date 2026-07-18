<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{

    public function register(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => ($request->password),
    ]);

    Auth::login($user);

    return redirect()->route('home');
}
}
