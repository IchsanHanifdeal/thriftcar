<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userRole = Auth::user()->role;

            if ($userRole == 'admin') {
                $request->session()->regenerate();
                $user = Auth::user();
                $request->session()->put('id_user', $user->id_user);
                $request->session()->put('email', $user->nama_depan);
                $request->session()->put('role', $user->role);
                return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
            } elseif ($userRole == 'customer') {
                $request->session()->regenerate();
                $user = Auth::user();
                $request->session()->put('id_user', $user->id_user);
                $request->session()->put('email', $user->email);
                $request->session()->put('role', $user->role);
                return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
            }

            return back()->with('loginError', 'Login gagal, peran pengguna tidak dikenali.');
        }

        toastr()->error('Email atau password salah.');

        return back()->withErrors([
            'loginError' => 'Email atau password salah.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'nama_lengkap' => 'required|unique:customer,nama_lengkap',
            'alamat' => 'required',
            'tempat' => 'required',
            'tanggal_lahir' => 'required',
            'pekerjaan' => 'required',
            'no_handphone' => 'required|unique:customer,no_handphone',
            'password' => 'required|min:8',
            'retype_password' => 'required|same:password'
        ], [
            'email.unique' => 'Email sudah digunakan, gunakan email lain!',
            'nama_lengkap.unique' => 'Nama sudah terdaftar, gunakan nama lain!',
            'no_handphone.unique' => 'No Handphone sudah terdaftar, gunakan No Hp lain!',
            'password.min' => 'Password minimal 8 Karakter!',
            'retype_password.same' => 'Password tidak cocok!'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $user = User::create([
              'email' => $request->email,
              'password' => Hash::make($request->password),
              'role' => 'customer'
            ]);

            $userID = $user->id_user;

            $customer = Customer::create([
                'id_user' => $userID,
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'tempat' => $request->tempat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'pekerjaan' => $request->pekerjaan,
                'no_handphone' => $request->no_handphone,
            ]);

            if (!$customer) {
                toastr()->error('Failed to register as a student!');
                DB::rollBack();
                return redirect()->back();
            }

            DB::commit();
      
            toastr()->success('Pendaftaran Berhasil!');
            return redirect()->route('login');
          } catch (\Exception $e) {
            toastr()->error('Pendaftaran gagal: ' . $e->getMessage());
            return redirect()->back()->withInput();
          }
    }

    /**
     * Display the specified resource.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toastr()->success('Logout Sukses, anda telah mengakhiri sesi');

        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show_register()
    {
        return view('auth.register', [
            'title' => 'Daftar Akun'
        ]);
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
