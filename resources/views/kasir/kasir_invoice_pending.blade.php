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
                                <li class="breadcrumb-item active">Pending</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Pending Transaction (Belum Dirposes)</h4>
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
                            <h4 class="header-title mb-3">Tabel Data Pending Transaction List</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th width="5">No.</th>
                                            <th width="5" class="text-center">Action</th>
                                            <th width="40">Customer Info</th>
                                            <th width="30">Invoice</th>
                                            <th class="text-center">Tanggal Transaksi</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($invoice as $invoice)
                                            <tr>
                                                <td>{{$no+=1}}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('kasir.transaction.pending.restore', ['id' => $invoice->id ]) }}">
                                                        <button title="Restore transaction" type="button" class="btn btn-info btn-xs waves-effect waves-light"><span class="mdi mdi-history"></span></button>&nbsp;
                                                    </a>
                                                    <a href="{{ route('kasir.transaction.pending.delete', ['id' => $invoice->id ]) }}">
                                                        <button title="Hapus transaksi pending" type="button" class="btn btn-danger btn-xs waves-effect waves-light"><span class="mdi mdi-trash-can"></span></button>
                                                    </a>
                                                </td>
                                                <td>{{$invoice->customer->customer_info}}</td>
                                                <td>{{$invoice->nomor_invoice}}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($invoice->tanggal_transaksi)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoice->created_at)->format('H:i:s')}}</td>
                                                <td class="text-center"><span class="badge bg-soft-danger text-danger">Belum Diproses</span></td>
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