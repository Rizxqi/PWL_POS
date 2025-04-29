<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\DetailPenjualanModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Transaksi',
            'list' => ['Home', 'Transaksi']
        ];

        $page = (object) [
            'title' => 'Daftar transaksi yang terdaftar dalam sistem'
        ];

        $penjualan = PenjualanModel::all();
        $activeMenu = 'transaksi';

        return view('transaksi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $query = DetailPenjualanModel::with('penjualan', 'barang');

        if ($request->filled('penjualan')) {
            $query->where('penjualan_id', $request->penjualan);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn  = '<button onclick="modalAction(\'' . url('/transaksi/' . $row->detail_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi/' . $row->detail_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi/' . $row->detail_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $detail = DetailPenjualanModel::with('penjualan', 'barang')->find($id);

        if (!$detail) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return view('transaksi.show_ajax', ['detail' => $detail]);
    }

    public function edit_ajax(string $id)
    {
        $detail = DetailPenjualanModel::with('barang')->find($id);

        if (!$detail) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return view('transaksi.edit_ajax', ['detail' => $detail]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jumlah' => 'required|integer|min:1',
                'harga_satuan' => 'required|integer|min:0'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $detail = DetailPenjualanModel::find($id);

            if ($detail) {
                $detail->update([
                    'jumlah' => $request->jumlah,
                    'harga_satuan' => $request->harga_satuan
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $detail = DetailPenjualanModel::find($id);

        return view('transaksi.confirm_ajax', ['detail' => $detail]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $detail = DetailPenjualanModel::find($id);

            if ($detail) {
                try {
                    $detail->delete();

                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data gagal dihapus karena terkait dengan data lain.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }
}
