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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.menu') }}">Admin Menu</a></li>
                                <li class="breadcrumb-item active">User Transaction List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Transaksi</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Transaksi User</h4>
                            <div class="row">
                                <div class="col-6">
                                    
                                </div>
                                <div class="col-6 text-end">
                                    <div id="daterange" class="float-end" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%; text-align:center">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> 
                                        <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table user-table-transaction dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Invoice</th>
                                            <th>Store Identifier</th>
                                            <th class="text-center">Tanggal Transaksi</th>
                                            <th class="text-center">Tanggal Pembayaran</th>
                                            <th class="text-center">Jenis Pembayaran</th>
                                            <th>Status Pembayaran</th>
                                            <th>Nominal Bayar</th>
                                            <th>MDR (%)</th>
                                            <th>Nominal MDR</th>
                                            <th>Nominal Terima Bersih Qris</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php $no=0; @endphp
                                        @foreach($invoice as $key => $invoice)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $invoice->nomor_invoice }}</td>
                                                <td>{{ $invoice->store_identifier }}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($invoice->tanggal_transaksi)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoice->created_at)->format('H:i:s')}}</td>
                                                <td class="text-center">
                                                    @if (!is_null($invoice->tanggal_pelunasan) || !empty($invoice->tanggal_pelunasan))
                                                        {{\Carbon\Carbon::parse($invoice->tanggal_pelunasan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoice->updated_at)->format('H:i:s')}}
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $invoice->jenis_pembayaran }}</td>
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
                                                <td>{{ $invoice->nominal_bayar }}</td>
                                                <td>{{ $invoice->mdr }}</td>
                                                <td>{{ $invoice->nominal_mdr }}</td>
                                                <td>{{ $invoice->nominal_terima_bersih }}</td>
                                            </tr>
                                        @endforeach --}}
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
