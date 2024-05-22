<x-guest-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center">
                <h1 data-aos="fade-up">We offer modern solutions for growing your business</h1>
                <h2 data-aos="fade-up" data-aos-delay="400">VIsioner POS memberikan kemudahan dan solusi bagi anda untuk kebutuhan bisnis anda!</h2>
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
            <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="{{ asset('assets/welcome/assets/img/hero-img.png') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</x-guest-layout>