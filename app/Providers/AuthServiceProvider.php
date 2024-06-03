<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthServiceProvider extends ServiceProvider
{
public function boot()
{
    $this->registerPolicies();

        Auth::viaRequest('api', function ($request) {
            return User::where('api_token', $request->bearerToken())->first();
        });
    }
}
