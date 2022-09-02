<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogWebController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\LoginUserController;


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

Route::apiResource('blogwebpost',BlogWebController::class);
Route::apiResource('blogwebusers',RegisterUserController::class);
Route::get('blogwebusers/search/{fullname}',[RegisterUserController::class,'search']);

Route::post('/login', [LoginUserController::class, 'login']);

