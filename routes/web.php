<?php

use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ShortUrlController::class, 'index'])
    ->name('url.index');

Route::post('/', [ShortUrlController::class, 'store'])
    ->name('url.shorten');

Route::get('/{code}', [ShortUrlController::class, 'redirect'])
    ->name('url.redirect');
