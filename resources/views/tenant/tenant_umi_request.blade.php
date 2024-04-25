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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Request Umi</h4>
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
                                @if ($umiRequest == "Empty")
                                    <form method="post" action="{{ route('tenant.request.umi.send') }}">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Formulir Pendaftaran Umi</h5>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="nama_pemilik" class="form-label">Nama Pemilik Usaha</label>
                                                    <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" required value="{{ auth()->user()->name }}" placeholder="Masukkan nama pemilik usaha" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="no_ktp" class="form-label">Nomor KTP</label>
                                                    <input type="text" class="form-control" name="no_ktp" id="no_ktp" required value="{{ auth()->user()->detail->no_ktp }}" placeholder="Masukkan nomor KTP" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="no_hp" class="form-label">Nomor Handphone</label>
                                                    <input type="text" class="form-control" name="no_hp" id="no_hp" required value="{{ auth()->user()->phone }}" placeholder="Masukkan nomor Handphone" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email" required value="{{ auth()->user()->email }}" placeholder="Masukkan alamat email" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="nama_usaha" class="form-label">Nama Usaha</label>
                                                    <input type="text" class="form-control" name="nama_usaha" id="nama_usaha" required value="{{ auth()->user()->storeDetail->name }}" placeholder="Masukkan nama usaha" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="jenis_usaha" class="form-label">Jenis Usaha</label>
                                                    <input type="text" class="form-control" name="jenis_usaha" id="jenis_usaha" required value="{{ auth()->user()->storeDetail->jenis_usaha }}" placeholder="Masukkan jenis usaha" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat Usaha</label>
                                                    <textarea readonly placeholder="Masukkan alamat usaha" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! auth()->user()->storeDetail->alamat !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="kab_kota" class="form-label">Kabupaten/Kota</label>
                                                    <input type="text" class="form-control" name="kab_kota" id="kab_kota" required value="{{ auth()->user()->storeDetail->kabupaten }}" placeholder="Masukkan kabupaten atau kota" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                                    <input type="text" class="form-control" name="kode_pos" id="kode_pos" required value="{{ auth()->user()->storeDetail->kode_pos }}" placeholder="Masukkan kode pos" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Ajukan Umi</button>
                                        </div>
                                    </form>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tanggal Pengajuan</th>
                                                    <th>Tanggal Approval</th>
                                                    <th>Status</th>
                                                    <th>Note</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>{{ $umiRequest->tanggal_pengajuan }}</td>
                                                    <td>{{ $umiRequest->tanggal_approval }}</td>
                                                    <td>
                                                        @if($umiRequest->is_active == 0)
                                                            <span class="badge bg-soft-warning text-warning">Pending</span>
                                                        @elseif($umiRequest->is_active == 1)
                                                            <span class="badge bg-soft-success text-success">Disetujui</span>
                                                        @elseif($umiRequest->is_active == 2)
                                                            <span class="badge bg-soft-danger text-danger">Ditolak</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $umiRequest->note }}</td>
                                                    <td><button title="Lihat data kasir" type="button" class="btn btn-info rounded-pill waves-effect waves-light">Ajukan Ulang</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                @endif
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