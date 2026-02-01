<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengaduanController extends Controller
{
    public function create()
    {
        $kategori = Kategori::all();
        return view('siswa.pengaduan.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'lokasi'      => 'required|string|max:50',
            'ket'         => 'required|string|max:255',
            'gambar'      => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('aspirasi', 'public');
        }

        $aspirasi = InputAspirasi::create([
            'nis'         => Session::get('nis'),
            'id_kategori' => $request->id_kategori,
            'lokasi'      => trim($request->lokasi),
            'ket'         => substr(trim($request->ket), 0, 255),
            'gambar'      => $gambar,
            'status'      => 'Menunggu',
        ]);

        Notifikasi::create([
            'judul' => 'Pengaduan Baru',
            'pesan' => 'Ada pengaduan baru dari siswa yang perlu ditinjau',
            'url' => route('admin.pengaduan.show', $aspirasi->id_pelaporan),
            'tipe' => 'admin',
            'id_pengaduan' => $aspirasi->id_pelaporan,
        ]);

        return redirect()->route('siswa.pengaduan.riwayat')
            ->with('success', 'Pengaduan berhasil dikirim');
    }

    public function riwayat()
    {
        $nis = Session::get('nis');

        $totalPengaduan = InputAspirasi::where('nis', $nis)->count();

        $pengaduan = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('nis', $nis)
            ->when(request('status'), function ($query) {
                if (request('status') == 'Menunggu') {
                    return $query->where(function ($q) {
                        $q->whereDoesntHave('aspirasi')
                            ->orWhereHas('aspirasi', function ($qa) {
                                $qa->where('status', 'Menunggu');
                            });
                    });
                }
                return $query->whereHas('aspirasi', function ($qa) {
                    $qa->where('status', request('status'));
                });
            })
            ->when(request('bulan'), function ($query) {
                return $query->whereMonth('created_at', request('bulan'));
            })
            ->when(request('tahun'), function ($query) {
                return $query->whereYear('created_at', request('tahun'));
            })
            ->latest()
            ->paginate(6);

        return view('siswa.pengaduan.riwayat', compact('pengaduan', 'totalPengaduan'));
    }

    public function show(InputAspirasi $aspirasi)
    {
        if ($aspirasi->nis !== Session::get('nis')) {
            abort(403);
        }

        $aspirasi->load(['siswa', 'kategori']);
        $aspirasiData = \App\Models\Aspirasi::where('id_input_aspirasi', $aspirasi->id_pelaporan)->first();
        $kategoris = Kategori::all();

        return view('siswa.pengaduan.show', compact('aspirasi', 'aspirasiData', 'kategoris'));
    }

    public function update(Request $request, InputAspirasi $aspirasi)
    {
        if ($aspirasi->nis !== Session::get('nis')) {
            abort(403);
        }

        $aspirasiData = \App\Models\Aspirasi::where('id_input_aspirasi', $aspirasi->id_pelaporan)->first();
        $hasFeedback = ($aspirasiData && !empty($aspirasiData->feedback));
        $currentStatus = $aspirasiData->status ?? 'Menunggu';

        if ($currentStatus == 'Selesai' || $currentStatus == 'Dibatalkan' || $hasFeedback) {
            return redirect()->back()->with('error', 'Pengaduan yang sudah selesai, dibatalkan, atau sudah ditanggapi tidak dapat diedit');
        }

        $request->validate([
            'id_kategori' => 'required',
            'lokasi'      => 'required|string|max:50',
            'ket'         => 'required|string|max:255',
            'gambar'      => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $gambar = $aspirasi->gambar;
        if ($request->hasFile('gambar')) {
            if ($aspirasi->gambar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($aspirasi->gambar);
            }
            $gambar = $request->file('gambar')->store('aspirasi', 'public');
        }

        $aspirasi->update([
            'id_kategori' => $request->id_kategori,
            'lokasi'      => trim($request->lokasi),
            'ket'         => substr(trim($request->ket), 0, 255),
            'gambar'      => $gambar,
        ]);

        return redirect()->route('siswa.pengaduan.show', $aspirasi->id_pelaporan)->with('success', 'Pengaduan berhasil diperbarui');
    }

    public function cancel(InputAspirasi $aspirasi)
    {
        if ($aspirasi->nis !== Session::get('nis')) {
            abort(403);
        }

        $aspirasiData = \App\Models\Aspirasi::where('id_input_aspirasi', $aspirasi->id_pelaporan)->first();
        $hasFeedback = ($aspirasiData && !empty($aspirasiData->feedback));

        $currentStatus = $aspirasiData->status ?? 'Menunggu';

        if ($currentStatus == 'Selesai' || $hasFeedback) {
            return redirect()->route('siswa.pengaduan.riwayat')->with('error', 'Pengaduan yang sudah selesai atau sudah ditanggapi tidak dapat dibatalkan');
        }

        if ($aspirasi->gambar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($aspirasi->gambar);
        }

        $aspirasi->delete();

        return redirect()->route('siswa.pengaduan.riwayat')->with('success', 'Pengaduan berhasil dibatalkan');
    }

    public function editForm(InputAspirasi $aspirasi)
    {
        if ($aspirasi->nis !== Session::get('nis')) {
            abort(403);
        }

        $aspirasiData = \App\Models\Aspirasi::where('id_input_aspirasi', $aspirasi->id_pelaporan)->first();
        $hasFeedback = ($aspirasiData && !empty($aspirasiData->feedback));

        $currentStatus = $aspirasiData->status ?? 'Menunggu';

        if ($currentStatus == 'Selesai' || $hasFeedback) {
            return redirect()->route('siswa.pengaduan.riwayat')->with('error', 'Pengaduan yang sudah selesai atau sudah ditanggapi tidak dapat diedit');
        }

        $aspirasi->load(['kategori']);
        $kategori = Kategori::all();

        return view('siswa.pengaduan.edit', compact('aspirasi', 'kategori'));
    }
}
