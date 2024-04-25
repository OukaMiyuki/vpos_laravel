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
                                <li class="breadcrumb-item"><a href="">Store Management</a></li>
                                <li class="breadcrumb-item active">Discount</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Ubah Data Diskon Baru</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <!-- end col-->
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <form method="post" action="{{ route('tenant.discount.insert') }}">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Modify Discount</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="min_harga" class="form-label">Minimum Harga</label>
                                                <input type="text" class="form-control" name="min_harga" id="min_harga" required value="@if(!empty($diskon->min_harga)) {{ $diskon->min_harga }} @endif" placeholder="Masukkan minimal harga">
                                                <small id="emailHelp" class="form-text text-muted">Masukkan 0 jika tidak ada minimum harga.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="diskon" class="form-label">Diskon <strong>(%)</strong></label>
                                                <input type="text" class="form-control" name="diskon" id="diskon" required value="@if(!empty($diskon->diskon)) {{ $diskon->diskon }} @endif" placeholder="Masukkan presentase diskon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="t_mulai" class="form-label">Tanggal Mulai Dskon</label>
                                                <input required type="date" class="form-control" name="t_mulai" id="t_mulai" @if(!empty($diskon->start_date)) value="{{ $diskon->start_date }}" @endif placeholder="Masukkan tanggal mulai berlaku">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="t_akhir" class="form-label">Tanggal Berakhir Diskon</label>
                                                <input required type="date" class="form-control" name="t_akhir" id="t_akhir"  @if(!empty($diskon->end_date)) value="{{ $diskon->end_date }}" @endif" placeholder="Masukkan tanggal akhir promo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="" name="status" required>
                                                    <option value="">- Pilih status diskon -</option>
                                                    <option @if(!empty( $diskon->is_active)) @if($diskon->is_active == 0) selected  @endif @endif value="0">Non-Aktif</option>
                                                    <option @if(!empty( $diskon->is_active)) @if($diskon->is_active == 1) selected  @endif @endif value="1">Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Tambah</button>
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