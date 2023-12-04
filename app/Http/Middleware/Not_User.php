<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class Not_User
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole(['user'])) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}