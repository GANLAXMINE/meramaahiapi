@extends('layouts.backend')

@section('content')

    @include('admin.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
          <div class="container-fluid py-1 px-3">
            <!-- <nav aria-label="breadcrumb">
              <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
                
              </ol>
              <h6 class="font-weight-bolder mb-0">Dashboard</h6>
            </nav> -->
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
              <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline">
                  {{-- <label class="form-label">Type here...</label>
                  <input type="text" class="form-control"> --}}
                </div>
              </div>
              <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                  <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                    <i class="fa fa-user me-sm-1"></i>
                    <span class="d-sm-inline d-none">Admin</span>
                  </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                  <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                    </div>
                  </a>
                </li>
                  
                {{-- <li class="nav-item dropdown px-3 d-flex align-items-center">
                  <a href="javascript:;" class="nav-link text-body p-0">
                    <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                  </a>
                </li> --}}
                <li class="nav-item dropdown px-3 d-flex align-items-center">
                  <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                  </a>
                  <ul class="dropdown-menu  dropdown-menu-end  px-1 py-2 me-sm-n4" aria-labelledby="dropdownMenuButton">
                    <li class="backlogout">
                      <form method="post" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="btn logout_btn">Logout</button>
                      </form>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
          <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
              <a href="{{ url('/admin/user/list') }}">
                <div class="card">
                  <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                      <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                      <p class="text-sm mb-0 text-capitalize font-weight-bolder">Total User's</p>
                      <h4 class="mb-0">{{$user}}</h4>
                    </div>
                  </div>
                  <hr class="dark horizontal my-0">
                  <div class="card-footer p-3">
                    {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than lask month</p> --}}
                    {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Total </span>{{ count($user_role) }}</p> --}}
                  </div>
                  
                </div>
              </a>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
              <a href="{{ url('/admin/match') }}">
                <div class="card">
                  <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                      <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                      <p class="text-sm mb-0 text-capitalize font-weight-bolder">Total Matches</p>
                      <h4 class="mb-0">{{$userCount}}</h4>
                    </div>
                  </div>
                  <hr class="dark horizontal my-0">
                  <div class="card-footer p-3">
                    {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than lask month</p> --}}
                    {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Total </span>{{ count($user_role) }}</p> --}}
                  </div>
                  
                </div>
              </a>
            </div>
            <!-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
              <a href="#">
                <div class="card">
                  <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                      <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                      <p class="text-sm mb-0 text-capitalize font-weight-bolder">Total Active</p>
                      <h4 class="mb-0">0</h4>
                    </div>
                  </div>
                  <hr class="dark horizontal my-0">
                  <div class="card-footer p-3">
                    {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than lask month</p> --}}
                    {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Total </span>{{ count($user_role) }}</p> --}}
                  </div>
                  
                </div>
              </a>
            </div> -->
            
        </div>
     
    </main>
    
@endsection

  