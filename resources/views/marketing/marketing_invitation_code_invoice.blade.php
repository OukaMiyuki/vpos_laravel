<x-marketing-layout>

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
                                                <img src="assets/images/logo-light.png" alt="" height="22">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="float-end">
                                    <h4 class="m-0 d-print-none">Withdrawal Invoice</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <p><b>Hello, Stanley Jones</b></p>
                                        <p class="text-muted">
                                            Berikut terlampir bukti invoice penarikan saldo untuk merchant Toko Bengkel Surabaya. Dokumen ini menjadi bukti penarikan yang dapat dipergunakan sebagai mana mestinya.
                                        </p>
                                    </div>

                                </div><!-- end col -->
                                <div class="col-md-4 offset-md-2">
                                    <div class="mt-3 float-end">
                                        <table>
                                            <tr>
                                                <td><p><strong>Withdraw Date</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p><span>&nbsp;&nbsp;&nbsp;&nbsp;Jan 17, 2016</span></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Withdraw Date</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p>&nbsp;&nbsp;&nbsp;&nbsp;<span class="badge bg-success">Paid</span></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><strong>Withdraw No.</strong></p></td>
                                                <td><p><strong>&nbsp;&nbsp;&nbsp;&nbsp;:</strong></p></td>
                                                <td><p>&nbsp;&nbsp;&nbsp;&nbsp;<span>000028 </span></p></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <h6>Billing Address</h6>
                                    <address>
                                        Stanley Jones<br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        <abbr title="Phone">P:</abbr> (123) 456-7890
                                    </address>
                                </div> <!-- end col -->

                                <div class="col-sm-6">
                                    <h6>Shipping Address</h6>
                                    <address>
                                        Stanley Jones<br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        <abbr title="Phone">P:</abbr> (123) 456-7890
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
                                                    <th width="5%">#</th>
                                                    <th width="30%">Nominal</th>
                                                    <th width="15%">Tanggal Penarikan</th>
                                                    <th width="10%">Pajak 2%</th>
                                                    <th width="10%">Biaya Admin 2%</th>
                                                    <th width="30%" class="text-end">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <b>RP. 1.000.000,00</b>
                                                    </td>
                                                    <td>02-03-2024</td>
                                                    <td>Rp. 5.000,00</td>
                                                    <td>RP. 1.500,00</td>
                                                    <td class="text-end">Rp. 1.000.000</td>
                                                </tr>
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
                                    <div class="float-end">
                                        <p><b>Sub-total:</b> <span class="float-end">Rp. 1.000.000,00</span></p>
                                        <p><b>Discount (10%):</b> <span class="float-end"> &nbsp;&nbsp;&nbsp; $459.75</span></p>
                                        <h3>Rp. 1.000.000,00</h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="mt-4 mb-1">
                                <div class="text-end d-print-none">
                                    <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer me-1"></i> Print</a>
                                    <a href="#" class="btn btn-info waves-effect waves-light">Submit</a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row --> 
            
        </div>
    </div>

</x-marketing-layout>