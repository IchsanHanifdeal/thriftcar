<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('management_users', [
            'title' => 'Kelola Pengguna',
            'active' => 'management_user',
            'role' => $request->session()->get('role'),
            'users' => User::all(),
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
    public function update(Request $request, $id_user)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required',
        ]);

        try {
            $user = User::findOrFail($id_user);

            $user->update([
                'role' => $request->role
            ]);
            toastr()->success('Role telah diganti!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Role gagal diganti: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
