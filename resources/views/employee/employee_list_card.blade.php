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
        <div class="card text-left">
            
            <div class="row card-header bg-transparent">
                <div class="col-lg-6 text-left">
                    <form action="">
                        <div class="form-group">
                          <label for="">Search</label>
                          <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
                          <small id="helpId" class="text-muted">Help text</small>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 text-right">
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
                            @if($employee->avatar !== 'no_avatar.png')
                            <img class="card-img-top" src="{{asset('assets/images/employee/avatar/'. $employee->avatar)}}" alt="Card image cap">
                            @else
                            <img class="card-img-top" src="{{asset('assets/images/employee/avatar/noimage.jpg')}}" alt="Card image cap">
                            @endif

                            <div class="card-body">
                                <div class="">
                                    <p class="text-primary text-24 mt-2 mb-0">{{$employee->firstname}} {{$employee->lastname}}</p>
                                    <p class="text-muted line-height-1 mb-2">{{$employee->designation->designation}}</p>
                                    <p class="text-muted line-height-1 mb-2">{{$employee->department->department}}</p>
                                    <p class="text-muted line-height-1 mb-2">{{$employee->phone}}</p>
                                    <p class="text-muted line-height-1 mb-2">{{$employee->email}}</p>
                                    <p class="text-muted line-height-1 mb-2">{{$employee->joining_date}}</p>
                                </div>
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
        //-----------------------------Autoload function-------------------
        created() {
        }

    })

</script>

<script type="text/javascript">
    $(function () {
      "use strict";

        $('#employee_list_table').DataTable( {
            "processing": true, // for show progress bar
            select: {
                style: 'multi',
                selector: '.select-checkbox',
                items: 'row',
            },
            responsive: {
                details: {
                    type: 'column',
                    target: 0
                }
            },
            columnDefs: [{
                targets: 0,
                    className: 'control'
                },
                {
                    targets: 1,
                    className: 'select-checkbox'
                },
                {
                    targets: [0, 1],
                    orderable: false
                }
            ],
        
            dom: "<'row'<'col-sm-12 col-md-7'lB><'col-sm-12 col-md-5 p-0'f>>rtip",
            oLanguage:
                { 
                sLengthMenu: "_MENU_", 
                sSearch: '',
                sSearchPlaceholder: "Search..."
            },
            buttons: [
                {
                    extend: 'collection',
                    text: 'EXPORT',
                    buttons: [
                        'csv','excel', 'pdf', 'print'
                    ]
                }]
        });

    });
</script>
@endsection