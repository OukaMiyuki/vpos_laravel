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
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                <li class="breadcrumb-item active">POS</li>
                            </ol>
                        </div>
                        <h4 class="page-title">POS</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="row g-0">
                                <div class="col-6">
                                    <div class="table-responsive">
                                        <table id="scroll-vertical-datatable" class="table table-bordered border-primary mb-0 w-100">
                                            <thead>
                                                <tr>
                                                  
                                                    <th>Nama</th>
                                                    <th width="25%">QTY</th>
                                                    <th>Harga</th>
                                                    <th>Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $allCart = Cart::content();
                                                    $no=0;
                                                @endphp
                                                @foreach ($allCart as $cart)
                                                    <tr>
                                                    
                                                        <td class="text-start">{{ $cart->name }}</td>
                                                        <td>
                                                            <input readonly type="number" name="qty" class="qty_txt" value="{{ $cart->qty }}" min="1">
                                                        </td>
                                                        <td>{{ $cart->price }}</td>
                                                        <td>{{ $cart->price*$cart->qty }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    @php
                                        $diskon = App\Models\Discount::where('id_tenant', auth()->user()->id_tenant)->where('is_active', 1)->first();
                                        $pajak =  App\Models\Tax::where('id_tenant', auth()->user()->id_tenant)->where('is_active', 1)->first();
                                    @endphp
                                    <div class="bg-primary pt-5 pb-5 h-100 text-center">
                                        <p class="pos-price-text">Total Item Quantity : {{ Cart::count() }} </p>
                                        <p class="pos-price-text">Sub Total : Rp. {{ Cart::subtotal() }}</p>
                                        <p class="pos-price-text">Pajak (
                                            @if(!empty($pajak->pajak))
                                                {{ $pajak->pajak }}%
                                            @endif
                                        ) : Rp. {{ Cart::tax() }}</p>
                                        <p class="pos-price-text">Diskon (
                                            @if(!empty($diskon->diskon))
                                                @if(Cart::subtotal()>=$diskon->diskon)
                                                    {{ $diskon->diskon }}%
                                                @endif
                                             @endif
                                        ) : Rp. {{ Cart::discount() }}</p>
                                        <p><h2 class="text-white">Total Belanja</h2><h1 class="text-white">Rp. {{ Cart::total() }}</h1></p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <form>
                                @csrf
                                <div class="row text-start">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="nominal" class="form-label" id="dengan-rupiah">Nomor Invoice</label>
                                            <input @if(Cart::subtotal()==0) disabled @endif type="text" class="form-control rupiah" name="invoice" id="invoice" required value="{{ $invoice->nomor_invoice}}" placeholder="Masukkan nomor invoice" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-start">
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
                                <div class="row text-start" id="tunai_text">
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
                                            <button @if(Cart::subtotal()==0) disabled @endif type="button" disabled id="formCheckout" class="btn btn-blue waves-effect waves-light m-1">Selesaikan Transaksi</button>&nbsp;&nbsp;
                                            {{-- <button @if(Cart::subtotal()==0) disabled @endif type="submit" formaction="{{ route('kasir.pos.transaction.save') }}" formmethod="post" class="btn m-1 btn-blue waves-effect waves-light">Save Transaction</button>&nbsp;&nbsp;
                                            <button @if(Cart::subtotal()==0) disabled @endif type="submit" formaction="{{ route('kasir.pos.transaction.clear') }}" formmethod="post" class="btn m-1 btn-blue waves-effect waves-light">Clear Transaction</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                <form class="px-3" action="{{ route('kasir.pos.transaction.pending.process') }}" method="post">
                    @csrf
                    <div class="modal-body" id="checkoutProcess">
                        <input hidden class="d-none" name="id_invoice" id="id_invoice" required value="{{ $invoice->id}}" readonly>
                        <input hidden class="d-none" type="text" name="jenisPembayaran" id="jenisPembayaran">
                        <input hidden class="d-none" type="text" name="nominalText" id="nominalText">
                        <input hidden class="d-none" type="text" name="kembalianText" id="kembalianText">
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
</x-kasir-layout>