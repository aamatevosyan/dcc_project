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
        Route::post('/create/{user:uuid}', 'create')
            ->name('create');

        Route::patch('/update/{user:uuid}', 'update')
            ->name('update');

        Route::get('/check/{user:uuid}', 'check')
            ->name('check');
    });
