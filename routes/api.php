<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('payment-qris-success', [\App\Http\Controllers\Api\PaymentQrisConfirm::class, 'qrisConfirmPayment']);
Route::post('request-invoice-number', [\App\Http\Controllers\Api\PaymentQrisConfirm::class, 'requestInvoiceNumber']);
Route::post('request-qris', [\App\Http\Controllers\Api\PaymentQrisConfirm::class, 'requestQris']);

Route::middleware(['guest:tenant', 'guest:kasir', 'throttle:100,1', 'custom.restrict'])->group( function () {
    Route::post('register', [\App\Http\Controllers\Auth\Api\RegisterController::class, 'registerTenant']);
    Route::post('login', [\App\Http\Controllers\Auth\Api\LoginController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'abilities:tenant', 'abilities:kasir', 'throttle:100,1', 'custom.restrict'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\Api\LoginController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\Auth\Api\LoginController::class, 'user']);
});


Route::middleware(['auth:sanctum', 'abilities:tenant', 'throttle:100,1', 'custom.restrict'])->prefix('tenant')->group(function () {
    Route::post('/send-mail-otp', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'sendMailOTP']);
    Route::post('/verify-email-otp', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'verifyMailOTP']);

    Route::post('/send-whatsapp-otp', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'sendWhatsappOTP']);
    Route::post('/verify-whatsapp-otp', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'verifyWhatsappOTP']);

    Route::post('/user/detail', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'userDetail']);
    Route::post('/user/update', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'userUpdate']);
    Route::post('/user/update-store', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'userUpdateStore']);
    Route::get('/cs-info', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'csInfo']);

    Route::post('/kasir-list', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'kasirList']);
    Route::post('/kasir/detail', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'kasirDetail']);
    Route::post('/kasir/register', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'kasirRegister']);

    Route::post('/setting/alias', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'aliasList']);
    Route::post('/setting/alias/update', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'aliasUpdate']);

    Route::get('/product', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'productList']);
    Route::post('/product/detail', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'productDetail']);
    Route::get('/category', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'productCategory']);
    Route::post('/filter-category', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'filterCategory']);
    Route::post('/search-product', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'searchProduct']);
    Route::post('/search-barcode', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'searchBarcode']);
    Route::post('/add-cart', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'addCart']);
    Route::post('/delete-cart', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'deleteCart']);
    Route::get('/cart', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'listCart']);
    Route::post('/cart-process', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'processCart']);
    Route::post('/cart-invoice', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'listCartInvoice']);
    Route::get('/get-alias', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'getAlias']);

    Route::post('/rek-list', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'rekList']);
    Route::post('/bank-list', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'bankList']);
    Route::post('/update-rekening', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'rekeningupdate']);

    Route::post('/cek-saldo-qris', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'cekSaldoQris']);

    Route::post('/tarik-dana-qris', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'tarikDana']);

    Route::post('/transaction', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'transactionList']);
    Route::post('/transaction-alias', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'transactionListAlias']);
    Route::get('/transaction/pending', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'transactionPending']);


    Route::post('/transaction/pending/cart/add', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'transactionCartAdd']);
    Route::post('/transaction/pending/cart/delete', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'transactionCartDelete']);
    Route::post('/transaction/pending/update', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'transactionPendingUpdate']);
    Route::post('/transaction/pending/delete', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'transactionPendingDelete']);
    Route::post('/transaction/change-payment', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'transactionChangePayment']);


    Route::get('/transaction/detail/{id}', [\App\Http\Controllers\Auth\Tenant\Api\TenantController::class, 'transactionDetail']);
});

Route::middleware(['auth:sanctum', 'abilities:kasir', 'throttle:100,1', 'custom.restrict'])->prefix('kasir')->group(function () {
    Route::post('/user/detail', [\App\Http\Controllers\Auth\Kasir\Api\AuthController::class, 'userDetail']);
    Route::post('/user/update', [\App\Http\Controllers\Auth\Kasir\Api\AuthController::class, 'userUpdate']);
    Route::get('/product', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'productList']);
    Route::post('/product/detail', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'productDetail']);
    Route::get('/category', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'productCategory']);
    Route::post('/filter-category', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'filterCategory']);
    Route::post('/search-product', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'searchProduct']);
    Route::post('/search-barcode', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'searchBarcode']);
    Route::post('/add-cart', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'addCart']);
    Route::post('/delete-cart', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'deleteCart']);
    Route::get('/cart', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'listCart']);
    Route::post('/cart-process', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'processCart']);
    Route::post('/cart-invoice', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'listCartInvoice']);
    Route::get('/get-alias', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'getAlias']);
    Route::post('/transaction', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionList']);
    Route::post('/transaction-alias', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionListAlias']);
    Route::get('/transaction/pending', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionPending']);
    Route::post('/transaction/pending/cart/add', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionCartAdd']);
    Route::post('/transaction/pending/cart/delete', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionCartDelete']);
    Route::post('/transaction/pending/update', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionPendingUpdate']);
    Route::post('/transaction/pending/delete', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionPendingDelete']);
    Route::post('/transaction/change-payment', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionChangePayment']);
    Route::get('/transaction/detail/{id}', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionDetail']);
});
