<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Support\Csp\Policies\CustomPolicy;
use Spatie\Csp\AddCspHeaders;

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
})->name('welcome');

// Temporarry commit because of error

Route::middleware(['guest:admin', 'throttle', 'addnonceScript', 'addnonceStyle', AddCspHeaders::class.':'.CustomPolicy::class])->prefix('admin')->group( function () {
    Route::get('login', [App\Http\Controllers\Auth\Admin\LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Auth\Admin\LoginController::class, 'store']);
    // Route::get('register', [App\Http\Controllers\Auth\Admin\RegisterController::class, 'create'])->name('admin.register');
    // Route::post('register', [App\Http\Controllers\Auth\Admin\RegisterController::class, 'store']);

});

// Route::middleware(['auth:admin'])->prefix('admin')->group( function () {
//     Route::get('/verify-email', [App\Http\Controllers\Auth\Admin\EmailVerificationPromptController::class, 'emailVerificationView'])->name('admin.verification.notice');
//     Route::get('verify-email/{id}/{hash}', [App\Http\Controllers\Auth\Admin\VerifyEmailController::class, 'verificationProcess'])
//                 ->middleware(['signed', 'throttle:6,1'])
//                 ->name('admin.verification.verify');
//     Route::post('email/verification-notification', [App\Http\Controllers\Auth\Admin\EmailVerificationNotificationController::class, 'store'])
//                 ->middleware('throttle:6,1')
//                 ->name('admin.verification.send');


//     Route::post('logout', [App\Http\Controllers\Auth\Admin\LoginController::class, 'destroy'])->name('admin.logout');
// });

Route::middleware(['auth:admin', 'throttle', 'addnonceScript', 'addnonceStyle', AddCspHeaders::class.':'.CustomPolicy::class])->prefix('admin')->group( function () {
    Route::post('logout', [App\Http\Controllers\Auth\Admin\LoginController::class, 'destroy'])->name('admin.logout');
    Route::get('/dashboard', [App\Http\Controllers\Auth\Admin\AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('settings/profile', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'profile'])->name('admin.profile');
    Route::post('settings/profile/account_update', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'profileAccountUpdate'])->name('admin.profile.account.update');
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'profileInfoUpdate'])->name('admin.profile.info.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'password'])->name('admin.password');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'passwordUpdate'])->name('admin.password.update');

    Route::get('dashboard/data/marketing', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMarketing'])->name('admin.dashboard.marketing');
    Route::get('dashboard/data/marketing/activation/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMarketingAccountActivation'])->name('admin.dashboard.marketing.account.activation');
    Route::get('dashboard/data/marketing/profile/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMarketingProfile'])->name('admin.dashboard.marketing.profile');
    Route::post('dashboard/data/marketing/account_update', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMarketingAccountUpdate'])->name('admin.dashboard.marketing.account.update');
    Route::post('dashboard/data/marketing/account_info_update', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMarketingAccountInfoUpdate'])->name('admin.dashboard.marketing.info.update');
});

Route::middleware(['guest:marketing', 'throttle', 'addnonceScript', 'addnonceStyle', AddCspHeaders::class.':'.CustomPolicy::class])->prefix('marketing')->group( function () {
    Route::get('login', [App\Http\Controllers\Auth\Marketing\LoginController::class, 'create'])->name('marketing.login');
    Route::post('login', [App\Http\Controllers\Auth\Marketing\LoginController::class, 'store']);
    Route::get('register', [App\Http\Controllers\Auth\Marketing\RegisterController::class, 'create'])->name('marketing.register');
    Route::post('register', [App\Http\Controllers\Auth\Marketing\RegisterController::class, 'store']);

});

