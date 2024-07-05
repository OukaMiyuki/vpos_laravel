<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Invoice Transaksi {{$invoice->nomor_invoice}}</title>
        <link rel="stylesheet" href="style.css" media="all" />
        <style>
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
                width: 21cm;
                height: 29.7cm;
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
                margin-bottom: 50px;
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
                font-size: 2.4em;
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
                padding: 20px;
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
                font-size: 1.2em;
                font-weight: normal;
                margin: 0 0 0.2em 0;
            }

            table .no {
                color: #FFFFFF;
                font-size: 1.6em;
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
                font-size: 1.2em;
            }

            table tbody tr:last-child td {
            border: none;
            }

            table tfoot td {
                padding: 10px 20px;
                background: #FFFFFF;
                border-bottom: none;
                font-size: 1.2em;
                white-space: nowrap;
                border-top: 1px solid #AAAAAA;
            }

            table tfoot tr:first-child td {
                border-top: none;
            }

            table tfoot tr:last-child td {
                color: #f76e05 !important;
                font-size: 1.4em;
                /* border-top: 1px solid #f76e05 !important; */
            }

            table tfoot tr td:first-child {
                border: none;
            }

            #thanks {
                font-size: 2em;
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
                <img src="{{ !empty($storeTenant->photo) ? Storage::url('images/profile/'.$storeTenant->photo) : asset('assets/images/logo/Logo2.png') }}">
                {{-- <img src="logo.png"> --}}
            </div>
            <div id="company">
                <h2 class="name">Company Name</h2>
                <div>455 Foggy Heights, AZ 85004, US</div>
                <div>(602) 519-0450</div>
                <div><a href="mailto:company@example.com">company@example.com</a></div>
            </div>
            </div>
        </header>
        <main>
            <div id="details" class="clearfix">
                <div id="client">
                    <div class="to">INVOICE TO:</div>
                    <h2 class="name">John Doe</h2>
                    <div class="address">796 Silver Harbour, TX 79273, US</div>
                    <div class="email"><a href="mailto:john@example.com">john@example.com</a></div>
                </div>
                <div id="invoice">
                    <h1>INVOICE 3-2-1</h1>
                    <div class="date">Date of Invoice: 01/06/2014</div>
                    <div class="date">Due Date: 30/06/2014</div>
                </div>
            </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th class="no">#</th>
                        <th class="desc">DESCRIPTION</th>
                        <th class="unit">UNIT PRICE</th>
                        <th class="qty">QUANTITY</th>
                        <th class="total">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="no">01</td>
                        <td class="desc">
                            <h3>Website Design</h3>
                            Creating a recognizable design solution based on the company's existing visual identity
                        </td>
                        <td class="unit">$40.00</td>
                        <td class="qty">30</td>
                        <td class="total">$1,200.00</td>
                    </tr>
                    <tr>
                        <td class="no">02</td>
                        <td class="desc">
                            <h3>Website Development</h3>
                            Developing a Content Management System-based Website
                        </td>
                        <td class="unit">$40.00</td>
                        <td class="qty">80</td>
                        <td class="total">$3,200.00</td>
                    </tr>
                    <tr>
                        <td class="no">03</td>
                        <td class="desc">
                            <h3>Search Engines Optimization</h3>
                            Optimize the site for search engines (SEO)
                        </td>
                        <td class="unit">$40.00</td>
                        <td class="qty">20</td>
                        <td class="total">$800.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">SUBTOTAL</td>
                        <td>$5,200.00</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">TAX 25%</td>
                        <td>$1,300.00</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">GRAND TOTAL</td>
                        <td>$6,500.00</td>
                    </tr>
                </tfoot>
            </table>
            <div id="thanks">Terima Kasih!</div>
            <div id="notices">
                <div>Scan di sini untuk membayar pesanan anda:</div>
                <!-- <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div> -->
				<div class="notice">
					<img width="200" src="{{public_path('qrcode/'.$invoice->nomor_invoice.'.png')}}">
				</div>
            </div>
        </main>
        <footer>
            Invoice was created on a computer and is valid without the signature and seal.
        </footer>
    </body>
</html>