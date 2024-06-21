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
                                    <li class="breadcrumb-item"><a href="">Settlement History</a></li>
                                </ol>
                            </div>
                            <h4 class="page-title">Daftar History Settlement</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar History Settlement</h4>
                            <div class="responsive-table-plugin">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="2%">No.</th>
                                                    <th class="text-center">Nomor Settlement</th>
                                                    <th class="text-center">Tanggal</th>
                                                    <th>Nominal Settlement (Rp.)</th>
                                                    <th>Total Cashback (Rp.)</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $no=0;
                                            @endphp
                                            <tbody>
                                                @foreach($settlement as $stl)
                                                    <tr>
                                                        <td>{{$no+=1}}</td>
                                                        <td>{{$stl->nomor_settlement}}</td>
                                                        <td class="text-center">{{\Carbon\Carbon::parse($stl->tanggal_settlement)->format('d-m-Y')}}</td>
                                                        <td>{{$stl->settlement_history_sum_nominal_settle}}</td>
                                                        <td>{{$stl->settlement_history_sum_nominal_insentif_cashback}}</td>
                                                        <td>
                                                            @if ($stl->status == 0)
                                                                <span class="badge bg-soft-warning text-danger">Settlement Gagal</span>
                                                            @elseif($stl->status == 1)
                                                                <span class="badge bg-soft-success text-success">Settlement Sukses</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('admin.dashboard.finance.settlement.history.detail', ['id' => $stl->id, 'code' => $stl->nomor_settlement]) }}" title="Lihat detail settlement" class="btn btn-xs btn-primary"><i class="mdi mdi-eye"></i></a>
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
