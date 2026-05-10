<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Post, Comment, SiteSetting, Message};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $siteSettings = SiteSetting::first();
        $stats = [
            'total_posts' => Post::count(),
            'total_post_views' => Post::sum('views'),
            'total_site_views' => $siteSettings->total_site_views ?? 0,
            'total_comments' => Comment::count(),
            'first_time_views' => $siteSettings->first_time_views ?? 0,
            'returning_views' => $siteSettings->returning_views ?? 0,
            'total_clicks' => $siteSettings->total_clicks ?? 0,
        ];

        // Fetch Post Stats by Interval
        $intervals = [
            'daily' => now()->subDay(),
            'weekly' => now()->subWeek(),
            'monthly' => now()->subMonth(),
            'quarterly' => now()->subMonths(3),
            'semesterly' => now()->subMonths(6),
            'yearly' => now()->subYear(),
        ];

        $postStats = [];
        foreach ($intervals as $key => $date) {
            $postStats[$key] = \DB::table('post_views')
                ->where('viewed_at', '>=', $date)
                ->count();
        }

        // Top viewed posts (overall top 5)
        $topPosts = Post::orderBy('views', 'desc')->take(5)->get();

        // Latest Interactions (Unified Comments and Contact Messages)
        $recentComments = Comment::with('user', 'post')->latest()->take(5)->get()->map(function($item) {
            return (object)[
                'id' => $item->id,
                'user_name' => $item->user->name ?? 'Guest',
                'body' => $item->comment,
                'date' => $item->created_at,
                'link' => route('admin.comments'), // Link to comment manager
                'type' => 'Comment'
            ];
        });

        $recentMessages = Message::latest()->take(5)->get()->map(function($item) {
            return (object)[
                'id' => $item->id,
                'user_name' => $item->name,
                'body' => $item->message,
                'date' => $item->created_at,
                'link' => route('admin.messages'), // Link to message manager
                'type' => 'Message'
            ];
        });

        $interactions = $recentComments->concat($recentMessages)->sortByDesc('date')->take(5);

        // Pre-fetch initial chart data (This Week)
        $initialChartData = $this->getChartDataByPeriod('this_week');

        return view('admin.index', compact('stats', 'postStats', 'topPosts', 'interactions', 'initialChartData'));
    }

    public function getChartData(Request $request)
    {
        $period = $request->input('period', 'this_week');
        return response()->json($this->getChartDataByPeriod($period));
    }

    private function getChartDataByPeriod($period)
    {
        $data = [];
        $labels = [];
        $views = [];
        $clicks = [];

        switch ($period) {
            case 'today':
                for ($i = 0; $i < 24; $i++) {
                    $hour = now()->startOfDay()->addHours($i);
                    $labels[] = $hour->format('H:00');
                    $views[] = \DB::table('site_analytics')->where('type', 'view')->whereBetween('created_at', [$hour, (clone $hour)->endOfHour()])->count();
                    $clicks[] = \DB::table('site_analytics')->where('type', 'click')->whereBetween('created_at', [$hour, (clone $hour)->endOfHour()])->count();
                }
                break;
            case 'this_week':
                for ($i = 6; $i >= 0; $i--) {
                    $date = now()->subDays($i)->startOfDay();
                    $labels[] = $date->format('D');
                    $views[] = \DB::table('site_analytics')->where('type', 'view')->whereDate('created_at', $date)->count();
                    $clicks[] = \DB::table('site_analytics')->where('type', 'click')->whereDate('created_at', $date)->count();
                }
                break;
            case 'this_month':
                $daysInMonth = now()->daysInMonth;
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $date = now()->startOfMonth()->addDays($i - 1);
                    $labels[] = $date->format('d M');
                    $views[] = \DB::table('site_analytics')->where('type', 'view')->whereDate('created_at', $date)->count();
                    $clicks[] = \DB::table('site_analytics')->where('type', 'click')->whereDate('created_at', $date)->count();
                }
                break;
            case 'last_6_months':
                for ($i = 5; $i >= 0; $i--) {
                    $month = now()->subMonths($i)->startOfMonth();
                    $labels[] = $month->format('M Y');
                    $views[] = \DB::table('site_analytics')->where('type', 'view')->whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count();
                    $clicks[] = \DB::table('site_analytics')->where('type', 'click')->whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count();
                }
                break;
        }

        return [
            'labels' => $labels,
            'views' => $views,
            'clicks' => $clicks
        ];
    }
}
