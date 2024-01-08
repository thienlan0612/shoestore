<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KichThuocSanPham extends Model
{
    use HasFactory;
    protected $table = 'KichThuocSanPham'; 
    protected $primaryKey = 'MaKichThuoc'; 
    public $incrementing = false;

    public function chiTietKichThuocSanPhams()
    {
        return $this->hasMany(ChiTietKichThuocSanPham::class, 'MaKichThuoc', 'MaKichThuoc');
    }
}

