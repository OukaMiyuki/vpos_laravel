<x-marketing-layout>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard.invitationcode') }}">Code</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('marketing.dashboard.tenant.list') }}">Data Tenant</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Profile</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="{{ !empty($tenant->storeDetail->store_photo) ? Storage::url('images/profile/'.$tenant->storeDetail->store_photo) : asset('assets/images/blank_profile.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            <h4 class="mb-0">
                                @if(!empty($tenant->storeDetail->store_name))
                                    {{ $tenant->storeDetail->store_name }}
                                @endif
                            </h4>
                            <p class="text-muted">
                                Toko
                            </p>
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
                                        Informasi Toko
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#about_tenant" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        Detail Infomasi Tenant
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    <form method="post">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Data Informasi Toko Tenant</h5>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Pemilik</label>
                                                    <input readonly type="text" class="form-control" name="name" id="name" required @if(!empty($tenant->name)) value="{{ $tenant->name }}" @endif placeholder="Masukkan nama toko">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="jenis" class="form-label">Jenis Usaha</label>
                                                    <input readonly type="text" class="form-control" name="jenis" id="jenis" required @if(!empty($tenant->storeDetail->jenis_usaha)) value="{{ $tenant->storeDetail->jenis_usaha }}" @endif placeholder="Masukkan jenis usaha">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat Toko</label>
                                                    <textarea readonly placeholder="Masukkan alamat anda" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>@if(!empty($tenant->storeDetail->store_alamat)) {!! $tenant->storeDetail->store_alamat !!} @endif</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="about_tenant">
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Data Informasi Pemilik Usaha</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control" name="name" id="name" readonly value="{{ $tenant->name }}" placeholder="Masukkan nama lengkap">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                                <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" readonly value="{{ $tenant->detail->tempat_lahir }}" placeholder="Masukkan tempat lahir">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ $tenant->detail->tanggal_lahir }}" placeholder="Masukkan tanggal lahir" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" readonly value="{{ $tenant->detail->jenis_kelamin }}" placeholder="Masukkan jenis kelamin">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat Pemilik Usaha</label>
                                                <textarea placeholder="Masukkan alamat anda" class="form-control" id="alamat" name="alamat" rows="5" spellcheck="false" required>{!! $tenant->detail->alamat !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="" class="dropdown-item">Cetak Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Tabel Data Penarikan Dana Tenant</h4>
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="mb-3"><span>Invitation Code : </span>{{ $tenant->invitationCode->inv_code }} - {{ $tenant->invitationCode->holder }}</h4>
                                </div>
                                <div class="col-6">
                                    <h4 class="mb-3 text-end"><span>Total Insentif : </span>Rp. @money($totalPenghasilan)</h4>
                                </div>
                            </div>
                            <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th class="text-center">Tanggal Penarikan</th>
                                        <th class="text-center">Nominal (Rp.)</th>
                                        <th class="text-center">Insentif Mitra (Rp.)</th>
                                        <th class="text-center">Status Penarikan</th>
                                    </tr>
                                </thead>
                                @php
                                    $no=0;
                                @endphp
                                <tbody>
                                    @foreach ($tenant->withdrawal as $wd)
                                        @foreach ($wd->detailWithdraw as $dtwd)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $tenant->name }}</td>
                                                <td class="text-center">{{\Carbon\Carbon::parse($wd->tanggal_penarikan)->format('d-m-Y')}}</td>
                                                <td class="text-center">@currency($wd->nominal)</td>
                                                <td class="text-center">@currency($dtwd->nominal)</td>
                                                <td class="text-center">
                                                    @if ($wd->status == 1)
                                                        <span class="badge bg-soft-success text-success">Sukses</span>
                                                    @endif
                                                </td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-marketing-layout>