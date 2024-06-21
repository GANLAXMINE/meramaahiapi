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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">user
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
                            <h6 class="text-white text-capitalize ps-3">User</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-3">
                            <a href="{{ url('/admin/user/list') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    Back</button></a>

                            {!! Form::open([
                            'method' => 'DELETE',
                            'url' => ['/admin/users', $user->id],
                            'style' => 'display:inline',
                            ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', [
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-sm',
                            'title' => 'Delete User',
                            'onclick' => 'return confirm("Confirm delete?")',
                            ]) !!}
                            {!! Form::close() !!}

                            @if ($user->verification_image != null)
                            @if ($user->verification_status == '2')
                            <button class="btn btn-success btn-sm" disabled id="approved_verify"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Verified</button>
                            @elseif ($user->verification_status == '3')
                            <button class="btn btn-danger btn-sm" disabled id="approved_verify"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Rejected</button>
                            @else
                            <button class="btn btn-success btn-sm changeStatus" data-value="{{ $user->id }}" data-status="2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Verify</button>
                            <button class="btn btn-danger btn-sm changeStatus" data-value="{{ $user->id }}" data-status="3"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Reject</button>
                            @endif
                            @endif
                            <br />
                            <br />

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <td class='font-weight-bold'> {{ $user->id }} </td>
                                        </tr>
                                        <tr>
                                            <th> Name</th>
                                            <td class='font-weight-bold'> {{ $user->name }} </td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td class='font-weight-bold'> {{ $user->email }} </td>
                                        </tr>
                                        <tr>
                                            <th>Personality Type</th>
                                            <td class='font-weight-bold'> {!! $user->personality_type ? $user->personality_type : 'NA' !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <td class='font-weight-bold'> {!! $user->address ? $user->address : 'NA' !!}
                                            <td>
                                        </tr>
                                        <tr>
                                            <th>Apple ID</th>
                                            <td class='font-weight-bold'> {!! $user->apple_id ? $user->apple_id : 'NA' !!} </td>
                                        </tr>
                                        <tr>
                                            <th>Google ID</th>
                                            <td class='font-weight-bold'> {!! $user->google_id ? $user->google_id : 'NA' !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Profile Image</th>
                                            <td class='font-weight-bold '>
                                                @if ($prifile_images!=null)
                                                <img src="{{ URL::to($prifile_images->image) }}" class="img-thumbnail img-responsive w-10 imageEnlarge1">
                                                @else
                                                NA
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Profile Verify Image</th>
                                            <td class='font-weight-bold image_wrap'>
                                                @if ($user->verification_image != null)
                                                <img src="{{ URL::to($user->verification_image) }}" class="img-thumbnail img-responsive imageEnlarge2">

                                                <img src="{{ url('img/sample_verify_img.png') }}" class="img-thumbnail img-responsive imageEnlarge2">
                                                @else
                                                NA
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

<script>
    $("#verify").on("click", function() {
        $('#model_verify').modal('show');
    });
    $("#reject").on("click", function() {
        $('#model_reject').modal('show');
    });
    $(".close").on("click", function() {
        $('#imagemodal1').modal('hide');
        $('#imagemodal2').modal('hide');
    });

    $(".imageEnlarge1").on("click", function() {
        $('#imagepreview1').attr('src', $(this).attr('src'));
        $('#imagemodal1').modal('show');
    });
    $(".imageEnlarge2").on("click", function() {
        $('#imagepreview2').attr('src', $(this).attr('src'));
        $('#imagemodal2').modal('show');
    });
</script>
{{-- <script>
        function approvedUser(id,status){
            alert(status);
            $.ajax({
              url : "{{route('usersStatus')}}",
method: "post",
data: {'id':id,'status':status,'_token':"{{ csrf_token() }}"},
success: function(html){

$('#model_verify').modal('hide');
location.reload();
}
});
}
</script> --}}
<script>
    $(function() {

        $('.changeStatus').click(function(e) {
            e.preventDefault();
            var id = $(this).attr('data-value');
            var status = $(this).attr('data-status');
            Swal.fire({
                title: 'Are you sure you wanted to change status?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!'
            }).then((result) => {
                Swal.showLoading();
                if (result.value) {
                    var form_data = new FormData();
                    form_data.append("id", id);
                    form_data.append("status", status);
                    form_data.append("_token", "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('user.changeStatus') }}",
                        method: "POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            Swal.showLoading();
                        },
                        success: function(data) {

                            console.log(data);
                            console.log(data.success);
                            if (data.success == false) {

                                Swal.fire(
                                    "Customer can't set to active state!",
                                    data.message,
                                    'info'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'User Status !',
                                    'Changed Succussfully',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection