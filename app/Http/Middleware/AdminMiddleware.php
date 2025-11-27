<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }

        session()->flash('warning', 'Login dulu kali ya biar syahdu 🙃');
        return redirect()->route('welcome');
    }
}
