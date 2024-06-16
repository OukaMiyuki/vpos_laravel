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
                                            <th class="text-center">Tanggal Pengajuan</th>
                                            <th class="text-center">Tanggal Approval</th>
                                            <th class="text-center">Status</th>
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
                                                <td class="text-center">
                                                    {{\Carbon\Carbon::parse($umi->tanggal_pengajuan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($umi->created_at)->format('H:i:s')}}
                                                </td>
                                                <td class="text-center">
                                                    @if (!is_null($umi->tanggal_approval) || !empty($umi->tanggal_approval))
                                                        {{\Carbon\Carbon::parse($umi->tanggal_approval)->format('d-m-Y')}} {{\Carbon\Carbon::parse($umi->updated_at)->format('H:i:s')}}
                                                    @endif
                                                </td>
                                                <td class="text-center">
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
                                                        <a href="" id="approval-umi" data-id="{{ $umi->id }}" data-store_identifier="{{ $umi->store_identifier }}" data-bs-toggle="modal" data-bs-target="#approve-umi-modal" class="btn btn-xs btn-success"><i class="mdi mdi-check-bold"></i></a>
                                                        <a href="" id="reject-umi" data-id="{{ $umi->id }}" data-store_identifier="{{ $umi->store_identifier }}" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#reject-umi-modal"><i class="mdi mdi-close-thick"></i></a>
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
    <div class="modal fade" id="approve-umi-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Apprve UMI Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('admin.dashboard.menu.userUmiRequest.approve') }}" method="post">
                    @csrf
                    <div class="modal-body" id="show">
                        <input type="hidden" readonly class="d-none @error('id') is-invalid @enderror" name="id" id="id" required value="{{ old('id') }}">
                        <input type="hidden" readonly class="d-none @error('store_identifier') is-invalid @enderror" name="store_identifier" id="store_identifier" required value="{{ old('store_identifier') }}">
                        <div class="row">
                            <div class="mb-3">
                                <label for="note" class="form-label">Note (Opsional)</label>
                                <textarea placeholder="Masukkan note approval" class="form-control" id="note" name="note" rows="5" spellcheck="false">{!! old('note') !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reject-umi-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Reject UMI Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('admin.dashboard.menu.userUmiRequest.reject') }}" method="post">
                    @csrf
                    <div class="modal-body" id="reject">
                        <input type="hidden" readonly class="d-none @error('id') is-invalid @enderror" name="id" id="id" required value="{{ old('id') }}">
                        <input type="hidden" readonly class="d-none @error('store_identifier') is-invalid @enderror" name="store_identifier" id="store_identifier" required value="{{ old('store_identifier') }}">
                        <div class="row">
                            <div class="mb-3">
                                <label for="note" class="form-label">Note (Opsional)</label>
                                <textarea placeholder="Masukkan note approval" class="form-control" id="note" name="note" rows="5" spellcheck="false">{!! old('note') !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
