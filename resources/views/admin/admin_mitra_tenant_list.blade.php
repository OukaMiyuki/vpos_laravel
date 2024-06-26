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
                                <li class="breadcrumb-item active">Mitra Tenant List</li>
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
                                <table id="scroll-horizontal-datatable" class="table user-table-mitra-tenant-list w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-center">Action</th>
                                            <th>Nama</th>
                                            <th>No. KTP</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th class="text-center">Tanggal Gabung</th>
                                            <th class="text-center">Jenis Kelamin</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Total Invoice</th>
                                            <th class="text-center">Total Withdraw</th>
                                            <th class="text-center">Invitation Code</th>
                                            <th class="text-center">Holder</th>
                                            <th class="text-center">Nama Mitra</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php $no=0; @endphp
                                        @foreach ($tenantMitra as $mitra)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $mitra->name }}</td>
                                                <td>{{ $mitra->phone }}&nbsp;@if(!is_null($mitra->phone_number_verified_at) || !empty($mitra->phone_number_verified_at) || $mitra->phone_number_verified_at != "" || $mitra->phone_number_verified_at != NULL) </span><span class="text-success mdi mdi-check-decagram-outline"></span> @else <span class="text-warning mdi mdi-clock-outline"></span> @endif</td>
                                                <td>{{ $mitra->email }}&nbsp;@if(!is_null($mitra->email_verified_at) || !empty($mitra->email_verified_at) || $mitra->email_verified_at != "" || $mitra->email_verified_at != NULL) </span><span class="text-success mdi mdi-check-decagram-outline"></span> @else <span class="text-warning mdi mdi-clock-outline"></span> @endif</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($mitra->created_at)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ $mitra->detail->jenis_kelamin }}</td>
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
                                                    @if ($mitra->is_active == 1)
                                                        <a href="{{ route('admin.dashboard.mitraTenant.activation', ['id' => $mitra->id]) }}">
                                                            <button title="Non-aktifkan Tenant" type="button" class="btn btn-danger rounded-pill waves-effect waves-light"><span class="mdi mdi-power"></span></button>
                                                        </a>
                                                    @elseif($mitra->is_active == 2)
                                                        <a href="{{ route('admin.dashboard.mitraTenant.activation', ['id' => $mitra->id]) }}">
                                                            <button title="Aktifkan Tenant" type="button" class="btn btn-success rounded-pill waves-effect waves-light"><span class="mdi mdi-power"></span></button>
                                                        </a>
                                                    @endif
                                                    &nbsp;
                                                    <a href="{{ route('admin.dashboard.mitraTenant.detail', ['id' => $mitra->id]) }}">
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
