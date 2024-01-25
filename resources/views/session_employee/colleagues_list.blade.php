@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">

@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Employee_List') }}</h1>
    <ul>
        <li><a href="/employees">{{ __('translate.Employees') }}</a></li>
        <li>{{ __('translate.Employee_List') }}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_Employee_list">
    <div class="col-md-12">
        <div class="card">
            
            <div class="row card-header bg-transparent">
                <div class="row col-lg-8 text-left inline">
                    <div class="ml-4 mr-2">
                        <form class="form-inline" action="">

                            <div class="text-right form-group">                         
                                <input type="text" name="search" id="" class="form-control" placeholder="search by name or department" aria-describedby="helpId" value="{{$search}}">
                                <button class="btn btn-primary">Search</button>
                            </div>
                                
                        </form>
                    </div>
                    {{-- Sort  --}}
                    <div>
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort By:
                        </a>
                        
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ URL::current()."?sort="}}">None</a>
                        <a class="dropdown-item" href="{{ URL::current()."?sort=department"}}">Department</a>
                        <a class="dropdown-item" href="{{ URL::current()."?sort=jobtitle"}}">Job title</a>
                        {{-- <a class="dropdown-item" href="{{ URL::current()."?sort=location"}}">Location</a> --}}
                        </div>
                    </div>
                </div>
                {{-- Creata  --}}
                
            </div>

            <div class="row card-body">                   
                @foreach($employees as $employee)               
            
                <div class="col-lg-3 col-md-6 col-sm-6">
                    
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            
                            
                            @if($employee->avatar !== 'no_avatar.png')
                            <img class="card-img-top" src="{{asset('assets/images/employee/avatar/'. $employee->avatar)}}" alt="Card image cap">
                            @else
                            <img class="card-img-top" src="{{asset('assets/images/employee/avatar/noimage.jpg')}}" alt="Card image cap">
                            @endif

                            <div class="card-body">
                                <div class="">
                                    <p class="text-primary text-24 mt-2 mb-0">{{$employee->firstname}} {{$employee->lastname}}</p>
                                    <p class="text-muted text-16 line-height-1 mb-2"><b>Job Title: </b>{{$employee->designation->designation}}</p>
                                    <p class="text-muted text-16 line-height-1 mb-2"><b>Department: </b> {{$employee->department->department}}</p>
                                    
                                    <p class="text-muted text-16 line-height-1 mb-2"><b>Phone: </b> {{$employee->phone}}</p>
                                    <p class="text-muted text-16 line-height-1 mb-2"><b>Email: </b> {{$employee->email}}</p>
                                </div>
                            </div>
                            
                        </div>
                    
                </div>                                      
                @endforeach

            </div>
            
            <div class="card-body">
                {{ $employees->links() }}
            </div>           
                
        </div>
    </div>
</div>

@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>


@endsection