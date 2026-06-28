<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    /**
     * Handle incoming referral links.
     */
    public function track(Request $request, $code)
    {
        // Store the referral code in the session for 30 days
        session(['referral_code' => $code]);

        // Redirect to homepage or registration
        return redirect()->route('home')->with('info', 'Welcome! You have been referred by a friend. Register now to get 5 Points!');
    }

    /**
     * Display the referral dashboard for the user.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure user has a referral code for link generation
        if (!$user->referral_code) {
            $user->referral_code = \App\Models\User::generateUniqueReferralCode();
            $user->save();
        }

        $referrals = User::where('referred_by_id', $user->id)->latest()->get();
        $referralLink = route('referral.track', ['code' => $user->referral_code]);
        
        $refReward = \App\Models\Setting::get('referral_reward', 10);
        $joinReward = \App\Models\Setting::get('join_reward', 5);

        return view('user.referral', compact('user', 'referrals', 'referralLink', 'refReward', 'joinReward'));
    }
}
