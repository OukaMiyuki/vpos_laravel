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
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $all }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Semua Transaksi</p>
                                        <a href="{{ route('tenant.mitra.dashboard.transaction.all_transaction') }}" class="btn btn-blue btn-sm ms-2">
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
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $allToday }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Transaksi Hari ini</p>
                                        <a href="{{ route('tenant.mitra.dashboard.transaction.all_today_transaction') }}" class="btn btn-blue btn-sm ms-2">
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
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $allPending }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Transaction Pending</p>
                                        <a href="{{ route('tenant.mitra.dashboard.transaction.pending_transaction') }}" class="btn btn-blue btn-sm ms-2">
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
                                    <img src="{{ asset('assets/images/icons/payment-finish.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-7">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $allFinish }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Payment Qris Finish</p>
                                        <a href="{{ route('tenant.mitra.dashboard.transaction.finish_transaction') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">Lihat Semua Laporan</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Frekuensi Transaksi Per-Merchant</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Store Identifier</th>
                                            <th>Nama Toko</th>
                                            <th>Banyak Transaksi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($storeList as $key => $inv)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $inv->store_identifier }}</td>
                                                <td>{{ $inv->name }}</td>
                                                <td>{{ $inv->invoice_count }}</td>
                                                <td>
                                                    <a href="{{ route('tenant.mitra.dashboard.transaction.store', ['store_identifier' => $inv->store_identifier]) }}">
                                                        <button title="Lihat daftar transaksi" type="button" class="btn btn-primary rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-tenant-layout>