<?php

use Illuminate\Support\Facades\Route;
use PasswordPolicy\Http\Controllers\UserPasswordPolicyController;
 
    /*
    |--------------------------------------------------------------------------
    | Routes about Recovery Password
    |--------------------------------------------------------------------------
    */
    Route::post('user/recoveryPolicy', [UserPasswordPolicyController::class, 'recovery']);
    Route::get('user/recoveryPolicy/{token}', [UserPasswordPolicyController::class, 'recoveryForm'])->name('user.passwordPolicy.recovery.form');
    Route::post('user/recoveryPolicy/{token}', [UserPasswordPolicyController::class, 'change']);

