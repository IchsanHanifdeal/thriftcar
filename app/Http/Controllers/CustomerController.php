<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('customer', [
            'title' => 'Customer',
            'active' => 'customer',
            'customer' => Customer::all(),
            'role' => $request->session()->get('role'),
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
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id_customer)
    {
        DB::beginTransaction();

        try {
            $customer = Customer::findOrFail($id_customer);

            if ($customer->id_user) {
                $user = User::findOrFail($customer->id_user);
                $user->delete();
            }

            $customer->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Customer berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error deleting customer: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus customer dan pengguna terkait');
        }
    }
}
