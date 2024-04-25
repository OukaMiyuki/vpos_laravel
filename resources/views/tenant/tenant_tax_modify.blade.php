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
                                <li class="breadcrumb-item active">Tax Settings</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Ubah Pajak Pembelian</h4>
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
                                <form method="post" action="{{ route('tenant.pajak.modify.insert') }}">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Modify Tax</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="pajak" class="form-label">Pajak</label>
                                                <input type="hidden" class="form-control" name="id" id="id" value="@if(!empty( $tax->id)){{$tax->id}}@endif">
                                                <input required type="text" class="form-control" name="pajak" id="pajak" value="@if(!empty( $tax->pajak)){{$tax->pajak}}@endif" placeholder="Masukkan presentase pajak">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="" name="status" required>
                                                    <option value="">- Pilih status pajak -</option>
                                                    <option @if(!empty( $tax->is_active)) @if($tax->is_active == 0) selected  @endif @endif value="0">Non-Aktif</option>
                                                    <option @if(!empty( $tax->is_active)) @if($tax->is_active == 1) selected  @endif @endif value="1">Aktif</option>
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