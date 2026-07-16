<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class PageController extends Controller
{
    public function about()
    {
        $content = Setting::get('about_content', '<p>We help tenants find trusted rooms and property owners connect with genuine renters. Our goal is to make renting simple, transparent and accessible.</p><p>Browse verified listings, compare options and connect with owners from one convenient platform.</p>');
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
        $content = Setting::get('how_it_works_content', '<h2>Find a room</h2><p>Search by city, budget, room type, furnishing and preferred tenant.</p><h2>Review the details</h2><p>Compare rent, amenities, photos, location and owner information.</p><h2>Connect securely</h2><p>Contact the owner and finalize your stay after verifying the property details.</p><h2>List a property</h2><p>Owners can create a listing, add photos and details, and manage enquiries from their dashboard.</p>');
        $title = 'How It Works';

        return view('pages.show', compact('content', 'title'));
    }

    public function safetyTips()
    {
        $content = Setting::get('safety_tips_content', '<h2>Visit before paying</h2><p>Inspect the property and confirm its condition before making a payment.</p><h2>Verify the owner</h2><p>Check the identity and ownership or authorization documents of the person listing the property.</p><h2>Use written agreements</h2><p>Record rent, deposit, notice period and included facilities in a signed rental agreement.</p><h2>Protect personal information</h2><p>Do not share OTPs, passwords or unnecessary financial information with anyone.</p>');
        $title = 'Safety Tips';

        return view('pages.show', compact('content', 'title'));
    }

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
