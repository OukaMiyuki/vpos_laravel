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
                    Marketing
                @endauth
                @auth('tenant')
                    Tenant
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
                        {{ route('tenant.dashboard') }}
                    @endauth
                    @auth('kasir')
                        {{ route('kasir.dashboard') }}
                    @endauth
                    ">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
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
                            <span> Transaction </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="transaction">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('kasir.transaction.pending') }}">Transaction Pending</a>
                                </li>
                            </ul>
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('kasir.transaction.pending.payment') }}">Payment Pending</a>
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
                    <li>
                        <a href="#marketing" data-bs-toggle="collapse">
                            <i class="mdi mdi-account-tie-voice"></i>
                            <span> Marketing </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="marketing">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('admin.dashboard.marketing') }}">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#">Marketing Accounts</a>
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
                                    <a href="#">Merchant List</a>
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
                                    <a href="crm-dashboard.html">Penghasilan</a>
                                </li>
                                <li>
                                    <a href="crm-contacts.html">Penarikan</a>
                                </li>
                                <li>
                                    <a href="crm-customers.html">Saldo</a>
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
                                    <a href="{{ route('marketing.dashboard.invitationcode.list') }}">Invitation Code List</a>
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
                                    <a href="{{ route('marketing.dashboard.tenant.list') }}">Tenant List</a>
                                </li>
                                <li>
                                    <a href="#">Data Penarikan</a>
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
                                    <a href="crm-dashboard.html">Penarikan Anda</a>
                                </li>
                                <li>
                                    <a href="crm-customers.html">Total Saldo</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endauth
                @auth('tenant')
                    <li>
                        <a href="#toko" data-bs-toggle="collapse">
                            <i class="mdi mdi-store"></i>
                            <span> Menu Toko </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="toko">
                            <ul class="nav-second-level">
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
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('tenant.transaction') }}">Dashboard Transaksi</a>
                                </li>
                                <li>
                                    <a href="{{ route('tenant.transaction.list') }}">Semua Transaksi</a>
                                </li>
                                <li>
                                    <a href="{{ route('tenant.transaction.list.pending') }}">Transaction Pending</a>
                                </li>
                                <li>
                                    <a href="{{ route('tenant.transaction.list.pending.payment') }}">Payment Pending</a>
                                </li>
                            </ul>
                        </div>
                    </li>
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
                    <li class="menu-title mt-2">Finance Manager</li>
                    <li>
                        <a href="#finance" data-bs-toggle="collapse">
                            <i class="mdi mdi-finance"></i>
                            <span> Finance </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="finance">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('tenant.saldo') }}">Total Saldo</a>
                                </li>
                                <li>
                                    <a href="#">History Penarikan</a>
                                </li>
                            </ul>
                        </div>
                    </li>
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
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
