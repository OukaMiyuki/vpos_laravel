<x-kasir-layout>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">UBold</a></li>
                                <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                                <li class="breadcrumb-item active">Invoice</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Invoice</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Logo & title -->
                            <div class="clearfix">
                                <div class="float-start">
                                    <div class="auth-logo">
                                        <div class="logo logo-dark">
                                            <span class="logo-lg">
                                                <img src="{{ asset('assets/images/logo/large.png') }}" alt="" height="40">
                                            </span>
                                        </div>

                                        <div class="logo logo-light">
                                            <span class="logo-lg">
                                                <img src="{{ asset('assets/images/logo/small.png') }}" alt="" height="22">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="float-end">
                                    <h4 class="m-0 d-print-none">Transaction Invoice</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        {{-- <p><b>Hello, Stanley Jones</b></p> --}}
                                        <p class="text-muted">
                                            Berikut terlampir bukti invoice untuk transaksi dengan nomor invoice <strong>{{ $invoice->nomor_invoice }}</strong>
                                        </p>
                                    </div>

                                </div><!-- end col -->
                                <div class="col-md-4 offset-md-2">
                                    <div class="mt-3 float-end">
                                        <table>
                                            <tr>
                                                <td><p><strong>Tanggal Transaksi</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p><span>&nbsp;&nbsp;&nbsp;&nbsp;{{ $invoice->tanggal_transaksi }}</span></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Tanggal Pembayaran</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p><span>&nbsp;&nbsp;&nbsp;&nbsp;{{ $invoice->tanggal_pelunasan }}</span></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Status Pembayaran</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    @if (empty($invoice->jenis_pembayaran))
                                                        <span class="badge bg-danger">
                                                            Belum Diproses
                                                        </span>
                                                    @else
                                                        @if($invoice->status_pembayaran == 1)
                                                            <span class="badge bg-success">
                                                                Di bayar
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">
                                                                Belum di bayar
                                                            </span>
                                                        @endif
                                                    @endif
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Invoice</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p>&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ $invoice->nomor_invoice }}</span></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Jenis Pembayaran</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p>&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ $invoice->jenis_pembayaran }}</span></p></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <!-- end row -->
                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <h6>Info Transaksi</h6>
                                    @php
                                        $field = App\Models\TenantField::where('store_identifier', auth()->user()->id_store)->first();
                                    @endphp
                                    @if (!empty($field))
                                        <address>
                                            @if (!empty($field->baris1)) {{ $field->baris1 }} : @if(!empty($invoice->invoiceField->content1)) {{ $invoice->invoiceField->content1 }} @endif<br>@endif
                                            @if (!empty($field->baris2)) {{ $field->baris2 }} : @if(!empty($invoice->invoiceField->content2)) {{ $invoice->invoiceField->content2 }} @endif<br>@endif
                                            @if (!empty($field->baris3)) {{ $field->baris3 }} : @if(!empty($invoice->invoiceField->content3)) {{ $invoice->invoiceField->content3 }} @endif<br>@endif
                                            @if (!empty($field->baris4)) {{ $field->baris4 }} : @if(!empty($invoice->invoiceField->content4)) {{ $invoice->invoiceField->content4 }} @endif<br>@endif
                                            @if (!empty($field->baris5)) {{ $field->baris5 }} : @if(!empty($invoice->invoiceField->content5)) {{ $invoice->invoiceField->content5 }} @endif<br>@endif
                                        </address>
                                    @endif
                                </div> <!-- end col -->
                                <div class="col-sm-6">
                                    <h6>Info Kasir</h6>
                                    <address>
                                        Nama Kasir : {{ auth()->user()->name }}<br>
                                        Jabatan : Kasir<br>
                                        Nomor Telp./WA : {{ auth()->user()->phone }}<br>
                                        Email : {{ auth()->user()->email }}<br>
                                    </address>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mt-4 table-centered">
                                            <thead>
                                                <tr>
                                                    <th width="width:5%">#</th>
                                                    <th width="width:25%">Nama</th>
                                                    <th width="width:10%">QTY</th>
                                                    <th width="width:25%">Harga Satuan</th>
                                                    <th width="width:25%">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no=0;
                                                    $total=0;
                                                @endphp
                                                @foreach ($invoice->shoppingCart as $cart)
                                                    <tr>
                                                        <td>{{ $no+=1 }}</td>
                                                        <td>{{ $cart->product_name }}</td>
                                                        <td>{{ $cart->qty }}</td></td>
                                                        <td>{{ $cart->harga }}</td>
                                                        <td>{{ $cart->sub_total }}</td>
                                                        @php
                                                            $total+=$cart->sub_total;
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive -->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="clearfix pt-5">
                                        <h6 class="text-muted">Notes:</h6>

                                        <small class="text-muted">
                                            All accounts are to be paid within 7 days from receipt of
                                            invoice. To be paid by cheque or credit card or direct payment
                                            online. If account is not paid within 7 days the credits details
                                            supplied as confirmation of work undertaken will be charged the
                                            agreed quoted fee noted above.
                                        </small>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-sm-6">
                                    @php
                                        $diskon = App\Models\Discount::where('store_identifier', auth()->user()->id_store)->where('is_active', 1)->first();
                                        $pajak =  App\Models\Tax::where('store_identifier', auth()->user()->id_store)->where('is_active', 1)->first();
                                    @endphp
                                    <div class="float-end">
                                        <p><b>Sub-total (Rp.):</b> <span class="float-end">{{ $total }}</span></p>
                                        <p><b>Discount (@if(!empty($diskon->diskon)){{$diskon->diskon}}%@endif):</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{$invoice->diskon}}</span></p>
                                        <p><b>Total (Rp.):</b> <span class="float-end">{{ $invoice->sub_total }}</span></p>
                                        <p><b>Pajak (@if(!empty($pajak->pajak)){{$pajak->pajak}}%@endif):</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{$invoice->pajak}}</span></p>
                                        <h3>Tagihan : Rp. {{$invoice->sub_total+$invoice->pajak}}</h3>
                                        @if ($invoice->jenis_pembayaran == "Tunai")
                                            <p><b>Nominal di bayar (Rp.):</b> <span class="float-end"><strong>{{ $invoice->nominal_bayar }}</strong></span></p>
                                            <p><b>Kambalian (Rp.):</b> <span class="float-end"><strong>{{ $invoice->kembalian }}</strong></span></p>
                                        @endif
                                    </div>
                                    <div class="clearfix"></div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="mt-4 mb-1">
                                <div class="text-end d-print-none">
                                    <a href="{{route('kasir.pos.transaction.invoice.receipt', ['id' => $invoice->id])}}" class="btn btn-primary waves-effect waves-light" target="_blank"><i class="mdi mdi-printer me-1"></i> Print Nota</a>
                                    {{-- <a href="" onclick="window.open('{{route('kasir.pos.transaction.invoice.receipt', ['id' => $invoice->id])}}','popUpWindow');" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer me-1"></i> Print Nota</a> --}}
                                    {{-- <a href="" onclick="window.open('{{route('kasir.pos.transaction.invoice.receipt', ['id' => $invoice->id])}}','popUpWindow','height=500,width=255,left=100,top=100,resizable=no,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer me-1"></i> Print Nota</a> --}}
                                    {{-- <a id="printNota" nonce="{{ csp_nonce() }}" onclick="window.open('{{route('kasir.pos.transaction.invoice.receipt', ['id' => $invoice->id])}}','popUpWindow','resizable=no,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer me-1"></i> Print Nota</a>&nbsp;&nbsp; --}}
                                    {{-- <a href="#" class="btn btn-info waves-effect waves-light">Submit</a> --}}
                                    @if (($invoice->jenis_pembayaran == "Qris") && (!empty($invoice->qris_data)) && ($invoice->status_pembayaran == 0))
                                        &nbsp;&nbsp;<a href=""  data-bs-toggle="modal" data-bs-target="#lihatqris" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer me-1"></i> Lihat Qris</a>
                                        <div class="modal fade" id="lihatqris" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Data Qris Pembayaran</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form class="px-3">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row text-center">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="qris" class="form-label">Data Qris</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row text-center">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        {!! QrCode::size(300)->generate($invoice->qris_data) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($invoice->status_pembayaran == 0)
                                        &nbsp;&nbsp;<a href=""  data-bs-toggle="modal" data-bs-target="#ubahpembayaran" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer me-1"></i> Ubah Pembayaran</a>
                                        <div class="modal fade" id="ubahpembayaran" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Apakah yakin ingin ubah pembayaran?</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form class="px-3" action="{{ route('kasir.pos.transaction.pending.changePayment') }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row text-center">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="qris" class="form-label">Konfirmasi ubah Pembayaran ke Tunai
                                                                        </label>
                                                                        <input type="hidden" class="d-none" name="id" id="id" required readonly value="{{$invoice->id}}">
                                                                        <input type="hidden" class="d-none" name="ttl" id="ttl" required readonly value="{{$invoice->sub_total+$invoice->pajak}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row text-start">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="nom" class="form-label">Masukkan Nominal Bayar</label>
                                                                        <input type="text" class="form-control @error('nominal') is-invalid @enderror" name="nominal" id="nom" value="{{ old('nominal') }}" placeholder="Masukkan data nominal pembayaran" required>
                                                                        @error('nominal')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="kem" class="form-label">Kembalian</label>
                                                                        <input type="text" class="form-control @error('kembalian') is-invalid @enderror" name="kembalian" id="kem" value="{{ old('kembalian') }}" placeholder="Nominal kembalian" required readonly>
                                                                        @error('kembalian')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div>
    </div>
</x-kasir-layout>
