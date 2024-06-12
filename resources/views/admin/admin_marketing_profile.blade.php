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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.marketing') }}">Mitra Aplikasi</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.marketing.list') }}">Mitra List</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Mitra Aplikasi User's Profile</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="{{ !empty($marketing->detail->photo) ? Storage::url('images/profile/'.$marketing->detail->photo) : asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            <h4 class="mb-0">
                                {{ $marketing->name }}
                            </h4>
                            <p class="text-muted">
                                Mitra Aplikasi
                            </p>
                            @if($marketing->is_active == 1)
                                <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Aktif</button>
                            @else
                                <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Tidak Aktif</button>
                            @endif
                            <div class="text-start mt-3">
                                <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ms-2">{{ $marketing->phone }}&nbsp;@if(!is_null($marketing->phone_number_verified_at) || !empty($marketing->phone_number_verified_at) || $marketing->phone_number_verified_at != "" || $marketing->phone_number_verified_at != NULL) </span><span class="text-success mdi mdi-check-decagram-outline"></span> @else <span class="text-warning mdi mdi-clock-outline"></span> @endif</p>
                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2">{{ $marketing->email }}&nbsp;@if(!is_null($marketing->email_verified_at) || !empty($marketing->email_verified_at) || $marketing->email_verified_at != "" || $marketing->email_verified_at != NULL) </span><span class="text-success mdi mdi-check-decagram-outline"></span> @else <span class="text-warning mdi mdi-clock-outline"></span> @endif</p>
                                <p class="text-muted mb-2 font-13"><strong>Bergabung Pada :</strong> <span class="ms-2">{{ \Carbon\Carbon::parse($marketing->created_at)->format('d-m-Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col-->
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg">
                                <li class="nav-item">
                                    <a href="#settings" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Account Settings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#aboutme" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        Detail Information
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#invcode" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        Invitation Codes
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    <form method="post">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Modify Account</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Lengkap</label>
                                                    <input readonly type="hidden" class="form-control" name="id" id="id" required value="{{ $marketing->id }}">
                                                    <input readonly type="text" class="form-control" name="name" id="name" required value="{{ $marketing->name }}" placeholder="Masukkan nama lengkap">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input readonly type="email" class="form-control" name="email" id="email" required value="{{ $marketing->email }}" placeholder="Masukkan email akun">
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        {{-- end row --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone Number</label>
                                                    <input readonly type="text" class="form-control" name="phone" id="phone" required value="{{ $marketing->phone }}" placeholder="Enter email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="example-select" class="form-label">Status Akun</label>
                                                    <select disabled class="form-select" id="example-select" name="status" required>
                                                        <option value="">- Pilih status akun -</option>
                                                        <option @if($marketing->is_active == 0) selected  @endif value="0">Belum Aktif</option>
                                                        <option @if($marketing->is_active == 1) selected  @endif value="1">Aktif</option>
                                                        <option @if($marketing->is_active == 2) selected  @endif value="1">Non-Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="aboutme">
                                    <form method="post" enctype="multipart/form-data">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Update Informasi User</h5>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="no_ktp" class="form-label">Nomor KTP</label>
                                                    <input readonly type="hidden" class="form-control" name="id" id="id" required value="{{ $marketing->detail->id }}">
                                                    <input type="text" class="form-control" name="no_ktp" id="no_ktp" required value="{{ $marketing->detail->no_ktp }}" placeholder="Masukkan nomor KTP">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                                    <input readonly type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" required value="{{ $marketing->detail->tempat_lahir }}" placeholder="Masukkan tempat lahir">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                    <input readonly type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ $marketing->detail->tanggal_lahir }}" placeholder="Masukkan tanggal lahir" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                    <select disabled class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                                        <option value="">- Pilih jenis kelamin -</option>
                                                        <option @if($marketing->detail->jenis_kelamin == "Laki-laki") selected @endif value="Laki-laki">Laki-laki</option>
                                                        <option @if($marketing->detail->jenis_kelamin == "Perempuan") selected @endif value="Perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <textarea readonly placeholder="Masukkan alamat anda" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! $marketing->detail->alamat !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="invcode">
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-qrcode me-1"></i> Invitation Code List</h5>
                                    <div class="responsive-table-plugin">
                                        <div class="table-rep-plugin">
                                            <div class="table-responsive" data-pattern="priority-columns">
                                                <table id="inv_table_marketing_profile" class="table dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Invitation Code</th>
                                                            <th>Holder</th>
                                                            <th>Created</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Attempt</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    @php
                                                        $no=0;
                                                    @endphp
                                                    <tbody>
                                                        @foreach ($marketing->invitationCode as $invitation)
                                                            <tr>
                                                                <td>{{ $no+=1 }}</td>
                                                                <td>{{ $invitation->inv_code }}</td>
                                                                <td>{{ $invitation->holder }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($invitation->created_at)->format('d-m-Y') }}</td>
                                                                <td class="text-center">
                                                                    @if ($invitation->is_active == 0)
                                                                        <span class="badge bg-soft-warning text-danger">Non Aktif</span>
                                                                    @elseif($invitation->is_active == 1)
                                                                        <span class="badge bg-soft-success text-success">Aktif</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">{{ $invitation->tenant->count() }}</td>
                                                                <td class="text-center">
                                                                    @if ($invitation->is_active == 1)
                                                                        <a href="{{ route('admin.dashboard.marketing.invitationcode.activation', ['id' => $invitation->id]) }}" class="btn btn-xs btn-danger"><i class="mdi mdi-power"></i></a>
                                                                    @else
                                                                        <a href="{{ route('admin.dashboard.marketing.invitationcode.activation', ['id' => $invitation->id]) }}" class="btn btn-xs btn-success"><i class="mdi mdi-power"></i></a>
                                                                    @endif
                                                                    <a href="" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
