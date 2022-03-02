<?php

use App\Http\Controllers\Auth\Register\EmailCodeController;
use App\Http\Controllers\Auth\Register\PhoneCodeController;
use App\Http\Controllers\Auth\Register\RegisterController;

Route::controller(EmailCodeController::class)
    ->name('email.')
    ->group(function () {
        Route::get('/', 'create')
            ->name('create');

        Route::post('/', 'store')
            ->name('store');

        Route::post('/resend', 'resend')
            ->name('resend');

        Route::prefix('/validate')
            ->name('validate.')
            ->group(function () {
                Route::get('/{uuid}', 'show')
                    ->whereUuid('uuid')
                    ->name('show');

                Route::delete('/{uuid}', 'destroy')
                    ->whereUuid('uuid')
                    ->name('destroy');
            });
    });


Route::controller(PhoneCodeController::class)
    ->prefix('/phone')
    ->name('phone.')
    ->group(function () {
        Route::get('/{user:uuid}', 'create')
            ->whereUuid('user')
            ->name('create');

        Route::post('/{user:uuid}', 'store')
            ->whereUuid('user')
            ->name('store');

        Route::post('/resend/{user:uuid}', 'resend')
            ->whereUuid('user')
            ->name('resend');

        Route::prefix('/validate')
            ->name('validate.')
            ->group(function () {
                Route::get('/{user:uuid}', 'show')
                    ->whereUuid('user')
                    ->name('show');

                Route::delete('/{user:uuid}', 'destroy')
                    ->whereUuid('user')
                    ->name('destroy');
            });
    });


Route::controller(RegisterController::class)
    ->prefix('/finalize')
    ->name('finalize.')
    ->group(function () {
        Route::get('/{user:uuid}', 'create')
            ->whereUuid('user')
            ->name('create');

        Route::post('/{user:uuid}', 'store')
            ->whereUuid('user')
            ->name('store');
    });
