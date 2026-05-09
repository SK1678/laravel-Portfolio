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
}
