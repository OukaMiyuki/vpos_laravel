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
                        <h4 class="page-title">Edit Data Produk</h4>
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
                                <form method="post" action="{{ route('tenant.product.batch.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Modify Account</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="p_name" class="form-label">Product Name</label>
                                                <input type="hidden" class="form-control" name="id" id="id" required value="{{ $product->id }}" readonly>
                                                <input type="text" class="form-control" name="p_name" id="p_name" required value="{{ $product->product_name }}" placeholder="Masukkan nama produk">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="batch" class="form-label">Batch ID</label>
                                                <select class="form-select @error('batch') is-invalid @enderror" id="batch" name="batch" required>
                                                    <option value="">- Pilih Batch ID -</option>
                                                    @foreach (App\Models\Batch::where('id_tenant', auth()->user()->id)->latest()->get() as $batch)
                                                        <option value="{{ $batch->id }}"@if ($product->id_batch == $batch->id) selected="selected" @endif>{{ $batch->batch_code }} -  {{ $batch->keterangan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="supplier" class="form-label">Supplier</label>
                                                <select class="form-select @error('supplier') is-invalid @enderror" id="supplier" name="supplier" required>
                                                    <option value="">- Pilih Supplier -</option>
                                                    @foreach (App\Models\Supplier::where('id_tenant', auth()->user()->id)->latest()->get() as $sup)
                                                        <option value="{{ $sup->id }}"@if ($product->id_supplier == $sup->id) selected="selected" @endif>{{ $sup->nama_supplier }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gudang" class="form-label">Nomor Gudang (Opsional)</label>
                                                <input type="text" class="form-control" name="gudang" id="gudang" value="{{ $product->nomor_gudang }}" placeholder="Masukkan nomor gudang">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="rak" class="form-label">Nomor Rak (Opsional)</label>
                                                <input type="text" class="form-control" name="rak" id="rak" value="{{ $product->nomor_rak }}" placeholder="Masukkan nomor rak">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="t_beli" class="form-label">Tanggal Beli</label>
                                                <input type="date" class="form-control" name="t_beli" id="t_beli" required value="{{ $product->tanggal_beli }}" placeholder="Masukkan tanggal beli">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="t_expired" class="form-label">Tanggal Expired (kosongi jika bukan peroduk makanan)</label>
                                                <input type="date" class="form-control" name="t_expired" id="t_expired" value="{{ $product->tanggal_expired }}" placeholder="Masukkan tanggal expired">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="h_beli" class="form-label">Harga beli <strong>(Rp.)</strong></label>
                                                <input type="text" class="form-control" name="h_beli" id="h_beli" required value="{{ $product->harga_beli }}" placeholder="Masukkan nominal harga beli">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="h_jual" class="form-label">Harga jual <strong>(Rp.)</strong></label>
                                                <input type="text" class="form-control" name="h_jual" id="h_jual" required value="{{ $product->harga_jual }}" placeholder="Masukkan nominal harga jual">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Upload Foto Product</label>
                                                <input type="file" id="image" class="form-control" name="photo" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="example-fileinput" class="form-label"></label>
                                                <img id="showImage" src="{{!empty($product->photo) ? Storage::url('images/product/'.$product->photo) : asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
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