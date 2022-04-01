<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AccountController;
use \App\Http\Controllers\AuthController;
use \App\Http\Middleware\AuthenticMD;
use \App\Http\Controllers\LevelController;
use \App\Http\Controllers\BreadController;
use \App\Http\Controllers\MeatsController;
use \App\Http\Controllers\OptionalController;

//auth
Route::post('/v1/authentication', [AuthController::class, 'post_Auth'])->name('authentication.auth');
Route::post('/v1/account', [AccountController::class, 'createUser'])->name('user.create');
Route::middleware(AuthenticMD::class)->get('/v1/authentication/token', [AuthController::class, 'token_verify']);

Route::middleware(AuthenticMD::class)->prefix('/v1')->group(function () {

    //user comun
    Route::get('/account/me', [AccountController::class, 'getInfoAccount'])->name('account.me');
    Route::put('/account/me', [AccountController::class, 'updateAccount'])->name('account.me');
    Route::post('/account/me/image', [AccountController::class, 'updateAccountImage'])->name('account.me');
    Route::get('/account/refresh', [AccountController::class, 'refreshToken'])->name('account.refresh');
    
    
    //admin
    Route::patch('/user/{id}', [UserController::class, 'updateUser'])->name('user.find');
    Route::get('/user', [UserController::class, 'allUsers'])->name('user.all');
    Route::get('/user/{id}', [UserController::class, 'getUser'])->name('user.find');
    Route::patch('/user/{id}', [UserController::class, 'updateUser'])->name('user.find');
   
    Route::get('/level', [LevelController::class, 'allLevel'])->name('level.all');

    Route::get('/merchants', [MerchantsController::class, 'allMerchant'])->name('merchants.all');
    Route::post('/merchants', [MerchantsController::class, 'createMerchant'])->name('merchants.create');
    Route::patch('/merchants/{id}', [MerchantsController::class, 'updateMerchant'])->name('merchants.update');

    Route::get('/breads', [BreadController::class, 'allBreads'])->name('breads.all');

   Route::get('/meats', [MeatsController::class, 'allMeats'])->name('meats.all');

    Route::get('/optionals', [OptionalController::class, 'allOptionals'])->name('optionals.all');
    
});


Route::any('{any}', function(){
    return response()->json([
        'status'    => false,
        'message'   => 'Page Not Found.',
    ], 404);
})->where('any', '.*');