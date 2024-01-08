<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SanPham;

class PumaProductsController extends Controller
{
    public function index()
    {
        $giayProducts = $this->getProductsByCategoryAndBrand('Giày', 'Puma');
        $tatProducts = $this->getProductsByCategoryAndBrand('Tất', 'Puma');
        
        return view('puma_products', compact('giayProducts', 'tatProducts'));
    }

    private function getProductsByCategoryAndBrand($category, $brand)
    {
        return SanPham::query()
            ->join('ThuongHieu', 'SanPham.MaThuongHieu', '=', 'ThuongHieu.MaThuongHieu')
            ->join('LoaiSanPham', 'SanPham.MaLoaiSanPham', '=', 'LoaiSanPham.MaLoaiSanPham')
            ->select(
                'SanPham.MaSanPham',
                'SanPham.TenSanPham',
                'SanPham.AnhDaiDien',
                'SanPham.MoTa',
                'SanPham.GiaBan'
            )
            ->where('ThuongHieu.TenThuongHieu', $brand)
            ->where('LoaiSanPham.TenLoaiSanPham', $category)
            ->get();
    }
}
