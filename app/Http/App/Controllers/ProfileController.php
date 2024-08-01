<?php

namespace App\Http\App\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\App\Resources\GameResources;
use App\Http\App\Resources\SessionResources;
use App\Models\Game;
use Illuminate\Support\Facades\Storage;

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

  public function getProfileImage(Request $request)
  {
      $user = $this->user; 
      $profileImage = $user->getFirstMedia('profile');

      if ($profileImage) {
          return $profileImage->toInlineResponse($request);
      }
  }

  public function image(Request $request)
  {
      $request->validate([
          'profile' => 'required|mimes:jpeg,png,jpg|max:2048' 
      ]);

      $user = $this->user; 
      $user->clearMediaCollection('profile');
      $user->addMediaFromRequest('profile')->toMediaCollection('profile', 'users');
  }

  public function getTeamStats()
  {
      $team = $this->user->teams()->first();
  
      $topScorer = $team->topScorer();
      $topAssister = $team->topAssister();
      $mostPresent = $team->mostPresent();
      $mostAbsent = $team->mostAbsent();
      $upcomingGame = $team->upcoming_game;
      $upcomingSession = $team->upcoming_training;
  
      return [
          'data' => [
              'upcoming_game' => $upcomingGame ? GameResources::make($upcomingGame) : null,
              'upcoming_session' => $upcomingSession ? SessionResources::make($upcomingSession) : null,
              'top_scorer' => $topScorer ? ['name' => $topScorer->name, 'goals' => $topScorer->total_goals] : null,
              'top_assister' => $topAssister ? ['name' => $topAssister->name, 'assists' => $topAssister->total_assists] : null,
              'most_present' => $mostPresent ? ['name' => $mostPresent->name, 'present' => $mostPresent->present_count] : null,
              'most_absent' => $mostAbsent ? ['name' => $mostAbsent->name, 'absent' => $mostAbsent->absent_count] : null,
          ]
      ];
  }

  public function getPlayerStats(Request $request)
  {
      $userId = $this->user->id;
  
      $games = Game::whereHas('users', function($query) use ($userId) {
          $query->where('user_id', $userId);
      })->with(['users' => function($query) use ($userId) {
          $query->where('user_id', $userId)
                ->select('users.id')
                ->withPivot('goals', 'assists', 'yellow_cards', 'red_cards');
      }])->get();
  
      $stats = $games->flatMap(function($game) {
          return $game->users->map(function($user) {
              return [
                  'goals' => $user->pivot->goals,
                  'assists' => $user->pivot->assists,
                  'yellow_cards' => $user->pivot->yellow_cards,
                  'red_cards' => $user->pivot->red_cards,
              ];
          });
      });
  
      $summarizedStats = $stats->reduce(function($carry, $stat) {
          $carry['goals'] += $stat['goals'];
          $carry['assists'] += $stat['assists'];
          $carry['yellow_cards'] += $stat['yellow_cards'];
          $carry['red_cards'] += $stat['red_cards'];
          return $carry;
      }, ['goals' => 0, 'assists' => 0, 'yellow_cards' => 0, 'red_cards' => 0]);
  
      return response()->json($summarizedStats);
  }  

    public function getTeamMembers()
    {
        $team = $this->user->teams()->first();

        $members = $team->players()->with(['gameParticipations' => function ($query) use ($team) {
            $query->whereHas('game', function ($q) use ($team) {
                $q->where('team_id', $team->id);
            });
        }])->get()->map(function ($player) {
            $stats = $player->gameParticipations->reduce(function ($carry, $participation) {
                $carry['goals'] += $participation->goals;
                $carry['assists'] += $participation->assists;
                $carry['yellow_cards'] += $participation->yellow_cards;
                $carry['red_cards'] += $participation->red_cards;
                return $carry;
            }, ['goals' => 0, 'assists' => 0, 'yellow_cards' => 0, 'red_cards' => 0]);

            return [
                'id' => $player->id,
                'name' => $player->name,
                'goals' => $stats['goals'],
                'assists' => $stats['assists'],
                'yellow_cards' => $stats['yellow_cards'],
                'red_cards' => $stats['red_cards'],
            ];
        });

        return [
            'team_name' => $team->name,
            'members' => $members
        ];
    }

}
