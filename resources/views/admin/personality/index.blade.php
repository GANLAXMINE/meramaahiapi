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
                            <h6 class="text-white text-capitalize ps-3">Personality</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-3">
                            <a href="{{URL::to('admin/personalities/create')}}" class="btn btn-success btn-sm" title="Add New User">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add Personality
                            </a>
                            <table class="table align-items-center mb-0 data-tables">
                                <thead style="text-align: center">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Personality Type</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Long Description</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bold text-dark">Short Description</th>
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
    <!-- Full Description Modal -->
    <div class="modal fade" id="fullDescriptionModal" tabindex="-1" role="dialog" aria-labelledby="fullDescriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fullDescriptionModalLabel">Full Description</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" onclick="closeFullDescriptionModal()">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="full-description-modal-content"></span>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"onclick="closeFullDescriptionModal()" data-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>

</main>
<!-- Bootstrap CSS -->
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

<!-- Bootstrap JS and Popper.js (required for Bootstrap) -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

<script>
    $(function() {
        var table = $('.data-tables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/personalities') }}",
            columns: [{
                    data: null,
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'short_description',
                    name: 'short_description'
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
                title: "Are you sure want to remove this Personality?",
                text: "Questions will be Deleted!",
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
                                swal.fire("Deleted!", "Personality has been deleted", "success");
                                table.ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });

    });
</script>
<script>
    function showFullDescription(button) {
        var fullDesc = $(button).siblings('.full-description').text();
        $('.full-description-modal-content').text(fullDesc);
        $('#fullDescriptionModal').modal('show');
    }

    function closeFullDescriptionModal() {
        $('#fullDescriptionModal').modal('hide');
    }
</script>



@endsection