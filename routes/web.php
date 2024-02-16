<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware('guest:admin')->prefix('admin')->group( function () {
    Route::get('login', [App\Http\Controllers\Auth\Admin\LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Auth\Admin\LoginController::class, 'store']);
    // Route::get('register', [App\Http\Controllers\Auth\Admin\RegisterController::class, 'create'])->name('admin.register');
    // Route::post('register', [App\Http\Controllers\Auth\Admin\RegisterController::class, 'store']);

});

Route::middleware('auth:admin')->prefix('admin')->group( function () {
    Route::post('logout', [App\Http\Controllers\Auth\Admin\LoginController::class, 'destroy'])->name('admin.logout');
    Route::view('/dashboard','admin.dashboard');

    Route::get('settings/profile', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'profile'])->name('admin.profile');
    Route::post('settings/profile/account_update', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'profileAccountUpdate'])->name('admin.profile.account.update');
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'profileInfoUpdate'])->name('admin.profile.info.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'password'])->name('admin.password');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'passwordUpdate'])->name('admin.password.update');
});

Route::middleware('guest:marketing')->prefix('marketing')->group( function () {
    Route::get('login', [App\Http\Controllers\Auth\Marketing\LoginController::class, 'create'])->name('marketing.login');
    Route::post('login', [App\Http\Controllers\Auth\Marketing\LoginController::class, 'store']);
    Route::get('register', [App\Http\Controllers\Auth\Marketing\RegisterController::class, 'create'])->name('marketing.register');
    Route::post('register', [App\Http\Controllers\Auth\Marketing\RegisterController::class, 'store']);

});

Route::middleware('auth:marketing')->prefix('marketing')->group( function () {

    Route::post('logout', [App\Http\Controllers\Auth\Marketing\LoginController::class, 'destroy'])->name('marketing.logout');

    Route::view('/dashboard','marketing.dashboard');

});

Route::middleware('guest:tenant')->prefix('tenant')->group( function () {

    Route::get('login', [App\Http\Controllers\Auth\Tenant\LoginController::class, 'create'])->name('tenant.login');
    Route::post('login', [App\Http\Controllers\Auth\Tenant\LoginController::class, 'store']);

    Route::get('register', [App\Http\Controllers\Auth\Tenant\RegisterController::class, 'create'])->name('tenant.register');
    Route::post('register', [App\Http\Controllers\Auth\Tenant\RegisterController::class, 'store']);

});

Route::middleware('auth:tenant')->prefix('tenant')->group( function () {

    Route::post('logout', [App\Http\Controllers\Auth\Tenant\LoginController::class, 'destroy'])->name('tenant.logout');

    Route::view('/dashboard','tenant.dashboard');

});

Route::middleware('guest:kasir')->prefix('kasir')->group( function () {

    Route::get('login', [App\Http\Controllers\Auth\Kasir\LoginController::class, 'create'])->name('kasir.login');
    Route::post('login', [App\Http\Controllers\Auth\Kasir\LoginController::class, 'store']);

    Route::get('register', [App\Http\Controllers\Auth\Kasir\RegisterController::class, 'create'])->name('kasir.register');
    Route::post('register', [App\Http\Controllers\Auth\Kasir\RegisterController::class, 'store']);

});

Route::middleware('auth:kasir')->prefix('kasir')->group( function () {

    Route::post('logout', [App\Http\Controllers\Auth\Kasir\LoginController::class, 'destroy'])->name('kasir.logout');

    Route::view('/dashboard','kasir.dashboard');

});

require __DIR__.'/auth.php';
