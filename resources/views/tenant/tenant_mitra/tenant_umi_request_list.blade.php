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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko') }}">Umi</a></li>
                                <li class="breadcrumb-item active">Qris Account Request List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Request Akun Qris</h4>
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
                            <h4 class="header-title mb-3">Tabel Request List</h4>
                        
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Store ID</th>
                                            <th>Store Name</th>
                                            <th>Tanggal Request</th>
                                            <th>Tanggal Tanggal Approval</th>
                                            <th>Status</th>
                                            <th>Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($umiRequest as $umi)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $umi->store_identifier }}</td>
                                                <td>{{ $umi->storeList->name }}</td>
                                                <td>{{ $umi->tanggal_pengajuan }}</td>
                                                <td>{{ $umi->tanggal_approval }}</td>
                                                <td>
                                                    @if ($umi->is_active == 0)
                                                        <button type='button' class='btn btn-warning btn-xs waves-effect mb-2 waves-light'>Permintaan sedang diproses</button>
                                                    @elseif($umi->is_active == 1)
                                                        <button type='button' class='btn btn-success btn-xs waves-effect mb-2 waves-light'>Akun Qris Terdaftar</button>
                                                    @endif
                                                </td>
                                                <td>{{ $umi->note }}</td>
                                                <td>  
                                                    @if ($umi->is_active == 1)
                                                        <a href="{{ route('tenant.mitra.dashboard.toko.request.qris.account' , ['store_identifier' => $umi->store_identifier]) }}">
                                                            <button title="Lihat akun Qris" type="button" class="btn btn-success rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>
                                                        </a>
                                                    @endif 
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-tenant-layout>