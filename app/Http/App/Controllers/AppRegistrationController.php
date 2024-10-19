<?php

namespace App\Http\App\Controllers;

use App\Models\Club;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\App\Resources\TeamResources;
use App\Http\App\Controllers\Resources\UserResources;


class AppRegistrationController extends Controller
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
    return [200];
  }

  public function getTeams($clubId)
  {
    $club = Club::findOrFail($clubId);
    return TeamResources::collection($club->teams);
  }
    
  public function linkUser(Request $request, $clubId, $teamId)
  {
      $user =  User::where('email', $request->email)->first();

      if (!$user) {
          return response()->json(['message' => 'Unauthorized'], 401);
      }

      $team = Team::where('id', $teamId)->where('club_id', $clubId)->first();
      if (!$team) {
          return response()->json(['message' => 'Invalid team or club'], 400);
      }

      $user->teams()->attach($teamId, ['is_manager' => false]);
      $user->roles()->attach(3);

      return [
          'token' => $user->createToken('user')->plainTextToken,
          'team_name' => $team->name,
          'user' => new UserResources($user),
      ];
  }
}
