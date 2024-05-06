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
})->name('welcome');

// Temporarry commit because of error

Route::middleware(['guest:admin', 'throttle'])->prefix('admin')->group( function () {
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

Route::middleware(['auth:admin', 'throttle'])->prefix('admin')->group( function () {
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

// Route::get('otp', function () {
//     return view('marketing.auth.otp');
// });

Route::middleware(['guest:marketing', 'throttle'])->prefix('marketing')->group( function () {
    Route::get('login', [App\Http\Controllers\Auth\Marketing\LoginController::class, 'create'])->name('marketing.login');
    Route::post('login', [App\Http\Controllers\Auth\Marketing\LoginController::class, 'store']);
    Route::post('login', [App\Http\Controllers\Auth\Marketing\LoginController::class, 'store']);
    Route::get('register', [App\Http\Controllers\Auth\Marketing\RegisterController::class, 'create'])->name('marketing.register');
    Route::post('register', [App\Http\Controllers\Auth\Marketing\RegisterController::class, 'store']);

});

Route::middleware(['auth:marketing', 'throttle'])->prefix('marketing')->group( function () {
    Route::get('/verify-email', [App\Http\Controllers\Auth\Marketing\EmailVerificationPromptController::class, 'emailVerificationView'])->name('marketing.verification.notice');
    // Route::get('verify-email/{id}/{hash}', [App\Http\Controllers\Auth\Marketing\VerifyEmailController::class, 'verificationProcess'])
    //             ->middleware(['signed', 'throttle:6,1'])
    //             ->name('marketing.verification.verify');
    Route::post('verify-email', [App\Http\Controllers\Auth\Marketing\VerifyEmailController::class, 'processVerification'])
                ->middleware(['throttle:6,1'])
                ->name('marketing.verification.verify');
    Route::post('email/verification-notification', [App\Http\Controllers\Auth\Marketing\EmailVerificationNotificationController::class, 'store'])
                ->middleware(['throttle:6,1'])
                ->name('marketing.verification.send');

    Route::post('logout', [App\Http\Controllers\Auth\Marketing\LoginController::class, 'destroy'])->name('marketing.logout');
});

Route::middleware(['auth:marketing', 'marketingemailverified', 'throttle', 'isMarketingActive'])->prefix('marketing')->group( function () {
    Route::get('/dashboard', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'index'])->name('marketing.dashboard');

    //Route::get('/testing-wa', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'whatsappNotification'])->name('testing.wa');

    //Route::get('/testing-wa', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'whatsappNotification'])->name('testing.wa');

    Route::post('settings/request/send-whatsapp-otp', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'whatsappNotification'])->name('marketing.settings.whatsappotp');
    Route::post('settings/validate/whatsapp-otp', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'whatsappOTPSubmit'])->name('marketing.settings.whatsappotp.validate');
    Route::get('settings', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'marketingSettings'])->name('marketing.settings');
    Route::get('settings/profile', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'profile'])->name('marketing.profile');
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'profileInfoUpdate'])->name('marketing.profile.info.update');
    Route::get('settings/rekening', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'rekeningSetting'])->name('marketing.rekening.setting');
    Route::post('settings/rekening', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'rekeningSettingUpdate'])->name('marketing.rekening.setting.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'password'])->name('marketing.password');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'passwordUpdate'])->name('marketing.password.update');

    Route::get('/dashboard/code', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invitationCodeDashboard'])->name('marketing.dashboard.invitationcode');
    Route::post('/dashboard/code/insert', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invitationCodeInsert'])->name('marketing.dashboard.invitationcode.insert');
    Route::get('/dashboard/code/cashout/info', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invitationCodeCashoutList'])->name('marketing.dashboard.invitationcode.cashout.list');
    Route::get('/dashboard/code/cashout/invoice', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invitationCodeCashoutInvoice'])->name('marketing.dashboard.invitationcode.cashout.invoice');

    Route::get('/dashboard/tenant/list', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'marketingTenantList'])->name('marketing.dashboard.tenant.list');
    Route::get('/dashboard/tenant/detail/{inv_code}/{id}', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'marketingTenantDetail'])->name('marketing.dashboard.tenant.detail');
});

Route::middleware(['guest:tenant', 'throttle'])->prefix('tenant')->group( function () {

    Route::get('login', [App\Http\Controllers\Auth\Tenant\LoginController::class, 'create'])->name('tenant.login');
    Route::post('login', [App\Http\Controllers\Auth\Tenant\LoginController::class, 'store']);

    Route::get('register', [App\Http\Controllers\Auth\Tenant\RegisterController::class, 'create'])->name('tenant.register');
    Route::post('register', [App\Http\Controllers\Auth\Tenant\RegisterController::class, 'store']);

});

Route::middleware(['auth:tenant', 'throttle'])->prefix('tenant')->group( function () {
    Route::get('/verify-email', [App\Http\Controllers\Auth\Tenant\EmailVerificationPromptController::class, 'emailVerificationView'])->name('tenant.verification.notice');
    // Route::get('verify-email/{id}/{hash}', [App\Http\Controllers\Auth\Tenant\VerifyEmailController::class, 'verificationProcess'])
    //             ->middleware(['signed', 'throttle:6,1'])
    //             ->name('tenant.verification.verify');
    Route::post('verify-email', [App\Http\Controllers\Auth\Tenant\VerifyEmailController::class, 'processVerification'])
                    ->middleware(['throttle:6,1'])
                    ->name('tenant.verification.verify');
    Route::post('email/verification-notification', [App\Http\Controllers\Auth\Tenant\EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('tenant.verification.send');

    Route::post('logout', [App\Http\Controllers\Auth\Tenant\LoginController::class, 'destroy'])->name('tenant.logout');
});

Route::middleware(['auth:tenant', 'tenantemailverivied', 'throttle', 'isTenantActive'])->prefix('tenant')->group( function () {
    // Route::get('check-payment', function () { event(new App\Events\PaymentCheck('Someone')); return "Event has been sent!";});
    // Route::get('test', function () {
    //     event(new App\Events\PaymentCheck('Someone'));
    //     return "Event has been sent!";
    //     });
    Route::get('/dashboard', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'index'])->name('tenant.dashboard');
    Route::get('/dashboard/kasir', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'tenantKasirDashboard'])->name('tenant.kasir');
    Route::get('/dashboard/kasir/list', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirList'])->name('tenant.kasir.list');
    Route::get('/dashboard/kasir/list/active', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirListActive'])->name('tenant.kasir.list.active');
    Route::get('/dashboard/kasir/list/non-aktif', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirListNonActive'])->name('tenant.kasir.list.non.active');
    Route::get('/dashboard/kasir/info/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirDetail'])->name('tenant.kasir.detail');
    Route::post('/kasir/register', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirRegister'])->name('tenant.register.kasir');
    
    Route::get('/dashboard/toko', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'tenantMenuToko'])->name('tenant.toko');
    Route::get('/dashboard/toko/supplier', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'supplierList'])->name('tenant.supplier.list');
    Route::post('/dashboard/toko/supplier/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'supplierInsert'])->name('tenant.supplier.insert');
    Route::post('/dashboard/toko/supplier/update', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'supplierUpdate'])->name('tenant.supplier.update');
    Route::get('/dashboard/toko/supplier/delete/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'supplierDelete'])->name('tenant.supplier.delete');
    Route::get('/dashboard/toko/batch', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchList'])->name('tenant.batch.list');
    Route::post('/dashboard/toko/batch/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchInsert'])->name('tenant.batch.insert');
    Route::post('/dashboard/toko/batch/update', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchUpdate'])->name('tenant.batch.update');
    Route::get('/dashboard/toko/batch/delete/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchDelete'])->name('tenant.batch.delete');
    Route::get('/dashboard/toko/category', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'categoryList'])->name('tenant.category.list');
    Route::post('/dashboard/toko/category/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'categoryInsert'])->name('tenant.category.insert');
    Route::post('/dashboard/toko/category/update', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'categoryUpdate'])->name('tenant.category.update');
    Route::get('/dashboard/toko/category/delete/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'categoryDelete'])->name('tenant.category.delete');

    Route::get('/dashboard/toko/product', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductList'])->name('tenant.product.batch.list');
    Route::get('/dashboard/toko/product/add', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductAdd'])->name('tenant.product.batch.add');
    Route::post('/dashboard/toko/product/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductInsert'])->name('tenant.product.batch.insert');
    Route::get('/dashboard/toko/product/detail/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductDetail'])->name('tenant.product.batch.detail');
    Route::get('/dashboard/toko/product/edit/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductEdit'])->name('tenant.product.batch.edit');
    Route::post('/dashboard/toko/product/update', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductUpdate'])->name('tenant.product.batch.update');
    Route::get('/dashboard/toko/product/delete/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'batchProductDelete'])->name('tenant.product.batch.delete');

    Route::get('/dashboard/toko/stock', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockList'])->name('tenant.product.stock.list');
    Route::get('/dashboard/toko/stock/add', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockAdd'])->name('tenant.product.stock.add');
    Route::post('/dashboard/toko/stock/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockInsert'])->name('tenant.product.stock.insert');
    Route::get('/dashboard/toko/stock/edit/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockEdit'])->name('tenant.product.stock.edit');
    Route::post('/dashboard/toko/stock/update', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockUpdate'])->name('tenant.product.stock.update');
    Route::get('/dashboard/toko/stock/delete/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockDelete'])->name('tenant.product.stock.delete');
    Route::get('/dashboard/toko/stock/barcode/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'productStockBarcode'])->name('tenant.product.stock.barcode.show');

    Route::get('/dashboard/transaction', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'tenantTransaction'])->name('tenant.transaction');
    Route::get('/dashboard/transaction/list/today', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'tenantThisDayTransaction'])->name('tenant.transaction.today');
    Route::get('/dashboard/transaction/list/finish', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionFinishList'])->name('tenant.transaction.finish');
    Route::get('/dashboard/transaction/list/finish/payment', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionQrisFinishList'])->name('tenant.transaction.finish.qris');
    Route::get('/dashboard/transaction/list', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionList'])->name('tenant.transaction.list');
    Route::get('/dashboard/transaction/list/pending', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionListPending'])->name('tenant.transaction.list.pending');
    Route::get('/dashboard/transaction/list/pending/payment', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionListPendingPayment'])->name('tenant.transaction.list.pending.payment');
    Route::get('/dashboard/transaction/list/invoice/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionInvoiceView'])->name('tenant.transaction.invoice');

    Route::get('/dashboard/finance', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'financeDashboard'])->name('tenant.finance');
    Route::get('/dashboard/finance/pemasukan', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'financePemasukan'])->name('tenant.finance.pemasukan');
    Route::get('/dashboard/finance/saldo', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'saldoData'])->name('tenant.saldo');
    Route::get('/dashboard/finance/history-penarikan', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'historyPenarikan'])->name('tenant.finance.history_penarikan');
    
    Route::get('/dashboard/management', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'storeManagement'])->name('tenant.store.management');
    Route::get('/dashboard/management/discount', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'discountModify'])->name('tenant.discount.modify');
    Route::post('/dashboard/management/discount/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'discountModifyInsert'])->name('tenant.discount.insert');
    Route::get('/dashboard/management/pajak', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'pajakModify'])->name('tenant.pajak.modify');
    Route::post('/dashboard/management/pajak/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'pajakModifyInsert'])->name('tenant.pajak.modify.insert');
    Route::get('/dashboard/management/custom_fields', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'customField'])->name('tenant.customField.modify');
    Route::post('/dashboard/management/custom_fields/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'customFieldInsert'])->name('tenant.customField.modify.insert');
    
    Route::get('settings', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'tenantSettings'])->name('tenant.settings');
    Route::get('settings/store', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'storeProfileSettings'])->name('tenant.store.profile');
    Route::post('settings/store', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'storeProfileSettingsUPdate'])->name('tenant.store.profile.update');
    Route::get('settings/profile', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'profile'])->name('tenant.profile');
    Route::post('settings/profile/account_update', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'profileAccountUpdate'])->name('tenant.profile.account.update');
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'profileInfoUpdate'])->name('tenant.profile.info.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'password'])->name('tenant.password');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'passwordUpdate'])->name('tenant.password.update');
    Route::get('settings/rekening', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'rekeingSetting'])->name('tenant.rekening.setting');

    Route::get('request/umi', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'umiRequestForm'])->name('tenant.request.umi');
    Route::post('request/umi', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'umiRequestProcess'])->name('tenant.request.umi.send');
});

