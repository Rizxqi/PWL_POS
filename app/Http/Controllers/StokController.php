<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Faker\Core\Barcode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Monolog\Level;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object)[
            'title' => 'Daftar stok yang telah terdaftar dalam sistem'
        ];

        $activeMenu = 'stok';

        $barang = BarangModel::all();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'barang' => $barang]);
    }

    public function list(Request $request)
    {
        $stok = StokModel::select('stok_id', 'stok_tanggal', 'stok_jumlah', 'barang_id')->with('barang');

        if ($request->barang_id) {
            $stok->where('barang_id', $request->barang_id);
        }

        return DataTables::of($stok)
            // Tambahkan index untuk nomor urut
            ->addIndexColumn()

            // Tambahkan kolom aksi (Detail, Edit, Hapus)
            ->addColumn('action', function ($stok) { // menambahkan kolom aksi
                /* $btn = '<a href="'.url('/stok/' . $stok->stok_id).'" class="btn btn-info btn- sm">Detail</a> ';
             $btn .= '<a href="'.url('/stok/' . $stok->stok_id . '/edit').'" class="btn btn- warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/stok/'.$stok-
                >stok_id).'">'
                . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';*/
                $btn  = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })


            // Memberitahu bahwa kolom action berisi HTML
            ->rawColumns(['action'])

            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah user',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $barang = BarangModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; // set menu yang sedang aktif 

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail User'
        ];

        $activeMenu = 'user';

        $level = BarangModel::all();
        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([

            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data berhasil disimpan');
    }

    /**
     * edit.
     */
    public function edit(string $id)
    {
        $user = StokModel::find($id);
        $level = BarangModel::all();
        $breadcrumb = [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit User'
        ];

        $activeMenu = 'user';

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer',
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id,
        ]);

        return redirect('/user')->with('success', 'Data user berhasil dirubah');
    }

    public function destroy(string $id)
    {
        $check = StokModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];
    
        $page = (object) [
            'title' => 'Tambah Stok Baru'
        ];
    
        $barang = BarangModel::select('barang_id', 'barang_nama')->get(); // ambil daftar barang
        $activeMenu = 'stok'; // aktifkan menu stok
    
        return view('stok.create_ajax', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }    

    public function get_current_stock(Request $request)
    {
        $barangId = $request->barang_id;

        $stok = Stok::where('barang_id', $barangId)
                    ->latest('stok_tanggal')
                    ->first();

        if ($stok) {
            return response()->json([
                'status' => true,
                'current_stock' => $stok->stok_jumlah
            ]);
        } else {
            return response()->json([
                'status' => false,
                'current_stock' => 0
            ]);
        }
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|numeric|min:1'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Simpan data
            StokModel::create([
                'barang_id' => $request->barang_id,
                'user_id' => 1,
                'stok_tanggal' => $request->stok_tanggal,
                'stok_jumlah' => $request->stok_jumlah,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan'
            ]);
        }
    }

    public function show_ajax(string $id)
    {
        $stok = StokModel::with('barang')->find($id);
    
        if (!$stok) {
            return view('stok.show_ajax')->with('stok', null);
        }
    
        return view('stok.show_ajax', ['stok' => $stok]);
    }
    

    // menampilkan halaman form edit user ajax
    public function edit_ajax($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();

        return view('stok.edit_ajax', ['stok' => $stok, 'barang' => $barang]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|numeric|min:1'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $stok = StokModel::find($id);

            if ($stok) {
                $stok->update([
                    'barang_id'     => $request->barang_id,
                    'stok_tanggal'  => $request->stok_tanggal,
                    'stok_jumlah'   => $request->stok_jumlah,
                ]);

                return response()->json([
                    'status'  => true,
                    'message' => 'Data stok berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data stok tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $stok = StokModel::find($id);

        return view('stok.confirm_ajax', ['stok' => $stok]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' =>   'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/stok');
    }
}
