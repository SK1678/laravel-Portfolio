<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceSetting;
use Illuminate\Http\Request;

class ServiceSettingsController extends Controller
{
    public function index()
    {
        $serviceSetting = ServiceSetting::first();
        $services = Service::orderBy('order')->get();
        return view('admin.pages.service_settings', compact('serviceSetting', 'services'));
    }

    public function save(Request $request)
    {
        // Save Section Headers
        ServiceSetting::updateOrCreate(
            ['id' => 1],
            [
                'title' => $request->title,
                'subtitle' => $request->subtitle
            ]
        );

        // Sync Services
        $existingIds = [];
        if ($request->services) {
            foreach ($request->services as $index => $s) {
                $service = Service::updateOrCreate(
                    ['id' => $s['id'] ?? null],
                    [
                        'title' => $s['title'],
                        'icon' => $s['icon'],
                        'description' => $s['description'],
                        'order' => $index
                    ]
                );
                $existingIds[] = $service->id;
            }
        }

        // Delete removed services
        Service::whereNotIn('id', $existingIds)->delete();

        return response()->json(['success' => true, 'message' => 'Service settings saved successfully']);
    }
}
