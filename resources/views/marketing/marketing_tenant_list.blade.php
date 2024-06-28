<x-marketing-layout>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard.invitationcode') }}">Code</a></li>
                                <li class="breadcrumb-item active">Data Tenant</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Tenant List</h4>
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
                            <h4 class="header-title mb-3">Tabel Tenant List</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-center">Invitation Code</th>
                                            <th>Nama Tenant</th>
                                            <th class="text-center">Tanggal Bergabung</th>
                                            <th>Phone</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($tenant as $key => $t)
                                            @foreach ($t->invitationCodeTenant as $userTenant)
                                                <tr>
                                                    <td>{{ $no+=1 }}</td>
                                                    <td class="text-center">{{ $userTenant->invitationCode->inv_code }}</td>
                                                    <td>{{ $userTenant->name }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($userTenant->tanggal_bergabung)->format('d-m-Y') }}</td>
                                                    <td>{{ $userTenant->phone }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('marketing.dashboard.tenant.detail', ['inv_code' => $userTenant->invitationCode->id, 'id' => $userTenant->id_tenant]) }}">
                                                            <button title="Lihat detail tenant" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
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
</x-marketing-layout>