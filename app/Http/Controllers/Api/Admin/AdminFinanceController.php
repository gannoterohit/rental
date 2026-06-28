<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Payment;
use App\Models\Payout;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminFinanceController extends BaseApiController
{
    /**
     * List all payments
     */
    public function payments(Request $request)
    {
        $query = Payment::with('user')->latest();
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('type')) $query->where('type', $request->type);
        return $this->sendSuccess($query->paginate($request->get('limit', 15)));
    }

    /**
     * List all payouts
     */
    public function payouts(Request $request)
    {
        $query = Payout::with(['owner', 'booking'])->latest();
        if ($request->filled('status')) $query->where('status', $request->status);
        return $this->sendSuccess($query->paginate($request->get('limit', 15)));
    }

    /**
     * Process a payout
     */
    public function processPayout(Request $request, $id)
    {
        $payout = Payout::find($id);
        if (!$payout) return $this->sendError('Payout not found');
        if ($payout->status !== 'pending') return $this->sendError('Already processed');
        if ($payout->release_date > now()) return $this->sendError('On hold');

        $validator = Validator::make($request->all(), ['payment_reference' => 'required|string']);
        if ($validator->fails()) return $this->sendError('Validation failed', $validator->errors(), 422);

        $payout->update(['status' => 'processed', 'payment_reference' => $request->payment_reference]);
        return $this->sendSuccess($payout, 'Payout processed');
    }

    /**
     * Plans Management
     */
    public function plans() { return $this->sendSuccess(Plan::latest()->get()); }

    public function storePlan(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required', 'price' => 'required|numeric', 'duration_days' => 'required|integer', 'listing_limit' => 'required', 'type' => 'required'
        ]);
        if ($validator->fails()) return $this->sendError('Validation failed', $validator->errors(), 422);
        $plan = Plan::create($request->all());
        return $this->sendSuccess($plan, 'Plan created', 201);
    }

    public function updatePlan(Request $request, $id) {
        $plan = Plan::find($id);
        if (!$plan) return $this->sendError('Plan not found');
        $plan->update($request->all());
        return $this->sendSuccess($plan, 'Plan updated');
    }

    public function togglePlan($id) {
        $plan = Plan::find($id);
        if (!$plan) return $this->sendError('Plan not found');
        $plan->update(['is_active' => !$plan->is_active]);
        return $this->sendSuccess(['is_active' => $plan->is_active], 'Status updated');
    }

    public function destroyPlan($id) {
        $plan = Plan::find($id);
        if (!$plan) return $this->sendError('Plan not found');
        $plan->delete();
        return $this->sendSuccess([], 'Plan deleted');
    }
}
