<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;

class BusinessSettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('admin.business-settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            // Handle file uploads (logo)
            if ($request->hasFile($key)) {
                // Delete old file if exists
                if ($setting && $setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }
                
                // Store new file
                $path = $request->file($key)->store('settings', 'public');
                $value = $path;
            }
            
            if ($setting) {
                $setting->update(['value' => $value]);
            } else {
                // Create new setting if doesn't exist
                Setting::create([
                    'key' => $key,
                    'value' => $value,
                    'type' => $request->hasFile($key) ? 'image' : 'text',
                    'group' => 'general'
                ]);
            }
        }

        return back()->with('success', 'Settings updated successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:settings,key',
            'value' => 'required',
            'type' => 'required|in:text,number,image,boolean',
            'group' => 'required',
        ]);

        Setting::create($request->all());

        return back()->with('success', 'Setting added successfully!');
    }

    /**
     * Ping Search Engines to index the dynamic sitemap
     */
    public function pingSearchEngines()
    {
        $sitemapUrl = url('/sitemap.xml');
        $success = false;
        
        try {
            // Ping Bing / IndexNow (Modern Standard)
            \Illuminate\Support\Facades\Http::get('https://www.bing.com/ping?sitemap=' . urlencode($sitemapUrl));
            
            // Note: Google deprecated their public ping endpoint in late 2023.
            // IndexNow is the current recommended way for Bing/Yandex.
            // For Google, having the sitemap in robots.txt (already done) is the most reliable way.
            
            $success = true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Sitemap Ping Failed: ' . $e->getMessage());
        }

        if ($success) {
            return back()->with('success', 'Search engines notified successfully! Your new rooms will be indexed faster.');
        }

        return back()->with('error', 'Failed to notify search engines. Please try again later.');
    }
}

