<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use \KgBot\LaravelLocalization\Facades\ExportLocalizations as ExportLocalization;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('app', function ($view) {
            return $view->with([
                'messages' => ExportLocalization::export()->toArray(),
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
