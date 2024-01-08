@extends('layouts.layout')

@section('content')
<div class="cart-container mx-auto max-w-2xl px-4">
    <h1 class="text-center text-3xl text-purple-500 mb-6">Giỏ Hàng Của Bạn</h1>
    @if(count($cart) > 0)
        @foreach($cart as $productId => $product)
            @for ($i = 0; $i < $product['pquantity']; $i++)
                <div class="cart-item flex items-center border-b-2 pb-4 mb-4">
                    <div class="item-thumbnail mr-4">
                        <input type="hidden" id="productID_{{ $productId }}" value="{{ $productId }}">
                        <img class="thumbnail-image w-24 h-24" src="{{ asset('images/' . $product['productImage']) }}" alt="{{ $product['productName'] }}">
                    </div>
                    <div class="item-details flex-grow">
                        <h3 class="text-2xl text-center mb-3 font-semibold">{{ $product['productName'] }}</h3>
                        <p><span class="mr-1 lg:mr-8">Giá bán:</span> <span class="price mb-2" id="productPrice_{{ $productId }}_{{ $i }}">{{ $product['productPrice'] }}</span> đ</p>

                        <div class="options mb-2">
                            <label for="productSize_{{ $productId }}_{{ $i }}" class="mr-1 lg:mr-14">Size:</label>
                            @if(isset($product['sizes']))
                                <select name="productSize" id="productSize_{{ $productId }}_{{ $i }}" class="border rounded-md px-2 py-1 productSize" data-product-id="{{ $productId }}_{{ $i }}">
                                    <option value="" selected disabled hidden>Vui lòng chọn size</option>
                                    @foreach($product['sizes'] as $size)
                                        <option value="{{ $size }}">{{ $size }}</option>
                                    @endforeach
                                </select>
                            @else
                                <span class="size-label">Vui lòng chọn size</span>
                            @endif
                        </div>

                        <div class="quantity mb-2" id="quantityContainer_{{ $productId }}_{{ $i }}">
                            <label for="quantity_{{ $productId }}_{{ $i }}" class="mr-5">Số lượng:</label>
                            @if(isset($product['sizes']))
                                <select name="quantity" id="quantity_{{ $productId }}_{{ $i }}" class="border rounded-md px-2 py-1 quantitySelect">

                                </select>
                            @else
                                <input type="number" name="quantity" id="quantity_{{ $productId }}_{{ $i }}" value="1" class="border rounded-md px-2 py-1 quantityInput">
                            @endif
                        </div>

                        <p class="total-price">Thành tiền: <span class="ml-3"id="totalPrice_{{ $productId }}_{{ $i }}">{{ $product['productPrice'] }}</span> đ</p>
                    </div>
                    <button class="delete-product-btn ml-auto bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-300 ease-in-out" data-product-id="{{ $productId }}" data-index="{{ $i }}">Xóa</button>
                </div>
            @endfor
        @endforeach
        <div class="flex justify-center mt-4">
            <button id="payButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300 ease-in-out mb-4">Thanh toán</button>
        </div>
    @else
        <p class="empty-cart text-center text-gray-500">Giỏ hàng của bạn đang trống.</p>
    @endif
    
</div>



<script>
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-product-btn')) {
            let productId = event.target.getAttribute('data-product-id');
            let index = event.target.getAttribute('data-index');

            let productContainer = document.querySelector(`#quantityContainer_${productId}_${index}`).closest('.cart-item');
            

            productContainer.remove();


            fetch('/removeFromCart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({
                    productId: productId
                }),
            })
            .then(response => response.json())
            .then(data => {
                let currentCount = parseInt(sessionStorage.getItem('cartCount'));

                if (!isNaN(currentCount) && currentCount > 0) {
                    currentCount--;
                    sessionStorage.setItem('cartCount', currentCount); 
                }

                const cartCountElement = document.getElementById('cartCountElement');
                if (!isNaN(currentCount) && currentCount > 0) {
                    cartCountElement.innerText = currentCount;
                    cartCountElement.style.visibility = 'visible';
                } else {
                    cartCountElement.style.visibility = 'hidden'; 
                }
            })
            .catch(error => {
                console.error('Lỗi khi xóa sản phẩm:', error);
            });
        }
    });
</script>




