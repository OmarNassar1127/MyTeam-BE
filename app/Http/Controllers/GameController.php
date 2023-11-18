<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function registerTeamForGame(Request $request)
    {
        $validatedData = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'date' => 'required|date',
            'opponent' => 'required|string',
            'season' => 'required|string',
        ]);

        $game = new Game();
        $game->team_id = $validatedData['team_id'];
        $game->date = $validatedData['date'];
        $game->opponent = $validatedData['opponent'];
        $game->season = $validatedData['season'];
        $game->save();

        $team = Team::with('users.roles')->find($validatedData['team_id']);
        if ($team) {
            foreach ($team->users as $user) {
                $isManager = $user->roles->contains('name', 'manager');
                $game->users()->attach($user->id, [
                    'team_id' => $team->id,
                    'is_manager' => $isManager,
                    'is_absent' => false
                ]);
            }
        }

        return response()->json(['message' => 'Success']);
    }

}
