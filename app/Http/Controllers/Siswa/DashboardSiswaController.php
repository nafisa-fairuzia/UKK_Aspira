<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Siswa;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Storage;

class DashboardSiswaController extends Controller
{

    public function index()
    {
        $nis = session('nis');

        $siswa = Siswa::where('nis', $nis)->first();
        if ($siswa && $siswa->profile_pic) {
            session(['siswa_profile_pic' => $siswa->profile_pic]);
        }

        $total = InputAspirasi::where('nis', $nis)->count();

        $menunggu = InputAspirasi::where('nis', $nis)
            ->whereDoesntHave('aspirasi')
            ->count();

        $proses = InputAspirasi::where('nis', $nis)
            ->whereHas('aspirasi', function ($q) {
                $q->where('status', 'Proses');
            })
            ->count();

        $selesai = InputAspirasi::where('nis', $nis)
            ->whereHas('aspirasi', function ($q) {
                $q->where('status', 'Selesai');
            })
            ->count();

        $terakhir = InputAspirasi::where('nis', $nis)
            ->latest()
            ->first();

        $riwayat = InputAspirasi::where('input_aspirasi.nis', $nis)
            ->with(['kategori', 'aspirasi'])
            ->leftJoin('aspirasi', 'input_aspirasi.id_pelaporan', '=', 'aspirasi.id_input_aspirasi')
            ->select('input_aspirasi.*')
            ->orderByRaw("CASE
                WHEN aspirasi.status = 'Proses' THEN 2
                WHEN aspirasi.status = 'Selesai' THEN 3
                ELSE 1
            END")
            ->latest('input_aspirasi.created_at')
            ->take(5)
            ->get();

        $unreadNotifications = Notifikasi::forSiswa()
            ->unread()
            ->latest()
            ->take(10)
            ->get();

        return view('siswa.dashboard.index', compact(
            'total',
            'menunggu',
            'proses',
            'selesai',
            'terakhir',
            'riwayat',
            'unreadNotifications'
        ));
    }

    public function getNotifications()
    {
        $nis = session('nis');

        $pengaduanIds = InputAspirasi::where('nis', $nis)->pluck('id_pelaporan');

        $notifications = Notifikasi::where('tipe', 'siswa')
            ->whereIn('id_pengaduan', $pengaduanIds)
            ->with('pengaduan')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notif) {
                return [
                    'id' => $notif->id_notifikasi,
                    'judul' => $notif->judul,
                    'pesan' => $notif->pesan,
                    'url' => $notif->url,
                    'dibaca' => $notif->dibaca,
                    'created_at' => $notif->created_at->diffForHumans()
                ];
            });

        $unreadCount = Notifikasi::where('tipe', 'siswa')
            ->whereIn('id_pengaduan', $pengaduanIds)
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    public function markNotificationsRead()
    {
        $nis = session('nis');
        $pengaduanIds = InputAspirasi::where('nis', $nis)->pluck('id_pelaporan');

        Notifikasi::where('tipe', 'siswa')
            ->whereIn('id_pengaduan', $pengaduanIds)
            ->unread()
            ->update(['dibaca' => true]);

        return redirect()->back()->with('success', 'Notifikasi telah ditandai sebagai dibaca');
    }

    public function markSingleNotificationRead($id)
    {
        $nis = session('nis');
        $pengaduanIds = InputAspirasi::where('nis', $nis)->pluck('id_pelaporan');

        $notification = Notifikasi::where('tipe', 'siswa')
            ->whereIn('id_pengaduan', $pengaduanIds)
            ->findOrFail($id);

        $notification->update(['dibaca' => true]);

        $unreadCount = Notifikasi::where('tipe', 'siswa')
            ->whereIn('id_pengaduan', $pengaduanIds)
            ->unread()
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi telah ditandai sebagai dibaca',
            'unread_count' => $unreadCount
        ]);
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $nis = session('nis');

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = 'siswa_' . $nis . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');

            $siswa = Siswa::where('nis', $nis)->first();
            if ($siswa) {
                $siswa->update(['profile_pic' => $path]);
                session(['siswa_profile_pic' => $path]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diubah',
                'path' => $path
            ]);
        }

        return response()->json(['success' => false, 'message' => 'File tidak ditemukan'], 400);
    }

    public function deleteProfilePicture(Request $request)
    {
        $nis = session('nis');
        $siswa = Siswa::where('nis', $nis)->first();

        if ($siswa && $siswa->profile_pic) {
            Storage::disk('public')->delete($siswa->profile_pic);
            $siswa->update(['profile_pic' => null]);
            session()->forget('siswa_profile_pic');
        }

        return response()->json([
            'success' => true,
            'message' => 'Foto profil dihapus'
        ]);
    }
}
