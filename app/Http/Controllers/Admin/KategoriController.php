<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{

    public function index()
    {
        $kategori = Kategori::withCount(['inputAspirasi as laporan_count'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ket_kategori' => 'required|string|max:255|unique:kategori,ket_kategori'
        ]);

        Kategori::create([
            'ket_kategori' => $request->ket_kategori
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::where('id_kategori', $id)->firstOrFail();
        return response()->json($kategori);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ket_kategori' => 'required|string|max:255|unique:kategori,ket_kategori,' . $id . ',id_kategori'
        ]);

        $kategori = Kategori::where('id_kategori', $id)->firstOrFail();
        $kategori->update([
            'ket_kategori' => $request->ket_kategori
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kategori = Kategori::where('id_kategori', $id)->firstOrFail();
        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }

    public function checkDuplicate(Request $request)
    {
        $request->validate([
            'ket_kategori' => 'required|string'
        ]);

        $exists = Kategori::where('ket_kategori', $request->ket_kategori)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }
}
