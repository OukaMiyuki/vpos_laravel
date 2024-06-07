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
                                <li class="breadcrumb-item"><a href="">Saldo</a></li>
                                <li class="breadcrumb-item active">Cashback</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Cashback Qris</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/withdraw.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $totakCashback }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Cashback</p>
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
                                    <a href="" class="dropdown-item">Cetak Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">History Cashback Qris</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Invoice</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>MDR</th>
                                            <th>Nominal MDR</th>
                                            <th>Nominal Bayar</th>
                                            <th>Nominal Terima Bersih</th>
                                            <th>Nominal Terima MDR (0.25%)</th>
                                            <th>Tanggal Cashback</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=0;
                                        @endphp
                                        @foreach ($historyCashback as $cashback)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $cashback->invoice->nomor_invoice }}</td>
                                                <td>{{ \Carbon\Carbon::parse($cashback->invoice->tanggal_transaksi)->format('d-m-Y') }}</td>
                                                <td>{{ $cashback->invoice->jenis_pembayaran }}</td>
                                                <td>{{ $cashback->invoice->mdr }}</td>
                                                <td>{{ $cashback->invoice->nominal_mdr }}</td>
                                                <td>{{ $cashback->invoice->nominal_bayar }}</td>
                                                <td>{{ $cashback->invoice->nominal_terima_bersih }}</td>
                                                <td>{{ $cashback->nominal_terima_mdr }}</td>
                                                <td>{{ \Carbon\Carbon::parse($cashback->created_at)->format('d-m-Y') }}</td>
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
            </div>
        </div>
        <!-- container -->
    </div>
</x-admin-layout>