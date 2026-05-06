<?php

namespace App\Http\Controllers;

use App\Models\AboutSetting;
use App\Models\CustomerMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class AboutSettingController extends Controller
{
    public function index()
    {
        $settings = AboutSetting::settings();
        return view('super-admin.about-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'who_we_are' => 'nullable|string',
            'our_vision' => 'nullable|string',
            'our_mission' => 'nullable|string',
            'what_we_believe' => 'nullable|string',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_whatsapp' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string',
            'working_hours' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
        ]);

        $settings = AboutSetting::settings();

        $settings->update([
            'who_we_are' => $request->who_we_are,
            'our_vision' => $request->our_vision,
            'our_mission' => $request->our_mission,
            'what_we_believe' => $request->what_we_believe,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_whatsapp' => $request->contact_whatsapp,
            'contact_address' => $request->contact_address,
            'working_hours' => $request->working_hours,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'linkedin_url' => $request->linkedin_url,
            'instagram_url' => $request->instagram_url,
        ]);

        return redirect()->route('super-admin.about-settings.index')
            ->with('success', 'About Us settings updated successfully!');
    }

    public function show()
    {
        $settings = AboutSetting::settings();
        return view('about', compact('settings'));
    }

    public function contact()
    {
        $settings = AboutSetting::settings();

        // generate a simple captcha code and store in session
        $captcha = Str::upper(Str::random(5));
        Session::put('contact_captcha', $captcha);

        return view('contact', compact('settings'));
    }

    /**
     * Handle contact form submission and validate captcha
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'first' => 'nullable|string|max:100',
            'last' => 'nullable|string|max:100',
            'mobile' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'message' => 'nullable|string',
            'captcha' => 'required|string',
        ]);

        $sessionCaptcha = Session::get('contact_captcha');
        if (! $sessionCaptcha || strtoupper($request->captcha) !== strtoupper($sessionCaptcha)) {
            return back()->withInput()->withErrors(['captcha' => 'Captcha does not match. Please try again.']);
        }

        // persist the contact message
        CustomerMessage::create([
            'first_name' => $request->input('first'),
            'last_name' => $request->input('last'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Clear captcha after successful validation
        Session::forget('contact_captcha');

        return redirect()->route('contact')->with('success', 'Your message has been submitted. Thank you!');
    }
}
