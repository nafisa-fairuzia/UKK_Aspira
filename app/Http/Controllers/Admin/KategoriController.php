<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount(['inputAspirasi as laporan_count'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ket_kategori' => 'required'
        ]);

        try {
            Kategori::create($request->all());
            return back()->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ket_kategori' => 'required'
        ]);

        Kategori::where('id_kategori', $id)
            ->update(['ket_kategori' => $request->ket_kategori]);

        return back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        Kategori::where('id_kategori', $id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
