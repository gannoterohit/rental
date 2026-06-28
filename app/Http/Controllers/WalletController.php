<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class WalletController extends Controller
{
    // Show wallet dashboard
    public function index()
    {
        $user = Auth::user();
        return view('user.wallet', compact('user'));
    }

    // Convert Points to Wallet Balance
    public function convertPoints(Request $request)
    {
        $request->validate([
            'points' => 'required|integer|min:1000'
        ]);

        $user = Auth::user();

        if ($user->wallet < $request->points) {
            return back()->with('error', 'Insufficient points to convert.');
        }

        // Conversion Rate: 1000 Points = ₹10
        // Formula: Amount = (Points / 1000) * 10
        $amount = ($request->points / 1000) * 10;

        DB::beginTransaction();
        try {
            // Deduct Points
            $user->decrement('wallet', $request->points);
            
            // Add Money to Wallet Balance
            $user->increment('wallet_balance', $amount);

            DB::commit();

            return back()->with('success', "Converted {$request->points} Points to ₹{$amount} successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Conversion failed: ' . $e->getMessage());
        }
    }
}
