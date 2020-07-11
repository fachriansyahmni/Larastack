<div class="profile clearfix">
  <div class="profile_pic">
    @if (!empty($data->photo))
    <img src="{{ asset('img/profile/'.$data->photo) }}"  width="20px" class="img-circle profile_img">
    @else
    <img src="{{ asset('img/profile/nophoto.jpg')}}"  width="20px" class="img-circle profile_img">
    @endif
  </div>
  <div class="profile_info">
    <span>Welcome,</span>
    
      @if (!empty(Auth::user()->name))
      
      <h2>{{ Auth::user()->name }}</h2>
      @endif
      
  </div>
</div>
<br />
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
      <h3>General</h3>
      <ul class="nav side-menu">
        <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ route('home') }}">profile</a></li>
          </ul>
        </li>
        <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ url('/pertanyaan/new') }}">Pertanyaan</a></li>
          </ul>
        </li>
      </ul>
    </div>

  </div>