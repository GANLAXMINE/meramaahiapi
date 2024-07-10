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
                            <h6 class="text-white text-capitalize ps-3">User List</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive ">
                            {{-- <a href="{{URL::to('admin/user/create')}}" class="btn btn-success btn-sm" title="Add New User">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add User
                            </a> --}}
<!-- 
                            <div class="selectboxwrap">
                                <div class="filter">
                                    <div class="toggleswtich">
                                        <select id="combinedFilter" class="form-select">
                                            <option value="">All Users</option>
                                            <option value="0:">Unblocked Users</option>
                                            <option value="1:">Blocked Users</option>
                                            <option value=":0">Pending Users</option>
                                            <option value=":2">Verified Users</option>
                                            <option value=":3">Rejected Users</option>
                                            <option value=":1">In Progress Users</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="gender_profile">
                                    <div class="filter1">
                                        <div class="toggleswtich">
                                            <select id="genderFilter" class="form-select">
                                                <option value="">Genders</option>
                                                @foreach($genders as $key => $gender)
                                                <option value="{{ $key }}">{{ $gender }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="filter1">
                                        <div class="toggleswtich">
                                           
                                            <select id="interestedFilter" class="form-select">
                                                <option value="">Looking For</option>
                                                @foreach($genders as $key => $interest)
                                                <option value="{{ $key }}">{{ $interest }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div> -->




                            <table class="table align-items-center mb-0 data-tables">
                                <thead style="text-align: center">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Email</th>
                                        <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Location</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Gender</th> -->
                                        <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Looking for </th> -->
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Dob</th> --}}
                                        <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Block</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Image Verify</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Date/Time</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">User Details</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Date Expections</th> -->
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
            ajax: "{{ url('admin/user/list') }}",
            order: [[ 8, 'desc' ], [ 1, 'desc' ]],
            columns: [{
                    data: null,
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                // {
                //     data: 'address',
                //     name: 'address',
                //     render: function(data, type, row) {
                //         return data ? data : 'N/A';
                //     }
                // }, {
                //     data: 'gender',
                //     name: 'gender',
                //     render: function(data) {
                //         return genders[data] || 'N/A';
                //     }
                // },
                // {
                //     data: 'interested',
                //     name: 'interested',
                //     render: function(data) {

                //         return genders[data] || 'N/A';
                //     }
                // },

                // {
                //     data: 'is_block_by_admin',
                //     name: 'is_block_by_admin'
                // },
                {
                    data: 'verification_status',
                    name: 'verification_status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                // {
                //     data: 'question_answer',
                //     name: 'question_answer',
                //     orderable: false,
                //     searchable: false
                // },
                // {
                //     data: 'date_question_answer',
                //     name: 'date_question_answer',
                //     orderable: false,
                //     searchable: false
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        // $('#combinedFilter').change(function() {
        //     var combinedFilterValue = $(this).val();
        //     var blockFilter = combinedFilterValue.charAt(0);
        //     var verificationFilter = combinedFilterValue.charAt(1);

        //     if (blockFilter === '' && verificationFilter === '') {
        //         // Reset the URL to fetch all users
        //         table.ajax.url("{{ route('admin.user.list') }}").load();
        //     } else {
        //         // Fetch data based on the selected filter
        //         table.ajax.url("{{ route('admin.user.list') }}?" + $.param({
        //             blockFilter: blockFilter,
        //             verificationFilter: verificationFilter,
        //         })).load();
        //     }
        // });
        $('#combinedFilter, #genderFilter, #interestedFilter').change(function() {
            var blockFilterValue = $('#combinedFilter').val().charAt(0);
            var verificationFilterValue = $('#combinedFilter').val().charAt(1);
            var genderFilterValue = $('#genderFilter').val();
            var interestedFilterValue = $('#interestedFilter').val();

            var queryParams = {};
            if (blockFilterValue !== '') {
                queryParams.blockFilter = blockFilterValue;
            }
            if (verificationFilterValue !== '') {
                queryParams.verificationFilter = verificationFilterValue;
            }
            if (genderFilterValue !== '') {
                queryParams.genderFilter = genderFilterValue;
            }
            if (interestedFilterValue !== '') {
                queryParams.interestedFilter = interestedFilterValue;
            }

            if (Object.keys(queryParams).length === 0) {
                // Reset the URL to fetch all users
                table.ajax.url("{{ route('admin.user.list') }}").load();
            } else {
                // Fetch data based on the selected filters
                table.ajax.url("{{ route('admin.user.list') }}?" + $.param(queryParams)).load();
            }
        });



        $('.data-tables').on('click', '.btnDelete', function(e) {
            e.preventDefault();
            var url = $(this).data('remove');
            swal.fire({
                title: "Are you sure want to remove this user?",
                text: "User will be Deleted!",
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
                                swal.fire("Deleted!", "User has been deleted", "success");
                                table.ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
        $('.data-tables').on('click', '.changeStatus', function(e) {
            e.preventDefault();
            var id = $(this).attr('value');
            var status = $(this).attr('data-status');
            Swal.fire({
                title: 'Are you sure you wanted to change Block status?',
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
                    form_data.append("is_block_by_admin", status);
                    form_data.append("_token", "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('block.Status') }}",
                        method: "POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            //                        Swal.showLoading();
                        },
                        success: function(data) {

                            console.log(data);
                            console.log(data.success);
                            if (data.success == false) {

                                Swal.fire(
                                    "User can't set to active state!",
                                    data.message,
                                    'info'
                                ).then(() => {
                                    table.ajax.reload(null, false);
                                });
                            } else {
                                Swal.fire(
                                    'User  Block Status !',
                                    'Changed Succussfully',
                                    'success'
                                ).then(() => {
                                    location.reload(true);
                                    // table.ajax.reload(null, false);
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