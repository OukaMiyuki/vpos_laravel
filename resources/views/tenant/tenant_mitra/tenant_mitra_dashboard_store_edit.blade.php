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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko') }}">Store</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko.list') }}">Store List</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Edit data toko</h4>
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
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Store Edit</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Toko</label>
                                                <input type="hidden" readonly class="d-none" name="id" id="id" value="{{ $store->id }}">
                                                <input type="hidden" readonly class="d-none" name="store_identifier" id="store_identifier" value="{{ $store->store_identifier }}">
                                                <input type="text" class="form-control" name="name" id="name" required value="{{ $store->name }}" placeholder="Masukkan nama toko">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="no_telp" class="form-label">No. Telp. Toko</label>
                                                <input type="text" class="form-control" name="no_telp" id="no_telp" required value="{{ $store->no_telp_toko }}" placeholder="Masukkan nomor telepon toko">
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
                                                <label for="alamat" class="form-label">Alamat Toko</label>
                                                <textarea placeholder="Masukkan alamat anda" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! $store->alamat !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                                <input type="text" class="form-control" name="kabupaten" id="kabupaten" required value="{{ $store->kabupaten }}" placeholder="Masukkan kabupaten atau kota">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="kode_pos" class="form-label">Kode Pos Toko</label>
                                                <input type="text" class="form-control" name="kode_pos" id="kode_pos" required value="{{ $store->kode_pos }}" placeholder="Masukkan kode pos">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Upload Logo Toko (Opsional)</label>
                                                <input type="file" id="image" class="form-control" name="photo" accept="image/*">
                                                <small id="emailHelp" class="form-text text-muted">Logo toko tidak wajib diisi atau boleh dikosongi</small>
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