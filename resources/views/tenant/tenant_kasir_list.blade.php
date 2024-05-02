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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.kasir') }}">Kasir</a></li>
                                <li class="breadcrumb-item active">Data Kasir</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Kasir Semua Toko</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Semua Kasir&nbsp;&nbsp;&nbsp;<button data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Tambah kode baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan kasir baru</button></h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Posisi</th>
                                            <th>Jenis Kelamin</th>
                                            <th>No. KTP</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($kasir as $kasir)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $kasir->name }}</td>
                                                <td>{{ $kasir->email }}</td>
                                                <td>Kasir</td>
                                                <td>{{ $kasir->detail->jenis_kelamin }}</td>
                                                <td>{{ $kasir->detail->no_ktp }}</td>
                                                <td>
                                                    @if($kasir->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Non Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('tenant.kasir.detail', ['id' => $kasir->id]) }}">
                                                        <button title="Lihat data kasir" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
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
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Kasir Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('tenant.register.kasir') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_ktp" class="form-label">Nomor KTP</label>
                                    <input type="text" class="form-control @error('no_ktp') is-invalid @enderror" name="no_ktp" id="no_ktp" required value="{{ old('no_ktp') }}" placeholder="Masukkan nomor KTP">
                                    @error('no_ktp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" required value="{{ old('email') }}" placeholder="Masukkan email akun">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">No Telp. / Whatsapp</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" required value="{{ old('phone') }}" placeholder="Contoh : 081XXXXXXXXX">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">- Pilih jenis kelamin -</option>
                                        <option value="Laki-laki"@if (old('jenis_kelamin') == "Laki-laki") {{ 'selected' }} @endif>Laki-laki</option>
                                        <option value="Perempuan"@if (old('jenis_kelamin') == "Perempuan") {{ 'selected' }} @endif>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" id="tempat_lahir" required value="{{ old('tempat_lahir') }}" placeholder="Masukkan temoat lahir">
                                    @error('tempat_lahir')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Masukkan ulang password" required>
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea placeholder="Masukkan alamat anda" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! old('alamat') !!}</textarea>
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
</x-tenant-layout>