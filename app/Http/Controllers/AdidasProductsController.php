<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SanPham;

class AdidasProductsController extends Controller
{
    public function index()
    {
        $giayProducts = $this->getProductsByCategoryAndBrand('Giày', 'Adidas');
        $tatProducts = $this->getProductsByCategoryAndBrand('Tất', 'Adidas');
        
        return view('adidas_products', compact('giayProducts', 'tatProducts'));
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
