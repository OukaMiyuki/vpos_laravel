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

Route::post('/admin/register', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'register']);
Route::post('/admin/login', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'login']);

// Route::middleware(['auth:admin'])->get('/admin/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
    Route::post('/admin/logout', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'logout']);
    Route::get('/admin/user', [\App\Http\Controllers\Auth\Admin\Api\AuthController::class, 'user']);
});
