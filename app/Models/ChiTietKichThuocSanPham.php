<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietKichThuocSanPham extends Model
{
    use HasFactory;
    protected $table = 'ChiTietKichThuocSanPham'; 
    protected $primaryKey = ['MaSanPham', 'MaKichThuoc'];
    public $incrementing = false;

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSanPham', 'MaSanPham');
    }

    public function kichThuocSanPham()
    {
        return $this->belongsTo(KichThuocSanPham::class, 'MaKichThuoc', 'MaKichThuoc');
    }
}
