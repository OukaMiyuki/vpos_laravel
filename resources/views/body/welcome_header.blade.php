<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="{{ route('welcome') }}" class="logo d-flex align-items-center">
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
                    <li><a class="getstarted scrollto" href="https://drive.usercontent.google.com/download?id=1rMH8ra-b3VOUumuxoGEtgzdcnAgk96jz&export=download&authuser=0&confirm=t&uuid=084aa0f5-296a-4713-b5cb-cfad08557331&at=APZUnTWKcH9tSmm0P_vYzFhFdeDE%3A1719790569702" target="_blank">Download Aplikasi</a></li>
                @endguest
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->
    </div>
</header>
<!-- End Header -->