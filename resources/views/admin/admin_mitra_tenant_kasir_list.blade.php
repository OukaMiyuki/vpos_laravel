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
                                <li class="breadcrumb-item active">Kasir List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Kasir List</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Akun Kasir</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th class="text-center">Jenis Kelamin</th>
                                            <th class="text-center">Status</th>
                                            <th>Store Identifier</th>
                                            <th>Store Name</th>
                                            <th>Tenant</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach ($kasir as $kasir)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $kasir->name }}</td>
                                                <td>{{ $kasir->email }}</td>
                                                <td>{{ $kasir->phone }}</td>
                                                <td class="text-center">{{ $kasir->detail->jenis_kelamin }}</td>
                                                <td class="text-center">
                                                    @if ($kasir->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>{{ $kasir->store->store_identifier }}</td>
                                                <td>{{ $kasir->store->name }}</td>
                                                <td>{{ $kasir->store->tenant->name }}</td>
                                                <td class="text-center">
                                                    @if ($kasir->is_active == 1)
                                                        <a href="{{ route('admin.dashboard.mitraTenant.kasir.activation', ['id' => $kasir->id]) }}">
                                                            <button title="Non-aktifkan Tenant" type="button" class="btn btn-danger rounded-pill waves-effect waves-light"><span class="mdi mdi-power"></span></button>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.dashboard.mitraTenant.kasir.activation', ['id' => $kasir->id]) }}">
                                                            <button title="Aktifkan Tenant" type="button" class="btn btn-success rounded-pill waves-effect waves-light"><span class="mdi mdi-power"></span></button>
                                                        </a>
                                                    @endif
                                                    &nbsp;
                                                    <a href="{{ route('admin.dashboard.mitraTenant.kasir.profile', ['id' =>  $kasir->id]) }}">
                                                        <button title="Lihat data admin" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>
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
