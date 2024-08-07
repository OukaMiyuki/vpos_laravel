<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>VPOS | Tenant - Dashboard</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/logo/Logo2.png') }}">
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Plugins css -->
        <link href="{{ asset('assets/libs/fullcalendar/main.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />
        {{-- Custom Form --}}
        <link href="{{ asset('assets/libs/mohithg-switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/selectize/css/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />


        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <!-- App css -->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>
        <!-- icons -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Head js -->
        <script src="{{ asset('assets/js/head.js') }}"></script>
        <link href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pos.css') }}" rel="stylesheet" type="text/css" />
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
        <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/dashboard-1.init.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
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
        <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('assets/libs/fullcalendar/main.min.js') }}"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="{{ asset('assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>
        <script src="{{ asset('assets/libs/mohithg-switchery/switchery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/multiselect/js/jquery.multi-select.js') }}"></script>
        <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jquery-mockjax/jquery.mockjax.min.js') }}"></script>
        <script src="{{ asset('assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/tenant.init.js') }}"></script>
        @if(Route::is('tenant.product.stock.add') || Route::is('tenant.product.stock.edit'))
            <script src="{{ asset('assets/js/pages/onscan.js') }}"></script>
            <Script type="text/javascript" src="{{ asset('assets/js/pages/onscaninit.js') }}"></Script>
        @endif
        @if (Route::is('tenant.pos'))
            <script src="{{ asset('assets/js/pages/onscan.js') }}"></script>
            <Script type="text/javascript" src="{{ asset('assets/js/pages/posinit.js') }}"></Script>
        @endif
        @if (Route::is('tenant.transaction.list.pending.restore'))
            <script src="{{ asset('assets/js/pages/onscan.js') }}"></script>
            <Script type="text/javascript" src="{{ asset('assets/js/pages/posinitrestore.js') }}"></Script>
        @endif
        @if (auth()->user()->id_inv_code != 0)
            <Script type="text/javascript" src="{{ asset('assets/js/pages/mitratenantinit.js') }}"></Script>
        @endif
        <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
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
    </body>
</html>
