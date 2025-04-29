<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object)[
            'title' => 'Daftar kategori yang telah terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::all();

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'kategori' => $kategori]);
    }

    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        if ($request->kategori_id) {
            $kategori->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($kategori)
            // Tambahkan index untuk nomor urut
            ->addIndexColumn()

            // Tambahkan kolom aksi (Detail, Edit, Hapus)
            ->addColumn('action', function ($kategori) {
                $btn  = '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })

            // Memberitahu bahwa kolom action berisi HTML
            ->rawColumns(['action'])

            ->make(true);
    }

    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    // Simpan data Level via AJAX
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|max:20|unique:m_kategori,kategori_kode',
                'kategori_nama' => 'required|string|max:20',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            KategoriModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data Level berhasil disimpan'
            ]);
        }
    }

    // Tampilkan detail kategori
    public function show_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);

        return view('kategori.show_ajax', ['kategori' => $kategori]);
    }

    // Tampilkan form edit kategori
    public function edit_ajax($id)
    {
        $kategori = KategoriModel::find($id);

        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    // Update data kategori
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|max:20|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
                'kategori_nama' => 'required|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data kategori berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/kategori');
    }

    // Konfirmasi hapus kategori
    public function confirm_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    // Hapus data kategori
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data kategori berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/kategori');
    }
}