<script>

    let totalAmount = 0;
    function calculateTotal() {
        totalAmount = 0;
        document.querySelectorAll('.total-price span').forEach(element => {
            totalAmount += parseFloat(element.innerText);
        });
    }



    document.addEventListener('change', function (event) {
        if (event.target.classList.contains('productSize')) {
            // Xử lý khi có thay đổi kích thước
            let selectedSize = event.target.value;
            let productIdIndex = event.target.getAttribute('data-product-id');
            let [productId, index] = productIdIndex.split('_');

            let productContainer = document.querySelector(`#quantityContainer_${productId}_${index}`);
            
            if (selectedSize !== "") {
                fetch(`/getQuantityForSize?productId=${productId}&size=${selectedSize}`)
                    .then(response => response.json())
                    .then(data => {
                        let quantityContainer = productContainer.querySelector('.quantitySelect');
                        quantityContainer.innerHTML = '';
                        for (let i = 1; i <= data.quantity; i++) {
                            quantityContainer.innerHTML += `<option value="${i}">${i}</option>`;
                        }
                       
                        calculateTotal();
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                let quantityContainer = productContainer.querySelector('.quantitySelect');
                quantityContainer.innerHTML = `<option value="1">1</option>`; // Set giá trị mặc định là 1

                calculateTotal();
            }
        } else if (event.target.classList.contains('quantityInput')) {
            let selectedQuantity = event.target.value;
            if (selectedQuantity === '0') {
                event.target.value = '1'; // Nếu số lượng là 0, thiết lập lại là 1
                selectedQuantity = '1'; // Cập nhật giá trị chọn số lượng
            }   
            calculateTotal();
        }
    });




    
    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('quantitySelect') || event.target.classList.contains('quantityInput')) {
            let selectedQuantity = event.target.value;
            let productIdIndex = event.target.id.split('_');
            let productId = productIdIndex[1];
            let index = productIdIndex[2];

            // Lấy giá sản phẩm từ phần view
            let productPrice = parseFloat(document.querySelector(`#productPrice_${productId}_${index}`).innerText);


            if (selectedQuantity === '0') {
                total = 0;
            } else {
                total = productPrice * selectedQuantity;
            }
            document.querySelector(`#totalPrice_${productId}_${index}`).innerText = total;
            calculateTotal();
        }
    });


    
</script>

<script>
    function checkDuplicateProducts() {
        const products = document.querySelectorAll('.cart-item');
        const selectedProducts = new Map();
        let hasDuplicate = false;

        products.forEach(product => {
            const productId = product.querySelector('[id^="productID_"]').value;
            const selectedSize = product.querySelector('.productSize').value;

            const key = productId + selectedSize;
            
            if (selectedProducts.has(key)) {
                alert('Bạn đã chọn cùng một sản phẩm với cùng kích thước. Vui lòng chỉ chọn một sản phẩm duy nhất.');
                hasDuplicate = true;
                return;
            } else {
                selectedProducts.set(key, true);
            }
        });

        return hasDuplicate;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.querySelector('#payButton');

        payButton.addEventListener('click', function () {
            event.preventDefault(); //Chặn hành vi mặc định 
            const products = document.querySelectorAll('.cart-item');
            const cartData = [];
            let allSizesSelected = true;

            products.forEach(product => {
                const selectedSize = product.querySelector('.productSize');
                if (selectedSize && selectedSize.value === "") {
                    allSizesSelected = false;
                    return;
                }
            });

            if (!allSizesSelected) {
                alert('Vui lòng chọn size cho tất cả sản phẩm trước khi thanh toán.');
                return;
            }

            const isDuplicate = checkDuplicateProducts();

            if (isDuplicate) {
                return; // Nếu có sản phẩm trùng lặp, ngăn chặn chuyển trang
            }
            else {
                let totalAmount = 0;
                document.querySelectorAll('.total-price span').forEach(element => {
                    totalAmount += parseFloat(element.innerText);
                });

                products.forEach(product => {
                    const currentProductId = product.querySelector('[id^="productID_"]').value;
                    const selectedSize = product.querySelector('.productSize');
                    const quantity = product.querySelector('.quantitySelect') || product.querySelector('.quantityInput');
                    const productPrice = product.querySelector('.price');

                    if (selectedSize) {
                        const data = {
                            'MaSanPham': currentProductId,
                            'TenKichThuoc': selectedSize.value,
                            'SoLuong': quantity.value,
                            'DonGia': productPrice.innerText
                        };

                        cartData.push(data);
                    }
                });

                fetch('/saveCartToSession', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cartData: cartData
                    }),
                })
                .then(response => {
                    window.location.href = 'thanhtoan?totalAmount=' + encodeURIComponent(totalAmount);
                })
                .catch(error => {
                    console.error('Lỗi khi gửi dữ liệu:', error);
                });
            }
        });
    });
</script>



@endsection