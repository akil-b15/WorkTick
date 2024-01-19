@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">


@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Frequently_Asked_Questions') }}</h1>
    {{-- <ul>
        <li><a href="/faq">{{ __('translate.faq_List') }}</a></li>
        <li>{{ __('translate.faq') }}</li>
    </ul> --}}
</div>

<div class="separator-breadcrumb border-top"></div>


<div class="row" id="section_Faq_list">
    <div class="col-md-12">
        <div class="card text-left">
            {{-- @can('faqs') --}}
            <div class="card-header text-right bg-transparent">
                <a class="btn btn-primary btn-md m-1" @click="New_Faq"><i class="i-Add text-white mr-2"></i>
                    {{ __('translate.Create') }}</a>
                <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                        class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a>
            </div>
            {{-- @endcan --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table id="faq_table" class="display table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('translate.Questions') }}</th>
                                <th>{{ __('translate.Answers') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($faqs as $faq)
                            <tr>
                                <td @click="selected_row( {{ $faq->id}})"></td>
                                <td><b>{{$faq->question}}</b></td>
                                <td>{{$faq->answer}}</td>
                                <td>
                                    {{-- @can('faq') --}}
                                    <a @click="Edit_Faq( {{ $faq}})" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>

                                    <a @click="Remove_Faq( {{ $faq->id}})"
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

        <!-- Modal Add & Edit FAQ -->
        <div class="modal fade" id="Faq_Modal" tabindex="-1" role="dialog" aria-labelledby="Faq_Modal"
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

                        <form @submit.prevent="editmode?Update_Faq():Create_Faq()">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="question" class="ul-form__label">{{ __('translate.Question') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" v-model="faq.question" class="form-control" name="question"
                                        id="question" placeholder="{{ __('translate.Enter_question') }}">
                                    <span class="error" v-if="errors && errors.question">
                                        @{{ errors.question[0] }}
                                    </span>
                                    <label for="answer" class="ul-form__label">{{ __('translate.Answer') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" v-model="faq.answer" class="form-control" name="answer"
                                        id="answer" placeholder="{{ __('translate.Enter_answer') }}">
                                    <span class="error" v-if="errors && errors.answer">
                                            @{{ errors.answer[0] }}
                                    
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
        el: '#section_Faq_list',
        data: {
            selectedIds:[],
            editmode: false,
            SubmitProcessing:false,
            errors:[],
            faqs: [], 
            faq: {
                question: "",
                answer: "",
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


            //------------------------------ Show Modal (Create FAQ) -------------------------------\\
            New_Faq() {
                this.reset_Form();
                this.editmode = false;
                $('#Faq_Modal').modal('show');
            },

            //------------------------------ Show Modal (Update FAQ) -------------------------------\\
            Edit_Faq(faq) {
                this.editmode = true;
                this.reset_Form();
                this.faq = faq;
                $('#Faq_Modal').modal('show');
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_Form() {
                this.faq = {
                    id: "",
                    question: "",
                    answer: "",
                };
                this.errors = {};
            },

            //------------------------ Create FAQ ---------------------------\\
            Create_Faq() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/faqs/create", {
                    question: self.faq.question,
                    answer: self.faq.answer,

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/faqs/all_faqs'; 
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

           //----------------------- Update FAQ ---------------------------\\
            Update_Faq() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/faqs/update/" + self.faq.id, {
                    question: self.faq.question,
                    answer: self.faq.answer,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/faqs/all_faqs'; 
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

             //--------------------------------- Remove FAQ ---------------------------\\
            Remove_Faq(id) {

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
                            .delete("/faqs/delete/" + id)
                            .then(() => {
                                window.location.href = '/faqs/all_faqs'; 
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
                        .post("/faqs/delete/by_selection", {
                            selectedIds: self.selectedIds
                        })
                            .then(() => {
                                window.location.href = '/faqs/all_faqs'; 
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

        $('#faq_table').DataTable( {
            "processing": true, // for show progress bar
            select: {
                style: 'multi',
                selector: '.select-checkbox',
                items: 'row',
            },
            columnDefs: [
                {
                    targets: 0,
                    className: 'select-checkbox'
                },
                {
                    targets: [0],
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