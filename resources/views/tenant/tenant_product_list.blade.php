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
                                <li class="breadcrumb-item active">Batch Product</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Data Product Toko</h4>
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
                            <h4 class="header-title mb-3">Tabel Product List&nbsp;&nbsp;&nbsp;<a href="{{ route('tenant.product.batch.add') }}"><button title="Tambah barang baru" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus-box-multiple-outline"></i>&nbsp;Tambahkan produk baru</button></a></h4>
                        
                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-center">Action</th>
                                            <th class="text-center">Photo</th>
                                            <th>Product Batch Code</th>
                                            <th>Product Name</th>
                                            <th>Kategori</th>
                                            <th>Harga Jual Per-Piece (Rp.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=0; @endphp
                                        @foreach($product as $product)
                                            <tr>
                                                <td>{{ $no+=1 }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('tenant.product.batch.detail', ['id' => $product->id]) }}">
                                                        <button title="Lihat detail produk" type="button" class="btn btn-primary btn-xs waves-effect waves-light"><span class="mdi mdi-eye"></span></button>&nbsp;
                                                    </a>
                                                    <a href="{{ route('tenant.product.batch.edit', ['id' => $product->id]) }}">
                                                        <button title="Edit data produk" type="button" class="btn btn-success btn-xs waves-effect waves-light"><span class="mdi mdi-pencil"></span></button>&nbsp;
                                                    </a>
                                                    <a href="{{ route('tenant.product.batch.delete', ['id' => $product->id]) }}">
                                                        <button title="Hapus produk" type="button" class="btn btn-danger btn-xs waves-effect waves-light"><span class="mdi mdi-trash-can"></span></button>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <img src="{{ !empty($product->photo) ? Storage::url('images/product/'.$product->photo) : asset('assets/images/blank_profile.png') }}" class="img-thumbnail" alt="Product Photo" width="80">
                                                </td>
                                                <td>{{ $product->product_code }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                {{-- <td>{{ $product->stok }}</td> --}}
                                                <td>@money($product->harga_jual)</td>
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