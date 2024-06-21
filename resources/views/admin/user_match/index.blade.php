@extends('layouts.backend')

@section('content')
@include('admin.sidebar')

<main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Cuisine</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Cuisine</h6>
            </nav> -->
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
                            <h6 class="text-white text-capitalize ps-3">Match List</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-3">
                            {{-- <a href="{{URL::to('admin/user/create')}}" class="btn btn-success btn-sm" title="Add New User">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add User
                            </a> --}}
                            <table class="table align-items-center mb-0 data-tables">
                                <thead style="text-align: center">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">First User</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Second User</th>
                                        <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Is Super Match</th> -->
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Match Date,Time</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bold text-dark">Actions</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<script>
    $(function() {
        var table = $('.data-tables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/match') }}",
            order: [[ 3, 'desc' ], [ 1, 'desc' ]],
            columns: [{
                    data: null,
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'match_user',
                    name: 'match_user'
                },
                // {
                //     data: 'no_column',
                //     name: 'no_column',
                //     createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                //         if (cellData === 'no') {
                //             $(cell).css('color', 'orange');
                //         }
                //     }
                // },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('.data-tables').on('click', '.btnDelete', function(e) {
            e.preventDefault();
            var url = $(this).data('remove');
            swal.fire({
                title: "Are you sure want to remove this user?",
                text: "User Match will be Deleted!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
            }).then((result) => {
                Swal.showLoading();
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            method: '_DELETE',
                            submit: true,
                            _token: '{{csrf_token()}}'
                        },
                        success: function(data) {
                            if (data == 'Success') {
                                swal.fire("Deleted!", "User Match has been deleted", "success");
                                table.ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });

    });
</script>
@endsection