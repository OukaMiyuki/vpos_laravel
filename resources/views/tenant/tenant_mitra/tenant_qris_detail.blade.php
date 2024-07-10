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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko') }}">Umi</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.toko.request.umi.list') }}">Qris Account Request List</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Request Akun Qris</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4 text-uppercase mt-3"><i class="mdi mdi-account-circle me-1"></i> Detail Informasi Akun Qris</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Qris Login User</label>
                                        <input type="text" class="form-control" readonly name="login-user" id="login-user" required value="{{ $tenantQris->qris_login_user }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="no_telp" class="form-label">Qris Password</label>
                                        <input type="text" class="form-control" readonly name="qpassword" id="qpassword" required value="{{ $tenantQris->qris_password }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="jenis" class="form-label">Qris Merchant ID</label>
                                        <input type="text" class="form-control" readonly name="mcrid" id="mcrid" required value="{{ $tenantQris->qris_merchant_id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="jenis" class="form-label">Qris Store ID</label>
                                        <input type="text" class="form-control" readonly name="storeid" id="storeid" required value="{{ $tenantQris->qris_store_id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="kabupaten" class="form-label">MDR (%)</label>
                                        <input readonly type="text" class="form-control" name="mdr" id="mdr" readonlyrequired value="{{ $tenantQris->mdr }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-tenant-layout>