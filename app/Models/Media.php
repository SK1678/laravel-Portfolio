<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'filename',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'type',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isUsed(): bool
    {
        $path = $this->file_path;
        
        // Handle different slash formats in JSON
        $jsonEscapedPath = str_replace('/', '\\\\/', $path);
        
        // Check in User (profile_image and deeply nested paths in additional_info)
        if (\App\Models\User::where('profile_image', $path)
            ->orWhere('additional_info', 'like', '%'.$path.'%')
            ->orWhere('additional_info', 'like', '%'.$jsonEscapedPath.'%')
            ->exists()) return true;
        
        // Check in SiteSetting
        if (\App\Models\SiteSetting::where('logo_image', $path)->orWhere('favicon', $path)->exists()) return true;

        // Check in AboutPage
        if (\App\Models\AboutPage::where('image_path', $path)->exists()) return true;

        // Check in Service
        if (\App\Models\Service::where('icon', $path)->exists()) return true;

        // Check in HomePage (handles both single image and slider JSON array)
        if (\App\Models\HomePage::whereJsonContains('images', $path)
            ->orWhere('images', 'like', '%'.$path.'%')
            ->orWhere('images', 'like', '%'.$jsonEscapedPath.'%')
            ->orWhere('video_file', $path)
            ->exists()) return true;

        // Check in Award
        if (\App\Models\Award::whereJsonContains('proofs', $path)
            ->orWhere('proofs', 'like', '%'.$path.'%')
            ->orWhere('proofs', 'like', '%'.$jsonEscapedPath.'%')
            ->orWhere('proof_url', $path)
            ->exists()) return true;

        return false;
    }
}
