<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', \App\Http\Controllers\Auth\Login::class);
Route::post('/auth/register', \App\Http\Controllers\Auth\Register::class);
Route::post('/validate/email', \App\Http\Controllers\Validate\ValidateEmail::class);

Route::post('/auth/check-email', \App\Http\Controllers\Auth\CheckEmail::class);

Route::get('/associations', \App\Http\Controllers\Association\GetAssociations::class);
Route::get('/projects', \App\Http\Controllers\Project\GetProjects::class);
Route::get('/contributions', \App\Http\Controllers\Contribution\GetContributions::class);
Route::get('/countries', \App\Http\Controllers\Location\GetCountries::class);
Route::get('/divisions', \App\Http\Controllers\Location\GetDivisions::class);

Route::middleware('auth:sanctum')->group(function () {

});
