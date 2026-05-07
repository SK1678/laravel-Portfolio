<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('frontend.home');
})->name('home');
Route::get('/about', function () {
    return view('frontend.about');
})->name('about');
Route::get('/resume', function () {
    return view('frontend.resume');
})->name('resume');
Route::get('/services', function () {
    return view('frontend.services');
})->name('services');
Route::get('/portfolio', function () {
    return view('frontend.portfolio');
})->name('portfolio');
Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

Route::middleware(['auth', 'verified'])->group(function () {
    // Shared Access (Both Admins and Users)
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    // Admin Only Access
    Route::middleware(['adminPermission'])->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::patch('/user/{id}/approve', [UserController::class, 'approve'])->name('user.approve');
        Route::patch('/user/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // User Only Access (Future)
    Route::middleware(['userPermission'])->group(function () {
        // Add user-specific routes here
    });
});

Route::get('/login', function () {
    return view('admin.login');
})->name('login');
Route::get('/signup', function () {
    return view('admin.signup');
})->name('signup');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
