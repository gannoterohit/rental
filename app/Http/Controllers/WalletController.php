<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index() { $user=Auth::user(); return view('user.wallet',compact('user')); }
    public function convertPoints(Request $request)
    {
        $data=$request->validate(['points'=>'required|integer|min:1000|multiple_of:1000']);
        $user=Auth::user();
        if((int)$user->wallet < $data['points']) return back()->with('error','You do not have enough points to convert this amount.');
        $amount=($data['points']/1000)*10;
        DB::beginTransaction();
        try {
            $user->decrement('wallet',$data['points']);
            $user->increment('wallet_balance',$amount);
            DB::commit();
            return back()->with('success','Converted '.number_format($data['points']).' points to ₹'.number_format($amount,2).' successfully.');
        } catch (\Throwable $e) {
            DB::rollBack(); report($e);
            return back()->with('error','The conversion could not be completed. Please try again.');
        }
    }
}
