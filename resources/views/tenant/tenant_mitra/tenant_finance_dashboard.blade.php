<x-tenant-layout>

    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Finance</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Menu Finansial</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">Data Saldo</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/profits.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('tenant.mitra.dashboard.finance.saldo') }}"><button title="Pengaturan profil toko" type="button" class="btn btn-info waves-effect waves-light">Lihat Data</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">History Settlement</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/balance-sheet.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('tenant.mitra.dashboard.finance.settlement') }}"><button title="Pengaturan profil toko" type="button" class="btn btn-info waves-effect waves-light">Lihat Data</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">History Penarikan Saldo Qris</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/cash-withdrawal.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('tenant.finance.history_penarikan') }}"><button title="Pengaturan rekening bank" type="button" class="btn btn-info waves-effect waves-light">Lihat Data</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-tenant-layout>