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
                                <li class="breadcrumb-item active">Application</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Menu Aplikasi</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">Akun Qris Merchant</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/qr-code.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('tenant.mitra.dashboard.app.qrisacc') }}"><button title="Pengaturan profil toko" type="button" class="btn btn-info waves-effect waves-light">Lihat Data</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">Pengaturan Qris</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/api.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('tenant.mitra.dashboard.app.setting') }}"><button title="Pengaturan rekening bank" type="button" class="btn btn-info waves-effect waves-light">Lihat Data</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">Dokumentasi</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/docs.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href=""><button title="Pengaturan rekening bank" type="button" class="btn btn-info waves-effect waves-light">Lihat Data</button></a>
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