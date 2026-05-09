<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSettingsController extends Controller
{
    public function index()
    {
        $homeSettings = HomePage::first();
        if (!$homeSettings) {
            $homeSettings = HomePage::create([
                'mode' => 'single',
                'images' => [],
                'buttons' => [],
                'show_cv_button' => true,
                'cv_button_label' => 'Download CV'
            ]);
        }

        $siteOwner = User::where('is_site_owner', true)->first();
        $cvData = null;
        if ($siteOwner && isset($siteOwner->additional_info['cv'])) {
            $cvData = $siteOwner->additional_info['cv'];
        }

        return view('admin.pages.home_settings', compact('homeSettings', 'cvData'));
    }

    public function save(Request $request)
    {
        $homeSettings = HomePage::first();
        
        $homeSettings->mode = $request->mode;
        
        // Handle Single Image or Slider Images
        if ($request->hasFile('home_images')) {
            $images = $homeSettings->images ?? [];
            foreach ($request->file('home_images') as $file) {
                $path = $file->store('home', 'public');
                $images[] = $path;
            }
            $homeSettings->images = $images;
        }

        // Handle Image Removals
        if ($request->remove_images) {
            $images = $homeSettings->images ?? [];
            $toRemove = explode(',', $request->remove_images);
            foreach ($toRemove as $path) {
                if (($key = array_search($path, $images)) !== false) {
                    unset($images[$key]);
                    Storage::disk('public')->delete($path);
                }
            }
            $homeSettings->images = array_values($images);
        }

        // Handle Video
        $homeSettings->video_source = $request->video_source ?? 'url';
        if ($request->video_source === 'file' && $request->hasFile('video_file')) {
            // Delete old file if exists
            if ($homeSettings->video_file) {
                Storage::disk('public')->delete($homeSettings->video_file);
            }
            $homeSettings->video_file = $request->file('video_file')->store('home/videos', 'public');
            $homeSettings->video_url = null;
        } else {
            $homeSettings->video_url = $request->video_url;
        }

        // Handle Other Action Buttons
        $buttons = [];
        if ($request->button_labels) {
            foreach ($request->button_labels as $key => $label) {
                if (!empty($label)) {
                    $type = $request->button_types[$key] ?? 'btn';
                    $link = $request->button_links[$key] ?? '#';
                    $filePath = $request->button_existing_files[$key] ?? null;
                    
                    // Handle File Upload for this button (only if not core)
                    if ($type == 'btn' && $request->hasFile('button_files') && isset($request->file('button_files')[$key])) {
                        // Delete old file if exists
                        if ($filePath) {
                            Storage::disk('public')->delete($filePath);
                        }
                        $filePath = $request->file('button_files')[$key]->store('home/buttons', 'public');
                        $link = asset('storage/' . $filePath);
                    }

                    $buttons[] = [
                        'type' => $type,
                        'label' => $label,
                        'link' => $link,
                        'file_path' => $filePath,
                        'bg_color' => $request->button_bg_colors[$key] ?? '#34b7a7',
                        'text_color' => $request->button_text_colors[$key] ?? '#ffffff',
                        'outline' => in_array($key, $request->button_outlines ?? [])
                    ];
                }
            }
        }
        $homeSettings->buttons = $buttons;

        // Handle Styling Options
        $homeSettings->title_size = $request->title_size;
        $homeSettings->title_color = $request->title_color;
        $homeSettings->title_font = $request->title_font;
        $homeSettings->subtitle_size = $request->subtitle_size;
        $homeSettings->subtitle_color = $request->subtitle_color;
        $homeSettings->subtitle_font = $request->subtitle_font;

        $homeSettings->save();

        return response()->json([
            'success' => true,
            'message' => 'Home page settings updated successfully!'
        ]);
    }
}
