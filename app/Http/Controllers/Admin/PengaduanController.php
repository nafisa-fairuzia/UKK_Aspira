<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\Aspirasi;
use App\Models\Notifikasi;
use App\Exports\PengaduanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
            ->leftJoin('aspirasi', 'input_aspirasi.id_pelaporan', '=', 'aspirasi.id_input_aspirasi')
            ->select('input_aspirasi.*');

        if ($request->filled('status')) {
            if ($request->status === 'Menunggu') {
                $query->where(function ($q) {
                    $q->whereDoesntHave('aspirasi')
                        ->orWhereHas('aspirasi', function ($qa) {
                            $qa->where('status', 'Menunggu');
                        });
                });
            } else {
                $query->whereHas('aspirasi', function ($qa) use ($request) {
                    $qa->where('status', $request->status);
                });
            }
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('siswa')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->siswa . '%')
                    ->orWhere('nis', 'like', '%' . $request->siswa . '%');
            });
        }

        if ($request->filled('search')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        $query->orderByRaw("CASE
                WHEN aspirasi.status = 'Proses' THEN 2
                WHEN aspirasi.status = 'Selesai' THEN 3
                ELSE 1
            END")
            ->latest('input_aspirasi.created_at');

        $pengaduan = $query->paginate(10)->appends($request->query());
        $kategori = Kategori::all();

        return view('admin.pengaduan.index', compact('pengaduan', 'kategori'));
    }

    public function show(InputAspirasi $pengaduan)
    {
        $pengaduan->load(['siswa', 'kategori', 'aspirasi']);
        $currentStatus = $pengaduan->aspirasi->status ?? 'Menunggu';

        return view('admin.pengaduan.show', compact('pengaduan', 'currentStatus'));
    }

    public function update(Request $request, InputAspirasi $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'tanggapan_admin' => 'nullable|string|max:1000'
        ]);

        $pengaduan->load('aspirasi');
        $oldStatus = $pengaduan->aspirasi->status ?? 'Menunggu';

        if ($oldStatus === 'Selesai') {
            return redirect()->back()->with('error', 'Tidak dapat mengubah status pengaduan yang sudah Selesai');
        }

        if ($request->status === 'Menunggu' && $oldStatus !== 'Menunggu') {
            return redirect()->back()->with('error', 'Tidak dapat mengubah status kembali ke Menunggu');
        }

        try {

            $aspirasi = Aspirasi::updateOrCreate(
                ['id_input_aspirasi' => $pengaduan->id_pelaporan],
                [
                    'status' => $request->status,
                    'id_kategori' => $pengaduan->id_kategori,
                    'feedback' => $request->tanggapan_admin,
                    'updated_at' => now()
                ]
            );

            if ($oldStatus !== $request->status) {
                Notifikasi::create([
                    'judul' => 'Status Pengaduan Diperbarui',
                    'pesan' => 'Status pengaduan Anda telah diperbarui menjadi: ' . $request->status,
                    'url' => route('siswa.pengaduan.show', $pengaduan->id_pelaporan),
                    'tipe' => 'siswa',
                    'id_pengaduan' => $pengaduan->id_pelaporan
                ]);
            }

            return redirect()->back()->with('success', 'Pengaduan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui pengaduan: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $fileName = 'Daftar-Pengaduan-' . now()->format('d-m-Y-His') . '.xlsx';
        return Excel::download(new PengaduanExport($request), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $query = InputAspirasi::with(['kategori', 'siswa', 'aspirasi'])
            ->where(function ($q) {
                $q->whereHas('aspirasi', function ($qa) {
                    $qa->whereIn('status', ['Menunggu', 'Proses', 'Selesai']);
                })->orWhereDoesntHave('aspirasi');
            })
            ->leftJoin('aspirasi', 'input_aspirasi.id_pelaporan', '=', 'aspirasi.id_input_aspirasi')
            ->select('input_aspirasi.*');

        if ($request->filled('status')) {
            if ($request->status === 'Menunggu') {
                $query->where(function ($q) {
                    $q->whereDoesntHave('aspirasi')
                        ->orWhereHas('aspirasi', function ($qa) {
                            $qa->where('status', 'Menunggu');
                        });
                });
            } else {
                $query->whereHas('aspirasi', function ($qa) use ($request) {
                    $qa->where('status', $request->status);
                });
            }
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('siswa')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->siswa . '%')
                    ->orWhere('nis', 'like', '%' . $request->siswa . '%');
            });
        }

        if ($request->filled('search')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        $query->orderByRaw("CASE
                WHEN aspirasi.status = 'Proses' THEN 2
                WHEN aspirasi.status = 'Selesai' THEN 3
                ELSE 1
            END")
            ->latest('input_aspirasi.created_at');

        $pengaduan = $query->get();
        $kategori = Kategori::all();
        $status = $request->status ?? null;

        $pdf = Pdf::loadView('admin.pengaduan.pdf', compact('pengaduan', 'kategori', 'status'))
            ->setPaper('a4', 'landscape');

        $fileName = 'Daftar-Pengaduan-' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
    }
}
