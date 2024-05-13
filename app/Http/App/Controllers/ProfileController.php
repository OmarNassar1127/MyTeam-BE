<?php

namespace App\Http\App\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Team;

class ProfileController extends Controller
{

  public function profile()
  {
    $user = $this->user->load(['gameParticipations', 'sessionParticipations']);

    $games = $user->gameParticipations->count();
    $presentGame = $user->gameParticipations->where('pivot.status', 'present')->count();
    $lateGame = $user->gameParticipations->where('pivot.status', 'late')->count();
    $absentGames = $user->gameParticipations->where('pivot.status', 'absent')->count();

    
    $trainings = $user->sessionParticipations->count();
    $presentSession = $user->sessionParticipations->where('pivot.status', 'present')->count();
    $absentSession = $user->sessionParticipations->where('pivot.status', 'absent')->count();
    $lateSession = $user->sessionParticipations->where('pivot.status', 'late')->count();

    return [
        'games' => $games,
        'present_in_the_game' => $presentGame,
        'late_to_the_game' => $lateGame,
        'absent_games' => $absentGames,
        'trainings' => $trainings,
        'present_in_the_session' => $presentSession,
        'absent_in_the_session' => $absentSession,
        'late_to_the_session' => $lateSession
    ];
  }

  public function getTeamStats(Team $team)
  {
      $team->with('players');
      $topScorer = $team->topScorer();
      $topAssister = $team->topAssister();
      $mostPresent = $team->mostPresent();
      $mostAbsent = $team->mostAbsent();

      return response()->json([
          'top_scorer' => $topScorer ? ['name' => $topScorer->name, 'goals' => $topScorer->goals_count] : 0,
          'top_assister' => $topAssister ? ['name' => $topAssister->name, 'assists' => $topAssister->assists_count] : 0,
          'most_present' => $mostPresent ? ['name' => $mostPresent->name, 'present' => $mostPresent->presence_count] : 0,
          'most_absent' => $mostAbsent ? ['name' => $mostAbsent->name, 'absent' => $mostAbsent->absence_count] : 0,
      ]);
  }
}
