<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CurrencyController;
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

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth', 'verified']], function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::post('/products/export', [AdminProductController::class, 'exportProductsToCsv'])->name('admin.products.export');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'delete'])->name('admin.products.delete');
});

Route::get('/', [HomeController::class, 'index'])->name('client.home.index');
Route::get('/products/{category?}', [CatalogController::class, 'index'])->name('client.products.index');
Route::get('/products/{category}/{product}', [CatalogController::class, 'showProduct'])->name('client.products.showProduct');

Route::get('/currency/{currency}/{rate}', [CurrencyController::class, 'changeCurrency'])->name('client.currencies.change');
