<!DOCTYPE html>
<html lang="en">
    <head>
        {{-- <link href="{{ asset('assets/css/print.css') }}" rel="stylesheet" type="text/css" /> --}}
        <style>
            /* @font-face {
    font-family: 'LCD';
    src: url('../fonts/LCD Solid 1.12.woff') format('woff'),
         url('../fonts/LCD Solid 1.12.ttf') format('truetype');
}  */
body {
    font-size:14px;
    /* font-family: LCD; */
    margin:0;
    padding:1rem;
    width: 58mm; text-align: left;
}
#invoice-POS{
    /* border: 1px solid #ddd; */
    /* padding: 1rem; */
    margin: 0 auto;
    width: 100%;
    /* page-break-after:always; */
    background: #FFF;
}
#invoice-POS ::selection {
    background: #f31544;
    color: #FFF;
}
#invoice-POS ::moz-selection {
    background: #f31544;
    color: #FFF;
}
#invoice-POS h1 {
    font-size: 1.5em;
    color: #000000 !important;
}
#invoice-POS h2.storeTitle {
    font-size: 1em;
}
#invoice-POS h3 {
    font-size: 0.9em;
    font-weight: 600;
    line-height: 0.8em;
}
#invoice-POS p.customer {
    font-size: .7em;
    color: #000000 !important; 
    line-height: 0em;
    font-weight: 800;
}
#invoice-POS #legalcopy p {
    font-size: .7em;
    color: #000000 !important;
    font-weight: 700 !important;
    line-height: 1.2em;
    text-align: center;
}
#invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
    border-bottom: 1px solid #EEE;
}
#invoice-POS #top {
    min-height: 100px;
}
#invoice-POS #mid {
    min-height: 80px;
}
#invoice-POS #bot {
    min-height: 50px !important;
}
#invoice-POS #top .logo {
    height: 50px;
    width: 50px;
    background: url() no-repeat;
    background-size: 50px 50px;
}
#invoice-POS .info {
    display: block;
    margin-left: 0;
}
#invoice-POS .title {
    float: right;
}
#invoice-POS .title p {
    text-align: right;
}
#invoice-POS table {
    width: 100%;
    border-collapse: collapse;
}
#invoice-POS .tabletitle {
    font-size: .48em;
    background: #EEE;
    font-weight: 700;
}
#invoice-POS tr.pembayaran {
    line-height: .1em !important;
    font-size: .45em !important;
}
#invoice-POS tr.pembayaran h2 {
    font-weight: 700;
}
#invoice-POS td.payment, #invoice-POS td.sub-total {
    text-align: right;
}
#invoice-POS td.qty {
    text-align: center;
}
#invoice-POS .service {
    border-bottom: 1px solid #EEE;
}
#invoice-POS .item {
    text-align: left !important;
    width: 24mm;
}
#invoice-POS .itemtext {
    font-size: .65em;
    font-weight: 600;
}
#invoice-POS #legalcopy {
    margin-top: 5mm;
}
h2.storeTitle {
    font-weight: 700 !important;
}
p.storeAddress {
    font-size: .78em !important; 
    font-weight: 600 !important;
}
p.customerTitle {
    font-weight: 600 !important;
}
table.customerInfo {
    margin-bottom: 1em; 
    font-weight: 700 !important;
}
h2.itemTitle{
    font-weight: 700 !important;
}
.tabletitle th.sub-total {
    text-align: right !important;
    width: 120px;
}
@media print {
    body { 
        font-size:14px;
        body { font-family: monospace; }
        body.struk                 { width: 58mm; text-align: left;}
        body.struk .sheet          { padding: 2mm; }
        /* font-family: LCD;  */
    }
    /* body { width: 58mm !important;} */
    /* body {
        visibility: hidden;
    }
    #invoice-POS {
        width: 44mm;
        visibility: visible;
        position: absolute;
        left: 0;
        top: 0;
    } */
    /* #print-button {
        display: none;
    } */
    /* body.struk .sheet          { padding: 2mm; }
    .txt-left { text-align: left;}
    .txt-center { text-align: center;}
    .txt-right { text-align: right;} */
}

