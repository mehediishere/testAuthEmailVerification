<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FrontEndController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::controller(FrontEndController::class)->group(function (){
    Route::get('/', 'home')->name('home');
    Route::get('/home', 'home')->name('home');

    Route::middleware('guest')->group(function (){
        Route::get('/login', 'login')->name('user.login');
        Route::post('/login', 'loginUser')->name('user.login');

        Route::get('/register', 'register')->name('user.register');
        Route::post('/register', 'registerStore')->name('user.register');
    });

    Route::middleware(['auth', 'verified'])->group(function (){
        Route::get('/profile', 'profile')->name('user.profile');
    });

    Route::middleware(['auth'])->group(function (){
        Route::get('/logout', 'logout')->name('user.logout');
    });

});

Route::prefix('dashboard')->controller(AdminDashboardController::class)->group(function (){

    Route::get('/', 'dashboard')->name('dashboard');

    Route::middleware('guest:admin')->group(function (){
        Route::get('/login', 'login')->name('admin.login');
        Route::post('/login', 'loginAdmin')->name('admin.login');

        Route::get('/register', 'register')->name('admin.register');
        Route::post('/register', 'registerStore')->name('admin.register');
    });

    Route::middleware('auth:admin')->group(function (){
        Route::get('/profile', 'profile')->name('admin.profile');
        Route::get('/logout', 'logout')->name('admin.logout');
    });
});

