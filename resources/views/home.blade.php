@extends('layouts.layout')

@section('content')
    
    <div class="grid md:grid-cols-3 gap-8 p-4 sm:p-8">
        <div class="md:block sm:hidden">
            <h2 class="text-center text-2xl font-semibold mb-4">Nike Products</h2>
            <div class="grid gap-4">
                @foreach($nikeProducts as $index => $product)
                    <div class="card-container flex h-full">
                        <div class="rounded-lg overflow-hidden shadow-md bg-white card flex flex-col">
                            <img class="w-full h-64 object-cover" src="{{ asset('images/' . $product->AnhDaiDien) }}" alt="{{ $product->TenSanPham }}">
                            <div class="p-4 h-60">
                                <h3 class="text-lg font-semibold mb-2">{{ $product->TenSanPham }}</h3>
                                <p class="text-gray-600">{{ $product->MoTa }}</p>
                                <p class=" text-red-500 mt-2">Giá:  {{ $product->GiaBan }}đ</p>
                                <p class="text-gray-600 mt-2">Số lượt yêu thích:  {{ $product->totalLikes }}</p>
                                <button class="absolute top-2 right-2 bg-gray-200 rounded-full p-2 add-to-cart" onclick="addToCart('{{ $product->MaSanPham }}', '{{ $product->TenSanPham }}', '{{ $product->GiaBan }}', this)">
                                    <i class="fa-solid fa-cart-plus text-gray-500 text-lg"></i>
                                </button>    
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="md:block sm:hidden">
            <h2 class="text-center text-2xl font-semibold mb-4">Adidas Products</h2>
            <div class="grid gap-4">
                @foreach($adidasProducts as $index => $product)
                    <div class="card-container flex h-full">
                        <div class="rounded-lg overflow-hidden shadow-md bg-white card flex flex-col">
                            <img class="w-full h-64 object-cover" src="{{ asset('images/' . $product->AnhDaiDien) }}" alt="{{ $product->TenSanPham }}">
                            <div class="p-4 h-60">
                                <h3 class="text-lg font-semibold mb-2">{{ $product->TenSanPham }}</h3>
                                <p class="text-gray-600">{{ $product->MoTa }}</p>
                                <p class=" text-red-500 mt-2">Giá:  {{ $product->GiaBan }}đ</p>
                                <p class="text-gray-600 mt-2">Số lượt yêu thích: {{ $product->totalLikes }}</p>
                                <button class="absolute top-2 right-2 bg-gray-200 rounded-full p-2 add-to-cart" onclick="addToCart('{{ $product->MaSanPham }}', '{{ $product->TenSanPham }}', '{{ $product->GiaBan }}', this)">
                                    <i class="fa-solid fa-cart-plus text-gray-500 text-lg"></i>
                                </button>    
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="md:block sm:hidden">
            <h2 class="text-center text-2xl font-semibold mb-4">Puma Products</h2>
            <div class="grid gap-4">
                @foreach($pumaProducts as $index => $product)
                    <div class="card-container flex h-full">
                        <div class="rounded-lg overflow-hidden shadow-md bg-white card flex flex-col">
                            <img class="w-full h-64 object-cover" src="{{ asset('images/' . $product->AnhDaiDien) }}" alt="{{ $product->TenSanPham }}">
                            <div class="p-4 h-60">
                                <h3 class="text-lg font-semibold mb-2">{{ $product->TenSanPham }}</h3>
                                <p class="text-gray-600">{{ $product->MoTa }}</p>
                                <p class=" text-red-500 mt-2">Giá:  {{ $product->GiaBan }}đ</p>
                                <p class="text-gray-600 mt-2">Số lượt yêu thích:  {{ $product->totalLikes }}</p>
                                <button class="absolute top-2 right-2 bg-gray-200 rounded-full p-2 add-to-cart" onclick="addToCart('{{ $product->MaSanPham }}', '{{ $product->TenSanPham }}', '{{ $product->GiaBan }}', this)">
                                    <i class="fa-solid fa-cart-plus text-gray-500 text-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>


@endsection
