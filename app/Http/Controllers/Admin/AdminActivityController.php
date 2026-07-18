<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminActivityController extends Controller
{
    public function index(Request $request)
    {
        $logs=AdminActivityLog::with('actor')->when($request->filled('actor'),fn($q)=>$q->where('actor_id',$request->actor))->when($request->filled('search'),fn($q)=>$q->where(fn($x)=>$x->where('description','like','%'.$request->search.'%')->orWhere('route_name','like','%'.$request->search.'%')))->latest()->paginate(30)->withQueryString();
        return view('admin.activity.index',[
            'logs'=>$logs,
            'staff'=>User::where('role','admin')->orderBy('name')->get(),
            'totalLogs'=>AdminActivityLog::count(),
            'todayLogs'=>AdminActivityLog::whereDate('created_at',today())->count(),
            'activeActors'=>AdminActivityLog::where('created_at','>=',now()->subDays(30))->distinct('actor_id')->count('actor_id'),
        ]);
    }
}
