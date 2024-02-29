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
                <div class="col-lg-12 col-xl-12">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="row g-0">
                                <div class="col-6">
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
                                                            <input readonly type="number" name="qty" style="width:40px;" value="{{ $cart->qty }}" min="1">
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
                                <div class="col-6">
                                    <div class="bg-primary pt-5 h-100 align-items-center">
                                        <p style="font-size:18px; color:#FFF">Total Item Quantity : {{ Cart::count() }} </p>
                                        <p style="font-size:18px; color:#FFF">Sub Total : Rp. {{ Cart::subtotal() }}</p>
                                        <p style="font-size:18px; color:#FFF">Pajak (5%) : Rp. {{ Cart::tax() }}</p>
                                        <p><h2 class="text-white">Total Belanja</h2><h1 class="text-white">Rp. {{ Cart::total() }}</h1></p>
                                    </div>
                                </div>
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
                                            <label for="nominal" class="form-label">Nominal Bayar</label>
                                            <input type="text" class="form-control" name="nominal" id="nominal" required value="" placeholder="Masukkan nominal bayar">
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
                                            <button class="btn btn-blue waves-effect waves-light">Finish Transaction</button>&nbsp;&nbsp;
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