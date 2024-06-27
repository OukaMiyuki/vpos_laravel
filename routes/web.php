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

Route::middleware(['guest', 'throttle'])->prefix('/')->group( function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('access.login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'store'])->name('process.login');
    Route::get('/login/reset-password', [App\Http\Controllers\Auth\LoginController::class, 'resetPassword'])->name('access.reset.password');
    Route::post('/login/reset-password', [App\Http\Controllers\Auth\LoginController::class, 'resetPasswordSerachAccount'])->name('access.reset.password.searchAccount');
    Route::post('/login/reset-password/send-otp', [App\Http\Controllers\Auth\LoginController::class, 'resetPasswordSendOTP'])->name('access.reset.password.sendOTP');
    Route::post('/login/reset-password/change-password', [App\Http\Controllers\Auth\LoginController::class, 'resetPasswordOTPVerification'])->name('access.reset.password.OTPVerification');
    Route::post('/login/reset-password/change-password/process', [App\Http\Controllers\Auth\LoginController::class, 'resetPasswordChangePassword'])->name('access.reset.password.process');
});

Route::middleware(['auth:admin', 'auth', 'throttle'])->prefix('admin')->group( function () {
    Route::get('settings', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'adminSettings'])->name('admin.setting');
    Route::get('settings/profile', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'profile'])->name('admin.profile');
    Route::post('settings/profile/account_update', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'profileAccountUpdate'])->name('admin.profile.account.update');
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'profileInfoUpdate'])->name('admin.profile.info.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'password'])->name('admin.password');
    Route::post('settings/request/send-whatsapp-otp', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'whatsappNotification'])->middleware(['throttle:90,1'])->name('admin.settings.whatsappotp');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'passwordUpdate'])->name('admin.password.update');
});

