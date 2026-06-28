<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $rooms = Room::where('user_id', Auth::id())->count();
        $bookings = \App\Models\Booking::whereHas('room', function ($q) {
            $q->where('user_id', Auth::id());
        })->count();
        $featuredRooms = Room::where('user_id', Auth::id())
            ->where('is_featured', true)
            ->count();
        $myRooms = Room::where('user_id', Auth::id())
            ->latest()
            ->get(); // Show all rooms, not just 6
        
            // dd($bookings);
        return view('owner.dashboard', compact('rooms', 'bookings', 'featuredRooms', 'myRooms'));
    }
}
