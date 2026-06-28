<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Http\Resources\PlanResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiSubscriptionController extends BaseApiController
{
    /**
     * List all available plans
     */
    public function plans()
    {
        $plans = Plan::where('status', true)->get();
        return $this->sendSuccess(PlanResource::collection($plans));
    }

    /**
     * Purchase a subscription
     */
    public function purchase(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'payment_method' => 'required|in:wallet,online',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $user = Auth::user();

        // Check for active subscription of same type
        $activeSub = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereHas('plan', fn($q) => $q->where('type', $plan->type))
            ->first();

        if ($activeSub) {
            return $this->sendError('You already have an active ' . $plan->type . ' subscription', [], 400);
        }

        DB::beginTransaction();
        try {
            if ($request->payment_method === 'wallet') {
                if ($user->wallet_balance < $plan->price) {
                    return $this->sendError('Insufficient wallet balance', [], 400);
                }

                $user->decrement('wallet_balance', $plan->price);

                $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($plan->duration),
                    'status' => 'active'
                ]);

                Payment::create([
                    'user_id' => $user->id,
                    'type' => 'subscription',
                    'amount' => $plan->price,
                    'gateway' => 'wallet',
                    'reference_id' => $subscription->id,
                    'status' => 'completed'
                ]);

                DB::commit();

                return $this->sendSuccess([
                    'new_balance' => (float) $user->wallet_balance
                ], 'Subscription activated successfully using wallet balance');
            }

            // For online payment
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addDays($plan->duration),
                'status' => 'pending'
            ]);

            return $this->sendSuccess([
                'subscription_id' => $subscription->id,
                'amount' => (float) $plan->price,
                'type' => 'subscription'
            ], 'Payment required to activate subscription');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($this->safeErrorMessage($e, 'Unable to complete subscription. Please try again.'), [], 500);
        }
    }
}
