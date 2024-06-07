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
                                <li class="breadcrumb-item"><a href="">Saldo</a></li>
                                <li class="breadcrumb-item active">Nobu Fee Transfer</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data History Nobu Fee Transfer</h4>
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
                            <h4 class="header-title mb-3">History Cashback Nobu Fee Transfer</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Invoice</th>
                                            <th>Tanggal Penarikan</th>
                                            <th>Nominal Penarikan</th>
                                            <th>Total Biaya Transfer</th>
                                            <th>Nobu Transfer Fee</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=0;
                                        @endphp
                                        @foreach ($nobuFeeHistory as $fee)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $fee->withdraw->invoice_pemarikan }}</td>
                                                <td>{{ \Carbon\Carbon::parse($fee->withdraw->tanggal_penarikan)->format('d-m-Y') }}</td>
                                                <td>{{ $fee->withdraw->nominal }}</td>
                                                <td>{{ $fee->withdraw->biaya_admin }}</td>
                                                <td>{{ $fee->nominal }}</td>
                                                <td>
                                                    <a href="" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
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
        <!-- container -->
    </div>
</x-admin-layout>