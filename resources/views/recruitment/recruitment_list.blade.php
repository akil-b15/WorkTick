@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">

@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Job_List') }}</h1>
    <ul>
        <li>{{ __('translate.Job') }}</li>
        <li>{{ __('translate.Job_List') }}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-All"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">{{ __('translate.Total') }}</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$total}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Yes"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">{{ __('translate.Active') }}</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$active}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
            <div class="card-body text-center">
                <i class="i-Loading-3"></i>
                <div class="content">
                    <p class="text-muted mt-2 mb-0">{{ __('translate.Inactive') }}</p>
                    <p class="text-primary text-24 line-height-1 mb-2">{{$inactive}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="section_Recruitment_list">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-header text-right bg-transparent">
                @can('recruitment_add')
                <a class="btn btn-primary btn-md m-1" href="{{route('recruitments.create')}}"><i
                        class="i-Add text-white mr-2"></i> {{ __('translate.Create') }}</a>
                @endcan
                @can('recruitment_delete')
                <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                        class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="recruitment_list_table" class="display table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>{{ __('translate.Title') }}</th>
                                <th>{{ __('translate.Start_Date') }}</th>
                                <th>{{ __('translate.End_Date') }}</th>
                                <th>{{ __('translate.Status') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $job)
                            <tr>
                                <td></td>
                                <td @click="selected_row( {{ $job->id}})"></td>
                                <td><a href="/recruitments/{{$job->id}}">{{$job->title}}</a></td>
                                <td>{{$job->start_date}}</td>
                                <td>{{$job->end_date}}</td>
                                <td>
                                    @if($job->status == 'active')
                                    <span class="badge badge-success m-2">{{ __('translate.Active') }}</span>
                                    @elseif($job->status == 'inactive')
                                    <span class="badge badge-danger m-2">{{ __('translate.Inactive') }}</span>
                                    @endif
                                </td>

                                <td>
                                    @can('recruitment_details')
                                    <a href="/recruitments/{{$job->id}}" class="ul-link-action text-info"
                                        data-toggle="tooltip" data-placement="top" title="Show">
                                        <i class="i-Eye"></i>
                                    </a>
                                    @endcan

                                    @can('recruitment_edit')
                                    <a href="/recruitments/{{$job->id}}/edit" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>
                                    @endcan
                                    @can('recruitment_delete')
                                    <a @click="Remove_recruitment( {{ $job->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>
                                    @endcan
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

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>

<script>
    var app = new Vue({
        el: '#section_recruitment_list',
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

            //--------------------------------- Remove recruitment ---------------------------\\
            Remove_recruitment(id) {

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
                            .delete("/recruitments/" + id)
                            .then(() => {
                                window.location.href = '/recruitments'; 
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
                        .post("/recruitments/delete/by_selection", {
                            selectedIds: self.selectedIds
                        })
                            .then(() => {
                                window.location.href = '/recruitments'; 
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

        $('#recruitment_list_table').DataTable( {
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