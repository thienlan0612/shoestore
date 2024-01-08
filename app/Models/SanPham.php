<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;
    protected $table = 'SanPham';


    public function loaiSanPham()
    {
        return $this->belongsTo(LoaiSanPham::class, 'MaLoaiSanPham', 'MaLoaiSanPham');
    }

    public function thuongHieu()
    {
        return $this->belongsTo(ThuongHieu::class, 'MaThuongHieu', 'MaThuongHieu');
    }
}
