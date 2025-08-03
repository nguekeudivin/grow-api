<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', \App\Http\Controllers\Auth\Login::class);

Route::get('/associations', \App\Http\Controllers\Association\GetAssociations::class);

Route::middleware('auth:sanctum')->group(function () {

});
