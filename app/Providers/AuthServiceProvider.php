<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Horizon\Horizon;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\User::class  => \App\Policies\UserPolicy::class,
        \App\Models\Topic::class => \App\Policies\TopicPolicy::class,
        \App\Models\Reply::class => \App\Policies\ReplyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Passport 路由
        Passport::routes();
        // access_token 过期时间
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        // refresh_token 过期时间
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        Horizon::auth(function ($request) {

           return Auth::user()->hasRole('Founder');
        });
    }
}
