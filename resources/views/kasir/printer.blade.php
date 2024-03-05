<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style>
            body {font-size:14px;font-family: monospace;margin:0;padding:0;}
			#print-button {
                margin: 1em 0 1em 0;
                display: flex;
                justify-content: center;
			}
            #print-button button {
                width: 18%;
			}
            #invoice-POS{
				border: 1px solid #ddd;
				padding: 2mm;
				margin: 0 auto;
				width: 58mm;
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
            #invoice-POS h2 {
            	font-size: .9em;
            }
            #invoice-POS h3 {
				font-size: 0.9em;
				font-weight: 600;
				line-height: 0.8em;
            }
            #invoice-POS p.customer {
				font-size: 0.57em;
				color: #000000 !important; 
				line-height: 0em;
                font-weight: 800;
            }
			#invoice-POS #legalcopy p {
				font-size: 0.57em;
				color: #000000 !important;
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
				background: url(https://codeforui.com/posts/dummylogo.png) no-repeat;
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
				font-size: 0.6em;
				background: #EEE;
                font-weight: 700;
            }
			#invoice-POS tr.pembayaran {
				line-height: .1em !important;
				font-size: .6em !important;
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
            	width: 24mm;
            }
            #invoice-POS .itemtext {
            	font-size: 0.5em;
            }
            #invoice-POS #legalcopy {
            	margin-top: 5mm;
            }
            @media print {
                body { font-size:14px;font-family: monospace; } */
                body { width: 58mm !important;}
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
        </style>
    </head>
    <body onload="printOut()">
        {{-- <div id="print-button">
			<button class="w3-button w3-light-green">Print</button></button>
		</div> --}}
        <div id="invoice-POS">
            <center id="top">
                <div class="logo"></div>
                <div class="info">
                    <h2 style="font-weight: 700 !important;">@if(!empty(auth()->user()->tenant->storeDetail->name)){{ auth()->user()->tenant->storeDetail->name }}@endif</h2>
					<p style="font-size: .6em !important; font-weight: 600 !important;">@if(!empty(auth()->user()->tenant->storeDetail->alamat)){{ auth()->user()->tenant->storeDetail->alamat }}@endif</p>
                </div>
            </center>
            <div id="mid">
                <div class="info">
                    <h3 style="font-weight: 600 !important;">Customer Info</h3>
                    <!-- <p> 
                        Nama : Ahmad Riza Syahputra</br>
						Alamat : Jl. Janti Sidoarjo No. 01 Waru</br>
						Kota : Surabaya</br>
                        Email : xyz@gmail.com</br>
                        Phone : 085156719832</br>
                    </p> -->
					<table style="margin-bottom: 1em; font-weight: 600 !important;">
                        @php
                            $field = App\Models\TenantField::where('id_tenant', auth()->user()->id_tenant)->first();
                        @endphp
                        @if (!empty($field))
                            <tr class="custom-field">
                                <td><p class="customer">{{ $field->baris1 }}</p></td>
                                <td><p class="customer">:</p></td>
                                <td><p class="customer">{{ $invoice->invoiceField->content1 }}</p></td>
                            </tr>
                            <tr class="custom-field">
                                <td><p class="customer">{{ $field->baris2 }}</p></td>
                                <td><p class="customer">:</p></td>
                                <td><p class="customer">{{ $invoice->invoiceField->content2 }}</p></td>
                            </tr>
                            <tr class="custom-field">
                                <td><p class="customer">{{ $field->baris3 }}</p></td>
                                <td><p class="customer">:</p></td>
                                <td><p class="customer">{{ $invoice->invoiceField->content3 }}</p></td>
                            </tr>
                            <tr class="custom-field">
                                <td><p class="customer">{{ $field->baris4 }}</p></td>
                                <td><p class="customer">:</p></td>
                                <td><p class="customer">{{ $invoice->invoiceField->content4 }}</p></td>
                            </tr>
                            <tr class="custom-field">
                                <td><p class="customer">{{ $field->baris5 }}</p></td>
                                <td><p class="customer">:</p></td>
                                <td><p class="customer">{{ $invoice->invoiceField->content5 }}</p></td>
                            </tr>
                        @endif
					</table>
                </div>
            </div>
            <!--End Invoice Mid-->
            <div id="bot">
                <div id="table" style="font-weight: 600 !important;">
                    <table>
                        <tr class="tabletitle">
                            <td class="item">
                                <h2 style="font-weight: 600 !important;">Item</h2>
                            </td>
                            <td class="Hours qty">
                                <h2 style="font-weight: 600 !important;">Qty</h2>
                            </td>
                            <td class="Rate sub-total" width="120" style="width: 120px;">
                                <h2 style="font-weight: 600 !important;">Sub Total</h2>
                            </td>
                        </tr>
                        @php
                            $total=0;
                        @endphp
                        @foreach ($invoice->shoppingCart as $cart)
                            <tr class="service">
                                <td class="tableitem">
                                    <p class="itemtext" style="font-size: .6em;">{{ $cart->product_name }}</p>
                                </td>
                                <td class="tableitem qty">
                                    <p class="itemtext" style="font-size: .6em;">{{ $cart->qty }}</p>
                                </td>
                                <td class="tableitem sub-total">
                                    <p class="itemtext" style="font-size: .6em;">{{ $cart->sub_total }}</p>
                                </td>
                            </tr>
                            @php
                                $total+=$cart->sub_total;
                            @endphp
                        @endforeach
                        {{-- <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">Communication</p>
                            </td>
                            <td class="tableitem qty">
                                <p class="itemtext">5</p>
                            </td>
                            <td class="tableitem sub-total">
                                <p class="itemtext">Rp. 100.000</p>
                            </td>
                        </tr>
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">Asset Gathering</p>
                            </td>
                            <td class="tableitem qty">
                                <p class="itemtext">3</p>
                            </td>
                            <td class="tableitem sub-total">
                                <p class="itemtext">Rp. 200.000</p>
                            </td>
                        </tr>
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">Design Development</p>
                            </td>
                            <td class="tableitem qty	">
                                <p class="itemtext">5</p>
                            </td>
                            <td class="tableitem sub-total">
                                <p class="itemtext">Rp. 1.000.0000</p>
                            </td>
                        </tr>
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">Animation</p>
                            </td>
                            <td class="tableitem qty">
                                <p class="itemtext">20</p>
                            </td>
                            <td class="tableitem sub-total">
                                <p class="itemtext">Rp. 500.000</p>
                            </td>
                        </tr>
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">Animation Revisions</p>
                            </td>
                            <td class="tableitem qty">
                                <p class="itemtext">10</p>
                            </td>
                            <td class="tableitem sub-total">
                                <p class="itemtext">Rp. 300.000</p>
                            </td>
                        </tr> --}}
                        @php
                            $diskon = App\Models\Discount::where('id_tenant', auth()->user()->id_tenant)->where('is_active', 1)->first();
                            $pajak =  App\Models\Tax::where('id_tenant', auth()->user()->id_tenant)->where('is_active', 1)->first();
                        @endphp
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
                                <h2>Sub Total</h2>
                            </td>
                            <td class="payment">
                                <h2>{{ $total }}</h2>
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
                                <h2>Total</h2>
                            </td>
                            <td class="payment">
                                <h2>{{ $invoice->sub_total }}</h2>
                            </td>
                        </tr>
						<tr class="tabletitle pembayaran">
                            <td></td>
                            <td class="Rate">
                                <h2>Pembayaran</h2>
                            </td>
                            <td class="payment">
                                <h2>Tunai</h2>
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
						<tr class="tabletitle pembayaran">
                            <td></td>
                            <td class="Rate">
                                <h2>Kembalian</h2>
                            </td>
                            <td class="payment">
                                <h2>{{ $invoice->kembalian }}</h2>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="legalcopy">
                    <p class="legal" style="font-weight: 700 !important;"><strong>Terima Kasih atas kunjungan anda!</strong>  Harap simpan baik baik bukti pembayaran ini, untuk keperluan garansi dan lain sebagainya. </p>
                </div>
            </div>
        </div>
        <script>
            var lama = 1000;
            t = null;
            function printOut(){
                window.print();
                t = setTimeout("self.close()",lama);
            }
        </script>
    </body>
</html>