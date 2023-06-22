<?php

namespace App\Http\Middleware;

use App\Models\AuthRoutingLog;
use App\Models\GuestRoutingLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoggingSystemRouting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()){
            AuthRoutingLog::create([
                'discordAccountId' => auth()->user()->discordAccountId,
                'url' => $request->url(),
                'ip' => $request->getClientIp()
            ]);
        }else{
            GuestRoutingLog::create([
                'guestInformations' => $request->getClientIp(),
                'url' => $request->url()
            ]);
        }
        return $next($request);
    }
}
