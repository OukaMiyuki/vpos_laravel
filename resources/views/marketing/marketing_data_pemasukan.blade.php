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
                                <li class="breadcrumb-item active">Pemasukan Anda</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Pemasukan Mitra Aplikasi</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/cash-withdrawal.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h4 class="text-dark mt-1">Rp.<span data-plugin="counterup">{{ $pemasukanMitraHariIni }}</span></h4>
                                        <p class="text-muted mb-1 text-truncate">Pemasukan Hari Ini</p>
                                        <a href="{{ route('marketing.dashboard.pemasukan.today') }}" class="btn btn-blue btn-sm ms-2">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/financial-statement.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h4 class="text-dark mt-1">Rp.<span data-plugin="counterup">{{ $pemasukanMitraBulaniIni }}</span></h4>
                                        <p class="text-muted mb-1 text-truncate">Pemasukan Bulan Ini</p>
                                        <a href="{{ route('marketing.dashboard.pemasukan.month') }}" class="btn btn-blue btn-sm ms-2">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-5 col-xl-5">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/money.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h2 class="text-dark mt-1">Rp.<span data-plugin="counterup">{{ $totalWithdrawMitra }}</span></h2>
                                        <p class="text-muted mb-1 text-truncate">Total Pemasukan</p>
                                    </div>
                                </div>
                            </div>
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
                                    <a href="" class="dropdown-item">Cetak Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Tabel Daftar Pemasukan</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Invitation Code</th>
                                            <th>Holder</th>
                                            <th>Nama Tenant</th>
                                            <th>Nama Toko</th>
                                            <th>Insentif Mitra (Rp.)</th>
                                            <th>Tanggal Penarikan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=0;
                                        @endphp
                                        @foreach($pemasukanTotal->invitationCodeTenant as $inv)
                                            @foreach($inv->withdrawal as $withdrawal)
                                                <tr>
                                                    <td>{{ $no+=1 }}</td>
                                                    <td>{{ $inv->invitationCode->inv_code }}</td>
                                                    <td>{{ $inv->invitationCode->holder }}</td>
                                                    <td>{{ $inv->name }}</td>
                                                    <td>{{ $inv->storeDetail->store_name }}</td>
                                                    <td>{{ $withdrawal->detailWithdraw->nominal }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($withdrawal->tanggal_penarikan)->format('d-m-Y') }}</td>
                                                    <td>
                                                        @if ($withdrawal->status == 1)
                                                            <span class="badge bg-soft-success text-success">Sukses</span>
                                                        @endif
                                                    </td>
                                                </tr>
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