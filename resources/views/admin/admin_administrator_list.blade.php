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
                                <li class="breadcrumb-item active">Administrator</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Administrator</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Administrator&nbsp;&nbsp;&nbsp;<a href="{{ route('admin.dashboard.administrator.create') }}"><button data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Tambah kode baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan admin baru</button></a></h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Level</th>
                                            <th>Jenis Kelamin</th>
                                            <th>No. KTP</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach ($adminList as $admin)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $admin->name }}</td>
                                                <td>{{ $admin->email }}</td>
                                                <td>{{ $admin->phone }}</td>
                                                <td>Administrator</td>
                                                <td>{{ $admin->detail->jenis_kelamin }}</td>
                                                <td>{{ $admin->detail->no_ktp }}</td>
                                                <td>
                                                    @if ($admin->is_active == 0)
                                                        <span class="badge bg-soft-danger text-danger">Non Aktif</span>
                                                    @else
                                                        <span class="badge bg-soft-success text-success">Aktif</span>                                                        
                                                    @endif
                                                <td>
                                                    <a href="{{ route('admin.dashboard.administrator.activation', ['id' => $admin->id]) }}">
                                                        <button title="Nonaktifkan Admin" type="button"
                                                        @if ($admin->is_active == 1)
                                                            title="Nonaktifkan Admin"
                                                            class="btn btn-danger rounded-pill waves-effect waves-light"
                                                        @else
                                                            title="Aktifkan Admin"
                                                            class="btn btn-success rounded-pill waves-effect waves-light"
                                                        @endif><span class="mdi mdi-power"></span></button>&nbsp;
                                                    </a>
                                                    <a href="{{ route('admin.dashboard.administrator.detail', ['id' => $admin->id]) }}">
                                                        <button title="Lihat data admin" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
                                                </td>
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