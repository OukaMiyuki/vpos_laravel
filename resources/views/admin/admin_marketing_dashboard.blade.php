<x-admin-layout>

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
                        <h4 class="page-title">Dashboard Mitra Aplikasi</h4>
                    </div>
                </div>
            </div>
            <!-- end page title --> 
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/teamwork.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $marketingList }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Mitra</p>
                                        <a href="{{ route('admin.dashboard.marketing.list') }}" class="btn btn-blue btn-sm ms-2">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <!-- end col-->
                <div class="col-md-6 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/letter.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $invitationCodeCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Invitation Codes</p>
                                        <a href="{{ route('admin.dashboard.marketing.invitationcode') }}" class="btn btn-blue btn-sm ms-2">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <!-- end col-->
                <div class="col-md-6 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/box.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $invTenantCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Redeemed</p>
                                        <a href="{{ route('admin.dashboard.marketing.withdraw') }}" class="btn btn-blue btn-sm ms-2">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
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
                            <h4 class="header-title mb-3">Mitra Aplikasi Baru</h4>
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Profile</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Jabatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($marketingData as $marData)
                                            <tr>
                                                <td>
                                                    <img src="{{ !empty($marData->detail->photo) ? Storage::url('images/profile/'.$marData->detail->photo) : asset('assets/images/blank_profile.png') }}"" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm" />
                                                </td>
                                                <td>
                                                    <h5 class="m-0 fw-normal">
                                                        @if(!empty($marData->name))
                                                            {{ $marData->name }}
                                                         @endif
                                                    </h5>
                                                    <p class="mb-0 text-muted"><small>Bergabung pada {{ $marData->created_at }}</small></p>
                                                </td>
                                                <td>
                                                    @if(!empty($marData->detail->jenis_kelamin))
                                                        {{ $marData->detail->jenis_kelamin }}
                                                    @endif
                                                </td>
                                                <td>
                                                    Marketing
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.dashboard.marketing.profile', ['id' => $marData]) }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-xl-6">
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
                            <h4 class="header-title mb-3">Waiting Account Activation</h4>
                            <div class="table-responsive">
                                <table id="scroll-vertical-datatable" class="table dt-responsive nowrap w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Action</th>
                                            <th>Nama</th>
                                            <th>Tanggal Gabung</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $nomer=0;
                                    @endphp
                                    <tbody>
                                        @foreach ($marketingAktivasi as $marketingAktivasi)
                                            <tr>
                                                <td>{{ $nomer+=1 }}</td>
                                                <td>
                                                    <a href="{{ route('admin.dashboard.marketing.account.activation', ['id'=>$marketingAktivasi->id]) }}" class="btn btn-xs btn-success"><i class="mdi mdi-power"></i></a>
                                                </td>
                                                <td>
                                                    <h5 class="m-0 fw-normal">{{ $marketingAktivasi->name }}</h5>
                                                </td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($marketingAktivasi->created_at)->format('d-m-Y H:i:s')}}
                                                </td>
                                                <td>
                                                    <span class="badge bg-soft-warning text-warning">Non Aktif</span>
                                                </td>
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- end .table-responsive-->
                        </div>
                    </div>
                    <!-- end card-->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>

</x-admin-layout>