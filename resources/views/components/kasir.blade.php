<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Laravel 10 Tutorial' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Kasir Navbar</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Home</a>
                    </li>
                    @guest('kasir')
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('kasir.login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('kasir.register') }}">Register</a>
                    </li>
                    @else
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::guard('kasir')->user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <form method="POST" action="{{ route('kasir.logout') }}">
                                    @csrf
                                    <a
                                        class="dropdown-item" href="{{ route('kasir.logout') }}"
                                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                                    >
                                        Log Out
                                    </a>
                                </form>
                            </li>
                        </ul>
                      </div>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div>
        {{ $slot }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{ $scripts ?? '' }}

</body>
</html>