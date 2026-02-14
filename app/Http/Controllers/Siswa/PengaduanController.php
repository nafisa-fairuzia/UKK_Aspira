<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\Aspirasi;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'lokasi' => 'required|string|max:50',
            'ket' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('aspirasi', 'public');
        }

        $pengaduan = InputAspirasi::create([
            'nis' => session('nis'),
            'id_kategori' => $request->id_kategori,
            'lokasi' => trim($request->lokasi),
            'ket' => substr(trim($request->ket), 0, 255),
            'gambar' => $gambar,
            'status' => 'Menunggu'
        ]);

        Notifikasi::create([
            'judul' => 'Pengaduan Baru',
            'pesan' => 'Ada pengaduan baru dari siswa yang perlu ditinjau',
            'url' => route('admin.pengaduan.show', $pengaduan->id_pelaporan),
            'tipe' => 'admin',
            'id_pengaduan' => $pengaduan->id_pelaporan
        ]);

        return redirect()->route('siswa.pengaduan.riwayat')
            ->with('success', 'Pengaduan berhasil dikirim');
    }

    public function riwayat()
    {
        $nis = session('nis');

        $totalPengaduan = InputAspirasi::where('nis', $nis)->count();

        $pengaduan = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('input_aspirasi.nis', $nis)
            ->leftJoin('aspirasi', 'input_aspirasi.id_pelaporan', '=', 'aspirasi.id_input_aspirasi')
            ->select('input_aspirasi.*')
            ->when(request('status'), function ($query) {
                if (request('status') === 'Menunggu') {
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
                return $query->whereMonth('input_aspirasi.created_at', request('bulan'));
            })
            ->when(request('tahun'), function ($query) {
                return $query->whereYear('input_aspirasi.created_at', request('tahun'));
            })
            ->orderByRaw("CASE
                WHEN aspirasi.status = 'Proses' THEN 2
                WHEN aspirasi.status = 'Selesai' THEN 3
                ELSE 1
            END")
            ->latest('input_aspirasi.created_at')
            ->paginate(6);

        return view('siswa.pengaduan.riwayat', compact('pengaduan', 'totalPengaduan'));
    }

    /**
     * Tampilkan daftar pengaduan dari siswa lain (mirip tampilan admin tapi read-only)
     * - Query efisien: eager load + where nis != current
     * - Dukung pencarian singkat dan filter status
     */
    public function others(Request $request)
    {
        $nis = session('nis');

        $query = InputAspirasi::with(['siswa.kelas', 'kategori', 'aspirasi'])
            ->where('input_aspirasi.nis', '!=', $nis)
            ->leftJoin('aspirasi', 'input_aspirasi.id_pelaporan', '=', 'aspirasi.id_input_aspirasi')
            ->select('input_aspirasi.*');

        if ($q = $request->query('q')) {
            $query->where(function ($qq) use ($q) {
                $qq->where('input_aspirasi.lokasi', 'like', "%{$q}%")
                    ->orWhere('input_aspirasi.ket', 'like', "%{$q}%")
                    ->orWhereHas('siswa', function ($s) use ($q) {
                        $s->where('nama', 'like', "%{$q}%");
                    });
            });
        }

        if ($status = $request->query('status')) {
            if ($status === 'Menunggu') {
                $query->where(function ($q2) {
                    $q2->whereDoesntHave('aspirasi')
                        ->orWhereHas('aspirasi', function ($qa) {
                            $qa->where('status', 'Menunggu');
                        });
                });
            } else {
                $query->whereHas('aspirasi', function ($qa) use ($status) {
                    $qa->where('status', $status);
                });
            }
        }

        $pengaduan = $query
            ->orderByRaw("CASE
                WHEN aspirasi.status = 'Proses' THEN 2
                WHEN aspirasi.status = 'Selesai' THEN 3
                ELSE 1
            END")
            ->latest('input_aspirasi.created_at')
            ->paginate(10);

        $filter = [
            'q' => $request->query('q'),
            'status' => $request->query('status')
        ];

        return view('siswa.pengaduan.lainnya', compact('pengaduan', 'filter'));
    }
    public function show(InputAspirasi $aspirasi)
    {

        if ($aspirasi->nis !== session('nis')) {
            abort(403);
        }

        $aspirasi->load(['siswa', 'kategori']);
        $aspirasiData = Aspirasi::where('id_input_aspirasi', $aspirasi->id_pelaporan)->first();
        $kategoris = Kategori::all();

        return view('siswa.pengaduan.show', compact('aspirasi', 'aspirasiData', 'kategoris'));
    }

    public function showPublic(InputAspirasi $aspirasi)
    {
        $aspirasi->load(['siswa', 'kategori']);
        $aspirasiData = Aspirasi::where('id_input_aspirasi', $aspirasi->id_pelaporan)->first();

        return view('siswa.pengaduan.show_public', compact('aspirasi', 'aspirasiData'));
    }

    public function update(Request $request, InputAspirasi $aspirasi)
    {

        if ($aspirasi->nis !== session('nis')) {
            abort(403);
        }

        $aspirasiData = Aspirasi::where('id_input_aspirasi', $aspirasi->id_pelaporan)->first();
        $hasFeedback = ($aspirasiData && !empty($aspirasiData->feedback));
        $currentStatus = $aspirasiData->status ?? 'Menunggu';

        if ($currentStatus === 'Selesai' || $currentStatus === 'Dibatalkan' || $hasFeedback) {
            return redirect()->back()
                ->with('error', 'Pengaduan yang sudah selesai, dibatalkan, atau sudah ditanggapi tidak dapat diedit');
        }

        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'lokasi' => 'required|string|max:50',
            'ket' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $gambar = $aspirasi->gambar;
        if ($request->hasFile('gambar')) {
            if ($aspirasi->gambar) {
                Storage::disk('public')->delete($aspirasi->gambar);
            }
            $gambar = $request->file('gambar')->store('aspirasi', 'public');
        }

        $aspirasi->update([
            'id_kategori' => $request->id_kategori,
            'lokasi' => trim($request->lokasi),
            'ket' => substr(trim($request->ket), 0, 255),
            'gambar' => $gambar
        ]);

        return redirect()->route('siswa.pengaduan.show', $aspirasi->id_pelaporan)
            ->with('success', 'Pengaduan berhasil diperbarui');
    }

    public function cancel(InputAspirasi $aspirasi)
    {

        if ($aspirasi->nis !== session('nis')) {
            abort(403);
        }

        $aspirasiData = Aspirasi::where('id_input_aspirasi', $aspirasi->id_pelaporan)->first();
        $hasFeedback = ($aspirasiData && !empty($aspirasiData->feedback));
        $currentStatus = $aspirasiData->status ?? 'Menunggu';

        if ($currentStatus === 'Selesai' || $hasFeedback) {
            return redirect()->route('siswa.pengaduan.riwayat')
                ->with('error', 'Pengaduan yang sudah selesai atau sudah ditanggapi tidak dapat dibatalkan');
        }

        if ($aspirasi->gambar) {
            Storage::disk('public')->delete($aspirasi->gambar);
        }

        $aspirasi->delete();

        return redirect()->route('siswa.pengaduan.riwayat')
            ->with('success', 'Pengaduan berhasil dibatalkan');
    }

    public function editForm(InputAspirasi $aspirasi)
    {

        if ($aspirasi->nis !== session('nis')) {
            abort(403);
        }

        $aspirasiData = Aspirasi::where('id_input_aspirasi', $aspirasi->id_pelaporan)->first();
        $hasFeedback = ($aspirasiData && !empty($aspirasiData->feedback));
        $currentStatus = $aspirasiData->status ?? 'Menunggu';

        if ($currentStatus === 'Selesai' || $hasFeedback) {
            return redirect()->route('siswa.pengaduan.riwayat')
                ->with('error', 'Pengaduan yang sudah selesai atau sudah ditanggapi tidak dapat diedit');
        }

        $aspirasi->load(['kategori']);
        $kategori = Kategori::all();

        return view('siswa.pengaduan.edit', compact('aspirasi', 'kategori'));
    }
}
