<?php namespace Hopkins\LaravelAylienWrapper\Providers;

use Illuminate\Support\ServiceProvider;

class AylienTraitsServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/config.php' => config_path('aylientraits.php')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'aylientraits');
    }
}
