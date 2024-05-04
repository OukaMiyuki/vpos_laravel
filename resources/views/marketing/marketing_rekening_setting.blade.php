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
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('marketing.settings') }}">Settings</a></li>
                                <li class="breadcrumb-item active">Rekening</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Pengaturan Rekening Anda</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-7 col-xl-7">
                    <div class="card">
                        <div class="card-body">
                            @if (auth()->user()->is_active == 0)
                                <div class="message">
                                    <h1 class="acces-denied">Access to this page is restricted</h1>
                                    <p class="sub-header">Saat ini akun anda belum diaktifkan dan diverifikasi oleh Admin.<br> silahkan hubungi admin kami untuk melanjutkan ke proses selanjutnya, Terima Kasih!.</p>
                                </div>
                            @else
                                @if (empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == "")
                                    <div class="message">
                                        <h1 class="acces-denied">Access to this page is restricted</h1>
                                        <p class="sub-header">Lakukan verifikasi nomor Whatsapp sebelum memasukkan nomor rekening anda.</p>
                                    </div>
                                @else
                                    <form method="post" action="{{ route('marketing.rekening.setting.update') }}" id="submitRekening">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="swift_code" class="form-label">Daftar Bank</label>
                                                    <select required class="form-control" name="swift_code" id="swift_code" data-toggle="select2" data-width="100%">
                                                        <option value="">- Pilih Daftar Bank -</option>
                                                        @foreach ($dataBankList as $bank)
                                                            <option @if($rekening->swift_code == $bank->swiftCode) selected @endif value="{{$bank->swiftCode}}">{{$bank->bankName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="no_rekening" class="form-label">Nomor Rekening</label>
                                                    <input type="text" class="form-control" name="no_rekening" id="no_rekening" required value="{{ $rekening->no_rekening }}" placeholder="Masukkan nomor rekening anda">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="otp" class="form-label">Kode OTP Whatsapp</label>
                                                    <input type="text" class="form-control" name="otp" id="otp" required value="" placeholder="Masukkan kode OTP Whatsapp">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ route('marketing.settings.whatsappotp') }}" method="POST" id="sendOtp">@csrf</form>
                                    <div class="text-end">
                                        <button type="submit" form="sendOtp" onclick="!this.form && document.getElementById('sendOtp').submit()" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-email-outline"></i> Kirim OTP Whatsapp</button>&nbsp;
                                        <button type="submit" form="submitRekening" onclick="!this.form && document.getElementById('submitRekening').submit()" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <!-- end card-->
                </div>
                @if(auth()->user()->is_active != 0)
                    @if (!empty(auth()->user()->phone_number_verified_at) || !is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at != NULL || auth()->user()->phone_number_verified_at != "")
                        @if(!empty($rekening->no_rekening) || !is_null($rekening->no_rekening) || $rekening->no_rekening != NULL || $rekening->no_rekening != "")
                        <div class="col-lg-5 col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Informasi Rekening</h4>
                                    <p class="sub-header">
                                        Add <code>.table-bordered</code> for borders on all sides of the table and cells.
                                    </p>

                                    <div class="table-responsive">
                                        <table class="table table-bordered border-primary mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Username</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Mark</td>
                                                    <td>Otto</td>
                                                    <td>@mdo</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                @endif
                <!-- end col -->
            </div>
            <!-- end row-->
        </div>
        <!-- container -->
    </div>

</x-tenant-layout>