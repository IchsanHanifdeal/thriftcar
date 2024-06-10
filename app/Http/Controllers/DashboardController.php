<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mobil;
use App\Models\Customer;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('dashboard', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'role' => $request->session()->get('role'),
            'mobil' => Mobil::all(),
            'total_mobil' => Mobil::count(),
            'total_customer' => Customer::count(),
            'totalPenjualan' => Penjualan::sum('dp'),
            'totalPenjualanBulanIni' => Penjualan::whereMonth('created_at', Carbon::now()->month)->sum('dp'),
            'totalPenjualanHariIni' => Penjualan::whereDate('created_at', Carbon::today())->sum('dp'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
