@extends('layouts.layout')

@section('content')
    <h1 class="text-center text-3xl text-purple-500">Giày Puma</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-4 sm:p-8">
        @foreach($giayProducts as $product)
            <div class="card-container">
                <div class="rounded-lg overflow-hidden shadow-md bg-white card flex flex-col sm:flex sm:flex-col">
                    <img class="w-full  h-64 object-cover" src="{{ asset('images/' . $product->AnhDaiDien) }}" alt="{{ $product->TenSanPham }}">
                    <div class="p-4 h-60">
                        <h3 class="text-lg font-semibold mb-2">{{ $product->TenSanPham }}</h3>
                        <p class="text-gray-600">{{ $product->MoTa }}</p>
                        <p class="text-red-500 mt-2">Giá {{ $product->GiaBan }}đ</p>
                        <button class="absolute top-2 right-2 bg-gray-200 rounded-full p-2 add-to-cart" onclick="addToCart('{{ $product->MaSanPham }}', '{{ $product->TenSanPham }}', '{{ $product->GiaBan }}', this)">
                            <i class="fa-solid fa-cart-plus text-gray-500 text-lg"></i>
                        </button>       
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <h1 class="text-center text-3xl text-purple-500">Tất Puma</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-4 sm:p-8">
        @foreach($tatProducts as $product)
            <div class="card-container">
                <div class="rounded-lg overflow-hidden shadow-md bg-white card flex flex-col sm:flex sm:flex-col">
                    <img class="w-full h-64 object-fit" src="{{ asset('images/' . $product->AnhDaiDien) }}" alt="{{ $product->TenSanPham }}">
                    <div class="p-4 h-60">
                        <h3 class="text-lg font-semibold mb-2">{{ $product->TenSanPham }}</h3>
                        <p class="text-gray-600">{{ $product->MoTa }}</p>
                        <p class="text-red-500 mt-2">Giá {{ $product->GiaBan }}đ</p>
                        <button class="absolute top-2 right-2 bg-gray-200 rounded-full p-2 add-to-cart" onclick="addToCart('{{ $product->MaSanPham }}', '{{ $product->TenSanPham }}', '{{ $product->GiaBan }}', this)">
                            <i class="fa-solid fa-cart-plus text-gray-500 text-lg"></i>
                        </button>      
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
