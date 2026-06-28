<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Room;
use App\Models\Enquiry;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiUnlockController extends BaseApiController
{
    /**
     * Unlock room contact details
     */
    public function unlock(Request $request, $id)
    {
        $room = Room::with('owner')->find($id);
        
        if (!$room) {
            return $this->sendError('Room not found');
        }

        // Check if user is owner
        if (Auth::id() === $room->user_id) {
            return $this->sendSuccess([
                'contact' => $room->owner->phone ?? $room->owner->email
            ], 'You are the owner of this room');
        }

        // Check if already unlocked
        $existingEnquiry = Enquiry::where('user_id', Auth::id())
            ->where('room_id', $room->id)
            ->where('unlocked', true)
            ->first();

        if ($existingEnquiry) {
            return $this->sendSuccess([
                'contact' => $room->owner->phone ?? $room->owner->email
            ], 'Already unlocked');
        }

        DB::beginTransaction();
        try {
            // 1. Check Subscription
            $activeSubscription = \App\Models\Subscription::where('user_id', Auth::id())
                ->where('status', 'active')
                ->with('plan')
                ->first();
            
            if ($activeSubscription && $activeSubscription->plan && $activeSubscription->plan->type === 'user') {
                $usedContacts = Enquiry::where('user_id', Auth::id())
                    ->where('unlocked', true)
                    ->whereNull('payment_id')
                    ->count();
                
                $totalContacts = $activeSubscription->plan->contacts_limit ?? 0;
                $remaining = ($totalContacts === -1) ? 9999 : max(0, $totalContacts - $usedContacts);
                
                if ($remaining > 0) {
                    Enquiry::create([
                        'user_id' => Auth::id(),
                        'room_id' => $room->id,
                        'unlocked' => true,
                        'unlocked_at' => now()
                    ]);

                    DB::commit();

                    return $this->sendSuccess([
                        'contact' => $room->owner->phone ?? $room->owner->email
                    ], 'Unlocked via subscription');
                }
            }

            // 2. Check Wallet
            $unlockFee = Setting::get('unlock_fee', 49);
            $user = Auth::user();

            if ($request->payment_method === 'wallet') {
                if ($user->wallet_balance >= $unlockFee) {
                    $user->decrement('wallet_balance', $unlockFee);
                    
                    $payment = Payment::create([
                        'user_id' => $user->id,
                        'type' => 'unlock',
                        'amount' => $unlockFee,
                        'gateway' => 'wallet',
                        'reference_id' => $room->id,
                        'status' => 'completed'
                    ]);

                    Enquiry::create([
                        'user_id' => $user->id,
                        'room_id' => $room->id,
                        'payment_id' => $payment->id,
                        'unlocked' => true,
                        'unlocked_at' => now()
                    ]);

                    DB::commit();

                    return $this->sendSuccess([
                        'contact' => $room->owner->phone ?? $room->owner->email,
                        'new_balance' => (float) $user->wallet_balance
                    ], 'Unlocked via wallet');
                } else {
                    return $this->sendError('Insufficient wallet balance');
                }
            }

            // 3. Initiate Online Payment
            if ($unlockFee <= 0) {
                 Enquiry::create([
                     'user_id' => Auth::id(),
                     'room_id' => $room->id,
                     'unlocked' => true,
                     'unlocked_at' => now()
                 ]);
                 DB::commit();
                 return $this->sendSuccess([
                     'contact' => $room->owner->phone ?? $room->owner->email
                 ], 'Unlocked for free');
            }
            
            return $this->sendSuccess([
                'amount' => (float) $unlockFee,
                'reference_id' => $room->id,
                'type' => 'unlock'
            ], 'Payment required to unlock contact');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($this->safeErrorMessage($e, 'Unable to unlock contact. Please try again.'), [], 500);
        }
    }
}
