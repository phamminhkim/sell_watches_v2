<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sell</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="icon" href="./images/watches.jpg" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <script>
        try {
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                // 'access_token' => $accessToken,
                'current_user' => Auth::user(),
            ]) !!};
        } catch (err) {

        }
    </script>
    <!-- Scripts -->


    <style>
        .dot {

            height: 6px;
            width: 6px;
            background-color: #dee2e6;
            border-radius: 50%;
            display: inline-block;
            margin-left: 10px;
            margin-right: 10px;

        }

        .active .dot {
            height: 6px;
            width: 6px;

            border-radius: 50%;
            display: inline-block;
            margin-left: 10px;
            margin-right: 8px;
            background-color: #3C8DBC;
        }

        .main-sidebar.sidebar-light-lightblue {

            background-color: white;
        }

        .main-header {
            border-bottom: 1px solid #c6c8c9;

        }

        .bosung-menu {
            background-color: #3C8DBC !important;
            color: white !important;
        }

        .show-hotline {
            display: block;
        }

        .hide-hotline {
            display: none;
        }

        /* canh chỉnh logo */
        /* .brand-link .brand-image {
          float: left;
          line-height: 0.8;
          margin-left: 0.8rem;
          margin-right: 0.5rem;
          margin-top: -2px;
          max-height: 40px;
          width: auto;
      } */
        .brand-link .brand-image {
            float: left;
            /* line-height: 0.8;
            margin-left: 0.8rem;
            margin-right: 0.5rem; */
            margin-top: -14px;
            margin-bottom: 52px;
            max-height: 60px;
            width: auto;
        }

        .btn-function_top {
            border-radius: 50%;
            background-color: #fff;
            border-color: #fff;
            box-shadow: 1px 1px 10px #aaa !important;
            color: black !important;
            padding-top: 12px;
            width: 50px;
            height: 50px;
        }


        /* .os-scrollbar .os-scrollbar-horizontal .os-scrollbar-unusable .os-scrollbar-auto-hidden:hover{
        background: gray ;
      }
      .os-dragging .os-scrollbar-vertical{
        background: gray ;
      }
      .os-scrollbar .os-scrollbar-vertical{
        background: gray ;
      } */
        .os-theme-light .os-scrollbar .os-scrollbar-track .os-scrollbar-handle:hover {
            background: gray;
        }

        /* .main-sidebar.sidebar-light-lightblue{
        background-color: #34829a24;;

      } */
        /* .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
        background-color: #b0b3b6;
      } */
    </style>
    @yield('css')
</head>

<body>
    <div class="wrapper" id="app">

        <!-- Navbar main-sidebar elevation-4 sidebar-light-lightblue -->
        {{-- <nav class="main-header navbar navbar-expand navbar-dark navbar-lightblue "  > --}}
        <nav class="main-header navbar navbar-expand">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" onclick="showHideLeftMenu()" href="#"
                        role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">{{ __('menu.home') }}</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/report/home" class="nav-link">{{ __('Báo cáo') }}</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/help" class="nav-link">{{ __('menu.help') }}</a>
                </li>
            </ul>


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">


              ki

               
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <span class="d-none d-md-inline">{{ Auth::user()->name }} -
                            {{ Auth::user()->email }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                        style="left: inherit; right: -8px; border: 0; margin-top: 8px">
                        <!-- User image -->
                        <li class="user-header ">

                            <p class="nav-link">
                                {{ Auth::user()->name }} - {{ Auth::user()->email }}
                                <small>Thành viên từ {{ Auth::user()->created_at }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        @can('manage-systems')
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-12 text-center">

                                        <a href="{{ url('/admin/users') }}">
                                            <i class="fas fa fa-cog mr-2"></i>
                                            {{ __('form.manegement_admin') }}
                                        </a>



                                    </div>

                                </div>
                                <!-- /.row -->
                            </li>
                        @endcan
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="{{ route('profile.index') }}" class="btn btn-default btn-flat">
                                {{ __('form.profile') }}</a>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="btn btn-default btn-flat float-right">{{ __('form.logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4">
            {{-- main-sidebar sidebar-light-lightblue  --}}
            <!-- Brand Logo -->
            <a href="{{ config('api_site.domain_root') }}" class="brand-link logo-switch"
                style="background-color: white;padding: 12.2px; border-bottom: 2px solid white;">

                <img src="img/logo_onethienlong.png" style="padding-left: 40px;" alt="TLG Logo large"
                    class="brand-image  logo-xl">
                <img src="img/logo_onethienlong.png" alt="TLG Logo small" class="brand-image-xl logo-xs"
                    style="left:10px">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                   kim

                </nav>

                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div id="content_wrapper" class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <div id="back-to-top" class="btn btn-default back-to-top btn-function_top" role="button"
                    aria-label="Back on top" onclick="gotoTop()">
                    <i  style="font-size: x-large;" class="fas fa-arrow-up"></i>
                </div>
            </section>
            <!-- /.content -->
        </div>
    
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
  
   
</body>

</html>
@yield('script')
