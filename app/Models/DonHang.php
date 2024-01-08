<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;
    protected $table = 'DonHang'; 

    protected $primaryKey = 'MaDonHang'; 

    protected $fillable = [
        'MaDonHang',
        'DaThanhToan',
        'TinhTrangGiaoHang',
        'NgayDat',
        'NgayGiao',
        'TaiKhoan',
        'TongTien'
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'TaiKhoan', 'TaiKhoan');
    }

    public static function autoIncrement($khoa)
    {
        $lastCode = DonHang::max($khoa);

        if ($lastCode) {
            $lastNumber = (int)substr($lastCode, 2);
            $nextNumber = $lastNumber + 1;
            $nextCode = 'DH' . str_pad($nextNumber, 8, '0', STR_PAD_LEFT);
            return $nextCode;
        } else {
            return 'DH00000001';
        }
    }



}
