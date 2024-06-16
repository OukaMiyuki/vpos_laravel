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
                                <li class="breadcrumb-item active">Bank Fee Transfer</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data History Bank Fee Transfer</h4>
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
                            <h4 class="header-title mb-3">History Cashback Bank Fee Transfer</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Invoice</th>
                                            <th class="text-center">Tanggal Penarikan</th>
                                            <th class="text-center">Nominal Penarikan (Rp.)</th>
                                            <th class="text-center">Total Biaya Transfer (Rp.)</th>
                                            <th class="text-center">Bank Transfer Fee (Rp.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=0;
                                        @endphp
                                        @foreach ($nobuFeeHistory as $fee)
                                            <tr>
                                                <td>{{$no+=1}}</td>
                                                <td>{{$fee->withdraw->invoice_pemarikan}}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($fee->withdraw->tanggal_penarikan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($fee->withdraw->created_at)->format('H:i:s')}}</td>
                                                <td class="text-center">{{$fee->withdraw->nominal}}</td>
                                                <td class="text-center">{{$fee->withdraw->biaya_admin}}</td>
                                                <td class="text-center">{{$fee->nominal}}</td>
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
        <!-- container -->
    </div>
</x-admin-layout>
