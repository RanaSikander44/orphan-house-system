<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use app\Models\User;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        if (Auth()->user()->role->name == $role) {
            return $next($request);
        }

        if (Auth()->user()->role->name === 'Admin') {
            return redirect()->route('dashboard');
        }

        if (Auth()->user()->role->name === 'Donor') {
            return redirect()->route('donor.dashboard');
        }

        abort(403);

    }
}
