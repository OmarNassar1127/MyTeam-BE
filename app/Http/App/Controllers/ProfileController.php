<?php

namespace App\Http\App\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

  public function profile()
  {
      $user = $this->user; 
      $teams = $user->teams;
  
      $trained = 0;
      $late = 0;
      $present = 0;
      $absent = 0;
  
      foreach ($teams as $team) {
          $trained += $team->games->count(); //not good 
          $late += $team->games->where('status', 'late')->count(); 
          $present += $team->sessions->where('status', 'present')->count(); 
          $absent += $team->sessions->where('status', 'absent')->count();
      }
  
      return [
              'trained' => $trained,
              'late' => $late,
              'present' => $present,
              'absent' => $absent,
      ];
  }  
  // need to fix the way it's accessing the data, it needs to be now through the session_users 
  //pivot table and game_users pivot table
}
