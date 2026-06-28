<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Show the form for editing the Terms page.
     */
    public function terms()
    {
        $setting = Setting::where('key', 'terms_content')->first();
        $pageTitle = 'Terms & Conditions';
        $route = route('admin.pages.terms.update');
        return view('admin.pages.editor', compact('setting', 'pageTitle', 'route'));
    }

    /**
     * Update the Terms page content.
     */
    public function updateTerms(Request $request)
    {
        $this->updatePageContent('terms_content', $request->input('content'));
        return back()->with('success', 'Terms page updated successfully!');
    }

    /**
     * Show the form for editing the Condition Policy page.
     */
    public function condition()
    {
        $setting = Setting::where('key', 'condition_content')->first();
        $pageTitle = 'Condition Policy';
        $route = route('admin.pages.condition.update');
        return view('admin.pages.editor', compact('setting', 'pageTitle', 'route'));
    }

    /**
     * Update the Condition Policy page content.
     */
    public function updateCondition(Request $request)
    {
        $this->updatePageContent('condition_content', $request->input('content'));
        return back()->with('success', 'Condition Policy page updated successfully!');
    }

    /**
     * Show the form for editing the Privacy Policy page.
     */
    public function privacy()
    {
        $setting = Setting::where('key', 'privacy_content')->first();
        $pageTitle = 'Privacy Policy';
        $route = route('admin.pages.privacy.update');
        return view('admin.pages.editor', compact('setting', 'pageTitle', 'route'));
    }

    /**
     * Update the Privacy Policy page content.
     */
    public function updatePrivacy(Request $request)
    {
        $this->updatePageContent('privacy_content', $request->input('content'));
        return back()->with('success', 'Privacy Policy page updated successfully!');
    }

    /**
     * Show the form for editing the Contact page.
     */
    public function contact()
    {
        $setting = Setting::where('key', 'contact_content')->first();
        $pageTitle = 'Contact Us';
        $route = route('admin.pages.contact.update');
        return view('admin.pages.editor', compact('setting', 'pageTitle', 'route'));
    }

    /**
     * Update the Contact page content.
     */
    public function updateContact(Request $request)
    {
        $this->updatePageContent('contact_content', $request->input('content'));
        return back()->with('success', 'Contact page updated successfully!');
    }

    /**
     * Show the form for editing the FAQ page.
     */
    /**
     * Show the form for editing the FAQ page.
     */
    public function faq()
    {
        $setting = Setting::where('key', 'faq_content')->first();
        $pageTitle = 'Frequently Asked Questions (FAQ)';
        $route = route('admin.pages.faq.update');
        return view('admin.pages.faq', compact('setting', 'pageTitle', 'route'));
    }

    /**
     * Update the FAQ page content.
     */
    public function updateFaq(Request $request)
    {
        $faqs = $request->input('faqs', []);
        // Filter out empty questions
        $faqs = array_filter($faqs, function($faq) {
            return !empty($faq['question']);
        });
        
        $json = json_encode(array_values($faqs));
        
        $this->updatePageContent('faq_content', $json);
        return back()->with('success', 'FAQ page updated successfully!');
    }

    /**
     * Helper function to update or create a page setting.
     */
    private function updatePageContent($key, $value)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            $setting->update(['value' => $value]);
        } else {
            Setting::create([
                'key' => $key,
                'value' => $value,
                'type' => 'textarea',
                'group' => 'pages'
            ]);
        }
    }
}   