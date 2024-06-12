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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.mitraTenant') }}">Mitra Tenant</a></li>
                                <li class="breadcrumb-item active">Store List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Store Mitra Tenant</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Store Mitra Tenant</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tenant</th>
                                            <th>Email</th>
                                            <th>Store Identifier</th>
                                            <th>Store Name</th>
                                            <th>Jenis Usaha</th>
                                            <th class="text-center">Status UMI</th>
                                            <th class="text-center">Total Invoice</th>
                                            <th class="text-center">Data Invoice</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach ($storeDetail as $store)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $store->tenant->name }}</td>
                                                <td>{{ $store->tenant->email }}</td>
                                                <td>{{ $store->store_identifier }}</td>
                                                <td>{{ $store->name }}</td>
                                                <td>{{ $store->jenis_usaha }}</td>
                                                <td class="text-center">
                                                    @if ($store->status_umi == 0)
                                                        <span class="badge bg-soft-warning text-warning">Tidak Terdaftar</span>
                                                    @elseif($store->status_umi == 1)
                                                        <span class="badge bg-soft-success text-success">Terdaftar</span>
                                                    @elseif($store->status_umi == 2)
                                                        <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td>{{ $store->invoice_count }}</td>
                                                <td>
                                                    <a href="{{ route('admin.dashboard.mitraTenant.store.invoice', ['id' => $store->id, 'store_identifier' => $store->store_identifier]) }}">
                                                        <button title="Lihat daftar invoice" type="button" class="btn btn-primary rounded-pill waves-effect waves-light">Lihat Invoice</button>&nbsp;
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.dashboard.mitraTenant.store.detail', ['id' => $store->id, 'store_identifier' => $store->store_identifier]) }}">
                                                        <button title="Lihat data admin" type="button" class="btn btn-info waves-effect waves-light"><span class="mdi mdi-eye"></span></button>
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
</x-admin-layout>