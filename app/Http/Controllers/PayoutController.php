<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payout;
use App\Models\Booking;
use Carbon\Carbon;

class PayoutController extends Controller
{
    // Called after booking confirmed -> create payout with hold period (e.g., 7 days)
    public function createForBooking(Booking $booking)
    {
        $holdDays = config('roomrental.payout_hold_days', 7);
        $releaseDate = Carbon::now()->addDays($holdDays);

        Payout::create([
            'owner_id' => $booking->room->user_id,
            'booking_id' => $booking->id,
            'amount' => $booking->owner_payout,
            'status' => 'pending',
            'release_date' => $releaseDate
        ]);
    }

    // Admin can process payouts manually (transfer via bank/UPI) and mark processed
    public function process(Payout $payout, Request $request)
    {
        // integrate with payout API or record manual transfer
        $payout->status = 'processed';
        $payout->payment_reference = $request->reference ?? null;
        $payout->save();

        return back()->with('success','Payout processed');
    }
}
