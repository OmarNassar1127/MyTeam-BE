<?php

namespace App\Http\App\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\App\Controllers\Resources\UserResources;


class AppLoginController extends Controller
{
  public function logIn(Request $request) 
  {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->with('teams')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'error' => ['De inloggegevens zijn onjuist.'],
            ]);
        }

        return [
            'token' => $user->createToken('admin')->plainTextToken,
            'team_name' => $user->teams()->first()->name,
            'user' => UserResources::make($user),
        ];
    }

    public function logOut(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
