<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Award;
use App\Models\AwardSetting;

class AwardSettingsController extends Controller
{
    public function index()
    {
        $settings = AwardSetting::first();
        if (!$settings) {
            $settings = AwardSetting::create([
                'title' => 'Awards & Certifications',
                'subtitle' => 'Recognitions and certifications earned throughout my professional journey'
            ]);
        }
        $awards = Award::orderBy('order')->get();
        return view('admin.pages.award_settings', compact('settings', 'awards'));
    }

    public function save(Request $request)
    {
        // Save Headers
        AwardSetting::updateOrCreate([], [
            'title' => $request->title,
            'subtitle' => $request->subtitle
        ]);

        // Save Awards (Sync by truncating and recreating to maintain order)
        Award::truncate();
        if ($request->titles) {
            foreach ($request->titles as $key => $title) {
                if (!empty($title)) {
                    // Extract proofs for this specific award
                    // We'll expect a JSON string for proofs or handle complex nesting
                    $proofData = [];
                    if ($request->proofs && isset($request->proofs[$key])) {
                        $proofData = is_array($request->proofs[$key]) ? $request->proofs[$key] : json_decode($request->proofs[$key], true);
                    }

                    Award::create([
                        'year' => $request->years[$key] ?? '',
                        'title' => $title,
                        'organization' => $request->organizations[$key] ?? '',
                        'description' => $request->descriptions[$key] ?? '',
                        'proofs' => $proofData,
                        'order' => $key
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Award settings saved successfully!']);
    }
}
