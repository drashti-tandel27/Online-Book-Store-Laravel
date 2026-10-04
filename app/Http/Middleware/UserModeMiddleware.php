<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserModeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user wants to enter user mode
        if ($request->has('mode') && $request->mode == 'user') {
            Session::put('user_mode', true);
            return redirect()->route('home');
        }
        
        // Check if user wants to exit user mode (coming from home page)
        if ($request->has('exit_mode') && $request->exit_mode == 'true') {
            Session::forget('user_mode');
            return redirect()->route('admin.dashboard');
        }
        
        // If in user mode, hide admin privileges
        if (Session::has('user_mode') && Session::get('user_mode') === true) {
            view()->share('user_mode', true);
        } else {
            view()->share('user_mode', false);
        }
        
        return $next($request);
    }
}