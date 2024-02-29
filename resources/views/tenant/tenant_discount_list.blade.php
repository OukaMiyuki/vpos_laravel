<x-tenant-layout>
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
                        <h4 class="page-title">Data Diskon</h4>
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
                            <h4 class="header-title mb-3">Tabel Diskon&nbsp;&nbsp;&nbsp;<a href="{{ route('tenant.discount.add') }}"><button title="Tambah diskon baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan diskon baru</button></a></h4>
                        
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Action</th>
                                            <th>Nama Promo</th>
                                            <th>Nama Produk</th>
                                            <th>Minimal Beli</th>
                                            <th>Harga Minimum</th>
                                            <th>Diskon (%)</th>
                                            <th>Status</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($diskon as $diskon)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td>
                                                    <a href="">
                                                        <button title="Lihat detail produk" type="button" class="btn btn-primary rounded-pill waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
                                                    <a href="">
                                                        <button title="Edit data produk" type="button" class="btn btn-success rounded-pill waves-effect waves-light"><span class="mdi mdi-pencil"></span></button>&nbsp;
                                                    </a>
                                                    <a href="">
                                                        <button title="Hapus produk" type="button" class="btn btn-danger rounded-pill waves-effect waves-light"><span class="mdi mdi-trash-can"></span></button>
                                                    </a>
                                                </td>
                                                <td>{{ $diskon->name }}</td>
                                                <td>{{ $diskon->product_name }}</td>
                                                <td>{{ $diskon->qty_amount }}</td>
                                                <td>{{ $diskon->price_amount }}</td>
                                                <td>{{ $diskon->discount }}</td>
                                                <td>
                                                    @if ($diskon->is_active == 0)
                                                        <span class="badge bg-soft-danger text-danger">Tidak AKtif</span>
                                                    @elseif($diskon->is_active == 1)
                                                        <span class="badge bg-soft-success text-success">AKtif</span>
                                                    @endif
                                                </td>
                                                <td>{{ $diskon->start_date }}</td>
                                                <td>{{ $diskon->end_date }}</td>
                                                <td>{{ $diskon->keterangan }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</x-tenant-layout>