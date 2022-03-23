<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ApiController;
use \App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//auth
Route::prefix('/authentication')->group(function () {
    Route::post('', [AuthController::class, 'post_Auth'])->name('authentication.auth');
    //Route::get('/refresh', [AuthController::class, 'post_Auth'])->name('authentication.refresh');;
});


//create user
Route::get('exemplo', [ApiController::class, 'getAllStudents']);



/* Route::get('students/{id}', 'ApiController@getStudent');
Route::post('students', 'ApiController@createStudent');
Route::put('students/{id}', 'ApiController@updateStudent');
Route::delete('students/{id}','ApiController@deleteStudent'); */

/* Route::get('students',  function() {
    $controller = new \App\Http\Controllers\ApiController;
    return $controller->getAllStudents();
    //fazer algo com o $array...
}); */