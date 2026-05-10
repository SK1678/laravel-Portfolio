<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('status', 'published')->with(['categories', 'tags']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->whereHas('categories', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $posts = $query->latest()->paginate(8);

        if ($request->ajax()) {
            return view('frontend.include.blog_list', compact('posts'))->render();
        }

        $categories = Category::root()->with('children')->get();

        return view('frontend.blogs', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
                    ->where('status', 'published')
                    ->with(['categories', 'tags'])
                    ->firstOrFail();

        $comments = $post->comments()->visible()->whereNull('parent_id')->with(['user', 'replies' => function($q) {
            $q->visible();
        }, 'replies.user'])->latest()->get();
        $recentPosts = Post::where('status', 'published')->where('id', '!=', $post->id)->latest()->take(5)->get();

        // Increment lifetime views and log time-based view
        $post->increment('views');
        \DB::table('post_views')->insert([
            'post_id' => $post->id,
            'ip_address' => request()->ip(),
            'viewed_at' => now(),
        ]);

        return view('frontend.blog_show', compact('post', 'comments', 'recentPosts'));
    }
}
