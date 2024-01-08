<?php

namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ChiTietDonHang;
use App\Models\KichThuocSanPham;
use App\Models\SanPham;
use App\Models\ChiTietKichThuocSanPham;
use App\Models\DonHang;


class ChiTietDonHangController extends Controller
{
        public function addToCart(Request $request)
        {
            $productId = $request->input('productId');
            $productName = $request->input('productName');
            $productPrice = $request->input('productPrice');

            if (!$request->session()->has('cart')) {
                $request->session()->put('cart', []);
            }

            if (!$request->session()->has('cartCount')) {
                $request->session()->put('cartCount', 1);
            }

            $cart = $request->session()->get('cart');

            if (!isset($cart[$productId])) {
                $cart[$productId] = [
                    'productName' => $productName,
                    'productPrice' => $productPrice,
                    'pquantity' => 1 
                ];
            } else {
                $cart[$productId]['pquantity']++;
            }

            $request->session()->put('cart', $cart);

            $cartCount = count($cart);
            $request->session()->put('cartCount', $cartCount);

            return response()->json(['cartCount' => $cartCount]);;
        }

    public function viewCart(Request $request)
    {
        if (!session()->has('TaiKhoan')) {
            return redirect()->route('login'); 
        }
        $cart = $request->session()->get('cart', []);

        foreach ($cart as $productId => $product) {
            if (!isset($product['pquantity'])) {
                $cart[$productId]['pquantity'] = 1; 
            }

            if (!isset($product['productImage'])) {
                $image = $this->getProductImage($productId); 
                $cart[$productId]['productImage'] = $image;
            }

            if (!isset($product['productSize'])) {
                $sizes = $this->getSizesForProduct($productId);
                $cart[$productId]['sizes'] = $sizes->toArray(); 
            }

            if (isset($product['selectedSize'])) {
                $quantityForSize = $this->getQuantityForSize($productId, $product['selectedSize']);
                $cart[$productId]['quantityForSize'] = $quantityForSize;
            }
        }

        $request->session()->put('cart', $cart);

        return view('chitietdonhang', [
            'cart' => $cart,
            'getQuantityForSize' => [$this, 'getQuantityForSize'],
            
        ]);
    }


    public function clearCartSession(Request $request)
    {
        $request->session()->forget('cart');
        $request->session()->forget('cartCount');

        return response()->json(['message' => 'Session giỏ hàng đã được xóa']);
    }

    public function thanhToan(Request $request)
    {
        $taiKhoan = session('TaiKhoan');
        $nguoiDung = DB::table('NguoiDung')
            ->select('HoTen', 'DiaChi', 'DienThoai')
            ->where('TaiKhoan', $taiKhoan)
            ->first();

        $totalAmount = $request->input('totalAmount');

        return view('thanhtoan', compact('nguoiDung','totalAmount'));
    }



    public function removeFromCart(Request $request)
    {
        $productId = $request->input('productId');

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($cart[$productId]['pquantity'] > 0) {
                $cart[$productId]['pquantity']--;
            }

            // Cập nhật giá trị trong session
            $request->session()->put('cart', $cart);

            return response()->json(['message' => 'Đã xóa sản phẩm khỏi giỏ hàng và giảm số lượng']);
        }

