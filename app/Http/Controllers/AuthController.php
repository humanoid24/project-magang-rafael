<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Register
    public function showRegister()
    {
        $divisis = Divisi::all();
        return view('auth.daftar', compact('divisis'));
    }

    public function actionRegister(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|max:255|email|unique:users',
            'name' => 'required|max:255',
            'password' => 'required|min:4|confirmed',
            'divisi_id' => 'required|exists:divisis,id',
        ], [
            'email.unique' => 'Email tidak boleh sama',
            'password.min' => 'Password minimal 4 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $user = User::create([
            'email' => $validate['email'],
            'name' => $validate['name'],
            'role' => 2,
            'divisi_id' => $validate['divisi_id'],
            'password' => Hash::make($validate['password']),
        ]);

        Session::flash('message', 'Register Berhasil. Akun Anda sudah Aktif silahkan Login menggunakan username dan password.');
        return redirect()->route('login');
    }


    // Login

    public function actionLogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 3) { // admin PPIC
                return redirect()->route('ppic.index');
            } else { // admin biasa / pekerja
                return redirect()->route('dashboard.index');
            }
        } else {
            Session::flash('error', 'Username atau Password Salah');
            return redirect('/');
        }
    }


    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        } else {
            return view('auth.login');
        }
    }

    public function actionLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
