<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Recruiters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->isRe() || auth()->user()->isRanked()){
            return $next($request);
        }
        /*
         * Set Errors Message
         */
        Session::flash('Failure', 'Hop hop hop reviens là toi !');
        return redirect()->back();
    }
}
