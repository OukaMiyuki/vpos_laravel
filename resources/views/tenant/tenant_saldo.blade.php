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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Saldo</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xl-6">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="avatar-lg rounded-circle bg-success border-success border shadow">
                                        <i class="mdi mdi-cash font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $tunai->saldo }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Saldo Transaksi Tunai</p>
                                        <a href="" class="btn btn-blue btn-sm ms-2">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <!-- end col-->
                <div class="col-md-6 col-xl-6">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="avatar-lg rounded-circle bg-danger border-danger border shadow">
                                        <i class="mdi mdi-cash-multiple font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $qris->saldo }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Saldo Transaksi Qris</p>
                                        <a href="" class="btn btn-blue btn-sm ms-2">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a title="Tarik Saldo" href="" class="btn btn-blue btn-sm ms-2">
                                            Tarik Saldo
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <!-- end col-->
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-tenant-layout>