<?php

use App\Models\User;
use App\Models\Media;
use App\Models\Award;
use App\Models\SiteSetting;
use App\Models\AboutPage;
use App\Models\Service;
use App\Models\HomePage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
 * Enhanced Script to sync ALL existing attachments to the Media Library.
 */

function syncMedia() {
    $count = 0;

    // 1. Users
    $users = User::all();
    foreach ($users as $user) {
        if ($user->profile_image) {
            if (registerIfMissing($user->profile_image, $user->id)) $count++;
        }
        $info = $user->additional_info;
        if (isset($info['cv']['path'])) {
            if (registerIfMissing($info['cv']['path'], $user->id, $info['cv']['name'] ?? null)) $count++;
        }
        // Education/Pro
        foreach (['education', 'professional'] as $type) {
            $items = $info[$type] ?? [];
            foreach ($items as $item) {
                $docs = $item['documents'] ?? [];
                foreach ($docs as $doc) {
                    if (isset($doc['path'])) {
                        if (registerIfMissing($doc['path'], $user->id, $doc['name'] ?? null)) $count++;
                    }
                }
            }
        }
    }

    // 2. Awards
    $awards = Award::all();
    foreach ($awards as $award) {
        $proofs = $award->proofs ?? [];
        foreach ($proofs as $proof) {
            $val = $proof['value'] ?? '';
            // Only sync local files (starting with uploads/ or containing storage/)
            if (str_contains($val, 'storage/')) {
                $path = explode('storage/', $val)[1];
                if (registerIfMissing($path, 1, $proof['label'] ?? null)) $count++;
            } elseif (str_starts_with($val, 'uploads/')) {
                if (registerIfMissing($val, 1, $proof['label'] ?? null)) $count++;
            }
        }
    }

    echo "Synced $count new records to Media Library.\n";
}

function registerIfMissing($path, $userId, $preferredName = null) {
    // Clean path (remove absolute URL if present)
    if (str_contains($path, 'http')) {
        if (str_contains($path, 'storage/')) {
            $path = explode('storage/', $path)[1];
        } else {
            return false; // External
        }
    }

    // Check if already registered
    if (Media::where('file_path', $path)->exists()) {
        return false;
    }

    $fullPath = storage_path('app/public/' . $path);
    if (!File::exists($fullPath)) {
        return false;
    }

    $mime = File::mimeType($fullPath);
    $size = File::size($fullPath);
    $originalName = $preferredName ?: basename($path);
    
    $type = 'document';
    if (str_starts_with($mime, 'image/')) $type = 'image';
    elseif (str_starts_with($mime, 'video/')) $type = 'video';
    elseif (str_starts_with($mime, 'audio/')) $type = 'audio';
    elseif (str_starts_with($mime, 'application/pdf')) $type = 'pdf';
    elseif (str_contains($mime, 'zip') || str_contains($mime, 'rar')) $type = 'archive';

    Media::create([
        'filename' => basename($path),
        'original_name' => $originalName,
        'file_path' => $path,
        'file_size' => $size,
        'mime_type' => $mime,
        'type' => $type,
        'user_id' => $userId,
    ]);
    
    return true;
}

syncMedia();
