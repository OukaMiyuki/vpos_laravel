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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.transaction') }}">Transaction</a></li>
                                <li class="breadcrumb-item active">Pending</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Transaksi Pending (Belum Diproses)</h4>
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
                            <h4 class="header-title mb-3">Tabel Transaction Pending List</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>No.</th>
                                            <th>Customer</th>
                                            <th>Invoice</th>
                                            <th>Kasir</th>
                                            <th>Transaksi Oleh</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Status Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($invoice as $invoice)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('tenant.transaction.list.pending.restore', ['id' => $invoice->id ]) }}">
                                                        <button title="Restore transaction" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-history"></span></button>&nbsp;
                                                    </a>
                                                    <a href="{{ route('tenant.transaction.pending.delete', ['id' => $invoice->id ]) }}">
                                                        <button title="Hapus transaksi pending" type="button" class="btn btn-danger rounded-pill waves-effect waves-light"><span class="mdi mdi-trash-can"></span></button>
                                                    </a>
                                                </td>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $invoice->customer->customer_info }}</td>
                                                <td>{{ $invoice->nomor_invoice }}</td>
                                                <td>
                                                    @if (empty($invoice->kasir->name ) || is_null($invoice->kasir->name) || $invoice->kasir->name == NULL || $invoice->kasir->name == "")
                                                        Transaksi Oleh Tenant
                                                    @else
                                                        {{ $invoice->kasir->name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (empty($invoice->kasir->name ) || is_null($invoice->kasir->name) || $invoice->kasir->name == NULL || $invoice->kasir->name == "")
                                                        Tenant
                                                    @else
                                                        Kasir
                                                    @endif
                                                </td>
                                                <td>{{ $invoice->tanggal_transaksi }}</td>
                                                <td>
                                                    <span class="badge bg-soft-danger text-danger">Belum Diproses</span>
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
</x-tenant-layout>