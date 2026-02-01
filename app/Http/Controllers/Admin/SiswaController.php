<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kategori;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::paginate(10);
        return view('admin.siswa.index', compact('siswa'));
    }


    public function create()
    {
        $kategori = Kategori::all();

        return view('admin.siswa.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'      => 'required|min:1|max:10|unique:siswa,nis',
            'nama'     => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        Siswa::create([
            'nis'      => $request->nis,
            'nama'     => $request->nama,
            'kelas_id' => $request->kelas_id,
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
        $request->validate([
            'nis'      => 'required|min:1|max:10|unique:siswa,nis,' . $nis . ',nis',
            'nama'     => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        $hasPengaduan = \App\Models\InputAspirasi::where('nis', $nis)->exists();

        if ($request->nis !== $nis && $hasPengaduan) {
            return back()->with('error', 'Tidak dapat mengubah NIS siswa yang sudah memiliki pengaduan/aspirasi.');
        }

        $siswa->update([
            'nis'      => $request->nis,
            'nama'     => $request->nama,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy($nis)
    {
        Siswa::where('nis', $nis)->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}
