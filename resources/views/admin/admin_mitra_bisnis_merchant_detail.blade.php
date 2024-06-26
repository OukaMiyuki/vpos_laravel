<x-tenant-layout>
    <div class="content">
        @php
            $umi = "";
            if($storeDetail->status_umi == NULL || $storeDetail->status_umi == "" || empty($storeDetail->status_umi) || is_null($storeDetail->status_umi)){
                $umi = "<button type='button' class='btn btn-info btn-xs waves-effect mb-2 waves-light'>UMI Belum Terdaftar</button>";
            } else {
                if($storeDetail->status_umi == 0) {
                    $umi = "<button type='button' class='btn btn-warning btn-xs waves-effect mb-2 waves-light'>UMI Belum Disetujui</button>";
                } else if($storeDetail->status_umi == 1){
                    $umi = "<button type='button' class='btn btn-success btn-xs waves-effect mb-2 waves-light'>Terdaftar UMI</button>";
                } else if($storeDetail->status_umi == 2){
                    $umi = "<button type='button' class='btn btn-danger btn-xs waves-effect mb-2 waves-light'>UMI Ditolak</button>";
                }
            }
        @endphp
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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.mitraBisnis.merchantList') }}">Merchant List</a></li>
                                <li class="breadcrumb-item active">Detail</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Detail Merchant</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="{{ !empty($storeDetail->photo) ? Storage::url('images/profile/store_list/'.$storeDetail->photo) : asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            <h4 class="mb-0">
                                {{ $storeDetail->name }}&nbsp;
                                @if ($storeDetail->is_active == 0)
                                    <span class="badge bg-soft-danger text-danger">Tidak Aktif</span>
                                @else
                                    <span class="badge bg-soft-success text-success">Aktif</span>
                                @endif
                            </h4>
                            <p class="text-muted">
                                Merchant
                            </p>
                            @php
                                echo htmlspecialchars_decode($umi);
                            @endphp
                        </div>
                    </div>
                </div>
                <!-- end col-->
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg" id="tab-profile">
                                <li class="nav-item">
                                    <a href="#settings" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Store Detail
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#aboutme" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        Request Umi
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    <form method="post" action="" enctype="multipart/form-data">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Detail Informasi Toko</h5>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Toko</label>
                                                    <input type="text" class="form-control" readonly name="name" id="name" required value="{{ $storeDetail->name }}" placeholder="Masukkan nama toko">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="no_telp" class="form-label">No. Telp. Toko</label>
                                                    <input type="text" class="form-control" readonly name="no_telp" id="no_telp" required value="{{ $storeDetail->no_telp_toko }}" placeholder="Masukkan nomor telepon toko">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="jenis" class="form-label">Jenis Usaha</label>
                                                    <input type="text" class="form-control" readonly name="jenis" id="jenis" required value="{{ $storeDetail->jenis_usaha }}" placeholder="Masukkan jenis usaha">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat Toko</label>
                                                    <textarea placeholder="Masukkan alamat anda" readonly class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! $storeDetail->alamat !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                                    <input type="text" class="form-control" name="kabupaten" id="kabupaten" readonlyrequired value="{{ $storeDetail->kabupaten }}" placeholder="Masukkan kabupaten atau kota">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="kode_pos" class="form-label">Kode Pos Toko</label>
                                                    <input type="text" class="form-control" name="kode_pos" id="kode_pos" readonly required value="{{ $storeDetail->kode_pos }}" placeholder="Masukkan kode pos">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="aboutme">
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Pengajuan UMI</h5>
                                    @if ($umiRequest == "Empty")
                                        <p class="sub-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <form method="post" action="{{ route('tenant.mitra.dashboard.toko.request.umi') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" readonly class="d-none" name="id" id="id" value="{{ $storeDetail->id }}">
                                            <input type="hidden" readonly class="d-none" name="store_identifier" id="store_identifier" value="{{ $storeDetail->store_identifier }}">
                                            <div class="row">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Ajukan Umi</button>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        @php
                                            $tenantQris = App\Models\TenantQrisAccount::where('store_identifier', $storeDetail->store_identifier)->first();
                                        @endphp
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Tanggal Approval</th>
                                                        <th class="text-center">Status</th>
                                                        <th>Note</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>{{ $umiRequest->tanggal_pengajuan }}</td>
                                                        <td>{{ $umiRequest->tanggal_approval }}</td>
                                                        <td class="text-center">
                                                            @if($umiRequest->is_active == 0)
                                                                <span class="badge bg-soft-warning text-warning">Pending</span>
                                                            @elseif($umiRequest->is_active == 1)
                                                                <span class="badge bg-soft-success text-success">Disetujui</span>
                                                            @elseif($umiRequest->is_active == 2)
                                                                <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $umiRequest->note }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @if($umiRequest->is_active == 1)
                                            @if (!empty($tenantQris) || !is_null($tenantQris))
                                                <h5 class="mb-4 text-uppercase mt-3"><i class="mdi mdi-account-circle me-1"></i> Detail Informasi Akun Qris</h5>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Qris Login User</label>
                                                            <input type="text" class="form-control" readonly name="login-user" id="login-user" required value="{{ $tenantQris->qris_login_user }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="no_telp" class="form-label">Qris Password</label>
                                                            <input type="text" class="form-control" readonly name="qpassword" id="qpassword" required value="{{ $tenantQris->qris_password }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="jenis" class="form-label">Qris Merchant ID</label>
                                                            <input type="text" class="form-control" readonly name="mcrid" id="mcrid" required value="{{ $tenantQris->qris_merchant_id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="jenis" class="form-label">Qris Store ID</label>
                                                            <input type="text" class="form-control" readonly name="storeid" id="storeid" required value="{{ $tenantQris->qris_store_id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="kabupaten" class="form-label">MDR (%)</label>
                                                            <input readonly type="text" class="form-control" name="mdr" id="mdr" readonlyrequired value="{{ $tenantQris->mdr }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <!-- end tab-content -->
                        </div>
                    </div>
                    <!-- end card-->
                </div>
                <!-- end col -->
            </div>
            <!-- end row-->
        </div>
        <!-- container -->
    </div>
</x-tenant-layout>
