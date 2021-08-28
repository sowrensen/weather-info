<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ThrottleIdenticalRequest
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
        if (ApiRequest::isMaxIdenticalRequestExceeded()) {
            return \Response::json([
                'status' => false,
                'message' => 'Too many identical requests.',
                'data' => null
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        return $next($request);
    }
}
