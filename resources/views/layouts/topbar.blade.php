<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end">
          <ul class="nav ">
            <li class="nav-item ">
              @guest
              <a class="nav-link btn btn-info btn-sm" href="{{ route('login') }}">{{ __('Masuk') }}</a>
            </li>
            <li class="nav-item">
              @if (Route::has('register'))
              <a class="nav-link btn btn-outline-secondary btn-sm" href="{{ route('register') }}">{{ __('Daftar') }}</a>
              @endif
              @else
            </li>
          </ul>
              <div class="dropdown">
                  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ Auth::user()->name }}
                  </button>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('home') }}">Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i>{{ __('Keluar') }}</a>
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