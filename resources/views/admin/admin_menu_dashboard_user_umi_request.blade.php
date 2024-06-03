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
                                <li class="breadcrumb-item active">User UMI Request List</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Request UMI</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Request UMI</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>User Email</th>
                                            <th>Store Identifier</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Tanggal Approval</th>
                                            <th>Status</th>
                                            <th class="text-center">File Attachment</th>
                                            <th>Note</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($umiRequest as $key => $umi)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $umi->email }}</td>
                                                <td>{{ $umi->store_identifier }}</td>
                                                <td>{{ $umi->tanggal_pengajuan }}</td>
                                                <td>{{ $umi->tanggal_approval }}</td>
                                                <td>
                                                    @if ($umi->is_active == 0)
                                                        <span class="badge bg-soft-warning text-warning">Belum Disetujui</span>
                                                    @elseif($umi->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Disetujui</span>
                                                    @elseif($umi->is_active == 2)
                                                        <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a title="Download dokumen request UMI" href="{{ route('admin.dashboard.menu.userUmiRequest.download', ['id' => $umi->id]) }}" class="btn btn-info btn-xs font-16 text-white">
                                                        <i class="dripicons-download"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $umi->note }}</td>
                                                <td class="text-center">
                                                    @if ($umi->is_active == 0)
                                                        <a href="" class="btn btn-xs btn-success"><i class="mdi mdi-check-bold"></i></a>
                                                        <a href="" class="btn btn-xs btn-danger"><i class="mdi mdi-close-thick"></i></a>
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
            </div>
        </div>
    </div>
</x-admin-layout>