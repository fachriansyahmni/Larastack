<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    
    <link rel="stylesheet" href="{{ asset('bootstrap4/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
<!-- Modal -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          
        <div class="card text-white bg-info">
            <div class="card-header ">
              <h5 style="text-align: center">{{ __('Login') }}
                <button type="button list-inline-item" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </h5>
            </div>
            
            <div class="card-body bg-light text-dark">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
  
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
  
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
  
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
  
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
  
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
  
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
  
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
  
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
  
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-success">
                                {{ __('Masuk') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
      </div>
    </div>
</div>
  <!-- End Modal -->

  <body  background="{{ asset('img')}}/bg.png" height="50px" >
    <div class="container">
        <div class="top mt-2 text-center">
            <h1><b>Lara</b>Stack</h1>
        </div>
        <nav class="navbar">
            <a class="navbar-brand"></a>
            <div class="form-inline">
                @guest
                <button class="nav-link btn btn-primary btn-sm list-inline-item " data-toggle="modal" data-target="#login" >{{ __('Masuk') }}</button>
                @if (Route::has('register'))
                <span></span>
                <a class="nav-link btn btn-warning btn-sm list-inline-item mr-2" href="{{ route('register') }}">{{ __('Daftar') }}</a>
                        @endif
                @else
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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

    <footer>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="{{ asset('bootstrap4/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('sweetalert2/sweetalert2.js') }}"></script>

    @stack('scripts')
</body>
</html>