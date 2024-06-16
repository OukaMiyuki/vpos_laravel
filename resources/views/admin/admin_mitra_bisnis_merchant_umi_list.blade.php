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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.mitraBisnis') }}">Mitra Bisnis</a></li>
                                <li class="breadcrumb-item active">Umi Request</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Umi Request Merchant</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar UMI Request Merchant</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Merchant Name</th>
                                            <th>Store Identifier</th>
                                            <th>Mitra Bisnis</th>
                                            <th>Jenis Usaha</th>
                                            <th class="text-center">Status UMI</th>
                                            <th class="text-center">Status Request UMI</th>
                                            <th class="text-center">Tanggal Pengajuan</th>
                                            <th class="text-center">Tanggal Approval</th>
                                            <th class="text-center">FIle Attachment</th>
                                            <th class="text-center">Note</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach ($umi as $tt)
                                            @foreach ($tt->storeListUMI as $umiReq)
                                                <td>{{$no+=1}}</td>
                                                <td>{{$umiReq->storeList->name}}</td>
                                                <td>{{$umiReq->storeList->store_identifier}}</td>
                                                <td>{{$tt->name}}</td>
                                                <td>{{$umiReq->storeList->jenis_usaha}}</td>
                                                <td class="text-center">
                                                    @if ($umiReq->storeList->status_umi == 0)
                                                        <span class="badge bg-soft-warning text-warning">Tidak Terdaftar</span>
                                                    @elseif($umiReq->storeList->status_umi == 1)
                                                        <span class="badge bg-soft-success text-success">Terdaftar</span>
                                                    @elseif($umiReq->storeList->status_umi == 2)
                                                        <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($umiReq->is_active == 0)
                                                        <span class="badge bg-soft-warning text-warning">Tidak Terdaftar</span>
                                                    @elseif($umiReq->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Terdaftar</span>
                                                    @elseif($umiReq->is_active == 2)
                                                        <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($umiReq->tanggal_pengajuan)->format('d-m-Y')}}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($umiReq->tanggal_approval)->format('d-m-Y')}}</td>
                                                <td class="text-center">
                                                    <a title="Download dokumen request UMI" href="{{ route('admin.dashboard.menu.userUmiRequest.download', ['id' => $umiReq->id]) }}" class="btn btn-info btn-xs font-16 text-white">
                                                        <i class="dripicons-download"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $umiReq->note }}</td>
                                                <td class="text-center">
                                                    @if ($umiReq->is_active == 0)
                                                        <a href="" id="approval-umi" data-id="{{ $umiReq->id }}" data-store_identifier="{{ $umiReq->store_identifier }}" data-bs-toggle="modal" data-bs-target="#approve-umi-modal" class="btn btn-success"><i class="mdi mdi-check-bold"></i></a>
                                                        &nbsp;
                                                        <a href="" id="reject-umi" data-id="{{ $umiReq->id }}" data-store_identifier="{{ $umiReq->store_identifier }}" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject-umi-modal"><i class="mdi mdi-close-thick"></i></a>
                                                    @endif
                                                </td>
                                            @endforeach
                                        @endforeach
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
