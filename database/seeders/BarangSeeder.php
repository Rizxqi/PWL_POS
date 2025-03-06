<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class barangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
                ['barang_id' =>1,'kategori_id' => 1, 'barang_kode' => 'TV001', 'barang_nama' => 'Televisi', 'harga_beli' => 2000000, 'harga_jual' => 2500000],
                ['barang_id' =>2,'kategori_id' => 1, 'barang_kode' => 'HP001', 'barang_nama' => 'Handphone', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
                ['barang_id' =>3, 'kategori_id' => 2, 'barang_kode' => 'MEJA01', 'barang_nama' => 'Meja', 'harga_beli' => 500000, 'harga_jual' => 700000],
                ['barang_id' =>4,'kategori_id' => 2, 'barang_kode' => 'KURSI01', 'barang_nama' => 'Kursi', 'harga_beli' => 300000, 'harga_jual' => 500000],
                ['barang_id' =>5,'kategori_id' => 3, 'barang_kode' => 'NASG01', 'barang_nama' => 'Nasi Goreng', 'harga_beli' => 15000, 'harga_jual' => 20000],
                ['barang_id' =>6,'kategori_id' => 3, 'barang_kode' => 'MIEG01', 'barang_nama' => 'Mie Goreng', 'harga_beli' => 12000, 'harga_jual' => 18000],
                ['barang_id' =>7,'kategori_id' => 4, 'barang_kode' => 'KAOS01', 'barang_nama' => 'Kaos Polos', 'harga_beli' => 40000, 'harga_jual' => 60000],
                ['barang_id' =>8,'kategori_id' => 4, 'barang_kode' => 'CELANA01', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 150000, 'harga_jual' => 200000],
                ['barang_id' =>9,'kategori_id' => 5, 'barang_kode' => 'OBENG01', 'barang_nama' => 'Obeng', 'harga_beli' => 10000, 'harga_jual' => 20000],
                ['barang_id' =>10,'kategori_id' => 5, 'barang_kode' => 'PALU01', 'barang_nama' => 'Palu', 'harga_beli' => 30000, 'harga_jual' => 50000],
        ];
        DB::table('m_barang')->insert($data);
    }
}
