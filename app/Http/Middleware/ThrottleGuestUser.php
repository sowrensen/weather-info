<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ThrottleGuestUser
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
        if (ApiRequest::isGuestRequestPerHourExceeded()) {
            return \Response::json([
                'status' => false,
                'message' => 'Please register yourself to avoid rate limiting.',
                'data' => null
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
