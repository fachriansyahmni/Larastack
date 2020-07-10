<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
          <ul class=" navbar-right text-right">
            <li class="nav-item dropdown open" style="padding-left: 15px;">
              @guest
              <ul class="list-inline">
                @if (Route::has('register'))
                    <li class="list-inline-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Daftar') }}</a></li>
                @endif
                <li class="list-inline-item mr-2"><a class="nav-link" href="{{ route('login') }}">{{ __('Masuk') }}</a></li>
              </ul>
              @else
            </li>
          </ul>
              <div class="dropdown">
                  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ Auth::user()->name }}
                  </button>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">{{ Auth::user()->email }}</a>
                    @php
                         $cekrep = App\Profile::where('user_id', Auth::user()->id)->first();
                    @endphp
                    <a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">My Reputation  <kbd>{{$cekrep->reputation}}</kbd></a>
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