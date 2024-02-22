<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;

    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            $this->user = auth()->user(); 
            return $next($request);
        });
    }

    public function unathenticated(){
        if (!$this->user) {
            abort(403, 'Unauthorized.');
        }
    }

    // public function isManager(){
    //     if ($this->user->role == 'manager') {
    //         true;
    //     } else {
    //         abort(403, 'Unauthorized.');
    //     }
    // }
}
