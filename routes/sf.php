<?php

use App\Http\Controllers\Sf\SfController;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

Route::any('/', function (Request $request) {
    Forrest::authenticate();

    return Forrest::sobjects();
})->name('root');

Route::controller(SfController::class)
    ->prefix("/courier")
    ->name('courier.')
    ->group(function () {
        Route::post('/create', 'create')
            ->name('create');

        Route::patch('/update', 'update')
            ->name('update');

        Route::get('/check/', 'check')
            ->name('check');
    });
