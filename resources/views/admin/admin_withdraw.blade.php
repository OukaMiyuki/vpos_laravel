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
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                <li class="breadcrumb-item active">Withdraw</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Withdraw Saldo Admin</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <!-- end col-->
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg">
                                <li class="nav-item">
                                    <a href="#qris" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Tarik Saldo Admin
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#syarat" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        Syarat dan Kententuan
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
                                                        <form method="post" action="{{ route('admin.settings.whatsappotp') }}">
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
                                            <label for="dana" class="form-label">Pilih Dana</label>
                                            <select class="form-select" id="dana" name="dana" required>
                                                <option value="">- Pilih Jenis Dana -</option>
                                                <option value="Qris">Insentif Qris</option>
                                                <option value="Aplikasi">Agregate Aplikasi</option>
                                                <option value="Transfer">Agregate Transfer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="saldo-qris-txt">
                                        <div class="mb-3">
                                            <label for="saldo-qris" class="form-label">Saldo Insentif Qris Anda (Rp.)</label>
                                            <input readonly type="text" class="form-control" name="saldo-qris" id="saldo-qris" required value="@money($adminQrisWallet->saldo)" placeholder="Masukkan jumlah saldo">
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="saldo-agregate-aplikasi-txt">
                                        <div class="mb-3">
                                            <label for="saldo-agregate" class="form-label">Saldo Insentif Agregate Aplikasi (Rp.)</label>
                                            <input readonly type="text" class="form-control" name="saldo-agregate-aplikasi" id="saldo-agregate-aplikasi" required value="@money($agregateWalletAplikasi->saldo)" placeholder="Masukkan jumlah saldo">
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="saldo-agregate-transfer-txt">
                                        <div class="mb-3">
                                            <label for="saldo-agregate" class="form-label">Saldo Insentif Agregate Transfer (Rp.)</label>
                                            <input readonly type="text" class="form-control" name="saldo-agregate-transfer" id="saldo-agregate-transfer" required value="@money($agregateWalletTransfer->saldo)" placeholder="Masukkan jumlah saldo">
                                        </div>
                                    </div>
                                    <form method="post" action="{{ route('admin.withdraw.tarik') }}">
                                        @csrf
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="rekening" class="form-label">Pilih Rekening</label>
                                                <select class="form-select" id="rekening" name="rekening" required>
                                                    <option value="">- Pilih Rekening Penarikan -</option>
                                                    @foreach ($rekening as $rek)
                                                        <option value="{{$rek->id}}">{{$rek->nama_rekening}} - {{$rek->no_rekening}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="nominal" class="form-label">Nominal Tarik (Rp.)</label>
                                                    <input readonly type="hidden" class="form-control d-none" name="jenis_tarik" id="jenis-tarik" required value="">
                                                    <input type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" name="nominal_tarik" id="nominal_tarik" required value="" placeholder="Masukkan nominal tarik dana">
                                                    <small id="emailHelp" class="form-text text-muted"><strong>Minimal tarik dana Rp. 10.000, Pastikan saldo anda cukup, sebelum melakukan penarikan!</strong></small>
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
                                            <button disabled id="tarikDanaButton" type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Tarik</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="syarat">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="accordion custom-accordion" id="custom-accordion-one">
                                                <div class="card mb-0">
                                                    <div class="card-header" id="headingNine">
                                                        <h5 class="m-0 position-relative">
                                                            <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse" href="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                                                                Withdrawal Disclaimer <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                            </a>
                                                        </h5>
                                                    </div>
            
                                                    <div id="collapseNine" class="collapse show" aria-labelledby="headingFour" data-bs-parent="#custom-accordion-one">
                                                        <div class="card-body">
                                                            Dalam melakukan transfer dana dan Qris, kami bekerjasama dengan Bank Swasta Nasional yakni <strong>Bank Nationalnobu</strong> yang berizin dan diawasi oleh <strong>OJK</strong> dan merupakan peserta penjaminan LPS. 
                                                            <br>
                                                            <br>
                                                            Pengguna wajib melakukan <strong>verifikasi data diri</strong> atau KYC (Know Your Customer) untuk menghindari tindakan pencucian dana hasil kejahatan sekaligus untuk memastikan fitur ini tidak disalah gunakan.
                                                            <br>
                                                            <br>
                                                            Demi keamanan, kami akan mewajibkan pengguna untuk memasukkan <strong>kode OTP</strong> yang dikirim melalui nomor Whatsapp, pastikan nomor anda aktif dan telah diverifikasi melalui aplikasi Whatsapp.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card mb-0">
                                                    <div class="card-header" id="headingFive">
                                                        <h5 class="m-0 position-relative">
                                                            <a class="custom-accordion-title text-reset collapsed d-block" data-bs-toggle="collapse" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                                Ketentuan biaya transfer bank <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                            </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-bs-parent="#custom-accordion-one">
                                                        <div class="card-body">
                                                            Kami menetapkan biaya penarikan dana sebesar <strong>Rp. 300</strong> untuk setiap penarikan ke semua bank.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
