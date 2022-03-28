<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AuthController;
use \App\Http\Middleware\AuthenticMD;

//auth
Route::post('/authentication', [AuthController::class, 'post_Auth'])->name('authentication.auth');

Route::middleware(AuthenticMD::class)->prefix('/v1')->group(function () {
    //create user
    Route::post('/user', [UserController::class, 'createUser'])->name('user.create');
    //get all users
    Route::get('/user', [UserController::class, 'allUsers'])->name('user.all');
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