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
                                <table id="pos-table" class="table table-bordered border-primary mb-0 w-100">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Nama</th>
                                            <th>QTY</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $allCart = Cart::content();
                                            $no=0;
                                            $total=0;
                                        @endphp
                                        @foreach ($allCart as $cart)
                                            <tr>
                                                <td><a href="{{ route('tenant.pos.deleteCart', ['id' => $cart->rowId]) }}"><h4><span class="mdi mdi-trash-can-outline"></span></h4></a></td>
                                                <td class="text-start">{{ $cart->name }}</td>
                                                <td>
                                                    <form id="qtyform" action="{{ route('tenant.pos.updateCart') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $cart->rowId }}">
                                                        <input type="number" name="qty" class="qty_txt" value="{{ $cart->qty }}" min="1">
                                                        <button type="submit" class="btn btn-sm btn-success"><span class="mdi mdi-check-bold"></span></button>
                                                    </form>
                                                </td>
                                                <td>{{ $cart->price }}</td>
                                                <td>{{ $cart->price*$cart->qty }}</td>
                                                @php
                                                    $total+=$cart->price*$cart->qty;
                                                @endphp
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                            <div class="bg-primary pt-3 pb-2">
                                @php
                                    $store = App\Models\StoreDetail::select(['store_identifier'])
                                                        ->where('id_tenant', auth()->user()->id)
                                                        ->where('email', auth()->user()->email)
                                                        ->first();
                                    $identifier = $store->store_identifier;
                                    $diskon = App\Models\Discount::where('store_identifier', $identifier)
                                                                    ->where('is_active', 1)
                                                                    ->first();
                                    $pajak =  App\Models\Tax::where('store_identifier', $identifier)
                                                                ->where('is_active', 1)
                                                                ->first();
                                @endphp
                                <p class="pos-price-text">Total Item Quantity : {{ Cart::count() }} </p>
                                <p class="pos-price-text">Diskon (
                                    @php
                                        $subtotal = (int) substr(str_replace([',', '.'], '', Cart::subtotal()), 0, -2);
                                    @endphp
                                    @if(!empty($diskon->diskon))
                                        @if($subtotal>=$diskon->diskon)
                                            {{ $diskon->diskon }}%
                                        @endif
                                     @endif
                                ) : Rp. {{ Cart::discount() }}</p>
                                <p class="pos-price-text">Sub Total : Rp. {{ Cart::subtotal() }}</p>
                                <p class="pos-price-text">Pajak (
                                    @if(!empty($pajak->pajak))
                                        {{ $pajak->pajak }}%
                                    @endif
                                ) : Rp. {{ Cart::tax() }}</p>
                                <p><h2 class="text-white">Total Belanja</h2><h1 class="text-white">Rp. {{ Cart::total() }}</h1></p>
                            </div>
                            <br>
                            <form>
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="hidden" class="d-none" name="subbttl" id="subbttl" required value="{{ Cart::total() }}" readonly>
                                            <select @if(Cart::subtotal()==0) disabled @endif class="form-select @error('pembayaran') is-invalid @enderror" id="pembayaran" name="pembayaran">
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
                                            <input @if(Cart::subtotal()==0) disabled @endif type="number" class="form-control rupiah" name="nominal" id="nominal" required value="" placeholder="Masukkan nominal bayar">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kembalian" class="form-label">Kembalian</label>
                                            <input @if(Cart::subtotal()==0) disabled @endif type="text" class="form-control" name="kembalian" id="kembalian" required value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <button @if(Cart::subtotal()==0) disabled @endif type="button" disabled id="formCheckout" class="btn btn-blue waves-effect waves-light m-1">Create Invoice</button>&nbsp;&nbsp;
                                            <button @if(Cart::subtotal()==0) disabled @endif type="button" data-bs-toggle="modal" data-bs-target="#modalAddCustomerIdentifier"  class="btn m-1 btn-blue waves-effect waves-light">Save Transaction</button>&nbsp;&nbsp;
                                            <button @if(Cart::subtotal()==0) disabled @endif type="submit" formaction="{{ route('tenant.pos.invoice.clear') }}" formmethod="post" class="btn m-1 btn-blue waves-effect waves-light">Clear Transaction</button>
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
                                                        <form id="cartForm" action="{{ route('tenant.pos.addcart') }}" method="post">
                                                            @csrf
                                                            <input readonly type="hidden" id="id" name="id" value="{{ $stok->id }}">
                                                            <input readonly type="hidden" id="barcode" name="barcode" value="{{ $stok->barcode }}">
                                                            <input readonly type="hidden" id="name" name="name" value="{{ $stok->product->product_name }}">
                                                            <input readonly type="hidden" id="qty" name="qty" value="1">
                                                            <input readonly type="hidden" id="price" name="price" value="{{ $stok->product->harga_jual }}">
                                                            <button class="pos-add-button" type="submit"><span class="mdi mdi-plus-box"></span></button>
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
    <div class="modal fade" id="processInvoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Masukkan Informasi Transaksi (Opsional boleh dikosongi)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('tenant.pos.process') }}" method="post">
                    @csrf
                    <div class="modal-body" id="checkoutProcess">
                        <input hidden class="d-none" type="text" name="jenisPembayaran" id="jenisPembayaran" readonly>
                        <input hidden class="d-none" type="text" name="nominalText" id="nominalText" readonly>
                        <input hidden class="d-none" type="text" name="kembalianText" id="kembalianText" readonly>
                        @switch(true)
                            @case($customField->id != '')
                                @if (!empty($customField->baris1) && $customField->baris_1_activation != 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="content1" class="form-label">{{$customField->baris1}}</label>
                                                <input type="text" class="form-control @error('content1') is-invalid @enderror" name="content1" id="content1" value="{{ old('content1') }}" placeholder="Masukkan data {{$customField->baris1}}">
                                                @error('content1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($customField->baris2) && $customField->baris_2_activation != 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="content2" class="form-label">{{$customField->baris2}}</label>
                                                <input type="text" class="form-control @error('content2') is-invalid @enderror" name="content2" id="content2" value="{{ old('content2') }}" placeholder="Masukkan data {{$customField->baris2}}">
                                                @error('content2')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($customField->baris3) && $customField->baris_3_activation != 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="content3" class="form-label">{{$customField->baris3}}</label>
                                                <input type="text" class="form-control @error('content3') is-invalid @enderror" name="content3" id="content3" value="{{ old('content3') }}" placeholder="Masukkan data {{$customField->baris3}}">
                                                @error('content3')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($customField->baris4) && $customField->baris_4_activation != 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="content4" class="form-label">{{$customField->baris4}}</label>
                                                <input type="text" class="form-control @error('content4') is-invalid @enderror" name="content4" id="content4" value="{{ old('content4') }}" placeholder="Masukkan data {{$customField->baris4}}">
                                                @error('content4')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($customField->baris5) && $customField->baris_5_activation != 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="content5" class="form-label">{{$customField->baris5}}</label>
                                                <input type="text" class="form-control @error('content5') is-invalid @enderror" name="content5" id="content5" value="{{ old('content5') }}" placeholder="Masukkan data {{$customField->baris5}}">
                                                @error('content5')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @break
                            @default
                        @endswitch
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Proses Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddCustomerIdentifier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Masukkan Info Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="px-3" action="{{ route('tenant.pos.invoice.save') }}" method="post" id="show">
                    @csrf
                    <div class="modal-body" id="checkoutProcess">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="cust_info" class="form-label">Customer Info</label>
                                    <input type="text" required class="form-control @error('cust_info') is-invalid @enderror" name="cust_info" id="cust_info" value="{{ old('cust_info') }}" placeholder="Nama Pelanggan/Nomor Meja">
                                    @error('cust_info')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Keterangan (Opsional boleh dikosongi)</label>
                                    <textarea placeholder="Masukkan keterangan" class="form-control" id="description" name="description" rows="5" spellcheck="false">{!! old('description') !!}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-tenant-layout>
