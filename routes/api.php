<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', \App\Http\Controllers\Auth\Login::class);

Route::middleware('auth:sanctum')->group(function () {

});
