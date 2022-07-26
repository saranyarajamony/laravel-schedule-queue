<?php

use Illuminate\Support\Facades\Route;

Route::name('users.')
->namespace("\App\Http\Controllers")
->group(function () {
    Route::get('/applications', [\App\Http\Controllers\ApplicationController::class, 'index'])
    ->name('index');

});
