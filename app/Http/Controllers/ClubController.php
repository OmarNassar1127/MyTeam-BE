<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Game;
use App\Models\User;

class ClubController extends Controller
{
    public function getClubInfo()
    {
        $club = Club::with(['presidents', 'teams.managers', 'teams.players'])->get();

        $data = $club;

        return [
            'club' => $data
        ];
    }

    public function presidents(){
        $presidents = User::isPresident()->get();

        return response()->json($presidents);
    }

    public function managers(){
        $managers = User::isManager()->get();

        return [
            'managers' => $managers
        ];
    }

    public function players(){
        $players = User::isPlayer()->get();

        return [
            'players' => $players
        ];
    }

    public function getGameParticipants($game)
    {
        $game = Game::with(['team.gameManagers', 'team.gamePlayers'])->find($game);

        $managers = $game->team ? $game->team->gameManagers : collect();
        $players = $game->team ? $game->team->gamePlayers : collect();

        return [
            'game_id' => $game->id,
            'managers' => $managers,
            'players' => $players,
        ];
    }

    public function game(Game $game)
    {
        $game->load('team');

        return [
            'game' => [
                'id' => $game->id,
                'team_name' => $game->team->name,
                'date' => $game->date,
                'opponent' => $game->opponent,
                'result' => $game->result,
                'season' => $game->season,
                'created_at' => $game->created_at,
                'updated_at' => $game->updated_at,
                'deleted_at' => $game->deleted_at
            ]
        ];
    }

}
