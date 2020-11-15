<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Purchase;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalsales         = Order::sum('total');
        $totalsalesyear     = Order::whereYear('created_at', Carbon::now()->year)->sum('total');
        $totalsalesday      = Order::whereDay('created_at', Carbon::now()->day)->sum('total');
        $totalpurchases     = Purchase::sum('price');
        $totalpurchasesyear = Purchase::whereYear('created_at', Carbon::now()->year)->sum('price');
        $totalpurchasesday  = Purchase::whereDay('created_at', Carbon::now()->day)->sum('price');

        $data = [
            'totalsales'         => $totalsales,
            'totalsalesyear'     => $totalsalesyear,
            'totalsalesday'      => $totalsalesday,
            'totalpurchases'     => $totalpurchases,
            'totalpurchasesyear' => $totalpurchasesyear,
            'totalpurchasesday'  => $totalpurchasesday,
        ];

        return view('home', compact('data'));
    }
}