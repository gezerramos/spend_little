<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AccountController;
use \App\Http\Controllers\AuthController;
use \App\Http\Middleware\AuthenticMD;
use \App\Http\Controllers\LevelController;

//auth
Route::post('/v1/authentication', [AuthController::class, 'post_Auth'])->name('authentication.auth');

Route::middleware(AuthenticMD::class)->prefix('/v1')->group(function () {


    Route::get('/account/me', [AccountController::class, 'getInfoAccount'])->name('account.me');
    Route::get('/account/refresh', [AccountController::class, 'refreshToken'])->name('account.refresh');
    
    Route::post('/user', [UserController::class, 'createUser'])->name('user.create');
    Route::get('/user', [UserController::class, 'allUsers'])->name('user.all');
    Route::get('/user/{id}', [UserController::class, 'getUser'])->name('user.find');
    Route::patch('/user/{id}', [UserController::class, 'updateUser'])->name('user.find');
   
    Route::get('/level', [LevelController::class, 'allLevel'])->name('level.all');

});


Route::any('{any}', function(){
    return response()->json([
        'status'    => false,
        'message'   => 'Page Not Found.',
    ], 404);
})->where('any', '.*');