<!-- Trong file resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-image {
            background-image: url('logo.png') !important;
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center bg-image">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h1 class="text-3xl font-semibold mb-6 text-center">Đăng nhập</h1>
            
            @if(session('error'))
                <p class="text-red-500 mb-4">{{ session('error') }}</p>
            @endif
            
            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="mb-4">
                    <label for="TaiKhoan" class="block mb-2">Tài khoản:</label>
                    <input type="text" id="TaiKhoan" name="TaiKhoan" class="w-full border rounded py-2 px-3" value="{{ Cookie::get('taiKhoan') ?: '' }}" required>
                </div>

                <div class="mb-6">
                    <label for="MatKhau" class="block mb-2">Mật khẩu:</label>
                    <input type="password" id="MatKhau" name="MatKhau" class="w-full border rounded py-2 px-3" value="{{ Cookie::get('matKhau') ?: '' }}" required>
                </div>

                <div class="mb-6">
                    <input type="checkbox" id="rememberMe" name="rememberMe">
                    <label for="rememberMe" class="ml-2">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Đăng nhập</button>
            </form>

            <div class="text-center mt-5">
                <a href="{{ route('register') }}" class="text-blue-500 underline">Bạn chưa có tài khoản?</a>
            </div>
        </div>
    </div>
</body>
</html>
