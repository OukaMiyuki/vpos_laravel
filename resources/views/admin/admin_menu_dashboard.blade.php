<x-admin-layout>

    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Admin Menu</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Admin Menu Dashboard</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">User Transacion Data</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/transaction-data.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('admin.dashboard.menu.userTransaction') }}"><button title="Pengaturan profil toko" type="button" class="btn btn-info waves-effect waves-light">View Data</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">User Withdrawals</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/cash-withdrawal.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('admin.dashboard.menu.userWithdrawals') }}"><button title="Pengaturan akun" type="button" class="btn btn-info waves-effect waves-light">View Data</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">User Bank Account</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/credit-card.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('tenant.mitra.dashboard.toko.request.umi.list') }}"><button title="Pengaturan akun" type="button" class="btn btn-info waves-effect waves-light">View Data</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">User UMI Request</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/job-application.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('tenant.mitra.dashboard.toko.request.umi.list') }}"><button title="Pengaturan akun" type="button" class="btn btn-info waves-effect waves-light">View Data</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">Tenant QRIS Account</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/qr-code.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('tenant.mitra.dashboard.toko.request.umi.list') }}"><button title="Pengaturan akun" type="button" class="btn btn-info waves-effect waves-light">View Data</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>