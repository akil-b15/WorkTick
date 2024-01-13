@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">


@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Announcements') }}</h1>
    <ul>
        <li><a href="/core/announcements">{{ __('translate.Announcements') }}</a></li>
        <li>{{ __('translate.Announcements') }}</li>
    </ul>
</div>
<p>Published at: {{ $announcement->created_at->format("Y-m-d") }}</p>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_Announcement_list">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h3>{{ $announcement->title }}</h3>
                <p> {{ $announcement->description }} </p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/vuejs-datepicker/vuejs-datepicker.min.js')}}"></script>


<script>
    Vue.component('v-select', VueSelect.VueSelect)
        var app = new Vue({
        el: '#section_Announcement_list',
        components: {
            vuejsDatepicker
        },
        data: {
            selectedIds:[],
            editmode: false,
            SubmitProcessing:false,
            errors:[],
            companies: [],
            departments: [],
            announcements: {}, 
            all_department : {
                id :"null",
                department :'all departments',
            },
            announcement: {
                title: "",
                description:"",
                summary:"",
                company_id:"",
                department_id:"",
                start_date:"",
                end_date:"",
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

            formatDate(d){
                var m1 = d.getMonth()+1;
                var m2 = m1 < 10 ? '0' + m1 : m1;
                var d1 = d.getDate();
                var d2 = d1 < 10 ? '0' + d1 : d1;
                return [d.getFullYear(), m2, d2].join('-');
            },

            Selected_Department(value) {
                if (value === null) {
                    this.announcement.department_id = "";
                }
            },

            //------------------------------ Show Modal (Create announcement) -------------------------------\\
            New_Announcement() {
                this.reset_Form();
                this.departments = [];
                this.editmode = false;
                this.Get_Data_Create();
                $('#Announcement_Modal').modal('show');
            },

            //------------------------------ Show Modal (Update Announcement) -------------------------------\\
            Edit_Announcement(announcement) {
                this.editmode = true;
                this.reset_Form();
                this.Get_Data_Edit(announcement.id);
                this.Get_departments_by_company(announcement.company_id);
                this.announcement = announcement;
                if(announcement.department_id === null){
                    this.announcement.department_id = "null";
                }
                $('#Announcement_Modal').modal('show');
            },

            Selected_Company(value) {
                if (value === null) {
                    this.announcement.company_id = "";
                    this.announcement.department_id = "";
                    this.departments = [];
                }else{
                    this.departments = [];
                    this.announcement.department_id = "";
                
                    this.Get_departments_by_company(value);
                }
            },


            
             //---------------------- Get Data Create  ------------------------------\\
             Get_Data_Create() {
                axios
                    .get("/core/announcements/create")
                    .then(response => {
                        this.companies   = response.data.companies;
                    })
                    .catch(error => {
                       
                    });
            },

             
             //---------------------- Get Data Edit  ------------------------------\\
             Get_Data_Edit(id) {
                axios
                    .get("/core/announcements/"+id+"/edit")
                    .then(response => {
                        this.companies   = response.data.companies;
                    })
                    .catch(error => {
                       
                    });
            },

            //---------------------- Get_departments_by_company ------------------------------\\
            Get_departments_by_company(value) {

                axios
                .get("/core/Get_departments_by_company?id=" + value)
                    .then(response => {
                        this.departments = response.data;
                        
                    })
                    .catch(error => {
                       
                    });
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_Form() {
                this.announcement = {
                    id: "",
                    title: "",
                    description:"",
                    summary:"",
                    company_id:"",
                    department_id:"",
                    start_date:"",
                    end_date:"",
                };
                this.errors = {};
            },
            
            //------------------------ Create Announcement ---------------------------\\
            Create_Announcement() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/core/announcements", {
                    title: self.announcement.title,
                    description: self.announcement.description,
                    summary: self.announcement.summary,
                    company_id: self.announcement.company_id,
                    department: self.announcement.department_id,
                    start_date: self.announcement.start_date,
                    end_date: self.announcement.end_date,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/core/announcements'; 
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

           //----------------------- Update Announcement ---------------------------\\
            Update_Announcement() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/core/announcements/" + self.announcement.id, {
                    title: self.announcement.title,
                    description: self.announcement.description,
                    summary: self.announcement.summary,
                    company_id: self.announcement.company_id,
                    department: self.announcement.department_id,
                    start_date: self.announcement.start_date,
                    end_date: self.announcement.end_date,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/core/announcements'; 
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

             //--------------------------------- Remove Announcement ---------------------------\\
            Remove_Announcement(id) {

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
                            .delete("/core/announcements/" + id)
                            .then(() => {
                                window.location.href = '/core/announcements'; 
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
                        .post("/core/announcements/delete/by_selection", {
                            selectedIds: self.selectedIds
                        })
                            .then(() => {
                                window.location.href = '/core/announcements'; 
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

        $('#announcement_list_table').DataTable( {
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