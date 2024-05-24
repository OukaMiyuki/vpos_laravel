<x-kasir-layout>
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
                                <li class="breadcrumb-item"><a href="{{ route('kasir.transaction') }}">Transaction</a></li>
                                <li class="breadcrumb-item active">Pending Payment</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Qris Pending Transaction</h4>
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
                            <h4 class="header-title mb-3">Tabel Transaction Pending Qris Payment List</h4>
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>No.</th>
                                            <th>Invoice</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Tanggal Pelunasan</th>
                                            <th>Pembayaran</th>
                                            <th>Status Transaksi</th>
                                            <th>Status Pembayaran</th>
                                            <th>Sub Total (Rp.)</th>
                                            <th>Pajak (Rp.)</th>
                                            <th>Diskon (Rp.)</th>
                                            <th>MDR (%)</th>
                                            <th>Nominal MDR (Rp.)</th>
                                            <th>Nominal Terima Bersih Qris (Rp.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($invoice as $invoice)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('kasir.pos.transaction.invoice', ['id' => $invoice->id ]) }}">
                                                        <button title="Restor transaction" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
                                                </td>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $invoice->nomor_invoice }}</td>
                                                <td>{{ $invoice->tanggal_transaksi }}</td>
                                                <td>{{ $invoice->tanggal_pelunasan }}</td>
                                                <td>{{ $invoice->jenis_pembayaran }}</td>
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
                                                <td>{{ $invoice->sub_total }}</td>
                                                <td>{{ $invoice->pajak }}</td>
                                                <td>{{ $invoice->diskon }}</td>
                                                <td>{{ $invoice->mdr }}</td>
                                                <td>{{ $invoice->nominal_mdr }}</td>
                                                <td>{{ $invoice->nominal_terima_bersih }}</td>
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
</x-kasir-layout>