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
                                    <li class="breadcrumb-item"><a href="">Settlement Setting</a></li>
                                </ol>
                            </div>
                            <h4 class="page-title">Daftar Pengaturan Tanggal Settlement</h4>
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
                            <h4 class="header-title mb-3">Settlement Holiday List&nbsp;&nbsp;&nbsp;<button data-bs-toggle="modal" data-bs-target="#add-holiday" title="Tambah tanggal libur settlement" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan Tanggal</button></h4></h4>
                            <div class="responsive-table-plugin">
                                <div class="table-rep-plugin">
                                    <div class="table-responsive" data-pattern="priority-columns">
                                        <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="2%">No.</th>
                                                    <th class="text-center">Start Date</th>
                                                    <th class="text-center">End Date</th>
                                                    <th class="text-center">Status</th>
                                                    <th>Note</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $no=0;
                                            @endphp
                                            <tbody>
                                                @foreach($settlementList as $stl)
                                                    <tr>
                                                        <td>{{$no+=1}}</td>
                                                        <td class="text-center">{{\Carbon\Carbon::parse($stl->stat_date)->format('d-m-Y')}}</td>
                                                        <td class="text-center">{{\Carbon\Carbon::parse($stl->end_date)->format('d-m-Y')}}</td>
                                                        <td class="text-center">
                                                            @php
                                                                $now = date('Y-m-d');
                                                                $now=date('Y-m-d', strtotime($now));
                                                                $startDate = date('Y-m-d', strtotime($stl->stat_date));
                                                                $endDate = date('Y-m-d', strtotime($stl->end_date));
                                                            @endphp
                                                            @if (($now >= $startDate) && ($now <= $endDate))
                                                                <span class="badge bg-soft-success text-success">Aktif</span>
                                                            @else
                                                                <span class="badge bg-soft-danger text-danger">Tidak Aktif</span>
                                                            @endif
                                                        </td>
                                                        <td>{{$stl->note}}</td>
                                                        <td class="text-center">
                                                            <a href="" title="Edit data settlement settings" id="edit-settlement" data-id="{{ $stl->id }}" data-start_date="{{ $stl->stat_date }}" data-end_date="{{ $stl->end_date }}" data-note="{{ $stl->note }}" data-bs-toggle="modal" data-bs-target="#edit-settlement-setting" class="btn btn-xs btn-primary"><i class="mdi mdi-pencil"></i></a>&nbsp;
                                                            <a href="{{ route('admin.dashboard.finance.settlement.delete', ['id' => $stl->id]) }}" class="btn btn-xs btn-danger"><i class="mdi mdi-trash-can"></i></a>
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
    <div class="modal fade" id="add-holiday" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Tanggal Libur Settlement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('admin.dashboard.finance.settlement.insert') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" required value="{{ old('start_date') }}" placeholder="Masukkan tanggal mulai">
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" required value="{{ old('end_date') }}" placeholder="Masukkan tanggal akhir">
                                    @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="note" class="form-label">Note (Opsional)</label>
                                    <textarea placeholder="Masukkan note" class="form-control" id="note" name="note" rows="5" spellcheck="false">{!! old('note') !!}</textarea>
                                    @error('end_date')
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
    <div class="modal fade" id="edit-settlement-setting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Tanggal Libur Settlement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('admin.dashboard.finance.settlement.update') }}" method="post">
                    @csrf
                    <div class="modal-body" id="show">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="hidden" class="d-none" name="id" id="id">
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" required value="{{ old('start_date') }}" placeholder="Masukkan tanggal mulai">
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" required value="{{ old('end_date') }}" placeholder="Masukkan tanggal akhir">
                                    @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="note" class="form-label">Note (Opsional)</label>
                                    <textarea placeholder="Masukkan note" class="form-control" id="note" name="note" rows="5" spellcheck="false">{!! old('note') !!}</textarea>
                                    @error('end_date')
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
