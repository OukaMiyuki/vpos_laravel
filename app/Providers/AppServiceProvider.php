<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
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
        Blade::directive('currency', function ( $expression ) { return "Rp. <?php echo number_format($expression,2,',','.'); ?>"; });
        Blade::directive('money', function ( $expression ) { return "<?php echo number_format($expression,0,',','.'); ?>"; });
        // Model::handleLazyLoadingViolationUsing(function($model, $relation){
        //     $class = $model->$relation()->getRelated();

        //     if(Str::startsWith(get_class($class), 'App')){
        //         throw new LazyLoadingViolationException($model, $relation);
        //     }
        // });
        // if(config('app.env') === 'production') {
        //     URL::forceScheme('https');
        // }
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
}