Route::middleware(['auth:admin', 'auth', 'throttle'])->prefix('admin')->group( function () {
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'destroy'])->name('admin.logout');
    Route::get('/dashboard', [App\Http\Controllers\Auth\Admin\AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('settings/rekening', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'rekeningList'])->name('admin.rekening.setting');
    Route::get('settings/rekening/add', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'rekeningListAdd'])->name('admin.rekening.setting.add');
    Route::post('settings/rekening/add', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'rekeningListInsert'])->name('admin.rekening.setting.insert');
    Route::get('settings/rekening/edit/{id}', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'rekeningListEdit'])->name('admin.rekening.setting.edit');
    Route::post('settings/rekening', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'rekeningSettingUpdate'])->name('admin.rekening.setting.update');

    Route::get('settings/wiithdraw', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'adminWithdraw'])->name('admin.withdraw');
    Route::post('settings/wiithdraw', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'adminWithdrawTarik'])->name('admin.withdraw.tarik');
    Route::post('settings/wiithdraw/process', [App\Http\Controllers\Auth\Admin\ProfileController::class, 'adminWithdrawTarikProcess'])->name('admin.withdraw.tarik.process');

    Route::get('/dashboard/admin', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuDashboard'])->name('admin.dashboard.menu');
    Route::get('/dashboard/user/transaction', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserTransaction'])->name('admin.dashboard.menu.userTransaction');
    Route::get('/dashboard/user/transaction/settlement-ready', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserTransactionSettlementReady'])->name('admin.dashboard.menu.userTransaction.settlementReady');
    Route::get('/dashboard/user/withdrawals', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserWithdrawals'])->name('admin.dashboard.menu.userWithdrawals');
    Route::get('/dashboard/user/withdrawals/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserWithdrawalDetail'])->name('admin.dashboard.menu.userWithdrawals.detail');
    Route::get('/dashboard/user/request-umi', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserUmiRequest'])->name('admin.dashboard.menu.userUmiRequest');
    Route::post('/dashboard/user/request-umi/approve', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserUmiRequestApprove'])->name('admin.dashboard.menu.userUmiRequest.approve');
    Route::post('/dashboard/user/request-umi/reject', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserUmiRequestReject'])->name('admin.dashboard.menu.userUmiRequest.reject');
    Route::get('/dashboard/user/request-umi/download/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserUmiRequestDownload'])->name('admin.dashboard.menu.userUmiRequest.download');
    Route::get('/dashboard/user/tenant-qris', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserTenantQris'])->name('admin.dashboard.menu.userTenantQris');
    Route::post('/dashboard/user/tenant-qris', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserTenantQrisRegister'])->name('admin.dashboard.menu.userTenantQris.register');
    Route::post('/dashboard/user/tenant-qris/update', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserTenantQrisUpdate'])->name('admin.dashboard.menu.userTenantQris.update');
    Route::get('/dashboard/user/tenant-qris/delete/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMenuUserTenantQrisDelete'])->name('admin.dashboard.menu.userTenantQris.delete');

    Route::get('/dashboard/administrator', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminList'])->name('admin.dashboard.administrator.list');
    Route::get('/dashboard/administrator/register', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminCreate'])->name('admin.dashboard.administrator.create');
    Route::post('/dashboard/administrator/register', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminRegister'])->name('admin.dashboard.administrator.register');
    Route::get('/dashboard/administrator/activation/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminActivation'])->name('admin.dashboard.administrator.activation');
    Route::get('/dashboard/administrator/detail/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDetail'])->name('admin.dashboard.administrator.detail');

    Route::get('dashboard/saldo', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSaldo'])->name('admin.dashboard.saldo');
    Route::get('dashboard/saldo/qris', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSaldoQris'])->name('admin.dashboard.saldo.qris');
    Route::get('dashboard/saldo/agregate', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSaldoAgregate'])->name('admin.dashboard.saldo.agregate');
    Route::get('dashboard/saldo/agregate-aplikasi', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSaldoAgregateAplikasi'])->name('admin.dashboard.saldo.agregate.aplikasi');
    Route::get('dashboard/saldo/agregate-transfer', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSaldoAgregateTransfer'])->name('admin.dashboard.saldo.agregate.transfer');
    Route::get('dashboard/saldo/data-history-cashback', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSaldoCashback'])->name('admin.dashboard.saldo.cashback');
    Route::get('dashboard/saldo/data-history-cashback-settlement-pending', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSaldoCashbackPending'])->name('admin.dashboard.saldo.cashback.settlement');
    Route::get('dashboard/saldo/data-bank-fee-transfer', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardNobuFeeTransfer'])->name('admin.dashboard.saldo.nobu.fee.transfer');

    Route::get('dashboard/mitra-aplikasi', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMarketing'])->name('admin.dashboard.marketing');
    Route::get('dashboard/mitra-aplikasi/list', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMarketingList'])->name('admin.dashboard.marketing.list');
    Route::get('dashboard/mitra-aplikasi/profile/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMarketingProfile'])->name('admin.dashboard.marketing.profile');
    Route::get('dashboard/mitra-aplikasi/activation/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminMarketingAccountActivation'])->name('admin.dashboard.marketing.account.activation');
    Route::get('dashboard/mitra-aplikasi/invitation-code', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMarketingInvitationCodeList'])->name('admin.dashboard.marketing.invitationcode');
    Route::get('dashboard/mitra-aplikasi/invitation-code/activation/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMarketingInvitationCodeListActivation'])->name('admin.dashboard.marketing.invitationcode.activation');
    Route::get('dashboard/mitra-aplikasi/invitation-code/store/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMarketingInvitationCodeStoreList'])->name('admin.dashboard.marketing.invitationcode.store.list');
    Route::get('dashboard/mitra-aplikasi/invitation-code/income/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMarketingInvitationCodeIncomeList'])->name('admin.dashboard.marketing.invitationcode.income.list');
    Route::get('dashboard/mitra-aplikasi/withdraw', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMarketingWithdrawalList'])->name('admin.dashboard.marketing.withdraw');

    Route::get('dashboard/mitra-bisnis', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnis'])->name('admin.dashboard.mitraBisnis');
    Route::get('dashboard/mitra-bisnis/list', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisList'])->name('admin.dashboard.mitraBisnis.list');
    Route::get('dashboard/mitra-bisnis/profile/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisProfile'])->name('admin.dashboard.mitraBisnis.profile');
    Route::get('dashboard/mitra-bisnis/activation/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisActivation'])->name('admin.dashboard.mitraBisnis.activation');
    Route::get('dashboard/mitra-bisnis/merchant', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisMerchantList'])->name('admin.dashboard.mitraBisnis.merchantList');
    Route::get('dashboard/mitra-bisnis/merchant/invoice/{id}/{store_identifier}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisMerchantInvoiceList'])->name('admin.dashboard.mitraBisnis.merchantList.invoice');
    Route::get('dashboard/mitra-bisnis/merchant/detail/{id}/{store_identifier}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisMerchantDetail'])->name('admin.dashboard.mitraBisnis.merchantList.detail');
    Route::get('dashboard/mitra-bisnis/merchant/activation/{id}/{store_identifier}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisMerchantActivation'])->name('admin.dashboard.mitraBisnis.merchantList.activation');
    Route::get('dashboard/mitra-bisnis/umi', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisUMIList'])->name('admin.dashboard.mitraBisnis.umi.list');
    Route::get('dashboard/mitra-bisnis/qris', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisQrisList'])->name('admin.dashboard.mitraBisnis.qris.list');
    Route::get('dashboard/mitra-bisnis/transaction', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisTransactionList'])->name('admin.dashboard.mitraBisnis.transactionList');
    Route::get('dashboard/mitra-bisnis/withdrawals', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisWithdrawalList'])->name('admin.dashboard.mitraBisnis.withdrawList');

    Route::get('dashboard/mitra-tenant', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenant'])->name('admin.dashboard.mitraTenant');
    Route::get('dashboard/mitra-tenant/list', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantList'])->name('admin.dashboard.mitraTenant.list');
    Route::get('dashboard/mitra-tenant/profile/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantDetail'])->name('admin.dashboard.mitraTenant.detail');
    Route::get('dashboard/mitra-tenant/activation/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantActivation'])->name('admin.dashboard.mitraTenant.activation');
    Route::get('dashboard/mitra-tenant/store', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantStoreList'])->name('admin.dashboard.mitraTenant.store.list');
    Route::get('dashboard/mitra-tenant/store/invoice/{id}/{store_identifier}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantStoreInvoiceList'])->name('admin.dashboard.mitraTenant.store.invoice');
    Route::get('dashboard/mitra-tenant/store/detail/{id}/{store_identifier}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantStoreDetail'])->name('admin.dashboard.mitraTenant.store.detail');
    Route::get('dashboard/mitra-tenant/kasir', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantKasirList'])->name('admin.dashboard.mitraTenant.kasir.list');
    Route::get('dashboard/mitra-tenant/kasir/profile/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantKasirProfile'])->name('admin.dashboard.mitraTenant.kasir.profile');
    Route::get('dashboard/mitra-tenant/kasir/activation/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantKasirActivation'])->name('admin.dashboard.mitraTenant.kasir.activation');
    Route::get('dashboard/mitra-tenant/umi', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantUMIList'])->name('admin.dashboard.mitraTenant.umi.list');
    Route::get('dashboard/mitra-tenant/qris', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantQrisList'])->name('admin.dashboard.mitraTenant.qris.list');
    Route::get('dashboard/mitra-tenant/transaction', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantTransactionList'])->name('admin.dashboard.mitraTenant.transaction.list');
    Route::get('dashboard/mitra-tenant/withdrawals', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraTenantWithdrawalList'])->name('admin.dashboard.mitraTenant.withdraw.list');

    Route::get('dashboard/finance', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardFinance'])->name('admin.dashboard.finance');
    Route::get('dashboard/finance/withdraw-invoice/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardFinanceInvoice'])->name('admin.dashboard.finance.withdraw.invoice');
    Route::get('dashboard/finance/insentif', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardInsentifSettingList'])->name('admin.dashboard.finance.insentif.list');
    Route::post('dashboard/finance/insentif', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardInsentifSettingInsert'])->name('admin.dashboard.finance.insentif.insert');
    Route::post('dashboard/finance/insentif/update', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardInsentifSettingUpdate'])->name('admin.dashboard.finance.insentif.update');
    Route::get('dashboard/finance/insentif/delete/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardInsentifSettingDelete'])->name('admin.dashboard.finance.insentif.delete');
    Route::get('dashboard/finance/settlement', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSettlementSettingList'])->name('admin.dashboard.finance.settlement.list');
    Route::post('dashboard/finance/settlement', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSettlementSettingListInsert'])->name('admin.dashboard.finance.settlement.insert');
    Route::get('dashboard/finance/settlement/delete/{id}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSettlementDelete'])->name('admin.dashboard.finance.settlement.delete');
    Route::post('dashboard/finance/settlement/update', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSettlementSettingListUpdate'])->name('admin.dashboard.finance.settlement.update');
    Route::get('dashboard/finance/settlement/pending', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSettlementPending'])->name('admin.dashboard.finance.settlement.pending');
    Route::get('dashboard/finance/settlement/history', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSettlementHistory'])->name('admin.dashboard.finance.settlement.history');
    Route::get('dashboard/finance/settlement/history/{id}/{code}', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardSettlementHistoryDetail'])->name('admin.dashboard.finance.settlement.history.detail');

    Route::get('dashboard/application/app-version', [App\Http\Controllers\Auth\Admin\AccessController::class, 'adminDashboardAppVersion'])->name('admin.dashboard.application.appversion');
    Route::post('dashboard/application/app-version', [App\Http\Controllers\Auth\Admin\AccessController::class, 'adminDashboardAppVersionUpdate'])->name('admin.dashboard.application.appversion.update');

    Route::get('dashboard/history', [App\Http\Controllers\Auth\Admin\AccessController::class, 'adminDashboardHistory'])->name('admin.dashboard.history');
    Route::get('dashboard/history/user-login', [App\Http\Controllers\Auth\Admin\AccessController::class, 'adminDashboardHistoryUserLogin'])->name('admin.dashboard.history.user.login');
    Route::get('dashboard/history/user-register', [App\Http\Controllers\Auth\Admin\AccessController::class, 'adminDashboardHistoryUserRegister'])->name('admin.dashboard.history.user.register');
    Route::get('dashboard/history/user-activity', [App\Http\Controllers\Auth\Admin\AccessController::class, 'adminDashboardHistoryUserActivity'])->name('admin.dashboard.history.user.activity');
    Route::get('dashboard/history/user-withdrawal', [App\Http\Controllers\Auth\Admin\AccessController::class, 'adminDashboardHistoryUserWithdrawal'])->name('admin.dashboard.history.user.withdraw');
    Route::get('dashboard/history/error', [App\Http\Controllers\Auth\Admin\AccessController::class, 'adminDashboardHistoryUserError'])->name('admin.dashboard.history.user.error');
    Route::get('dashboard/history/detail/{activity}/{id}', [App\Http\Controllers\Auth\Admin\AccessController::class, 'adminDashboardHistoryDetail'])->name('admin.dashboard.history.user.detail');



    Route::post('dashboard/mitra-bisnis/transaction/testing', [App\Http\Controllers\Auth\Admin\AdminController::class, 'adminDashboardMitraBisnisTransactionListTesting'])->name('admin.dashboard.mitraBisnis.transactionList.testingWoi');
});


Route::middleware(['guest:marketing', 'throttle'])->prefix('marketing')->group( function () {
    Route::get('register', [App\Http\Controllers\Auth\Marketing\RegisterController::class, 'create'])->name('marketing.register');
    Route::post('register', [App\Http\Controllers\Auth\Marketing\RegisterController::class, 'store']);

});

Route::middleware(['auth:marketing', 'auth', 'throttle'])->prefix('marketing')->group( function () {
    Route::get('/verify-email', [App\Http\Controllers\Auth\Marketing\EmailVerificationPromptController::class, 'emailVerificationView'])->name('marketing.verification.notice');
    Route::post('verify-email', [App\Http\Controllers\Auth\Marketing\VerifyEmailController::class, 'processVerification'])
                ->middleware(['throttle:80,1'])
                ->name('marketing.verification.verify');
    Route::post('email/verification-notification', [App\Http\Controllers\Auth\Marketing\EmailVerificationNotificationController::class, 'store'])
                ->middleware(['throttle:80,1'])
                ->name('marketing.verification.send');

    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'destroy'])->name('marketing.logout');
});

Route::middleware(['auth:marketing', 'auth', 'marketingemailverified', 'throttle', 'isMarketingActive'])->prefix('mitra')->group( function () {
    Route::get('/dashboard', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'index'])->name('marketing.dashboard');

    Route::post('settings/request/send-whatsapp-otp', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'whatsappNotification'])->middleware(['throttle:90,1'])->name('marketing.settings.whatsappotp');
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
    Route::get('/dashboard/code/cashout/info/{code}', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invitationCodeCashoutList'])->name('marketing.dashboard.invitationcode.cashout.list');
    Route::get('/dashboard/code/cashout/invoice', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invitationCodeCashoutInvoice'])->name('marketing.dashboard.invitationcode.cashout.invoice');

    Route::get('/dashboard/code/tenant/', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'marketingTenantList'])->name('marketing.dashboard.tenant.list');
    Route::get('/dashboard/code/tenant/detail/{inv_code}/{id}', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'marketingTenantDetail'])->name('marketing.dashboard.tenant.detail');

    Route::get('/dashboard/code/pemasukan', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'marketingPemasukanList'])->name('marketing.dashboard.pemasukan');
    Route::get('/dashboard/code/pemasukan/today', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'marketingPemasukanListToday'])->name('marketing.dashboard.pemasukan.today');
    Route::get('/dashboard/code/pemasukan/this-month', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'marketingPemasukanListMonth'])->name('marketing.dashboard.pemasukan.month');

    Route::get('/dashboard/merchant', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'marketingMerchant'])->name('marketing.dashboard.merchant');

    Route::get('/dashboard/finance', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'financeDashboard'])->name('marketing.finance');
    Route::get('/dashboard/finance/saldo', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'financeSaldo'])->name('marketing.finance.saldo');
    Route::get('/dashboard/finance/history-penarikan', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'historyPenarikan'])->name('marketing.finance.history_penarikan');
    Route::get('/dashboard/finance/history-penarikan/{id}', [App\Http\Controllers\Auth\Marketing\MarketingController::class, 'invoiceTarikDana'])->name('marketing.finance.history_penarikan.invoice');

    Route::get('settings/withdraw', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'withdraw'])->name('marketing.withdraw');
    Route::post('settings/withdraw', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'withdrawProcess'])->name('marketing.withdraw.process');

    Route::post('settings/profile/tarik-dana', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'tarikDanaQris'])->name('marketing.profile.tarik');
    Route::post('settings/profile/tarik-dana/proses', [App\Http\Controllers\Auth\Marketing\ProfileController::class, 'prosesTarikDana'])->name('marketing.profile.tarik.proses');
});

Route::middleware(['guest:tenant', 'throttle'])->prefix('tenant')->group( function () {

    Route::get('register', [App\Http\Controllers\Auth\Tenant\RegisterController::class, 'create'])->name('tenant.register');
    Route::post('register', [App\Http\Controllers\Auth\Tenant\RegisterController::class, 'store']);

    Route::prefix('mitra')->group(function() {
        Route::get('register', [App\Http\Controllers\Auth\Tenant\RegisterController::class, 'createMitra'])->name('tenant.mitra.register');
        Route::post('register', [App\Http\Controllers\Auth\Tenant\RegisterController::class, 'storeMitra'])->name('tenant.mitra.register.insert');
    });
});

Route::middleware(['auth:tenant', 'auth', 'throttle'])->prefix('tenant')->group( function () {
    Route::get('/verify-email', [App\Http\Controllers\Auth\Tenant\EmailVerificationPromptController::class, 'emailVerificationView'])->name('tenant.verification.notice');
    Route::post('verify-email', [App\Http\Controllers\Auth\Tenant\VerifyEmailController::class, 'processVerification'])
                    ->middleware(['throttle:80,1'])
                    ->name('tenant.verification.verify');
    Route::post('email/verification-notification', [App\Http\Controllers\Auth\Tenant\EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:80,1')
                ->name('tenant.verification.send');

    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'destroy'])->name('tenant.logout');
});

Route::middleware(['auth:tenant', 'auth', 'tenantemailverivied', 'throttle', 'isTenantActive'])->prefix('tenant')->group( function () {
    Route::get('settings', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'tenantSettings'])->name('tenant.settings');
    Route::post('settings/request/send-whatsapp-otp', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'whatsappNotification'])->middleware(['throttle:90,1'])->name('tenant.settings.whatsappotp');
    Route::post('settings/validate/whatsapp-otp', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'whatsappOTPSubmit'])->name('tenant.settings.whatsappotp.validate');

    Route::get('settings/profile', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'profile'])->name('tenant.profile');
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'profileInfoUpdate'])->name('tenant.profile.info.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'password'])->name('tenant.password');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'passwordUpdate'])->name('tenant.password.update');
    Route::get('settings/rekening', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'rekeingSetting'])->name('tenant.rekening.setting');
    Route::post('settings/rekening', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'rekeningSettingUpdate'])->name('tenant.rekening.setting.update');

    Route::get('settings/withdraw', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'withdraw'])->name('tenant.withdraw');
    Route::post('settings/withdraw', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'withdrawProcess'])->name('tenant.withdraw.process');

    Route::get('/dashboard/finance/history-penarikan', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'historyPenarikan'])->name('tenant.finance.history_penarikan');
    Route::get('/dashboard/finance/history-penarikan/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'invoiceTarikDana'])->name('tenant.finance.history_penarikan.invoice');
});

Route::middleware(['auth:tenant', 'auth', 'tenantemailverivied', 'throttle', 'isTenantActive', 'isTenantIsNotMitra'])->prefix('/tenant/mitra')->group( function () {
    Route::get('/dashboard', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'index'])->name('tenant.mitra.dashboard');

    Route::get('/dashboard/store', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'storeDashboard'])->name('tenant.mitra.dashboard.toko');
    Route::get('/dashboard/store/list', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'storeList'])->name('tenant.mitra.dashboard.toko.list');
    Route::get('/dashboard/store/create', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'storeCreate'])->name('tenant.mitra.dashboard.toko.create');
    Route::post('/dashboard/store/create', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'storeRegister'])->name('tenant.mitra.dashboard.toko.register');
    Route::get('/dashboard/store/edit/{id}', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'storeEdit'])->name('tenant.mitra.dashboard.toko.edit');
    Route::post('/dashboard/store/update', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'storeUpdate'])->name('tenant.mitra.dashboard.toko.update');
    Route::get('/dashboard/store/detail/{id}/{store_identifier}', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'storeDetail'])->name('tenant.mitra.dashboard.toko.detail');
    Route::get('/dashboard/store/invoice/{store_identifier}', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'storeInvoiceList'])->name('tenant.mitra.dashboard.toko.invoice');
    Route::post('/dashboard/store/request_umi', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'requestUmi'])->name('tenant.mitra.dashboard.toko.request.umi');
    Route::post('/dashboard/store/request_umi/resend', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'requestUmiResend'])->name('tenant.mitra.dashboard.toko.request.umi.resend');
    Route::get('/dashboard/store/request_umi', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'umiRequestList'])->name('tenant.mitra.dashboard.toko.request.umi.list');
    Route::get('/dashboard/transaction/', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'transationDashboard'])->name('tenant.mitra.dashboard.transaction');
    Route::get('/dashboard/transaction/list', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'transationAll'])->name('tenant.mitra.dashboard.transaction.all_transaction');
    Route::get('/dashboard/transaction/today', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'transationAllToday'])->name('tenant.mitra.dashboard.transaction.all_today_transaction');
    Route::get('/dashboard/transaction/list/pending_payment', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'transationPending'])->name('tenant.mitra.dashboard.transaction.pending_transaction');
    Route::get('/dashboard/transaction/list/finish_payment', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'transationFinish'])->name('tenant.mitra.dashboard.transaction.finish_transaction');
    Route::get('/dashboard/transaction/list/finish_payment_today', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'transationFinishToday'])->name('tenant.mitra.dashboard.transaction.finish_transaction_today');
    Route::get('/dashboard/transaction/store/{store_identifier}', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'transationStore'])->name('tenant.mitra.dashboard.transaction.store');

    Route::get('/dashboard/application', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'appDashboard'])->name('tenant.mitra.dashboard.app');
    Route::get('/dashboard/application/qris', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'qrisAccountList'])->name('tenant.mitra.dashboard.app.qrisacc');
    Route::get('/dashboard/application/setting', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'qrisApiSetting'])->name('tenant.mitra.dashboard.app.setting');
    Route::post('/dashboard/application/setting/generate-key', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'qrisApiSettingGenerateKey'])->name('tenant.mitra.dashboard.app.setting.generateKey');
    Route::post('/dashboard/application/setting/update-callback', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'qrisApiSettingUpdateCallback'])->name('tenant.mitra.dashboard.app.setting.updateCallback');

    Route::get('/dashboard/finance', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'financeDashboard'])->name('tenant.mitra.dashboard.finance');
    Route::get('/dashboard/finance/saldo', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'saldoData'])->name('tenant.mitra.dashboard.finance.saldo');

    Route::get('/dashboard/finance/saldo/invoice-transaksi-qris-yesterday', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'pemasukanQrisPending'])->name('tenant.mitra.dashboard.finance.pemasukan.qris.pending');
    Route::get('/dashboard/finance/saldo/invoice-transaksi-qris-today', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'pemasukanQrisToday'])->name('tenant.mitra.dashboard.finance.pemasukan.qris.today');
    Route::get('/dashboard/finance/saldo/invoice-transaksi-qris-all', [App\Http\Controllers\Auth\Tenant\Mitra\TenantMitraController::class, 'pemasukanQris'])->name('tenant.mitra.dashboard.finance.pemasukan.qris.all');
});

