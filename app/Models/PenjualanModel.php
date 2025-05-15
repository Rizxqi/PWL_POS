<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenjualanModel extends Model
{
    use HasFactory;
    protected $table = "t_penjualan";
    protected $primaryKey = "penjualan_id";
    protected $fillable = ['user_id', 'pembeli', 'penjualan_kode', 'penjualan_Tanggal'];

    public function detail_penjualan(): HasMany
    {
        return $this->hasMany(DetailPenjualanModel::class, 'detail_id', 'detail_id');
    }
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }
}
