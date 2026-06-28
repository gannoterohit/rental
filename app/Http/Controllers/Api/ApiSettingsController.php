<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Setting;
use Illuminate\Http\Request;

class ApiSettingsController extends BaseApiController
{
    /**
     * Get global app settings
     */
    public function index()
    {
        $settings = [
            'website_name' => Setting::get('website_name', 'RoomRental'),
            'website_logo' => asset('storage/' . Setting::get('website_logo', 'logo.png')),
            'contact_email' => Setting::get('contact_email', ''),
            'contact_phone' => Setting::get('contact_phone', ''),
            'currency_symbol' => '₹',
            'razorpay_key' => Setting::get('razorpay_key', ''),
            'social_links' => [
                'facebook' => Setting::get('facebook_url', ''),
                'instagram' => Setting::get('instagram_url', ''),
                'twitter' => Setting::get('twitter_url', ''),
                'youtube' => Setting::get('youtube_url', ''),
            ],
            'fees' => [
                'unlock_fee' => (float) Setting::get('unlock_fee', 49),
                'listing_fee' => (float) Setting::get('listing_fee', 199),
                'featured_fee' => (float) Setting::get('featured_fee', 99),
            ]
        ];

        return $this->sendSuccess($settings);
    }
}
