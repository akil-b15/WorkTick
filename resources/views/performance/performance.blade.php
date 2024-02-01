@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">


@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Performance') }}</h1>
    
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_performance_list">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-header text-right bg-transparent">
                {{-- @can('performance_add') --}}
                <a class="btn btn-primary btn-md m-1" href="{{route('performance.create')}}"><i
                        class="i-Add text-white mr-2"></i> {{ __('translate.Create') }}</a>
                {{-- @endcan --}}
                {{-- @can('performance_delete') --}}
                <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                        class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a>
                {{-- @endcan --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="performance_list_table" class="display table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>{{ __('translate.Goal_Type') }}</th>
                                <th>{{ __('translate.Subject') }}</th>
                                <th>{{ __('translate.Employee') }}</th>
                                <th>{{ __('translate.Target_Achievement') }}</th>
                                <th>{{ __('translate.Start_Date') }}</th>
                                <th>{{ __('translate.Finish_Date') }}</th>
                                <th>{{ __('translate.Rating') }}</th>
                                <th>{{ __('translate.Progress') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($performances as $performance)
                            <tr>
                                <td></td>
                                <td @click="selected_row( {{ $performance->id}})"></td>
                                <td>{{$performance->goal_type}}</td>
                                <td>{{$performance->subject}}</td>
                                <td>{{$performance->employee->username}}</td>
                                <td>{{$performance->target_achievement}}</td>
                                <td>{{$performance->start_date}}</td>
                                <td>{{$performance->end_date}}</td>
                                <td>
                                    <div class="rating">
                                        @for($i=1; $i<= $performance->ratings; $i++)
                                            <i class="fa fa-star checked"></i>
                                        @endfor
                                        @for($i= $performance->ratings+1; $i<= 5; $i++)
                                            <i class="fa fa-star"></i>
                                        @endfor                                       
                                    </div>
                                </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{$performance->progress}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">{{$performance->progress}}%</div>
                                    </div>
                                </td>
                                
                                <td class="text-right">
                                    {{-- @can('performance_view') --}}
                                    {{-- <a href="/performances/{{$performance->id}}" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Show">
                                        <i class="i-Eye"></i>
                                    </a> --}}
                                    {{-- @endcan --}}

                                    {{-- @can('performance_edit') --}}
                                    <a href="/performance/{{$performance->id}}/edit" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>
                                    {{-- @endcan --}}

                                    {{-- @can('performance_delete') --}}
                                    <a @click="Remove_Performance( {{ $performance->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>
                                    {{-- @endcan --}}

                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection

@section('page-js')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>


<script>
    var app = new Vue({
        el: '#section_performance_list',
        data: {
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

             //--------------------------------- Remove performance ---------------------------\\
            Remove_Performance(id) {

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
                            .delete("/performance/" + id)
                            .then(() => {
                                window.location.href = '/performance'; 
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
                        .post("/performance/delete/by_selection", {
                            selectedIds: self.selectedIds
                        })
                            .then(() => {
                                window.location.href = '/performance'; 
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

    $('#performance_list_table').DataTable( {
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

<style>
    .checked {
        color: #ffc107
    }
</style>
@endsection