<?php

use App\Http\Controllers\Sf\SfController;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

Route::any('/', function (Request $request) {
    Forrest::authenticate();

    return Forrest::sobjects();
});

Route::controller(SfController::class)
    ->prefix("/courier")
    ->name('courier.')
    ->group(function () {
        Route::post('/create/{user:uuid}', 'create');
    });
