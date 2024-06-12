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
                                <li class="breadcrumb-item active">Merchant List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Merchant Mitra Bisnis</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Merchant Mitra Bisnis</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Merchant Name</th>
                                            <th>Store Identifier</th>
                                            <th>MItra Bisnis</th>
                                            <th>Email</th>
                                            <th>Jenis Usaha</th>
                                            <th class="text-center">Status</th>
                                            <th>Status UMI</th>
                                            <th class="text-center">Total Transaksi</th>
                                            <th class="text-center">Lihat Invoice</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach ($storeList as $store)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $store->name }}</td>
                                                <td>{{ $store->store_identifier }}</td>
                                                <td>{{ $store->tenant->name }}</td>
                                                <td>{{ $store->tenant->email }}</td>
                                                <td>{{ $store->jenis_usaha }}</td>
                                                <td class="text-center">
                                                    @if($store->is_active == 0)
                                                        <span class="badge bg-soft-danger text-danger">Non Aktif</span>
                                                    @elseif($store->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($store->status_umi == 0)
                                                        <span class="badge bg-soft-warning text-warning">Tidak Terdaftar</span>
                                                    @elseif($store->status_umi == 1)
                                                        <span class="badge bg-soft-success text-success">Terdaftar</span>
                                                    @elseif($store->status_umi == 2)
                                                        <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $store->invoice_count }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.dashboard.mitraBisnis.merchantList.invoice', ['id' => $store->id, 'store_identifier' => $store->store_identifier]) }}">
                                                        <button title="Lihat daftar invoice" type="button" class="btn btn-primary rounded-pill waves-effect waves-light">Lihat Invoice</button>&nbsp;
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    @if ($store->is_active == 0)
                                                        <a href="{{ route('admin.dashboard.mitraBisnis.merchantList.activation', ['id' => $store->id, 'store_identifier' => $store->store_identifier]) }}">
                                                            <button title="Lihat detail merchant" type="button" class="btn btn-success waves-effect waves-light"><span class="mdi mdi-power"></span></button>
                                                        </a>
                                                    @elseif($store->is_active == 1)
                                                        <a href="{{ route('admin.dashboard.mitraBisnis.merchantList.activation', ['id' => $store->id, 'store_identifier' => $store->store_identifier]) }}">
                                                            <button title="Lihat detail merchant" type="button" class="btn btn-danger waves-effect waves-light"><span class="mdi mdi-power"></span></button>
                                                        </a>
                                                    @endif
                                                    &nbsp;
                                                    <a href="{{ route('admin.dashboard.mitraBisnis.merchantList.detail', ['id' => $store->id, 'store_identifier' => $store->store_identifier]) }}">
                                                        <button title="Lihat detail merchant" type="button" class="btn btn-info waves-effect waves-light"><span class="mdi mdi-eye"></span></button>
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