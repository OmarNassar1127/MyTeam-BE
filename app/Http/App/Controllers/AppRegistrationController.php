<?php

namespace App\Http\App\Controllers;

use App\Models\Club;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AppRegistrationController
{
  public function clubFetch(Request $request) {
    $request->validate([
      'code' => 'required|exists:clubs,code',
    ]);

    $club = Club::with('media')->where('code', $request->code)->first();

    if (!$club) {
      return response()->json(['error' => 'Club not found'], 404);
    }

    return [
      'club' => $club,
    ];
  }

  public function register(Request $request) {
    $request->validate([
      'voornamen' => 'required',
      'achternaam' => 'required',
      'email' => 'required|email,unique:users,email',
    ]);

    User::create([
      'voornamen' => $request->voornamen,
      'achternaam' => $request->achternaam,
      'email' => $request->email,
    ]);
  }

  public function registerFinish(Request $request) {
    $request->validate([
      'phone' => 'required',
      'password' => 'required',
      'password_confirmation' => 'required|same:password',
    ]);

    User::create([
      'phone' => $request->phone,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);
  }
    
}
