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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.marketing') }}">Mitra Aplikasi</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.menu') }}">Admin Menu</a></li>
                                <li class="breadcrumb-item active">Withdrawals</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Withdraw Mitra Aplikasi</h4>
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
                            <h4 class="header-title mb-3">Tabel Withdraw Mitra Aplikasi</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Action</th>
                                            <th>No. Invoice</th>
                                            <th>Nama</th>
                                            <th>User Email</th>
                                            <th class="text-center">Tanggal Penarikan</th>
                                            <th class="text-center">Nominal (Rp.)</th>
                                            <th class="text-center">Nominal Bersih Penarikan (Rp.)</th>
                                            <th>Total Biaya Transfer (Rp.)</th>
                                            <th>Transfer Bank (Rp.)</th>
                                            <th>Mitra Aplikasi (Rp.)</th>
                                            <th>Insentif Admin (Rp.)</th>
                                            <th>Insentif Agregate (Rp.)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($marketingWD as $key => $wd)
                                            @foreach ($wd->withdraw as $withdraw)
                                                <tr>
                                                    <td>{{$no+=1}}</td>
                                                    <td>
                                                        <a href="{{ route('admin.dashboard.menu.userWithdrawals.detail', ['id' => $withdraw->id]) }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
                                                    </td>
                                                    <td>{{$withdraw->invoice_pemarikan}}</td>
                                                    <td>{{$wd->name}}</td>
                                                    <td>{{$wd->email}}</td>
                                                    <td class="text-center">{{\Carbon\Carbon::parse($withdraw->tanggal_penarikan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($withdraw->created_at)->format('H:i:s')}}</td>
                                                    <td class="text-center">{{$withdraw->nominal+$withdraw->biaya_admin }}</td>
                                                    <td class="text-center">{{$withdraw->detailWithdraw->nominal_bersih_penarikan }}</td>
                                                    <td>{{$withdraw->biaya_admin}}</td>
                                                    <td>{{$withdraw->detailWithdraw->biaya_nobu}}</td>
                                                    <td>{{$withdraw->detailWithdraw->biaya_mitra}}</td>
                                                    <td>{{$withdraw->detailWithdraw->biaya_admin_su}}</td>
                                                    <td>{{$withdraw->detailWithdraw->biaya_agregate}}</td>
                                                    <td>
                                                        @if ($withdraw->status == 0)
                                                            <span class="badge bg-soft-danger text-danger">Penarikan Gagal</span>
                                                        @else
                                                            <span class="badge bg-soft-success text-success">Penarikan Sukses</span>
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
</x-admin-layout>
