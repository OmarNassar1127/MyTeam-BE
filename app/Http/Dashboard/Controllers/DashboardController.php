<?php

namespace App\Http\Dashboard\Controllers;

use Carbon\Carbon;
use App\Models\Club;
use App\Http\Dashboard\Helpers\StatisticsHelper;
use App\Http\Dashboard\Resources\ClubTableResources;
use Illuminate\Http\Request;

class DashboardController 
{
    public function statistics()
    {
        $dateAWeekAgo = Carbon::now()->subDays(7);

        $currentClubs = Club::with(['presidents', 'teams.managers', 'teams.players'])->get();
        $clubsAWeekAgo = Club::with(['presidents', 'teams.managers', 'teams.players'])
                            ->whereDate('created_at', '<=', $dateAWeekAgo)->get();

        $currentTotalClubs = $currentClubs->count();
        $currentTotalPresidents = $currentClubs->pluck('presidents')->flatten()->unique('id')->count();
        $currentTotalManagers = $currentClubs->pluck('teams')->flatten()->pluck('managers')->flatten()->unique('id')->count();
        $currentTotalPlayers = $currentClubs->pluck('teams')->flatten()->pluck('players')->flatten()->unique('id')->count();

        $totalClubsAWeekAgo = $clubsAWeekAgo->count();
        $totalPresidentsAWeekAgo = $clubsAWeekAgo->pluck('presidents')->flatten()->unique('id')->count();
        $totalManagersAWeekAgo = $clubsAWeekAgo->pluck('teams')->flatten()->pluck('managers')->flatten()->unique('id')->count();
        $totalPlayersAWeekAgo = $clubsAWeekAgo->pluck('teams')->flatten()->pluck('players')->flatten()->unique('id')->count();

        $clubPercentageChange = StatisticsHelper::calculatePercentageChange($totalClubsAWeekAgo, $currentTotalClubs);
        $presidentPercentageChange = StatisticsHelper::calculatePercentageChange($totalPresidentsAWeekAgo, $currentTotalPresidents);
        $managerPercentageChange = StatisticsHelper::calculatePercentageChange($totalManagersAWeekAgo, $currentTotalManagers);
        $playerPercentageChange = StatisticsHelper::calculatePercentageChange($totalPlayersAWeekAgo, $currentTotalPlayers);

        return [
            'total_clubs' => $currentTotalClubs,
            'club_percentage_change' => $clubPercentageChange,
            'total_presidents' => $currentTotalPresidents,
            'president_percentage_change' => $presidentPercentageChange,
            'total_managers' => $currentTotalManagers,
            'manager_percentage_change' => $managerPercentageChange,
            'total_players' => $currentTotalPlayers,
            'player_percentage_change' => $playerPercentageChange,
        ];
    }

    public function clubs() {
        $clubs = Club::with(['presidents', 'teams.managers', 'teams.players', 'media'])->get();
        return ClubTableResources::collection($clubs);
    }

    public function uploadLogo(Request $request, $clubId)
    {
        $request->validate([
            'logo' => 'required|image'
        ]);

        $club = Club::find($clubId);
        if (!$club) {
            return response()->json(['message' => 'Club not found'], 404);
        }

        $club->addMediaFromRequest('logo')
             ->toMediaCollection('club_logos');

        return response()->json(['message' => 'Logo uploaded successfully']);
    }
}
