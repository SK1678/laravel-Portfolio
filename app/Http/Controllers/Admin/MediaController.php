<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('original_name', 'like', "%{$search}%");
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $query->orderBy('created_at', 'desc');

        $media = $query->paginate(24)->appends($request->all());

        $types = Media::select('type')->distinct()->pluck('type');

        return view('admin.media.index', compact('media', 'types'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filename = time() . '_' . $originalName;
            $path = $file->storeAs('uploads/media', $filename, 'public');
            
            $mime = $file->getMimeType();
            $type = 'document';
            if (str_starts_with($mime, 'image/')) $type = 'image';
            elseif (str_starts_with($mime, 'video/')) $type = 'video';
            elseif (str_starts_with($mime, 'audio/')) $type = 'audio';
            elseif (str_starts_with($mime, 'application/pdf')) $type = 'pdf';
            elseif (str_contains($mime, 'zip') || str_contains($mime, 'rar')) $type = 'archive';

            $mediaModel = Media::create([
                'filename' => $filename,
                'original_name' => $originalName,
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $mime,
                'type' => $type,
                'user_id' => Auth::id(),
            ]);
            
            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $path),
                'path' => $path,
                'media' => $mediaModel
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Upload failed'], 400);
    }

    public function destroy(Media $media)
    {
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }
        $media->delete();

        return redirect()->back()->with('success', 'Media file deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:media,id'
        ]);

        $medias = Media::whereIn('id', $request->ids)->get();

        foreach ($medias as $media) {
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
            $media->delete();
        }

        return response()->json(['success' => true, 'message' => 'Selected media files deleted successfully.']);
    }

    public function fetch(Request $request)
    {
        $query = Media::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('original_name', 'like', "%{$search}%");
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $media = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'media' => $media
        ]);
    }
}
