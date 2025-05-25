<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = PenjualanModel::all(); // Ambil semua data produk
        $activeMenu = 'dashboard';
        return view('home', compact('products'));
    }
}
