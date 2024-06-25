<x-admin-layout>

    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.marketing') }}">Mitra Aplikasi</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.marketing.invitationcode') }}">Invitation Code</a></li>
                                    <li class="breadcrumb-item active">Store Lists</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Invitation Code's Info</h4>
                        </div>
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
                                    <a href="" class="dropdown-item">Lihat Semua Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Store List</h4>
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="mb-3"><span>Invitation Code : </span>{{ $storeList->inv_code }} - {{ $storeList->holder }}</h3>
                                </div>
                            </div>
                            <div class="responsive-table-plugin">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="scroll-horizontal-table" class="table w-100 nowrap">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Mitra Aplikasi</th>
                                                    <th>Nama Tenant</th>
                                                    <th>Nama Toko</th>
                                                    <th>Jenis Usaha</th>
                                                    <th class="text-center">Status UMI</th>
                                                    <th class="text-center">Tanggal Gabung</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $no=0;
                                            @endphp
                                            <tbody>
                                                @foreach ($storeList->tenant as $tenantList)
                                                    <tr>
                                                        <td>{{ $no+=1 }}</td>
                                                        <td>{{ $storeList->marketing->name }}</td>
                                                        <td>{{ $tenantList->name }}</td>
                                                        <td>{{ $tenantList->storeDetail->name }}</td>
                                                        <td>{{ $tenantList->storeDetail->jenis_usaha }}</td>
                                                        <td class="text-center">
                                                            @if ($tenantList->storeDetail->status_umi == 0)
                                                                <span class="badge bg-soft-warning text-warning">Tidak Terdaftar</span>
                                                            @elseif($tenantList->storeDetail->status_umi == 1)
                                                                <span class="badge bg-soft-success text-success">Terdaftar</span>
                                                            @elseif($tenantList->storeDetail->status_umi == 2)
                                                                <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{\Carbon\Carbon::parse($tenantList->tanggal_penarikan)->format('d-m-Y')}}</td>
                                                        <td class="text-center">
                                                            @if ($storeList->is_active == 0)
                                                                <span class="badge bg-soft-danger text-danger">Tidak Aktif</span>
                                                            @else
                                                                <span class="badge bg-soft-success text-success">Aktif</span>
                                                            @endif
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
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>

</x-admin-layout>
