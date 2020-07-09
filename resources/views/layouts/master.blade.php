<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="icon" href="{{ asset('img/laralogo.png') }}" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('bootstrap4/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
<body>
    <div class="container mb-5">
        <div class="top mt-2 text-center">
            <h1><b>Lara</b>Stack</h1>
        </div>
        <nav class="navbar">
            <a class="navbar-brand"></a>
            <div class="form-inline">
                @guest
                <a class="nav-link" href="{{ route('login') }}">{{ __('Masuk') }}</a>
                @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Daftar') }}</a>
                        @endif
                @else
                @php
                    $rep = DB::table('profile')->join('users', 'users.id', '=', 'profile.user_id')->where('user_id', Auth::user()->id)->first();
                @endphp
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <p class="dropdown-item text-right">Reputation <br> <b>{{ $rep->reputation }}</b></p>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('home') }}">Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Keluar') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                  </div>
                    @endguest
            </div>
          </nav>  
    
        <div class="col-sm-12 col-md-12 col-lg mx-auto">
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="bg-dark">
        <div class="container-fluid p-5">
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="{{ asset('bootstrap4/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('sweetalert2/sweetalert2.js') }}"></script>

    @stack('scripts')
</body>
</html>