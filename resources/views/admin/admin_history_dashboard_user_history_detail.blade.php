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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.history') }}">History</a></li>
                                <li class="breadcrumb-item active">Detail</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Detail Activity : {{ $historyType }} at {{\Carbon\Carbon::parse($history->created_at)->format('d-m-Y H:i:s') }}</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg">
                                <li class="nav-item">
                                    <a href="#settings" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Detail Activity User
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> User Activity</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama User</label>
                                                <input readonly type="text" class="form-control" name="name" id="name" required @if(is_null($user) || empty($user) || $user == "" || $user == NULL) value="Syetem Report" @else value="{{ $user->name }}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input readonly type="email" class="form-control" name="email" id="email" required @if(is_null($user) || empty($user) || $user == "" || $user == NULL) value="Syetem Report" @else value="{{ $user->email }}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="access" class="form-label">Access Level</label>
                                                <input readonly type="text" class="form-control" name="access" id="access" required @if(is_null($userType) || empty($userType) || $userType == "" || $userType == NULL) value="System" @else value="{{ $userType }}" @endif>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="action" class="form-label">Activity</label>
                                                <input readonly type="text" class="form-control" name="action" id="action" required value="{{ $history->action }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="location" class="form-label">User Location</label>
                                                <input readonly type="text" class="form-control" name="location" id="location" required value="{{ $history->lokasi_anda }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="ip" class="form-label">Deteksi IP</label>
                                                <input readonly type="text" class="form-control" name="ip" id="ip" required value="{{ $history->deteksi_ip }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status_activity" class="form-label">Activity Status</label>
                                                <input readonly type="text" class="form-control" name="status_activity" id="status_activity" required @if($history->status == 0)  value="Failed" @else value="Success" @endif>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="log" class="form-label">Activity Log</label>
                                                <textarea readonly class="form-control" id="log" name="log" rows="5" spellcheck="false" required>{!! $history->log !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab-content -->
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

</x-admin-layout>
