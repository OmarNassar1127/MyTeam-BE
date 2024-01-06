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
      'first_name' => 'required|string',
      'last_name' => 'required|string',
      'email' => 'required|email|unique:users,email',
    ]);
  
    User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
    ]);
  }
  
  public function registerFinish(Request $request) {
    $request->validate([
      'email' => 'required|email|exists:users,email',
      'phone_number' => 'required',
      'password' => 'required',
      'password_confirmation' => 'required|same:password',
    ]);
  
    $user = User::where('email', $request->email)->first();
  
    $user->update([
      'phone_number' => $request->phone_number,
      'password' => Hash::make($request->password),
    ]);
  
    return ['user' => $user];
  }
    
}
