<x-kasir-layout>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                <li class="breadcrumb-item active">POS</li>
                            </ol>
                        </div>
                        <h4 class="page-title">POS</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                          
                                            <th>Nama</th>
                                            <th width="25%">QTY</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $allCart = Cart::content();
                                            $no=0;
                                        @endphp
                                        @foreach ($allCart as $cart)
                                            <tr>
                                            
                                                <td>{{ $cart->name }}</td>
                                                <td>
                                                    <form id="qtyform" action="{{ route('kasir.pos.updateCart') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $cart->rowId }}">
                                                        <input type="number" name="qty" style="width:40px;" value="{{ $cart->qty }}" min="1">
                                                        <button type="submit" class="btn btn-sm btn-success"><span class="mdi mdi-check-bold"></span></button>
                                                    </form>
                                                </td>
                                                <td>{{ $cart->price }}</td>
                                                <td>{{ $cart->price*$cart->qty }}</td>
                                                <td><a href="{{ route('kasir.pos.deleteCart', ['id' => $cart->rowId]) }}" style="font-size: 20px;"><span class="mdi mdi-trash-can-outline"></span></a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                            <div class="bg-primary pt-3 pb-2">
                                <p style="font-size:18px; color:#FFF">Total Item Quantity : {{ Cart::count() }} </p>
                                <p style="font-size:18px; color:#FFF">Sub Total : Rp. {{ Cart::subtotal() }}</p>
                                <p style="font-size:18px; color:#FFF">Pajak (5%) : Rp. {{ Cart::tax() }}</p>
                                <p><h2 class="text-white">Total Belanja</h2><h1 class="text-white">Rp. {{ Cart::total() }}</h1></p>
                            </div>
                            <br>
                            <form method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select class="form-select @error('pembayaran') is-invalid @enderror" id="pembayaran" name="pembayaran">
                                                <option value="">- Pilih jenis pembayaran -</option>
                                                <option value="Tunai">Tunai</option>
                                                <option value="Qris">Qris</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="tunai_text">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nominal" class="form-label" id="dengan-rupiah">Nominal Bayar</label>
                                            {{-- <input type="text" id="rupiah" /> --}}
                                            <input type="text" class="form-control rupiah" name="nominal" id="nominal" required value="" placeholder="Masukkan nominal bayar">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kembalian" class="form-label">Kembalian</label>
                                            <input type="text" class="form-control" name="kembalian" id="kembalian" required value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <button class="btn btn-blue waves-effect waves-light">Create Invoice</button>&nbsp;&nbsp;
                                            <button type="submit" formaction="{{ route('kasir.pos.transaction.save') }}" class="btn btn-blue waves-effect waves-light">Save Transaction</button>&nbsp;&nbsp;
                                            <button type="submit" formaction="{{ route('kasir.pos.transaction.clear') }}" class="btn btn-blue waves-effect waves-light">Clear Transaction</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end col-->
                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg">
                                <li class="nav-item">
                                    <a href="#productlist" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Product List
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="productlist">
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Product List</h5>
                                    <table id="pos" class="table w-100 nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th></th>
                                                <th>Barcode</th>
                                                <th>Kode Barang</th>
                                                <th>Name</th>
                                                <th>Harga</th>
                                                <th>Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=0; @endphp
                                            @foreach($stock as $stok)
                                                <tr>
                                                    <td>{{ $no+=1 }}</td>
                                                    <td>
                                                        <form id="cartForm" action="{{ route('kasir.pos.addCart') }}" method="post">
                                                            @csrf
                                                            <input readonly type="hidden" id="id" name="id" value="{{ $stok->id }}">
                                                            <input readonly type="hidden" id="barcode" name="barcode" value="{{ $stok->barcode }}">
                                                            <input readonly type="hidden" id="name" name="name" value="{{ $stok->product->product_name }}">
                                                            <input readonly type="hidden" id="qty" name="qty" value="1">
                                                            <input readonly type="hidden" id="price" name="price" value="{{ $stok->product->harga_jual }}">
                                                            <button type="submit" style="font-size:20px; color:#000;">
                                                                <span class="mdi mdi-plus-box"></span>
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        {{-- <table>
                                                            @foreach($stok->productStock as $stokPerBarcode)
                                                                <tr>
                                                                    <td>{{ $stokPerBarcode->barcode }}<td>
                                                                <tr>
                                                            @endforeach
                                                        </table> --}}
                                                        {{ $stok->barcode }}
                                                    </td>
                                                    <td>{{ $stok->product->product_code }}</td>
                                                    <td>{{ $stok->product->product_name }}</td>
                                                    <td>{{ $stok->product->harga_jual }}</td>
                                                    <td>{{ $stok->stok }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end tab-content -->
                        </div>
                    </div>
                    <!-- end card-->
                </div>
                <!-- end col -->
            </div>
            <!-- end row-->
        </div>
        <!-- container -->
    </div>
</x-kasir-layout>