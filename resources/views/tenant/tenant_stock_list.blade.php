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
                        <h4 class="page-title">Data Stock & Barcode Barang</h4>
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
                            <h4 class="header-title mb-3">Tabel Product List&nbsp;&nbsp;&nbsp;<a href="{{ route('tenant.product.stock.add') }}"><button title="Tambah barang baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan stok baru</button></a></h4>
                        
                            <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Action</th>
                                        <th>Photo</th>
                                        <th>Barcode</th>
                                        <th>Product Name</th>
                                        <th>Tanggal Beli</th>
                                        <th>Tanggal Expired</th>
                                        <th>Harga Beli (Rp.)</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no=0; @endphp
                                    @foreach($stock as $stok)
                                        <tr>
                                            <td>{{ $no+=1 }}</td>
                                            <td>
                                                <a href="">
                                                    <button title="Lihat barcode" type="button" class="btn btn-info rounded-pill waves-effect waves-light"><span class="mdi mdi-barcode-scan"></span></button>&nbsp;
                                                </a>
                                                <a href="{{ route('tenant.product.stock.edit', ['id' => $stok->id]) }}">
                                                    <button title="Edit data stok" type="button" class="btn btn-success rounded-pill waves-effect waves-light"><span class="mdi mdi-pencil"></span></button>&nbsp;
                                                </a>
                                                <a href="{{ route('tenant.product.stock.delete', ['id' => $stok->id]) }}">
                                                    <button title="Hapus produk" type="button" class="btn btn-danger rounded-pill waves-effect waves-light"><span class="mdi mdi-trash-can"></span></button>
                                                </a>
                                            </td>
                                            <td>
                                                <img src="{{ !empty($stok->product->photo) ? Storage::url('images/product/'.$stok->product->photo) : asset('assets/images/blank_profile.png') }}" class="img-thumbnail" style="width:50px; height:40px;" alt="Product Photo">
                                            </td>
                                            <td>{{ $stok->barcode }}</td>
                                            <td>{{ $stok->product->product_name }}</td>
                                            <td>{{ $stok->tanggal_beli }}</td>
                                            <td>{{ $stok->tanggal_expired }}</td>
                                            <td>{{ $stok->harga_beli }}</td>
                                            <td>{{ $stok->stok }}</td>
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