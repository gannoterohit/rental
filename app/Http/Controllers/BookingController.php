<?php

namespace App\Http\Controllers;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Payout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller {
    public function store(Request $req) {
        $req->validate([
            'room_id' => 'required|exists:rooms,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
        ]);

        $room = Room::findOrFail($req->room_id);
        
        // Calculate total amount (rent per month * number of months)
        $from = \Carbon\Carbon::parse($req->from_date);
        $to = \Carbon\Carbon::parse($req->to_date);
        $months = $from->diffInMonths($to) + 1;
        $total = $room->rent * $months;

        // Commission calculation (from settings or default 10%)
        $commissionPercent = config('app.commission_percent', 10);
        $adminCommission = round($total * $commissionPercent / 100);
        
        // Service charge (fixed or from settings)
        $serviceCharge = config('app.service_charge', 200);
        
        // Owner payout
        $ownerPayout = $total - $adminCommission;
        
        // User pays: total + service charge
        $userPayAmount = $total + $serviceCharge;

        DB::beginTransaction();
        try {
            // Create booking with pending status
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'room_id' => $room->id,
                'from_date' => $req->from_date,
                'to_date' => $req->to_date,
                'total_amount' => $total,
                'admin_commission' => $adminCommission,
                'service_charge' => $serviceCharge,
                'owner_payout' => $ownerPayout,
                'status' => 'pending'
            ]);

            // Create payment record (will be updated after payment gateway success)
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'type' => 'booking',
                'amount' => $userPayAmount,
                'gateway' => 'razorpay',
                'reference_id' => $booking->id,
                'status' => 'pending'
            ]);

            $booking->update(['payment_id' => $payment->id]);

            // Create payout record for owner (hold for 7 days)
            Payout::create([
                'owner_id' => $room->user_id,
                'booking_id' => $booking->id,
                'amount' => $ownerPayout,
                'status' => 'pending',
                'release_date' => now()->addDays(7)
            ]);

            DB::commit();

            // Return payment order details for Razorpay
            return response()->json([
                'success' => true,
                'booking_id' => $booking->id,
                'payment_id' => $payment->id,
                'amount' => $userPayAmount,
                'message' => 'Booking created. Please complete payment.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }
}
