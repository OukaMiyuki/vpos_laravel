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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.menu') }}">Admin Menu</a></li>
                                <li class="breadcrumb-item active">User Withdrawals List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Withdraw Mitra Bisnis</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Withdraw Mitra Bisnis</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Action</th>
                                            <th>No. Invoice</th>
                                            <th>Name</th>
                                            <th>User Email</th>
                                            <th>Tanggal Penarikan</th>
                                            <th>Nominal</th>
                                            <th>Biaya Transfer</th>
                                            <th>Nominal Bersih Penarikan</th>
                                            <th>Status</th>
                                            <th>Biaya Nobu</th>
                                            <th>Insentif Mitra Aplikasi</th>
                                            <th>Nomnial Penarikan Tenant</th>
                                            <th>Insentif Admin</th>
                                            <th>Insentif Agregate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($tenantWithdraw as $key => $tenant)
                                            @foreach ($tenant->withdrawal as $withdrawal)
                                                <tr>
                                                    <td>{{ $no+=1 }}</td>
                                                    <td>
                                                        <a href="" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
                                                    </td>
                                                    <td>{{ $withdrawal->invoice_pemarikan }}</td>
                                                    <td>{{ $tenant->name }}</td>
                                                    <td>{{ $tenant->email }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($withdrawal->tanggal_penarikan)->format('d-m-Y') }}</td>
                                                    <td>{{ $withdrawal->nominal }}</td>
                                                    <td>{{ $withdrawal->biaya_admin }}</td>
                                                    <td>{{ $withdrawal->detailWithdraw->nominal_bersih_penarikan }}</td>
                                                    <td>
                                                        @if ($withdrawal->status == 0)
                                                            <span class="badge bg-soft-danger text-danger">Penarikan Gagal</span>
                                                        @else
                                                            <span class="badge bg-soft-success text-success">Penarikan Sukses</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $withdrawal->detailWithdraw->biaya_nobu }}</td>
                                                    <td>{{ $withdrawal->detailWithdraw->biaya_mitra }}</td>
                                                    <td>{{ $withdrawal->detailWithdraw->biaya_tenant }}</td>
                                                    <td>{{ $withdrawal->detailWithdraw->biaya_admin_su }}</td>
                                                    <td>{{ $withdrawal->detailWithdraw->biaya_agregate }}</td>
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
        </div>
    </div>
</x-admin-layout>