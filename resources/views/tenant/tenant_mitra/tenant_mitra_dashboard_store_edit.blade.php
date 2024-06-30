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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko') }}">Merchant</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko.list') }}">Merchant List</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Edit data Merchant</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <!-- end col-->
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <form method="post" action="{{ route('tenant.mitra.dashboard.toko.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Merchant Edit</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Merchant</label>
                                                <input type="hidden" readonly class="d-none" name="id" id="id" value="{{ $store->id }}">
                                                <input type="hidden" readonly class="d-none" name="store_identifier" id="store_identifier" value="{{ $store->store_identifier }}">
                                                <input type="text" class="form-control" name="name" id="name" required value="{{ $store->name }}" placeholder="Masukkan nama Merchant">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="no_telp" class="form-label">No. Telp. Merchant</label>
                                                <input type="text" class="form-control" name="no_telp" id="no_telp" required value="{{ $store->no_telp_toko }}" placeholder="Masukkan nomor telepon Merchant">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="jenis" class="form-label">Jenis Usaha</label>
                                                <select required class="form-control" name="jenis" id="jenis" data-toggle="select2" data-width="100%">
                                                    <option value="">- Pilih Jenis Usaha -</option>
                                                    @foreach (App\Models\JenisUsaha::get() as $jenis_usaha)
                                                        <option value="{{ $jenis_usaha->jenis_usaha }}"@if ($store->jenis_usaha == $jenis_usaha->jenis_usaha) selected="selected" @endif>{{ $jenis_usaha->jenis_usaha  }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat Lengkap Merchant</label>
                                                <textarea placeholder="Masukkan alamat anda" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! $store->alamat !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama_jalan" class="form-label">Nama Jalan</label>
                                                <input type="text" class="form-control" name="nama_jalan" id="nama_jalan" required value="{{$store->nama_jalan}}" placeholder="Masukkan nama jalan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama_blok" class="form-label">Nama Blok / Tempat Usaha (Opsional)</label>
                                                <input type="text" class="form-control" name="nama_blok" id="nama_blok" required value="{{$store->nama_blok}}" placeholder="Masukkan nama blok">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="rt" class="form-label">RT.</label>
                                                <input type="text" class="form-control" name="rt" id="rt" required value="{{$store->rt}}" placeholder="Masukkan nomor RT">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="rw" class="form-label">RW.</label>
                                                <input type="text" class="form-control" name="rw" id="rw" required value="{{$store->rw}}" placeholder="Masukkan nomor RW">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="kelurahan_desa" class="form-label">Kelurahan/Desa</label>
                                                <input type="text" class="form-control" name="kelurahan_desa" id="kelurahan_desa" required value="{{$store->kelurahan_desa}}" placeholder="Masukkan nama kelurahan atau desa">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                                <input type="text" class="form-control" name="kecamatan" id="kecamatan" required value="{{$store->kecamatan}}" placeholder="Masukkan nama kecamatan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                                <input type="text" class="form-control" name="kabupaten" id="kabupaten" required value="{{$store->kabupaten}}" placeholder="Masukkan nama kabupaten atau kota">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="kode_pos" class="form-label">Kode Pos Toko</label>
                                                <input type="text" class="form-control" name="kode_pos" id="kode_pos" required value="{{$store->kode_pos}}" placeholder="Masukkan kode pos">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="no_npwp" class="form-label">NPWP (Opsional)</label>
                                                <input type="text" class="form-control" name="no_npwp" id="no_npwp" value="{{$store->no_npwp}}" placeholder="Masukkan nomor NPWP">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="kantor_toko_fisik" class="form-label">Memiliki Toko Fisik atau Kantor Usaha?</label>
                                                <select required class="form-control" name="kantor_toko_fisik" id="kantor_toko_fisik" data-width="100%">
                                                    <option value="">- Pilih -</option>
                                                    <option @if($store->kantor_toko_fisik == "Ya") selected @endif value="Ya">Ya</option>
                                                    <option @if($store->kantor_toko_fisik == "Tidak") selected @endif value="Tidak">Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="kategori_usaha_omset" class="form-label">Kategori Usaha Berdasarkan Omzet</label>
                                                <select required class="form-control" name="kategori_usaha_omset" id="jenis-omset" data-width="100%">
                                                    <option value="">- Pilih -</option>
                                                    <option @if($store->kategori_usaha_omset == "UMI - Penjualan/Tahun: < 2M") selected @endif value="UMI - Penjualan/Tahun: < 2M">UMI - Penjualan/Tahun: < 2M</option>
                                                    <option @if($store->kategori_usaha_omset == "UKE - Penjualan/Tahun: >2M-15M") selected @endif value="UKE - Penjualan/Tahun: >2M-15M">UKE - Penjualan/Tahun: >2M-15M</option>
                                                    <option @if($store->kategori_usaha_omset == "UME - Penjualan/Tahun: >15M-50M") selected @endif value="UME - Penjualan/Tahun: >15M-50M">UME - Penjualan/Tahun: >15M-50M</option>
                                                    <option @if($store->kategori_usaha_omset == "UBE - Penjualan/Tahun: >50M") selected @endif value="UBE - Penjualan/Tahun: >50M">"UBE - Penjualan/Tahun: >50M</option>
                                                    <option @if($store->kategori_usaha_omset == "URE - Donasi, Organisasi Sosial, dsb") selected @endif value="URE - Donasi, Organisasi Sosial, dsb">URE - Donasi, Organisasi Sosial, dsb</option>
                                                    <option @if($store->kategori_usaha_omset == "PSO - Pelayanan Sosial/Bantuan Sosial") selected @endif value="PSO - Pelayanan Sosial/Bantuan Sosial">PSO - Pelayanan Sosial/Bantuan Sosial</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="website" class="form-label">Website (Opsional)</label>
                                                <input type="text" class="form-control" name="website" id="website" value="{{$store->website}}" placeholder="Masukkan alamat website usaha jika ada">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Upload Logo Merchant (Opsional)</label>
                                                <input type="file" id="image" class="form-control" name="photo" accept="image/*">
                                                <small id="emailHelp" class="form-text text-muted">Logo Merchant tidak wajib diisi atau boleh dikosongi</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="example-fileinput" class="form-label"></label>
                                                <img id="showImage" src="{{ asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                    </div>
                                </form>
                            </div>
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
