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
                                                <td><p><span>&nbsp;&nbsp;&nbsp;&nbsp;Jan 17, 2016</span></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Tanggal Pembayaran</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p><span>&nbsp;&nbsp;&nbsp;&nbsp;Jan 17, 2016</span></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Status Pembayaran</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p>&nbsp;&nbsp;&nbsp;&nbsp;<span class="badge bg-success">Di bayar</span></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Invoice</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p>&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ $invoice->nomor_invoice }}</span></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Janis Pembayaran</strong></p></td>
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
                                        $field = App\Models\TenantField::where('id_tenant', auth()->user()->id_tenant)->first();
                                    @endphp
                                    @if (!empty($field))
                                        <address>
                                            {{ $field->baris1 }} : {{ $invoice->invoiceField->content1 }}<br>
                                            {{ $field->baris2 }} : {{ $invoice->invoiceField->content2 }}<br>
                                            {{ $field->baris3 }} : {{ $invoice->invoiceField->content3 }}<br>
                                            {{ $field->baris4 }} : {{ $invoice->invoiceField->content4 }}<br>
                                            {{ $field->baris5 }} : {{ $invoice->invoiceField->content5 }}
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
                                        $diskon = App\Models\Discount::where('id_tenant', auth()->user()->id_tenant)->where('is_active', 1)->first();
                                        $pajak =  App\Models\Tax::where('id_tenant', auth()->user()->id_tenant)->where('is_active', 1)->first();
                                    @endphp
                                    <div class="float-end">
                                        <p><b>Sub-total (Rp.):</b> <span class="float-end">{{ $total }}</span></p>
                                        <p><b>Discount (@if(!empty($diskon->diskon)){{$diskon->diskon}}%@endif):</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{$invoice->diskon}}</span></p>
                                        <p><b>Pajak (@if(!empty($pajak->pajak)){{$pajak->pajak}}%@endif):</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; {{$invoice->pajak}}</span></p>
                                        <p><b>Total (Rp.):</b> <span class="float-end">{{ $invoice->sub_total }}</span></p>
                                        <h3>Rp. {{$invoice->sub_total+$invoice->pajak}}</h3>
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
