<x-tenant-layout>

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
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-2">
                                    <i class="mdi mdi-autorenew"></i>
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
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $transaksiTunaiCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Transaksi Tunai</p>
                                        <a href="{{ route('tenant.transaction.list.tunai') }}" class="btn btn-blue btn-sm ms-2">
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
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $transaksiQrisCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Transaksi Qris</p>
                                        <a href="{{ route('tenant.transaction.list.qris') }}" class="btn btn-blue btn-sm ms-2">
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
                                        <h3 class="text-dark mt-1""><span data-plugin="counterup">{{ $invoice }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Semua Transaksi</p>
                                        <a href="{{ route('tenant.transaction') }}" class="btn btn-blue btn-sm ms-2">
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
                                <div class="col-3">
                                    <img src="{{ asset('assets/images/icons/salary.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">@money($pemasukanHariIni)</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Pemasukan hari ini</p>
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
                                    <img src="{{ asset('assets/images/icons/balance-sheet.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">@money($totalSaldo)</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Penghasilan Toko</p>
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
            <!-- end row-->
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
                                <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Invoice</th>
                                            <th>Kasir</th>
                                            <th class="text-center">Tanggal Transaksi</th>
                                            <th class="text-center">Jenis Pembayaran</th>
                                            <th class="text-center">Nilai Transaksi (Rp.)</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($latestInvoice as $invoice)
                                            <tr>
                                                <td>{{$no+=1}}</td>
                                                <td>{{$invoice->nomor_invoice}}</td>
                                                <td>@if(!empty($invoice->kasir) || !is_null($invoice->kasir)) {{ $invoice->kasir->name }} @else Transaction by Tenant @endif</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($invoice->tanggal_transaksi)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoice->created_at)->format('H:i:s')}}</td>
                                                <td class="text-center">{{$invoice->jenis_pembayaran}}</td>
                                                <td class="text-center">{{$invoice->sub_total+$invoice->pajak}}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('tenant.transaction.invoice', ['id' => $invoice->id ]) }}"" class="btn btn-xs btn-success"><i class="mdi mdi-eye"></i></a>
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
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>

</x-tenant-layout>