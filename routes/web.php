<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', [PageController::class,'home'])->name('home');
 
Route::get('/auth/google/redirect', [SocialiteController::class,'redirect']);
 
Route::get('/auth/google/callback', [SocialiteController::class,'callback']);

Route::get('/payment', function () {
    return view('payment');
});

Route::post('beli/wishlist', [WishlistController::class,'store']);
Route::delete('delete/wishlist', 
    [WishlistController::class,'destroy']);

Route::post('beli/keranjang', 
    [KeranjangController::class,'store'])->name('beli.keranjang');
Route::put('/qty/{nama_produk}', 
    [KeranjangController::class,'qty'])->name('qty');
Route::put('/qty', 
    [KeranjangController::class,'qty_keranjang'])->name('qty.keranjang');
Route::delete('/delete/keranjang', 
    [KeranjangController::class,'delete_keranjang'])->name('delete.keranjang');

Route::get('/cari', [ProdukController::class,'cari']);

Route::get('/login', [LoginController::class,'index'])->middleware('guest');
Route::post('/login', [LoginController::class,'authenticate']);
Route::post('/logout', [LoginController::class,'logout']);

Route::get('/registration', [CustomerController::class,'tampil'])->middleware('guest')->name('page-daftar');
Route::post('/registration', [CustomerController::class,'store'])->name('daftar');

Route::get('/daftar-produk', [ProdukController::class,'list']);

// Route::get('/{nama_produk}', function ($nama_produk) {
//     return view('produk', ['nama_produk' => $nama_produk]);
// });

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class,'show']);
    Route::get('/keranjang', [KeranjangController::class,'show']);
    Route::get('/checkout', [CustomerController::class,'checkout']);
    Route::get('{nama_produk}', [ProdukController::class,'link']);
});

Route::post('check-ongkir', 
[PageController::class,'tampil_ongkir'])->name('check-ongkir');

Route::post('check-harga', 
[PageController::class,'tampil_harga'])->name('check-harga');