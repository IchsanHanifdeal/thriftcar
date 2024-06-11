<?php

namespace App\Http\Controllers;

use App\Models\Cicilan;
use App\Models\Customer;
use Illuminate\Http\Request;

class CicilanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->session()->get('role');

        if ($role === 'customer') {
            $idUser = auth()->id();
            $cicilan = Cicilan::whereHas('customer', function ($query) use ($idUser) {
                $query->where('id_user', $idUser);
            })->get();
            $customers = Customer::where('id_user', $idUser)->get();
        } else {
            $cicilan = Cicilan::with('customer')->get();
            $customers = Customer::all();
        }

        return view('cicilan', [
            'title' => 'Cicilan',
            'active' => 'cicilan',
            'cicilan' => $cicilan,
            'role' => $role,
            'customers' => $customers,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function cicil(Request $request, $id_cicilan)
    {
        $cicilan = Cicilan::find($id_cicilan);
        if ($cicilan) {
            $currentDate = \Carbon\Carbon::now();
            $dueDate = \Carbon\Carbon::parse($cicilan->jatuh_tempo);
            $penalty = $cicilan->jumlah_cicilan * 0.1;
            $amountDue = $currentDate->greaterThan($dueDate) ? $cicilan->jumlah_cicilan + $penalty : $cicilan->jumlah_cicilan;

            $cicilan->jumlah_pembayaran = $amountDue;
            $cicilan->tanggal_pembayaran = $currentDate;
            $cicilan->status_cicilan = 'menunggu validasi';

            $cicilan->save();

            return redirect()->back()->with('success', 'Pembayaran cicilan berhasil, menunggu validasi.');
        }

        return redirect()->back()->with('error', 'Cicilan tidak ditemukan.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function terima(Request $request, $id_cicilan)
    {
        $cicilan = Cicilan::find($id_cicilan);
        if ($cicilan) {
            $cicilan->status_cicilan = 'dibayar';
            $cicilan->save();

            return redirect()->back()->with('success', 'Pembayaran cicilan diterima.');
        }

        return redirect()->back()->with('error', 'Cicilan tidak ditemukan.');
    }

    /**
     * Display the specified resource.
     */
    public function tolak(Request $request, $id_cicilan)
    {
        $cicilan = Cicilan::find($id_cicilan);
        if ($cicilan) {
            $cicilan->status_cicilan = 'belum lunas';
            $cicilan->tanggal_pembayaran = null;
            $cicilan->jumlah_pembayaran = null;
            $cicilan->save();

            return redirect()->back()->with('success', 'Pembayaran cicilan ditolak.');
        }

        return redirect()->back()->with('error', 'Cicilan tidak ditemukan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cicilan $cicilan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cicilan $cicilan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cicilan $cicilan)
    {
        //
    }
}
