<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->controller('\Bishopm\Bible\Http\Controllers\HomeController')->group(function () {
    Route::get('/', 'home')->name('web.home');
});


