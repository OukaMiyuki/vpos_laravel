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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.mitraTenant') }}">Mitra Tenant</a></li>
                                <li class="breadcrumb-item active">Umi Request</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Umi Request Tenant</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar UMI Request Tenant</h4>
                            <div class="table-responsive">
                                <table id="basic-table" class="table dt-responsive w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Merchant Name</th>
                                            <th>Mitra Tenant</th>
                                            <th>Jenis Usaha</th>
                                            <th class="text-center">Status Pengajuan</th>
                                            <th>Qris Request Type</th>
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
                                            @foreach ($tt->storeDetailUMI as $umiReq)
                                                <td>{{$no+=1}}</td>
                                                <td>{{$umiReq->storeDetail->name}}</td>
                                                <td>{{$tt->name}}</td>
                                                <td>{{$umiReq->storeDetail->jenis_usaha}}</td>
                                                <td class="text-center">
                                                    @if ($umiReq->is_active == 0)
                                                        <span class="badge bg-soft-warning text-warning">Belum Disetujui</span>
                                                    @elseif($umiReq->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Disetujui</span>
                                                    @elseif($umiReq->is_active == 2)
                                                        <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td>{{$umiReq->request_type}}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($umiReq->tanggal_pengajuan)->format('d-m-Y')}}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($umiReq->tanggal_approval)->format('d-m-Y')}}</td>
                                                <td class="text-center">
                                                    <a title="Download dokumen request UMI" href="{{ route('admin.dashboard.menu.userUmiRequest.download', ['id' => $umiReq->id]) }}" class="btn btn-info btn-xs text-white">
                                                        <i class="dripicons-download"></i>
                                                    </a>
                                                </td>
                                                <td>{{$umiReq->note}}</td>
                                                <td class="text-center">
                                                    @if ($umiReq->is_active == 0)
                                                        <a href="" id="approval-umi" data-id="{{$umiReq->id}}" data-store_identifier="{{ $umiReq->store_identifier }}" data-bs-toggle="modal" data-bs-target="#approve-umi-modal" class="btn btn-xs btn-success"><i class="mdi mdi-check-bold"></i></a>
                                                        &nbsp;
                                                        <a href="" id="reject-umi" data-id="{{$umiReq->id}}" data-store_identifier="{{ $umiReq->store_identifier }}" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#reject-umi-modal"><i class="mdi mdi-close-thick"></i></a>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Approve Qris Request by Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('admin.dashboard.menu.userUmiRequest.approve') }}" method="post">
                    @csrf
                    <div class="modal-body" id="show">
                        <input type="hidden" readonly class="d-none @error('id') is-invalid @enderror" name="id" id="id" required value="{{ old('id') }}">
                        <input type="hidden" readonly class="d-none @error('store_identifier') is-invalid @enderror" name="store_identifier" id="store_identifier" required value="{{ old('store_identifier') }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="qris_login" class="form-label">Qris Login</label>
                                    <input type="text" class="form-control @error('qris_login') is-invalid @enderror" name="qris_login" id="qris_login" required value="{{ old('qris_login') }}" placeholder="Masukkan qris login">
                                    @error('qris_login')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="qris_password" class="form-label">Qris Password</label>
                                    <input type="text" class="form-control @error('qris_password') is-invalid @enderror" name="qris_password" id="qris_password" required value="{{ old('qris_password') }}" placeholder="Masukkan qris password">
                                    @error('qris_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="qris_merchant_id" class="form-label">Qris Merchant ID</label>
                                    <input type="text" class="form-control @error('qris_merchant_id') is-invalid @enderror" name="qris_merchant_id" id="qris_merchant_id" required value="{{ old('qris_merchant_id') }}" placeholder="Masukkan qris merchant id">
                                    @error('qris_merchant_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="qris_store_id" class="form-label">Qris Store ID</label>
                                    <input type="text" class="form-control @error('qris_store_id') is-invalid @enderror" name="qris_store_id" id="qris_store_id" required value="{{ old('qris_store_id') }}" placeholder="Masukkan qris store id">
                                    @error('qris_store_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="mdr" class="form-label">MDR (%)</label>
                                    <input type="text" class="form-control @error('mdr') is-invalid @enderror" name="mdr" id="mdr" required value="{{ old('mdr') }}" placeholder="Masukkan mdr">
                                    @error('mdr')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
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
