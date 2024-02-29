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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Tambah Data Diskon Baru</h4>
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
                                <form method="post" action="{{ route('tenant.product.stock.insert') }}">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Discount</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="id_batch_product" class="form-label">Product Name</label>
                                                <select required class="form-control" name="id_batch_product" id="id_batch_product" data-toggle="select2" data-width="100%">
                                                    <option value="">- Pilih Batch Product -</option>
                                                    <option value="All Product">Semua Produk</option>
                                                    @foreach (App\Models\Product::where('id_tenant', auth()->user()->id)->latest()->get() as $product)
                                                        <option value="{{ $product->id }}"@if (old('id_batch_product') == $product->id) selected="selected" @endif>{{ $product->product_code }} - {{ $product->product_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="barcode" class="form-label">Nama Promo</label>
                                                <input readonly required type="text" class="form-control" name="barcode" id="barcode" value="" placeholder="Masukkan barcode">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="stok" class="form-label">Jumlah Minimum Pembelian</label>
                                                <input required type="number" class="form-control" name="stok" id="stok" value="" placeholder="Masukkan jumlah stok">
                                                <small id="emailHelp" class="form-text text-muted">Masukkan 0 jika tidak ada minimum jumlah pembelian.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="t_beli" class="form-label">Minimum Harga</label>
                                                <input type="text" class="form-control" name="t_beli" id="t_beli" required value="" placeholder="Masukkan tanggal beli">
                                                <small id="emailHelp" class="form-text text-muted">Masukkan 0 jika tidak ada minimum harga.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="h_beli" class="form-label">Diskon <strong>(%)</strong></label>
                                                <input type="number" class="form-control" name="h_beli" id="h_beli" required value="" placeholder="Masukkan nominal harga beli">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="barcode" class="form-label">Tanggal Mulai Dskon</label>
                                                <input readonly required type="text" class="form-control" name="barcode" id="barcode" value="" placeholder="Masukkan barcode">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="stok" class="form-label">Tanggal Berakhor Diskon</label>
                                                <input required type="number" class="form-control" name="stok" id="stok" value="" placeholder="Masukkan jumlah stok">
                                                <small id="emailHelp" class="form-text text-muted">Masukkan 0 jika tidak ada minimum jumlah pembelian.</small>
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