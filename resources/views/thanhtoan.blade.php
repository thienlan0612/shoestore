@extends('layouts.layout')

@section('content')


<div class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md bg-white shadow-md rounded-md p-8 space-y-6">
        <h1 class="text-3xl font-semibold mb-6 text-center">Thanh toán</h1>
        <div class="flex justify-center items-center">
            <button class="bg-transparent border-0" data-bs-toggle="modal" data-bs-target="#editModal">
                <i class="fas fa-edit text-blue-500 cursor-pointer text-2xl"></i>
            </button>
        </div>
        @if(session('message'))
            <div id="message" class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <form action="/saveBill" method="POST">
            @csrf 
            @php
                $cartData = session('cartBill');
            @endphp

            @if($cartData)
                <input type="hidden" name="cartData" value='@json($cartData)'>
                <table style="display: block;">
                    <thead>
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên kích thước</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartData as $item)
                            <tr>
                                <td>{{ $item['MaSanPham'] }}</td>
                                <td>{{ $item['TenKichThuoc'] }}</td>
                                <td>{{ $item['SoLuong'] }}</td>
                                <td>{{ $item['DonGia'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <table class="w-full mb-6">
                <tbody>
                    <tr>
                        <td class="font-semibold text-gray-600 text-lg mr-3">Họ và tên:</td>
                        <td class="text-lg" id="name"><input type="text" name="HoTenNguoiNhan" value="{{ $nguoiDung->HoTen }}"></td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 text-lg mr-3">Địa chỉ:</td>
                        <td class="text-lg" id="address"><input type="text" name="DiaChiNguoiNhan" value="{{ $nguoiDung->DiaChi }}"></td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 text-lg mr-6">Điện thoại:</td>
                        <td class="text-lg" id="phone"><input type="text" name="DienThoaiNguoiNhan" value="{{ $nguoiDung->DienThoai }}"></td>
                    </tr>
                </tbody>
            </table>
            
            
            
            <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">

            <div class="flex items-center justify-left">
                <h2 id="totalBill" class="text-xl font-semibold mr-3">Tổng tiền:</h2>
                <p class="text-xl">{{ $totalAmount }} đ</p>
            </div>

            <div class="flex justify-center">
                <button type="submit" id="payButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300 ease-in-out">Thanh toán</button>
            </div>
        </form>

        
    </div>
</div>

<form action="/chitietdonhang" method="POST">
    {{ csrf_field() }}  
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 33%;">
                                <label for="HoTen">Họ và tên:</label>
                            </td>
                            <td colspan="2" style="width: 66%;">
                                <input type="text" id="HoTen" name="HoTen" value="{{ $nguoiDung->HoTen }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 33%;">
                                <label for="DiaChi">Địa chỉ:</label>
                            </td>
                            <td colspan="2" style="width: 66%;">
                                <input type="text" id="DiaChi" name="DiaChi" value="{{ $nguoiDung->DiaChi }}">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 33%;">
                                <label for="DienThoai">Điện thoại:</label>
                            </td>
                            <td colspan="2" style="width: 66%;">
                                <input type="text" id="DienThoai" name="DienThoai" value="{{ $nguoiDung->DienThoai }}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center;">
                                <button type="submit" id="updateButton" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 transition duration-300 ease-in-out mt-3">Cập nhật</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const updateButton = document.querySelector('#updateButton');

        updateButton.addEventListener('click', function () {
            const fullName = document.querySelector('#fullName').value;
            const address = document.querySelector('#address').value;
            const phoneNumber = document.querySelector('#phoneNumber').value;
            

            fetch('/updateUserInfo', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({
                    fullName: fullName,
                    address: address,
                    phoneNumber: phoneNumber,
                }),
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('.name').innerText = data.updatedHoTen;
                document.querySelector('.address').innerText = data.updatedDiaChi;
                document.querySelector('.phone').innerText = data.updatedDienThoai;
            })
            .catch(error => {
                console.error('Lỗi khi cập nhật dữ liệu:', error);
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var messageElement = document.getElementById('message');
        
        if (messageElement) {
            setTimeout(function() {
                messageElement.style.display = 'none';
            }, 5000); 
        }
    });
</script>
    





