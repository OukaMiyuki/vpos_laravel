<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>VPOS | Kasir - Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/logo/Logo2.png') }}">
        <link href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Plugins css -->
        <link href="{{ asset('assets/libs/fullcalendar/main.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />
        {{-- Custom Form CSS --}}
        <link href="{{ asset('assets/libs/mohithg-switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Bootstrap css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>
        <!-- icons -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Head js -->
        <script src="{{ asset('assets/js/head.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    </head>
    <!-- body start -->
    <body data-layout-mode="default" data-theme="light" data-topbar-color="dark" data-menu-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Topbar Start -->
            @include('body.header')
            <!-- end Topbar -->
            <!-- ========== Left Sidebar Start ========== -->
            @include('body.sidebar')
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                {{ $slot }}
                <!-- content -->
                <!-- Footer Start -->
                @include('body.footer')
                <!-- end Footer -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->
        <!-- Right Sidebar -->
        @include('body.right-sidebar')
        <!-- /Right-bar -->
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <!-- Plugins js-->
        <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>
        <!-- Dashboar 1 init js-->
        <script src="{{ asset('assets/js/pages/dashboard-1.init.js') }}"></script>
        <!-- App js-->
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
        <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('assets/libs/fullcalendar/main.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/calendar.init.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        {{-- Custom Form JS --}}

        <script src="{{ asset('assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>
        <script src="{{ asset('assets/libs/mohithg-switchery/switchery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/multiselect/js/jquery.multi-select.js') }}"></script>
        <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jquery-mockjax/jquery.mockjax.min.js') }}"></script>
        <script src="{{ asset('assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

        {{-- ON SCAN --}}
        <script src="{{ asset('assets/js/pages/onscan.js') }}"></script>

        <!-- Init js-->
        <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>

        {{-- Custom FOrm JS --}}

        <script>
            @if(Session::has('message'))
                var type = "{{ Session::get('alert-type','info') }}"
                switch(type){
                    case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;
                
                    case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;
                
                    case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;
                
                    case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break; 
                }
            @endif 
        </script>
        <Script type="text/javascript">
            $(document).ready(function(){
                $('#image').change(function(e){
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('#showImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                });

                $(document).on("click", "#detailsupplier", function() {
                    var nama_supplier = $(this).data('nama');
                    var email_supplier = $(this).data('email');
                    var phone_supplier = $(this).data('phone');
                    var alamat_supplier = $(this).data('alamat');
                    var keterangan = $(this).data('keterangan');
                    $("#show #nama_supplier").val(nama_supplier);
                    $("#show #phone").val(phone_supplier);
                    $("#show #email").val(email_supplier);
                    $("#show #alamat").val(alamat_supplier);
                    $("#show #keterangan").val(keterangan);
                });

                $(document).on("click", "#editsupplier", function() {
                    var id = $(this).data('id');
                    var nama_supplier = $(this).data('nama');
                    var email_supplier = $(this).data('email');
                    var phone_supplier = $(this).data('phone');
                    var alamat_supplier = $(this).data('alamat');
                    var keterangan = $(this).data('keterangan');
                    $("#show #id").val(id);
                    $("#show #nama_supplier").val(nama_supplier);
                    $("#show #phone").val(phone_supplier);
                    $("#show #email").val(email_supplier);
                    $("#show #alamat").val(alamat_supplier);
                    $("#show #keterangan").val(keterangan);
                });

                $(document).on("click", "#editkategori", function() {
                    var id = $(this).data('id');
                    var nama = $(this).data('nama');
                    $("#show #id").val(id);
                    $("#show #category").val(nama);
                });

                $(document).on("click", "#editbatch", function() {
                    var id = $(this).data('id');
                    var kode = $(this).data('kode');
                    var keterangan = $(this).data('keterangan');
                    $("#show #id").val(id);
                    $("#show #name").val(kode);
                    $("#show #keterangan").val(keterangan);
                });

                $(function(){
                    var dtToday = new Date();
                    
                    var month = dtToday.getMonth() + 1;
                    var day = dtToday.getDate();
                    var year = dtToday.getFullYear();
                    if(month < 10)
                        month = '0' + month.toString();
                    if(day < 10)
                        day = '0' + day.toString();
                    
                    var maxDate = year + '-' + month + '-' + day;
                    $('#t_beli').attr('max', maxDate);
                });


                // document.getElementById('enable_manual_batcode').onclick = function() {
                //     const barcode_txt = document.getElementById('barcode');
                //     if (barcode_txt.readOnly) {
                //         barcode_txt.readOnly = false;
                //         this.innerHTML = "Masukkan Barcode via Scanner";
                //         // console.log('✅ element is read-only');
                //     } else {
                //         // console.log('⛔️ element is not read-only');
                //         this.innerHTML = "Input Barcode Manual";
                //         barcode_txt.value = "";
                //         barcode_txt.readOnly = true;
                //     }
                //     // document.getElementById('myInput').readOnly = false;
                // };

                // var barcode = "";
                // var interval = "";

                // document.addEventListener('keydown', function(evt){
                //     if(interval)
                //         clearInterval(interval);
                //     if(evt.code == "Enter") {
                //         if(barcode)
                //             handleBarcode(barcode);
                //         barcode = '';
                //         return;
                //     }
                //     if(evt.key != 'Shift')
                //         barcode += evt.key;
                //     interval = setInterval( ()=> barcode = '', 20 );
                // });

                // function handleBarcode(scanned_barcode){
                //     console.log(scanned_barcode);
                // }
                
            });
            $("#tunai_text").hide();
            $("#nominal").attr("disabled", "disabled"); 
            $("#kembalian").attr("disabled", "disabled");
            $(document).ready(function(){
                $('#pembayaran').on('change', function() {
                    if ( this.value == 'Tunai') {
                        $("#tunai_text").show();
                        $("#nominal").removeAttr("disabled"); 
                        $("#kembalian").removeAttr("disabled"); 
                    }
                    else {
                        $("#tunai_text").hide();
                        $("#nominal").val("");
                        $("#nominal").attr("disabled", "disabled"); 
                        $("#kembalian").attr("disabled", "disabled");
                    }
                });
            });

            // Enable scan events for the entire document
            onScan.attachTo(document, {
                suffixKeyCodes: [13], // enter-key expected at the end of a scan
                reactToPaste: true, // Compatibility to built-in scanners in paste-mode (as opposed to keyboard-mode)
                onScan: function(sCode, iQty) { // Alternative to document.addEventListener('scan')
                    alert('Scanned: ' + iQty + 'x ' + sCode); 
                    // $("#nominal").val(sCode);
                    $('#pos').DataTable().search(sCode).draw();
                    var theTbl = document.getElementById('pos');
                    var Cells = theTbl.getElementsByTagName("td");
                    console.log(Cells[2].innerText);
                    if(Cells[2].innerText == sCode){
                        document.getElementById('cartForm').submit();
                    }
                },
                onKeyDetect: function(iKeyCode){ // output all potentially relevant key events - great for debugging!
                    console.log('Pressed: ' + iKeyCode);
                }
            });
            // Register event listener
            // document.addEventListener('scan');
            // var rupiah = document.getElementById("nominal");
            // rupiah.addEventListener("keyup", function(e) {
            //     rupiah.value = formatRupiah(this.value, "Rp. ");
            // });

            // var kembalian = document.getElementById("kembalian");
            // kembalian.addEventListener("keyup", function(e) {
            //     kembalian.value = formatRupiah(this.value, "Rp. ");
            // });

            // function formatRupiah(angka, prefix) {
            // var number_string = angka.replace(/[^,\d]/g, "").toString(),
            //     split = number_string.split(","),
            //     sisa = split[0].length % 3,
            //     rupiah = split[0].substr(0, sisa),
            //     ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            // if (ribuan) {
            //     separator = sisa ? "." : "";
            //     rupiah += separator + ribuan.join(".");
            // }

            //     rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            //     return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
            // }
            
            $(document).ready(function() {
                let kembaliantxt = document.getElementById("kembalian");
                $('#nominal').on("input", function() {
                    let nominal = $('#nominal').val();
                    let subttl = "{{ Cart::total() }}";
                    let angka_sub_total = subttl.replace(/[^0-9.-]+/g,"");
                    let subtotal = parseInt(angka_sub_total);
                    let kembalian = nominal-subtotal;
                    if (kembalian >= 0){
                        // $('#kembalian').val(kembalian);
                        kembaliantxt.value = formatRupiah(kembalian, "Rp. ");
                    } else {
                        $('#kembalian').val(0);
                    }
                });
            });

            function formatRupiah(angka, prefix) {
                var number_string = angka.toString().replace(/[^,\d]/g, ""),
                    split = number_string.split(","),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                if (ribuan) {
                    separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
            }

            $(document).ready(function() {
                $("#pembayaran").on('change', function() {
                    if ($(this).val() == ''){
                        $("#formCheckout").attr('disabled',true);
                    } else {
                        $("#formCheckout").attr('disabled',false);
                        $('#formCheckout').on('click', function(e){
                            if($("#pembayaran").val() == 'Tunai'){
                                if($("#nominal").val().length > 0 && $("#kembalian").val().length > 0){
                                    $("#checkoutProcess #jenisPembayaran").val($("#pembayaran").val());
                                    $("#checkoutProcess #nominalText").val($("#nominal").val());
                                    $("#checkoutProcess #kembalianText").val($("#kembalian").val());
                                    $('#processInvoice').modal('show');
                                    e.preventDefault();
                                }
                            } else if($("#pembayaran").val() == 'Qris'){
                                $("#checkoutProcess #jenisPembayaran").val($("#pembayaran").val());
                                $('#processInvoice').modal('show');
                                e.preventDefault();
                            }
                        });
                    }
                });
            });

        </Script>
    </body>
</html>