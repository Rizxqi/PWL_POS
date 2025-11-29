<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\DetailPenjualanModel;
use App\Models\BarangModel;
use Illuminate\Support\Facades\DB;
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
        $totalTransaksi = PenjualanModel::count();
        $penjualan = PenjualanModel::all();
        $activeMenu = 'transaksi';

        return view('transaksi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'totalTransaksi' => $totalTransaksi,
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
                $btn = '<button onclick="modalAction(\'' . url('/transaksi/' . $row->detail_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi/' . $row->detail_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi/' . $row->detail_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $barang = BarangModel::select('barang_id', 'barang_nama', 'harga_jual')->get(); // misal ada
        return view('transaksi.create_ajax')->with('barang', $barang);
    }

    public function store_ajax(Request $request)
    {

        if ($request->ajax()) {
            $rules = [
                'user_id' => 'required|integer',
                'pembeli' => 'required|string',
                'penjualan_kode' => 'required|string',
                'penjualan_tanggal' => 'required|date',
                'barang_id' => 'required|array',
                'harga' => 'required|array',
                'jumlah' => 'required|array',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $formattedDate = date('Y-m-d H:i:s', strtotime($request->penjualan_tanggal));

                DB::statement('CALL simpan_penjualan_detail(?, ?, ?, ?, ?, ?, ?)', [
                    $request->penjualan_kode,             // kode (VARCHAR)
                    $request->pembeli,                    // nama_pembeli (VARCHAR)
                    $formattedDate,                       // tanggal (DATETIME)
                    $request->user_id,                    // uid (INT)
                    json_encode($request->barang_id),     // barang_json (JSON)
                    json_encode($request->harga),         // harga_json (JSON)
                    json_encode($request->jumlah),        // jumlah_json (JSON)
                ]);


                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function show($id)
    {

        $transaksi = PenjualanModel::with(['user', 'detail.barang'])->find($id);

        return view('transaksi.show_ajax', compact('transaksi'));
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

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required|numeric|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $detail = DetailPenjualanModel::find($id);
            if (!$detail) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $detail->jumlah = $request->jumlah;
            $detail->harga = $request->harga;
            $detail->save();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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
