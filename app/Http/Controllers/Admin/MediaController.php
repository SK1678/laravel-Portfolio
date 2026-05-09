<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/media', $filename, 'public');
            
            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $path),
                'path' => $path
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Upload failed'], 400);
    }
}
