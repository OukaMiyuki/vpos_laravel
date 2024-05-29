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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.mitra.dashboard.app') }}">Application</a></li>
                                <li class="breadcrumb-item active">API Settings</li>
                            </ol>
                        </div>
                        <h4 class="page-title">API Settings</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="api_key" class="form-label">API Key</label>
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="text" readonly class="form-control" name="api_key" id="api_key" required @if(!is_null($apiKey) || !empty($apiKey)) value={{ $apiKey->true_key }} @endif placeholder="Masukkan api key">
                                            </div>
                                            <div class="col-4">
                                                <form method="post" action="{{ route('tenant.mitra.dashboard.app.setting.generateKey') }}">
                                                    @csrf
                                                    <button type="submit" class="w-100 btn btn-success waves-effect waves-light"><i class="mdi mdi-email-outline"></i> Generate API Key</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="{{ route('tenant.mitra.dashboard.app.setting.updateCallback') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="callback" class="form-label">Callback</label>
                                                    <input type="text" class="form-control" name="callback" id="callback" required @if(!is_null($callback) || !empty($callback)) value="{{ $callback->callback }}" @endif placeholder="Masukkan callback link">
                                                    <small id="emailHelp" class="form-text text-muted"><strong>Contoh : https://example.com/update_invoice</strong></small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="parameter" class="form-label">Parameter Callback</label>
                                                    <input type="text" class="form-control" name="parameter" id="parameter" required @if(!is_null($callback) || !empty($callback)) value="{{ $callback->parameter }}" @endif placeholder="Masukkan parameter callback">
                                                    <small id="emailHelp" class="form-text text-muted"><strong>Tidak boleh ada spasi Contoh : nomor_invoice</strong></small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="secret_key_parameter" class="form-label">Secret Key Callback</label>
                                                    <input type="text" class="form-control" name="secret_key_parameter" id="secret_key_parameter" required @if(!is_null($callback) || !empty($callback)) value="{{ $callback->secret_key_parameter }}" @endif placeholder="Masukkan parameter secret key">
                                                    <small id="emailHelp" class="form-text text-muted"><strong>Tidak boleh ada spasi Contoh : secret_key</strong></small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="secret_key" class="form-label">Callback Secret Key</label>
                                                    <input type="text" class="form-control" name="secret_key" id="secret_key" required @if(!is_null($callback) || !empty($callback)) value="{{ $callback->secret_key }}" @endif placeholder="Masukkan secret key">
                                                    <small id="emailHelp" class="form-text text-muted"><strong>Input String Secret Key</strong></small>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="w-100 btn btn-success waves-effect waves-light"><i class="mdi mdi-email-outline"></i> Register Callback</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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