@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">

@endsection

<div class="breadcrumb">
    <h1>Payslip Lists</h1>
    <ul>
        <li>Payslip</li>
        <li>Payslip Lists</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

{{-- <div class="row">
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
</div> --}}

<div class="row" id="section_payslip_list">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-header text-right bg-transparent">
                {{-- @can('payslip_add') --}}
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <form @submit.prevent="Show_Salary()">
                                <div class="row align-items-end">
                                    <div class="col-md-4 col-12">
                                        <label class="ul-form__label">Select Month<span
                                                class="field_required">*</span></label>
                                        <v-select @input="Selected_Month" placeholder="Select month"
                                            v-model="show_salary.month" :reduce="(option) => option.value" :options="
                                                [
                                                    {value: '01', label: 'JAN'},
                                                    {value: '02', label: 'FEB'},
                                                    {value: '03', label: 'MAR'},
                                                    {value: '04', label: 'APR'},
                                                    {value: '05', label: 'MAY'},
                                                    {value: '06', label: 'JUN'},
                                                    {value: '07', label: 'JUL'},
                                                    {value: '08', label: 'AUG'},
                                                    {value: '09', label: 'SEP'},
                                                    {value: '10', label: 'OCT'},
                                                    {value: '11', label: 'NOV'},
                                                    {value: '12', label: 'DEC'}
                                                ]">
                                        </v-select>
                                        <span class="error" v-if="errors && errors.month">
                                            @{{ errors.month[0] }}
                                        </span>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <label class="ul-form__label">Select Year<span
                                                class="field_required">*</span></label>
                                        <v-select @input="Selected_Year" placeholder="Select year"
                                            v-model="show_salary.year" :reduce="(option) => option.value" :options="
                                                [
                                                    @foreach ($year as $label => $value)
                                                        {{ '{value: '.$value.', label: '.$label.'},' }}
                                                    @endforeach
                                                ]">
                                        </v-select>
                                        <span class="error" v-if="errors && errors.year">
                                            @{{ errors.year[0] }}
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary" :disabled="SubmitProcessing">
                                            Show
                                        </button>
                                        <div v-once class="typo__p" v-if="SubmitProcessing">
                                            <div class="spinner spinner-primary mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 col-md-122">
                            <form @submit.prevent="Create_Payslip()">
                                <div class="row align-items-end justify-content-center">
                                    <div class="col-md-4 col-12">
                                        <label class="ul-form__label">Select Month<span
                                                class="field_required">*</span></label>
                                        <v-select @input="Selected_Month" placeholder="Select month"
                                            v-model="salary_generate.month" :reduce="(option) => option.value" :options="
                                                [
                                                    {value: '01', label: 'JAN'},
                                                    {value: '02', label: 'FEB'},
                                                    {value: '03', label: 'MAR'},
                                                    {value: '04', label: 'APR'},
                                                    {value: '05', label: 'MAY'},
                                                    {value: '06', label: 'JUN'},
                                                    {value: '07', label: 'JUL'},
                                                    {value: '08', label: 'AUG'},
                                                    {value: '09', label: 'SEP'},
                                                    {value: '10', label: 'OCT'},
                                                    {value: '11', label: 'NOV'},
                                                    {value: '12', label: 'DEC'}
                                                ]">
                                        </v-select>

                                        <span class="error" v-if="errors && errors.month">
                                            @{{ errors.month[0] }}
                                        </span>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <label class="ul-form__label">Select Year<span
                                                class="field_required">*</span></label>
                                        <v-select @input="Selected_Year" placeholder="Select year"
                                            v-model="salary_generate.year" :reduce="(option) => option.value" :options="
                                                [
                                                    @foreach ($year as $label => $value)
                                                        {{ '{value: '.$value.', label: '.$label.'},' }}
                                                    @endforeach
                                                ]">
                                        </v-select>

                                        <span class="error" v-if="errors && errors.year">
                                            @{{ errors.year[0] }}
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary" :disabled="SubmitProcessing">
                                            Generate
                                        </button>
                                        <div v-once class="typo__p" v-if="SubmitProcessing">
                                            <div class="spinner spinner-primary mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                
                {{-- @endcan --}}
                {{-- @can('payslip_delete') --}}
                {{-- <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                        class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a> --}}
                {{-- @endcan --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="payslip_list_table" class="display table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>{{ __('translate.Name') }}</th>
                                <th>Salary</th>
                                <th>Net Salary</th>
                                <th>Status</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payslips as $payslip)
                            <tr>
                                <td></td>
                                <td @click="selected_row( {{ $payslip['id']}})"></td>
                                <td>{{$payslip['firstname']}} {{$payslip['lastname']}}</td>
                                <td>{{number_format($payslip['salary'], 2)}}</td>
                                <td>{{number_format($payslip['net_salary'], 2)}}</td>
                                <td>
                                    @if($payslip['status'] == 1)
                                        <span style="font-size: 0.8rem" class="badge badge-primary p-2 m-2">Paid</span>
                                    @elseif($payslip['status'] == 0)
                                        <spa style="font-size: 0.8rem" class="badge badge-danger p-2 m-2">unpaid</spa>
                                    @endif
                                </td>
                                <td>
                                    <a @click="Show_payslip( {{ $payslip['id']}})"
                                        role="button"
                                        class="ul-link-action text-primary mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Show">
                                        <i class="i-Eye"></i>
                                    </a>
                                    @if($payslip['status'] == 0)
                                        <a @click="Mark_paid( {{ $payslip['payslip_id']}})"
                                            class="ul-link-action text-info mr-1" data-toggle="tooltip"
                                            data-placement="top" title="Mark Paid">
                                            <i class="i-Yes"></i>
                                        </a>
                                    @endif

                                    <a @click="Remove_payslip( {{ $payslip['payslip_id']}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>

                                    {{-- @can('job_on_boarding_add')
                                        @if ($payslip->stage == 4)
                                        <a href="/job_on_boarding/{{$payslip->id}}" class="ul-link-action text-info"
                                            data-toggle="tooltip" data-placement="top" title="On Board">
                                            <i class="i-Add"></i>
                                        </a>
                                        @endif
                                    
                                    @endcan
                                    @can('payslip_details')
                                    <a href="/payslips/{{$payslip->id}}" class="ul-link-action text-info"
                                        data-toggle="tooltip" data-placement="top" title="Show">
                                        <i class="i-Eye"></i>
                                    </a>
                                    @endcan

                                    @can('payslip_edit')
                                    @if ($payslip->stage != 5)
                                    <a href="/payslips/{{$payslip->id}}/edit" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>
                                    @endif
                                    @endcan
                                    @can('payslip_delete')
                                    <a @click="Remove_payslip( {{ $payslip->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>
                                    @endcan --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="salary_Modal" tabindex="-1" role="dialog" aria-labelledby="salary_Modal" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payslip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="payslip-body">
                    
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets/js/html2pdf.bundle.min.js') }}"></script>
<script>
    function saveAsPDF(name) {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,
            filename: name,
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 4,
                dpi: 72,
                letterRendering: true
            },
            jsPDF: {
                unit: 'in',
                format: 'A4'
            }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

<script>
    Vue.component('v-select', VueSelect.VueSelect)
    var app = new Vue({
        el: '#section_payslip_list',
        data: {
            errors:[],
            SubmitProcessing:false,
            salary_generate: {
                'month': "",
                'year': "",
            },
            show_salary: {
                'month': "{{ request()->month ? request()->month : now()->format('m') }}",
                'year': "{{ request()->year ? request()->year : now()->format('Y') }}",
            },
        },
       
        methods: {

            Selected_Month(value) {
                if (value === null) {
                    this.salary_generate.month = "";
                }
            },

            Selected_Year(value) {
                if (value === null) {
                    this.salary_generate.year = "";
                }
            },

            Show_payslip(id){
                var self = this;
                let month = `${self.show_salary.year}-${self.show_salary.month}`;
                axios
                .get(`/payslips/show/${id}/${month}`)
                .then((res) => {
                    console.log(res)
                    let body = document.querySelector('#payslip-body');
                    body.innerHTML = res.data;
                    $('#salary_Modal').modal('show');
                })
                .catch(error => {
                    self.SubmitProcessing = false;
                    if (error.response.status == 422) {
                        self.errors = error.response.data.errors;
                    }
                    toastr.error('{{ __('translate.There_was_something_wronge') }}');
                });
            },

            //--------------------------------- Remove payslip ---------------------------\\
            Create_Payslip(id) {
                var self = this;
                // self.SubmitProcessing = true;

                axios
                .post("/payslips", {
                    month: self.salary_generate.month,
                    year: self.salary_generate.year,
                })
                .then(() => {
                    window.location.reload(); 
                    toastr.success('{{ __('translate.Created_in_successfully') }}');
                    self.errors = {};
                })
                .catch(error => {
                    self.SubmitProcessing = false;
                    if (error.response.status == 422) {
                        self.errors = error.response.data.errors;
                    }
                    toastr.error('{{ __('translate.There_was_something_wronge') }}');
                });
            },

            Mark_paid(id) {
                var self = this;
                // self.SubmitProcessing = true;
                swal({
                    title: '{{ __('translate.Are_you_sure') }}',
                    text: '{{ __('translate.You_wont_be_able_to_revert_this') }}',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0CC27E',
                    cancelButtonColor: '#FF586B',
                    confirmButtonText: 'Yes mark as paid!',
                    cancelButtonText: '{{ __('translate.No_cancel') }}',
                    confirmButtonClass: 'btn btn-primary mr-5',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    axios
                    .post(`/payslips/paid/${id}`)
                    .then(() => {
                        window.location.reload(); 
                        toastr.success('{{ __('translate.Paid_successfully') }}');
                        self.errors = {};
                    })
                    .catch(error => {
                        self.SubmitProcessing = false;
                        if (error.response.status == 422) {
                            self.errors = error.response.data.errors;
                        }
                        toastr.error('{{ __('translate.There_was_something_wronge') }}');
                    });
                });
            },

            Remove_payslip(id) {
                var self = this;
                // self.SubmitProcessing = true;
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
                    .delete(`/payslips/${id}`)
                    .then(() => {
                        window.location.reload(); 
                        toastr.success('{{ __('translate.Deleted_successfully') }}');
                        self.errors = {};
                    })
                    .catch(error => {
                        self.SubmitProcessing = false;
                        if (error.response.status == 422) {
                            self.errors = error.response.data.errors;
                        }
                        toastr.error('{{ __('translate.There_was_something_wronge') }}');
                    });
                });
            },

            Show_Salary(id) {
                var self = this;
                window.location.href = `/payslips?year=${self.show_salary.year}&month=${self.show_salary.month}`;
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
                    .post("/payslips/delete/by_selection", {
                        selectedIds: self.selectedIds
                    })
                        .then(() => {
                            window.location.reload(); 
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

        $('#payslip_list_table').DataTable( {
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