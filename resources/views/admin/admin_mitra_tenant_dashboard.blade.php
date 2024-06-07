<x-admin-layout>

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
                        <h4 class="page-title">Dashboard Mitra Tenant</h4>
                    </div>
                </div>
            </div>
            <!-- end page title --> 
            <div class="row">
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/partner.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $tenantCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Mitra</p>
                                        <a href="{{ route('admin.dashboard.mitraTenant.list') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/store.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $storeCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Store</p>
                                        <a href="{{ route('admin.dashboard.mitraTenant.store.list') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/cashier.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $kasir }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Kasir</p>
                                        <a href="{{ route('admin.dashboard.mitraTenant.kasir.list') }}" class="btn btn-blue btn-sm ms-2">
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
            <div class="row">
                <div class="col-md-6 col-xl-6">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/transaction-data.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $merchantTransactionCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Transaction</p>
                                        <a href="{{ route('admin.dashboard.mitraTenant.transaction.list') }}" class="btn btn-blue btn-sm ms-2">
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
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/cash-withdrawal.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $withdrawalCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Withdraw</p>
                                        <a href="{{ route('admin.dashboard.mitraTenant.withdraw.list') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="" class="dropdown-item">Lihat Semua Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Mitra Tenant Baru</h4>
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Tanggal Gabung</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($tenantBaru as $tenant)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $tenant->name }}</td>
                                                <td>{{ $tenant->email }}&nbsp;@if(!is_null($tenant->email_verified_at) || !empty($tenant->email_verified_at) || $tenant->email_verified_at != "" || $tenant->email_verified_at != NULL) </span><span class="text-success mdi mdi-check-decagram-outline"></span> @else <span class="text-warning mdi mdi-clock-outline"></span> @endif</td>
                                                <td>{{ $tenant->phone }}&nbsp;@if(!is_null($tenant->phone_number_verified_at) || !empty($tenant->phone_number_verified_at) || $tenant->phone_number_verified_at != "" || $tenant->phone_number_verified_at != NULL) </span><span class="text-success mdi mdi-check-decagram-outline"></span> @else <span class="text-warning mdi mdi-clock-outline"></span> @endif</td>
                                                <td>{{ \Carbon\Carbon::parse($tenant->created_at)->format('d-m-Y') }}</td>
                                                <td>
                                                    <a href="" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="" class="dropdown-item">Lihat Semua Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Daftar Penarikan Terbaru</h4>
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-center">Action</th>
                                            <th>Invoice Penarikan</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Tanggal Penarikan</th>
                                            <th>Nominal</th>
                                            <th>Biaya Transfer</th>
                                            <th>Nominal Bersih Penarikan</th>
                                            <th>Biaya Nobu</th>
                                            <th>Biaya Mitra</th>
                                            <th>Biaya Tenant</th>
                                            <th>Biaya Admin SU</th>
                                            <th>Biaya Agregate</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach ($tenantWithdrawNew as $wd)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>
                                                    <a href="" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
                                                </td>
                                                <td>{{ $wd->invoice_pemarikan }}</td>
                                                <td>{{ $wd->tenant->name }}</td>
                                                <td>{{ $wd->tenant->email }}</td>
                                                <td>{{ $wd->tanggal_penarikan }}</td>
                                                <td>{{ $wd->nominal }}</td>
                                                <td>{{ $wd->biaya_admin }}</td>
                                                <td>{{ $wd->detailWithdraw->nominal_bersih_penarikan }}</td>
                                                <td>{{ $wd->detailWithdraw->biaya_nobu }}</td>
                                                <td>{{ $wd->detailWithdraw->biaya_mitra }}</td>
                                                <td>{{ $wd->detailWithdraw->biaya_tenant }}</td>
                                                <td>{{ $wd->detailWithdraw->biaya_admin_su }}</td>
                                                <td>{{ $wd->detailWithdraw->biaya_agregate }}</td>
                                                <td>
                                                    @if ($wd->status == 0)
                                                        <span class="badge bg-soft-danger text-danger">Penarikan Gagal</span>
                                                    @else
                                                        <span class="badge bg-soft-success text-success">Penarikan Sukses</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- end .table-responsive-->
                        </div>
                    </div>
                    <!-- end card-->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>

</x-admin-layout>