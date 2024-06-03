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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko') }}">Merchant</a></li>
                                <li class="breadcrumb-item active">List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Merchant List</h4>
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
                            <h4 class="header-title mb-3">Tabel Merchant List&nbsp;&nbsp;&nbsp;<a href="{{ route('tenant.mitra.dashboard.toko.create') }}"><button title="Tambah merchant baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan merchant baru</button></a></h4>
                        
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Merchant ID</th>
                                            <th>Name</th>
                                            <th>No. Telp Toko</th>
                                            <th>Jenis Usaha</th>
                                            <th>Status Umi</th>
                                            <th>Banyak Invoice</th>
                                            <th>Daftar Invoice</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($storeList as $store)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $store->store_identifier }}</td>
                                                <td>{{ $store->name }}</td>
                                                <td>{{ $store->no_telp_toko }}</td>
                                                <td>{{ $store->jenis_usaha }}</td>
                                                <td>
                                                    @if($store->status_umi == NULL || $store->status_umi == "" || empty($store->status_umi) || is_null($store->status_umi))
                                                        <button type='button' class='btn btn-info btn-xs waves-effect mb-2 waves-light'>UMI Belum Terdaftar</button>
                                                    @else
                                                        @if ($store->status_umi == 0)
                                                            <button type='button' class='btn btn-warning btn-xs waves-effect mb-2 waves-light'>UMI Belum Disetujui</button>
                                                        @elseif($store->status_umi == 1)
                                                            <button type='button' class='btn btn-success btn-xs waves-effect mb-2 waves-light'>Terdaftar UMI</button>
                                                        @elseif($store->status_umi == 2)
                                                            <button type='button' class='btn btn-danger btn-xs waves-effect mb-2 waves-light'>UMI Ditolak</button>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $store->invoice_count }}</td>
                                                <td>
                                                    <a href="{{ route('tenant.mitra.dashboard.toko.invoice', ['store_identifier' => $store->store_identifier]) }}">
                                                        <button title="Lihat daftar invoice" type="button" class="btn btn-primary rounded-pill waves-effect waves-light">Lihat Invoice</button>&nbsp;
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('tenant.mitra.dashboard.toko.detail', ['id' => $store->id, 'store_identifier' => $store->store_identifier]) }}">
                                                        <button title="Lihat detail Toko" type="button" class="btn btn-primary rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
                                                    <a href="{{ route('tenant.mitra.dashboard.toko.edit', ['id' => $store->id ]) }}">
                                                        <button title="Edit data Toko" type="button" class="btn btn-success rounded-pill waves-effect waves-light"><span class="mdi mdi-pencil"></span></button>&nbsp;
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
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-tenant-layout>