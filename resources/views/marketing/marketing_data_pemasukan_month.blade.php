<x-marketing-layout>

    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard.invitationcode') }}">Code</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard.pemasukan') }}">Pemasukan Anda</a></li>
                                <li class="breadcrumb-item active">This Month</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Pemasukan Bulan Ini</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Pemasukan Bulan Ini</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-center">Invitation Code</th>
                                            <th>Holder</th>
                                            <th>Nama Tenant</th>
                                            <th>Nama Toko</th>
                                            <th class="text-center">Insentif Mitra (Rp.)</th>
                                            <th class="text-center">Tanggal Insentif</th>
                                            <th class="text-center">Bulan</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=0;
                                        @endphp
                                        @foreach($pemasukanTerbaru->invitationCodeTenant as $inv)
                                            @foreach($inv->withdrawal as $withdrawal)
                                                @foreach ($withdrawal->detailWithdraw as $dtwd)
                                                    <tr>
                                                        <td>{{ $no+=1 }}</td>
                                                        <td class="text-center">{{ $inv->invitationCode->inv_code }}</td>
                                                        <td>{{ $inv->invitationCode->holder }}</td>
                                                        <td>{{ $inv->name }}</td>
                                                        <td>{{ $inv->storeDetail->store_name }}</td>
                                                        <td class="text-center">@currency($dtwd->nominal)</td>
                                                        <td class="text-center">{{\Carbon\Carbon::parse($withdrawal->tanggal_penarikan)->format('d-m-Y')}}</td>
                                                        <td class="text-center">{{\Carbon\Carbon::parse($withdrawal->tanggal_penarikan)->format('F')}}</td>
                                                        <td class="text-center">
                                                            @if ($withdrawal->status == 1)
                                                                <span class="badge bg-soft-success text-success">Sukses</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
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
</x-marketing-layout>