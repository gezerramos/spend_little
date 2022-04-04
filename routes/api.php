<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AccountController;
use \App\Http\Controllers\UpdateAccountController;
use \App\Http\Controllers\AuthController;
//use \App\Http\Middleware\AuthenticMD;
use \App\Http\Controllers\LevelController;
use \App\Http\Controllers\BreadController;
use \App\Http\Controllers\MeatsController;
use \App\Http\Controllers\OptionalController;
use \App\Http\Controllers\HamburgerController;
use \App\Http\Controllers\DeleteHamburgerController;
use \App\Http\Controllers\AdditionalHamburgerController;
use \App\Http\Controllers\CancellationHamburgerController;

//auth
Route::post('/v1/authentication', [AuthController::class, 'post_Auth'])->name('authentication.auth');
Route::post('/v1/account', [AccountController::class, 'createUser'])->name('user.create');
Route::middleware('AuthenticMD')->get('/v1/authentication/token', [AuthController::class, 'token_verify'])->name('testdd');

Route::middleware('AuthenticMD')->prefix('/v1')->group(function () {

    //user comun
    Route::get('/account/me', [AccountController::class, 'getInfoAccount'])->name('account.me');
    Route::patch('/account/me', [UpdateAccountController::class, 'updateAccount'])->name('account.me');
    Route::post('/account/me/image', [AccountController::class, 'updateAccountImage'])->name('account.me');
    //Route::get('/account/refresh', [AccountController::class, 'refreshToken'])->name('account.refresh');

    Route::middleware('CheckIsAdmin')->patch('/user/{id}', [UserController::class, 'updateUser'])->name('user.find');
    Route::middleware('CheckIsAdmin')->get('/user', [UserController::class, 'allUsers'])->name('user.all');
    Route::middleware('CheckIsAdmin')->get('/user/{id}', [UserController::class, 'getUser'])->name('user.find');
    Route::middleware('CheckIsAdmin')->patch('/user/{id}', [UserController::class, 'updateUser'])->name('user.find');

    Route::middleware('CheckIsAdmin')->get('/level', [LevelController::class, 'allLevel'])->name('level.all');

    Route::get('/breads', [BreadController::class, 'allBreads'])->name('breads.all');

    Route::get('/meats', [MeatsController::class, 'allMeats'])->name('meats.all');

    Route::get('/optionals', [OptionalController::class, 'allOptionals'])->name('optionals.all');

    Route::post('/hamburger', [HamburgerController::class, 'createHamburger'])->name('user.createburger');
    Route::get('/hamburger', [HamburgerController::class, 'allHamburgerUser'])->name('user.allburger');
    Route::post('/hamburger/{hamburger_id}/optionals', [AdditionalHamburgerController::class, 'AdditionalHamburgerUser'])->name('user.additionalburger');
    Route::delete('/hamburger/{hamburger_id}/optionals/{optionals_id}', [DeleteHamburgerController::class, 'destroyHamburgerUser'])->name('user.destroyburger');
    Route::patch('/hamburger/{hamburger_id}', [CancellationHamburgerController::class, 'cancelHamburgerUser'])->name('user.cancelburger');
    
});


Route::any('{any}', function () {
    return response()->json([
        'status'    => false,
        'message'   => 'Page Not Found.',
    ], 404);
})->where('any', '.*');
