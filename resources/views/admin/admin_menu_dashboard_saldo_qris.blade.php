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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.saldo') }}">Saldo</a></li>
                                <li class="breadcrumb-item active">Qris</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Insentif Transfer Qris</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/withdraw.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">@money($totalPendapatanAdmin)</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Insentif Withdraw User</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/digital-wallet.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">@money($adminQrisWallet->saldo)</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Saldo Qris</p>
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
                            <h4 class="header-title mb-3">History Insentif Transfer</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table nowrap w-100">
                                    <table id="basic-table" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Action</th>
                                                <th>No. Invoice</th>
                                                <th>User Email</th>
                                                <th>Jenis Penarikan</th>
                                                <th class="text-center">Tanggal Penarikan</th>
                                                <th>Nominal (Rp.)</th>
                                                <th class="text-center">Total Biaya Transfer (Rp.)</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=0; @endphp
                                            @foreach($withdrawals as $key => $wd)
                                                <tr>
                                                    <td>{{$no+=1}}</td>
                                                    <td>
                                                        <a href="{{ route('admin.dashboard.menu.userWithdrawals.detail', ['id' => $wd->id]) }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
                                                    </td>
                                                    <td>{{$wd->invoice_pemarikan}}</td>
                                                    <td>{{$wd->email}}</td>
                                                    <td>{{$wd->jenis_penarikan}}</td>
                                                    <td class="text-center">
                                                        {{\Carbon\Carbon::parse($wd->tanggal_penarikan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($wd->created_at)->format('H:i:s')}}
                                                    </td>
                                                    <td>@currency($wd->nominal)</td>
                                                    <td class="text-center">@currency($wd->biaya_admin)</td>
                                                    <td class="text-center">
                                                        @if ($wd->status == 0)
                                                            <span class="badge bg-soft-danger text-danger">Penarikan Gagal</span>
                                                        @else
                                                            <span class="badge bg-soft-success text-success">Penarikan Sukses</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </div>
</x-admin-layout>
