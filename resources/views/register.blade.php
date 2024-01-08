<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center h-120">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h1 class="text-3xl font-semibold mb-6 text-center">Đăng ký</h1>
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="TaiKhoan" class="block mb-2 font-semibold">Tài khoản:</label>
                    <input type="text" id="TaiKhoan" name="TaiKhoan" class="w-full border rounded py-2 px-3" required>
                </div>
                <div>
                    <label for="HoTen" class="block mb-2 font-semibold">Họ và tên:</label>
                    <input type="text" id="HoTen" name="HoTen" class="w-full border rounded py-2 px-3" required>
                </div>
                <div>
                    <label for="MatKhau" class="block mb-2 font-semibold">Mật khẩu:</label>
                    <input type="password" id="MatKhau" name="MatKhau" class="w-full border rounded py-2 px-3" required>
                </div>
                <div>
                    <label for="NhapLaiMatKhau" class="block mb-2 font-semibold">Nhập lại mật khẩu:</label>
                    <input type="password" id="NhapLaiMatKhau" name="NhapLaiMatKhau" class="w-full border rounded py-2 px-3" required>
                    <p id="error-message" class="text-red-500 hidden">Mật khẩu không khớp.</p>
                </div>
                <div>
                    <label for="Email" class="block mb-2 font-semibold">Email:</label>
                    <input type="email" id="Email" name="Email" class="w-full border rounded py-2 px-3" required>
                </div>
                <div>
                    <label for="DiaChi" class="block mb-2 font-semibold">Địa chỉ:</label>
                    <input type="text" id="DiaChi" name="DiaChi" class="w-full border rounded py-2 px-3" required>
                </div>
                <div>
                    <label for="DienThoai" class="block mb-2 font-semibold">Điện thoại:</label>
                    <input type="tel" id="DienThoai" name="DienThoai" class="w-full border rounded py-2 px-3" required>
                </div>
                <div>
                    <label for="GioiTinh" class="block mb-2 font-semibold">Giới tính:</label>
                    <select id="GioiTinh" name="GioiTinh" class="w-full border rounded py-2 px-3" required>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>
                </div>
                <div>
                    <label for="NgaySinh" class="block mb-2 font-semibold">Ngày sinh:</label>
                    <input type="date" id="NgaySinh" name="NgaySinh" class="w-full border rounded py-2 px-3" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Đăng ký</button>
            </form>
        </div>
    </div>

</body>
</html>