@extends('layouts.backend')

@section('content')
@include('admin.sidebar')

<style>
    .img-fluid-new {
        height: 50px;
        width: 50px;
        border-radius: 60%;
    }

    .main-content {
        position: relative !important;
        z-index: 21;
        left: 0%;
        margin-left: 20%;

    }

    .message-area {
        height: 100vh;
        overflow: hidden;
        padding: 30px 0;
        /* background: #F5F5F5; */
        /* border: 1px solid #F5F5F5; */

    }

    .chat-area {
        position: relative;
        width: 100%;
        background-color: #fff;
        border-radius: 1.3rem;
        height: 90vh;
        overflow: hidden;
        min-height: calc(100% - 1rem);
    }

    .chatlist {
        outline: 0;
        height: 100%;
        overflow: hidden;
        width: 300px;
        float: left;
        padding: 15px;
    }

    .chat-area .modal-content {
        border: none;
        border-radius: 0;
        outline: 0;
        height: 100%;
    }

    .chat-area .modal-dialog-scrollable {
        height: 100% !important;
    }

    .chatbox {
        width: auto;
        overflow: hidden;
        height: 100%;
        border-left: 1px solid #ccc;
    }

    .chatbox .modal-dialog,
    .chatlist .modal-dialog {
        max-width: 100%;
        margin: 0;
    }

    .msg-search {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-area .form-control {
        display: block;
        width: 80%;
        padding: 0.375rem 0.75rem;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        color: #222;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ccc;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .chat-area .form-control:focus {
        outline: 0;
        box-shadow: inherit;
    }

    a.add img {
        height: 36px;
    }

    .chat-area .nav-tabs {
        border-bottom: 1px solid #DEE2E6;
        align-items: center;
        justify-content: space-between;
        flex-wrap: inherit;
    }

    .chat-area .nav-tabs .nav-item {
        width: 100%;
    }

    .chat-area .nav-tabs .nav-link {
        width: 100%;
        color: #180660;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.5;
        text-transform: capitalize;
        margin-top: 5px;
        margin-bottom: -1px;
        background: 0 0;
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }

    .chat-area .nav-tabs .nav-item.show .nav-link,
    .chat-area .nav-tabs .nav-link.active {
        color: #222;
        background-color: #fff;
        border-color: transparent transparent #000;
    }

    .chat-area .nav-tabs .nav-link:focus,
    .chat-area .nav-tabs .nav-link:hover {
        border-color: transparent transparent #000;
        isolation: isolate;
    }

    .chat-list h3 {
        color: #222;
        font-size: 16px;
        font-weight: 500;
        line-height: 1.5;
        text-transform: capitalize;
        margin-bottom: 0;
    }

    .chat-list p {
        color: #343434;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        text-transform: capitalize;
        margin-bottom: 0;
    }

    .chat-list a.d-flex {
        margin-bottom: 15px;
        position: relative;
        text-decoration: none;
    }

    .chat-list .active {
        display: block;
        content: '';
        clear: both;
        position: absolute;
        bottom: 3px;
        left: 34px;
        height: 12px;
        width: 12px;
        background: #00DB75;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .msg-head h3 {
        color: #222;
        font-size: 18px;
        font-weight: 600;
        line-height: 1.5;
        margin-bottom: 0;
    }

    .msg-head p {
        color: #343434;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        text-transform: capitalize;
        margin-bottom: 0;
    }

    .msg-head {
        padding: 15px;
        border-bottom: 1px solid #ccc;
    }

    .moreoption {
        display: flex;
        align-items: center;
        justify-content: end;
    }

    .moreoption .navbar {
        padding: 0;
    }

    .moreoption li .nav-link {
        color: #222;
        font-size: 16px;
    }

    .moreoption .dropdown-toggle::after {
        display: none;
    }

    .moreoption .dropdown-menu[data-bs-popper] {
        top: 100%;
        left: auto;
        right: 0;
        margin-top: 0.125rem;
    }

    .msg-body ul {
        overflow: hidden;
    }

    .msg-body ul li {
        list-style: none;
        margin: 15px 0;
    }

    .msg-body ul li.sender {
        display: block;
        width: 100%;
        position: relative;
    }

    .msg-body ul li.sender:before {
        display: block;
        clear: both;
        content: '';
        position: absolute;
        top: -6px;
        left: -7px;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 12px 15px 12px;
        border-color: transparent transparent #F5F5F5 transparent;
        -webkit-transform: rotate(-37deg);
        -ms-transform: rotate(-37deg);
        transform: rotate(-37deg);
    }

    .msg-body ul li.sender p {
        color: #000;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 400;
        padding: 15px;
        background: #F5F5F5;
        display: inline-block;
        border-bottom-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        margin-bottom: 0;
    }

    .msg-body ul li.sender p b {
        display: block;
        color: #180660;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 500;
    }

    .msg-body ul li.repaly {
        display: block;
        width: 100%;
        text-align: right;
        position: relative;
    }



    .msg-body ul li.repaly p {
        color: #fff;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 400;
        padding: 15px;
        background: #4B7BEC;
        display: inline-block;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-left-radius: 10px;
        margin-bottom: 0;
    }

    .msg-body ul li.repaly p b {
        display: block;
        color: #061061;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 500;
    }

    .msg-body ul li.repaly:after {
        display: block;
        content: '';
        clear: both;
    }

    .time {
        display: block;
        color: #000;
        font-size: 12px;
        line-height: 1.5;
        font-weight: 400;
    }

    li.repaly .time {
        margin-right: 20px;
    }

    .divider {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .msg-body h6 {
        text-align: center;
        font-weight: normal;
        font-size: 14px;
        line-height: 1.5;
        color: #222;
        background: #fff;
        display: inline-block;
        padding: 0 5px;
        margin-bottom: 0;
    }

    .divider:after {
        display: block;
        content: '';
        clear: both;
        position: absolute;
        top: 12px;
        left: 0;
        border-top: 1px solid #EBEBEB;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    .send-box {
        padding: 15px;
        border-top: 1px solid #ccc;
    }

    .send-box form {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .send-box .form-control {
        display: block;
        width: 85%;
        padding: 0.375rem 0.75rem;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        color: #222;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ccc;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .send-box button {
        border: none;
        background: #3867D6;
        padding: 0.375rem 5px;
        color: #fff;
        border-radius: 0.25rem;
        font-size: 14px;
        font-weight: 400;
        width: 24%;
        margin-left: 1%;
    }

    .send-box button i {
        margin-right: 5px;
    }

    .send-btns .button-wrapper {
        position: relative;
        width: 125px;
        height: auto;
        text-align: left;
        margin: 0 auto;
        display: block;
        background: #F6F7FA;
        border-radius: 3px;
        padding: 5px 15px;
        float: left;
        margin-right: 5px;
        margin-bottom: 5px;
        overflow: hidden;
    }

    .send-btns .button-wrapper span.label {
        position: relative;
        z-index: 1;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        width: 100%;
        cursor: pointer;
        color: #343945;
        font-weight: 400;
        text-transform: capitalize;
        font-size: 13px;
    }

    #upload {
        display: inline-block;
        position: absolute;
        z-index: 1;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .send-btns .attach .form-control {
        display: inline-block;
        width: 120px;
        height: auto;
        padding: 5px 8px;
        font-size: 13px;
        font-weight: 400;
        line-height: 1.5;
        color: #343945;
        background-color: #F6F7FA;
        background-clip: padding-box;
        border: 1px solid #F6F7FA;
        border-radius: 3px;
        margin-bottom: 5px;
    }

    .send-btns .button-wrapper span.label img {
        margin-right: 5px;
    }

    .button-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        text-align: center;
        margin: 0 auto;
    }

    button:focus {
        outline: 0;
    }

    .add-apoint {
        display: inline-block;
        margin-left: 5px;
    }

    .add-apoint a {
        text-decoration: none;
        background: #F6F7FA;
        border-radius: 8px;
        padding: 8px 8px;
        font-size: 13px;
        font-weight: 400;
        line-height: 1.2;
        color: #343945;
    }

    .add-apoint a svg {
        margin-right: 5px;
    }

    .chat-icon {
        display: none;
    }

    .closess i {
        display: none;
    }

    @media (max-width: 767px) {
        .chat-icon {
            display: block;
            margin-right: 5px;
        }

        .chatlist {
            width: 100%;
        }

        .chatbox {
            width: 100%;
            position: absolute;
            left: 1000px;
            right: 0;
            background: #fff;
            transition: all 0.5s ease;
            border-left: none;
        }

        .showbox {
            left: 0 !important;
            transition: all 0.5s ease;
        }

        .msg-head h3 {
            font-size: 14px;
        }

        .msg-head p {
            font-size: 12px;
        }

        .msg-head .flex-shrink-0 img {
            height: 30px;
        }

        .send-box button {
            width: 28%;
        }

        .send-box .form-control {
            width: 70%;
        }

        .chat-list h3 {
            font-size: 14px;
        }

        .chat-list p {
            font-size: 12px;
        }

        .msg-body ul li.sender p {
            font-size: 13px;
            padding: 8px;
            border-bottom-left-radius: 6px;
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .msg-body ul li.repaly p {
            font-size: 13px;
            padding: 8px;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
            border-bottom-left-radius: 6px;
        }
    }

    .input-fields-box {
        display: flex;
        justify-content: space-between;
    }

    .input-fields-box div {
        width: 48%;
        padding: 12px;
    }

    .input-fields-box h2 {
        font-size: 16px;
        color: #232325;
        font-weight: 500;
        font-family: sans-serif;
    }

    .input-fields-box label {
        margin-left: 0px;
    }
</style>
<main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Chats</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Chats</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                    {!! Form::open(['method' => 'GET', 'url' => '/admin/genres', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search']) !!}
                    <div class="input-group input-group-outline" style="margin-top: 15px;">
                        {{-- <label class="form-label">Type here...</label>
                        <input type="text" class="form-control" name="search" style="height:40px;" > --}}
                        {{-- <input type="text" class="form-control" name="search" placeholder="Search..."> --}}
                        {{-- <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span> --}}
                    </div>
                    {!! Form::close() !!}
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
                            <h6 class="text-white text-capitalize ps-3">Chats</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <section class="message-area">
                            {{-- <div class="container-fluid">
                        <div class="row">
                          <div class="col-12"> --}}
                            <div class="chat-area">
                                <!-- chatbox -->
                                <div class="chatbox showbox">
                                    <div class="modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="msg-head">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="d-flex align-items-center">
                                                            <span class="chat-icon"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/arroleftt.svg" alt="image title"></span>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h3>{{ $receiver_detail->name }}</h3>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="modal-body">
                                                <div class="msg-body">
                                                    <ul>
                                                        @foreach ($chats->items() as $chat)
                                                        @php
                                                        $senderName = optional($sender_detail)->name ?? 'Sender Not Found';
                                                        $receiverName = optional($receiver_detail)->name ?? 'Receiver Not Found';
                                                        $isSender = $chat->sender_id == optional($sender_detail)->id;
                                                        $displayName = $isSender ? $senderName : $receiverName;
                                                        @endphp
                                                        <li class="{{ $isSender ? 'sender' : 'repaly' }}">
                                                            <p>
                                                                @if ($displayName !== 'Sender Not Found' && $displayName !== 'Receiver Not Found')
                                                                <strong>{{ $displayName }}</strong>:
                                                                @endif
                                                                {{ $chat->message }}
                                                                <span class="time">{{ $chat->created_at->format('h:i A') }}</span>
                                                                <!-- <span class="date">{{ $chat->created_at->format('M d, Y') }}</span> -->
                                                            </p>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>





                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- chatbox -->
                    </div>
                    {{-- </div>
                      </div>
                      </div> --}}
                    </section>
                </div>
            </div>
        </div>
    </div>

    </div>

</main>

@endsection