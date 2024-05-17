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
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';
    public const WELCOME = '/';
    public const ADMIN_DASHBOARD = '/admin/dashboard';
    public const MARKETING_DASHBOARD = '/marketing/dashboard';
    public const TENANT_DASHBOARD = '/tenant/dashboard';
    public const TENANT_MITRA_DASHBOARD = '/tenant/mitra/dashboard';
    public const KASIR_DASHBOARD = '/kasir/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(90)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(90)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
