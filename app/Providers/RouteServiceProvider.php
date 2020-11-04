<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->authRoute();

            $this->memberRoute();
            $this->bookkeepingRoute();
            //$this->futuresRoute();

//            Route::prefix('api')
//                ->middleware('api')
//                ->namespace($this->namespace)
//                ->group(base_path('routes/api.php'));
//
//            Route::middleware('web')
//                ->namespace($this->namespace)
//                ->group(base_path('routes/web.php'));
        });
    }

    protected function authRoute()
    {
        Route::middleware('web')
            ->namespace("{$this->namespace}")
            ->group(base_path('routes/web.php'));
    }

    protected function memberRoute()
    {
        Route::middleware(['web', 'auth'])
            ->namespace("{$this->namespace}\Member")
            ->as('member.')
            ->group(base_path('routes/member.php'));
    }

    protected function bookkeepingRoute()
    {
        Route::middleware(['web', 'auth'])
            ->namespace("{$this->namespace}\Bookkeeping")
            ->prefix('bookkeeping')
            ->group(base_path('routes/bookkeeping.php'));
    }

    protected function futuresRoute()
    {
        Route::middleware(['web', 'auth'])
            ->namespace("{$this->namespace}\Futures")
            ->as('futures.')
            ->group(base_path('routes/futures.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
