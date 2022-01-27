<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthHrdRole
{
    const ALLOWED_ROLE_ID = 1;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role_id != self::ALLOWED_ROLE_ID) {
            return $this->responseUnauthorized();
        }

        return $next($request);
    }

    private function responseUnauthorized()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized Access.'
        ], 401);
    }
}
