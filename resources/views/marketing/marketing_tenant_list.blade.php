<x-marketing-layout>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex align-items-center mb-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control border-0" id="dash-daterange">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                    <i class="mdi mdi-calendar-range"></i>
                                    </span>
                                </div>
                                <a href="#" class="btn btn-blue btn-sm ms-2">
                                <i class="mdi mdi-autorenew"></i>
                                </a>
                                <a href="#" class="btn btn-blue btn-sm ms-1">
                                <i class="mdi mdi-filter-variant"></i>
                                </a>
                            </form>
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
                                            <th>Invitation Code</th>
                                            <th>Nama Tenant</th>
                                            <th>Tanggal Bergabung</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($tenant as $key => $t)
                                            @foreach ($t->invitationCodeTenant as $userTenant)
                                                <tr>
                                                    <td>{{ $no+=1 }}</td>
                                                    <td>{{ $userTenant->invitationCode->inv_code }}</td>
                                                    <td>{{ $userTenant->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($userTenant->tanggal_bergabung)->format('d-m-Y') }}</td>
                                                    <td>{{ $userTenant->phone }}</td>
                                                    <td>
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