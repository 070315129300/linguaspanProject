<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ProfileController;
//use App\Http\Controllers\PagesController;
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

// Public Routes
Route::post('/user/login', [UserController::class, "login"]);
Route::post('/user/register', [UserController::class, "createUser"]);
Route::post('/user/forgetpassword', [UserController::class, "forgetpassword"]);
Route::post('/user/resetpassword', [UserController::class, "resetpassword"]);
//Route::post('/index_analytics', [PagesController::class, 'index']);
//Route::post('/user/stats', [PagesController::class, 'stats']);
//Route::get('/language-stats', [PagesController::class, 'language']);

// Protected Routes (Require Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/user/updateprofile', [ProfileController::class, 'updateprofile']);
    Route::post('/user/updatechangeinfo', [ProfileController::class, 'updatechangeinfo']);
    Route::delete('/user/updatedelete', [ProfileController::class, 'updatedelete']);
});