Route::middleware(['guest:kasir', 'throttle'])->prefix('kasir')->group( function () {

    Route::get('login', [App\Http\Controllers\Auth\Kasir\LoginController::class, 'create'])->name('kasir.login');
    Route::post('login', [App\Http\Controllers\Auth\Kasir\LoginController::class, 'store'])->name('kasir.login.process');

    // Route::get('register', [App\Http\Controllers\Auth\Kasir\RegisterController::class, 'create'])->name('kasir.register');
    // Route::post('register', [App\Http\Controllers\Auth\Kasir\RegisterController::class, 'store']);

});

Route::middleware(['auth:kasir', 'throttle', 'isKasirActive'])->prefix('kasir')->group( function () {

    Route::post('logout', [App\Http\Controllers\Auth\Kasir\LoginController::class, 'destroy'])->name('kasir.logout');

    Route::get('/dashboard', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'index'])->name('kasir.dashboard');
    Route::get('/dashboard/pos', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'kasirPos'])->name('kasir.pos');
    Route::post('/dashboard/pos/addcart', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'addCart'])->name('kasir.pos.addCart');
    Route::get('/dashboard/pos/allitem', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'allItem'])->name('kasir.pos.allitem');
    Route::post('/dashboard/pos/update', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'updateCart'])->name('kasir.pos.updateCart');
    Route::get('/dashboard/pos/delete/{id}', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'removeCart'])->name('kasir.pos.deleteCart');
    Route::post('/dashboard/pos/transaction/save', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionSave'])->name('kasir.pos.transaction.save');
    Route::post('/dashboard/pos/transaction/clear', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionClear'])->name('kasir.pos.transaction.clear');
    Route::post('/dashboard/pos/transaction/process', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionProcess'])->name('kasir.pos.transaction.process');
    Route::get('/dashboard/pos/transaction/process/invoice/{id}', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionInvoice'])->name('kasir.pos.transaction.invoice');
    Route::get('/dashboard/pos/transaction/process/invoice/receipt/{id}', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionInvoiceReceipt'])->name('kasir.pos.transaction.invoice.receipt');

    Route::get('/dashboard/transaction', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionDashboard'])->name('kasir.transaction');
    Route::get('/dashboard/transaction/list', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionList'])->name('kasir.transaction.list');
    Route::get('/dashboard/transaction/pending', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionPending'])->name('kasir.transaction.pending');
    Route::get('/dashboard/transaction/restore/{id}', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionPendingRestore'])->name('kasir.transaction.pending.restore');
    Route::post('/dashboard/transaction/pending/addcart', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionPendingAddCart'])->name('kasir.transaction.pending.addCart');
    Route::post('/dashboard/transaction/pending/updatecart', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionPendingUpdateCart'])->name('kasir.transaction.pending.updateCart');
    Route::post('/dashboard/transaction/pending/deletecart', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionPendingDeleteCart'])->name('kasir.transaction.pending.deleteCart');
    Route::get('/dashboard/transaction/pending/delete/{id}', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionPendingDelete'])->name('kasir.transaction.pending.delete');
    Route::post('/dashboard/transaction/pending/process', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionPendingProcess'])->name('kasir.pos.transaction.pending.process');
    Route::post('/dashboard/transaction/pending/change-payment', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'cartTransactionPendingChangePayment'])->name('kasir.pos.transaction.pending.changePayment');

    Route::get('/dashboard/transaction/pending/payment', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionPendingPayment'])->name('kasir.transaction.pending.payment');
    Route::get('/dashboard/transaction/finish', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'transactionFinish'])->name('kasir.transaction.finish');

    Route::get('settings', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'kasirSettings'])->name('kasir.settings');
    Route::get('settings/profile', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'profile'])->name('kasir.profile');
    Route::post('settings/profile/account_update', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'profileAccountUpdate'])->name('kasir.profile.account.update');
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'profileInfoUpdate'])->name('kasir.profile.info.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'password'])->name('kasir.password');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'passwordUpdate'])->name('kasir.password.update');

    Route::get('tesprint', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'testPrint']);
    Route::get('testime', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'testTimestamp']);
});

require __DIR__.'/auth.php';
