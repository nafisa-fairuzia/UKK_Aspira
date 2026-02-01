<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Siswa;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DashboardSiswaController extends Controller
{
    public function index()
    {
        $nis = Session::get('nis');

        $siswa = Siswa::where('nis', $nis)->first();
        if ($siswa && $siswa->profile_pic) {
            Session::put('siswa_profile_pic', $siswa->profile_pic);
        }

        $total = InputAspirasi::where('nis', $nis)->count();

        $menunggu = InputAspirasi::where('nis', $nis)
            ->whereNull('status')
            ->orWhere('status', 'Menunggu')
            ->count();

        $proses = InputAspirasi::where('nis', $nis)
            ->where('status', 'Proses')
            ->count();

        $selesai = InputAspirasi::where('nis', $nis)
            ->where('status', 'Selesai')
            ->count();

        $terakhir = InputAspirasi::where('nis', $nis)
            ->latest()
            ->first();

        $riwayat = InputAspirasi::where('nis', $nis)
            ->with('kategori')
            ->latest()
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
        $nis = Session::get('nis');

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
                    'created_at' => $notif->created_at->diffForHumans(),
                ];
            });

        $unreadCount = Notifikasi::where('tipe', 'siswa')
            ->whereIn('id_pengaduan', $pengaduanIds)
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    public function markNotificationsRead()
    {
        $nis = Session::get('nis');
        $pengaduanIds = InputAspirasi::where('nis', $nis)->pluck('id_pelaporan');

        Notifikasi::where('tipe', 'siswa')
            ->whereIn('id_pengaduan', $pengaduanIds)
            ->unread()
            ->update(['dibaca' => true]);

        return redirect()->back()->with('success', 'Notifikasi telah ditandai sebagai dibaca');
    }

    public function markSingleNotificationRead($id)
    {
        $nis = Session::get('nis');
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
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $nis = Session::get('nis');
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = 'siswa_' . $nis . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');

            $siswa = Siswa::where('nis', $nis)->first();
            if ($siswa) {
                $siswa->update(['profile_pic' => $path]);
                Session::put('siswa_profile_pic', $path);
            }
        }

        return response()->json(['success' => true, 'message' => 'Foto profil berhasil diubah', 'path' => $path ?? null]);
    }

    public function deleteProfilePicture(Request $request)
    {
        $nis = Session::get('nis');
        $siswa = Siswa::where('nis', $nis)->first();
        if ($siswa && $siswa->profile_pic) {
            Storage::disk('public')->delete($siswa->profile_pic);
            $siswa->update(['profile_pic' => null]);
            Session::forget('siswa_profile_pic');
        }

        return response()->json(['success' => true, 'message' => 'Foto profil dihapus']);
    }
}
