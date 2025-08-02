<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Hello';
});

Route::get('/verify/email', \App\Http\Controllers\Auth\VerifyEmail::class);
Route::get('/verify/password', \App\Http\Controllers\Auth\VerifyPasswordResetToken::class);

Route::get('/mailable', function () {
    return new App\Mail\AccountCreated(\App\Models\User::first());
});
