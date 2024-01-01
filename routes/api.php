<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ----------------------------- register api route ------------------------------//
Route::post('/register', [ApiController::class, 'register']);

// ----------------------------- login api route ------------------------------//
Route::post('/login', [ApiController::class, 'login']);

// ----------------------------- profile api route ------------------------------//
Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::get('/profile', [ApiController::class, 'profile']);

    Route::get('/logout', [ApiController::class, 'logout']);

});
