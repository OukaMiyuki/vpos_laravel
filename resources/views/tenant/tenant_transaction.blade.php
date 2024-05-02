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
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $allTransaksiCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Semua Transaksi</p>
                                        <a href="{{ route('tenant.transaction.list') }}" class="btn btn-blue btn-sm ms-2">
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
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $transaksiHariIniCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Transaksi Hari ini</p>
                                        <a href="{{ route('tenant.transaction.today') }}" class="btn btn-blue btn-sm ms-2">
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
                                    <img src="{{ asset('assets/images/icons/time.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-7">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $transaksiPendingCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Transaction Pending</p>
                                        <a href="{{ route('tenant.transaction.list.pending') }}" class="btn btn-blue btn-sm ms-2">
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
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $paymentPendingCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Payment Qris Pending</p>
                                        <a href="{{ route('tenant.transaction.list.pending.payment') }}" class="btn btn-blue btn-sm ms-2">
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
            <div class="row">
                <div class="col-md-6 col-xl-6">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <img src="{{ asset('assets/images/icons/transaction-finish.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-7">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $invoiceFinishCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Semua Transaksi Selesai</p>
                                        <a href="{{ route('tenant.transaction.finish') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-md-6 col-xl-6">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <img src="{{ asset('assets/images/icons/payment-finish.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-7">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $invoicePaymentQrisFinish }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Pembayaran Qris Sukses</p>
                                        <a href="{{ route('tenant.transaction.finish.qris') }}" class="btn btn-blue btn-sm ms-2">
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