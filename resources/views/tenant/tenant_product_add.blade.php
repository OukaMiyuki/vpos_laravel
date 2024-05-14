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
                                <li class="breadcrumb-item active">Tambah</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Tambah produk baru</h4>
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
                                <form method="post" action="{{ route('tenant.product.batch.insert') }}" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Product</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="p_name" class="form-label">Product Name</label>
                                                <input type="text" class="form-control" name="p_name" id="p_name" required value="{{ old('p_name') }}" placeholder="Masukkan nama produk">
                                            </div>
                                        </div>
                                        @php
                                            $store = App\Models\StoreDetail::select(['store_identifier'])
                                                                ->where('id_tenant', auth()->user()->id)
                                                                ->where('email', auth()->user()->email)
                                                                ->first();
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category</label>
                                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                                    <option value="">- Pilih Kategori Barang -</option>
                                                    @foreach (App\Models\ProductCategory::where('store_identifier', $store->store_identifier)->latest()->get() as $cat)
                                                        <option value="{{ $cat->id }}"@if (old('category') == $cat->id) selected="selected" @endif>{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="batch" class="form-label">Batch ID</label>
                                                <select class="form-select @error('batch') is-invalid @enderror" id="batch" name="batch" required>
                                                    <option value="">- Pilih Batch ID -</option>
                                                    @foreach (App\Models\Batch::where('store_identifier', $store->store_identifier)->latest()->get() as $batch)
                                                        <option value="{{ $batch->id }}"@if (old('batch') == $batch->id) selected="selected" @endif>{{ $batch->batch_code }} -  {{ $batch->keterangan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="supplier" class="form-label">Supplier</label>
                                                <select class="form-select @error('supplier') is-invalid @enderror" id="supplier" name="supplier" required>
                                                    <option value="">- Pilih Supplier -</option>
                                                    @foreach (App\Models\Supplier::where('store_identifier', $store->store_identifier)->latest()->get() as $sup)
                                                        <option value="{{ $sup->id }}"@if (old('supplier') == $sup->id) selected="selected" @endif>{{ $sup->nama_supplier }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gudang" class="form-label">Nomor Gudang (Opsional)</label>
                                                <input type="text" class="form-control" name="gudang" id="gudang" value="{{ old('gudang') }}" placeholder="Masukkan nomor gudang">
                                                <small id="emailHelp" class="form-text text-muted">Tidak wajib diisi atau boleh dikosongi</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="rak" class="form-label">Nomor Rak (Opsional)</label>
                                                <input type="text" class="form-control" name="rak" id="rak" value="{{ old('rak') }}" placeholder="Masukkan nomor rak">
                                                <small id="emailHelp" class="form-text text-muted">Tidak wajib diisi atau boleh dikosongi</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="h_jual" class="form-label">Harga jual <strong>(Rp.)</strong></label>
                                                <input type="number" class="form-control" name="h_jual" id="h_jual" required value="{{ old('h_jual') }}" placeholder="Masukkan nominal harga jual">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Upload Foto Product</label>
                                                <input type="file" required id="image" class="form-control" name="photo" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="example-fileinput" class="form-label"></label>
                                                <img id="showImage" src="{{ asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
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