Route::middleware(['auth:marketing', 'throttle', 'addnonceScript', 'addnonceStyle', AddCspHeaders::class.':'.CustomPolicy::class])->prefix('marketing')->group( function () {
    Route::get('/verify-email', [App\Http\Controllers\Auth\Marketing\EmailVerificationPromptController::class, 'emailVerificationView'])->name('marketing.verification.notice');
    Route::get('verify-email/{id}/{hash}', [App\Http\Controllers\Auth\Marketing\VerifyEmailController::class, 'verificationProcess'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('marketing.verification.verify');
    Route::post('email/verification-notification', [App\Http\Controllers\Auth\Marketing\EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('marketing.verification.send');

    Route::post('logout', [App\Http\Controllers\Auth\Marketing\LoginController::class, 'destroy'])->name('marketing.logout');
});

Route::middleware(['auth:marketing', 'marketingemailverified', 'throttle', 'addnonceScript', 'addnonceStyle', AddCspHeaders::class.':'.CustomPolicy::class])->prefix('marketing')->group( function () {
    Route::get('/dashboard', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'index'])->name('marketing.dashboard');

    Route::get('settings/profile', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'profile'])->name('marketing.profile');
    Route::post('settings/profile/account_update', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'profileAccountUpdate'])->name('marketing.profile.account.update');
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'profileInfoUpdate'])->name('marketing.profile.info.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'password'])->name('marketing.password');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'passwordUpdate'])->name('marketing.password.update');

    Route::get('/dashboard/data/code/list', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invitationCodeList'])->name('marketing.dashboard.invitationcode.list');
    Route::post('/dashboard/data/code/insert', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invitationCodeInsert'])->name('marketing.dashboard.invitationcode.insert');
    Route::get('/dashboard/data/code/cashout/info', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invitationCodeCashoutList'])->name('marketing.dashboard.invitationcode.cashout.list');
    Route::get('/dashboard/data/code/cashout/invoice', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invitationCodeCashoutInvoice'])->name('marketing.dashboard.invitationcode.cashout.invoice');
});

Route::middleware(['guest:tenant', 'throttle', 'addnonceScript', 'addnonceStyle', AddCspHeaders::class.':'.CustomPolicy::class])->prefix('tenant')->group( function () {

    Route::get('login', [App\Http\Controllers\Auth\Tenant\LoginController::class, 'create'])->name('tenant.login');
    Route::post('login', [App\Http\Controllers\Auth\Tenant\LoginController::class, 'store']);

    Route::get('register', [App\Http\Controllers\Auth\Tenant\RegisterController::class, 'create'])->name('tenant.register');
    Route::post('register', [App\Http\Controllers\Auth\Tenant\RegisterController::class, 'store']);

});

Route::middleware(['auth:tenant', 'throttle', 'addnonceScript', 'addnonceStyle', AddCspHeaders::class.':'.CustomPolicy::class])->prefix('tenant')->group( function () {
    Route::get('/verify-email', [App\Http\Controllers\Auth\Tenant\EmailVerificationPromptController::class, 'emailVerificationView'])->name('tenant.verification.notice');
    Route::get('verify-email/{id}/{hash}', [App\Http\Controllers\Auth\Tenant\VerifyEmailController::class, 'verificationProcess'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('tenant.verification.verify');
    Route::post('email/verification-notification', [App\Http\Controllers\Auth\Tenant\EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('tenant.verification.send');

    Route::post('logout', [App\Http\Controllers\Auth\Tenant\LoginController::class, 'destroy'])->name('tenant.logout');
});

Route::middleware(['auth:tenant', 'tenantemailverivied', 'throttle', 'addnonceScript', 'addnonceStyle', AddCspHeaders::class.':'.CustomPolicy::class])->prefix('tenant')->group( function () {
    Route::get('/dashboard', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'index'])->name('tenant.dashboard');
    Route::get('/dashboard/data/kasir/list', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirList'])->name('tenant.kasir.list');
    Route::get('/dashboard/data/kasir/info/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirDetail'])->name('tenant.kasir.detail');
    Route::post('/kasir/register', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirRegister'])->name('tenant.register.kasir');
    Route::get('/dashboard/data/supplier/list', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'supplierList'])->name('tenant.supplier.list');
    Route::post('/dashboard/data/supplier/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'supplierInsert'])->name('tenant.supplier.insert');
    Route::post('/dashboard/data/supplier/update', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'supplierUpdate'])->name('tenant.supplier.update');
    Route::get('/dashboard/data/supplier/delete/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'supplierDelete'])->name('tenant.supplier.delete');
    Route::get('/dashboard/data/product/batch/list', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchList'])->name('tenant.batch.list');
    Route::post('/dashboard/data/product/batch/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchInsert'])->name('tenant.batch.insert');
    Route::post('/dashboard/data/product/batch/update', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchUpdate'])->name('tenant.batch.update');
    Route::get('/dashboard/data/product/batch/delete/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchDelete'])->name('tenant.batch.delete');
    Route::get('/dashboard/data/product/category/list', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'categoryList'])->name('tenant.category.list');
    Route::post('/dashboard/data/product/category/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'categoryInsert'])->name('tenant.category.insert');
    Route::post('/dashboard/data/product/category/update', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'categoryUpdate'])->name('tenant.category.update');
    Route::get('/dashboard/data/product/category/delete/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'categoryDelete'])->name('tenant.category.delete');

    Route::get('/dashboard/data/batch/product/list', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductList'])->name('tenant.product.batch.list');
    Route::get('/dashboard/data/batch/product/add', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductAdd'])->name('tenant.product.batch.add');
    Route::post('/dashboard/data/batch/product/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductInsert'])->name('tenant.product.batch.insert');
    Route::get('/dashboard/data/batch/product/detail/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductDetail'])->name('tenant.product.batch.detail');
    Route::get('/dashboard/data/batch/product/edit/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductEdit'])->name('tenant.product.batch.edit');
    Route::post('/dashboard/data/batch/product/update', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductUpdate'])->name('tenant.product.batch.update');
    Route::get('/dashboard/data/batch/product/delete/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductDelete'])->name('tenant.product.batch.delete');

    Route::get('/dashboard/data/batch/product/stock', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockList'])->name('tenant.product.stock.list');
    Route::get('/dashboard/data/batch/product/stock/add', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockAdd'])->name('tenant.product.stock.add');
    Route::post('/dashboard/data/batch/product/stock/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockInsert'])->name('tenant.product.stock.insert');
    Route::get('/dashboard/data/batch/product/stock/edit/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockEdit'])->name('tenant.product.stock.edit');
    Route::post('/dashboard/data/batch/product/stock/update', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockUpdate'])->name('tenant.product.stock.update');
    Route::get('/dashboard/data/batch/product/stock/delete/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockDelete'])->name('tenant.product.stock.delete');
    Route::get('/dashboard/data/batch/product/stock/barcode/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockBarcode'])->name('tenant.product.stock.barcode.show');

    Route::get('/dashboard/store/settings/discount', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'discountModify'])->name('tenant.discount.modify');
    Route::post('/dashboard/store/settings/discount/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'discountModifyInsert'])->name('tenant.discount.insert');

    Route::get('/dashboard/store/settings/pajak', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'pajakModify'])->name('tenant.pajak.modify');
    Route::post('/dashboard/store/settings/pajak/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'pajakModifyInsert'])->name('tenant.pajak.modify.insert');

    Route::get('/dashboard/store/settings/custom_fields', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'customField'])->name('tenant.customField.modify');
    Route::post('/dashboard/store/settings/custom_fields/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'customFieldInsert'])->name('tenant.customField.modify.insert');

    Route::get('settings/store', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'storeProfileSettings'])->name('tenant.store.profile');
    Route::post('settings/store', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'storeProfileSettingsUPdate'])->name('tenant.store.profile.update');
    Route::get('settings/profile', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'profile'])->name('tenant.profile');
    Route::post('settings/profile/account_update', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'profileAccountUpdate'])->name('tenant.profile.account.update');
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'profileInfoUpdate'])->name('tenant.profile.info.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'password'])->name('tenant.password');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'passwordUpdate'])->name('tenant.password.update');
});

Route::middleware(['guest:kasir', 'throttle', 'addnonceScript', 'addnonceStyle', AddCspHeaders::class.':'.CustomPolicy::class])->prefix('kasir')->group( function () {

    Route::get('login', [App\Http\Controllers\Auth\Kasir\LoginController::class, 'create'])->name('kasir.login');
    Route::post('login', [App\Http\Controllers\Auth\Kasir\LoginController::class, 'store']);

    // Route::get('register', [App\Http\Controllers\Auth\Kasir\RegisterController::class, 'create'])->name('kasir.register');
    // Route::post('register', [App\Http\Controllers\Auth\Kasir\RegisterController::class, 'store']);

});

Route::middleware(['auth:kasir', 'throttle', 'addnonceScript', 'addnonceStyle', AddCspHeaders::class.':'.CustomPolicy::class])->prefix('kasir')->group( function () {

    Route::post('logout', [App\Http\Controllers\Auth\Kasir\LoginController::class, 'destroy'])->name('kasir.logout');

    Route::view('/dashboard','kasir.dashboard');
    Route::get('/dashboard/kasir/pos', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'kasirPos'])->name('kasir.pos');
    Route::post('/dashboard/kasir/pos/addcart', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'addCart'])->name('kasir.pos.addCart');
    Route::get('/dashboard/kasir/pos/allitem', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'allItem'])->name('kasir.pos.allitem');
    Route::post('/dashboard/kasir/pos/update', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'updateCart'])->name('kasir.pos.updateCart');
    Route::get('/dashboard/kasir/pos/delete/{id}', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'removeCart'])->name('kasir.pos.deleteCart');
    Route::post('/dashboard/kasir/pos/transaction/save', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionSave'])->name('kasir.pos.transaction.save');
    Route::post('/dashboard/kasir/pos/transaction/clear', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionClear'])->name('kasir.pos.transaction.clear');
    Route::post('/dashboard/kasir/pos/transaction/process', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionProcess'])->name('kasir.pos.transaction.process');
    Route::get('/dashboard/kasir/pos/transaction/process/invoice/{id}', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionInvoice'])->name('kasir.pos.transaction.invoice');
    Route::get('/dashboard/kasir/pos/transaction/process/invoice/receipt/{id}', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionInvoiceReceipt'])->name('kasir.pos.transaction.invoice.receipt');

    Route::get('/dashboard/kasir/transaction/pending', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionPending'])->name('kasir.transaction.pending');
    Route::get('/dashboard/kasir/transaction/restore/{id}', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionPendingRestore'])->name('kasir.transaction.pending.restore');
    Route::post('/dashboard/kasir/transaction/pending/process', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionPendingProcess'])->name('kasir.pos.transaction.pending.process');
    // Route::post('/dashboard/kasir/pos/transaction/update', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionPendingUpdate'])->name('kasir.pos.transaction.pending.update');

    Route::get('/dashboard/kasir/transaction/finish', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionFinish'])->name('kasir.transaction.finish');

    Route::get('settings/profile', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'profile'])->name('kasir.profile');
    Route::post('settings/profile/account_update', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'profileAccountUpdate'])->name('kasir.profile.account.update');
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'profileInfoUpdate'])->name('kasir.profile.info.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'password'])->name('kasir.password');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'passwordUpdate'])->name('kasir.password.update');
});

require __DIR__.'/auth.php';
