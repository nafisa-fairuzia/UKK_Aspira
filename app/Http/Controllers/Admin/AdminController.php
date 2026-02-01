<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%');
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());

        return view('admin.admins.index', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin,username',
            'password' => 'required|string|min:6',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['nama', 'username']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile_pictures', 'public');
            $data['profile_pic'] = $path;
        }

        Admin::create($data);
        return back()->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return response()->json($admin);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin,username,' . $admin->id,
            'password' => 'nullable|string|min:6',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $admin->nama = $request->nama;
        $admin->username = $request->username;
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_pic')) {
            if ($admin->profile_pic) {
                Storage::disk('public')->delete($admin->profile_pic);
            }
            $path = $request->file('profile_pic')->store('profile_pictures', 'public');
            $admin->profile_pic = $path;
        }

        $admin->save();
        return back()->with('success', 'Admin berhasil diperbarui');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        if (Auth::id() === $admin->id) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri');
        }
        if ($admin->profile_pic) {
            Storage::disk('public')->delete($admin->profile_pic);
        }
        $admin->delete();
        return back()->with('success', 'Admin berhasil dihapus');
    }
}
