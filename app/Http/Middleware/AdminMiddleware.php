<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user is admin (is_admin == 1)
        if (Auth::user()->is_admin != 1) {
            abort(403, 'Unauthorized access. Admin only.');
        }

        return $next($request);
    }
}