<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('mobil', [
            'title' => 'Mobil',
            'active' => 'mobil',
            'mobil' => Mobil::all(),
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
        $validator = Validator::make($request->all(), [
            'nama_mobil' => 'required',
            'tipe_mobil' => 'required',
            'merk_mobil' => 'required',
            'warna' => 'required',
            'transmisi' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif',
        ], [
            'gambar.required' => 'Gambar harus diunggah.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat: jpeg, png, jpg, atau gif.',
        ]);

        if ($validator->fails()) {
            toastr()->error('Pendaftaran gagal: ' . $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $gambarPath = null;

            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('public/gambar');
                $gambarPath = str_replace('public/', '', $gambarPath);
            }

            $mobil = Mobil::create([
                'nama_mobil' => $request->nama_mobil,
                'tipe_mobil' => $request->tipe_mobil,
                'merk_mobil' => $request->merk_mobil,
                'warna' => $request->warna,
                'transmisi' => $request->transmisi,
                'stok' => $request->stok,
                'harga' => $request->harga,
                'gambar' => $gambarPath,
            ]);

            toastr()->success('Pendaftaran mobil Berhasil!');
            return redirect()->route('mobil');
        } catch (\Exception $e) {
            toastr()->error('Pendaftaran gagal: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mobil $mobil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mobil $mobil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id_mobil)
    {
        $validator = Validator::make($request->all(), [
            'nama_mobil' => 'required',
            'tipe_mobil' => 'required',
            'merk_mobil' => 'required',
            'warna' => 'required',
            'transmisi' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif',
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat: jpeg, png, jpg, atau gif.',
        ]);

        if ($validator->fails()) {
            toastr()->error('Pembaruan gagal: ' . $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $mobil = Mobil::findOrFail($id_mobil);
            $gambarPath = $mobil->gambar;

            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('public/gambar');
                $gambarPath = str_replace('public/', '', $gambarPath);
            }

            $mobil->update([
                'nama_mobil' => $request->nama_mobil,
                'tipe_mobil' => $request->tipe_mobil,
                'merk_mobil' => $request->merk_mobil,
                'warna' => $request->warna,
                'transmisi' => $request->transmisi,
                'stok' => $request->stok,
                'harga' => $request->harga,
                'gambar' => $gambarPath,
            ]);

            toastr()->success('Pembaruan mobil berhasil!');
            return redirect()->route('mobil');
        } catch (\Exception $e) {
            toastr()->error('Pembaruan gagal: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id_mobil)
    {
        $mobil = Mobil::findOrFail($id_mobil);
    
        if ($mobil->gambar) {
            Storage::delete('public/' . $mobil->gambar);
        }
        
        $mobil->delete();
        
        return redirect()->back()->with('success', 'Mobil berhasil dihapus');
    }
}
