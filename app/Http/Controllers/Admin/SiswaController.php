<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\InputAspirasi;
use Illuminate\Http\Request;

class SiswaController extends Controller
{

    public function index()
    {

        $siswa = Siswa::with('kelas')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|min:1|max:10|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'id_kelas' => 'required|exists:kelas,id',
            'username' => 'required|string|max:50|unique:siswa,username',
            'password' => 'required|string|min:6'
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->id_kelas,
            'username' => $request->username,
            'password' => $request->password
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        $request->validate([
            'nis' => 'required|min:1|max:10|unique:siswa,nis,' . $nis . ',nis',
            'nama' => 'required|string|max:255',
            'id_kelas' => 'required|exists:kelas,id',
            'username' => 'required|string|max:50|unique:siswa,username,' . $siswa->nis . ',nis',
            'password' => 'nullable|string|min:6'
        ]);

        if ($request->nis !== $nis) {
            $hasPengaduan = InputAspirasi::where('nis', $nis)->exists();
            if ($hasPengaduan) {
                return back()->with('error', 'Tidak dapat mengubah NIS siswa yang sudah memiliki pengaduan/aspirasi');
            }
        }

        $data = [
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->id_kelas,
            'username' => $request->username,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }

    public function checkNis(Request $request)
    {
        $request->validate([
            'nis' => 'required|string'
        ]);

        $exists = Siswa::where('nis', $request->nis)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function checkUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string'
        ]);

        $exists = Siswa::where('username', $request->username)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }
}
