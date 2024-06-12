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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.mitraTenant.kasir.list') }}">Kasir List</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Kasir User's Profile</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="{{ !empty($kasirDetail->detail->photo) ? Storage::url('images/profile/'.$kasirDetail->detail->photo) : asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            <h4 class="mb-0">
                                {{ $kasirDetail->name }}
                            </h4>
                            <p class="text-muted">
                                Kasir
                            </p>
                            @if($kasirDetail->is_active == 1)
                                <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Aktif</button>
                            @else
                                <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Tidak Aktif</button>
                            @endif
                            <div class="text-start mt-3">
                                <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ms-2">{{ $kasirDetail->phone }}</p>
                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2">{{ $kasirDetail->email }}</p>
                            </div>
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
                                        Account Settings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#aboutme" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        Detail Information
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    <form method="post">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Modify Account</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Lengkap</label>
                                                    <input readonly type="hidden" class="form-control" name="id" id="id" required value="{{ $kasirDetail->id }}">
                                                    <input readonly type="text" class="form-control" name="name" id="name" required value="{{ $kasirDetail->name }}" placeholder="Masukkan nama lengkap">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input readonly type="email" class="form-control" name="email" id="email" required value="{{ $kasirDetail->email }}" placeholder="Masukkan email akun">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        {{-- end row --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone Number</label>
                                                    <input readonly type="text" class="form-control" name="phone" id="phone" required value="{{ $kasirDetail->phone }}" placeholder="Enter email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="example-select" class="form-label">Status Akun</label>
                                                    <select disabled class="form-select" id="example-select" name="status" required>
                                                        <option value="">- Pilih status akun -</option>
                                                        <option @if($kasirDetail->is_active == 0) selected  @endif value="0">Belum Aktif</option>
                                                        <option @if($kasirDetail->is_active == 1) selected  @endif value="1">Aktif</option>
                                                        <option @if($kasirDetail->is_active == 2) selected  @endif value="1">Non-Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="aboutme">
                                    <form method="post" enctype="multipart/form-data">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Update Informasi User</h5>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="no_ktp" class="form-label">Nomor KTP</label>
                                                    <input readonly type="hidden" class="form-control" name="id" id="id" required value="{{ $kasirDetail->detail->id }}">
                                                    <input type="text" class="form-control" name="no_ktp" id="no_ktp" required value="{{ $kasirDetail->detail->no_ktp }}" placeholder="Masukkan nomor KTP">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                                    <input readonly type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" required value="{{ $kasirDetail->detail->tempat_lahir }}" placeholder="Masukkan tempat lahir">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                    <input readonly type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ $kasirDetail->detail->tanggal_lahir }}" placeholder="Masukkan tanggal lahir" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                    <select disabled class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                                        <option value="">- Pilih jenis kelamin -</option>
                                                        <option @if($kasirDetail->detail->jenis_kelamin == "Laki-laki") selected @endif value="Laki-laki">Laki-laki</option>
                                                        <option @if($kasirDetail->detail->jenis_kelamin == "Perempuan") selected @endif value="Perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <textarea readonly placeholder="Masukkan alamat anda" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! $kasirDetail->detail->alamat !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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

</x-admin-layout>
