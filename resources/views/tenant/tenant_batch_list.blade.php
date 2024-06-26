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
                                <li class="breadcrumb-item"><a href="{{ route('tenant.toko') }}">Toko</a></li>
                                <li class="breadcrumb-item active">Batch Code</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Kode Batch Barang</h4>
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
                            <h4 class="header-title mb-3">Tabel Batch List&nbsp;&nbsp;&nbsp;<button data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="Tambah kode baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambah Batch Baru</button></h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th width="20">No.</th>
                                            <th width="50">Nama</th>
                                            <th>Keterangan</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($batch as $batch)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $batch->batch_code  }}</td>
                                                <td>{{ $batch->keterangan  }}</td>
                                                <td class="text-center">
                                                    <a href="" id="editbatch" data-id="{{ $batch->id }}" data-kode="{{ $batch->batch_code }}"  data-keterangan="{{ $batch->keterangan }}" data-bs-toggle="modal" data-bs-target="#modaleditsupplier">
                                                        <button title="Lihat data kasir" type="button" class="btn btn-success btn-xs waves-effect waves-light"><span class="mdi mdi-pencil"></span></button>&nbsp;
                                                    </a>
                                                    <a href="{{ route('tenant.batch.delete', ['id' => $batch->id]) }}">
                                                        <button title="Hapus data supplier" type="button" class="btn btn-danger btn-xs waves-effect waves-light"><span class="mdi mdi-trash-can"></span></button>
                                                    </a>
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
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Batch Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('tenant.batch.insert') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Batch Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required value="{{ old('name') }}" placeholder="Masukkan nama batch">
                                    <small id="emailHelp" class="form-text text-muted">Isi dengan kode unik untuk product contoh : Produk Mie Goreng isi dengan MGR</small>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea placeholder="Masukkan keterangan" class="form-control" id="keterangan" name="keterangan" rows="5" spellcheck="false" required>{!! old('keterangan') !!}</textarea>
                                    <small id="emailHelp" class="form-text text-muted">Isi dengan keterangan dari kode diatas contoh : kode MGR isi dengan Kode Produk untuk Mie Goreng</small>
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

    <div class="modal fade" id="modaleditsupplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Batch Name Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('tenant.batch.update') }}" method="POST">
                    @csrf
                    <div class="modal-body" id="show">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Batch Name</label>
                                    <input type="hidden" readonly class="form-control @error('id') is-invalid @enderror" name="id" id="id" required value="{{ old('id') }}">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required value="{{ old('name') }}" placeholder="Masukkan nama batch">
                                    <small id="emailHelp" class="form-text text-muted">Isi dengan kode unik untuk product contoh : Produk Mie Goreng isi dengan MGR</small>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea placeholder="Masukkan keterangan" class="form-control" id="keterangan" name="keterangan" rows="5" spellcheck="false" required>{!! old('keterangan') !!}</textarea>
                                    <small id="emailHelp" class="form-text text-muted">Isi dengan keterangan dari kode diatas contoh : kode MGR isi dengan Produk Mie Goreng</small>
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
</x-tenant-layout>