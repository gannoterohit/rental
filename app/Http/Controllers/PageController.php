<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class PageController extends Controller
{
    public function terms()
    {
        $content = Setting::get('terms_content', 'Terms and Conditions content not set.');
        $title = 'Terms & Conditions';
        return view('pages.show', compact('content', 'title'));
    }

    public function privacy()
    {
        $content = Setting::get('privacy_content', 'Privacy Policy content not set.');
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
