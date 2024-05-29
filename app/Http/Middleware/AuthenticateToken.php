<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AuthenticateToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('api_token')) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $apiToken = $request->input('api_token');

        $user = User::where('api_token', $apiToken)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid API token'], 401);
        }

        $request->merge(['user' => $user]);

        return $next($request);
    }
}
