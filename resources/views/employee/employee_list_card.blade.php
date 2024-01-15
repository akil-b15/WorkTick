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
                        <a class="dropdown-item" href="{{ URL::current()."?sort=location"}}">Location</a>
                        </div>
                    </div>
                </div>
                {{-- Creata  --}}
                <div class="col-lg-4 text-right">
                    @can('employee_add')
                        <a class="btn btn-primary btn-md m-1" href="{{route('employees.create')}}"><i
                                class="i-Add-User text-white mr-2"></i> {{ __('translate.Create') }}</a>
                        @endcan
                        @can('employee_delete')
                        <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                                class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a>
                        @endcan
                </div>
            </div>

            <div class="row card-body">                   
                @foreach($employees as $employee)               
            
                <div class="col-lg-3 col-md-6 col-sm-6">
                    
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="form-check text-right">
                                <input class="form-check-input" type="checkbox" value="" @click="selected_row( {{ $employee->id}})" id="flexCheckChecked">                                
                            </div>
                            
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
                                    <p class="text-muted text-16 line-height-1 mb-2"><b>Joining Date: </b> {{$employee->joining_date}}</p>
                                    <p class="text-muted text-16 line-height-1 mb-2"><b>Phone: </b> {{$employee->phone}}</p>
                                    <p class="text-muted text-16 line-height-1 mb-2"><b>Email: </b> {{$employee->email}}</p>
                                    <p class="text-muted text-16 line-height-1 mb-2"><b>Country: </b> {{$employee->country}}</p>
                                </div>
                            </div>
                            <div class="text-right mb-2 mr-2">
                                @can('employee_edit')
                                    <a href="/employees/{{$employee->id}}/edit" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit" style="font-size: 2rem;"></i>
                                    </a>
                                @endcan
                                {{-- <button class="btn btn-danger">Delete</button> --}}
                                @can('employee_delete')
                                    <a @click="Remove_Employee( {{ $employee->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window" style="font-size: 2rem;"></i>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    
                </div>                                      
                @endforeach
                    
            </div>  
                    
                
        </div>
    </div>
</div>

@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>


<script>
    var app = new Vue({
        el: '#section_Employee_list',
        data: {
            SubmitProcessing:false,
            selectedIds:[],
        },
       
        methods: {

            //---- Event selected_row
            selected_row(id) {
                //in here you can check what ever condition  before append to array.
                if(this.selectedIds.includes(id)){
                    const index = this.selectedIds.indexOf(id);
                    this.selectedIds.splice(index, 1);
                }else{
                    this.selectedIds.push(id)
                }
            },

            //--------------------------------- Remove Employee ---------------------------\\
            Remove_Employee(id) {

                swal({
                    title: '{{ __('translate.Are_you_sure') }}',
                    text: '{{ __('translate.You_wont_be_able_to_revert_this') }}',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0CC27E',
                    cancelButtonColor: '#FF586B',
                    confirmButtonText: '{{ __('translate.Yes_delete_it') }}',
                    cancelButtonText: '{{ __('translate.No_cancel') }}',
                    confirmButtonClass: 'btn btn-primary mr-5',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                        axios
                            .delete("/employees/" + id)
                            .then(() => {
                                window.location.href = '/employees'; 
                                toastr.success('{{ __('translate.Deleted_in_successfully') }}');

                            })
                            .catch(() => {
                                toastr.error('{{ __('translate.There_was_something_wronge') }}');
                            });
                    });
                },


                
            //--------------------------------- delete_selected ---------------------------\\
            delete_selected() {
                var self = this;
                swal({
                    title: '{{ __('translate.Are_you_sure') }}',
                    text: '{{ __('translate.You_wont_be_able_to_revert_this') }}',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0CC27E',
                    cancelButtonColor: '#FF586B',
                    confirmButtonText: '{{ __('translate.Yes_delete_it') }}',
                    cancelButtonText: '{{ __('translate.No_cancel') }}',
                    confirmButtonClass: 'btn btn-primary mr-5',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                        axios
                        .post("/employees/delete/by_selection", {
                            selectedIds: self.selectedIds
                        })
                            .then(() => {
                                window.location.href = '/employees'; 
                                toastr.success('{{ __('translate.Deleted_in_successfully') }}');

                            })
                            .catch(() => {
                                toastr.error('{{ __('translate.There_was_something_wronge') }}');
                            });
                    });
            },         
        },
    })

</script>


@endsection