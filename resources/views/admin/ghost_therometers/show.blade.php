@extends('layouts.backend')

@section('content')
@include('admin.sidebar')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Ghost Thermometer
                    <li>
                </ol>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">

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
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Ghost Thermometer</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-3">
                            <a href="{{ url('/admin/ghost/thermometer') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    Back</button></a>
                            <br />
                            <br />

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>User</th>
                                            @if (!empty($date))
                                            <th>Date</th>
                                            @endif
                                            <th>Answer</th>
                                        </tr>
                                        <tr>
                                            <td class='font-weight-bold'> {{ $user_name }} </td>
                                            @if (!empty($date))
                                            <td class='font-weight-bold'> {{ $date }} </td>
                                            @endif
                                            <td>
                                                @if (!empty($rating))
                                                @for ($i = 0; $i < $rating; $i++) <i class="fa fa-star text-warning"></i>
                                                    @endfor
                                                    @else
                                                    @if(empty($date) && empty($oppositeDate))
                                                    Pending
                                                    @endif
                                                    @endif
                                                    @if (!empty($answer))
                                                    {{ $answer }}
                                                    @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='font-weight-bold'> {{ $receiver_name }} </td>
                                            @if (!empty($oppositeDate))
                                            <td class='font-weight-bold'> {{ $oppositeDate }} </td>
                                            @endif
                                            <td>
                                                @if (!empty($oppositeRating))
                                                @for ($i = 0; $i < $oppositeRating; $i++) <i class="fa fa-star text-warning"></i>
                                                    @endfor
                                                    @else
                                                    @if(empty($date) && empty($oppositeDate))
                                                    Pending
                                                    @endif
                                                    @endif
                                                    @if (!empty($oppositeAnswer))
                                                    {{ $oppositeAnswer }}
                                                    @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>








                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>


@endsection