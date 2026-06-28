<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Payout;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ApiBookingController extends BaseApiController
{
    /**
     * Create a new booking
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors(), 422);
        }

        $room = Room::findOrFail($request->room_id);
        
        // Calculation logic
        $from = Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);
        $months = $from->diffInMonths($to) + 1;
        $total = $room->rent * $months;

        $commissionPercent = \App\Models\Setting::get('commission_percent', 10);
        $adminCommission = round($total * $commissionPercent / 100);
        $serviceCharge = \App\Models\Setting::get('service_charge', 200);
        $ownerPayout = $total - $adminCommission;
        $userPayAmount = $total + $serviceCharge;

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'room_id' => $room->id,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'total_amount' => $total,
                'admin_commission' => $adminCommission,
                'service_charge' => $serviceCharge,
                'owner_payout' => $ownerPayout,
                'status' => 'pending'
            ]);

            DB::commit();

            return $this->sendSuccess([
                'booking_id' => $booking->id,
                'amount' => (float) $userPayAmount,
                'type' => 'booking'
            ], 'Booking created successfully. Payment required.');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($this->safeErrorMessage($e, 'Unable to complete booking. Please try again.'), [], 500);
        }
    }

    /**
     * Get user's bookings
     */
    public function index()
    {
        $bookings = Booking::with('room.owner')->where('user_id', Auth::id())->latest()->get();
        
        $data = $bookings->map(function($booking) {
            return [
                'id' => $booking->id,
                'room' => new RoomResource($booking->room),
                'from_date' => $booking->from_date,
                'to_date' => $booking->to_date,
                'amount' => (float) $booking->total_amount,
                'status' => $booking->status,
                'created_at' => $booking->created_at
            ];
        });

        return $this->sendSuccess($data);
    }
}
