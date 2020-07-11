<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
          <ul class=" navbar-right text-right">
            <div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search for...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Go!</button>
									</span>
								</div>
							</div>
						</div>
            <li class="nav-item dropdown open" style="padding-left: 15px;">
              @guest
              <ul class="list-inline">
                @if (Route::has('register'))
                    <li class="list-inline-item"><a class="btn btn-warning btn-sm " href="{{ route('register') }}">{{ __('Daftar') }}</a></li>
                @endif
                <li class="list-inline-item mr-2"><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#login">{{ __('Masuk') }}</button></li>
              </ul>
              @else
              <div class="dropdown">
                  <button class="btn-sm dropdown-toggle btn-outline-info" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (!empty($data->photo))
                    <img src="{{ asset('img/profile/'.$data->photo) }}"  width="15px" class="mr-2" alt="">{{ Auth::user()->name }}
                    @else
                    <img src="{{ asset('img/profile/nophoto.jpg')}}"  width="15px" class="mr-2" alt="">{{ Auth::user()->name }}
                    @endif
                  </button>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">{{ Auth::user()->email }}</a>
                    @php
                         $cekrep = App\Profile::where('user_id', Auth::user()->id)->first();
                    @endphp
                    <a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">My Reputation  <kbd class="pull-right">{{$cekrep->reputation}}</kbd></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('home') }}">Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> {{ __('Keluar') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </div>
                </div>
                  @endguest
                </li>
              </ul>
        </nav>
    </div>
</div>

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