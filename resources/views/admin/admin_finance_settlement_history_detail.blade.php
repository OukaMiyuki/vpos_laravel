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
                                    <li class="breadcrumb-item active">Settlement Detail</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Data Settlement Detail {{$settlementDetailHistory->nomor_settlement}}</h4>
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
                            <h4 class="header-title mb-3">Settlement Info on {{\Carbon\Carbon::parse($settlementDetailHistory->tanggal_settlement)->format('d-m-Y')}}</h4>
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="mb-3"><span>Total Settlement : </span> @currency($settlementDetailHistory->settlement_history_sum_nominal_settle)</h3>
                                </div>
                                <div class="col-6 text-end">
                                    <h3 class="mb-3"><span>Total Insentif Cashback : </span>@currency($settlementDetailHistory->settlement_history_sum_nominal_insentif_cashback) </h3>
                                </div>
                            </div>
                            <div class="responsive-table-plugin">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="scroll-horizontal-table" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Tenant</th>
                                                    <th>Email</th>
                                                    <th class="text-center">Tanggal Settlement</th>
                                                    <th class="text-center">Nominal Settlement (Rp.)</th>
                                                    <th class="text-center">Nominal Insentif Cashback (Rp.)</th>
                                                    <th class="text-center">Status</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $no=0;
                                            @endphp
                                            <tbody>
                                                @foreach ($settlementDetailHistory->settlementHistory as $stl)
                                                    <tr>
                                                        <td>{{$no+=1}}</td>
                                                        <td>{{$stl->tenant->name}}</td>
                                                        <td>{{$stl->tenant->email}}</td>
                                                        <td class="text-center">{{\Carbon\Carbon::parse($stl->settlement_time_stamp)->format('d-m-Y H:i:s')}}</td>
                                                        <td>@currency($stl->nominal_settle)</td>
                                                        <td>@currency($stl->nominal_insentif_cashback)</td>
                                                        <td>
                                                            @if ($stl->status == 0)
                                                                <span class="badge bg-soft-warning text-danger">Settlement Gagal</span>
                                                            @elseif($stl->status == 1)
                                                                <span class="badge bg-soft-success text-success">Settlement Sukses</span>
                                                            @endif
                                                        </td>
                                                        <td>{{$stl->note}}</td>
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
