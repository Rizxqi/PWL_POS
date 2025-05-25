<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserModel;

class ProfileController extends Controller
{
    // Tampilkan profil user yang sedang login
    public function index()
    {
        // Ambil user yang sedang login
        $user = UserModel::findOrFail(Auth::id());

        $page = (object) ['title' => 'Profil User'];

        return view('profile.index', compact('user', 'page'))->with('activeMenu', 'profile');
    }

    // Tampilkan profil user berdasarkan id (jika diperlukan)
    public function showProfile($id)
    {
        $user = UserModel::findOrFail($id);
        $page = (object) ['title' => 'Profil User'];

        return view('user.profile', compact('user', 'page'));
    }

    // Update profil user yang sedang login
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $user = UserModel::findOrFail(Auth::id());
        $user->nama = $request->nama;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Update foto profil user yang sedang login
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = UserModel::findOrFail(Auth::id());

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '.' . $foto->getClientOriginalExtension();

            // Simpan file ke folder storage/app/public/uploads/foto
            $foto->storeAs('public/uploads/foto', $filename);

            // Simpan nama file di database
            $user->foto = $filename;
            $user->save();
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}
