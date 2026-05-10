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
    $portfolioCategory = \App\Models\Category::where('name', 'Portfolio')->first();
    $posts = collect();
    $subCategories = collect();
    if ($portfolioCategory) {
        $subCategories = $portfolioCategory->children;
        $categoryIds = $subCategories->pluck('id')->push($portfolioCategory->id);
        $posts = \App\Models\Post::whereHas('categories', function($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        })->with('categories')->where('status', 'published')->latest()->get();
    }
    return view('frontend.portfolio', compact('posts', 'subCategories'));
})->name('portfolio');
Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::get('/blogs', [\App\Http\Controllers\BlogController::class, 'index'])->name('blogs');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
Route::put('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

Route::middleware(['auth', 'verified'])->group(function () {
    // Shared Access (Both Admins and Users)
    // Shared Access (Both Admins and Users) - Empty for now

    // Admin Only Access
    Route::middleware(['adminPermission'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/chart-data', [\App\Http\Controllers\Admin\DashboardController::class, 'getChartData'])->name('admin.dashboard.chartData');

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
        Route::get('/media', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('admin.media');
        Route::get('/media/fetch', [\App\Http\Controllers\Admin\MediaController::class, 'fetch'])->name('admin.media.fetch');
        Route::post('/media/upload', [\App\Http\Controllers\Admin\MediaController::class, 'upload'])->name('admin.media.upload');
        Route::delete('/media/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('admin.media.destroy');
        Route::post('/media/bulk-delete', [\App\Http\Controllers\Admin\MediaController::class, 'bulkDelete'])->name('admin.media.bulkDelete');
        Route::get('/messages', [\App\Http\Controllers\Admin\PageController::class, 'messages'])->name('admin.messages');
        Route::post('/messages/{id}/mark-as-read', [\App\Http\Controllers\Admin\PageController::class, 'markAsRead'])->name('admin.messages.markAsRead');
        Route::delete('/messages/{id}', [\App\Http\Controllers\Admin\PageController::class, 'destroyMessage'])->name('admin.messages.destroy');

        // Categories
        Route::controller(\App\Http\Controllers\Admin\CategoryController::class)->group(function () {
            Route::get('/categories', 'index')->name('admin.categories');
            Route::post('/categories', 'store')->name('admin.categories.store');
            Route::delete('/categories/{id}', 'destroy')->name('admin.categories.destroy');
        });

        // Posts
        Route::controller(\App\Http\Controllers\Admin\PostController::class)->group(function () {
            Route::get('/posts', 'index')->name('admin.posts');
            Route::get('/posts/create', 'create')->name('admin.posts.create');
            Route::post('/posts', 'store')->name('admin.posts.store');
            Route::get('/posts/{id}/edit', 'edit')->name('admin.posts.edit');
            Route::put('/posts/{id}', 'update')->name('admin.posts.update');
            Route::delete('/posts/{id}', 'destroy')->name('admin.posts.destroy');
            Route::get('/tags/fetch', 'fetchTags')->name('admin.tags.fetch');
        });

        // Comments
        Route::controller(\App\Http\Controllers\Admin\CommentController::class)->group(function () {
            Route::get('/comments', 'index')->name('admin.comments');
            Route::post('/comments/{id}/toggle-status', 'toggleStatus')->name('admin.comments.toggle');
            Route::delete('/comments/{id}', 'destroy')->name('admin.comments.destroy');
            Route::post('/comments/{id}/mark-as-read', 'markAsRead')->name('admin.comments.markAsRead');
        });
    });

    // User Only Access (Future)
    Route::middleware(['userPermission'])->group(function () {
        // Add user-specific routes here
    });
});

// Chat System Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chat/messages', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/messages', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');

    Route::middleware(['adminPermission'])->prefix('dashboard')->group(function () {
        Route::get('/chats', [\App\Http\Controllers\ChatController::class, 'adminIndex'])->name('admin.chats');
        Route::get('/chats/sidebar', [\App\Http\Controllers\ChatController::class, 'getSidebar'])->name('admin.chats.sidebar');
        Route::get('/chats/json', [\App\Http\Controllers\ChatController::class, 'getConversationsJson'])->name('admin.chats.json');
        Route::get('/chats/search-users', [\App\Http\Controllers\ChatController::class, 'searchUsers'])->name('admin.chats.searchUsers');
        Route::get('/chats/{user}', [\App\Http\Controllers\ChatController::class, 'getConversation'])->name('admin.chats.show');
        Route::post('/chats/{user}/reply', [\App\Http\Controllers\ChatController::class, 'adminReply'])->name('admin.chats.reply');
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

// Google Auth Routes
Route::get('auth/google', [\App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

require __DIR__ . '/auth.php';

Route::post('/track-click', [\App\Http\Controllers\HomeController::class, 'trackClick'])->name('track.click');