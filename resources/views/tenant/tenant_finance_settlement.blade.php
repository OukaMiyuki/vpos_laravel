<x-tenant-layout>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="">Finance</a></li>
                                <li class="breadcrumb-item active">Settlement</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data History Settlement</h4>
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
                            <h4 class="header-title mb-3">Tabel Data History Settlement</h4>
                            <div class="row">
                                <div class="col-6">

                                </div>
                                <div class="col-6 text-end">
                                    <div id="daterange_settlement_tenant" class="float-end" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%; text-align:center">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span>
                                        <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="basic-datatable" class="table tenant-settlement-list dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nomor Settlement</th>
                                            <th>Periode Settlement</th>
                                            <th>Nominal Settlement (Rp.)</th>
                                            <th class="text-center">Status</th>
                                            <th>Note</th>
                                            <th>Periode Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php $no=0; @endphp
                                        @foreach($SettlementHstory as $stl)
                                            <tr>
                                                <td>{{$no+=1}}</td>
                                                <td>{{$stl->settlement->nomor_settlement}}</td>
                                                <td>{{\Carbon\Carbon::parse($stl->settlement_time_stamp)->format('d-m-Y H:i:s')}}</td>
                                                <td>@currency($stl->nominal_settle)</td>
                                                <td class="text-center">
                                                    @if($stl->status == 0)
                                                        <span class="badge bg-soft-danger text-danger">Settlement Gagal</span>
                                                    @elseif($stl->status == 1)
                                                        <span class="badge bg-soft-success text-success">Settlement Sukses</span>
                                                    @endif
                                                </td>
                                                <td>{{$stl->note}}</td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </div>
</x-tenant-layout>
