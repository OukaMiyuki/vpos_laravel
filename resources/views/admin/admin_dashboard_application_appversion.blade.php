<x-admin-layout>
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
                                <li class="breadcrumb-item active">App Version Setting</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Application Version</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.dashboard.application.appversion.update') }}" enctype="multipart/form-data">
                                @csrf
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Set Version</h5>
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" class="w-100 form-control @error('versi') is-invalid @enderror" name="versi" id="versi" required value="{{ $appversion->versi }}" placeholder="Masukkan versi aplikasi">
                                        @error('versi')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn w-100 btn-success waves-effect waves-light"><i class="mdi mdi-content-save"></i> Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if (!is_null($app->apk_link) || !empty($app->apk_link))
                <div class="col-xl-4 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title font-16 mb-3">File Uploaded</h5>
                            <div class="card mb-1 shadow-none border">
                                <div class="p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title badge-soft-success text-success rounded">
                                                    APK
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0">
                                            <a href="javascript:void(0);" class="text-muted fw-bold">{{$app->apk_link}}</a>
                                            <p class="mb-0 font-12">{{$app->file_size}}</p>
                                        </div>
                                        <div class="col-auto">
                                            <!-- Button -->
                                            <a href="{{route('admin.download.apk')}}" class="btn btn-link font-16 text-muted">
                                                <i class="dripicons-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <form method="post" action="{{ route('admin.dashboard.application.app.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Upload App</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="app" class="form-label">Upload APK File</label>
                                                <input required type="file" class="form-control" name="app">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-content-save"></i> Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-admin-layout>