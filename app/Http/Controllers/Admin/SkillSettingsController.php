<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\SkillSetting;

class SkillSettingsController extends Controller
{
    public function index()
    {
        $settings = SkillSetting::first();
        if (!$settings) {
            $settings = SkillSetting::create([
                'title' => 'Skills',
                'subtitle' => 'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit'
            ]);
        }
        $skills = Skill::orderBy('order')->get();
        return view('admin.pages.skills_settings', compact('settings', 'skills'));
    }

    public function save(Request $request)
    {
        // Save Headers
        SkillSetting::updateOrCreate([], [
            'title' => $request->title,
            'subtitle' => $request->subtitle
        ]);

        // Save Skills (Sync by truncating and recreating to maintain order)
        Skill::truncate();
        if ($request->names) {
            foreach ($request->names as $key => $name) {
                if (!empty($name)) {
                    Skill::create([
                        'name' => $name,
                        'percent' => $request->percents[$key] ?? 100,
                        'order' => $key
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Skills settings saved successfully!']);
    }
}
