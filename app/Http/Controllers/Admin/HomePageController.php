<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        return view('admin.home-page', ['sections' => $this->sections()]);
    }

    public function update(Request $request)
    {
        $allowed = collect($this->sections())->flatMap(fn ($fields) => array_keys($fields))->all();
        $rules = collect($allowed)->mapWithKeys(fn ($key) => [
            $key => str_ends_with($key, '_url')
                ? ['nullable', 'url', 'max:1000']
                : ['nullable', 'string', 'max:2000'],
        ])->all();
        $data = $request->validate($rules);

        foreach ($allowed as $key) {
            Setting::set($key, $data[$key] ?? '');
        }

        return back()->with('success', 'Home page content updated successfully.');
    }

    private function sections(): array
    {
        return [
            'Hero Section' => [
                'home_hero_eyebrow' => ['label' => 'Trust line', 'default' => 'Verified Rooms · No Brokerage · Direct Owner Contact'],
                'home_hero_title' => ['label' => 'Main heading', 'default' => 'Find Verified Rooms'],
                'home_hero_highlight' => ['label' => 'Highlighted heading', 'default' => 'Your City'],
                'home_hero_description' => ['label' => 'Description', 'default' => 'Verified rooms, PGs and apartments. No brokerage. Connect directly with owners.', 'textarea' => true],
                'home_search_button' => ['label' => 'Search button', 'default' => 'Search Rooms'],
            ],
            'Section Headings' => [
                'home_why_title' => ['label' => 'Why us heading', 'default' => 'Why Choose ApnaNest?'],
                'home_why_description' => ['label' => 'Why us description', 'default' => 'A safe, secure and hassle-free renting experience.'],
                'home_category_eyebrow' => ['label' => 'Category small label', 'default' => 'Property Types'],
                'home_category_title' => ['label' => 'Category heading', 'default' => 'Browse by Category'],
                'home_category_description' => ['label' => 'Category description', 'default' => 'Explore rental options available near you.'],
                'home_latest_title' => ['label' => 'Latest rooms heading', 'default' => 'Latest Verified Rooms'],
                'home_latest_description' => ['label' => 'Latest rooms description', 'default' => 'Handpicked verified listings just for you.'],
                'home_steps_title' => ['label' => 'How it works heading', 'default' => 'How It Works?'],
                'home_steps_description' => ['label' => 'How it works description', 'default' => 'Three simple steps to find your next home.'],
                'home_testimonials_title' => ['label' => 'Testimonials heading', 'default' => 'What Our Users Say'],
                'home_testimonials_description' => ['label' => 'Testimonials description', 'default' => 'Experiences shared by tenants using our platform.'],
                'home_blog_title' => ['label' => 'Blog heading', 'default' => 'Latest from Blog'],
                'home_blog_description' => ['label' => 'Blog description', 'default' => 'Tips, guides and rental insights.'],
                'home_faq_title' => ['label' => 'FAQ heading', 'default' => 'Frequently Asked Questions'],
                'home_faq_description' => ['label' => 'FAQ description', 'default' => 'Quick answers to common questions.'],
            ],
            'Why Choose Us Cards' => $this->cardFields('why', [
                ['Verified Listings', 'Listings reviewed for authenticity.', 'fa-circle-check'],
                ['Zero Brokerage', 'Connect directly with property owners.', 'fa-wallet'],
                ['Secure Payments', 'Protected payments through trusted gateways.', 'fa-shield-halved'],
                ['Customer Support', 'Support throughout your rental journey.', 'fa-headset'],
            ]),
            'How It Works' => $this->cardFields('step', [
                ['Search', 'Find rooms by city, budget and preference.', 'fa-search'],
                ['Connect', 'Review details and connect with the owner.', 'fa-comments'],
                ['Move In', 'Verify the property, complete documentation and move in.', 'fa-key'],
            ]),
            'Trust Ribbon' => $this->cardFields('trust', [
                ['Available Today', 'Move in hassle free', 'fa-calendar-check'],
                ['Quick Enquiries', 'Connect without delays', 'fa-bolt'],
                ['Easy Documentation', 'A simpler rental process', 'fa-file-signature'],
                ['Verified Listings', 'Trusted property information', 'fa-shield-halved'],
            ]),
            'Testimonials' => $this->testimonialFields(),
            'Owner Call To Action' => [
                'home_owner_title' => ['label' => 'Heading', 'default' => 'Own a Property?'],
                'home_owner_description' => ['label' => 'Description', 'default' => 'List your property and connect with genuine tenants.', 'textarea' => true],
                'home_owner_button' => ['label' => 'Button text', 'default' => 'List Your Property'],
            ],
            'App & Newsletter' => [
                'home_app_title' => ['label' => 'App heading', 'default' => 'Download Our App'],
                'home_app_description' => ['label' => 'App description', 'default' => 'Find stays on the go with our mobile app.'],
                'home_android_url' => ['label' => 'Google Play URL', 'default' => ''],
                'home_ios_url' => ['label' => 'App Store URL', 'default' => ''],
                'home_newsletter_title' => ['label' => 'Newsletter heading', 'default' => 'Stay Updated'],
                'home_newsletter_description' => ['label' => 'Newsletter description', 'default' => 'Get updates on new rooms and offers.'],
            ],
        ];
    }

    private function cardFields(string $prefix, array $cards): array
    {
        $fields = [];
        foreach ($cards as $index => [$title, $description, $icon]) {
            $number = $index + 1;
            $fields["home_{$prefix}_{$number}_title"] = ['label' => "Card {$number} title", 'default' => $title];
            $fields["home_{$prefix}_{$number}_description"] = ['label' => "Card {$number} description", 'default' => $description, 'textarea' => true];
            $fields["home_{$prefix}_{$number}_icon"] = ['label' => "Card {$number} icon class", 'default' => $icon];
        }
        return $fields;
    }

    private function testimonialFields(): array
    {
        $fields = [];
        foreach ([1, 2] as $number) {
            $fields["home_testimonial_{$number}_name"] = ['label' => "Testimonial {$number} name", 'default' => $number === 1 ? 'Rahul Sharma' : 'Neha Verma'];
            $fields["home_testimonial_{$number}_role"] = ['label' => "Testimonial {$number} role", 'default' => $number === 1 ? 'Student' : 'Working Professional'];
            $fields["home_testimonial_{$number}_text"] = ['label' => "Testimonial {$number} review", 'default' => 'A simple and reliable room-finding experience.', 'textarea' => true];
        }
        return $fields;
    }
}
