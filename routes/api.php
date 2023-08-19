<?php

use App\Http\Controllers\Api\DataAdminController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(UserController::class)->group(function() {
    // routing users
    Route::resource('/users', UserController::class);
    
    // routing register
    Route::post('/register', 'register')->name('register');

    // routing login
    Route::post('/login', 'login')->name('login');

    // routing logout
    Route::post('/logout', 'logout')->name('logout');

    // routing email verify
    Route::put('/email/verify/{uuid}', 'verify')->name('verification.verify');

    // routing resend email
    Route::get('/email/resend', 'resend')->name('verification.resend');
});


// routing data admin
Route::controller(DataAdminController::class)->group(function() {
    Route::resource('/data-admin', DataAdminController::class); 
});
