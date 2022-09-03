<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\UserUpdateProfile;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:sanctum'], function () {
    // Route that needs the user to be logged in
    Route::get('/userDetails', [LoginUserController::class, 'userDetails']);
    Route::apiResource('blogwebpost',PostController::class);
    Route::apiResource('updatename',UserUpdateProfile::class);

});


Route::apiResource('blogwebusers',RegisterUserController::class);
Route::get('blogwebusers/search/{fullname}',[RegisterUserController::class,'search']);
Route::post('/login', [LoginUserController::class, 'login']);




