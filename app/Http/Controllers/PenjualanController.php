<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mobil;
use App\Models\Cicilan;
use App\Models\Customer;
use App\Models\Penjualan;
use Illuminate\Http\Request;
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

        $customer = Customer::where('id_user', $id_user)->first();

        $sales = User::where('role', 'sales')->get();

        return view('cash', [
            'title' => 'Cash',
            'active' => 'dashboard',
            'role' => $request->session()->get('role'),
            'mobil' => Mobil::find($id_mobil),
            'customer' => $customer,
            'sales' => $sales,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store_payment(Request $request, $id_mobil)
    {
        // Validasi input termasuk id_user
        $validator = Validator::make($request->all(), [
            'dp' => 'required|numeric|min:0',
            'id_user' => 'nullable', // Memastikan id_user ada di tabel users, boleh kosong
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil data customer
        $id_user_log = $request->session()->get('id_user');
        $customer = Customer::where('id_user', $id_user_log)->first();

        if (!$customer) {
            return redirect()->back()->with('error', 'Customer tidak ditemukan.');
        }

        // Buat data penjualan
        $penjualan = Penjualan::create([
            'id_customer' => $customer->id_customer,
            'id_mobil' => $id_mobil,
            'id_user' => $request->id_user,
            'dp' => $request->dp,
            'tanggal_transaksi' => now(),
            'cara_pembayaran' => 'cash',
            'status_pembayaran' => 'lunas',
        ]);

        // Kurangi stok mobil
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
        $sales = User::where('role', 'sales')->get();

        $id_user = $request->session()->get('id_user');

        return view('kredit', [
            'title' => 'Kredit',
            'active' => 'dashboard',
            'role' => $request->session()->get('role'),
            'mobil' => Mobil::find($id_mobil),
            'sales' => $sales,
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
        $mobil = Mobil::findOrFail($id_mobil);
        $minDp = $mobil->harga * 0.1;

        $validator = Validator::make($request->all(), [
            'dp' => [
                'required',
                'numeric',  // Memastikan hanya angka yang valid
                function ($attribute, $value, $fail) use ($minDp, $mobil) {
                    if ($value < $minDp) {
                        $fail('DP tidak boleh kurang dari ' . number_format($minDp, 0, '', '.'));
                    }
                    if ($value > $mobil->harga) {
                        $fail('DP tidak boleh lebih dari harga mobil.');
                    }
                },
            ],
            'tenor' => ['required', 'numeric', 'in:12,24,36'], // Validasi tenor hanya 12, 24, atau 36 bulan
        ], [
            'dp.required' => 'DP wajib diisi.',
            'dp.numeric' => 'Format DP tidak valid. Harus berupa angka dengan pemisah ribuan titik.',
            'tenor.required' => 'Tenor wajib diisi.',
            'tenor.in' => 'Tenor hanya boleh 12, 24, atau 36 bulan.',
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
                'id_user' => $request->id_user,
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
    public function tarik(Request $request, $id_penjualan)
    {
        $penjualan = Penjualan::findorfail($id_penjualan);

        $penjualan->update([
            'status_pembayaran' => 'ditarik',
        ]);

        Cicilan::where('id_penjualan', $id_penjualan)->delete();

        return redirect()->back()->with('success', 'Mobil berhasil ditarik');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id_penjualan)
    {
        $penjualan = Penjualan::findOrFail($id_penjualan);

        $penjualan->delete();

        return redirect()->back()->with('success', 'Mobil berhasil dihapus');
    }

    public function laporan_sales(Request $request)
    {
        $role = $request->session()->get('role');

        $penjualans = DB::table('penjualan')
            ->join('customer', 'penjualan.id_customer', '=', 'customer.id_customer')
            ->join('mobil', 'penjualan.id_mobil', '=', 'mobil.id_mobil')
            ->join('users as sales', 'penjualan.id_user', '=', 'sales.id_user')
            ->select(
                'penjualan.id_penjualan',
                'sales.nama as nama_sales',
                'penjualan.tanggal_transaksi',
                'customer.nama_lengkap as nama_customer',
                'mobil.nama_mobil as item_terjual',
                'penjualan.cara_pembayaran as tipe_penjualan',
                'mobil.harga'
            )
            ->get();

        return view('laporan_sales', [
            'title' => 'Laporan Penjualan Sales',
            'active' => 'laporan_sales',
            'role' => $role,
            'penjualans' => $penjualans,
        ]);
    }
}
