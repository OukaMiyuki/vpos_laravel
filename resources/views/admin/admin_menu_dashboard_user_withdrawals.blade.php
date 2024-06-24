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
                        <h4 class="page-title">Data Withdraw User</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Withdraw User</h4>
                            <div class="row">
                                <div class="col-6">
                                    
                                </div>
                                <div class="col-6 text-end">
                                    <div id="daterange_user_withdraw" class="float-end" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%; text-align:center">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> 
                                        <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table user-table-withdrawal dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Action</th>
                                            <th>No. Invoice</th>
                                            <th>User Email</th>
                                            <th>Jenis Penarikan</th>
                                            <th class="text-center">Tanggal Penarikan</th>
                                            <th>Nominal (Rp.)</th>
                                            <th class="text-center">Total Biaya Transfer (Rp.)</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php $no=0; @endphp
                                        @foreach($withdrawals as $key => $wd)
                                            <tr>
                                                <td>{{$no+=1}}</td>
                                                <td>
                                                    <a href="{{ route('admin.dashboard.menu.userWithdrawals.detail', ['id' => $wd->id]) }}" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
                                                </td>
                                                <td>{{$wd->invoice_pemarikan}}</td>
                                                <td>{{$wd->email}}</td>
                                                <td>{{$wd->jenis_penarikan}}</td>
                                                <td class="text-center">
                                                    {{\Carbon\Carbon::parse($wd->tanggal_penarikan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($wd->created_at)->format('H:i:s')}}
                                                </td>
                                                <td>{{$wd->nominal}}</td>
                                                <td class="text-center">{{$wd->biaya_admin}}</td>
                                                <td class="text-center">
                                                    @if ($wd->status == 0)
                                                        <span class="badge bg-soft-danger text-danger">Penarikan Gagal</span>
                                                    @else
                                                        <span class="badge bg-soft-success text-success">Penarikan Sukses</span>
                                                    @endif
                                                </td>
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
    </div>
</x-admin-layout>
