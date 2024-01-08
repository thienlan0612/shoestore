<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h1 class="text-2xl font-semibold mb-4">Xác nhận đăng ký</h1>
            <form method="POST" action="{{ route('verify') }}">
                @csrf
                <div class="mb-4">
                    <label for="maXacNhan" class="block mb-2">Nhập mã xác nhận:</label>
                    <input type="text" id="maXacNhan" name="maXacNhan" class="w-full border rounded py-2 px-3" required >
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Xác nhận</button>
            </form>
            
            @if(isset($error))
                <div class="text-red-500 mt-2">{{ $error }}</div>
            @endif
        </div>
    </div>
</body>
</html>