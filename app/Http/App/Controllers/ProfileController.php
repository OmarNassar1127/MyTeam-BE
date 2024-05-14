<?php

namespace App\Http\App\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\App\Resources\GameResources;

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

  public function getTeamStats(Request $request)
  {
      $team = $request->user()->teams()->first();

      $topScorer = $team->topScorer();
      $topAssister = $team->topAssister();
      $mostPresent = $team->mostPresent();
      $mostAbsent = $team->mostAbsent();
      $upcomingGame = $team->upcoming_game;
      $upcomingSession = $team->upcoming_training;

      return [
          'upcoming_game' => GameResources::make($upcomingGame),
          'upcoming_session' => $upcomingSession,
          'top_scorer' => $topScorer ? ['name' => $topScorer->name, 'goals' => $topScorer->profile->goals] : null,
          'top_assister' => $topAssister ? ['name' => $topAssister->name, 'assists' => $topAssister->profile->assists] : null,
          'most_present' => $mostPresent ? ['name' => $mostPresent->name, 'present' => $mostPresent->present_games_count + $mostPresent->present_sessions_count] : null,
          'most_absent' => $mostAbsent ? ['name' => $mostAbsent->name, 'absent' => $mostAbsent->absent_games_count + $mostAbsent->absent_sessions_count] : null,
      ];
  }
}
