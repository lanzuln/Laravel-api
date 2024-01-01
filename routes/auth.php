<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\api\auth\LoginController;
use App\Http\Controllers\api\auth\LogoutController;
use App\Http\Controllers\api\auth\RegisterController;
use App\Http\Controllers\api\auth\PasswordResetController;

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


Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [LogoutController::class, 'logout']);
    Route::post('verify/email/send', [EmailVerifyController::class, 'verifyEmailSend']);
    Route::post('verify/email', [EmailVerifyController::class, 'verifyEmail'])->name('email.verify');
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('reset/email/send', [PasswordResetController::class, 'resetPasswordLink']);
Route::post('reset/password', [PasswordResetController::class, 'resetPassword'])->middleware('signed')->name('reset.Password.Link');
