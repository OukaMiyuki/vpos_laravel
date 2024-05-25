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
                                <li class="breadcrumb-item active">Today</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Pemasukan Hari Ini</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Pemasukan Hari Ini</h4>
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
                                        @foreach($pemasukanTerbaru->invitationCodeTenant as $inv)
                                            @foreach($inv->withdrawal as $withdrawal)
                                                <tr>
                                                    <td>{{ $no+=1 }}</td>
                                                    <td>{{ $inv->invitationCode->inv_code }}</td>
                                                    <td>{{ $inv->invitationCode->holder }}</td>
                                                    <td>{{ $inv->name }}</td>
                                                    <td>{{ $inv->storeDetail->store_name }}</td>
                                                    <td>{{ $withdrawal->detailWithdraw->biaya_mitra }}</td>
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