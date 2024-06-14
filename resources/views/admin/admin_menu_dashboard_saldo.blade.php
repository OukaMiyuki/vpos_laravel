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
                                <li class="breadcrumb-item active">Saldo</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Dashboard Saldo Admin</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/digital-wallet.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h4 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $adminQrisWallet->saldo }}</span></h4>
                                        <p class="text-muted mb-1 text-truncate">Saldo Qris</p>
                                        <a href="{{ route('admin.dashboard.saldo.qris') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-md-3 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/walletadminagregate.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h4 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $agregateWallet->saldo }}</span></h4>
                                        <p class="text-muted mb-1 text-truncate">Saldo Agregate</p>
                                        <a href="{{ route('admin.dashboard.saldo.agregate') }}" class="btn btn-blue btn-sm ms-2">
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
                <div class="col-md-3 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/cashback.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h4 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $historyCashbackAdmin }}</span></h4>
                                        <p class="text-muted mb-1 text-truncate">Total Cashback Transaksi</p>
                                        <a href="{{ route('admin.dashboard.saldo.cashback') }}" class="btn btn-blue btn-sm ms-2">
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
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/expenses.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h4 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $nobuWithdrawFeeHistory }}</span></h4>
                                        <p class="text-muted mb-1 text-truncate">Total Bank Fee Transfer</p>
                                        <a href="{{ route('admin.dashboard.saldo.nobu.fee.transfer') }}" class="btn btn-blue btn-sm ms-2">
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
                                    <a href="" class="dropdown-item">Lihat Semua Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Insentif Transfer Baru</h4>
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Invoice</th>
                                            <th>Email</th>
                                            <th class="text-center">Tanggal Penarikan</th>
                                            <th class="text-center">Total Penarikan (Rp.)</th>
                                            <th class="text-center">Total Biaya Transfer (Rp.)</th>
                                            <th class="text-center">Nominal Bersih Penarikan</th>
                                            <th class="text-center">Biaya Transfer Bank (Rp.)</th>
                                            <th class="text-center">Mitra (Rp.)</th>
                                            <th class="text-center">Tenant (Rp.)</th>
                                            <th class="text-center">Insentif Admin (Rp.)</th>
                                            <th class="text-center">Insentif Agregate (Rp.)</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=0;
                                        @endphp
                                        @foreach ($withdrawals as $wd)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $wd->invoice_pemarikan }}</td>
                                                <td>{{ $wd->email }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($wd->tanggal_penarikan)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ $wd->nominal+$wd->biaya_admin }}</td>
                                                <td class="text-center">{{ $wd->biaya_admin }}</td>
                                                <td class="text-center">{{ $wd->detailWithdraw->nominal_bersih_penarikan }}</td>
                                                <td class="text-center">{{ $wd->detailWithdraw->biaya_nobu }}</td>
                                                <td class="text-center">{{ $wd->detailWithdraw->biaya_mitra }}</td>
                                                <td class="text-center">{{ $wd->detailWithdraw->biaya_tenant }}</td>
                                                <td class="text-center">{{ $wd->detailWithdraw->biaya_admin_su }}</td>
                                                <td class="text-center">{{ $wd->detailWithdraw->biaya_agregate }}</td>
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>

</x-admin-layout>