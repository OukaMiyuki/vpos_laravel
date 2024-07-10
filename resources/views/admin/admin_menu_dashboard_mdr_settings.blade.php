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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.menu') }}">Admin Menu</a></li>
                                    <li class="breadcrumb-item active">Kategori MDR</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Daftar Kategori MDR Merchant</h4>
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
                            <h4 class="header-title mb-3">Tabel Daftar Kategori MDR&nbsp;&nbsp;&nbsp;<button data-bs-toggle="modal" data-bs-target="#add-mdr" title="Tambah tanggal libur settlement" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan Kategori</button></h4></h4>
                            <div class="responsive-table-plugin">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="scroll-horizontal-table" class="table w-100 nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="2%">No.</th>
                                                    <th>Jenis Usaha</th>
                                                    <th class="text-center">Presentase Minimal MDR (%)</th>
                                                    <th class="text-center">Presentase Maksimal MDR (%)</th>
                                                    <th>Batas Nominal Transaksi Minimal (Rp.)</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $no=0;
                                            @endphp
                                            <tbody>
                                                @foreach ($mdr as $mdr)
                                                    <tr>
                                                        <td>{{$no+=1}}</td>
                                                        <td>{{$mdr->jenis_usaha}}</td>
                                                        <td class="text-center">{{$mdr->presentase_minimal_mdr}}</td>
                                                        <td class="text-center">{{$mdr->presentase_maksimal_mdr}}</td>
                                                        <td>@currency($mdr->nominal_minimal_mdr)</td>
                                                        <td class="text-center">
                                                            <a href="" title="Edit data mdr" id="edit-mdr" data-id="{{$mdr->id}}" data-jenis="{{$mdr->jenis_usaha}}" data-min_mdr="{{$mdr->presentase_minimal_mdr}}" data-max_mdr="{{$mdr->presentase_maksimal_mdr}}" data-nominal="{{$mdr->nominal_minimal_mdr}}" data-ketentuan="{{$mdr->ketentuan}}" data-bs-toggle="modal" data-bs-target="#edit-kategori-mdr" class="btn btn-xs btn-primary"><i class="mdi mdi-pencil"></i></a>
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
    <div class="modal fade" id="add-mdr" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Kategori MDR Usaha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('admin.dashboard.menu.mdr.insert') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="jenis" class="form-label">Kategori Usaha berdasarkan Omzet</label>
                                    <input type="text" class="form-control" name="jenis" id="jenis" required value="" placeholder="Masukkan jenis kategori usaha">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="presentase_minimal" class="form-label">Presentase Minimal MDR (%)</label>
                                    <input type="text" class="form-control" name="presentase_minimal" id="presentase_minimal" required value="" placeholder="Masukkan presentase minimal mdr">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="presentase_maksimal" class="form-label">Presentase Maksimal MDR (%)</label>
                                    <input type="text" class="form-control" name="presentase_maksimal" id="presentase_maksimal" required value="" placeholder="Masukkan presentase maksimal mdr">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="batas_nominal" class="form-label">Ketentuan Batas Nominal Transaksi (Rp.)</label>
                                    <input type="text" class="form-control" name="batas_nominal" id="batas_nominal" required value="" placeholder="Masukkan ketentuan batas nominal transaksi">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="ketentuan" class="form-label">Ketentuan</label>
                                    <textarea required placeholder="Masukkan ketentuan mdr" class="form-control" id="ketentuan" name="ketentuan" rows="5" spellcheck="false"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Insert Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-kategori-mdr" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Kategori MDR Usaha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{route('admin.dashboard.menu.mdr.update')}}" method="post">
                    @csrf
                    <div class="modal-body" id="show">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="jenis" class="form-label">Kategori Usaha berdasarkan Omzet</label>
                                    <input type="hidden" class="d-none" name="id" id="id">
                                    <input type="text" class="form-control" name="jenis" id="jenis" required value="" placeholder="Masukkan jenis kategori usaha">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="presentase_minimal" class="form-label">Presentase Minimal MDR (%)</label>
                                    <input type="text" class="form-control" name="presentase_minimal" id="presentase_minimal" required value="" placeholder="Masukkan presentase minimal mdr">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="presentase_maksimal" class="form-label">Presentase Maksimal MDR (%)</label>
                                    <input type="text" class="form-control" name="presentase_maksimal" id="presentase_maksimal" required value="" placeholder="Masukkan presentase maksimal mdr">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="batas_nominal" class="form-label">Ketentuan Batas Nominal Transaksi (Rp.)</label>
                                    <input type="text" class="form-control" name="batas_nominal" id="batas_nominal" required value="" placeholder="Masukkan ketentuan batas nominal transaksi">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="ketentuan" class="form-label">Ketentuan</label>
                                    <textarea required placeholder="Masukkan ketentuan mdr" class="form-control" id="ketentuan" name="ketentuan" rows="5" spellcheck="false"></textarea>
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
