<x-marketing-layout>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('marketing.settings') }}">Settings</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('marketing.profile') }}">Profile</a></li>
                                <li class="breadcrumb-item active">Proses Penarikan</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Form Proses Penarikan Dana</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-xl-7">
                    <div class="card">
                        <div class="card-body">
                            @if (empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == "")
                                <div class="message">
                                    <h1 class="acces-denied">Access to this page is restricted</h1>
                                    <p class="sub-header text-danger"><strong>Lakukan verifikasi nomor Whatsapp sebelum memasukkan nomor rekening anda.</strong></p>
                                </div>
                            @else
                                <p class="sub-header text-danger"><strong>Pastikan informasi data yang anda masukkan benar dan sesuai sebelum melanjutkan proses penarikan!</strong></p>
                                <form method="post" action="{{ route('marketing.profile.tarik.proses') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="nominal_penarikan" class="form-label">Nominal Penarikan (Rp.)</label>
                                                <input readonly type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" name="nominal_penarikan" id="nominal_penarikan" required value="{{ $nominal_tarik }}" placeholder="Masukkan nominal tarik dana">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="biaya_admin" class="form-label">Biaya Transfer <label for="" style="font-style: italic;">BI-Fast</label> (Rp.)</label>
                                                <input readonly type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" name="biaya_admin" id="biaya_admin" required value="{{ $biayaAdmin }}" placeholder="Masukkan biaya admin">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="total_tarik" class="form-label">Total (Rp.)</label>
                                                <input readonly type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" name="total_tarik" id="total_tarik" required value="{{ $totalPenarikan }}" placeholder="Masukkan total penarikan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Proses Tarik Dana</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                    <!-- end card-->
                </div>
                @if (!empty(auth()->user()->phone_number_verified_at) || !is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at != NULL || auth()->user()->phone_number_verified_at != "")
                    @if(!empty($rekening->no_rekening) || !is_null($rekening->no_rekening) || $rekening->no_rekening != NULL || $rekening->no_rekening != "")
                        <div class="col-lg-5 col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Informasi Rekening</h4>
                                    {{-- <p class="sub-header">
                                        Add <code>.table-bordered</code> for borders on all sides of the table and cells.
                                    </p> --}}

                                    <div class="table-responsive">
                                        <table class="table table-bordered border-primary mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Atas Nama</th>
                                                    <th>Nomor Rekening</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>{{ $dataRekening->beneficiaryAccountName }}</td>
                                                    <td>{{ $dataRekening->beneficiaryAccountNo }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                <!-- end col -->
            </div>
            <!-- end row-->
        </div>
        <!-- container -->
    </div>

</x-marketing-layout>