<?php

namespace App\Providers;

use App\Models\ApiToken;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('tokens', function ($request) {
            if ( ApiToken::where('api_token', $request->bearerToken())->exists() ) {
                return ApiToken::where('api_token', $request->bearerToken())->first()->user;
            }

            throw new AuthenticationException();
        });
    }
}
