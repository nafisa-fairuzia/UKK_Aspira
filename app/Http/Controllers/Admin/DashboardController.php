<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Notifikasi;
use App\Models\Kategori;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $total = InputAspirasi::where('status', '!=', 'Dibatalkan')->count();

        $menunggu = InputAspirasi::whereDoesntHave('aspirasi')->count();
        $proses = InputAspirasi::whereHas('aspirasi', function ($q) {
            $q->where('status', 'Proses');
        })->count();
        $selesai = InputAspirasi::whereHas('aspirasi', function ($q) {
            $q->where('status', 'Selesai');
        })->count();

        $pengaduan = InputAspirasi::with(['siswa', 'kategori', 'aspirasi'])
            ->where('input_aspirasi.status', '!=', 'Dibatalkan')
            ->leftJoin('aspirasi', 'input_aspirasi.id_pelaporan', '=', 'aspirasi.id_input_aspirasi')
            ->select('input_aspirasi.*')
            ->orderByRaw("CASE
                WHEN aspirasi.status = 'Proses' THEN 2
                WHEN aspirasi.status = 'Selesai' THEN 3
                ELSE 1
            END")
            ->latest('input_aspirasi.created_at')
            ->take(3)
            ->get();

        $kategori_stats = Kategori::withCount('inputAspirasi')->get();

        $start = now()->startOfDay()->subDays(6);
        $end = now()->endOfDay();

        $countsByDate = InputAspirasi::selectRaw('DATE(created_at) as date, COUNT(*) as cnt')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', '!=', 'Dibatalkan')
            ->groupByRaw('DATE(created_at)')
            ->pluck('cnt', 'date')
            ->toArray();

        $chart_labels = [];
        $chart_data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $label = $date->isoFormat('ddd');
            $key = $date->toDateString();
            $chart_labels[] = $label;
            $chart_data[] = isset($countsByDate[$key]) ? (int) $countsByDate[$key] : 0;
        }

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
                    'created_at' => $notif->created_at->diffForHumans()
                ];
            });

        return view('admin.dashboard.index', compact(
            'total',
            'menunggu',
            'proses',
            'selesai',
            'pengaduan',
            'kategori_stats',
            'notifications',
            'chart_labels',
            'chart_data'
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
                    'created_at' => $notif->created_at->diffForHumans()
                ];
            });

        $unreadCount = Notifikasi::forAdmin()->unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
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

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai dibaca'
        ]);
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = 'admin_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');

            $adminId = session('admin_id');
            if ($adminId) {
                $admin = Admin::find($adminId);
                if ($admin) {

                    if ($admin->profile_pic && Storage::disk('public')->exists($admin->profile_pic)) {
                        Storage::disk('public')->delete($admin->profile_pic);
                    }

                    $admin->update(['profile_pic' => $path]);

                    session(['profile_pic' => $path]);
                }
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
        $adminId = session('admin_id');
        if ($adminId) {
            $admin = Admin::find($adminId);
            if ($admin && $admin->profile_pic) {
                if (Storage::disk('public')->exists($admin->profile_pic)) {
                    Storage::disk('public')->delete($admin->profile_pic);
                }

                $admin->update(['profile_pic' => null]);
            }
        }

        session()->forget('profile_pic');

        return response()->json([
            'success' => true,
            'message' => 'Foto profil dihapus'
        ]);
    }

    public function deleteAccount(Request $request)
    {
        /** @var Admin $admin */
        $admin = Auth::user();

        if ($admin->profile_pic) {
            Storage::disk('public')->delete($admin->profile_pic);
        }

        $admin->delete();

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dihapus',
            'redirect' => route('login')
        ]);
    }
}
