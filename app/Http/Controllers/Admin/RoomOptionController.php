<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomOption;
use Illuminate\Http\Request;

class RoomOptionController extends Controller
{
    public function index()
    {
        $groups = ['room_type' => 'Room Type', 'furnishing_type' => 'Furnishing', 'tenant_type' => 'Preferred Tenant'];
        $options = RoomOption::orderBy('group')->orderBy('sort_order')->orderBy('label')->get()->groupBy('group');

        return view('admin.room-options.index', compact('options', 'groups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'group' => 'required|in:room_type,furnishing_type,tenant_type',
            'key' => 'required|string|max:100|regex:/^[a-z0-9_\-]+$/|unique:room_options,key',
            'label' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        RoomOption::create(array_merge($data, ['is_active' => true]));

        return redirect()->back()->with('success', 'Room option added successfully.');
    }

    public function update(Request $request, RoomOption $roomOption)
    {
        $data = $request->validate([
            'group' => 'required|in:room_type,furnishing_type,tenant_type',
            'key' => 'required|string|max:100|regex:/^[a-z0-9_\-]+$/|unique:room_options,key,' . $roomOption->id,
            'label' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $roomOption->update($data);

        return redirect()->back()->with('success', 'Room option updated successfully.');
    }

    public function destroy(RoomOption $roomOption)
    {
        $roomOption->update(['is_active' => false]);

        return redirect()->back()->with('success', 'Room option removed successfully.');
    }
}
