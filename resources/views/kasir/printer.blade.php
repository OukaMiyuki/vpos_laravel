<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="{{ asset('assets/css/printposcetak.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        {{-- <div id="print-button">
			<button class="w3-button w3-light-green">Print</button></button>
		</div> --}}
        <div id="invoice-POS">
            <center id="top">
                <div class="logo"></div>
                <div class="info">
                    <h2 class="storeTitle">@if(!empty(auth()->user()->store->name)){{ auth()->user()->store->name }}@endif</h2>
					<p  class="storeAddress">@if(!empty(auth()->user()->store->alamat)){{ auth()->user()->store->alamat }}@endif</p>
                </div>
            </center>
            @php
                $field = App\Models\TenantField::where('store_identifier', auth()->user()->id_store)->first();
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
                        $diskon = App\Models\Discount::where('store_identifier', auth()->user()->id_store)->where('is_active', 1)->first();
                        $pajak =  App\Models\Tax::where('store_identifier', auth()->user()->id_store)->where('is_active', 1)->first();
                    @endphp
                    <table class="payments">
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
                            {!! QrCode::size(200)->generate($invoice->qris_data) !!}
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