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
                                <li class="breadcrumb-item active">Profile</li>
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
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="qris">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="dana" class="form-label">Pilih Dana</label>
                                            <select class="form-select" id="dana" name="dana" required>
                                                <option value="">- Pilih Jenis Dana -</option>
                                                <option value="Qris">Insentif Qris</option>
                                                <option value="Agregate">Agregate</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="saldo" class="form-label">Saldo Anda (Rp.)</label>
                                            <input readonly type="text" class="form-control" name="saldo" id="saldo" required value="{{ $adminQrisWallet->saldo }}" placeholder="Masukkan jumlah saldo">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="no_wa" class="form-label">Nomor Whatsapp</label>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <input readonly type="text" class="form-control" name="no_wa" id="no_wa" required value="" placeholder="Masukkan nomor Whatsapp">
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
                                    <form method="post" action="{{ route('marketing.profile.tarik') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="nominal" class="form-label">Nominal Tarik (Rp.)</label>
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

</x-admin-layout>