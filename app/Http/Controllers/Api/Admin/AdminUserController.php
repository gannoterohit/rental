<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\User;
use App\Models\Room;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends BaseApiController
{
    /**
     * List all regular users
     */
    public function users(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_blocked', $request->status === 'blocked');
        }

        $users = $query->latest()->paginate($request->get('limit', 15));
        return $this->sendSuccess($users);
    }

    /**
     * Get user detail
     */
    public function userDetail($id)
    {
        $user = User::with(['bookings', 'rooms'])->find($id);
        if (!$user) return $this->sendError('User not found');
        return $this->sendSuccess($user);
    }

    /**
     * Toggle block user
     */
    public function toggleBlockUser($id)
    {
        $user = User::find($id);
        if (!$user) return $this->sendError('User not found');
        $user->update(['is_blocked' => !$user->is_blocked]);
        return $this->sendSuccess(['is_blocked' => $user->is_blocked], $user->is_blocked ? 'User blocked' : 'User unblocked');
    }

    /**
     * List all owners
     */
    public function owners(Request $request)
    {
        $query = User::where('role', 'owner')->withCount('rooms');
        if($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }
        $owners = $query->latest()->paginate($request->get('limit', 15));
        return $this->sendSuccess($owners);
    }

    /**
     * Get owner detail
     */
    public function ownerDetail($id)
    {
        $owner = User::where('role', 'owner')->find($id);
        if (!$owner) return $this->sendError('Owner not found');
        $rooms = Room::where('user_id', $id)->latest()->paginate(10);
        return $this->sendSuccess([
            'owner' => $owner,
            'rooms' => RoomResource::collection($rooms),
        ]);
    }

    /**
     * Toggle block owner
     */
    public function toggleBlockOwner($id)
    {
        $owner = User::where('role', 'owner')->find($id);
        if (!$owner) return $this->sendError('Owner not found');
        $owner->update(['is_blocked' => !$owner->is_blocked]);
        return $this->sendSuccess(['is_blocked' => $owner->is_blocked], $owner->is_blocked ? 'Owner blocked' : 'Owner unblocked');
    }

    /**
     * Admin create owner
     */
    public function createOwner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
        ]);

        if ($validator->fails()) return $this->sendError('Validation failed', $validator->errors(), 422);

        $owner = User::create([
            'name' => $request->name, 'email' => $request->email, 'phone' => $request->phone,
            'role' => 'owner', 'email_verified_at' => now(),
        ]);
        return $this->sendSuccess($owner, 'Owner created', 201);
    }
}
