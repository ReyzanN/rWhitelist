<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class KillSessionIfGetBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->killSession == 1){
            auth()->user()->update(['killSession' => 0]);
            auth()->logout();
            Session::flash('Failure', 'Vous avez été déconnecté');
            return redirect()->route('base');
        }
        return $next($request);
    }
}
