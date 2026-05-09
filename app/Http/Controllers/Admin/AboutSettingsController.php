<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AboutPage;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AboutSettingsController extends Controller
{
    public function index()
    {
        $about = AboutPage::first();
        if (!$about) {
            $about = AboutPage::create([
                'career_objective' => '',
                'details' => []
            ]);
        }
        $siteOwner = User::where('is_site_owner', 1)->first();
        return view('admin.pages.about_settings', compact('about', 'siteOwner'));
    }

    public function save(Request $request)
    {
        $about = AboutPage::first();
        
        // Handle Image
        $imagePath = $about->image_path;
        if ($request->hasFile('about_image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('about_image')->store('about', 'public');
        }

        // Handle Details JSON
        $details = [];
        if ($request->labels) {
            foreach ($request->labels as $key => $label) {
                if (!empty($label)) {
                    $details[] = [
                        'label' => $label,
                        'value' => $request->values[$key] ?? '',
                        'type' => $request->types[$key] ?? 'text'
                    ];
                }
            }
        }

        $about->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'objective_title' => $request->objective_title,
            'image_path' => $imagePath,
            'career_objective' => $request->career_objective,
            'details' => $details
        ]);

        return response()->json(['success' => true, 'message' => 'About settings saved successfully!']);
    }
}
