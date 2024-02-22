<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>VPOS | Marketing - Dashboard</title>
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


                document.getElementById('enable_manual_batcode').onclick = function() {
                    const barcode_txt = document.getElementById('barcode');
                    if (barcode_txt.readOnly) {
                        barcode_txt.readOnly = false;
                        this.innerHTML = "Masukkan Barcode via Scanner";
                        // console.log('✅ element is read-only');
                    } else {
                        // console.log('⛔️ element is not read-only');
                        this.innerHTML = "Input Barcode Manual";
                        barcode_txt.value = "";
                        barcode_txt.readOnly = true;
                    }
                    // document.getElementById('myInput').readOnly = false;
                };

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

            // Author: Neel Bhanushali <neal.bhanushali@gmail.com>
            document.addEventListener('keydown', function(e) {
                // add scan property to window if it does not exist
                if(!window.hasOwnProperty('scan')) {
                    window.scan = []
                }
                
                // if key stroke appears after 10 ms, empty scan array
                if(window.scan.length > 0 && (e.timeStamp - window.scan.slice(-1)[0].timeStamp) > 10) {
                    window.scan = []
                }
                
                // if key store is enter and scan array contains keystrokes
                // dispatch `scanComplete` with keystrokes in detail property
                // empty scan array after dispatching event
                if(e.key === "Enter" && window.scan.length > 0) {
                    let scannedString = window.scan.reduce(function(scannedString, entry) {
                        return scannedString + entry.key
                    }, "")
                    window.scan = []
                    return document.dispatchEvent(new CustomEvent('scanComplete', {detail: scannedString}))
                }
                
                // do not listen to shift event, since key for next keystroke already contains a capital letter
                // or to be specific the letter that appears when that key is pressed with shift key
                if(e.key !== "Shift") {
                    // push `key`, `timeStamp` and calculated `timeStampDiff` to scan array
                    let data = JSON.parse(JSON.stringify(e, ['key', 'timeStamp']))
                    data.timeStampDiff = window.scan.length > 0 ? data.timeStamp - window.scan.slice(-1)[0].timeStamp : 0;

                    window.scan.push(data)
                }
            })
            // listen to `scanComplete` event on document
            document.addEventListener('scanComplete', function(e) { console.log(e.detail) })
        </Script>
    </body>
</html>