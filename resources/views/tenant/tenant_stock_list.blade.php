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
                                <li class="breadcrumb-item active">Stock Product</li>
                            </ol>
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
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Photo</th>
                                        <th>Barcode</th>
                                        <th>Product Name</th>
                                        <th>Stok Barang</th>
                                        <th class="text-center">Tanggal Beli</th>
                                        <th class="text-center">Tanggal Expired</th>
                                        <th>Harga Beli (Rp.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $no=0; 
                                    @endphp
                                    @foreach($stock as $stok)
                                        <tr>
                                            <td>{{ $no+=1 }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('tenant.product.stock.barcode.show', ['id' => $stok->id]) }}">
                                                    <button title="Lihat barcode" type="button" class="btn btn-info btn-xs waves-effect waves-light"><span class="mdi mdi-barcode-scan"></span></button>&nbsp;
                                                </a>
                                                <a href="{{ route('tenant.product.stock.edit', ['id' => $stok->id]) }}">
                                                    <button title="Edit data stok" type="button" class="btn btn-success btn-xs waves-effect waves-light"><span class="mdi mdi-pencil"></span></button>&nbsp;
                                                </a>
                                                <a href="{{ route('tenant.product.stock.delete', ['id' => $stok->id]) }}">
                                                    <button title="Hapus produk" type="button" class="btn btn-danger btn-xs waves-effect waves-light"><span class="mdi mdi-trash-can"></span></button>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <img src="{{ !empty($stok->product->photo) ? Storage::url('images/product/'.$stok->product->photo) : asset('assets/images/blank_profile.png') }}" class="img-thumbnail" alt="Product Photo" width="80">
                                            </td>
                                            <td>{{ $stok->barcode }}</td>
                                            <td>{{ $stok->product->product_name }}</td>
                                            <td>{{ $stok->stok }}</td>
                                            <td class="text-center">{{ $stok->tanggal_beli }}</td>
                                            <td class="text-center">{{ $stok->tanggal_expired }}</td>
                                            <td>@money($stok->harga_beli)</td>
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