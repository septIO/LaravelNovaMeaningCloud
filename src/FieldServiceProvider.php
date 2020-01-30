<?php

namespace Septio\LaravelMeaningcloud;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('laravel-meaningcloud', __DIR__.'/../dist/js/field.js');
            Nova::style('laravel-meaningcloud', __DIR__.'/../dist/css/field.css');
            Nova::provideToScript([
                'key' => env('MEANINGCLOUD_KEY')
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
