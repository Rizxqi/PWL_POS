<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::with('level')->get();
        return view('user',['data'=>$user]);
        // $user = UserModel::all();
        // return view('user', ['data' => $user]);
    }

    public function tambah()
    {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }

    public function ubah($id)
    {
        // $user = UserModel::find($id);

        // // if (!$user) {
        // //     return redirect('/user')->with('error', 'User tidak ditemukan');
        // // }
        // // $user = User::find($id);
        // return view('user_ubah', ['data' => $user]);

        // Fetch the user by ID
        $user = UserModel::find($id);

        // Check if the user exists
        if (!$user) {
            return redirect()->route('/user')->with('error', 'User not found');
        }

        // Pass the user data to the view
        return view('user_ubah', ['data' => $user]);

    }

    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::find($id);
    
        // if (!$user) {
        //     return redirect('/user')->with('error', 'User tidak ditemukan');
        // }
    
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->level_id = $request->level_id;
    
        $user->save();
        return redirect('/user')->with('success', 'User berhasil diperbarui');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
}
