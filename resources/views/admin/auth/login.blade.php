@extends('layouts.backend')

@section('content')

    <div class="d-flex">
        <div class="col-sm-6">
            <div class="" style="margin:100px">
                <div>
                    <h3 style="font-family:Nunito;font-weight: bold;">Let's Get Started</h3>
                    <p class="text-secondary text-signup">Log in to see what's happening near you</p>
                </div>
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="mt-5 login-inner-input">
                        <p style="font-size: 13px;" class="mt-2">Email </p>
                        <input required style="background-color: #ffffff;border: 1px solid;padding-left: 10px;" type="email" name="email" id="email" class="mt-2 form-control">
                        <p style="font-size: 13px;" class="mt-2">Password</p>
                        <input required style="background-color: #ffffff;border: 1px solid;padding-left: 10px;" type="password" name="password" id="password" class="mt-2 form-control">
                        <i class="fa fa-eye-slash" id="togglePassword" style="right: 2%;bottom: 0%;position: relative;float: right;top: 50%!important;margin-top: -30px;"></i>
                    </div>
                    <div class="mt-5">
                        <button class="btn btn-dark text-white col-sm-12" style="background-image: linear-gradient(to left, #FF6E5A , #FFC596);height: 50px;border-radius: 11px">Login</button>
                        {{-- <p class="mt-4" style="text-align: center;font-family: 'Nunito'">If you are user?<a href="" style="color: #00AFF0">Download the App Now</a></p> --}}
                    </div>
                </form>
                {{-- <div class="play-btns">
                    <div class="">
                        <button class="btn ml-3"><img src="{{asset('dj/images/Playstore.png')}}" alt="" class="play-icons"> Play Store</button>
                    </div>
                    <div class="">
                        <button class="btn ml-3"><img src="{{asset('dj/images/app-store.png')}}" alt="" class="play-icons"> App Store</button>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="col-sm-6">
            <img src="{{ url('img/hito_login.png') }}" alt="" class="w-100">
        </div>
    </div>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye / eye slash icon
        if($(this).hasClass('fa-eye')){
            $(this).toggleClass('fa-eye-slash');
        }
        else{
            $(this).removeClass('fa-eye-slash');
            $(this).toggleClass('fa-eye');
        }
    });
</script>
@endsection
