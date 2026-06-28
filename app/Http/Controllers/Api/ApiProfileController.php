<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting;

class ApiProfileController extends BaseApiController
{
    /**
     * Get user profile
     */
    public function show()
    {
        return $this->sendSuccess(new UserResource(Auth::user()));
    }

    /**
     * Update profile details
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors(), 422);
        }

        $user->name = $request->name;
        $user->phone = $request->phone;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return $this->sendSuccess(new UserResource($user), 'Profile updated successfully');
    }

    /**
     * Send OTP for account deletion
     */
    public function sendDeleteOtp()
    {
        $user = Auth::user();
        $otp = rand(1000, 9999);
        
        $user->update(['verification_code' => $otp]);
        
        // Use existing mail logic if available or just return for integration
        Setting::setMailConfig();

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OTPMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Delete OTP mail failed: ' . $e->getMessage());
            return $this->sendError(
                'Unable to send verification email. Please try again later.',
                config('app.debug') ? ['error' => $e->getMessage()] : [],
                500
            );
        }

        return $this->sendSuccess([], 'OTP sent to your email for account deletion verification');
    }

    /**
     * Delete account
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        if ($request->filled('otp')) {
            if ($user->verification_code != $request->otp) {
                return $this->sendError('Invalid OTP');
            }
        } else {
             return $this->sendError('OTP is required for account deletion');
        }

        $user->tokens()->delete();
        $user->delete();

        return $this->sendSuccess([], 'Account deleted successfully');
    }
}
