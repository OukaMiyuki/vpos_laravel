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
                                <li class="breadcrumb-item"><a href="{{route('marketing.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('marketing.settings') }}">Settings</a></li>
                                <li class="breadcrumb-item active">Withdraw</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Withdraw Saldo Qris</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <!-- end col-->
                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg">
                                <li class="nav-item">
                                    <a href="#qris" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Tarik Saldo Qris
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="qris">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="no_wa" class="form-label">Nomor Whatsapp</label>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <input readonly type="text" class="form-control" name="no_wa" id="no_wa" required value="{{ auth()->user()->phone }}" placeholder="Masukkan nomor Whatsapp">
                                                    </div>
                                                    <div class="col-4">
                                                        <form method="post" action="{{ route('marketing.settings.whatsappotp') }}">
                                                            @csrf
                                                            <button type="submit" class="w-100 btn btn-success waves-effect waves-light"><i class="mdi mdi-email-outline"></i> Kirim Kode OTP</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="saldo-qris" class="form-label">Saldo Qris (Rp.)</label>
                                            <input readonly type="text" class="form-control" name="saldo-qris" id="saldo-qris" required value="@money($qrisWallet->saldo)" placeholder="Masukkan jumlah saldo">
                                        </div>
                                    </div>
                                    <form method="post" action="{{ route('marketing.withdraw.process') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="nominal_tarik_dana" class="form-label">Nominal Tarik (Rp.)</label>
                                                    <input type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" name="nominal_tarik_dana" id="nominal_tarik_dana" required value="" placeholder="Masukkan nominal tarik dana">
                                                    <small id="emailHelp" class="form-text text-muted"><strong>Minimal tarik dana Rp. 10.000, Pastikan saldo anda cukup, sebelum melakukan penarikan!</strong></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="biaya_transfer_bank" class="form-label">Biaya Transfer Bank (Rp.)</label>
                                                    <input readonly type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" name="biaya_transfer_bank" id="biaya_transfer_bank" required value="{{$biayaAdmin}}" placeholder="Masukkan nominal biaya transfer">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="total_tarik" class="form-label">Total Penarikan (Rp.)</label>
                                                    <input readonly type="text" class="form-control" name="total_tarik" id="total_tarik" required value="" placeholder="Masukkan total tarik">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="nominal" class="form-label">Whatsapp OTP</label>
                                                    <input type="text" class="form-control" name="wa_otp" id="wa_otp" required value="" placeholder="Masukkan kode OTP Whatsapp">
                                                    <small id="emailHelp" class="form-text text-muted"><strong>Wajib melampirkan OTP Whatsapp!</strong></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button id="tarikDanaButton" type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Tarik</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end tab-content -->
                        </div>
                    </div>
                    <!-- end card-->
                </div>
                @if (!empty(auth()->user()->phone_number_verified_at) || !is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at != NULL || auth()->user()->phone_number_verified_at != "")
                    @if(!empty($rekening->no_rekening) || !is_null($rekening->no_rekening) || $rekening->no_rekening != NULL || $rekening->no_rekening != "")
                        @if ($dataRekening->responseCode == 2001600 ||$dataRekening->responseCode == "2001600")
                            <div class="col-lg-6 col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Informasi Rekening</h4>
                                        <p class="sub-header">
                                            Pastikan nama pemilik rekening, muncul dan sesuai!
                                        </p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered border-primary mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Bank</th>
                                                        <th>Atas Nama</th>
                                                        <th>Nomor Rekening</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <th>{{ $rekening->nama_bank }}</th>
                                                        <td>{{ $dataRekening->beneficiaryAccountName }}</td>
                                                        <td>{{ $dataRekening->beneficiaryAccountNo }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-5 col-xl-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Informasi Rekening</h4>
                                        <p class="sub-header text-danger">
                                            Data rekening yang anda masukkan salah!, silahkan cek kembali data rekening anda!
                                        </p>
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

</x-marketing-layout>
