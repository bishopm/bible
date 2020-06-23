<?php

Route::get('/', ['uses'=>'Bishopm\Bible\Http\Controllers\VersesController@home','as'=>'home']);
Route::get('/api/{version}/{book}/{chapter}', ['uses'=>'Bishopm\Bible\Http\Controllers\VersesController@verses','as'=>'verses']);
Route::get('/api/dropdowns', ['uses'=>'Bishopm\Bible\Http\Controllers\VersesController@dropdowns','as'=>'dropdowns']);
