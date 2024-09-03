<?php

namespace App\Http\App\Controllers;


use Carbon\Carbon;
use App\Models\Session;
use App\Models\SessionUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\App\Controllers\Requests\StoreSessionRequest;
use App\Http\App\Controllers\Requests\UpdateSessionUserRequest;

class SessionController extends Controller
{
    public function index()
    {
        $team = $this->user->teams()->latest()->first();
        $sessions = Session::where('team_id', $team->id)->orderBy('date', 'desc')->get();
        
        return $sessions;
    }

    public function store(StoreSessionRequest $request)
    {
        $validated = $request->validated();
        $team = $this->user->teams()->latest()->first();

        if (!$team) {
            return response()->json(['error' => 'No team found for this user'], 404);
        }

        $sessions = [];
        $startDate = Carbon::parse($validated['date']);
        $endDate = $validated['is_weekly'] ? Carbon::parse($validated['end_date']) : $startDate;

        while ($startDate <= $endDate) {
            $session = Session::create([
                'team_id' => $team->id,
                'date' => $startDate,
                'notes' => $validated['notes'] ?? null,
                'completed' => false,
            ]);

            $teamMembers = $team->users()->pluck('users.id');

            $pivotData = $teamMembers->mapWithKeys(function ($userId) use ($team) {
                return [$userId => [
                    'team_id' => $team->id,
                ]];
            })->all();

            $session->users()->attach($pivotData);

            $sessions[] = $session;

            if ($validated['is_weekly']) {
                $startDate->addWeek();
            } else {
                break;
            }
        }
    }

    public function updatePlayers($gameId, UpdateSessionUserRequest $request)
    {
        if ($this->user->role !== 'manager'){
            abort(403, 'unauthorized');
        }
        
        $playerStatuses = $request->validated('players');
        
        foreach ($playerStatuses as $player) {
            SessionUser::where('session_id', $gameId)
                ->where('user_id', $player['user_id'])
                ->update(['status' => $player['status']]);
        }        
    }
}
