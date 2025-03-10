<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(){
        // $data =[
        //     'kategori_kode' => 'SNK',
        //     'kategori_nama' => 'Snack/Makanan Ringan',
        //     'created_at' => now(),
        // ];
        // DB::table('m_kategori')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama'=>'Camilan']);
        // return 'Update data baru berhasil. Jumlah data yang di Update: ' .$row.'baris';
       
        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
        // return 'Delete data baru berhasil. Jumlah data yang di Delete: ' .$row.'baris';

        $data = DB::table('m_kategori')->get();
        return view('kategori', ['data'=>$data]);
    }
}
