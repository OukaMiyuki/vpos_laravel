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
                                <li class="breadcrumb-item active">Tenant Qris Account</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Tenant Qris Acoount</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Tenant Qris&nbsp;&nbsp;&nbsp;<button data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Tambah kode baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan Akun Qris</button></h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Store Identifier</th>
                                            <th>Email</th>
                                            <th>Qris Login</th>
                                            <th>Qris Password</th>
                                            <th>Qris Merchant ID</th>
                                            <th>Qris Store ID</th>
                                            <th>MDR</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($tenantQris as $key => $qris)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $qris->store_identifier }}</td>
                                                <td>{{ $qris->email }}</td>
                                                <td>{{ $qris->qris_login_user }}</td>
                                                <td>{{ $qris->qris_password }}</td>
                                                <td>{{ $qris->qris_merchant_id }}</td>
                                                <td>{{ $qris->qris_store_id }}</td>
                                                <td>{{ $qris->mdr }}</td>
                                                <td class="text-center">
                                                    <a href="" class="btn btn-xs btn-info"><i class="mdi mdi-pencil"></i></a>
                                                    <a href="" class="btn btn-xs btn-danger"><i class="mdi mdi-trash-can-outline"></i></a>
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
</x-admin-layout>