<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data=[
            ['kategori_kode' => 'ELEC', 'kategori_nama' => 'Electronics'],
            ['kategori_kode' => 'FOOD', 'kategori_nama' => 'Food'],
            ['kategori_kode' => 'CLOT', 'kategori_nama' => 'Clothing'],
            ['kategori_kode' => 'TOOL', 'kategori_nama' => 'Tools'],
            ['kategori_kode' => 'HOME', 'kategori_nama' => 'Home Appliances'],
        ];
        DB::table('m_kategori_')->insert($data);
    }
}
