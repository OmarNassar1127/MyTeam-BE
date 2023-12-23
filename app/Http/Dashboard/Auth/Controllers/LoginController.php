<?php

namespace App\Http\Dashboard\Auth\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController
{
    public function adminLogin(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['De inloggegevens zijn onjuist.'],
            ]);
        }

        return [
            'token' => $admin->createToken('admin')->plainTextToken
        ];
    }
}