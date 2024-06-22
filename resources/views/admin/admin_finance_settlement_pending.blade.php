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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.finance.settlement.history') }}">Settlement History</a></li>
                                    <li class="breadcrumb-item active">Settlement Pending</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Data Settlement Pending</h4>
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
                            <h4 class="header-title mb-3">Settlement Pending List</h4>
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="mb-3"><span>Total Settlement Pending : </span>{{ $settlemetHistory->sum('nominal_settle') }}</h3>
                                </div>
                                <div class="col-6 text-end">
                                    <h3 class="mb-3"><span>Total Insentif Cashback Pending : </span>{{ $settlemetHistory->sum('nominal_insentif_cashback') }} </h3>
                                </div>
                            </div>
                            <div class="responsive-table-plugin">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Tenant</th>
                                                    <th>Email</th>
                                                    <th>Nomor Settlement</th>
                                                    <th class="text-center">Settlement Schedule</th>
                                                    <th class="text-center">Nominal Settlement (Rp.)</th>
                                                    <th class="text-center">Nominal Insentif Cashback (Rp.)</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $no=0;
                                            @endphp
                                            <tbody>
                                                @foreach ($settlemetHistory as $stlpending)
                                                    <tr>
                                                        <td>{{$no+=1}}</td>
                                                        <td>{{$stlpending->tenant->name}}</td>
                                                        <td>{{$stlpending->tenant->email}}</td>
                                                        <td>{{$stlpending->nomor_settlement_pending}}</td>
                                                        <td class="text-center">{{\Carbon\Carbon::parse($stlpending->settlement_schedule)->format('d-m-Y')}}</td>
                                                        <td>{{$stlpending->nominal_settle}}</td>
                                                        <td>{{$stlpending->nominal_insentif_cashback}}</td>
                                                        <td>
                                                            @if ($stlpending->status == 0)
                                                                <span class="badge bg-soft-warning text-danger">Settlement Gagal</span>
                                                            @elseif($stlpending->status == 1)
                                                                <span class="badge bg-soft-success text-success">Settlement Sukses</span>
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
