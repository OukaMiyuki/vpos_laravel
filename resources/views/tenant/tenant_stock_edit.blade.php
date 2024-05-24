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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.toko') }}">Toko</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.product.stock.list') }}">Stock Product</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Edit Data Stok Produk</h4>
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
                                <form method="post" action="{{ route('tenant.product.stock.update') }}">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Stock</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="id_batch_product" class="form-label">Product Name</label>
                                                <input required readonly type="hidden" class="form-control" name="id" id="id" value="{{ $stock->id }}"">
                                                <input required readonly type="text" class="form-control" name="id_batch_product" id="id_batch_product" value="{{ $stock->product->product_name }}" placeholder="Masukkan batch produk">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="barcode" class="form-label">Barcode</label>
                                                <input required type="text" class="form-control" name="barcode" id="barcode" readonly value="{{ $stock->barcode }}" placeholder="Masukkan barcode">
                                                <small id="emailHelp" class="form-text text-muted">Barcode tidak boleh sama dengan data stok lain</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="stok" class="form-label">Stok</label>
                                                {{-- <input required readonly type="hidden" class="form-control" name="stok_temp" id="stok_temp" value="{{ $stock->stok }}"> --}}
                                                <input required type="number" class="form-control" name="stok" id="stok" value="{{ $stock->stok }}" placeholder="Masukkan jumlah stok">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="t_beli" class="form-label">Tanggal Beli (Opsional)</label>
                                                <input type="date" class="form-control" name="t_beli" id="t_beli" value="{{ $stock->tanggal_beli }}" placeholder="Masukkan tanggal beli">
                                                <small id="emailHelp" class="form-text text-muted"><strong>Isikan dengan tanggal beli produk, field ini tidak wajib diisi atau boleh dikosongi!</strong></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="t_expired" class="form-label">Tanggal Expired (Kosongi jika bukan peroduk makanan)</label>
                                                <input type="date" class="form-control" name="t_expired" id="t_expired" value="{{ $stock->tanggal_expired }}" placeholder="Masukkan tanggal expired">
                                                <small id="emailHelp" class="form-text text-muted"><strong>Isikan dengan tanggal expired produk, field ini tidak wajib diisi atau boleh dikosongi!</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="h_beli" class="form-label">Harga beli per piece <strong>(Rp.)</strong></label>
                                                <input type="number" class="form-control" name="h_beli" id="h_beli" value="{{ $stock->harga_beli }}" placeholder="Masukkan nominal harga beli">
                                                <small id="emailHelp" class="form-text text-muted"><strong>Isikan dengan harga beli per-item dari supplier, field ini tidak wajib diisi atau boleh dikosongi!</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update</button>
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