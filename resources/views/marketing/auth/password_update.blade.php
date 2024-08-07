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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                <li class="breadcrumb-item active">Change Password</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Change Password</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            @if (auth()->user()->is_active == 0)
                                <div class="message">
                                    <h1 class="acces-denied">Access to this page is restricted</h1>
                                    <p class="sub-header text-danger"><strong>Saat ini akun anda belum diaktifkan dan diverifikasi oleh Admin.<br> silahkan hubungi admin kami untuk melanjutkan ke proses selanjutnya, Terima Kasih!.</strong></p>
                                </div>
                            @else
                                @if (empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == "")
                                    <div class="message">
                                        <h1 class="acces-denied">Access to this page is restricted</h1>
                                        <p class="sub-header text-danger"><strong>Lakukan verifikasi nomor Whatsapp sebelum melakukan update password.</strong></p>
                                    </div>
                                @else
                                    <form id="update-password" method="post" action="{{ route('marketing.password.update') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="old_password" class="form-label">Old Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input required type="password" name="old_password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Masukkan password lama">
                                                        <div class="input-group-text" data-password="false">
                                                            <span class="password-eye"></span>
                                                        </div>
                                                    </div>
                                                    @error('old_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="new_password" class="form-label">New Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input required type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Masukkan password baru">
                                                        <div class="input-group-text" data-password="false">
                                                            <span class="password-eye"></span>
                                                        </div>
                                                    </div>
                                                    @error('new_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input required type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Masukkan ulang password baru">
                                                        <div class="input-group-text" data-password="false">
                                                            <span class="password-eye"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="otp" class="form-label">Kode OTP Whatsapp</label>
                                                    <div class="input-group input-group-merge">
                                                        <input required type="text" name="otp" id="otp" class="form-control" placeholder="Masukkan kode OTP Whatsapp">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ route('marketing.settings.whatsappotp') }}" method="POST" id="sendOtp">@csrf</form>
                                    <div class="text-end">
                                        <button type="submit" form="sendOtp" onclick="!this.form && document.getElementById('sendOtp').submit()" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-whatsapp"></i> Kirim OTP Whatsapp</button>&nbsp;
                                        <button form="update-password" onclick="!this.form && document.getElementById('update-password').submit()" type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                    </div>
                                @endif
                            @endif
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