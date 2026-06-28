<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        // For admin, show all plans
        if (Auth::check() && Auth::user()->role === 'admin') {
            $plans = Plan::all();
            $contactPlans = Plan::where('type', 'user')->where('contacts_limit', '>', 0)->get();
            $listingPlans = Plan::where('type', 'owner')->where('listing_limit', '>', 0)->get();
            return view('plans.index', compact('plans', 'contactPlans', 'listingPlans'));
        }
        
        // Show contact subscription plans ONLY to users (ACTIVE ONLY)
        if (Auth::check() && Auth::user()->role === 'user') {
            $contactPlans = Plan::where('type', 'user')
                ->where('contacts_limit', '>', 0)
                ->where('is_active', true)
                ->get();
            return view('plans.index', compact('contactPlans'));
        }
        
        // Show room listing plans ONLY to owners (ACTIVE ONLY)
        if (Auth::check() && Auth::user()->role === 'owner') {
            $listingPlans = Plan::where('type', 'owner')
                ->where('listing_limit', '>', 0)
                ->where('is_active', true)
                ->get();
            return view('plans.index', compact('listingPlans'));
        }
        
        // Not logged in - show nothing or redirect to login
        $contactPlans = collect([]);
        $listingPlans = collect([]);
        return view('plans.index', compact('contactPlans', 'listingPlans'));
    }

    public function create()
    {
        return view('plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'duration_days' => 'required|numeric',
            'listing_limit' => 'nullable|numeric',
            'contacts_limit' => 'nullable|numeric',
            'type' => 'required',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string'
        ]);

        Plan::create($data);
        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully!');
    }

    public function edit(Plan $plan)
    {
        return view('plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'duration_days' => 'required|numeric',
            'listing_limit' => 'nullable|numeric',
            'contacts_limit' => 'nullable|numeric',
            'type' => 'required',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string'
        ]);

        $plan->update($data);
        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully!');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully!');
    }

    public function toggleActive(Plan $plan)
    {
        $plan->update(['is_active' => !$plan->is_active]);
        $status = $plan->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.plans.index')->with('success', "Plan {$status} successfully!");
    }
}

