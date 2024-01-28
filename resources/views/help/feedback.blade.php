@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">

@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Frequently_Asked_Questions') }}</h1>
    <ul>
        {{-- <li><a href="/employees">{{ __('translate.FAQ') }}</a></li> --}}
        <li>{{ __('translate.FAQ') }}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="container contact-form card">
    <div class="contact-image">
        <img src="{{asset('assets/images/rocket.png')}}" alt="rocket"/>
    </div>
    <form action="{{url('feedback/store')}}" method="post">
        @csrf
        <h3>Send Your Feedback</h3>
        <div class="row">
            <div class="col-md-2 text-center"></div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="title"><h5>Feedback On *</h5></label>
                    <input type="text" name="title" class="form-control" placeholder="Feedback title" value="" />
                    <span class="text-danger">@error('title'){{$message}}@enderror</span>
                </div>
                <div class="form-group mb-3">
                    <label for="feedback"><h5>Write your Feedback *</h5></label>
                    <textarea name="feedback" class="form-control" placeholder="Your feedback here" style="width: 100%; height: 150px;"></textarea>
                    <span class="text-danger">@error('feedback'){{$message}}@enderror</span>
                </div>
                <div class="form-group text-center">
                    <input type="submit" name="btnSubmit" class="btn btn-primary" value="Send" />
                </div>
            </div>
            <div class="col-md-2 text-center"></div>
        </div>
    </form>
</div>
<div class="row" id="section_Employee_list">
    
</div>

@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>

<style>
    body{
        background: -webkit-linear-gradient(left, #0072ff, #00c6ff);
    }
    .contact-form{
        background: #fff;
        /* margin-top: 10%; */
        margin-bottom: 5%;
        width: 70%;
    }
    .contact-form .form-control{
        border-radius:1rem;
    }
    .contact-image{
        text-align: center;
    }
    .contact-image img{
        border-radius: 6rem;
        width: 11%;
        margin-top: -3%;
        transform: rotate(29deg);
    }
    .contact-form form{
        padding: 10%;
    }
    .contact-form form .row{
        margin-bottom: -7%;
    }
    .contact-form h3{
        margin-bottom: 4%;
        margin-top: -10%;
        text-align: center;
        color: #0062cc;
    }
    .contact-form .btnContact {
        width: 50%;
        border: none;
        border-radius: 1rem;
        padding: 1.5%;
        background: #dc3545;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
    }
    .btnContactSubmit
    {
        width: 50%;
        border-radius: 1rem;
        padding: 1.5%;
        color: #fff;
        background-color: #0062cc;
        border: none;
        cursor: pointer;
    }
</style>
@endsection