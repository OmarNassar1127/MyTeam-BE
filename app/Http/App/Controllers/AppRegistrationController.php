<?php

namespace App\Http\App\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class AppRegistrationController
{
  public function clubFetch(Request $request) {
    $request->validate([
      'code' => 'required|exists:clubs,code',
    ]);

    $club = Club::with('media')->where('code', $request->code)->first();

    if (!$club) {
      return response()->json(['error' => 'Club not found'], 404);
    }

    return [
      'club' => $club,
    ];
  }
}
