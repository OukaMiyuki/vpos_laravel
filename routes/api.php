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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware(['guest:admin', 'throttle:10,1', 'custom.restrict'])->prefix('admin')->group( function () {
//     Route::post('register', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'register']);
//     Route::post('login', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'login']);
// });

// Route::middleware(['auth:sanctum', 'abilities:admin', 'throttle:10,1', 'custom.restrict'])->prefix('admin')->group(function () {
//     Route::post('/logout', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'logout']);
//     Route::get('/user', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'user']);
// });

// Route::middleware(['guest:marketing', 'throttle:10,1','custom.restrict'])->prefix('marketing')->group( function () {
//     Route::post('register', [\App\Http\Controllers\Auth\Marketing\Api\AuthController::class, 'register']);
//     Route::post('login', [\App\Http\Controllers\Auth\Marketing\Api\AuthController::class, 'login']);
// });

// Route::middleware(['auth:sanctum', 'abilities:marketing', 'throttle:10,1','custom.restrict'])->prefix('marketing')->group(function () {
//     Route::post('/logout', [\App\Http\Controllers\Auth\Marketing\Api\AuthController::class, 'logout']);
//     Route::get('/user', [\App\Http\Controllers\Auth\Marketing\Api\AuthController::class, 'user']);
// });

Route::middleware(['guest:tenant', 'guest:kasir', 'throttle:90,1', 'custom.restrict'])->group( function () {
    Route::post('register', [\App\Http\Controllers\Auth\Api\RegisterController::class, 'registerTenant']);
    Route::post('login', [\App\Http\Controllers\Auth\Api\LoginController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'abilities:tenant', 'abilities:kasir', 'throttle:90,1', 'custom.restrict'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\Api\LoginController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\Auth\Api\LoginController::class, 'user']);
});

// Route::middleware(['guest:tenant', 'throttle:10,1', 'custom.restrict'])->prefix('tenant')->group( function () {
//     Route::post('register', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'register']);
//     Route::post('login', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'login']);
// });

// Route::middleware(['auth:sanctum', 'abilities:tenant', 'throttle:10,1', 'custom.restrict'])->prefix('tenant')->group(function () {
//     Route::post('/logout', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'logout']);
//     Route::get('/user', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'user']);
// });

// Route::middleware(['guest:kasir', 'throttle:10,1', 'custom.restrict'])->prefix('kasir')->group( function () {
//     Route::post('login', [\App\Http\Controllers\Auth\Kasir\Api\AuthController::class, 'login']);
// });

Route::middleware(['auth:sanctum', 'abilities:kasir', 'throttle:90,1', 'custom.restrict'])->prefix('kasir')->group(function () {
    // Route::post('/logout', [\App\Http\Controllers\Auth\Kasir\Api\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\Auth\Kasir\Api\AuthController::class, 'user']);
    Route::get('/product', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'productList']);
    Route::get('/category', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'productCategory']);
    Route::post('/filter-category', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'filterCategory']);
    Route::post('/search-product', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'searchProduct']);
    Route::post('/search-barcode', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'searchBarcode']);
    Route::post('/add-cart', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'addCart']);
    Route::post('/delete-cart', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'deleteCart']);
    Route::get('/cart', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'listCart']);
    Route::post('/cart-process', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'processCart']);
    Route::get('/transaction', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionList']);
    Route::get('/transaction/pending', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionPending']);
    Route::post('/transaction/pending/cart/add', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionCartAdd']);
    Route::post('/transaction/pending/cart/delete', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionCartDelete']);
    Route::post('/transaction/pending/update', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionPendingUpdate']);
    Route::post('/transaction/pending/delete', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionPendingDelete']);
    Route::get('/transaction/detail/{id}', [\App\Http\Controllers\Auth\Kasir\Api\KasirController::class, 'transactionDetail']);
});
