<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\NguoiDung;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\1-2023-2024\ShoeStore\vendor\autoload.php';


class NguoiDungController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function showVerifyForm(Request $request)
    {
        $email = session('email');
        $maXacNhan = session('maXacNhan');

        return view('verify')->with('email', $email)->with('maXacNhan', $maXacNhan);
    }



    public function login(Request $request)
    {
        $taiKhoan = $request->input('TaiKhoan');
        $matKhau = $request->input('MatKhau');

        $nguoiDung = NguoiDung::where('TaiKhoan', $taiKhoan)->first();

        if ($nguoiDung && $nguoiDung->MatKhau === $matKhau) {
            // Kiểm tra xem checkbox 
            if ($request->has('rememberMe')) {
                session(['TaiKhoan' => $taiKhoan]);
                
                $cookieTaiKhoan = cookie('taiKhoan', $taiKhoan, 5 * 365 * 24 * 60);
                $cookieMatKhau = cookie('matKhau', $matKhau, 5 * 365 * 24 * 60);

                // Tạo response và thêm cookie vào response
                $response = redirect()->intended('/');
                $response->withCookie($cookie);
                $response->withCookie($cookie_matKhau);

                return $response;
            }

            session(['TaiKhoan' => $taiKhoan]);

            return redirect()->route('home');
        }

        return redirect()->route('login')->with('error', 'Đăng nhập không thành công');
    }

    public function register(Request $request)
    {
        $taiKhoan = $request->input('TaiKhoan');
        $hoTen = $request->input('HoTen');
        $matKhau = $request->input('MatKhau');
        $email = $request->input('Email');
        $diaChi = $request->input('DiaChi');
        $dienThoai = $request->input('DienThoai');
        if ($request->input('GioiTinh') === 'Nam') {
            $gioiTinh = 0; 
        } elseif ($request->input('GioiTinh') === 'Nữ') {
            $gioiTinh = 1; 
        }
        $ngaySinh = $request->input('NgaySinh');

        $xacThuc = 'chuaxacthuc';
        $mail = new PHPMailer(true);
        $maXacNhan = mt_rand(100000, 999999);
    
        NguoiDung::create([
            'TaiKhoan' => $taiKhoan,
            'HoTen' => $hoTen,
            'MatKhau' => $matKhau,
            'Email' => $email,
            'DiaChi' => $diaChi,
            'DienThoai' => $dienThoai,
            'GioiTinh' => $gioiTinh,
            'NgaySinh' => $ngaySinh,
            'XacThuc' => $xacThuc,
        ]);

        try {
            $mail->SMTPDebug = 0;                     
            $mail->isSMTP();                          
            $mail->Host       = 'smtp.gmail.com';    
            $mail->SMTPAuth   = true;                 
            $mail->Username   = 'lan.pnt.62cntt@ntu.edu.vn';   
            $mail->Password   = '06122002';       
            $mail->SMTPSecure = 'tls';                
            $mail->Port       = 587;                 

            $mail->setFrom('lan.pnt.62cntt@ntu.edu.vn', 'Thiên Lân');
            $mail->addAddress($email, $hoTen);        

            $mail->isHTML(true);                      
            $mail->Subject = 'Ma xac nhan';
            $mail->Body    = 'Chào ' . $hoTen . ',<br>Đây là mã xác nhận của bạn! '.$maXacNhan.'';

            $mail->send();
            echo 'Email đã được gửi đi';
        } catch (Exception $e) {
            echo "Lỗi khi gửi email: {$mail->ErrorInfo}";
        }

        session(['email' => $email, 'maXacNhan' => $maXacNhan]);    
        return redirect()->route('verify', ['email' => $email, 'xacThuc' => $maXacNhan]);
    }

    


    public function verify(Request $request)
    {
        $email = session('email');
        $maXacNhanInput = (int)$request->input('maXacNhan'); 
        $maXacNhanSession = (int)session('maXacNhan'); 


        if ($maXacNhanInput === $maXacNhanSession) {
            NguoiDung::where('Email', $email)->update(['XacThuc' => 'daxacthuc']);
            return redirect()->route('login');
        }

        return view('verify', ['error' => 'Mã xác nhận không đúng']);
    }


    public function logout()
    {
        session()->flush();
        return redirect()->route('home');
    }
}
