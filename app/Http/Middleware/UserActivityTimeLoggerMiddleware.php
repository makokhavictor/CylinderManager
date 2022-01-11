<?php

namespace App\Http\Middleware;

use App\Events\UserActivityEvent;
use Closure;
use Illuminate\Http\Request;

class UserActivityTimeLoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        UserActivityEvent::dispatch(auth()->user());
        return $next($request);
    }
}
