<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\HomePage;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $homeSettings = HomePage::first();
        $siteOwner = User::where('is_site_owner', true)->first();
        
        return view('frontend.home', compact('homeSettings', 'siteOwner'));
    }

    public function trackClick(Request $request)
    {
        \App\Models\SiteSetting::query()->increment('total_clicks');

        // Log to site_analytics for time-series charts
        \DB::table('site_analytics')->insert([
            'type' => 'click',
            'created_at' => now(),
        ]);
        return response()->json(['status' => 'success']);
    }
}
