<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('admin.pages.index');
    }

    public function portfolio()
    {
        return view('admin.pages.portfolio');
    }

    public function skills()
    {
        return view('admin.pages.skills');
    }

    public function messages()
    {
        return view('admin.pages.messages');
    }
}
