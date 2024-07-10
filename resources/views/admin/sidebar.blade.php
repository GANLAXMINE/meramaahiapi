<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 ps bg-white" id="sidenav-main">
  <div class="sidenav-header" style="height:5.875rem !important">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{ url('/admin/dashboard') }}">
      <img style="max-height: 10rem !important;width:300px" src="{{ url('img/admin_img.png') }}" class="navbar-brand-img h-100" alt="main_logo">
      {{-- <span class="ms-1 font-weight-bold text-dark">DJ That</span> --}}
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  {{-- <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main"> --}}
  <div class="collapse navbar-collapse h-100 w-auto max-height-vh-100" id="sidenav-collapse-main" style="margin-top: 50px;">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-dark" href="{{ url('/admin/dashboard') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons ">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/user/list') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons ">person</i>
          </div>
          <span class="nav-link-text ms-1">Users</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/notification/form') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-bell"></i>
          </div>
          <span class="nav-link-text ms-1">Push Notifications</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/match') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center ">
            <i class="fa-solid fa-children"></i>
          </div>
          <span class="nav-link-text ms-1">Match</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/survey_questions') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <img style="height:20px;width:20px;" class="icon_color" id="Configuration" src="{{ asset('/img/survey.png') }}" alt="">
          </div>
          <span class="nav-link-text ms-1">HitoMatch Assessment</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/personalities') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center match_icons">
            <img style="height:20px;width:20px;" class="icon_color" id="test" src="{{ asset('/img/test.png') }}" alt="">
          </div>
          <span class="nav-link-text ms-1">Personality Types</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/date-expectations') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <img style="height:20px;width:20px;" class="icon_color" id="test" src="{{ asset('/img/couple.png') }}" alt="">
          </div>
          <span class="nav-link-text ms-1">First Date Expections</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/ghost/thermometer') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <img style="height:20px;width:20px;" class="icon_color" id="faq" src="{{ asset('/img/ghost.png') }}" alt="">
          </div>
          <span class="nav-link-text ms-1">Ghost Thermometer</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/configuration') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <img style="height:20px;width:20px;" class="icon_color" id="Configuration" src="{{ asset('/img/configuration_icon.png') }}" alt="">
          </div>
          <span class="nav-link-text ms-1">Configuration</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/reports') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <img style="height:20px;width:20px;" class="icon_color" id="faq" src="{{ asset('/img/report.png') }}" alt="">
          </div>
          <span class="nav-link-text ms-1">Reporting User</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/user-chats') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <img style="height:20px;width:20px;" class="icon_color" id="faq" src="{{ asset('/img/chat.png') }}" alt="">
          </div>
          <span class="nav-link-text ms-1">Chat</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark " href="{{ url('/admin/faq') }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <img style="height:20px;width:20px;" class="icon_color" id="faq" src="{{ asset('/img/faq.png') }}" alt="">
          </div>
          <span class="nav-link-text ms-1">FAQ</span>
        </a>
      </li> -->

    </ul>
  </div>
</aside>