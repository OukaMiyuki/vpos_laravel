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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Transaction</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Dashboard Data Transaksi</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <img src="{{ asset('assets/images/icons/transaction-data.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-7">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">23</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Semua Transaksi</p>
                                        <a href="{{ route('tenant.product.batch.list') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-md-3 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <img src="{{ asset('assets/images/icons/today-transaction.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-7">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">23</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Transaksi Hari ini</p>
                                        <a href="{{ route('tenant.product.batch.list') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-md-3 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <img src="{{ asset('assets/images/icons/transaction-pending.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-7">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">30</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Transaction Pending</p>
                                        <a href="{{ route('tenant.supplier.list') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-md-3 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <img src="{{ asset('assets/images/icons/payment-pending.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-7">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">30</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Payment Pending</p>
                                        <a href="{{ route('tenant.supplier.list') }}" class="btn btn-blue btn-sm ms-2">
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
            </div>
        </div>
    </div>

</x-tenant-layout>