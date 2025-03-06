<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('t_stok')->insert([
                'barang_id' => $i,
                'user_id' => 1, // Sesuaikan dengan user yang ada
                'stok_tanggal' => now(),
                'stok_jumlah' => rand(10, 100),
            ]);
        }
    }
}
