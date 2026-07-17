<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $rooms = Room::where('user_id', Auth::id())->count();
        $contactUnlocks = \App\Models\Enquiry::where('unlocked', true)->whereHas('room', function ($q) {
            $q->where('user_id', Auth::id());
        })->count();
        $featuredRooms = Room::where('user_id', Auth::id())
            ->where('is_featured', true)
            ->count();
        $recentRooms = Room::where('user_id', Auth::id())
            ->latest()
            ->take(3)
            ->get();

        return view('owner.dashboard', compact('rooms', 'contactUnlocks', 'featuredRooms', 'recentRooms'));
    }

    public function rooms()
    {
        $myRooms = Room::where('user_id', Auth::id())
            ->latest()
            ->paginate(9);

        $roomCounts = [
            'all' => Room::where('user_id', Auth::id())->count(),
            'active' => Room::where('user_id', Auth::id())->where('status', 'active')->count(),
            'pending' => Room::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'booked' => Room::where('user_id', Auth::id())->where('status', 'booked')->count(),
        ];

        return view('owner.rooms', compact('myRooms', 'roomCounts'));
    }
}
