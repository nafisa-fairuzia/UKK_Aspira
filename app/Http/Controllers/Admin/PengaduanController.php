<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\Aspirasi;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Notification;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = InputAspirasi::with(['kategori', 'siswa', 'aspirasi'])
            ->where(function ($q) {
                $q->whereHas('aspirasi', function ($qa) {
                    $qa->whereIn('status', ['Menunggu', 'Proses', 'Selesai']);
                })->orWhereDoesntHave('aspirasi');
            })
            ->latest();

        if ($request->status) {
            if ($request->status === 'Menunggu') {
                $query->where(function ($q) use ($request) {
                    $q->whereDoesntHave('aspirasi')
                        ->orWhereHas('aspirasi', function ($qa) use ($request) {
                            $qa->where('status', $request->status);
                        });
                });
            } else {
                $query->whereHas('aspirasi', function ($qa) use ($request) {
                    $qa->where('status', $request->status);
                });
            }
        }

        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->siswa) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->siswa . '%')
                    ->orWhere('nis', 'like', '%' . $request->siswa . '%');
            });
        }

        if ($request->search) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }

        return view('admin.pengaduan.index', [
            'pengaduan' => $query->paginate(10)->appends($request->query()),
            'kategori'  => Kategori::all()
        ]);
    }

    public function show(InputAspirasi $pengaduan)
    {
        $pengaduan->load(['siswa', 'kategori']);
        $aspirasi = Aspirasi::where('id_input_aspirasi', $pengaduan->id_pelaporan)->first();
        return view('admin.pengaduan.show', compact('pengaduan', 'aspirasi'));
    }

    public function update(Request $request, InputAspirasi $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'tanggapan_admin' => 'nullable|string|max:1000',
        ]);

        $oldStatus = optional($pengaduan->aspirasi)->status ?? 'Menunggu';

        if ($oldStatus === 'Selesai') {
            return redirect()->back()->with('error', 'Tidak dapat mengubah status pengaduan yang sudah Selesai.');
        }

        if ($request->status === 'Menunggu' && $oldStatus !== 'Menunggu') {
            return redirect()->back()->with('error', 'Tidak dapat mengubah status kembali ke Menunggu.');
        }

        Aspirasi::updateOrCreate(
            ['id_input_aspirasi' => $pengaduan->id_pelaporan],
            [
                'status' => $request->status,
                'id_kategori' => $pengaduan->id_kategori,
                'feedback' => $request->tanggapan_admin,
            ]
        );

        if ($oldStatus !== $request->status) {
            Notifikasi::create([
                'judul' => 'Status Pengaduan Diperbarui',
                'pesan' => 'Status pengaduan Anda telah diperbarui menjadi: ' . $request->status,
                'url' => route('siswa.pengaduan.show', $pengaduan->id_pelaporan),
                'tipe' => 'siswa',
                'id_pengaduan' => $pengaduan->id_pelaporan,
            ]);
        }

        return redirect()->back()->with('success', 'Pengaduan berhasil diperbarui');
    }
}
