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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.product.batch.list') }}">Batch Product</a></li>
                                <li class="breadcrumb-item active">Detail</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Detail produk</h4>
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
                                <form method="post" action="" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Product Detail</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="p_code" class="form-label">Product Code</label>
                                                <input readonly type="text" class="form-control" name="p_code" id="p_code" required value="{{ $product->product_code }}" placeholder="Masukkan product code">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="p_name" class="form-label">Product Name</label>
                                                <input readonly type="text" class="form-control" name="p_name" id="p_name" required value="{{ $product->product_name }}" placeholder="Masukkan nama produk">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Product Category</label>
                                                <input readonly type="text" class="form-control" name="category" id="category" required value="{{ $product->category->name }}" placeholder="Masukkan product category">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="batch" class="form-label">Batch ID</label>
                                                <input readonly type="text" class="form-control" name="batch" id="batch" required value="{{ $product->batch->batch_code }} - {{ $product->batch->keterangan }}" placeholder="Masukkan batch id">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="supplier" class="form-label">Supplier</label>
                                                <input readonly type="text" class="form-control" name="supplier" id="supplier" required value="{{ $product->supplier->nama_supplier }}" placeholder="Masukkan nama supplier">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gudang" class="form-label">Nomor Gudang (Opsional)</label>
                                                <input readonly type="text" class="form-control" name="gudang" id="gudang" value="{{ $product->nomor_gudang }}" placeholder="Masukkan nomor gudang">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="rak" class="form-label">Nomor Rak (Opsional)</label>
                                                <input readonly type="text" class="form-control" name="rak" id="rak" value="{{ $product->nomor_rak }}" placeholder="Masukkan nomor rak">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="t_beli" class="form-label">Tanggal Beli</label>
                                                <input readonly type="date" class="form-control" name="t_beli" id="t_beli" required value="{{ $product->tanggal_beli }}" placeholder="Masukkan tanggal beli">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="t_expired" class="form-label">Tanggal Expired (kosongi jika bukan peroduk makanan)</label>
                                                <input type="date" class="form-control" name="t_expired" id="t_expired" readonly value="{{ $product->tanggal_expired }}" placeholder="Masukkan tanggal expired">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        {{-- <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="h_beli" class="form-label">Harga beli <strong>(Rp.)</strong></label>
                                                <input type="text" class="form-control" name="h_beli" id="h_beli" readonly required value="{{ $product->harga_beli }}" placeholder="Masukkan nominal harga beli">
                                            </div>
                                        </div> --}}
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="h_jual" class="form-label">Harga jual <strong>(Rp.)</strong></label>
                                                <input type="text" class="form-control" name="h_jual" id="h_jual" readonly required value="{{ $product->harga_jual }}" placeholder="Masukkan nominal harga jual">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                @php
                                                    $stokBarang = 0;
                                                    foreach (App\Models\ProductStock::where('id_batch_product', $product->id)->get() as $stock) {
                                                        $stokBarang+=$stock->stok;
                                                    }
                                                @endphp
                                                <label for="stok" class="form-label">Jumlah stok tersedia</label>
                                                <input type="text" class="form-control" name="stok" id="stok" readonly required value="{{ $stokBarang }}" placeholder="Masukkan jumlah stok">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-center"                                                                                                                                                                                                >
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="example-fileinput" class="form-label"></label>
                                                <img id="showImage" src="{{ !empty($product->photo) ? Storage::url('images/product/'.$product->photo) : asset('assets/images/blank_profile.png') }}" class="w-50 img-thumbnail" alt="profile-image">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <h4 class="header-title mb-3">Daftar Stock Barang</h4>
                                        
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Barcode</th>
                                            <th>Tanggal beli</th>
                                            <th>Tanggal Expired</th>
                                            <th>Harga Beli per piece</th>
                                            <th>Stok</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($stockList as $stok)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $stok->barcode }}</td>
                                                <td>{{ $stok->tanggal_beli }}</td>
                                                <td>{{ $stok->tanggal_expired }}</td>
                                                <td>{{ $stok->harga_beli }}</td>
                                                <td>{{ $stok->stok }}</td>
                                                <td>
                                                    <a href="">
                                                        <button title="Lihat barcode" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-barcode-scan"></span></button>&nbsp;
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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