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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.finance') }}">Finance</a></li>
                                <li class="breadcrumb-item active">History Penarikan</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data History Penarikan</h4>
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
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">@if(is_null($penarikanTerbaru) || empty($penarikanTerbaru)) 0 @else {{ $penarikanTerbaru->nominal }} @endif</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Penarikan Terbaru</p>
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
                                    <img src="{{ asset('assets/images/icons/all-money.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp. <span data-plugin="counterup">{{ $allDataSum }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Semua Penarikan</p>
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
                            <h4 class="header-title mb-3">Tabel Histori Penarikan</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Tanggal Penarikan</th>
                                            <th>Nominal</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Status</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allData as $data)
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->tanggal_penarikan }}</td>
                                            <td>{{ $data->nominal }}</td>
                                            <td>{{ $data->tanggal_masuk }}</td>
                                            <td>
                                                @if ($data->status == 0)
                                                    <span class="badge bg-soft-warning text-warning">Pending</span>
                                                @elseif($data->status == 1)
                                                    <span class="badge bg-soft-success text-success">Penarikan Sukses</span>
                                                @elseif($data->status == 2)
                                                    <span class="badge bg-soft-danger text-danger">Penarikan Gagal</span>
                                                @endif
                                            </td>
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
</x-tenant-layout>