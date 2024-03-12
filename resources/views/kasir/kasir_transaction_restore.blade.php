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
                                                            <input readonly type="number" name="qty" class="qty_txt" value="{{ $cart->qty }}" min="1">
                                                        </td>
                                                        <td>{{ $cart->price }}</td>
                                                        <td>{{ $cart->price*$cart->qty }}</td>
                                                        <td><a href="{{ route('kasir.pos.deleteCart', ['id' => $cart->rowId]) }}" style="font-size: 20px;"><span class="mdi mdi-trash-can-outline"></span></a></td>
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
                                        <p style="font-size:18px; color:#FFF">Total Item Quantity : {{ Cart::count() }} </p>
                                        <p style="font-size:18px; color:#FFF">Sub Total : Rp. {{ Cart::subtotal() }}</p>
                                        <p style="font-size:18px; color:#FFF">Pajak (
                                            @if(!empty($pajak->pajak))
                                                {{ $pajak->pajak }}%
                                            @endif
                                        ) : Rp. {{ Cart::tax() }}</p>
                                        <p style="font-size:18px; color:#FFF">Diskon (
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
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
                                            <button @if(Cart::subtotal()==0) disabled @endif type="button" disabled id="formCheckout" class="btn btn-blue waves-effect waves-light">Create Invoice</button>&nbsp;&nbsp;
                                            {{-- <button @if(Cart::subtotal()==0) disabled @endif type="submit" formaction="{{ route('kasir.pos.transaction.save') }}" formmethod="post" class="btn btn-blue waves-effect waves-light">Save Transaction</button>&nbsp;&nbsp;
                                            <button @if(Cart::subtotal()==0) disabled @endif type="submit" formaction="{{ route('kasir.pos.transaction.clear') }}" formmethod="post" class="btn btn-blue waves-effect waves-light">Clear Transaction</button> --}}
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
</x-kasir-layout>