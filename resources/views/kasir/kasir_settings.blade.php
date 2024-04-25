<x-kasir-layout>

    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('kasir.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Pengaturan</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">Account Settings</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/accoin-ico.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('kasir.profile') }}"><button title="Pengaturan akun" type="button" class="btn btn-info waves-effect waves-light">Setting</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-0">Password Settings</h4>
                            <div id="cardCollpase1" class="collapse show">
                                <div class="text-center pt-3">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/icons/lock3.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <a href="{{ route('kasir.password') }}"><button title="Pengaturan rekening bank" type="button" class="btn btn-info waves-effect waves-light">Setting</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-kasir-layout>