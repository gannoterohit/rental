<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        $path = $request->file('upload')->store('page-content', 'public');

        return response()->json(['url' => asset('storage/' . $path)]);
    }

    public function about()
    {
        return $this->showEditor('about_content', 'About Us', 'admin.pages.about.update');
    }

    public function updateAbout(Request $request)
    {
        return $this->saveEditor($request, 'about_content', 'About Us');
    }

    public function careers()
    {
        return $this->showEditor('careers_content', 'Careers', 'admin.pages.careers.update');
    }

    public function updateCareers(Request $request)
    {
        return $this->saveEditor($request, 'careers_content', 'Careers');
    }

    public function howItWorks()
    {
        return $this->showEditor('how_it_works_content', 'How It Works', 'admin.pages.how-it-works.update');
    }

    public function updateHowItWorks(Request $request)
    {
        return $this->saveEditor($request, 'how_it_works_content', 'How It Works');
    }

    public function safetyTips()
    {
        return $this->showEditor('safety_tips_content', 'Safety Tips', 'admin.pages.safety-tips.update');
    }

    public function updateSafetyTips(Request $request)
    {
        return $this->saveEditor($request, 'safety_tips_content', 'Safety Tips');
    }

    public function ownerGuidelines()
    {
        return $this->showEditor('owner_guidelines_content', 'Owner Guidelines', 'admin.pages.owner-guidelines.update');
    }

    public function updateOwnerGuidelines(Request $request)
    {
        return $this->saveEditor($request, 'owner_guidelines_content', 'Owner Guidelines');
    }

    public function userGuidelines()
    {
        return $this->showEditor('user_guidelines_content', 'User Guidelines', 'admin.pages.user-guidelines.update');
    }

    public function updateUserGuidelines(Request $request)
    {
        return $this->saveEditor($request, 'user_guidelines_content', 'User Guidelines');
    }

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

    private function showEditor(string $key, string $pageTitle, string $routeName)
    {
        $setting = Setting::where('key', $key)->first();
        if (!$setting) {
            $setting = new Setting(['key' => $key, 'value' => config("cms.defaults.{$key}", '')]);
        }
        $route = route($routeName);

        return view('admin.pages.editor', compact('setting', 'pageTitle', 'route'));
    }

    private function saveEditor(Request $request, string $key, string $pageTitle)
    {
        $request->validate(['content' => 'nullable|string']);
        $this->updatePageContent($key, $request->input('content', ''));

        return back()->with('success', $pageTitle . ' page updated successfully!');
    }
}
