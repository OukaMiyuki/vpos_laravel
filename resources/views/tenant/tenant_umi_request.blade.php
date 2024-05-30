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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                <li class="breadcrumb-item active">Pengajuan UMI</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Request Umi</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <!-- end col-->
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @if (empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == "")
                                    <div class="message">
                                        <h1 class="acces-denied">Access to this page is restricted</h1>
                                        <p class="sub-header text-danger"><strong>Lakukan verifikasi nomor Whatsapp sebelum mengupdate data toko anda.</strong></p>
                                    </div>
                                @else
                                    @if ($umiRequest == "Empty")
                                        <form method="post" action="{{ route('tenant.request.umi.send') }}">
                                            @csrf
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Formulir Pendaftaran Umi</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="nama_pemilik" class="form-label">Nama Pemilik Usaha</label>
                                                        <input type="hidden" class="d-none" name="store_identifier" required value="{{ auth()->user()->storeDetail->store_identifier }}" readonly>
                                                        <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" required value="{{ auth()->user()->name }}" placeholder="Masukkan nama pemilik usaha" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="no_ktp" class="form-label">Nomor KTP</label>
                                                        <input type="text" class="form-control" name="no_ktp" id="no_ktp" required value="{{ auth()->user()->detail->no_ktp }}" placeholder="Masukkan nomor KTP" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="no_hp" class="form-label">Nomor Handphone</label>
                                                        <input type="text" class="form-control" name="no_hp" id="no_hp" required value="{{ auth()->user()->phone }}" placeholder="Masukkan nomor Handphone" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email" id="email" required value="{{ auth()->user()->email }}" placeholder="Masukkan alamat email" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="nama_usaha" class="form-label">Nama Usaha</label>
                                                        <input type="text" class="form-control" name="nama_usaha" id="nama_usaha" required value="{{ auth()->user()->storeDetail->name }}" placeholder="Masukkan nama usaha" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="jenis_usaha" class="form-label">Jenis Usaha</label>
                                                        <input type="text" class="form-control" name="jenis_usaha" id="jenis_usaha" required value="{{ auth()->user()->storeDetail->jenis_usaha }}" placeholder="Masukkan jenis usaha" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="alamat" class="form-label">Alamat Usaha</label>
                                                        <textarea readonly placeholder="Masukkan alamat usaha" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! auth()->user()->storeDetail->alamat !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="kab_kota" class="form-label">Kabupaten/Kota</label>
                                                        <input type="text" class="form-control" name="kab_kota" id="kab_kota" required value="{{ auth()->user()->storeDetail->kabupaten }}" placeholder="Masukkan kabupaten atau kota" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="kode_pos" class="form-label">Kode Pos</label>
                                                        <input type="text" class="form-control" name="kode_pos" id="kode_pos" required value="{{ auth()->user()->storeDetail->kode_pos }}" placeholder="Masukkan kode pos" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Ajukan Umi</button>
                                            </div>
                                        </form>
                                    @else
                                        @php
                                            $tenantQris = App\Models\TenantQrisAccount::where('store_identifier', auth()->user()->storeDetail->store_identifier)
                                                                                        ->where('id_tenant', auth()->user()->id)
                                                                                        ->where('email', auth()->user()->email)
                                                                                        ->first();
                                        @endphp
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Tanggal Approval</th>
                                                        <th>Status</th>
                                                        <th>Note</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>{{ $umiRequest->tanggal_pengajuan }}</td>
                                                        <td>{{ $umiRequest->tanggal_approval }}</td>
                                                        <td>
                                                            @if($umiRequest->is_active == 0)
                                                                <span class="badge bg-soft-warning text-warning">Pending</span>
                                                            @elseif($umiRequest->is_active == 1)
                                                                <span class="badge bg-soft-success text-success">Disetujui</span>
                                                            @elseif($umiRequest->is_active == 2)
                                                                <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $umiRequest->note }}</td>
                                                        <td>
                                                            @if ($umiRequest->is_active == 2)
                                                                <form method="post" action="{{ route('tenant.request.umi.resend') }}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" readonly class="d-none" name="id" id="id" value="{{ auth()->user()->storeDetail->id }}">
                                                                    <input type="hidden" readonly class="d-none" name="store_identifier" id="store_identifier" value="{{ auth()->user()->storeDetail->store_identifier }}">
                                                                    <div class="row">
                                                                        <div class="text-center">
                                                                            <button title="Ajukan Umi Ulang" type="submit" class="btn btn-info rounded-pill waves-effect waves-light">Ajukan Ulang</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        </td>
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>