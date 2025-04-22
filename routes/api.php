<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\PagesController; 
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

Route::view('/index', 'index');

Route::post('/user/login', [UserController::class, "login"]);
Route::post('/user/register', [UserController::class, "createUser"]);
Route::post('/user/forgetpassword', [UserController::class, "forgetpassword"]);
Route::post('/user/resetpassword', [UserController::class, "resetpassword"]);

Route::post('/index_analytics', [PagesController::class, 'index']);

Route::post('/user/updateprofile', [ProfileController::class, 'updateprofile']);
Route::post('/user/updatechangeinfo', [ProfileController::class, 'updatechangeinfo']);
Route::post('/user/updatedelete', [ProfileController::class, 'updatedelete']);