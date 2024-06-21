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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Survey Questions
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
                            <h6 class="text-white text-capitalize ps-3">Survey Questions</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-3">
                            <a href="{{ url('/admin/survey_questions') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    Back</button></a>

                            {!! Form::open([
                            'method' => 'DELETE',
                            'url' => ['/admin/survey_questions', $questions->id],
                            'style' => 'display:inline',
                            ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', [
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-sm',
                            'title' => 'Delete User',
                            'onclick' => 'return confirm("Confirm delete?")',
                            ]) !!}
                            {!! Form::close() !!}
                            <br />
                            <br />

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Category</th>
                                            <td class='font-weight-bold'> {{ $questions->category }} </td>
                                        </tr>
                                        <tr>
                                            <th>Question</th>
                                            <td class='font-weight-bold'> {{ $questions->questions }} </td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td class='font-weight-bold'> {{ $questions->description }} </td>
                                        </tr>
                                        <tr>
                                            <th>Option</th>
                                            <td class='font-weight-bold'> {{ $questions->option_1 }} </td>
                                        </tr>
                                        <tr>
                                            <th>Option</th>
                                            <td class='font-weight-bold'> {{ $questions->option_2 }} </td>
                                        </tr>
                                        <tr>
                                            <th>Option</th>
                                            <td class='font-weight-bold'> {{ $questions->option_3 }} </td>
                                        </tr>
                                        <tr>
                                            <th>Option</th>
                                            <td class='font-weight-bold'> {!! $questions->option_4 ? $questions->option_4 : 'NA' !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Option</th>
                                            <td class='font-weight-bold'> {!! $questions->option_5 ? $questions->option_5 : 'NA' !!} </td>
                                        </tr>
                                        <tr>
                                            <th>Question Types</th>
                                            <td class='font-weight-bold'> {{ $questions->option_types }} </td>
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



<div class="modal fade" id="imagemodal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:rgba(255,255,255,.8)" ;>
            <div class="modal-header" style="background-image: linear-gradient(195deg, #FFC596 0%, #FF6E5A 100%) !IMPORTANT">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <img src="" id="imagepreview1" style="width: 460px; height: 300px;">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="imagemodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:rgba(255,255,255,.8)" ;>
            <div class="modal-header cross_button" style="background-image: linear-gradient(195deg, #FFC596 0%, #FF6E5A 100%) !IMPORTANT">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <img src="" id="imagepreview2" style="width: 460px; height: 300px;">
            </div>
        </div>
    </div>
</div>

@endsection