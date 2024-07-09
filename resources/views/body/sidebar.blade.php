<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{ !empty(auth()->user()->detail->photo) ? Storage::url('images/profile/'.auth()->user()->detail->photo) : asset('assets/images/blank_profile.png') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="#" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown">{{ auth()->user()->name }}</a>
                <div class="dropdown-menu user-pro-dropdown">
                    <!-- item-->
                    <a href="
                        @auth('admin')
                            {{ route('admin.profile') }}
                        @endauth
                        @auth('marketing')
                            {{ route('marketing.profile') }}
                        @endauth
                        @auth('tenant')
                            {{ route('tenant.profile') }}
                        @endauth
                        @auth('kasir')

                        @endauth
                    " class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>
                    <!-- item-->
                    <a href="#" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>
                    <!-- item-->
                    <a href="
                        @auth('admin')
                            {{ route('admin.password') }}
                        @endauth
                        @auth('marketing')
                            {{ route('marketing.password') }}
                        @endauth
                        @auth('tenant')
                            {{ route('tenant.password') }}
                        @endauth
                        @auth('kasir')

                        @endauth
                    " class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Change Password</span>
                    </a>
                    <!-- item-->
                    @auth('admin')
                        <form method="POST" action="{{route('admin.logout')}}">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item">
                                <i class="fe-log-out me-1"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endauth
                    @auth('marketing')
                        <form method="POST" action="{{route('marketing.logout')}}">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item">
                                <i class="fe-log-out me-1"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endauth
                    @auth('tenant')
                        <form method="POST" action="{{route('tenant.logout')}}">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item">
                                <i class="fe-log-out me-1"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endauth
                    @auth('kasir')
                        <form method="POST" action="{{route('kasir.logout')}}">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item">
                                <i class="fe-log-out me-1"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
            <p class="text-muted">
                @auth('admin')
                    Super User
                @endauth
                @auth('marketing')
                    Mitra Aplikasi
                @endauth
                @auth('tenant')
                    @if (auth()->user()->id_inv_code == 0)
                        Mitra Bisnis
                    @else
                        Tenant
                    @endif
                @endauth
                @auth('kasir')
                    Kasir
                @endauth
            </p>
        </div>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="menu-title">Navigation</li>
                <li>
                    <a href="
                    @auth('admin')
                        {{ route('admin.dashboard') }}
                    @endauth
                    @auth('marketing')
                        {{ route('marketing.dashboard') }}
                    @endauth
                    @auth('tenant')
                        @if (auth()->user()->id_inv_code == 0)
                            {{ route('tenant.mitra.dashboard') }}
                        @else
                            {{ route('tenant.dashboard') }}
                        @endif
                    @endauth
                    @auth('kasir')
                        {{ route('kasir.dashboard') }}
                    @endauth
                    ">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
                @auth('admin')
                    <li>
                        <a href="#transaction-list-admin" data-bs-toggle="collapse">
                            <i class="mdi mdi-view-list-outline"></i>
                            <span> Admin Menu </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="transaction-list-admin">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('admin.dashboard.menu') }}">Dashboard</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.menu.userTransaction') }}">User Transaction List</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.menu.userTransaction.settlementReady') }}">Transaction Settlement Ready</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.menu.userWithdrawals') }}">User Withdrawals</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.menu.userUmiRequest') }}">Request UMI</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.menu.userTenantQris') }}">Tenant Qris Account</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @if(auth()->user()->access_level == 0)
                        <li>
                            <a href="#sidebarCrm" data-bs-toggle="collapse">
                                <i class="mdi mdi-account-box-multiple"></i>
                                <span> Administrator </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarCrm">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('admin.dashboard.administrator.list') }}">Account</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                @endauth
                @auth('tenant')
                    @if (auth()->user()->id_inv_code != 0)
                        <li>
                            <a href="{{ route('tenant.pos') }}">
                                <i class="mdi mdi-point-of-sale"></i>
                                <span> POS </span>
                            </a>
                        </li>
                    @endif
                @endauth
                @auth('kasir')
                    <li>
                        <a href="{{ route('kasir.pos') }}">
                            <i class="mdi mdi-point-of-sale"></i>
                            <span> POS </span>
                        </a>
                    </li>
                @endauth
                <li class="menu-title mt-2">Manager</li>
                <li>
                    <a href="#">
                        <i class="mdi mdi-calendar"></i>
                        <span> Calendar </span>
                    </a>
                </li>
                @auth('kasir')
                    <li class="menu-title mt-2">Transaction</li>
                    <li>
                        <a href="#transaction" data-bs-toggle="collapse">
                            <i class="mdi mdi-folder-open"></i>
                            <span> Transaksi </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="transaction">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('kasir.transaction') }}">Dashboard Transaksi</a>
                                </li>
                            </ul>
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('kasir.transaction.list') }}">Semua Transaksi</a>
                                </li>
                            </ul>
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('kasir.transaction.pending') }}">Transaction Pending</a>
                                </li>
                            </ul>
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('kasir.transaction.pending.payment') }}">Payment Qris Pending</a>
                                </li>
                            </ul>
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('kasir.transaction.finish') }}">Transaction Finish</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endauth
                @auth('admin')
                    @if (auth()->user()->access_level == 0)
                        <li>
                            <a href="#saldo-admin" data-bs-toggle="collapse">
                                <i class="mdi mdi-wallet"></i>
                                <span> Saldo </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="saldo-admin">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('admin.dashboard.saldo') }}">Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.dashboard.saldo.qris') }}">Saldo Qris</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.dashboard.saldo.agregate') }}">Saldo Agregate</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.dashboard.saldo.agregate.aplikasi') }}">Saldo Agregate Aplikasi</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.dashboard.saldo.agregate.transfer') }}">Saldo Agregate Transfer</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.dashboard.saldo.cashback') }}">History Cashback Transaksi</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.dashboard.saldo.cashback.settlement') }}">History Cashback Pending Settlement</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.dashboard.saldo.nobu.fee.transfer') }}">History Bank Fee Transfer</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    <li>
                        <a href="#marketing" data-bs-toggle="collapse">
                            <i class="mdi mdi-account-tie-voice"></i>
                            <span> Mitra Aplikasi </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="marketing">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('admin.dashboard.marketing') }}">Dashboard</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.marketing.list') }}">Mitra List</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.marketing.invitationcode') }}">Invitation Codes</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.marketing.withdraw') }}">Withdrawals</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#mitra-bisnis-admin" data-bs-toggle="collapse">
                            <i class="mdi mdi-account-tie"></i>
                            <span> Mitra Bisnis </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="mitra-bisnis-admin">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraBisnis') }}">Dashboard</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraBisnis.list') }}">Mitra List</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraBisnis.merchantList') }}">Merchant List</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraBisnis.umi.list') }}">Request UMI</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraBisnis.qris.list') }}">Tenant Qris Account</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraBisnis.transactionList') }}">Transaction List</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraBisnis.withdrawList') }}">Withdrawals</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#mitra-tenant-admin" data-bs-toggle="collapse">
                            <i class="mdi mdi-store"></i>
                            <span> Mitra Tenant </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="mitra-tenant-admin">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraTenant') }}">Dashboard</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraTenant.list') }}">Mitra List</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraTenant.store.list') }}">Store List</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraTenant.kasir.list') }}">Kasir List</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraTenant.umi.list') }}">Request UMI</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraTenant.qris.list') }}">Tenant Qris Account</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraTenant.transaction.list') }}">Transaction List</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.mitraTenant.withdraw.list') }}">Withdrawals</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#finance" data-bs-toggle="collapse">
                            <i class="mdi mdi-finance"></i>
                            <span> Finance </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="finance">
                            <ul class="nav-second-level">
                                @if(auth()->user()->access_level == 0)
                                    <li>
                                        <a href="{{ route('admin.dashboard.finance') }}">History Saldo</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.dashboard.finance.insentif.list') }}">Insentive Setting</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.dashboard.finance.settlement.list') }}">Settlement Setting</a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('admin.dashboard.finance.settlement.pending') }}">Settlement Pending</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.finance.settlement.history') }}">Settlement History</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endauth
                @auth('marketing')
                    <li>
                        <a href="#marketing" data-bs-toggle="collapse">
                            <i class="mdi mdi-qrcode-scan"></i>
                            <span> Invitation Code </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="marketing">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('marketing.dashboard.invitationcode') }}">Dashboard Code</a>
                                </li>
                                <li>
                                    <a href="{{ route('marketing.dashboard.pemasukan') }}">Daftar Pemasukan</a>
                                </li>
                                <li>
                                    <a href="{{ route('marketing.dashboard.pemasukan.today') }}">Pemasukan Hari Ini</a>
                                </li>
                                <li>
                                    <a href="{{ route('marketing.dashboard.pemasukan.month') }}">Pemasukan Bulan Ini</a>
                                </li>
                                <li>
                                    <a href="{{ route('marketing.dashboard.tenant.list') }}">Data Tenant</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#sidebarCrm" data-bs-toggle="collapse">
                            <i class="mdi mdi-store"></i>
                            <span> Merchant </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCrm">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('marketing.dashboard.merchant') }}">Merchant List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#finance" data-bs-toggle="collapse">
                            <i class="mdi mdi-finance"></i>
                            <span> Finance </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="finance">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('marketing.finance') }}">Dashboard Finansial</a>
                                </li>
                                <li>
                                    <a href="{{ route('marketing.finance.saldo') }}">Total Saldo</a>
                                </li>
                                <li>
                                    <a href="{{ route('marketing.finance.history_penarikan') }}">History Penarikan Anda</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endauth
                @auth('tenant')
                    <li>
                        <a href="#toko" data-bs-toggle="collapse">
                            <i class="mdi mdi-store"></i>
                            <span>
                                @if (auth()->user()->id_inv_code != 0)
                                    Menu Toko
                                @else
                                    Menu Merchant
                                @endif
                            </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="toko">
                            <ul class="nav-second-level">
                                @if (auth()->user()->id_inv_code != 0)
                                    <li>
                                        <a href="{{ route('tenant.toko') }}">Dashboard Toko</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.supplier.list') }}">Supplier</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.batch.list') }}">Batch Code</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.category.list') }}">Kategori</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.product.batch.list') }}">Batch Product</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.product.stock.list') }}">Stock Manager</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.toko') }}">Dashboard Merchant</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.toko.list') }}">Merchant List</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.toko.request.umi.list') }}">Umi</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#transaksi" data-bs-toggle="collapse">
                            <i class="mdi mdi-folder-open"></i>
                            <span> Transaksi </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="transaksi">
                            {{-- Akses Menu Transaksi Mitra Bisnis --}}
                            @if (auth()->user()->id_inv_code == 0)
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.transaction') }}">Dashboard Transaksi</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.transaction.all_transaction') }}">Semua Transaksi</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.transaction.pending_transaction') }}">Pyament Pending</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.transaction.finish_transaction') }}">Payment Finish</a>
                                    </li>
                                </ul>
                            @else
                            {{-- Akses Menu Transaksi Mitra Tenant --}}
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('tenant.transaction') }}">Dashboard Transaksi</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.transaction.list') }}">Semua Transaksi</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.transaction.list.tunai') }}">Transaksi Tunai</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.transaction.list.qris') }}">Transaksi Qris</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.transaction.list.pending') }}">Transaksi Pending</a>
                                    </li>
                                    {{-- <li>
                                        <a href="{{ route('tenant.transaction.finish') }}">Transaction Finish</a>
                                    </li> --}}
                                    <li>
                                        <a href="{{ route('tenant.transaction.list.pending.payment') }}">Payment Qris Pending</a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </li>
                    @if (auth()->user()->id_inv_code != 0)
                        <li>
                            <a href="#pemasukan-tenant" data-bs-toggle="collapse">
                                <i class="mdi mdi-inbox-arrow-down"></i>
                                <span> Pemasukan </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="pemasukan-tenant">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('tenant.pemasukan') }}">Dashboard Pemasukan</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.pemasukan.qris') }}">Pemasukan Transaksi Qris</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if (auth()->user()->id_inv_code == 0)
                        <li>
                            <a href="#aplikasi" data-bs-toggle="collapse">
                                <i class="mdi mdi-apps"></i>
                                <span> Aplikasi </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="aplikasi">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.app') }}">Dashboard Aplikasi</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.app.qrisacc') }}">Akun Qris Merchant</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.app.setting') }}">Pengaturan API Qris</a>
                                    </li>
                                    <li>
                                        <a href="#">Dokumentasi</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if (auth()->user()->id_inv_code != 0)
                        <li>
                            <a href="#karyawan" data-bs-toggle="collapse">
                                <i class="mdi mdi-account-multiple-outline"></i>
                                <span> Menu Karyawan </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="karyawan">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('tenant.kasir') }}">Dashboard Kasir</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.kasir.list') }}">Manager Kasir</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#harga" data-bs-toggle="collapse">
                                <i class="mdi mdi-sale"></i>
                                <span> Store Managament </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="harga">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('tenant.store.management') }}">Store Menu</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.discount.modify') }}">Pengaturan Diskon</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.pajak.modify') }}">Pengaturan Pajak</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.customField.modify') }}">Custom Fields</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    <li class="menu-title mt-2">Finance Manager</li>
                    @if (auth()->user()->id_inv_code != 0)
                        <li>
                            <a href="#finance" data-bs-toggle="collapse">
                                <i class="mdi mdi-finance"></i>
                                <span> Finance </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="finance">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('tenant.finance') }}">Dashboard Finansial</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.saldo') }}">Saldo Pemasukan</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.finance.settlement') }}">History Settlement Transaksi</a>
                                    </li>
                                    {{-- <li>
                                        <a href="{{ route('tenant.finance.pemasukan') }}">Pemasukan</a>
                                    </li> --}}
                                    <li>
                                        <a href="{{ route('tenant.finance.history_penarikan') }}">History Penarikan Anda</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @else
                        <li>
                            <a href="#finance" data-bs-toggle="collapse">
                                <i class="mdi mdi-finance"></i>
                                <span> Finance </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="finance">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.finance') }}">Dashboard Finansial</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.finance.saldo') }}">Saldo Anda</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.mitra.dashboard.finance.settlement') }}">History Settlement Transaksi</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.finance.history_penarikan') }}">History Penarikan Anda</a>
                                    </li>
                                </ul>
                            </div>
                    </li>
                    @endif
                    <li class="menu-title mt-2">Other Menu</li>
                    <li>
                        <a href="#role" data-bs-toggle="collapse">
                            <i class="mdi mdi-folder-key"></i>
                            <span> Role Manager </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="role">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="#">Pengatura hak akses</a>
                                </li>
                                <li>
                                    <a href="#">Backup Database</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endauth
                @auth('admin')
                    <li class="menu-title mt-2">Other Menu</li>
                    <li>
                        <a href="#app-setting" data-bs-toggle="collapse">
                            <span class="mdi mdi-apple-keyboard-command"></span>
                            <span> Application </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="app-setting">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('admin.dashboard.application.appversion') }}">Application Version Setting</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#role" data-bs-toggle="collapse">
                            <span class="mdi mdi-message-text-clock-outline"></span>
                            <span> History </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="role">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('admin.dashboard.history') }}">Dashboard</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.history.user.login') }}">User Login</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.history.user.register') }}">User Regsister</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.history.user.activity') }}">User Activity</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.history.user.withdraw') }}">User Withdrawal</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard.history.user.error') }}">Errors</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
