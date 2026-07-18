<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class PageController extends Controller
{
    public function about()
    {
        $content = Setting::get('about_content', config('cms.defaults.about_content'));
        $title = 'About Us';

        return view('pages.show', compact('content', 'title'));
    }

    public function careers()
    {
        $content = Setting::get('careers_content', '<p>Join us in building a simpler and more trustworthy rental experience.</p><p>For current opportunities, send your profile to our contact email with the role you are interested in.</p>');
        $title = 'Careers';

        return view('pages.show', compact('content', 'title'));
    }

    public function howItWorks()
    {
        $content = Setting::get('how_it_works_content', config('cms.defaults.how_it_works_content'));
        $title = 'How It Works';

        return view('pages.how-it-works', compact('content', 'title'));
    }

    public function safetyTips()
    {
        $content = Setting::get('safety_tips_content', config('cms.defaults.safety_tips_content'));
        $title = 'Safety Tips';

        return view('pages.show', compact('content', 'title'));
    }

    public function ownerGuidelines()
    {
        $content = Setting::get('owner_guidelines_content', config('cms.defaults.owner_guidelines_content'));
        $title = 'Owner Guidelines';
        return view('pages.show', compact('content', 'title'));
    }

    public function userGuidelines()
    {
        $content = Setting::get('user_guidelines_content', config('cms.defaults.user_guidelines_content'));
        $title = 'User Guidelines';
        return view('pages.show', compact('content', 'title'));
    }

    public function terms()
    {
        $content = Setting::get('terms_content', config('cms.defaults.terms_content'));
        $title = 'Terms & Conditions';
        return view('pages.show', compact('content', 'title'));
    }

    public function privacy()
    {
        $content = Setting::get('privacy_content', config('cms.defaults.privacy_content'));
        $title = 'Privacy Policy';
        return view('pages.show', compact('content', 'title'));
    }

    public function condition()
    {
        $content = Setting::get('condition_content', 'Condition Policy content not set.');
        $title = 'Condition Policy';
        return view('pages.show', compact('content', 'title'));
    }

    public function contact()
    {
        $content = Setting::get('contact_content', 'Contact information not set.');
        $title = 'Contact Us';
        return view('pages.contact', compact('content', 'title')); // Special view for contact if form needed
    }

    public function faq()
    {
        $json = Setting::get('faq_content', '[]');
        // Ensure it's valid JSON, if not (legacy text), might break. 
        // Logic: Try decode. If array, good. If string, maybe legacy text?
        // But since we just switched system, assuming JSON.
        $faqs = json_decode($json, true);
        if (!is_array($faqs)) {
            // Fallback if legacy text was stored
            $faqs = []; 
        }
        
        $title = 'Frequently Asked Questions';
        return view('pages.faq', compact('faqs', 'title'));
    }
}
