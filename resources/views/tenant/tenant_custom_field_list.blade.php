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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.store.management') }}">Store Management</a></li>
                                <li class="breadcrumb-item active">Custom Field</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Custom Field Modifcation</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <!-- end col-->
                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <form method="post" action="{{ route('tenant.customField.modify.insert') }}">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Modify Data</h5>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="mb-3">
                                                <label for="baris1" class="form-label">Baris Pertama</label>
                                                <input type="hidden" class="form-control" name="id" id="id" value="@if(!empty( $customField->id)){{$customField->id}}@endif">
                                                <input type="text" class="form-control" name="baris1" id="baris1" value="@if(!empty( $customField->baris1)){{$customField->baris1}}@endif" placeholder="Masukkan nama baris pertama">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="aktivasi_baris_1" class="form-label">Status</label>
                                                <select class="form-select @error('aktivasi_baris_1') is-invalid @enderror" id="aktivasi_baris_1" name="aktivasi_baris_1">
                                                    <option value="">- Pilih Status -</option>
                                                    <option @if(!empty($customField->id)) @if($customField->baris_1_activation == "1") selected @endif @endif value="1">Aktif</option>
                                                    <option @if(!empty($customField->id)) @if($customField->baris_1_activation == "0") selected @endif @endif value="0">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="mb-3">
                                                <label for="baris2" class="form-label">Baris Kedua</label>
                                                <input type="text" class="form-control" name="baris2" id="baris2" value="@if(!empty( $customField->baris2)){{$customField->baris2}}@endif" placeholder="Masukkan nama baris kedua">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="aktivasi_baris_2" class="form-label">Status</label>
                                                <select class="form-select @error('aktivasi_baris_2') is-invalid @enderror" id="aktivasi_baris_2" name="aktivasi_baris_2">
                                                    <option value="">- Pilih Status -</option>
                                                    <option @if(!empty($customField->id)) @if($customField->baris_2_activation == "1") selected @endif @endif value="1">Aktif</option>
                                                    <option @if(!empty($customField->id)) @if($customField->baris_2_activation == "0") selected @endif @endif value="0">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="mb-3">
                                                <label for="baris3" class="form-label">Baris Ketiga</label>
                                                <input type="text" class="form-control" name="baris3" id="baris3" value="@if(!empty($customField->baris3)){{$customField->baris3}}@endif" placeholder="Masukkan nama baris ketiga">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="aktivasi_baris_3" class="form-label">Status</label>
                                                <select class="form-select @error('aktivasi_baris_3') is-invalid @enderror" id="aktivasi_baris_3" name="aktivasi_baris_3">
                                                    <option value="">- Pilih Status -</option>
                                                    <option @if(!empty($customField->id)) @if($customField->baris_3_activation == "1") selected @endif @endif value="1">Aktif</option>
                                                    <option @if(!empty($customField->id)) @if($customField->baris_3_activation == "0") selected @endif @endif value="0">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="mb-3">
                                                <label for="baris4" class="form-label">Baris Keempat</label>
                                                <input type="text" class="form-control" name="baris4" id="baris4" value="@if(!empty($customField->baris4)){{$customField->baris4}}@endif" placeholder="Masukkan nama baris keempat">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="aktivasi_baris_4" class="form-label">Status</label>
                                                <select class="form-select @error('aktivasi_baris_4') is-invalid @enderror" id="aktivasi_baris_4" name="aktivasi_baris_4">
                                                    <option value="">- Pilih Status -</option>
                                                    <option @if(!empty($customField->id)) @if($customField->baris_4_activation == "1") selected @endif @endif value="1">Aktif</option>
                                                    <option @if(!empty($customField->id)) @if($customField->baris_4_activation == "0") selected @endif @endif value="0">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="mb-3">
                                                <label for="baris5" class="form-label">Baris Kelima</label>
                                                <input type="text" class="form-control" name="baris5" id="baris5" value="@if(!empty($customField->baris5)){{$customField->baris5}}@endif" placeholder="Masukkan nama baris kelima">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label for="aktivasi_baris_5" class="form-label">Status</label>
                                                <select class="form-select @error('aktivasi_baris_5') is-invalid @enderror" id="aktivasi_baris_5" name="aktivasi_baris_5">
                                                    <option value="">- Pilih Status -</option>
                                                    <option @if(!empty($customField->id)) @if($customField->baris_5_activation == "1") selected @endif @endif value="1">Aktif</option>
                                                    <option @if(!empty($customField->id)) @if($customField->baris_5_activation == "0") selected @endif @endif value="0">Tidak Aktif</option>
                                                </select>
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