<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AuthController;
use \App\Http\Middleware\AuthenticMD;
use \App\Http\Controllers\LevelController;

//auth
Route::post('/authentication', [AuthController::class, 'post_Auth'])->name('authentication.auth');

Route::middleware(AuthenticMD::class)->prefix('/v1')->group(function () {
    //create user
    Route::post('/user', [UserController::class, 'createUser'])->name('user.create');
    Route::get('/user', [UserController::class, 'allUsers'])->name('user.all');
    Route::get('/user/{id}', [UserController::class, 'getUser'])->name('user.find');

    Route::get('/level', [LevelController::class, 'allLevel'])->name('level.all');
    //ref token
    Route::get('/refresh', [AuthController::class, 'refresh_token'])->name('authentication.refresh');
});


/* Route::get('students/{id}', 'ApiController@getStudent');
Route::post('students', 'ApiController@createStudent');
Route::put('students/{id}', 'ApiController@updateStudent');
Route::delete('students/{id}','ApiController@deleteStudent'); */

Route::any('{any}', function(){
    return response()->json([
        'status'    => false,
        'message'   => 'Page Not Found.',
    ], 404);
})->where('any', '.*');