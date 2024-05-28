<x-tenant_mitra-layout>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.app') }}">Application</a></li>
                                <li class="breadcrumb-item active">Qris Account</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Merchant List</h4>
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
                            <h4 class="header-title mb-3">Tabel Merchant Qris List</h4>
                        
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Store Identifier</th>
                                            <th>Qris Login User</th>
                                            <th>Qris Password</th>
                                            <th>Qris Merchant ID</th>
                                            <th>Qris Store ID</th>
                                            <th>MDR (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($qrisAcc as $qris)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $qris->store_identifier }}</td>
                                                <td>{{ $qris->qris_login_user }}</td>
                                                <td>{{ $qris->qris_password }}</td>
                                                <td>{{ $qris->qris_merchant_id }}</td>
                                                <td>{{ $qris->qris_store_id }}</td>
                                                <td>{{ $qris->mdr }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-tenant_mitra-layout>