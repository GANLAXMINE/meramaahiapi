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
                            <h6 class="text-white text-capitalize ps-3">Coupon</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-3">
                            <a href="{{URL::to('admin/coupons/create')}}" class="btn btn-success btn-sm" title="Add New User">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add Coupon
                            </a>
                            <table class="table align-items-center mb-0 data-tables">
                                <thead style="text-align: center">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Description</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Type</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Code</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Start Date </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">End Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Status</th>
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
            ajax: "{{ url('admin/coupons') }}",
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
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'type',
                    name: 'type',
                },
                {
                    data: 'code',
                    name: 'code',
                },
                {
                    data: 'start_date',
                    name: 'start_date',
                },
                {
                    data: 'end_date',
                    name: 'end_date',
                },
                {
                    data: 'status',
                    name: 'status'
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
                title: "Are you sure want to remove this coupon?",
                text: "Coupon will be Deleted!",
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
                                swal.fire("Deleted!", "Coupon has been deleted", "success");
                                table.ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });

        $('.data-tables').on('change', '.changeStatus', function(e) {
            var id = $(this).val();
            var status = $(this).is(':checked') ? 1 : 0;
            var $checkbox = $(this);

            Swal.fire({
                title: 'Are you sure you want to change the status?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!'
            }).then((result) => {
                if (result.value) {
                    var form_data = new FormData();
                    form_data.append("id", id);
                    form_data.append("status", status);
                    form_data.append("_token", "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('coupon.Status') }}",
                        method: "POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            if (data.success === false) {
                                Swal.fire(
                                    "Coupon status couldn't be changed!",
                                    data.message,
                                    'info'
                                ).then(() => {
                                    // Reverse the checkbox state if the status change fails
                                    $checkbox.prop('checked', !$checkbox.prop('checked'));
                                });
                            } else {
                                Swal.fire(
                                    'Coupon Status Changed!',
                                    'The status has been changed successfully.',
                                    'success'
                                );
                            }
                        }
                    });
                } else {
                    // Reverse the checkbox state if the user cancels the action
                    $checkbox.prop('checked', !$checkbox.prop('checked'));
                }
            });
        });


    });
</script>
@endsection