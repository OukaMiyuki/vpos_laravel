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
                                <li class="breadcrumb-item active">Tenant Qris</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Tenant Qris Accounts</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Tenant Qris&nbsp;&nbsp;&nbsp;<button data-bs-toggle="modal" data-bs-target="#add-qris" title="Tambah akun baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan Akun Qris</button></h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Mitra Bisnis</th>
                                            <th>Email</th>
                                            <th>Store Identifier</th>
                                            <th>Merchant Name</th>
                                            <th>Qris Login</th>
                                            <th>Qris Password</th>
                                            <th>Qris Merchant ID</th>
                                            <th>Qris Store ID</th>
                                            <th class="text-center">MDR</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($qris as $key => $tqris)
                                            @foreach ($tqris->tenantQrisAccountStoreDetail as $qrisacc)
                                                <tr>
                                                    <td>{{ $no+=1 }}</td>
                                                    <td>{{ $tqris->name }}</td>
                                                    <td>{{ $tqris->email }}</td>
                                                    <td>{{ $qrisacc->storeDetail->store_identifier }}</td>
                                                    <td>{{ $qrisacc->storeDetail->name }}</td>
                                                    <td>{{ $qrisacc->qris_login_user }}</td>
                                                    <td>{{ $qrisacc->qris_password }}</td>
                                                    <td>{{ $qrisacc->qris_merchant_id }}</td>
                                                    <td>{{ $qrisacc->qris_store_id }}</td>
                                                    <td class="text-center">{{$qrisacc->mdr}}</td>
                                                    <td class="text-center">
                                                        <a href="" id="edit-data-qris" data-id="{{ $qrisacc->id }}" data-store_identifier="{{ $qrisacc->store_identifier }}" data-qris_login="{{ $qrisacc->qris_login_user }}" data-qris_password="{{ $qrisacc->qris_password }}" data-qris_merchant_id="{{ $qrisacc->qris_merchant_id }}" data-qris_store_id="{{ $qrisacc->qris_store_id }}" data-mdr="{{ $qrisacc->mdr }}" data-bs-toggle="modal" data-bs-target="#edit-qris" class="btn btn-xs btn-info"><i class="mdi mdi-pencil"></i></a>
                                                        &nbsp;
                                                        <a href="{{ route('admin.dashboard.menu.userTenantQris.delete', ['id' => $qrisacc->id]) }}" class="btn btn-xs btn-danger"><i class="mdi mdi-trash-can-outline"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
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
    <div class="modal fade" id="add-qris" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Akun Qris Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('admin.dashboard.menu.userTenantQris.register') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="store_identifier" class="form-label">Store Identifier</label>
                                    <input type="text" class="form-control @error('store_identifier') is-invalid @enderror" name="store_identifier" id="store_identifier" required value="{{ old('store_identifier') }}" placeholder="Masukkan store identifier">
                                    @error('store_identifier')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="mdr" class="form-label">MDR (%)</label>
                                    <input type="text" class="form-control @error('mdr') is-invalid @enderror" name="mdr" id="mdr" required value="{{ old('mdr') }}" placeholder="Masukkan mdr">
                                    @error('mdr')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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
    <div class="modal fade" id="edit-qris" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Akun Qris Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('admin.dashboard.menu.userTenantQris.update') }}" method="post">
                    @csrf
                    <div class="modal-body" id="show">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="store_identifier" class="form-label">Store Identifier</label>
                                    <input type="hidden" class="d-none @error('id') is-invalid @enderror" readonly name="id" id="id" required value="{{ old('id') }}">
                                    <input type="text" class="form-control @error('store_identifier') is-invalid @enderror" readonly name="store_identifier" id="store_identifier" required value="{{ old('store_identifier') }}" placeholder="Masukkan store identifier">
                                    @error('store_identifier')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="mdr" class="form-label">MDR (%)</label>
                                    <input type="text" class="form-control @error('mdr') is-invalid @enderror" name="mdr" id="mdr" required value="{{ old('mdr') }}" placeholder="Masukkan mdr">
                                    @error('mdr')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>