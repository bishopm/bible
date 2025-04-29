<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->controller('\Bishopm\Bible\Http\Controllers\HomeController')->group(function () {
    Route::get('/{book?}/{chapter?}', 'home')->name('web.home');
});


