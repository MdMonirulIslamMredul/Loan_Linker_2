<?php

namespace App\Http\Controllers;

use App\Models\LogoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoSettingController extends Controller
{
    public function index()
    {
        $settings = LogoSetting::settings();
        return view('super-admin.logo-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'header_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'footer_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg,svg,ico|max:1024',
        ]);

        $settings = LogoSetting::settings();

        // Update site name
        $settings->site_name = $request->site_name;

        // Handle header logo upload
        if ($request->hasFile('header_logo')) {
            // Delete old file if exists
            if ($settings->header_logo && Storage::disk('public')->exists($settings->header_logo)) {
                Storage::disk('public')->delete($settings->header_logo);
            }

            $headerLogoPath = $request->file('header_logo')->store('logos', 'public');
            $settings->header_logo = $headerLogoPath;
        }

        // Handle footer logo upload
        if ($request->hasFile('footer_logo')) {
            // Delete old file if exists
            if ($settings->footer_logo && Storage::disk('public')->exists($settings->footer_logo)) {
                Storage::disk('public')->delete($settings->footer_logo);
            }

            $footerLogoPath = $request->file('footer_logo')->store('logos', 'public');
            $settings->footer_logo = $footerLogoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old file if exists
            if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                Storage::disk('public')->delete($settings->favicon);
            }

            $faviconPath = $request->file('favicon')->store('logos', 'public');
            $settings->favicon = $faviconPath;
        }

        $settings->save();

        return redirect()->route('super-admin.logo-settings.index')
            ->with('success', 'Logo settings updated successfully!');
    }

    public function deleteLogo(Request $request, $type)
    {
        $settings = LogoSetting::settings();

        if (in_array($type, ['header_logo', 'footer_logo', 'favicon'])) {
            if ($settings->$type && Storage::disk('public')->exists($settings->$type)) {
                Storage::disk('public')->delete($settings->$type);
            }
            $settings->$type = null;
            $settings->save();

            return redirect()->route('super-admin.logo-settings.index')
                ->with('success', ucfirst(str_replace('_', ' ', $type)) . ' deleted successfully!');
        }

        return redirect()->route('super-admin.logo-settings.index')
            ->with('error', 'Invalid logo type!');
    }
}