table.payments { width: 100%; margin-bottom: 20px; }
/* .short {
    width: 40%
}
.long {
    width: 40%;
} */

thead.items-thead {
    border-top: double #000000;
    border-bottom: double #000000;
}

tbody.items-tbody{
    border-bottom: double #000000;
}

div.qris {
    text-align: center;
}
        </style>
    </head>
    <body class="struk">
        {{-- <div id="print-button">
			<button class="w3-button w3-light-green">Print</button></button>
		</div> --}}
        <div id="invoice-POS">
            <center id="top">
                <div class="logo"></div>
                @php
                    $store = App\Models\StoreDetail::where('id_tenant', auth()->user()->id)
                                                ->where('email', auth()->user()->email)
                                                ->first();
                @endphp
                <div class="info">
                    <h2 class="storeTitle">{{ $store->name }}</h2>
					<p  class="storeAddress">{{ $store->alamat }}</p>
                </div>
            </center>
            @php
                $field = App\Models\TenantField::where('store_identifier', $store->store_identifier)->first();
            @endphp
            @if(!empty($field->id))
                @if ( !empty($invoice->invoiceField->content1) || !empty($invoice->invoiceField->content2) || !empty($invoice->invoiceField->content3) || !empty($invoice->invoiceField->content4) || !empty($invoice->invoiceField->content5))
                    <div id="mid">
                        <div class="info">
                            <h3 class="customerTitle">Customer Info</h3>
                            <table class="customerInfo">
                                @if (!empty($invoice->invoiceField->content1))
                                    <tr class="custom-field">
                                        <td width="35%"><p class="customer">{{ $field->baris1 }}</p></td>
                                        <td width="5%"><p class="customer">:</p></td>
                                        <td width="60%"><p class="customer">{{ $invoice->invoiceField->content1 }}</p></td>
                                    </tr>
                                @endif
                                @if (!empty($invoice->invoiceField->content2))
                                    <tr class="custom-field">
                                        <td width="35%"><p class="customer">{{ $field->baris2 }}</p></td>
                                        <td width="5%"><p class="customer">:</p></td>
                                        <td width="60%"><p class="customer">{{ $invoice->invoiceField->content2 }}</p></td>
                                    </tr>
                                @endif
                                @if (!empty($invoice->invoiceField->content3))
                                    <tr class="custom-field">
                                        <td width="35%"><p class="customer">{{ $field->baris3 }}</p></td>
                                        <td width="5%"><p class="customer">:</p></td>
                                        <td width="60%"><p class="customer">{{ $invoice->invoiceField->content3 }}</p></td>
                                    </tr>
                                @endif
                                @if (!empty($invoice->invoiceField->content4))
                                    <tr class="custom-field">
                                        <td width="35%"><p class="customer">{{ $field->baris4 }}</p></td>
                                        <td width="5%"><p class="customer">:</p></td>
                                        <td width="60%"><p class="customer">{{ $invoice->invoiceField->content4 }}</p></td>
                                    </tr>
                                @endif
                                @if (!empty($invoice->invoiceField->content5))
                                    <tr class="custom-field">
                                        <td width="35%"><p class="customer">{{ $field->baris5 }}</p></td>
                                        <td width="5%"><p class="customer">:</p></td>
                                        <td width="60%"><p class="customer">{{ $invoice->invoiceField->content5 }}</p></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                @else
                    <br>
                    <br>
                @endif
            @else
                <br>
                <br>
            @endif
            <!--End Invoice Mid-->
            <div id="bot">
                <div id="table">
                    <table class="items-table">
                        <thead class="items-thead">
                            <tr class="tabletitle">
                                <th class="item">
                                    <h2 class="itemTitle">Item</h2>
                                </th>
                                <th class="Hours qty">
                                    <h2 class="itemTitle">Qty</h2>
                                </th>
                                <th class="Rate sub-total" width="120">
                                    <h2 class="itemTitle">Sub Total</h2>
                                </th>
                            </tr>
                        </thead>
                        @php
                            $total=0;
                        @endphp
                        @foreach ($invoice->shoppingCart as $cart)
                        <tbody class="items-tbody">
                            <tr class="service">
                                <td class="tableitem">
                                    <p class="itemtext">{{ $cart->product_name }}</p>
                                </td>
                                <td class="tableitem qty">
                                    <p class="itemtext">{{ $cart->qty }}</p>
                                </td>
                                <td class="tableitem sub-total">
                                    <p class="itemtext">{{ $cart->sub_total }}</p>
                                </td>
                            </tr>
                            @php
                                $total+=$cart->sub_total;
                            @endphp
                        </tbody>
                        @endforeach
                    </table>
                    @php
                        $diskon = App\Models\Discount::where('store_identifier', $store->store_identifier)
                                                        ->where('is_active', 1)
                                                        ->first();
                        $pajak =  App\Models\Tax::where('store_identifier', $store->store_identifier)
                                                    ->where('is_active', 1)
                                                    ->first();
                    @endphp
                    <table class="payments" style="width:100%;">
                        <colgroup>
                            <col class="short" />
                            <col span="2" class="long" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tabletitle pembayaran">
                                <td></td>
                                <td class="Rate">
                                    <h2>Sub Total</h2>
                                </td>
                                <td class="payment">
                                    <h2>{{ $total }}</h2>
                                </td>
                            </tr>
                            <tr class="tabletitle pembayaran">
                                <td></td>
                                <td class="Rate">
                                    <h2>Disc.(@if(!empty($diskon->diskon)){{$diskon->diskon}}%@endif)</h2>
                                </td>
                                <td class="payment">
                                    <h2>{{$invoice->diskon}}</h2>
                                </td>
                            </tr>
                            <tr class="tabletitle pembayaran">
                                <td></td>
                                <td class="Rate">
                                    <h2>Total</h2>
                                </td>
                                <td class="payment">
                                    <h2>{{ $invoice->sub_total }}</h2>
                                </td>
                            </tr>
                            <tr class="tabletitle pembayaran">
                                <td></td>
                                <td class="Rate">
                                    <h2>Pajak(@if(!empty($pajak->pajak)){{$pajak->pajak}}%@endif)</h2>
                                </td>
                                <td class="payment">
                                    <h2>{{$invoice->pajak}}</h2>
                                </td>
                            </tr>
                            <tr class="tabletitle pembayaran">
                                <td></td>
                                <td class="Rate">
                                    <h2>Pembayaran</h2>
                                </td>
                                <td class="payment">
                                    <h2>{{ $invoice->jenis_pembayaran}}</h2>
                                </td>
                            </tr>
                            <tr class="tabletitle pembayaran">
                                <td></td>
                                <td class="Rate">
                                    <h2>Bayar</h2>
                                </td>
                                <td class="payment">
                                    <h2>{{ $invoice->nominal_bayar }}</h2>
                                </td>
                            </tr>
                            @if ($invoice->jenis_pembayaran == "Tunai")
                                <tr class="tabletitle pembayaran">
                                    <td></td>
                                    <td class="Rate">
                                        <h2>Kembalian</h2>
                                    </td>
                                    <td class="payment">
                                        <h2>{{ $invoice->kembalian }}</h2>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if ($invoice->jenis_pembayaran == "Qris")
                    @if ($invoice->status_pembayaran == 0)
                        <div class="qris">
                            <img src="data:image/png;base64,{{ $qrcode }}">
                            {{-- {!! QrCode::size(200)->generate($invoice->qris_data) !!} --}}
                        </div>  
                    @endif
                @endif
                <div id="legalcopy">
                    <p class="legal"><strong>Terima Kasih atas kunjungan anda!</strong>  Harap simpan baik baik bukti pembayaran ini, untuk keperluan garansi dan lain sebagainya. </p>
                </div>
            </div>
        </div>
        {{-- <script src="{{ asset('assets/js/pos.js') }}"></script> --}}
    </body>
</html>