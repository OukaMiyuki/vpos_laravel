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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.menu') }}">Admin Menu</a></li>
                                <li class="breadcrumb-item active">User Withdrawals List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Withdraw Mitra Bisnis</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Withdraw Mitra Bisnis</h4>
                            <div class="row">
                                <div class="col-6">
                                    
                                </div>
                                <div class="col-6 text-end">
                                    <div id="daterange_user_mitra_bisnis_withdraw" class="float-end" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%; text-align:center">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> 
                                        <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <table id="selection-horizontal-datatable" class="table user-table-withdrawal-mitra-bisnis nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Action</th>
                                        <th>No. Invoice</th>
                                        <th>Nama</th>
                                        <th>User Email</th>
                                        <th class="text-center">Tanggal Penarikan</th>
                                        <th>Nominal (Rp.)</th>
                                        <th>Total Biaya Transfer (Rp.)</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php $no=0; @endphp
                                    @foreach($tenantWithdraw as $key => $wd)
                                        @foreach ($wd->withdrawal as $withdraw)
                                            <tr>
                                                <td>{{$no+=1}}</td>
                                                <td>
                                                    <a href="{{ route('admin.dashboard.menu.userWithdrawals.detail', ['id' => $withdraw->id]) }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
                                                </td>
                                                <td>{{$withdraw->invoice_pemarikan}}</td>
                                                <td>{{$wd->name}}</td>
                                                <td>{{$wd->email}}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($withdraw->tanggal_penarikan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($withdraw->created_at)->format('H:i:s')}}</td>
                                                <td>{{$withdraw->nominal}}</td>
                                                <td>{{$withdraw->biaya_admin}}</td>
                                                <td>
                                                    @if ($withdraw->status == 0)
                                                        <span class="badge bg-soft-danger text-danger">Penarikan Gagal</span>
                                                    @else
                                                        <span class="badge bg-soft-success text-success">Penarikan Sukses</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
