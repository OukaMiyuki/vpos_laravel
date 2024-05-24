<x-guest-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-7 d-flex flex-column justify-content-center">
                <h1 data-aos="fade-up">We offer modern solutions for growing your business</h1>
                <h2 data-aos="fade-up" data-aos-delay="400">VIsioner POS memberikan kemudahan dan solusi bagi anda untuk kebutuhan bisnis anda <strong>GRATIS!</strong></h2>
                <div data-aos="fade-up" data-aos-delay="600">
                    <div class="text-center text-lg-start">
                        <div class="dropdown">
                            <a href="#about" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>Registrasi</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('tenant.mitra.register') }}">Mitra Bisnis</a></li>
                                <li><a class="dropdown-item" href="{{ route('marketing.register') }}">Mitra Aplikasi</a></li>
                                <li><a class="dropdown-item" href="{{ route('tenant.register') }}">Mitra Tenant</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">
                            <a href="index.html" class="logo logo-dark text-center">
                                <span class="logo-lg">
                                    <img class="img-fluid" src="{{ asset('assets/images/logo/Logo1.png') }}" alt="" width="80">
                                </span>
                            </a>
                        </div>
                        <br class="m-2">
                        <form method="POST" action="{{ route('process.login') }}">
                            @csrf
                            <div class="mb-3 text-start">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" value="{{ old('email') }}" id="email" required="" name="email" placeholder="Masukkan E-mail anda">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 text-start">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" required name="password" placeholder="Masukkan Password">
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 text-start">
                                <div class="form-check">
                                    <input id="remember_me" name="remember_me" type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>
                            <div class="text-center d-grid">
                                <button class="btn btn-primary" type="submit"> Log In </button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <img src="{{ asset('assets/welcome/assets/img/hero-img.png') }}" class="img-fluid" alt=""> --}}
            </div>
        </div>
    </div>
</x-guest-layout>