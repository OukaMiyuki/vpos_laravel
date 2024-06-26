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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.history') }}">History</a></li>
                                <li class="breadcrumb-item active">User Withdraw History</li>
                            </ol>
                        </div>
                        <h4 class="page-title">User Withdraw History</h4>
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
                                    <div id="daterange_user_withdraw_history" class="float-end" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%; text-align:center">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> 
                                        <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table user-table-withdraw-history-list w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Email</th>
                                            <th>Activity</th>
                                            <th>Lokasi</th>
                                            <th>IP Address</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php $no=0; @endphp
                                        @foreach ($history as $hs)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $hs->email }}</td>
                                                <td>{{ $hs->action }}</td>
                                                <td>{{ $hs->lokasi_anda }}</td>
                                                <td>{{ $hs->deteksi_ip }}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($hs->created_at)->format('d-m-Y H:i:s') }}</td>
                                                <td class="text-center">
                                                    @if ($hs->status == 0)
                                                        <span class="badge bg-soft-warning text-warning">Failed</span>
                                                    @elseif($hs->status == 1)
                                                        <span class="badge bg-soft-success text-success">Sukses</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.dashboard.history.user.detail', ['activity' => "Withdraw", 'id' => $hs->id]) }}" class="btn btn-xs btn-success"><i class="mdi mdi-eye"></i></a>
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
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-admin-layout>
