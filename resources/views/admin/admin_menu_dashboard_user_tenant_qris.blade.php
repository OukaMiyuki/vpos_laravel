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
                                <li class="breadcrumb-item active">Tenant Qris Account</li>
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
                            <h4 class="header-title mb-3">Tabel Daftar Tenant Qris</h4>
                            <div class="table-responsive">
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Store Identifier</th>
                                            <th>Email</th>
                                            <th>Qris Login</th>
                                            <th>Qris Password</th>
                                            <th>Qris Merchant ID</th>
                                            <th>Qris Store ID</th>
                                            <th>MDR</th>
                                            <th>Aktifkan UMI<th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($tenantQris as $key => $qris)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $qris->store_identifier }}</td>
                                                <td>{{ $qris->email }}</td>
                                                <td>{{ $qris->qris_login_user }}</td>
                                                <td>{{ $qris->qris_password }}</td>
                                                <td>{{ $qris->qris_merchant_id }}</td>
                                                <td>{{ $qris->qris_store_id }}</td>
                                                <td>{{ $qris->mdr }}</td>
                                                <td>
                                                    @if($qris->mdr == 0)
                                                        <a href="{{ route('admin.dashboard.menu.userUmiRequest.approved', ['store_identifier' => $qris->store_identifier]) }}" class="btn btn-xs btn-success"><i class="mdi mdi-check-all"></i></a>
                                                    @endif
                                                <td>
                                                <td class="text-center">
                                                    <a href="" id="edit-data-qris" data-id="{{ $qris->id }}" data-store_identifier="{{ $qris->store_identifier }}" data-qris_login="{{ $qris->qris_login_user }}" data-qris_password="{{ $qris->qris_password }}" data-qris_merchant_id="{{ $qris->qris_merchant_id }}" data-qris_store_id="{{ $qris->qris_store_id }}" data-mdr="{{ $qris->mdr }}" data-bs-toggle="modal" data-bs-target="#edit-qris" class="btn btn-xs btn-info"><i class="mdi mdi-pencil"></i></a>
                                                    <a href="{{ route('admin.dashboard.menu.userTenantQris.delete', ['id' => $qris->id]) }}" class="btn btn-xs btn-danger"><i class="mdi mdi-trash-can-outline"></i></a>
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