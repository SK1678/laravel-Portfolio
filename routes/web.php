<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\HomeSettingsController;
use App\Http\Controllers\Admin\AboutSettingsController;
use App\Http\Controllers\Admin\SkillSettingsController;
use App\Http\Controllers\Admin\CounterSettingsController;
use App\Http\Controllers\Admin\AwardSettingsController;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    $about = \App\Models\AboutPage::first();
    $siteOwner = \App\Models\User::where('is_site_owner', 1)->first();
    $skillSettings = \App\Models\SkillSetting::first();
    $skills = \App\Models\Skill::orderBy('order')->get();
    $counterSettings = \App\Models\CounterSetting::first();
    $counters = \App\Models\Counter::orderBy('order')->get();
    $awardSettings = \App\Models\AwardSetting::first();
    $awards = \App\Models\Award::orderBy('order')->get();
    return view('frontend.about', compact('about', 'siteOwner', 'skillSettings', 'skills', 'counterSettings', 'counters', 'awardSettings', 'awards'));
})->name('about');
Route::get('/resume', function () {
    $siteOwner = \App\Models\User::where('is_site_owner', 1)->first();
    return view('frontend.resume', compact('siteOwner'));
})->name('resume');
Route::get('/services', function () {
    $serviceSetting = \App\Models\ServiceSetting::first();
    $services = \App\Models\Service::orderBy('order')->get();
    return view('frontend.services', compact('serviceSetting', 'services'));
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

        // Settings
        Route::controller(\App\Http\Controllers\Admin\SettingsController::class)->group(function () {
            Route::get('/settings/global', 'index')->name('settings.global');
            Route::post('/settings/global/general', 'saveGeneral')->name('settings.saveGeneral');
            Route::post('/settings/global/seo', 'saveSeo')->name('settings.saveSeo');
            Route::post('/settings/global/email', 'saveEmail')->name('settings.saveEmail');
            Route::post('/settings/global/test-smtp', 'testSmtp')->name('settings.testSmtp');
        });

        // Page Configurations
        Route::get('/page', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('page');
        Route::get('/page/home', [HomeSettingsController::class, 'index'])->name('admin.page.home');
        Route::post('/page/home/save', [HomeSettingsController::class, 'save'])->name('admin.page.home.save');
        Route::get('/page/about', [AboutSettingsController::class, 'index'])->name('admin.page.about');
        Route::post('/page/about/save', [AboutSettingsController::class, 'save'])->name('admin.page.about.save');
        
        Route::get('/portfolio-manager', [\App\Http\Controllers\Admin\PageController::class, 'portfolio'])->name('admin.portfolio');
        Route::get('/skills-manager', [SkillSettingsController::class, 'index'])->name('admin.skills');
        Route::post('/skills-manager/save', [SkillSettingsController::class, 'save'])->name('admin.skills.save');
        Route::get('/counter-manager', [CounterSettingsController::class, 'index'])->name('admin.counters');
        Route::post('/counter-manager/save', [CounterSettingsController::class, 'save'])->name('admin.counters.save');
        Route::get('/award-manager', [AwardSettingsController::class, 'index'])->name('admin.awards');
        Route::post('/award-manager/save', [AwardSettingsController::class, 'save'])->name('admin.awards.save');
        Route::get('/services-manager', [\App\Http\Controllers\Admin\ServiceSettingsController::class, 'index'])->name('admin.services');
        Route::post('/services-manager/save', [\App\Http\Controllers\Admin\ServiceSettingsController::class, 'save'])->name('admin.services.save');
        Route::post('/media/upload', [\App\Http\Controllers\Admin\MediaController::class, 'upload'])->name('admin.media.upload');
        Route::get('/messages', [\App\Http\Controllers\Admin\PageController::class, 'messages'])->name('admin.messages');
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
