<?php

namespace App\Http\App\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

  public function profile()
  {
    $user = $this->user->load(['gameParticipations', 'sessionParticipations']);

    $playedGames = $user->gameParticipations->count();
    $lateGame = $user->gameParticipations->where('pivot.status', 'late')->count();
    $absentGames = $user->gameParticipations->where('pivot.status', 'absent')->count();

    $trainedSessions = $user->sessionParticipations->count();
    $presentSession = $user->sessionParticipations->where('pivot.status', 'present')->count();
    $absentSession = $user->sessionParticipations->where('pivot.status', 'absent')->count();

    return [
        'late_to_the_game' => $lateGame,
        'played_games' => $playedGames,
        'absent_games' => $absentGames,
        'trained_sessions' => $trainedSessions,
        'present_in_the_session' => $presentSession,
        'absent_in_the_session' => $absentSession,
    ];
  }
}
