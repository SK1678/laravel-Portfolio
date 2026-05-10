<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the global settings page.
     */
    public function index()
    {
        $siteSettings = SiteSetting::firstOrCreate(['id' => 1]);
        return view('admin.settings.global', compact('siteSettings'));
    }

    /**
     * Save General Settings (tab 1).
     */
    public function saveGeneral(Request $request)
    {
        $request->validate([
            'site_title'        => 'required|string|max:255',
            'logo_type'         => 'required|in:text,image',
            'logo_text'         => 'nullable|string|max:100',
            'time_zone'         => 'required|string',
            'default_font'      => 'nullable|string|max:100',
            'heading_font'      => 'nullable|string|max:100',
            'body_bg'           => 'nullable|string|max:7',
            'primary_color'     => 'nullable|string|max:7',
            'heading_color'     => 'nullable|string|max:7',
            'accent_color'      => 'nullable|string|max:7',
            'surface_color'     => 'nullable|string|max:7',
            'contrast_color'    => 'nullable|string|max:7',
            'nav_primary'       => 'nullable|string|max:7',
            'nav_hover'         => 'nullable|string|max:7',
            'nav_mobile_bg'     => 'nullable|string|max:7',
            'nav_dd_bg'         => 'nullable|string|max:7',
            'nav_dd_link'       => 'nullable|string|max:7',
            'nav_dd_hover'      => 'nullable|string|max:7',
            'dark_body_bg'      => 'nullable|string|max:7',
            'dark_primary_color'=> 'nullable|string|max:7',
            'dark_heading_color'=> 'nullable|string|max:7',
            'dark_accent_color' => 'nullable|string|max:7',
            'dark_surface_color'=> 'nullable|string|max:7',
            'dark_contrast_color'=>'nullable|string|max:7',
            'contact_mail'      => 'nullable|email|max:255',
            'contact_no'        => 'nullable|string|max:50',
            'address'           => 'nullable|string|max:500',
            'map_link'          => 'nullable|string',
        ]);

        $data = $request->except(['_token', 'favicon', 'logo_image', 'remove_logo', 'remove_favicon', 'logo_image_path', 'favicon_path']);
        $data['is_dark_mode'] = $request->boolean('is_dark_mode');

        // Handle logo removal
        if ($request->remove_logo == '1') {
            $data['logo_image'] = null;
        }

        // Handle favicon removal
        if ($request->remove_favicon == '1') {
            $data['favicon'] = null;
        }

        // Handle favicon path from media library
        if ($request->filled('favicon_path')) {
            $data['favicon'] = $request->favicon_path;
        }

        // Handle favicon upload (overrides selected path if file is provided)
        if ($request->hasFile('favicon')) {
            $request->validate(['favicon' => 'image|mimes:png,jpg,ico|max:512']);
            $path = $request->file('favicon')->store('settings', 'public');
            $data['favicon'] = $path;
        }

        // Handle logo image path from media library
        if ($request->filled('logo_image_path')) {
            $data['logo_image'] = $request->logo_image_path;
        }

        // Handle logo image upload (overrides selected path if file is provided)
        if ($request->hasFile('logo_image')) {
            $request->validate(['logo_image' => 'image|mimes:png,jpg,svg|max:1024']);
            $path = $request->file('logo_image')->store('settings', 'public');
            $data['logo_image'] = $path;
        }

        SiteSetting::updateOrCreate(['id' => 1], $data);

        return response()->json(['success' => true, 'message' => 'General settings saved successfully.']);
    }

    /**
     * Save SEO Settings (tab 2).
     */
    public function saveSeo(Request $request)
    {
        $request->validate([
            'meta_description'   => 'nullable|string',
            'meta_keywords'      => 'nullable|string|max:500',
            'google_analytics_id'=> 'nullable|string|max:50',
        ]);

        $data = [
            'meta_description'    => $request->meta_description,
            'meta_keywords'       => $request->meta_keywords,
            'google_analytics_id' => $request->google_analytics_id,
            'allow_indexing'      => $request->boolean('allow_indexing'),
        ];

        SiteSetting::updateOrCreate(['id' => 1], $data);

        return response()->json(['success' => true, 'message' => 'SEO settings saved successfully.']);
    }

    /**
     * Save Email Server Settings (tab 3).
     */
    public function saveEmail(Request $request)
    {
        $request->validate([
            'smtp_host'       => 'nullable|string|max:255',
            'smtp_port'       => 'nullable|numeric',
            'encryption_type' => 'nullable|in:tls,ssl,none',
            'smtp_username'   => 'nullable|string|max:255',
            'smtp_password'   => 'nullable|string|max:255',
            'sender_name'     => 'nullable|string|max:255',
        ]);

        SiteSetting::updateOrCreate(['id' => 1], $request->only([
            'smtp_host', 'smtp_port', 'encryption_type',
            'smtp_username', 'smtp_password', 'sender_name',
        ]));

        return response()->json(['success' => true, 'message' => 'Email settings saved successfully.']);
    }

    /**
     * Test SMTP connectivity.
     */
    public function testSmtp(Request $request)
    {
        $settings = SiteSetting::first();

        if (!$settings || !$settings->smtp_host) {
            return response()->json([
                'success' => false,
                'message' => 'SMTP not configured. Please save email settings first.',
            ]);
        }

        try {
            // Dynamically configure mail from saved settings
            config([
                'mail.mailers.smtp.host'       => $settings->smtp_host,
                'mail.mailers.smtp.port'       => $settings->smtp_port,
                'mail.mailers.smtp.encryption' => $settings->encryption_type === 'none' ? null : $settings->encryption_type,
                'mail.mailers.smtp.username'   => $settings->smtp_username,
                'mail.mailers.smtp.password'   => $settings->smtp_password,
                'mail.from.name'               => $settings->sender_name,
            ]);

            // Attempt socket connection as a lightweight test
            $socket = @fsockopen($settings->smtp_host, $settings->smtp_port, $errno, $errstr, 5);
            if ($socket) {
                fclose($socket);
                return response()->json(['success' => true, 'message' => 'SMTP server is reachable.']);
            }

            return response()->json(['success' => false, 'message' => "Could not connect: $errstr ($errno)"]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
