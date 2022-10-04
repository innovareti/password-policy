<?php

use Illuminate\Support\Facades\Route;
 
    /*
    |--------------------------------------------------------------------------
    | Routes about Recovery Password
    |--------------------------------------------------------------------------
    */
    Route::post('user/recovery', 'UserController@recovery');
    Route::get('user/recovery/{token}', 'UserController@recoveryForm')->name('user.password.recovery.form');
    Route::post('user/recovery/{token}', 'UserController@change');
