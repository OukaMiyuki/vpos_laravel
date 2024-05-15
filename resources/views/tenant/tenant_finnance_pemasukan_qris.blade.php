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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.finance') }}">Finance</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.saldo') }}">Saldo</a></li>
                                <li class="breadcrumb-item active">Qris</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Pemasukan Qris</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/salary.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $totalPemasukanQrisHariini }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Pemasukan Hari Ini</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/financial-statement.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $totalPemasukanQrisBulanIni }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Pemasukan Bulan Ini</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/money.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $totalPemasukanQris }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Pemasukan Qris</p>
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
                            <h4 class="header-title mb-3">Tabel Data Pemasukan Qris Toko</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>No.</th>
                                            <th>Invoice</th>
                                            <th>Nilai Transaksi (Rp.)</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Pembayaran</th>
                                            <th>Transaksi Oleh</th>
                                            <th>Status Transaksi</th>
                                            <th>Status Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($invoice as $invoice)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('tenant.transaction.invoice', ['id' => $invoice->id ]) }}">
                                                        <button title="Lihat Invoice" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
                                                </td>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $invoice->nomor_invoice }}</td>
                                                <td>{{ $invoice->sub_total+$invoice->pajak }}</td>
                                                <td>{{ $invoice->tanggal_transaksi }}</td>
                                                <td>{{ $invoice->jenis_pembayaran }}</td>
                                                <td>
                                                    @if (empty($invoice->kasir->name ) || is_null($invoice->kasir->name) || $invoice->kasir->name == NULL || $invoice->kasir->name == "")
                                                        Tenant
                                                    @else
                                                        Kasir
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($invoice->jenis_pembayaran) || !is_null($invoice->jenis_pembayaran) || $invoice->jenis_pembayaran != "")
                                                        @if($invoice->status_pembayaran == 0)
                                                            <span class="badge bg-soft-warning text-warning">Pending Pembayaran</span>
                                                        @elseif($invoice->status_pembayaran == 1)
                                                            <span class="badge bg-soft-success text-success">Selesai</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Belum Diproses</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($invoice->status_pembayaran == 0)
                                                        <span class="badge bg-soft-warning text-warning">Belum Bayar</span>
                                                    @elseif($invoice->status_pembayaran == 1)
                                                        <span class="badge bg-soft-success text-success">Dibayar</span>
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
        </div>
        <!-- container -->
    </div>
</x-tenant-layout>