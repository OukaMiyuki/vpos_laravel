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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.marketing') }}">Mitra Aplikasi</a></li>
                                <li class="breadcrumb-item active">Invitation Code</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Invitation Code</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Invitation Code</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th class="text-center">Invitation Code</th>
                                            <th>Holder</th>
                                            <th class="text-center">Attempt</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Store List</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach ($invitationCode as $inv)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $inv->marketing->name }}</td>
                                                <td>{{ $inv->marketing->email }}</td>
                                                <td class="text-center">{{$inv->inv_code}}</td>
                                                <td>{{ $inv->holder }}</td>
                                                <td class="text-center">{{ $inv->tenant->count() }}</td>
                                                <td class="text-center">
                                                    @if ($inv->is_active == 0)
                                                        <span class="badge bg-soft-warning text-danger">Non Aktif</span>
                                                    @elseif($inv->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Aktif</span>
                                                    @endif
                                                </td>
                                                <td class="text-center"><a title="Lihat daftar tenant" href="{{ route('admin.dashboard.marketing.invitationcode.store.list', ['id' => $inv->id]) }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a></td>
                                                <td class="text-center">
                                                    @if ($inv->is_active == 1)
                                                        <a title="Nonaktifkan" href="{{ route('admin.dashboard.marketing.invitationcode.activation', ['id' => $inv->id]) }}" class="btn btn-xs btn-danger"><i class="mdi mdi-power"></i></a>
                                                    @else
                                                        <a title="Aktifkan" href="{{ route('admin.dashboard.marketing.invitationcode.activation', ['id' => $inv->id]) }}" class="btn btn-xs btn-success"><i class="mdi mdi-power"></i></a>
                                                    @endif
                                                    <a title="Lihat daftar pemasukan" href="{{ route('admin.dashboard.marketing.invitationcode.income.list', ['id' => $inv->id]) }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
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
