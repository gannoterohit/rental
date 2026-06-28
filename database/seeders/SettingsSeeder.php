<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Business Fees
            [
                'key' => 'listing_fee',
                'value' => '199',
                'type' => 'number',
                'group' => 'business',
                'description' => 'One-time fee to list a room'
            ],
            [
                'key' => 'featured_fee',
                'value' => '99',
                'type' => 'number',
                'group' => 'business',
                'description' => 'Fee to feature room at top'
            ],
            [
                'key' => 'unlock_fee',
                'value' => '49',
                'type' => 'number',
                'group' => 'business',
                'description' => 'Fee to unlock owner contact details'
            ],

            // Commission Settings
            [
                'key' => 'commission_percent',
                'value' => '10',
                'type' => 'number',
                'group' => 'business',
                'description' => 'Admin commission percentage on bookings'
            ],
            [
                'key' => 'service_charge',
                'value' => '200',
                'type' => 'number',
                'group' => 'business',
                'description' => 'Fixed service charge per booking'
            ],

            // Website Appearance
            [
                'key' => 'website_name',
                'value' => 'RoomRental',
                'type' => 'text',
                'group' => 'appearance',
                'description' => 'Website display name'
            ],
            [
                'key' => 'website_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'appearance',
                'description' => 'Website logo image'
            ],
            [
                'key' => 'contact_email',
                'value' => 'support@roomrental.com',
                'type' => 'text',
                'group' => 'appearance',
                'description' => 'Contact/support email'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+91 1234567890',
                'type' => 'text',
                'group' => 'appearance',
                'description' => 'Contact/support phone'
            ],

            // Payment Gateway
            [
                'key' => 'razorpay_key',
                'value' => '',
                'type' => 'text',
                'group' => 'payment',
                'description' => 'Razorpay API Key ID'
            ],
            [
                'key' => 'razorpay_secret',
                'value' => '',
                'type' => 'text',
                'group' => 'payment',
                'description' => 'Razorpay API Secret'
            ],
            [
                'key' => 'razorpay_webhook_secret',
                'value' => '',
                'type' => 'text',
                'group' => 'payment',
                'description' => 'Razorpay Webhook Secret (from Razorpay Dashboard → Webhooks)'
            ],

            // Google Maps
            [
                'key' => 'google_maps_api_key',
                'value' => '',
                'type' => 'text',
                'group' => 'maps',
                'description' => 'Google Maps API Key for location services'
            ],

            // SEO & Analytics
            [
                'key' => 'google_search_console_code',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Google Search Console verification code'
            ],
            [
                'key' => 'seo_meta_description',
                'value' => 'Find your perfect room in your city. Browse verified room listings, connect with owners, and find the best rental deals.',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Default meta description for SEO (150-160 characters)'
            ],
            [
                'key' => 'seo_meta_keywords',
                'value' => 'room rental, apartment, house, property, rent, room finder, room listing',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Default meta keywords for SEO (comma-separated)'
            ],
            [
                'key' => 'website_url',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Website canonical URL (e.g., https://yourwebsite.com)'
            ],

            // Google Ads Settings
            [
                'key' => 'google_ads_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'seo',
                'description' => 'Enable Google Ads tracking (only works on production)'
            ],
            [
                'key' => 'google_ads_tag_id',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Google Ads Tag ID (AW-XXXXXXXXX)'
            ],
            [
                'key' => 'google_ads_conversion_label',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Google Ads Payment Conversion Label'
            ],
            [
                'key' => 'google_ads_signup_label',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Google Ads Signup Conversion Label'
            ],
            [
                'key' => 'google_ads_room_view_label',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Google Ads Room View Conversion Label'
            ],
            [
                'key' => 'ga4_measurement_id',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Google Analytics 4 Measurement ID (G-XXXXXXXXXX)'
            ],
            [
                'key' => 'adsense_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'seo',
                'description' => 'Enable Google AdSense'
            ],
            [
                'key' => 'adsense_client_id',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Google AdSense Client ID (ca-pub-XXXXXXXXXXXXXXXX)'
            ],
            // Legal & Static Pages
            [
                'key' => 'terms_content',
                'value' => '<h2>1. Acceptance of Terms</h2><p>By accessing RoomRental, you agree to follow these terms...</p>',
                'type' => 'textarea',
                'group' => 'pages',
                'description' => 'Terms & Conditions Page Content'
            ],
            [
                'key' => 'privacy_content',
                'value' => '<h2>1. Data Collection</h2><p>We collect your email and location to provide better services...</p>',
                'type' => 'textarea',
                'group' => 'pages',
                'description' => 'Privacy Policy Page Content'
            ],
            [
                'key' => 'contact_content',
                'value' => 'Feel free to contact us for any queries or support.',
                'type' => 'textarea',
                'group' => 'pages',
                'description' => 'Contact Page Intro Content'
            ],
            [
                'key' => 'faq_content',
                'value' => '[{"question":"Is RoomRental free?","answer":"Listing is free for basic users, but featured listings have a small fee."}]',
                'type' => 'textarea',
                'group' => 'pages',
                'description' => 'FAQ JSON Content'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

