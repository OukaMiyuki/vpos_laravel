<div class="navbar-custom">
    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-end mb-0">
            <li class="d-none d-lg-block">
                <form class="app-search">
                    <div class="app-search-box dropdown">
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Search..." id="top-search">
                            <button class="btn input-group-text" type="submit">
                            <i class="fe-search"></i>
                            </button>
                        </div>
                        <div class="dropdown-menu dropdown-lg" id="search-dropdown">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h5 class="text-overflow mb-2">Found 22 results</h5>
                            </div>
                            <!-- item-->
                            <a href="#" class="dropdown-item notify-item">
                                <i class="fe-home me-1"></i>
                                <span>Analytics Report</span>
                            </a>
                            <!-- item-->
                            <a href="#" class="dropdown-item notify-item">
                                <i class="fe-aperture me-1"></i>
                                <span>How can I help you?</span>
                            </a>
                            <!-- item-->
                            <a href="#" class="dropdown-item notify-item">
                                <i class="fe-settings me-1"></i>
                                <span>User profile settings</span>
                            </a>
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow mb-2 text-uppercase">Users</h6>
                            </div>
                            <div class="notification-list">
                                <!-- item-->
                                <a href="#" class="dropdown-item notify-item">
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex me-2 rounded-circle" src="{{ asset('assets/images/users/user-2.jpg') }}" alt="Generic placeholder image" height="32">
                                        <div class="w-100">
                                            <h5 class="m-0 font-14">Erwin E. Brown</h5>
                                            <span class="font-12 mb-0">UI Designer</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item-->
                                <a href="#" class="dropdown-item notify-item">
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex me-2 rounded-circle" src="{{ asset('assets/images/users/user-5.jpg') }}" alt="Generic placeholder image" height="32">
                                        <div class="w-100">
                                            <h5 class="m-0 font-14">Jacob Deo</h5>
                                            <span class="font-12 mb-0">Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </li>
            <li class="dropdown d-inline-block d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-search noti-icon"></i>
                </a>
                <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                    <form class="p-3">
                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                    </form>
                </div>
            </li>
            <li class="dropdown d-none d-lg-inline-block">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                <i class="fe-maximize noti-icon"></i>
                </a>
            </li>
            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-bell noti-icon"></i>
                <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="m-0">
                            <span class="float-end">
                            <a href="" class="text-dark">
                            <small>Clear All</small>
                            </a>
                            </span>Notification
                        </h5>
                    </div>
                    <div class="noti-scroll" data-simplebar>
                        <!-- item-->
                        <a href="#" class="dropdown-item notify-item active">
                            <div class="notify-icon">
                                <img src="{{ asset('assets/images/users/user-1.jpg') }}" class="img-fluid rounded-circle" alt="" /> 
                            </div>
                            <p class="notify-details">Cristina Pride</p>
                            <p class="text-muted mb-0 user-msg">
                                <small>Hi, How are you? What about our next meeting</small>
                            </p>
                        </a>
                        <!-- item-->
                        <a href="#" class="dropdown-item notify-item">
                            <div class="notify-icon bg-primary">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details">Caleb Flakelar commented on Admin
                                <small class="text-muted">1 min ago</small>
                            </p>
                        </a>
                        <!-- item-->
                        <a href="#" class="dropdown-item notify-item">
                            <div class="notify-icon">
                                <img src="{{ asset('assets/images/users/user-4.jpg') }}" class="img-fluid rounded-circle" alt="" /> 
                            </div>
                            <p class="notify-details">Karen Robinson</p>
                            <p class="text-muted mb-0 user-msg">
                                <small>Wow ! this admin looks good and awesome design</small>
                            </p>
                        </a>
                        <!-- item-->
                        <a href="#" class="dropdown-item notify-item">
                            <div class="notify-icon bg-warning">
                                <i class="mdi mdi-account-plus"></i>
                            </div>
                            <p class="notify-details">New user registered.
                                <small class="text-muted">5 hours ago</small>
                            </p>
                        </a>
                        <!-- item-->
                        <a href="#" class="dropdown-item notify-item">
                            <div class="notify-icon bg-info">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details">Caleb Flakelar commented on Admin
                                <small class="text-muted">4 days ago</small>
                            </p>
                        </a>
                        <!-- item-->
                        <a href="#" class="dropdown-item notify-item">
                            <div class="notify-icon bg-secondary">
                                <i class="mdi mdi-heart"></i>
                            </div>
                            <p class="notify-details">Carlos Crouch liked
                                <b>Admin</b>
                                <small class="text-muted">13 days ago</small>
                            </p>
                        </a>
                    </div>
                    <!-- All-->
                    <a href="#" class="dropdown-item text-center text-primary notify-item notify-all">
                    View all
                    <i class="fe-arrow-right"></i>
                    </a>
                </div>
            </li>
            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ !empty(auth()->user()->detail->photo) ? Storage::url('images/profile/'.auth()->user()->detail->photo) : asset('assets/images/blank_profile.png') }}" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ms-1">
                        {{ auth()->user()->name }} <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>
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
                            {{ route('kasir.profile') }}
                        @endauth
                    " class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Account</span>
                    </a>
                    @auth('tenant')
                        @if (auth()->user()->id_inv_code != 0)
                            <a href="{{ route('tenant.store.profile') }}" class="dropdown-item notify-item">
                                <i class="mdi mdi-store-outline"></i>
                                <span>Store Settings</span>
                            </a>
                        @endif
                        <a href="{{ route('tenant.rekening.setting') }}" class="dropdown-item notify-item">
                            <i class="mdi mdi-credit-card-outline"></i>
                            <span>Rekening</span>
                        </a>
                    @endauth
                    @auth('marketing')
                        <a href="{{ route('marketing.rekening.setting') }}" class="dropdown-item notify-item">
                            <i class="mdi mdi-credit-card-outline"></i>
                            <span>Rekening</span>
                        </a>
                    @endauth
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
                            {{ route('kasir.password') }}
                        @endauth
                    " class="dropdown-item notify-item">
                        <i class="fe-lock"></i>
                        <span>Change Password</span>
                    </a>
                    <a href="
                        @auth('marketing')
                            {{ route('marketing.settings') }}
                        @endauth
                        @auth('tenant')
                            {{ route('tenant.settings') }}
                        @endauth
                        @auth('kasir')
                            {{ route('kasir.settings') }}
                        @endauth
                    " class="dropdown-item notify-item">
                        <i class="fe-settings"></i>
                        <span>Settings</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    @auth('admin')
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endauth
                    @auth('marketing')
                        <form method="POST" action="{{ route('marketing.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endauth
                    @auth('tenant')
                        <form method="POST" action="{{ route('tenant.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endauth
                    @auth('kasir')
                        <form method="POST" action="{{ route('kasir.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @endauth
                    <!-- item-->
                </div>
            </li>
            <li class="dropdown notification-list">
                <a href="#" class="nav-link right-bar-toggle waves-effect waves-light">
                <i class="fe-settings noti-icon"></i>
                </a>
            </li>
        </ul>
        <!-- LOGO -->
        <div class="logo-box">
            <a href="" class="logo logo-dark text-center">
                <span class="logo-sm">
                    <img src="{{ asset('assets/images/logo/Logo2.png') }}" alt="" height="20">
                    <!-- <span class="logo-lg-text-light">UBold</span> -->
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo/large.png') }}" alt="" height="40">
                    <!-- <span class="logo-lg-text-light">U</span> -->
                </span>
            </a>
            <a href="" class="logo logo-light text-center">
                <span class="logo-sm">
                    <img src="{{ asset('assets/images/logo/Logo2.png') }}" alt="" height="20">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo/large.png') }}" alt="" height="40">
                </span>
            </a>
        </div>
        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>
            <li>
                <!-- Mobile menu toggle (Horizontal Layout)-->
                <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>
            <li class="dropdown d-none d-xl-block">
                <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    Quick Menu
                    <i class="mdi mdi-chevron-down"></i> 
                </a>
                <div class="dropdown-menu">
                    @auth('admin')
                        <a href="#" class="dropdown-item">
                            <i class="mdi mdi-account-multiple-plus me-1"></i>
                            <span>Tambah Marketing</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="mdi mdi-account-tie-voice me-1"></i>
                            <span>Marketing Accounts</span>
                        </a>
                        <!-- item-->
                        <a href="#" class="dropdown-item">
                            <i class="fe-bar-chart-line- me-1"></i>
                            <span>Revenue Report</span>
                        </a>
                        <!-- item-->
                        <a href="#" class="dropdown-item">
                            <i class="fe-settings me-1"></i>
                            <span>Settings</span>
                        </a>
                    @endauth
                    @auth('tenant')
                        <a href="{{ route('tenant.kasir.list') }}" class="dropdown-item">
                            <i class="mdi mdi-account-multiple-outline"></i>
                            <span>Tambah Kasir</span>
                        </a>
                        <a href="{{ route('tenant.product.batch.add') }}" class="dropdown-item">
                            <i class="mdi mdi-bank-plus"></i>
                            <span>Tambah Produk</span>
                        </a>
                        <a href="{{ route('tenant.product.stock.add') }}" class="dropdown-item">
                            <i class="mdi mdi-book-plus"></i>
                            <span>Tambah Stok Barang</span>
                        </a>
                    @endauth
                    @auth('kasir')
                        <a href="{{ route('kasir.pos') }}" class="dropdown-item">
                            <i class="mdi mdi-point-of-sale"></i>
                            <span>Tambah Transaksi</span>
                        </a>
                        <a href="{{ route('kasir.transaction') }}" class="dropdown-item">
                            <i class="mdi mdi-folder-open"></i>
                            <span>Dashboard Transaksi</span>
                        </a>
                    @endauth
                    <div class="dropdown-divider"></div>
                    <!-- item-->
                    <a href="#" class="dropdown-item">
                        <i class="fe-headphones me-1"></i>
                        <span>Help & Support</span>
                    </a>
                </div>
            </li>
            @auth('tenant')
                <li class="dropdown dropdown-mega d-none d-xl-block">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    Mnager Toko
                    <i class="mdi mdi-chevron-down"></i> 
                    </a>
                    <div class="dropdown-menu dropdown-megamenu">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h5 class="text-dark mt-0">Menu Toko</h5>
                                        <ul class="list-unstyled megamenu-list">
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
                                    <div class="col-md-3">
                                        <h5 class="text-dark mt-0">Transaksi</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="{{ route('tenant.transaction.list') }}">Semua Transaksi</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('tenant.transaction.list.pending') }}">Transaction Pending</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('tenant.transaction.list.pending.payment') }}">Payment Qris Pending</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-dark mt-0">Menu Karyawan</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="{{ route('tenant.kasir.list') }}">Manager Kasir</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-dark mt-0">Store Manager</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="{{ route('tenant.discount.modify') }}">Pengaturan Diskon</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('tenant.pajak.modify') }}">Pengaturan Pajak</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('tenant.customField.modify') }}">Cutom Fields</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-center mt-3">
                                    {{-- <h3 class="text-dark">Special Discount Sale!</h3>
                                    <h4>Save up to 70% off.</h4>
                                    <button class="btn btn-primary rounded-pill mt-3">Download Now</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown dropdown-mega d-none d-xl-block">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    Other Menu
                    <i class="mdi mdi-chevron-down"></i> 
                    </a>
                    <div class="dropdown-menu dropdown-megamenu">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h5 class="text-dark mt-0">Finance</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="{{ route('tenant.finance.pemasukan') }}">Pemasukan</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('tenant.saldo') }}">Total Saldo</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('tenant.finance.history_penarikan') }}">History Penarikan</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-dark mt-0">Role Manager</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="#">Pengaturan Hak Akses</a>
                                            </li>
                                            <li>
                                                <a href="#">Backup Database</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-center mt-3">
                                    {{-- <h3 class="text-dark">Special Discount Sale!</h3>
                                    <h4>Save up to 70% off.</h4>
                                    <button class="btn btn-primary rounded-pill mt-3">Download Now</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endauth
            @auth('kasir')
            <li class="dropdown dropdown-mega d-none d-xl-block">
                <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                Menu Transaksi
                <i class="mdi mdi-chevron-down"></i> 
                </a>
                <div class="dropdown-menu dropdown-megamenu">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-md-3">
                                    <h5 class="text-dark mt-0">Transaksi</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <a href="{{ route('kasir.transaction.list') }}">Semua Transaksi</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('kasir.transaction.pending') }}">Transaction Pending</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('kasir.transaction.pending.payment') }}">Payment Qris Pending</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('kasir.transaction.finish') }}">Transaction finish</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center mt-3">
                                {{-- <h3 class="text-dark">Special Discount Sale!</h3>
                                <h4>Save up to 70% off.</h4>
                                <button class="btn btn-primary rounded-pill mt-3">Download Now</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endauth
        </ul>
        <div class="clearfix"></div>
    </div>
</div>