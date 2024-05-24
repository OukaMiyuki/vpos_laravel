<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/images/logo/Logo2.png') }}" alt="">
        <span>Visioner POS</span>
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">About</a></li>
                <li><a class="nav-link scrollto" href="#services">Services</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                @guest
                    <li><a class="getstarted scrollto" href="{{ route('access.login') }}">Hubungi Kami</a></li>
                @endguest
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->
    </div>
</header>
<!-- End Header -->