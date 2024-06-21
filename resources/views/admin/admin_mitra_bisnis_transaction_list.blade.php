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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.mitraBisnis') }}">Mitra Bisnis</a></li>
                                <li class="breadcrumb-item active">Transaction List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Transaksi Mitra Bisnis</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Transaksi Mitra Bisnis</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Invoice</th>
                                            <th>Tenant</th>
                                            <th>Store Identifier</th>
                                            <th>Merchant Name</th>
                                            <th class="text-center">Status Pembayaran</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>Nominal Bayar</th>
                                            <th>MDR (%)</th>
                                            <th>Nominal MDR</th>
                                            <th>Nominal Terima Bersih Qris</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($tenantInvoice as $key => $invoice)
                                            @foreach ($invoice->storeList as $invoiceStore )
                                                @foreach ($invoiceStore->invoice as $invoiceList)
                                                    <tr>
                                                        <td>{{ $no+=1 }}</td>
                                                        <td>{{ $invoiceList->nomor_invoice }}</td>
                                                        <td>{{ $invoice->name }}</td>
                                                        <td>{{ $invoiceStore->store_identifier }}</td>
                                                        <td>{{ $invoiceStore->name }}</td>
                                                        <td class="text-center">
                                                            @if($invoiceList->status_pembayaran == 0)
                                                                <span class="badge bg-soft-warning text-warning">Pending Pembayaran</span>
                                                            @elseif($invoiceList->status_pembayaran == 1)
                                                                <span class="badge bg-soft-success text-success">Selesai</span>
                                                            @endif
                                                        </td>
                                                        <td>{{\Carbon\Carbon::parse($invoiceList->tanggal_transaksi)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoiceList->created_at)->format('H:i:s')}}</td>
                                                        <td>
                                                            @if (!is_null($invoiceList->tanggal_pelunasan) || !empty($invoiceList->tanggal_pelunasan))
                                                                {{\Carbon\Carbon::parse($invoiceList->tanggal_pelunasan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoiceList->updated_at)->format('H:i:s')}}
                                                            @endif
                                                        </td>
                                                        <td>{{ $invoiceList->jenis_pembayaran }}</td>
                                                        <td>{{ $invoiceList->nominal_bayar }}</td>
                                                        <td>{{ $invoiceList->mdr }}</td>
                                                        <td>{{ $invoiceList->nominal_mdr }}</td>
                                                        <td>{{ $invoiceList->nominal_terima_bersih }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
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
</x-admin-layout>
