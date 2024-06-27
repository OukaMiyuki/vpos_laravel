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
                                <li class="breadcrumb-item active">Transaksi Qris Hari Ini</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Transaksi Qris Hari Ini</h4>
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
                                    <a href="" class="dropdown-item">Cetak Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Tabel Data Transaksi Qris Toko Hari Ini</h4>
                            <div class="table-responsive">
                                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Action</th>
                                            <th>Invoice</th>
                                            <th>Kasir</th>
                                            <th class="text-center">Tanggal Transaksi</th>
                                            <th class="text-center">Tanggal Pembayaran</th>
                                            <th class="text-center">Pembayaran</th>
                                            <th class="text-center">Transaksi Oleh</th>
                                            <th>Status Transaksi</th>
                                            <th>Status Pembayaran</th>
                                            <th class="text-center">Sub Total (Rp.)</th>
                                            <th class="text-center">Pajak (Rp.)</th>
                                            <th class="text-center">Diskon (Rp.)</th>
                                            <th class="text-center">MDR (%)</th>
                                            <th class="text-center">Nominal MDR (Rp.)</th>
                                            <th class="text-center">Nominal Terima Bersih Qris (Rp.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($invoice as $invoice)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>
                                                    <a href="{{ route('tenant.transaction.invoice', ['id' => $invoice->id ]) }}">
                                                        <button title="Lihat Invoice" type="button" class="btn btn-info btn-xs waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
                                                </td>
                                                <td>{{ $invoice->nomor_invoice }}</td>
                                                <td>
                                                    @if (empty($invoice->kasir->name ) || is_null($invoice->kasir->name) || $invoice->kasir->name == NULL || $invoice->kasir->name == "")
                                                        Transaksi Oleh Tenant
                                                    @else
                                                        {{ $invoice->kasir->name }}
                                                    @endif
                                                </td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($invoice->tanggal_transaksi)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoice->created_at)->format('H:i:s')}}</td>
                                                <td class="text-center">@if(!is_null($invoice->tanggal_pelunasan) || !empty($invoice->tanggal_pelunasan)){{\Carbon\Carbon::parse($invoice->tanggal_pelunasan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoice->updated_at)->format('H:i:s')}}@endif</td>
                                                <td class="text-center">{{ $invoice->jenis_pembayaran }}</td>
                                                <td class="text-center">
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
                                                <td class="text-center">{{ $invoice->sub_total }}</td>
                                                <td class="text-center">{{ $invoice->pajak }}</td>
                                                <td class="text-center">{{ $invoice->diskon }}</td>
                                                <td class="text-center">{{ $invoice->mdr }}</td>
                                                <td class="text-center">{{ $invoice->nominal_mdr }}</td>
                                                <td class="text-center">{{ $invoice->nominal_terima_bersih }}</td>
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