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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.saldo') }}">Saldo</a></li>
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
                                            <th class="text-center">Tanggal Transaksi</th>
                                            <th class="text-center">Jenis Pembayaran</th>
                                            <th class="text-center">MDR (%)</th>
                                            <th class="text-center">Nominal MDR (Rp.)</th>
                                            <th class="text-center">Nominal Bayar (Rp.)</th>
                                            <th class="text-center">Nominal Terima Bersih Qris User (Rp.)</th>
                                            <th class="text-center">Nominal Terima MDR (25%)</th>
                                            <th class="text-center">Tanggal Cashback</th>
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
                                                <td class="text-center">{{\Carbon\Carbon::parse($cashback->invoice->tanggal_transaksi)->format('d-m-Y') }} {{\Carbon\Carbon::parse($cashback->invoice->created_at)->format('H:i:s') }}</td>
                                                <td class="text-center">{{$cashback->invoice->jenis_pembayaran}}</td>
                                                <td class="text-center">{{$cashback->invoice->mdr}}</td>
                                                <td class="text-center">{{$cashback->invoice->nominal_mdr}}</td>
                                                <td class="text-center">{{$cashback->invoice->nominal_bayar}}</td>
                                                <td class="text-center">{{$cashback->invoice->nominal_terima_bersih}}</td>
                                                <td class="text-center">{{$cashback->nominal_terima_mdr}}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($cashback->created_at)->format('d-m-Y') }} {{\Carbon\Carbon::parse($cashback->created_at)->format('H:i:s')}}</td>
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
