<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Model::preventLazyLoading();
        // Model::handleLazyLoadingViolationUsing(function($model, $relation){
        //     $class = $model->$relation()->getRelated();

        //     if(Str::startsWith(get_class($class), 'App')){
        //         throw new LazyLoadingViolationException($model, $relation);
        //     }
        // });
        // if(config('app.env') === 'production') {
        //     URL::forceScheme('https');
        // }
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
}
