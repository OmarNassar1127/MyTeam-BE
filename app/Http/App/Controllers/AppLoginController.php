<?php

namespace App\Http\App\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AppLoginController extends Controller
{
  public function logIn(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['De inloggegevens zijn onjuist.'],
        ]);
    }

    return [
        'token' => $user->createToken('admin')->plainTextToken,
        'user' => $user
    ];
}
}
