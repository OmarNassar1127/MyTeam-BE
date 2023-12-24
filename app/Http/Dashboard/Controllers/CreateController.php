<?php

namespace App\Http\Dashboard\Controllers;

use App\Models\Club;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class CreateController 
{
  public function storeClub(Request $request) {
    $request->validate([
      'name' => 'required|string',
      'address' => 'required|string',
      'contact_info' => 'nullable|string',
      'email' => 'required|email',
      'president_user_id' => 'nullable|integer|exists:users,id',
      'logo' => 'nullable|image'
    ]);
  
    $club = Club::create([
      'name' => $request->name,
      'address' => $request->address,
      'contact_info' => $request->contact_info,
      'email' => $request->email,
      'president_user_id' => $request->president_user_id,
    ]);
  
    if ($request->hasFile('logo')) {
      $club->addMediaFromRequest('logo')->toMediaCollection('club_logos');
    }
  
    return response()->json([
      'message' => 'Club created successfully'
    ], 200);
  }

  public function storePresident(Request $request) {
    $request->validate([
      'name' => 'required|string',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:6',
      'address' => 'required|string',
      'phone_number' => 'required|string',
    ]);
  
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'address' => $request->address,
      'phone_number' => $request->phone_number,
    ]);

    $presidentRole = Role::where('name', 'president')->first();
    $user->roles()->attach($presidentRole);

    return response()->json([
      'message' => 'President created successfully'
    ], 200);
  }

  public function storeManager(Request $request) {
    $request->validate([
      'name' => 'required|string',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:6',
      'address' => 'required|string',
      'phone_number' => 'required|string',
    ]);
  
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'address' => $request->address,
      'phone_number' => $request->phone_number,
    ]);

    $presidentRole = Role::where('name', 'manager')->first();
    $user->roles()->attach($presidentRole);

    return response()->json([
      'message' => 'Manager created successfully'
    ], 200);
  }

  public function storeTeam(Request $request) {
    $request->validate([
      'club_id' => 'required|int|exists:clubs,id',
      'name' => 'required|string',
      'category' => 'required|string',
    ]);
  
    Team::create([
      'club_id' => $request->club_id,
      'name' => $request->name,
      'category' => $request->category,
    ]);

    return response()->json([
      'message' => 'Team created successfully'
    ], 200);
  }

}
