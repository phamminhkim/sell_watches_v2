<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Sell </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        /* Create a column layout with Flexbox */
        .row {
            display: flex;
        }

        /* Left column (menu) */
        .left {
            flex: 0%;
            padding: 15px 0;
        }

        .left h2 {
            padding-left: 8px;
        }

        /* Right column (page content) */
        .right {
            flex: 65%;
            padding: 15px;
        }

        /* Style the search box */
        #mySearch {
            width: 100%;
            font-size: 18px;
            padding: 11px;
            border: 1px solid #ddd;
        }

        /* Style the navigation menu inside the left column */
        #myMenu {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #myMenu li a {
            padding: 12px;
            text-decoration: none;
            color: black;
            display: block
        }

        #myMenu li a:hover {
            background-color: #eee;
        }

        .active {
            color: #120000 !important;
            background: rgba(157, 178, 191, .5) !important;
        }

        .main-content {
            min-height: 85vh
        }
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
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/watches.jpg') }}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid mt-3">
            <div class="row main-content">
                <div class="left shadow bg-white">
                    <ul id="myMenu">
                        <h6 class="font-weight-bold"> <i class="fa fa-list ml-2 mr-2 mb-2"></i>Danh sách Menu</h6>
                        <li><a href="/category" class="menu-item p-2 mb-1 ">Danh mục sản phẩm</a></li>
                        <li><a href="/brand" class="menu-item p-2">Thương hiệu</a></li>
                        <li><a href="/color" class="menu-item p-2">Màu sản phẩm</a></li>
                        <li><a href="/product" class="menu-item p-2">Sản phẩm</a></li>


                    </ul>
                </div>
                <div class="right" style="background-color: rgb(221 221 221 / 12%);">
                    <main class="py-4">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>

    </div>

    </div>
    <script>
        let active = window.location.pathname;
        console.log(active);
        const menuItems = document.querySelectorAll("#myMenu .menu-item");
        console.log(menuItems.length);
        // Duyệt qua từng menu-item để kiểm tra và thêm class "active" nếu cần
        for (let i = 0; i < menuItems.length; i++) {
            const menuItemPath = menuItems[i].getAttribute("href");
            if (menuItemPath === active) {
                // Nếu đường dẫn của menu-item trùng với active, thêm class "active" vào menu-item
                menuItems[i].classList.add("active");
            }
        }
    </script>
</body>

</html>
