<?php

use App\Http\Controllers\Sf\SfController;

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
