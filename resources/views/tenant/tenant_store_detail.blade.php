<x-tenant-layout>
    <div class="content">
        @php
            $umi = "";
            if($tenantStore->status_umi == NULL || $tenantStore->status_umi == "" || empty($tenantStore->status_umi) || is_null($tenantStore->status_umi)){
                $umi = "<button type='button' class='btn btn-info btn-xs waves-effect mb-2 waves-light'>UMI Belum Terdaftar</button>";
            } else {
                if($tenantStore->status_umi == 0) {
                    $umi = "<button type='button' class='btn btn-warning btn-xs waves-effect mb-2 waves-light'>UMI Belum Disetujui</button>";
                } else if($tenantStore->status_umi == 1){
                    $umi = "<button type='button' class='btn btn-success btn-xs waves-effect mb-2 waves-light'>Terdaftar UMI</button>";
                } else if($tenantStore->status_umi == 2){
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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.settings') }}">Settings</a></li>
                                <li class="breadcrumb-item active">Store Settings</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Profile</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-4 col-xl-4">
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
                                echo htmlspecialchars_decode($umi);
                            @endphp
                        </div>
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
                                                        <label for="alamat" class="form-label">Alamat Toko</label>
                                                        <textarea placeholder="Masukkan alamat anda" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! $tenantStore->alamat !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                                        <input type="text" class="form-control" name="kabupaten" id="kabupaten" required value="{{ $tenantStore->kabupaten }}" placeholder="Masukkan kabupaten atau kota">
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
                                                        <label for="catatan" class="form-label">Catatan Kaki Nota (Opsional)</label>
                                                        <textarea placeholder="Masukkan catatan kaki" class="form-control" id="catatan" name="catatan" rows="5" spellcheck="false">{!! $tenantStore->catatan_kaki !!}</textarea>
                                                        <small id="emailHelp" class="form-text text-muted">Kata-kata yang akan ditampilkan pada nota pembayaran. Field ini bersifat opsional dan tidak wajib diisi atau boleh dikosongi</small>
                                                    </div>
                                                </div>
                                            </div>
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
                                                <!-- end col -->
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                            </div>
                                        </form>
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