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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.kasir') }}">Kasir</a></li>
                                <li class="breadcrumb-item active">Data Kasir Aktif</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Kasir Aktif</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Kasir Aktif</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Posisi</th>
                                            <th>Jenis Kelamin</th>
                                            <th>No. KTP</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($kasirListActive as $key => $kasir)
                                            @foreach ($kasir->kasir as $key => $k)
                                                <tr>
                                                    <td>{{ $no+=1 }}</td>
                                                    <td>{{ $k->name }}</td>
                                                    <td>{{ $k->email }}</td>
                                                    <td>Kasir</td>
                                                    <td>{{ $k->detail->jenis_kelamin }}</td>
                                                    <td>{{ $k->detail->no_ktp }}</td>
                                                    <td>
                                                        @if($k->is_active == 1)
                                                            <span class="badge bg-soft-success text-success">Aktif</span>
                                                        @else
                                                            <span class="badge bg-soft-danger text-danger">Non Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('tenant.kasir.activation', ['id' => $k->id]) }}">
                                                            <button title="Nonaktifkan Kasir" type="button" class="btn
                                                            @if ($k->is_active == 1)
                                                                btn-danger
                                                            @else
                                                                btn-success
                                                            @endif  rounded-pill waves-effect waves-light"><span class="mdi mdi-power"></span></button>&nbsp;
                                                        </a>
                                                        <a href="{{ route('tenant.kasir.detail', ['id' => $k->id]) }}">
                                                            <button title="Lihat data kasir" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
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
