@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">


@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Policy') }}</h1>
    <ul>
        <li><a href="/core/policies">{{ __('translate.Policy') }}</a></li>
        <li>{{ __('translate.Policy') }}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_Policy_list">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h3>{{ $policy->title }}</h3>
                <p> {{ $policy->description }} </p>
            </div>
        </div>

    </div>
</div>

@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>



<script>
    Vue.component('v-select', VueSelect.VueSelect)

        var app = new Vue({
        el: '#section_Policy_list',
        data: {
            selectedIds:[],
            editmode: false,
            SubmitProcessing:false,
            errors:[],
            policies: {}, 
            companies: [], 
            policy: {
                title: "",
                company_id:"",
                description:"",
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


            //------------------------------ Show Modal (Create Policy) -------------------------------\\
            New_Policy() {
                this.reset_Form();
                this.editmode = false;
                this.Get_Data_Create();
                $('#Policy_Modal').modal('show');
            },

            //------------------------------ Show Modal (Update Policy) -------------------------------\\
            Edit_Policy(policy) {
                this.editmode = true;
                this.reset_Form();
                this.Get_Data_Edit(policy.id);
                this.policy = policy;
                $('#Policy_Modal').modal('show');
            },


             //---------------------- Get_Data_Create ------------------------------\\
             Get_Data_Create() {
                axios
                    .get("/core/policies/create")
                    .then(response => {
                        this.companies   = response.data.companies;
                    })
                    .catch(error => {
                       
                    });
            },

            //---------------------- Get_Data_Edit ------------------------------\\
            Get_Data_Edit(id) {
                axios
                    .get("/core/policies/"+id+"/edit")
                    .then(response => {
                        this.companies   = response.data.companies;
                    })
                    .catch(error => {
                       
                    });
            },

            Selected_Company(value) {
                if (value === null) {
                    this.policy.company_id = "";
                }
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_Form() {
                this.policy = {
                    id: "",
                    title: "",
                    company_id:"",
                    description: "",
                };
                this.errors = {};
            },
            
            //------------------------ Create Policy ---------------------------\\
            Create_Policy() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/core/policies", {
                    title: self.policy.title,
                    company_id: self.policy.company_id,
                    description: self.policy.description,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/core/policies'; 
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

           //----------------------- Update Policy ---------------------------\\
            Update_Policy() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/core/policies/" + self.policy.id, {
                    title: self.policy.title,
                    company_id: self.policy.company_id,
                    description: self.policy.description,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/core/policies'; 
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

             //--------------------------------- Remove policy ---------------------------\\
            Remove_Policy(id) {

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
                            .delete("/core/policies/" + id)
                            .then(() => {
                                window.location.href = '/core/policies'; 
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
                        .post("/core/policies/delete/by_selection", {
                            selectedIds: self.selectedIds
                        })
                            .then(() => {
                                window.location.href = '/core/policies'; 
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

        $('#policy_list_table').DataTable( {
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