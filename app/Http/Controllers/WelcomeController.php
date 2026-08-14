<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\UserModel;
use App\Models\PenjualanModel;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Home', 'Dashboard'],
        ];

        $activeMenu = 'dashboard';

        $totalBarang = BarangModel::count();
        $totalKategori = KategoriModel::count();
        $totalUser = UserModel::count();
        $totalPenjualan = PenjualanModel::count();

        return view('welcome', compact('breadcrumb', 'activeMenu', 'totalBarang', 'totalKategori', 'totalUser', 'totalPenjualan'));
    }
}
