<?php

namespace App\Http\Dashboard\Auth\Controllers;

use Illuminate\Http\Request;

class LogoutController
{
  public function adminLogout(Request $request)
  {
      $admin = auth('admins')->user();

      if ($admin) {
          $admin->tokens()->delete();
          return [200];
      }

      return [404];
  }

}