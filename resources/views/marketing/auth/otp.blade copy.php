<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>VPOS | Login - Area</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/Logo2.png') }}">
    <!-- Bootstrap css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>
    <!-- icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Head js -->
    <script src="{{ asset('assets/js/head.js') }}"></script>
    <link href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body class="authentication-bg authentication-bg-pattern">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8 col-xl-6">
                    <div class="card bg-pattern">
                        <div class="card-body">
                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="#" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('assets/images/logo/Logo1.png') }}" alt="" height="100">
                                        </span>
                                    </a>
                                    <a href="index.html" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('assets/images/logo/Logo1.png') }}" alt="" height="100">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Terima Kasih telah mendaftar! Harap masukkan kode OTP yang telah dikirim ke email anda!</p>
                            </div>
                            <form action="{{ route('marketing.verification.verify') }}" method="POST">
                                @csrf
                                <div class="row" id="otp">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input required type="text" class="masukan text-center form-control" name="first" id="first" maxlength="1"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input required type="text" class="masukan text-center form-control" name="second" id="second" maxlength="1"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input required type="text" class="masukan text-center form-control" name="third" id="third" maxlength="1"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input required type="text" class="masukan text-center form-control" name="fourth" id="fourth" maxlength="1"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input required type="text" class="masukan text-center form-control" name="fifth" id="fifth" maxlength="1"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input required type="text" class="masukan text-center form-control" name="sixth" id="sixth" maxlength="1"/>
                                        </div>
                                    </div>
                                    <div class="text-center d-grid">
                                        <button class="btn btn-success" type="submit"> Konfirmasi </button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <div class="row">
                                <div class="text-center d-grid">
                                    <form id="resend-code" method="POST" action="{{ route('marketing.verification.send') }}">
                                        @csrf
                                        <button class="btn btn-primary w-100" type="submit"> Kirim Ulang Kode </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p><a href="javascript:{}" onclick="document.getElementById('logout').submit();" class="text-white-50 ms-1">Logout Akun</a></p>
                            <form id="logout" method="POST" action="{{ route('marketing.logout') }}">
                                @csrf
                            </form>
                        </div>
                        <!-- end col -->
                    </div>
                    <p class="text-muted mb-4 mt-3"><strong>*Note : Jika anda tidak menemukan Email berisikan OTP, coba cek pada folder spam.</strong></p>
                    <!-- end row -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
    <footer class="footer footer-alt">
        2015 - <script>document.write(new Date().getFullYear())</script> &copy; UBold theme by <a href="" class="text-white-50">Coderthemes</a> 
    </footer>
    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
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
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            function OTPInput() {
                const inputs = document.getElementsByClassName('masukan');
                for (let i = 0; i < inputs.length; i++) { 
                    inputs[i].addEventListener('keydown', function(event) {
                         if (event.key==="Backspace" ) { 
                            inputs[i].value='' ; 
                            if (i !==0) inputs[i - 1].focus(); 
                        } else { 
                            if (i===inputs.length - 1 && inputs[i].value !=='' ) { 
                                return true; 
                            } else if (event.keyCode> 47 && event.keyCode < 58) { 
                                inputs[i].value=event.key;
                                 if (i !==inputs.length - 1) 
                                    inputs[i + 1].focus(); event.preventDefault(); 
                            } else if (event.keyCode> 64 && event.keyCode < 91) { 
                                inputs[i].value=String.fromCharCode(event.keyCode); 
                                if (i !==inputs.length - 1) 
                                    inputs[i + 1].focus(); event.preventDefault(); 
                            } 
                        } 
                    }); 
                } 
            } OTPInput(); 
        });
    </script>
</body>
</html>