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
                                <li class="breadcrumb-item active">Mitra Bisnis</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Mitra Bisnis</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Mitra Bisnis</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table user-table-mitra-bisnis-list w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th class="text-center">Tanggal Gabung</th>
                                            <th class="text-center">Total Merchant</th>
                                            <th class="text-center">Total Withdraw</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php $no=0; @endphp
                                        @foreach ($tenantList as $tenant)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $tenant->name }}</td>
                                                <td>{{ $tenant->phone }}&nbsp;@if(!is_null($tenant->phone_number_verified_at) || !empty($tenant->phone_number_verified_at) || $tenant->phone_number_verified_at != "" || $tenant->phone_number_verified_at != NULL) </span><span class="text-success mdi mdi-check-decagram-outline"></span> @else <span class="text-warning mdi mdi-clock-outline"></span> @endif</td>
                                                <td>{{ $tenant->email }}&nbsp;@if(!is_null($tenant->email_verified_at) || !empty($tenant->email_verified_at) || $tenant->email_verified_at != "" || $tenant->email_verified_at != NULL) </span><span class="text-success mdi mdi-check-decagram-outline"></span> @else <span class="text-warning mdi mdi-clock-outline"></span> @endif</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($tenant->created_at)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ $tenant->store_list_count }}</td>
                                                <td class="text-center">{{ $tenant->withdrawal_count }}</td>
                                                <td class="text-center">
                                                    @if ($tenant->is_active == 0)
                                                        <span class="badge bg-soft-warning text-warning">Belum Aktif</span>
                                                    @elseif($tenant->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Aktif</span>
                                                    @elseif($tenant->is_active == 2)
                                                        <span class="badge bg-soft-danger text-danger">Non Aktif</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($tenant->is_active == 0)
                                                        <a href="{{ route('admin.dashboard.mitraBisnis.activation', ['id' => $tenant->id]) }}" class="btn btn-warning rounded-pill waves-effect waves-light"><i class="mdi mdi-check-all"></i></a>
                                                    @elseif($tenant->is_active == 1)
                                                        <a href="{{ route('admin.dashboard.mitraBisnis.activation', ['id' => $tenant->id]) }}" class="btn btn-danger rounded-pill waves-effect waves-light"><i class="mdi mdi-power"></i></a>
                                                    @elseif($tenant->is_active == 2)
                                                        <a href="{{ route('admin.dashboard.mitraBisnis.activation', ['id' => $tenant->id]) }}" class="btn btn-success rounded-pill waves-effect waves-light"><i class="mdi mdi-power"></i></a>
                                                    @endif
                                                    <a href="{{ route('admin.dashboard.mitraBisnis.profile', ['id' => $tenant->id]) }}">
                                                        <button title="Lihat data admin" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach --}}
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