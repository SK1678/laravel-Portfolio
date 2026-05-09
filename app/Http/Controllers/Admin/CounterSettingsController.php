<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Counter;
use App\Models\CounterSetting;

class CounterSettingsController extends Controller
{
    public function index()
    {
        $settings = CounterSetting::first();
        if (!$settings) {
            $settings = CounterSetting::create([
                'title' => 'Facts',
                'subtitle' => 'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit'
            ]);
        }
        $counters = Counter::orderBy('order')->get();
        return view('admin.pages.counter_settings', compact('settings', 'counters'));
    }

    public function save(Request $request)
    {
        // Save Headers
        CounterSetting::updateOrCreate([], [
            'title' => $request->title,
            'subtitle' => $request->subtitle
        ]);

        // Save Counters (Sync by truncating and recreating to maintain order)
        Counter::truncate();
        if ($request->names) {
            foreach ($request->names as $key => $name) {
                if (!empty($name)) {
                    Counter::create([
                        'name' => $name,
                        'value' => $request->values[$key] ?? '0',
                        'order' => $key
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Counter settings saved successfully!']);
    }
}