Route::middleware(['auth:tenant', 'auth', 'tenantemailverivied', 'throttle', 'isTenantActive', 'isTenantIsMitra'])->prefix('tenant')->group( function () {
    Route::get('request/umi', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'umiRequestForm'])->name('tenant.request.umi');
    Route::post('request/umi', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'umiRequestProcess'])->name('tenant.request.umi.send');
    Route::post('request/umi/resend', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'umiRequestProcessResend'])->name('tenant.request.umi.resend');

    Route::get('/dashboard', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'index'])->name('tenant.dashboard');
    Route::get('/dashboard/kasir', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'tenantKasirDashboard'])->name('tenant.kasir');
    Route::get('/dashboard/kasir/list', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirList'])->name('tenant.kasir.list');
    Route::get('/dashboard/kasir/list/active', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirListActive'])->name('tenant.kasir.list.active');
    Route::get('/dashboard/kasir/list/non-aktif', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirListNonActive'])->name('tenant.kasir.list.non.active');
    Route::get('/dashboard/kasir/info/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirDetail'])->name('tenant.kasir.detail');
    Route::get('/dashboard/kasir/activation/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirActivate'])->name('tenant.kasir.activation');
    Route::post('/kasir/register', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'kasirRegister'])->name('tenant.register.kasir');

    Route::get('/dashboard/pos', [App\Http\Controllers\Auth\Tenant\PosController::class, 'pos'])->name('tenant.pos');
    Route::post('/dashboard/pos/addcart', [App\Http\Controllers\Auth\Tenant\PosController::class, 'addCart'])->name('tenant.pos.addcart');
    Route::post('/dashboard/pos/update', [App\Http\Controllers\Auth\Tenant\PosController::class, 'updateCart'])->name('tenant.pos.updateCart');
    Route::get('/dashboard/pos/delete/{id}', [App\Http\Controllers\Auth\Tenant\PosController::class, 'removeCart'])->name('tenant.pos.deleteCart');
    Route::post('/dashboard/pos/process', [App\Http\Controllers\Auth\Tenant\PosController::class, 'cartTransactionProcess'])->name('tenant.pos.process');
    Route::get('/dashboard/pos/invoice/{id}', [App\Http\Controllers\Auth\Tenant\PosController::class, 'cartTransactionInvoice'])->name('tenant.pos.invoice');
    Route::get('/dashboard/pos/invoice/receipt/{id}', [App\Http\Controllers\Auth\Tenant\PosController::class, 'cartTransactionInvoiceReceipt'])->name('tenant.pos.invoice.receipt');
    Route::post('/dashboard/pos/invoice/change-payment', [App\Http\Controllers\Auth\Tenant\PosController::class, 'cartTransactionPendingChangePayment'])->name('tenant.pos.invoice.changePayment');
    Route::post('/dashboard/pos/invoice/save', [App\Http\Controllers\Auth\Tenant\PosController::class, 'cartTransactionSave'])->name('tenant.pos.invoice.save');
    Route::post('/dashboard/pos/invoice/clear', [App\Http\Controllers\Auth\Tenant\PosController::class, 'cartTransactionClear'])->name('tenant.pos.invoice.clear');

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

    Route::get('/dashboard/transaction', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionList'])->name('tenant.transaction');
    Route::get('/dashboard/transaction/tunai', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionListTunai'])->name('tenant.transaction.list.tunai');
    Route::get('/dashboard/transaction/qris', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionListQris'])->name('tenant.transaction.list.qris');
    Route::get('/dashboard/transaction/list/pending', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionListPending'])->name('tenant.transaction.list.pending');
    Route::get('/dashboard/transaction/list/pending-payment', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionListPendingPayment'])->name('tenant.transaction.list.pending.payment');

    Route::get('/dashboard/transaction/list/pending/delete/{id}', [App\Http\Controllers\Auth\Tenant\PosController::class, 'transactionPendingDelete'])->name('tenant.transaction.pending.delete');
    Route::get('/dashboard/transaction/list/pending/restore/{id}', [App\Http\Controllers\Auth\Tenant\PosController::class, 'transactionPendingRestore'])->name('tenant.transaction.list.pending.restore');
    Route::post('/dashboard/transaction/list/pending/addcart', [App\Http\Controllers\Auth\Tenant\PosController::class, 'transactionPendingAddCart'])->name('tenant.transaction.pending.addCart');
    Route::post('/dashboard/transaction/list/pending/updatecart', [App\Http\Controllers\Auth\Tenant\PosController::class, 'transactionPendingUpdateCart'])->name('tenant.transaction.pending.updateCart');
    Route::post('/dashboard/transaction/list/pending/deletecart', [App\Http\Controllers\Auth\Tenant\PosController::class, 'transactionPendingDeleteCart'])->name('tenant.transaction.pending.deleteCart');
    Route::post('/dashboard/transaction/list/pending/process', [App\Http\Controllers\Auth\Tenant\PosController::class, 'cartTransactionPendingProcess'])->name('tenant.pos.transaction.pending.process');

    Route::get('/dashboard/transaction/list/invoice/{id}', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'transactionInvoiceView'])->name('tenant.transaction.invoice');

    Route::get('/dashboard/pemasukan', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'pemasukan'])->name('tenant.pemasukan');
    Route::get('/dashboard/pemasukan/qris', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'pemasukanQrisAll'])->name('tenant.pemasukan.qris');

    Route::get('/dashboard/finance', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'financeDashboard'])->name('tenant.finance');
    Route::get('/dashboard/finance/saldo', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'saldoData'])->name('tenant.saldo');
    Route::get('/dashboard/finance/saldo/invoice-transaksi-qris-settlement', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'pemasukanQrisPending'])->name('tenant.finance.pemasukan.qris.pending');
    Route::get('/dashboard/finance/saldo/invoice-transaksi-qris-today', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'pemasukanQrisToday'])->name('tenant.finance.pemasukan.qris.today');
    Route::get('/dashboard/finance/saldo/settlement', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'settlement'])->name('tenant.finance.settlement');

    Route::get('/dashboard/management', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'storeManagement'])->name('tenant.store.management');
    Route::get('/dashboard/management/discount', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'discountModify'])->name('tenant.discount.modify');
    Route::post('/dashboard/management/discount/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'discountModifyInsert'])->name('tenant.discount.insert');
    Route::get('/dashboard/management/pajak', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'pajakModify'])->name('tenant.pajak.modify');
    Route::post('/dashboard/management/pajak/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'pajakModifyInsert'])->name('tenant.pajak.modify.insert');
    Route::get('/dashboard/management/custom_fields', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'customField'])->name('tenant.customField.modify');
    Route::post('/dashboard/management/custom_fields/insert', [App\Http\Controllers\Auth\Tenant\TenantController::class, 'customFieldInsert'])->name('tenant.customField.modify.insert');

    Route::get('settings/store', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'storeProfileSettings'])->name('tenant.store.profile');
    Route::post('settings/store', [App\Http\Controllers\Auth\Tenant\ProfileController::class, 'storeProfileSettingsUPdate'])->name('tenant.store.profile.update');
});

Route::middleware(['auth:kasir', 'auth', 'throttle', 'isKasirActive', 'isKasirStoreActive'])->prefix('kasir')->group( function () {

    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'destroy'])->name('kasir.logout');

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
    Route::post('settings/profile/info_update', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'profileInfoUpdate'])->name('kasir.profile.info.update');
    Route::get('settings/password', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'password'])->name('kasir.password');
    Route::post('settings/password/update', [App\Http\Controllers\Auth\Kasir\ProfileController::class, 'passwordUpdate'])->name('kasir.password.update');

    Route::get('tesprint', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'testPrint']);
    Route::get('testime', [App\Http\Controllers\Auth\Kasir\KasirController::class, 'testTimestamp']);
});

require __DIR__.'/auth.php';
