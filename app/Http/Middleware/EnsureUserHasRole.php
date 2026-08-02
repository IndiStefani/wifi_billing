<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (! $request->user() || ! $request->user()->hasRole($role)) {
            return Redirect::route('dashboard')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
