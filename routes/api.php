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

Route::middleware(['guest:admin'])->prefix('admin')->group( function () {
    Route::post('register', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'abilities:admin'])->prefix('admin')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'user']);
});

Route::middleware(['guest:marketing'])->prefix('marketing')->group( function () {
    Route::post('register', [\App\Http\Controllers\Auth\Marketing\Api\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\Auth\Marketing\Api\AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'abilities:marketing'])->prefix('marketing')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\Marketing\Api\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\Auth\Marketing\Api\AuthController::class, 'user']);
});

Route::middleware(['guest:tenant'])->prefix('tenant')->group( function () {
    Route::post('register', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'abilities:tenant'])->prefix('tenant')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\Auth\Tenant\Api\AuthController::class, 'user']);
});

Route::middleware(['guest:kasir'])->prefix('kasir')->group( function () {
    Route::post('login', [\App\Http\Controllers\Auth\Kasir\Api\AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'abilities:kasir'])->prefix('kasir')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\Kasir\Api\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\Auth\Kasir\Api\AuthController::class, 'user']);
});
