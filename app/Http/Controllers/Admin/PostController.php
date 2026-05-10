<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('admin.pages.post_create', compact('categories'));
    }

    public function store(Request $request)
    {
        Log::info('POST STORE HIT', $request->all());

        try {
            // Validate basic info
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|unique:posts,slug',
            ]);

            // Create post
            $post = Post::create([
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'content' => $request->input('content'),
                'excerpt' => $request->input('excerpt'),
                'feature_gallery' => $request->input('feature_gallery'),
                'attachments' => $request->input('attachments'),
                'status' => $request->input('status', 'published'),
            ]);

            if ($request->input('categories')) {
                $post->categories()->sync($request->input('categories'));
            }

            if ($request->input('tags')) {
                $tagNames = is_array($request->input('tags')) ? $request->input('tags') : json_decode($request->input('tags'), true);
                if (is_array($tagNames)) {
                    $tagIds = [];
                    foreach ($tagNames as $tagData) {
                        $name = is_string($tagData) ? $tagData : ($tagData['value'] ?? $tagData);
                        $tag = Tag::firstOrCreate(
                            ['slug' => Str::slug($name)],
                            ['name' => $name]
                        );
                        $tagIds[] = $tag->id;
                    }
                    $post->tags()->sync($tagIds);
                }
            }

            Log::info('POST SAVED SUCCESS: ID ' . $post->id);

            return response()->json([
                'success' => true, 
                'message' => 'Post saved successfully!', 
                'redirect' => route('admin.posts')
            ]);

        } catch (\Illuminate\Validation\ValidationException $ve) {
            Log::warning('POST VALIDATION FAILED', $ve->errors());
            return response()->json([
                'success' => false, 
                'message' => 'Validation failed', 
                'errors' => $ve->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('POST STORE ERROR: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $query = Post::with(['categories', 'tags']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.name', $request->tag);
            });
        }

        $posts = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        
        if ($request->ajax()) {
            return view('admin.pages.partials.post_table_rows', compact('posts', 'categories'))->render();
        }

        return view('admin.pages.post_index', compact('posts', 'categories'));
    }

    public function edit($id)
    {
        $post = Post::with(['categories', 'tags'])->findOrFail($id);
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('admin.pages.post_create', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        Log::info('POST UPDATE HIT: ID ' . $id, $request->all());

        try {
            $post = Post::findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|unique:posts,slug,' . $id,
            ]);

            $post->update([
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'content' => $request->input('content'),
                'excerpt' => $request->input('excerpt'),
                'feature_gallery' => $request->input('feature_gallery'),
                'attachments' => $request->input('attachments'),
                'status' => $request->input('status', 'published'),
            ]);

            if ($request->input('categories')) {
                $post->categories()->sync($request->input('categories'));
            } else {
                $post->categories()->detach();
            }

            if ($request->input('tags')) {
                $tagNames = is_array($request->input('tags')) ? $request->input('tags') : json_decode($request->input('tags'), true);
                if (is_array($tagNames)) {
                    $tagIds = [];
                    foreach ($tagNames as $tagData) {
                        $name = is_string($tagData) ? $tagData : ($tagData['value'] ?? $tagData);
                        $tag = Tag::firstOrCreate(
                            ['slug' => Str::slug($name)],
                            ['name' => $name]
                        );
                        $tagIds[] = $tag->id;
                    }
                    $post->tags()->sync($tagIds);
                }
            } else {
                $post->tags()->detach();
            }

            return response()->json([
                'success' => true, 
                'message' => 'Post updated successfully!', 
                'redirect' => route('admin.posts')
            ]);

        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $ve->errors()], 422);
        } catch (\Exception $e) {
            Log::error('POST UPDATE ERROR: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(['success' => true, 'message' => 'Post deleted successfully!']);
    }

    public function fetchTags(Request $request)
    {
        $search = $request->input('q', '');
        $tags = Tag::where('name', 'like', "%{$search}%")->get(['name as value', 'name']);
        return response()->json($tags);
    }
}
