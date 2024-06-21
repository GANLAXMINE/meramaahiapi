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
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Generator Formli>
            </ol>
            <h6 class="font-weight-bolder mb-0">Generator Formh6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    
                </div>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">Sign In</span>
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
                    <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
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
                        <h6 class="text-white text-capitalize ps-3">Generator Form</h6>
                    </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-3">
                        
                        <form class="form-horizontal" method="post" action="{{ url('/admin/generator') }}">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="crud_name" class="col-md-4 col-form-label text-right">Crud Name:</label>
                                <div class="col-md-6">
                                    <input type="text" name="crud_name" class="form-control" id="crud_name" placeholder="Posts" required="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="controller_namespace" class="col-md-4 col-form-label text-right">Controller Namespace:</label>
                                <div class="col-md-6">
                                    <input type="text" name="controller_namespace" class="form-control" id="controller_namespace" placeholder="Admin">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="route_group" class="col-md-4 col-form-label text-right">Route Group Prefix:</label>
                                <div class="col-md-6">
                                    <input type="text" name="route_group" class="form-control" id="route_group" placeholder="admin">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="view_path" class="col-md-4 col-form-label text-right">View Path:</label>
                                <div class="col-md-6">
                                    <input type="text" name="view_path" class="form-control" id="view_path" placeholder="admin">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="route" class="col-md-4 col-form-label text-right">Want to add route?</label>
                                <div class="col-md-6">
                                    <select name="route" class="form-control" id="route">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="relationships" class="col-md-4 col-form-label text-right">Relationships</label>
                                <div class="col-md-6">
                                    <input type="text" name="relationships" class="form-control" id="relationships" placeholder="comments#hasMany#App\Comment">
                                    <p class="help-block">method#relationType#Model</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="form_helper" class="col-md-4 col-form-label text-right">Form Helper</label>
                                <div class="col-md-6">
                                    <input type="text" name="form_helper" class="form-control" id="form_helper" placeholder="laravelcollective" value="laravelcollective">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="soft_deletes" class="col-md-4 col-form-label text-right">Want to use soft deletes?</label>
                                <div class="col-md-6">
                                    <select name="soft_deletes" class="form-control" id="soft_deletes">
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group table-fields">
                                <h4 class="text-center">Table Fields:</h4><br>
                                <div class="entry col-md-10 offset-md-2 form-inline">
                                    <input class="form-control" name="fields[]" type="text" placeholder="field_name" required="true">
                                    <select name="fields_type[]" class="form-control">
                                        <option value="string">string</option>
                                        <option value="char">char</option>
                                        <option value="varchar">varchar</option>
                                        <option value="password">password</option>
                                        <option value="email">email</option>
                                        <option value="date">date</option>
                                        <option value="datetime">datetime</option>
                                        <option value="time">time</option>
                                        <option value="timestamp">timestamp</option>
                                        <option value="text">text</option>
                                        <option value="mediumtext">mediumtext</option>
                                        <option value="longtext">longtext</option>
                                        <option value="json">json</option>
                                        <option value="jsonb">jsonb</option>
                                        <option value="binary">binary</option>
                                        <option value="number">number</option>
                                        <option value="integer">integer</option>
                                        <option value="bigint">bigint</option>
                                        <option value="mediumint">mediumint</option>
                                        <option value="tinyint">tinyint</option>
                                        <option value="smallint">smallint</option>
                                        <option value="boolean">boolean</option>
                                        <option value="decimal">decimal</option>
                                        <option value="double">double</option>
                                        <option value="float">float</option>
                                    </select>

                                    <label>Required</label>
                                    <select name="fields_required[]" class="form-control">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>

                                    <button class="btn btn-success btn-add inline btn-sm" type="button">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </div>
                            </div>
                            <p class="help text-center">It will automatically assume form fields based on the migration field type.</p>
                            <br>
                            <div class="form-group row">
                                <div class="offset-md-4 col-md-4">
                                    <button type="submit" class="btn btn-primary" name="generate">Generate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            </div>

        </div>
    </main>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $(document).on('click', '.btn-add', function(e) {
            e.preventDefault();

            var tableFields = $('.table-fields'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(tableFields);

            newEntry.find('input').val('');
            tableFields.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="fa fa-minus"></span>');
        }).on('click', '.btn-remove', function(e) {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
        });

    });
</script>
@endsection
