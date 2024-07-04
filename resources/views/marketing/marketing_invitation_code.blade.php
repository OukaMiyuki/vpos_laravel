<x-marketing-layout>

    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Code</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Dashboard Invitation Code</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/letter.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $code }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Kode</p>
                                        <a href="" class="btn btn-blue btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Tambah kode baru">
                                            <i class="mdi mdi-plus"></i>&nbsp;Tambah
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <div class="col-md-4 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/icons/retailer.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-8">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $tenantNumber }}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Tenant</p>
                                        <a href="{{ route('marketing.dashboard.tenant.list') }}" class="btn btn-blue btn-sm ms-2">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                    <!-- end widget-rounded-circle-->
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
                                            <th class="text-center">Tanggal Dibuat</th>
                                            <th class="text-center">Redeemed</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($invitationCode as $code)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $code->inv_code }}</td>
                                                <td>{{ $code->holder }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($code->created_at)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ $code->tenant->count() }}</td>
                                                <td class="text-center">
                                                    @if($code->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Non Aktif</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('marketing.dashboard.invitationcode.cashout.list', ['code' => $code->inv_code]) }}">
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
        </div>
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
                            <label for="inv_code" class="form-label">Kode</label>
                            <input class="form-control" type="text" id="inv_code" name="inv_code" required="" placeholder="Masukkan kode undangan">
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