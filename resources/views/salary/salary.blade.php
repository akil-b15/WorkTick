@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">


@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Manage_Employee_Salary') }}</h1>
    {{-- <ul>
        <li><a href="/contact">{{ __('translate.contact_List') }}</a></li>
        <li>{{ __('translate.contact') }}</li>
    </ul> --}}
</div>

<div class="separator-breadcrumb border-top"></div>


<div class="row" id="section_set_salary">
    <div class="col-md-12">
        <div class="card text-left">
            {{-- @can('contacts') --}}
            <div class="card-header text-right bg-transparent">
                <a class="btn btn-primary btn-md m-1" @click="New_contact"><i class="i-Add text-white mr-2"></i>
                    {{ __('translate.Create') }}</a>
                <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                        class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a>
            </div>
            {{-- @endcan --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table id="salary_table" class="display table">
                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>{{ __('translate.Employee_ID') }}</th>
                                <th>{{ __('translate.Name') }}</th>
                                <th>{{ __('translate.Payroll_Type') }}</th>
                                <th>{{ __('translate.Salary') }}</th>
                                <th>{{ __('translate.Net_Salary') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                {{-- <td @click="selected_row( {{ $contact->id}})"></td> --}}
                                <td>{{$employee->id}}</td>
                                <td>{{$employee->username}}</td>
                                <td></td>
                                <td>{{$employee->salary}}</td>
                                <td></td>
                                <td>
                                    <a href="{{ route('salary.show', $employee->id) }}" class="ul-link-eye text-success mr-1"
                                        data-toggle="tooltip" data-placement="top" title="Show">
                                        <i class="i-Eye" style="font-size: 2rem;color:#8b5cf6;"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Add & Edit contact -->
        <div class="modal fade" id="contact_Modal" tabindex="-1" role="dialog" aria-labelledby="contact_Modal"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editmode" class="modal-title">{{ __('translate.Edit') }}</h5>
                        <h5 v-else class="modal-title">{{ __('translate.Create') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form @submit.prevent="editmode?Update_contact():Create_contact()">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name" class="ul-form__label">{{ __('translate.Name') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" v-model="contact.name" class="form-control" name="name"
                                        id="name" placeholder="{{ __('translate.Contact_Name') }}">
                                    <span class="error" v-if="errors && errors.name">
                                        @{{ errors.name[0] }}
                                    </span>
                                    <label for="email" class="ul-form__label">{{ __('translate.Email') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" v-model="contact.email" class="form-control" name="email"
                                        id="email" placeholder="{{ __('translate.Contact_Email') }}">
                                    <span class="error" v-if="errors && errors.email">
                                            @{{ errors.email[0] }}
                                    </span>
                                    <label for="phone" class="ul-form__label">{{ __('translate.Phone') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" v-model="contact.phone" class="form-control" name="phone"
                                        id="phone" placeholder="{{ __('translate.Contact_Phone_No') }}">
                                    <span class="error" v-if="errors && errors.phone">
                                            @{{ errors.phone[0] }}
                                    </span>       
                                    
                                </div>

                            </div>


                            <div class="row mt-3">

                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" :disabled="SubmitProcessing">
                                        {{ __('translate.Submit') }}
                                    </button>
                                    <div v-once class="typo__p" v-if="SubmitProcessing">
                                        <div class="spinner spinner-primary mt-3"></div>
                                    </div>
                                </div>
                            </div>


                        </form>

                    </div>

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
        el: '#section_set_salary',
        data: {
            selectedIds:[],
            editmode: false,
            SubmitProcessing:false,
            errors:[],
            contacts: [], 
            contact: {
                name: "",
                email: "",
                phone: "",
            }, 
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


            //------------------------------ Show Modal (Create contact) -------------------------------\\
            New_contact() {
                this.reset_Form();
                this.editmode = false;
                $('#contact_Modal').modal('show');
            },

            //------------------------------ Show Modal (Update contact) -------------------------------\\
            Edit_contact(contact) {
                this.editmode = true;
                this.reset_Form();
                this.contact = contact;
                $('#contact_Modal').modal('show');
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_Form() {
                this.contact = {
                    id: "",
                    name: "",
                    email: "",
                    phone: "",
                };
                this.errors = {};
            },

            //------------------------ Create contact ---------------------------\\
            Create_contact() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/contact/create", {
                    name: self.contact.name,
                    email: self.contact.email,
                    phone: self.contact.phone,

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/contact/show'; 
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

           //----------------------- Update contact ---------------------------\\
            Update_contact() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/contact/update/" + self.contact.id, {
                    name: self.contact.name,
                    email: self.contact.email,
                    phone: self.contact.phone,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/contact/show'; 
                        toastr.success('{{ __('translate.Updated_in_successfully') }}');
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

             //--------------------------------- Remove contact ---------------------------\\
            Remove_contact(id) {

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
                            .delete("/contact/delete/" + id)
                            .then(() => {
                                window.location.href = '/contact/show'; 
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
                        .post("/contact/delete/by_selection", {
                            selectedIds: self.selectedIds
                        })
                            .then(() => {
                                window.location.href = '/contact/show'; 
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

        $('#salary_table').DataTable( {
            "processing": true, // for show progress bar
            // select: {
            //     style: 'multi',
            //     selector: '.select-checkbox',
            //     items: 'row',
            // },
            // columnDefs: [
            //     {
            //         targets: 0,
            //         className: 'select-checkbox'
            //     },
            //     {
            //         targets: [0],
            //         orderable: false
            //     }
            // ],
        
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