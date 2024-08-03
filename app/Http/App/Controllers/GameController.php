<?php

namespace App\Http\App\Controllers;

use App\Models\Game;
use App\Models\GameUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\App\Resources\GameResources;
use App\Http\App\Controllers\Requests\StoreGameRequest;
use App\Http\App\Controllers\Requests\UpdateGamePlayersRequest;

class GameController extends Controller
{
    public function index()
    {
        $team = $this->user->teams()->latest()->first();
        $games = Game::where('team_id', $team->id)->orderBy('date', 'desc')->get();
        return GameResources::collection($games);
    }

    public function store(StoreGameRequest $request)
    {
        if ($this->user->role !== 'manager'){
            abort(403, 'unauthorized');
        }

        $validated = $request->validated();
        
        $team = $this->user->teams()->latest()->first();
        
        $game = Game::create([
            'team_id' => $team->id,
            'date' => $validated['date'],
            'opponent' => $validated['opponent'],
            'home' => $validated['home'],
            'location' => $validated['location'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'result' => '0-0',
            'season' => '2024/2025', //ToDo:: this needs to be solved.
        ]);

        $teamMembers = $team->users()->pluck('users.id');

        $pivotData = $teamMembers->mapWithKeys(function ($userId) use ($team) {
            return [$userId => [
                'team_id' => $team->id,
                'status' => 'present',
                'goals' => 0,
                'assists' => 0,
                'yellow_cards' => 0,
                'red_cards' => 0,
            ]];
        })->all();
    
        $game->users()->attach($pivotData);
    }

    public function updatePlayers($gameId, UpdateGamePlayersRequest $request)
    {
        if ($this->user->role !== 'manager'){
            abort(403, 'unauthorized');
        }
        
        $playerStatuses = $request->validated('players');
        
        foreach ($playerStatuses as $player) {
            GameUser::where('game_id', $gameId)
                ->where('user_id', $player['user_id'])
                ->update(['status' => $player['status']]);
        }        
    }
}
