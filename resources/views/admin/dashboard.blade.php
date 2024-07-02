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
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-2">
                                    <i class="mdi mdi-autorenew"></i>
                                </a>
                            </form>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
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
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $marketingCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Mitra Aplikasi</p>
                                        <a href="{{route('admin.dashboard.marketing.list')}}" class="btn btn-blue btn-sm ms-2">
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
                                    <img src="{{ asset('assets/images/icons/partner.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $mitraBisnis }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Mitra Bisnis</p>
                                        <a href="{{route('admin.dashboard.mitraBisnis.list')}}" class="btn btn-blue btn-sm ms-2">
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
                                    <img src="{{ asset('assets/images/icons/suplier.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1""><span data-plugin="counterup">{{ $mitraTenant }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Mitra Tenant</p>
                                        <a href="{{route('admin.dashboard.mitraTenant.list')}}" class="btn btn-blue btn-sm ms-2">
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
            </div>
            <div class="row">
                <div class="col-md-6 col-xl-6">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{ asset('assets/images/icons/salary.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">@money($totalWithdrawToday)</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Insentif Withdraw Hari Ini</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <!-- end col-->
                <div class="col-md-6 col-xl-6">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{ asset('assets/images/icons/balance-sheet.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-9">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $withdrawCount }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Withdraw</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <!-- end col-->
            </div>
            <!-- end row-->
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">Lihat Semua Laporan</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Mitra Aplikasi Baru</h4>
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Action</th>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Tanggal Gabung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach ($marketing as $mitra)
                                            <tr>
                                                <td>
                                                    <a href="{{route('admin.dashboard.marketing.profile', ['id' => $mitra->id])}}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>&nbsp;&nbsp;
                                                    @if($mitra->is_active == 0)
                                                        <a href="{{route('admin.dashboard.marketing.account.activation', ['id' => $mitra->id])}}" class="btn btn-xs btn-warning"><i class="mdi mdi-check-all"></i></a>
                                                    @elseif($mitra->is_active == 1)
                                                        <a href="{{route('admin.dashboard.marketing.account.activation', ['id' => $mitra->id])}}" class="btn btn-xs btn-danger"><i class="mdi mdi-power"></i></a>
                                                    @elseif($mitra->is_active == 2)
                                                        <a href="{{route('admin.dashboard.marketing.account.activation', ['id' => $mitra->id])}}" class="btn btn-xs btn-success"><i class="mdi mdi-power"></i></a>
                                                    @endif
                                                </td>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $mitra->name }}</td>
                                                <td>@if(!is_null($mitra->detail->jenis_kelamin)) {{$mitra->detail->jenis_kelamin}} @endif</td>
                                                <td>{{ $mitra->email }}</td>
                                                <td>
                                                    @if($mitra->is_active == 0)
                                                        <span class="badge bg-soft-warning text-warning">Pending Verification</span>
                                                    @elseif($mitra->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Aktif</span>
                                                    @elseif($mitra->is_active == 2)
                                                        <span class="badge bg-soft-danger text-danger">Non Aktif</span>
                                                    @endif
                                                </td>
                                                <td>{{\Carbon\Carbon::parse($mitra->created_at)->format('d-m-Y')}}</td>
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
                                    <a href="javascript:void(0);" class="dropdown-item">Lihat Semua Laporan</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">History Penarikan User Terbaru</h4>
                            <div class="table-responsive">
                                <table class="table table-borderless table-nowrap table-hover table-centered m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">Action</th>
                                            <th>No.</th>
                                            <th>Invoice</th>
                                            <th class="text-center">Tanggal Penarikan</th>
                                            <th class="text-center">Nominal (Rp.)</th>
                                            <th class="text-center">Insentif Admin (Rp.)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $no=0;
                                    @endphp
                                    <tbody>
                                        @foreach ($withdrawNew as $wd)
                                            @foreach ($wd->detailWithdraw as $insentif)
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.dashboard.menu.userWithdrawals.detail', ['id' => $wd->id]) }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
                                                    </td>
                                                    <td>{{ $no+=1 }}</td>
                                                    <td>{{ $wd->invoice_pemarikan }}</td>
                                                    <td class="text-center">{{\Carbon\Carbon::parse($wd->tanggal_penarikan)->format('d-m-Y') }} {{\Carbon\Carbon::parse($wd->created_at)->format('H:i:s') }}</td>
                                                    <td class="text-center">{{ $wd->nominal }}</td>
                                                    <td class="text-center">
                                                        @if ($wd->status == 0)
                                                            0
                                                        @else
                                                            {{$insentif->nominal}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($wd->status == 0)
                                                            <span class="badge bg-soft-danger text-danger">Penarikan Gagal</span>
                                                        @else
                                                            <span class="badge bg-soft-success text-success">Penarikan Sukses</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
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
