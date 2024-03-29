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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                <li class="breadcrumb-item active">Profile</li>
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
                            <img src="{{ !empty(auth()->user()->detail->photo) ? Storage::url('images/profile/'.auth()->user()->detail->photo) : asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            <h4 class="mb-0">
                                {{ auth()->user()->name }}
                            </h4>
                            <p class="text-muted">
                                Marketing
                            </p>
                            @if(auth()->user()->is_active == 1)
                                <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Aktif</button>
                            @else 
                                <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Tidak Aktif</button>
                            @endif
                            <div class="text-start mt-3">
                                <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ms-2">{{ auth()->user()->phone }}</span></p>
                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2">{{ auth()->user()->email }}</span></p>
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
                                <li class="nav-item">
                                    <a href="#saldo" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        Penarikan Saldo
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    <form method="post" action="{{ route('marketing.profile.account.update') }}">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Modify Account</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Lengkap</label>
                                                    <input readonly type="hidden" class="form-control" name="id" id="id" required value="{{ auth()->user()->id }}">
                                                    <input type="text" class="form-control" name="name" id="name" required value="{{ auth()->user()->name }}" placeholder="Masukkan nama lengkap">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email" required value="{{ auth()->user()->email }}" placeholder="Masukkan email akun">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control" name="phone" id="phone" required value="{{ auth()->user()->phone }}" placeholder="Enter email">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="aboutme">
                                    <form method="post" action="{{ route('marketing.profile.info.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Update Informasi User</h5>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="no_ktp" class="form-label">Nomor KTP</label>
                                                    <input readonly type="hidden" class="form-control" name="id" id="id" required value="{{ auth()->user()->detail->id }}">
                                                    <input type="text" class="form-control" name="no_ktp" id="no_ktp" required value="{{auth()->user()->detail->no_ktp}}" placeholder="Masukkan nomor KTP">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" required value="{{ auth()->user()->detail->tempat_lahir }}" placeholder="Masukkan tempat lahir">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ auth()->user()->detail->tanggal_lahir }}" placeholder="Masukkan tanggal lahir" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                                        <option value="">- Pilih jenis kelamin -</option>
                                                        <option @if(auth()->user()->detail->jenis_kelamin == "Laki-laki") selected @endif value="Laki-laki">Laki-laki</option>
                                                        <option @if(auth()->user()->detail->jenis_kelamin == "Perempuan") selected @endif value="Perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <textarea placeholder="Masukkan alamat anda" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! auth()->user()->detail->alamat !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="photo" class="form-label">Upload Foto Profil</label>
                                                    <input type="file" id="image" class="form-control" name="photo" accept="image/*">
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
                                </div>
                                <div class="tab-pane" id="saldo">
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-cash-multiple me-1"></i> Proses Penarikan Saldo</h5>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="saldo" class="form-label">Saldo Anda (Rp.)</label>
                                            <input readonly type="text" class="form-control" name="saldo" id="saldo" required value="1000000" placeholder="Masukkan jumlah saldo">
                                        </div>
                                    </div>
                                    <form method="post" action="">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" class="form-control" name="id" id="id" required value="{{auth()->user()->detail->id}}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="tempat_lahir" class="form-label">Nominal Tarik</label>
                                                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" required value="" placeholder="Masukkan nominal tarik dana">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Tarik</button>
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
</x-marketing-layout>