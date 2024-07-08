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
                                <li class="breadcrumb-item"><a href="{{ route('admin.setting') }}">Settings</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.rekening.setting') }}">Rekening</a></li>
                                <li class="breadcrumb-item active">Add</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Pengaturan Rekening Anda</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-xl-7">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.rekening.setting.insert') }}" id="submitRekening">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="swift_code" class="form-label">Daftar Bank</label>
                                            <select required class="form-control" name="swift_code" id="swift_code" data-toggle="select2" data-width="100%">
                                                <option value="">- Pilih Daftar Bank -</option>
                                                @foreach ($dataBankList as $bank)
                                                    <option value="{{$bank->swiftCode}}">{{$bank->bankName}}</option>
                                                @endforeach
                                            </select>
                                            <small id="emailHelp" class="form-text text-danger"><strong>Pastikan anda memasukkan data bank dan nomor rekening dengan benar!</strong></small>
                                            <input type="hidden" readonly class="d-none" name="nama_bank" id="nama_bank" required value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="nama_rekening" class="form-label">Nama Rekening</label>
                                            <input type="text" class="form-control" name="nama_rekening" id="nama_rekening" required value="" placeholder="Masukkan nama rekening">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="no_rekening" class="form-label">Nomor Rekening</label>
                                            <input type="text" class="form-control" name="no_rekening" id="no_rekening" required value="" placeholder="Masukkan nomor rekening anda">
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
                                <input readonly type="hidden" class="d-none" name="long" id="long" required value="">
                                <input readonly type="hidden" class="d-none" name="lat" id="lat" required value="">
                            </form>
                            <form action="{{ route('admin.settings.whatsappotp') }}" method="POST" id="sendOtp">@csrf</form>
                            <div class="text-end">
                                <button type="submit" form="sendOtp" onclick="!this.form && document.getElementById('sendOtp').submit()" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-whatsapp"></i> Kirim OTP Whatsapp</button>&nbsp;
                                <button type="submit" form="submitRekening" onclick="!this.form && document.getElementById('submitRekening').submit()" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>