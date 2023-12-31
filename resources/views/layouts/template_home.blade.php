<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sell</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="./images/watches.jpg" type="image/x-icon">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

    <!-- Styles -->
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .nav-submenu {
            list-style: none;
            position: absolute;
            visibility: hidden;
            width: 200px;
        }

        .nav-submenu>li>.nav-submenu-item {
            color: #636b6f;
            font-size: .85rem;
            text-decoration: none
        }

        .nav-submenu>li>.nav-submenu-item:hover {
            color: #000;
        }

        .nav-item {
            text-align: start;
            cursor: pointer;
        }

        /* @media screen and (min-width: 1023px) { */
        .nav-item:hover>.nav-submenu {
            visibility: visible !important;
        }

        /* } */
    </style>
    <script>
        try {
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'access_token' => $accessToken,
                'current_user' => Auth::user(),
            ]) !!};
            console.log('Laravel', window.Laravel);
        } catch (err) {

        }
    </script>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="../images/watches.jpg" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav text-center font-weight-bold mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Trang chủ <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item position-relative">
                        <span class="nav-link">Sản Phẩm</span>
                        <ul class="nav-submenu p-0">
                            <li>
                                <a class="nav-submenu-item" href="#">Dành cho nam</a>
                            </li>
                            <li class="float-left">
                                <a class="nav-submenu-item" href="#">Dành cho nữ</a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="nav-item">
                    <a class="nav-link">Giới thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Contact</a>
                </li> --}}
                </ul>
                <div class="">
                    @if (Route::has('login'))
                        @auth
                            <ul class="navbar-nav text-center font-weight-bold">
                                <li class="nav-item text-uppercase px-4">
                                    <a class="nav-link" href="{{ url('/card') }}">
                                        <i class="fa fa-shopping-cart mr-2"></i>Giỏ hàng
                                    </a>
                                </li>
                                @if (Auth::user()->role === 'admin')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/product') }}">Dashboard</a>
                                    </li>
                                @endif

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ url('/order') }}">
                                            Đơn hàng
                                        </a>

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        @else
                            <a href="{{ route('login') }}">Đăng nhập</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Đăng ký</a>
                            @endif
                        @endauth


                    @endif
                </div>
            </div>
        </nav>
        <main class="py-4 container-fluid">
            @yield('content')
        </main>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>

</html>
