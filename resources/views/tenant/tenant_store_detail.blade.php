<x-tenant-layout>
    <div class="content">
        @php
            $umi = "";
            if($tenantStore->status_umi == NULL || $tenantStore->status_umi == "" || empty($tenantStore->status_umi) || is_null($tenantStore->status_umi)){
                $umi = "<span class='badge bg-info'>UMI Belum Terdaftar</span>";
            } else {
                if($tenantStore->status_umi == 0) {
                    $umi = "<span class='badge bg-warning'>UMI Sedang diproses</span>";
                } else if($tenantStore->status_umi == 1){
                    $umi = "<span class='badge bg-success'>Terdaftar UMI</span>";
                } else if($tenantStore->status_umi == 2){
                    $umi = "<span class='badge bg-succes'>Pendaftaran UMI di Tolak</span>";
                }
            }
            $qris = "";
            if($tenantStore->status_registrasi_qris == 0){
                $qris = "<button type='button' class='btn btn-info btn-xs waves-effect mb-2 waves-light'>Toko Anda Belum Memiliki Akun Qris Sendiri</button>";
            } else if($tenantStore->status_registrasi_qris == 1){
                $qris = "<button type='button' class='btn btn-success btn-xs waves-effect mb-2 waves-light'>Terdaftar Akun Qris</button>";
            } else {
                $qris = "<button type='button' class='btn btn-warning btn-xs waves-effect mb-2 waves-light'>Akun Qris Dalam Proses Pengajuan</button>";
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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.settings') }}">Settings</a></li>
                                <li class="breadcrumb-item active">Store Settings</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Profile this {{$tenantStore->status_umi}}</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card text-center">
                                <div class="card-body">
                                    <img src="{{ !empty($tenantStore->photo) ? Storage::url('images/profile/'.$tenantStore->photo) : asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                    <h4 class="mb-0">
                                        {{ $tenantStore->name }}
                                    </h4>
                                    <p class="text-muted">
                                        Toko
                                    </p>
                                    @php
                                        echo htmlspecialchars_decode($qris);
                                    @endphp
                                    <br>
                                    @php
                                        echo htmlspecialchars_decode($umi);
                                    @endphp
                                    <br>
                                </div>
                            </div>
                        </div>
                        {{-- @if (!is_null($tenantStore->ktp_image) || !empty($tenantStore->ktp_image) || $tenantStore->ktp_image != NULL || $tenantStore->ktp_image != "")
                            <div class="col-md-12">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <img src="{{ !empty($tenantStore->ktp_image) ? Storage::url('images/profile/'.$tenantStore->ktp_image) : asset('assets/images/blank_profile.png') }}" class="img-thumbnail" width="300" alt="profile-image">
                                    </div>
                                </div>
                            </div>
                        @endif --}}
                    </div>
                </div>
                <!-- end col-->
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg">
                                <li class="nav-item">
                                    <a href="#settings" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Informasi Toko
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#qris_detail" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                        Informasi Akun Qris Anda
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    @if (empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == "")
                                        <div class="message">
                                            <h1 class="acces-denied">Access to this page is restricted</h1>
                                            <p class="sub-header text-danger"><strong>Lakukan verifikasi nomor Whatsapp sebelum mengupdate data toko anda.</strong></p>
                                        </div>
                                    @else
                                        <form method="post" action="{{ route('tenant.store.profile.update') }}" enctype="multipart/form-data">
                                            @csrf
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Update Informasi Toko</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Nama Toko</label>
                                                        <input type="text" class="form-control" name="name" id="name" required value="{{ $tenantStore->name }}" placeholder="Masukkan nama toko">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="no_telp" class="form-label">No. Telp. Toko</label>
                                                        <input type="text" class="form-control" name="no_telp" id="no_telp" required value="{{ $tenantStore->no_telp_toko }}" placeholder="Masukkan nomor telepon toko">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="jenis" class="form-label">Jenis Usaha</label>
                                                        <select required class="form-control" name="jenis" id="jenis" data-toggle="select2" data-width="100%">
                                                            <option value="">- Pilih Jenis Usaha -</option>
                                                            @foreach (App\Models\JenisUsaha::get() as $jenis_usaha)
                                                                <option value="{{ $jenis_usaha->jenis_usaha }}"@if ($tenantStore->jenis_usaha == $jenis_usaha->jenis_usaha) selected="selected" @endif>{{ $jenis_usaha->jenis_usaha  }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                                                        <textarea placeholder="Masukkan alamat anda" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! $tenantStore->alamat !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nama_jalan" class="form-label">Nama Jalan</label>
                                                        <input type="text" class="form-control" name="nama_jalan" id="nama_jalan" required value="{{ $tenantStore->nama_jalan }}" placeholder="Masukkan nama jalan">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nama_blok" class="form-label">Nama Blok / Tempat Usaha (Opsional)</label>
                                                        <input type="text" class="form-control" name="nama_blok" id="nama_blok" required value="{{ $tenantStore->nama_blok }}" placeholder="Masukkan nama blok">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="rt" class="form-label">RT.</label>
                                                        <input type="text" class="form-control" name="rt" id="rt" required value="{{ $tenantStore->rt }}" placeholder="Masukkan nomor RT">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="rw" class="form-label">RW.</label>
                                                        <input type="text" class="form-control" name="rw" id="rw" required value="{{ $tenantStore->rw }}" placeholder="Masukkan nomor RW">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="kelurahan_desa" class="form-label">Kelurahan/Desa</label>
                                                        <input type="text" class="form-control" name="kelurahan_desa" id="kelurahan_desa" required value="{{ $tenantStore->kelurahan_desa }}" placeholder="Masukkan nama kelurahan atau desa">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="kecamatan" class="form-label">Kecamatan</label>
                                                        <input type="text" class="form-control" name="kecamatan" id="kecamatan" required value="{{ $tenantStore->kecamatan }}" placeholder="Masukkan nama kecamatan">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                                        <input type="text" class="form-control" name="kabupaten" id="kabupaten" required value="{{ $tenantStore->kabupaten }}" placeholder="Masukkan nama kabupaten atau kota">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="kode_pos" class="form-label">Kode Pos Toko</label>
                                                        <input type="text" class="form-control" name="kode_pos" id="kode_pos" required value="{{ $tenantStore->kode_pos }}" placeholder="Masukkan kode pos">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="no_npwp" class="form-label">NPWP (Opsional)</label>
                                                        <input type="text" class="form-control" name="no_npwp" id="no_npwp" value="{{ $tenantStore->no_npwp }}" placeholder="Masukkan nomor NPWP">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="kantor_toko_fisik" class="form-label">Memiliki Toko Fisik atau Kantor Usaha?</label>
                                                        <select required class="form-control" name="kantor_toko_fisik" id="kantor_toko_fisik" data-width="100%">
                                                            <option value="">- Pilih -</option>
                                                            <option @if($tenantStore->kantor_toko_fisik == "Ya") selected @endif value="Ya">Ya</option>
                                                            <option @if($tenantStore->kantor_toko_fisik == "Tidak") selected @endif value="Tidak">Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="kategori_usaha_omset" class="form-label">Kategori Usaha Berdasarkan Omzet &nbsp;&nbsp;&nbsp;<a href="{{route('tenant.help.umi')}}"><button title="Baca ketentuan MDR berdasarkan kategori usaha" type="button" class="btn btn-info btn-xs waves-effect waves-light">Baca Ketentuan MDR</button></a></label>
                                                        <select required class="form-control" name="kategori_usaha_omset" id="jenis-omset" data-width="100%">
                                                            <option value="">- Pilih -</option>
                                                            @foreach (App\Models\MDR::get() as $mdr)
                                                                <option value="{{$mdr->id}}"@if ($tenantStore->kategori_usaha_omset == $mdr->id) selected="selected" @endif>{{$mdr->jenis_usaha}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="website" class="form-label">Website (Opsional)</label>
                                                        <input type="text" class="form-control" name="website" id="website" value="{{ $tenantStore->website }}" placeholder="Masukkan alamat website usaha jika ada">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="catatan" class="form-label">Catatan Kaki Nota (Opsional)</label>
                                                        <textarea placeholder="Masukkan catatan kaki" class="form-control" id="catatan" name="catatan" rows="5" spellcheck="false">{!! $tenantStore->catatan_kaki !!}</textarea>
                                                        <small id="emailHelp" class="form-text text-muted">Kata-kata yang akan ditampilkan pada nota pembayaran. Field ini bersifat opsional dan tidak wajib diisi atau boleh dikosongi</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="photo" class="form-label">Upload Logo Toko (Opsional)</label>
                                                                <input type="file" id="image" class="form-control" name="photo" accept="image/*">
                                                                <small id="emailHelp" class="form-text text-muted">Logo toko tidak wajib diisi atau boleh dikosongi</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="example-fileinput" class="form-label"></label>
                                                                <img id="showImage" src="{{ asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="photo" class="form-label">Upload Foto KTP</label>
                                                                <input type="file" id="ktp-image" required class="form-control" name="ktp-image" accept="image/*">
                                                                <small id="emailHelp" class="form-text text-muted">Logo toko tidak wajib diisi atau boleh dikosongi</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="example-fileinput" class="form-label"></label>
                                                                <img id="showImageKtp" src="{{ asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="ktp-image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                                <div class="tab-pane show" id="qris_detail">
                                    @if (empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == "")
                                        <div class="message">
                                            <h1 class="acces-denied">Access to this page is restricted</h1>
                                            <p class="sub-header text-danger"><strong>Lakukan verifikasi nomor Whatsapp sebelum mengupdate data toko anda.</strong></p>
                                        </div>
                                    @else
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Informasi Akun Qris Anda</h5>
                                        @if ($tenantStore->status_registrasi_qris == 0)
                                            <p class="sub-header">Anda belum mengajukan permintaan registrasi Qris dengan nama toko anda, jika anda tidak melakukan registrasi akun Qris maka setiap transaksi otomatis akan menggunakan nama Vsioner untuk setiap transaksi.</p>
                                            <p class="sub-header">Untuk melakukan registrasi akun Qris harap melengkapi informasi detail toko pada menu informasi toko dan melakukan pengekapan profil pada menu My Account. Selanjutnya masuk ke menu Pengajuan Qris ID & Umi untuk mengajukan akun Qris.</p>
                                            <p class="sub-header">Untuk info lebih lanjut <a href="{{route('tenant.help.umi')}}">Baca ketentuan kategori MDR qris</a></p>
                                            <p class="sub-header">Jika anda telah melengkapi profil anda silahkan <a href="{{route('tenant.request.umi')}}">Ajukan Registrasi Akun Qris</a></p>
                                        @else
                                            @if(!is_null($tenantStore->tenantQrisAccount) || !empty($tenantStore->tenantQrisAccount))
                                                <p class="sub-header">
                                                    Jika akun Qris anda <strong>terdaftar sebagai UMI</strong>, maka <strong>MDR 0%</strong> hanya berlaku jika transaksi dibawah <strong>Rp. 100.000</strong>. Jika transaksi diatas <strong>Rp. 100.000</strong> akan dikenakan biaya MDR 0.3% untuk setiap transaksi menggunakan Qris.
                                                </p>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered border-primary mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nama Merchant Qris</th>
                                                                <th>Qris Login User</th>
                                                                <th>Qris Password</th>
                                                                <th>Qris Mecrchant ID</th>
                                                                <th>Qris Store ID</th>
                                                                <th>MDR (%)</th>
                                                                <th>Type Qris</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <th>{{ $tenantStore->name  }}</th>
                                                                <td>{{ $tenantStore->tenantQrisAccount->qris_login_user }}</td>
                                                                <td>{{ $tenantStore->tenantQrisAccount->qris_password }}</td>
                                                                <td>{{ $tenantStore->tenantQrisAccount->qris_merchant_id }}</td>
                                                                <td>{{ $tenantStore->tenantQrisAccount->qris_store_id }}</td>
                                                                <td>{{ $tenantStore->tenantQrisAccount->mdr }}</td>
                                                                <td>
                                                                    @if ($tenantStore->tenantQrisAccount->mdr == 0)
                                                                        Qris UMI
                                                                    @else
                                                                        Qris Reguler
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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