<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TranscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PagesController::class, "index"])->name('index');
Route::get('/user/login', [PagesController::class, "login"]);
Route::post('/userlogin', [PagesController::class, "userlogin"])->name('userlogin');
Route::get('/resetpassword',[PagesController::class, 'resetpassword']);
Route::get('/forgetpassword',[PagesController::class, 'forgetpassword']);
Route::get('contribute', [PagesController::class, 'contribute']);
Route::get('listen', [PagesController::class, 'listen']);
Route::get('review', [PagesController::class, 'review']);
Route::get('write', [PagesController::class, 'write']);
Route::get('language', [PagesController::class, 'language']);
Route::get('dataCollection', [PagesController::class, 'dataCollection']);
Route::get('about', [PagesController::class, 'about']);

Route::middleware('auth')->group(function () {
    Route::get('profiles', [PagesController::class, 'profiles']);
    Route::get('stats', [PagesController::class, 'stats']);
    Route::get('change_info', [PagesController::class, 'changeinfo']);
    Route::get('delete_profile', [PagesController::class, 'delete_profile']);
    Route::get('download', [PagesController::class, 'download']);
    Route::get('/profile', [ProfileController::class, 'updateprofile'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'updateprofile'])->name('profile.update');
    Route::post('/changeinfo/update', [ProfileController::class, 'updatechangeinfo'])->name('changeinfo.update');
    Route::post('/profile.delete', [ProfileController::class, 'updatedelete'])->name('profile.delete');
});


// Admin login route (publicly accessible)
Route::get('/admin/login', [AdminController::class, 'login'])->name('adminlogin');
// Protected admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admindashboard', [AdminController::class, 'admindashboard'])->name('admindashboard');
    Route::get('/role', [AdminController::class, 'role'])->name('admin.role');
    Route::get('/permission', [AdminController::class, 'permission'])->name('admin.permission');
    Route::get('/usermanagement', [AdminController::class, 'usermanagement'])->name('admin.usermanagement');
    Route::get('/rewardmanagement', [AdminController::class, 'rewardmanagement'])->name('admin.rewardmanagement');
    Route::get('/transcriptionmanagement', [AdminController::class, 'transcriptionmanagement'])->name('admin.transcriptionmanagement');
    Route::get('/languagemanagement', [AdminController::class, 'languagemanagement'])->name('admin.languagemanagement');
    Route::get('/settingsmanagement', [AdminController::class, 'settingsmanagement'])->name('admin.settingsmanagement');
    Route::get('/assignrole', [AdminController::class, 'assignrole'])->name('admin.assignrole');
    Route::post('/admin/activateadmin/{userId}', [AdminController::class, 'activateUser'])->name('admin.activateUser');
    Route::post('/admin/suspend/{userId}', [AdminController::class, 'suspendUser']);
    Route::post('/admin/delete', [AdminController::class, 'deleteUser']);
    Route::post('/admin/resetpassword', [AdminController::class, 'resetpassword']);
    Route::post('/admin/assignrole/{userId}', [AdminController::class, 'assignRole']);
    Route::post('/admin/make-admin', [AdminController::class, 'makeAdmin']);

    //invite user or admin
    Route::post('/inviteadmin', [AdminController::class, 'inviteAdmin']);
    Route::post('/createlanguage', [AdminController::class, 'createlanguage']);
});

Route::prefix('transcriptions')->group(function () {
    Route::get('/', [TranscriptionController::class, 'index']);
    Route::post('/', [TranscriptionController::class, 'store']);
});

Route::prefix('getspeak')->group(function () {
    Route::get('/', [TranscriptionController::class, 'getSpeak']);
    Route::post('/', [TranscriptionController::class, 'createSpeak']);
});

Route::prefix('getreview')->group(function () {
    Route::get('/', [TranscriptionController::class, 'getReview']);
    Route::post('/{id}/update', [TranscriptionController::class, 'updateReview']);
    Route::get('/next', [TranscriptionController::class, 'getNextReview']);
});


Route::prefix('getlisten')->group(function () {
    Route::get('/', [TranscriptionController::class, 'getListen']);
    Route::post('/', [TranscriptionController::class, 'createListen']);
});

Route::prefix('getwrite')->group(function () {
    Route::get('/', [TranscriptionController::class, 'getWrite']);
    Route::post('/', [TranscriptionController::class, 'createWrite']);
});

Route::prefix('getreward')->group(function () {
    Route::get('/', [TranscriptionController::class, 'getReward']);
    Route::post('/', [TranscriptionController::class, 'createReward']);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/logout', function () {
    Auth::logout();
    session()->flush(); // Remove all session data
    return redirect('/'); // Redirect to the homepage or login page
})->name('logout');
require __DIR__.'/auth.php';
