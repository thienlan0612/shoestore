<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NikeProductsController;
use App\Http\Controllers\AdidasProductsController;
use App\Http\Controllers\PumaProductsController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\ChiTietDonHangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nike', [NikeProductsController::class, 'index'])->name('nike_products');
Route::get('/adidas', [AdidasProductsController::class, 'index'])->name('adidas_products');
Route::get('/puma', [PumaProductsController::class, 'index'])->name('puma_products');
Route::get('/login', [NguoiDungController::class, 'showLoginForm'])->name('login');
Route::post('/login', [NguoiDungController::class, 'login']);
Route::get('/register', [NguoiDungController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [NguoiDungController::class, 'register'])->name('register');
Route::get('/verify', [NguoiDungController::class, 'showVerifyForm'])->name('verify');
Route::post('/verify', [NguoiDungController::class, 'verify'])->name('verify');
Route::get('/logout', [NguoiDungController::class, 'logout'])->name('logout');
Route::post('/add-to-cart', [ChiTietDonHangController::class, 'addToCart'])->name('addToCart');
Route::get('/chitietdonhang', [ChiTietDonHangController::class, 'viewCart'])->name('chitietdonhang');
Route::post('/checkout', [ChiTietDonHangController::class, 'checkout'])->name('checkout');
Route::get('/getQuantityForSize', [ChiTietDonHangController::class, 'getQuantityForSize']);
Route::post('/clear-cart-session', [ChiTietDonHangController::class, 'clearCartSession']);
Route::post('/chitietdonhang', [ChiTietDonHangController::class, 'updateUserInfo']);
Route::post('/removeFromCart', [ChiTietDonHangController::class, 'removeFromCart'])->name('removeFromCart');
Route::get('/thanhtoan', [ChiTietDonHangController::class, 'thanhtoan'])->name('thanhtoan');
Route::post('/saveBill', [ChiTietDonHangController::class, 'saveBill']);
Route::post('/saveCartToSession', [ChiTietDonHangController::class, 'saveCartToSession']);





