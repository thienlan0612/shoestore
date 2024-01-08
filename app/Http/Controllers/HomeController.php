<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SanPham;
class HomeController extends Controller
{
    public function index(){
        $nikeProducts = $this->getMostLikedProductsByBrand('Nike');
        $adidasProducts = $this->getMostLikedProductsByBrand('Adidas');
        $pumaProducts = $this->getMostLikedProductsByBrand('Puma');
        
        return view('home', [
            'nikeProducts' => $nikeProducts,
            'adidasProducts' => $adidasProducts,
            'pumaProducts' => $pumaProducts
        ]);
    }

    private function getMostLikedProductsByBrand($brand){
        $products = SanPham::query()
                    ->join('ThuongHieu', 'SanPham.MaThuongHieu', '=', 'ThuongHieu.MaThuongHieu')
                    ->join('SanPhamYeuThich', 'SanPham.MaSanPham', '=', 'SanPhamYeuThich.MaSanPham')
                    ->join('LoaiSanPham', 'SanPham.MaLoaiSanPham', '=','LoaiSanPham.MaLoaiSanPham' )
                    ->select('SanPham.MaSanPham', 'SanPham.TenSanPham', 'SanPham.AnhDaiDien', 'SanPham.MoTa','SanPham.GiaBan', DB::raw('COUNT(SanPhamYeuThich.MaSanPham) as totalLikes'))
                    ->where('ThuongHieu.TenThuongHieu', $brand)
                    ->where('LoaiSanPham.TenLoaiSanPham', 'Giày')
                    ->groupBy('SanPham.MaSanPham', 'SanPham.TenSanPham', 'SanPham.AnhDaiDien', 'SanPham.MoTa','SanPham.GiaBan') 
                    ->orderByDesc('totalLikes') 
                    ->limit(3)
                    ->get();
    
        return $products;
    }
}