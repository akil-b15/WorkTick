@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">

@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Help_and_Support') }}</h1>
    <ul>
        {{-- <li><a href="/employees">{{ __('translate.Contact') }}</a></li> --}}
        <li>{{ __('translate.Contact') }}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

    @foreach ($contacts as $contact)
        <p class="text-primary text-24 mt-2 mb-0">{{$contact->name}}</p>
        <p class="text-muted text-16 line-height-1 mb-2"><b></b>{{$contact->email}}</p>
        <p class="text-muted text-16 line-height-1 mb-2"><b></b>{{$contact->phone}}</p>
    @endforeach
<div class="row" id="section_Employee_list">
    
</div>

@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>


@endsection