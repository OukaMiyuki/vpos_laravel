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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko') }}">Store</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko.list') }}">Store List</a></li>
                                <li class="breadcrumb-item active">Invoice</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Transaksi - {{$store->name}}</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Transaksi</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Invoice</th>
                                            <th>Store Identifier</th>
                                            <th>Nama Merchant</th>
                                            <th class="text-center">Tanggal Transaksi</th>
                                            <th class="text-center">Tanggal Pembayaran</th>
                                            <th class="text-center">Jenis Pembayaran</th>
                                            <th class="text-center">Status Pembayaran</th>
                                            <th class="text-center">Nominal Bayar</th>
                                            <th class="text-center">MDR (%)</th>
                                            <th class="text-center">Nominal MDR</th>
                                            <th class="text-center">Nominal Terima Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($invoice as $key => $invoice)
                                            <tr>
                                                <td>{{$no+=1 }}</td>
                                                <td>{{$invoice->nomor_invoice}}</td>
                                                <td>{{$invoice->store_identifier}}</td>
                                                <td>{{$invoice->storeMitra->name}}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($invoice->tanggal_transaksi)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoice->created_at)->format('H:i:s')}}</td>
                                                <td class="text-center">@if(!is_null($invoice->tanggal_pelunasan) || !empty($invoice->tanggal_pelunasan)){{\Carbon\Carbon::parse($invoice->tanggal_pelunasan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoice->updated_at)->format('H:i:s')}}@endif</td>
                                                <td class="text-center">{{$invoice->jenis_pembayaran}}</td>
                                                <td class="text-center">
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
                                                <td class="text-center">{{$invoice->nominal_bayar}}</td>
                                                <td class="text-center">{{$invoice->mdr}}</td>
                                                <td class="text-center">{{$invoice->nominal_mdr}}</td>
                                                <td class="text-center">{{$invoice->nominal_terima_bersih}}</td>
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
</x-tenant-layout>