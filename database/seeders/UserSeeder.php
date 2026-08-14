<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 56,
                'level_id' =>1,
                'username' => 'adming',
                'nama'     => 'Administrator',
                'password' =>  Hash::make('password134'),
                'image'    => 'default.png',
            ],
        ];
        DB::table('m_user')->insert($data);
    }
}
