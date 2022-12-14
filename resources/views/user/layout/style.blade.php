<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pizza Order System</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('customer/assets/favicon.ico') }}" />
    <!-- own css -->
    <link rel="stylesheet" href="{{ asset('customer/css/list.css') }}">

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('customer/css/styles.css') }}" rel="stylesheet" />
    <style>


    </style>
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container px-5">
            <a class="navbar-brand" href="#!">
                <i class="fa-solid fa-pizza-slice text-warning">
                    <span class="ms-2">Pi<span class="text-danger">zza</span> </span>
                </i><span class="text-warning">_Hou</span><sup>se<sup class="text-info">^</sup> </sup>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page"
                            href="{{ route('user#index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pizza">Pizza</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item"><span class="nav-link text-primary">{{ Auth()->user()->name }}</span></li>
                    <form action="{{ route('logout') }}" class="d-flex" method="POST">
                        @csrf
                        <button style="background-color: inherit;border:none" type="submit">
                            <i class="fa-solid fa-right-from-bracket text-danger">
                                <sup class="ms-2">logout</sup>
                            </i>
                        </button>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('customer/js/scripts.js') }}"></script>
    {{-- font awesome --}}
    <script src="https://kit.fontawesome.com/63064025bf.js" crossorigin="anonymous"></script>

</body>

</html>
