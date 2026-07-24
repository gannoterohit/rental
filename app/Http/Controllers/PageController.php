<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CmsPage;
use App\Models\Setting;

class PageController extends Controller
{
    public function about()
    {
        return $this->render('about-us', 'About Us', 'about_content');
    }

    public function careers()
    {
        return $this->render('careers', 'Careers', 'careers_content');
    }

    public function howItWorks()
    {
        return $this->render('how-it-works', 'How It Works', 'how_it_works_content', 'pages.how-it-works');
    }

    public function safetyTips()
    {
        return $this->render('safety-tips', 'Safety Tips', 'safety_tips_content');
    }

    public function ownerGuidelines()
    {
        return $this->render('owner-guidelines', 'Owner Guidelines', 'owner_guidelines_content');
    }

    public function userGuidelines()
    {
        return $this->render('user-guidelines', 'User Guidelines', 'user_guidelines_content');
    }

    public function terms()
    {
        return $this->render('terms-and-conditions', 'Terms & Conditions', 'terms_content');
    }

    public function privacy()
    {
        return $this->render('privacy-policy', 'Privacy Policy', 'privacy_content');
    }

    public function condition()
    {
        return $this->render('condition-policy', 'Refund & Cancellation Policy', 'condition_content');
    }

    public function contact()
    {
        return $this->render('contact-us', 'Contact Us', 'contact_content', 'pages.contact');
    }

    public function faq()
    {
        $page = $this->page('faq');
        $json = $page?->content ?: Setting::get('faq_content', '[]');
        // Ensure it's valid JSON, if not (legacy text), might break. 
        // Logic: Try decode. If array, good. If string, maybe legacy text?
        // But since we just switched system, assuming JSON.
        $faqs = json_decode($json, true);
        if (!is_array($faqs)) {
            // Fallback if legacy text was stored
            $faqs = []; 
        }
        
        $title = $page?->title ?: 'Frequently Asked Questions';
        return view('pages.faq', compact('faqs', 'title'));
    }

    public function show(string $slug)
    {
        $page = CmsPage::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return $this->renderPage($page);
    }

    private function render(string $slug, string $fallbackTitle, string $settingKey, string $view = 'pages.show')
    {
        $page = $this->page($slug);
        if ($page) {
            return $this->renderPage($page, $view);
        }

        $content = Setting::get($settingKey, config("cms.defaults.{$settingKey}", ''));
        $title = $fallbackTitle;
        return view($view, compact('content', 'title'));
    }

    private function renderPage(CmsPage $page, ?string $forcedView = null)
    {
        if (!$page->isPublished()) abort(404);

        $content = $page->content;
        $title = $page->seo_title ?: $page->title;
        if (($forcedView ?: $page->template) === 'contact' || $page->template === 'contact') {
            return view('pages.contact', compact('content', 'title'));
        }
        if (($forcedView ?: $page->template) === 'faq' || $page->template === 'faq') {
            $faqs = json_decode((string) $page->content, true);
            if (!is_array($faqs)) $faqs = [];
            return view('pages.faq', compact('faqs', 'title'));
        }
        $view = $forcedView ?: 'pages.show';
        return view($view, compact('content', 'title'));
    }

    private function page(string $slug): ?CmsPage
    {
        return CmsPage::where('slug', $slug)->first();
    }
}
