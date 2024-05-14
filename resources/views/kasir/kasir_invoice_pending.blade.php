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
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Invoice</th>
                                            <th>Customer Info</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($invoice as $invoice)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $invoice->nomor_invoice }}</td>
                                                <td>{{ $invoice->customer->customer_info }}</td>
                                                <td>{{ $invoice->tanggal_transaksi }}</td>
                                                <td><span class="badge bg-soft-danger text-danger">Belum Diproses</span></td>
                                                <td>
                                                    <a href="{{ route('kasir.transaction.pending.restore', ['id' => $invoice->id ]) }}">
                                                        <button title="Restore transaction" type="button" class="btn btn-success rounded-pill waves-effect waves-light"><span class="mdi mdi-history"></span></button>&nbsp;
                                                    </a>
                                                    <a href="{{ route('kasir.transaction.pending.delete', ['id' => $invoice->id ]) }}">
                                                        <button title="Hapus transaksi pending" type="button" class="btn btn-danger rounded-pill waves-effect waves-light"><span class="mdi mdi-trash-can"></span></button>
                                                    </a>
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
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-kasir-layout>