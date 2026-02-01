<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Admin;
use App\Models\Notifikasi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {

        $total = InputAspirasi::where('status', '!=', 'Dibatalkan')->count();
        $pending = InputAspirasi::where('status', 'Menunggu')->count();
        $diproses = InputAspirasi::where('status', 'Proses')->count();
        $selesai = InputAspirasi::where('status', 'Selesai')->count();

        
        $pengaduan = InputAspirasi::with(['siswa', 'kategori'])
            ->where('status', '!=', 'Dibatalkan')
            ->latest()
            ->take(3)
            ->get();

        $kategori_stats = Kategori::withCount('inputAspirasi')->get();

        $notifications = Notifikasi::forAdmin()
            ->with('pengaduan.siswa')
            ->latest()
            ->take(5)
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

        return view('admin.dashboard.index', compact(
            'total',
            'pending',
            'diproses',
            'selesai',
            'pengaduan',
            'kategori_stats',
            'notifications'
        ));
    }

    public function getNotifications()
    {
        $notifications = Notifikasi::forAdmin()
            ->with('pengaduan.siswa')
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

        $unreadCount = Notifikasi::forAdmin()->unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    public function markSingleNotificationRead($id)
    {
        $notification = Notifikasi::forAdmin()->findOrFail($id);
        $notification->update(['dibaca' => true]);

        $unreadCount = Notifikasi::forAdmin()->unread()->count();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi telah ditandai sebagai dibaca',
            'unread_count' => $unreadCount
        ]);
    }

    public function markNotificationsRead()
    {
        Notifikasi::forAdmin()->unread()->update(['dibaca' => true]);
        return response()->json(['success' => true, 'message' => 'Semua notifikasi ditandai sebagai dibaca']);
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = 'admin_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');

            Session::put('profile_pic', $path);
        }

        return response()->json(['success' => true, 'message' => 'Foto profil berhasil diubah', 'path' => $path ?? null]);
    }

    public function deleteProfilePicture(Request $request)
    {
        $path = Session::get('profile_pic');
        if ($path) {
            Storage::disk('public')->delete($path);
            Session::forget('profile_pic');
        }

        return response()->json(['success' => true, 'message' => 'Foto profil dihapus']);
    }
}
