<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::middleware('guest')->group(function () {
    Route::get('/registration', [RegisterController::class, 'create'])->name('register');
    Route::post('/registration', [RegisterController::class, 'store']);
    Route::get('/login', [RegisterController::class, 'login'])->name('login');
    Route::post('/login', [RegisterController::class, 'authenticate'])->name('authenticate');
    Route::get('/forgot-password', [RegisterController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [RegisterController::class, 'sendResetLink'])
        ->name('password.email')
        ->middleware('throttle:3,1');
    Route::get('reset-password/{token}', [RegisterController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [RegisterController::class, 'updatePassword'])->name('password.update');
});


Route::middleware('auth')->group(function () {
    Route::get('/verify-email', [RegisterController::class, 'verifyEmail'])->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:3,1'])->name('verification.send');

    Route::get('logout', [RegisterController::class, 'logout'])->name('logout');
});

Route::get('/', [HomeController::class, 'index'])->name('client.home.index');
Route::get('/products', [CatalogController::class, 'index'])->name('client.products.index');
Route::get('/products/{category}', [CatalogController::class, 'showProductsByCategory'])->name('client.products.showProductsByCategory');
Route::get('/products/{category}/{product}', [CatalogController::class, 'showProduct'])->name('client.products.showProduct');

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth', 'verified']], function () {
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'delete'])->name('admin.products.delete');
});
