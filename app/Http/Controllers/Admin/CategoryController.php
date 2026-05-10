<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->orderBy('parent_id')->orderBy('name')->get();
        $parents = Category::whereNull('parent_id')->get();
        return view('admin.pages.categories', compact('categories', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'parent_id' => $request->parent_id,
            'is_protected' => false
        ]);

        return response()->json(['success' => true, 'message' => 'Category created successfully!']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->is_protected) {
            return response()->json(['success' => false, 'message' => 'Protected categories cannot be deleted!'], 403);
        }

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted successfully!']);
    }
}
