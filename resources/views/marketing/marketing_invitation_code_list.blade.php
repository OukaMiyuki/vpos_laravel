<x-marketing-layout>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex align-items-center mb-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control border-0" id="dash-daterange">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                    <i class="mdi mdi-calendar-range"></i>
                                    </span>
                                </div>
                                <a href="#" class="btn btn-blue btn-sm ms-2">
                                <i class="mdi mdi-autorenew"></i>
                                </a>
                                <a href="#" class="btn btn-blue btn-sm ms-1">
                                <i class="mdi mdi-filter-variant"></i>
                                </a>
                            </form>
                        </div>
                        <h4 class="page-title">Data Invitation Code</h4>
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
                            <h4 class="header-title mb-3">Tabel Invitation List&nbsp;&nbsp;&nbsp;<button data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Tambah kode baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Buat Kode Baru</button></h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Invitation Code</th>
                                            <th>Holder</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Redeemed</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($invitationCode as $code)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $code->inv_code }}</td>
                                                <td>{{ $code->holder }}</td>
                                                <td>{{ $code->created_at }}</td>
                                                <td>{{ $code->attempt }}</td>
                                                <td>
                                                    @if($code->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Non Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('marketing.dashboard.invitationcode.cashout.list') }}">
                                                        <button title="Lihat data penarikan" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
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
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Kode Undangan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('marketing.dashboard.invitationcode.insert') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode</label>
                            <input class="form-control" type="text" id="code" name="code" required="" placeholder="Masukkan kode undangan">
                            <small id="emailHelp" class="form-text text-muted">Kode maksimal 5 karakter, terdiri dari huruf & angka | Contoh : DENY5</small>
                        </div>
                        <div class="mb-3">
                            <label for="holder" class="form-label">Holder Name</label>
                            <input class="form-control" type="text" id="holder" name="holder" required="" placeholder="Masukkan holder name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Buat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-marketing-layout>