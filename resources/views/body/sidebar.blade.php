<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{ !empty(auth()->user()->detail->photo) ? Storage::url('images/profile/'.auth()->user()->detail->photo) : asset('assets/images/blank_profile.png') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown">{{ auth()->user()->name }}</a>
                <div class="dropdown-menu user-pro-dropdown">
                    <!-- item-->
                    <a href="P{{ route('admin.profile') }}" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>
                    <!-- item-->
                    <a href="{{ route('admin.password') }}" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Change Password</span>
                    </a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>
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
                    <a href="">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
                <li class="menu-title mt-2">Manager</li>
                <li>
                    <a href="">
                        <i class="mdi mdi-calendar"></i>
                        <span> Calendar </span>
                    </a>
                </li>
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
                                    <a href="">Dashboard</a>
                                </li>
                                <li>
                                    <a href="">Marketing Accounts</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#sidebarCrm" data-bs-toggle="collapse">
                            <i class="mdi mdi-storefront-outline"></i>
                            <span> Merchant </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCrm">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="">Merchant List</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#finance" data-bs-toggle="collapse">
                            <i class="mdi mdi-cash-multiple"></i>
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
                                    <a href="">Invitation Code List</a>
                                </li>
                                <li>
                                    <a href="crm-contacts.html">Contacts</a>
                                </li>
                                <li>
                                    <a href="">Marketing Accounts</a>
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