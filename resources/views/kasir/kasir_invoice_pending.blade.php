<x-kasir-layout>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex align-items-center mb-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control border-0" id="dash-daterange">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                    <i class="mdi mdi-calendar-range"></i>
                                    </span>
                                </div>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-2">
                                <i class="mdi mdi-autorenew"></i>
                                </a>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-1">
                                <i class="mdi mdi-filter-variant"></i>
                                </a>
                            </form>
                        </div>
                        <h4 class="page-title">Pending Transaction</h4>
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
                            <h4 class="header-title mb-3">Tabel Transaction List&nbsp;&nbsp;&nbsp;<a href="{{ route('kasir.pos') }}"><button title="Tambah transaksi baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan Transaksi Baru</button></a</h4>
                            <div class="table-responsive">
                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Invoice</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($supplier as $supply)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>{{ $supply->nama_supplier }}</td>
                                                <td>{{ $supply->email_supplier }}</td>
                                                <td>{{ $supply->phone_supplier }}</td>
                                                <td>
                                                    <a href="" id="detailsupplier" data-id="{{ $supply->id }}" data-nama="{{ $supply->nama_supplier }}" data-email="{{ $supply->email_supplier }}" data-phone="{{ $supply->phone_supplier }}" data-alamat="{{ $supply->alamat_supplier }}" data-keterangan="{{ $supply->keterangan }}" data-bs-toggle="modal" data-bs-target="#modaldetailsupplier">
                                                        <button title="Lihat data supplier" type="button" class="btn btn-primary rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
                                                    <a href="" id="editsupplier" data-id="{{ $supply->id }}" data-nama="{{ $supply->nama_supplier }}" data-email="{{ $supply->email_supplier }}" data-phone="{{ $supply->phone_supplier }}" data-alamat="{{ $supply->alamat_supplier }}" data-keterangan="{{ $supply->keterangan }}" data-bs-toggle="modal" data-bs-target="#modaleditsupplier">
                                                        <button title="Edit data supplier" type="button" class="btn btn-success rounded-pill waves-effect waves-light"><span class="mdi mdi-pencil"></span></button>&nbsp;
                                                    </a>
                                                    <a href="{{ route('tenant.supplier.delete', ['id' => $supply->id]) }}">
                                                        <button title="Hapus data supplier" type="button" class="btn btn-danger rounded-pill waves-effect waves-light"><span class="mdi mdi-trash-can"></span></button>
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
</x-kasir-layout>