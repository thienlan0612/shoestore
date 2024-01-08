<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <title>Shoe Store</title>
  <style>
    @media (max-width: 767px) {
      #navbar-sticky a.bg-blue-700 {
        background-color: #4299e1;
      }
    }
  </style>
</head>
<?php
  $currentRoute = Request::route()->getName();
  $cartCount = session('cartCount', 0);
?>
<body class="flex flex-col h-screen">
  <header class="mx-auto">
    <nav class="bg-gray-300 dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-3">
      <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="images/logo.png" class="w-16 h-16 md:w-28 md:h-28 rounded-full" alt="TLSSLogo">
      </a>
      <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
          <div class="cart-icon flex mr-2">
            <a href="{{ route('chitietdonhang') }}">
              <svg aria-hidden="true" class="pre-nav-design-icon" focusable="false" viewBox="0 0 24 24" role="img" width="24px" height="24px" fill="none">
                <path stroke="currentColor" stroke-width="1.5" d="M8.25 8.25V6a2.25 2.25 0 012.25-2.25h3a2.25 2.25 0 110 4.5H3.75v8.25a3.75 3.75 0 003.75 3.75h9a3.75 3.75 0 003.75-3.75V8.25H17.5"></path>
            </svg>
            <span id="cartCountElement" class="cart-count pre-jewel pre-cart-jewel text-color-primary-dark" style="visibility: hidden" data-var="jewel">0</span>
            </a>
            
          </div>
      

          @if(session('TaiKhoan'))
            <div class="relative">
              <button id="logoButton" class="focus:outline-none">
                <img src="images/logo.png" class="w-8 h-8 md:w-12 md:h-12 rounded-full" alt="LogoSmall">
              </button>
            
              <div id="editProfile" class="hidden absolute bg-white rounded-md shadow-md py-2 w-40 top-full right-0 transition duration-300 ease-in-out">
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Sửa thông tin</a>
                <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Đăng xuất</a>
              </div>                    
            </div>
          @else
            
            <a href="{{ route('login') }}" class="w-full block">
              <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Đăng nhập</button>
            </a>
          @endif
          <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
      </div>
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
          <li>
            <a href="/" class="block py-2 px-3 text-gray-900 rounded {{ $currentRoute === 'home' ? 'bg-blue-700 text-dark dark:text-white' : '' }}" aria-current="page">Home</a>
          </li>
          <li>
            <a href="{{ route('nike_products') }}" class="block py-2 px-3 text-gray-900 rounded {{ $currentRoute === 'nike_products' ? 'bg-blue-700 text-dark dark:text-white' : '' }}">Nike</a>
          </li>
          <li>
            <a href="{{ route('adidas_products') }}" class="block py-2 px-3 text-gray-900 rounded {{ $currentRoute === 'adidas_products' ? 'bg-blue-700 text-dark dark:text-white' : '' }}">Adidas</a>
          </li>
          <li>
            <a href="{{ route('puma_products') }}" class="block py-2 px-3 text-gray-900 rounded {{ $currentRoute === 'puma_products' ? 'bg-blue-700 text-dark dark:text-white' : '' }}">Puma</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">Sale</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">Contact</a>
          </li>
        </ul>
      </div>
      </div>
    </nav>
  </header>

  <main class="flex-grow">
    <div class="container pt-40 "> 
      @yield('content')
    </div>
  </main>

    
  @yield('scripts')
  <footer class="bg-gray-300 dark:bg-gray-900 bottom-0 w-full py-4">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
      <div class="md:flex md:justify-between">
        <div class="mb-6 md:mb-0 md:col-4 sm:col-3">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
              <img src="images/logo.png" class="w-16 h-16 md:w-28 md:h-28 rounded-full" alt="TLSSLogo">
            </a>
        </div>
        <div class="md:col-8 sm:col-9">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div class="justify-self-end">
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Info</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">CÔNG TY TNHH TLSS VIỆT NAM</span><br>
                        </li>
                        <li>
                            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">Địa chỉ: 02 Nguyễn Đình Chiểu, Vĩnh Thọ, Nha Trang</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-3 text-sm font-semibold text-gray-900 uppercase dark:text-white">Follow us</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="https://www.facebook.com/TL06122002/"><i class="fa-brands fa-facebook text-2xl"></i></a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/lan.ph06/"><i class="fa-brands fa-instagram text-2xl"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
     </div>

      <div class="flex items-center justify-between mt-3">
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400 sm:w-full">© 2023 <a href="#" class="hover:underline">TLSS™</a>. All Rights Reserved.</span>
      </div>
    </div>
  </footer>






<script>
  document.addEventListener('DOMContentLoaded', function() {
    const navbarToggleBtn = document.querySelector('[data-collapse-toggle="navbar-sticky"]');
    const navbarMenu = document.getElementById('navbar-sticky');

    navbarToggleBtn.addEventListener('click', function() {
      navbarMenu.classList.toggle('hidden'); 
    });
  });
</script>


<script>
  function addToCart(productId, productName, productPrice, button) {
    if (button.classList.contains('add-to-cart')) {
      fetch(`/add-to-cart`, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}' 
          },
          body: JSON.stringify({
              productId: productId,
              productName: productName, 
              productPrice: productPrice 
          })
      })
      .then(response => response.json())
      .then(data => {
          
      })
      .catch(error => {
          console.error('Error:', error);
      });
      
      let currentCount = parseInt(sessionStorage.getItem('cartCount')) || 0;

      const newCount = currentCount + 1; 
      sessionStorage.setItem('cartCount', newCount); 


      const cartCountElement = document.getElementById('cartCountElement');
      cartCountElement.innerText = newCount;
      cartCountElement.style.visibility = newCount > 0 ? 'visible' : 'hidden';

      
    }
  }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    const currentCount = sessionStorage.getItem('cartCount');
    const cartCountElement = document.getElementById('cartCountElement');
  
    if (currentCount && parseInt(currentCount) > 0) {
      cartCountElement.innerText = currentCount;
      cartCountElement.style.visibility = 'visible';
    }
  });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
      const logoButton = document.getElementById('logoButton');
      const editProfile = document.getElementById('editProfile');

      logoButton.addEventListener('click', function() {
        editProfile.classList.toggle('hidden');
      });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const currentCount = sessionStorage.getItem('cartCount');
    const cartCountElement = document.getElementById('cartCountElement');

    if (!currentCount || parseInt(currentCount) === 0) {
      fetch('/clear-cart-session', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}' 
        }
      })
      .then(response => {
      })
      .catch(error => {
        console.error('Error:', error);
        alert(response.message);
      });
    }

  });

</script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const logoutButton = document.querySelector('[data-logout-button]');
    
    if (logoutButton) {
      logoutButton.addEventListener('click', function() {
        fetch('/logout', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          }
        })
        .then(response => {          
        })
        .catch(error => {
          console.error('Lỗi:', error);
        });
      });
    }
  });
</script>
  
</body>
</html>
