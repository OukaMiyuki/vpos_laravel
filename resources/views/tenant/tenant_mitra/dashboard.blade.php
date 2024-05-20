<x-tenant_mitra-layout>

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
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- end page title --> 
            <div class="row">
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{ asset('assets/images/icons/today-transaction.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $allToday }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Transaksi Masuk Hari Ini</p>
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
                <!-- end col-->
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{ asset('assets/images/icons/transaction-finish.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $allFinish }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Transaksi Selesai Hari Ini</p>
                                        <a href="{{ route('tenant.mitra.dashboard.transaction.finish_transaction_today') }}" class="btn btn-blue btn-sm ms-2">
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
                                <div class="col-3">
                                    <img src="{{ asset('assets/images/icons/transaction-data.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1""><span data-plugin="counterup">{{ $all }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Transaksi</p>
                                        <a href="" class="btn btn-blue btn-sm ms-2">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <h4 class="header-title mb-3">Transaksi Selesai Terbaru</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Invoice</th>
                                            <th>Merchant Identifier</th>
                                            <th>Nama Merchant</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Tanggal Pelunasan</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>Status Pembayaran</th>
                                            <th>Nominal Bayar</th>
                                            <th>MDR (%)</th>
                                            <th>Nominal MDR</th>
                                            <th>Nominal Terima Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($invoiceNew as $key => $all)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $all->nomor_invoice }}</td>
                                                <td>{{ $all->store_identifier }}</td>
                                                <td>{{ $all->storeMitra->name }}</td>
                                                <td>{{ $all->tanggal_transaksi }}</td>
                                                <td>{{ $all->tanggal_pelunasan }}</td>
                                                <td>{{ $all->jenis_pembayaran }}</td>
                                                <td>
                                                    @if (!empty($all->jenis_pembayaran) || !is_null($all->jenis_pembayaran) || $all->jenis_pembayaran != "")
                                                        @if($all->status_pembayaran == 0)
                                                            <span class="badge bg-soft-warning text-warning">Pending Pembayaran</span>
                                                        @elseif($all->status_pembayaran == 1)
                                                            <span class="badge bg-soft-success text-success">Selesai</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Belum Diproses</span>
                                                    @endif
                                                </td>
                                                <td>{{ $all->nominal_bayar }}</td>
                                                <td>{{ $all->mdr }}</td>
                                                <td>{{ $all->nominal_mdr }}</td>
                                                <td>{{ $all->nominal_terima_bersih }}</td>
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

</x-tenant_mitra-layout>