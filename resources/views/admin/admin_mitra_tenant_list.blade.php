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
                        <h4 class="page-title">Data Mitra Tenant</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Mitra Tenant</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Jenis Kelamin</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Total Invoice</th>
                                            <th class="text-center">Total Withdraw</th>
                                            <th class="text-center">Invitation Code</th>
                                            <th class="text-center">Holder</th>
                                            <th class="text-center">Nama Mitra</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach ($tenantMitra as $mitra)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $mitra->name }}</td>
                                                <td>{{ $mitra->email }}</td>
                                                <td>{{ $mitra->phone }}</td>
                                                <td>{{ $mitra->detail->jenis_kelamin }}</td>
                                                <td class="text-center">
                                                    @if ($mitra->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>{{ $mitra->invoice_count }}</td>
                                                <td>{{ $mitra->withdrawal_count }}</td>
                                                <td class="text-center">{{ $mitra->invitationCode->inv_code }}</td>
                                                <td class="text-center">{{ $mitra->invitationCode->holder }}</td>
                                                <td class="text-center">{{ $mitra->invitationCode->marketing->name }}</td>
                                                <td class="text-center">
                                                    <a href="">
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