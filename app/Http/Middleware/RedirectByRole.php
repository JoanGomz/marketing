<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;

use Closure;
use Illuminate\Support\Facades\Auth;


class RedirectByRole
{
    public function handle($request, Closure $next)
    {
        Log::info('Middleware RedirectByRole ejecutado');

        $user = Auth::user();
        Log::info($user);

        if (!$user) {
            Log::info('usuario no encontrado');
            return redirect('/');
        }

        // if ($user->hasRole('SuperAdmin') && !$request->is('dashboard')) {
        //     return redirect('/dashboard');
        // }

        if ($user->hasRole('Asesor') && !$request->is('asesor/*')) {
            return redirect('/asesor/chatPanel');
        }

        if ($user->hasRole('cash') && !$request->is('cash/*')) {
            return redirect('/cash/home');
        }

        return $next($request);
    }
}
