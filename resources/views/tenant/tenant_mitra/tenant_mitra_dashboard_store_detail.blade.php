<x-tenant-layout>
    <div class="content">
        @php
            $umi = "";
            if($store->status_umi == NULL || $store->status_umi == "" || empty($store->status_umi) || is_null($store->status_umi)){
                $umi = "<button type='button' class='btn btn-info btn-xs waves-effect mb-2 waves-light'>UMI Belum Terdaftar</button>";
            } else {
                if($store->status_umi == 0) {
                    $umi = "<button type='button' class='btn btn-warning btn-xs waves-effect mb-2 waves-light'>UMI Belum Disetujui</button>";
                } else if($store->status_umi == 1){
                    $umi = "<button type='button' class='btn btn-success btn-xs waves-effect mb-2 waves-light'>Terdaftar UMI</button>";
                } else if($store->status_umi == 2){
                    $umi = "<button type='button' class='btn btn-danger btn-xs waves-effect mb-2 waves-light'>UMI Ditolak</button>";
                }
            }
        @endphp
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko') }}">Merchant</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko.list') }}">Merchant List</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Detail Merchant</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="{{ !empty($store->photo) ? Storage::url('images/profile/store_list/'.$store->photo) : asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            <h4 class="mb-0">
                                {{ $store->name }}
                            </h4>
                            <p class="text-muted">
                                Merchant
                            </p>
                            @php
                                echo htmlspecialchars_decode($umi);
                            @endphp
                        </div>
                    </div>
                </div>
                <!-- end col-->
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg" id="tab-profile">
                                <li class="nav-item">
                                    <a href="#settings" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Merchant Detail
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#aboutme" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        Request Qris & UMI
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    <form method="post" action="" enctype="multipart/form-data">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Detail Informasi Merchant</h5>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Merchant</label>
                                                    <input type="text" class="form-control" name="name" id="name" required value="{{$store->name}}" readonly placeholder="Masukkan nama merchant">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="no_telp" class="form-label">No. Telp. Merchant</label>
                                                    <input type="text" class="form-control" readonly name="no_telp" id="no_telp" required value="{{$store->no_telp_toko}}" placeholder="Masukkan nomor telepon kantor merchant">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="jenis" class="form-label">Jenis Usaha</label>
                                                    <input type="text" class="form-control" name="jenis_usaha" id="jenis_usaha" required value="{{$store->jenis_usaha}}" readonly placeholder="Masukkan jenis usaha">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat Lengkap Merchant</label>
                                                    <textarea placeholder="Masukkan alamat anda" class="form-control" id="alamat" readonly name="alamat" rows="5" spellcheck="false" required>{!!$store->alamat!!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="nama_jalan" class="form-label">Nama Jalan</label>
                                                    <input type="text" class="form-control" name="nama_jalan" id="nama_jalan" required value="{{$store->nama_jalan}}" readonly placeholder="Masukkan nama jalan">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="nama_blok" class="form-label">Nama Blok / Tempat Usaha (Opsional)</label>
                                                    <input type="text" class="form-control" name="nama_blok" id="nama_blok" required value="{{$store->nama_blok}}" readonly placeholder="Masukkan nama blok">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="rt" class="form-label">RT.</label>
                                                    <input type="text" class="form-control" name="rt" id="rt" required value="{{$store->rt}}" readonly placeholder="Masukkan nomor RT">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="rw" class="form-label">RW.</label>
                                                    <input type="text" class="form-control" name="rw" id="rw" required value="{{$store->rw}}" readonly placeholder="Masukkan nomor RW">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="kelurahan_desa" class="form-label">Kelurahan/Desa</label>
                                                    <input type="text" readonly class="form-control" name="kelurahan_desa" id="kelurahan_desa" required value="{{$store->kelurahan_desa}}" placeholder="Masukkan nama kelurahan atau desa">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                                    <input type="text" class="form-control" name="kecamatan" id="kecamatan" required value="{{$store->kecamatan}}" readonly placeholder="Masukkan nama kecamatan">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                                    <input type="text" class="form-control" name="kabupaten" id="kabupaten" required value="{{$store->kabupaten}}" readonly placeholder="Masukkan nama kabupaten atau kota">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="kode_pos" class="form-label">Kode Pos Kantor Merchant</label>
                                                    <input type="text" class="form-control" name="kode_pos" id="kode_pos" required value="{{$store->kode_pos}}" readonly placeholder="Masukkan kode pos">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="no_npwp" class="form-label">NPWP (Opsional)</label>
                                                    <input type="text" class="form-control" name="no_npwp" id="no_npwp" value="{{$store->no_npwp}}" readonly placeholder="Masukkan nomor NPWP">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="kantor_toko_fisik" class="form-label">Memiliki Toko Fisik atau Kantor Usaha?</label>
                                                    <input type="text" class="form-control" name="kantor_toko_fisik" id="kantor_toko_fisik" readonly value="{{$store->kantor_toko_fisik}}" placeholder="Masukkan status kantor fisik">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="kategori_usaha_omset" class="form-label">Kategori Usaha Berdasarkan Omzet</label>
                                                    <input type="text" class="form-control" name="kategori_usaha_omset" id="kategori_usaha_omset" readonly value="{{$store->kategori_usaha_omset}}" placeholder="Masukkan jenis omset">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="website" class="form-label">Website (Opsional)</label>
                                                    <input type="text" class="form-control" name="website" id="website" value="{{$store->website}}" readonly placeholder="Masukkan alamat website usaha jika ada">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="aboutme">
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Pengajuan Qris Merchant ID & UMI</h5>
                                    @if ($umiRequest == "Empty")
                                        <p class="sub-header">
                                            <div class="col-xl-12">
                                                <div class="accordion custom-accordion" id="custom-accordion-one">
                                                    <div class="card mb-0">
                                                        <div class="card-header" id="headingNine">
                                                            <h5 class="m-0 position-relative">
                                                                <a class="custom-accordion-title text-reset d-block" data-bs-toggle="collapse" href="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                                                                    Q. Apa itu pendaftaran QRIS Merchant dan UMI? <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                                </a>
                                                            </h5>
                                                        </div>
                
                                                        <div id="collapseNine" class="collapse show" aria-labelledby="headingFour" data-bs-parent="#custom-accordion-one">
                                                            <div class="card-body">
                                                                Kami memberikan fasilitas bagi pengguna <strong>Mitra Bisnis untuk dapat memiliki akun Qris</strong> dengan nama merchant yang dimiliki oleh Mitra Bisnis.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card mb-0">
                                                        <div class="card-header" id="headingFive">
                                                            <h5 class="m-0 position-relative">
                                                                <a class="custom-accordion-title text-reset collapsed d-block" data-bs-toggle="collapse" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                                    Q. Apa keuntungan melakukan request akun Qris? <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-bs-parent="#custom-accordion-one">
                                                            <div class="card-body">
                                                                Dengan melakukan pendaftaran Qris Merchant, pengguna akan mendapatkan <strong>akun QRIS dengan nama sesuai dengan merchant</strong> saat melakukan pembayaran, sehingga <strong>memudahkan pelanggan untuk mengenali dan mengidentifikasi transaksi</strong> yang dilakukan. 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card mb-0">
                                                        <div class="card-header" id="headingSix">
                                                            <h5 class="m-0 position-relative">
                                                                <a class="custom-accordion-title text-reset collapsed d-block" data-bs-toggle="collapse" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                                    Q. Apakah wajib melakukan pendaftaran Qris Merchant? <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-bs-parent="#custom-accordion-one">
                                                            <div class="card-body">
                                                                Pendaftaran ini bersifat <strong>tidak wajib</strong>, pengguna tetap bisa melakukan transaksi maupun request pembayatan Qris melalui API. Namun secara default <strong>nama yang tertera saat pembayaran Qris akan menggunakan Merchant Name dari Visioner</strong>.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card mb-0">
                                                        <div class="card-header" id="headingSeven">
                                                            <h5 class="m-0 position-relative">
                                                                <a class="custom-accordion-title text-reset collapsed d-block" data-bs-toggle="collapse" href="#collapseSeven"  aria-expanded="false" aria-controls="collapseSeven">
                                                                    Q. Apa bedanya Qris Reguler dan Qris UMI? <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-bs-parent="#custom-accordion-one">
                                                            <div class="card-body">
                                                                <strong>QRIS Reguler</strong> dan <strong>QRIS UMI</strong> memiliki perbedaan yang signifikan dalam tujuan dan penggunaannya. <strong>QRIS Reguler dirancang untuk mendukung berbagai jenis usaha, baik besar maupun kecil, dan terbuka untuk semua merchant</strong> seperti toko retail dan restoran, dengan transaksi yang cocok untuk berbagai jumlah nominal serta fitur lengkap seperti integrasi dengan berbagai aplikasi pembayaran dan dukungan multi-bank. Sebaliknya, <strong>QRIS UMI (Usaha Mikro Indonesia) khusus ditujukan untuk pedagang kecil, usaha rumahan, dan UMKM, ideal untuk transaksi dengan nominal kecil</strong> dan menawarkan biaya yang lebih terjangkau serta proses pendaftaran yang lebih sederhana, sehingga sangat mendukung pertumbuhan usaha mikro di Indonesia.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card mb-0">
                                                        <div class="card-header" id="headingEight">
                                                            <h5 class="m-0 position-relative">
                                                                <a class="custom-accordion-title text-reset collapsed d-block"
                                                                    data-bs-toggle="collapse" href="#collapseEight"
                                                                    aria-expanded="false" aria-controls="collapseEight">
                                                                    Q. Bagaimana caranya melakukan pendaftaran Qris Merchant? <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseEight" class="collapse"
                                                            aria-labelledby="headingEight"
                                                            data-bs-parent="#custom-accordion-one">
                                                            <div class="card-body">
                                                                Pendaftaran akun Qris Merchant dapat dilakukan pada masiing-masing merchant list dengan melakukan <strong>klik pada tombol detail merchant</strong>, lalu masuk ke tab <strong>Request Qris & UMI</strong> kemudian klik tombol <strong>Ajukan Request</strong>. Setelah itu permintaan anda akan diproses oleh pihak bank dengan estimasi maksimal 7 hari kerja. Pengguna Mitra Bisnis akan otomatis mendapatkan notifikasi melalui Whatsapp jika akun anda siap untuk digunakan.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </p>
                                        <form method="post" action="{{ route('tenant.mitra.dashboard.toko.request.umi') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" readonly class="d-none" name="id" id="id" value="{{ $store->id }}">
                                            <input type="hidden" readonly class="d-none" name="store_identifier" id="store_identifier" value="{{ $store->store_identifier }}">
                                            <div class="row">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Ajukan Request</button>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        @php
                                            $tenantQris = App\Models\TenantQrisAccount::where('store_identifier', $store->store_identifier)
                                                                                        ->where('id_tenant', auth()->user()->id)
                                                                                        ->where('email', auth()->user()->email)
                                                                                        ->first();
                                        @endphp
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th class="text-center">Tanggal Pengajuan</th>
                                                        <th class="text-center">Tanggal Approval</th>
                                                        <th class="text-center">Status</th>
                                                        <th>Note</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td class="text-center">{{ $umiRequest->tanggal_pengajuan }}</td>
                                                        <td class="text-center">{{ $umiRequest->tanggal_approval }}</td>
                                                        <td class="text-center">
                                                            @if($umiRequest->is_active == 0)
                                                                <span class="badge bg-soft-warning text-warning">Pending</span>
                                                            @elseif($umiRequest->is_active == 1)
                                                                <span class="badge bg-soft-success text-success">Disetujui</span>
                                                            @elseif($umiRequest->is_active == 2)
                                                                <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $umiRequest->note }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @if($umiRequest->is_active == 1)
                                            @if (!empty($tenantQris) || !is_null($tenantQris))
                                                <h5 class="mb-4 text-uppercase mt-3"><i class="mdi mdi-account-circle me-1"></i> Detail Informasi Akun Qris</h5>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Qris Login User</label>
                                                            <input type="text" class="form-control" readonly name="login-user" id="login-user" required value="{{ $tenantQris->qris_login_user }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="no_telp" class="form-label">Qris Password</label>
                                                            <input type="text" class="form-control" readonly name="qpassword" id="qpassword" required value="{{ $tenantQris->qris_password }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="jenis" class="form-label">Qris Merchant ID</label>
                                                            <input type="text" class="form-control" readonly name="mcrid" id="mcrid" required value="{{ $tenantQris->qris_merchant_id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="jenis" class="form-label">Qris Store ID</label>
                                                            <input type="text" class="form-control" readonly name="storeid" id="storeid" required value="{{ $tenantQris->qris_store_id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="kabupaten" class="form-label">MDR (%)</label>
                                                            <input readonly type="text" class="form-control" name="mdr" id="mdr" readonlyrequired value="{{ $tenantQris->mdr }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
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
</x-tenant-layout>
