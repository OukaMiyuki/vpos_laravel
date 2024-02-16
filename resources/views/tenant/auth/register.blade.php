<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>VPOS User Register | Tenant</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/logo/Logo2.png') }}">
        <!-- Bootstrap css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>
        <!-- icons -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Head js -->
        <script src="{{ asset('assets/js/head.js') }}"></script>
    </head>
    <body class="authentication-bg authentication-bg-pattern">
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9 col-lg-7 col-xl-6">
                        <div class="card bg-pattern">
                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="index.html" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="{{ asset('assets/images/logo/Logo1.png') }}" alt="" height="100">
                                            </span>
                                        </a>
                                        <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="{{ asset('assets/images/logo/Logo1.png') }}" alt="" height="100">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">Don't have an account? Create your account, it takes less than a minute</p>
                                </div>
                                <form method="POST" action="{{ route('tenant.register') }}">
                                    @csrf
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
                                    {{-- <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="checkbox-signup">
                                            <label class="form-check-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-dark">Terms and Conditions</a></label>
                                        </div>
                                    </div> --}}
                                    <div class="text-center d-grid">
                                        <button class="btn btn-success" type="submit"> Sign Up </button>
                                    </div>
                                </form>
                            </div>
                            <!-- end card-body -->
                        </div>
                        <!-- end card -->
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Sudah punya akun?  <a href="{{ route('tenant.login') }}" class="text-white ms-1"><b>Sign In</b></a></p>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
        <footer class="footer footer-alt">
            2015 - <script>document.write(new Date().getFullYear())</script> &copy; UBold theme by <a href="" class="text-white-50">Coderthemes</a>
        </footer>
        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <!-- App js -->
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
    </body>
</html>
