<x-kasir-layout>

    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex align-items-center mb-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control border-0" id="dash-daterange">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                    <i class="mdi mdi-calendar-range"></i>
                                    </span>
                                </div>
                                <a href="#" class="btn btn-blue btn-sm ms-2">
                                <i class="mdi mdi-autorenew"></i>
                                </a>
                                <a href="#" class="btn btn-blue btn-sm ms-1">
                                <i class="mdi mdi-filter-variant"></i>
                                </a>
                            </form>
                        </div>
                        <h4 class="page-title">Transaction Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- end page title --> 
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="avatar-lg rounded-circle bg-primary border-primary border shadow">
                                        <i class="mdi mdi-book-open-outline font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $transaction }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Semua Transaksi</p>
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
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="avatar-lg rounded-circle bg-success border-success border shadow">
                                        <i class="mdi mdi-book-clock-outline font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $transactionPending }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Transaksi Pending</p>
                                        <a href="{{ route('kasir.transaction.pending') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="avatar-lg rounded-circle bg-warning border-warning border shadow">
                                        <i class="mdi mdi-credit-card-sync-outline font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $transactionPendingPayment }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Payment Pending</p>
                                        <a href="{{ route('kasir.transaction.pending.payment') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="avatar-lg rounded-circle bg-danger border-danger border shadow">
                                        <i class="mdi mdi-clipboard-check-outline font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $transactionFinish }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Transaksi Selesai</p>
                                        <a href="{{ route('kasir.transaction.finish') }}" class="btn btn-blue btn-sm ms-2">
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
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>

</x-kasir-layout>