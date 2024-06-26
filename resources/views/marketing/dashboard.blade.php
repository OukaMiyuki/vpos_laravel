<x-marketing-layout>

        <div class="content">
            <div class="container-fluid">
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
                            {{-- <p id="locationData"></p> --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="{{ asset('assets/images/icons/letter.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="col-7">
                                        <div class="text-end">
                                            <h4 class="text-dark mt-1"><span data-plugin="counterup">{{ $code }}</span></h4>
                                            <p class="text-muted mb-1 text-truncate">Invitation Code</p>
                                            <a href="{{ route('marketing.dashboard.invitationcode') }}" class="btn btn-blue btn-sm ms-2">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="widget-rounded-circle card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="{{ asset('assets/images/icons/box.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="col-7">
                                        <div class="text-end">
                                            <h4 class="text-dark mt-1"><span data-plugin="counterup">{{ $tenantNumber }}</span></h4>
                                            <p class="text-muted mb-1 text-truncate">Redeemed Code</p>
                                            <a href="{{ route('marketing.dashboard.tenant.list') }}" class="btn btn-blue btn-sm ms-2">
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
                                    <div class="col-5">
                                        <img src="{{ asset('assets/images/icons/digital-wallet.png') }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="col-7">
                                        <div class="text-end">
                                            <h4 class="text-dark mt-1">RP.&nbsp;<span data-plugin="counterup">@money($qrisWallet->saldo)</span></h4>
                                            <p class="text-muted mb-1 text-truncate">Saldo Anda</p>
                                            <a href="{{ route('marketing.finance.saldo') }}" class="btn btn-blue btn-sm ms-2">
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
                <!-- end row-->
                <div class="row">
                    {{-- <button onclick="getLocation()">Try It</button>
                    <p id="demo"></p> --}}
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                    </div>
                                </div>
                                <h4 class="header-title mb-3">Tenant Terbaru</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Action</th>
                                                <th>Nama</th>
                                                <th>Tanggal Bergabung</th>
                                                <th>Phone</th>
                                                <th>Invitation Code</th>
                                                <th>Holder</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tenantTerbaru as $tenants)
                                                @foreach ($tenants->invitationCodeTenant as $tenantInfo)
                                                    <tr>
                                                        <td><a href="{{ route('marketing.dashboard.tenant.detail', ['inv_code' => $tenantInfo->invitationCode->id, 'id' => $tenantInfo->id]) }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a></td>
                                                        <td>{{ $tenantInfo->name }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($tenantInfo->created_at)->format('d-m-Y') }}</td>
                                                        <td>{{ $tenantInfo->phone }}</td>
                                                        <td>{{ $tenantInfo->invitationCode->inv_code }}</td>
                                                        <td>{{ $tenantInfo->invitationCode->holder }}</td>
                                                    </tr>
                                                @endforeach
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
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                    </div>
                                </div>
                                <h4 class="header-title mb-3">Pemasukan Terbaru</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-nowrap table-hover table-centered m-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Action</th>
                                                <th>Nama Tenant</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Status</th>
                                                <th>Nominal Insentif (Rp.)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pemasukanTerbaru as $tenantList)
                                                @foreach ($tenantList->invitationCodeTenant as $tenantInfo)
                                                    @foreach ($tenantInfo->withdrawal as $detail)
                                                        <tr>
                                                            <td><a href="{{ route('marketing.dashboard.tenant.detail', ['inv_code' => $tenantInfo->invitationCode->id, 'id' => $tenantInfo->id]) }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a></td>
                                                            <td>{{ $tenantInfo->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($detail->tanggal_penarikan)->format('d-m-Y') }}</td>
                                                            <td>
                                                                @if ($detail->status == 1)
                                                                    <span class="badge bg-soft-success text-success">Sukses</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $detail->detailWithdraw->biaya_mitra }}</td>
                                                        </tr>
                                                    @endforeach
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
        </div>

</x-marketing-layout>
