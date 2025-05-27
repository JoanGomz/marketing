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


        if ($user->role_id == 2) {
            return redirect('/conversations');
        }

        return $next($request);
    }
}
