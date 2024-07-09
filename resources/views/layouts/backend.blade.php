<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('img/admin_img.png') }}">
    <link rel="icon" type="image/png" href="{{ url('img/admin_img.png') }}">
    <title>
        Mera Maahi
    </title>
    <!--     Fonts and icons     -->
    <!-- <script src="demo_defer.js" defer></script> -->

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ url('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ url('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ url('css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css'>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script> -->
    {{-- dj-css --}}
    <!-- <link rel="stylesheet" href="{{ url('dj/css/style.css') }}"> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <style>
        /* Adjust the styling of the combined filter select box */
        .selectboxwrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        
        .filter1 {
            width: 25%
        }
        .gender_profile {
            display: flex;
            width: 48%;
            column-gap: 12px;
            justify-content: end;
        }

        .toggleswtich {
            margin-bottom: 10px;
        }

        .toggleswtich label {
            font-weight: bold;
        }

        .filter {
            width: 14%;
        }

        .toggleswtich select {
            width: 100%;
            padding: 0px 3px 0px 3px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            color: #333;
            font-size: 12px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .table-responsive {
            padding: 12px;
        }

        .card .card-body {
            padding: 0px !important;
        }

        .toggleswtich select:focus {
            border-color: #5e72e4;
        }

        /* Style the options in the select box */
        .toggleswtich select option {
            padding: 10px;
            background-color: #fff;
            color: #333;
        }

        .bg-gradient-dark {
            background-image: linear-gradient(195deg, #FFC596 0%, #FF6E5A 100%) !important;
        }

        .cross_button {
            justify-content: end !important;
        }

        button.btn.logout_btn:focus {
            box-shadow: none;
        }

        .backlogout {
            margin-bottom: -20px;

        }

        .imageEnlarge {
            border-radius: 10%;
        }

        .fa,
        .fas {
            font-size: 12px !important;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: red;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: green;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px green;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .font-weight-bold {
            text-overflow: ellipsis !important;
            white-space: normal !important;
        }

        .image_wrap img {
            height: 200px;
            width: 175px;
        }

        .see-more-btn {
            background: transparent;
            border: none;
            padding: 7px 28px;
            border-radius: 7px;
            color: #ff846a;
        }

        .table td.full-description {
            white-space: pre-wrap;
        }

        .table-responsive li {
            line-height: 28px;
            margin-bottom: 28px;
        }

        .slider {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .slider-gray {
            background-color: #ccc;
            /* Gray color */
        }

        .slider-red {
            background-color: red;
            /* Red color */
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .navbar-vertical .navbar-nav>.nav-item .nav-link.active img {
            filter: brightness(15.5) !important;
        }

        .navbar-vertical .nav-item:focus img .nav-link {
            height: 25px;
            width: 25px;
            filter: brightness(20);
        }

        input:checked+.slider.round:before {
            transform: translateX(26px);
        }
    </style>

</head>

<body class="g-sidenav-show  bg-gray-200">
    @if (session('error'))
    <script>
        toastr.options.closeButton = true;
        toastr.error("{{ session('error') }}")
    </script>
    @endif
    @if (session('flash_message'))
    <script>
        toastr.options.closeButton = true;
        toastr.success("{{ session('flash_message') }}")
    </script>
    @endif

    @yield('content')
    <!--   Core JS Files   -->
    <script src="{{ url('js/core/popper.min.js') }}"></script>
    <script src="{{ url('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ url('js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ url('js/plugins/chartjs.min.js') }}"></script>

    <script>
        jQuery(function($) {
            var path = window.location.href;
            // because the 'href' property of the DOM element is the absolute path
            var base = new URL('/', location.href).href;
            var base_url = base + 'dj-that/public';
            var djs_url = base + 'dj-that/public/admin/dj/list';
            var Categories_url = base + 'dj-that/public/admin/categories';



            $('ul a').each(function() {
                if (this.href === path) {
                    $(this).addClass('active');
                    $(this).addClass('bg-gradient-dark');
                    if (this.href === djs_url) {
                        $("#Djs").attr("src", base_url + "/img/dj_white.png");
                    }
                    if (this.href === Categories_url) {
                        $("#Categories").attr("src", base_url + "/img/category_active_icon.png");
                    }

                } else {
                    $(this).removeClass('active');
                    $(this).removeClass('bg-gradient-dark');
                }
            });
        });
        // $(".nav-link").last().addClass( "selected" )
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ url('js/material-dashboard.min.js') }}"></script>
</body>

</html>