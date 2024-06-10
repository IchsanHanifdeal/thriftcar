<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Cicilan;
use App\Models\Customer;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->session()->get('role');

        if ($role === 'customer') {
            $idUser = auth()->id();

            $penjualan = Penjualan::whereHas('customer', function ($query) use ($idUser) {
                $query->where('id_user', $idUser);
            })->get();
        } else {
            $penjualan = Penjualan::all();
        }

        return view('penjualan', [
            'title' => 'Penjualan',
            'active' => 'penjualan',
            'penjualan' => $penjualan,
            'role' => $role,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function payment(Request $request, $id_mobil)
    {
        $id_user = $request->session()->get('id_user');

        return view('cash', [
            'title' => 'Cash',
            'active' => 'dashboard',
            'role' => $request->session()->get('role'),
            'mobil' => Mobil::find($id_mobil),
            'customer' => Customer::where('id_user', $id_user)->first(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_payment(Request $request, $id_mobil)
    {

        $id_user = $request->session()->get('id_user');
        $customer = Customer::where('id_user', $id_user)->first();

        $validator = Validator::make($request->all(), [
            'dp' => 'required',
        ]);

        $penjualan = Penjualan::create([
            'id_customer' => $customer->id_customer,
            'id_mobil' => $id_mobil,
            'dp' => $request->dp,
            'tanggal_transaksi' => now(),
            'cara_pembayaran' => 'cash',
            'status_pembayaran' => 'lunas',
        ]);

        $mobil = Mobil::find($id_mobil);
        if ($mobil) {
            $mobil->stok -= 1;
            $mobil->save();
        } else {
            return redirect()->back()->with('error', 'Mobil tidak ditemukan.');
        }

        toastr()->success('Pembelian Mobil Berhasil!');
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function payment_kredit(Request $request, $id_mobil)
    {
        $id_user = $request->session()->get('id_user');

        return view('kredit', [
            'title' => 'Kredit',
            'active' => 'dashboard',
            'role' => $request->session()->get('role'),
            'mobil' => Mobil::find($id_mobil),
            'customer' => Customer::where('id_user', $id_user)->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function store_payment_kredit(Request $request, $id_mobil)
    {
        $id_user = $request->session()->get('id_user');
        $customer = Customer::where('id_user', $id_user)->first();

        $validator = Validator::make($request->all(), [
            'dp' => 'required|numeric|min:0',
            'tenor' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $penjualan = Penjualan::create([
                'id_customer' => $customer->id_customer,
                'id_mobil' => $id_mobil,
                'dp' => $request->dp,
                'tanggal_transaksi' => now(),
                'cara_pembayaran' => 'kredit',
                'status_pembayaran' => 'kredit',
            ]);

            $mobil = Mobil::find($id_mobil);
            if ($mobil) {
                $mobil->stok -= 1;
                $mobil->save();
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Mobil tidak ditemukan.');
            }

            $penjualanID = $penjualan->id_penjualan;

            $principal = $mobil->harga - $request->dp;
            $factor = 1.0;

            if ($request->tenor == 12) {
                $factor = 1.171;
            } elseif ($request->tenor == 24) {
                $factor = 1.211;
            } elseif ($request->tenor == 36) {
                $factor = 1.285;
            }

            $totalAmount = $principal * $factor;
            $monthlyInstallment = $totalAmount / $request->tenor;

            function roundSignificant($value)
            {
                if ($value < 10000) {
                    return round($value, -2);
                } elseif ($value < 100000) {
                    return round($value, -3);
                } else {
                    return round($value, -4);
                }
            }

            $monthlyInstallment = roundSignificant($monthlyInstallment);

            for ($i = 0; $i < $request->tenor; $i++) {
                Cicilan::create([
                    'id_customer' => $customer->id_customer,
                    'id_penjualan' => $penjualanID,
                    'tenor' => $request->tenor,
                    'jumlah_cicilan' => $monthlyInstallment,
                    'jatuh_tempo' => Carbon::now()->addMonths($i + 1),
                    'status_pembayaran' => 'belum lunas',
                    'status_cicilan' => 'belum lunas',
                ]);
            }

            DB::commit();
            toastr()->success('Pembelian Mobil Berhasil!');
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses transaksi.')->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
}