        return response()->json(['message' => 'Sản phẩm không tồn tại trong giỏ hàng']);
    }

    public function updateUserInfo(Request $request)
    {
        $TaiKhoan = $request->session()->get('TaiKhoan');

        $HoTen = $request->input('HoTen');
        $DiaChi = $request->input('DiaChi');
        $DienThoai = $request->input('DienThoai');

        if (!empty($HoTen)) {
            DB::table('NguoiDung')
                ->where('TaiKhoan', $TaiKhoan)
                ->update([
                    'HoTen' => $HoTen,
                    'DiaChi' => $DiaChi,
                    'DienThoai' => $DienThoai,
                ]);    
        }

 
        return response()->json(['message' => 'Cập nhật thông tin thành công']);


    }

    public function getSizesForProduct($productId)
    {
        $sizes = KichThuocSanPham::join('ChiTietKichThuocSanPham', 'ChiTietKichThuocSanPham.MaKichThuoc', '=', 'KichThuocSanPham.MaKichThuoc')
        ->where('ChiTietKichThuocSanPham.MaSanPham', $productId)
        ->where('ChiTietKichThuocSanPham.SoLuong', '>', 0)
        ->pluck('KichThuocSanPham.TenKichThuoc');
        //phương thức pluck được dùng để lấy ra 1 mảng tên kích thước
        
        return $sizes;
    }


    public function saveCartToSession(Request $request)
    {
        $cartData = $request->input('cartData');
        session()->put('cartBill', $cartData);

        return response()->json(['success' => true]);
    }

    public function saveBill(Request $request)
    {
        $hoTen = $request->input('HoTenNguoiNhan');
        $diaChi = $request->input('DiaChiNguoiNhan');
        $dienThoai = $request->input('DienThoaiNguoiNhan');
        $totalAmount = $request->input('totalAmount');
        $maDonHang = DonHang::autoIncrement('MaDonHang');
        $taiKhoan = session('TaiKhoan');


        DB::table('DonHang')->insert([
            'MaDonHang' => $maDonHang,
            'DaThanhToan' => 0,
            'TinhTrangGiaoHang' => 0,
            'NgayDat' => now(),
            'NgayGiao' => NULL,
            'TaiKhoan' => $taiKhoan,
            'TongTien' => $totalAmount,
            'HoTenNguoiNhan' => $hoTen,
            'DienThoaiNguoiNhan' => $dienThoai,
            'DiaChiNguoiNhan' => $diaChi,
        ]);

        $cartData = json_decode($_POST['cartData'], true);
        foreach ($cartData as $item) {
            $tenKichThuoc = $item['TenKichThuoc'];
            $maKichThuoc = KichThuocSanPham::where('TenKichThuoc', $tenKichThuoc)->value('MaKichThuoc');
            DB::table('ChiTietDonHang')->insert([
                'MaSanPham' => $item['MaSanPham'],
                'MaDonHang' => $maDonHang, 
                'MaKichThuoc' => $maKichThuoc,
                'SoLuong' => $item['SoLuong'],
                'DonGia' => $item['DonGia'],
            ]);
        }


        $mail = new PHPMailer(true);

        $userInfo = DB::table('NguoiDung')
            ->select('Email', 'HoTen')
            ->where('TaiKhoan', $taiKhoan)
            ->first(); 
        
        $emailND = $userInfo->Email;
        $hoTenND = $userInfo->HoTen;

        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username   = 'lan.pnt.62cntt@ntu.edu.vn';   
            $mail->Password   = '06122002';       
            $mail->SMTPSecure = 'tls'; 
            $mail->Port = 587; 
            $mail->setFrom('lan.pnt.62cntt@ntu.edu.vn', 'Thiên Lân Shoe Store');
            $mail->addAddress( $emailND, $hoTenND);
            $mail->isHTML(true);
            $mail->Subject = 'Subject of Email';

            $emailContent = "Thông tin người nhận: <br>";
            $emailContent .= "Họ tên: $hoTen <br>";
            $emailContent .= "Địa chỉ: $diaChi <br><br>";

            $emailContent .= "Chi tiết đơn hàng: <br>";
            foreach ($cartData as $item) {
                $maSanPham = $item['MaSanPham'];
                $tenSanPham = DB::table('SanPham')
                    ->where('MaSanPham', $maSanPham)
                    ->value('TenSanPham');
                $size = $item['TenKichThuoc'];
                $soLuong = $item['SoLuong'];
                $donGia = $item['DonGia'];
                $thanhTien = $soLuong * $donGia;
            
                $emailContent .= "Tên sản phẩm: $tenSanPham <br>";
                $emailContent .= "Kích thước: $size - Số lượng: $soLuong - Đơn giá: $donGia đ - Thành tiền: $thanhTien đ    <br><br>";
            }
            $emailContent .= "Tổng tiền đơn hàng: $totalAmount <br><br>";
            $mail->Body = $emailContent;

            $mail->send();

            $this->clearCartSession($request);
            return redirect()->route('home')->with('success', 'Email đã được gửi thành công.');
        } catch (Exception $e) {
            $this->clearCartSession($request);
            return redirect()->route('home')->with('error', "Đã xảy ra lỗi.");
        }
        


    }


    public function getQuantityForSize(Request $request)
    {
        $productId = $request->input('productId');
        $size = $request->input('size');
        $quantity = ChiTietKichThuocSanPham::whereHas('kichThuocSanPham', function ($query) use ($productId, $size) {
            $query->where('TenKichThuoc', $size)
                ->where('MaSanPham', $productId);
        })
        ->value('SoLuong');

    return response()->json(['quantity' => $quantity]);
    }



    public function getProductImage($productId)
    {
        
        $productImage = SanPham::where('MaSanPham', $productId)
        ->value('AnhDaiDien');

        return $productImage ?? null;
    }

    

    public function logout(Request $request)
    {
        $request->session()->forget('cart');
        $request->session()->flush();

        return redirect()->route('home');
    }
}
