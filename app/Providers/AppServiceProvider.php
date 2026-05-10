<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            $siteSettings = \App\Models\SiteSetting::first();
            view()->share('siteSettings', $siteSettings);

            // Dynamically configure mailer if settings exist
            if ($siteSettings && $siteSettings->smtp_host) {
                config([
                    'mail.mailers.smtp.host' => $siteSettings->smtp_host,
                    'mail.mailers.smtp.port' => $siteSettings->smtp_port,
                    'mail.mailers.smtp.encryption' => $siteSettings->encryption_type,
                    'mail.mailers.smtp.username' => $siteSettings->smtp_username,
                    'mail.mailers.smtp.password' => $siteSettings->smtp_password,
                    'mail.from.address' => $siteSettings->smtp_username,
                    'mail.from.name' => $siteSettings->sender_name ?? config('app.name'),
                    'mail.default' => 'smtp',
                ]);
            }

            $siteOwner = \App\Models\User::where('is_site_owner', true)->first();
            view()->share('siteOwner', $siteOwner);

            // Use View Composer for dynamic notifications to ensure they reflect Controller changes
            view()->composer('admin.include.adminHeader', function ($view) {
                $comments = \App\Models\Comment::with(['user', 'post'])->latest()->take(5)->get()->map(function($item) {
                    $item->notif_type = 'comment';
                    $item->body = $item->comment; // Add body property for consistency
                    return $item;
                });
                $messages = \App\Models\Message::latest()->take(5)->get()->map(function($item) {
                    $item->notif_type = 'message';
                    $item->body = $item->message; // Add body property for consistency
                    return $item;
                });

                $notifications = $comments->concat($messages)->sortByDesc('created_at')->take(5);
                
                $unreadComments = \App\Models\Comment::where('is_read', false)->count();
                $unreadMessages = \App\Models\Message::where('is_read', false)->count();
                
                $unreadChats = 0;
                if (auth()->check()) {
                    $unreadChats = \App\Models\ChatMessage::where('receiver_id', auth()->id())
                        ->where('is_read', false)
                        ->count();
                }

                $view->with([
                    'notifications' => $notifications,
                    'totalUnread' => $unreadComments + $unreadMessages + $unreadChats
                ]);
            });
        }
    }
}
