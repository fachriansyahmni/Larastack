<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link rel="icon" href="{{ asset('img/laralogo.png') }}" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('bootstrap4/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <!-- Bootstrap -->
    <link href="{{asset('/asset/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('/asset/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('/asset/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{asset('/asset/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="{{asset('/asset/build/css/custom.min.css')}}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{ route('question') }}" class="site_title"><i class="fa fa-bug"></i> <span><b>Lara</b>Stack</span></a>
            </div>

            <div class="clearfix"></div>

            <br />

            <!-- sidebar menu -->
            @include('layouts.sidebar')
            <!-- /sidebar menu -->

          </div>
        </div>

        <!-- top navigation -->
        @include('layouts.topbar')
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
              <div class="container">
                <div class="col-sm-12 col-md-12 col-lg mx-auto">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            LaraStack by <a href="#">Kelompok 83</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    @stack('scripts')
    <!-- jQuery -->
    <script src="{{asset('/asset/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
   <script src="{{asset('/asset/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('/asset/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('/asset/vendors/nprogress/nprogress.js')}}"></script>
    <!-- jQuery custom content scroller -->
    <script src="{{asset('/asset/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{asset('/asset/build/js/custom.min.js')}}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('sweetalert2/sweetalert2.js') }}"></script>

    
  </body>
</html>