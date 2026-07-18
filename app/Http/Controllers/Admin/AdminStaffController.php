<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminStaffController extends Controller
{
    public function index() { return view('admin.staff.index', ['staff' => User::where('role','admin')->with('adminRole')->latest()->get(), 'roles' => AdminRole::orderBy('name')->get()]); }
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:100','email'=>'required|email|unique:users,email','phone'=>'nullable|string|max:20','password'=>'required|string|min:8|confirmed','admin_role_id'=>'required|exists:admin_roles,id']);
        $data += ['role'=>'admin','is_verified'=>true,'is_staff_active'=>true,'email_verified_at'=>now()];
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return back()->with('success','Staff account created.');
    }
    public function update(Request $request, User $staff)
    {
        abort_unless($staff->role === 'admin', 404);
        $data = $request->validate(['name'=>'required|string|max:100','email'=>'required|email|unique:users,email,'.$staff->id,'phone'=>'nullable|string|max:20','admin_role_id'=>'required|exists:admin_roles,id','password'=>'nullable|string|min:8|confirmed']);
        if (!empty($data['password'])) $data['password'] = Hash::make($data['password']); else unset($data['password']);
        $staff->update($data);
        return back()->with('success','Staff account updated.');
    }
    public function toggle(User $staff)
    {
        abort_unless($staff->role === 'admin', 404);
        abort_if(auth()->id() === $staff->id, 422, 'You cannot disable your own account.');
        $staff->update(['is_staff_active'=>!$staff->is_staff_active]);
        return back()->with('success','Staff access updated.');
    }
}
