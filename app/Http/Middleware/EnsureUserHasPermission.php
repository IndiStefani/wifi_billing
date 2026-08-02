<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EnsureUserHasPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (! $request->user() || ! $request->user()->hasPermission($permission)) {
            return Redirect::route('dashboard')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
