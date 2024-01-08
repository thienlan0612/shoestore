<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model
{
    use HasFactory;
    protected $table = 'NguoiDung'; 
    protected $primaryKey = 'TaiKhoan'; 
    public $timestamps = false;

    protected $fillable = [
        'TaiKhoan', 'HoTen', 'MatKhau', 'Email', 'DiaChi', 'DienThoai', 'GioiTinh', 'NgaySinh', 'RoleID','XacThuc'
    ];
}
