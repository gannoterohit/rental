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

    public function terms()
    {
        return $this->showEditor('terms_content', 'Terms & Conditions', 'admin.pages.terms.update');
    }

    public function updateTerms(Request $request)
    {
        return $this->saveEditor($request, 'terms_content', 'Terms & Conditions');
    }

    public function condition()
    {
        return $this->showEditor('condition_content', 'Condition Policy', 'admin.pages.condition.update');
    }

    public function updateCondition(Request $request)
    {
        return $this->saveEditor($request, 'condition_content', 'Condition Policy');
    }

    public function privacy()
    {
        return $this->showEditor('privacy_content', 'Privacy Policy', 'admin.pages.privacy.update');
    }

    public function updatePrivacy(Request $request)
    {
        return $this->saveEditor($request, 'privacy_content', 'Privacy Policy');
    }

    public function contact()
    {
        return $this->showEditor('contact_content', 'Contact Us', 'admin.pages.contact.update');
    }

    public function updateContact(Request $request)
    {
        return $this->saveEditor($request, 'contact_content', 'Contact Us');
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
