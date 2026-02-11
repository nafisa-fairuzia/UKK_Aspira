<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\Admin;
use App\Models\Kelas;

class AuthController extends Controller
{
    public function showLogin()
    {
        $all_kelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('auth.login', compact('all_kelas'));
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = Admin::where('username', $request->username)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            Session::put('login', true);
            Session::put('role', 'admin');
            Session::put('admin_id', $admin->id);
            Session::put('nama', $admin->nama);
            Session::put('profile_pic', $admin->profile_pic ?? null);

            return redirect('/admin/dashboard');
        }

        $siswa = Siswa::where('username', $request->username)->first();
        if ($siswa && Hash::check($request->password, $siswa->password)) {
            Session::put('login', true);
            Session::put('role', 'siswa');
            Session::put('siswa_id', $siswa->nis);
            Session::put('nis', $siswa->nis);
            Session::put('nama', $siswa->nama);
            Session::put('kelas_id', $siswa->id_kelas ?? null);

            return redirect('/siswa/dashboard');
        }

        return back()->with('error', 'Username atau Password salah');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }

    public function searchKelas(Request $request)
    {
        $search = $request->query('q', '');

        try {
            $kelas = Kelas::where('nama_kelas', 'like', "%$search%")
                ->orderBy('nama_kelas', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'text' => $item->nama_kelas
                    ];
                });

            return response()->json([
                'results' => $kelas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'results' => []
            ]);
        }
    }
}
