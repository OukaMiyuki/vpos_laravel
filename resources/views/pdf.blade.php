<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Invoice Transaksi {{$invoice->nomor_invoice}}</title>
        <link rel="stylesheet" href="style.css" media="all" />
        <style>
            @page { margin: 20px !important; }
            body { margin: 20px !important; }
            @font-face {
                font-family: SourceSansPro;
                src: url(SourceSansPro-Regular.ttf);
            }

            .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }

            a {
                color: #0087C3;
                text-decoration: none;
            }

            body {
                position: relative;
                /* width: 21cm;
                height: 29.7cm; */
                margin: 0 auto;
                color: #555555;
                background: #FFFFFF;
                font-family: Arial, sans-serif;
                font-size: 14px;
                font-family: SourceSansPro;
            }

            header {
                padding: 10px 0;
                margin-bottom: 20\px;
                border-bottom: 1px solid #AAAAAA;
            }

            #logo {
                float: left;
                margin-top: 8px;
            }

            #logo img {
                height: 70px;
            }

            #company {
                float: right;
                text-align: right;
            }


            #details {
                margin-bottom: 25px !important;
            }

            #client {
                padding-left: 6px;
                border-left: 6px solid #f76e05 !important;
                float: left;
            }

            #client .to {
                color: #777777;
            }

            h2.name {
                font-size: 1.4em;
                font-weight: normal;
                margin: 0;
            }

            #invoice {
                float: right;
                text-align: right;
            }

            #invoice h1 {
                color: #f76e05 !important;
                font-size: 1.35em !important;
                line-height: 1em;
                font-weight: normal;
                margin: 0 0 10px 0;
            }

            #invoice .date {
                font-size: 1.1em;
                color: #777777;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 10px;
            }

            table th,
            table td {
                padding: 3px !important;
                background: #EEEEEE;
                text-align: center;
                border-bottom: 1px solid #FFFFFF;
            }

            table th {
                white-space: nowrap;
                font-weight: normal;
            }

            table td {
                text-align: right;
            }

            table td h3 {
                color: #f76e05 !important;
                font-size: 12px !important;
                font-weight: normal;
                margin: 0 0 0.2em 0;
            }

            table .no {
                text-align: center;
                color: #FFFFFF;
                font-size: 12px !important;
                background: #FD9A5F !important;
            }

            table .desc {
                text-align: left;
            }

            table .unit {
                background: #DDDDDD;
            }

            table .qty {}

            table .total {
                background: #FD9A5F !important;
                color: #FFFFFF;
            }

            table td.unit,
            table td.qty,
            table td.total {
                font-size: 12px !important;
            }

            table tbody tr:last-child td {
            border: none;
            }

            table tfoot td {
                padding: 10px 20px;
                background: #FFFFFF;
                border-bottom: none;
                font-size: 12px !important;
                white-space: nowrap;
                border-top: 1px solid #AAAAAA;
            }

            table tfoot tr:first-child td {
                border-top: none;
            }

            table tfoot tr:nth-child(4) td {
                color: #f76e05 !important;
                font-size: 12px !important;
                /* border-top: 1px solid #f76e05 !important; */
            }

            table tfoot tr td:first-child, table tfoot tr td:nth-child(2) {
                border: none;
            }

            #thanks {
                font-size: 1.2em;
                margin-bottom: 20px;
            }

            #notices {
                /* float: right; */
                padding-left: 6px;
                border-left: 6px solid #f76e05 !important;
            }

            #notices .notice {
                margin-top: 20px;
                font-size: 1.2em;
            }

            footer {
                color: #777777;
                margin-top: 20px;
                width: 100%;
                height: 30px;
                /* position: absolute; */
                bottom: 0;
                border-top: 1px solid #AAAAAA;
                padding: 8px 0;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header class="clearfix">
            <div id="logo">
                @php
                    $storeTenant = App\Models\StoreDetail::where('store_identifier', $invoice->store_identifier)->first();
                @endphp
                <img src="{{ !empty($storeTenant->photo) ? 'https://visipos.id/storage/images/profile/'.$storeTenant->photo :'https://visipos.id/assets/images/logo/Logo2.png' }}">
                {{-- <img src="logo.png"> --}}
            </div>
            <div id="company">
                <h2 class="name"><strong>{{$storeTenant->name}}</strong></h2>
                <div>{{$storeTenant->alamat}}</div>
                <div>{{$storeTenant->no_telp_toko}}</div>
                {{-- <div><a href="mailto:company@example.com">company@example.com</a></div> --}}
                <div>{{$storeTenant->website}}</div>
            </div>
            </div>
        </header>
        <br>
        @php
            $field = App\Models\TenantField::where('store_identifier', $storeTenant->store_identifier)->first();
        @endphp
        <main>
            <div id="details" class="clearfix">
                <div id="client">
                    <div class="to">INVOICE TO:</div>
                    @if(!empty($field->id))
                        @if ( !empty($invoice->invoiceField->content1) || !empty($invoice->invoiceField->content2) || !empty($invoice->invoiceField->content3) || !empty($invoice->invoiceField->content4) || !empty($invoice->invoiceField->content5))
                            <h2 class="name">@if(!empty($invoice->invoiceField->content1)){{$invoice->invoiceField->content1}}@endif</h2>
                            <div class="address">@if(!empty($invoice->invoiceField->content2)){{$invoice->invoiceField->content2}}@endif</div>
                            <div class="address">@if(!empty($invoice->invoiceField->content3)){{$invoice->invoiceField->content3}}@endif</div>
                            <div class="phone">@if(!empty($invoice->invoiceField->content4)){{$invoice->invoiceField->content4}}@endif</div>
                            <div class="email">@if (!empty($invoice->invoiceField->content5))<a href="mailto:{{$invoice->invoiceField->content5}}">{{$invoice->invoiceField->content5}}</a>@endif</div>
                        @endif
                    @endif
                </div>
                <div id="invoice">
                    <h1>INVOICE : {{$invoice->nomor_invoice}}</h1>
                    <div class="date">Tanggal Transaksi: {{\Carbon\Carbon::parse($invoice->tanggal_transaksi)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoice->created_at)->format('H:i:s')}}</div>
                    <div class="date">Tanggal Pembayaran: @if(!is_null($invoice->tanggal_pelunasan) || !empty($invoice->tanggal_pelunasan)){{\Carbon\Carbon::parse($invoice->tanggal_pelunasan)->format('d-m-Y')}} {{\Carbon\Carbon::parse($invoice->updated_at)->format('H:i:s')}}@endif</div>
                    <div class="date">Status Pembayaran: @if($invoice->status_pembayaran == 0)<strong>Belum Bayar</strong>@else<strong>Terbayar</strong>@endif</div>
                </div>
            </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th class="no">#</th>
                        <th class="desc">ITEM BELANJA</th>
                        <th class="unit">HARGA (Rp.)</th>
                        <th class="qty">QUANTITY</th>
                        <th class="total">TOTAL (Rp.)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=0;
                    @endphp
                    @foreach ($invoice->shoppingCart as $cart)
                        <tr>
                            <td class="no">{{$no+=1}}</td>
                            <td class="desc">
                                <h3>{{ $cart->product_name }}</h3>
                            </td>
                            <td class="unit">@money($cart->harga)</td>
                            <td class="qty">{{$cart->qty}}</td>
                            <td class="total">@money($cart->sub_total)</td>
                        </tr>
                    @endforeach
                </tbody>
                @php
                    $diskon = App\Models\Discount::where('store_identifier', $storeTenant->store_identifier)
                                                    ->where('is_active', 1)
                                                    ->first();
                    $pajak =  App\Models\Tax::where('store_identifier', $storeTenant->store_identifier)
                                                ->where('is_active', 1)
                                                ->first();
                @endphp
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">SUBTOTAL (Rp.)</td>
                        <td>@money($invoice->sub_total)</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">DISC. (@if(!empty($diskon->diskon)){{$diskon->diskon}}%@endif)</td>
                        <td>@money($invoice->diskon)</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">PAJAK (@if(!empty($pajak->pajak)){{$pajak->pajak}}%@endif)</td>
                        <td>@money($invoice->pajak)</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">GRAND TOTAL (Rp.)</td>
                        @php
                            $total = $invoice->sub_total+$invoice->pajak;
                        @endphp
                        <td>@money($total)</td>
                    </tr>
                    @if ($invoice->jenis_pembayaran == "Tunai")
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">NOMINAL BAYAR (Rp.)</td>
                            <td>@money($invoice->nominal_bayar)</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">KEMBALIAN (Rp.)</td>
                            <td>@money($invoice->kembalian)</td>
                        </tr>
                    @endif
                </tfoot>
            </table>
            <div id="thanks">Terima Kasih!</div>
            @if ($invoice->jenis_pembayaran == "Qris" || is_null($invoice->qris_data) || !empty($invoice->qris_data) || $invoice->qris_data != "" || $invoice->qris_data != NULL)
                @if ($invoice->status_pembayaran == 0)
                    <div id="notices">
                        <div>Scan di sini untuk membayar pesanan anda:</div>
                        <!-- <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div> -->
                        <div class="notice">
                            <img width="120`" src="https://visipos.id/public/qrcode/{{$invoice->nomor_invoice}}.png">
                        </div>
                    </div>
                @endif
            @endif
        </main>
        <footer>
            Invoice was created on a computer and is valid without the signature and seal.
        </footer>
    </body>
</html>