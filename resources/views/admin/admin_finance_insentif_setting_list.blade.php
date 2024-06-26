<x-admin-layout>

    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="">Insentif Setting</a></li>
                                </ol>
                            </div>
                            <h4 class="page-title">Daftar Biaya Insentif Transfer</h4>
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
                                    <a href="" class="dropdown-item">Lihat Semua Data</a>
                                </div>
                            </div>
                            <h4 class="header-title mb-3">Insentif List&nbsp;&nbsp;&nbsp;<button data-bs-toggle="modal" data-bs-target="#add-insentif" title="Tambah insentif baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan Insentif</button></h4>
                            <div class="row">
                                <div class="col-6">
                                    
                                </div>
                                <div class="col-6 text-end">
                                    <h3 class="mb-3"><span>Total Insentif : </span>Rp. {{$totalInsentif}}</h3>
                                </div>
                            </div>
                            <div class="responsive-table-plugin">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="scroll-horizontal-table" class="table w-100 nowrap">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Jenis Insentif</th>
                                                    <th class="text-center">Nominal (Rp.)</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $no=0;
                                            @endphp
                                            <tbody>
                                                @foreach($insentifTransfer as $tf)
                                                    <tr>
                                                        <td>{{$no+=1}}</td>
                                                        <td>{{$tf->jenis_insentif}}</td>
                                                        <td class="text-center">{{$tf->nominal}}</td>
                                                        <td class="text-center">
                                                            <a href="" title="Edit data insentif" id="edit-data-insentif" data-id="{{ $tf->id }}" data-jenis_insentif="{{ $tf->jenis_insentif }}" data-nominal="{{ $tf->nominal }}" data-bs-toggle="modal" data-bs-target="#edit-insentif" class="btn btn-xs btn-info"><i class="mdi mdi-pencil"></i></a>
                                                            <a href="{{ route('admin.dashboard.finance.insentif.delete', ['id' => $tf->id]) }}" title="Hapus data insentif" class="btn btn-xs btn-danger"><i class="mdi mdi-trash-can"></i></a>
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
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
    <div class="modal fade" id="add-insentif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Insentif Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('admin.dashboard.finance.insentif.insert') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Insentif</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required value="{{ old('name') }}" placeholder="Masukkan nama Insentif">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="nominal_insentif" class="form-label">Nominal</label>
                                    <input type="text" class="form-control @error('nominal_insentif') is-invalid @enderror" name="nominal_insentif" id="nominal_insentif" required value="{{ old('nominal_insentif') }}" placeholder="Masukkan nominal insentif">
                                    @error('nominal_insentif')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-insentif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Insentif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('admin.dashboard.finance.insentif.update') }}" method="post">
                    @csrf
                    <div class="modal-body" id="show">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Insentif</label>
                                    <input type="hidden" class="d-none @error('id') is-invalid @enderror" name="id" id="id" required value="{{ old('id') }}">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required value="{{ old('name') }}" placeholder="Masukkan nama Insentif">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="nominal_insentif" class="form-label">Nominal</label>
                                    <input type="text" class="form-control @error('nominal_insentif') is-invalid @enderror" name="nominal_insentif" id="nominal_insentif" required value="{{ old('nominal_insentif') }}" placeholder="Masukkan nominal insentif">
                                    @error('nominal_insentif')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
