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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">User Question Answer
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
                            <h6 class="text-white text-capitalize ps-3">User Question Answer</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-3">
                            <a href="{{ url('/admin/user/list') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    Back</button></a>

                            <br />
                            <br />

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        {{-- <tr><th>ID</th><td class='font-weight-bold'> {{ $user->id }} </td>
                                        </tr> --}}
                                        <tr>
                                            <th>About Me</th>
                                            <td class='font-weight-bold'> {{ $user->about_me ? $user->about_me : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Interest</th>
                                            <td class='font-weight-bold'> {{ $user->interest ? $user->interest : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Relationship Goal</th>
                                            <td class='font-weight-bold'> {{ $user->relationship_goal ? $user->relationship_goal : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Height</th>
                                            <td class='font-weight-bold'> {{ $user->height_foot . " (" . $user->height_cm . ")" ? $user->height_foot : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Zodiac</th>
                                            <td class='font-weight-bold'> {{ $user->zodiac ? $user->zodiac : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Birthday</th>
                                            <?php
                                            $dob = $user->birthday;
                                            ?>
                                            <td class='font-weight-bold'> {{ \Carbon\Carbon::parse($dob)->format('M d,Y') }} </td>
                                        </tr>
                                        @php
                                        $genders = [
                                        0 => "Male",
                                        1 => "Female",
                                        2 => "Agender",
                                        3 => "Ambigender",
                                        4 => "Androgyne",
                                        5 => "Bigender",
                                        6 => "Butch",
                                        7 => "Cis female",
                                        8 => "Cis woman",
                                        9 => "Cisgender",
                                        10 => "Demigender",
                                        11 => "Gender fluidity",
                                        12 => "Gender neutrality",
                                        13 => "Gender variance",
                                        14 => "Intersex",
                                        15 => "Non-binary",
                                        16 => "Pangender",
                                        17 => "Queer",
                                        18 => "Trans woman",
                                        19 => "Transgender",
                                        20 => "Transsexual",
                                        21 => "Transsexual female",
                                        22 => "Trigender",
                                        23 => "Two-spirit"
                                        ];
                                        @endphp

                                        <tr>
                                            <th>Gender</th>
                                            <td class='font-weight-bold'>
                                                @if(isset($genders[$user->gender]))
                                                {{ $genders[$user->gender] }}
                                                @else
                                                Unknown
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- <tr>
                                                <th>Gender</th>
                                                <td class='font-weight-bold'> {{ $user->gender  ? $user->gender : 'NA'}} </td>
                                            </tr> -->
                                        <tr>
                                            <th>Drink</th>
                                            <td class='font-weight-bold'> {{ $user->drink ? $user->drink : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Dietary</th>
                                            <td class='font-weight-bold'> {{ $user->dietary ? $user->dietary : 'NA' }} </td>
                                        </tr>
                                        @php
                                        $interestedOptions = [
                                        0 => "Male",
                                        1 => "Female",
                                        2 => "Agender",
                                        3 => "Ambigender",
                                        4 => "Androgyne",
                                        5 => "Bigender",
                                        6 => "Butch",
                                        7 => "Cis female",
                                        8 => "Cis woman",
                                        9 => "Cisgender",
                                        10 => "Demigender",
                                        11 => "Gender fluidity",
                                        12 => "Gender neutrality",
                                        13 => "Gender variance",
                                        14 => "Intersex",
                                        15 => "Non-binary",
                                        16 => "Pangender",
                                        17 => "Queer",
                                        18 => "Trans woman",
                                        19 => "Transgender",
                                        20 => "Transsexual",
                                        21 => "Transsexual female",
                                        22 => "Trigender",
                                        23 => "Two-spirit"
                                        ];

                                        $interested = isset($interestedOptions[$user->interested]) ? $interestedOptions[$user->interested] : 'NA';
                                        @endphp

                                        <tr>
                                            <th>Interested In Seeing</th>
                                            <td class='font-weight-bold'>{{ $interested }}</td>
                                        </tr>

                                        <!-- <tr>
                                            <th>Interested In Seeing</th>
                                            <?php
                                            if ($user->interested == '1') {
                                                $interested = 'Female';
                                            } elseif ($user->interested == '0') {
                                                $interested = 'Male';
                                            } else {
                                                $interested = 'Non-Binary';
                                            }
                                            ?>
                                            <td class='font-weight-bold'> {{ $interested ? $interested : 'NA' }} </td>
                                        </tr> -->
                                        <tr>
                                            <th>Distance</th>
                                            <td class='font-weight-bold'> {{ $user->distance ? $user->distance : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Pet</th>
                                            <?php
                                            if ($user->pet == '0') {
                                                $pet = 'Yes';
                                            } else {
                                                $pet = 'No';
                                            }
                                            ?>
                                            <td class='font-weight-bold'> {{ $pet ? $pet : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Sleeping Habits</th>
                                            <td class='font-weight-bold'> {{ $user->sleeping ? $user->sleeping : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Job</th>
                                            <td class='font-weight-bold'> {{ $user->job ? $user->job : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Personality</th>
                                            <td class='font-weight-bold'> {{ $user->personality ? $user->personality : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Work Style</th>
                                            <td class='font-weight-bold'> {{ $user->work_style ? $user->work_style : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Family Style</th>
                                            <td class='font-weight-bold'> {{ $user->family_style ? $user->family_style : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Education</th>
                                            <td class='font-weight-bold'> {{ $user->education ? $user->education : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Smoking</th>
                                            <td class='font-weight-bold'> {{ $user->smoking ? $user->smoking : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Workout</th>
                                            <td class='font-weight-bold'> {{ $user->workout ? $user->workout : 'NA' }} </td>
                                        </tr>
                                        <tr>
                                            <th>Video</th>
                                            <td class='font-weight-bold'>
                                                @if ($user->video)
                                                <video width="520" height="240" controls>
                                                    <source src="{{ $user->video }}" type="video/mp4">
                                                </video>
                                                @else
                                                NA
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Profile Images</th>
                                            <td class='font-weight-bold image_wrap'>
                                                @if (count($user_images)>0)
                                                @foreach ($user_images as $user_image)
                                                <img src="{{ URL::to($user_image->image) }}" class="img-thumbnail img-responsive    imageEnlarge2">
                                                @endforeach
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

{{-- <div class="modal fade" id="imagemodal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:rgba(255,255,255,.8)";>
                <div class="modal-header" style=" background-image: linear-gradient(195deg, #FFC596 0%, #FF6E5A 100%) !IMPORTANT";>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <img src="" id="imagepreview1" style="width: 460px; height: 300px;">
                </div>
            </div>
        </div>
    </div> --}}
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
{{-- <div class="modal fade" id="imagemodal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:rgba(255,255,255,.8)";>
                <div class="modal-header" style=" background-image: linear-gradient(195deg, #FFC596 0%, #FF6E5A 100%) !IMPORTANT";>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <img src="" id="imagepreview3" style="width: 460px; height: 300px;">
                </div>
            </div>
        </div>
    </div> --}}
<script>
    $(".close").on("click", function() {
        $('#imagemodal2').modal('hide');
    });

    $(".imageEnlarge2").on("click", function() {
        $('#imagepreview2').attr('src', $(this).attr('src'));
        $('#imagemodal2').modal('show');
    });
</script>

@endsection