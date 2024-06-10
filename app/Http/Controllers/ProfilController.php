<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->session()->get('role');

        return view('profil', [
            'title' => 'Profil',
            'active' => 'profil',
            'role' => $role,
        ]);
    }
    public function password(Request $request)
    {
        $role = $request->session()->get('role');

        return view('password', [
            'title' => 'Password',
            'active' => 'ubah_password',
            'role' => $role,
        ]);
    }
    public function updatePassword(Request $request)
    {
        $id_user = $request->session()->get('id_user');

        $request->validate(
            [
                'password_lama' => 'required',
                'password_baru' => 'required|min:8',
                'konfirmasi_password_baru' => 'required|same:password_baru',
            ],
            [
                'password_baru.min:8' => 'Password Baru minimal 8 Karakter',
                'konfirmasi_password_baru' => 'Password tidak sama',
            ]
        );

        $user = User::where('id_user', $id_user)->firstOrFail();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama salah.'])->withInput();
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil diperbarui.');
    }
}
