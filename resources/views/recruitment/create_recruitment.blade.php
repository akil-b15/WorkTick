@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/vue-slider-component.css')}}">

@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Create_Job') }}</h1>
    <ul>
        <li><a href="/recruitments">{{ __('translate.Job') }}</a></li>
        <li>{{ __('translate.Create_Job') }}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<!-- begin::main-row -->
<div class="row" id="section_Recruitment_Create">
    <div class="col-lg-12 mb-3">
        <div class="card">

            <!--begin::form-->
            <form @submit.prevent="Create_Recruitment()">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="title" class="ul-form__label">{{ __('translate.Recruitment_Title') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" v-model="recruitment.title" class="form-control" name="title" id="title"
                                placeholder="{{ __('translate.Enter_Recruitment_Title') }}">
                            <span class="error" v-if="errors && errors.title">
                                @{{ errors.title[0] }}
                            </span>
                        </div>

                        <div class="col-md-4">
                            <label for="start_date" class="ul-form__label">{{ __('translate.Start_Date') }} <span
                                    class="field_required">*</span></label>

                            <vuejs-datepicker id="start_date" name="start_date"
                                placeholder="{{ __('translate.Enter_Start_date') }}" v-model="recruitment.start_date"
                                input-class="form-control" format="yyyy-MM-dd"
                                @closed="recruitment.start_date=formatDate(recruitment.start_date)">
                            </vuejs-datepicker>

                            <span class="error" v-if="errors && errors.start_date">
                                @{{ errors.start_date[0] }}
                            </span>
                        </div>

                        <div class="col-md-4">
                            <label for="end_date" class="ul-form__label">{{ __('translate.Finish_Date') }} <span
                                    class="field_required">*</span></label>

                            <vuejs-datepicker id="end_date" name="end_date"
                                placeholder="{{ __('translate.Enter_Finish_date') }}" v-model="recruitment.end_date"
                                input-class="form-control" format="yyyy-MM-dd"
                                @closed="recruitment.end_date=formatDate(recruitment.end_date)">
                            </vuejs-datepicker>

                            <span class="error" v-if="errors && errors.end_date">
                                @{{ errors.end_date[0] }}
                            </span>
                        </div>

                        {{-- <div class="col-md-4">
                            <label class="ul-form__label">{{ __('translate.Client') }} <span
                                    class="field_required">*</span></label>
                            <v-select @input="Selected_Client" placeholder="{{ __('translate.Choose_Client') }}"
                                v-model="recruitment.client_id" :reduce="label => label.value"
                                :options="clients.map(clients => ({label: clients.username, value: clients.id}))">
                            </v-select>
                            <span class="error" v-if="errors && errors.client">
                                @{{ errors.client[0] }}
                            </span>
                        </div> --}}

                        {{-- <div class="col-md-4">
                            <label class="ul-form__label">{{ __('translate.Company') }} <span
                                    class="field_required">*</span></label>
                            <v-select @input="Selected_Company" placeholder="{{ __('translate.Choose_Company') }}"
                                v-model="recruitment.company_id" :reduce="label => label.value"
                                :options="companies.map(companies => ({label: companies.name, value: companies.id}))">
                            </v-select>

                            <span class="error" v-if="errors && errors.company_id">
                                @{{ errors.company_id[0] }}
                            </span>
                        </div> --}}

                        {{-- <div class="col-md-4">
                            <label class="ul-form__label">{{ __('translate.Assigned_Employees') }} <span
                                    class="field_required">*</span></label>
                            <v-select multiple @input="Selected_Team" placeholder="{{ __('translate.Choose_Team') }}"
                                v-model="recruitment.assigned_to" :reduce="label => label.value"
                                :options="employees.map(employees => ({label: employees.username, value: employees.id}))">
                            </v-select>
                            <span class="error" v-if="errors && errors.assigned_to">
                                @{{ errors.assigned_to[0] }}
                            </span>
                        </div> --}}

                        <div class="col-md-4">
                            <label for="position" class="ul-form__label">{{ __('translate.Number_of_Positions') }}
                            </label>
                            <input type="text" v-model="recruitment.position" class="form-control"
                                name="position" id="title" placeholder="{{ __('translate.Enter_Number_of_Positions') }}">
                            <span class="error" v-if="errors && errors.position">
                                @{{ errors.position[0] }}
                            </span>
                        </div>


                        {{-- <div class="col-md-4">
                            <label for="summary" class="ul-form__label">{{ __('translate.Summary') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" v-model="recruitment.summary" class="form-control" name="summary"
                                id="summary" placeholder="{{ __('translate.Enter_Recruitment_Summary') }}">
                            <span class="error" v-if="errors && errors.summary">
                                @{{ errors.summary[0] }}
                            </span>
                        </div> --}}


                        <div class="col-md-4">
                            <label class="ul-form__label">{{ __('translate.Status') }} <span
                                    class="field_required">*</span></label>
                            <v-select @input="Selected_Status" placeholder="{{ __('translate.Select_status') }}"
                                v-model="recruitment.status" :reduce="(option) => option.value" :options="
                                        [
                                            {label: 'Active', value: 'active'},
                                            {label: 'Inactive', value: 'inactive'},
                                        ]">
                            </v-select>

                            <span class="error" v-if="errors && errors.status">
                                @{{ errors.status[0] }}
                            </span>
                        </div>

                        {{-- <div class="col-md-4">
                            <label class="ul-form__label">{{ __('translate.Status') }} <span
                                    class="field_required">*</span></label>
                            <v-select @input="Selected_Status" placeholder="{{ __('translate.Select_status') }}"
                                v-model="recruitment.status" :reduce="(option) => option.value" :options="
                                            [
                                                {label: 'Not Started', value: 'not_started'},
                                                {label: 'In Progress', value: 'progress'},
                                                {label: 'Cancelled', value: 'cancelled'},
                                                {label: 'On Hold', value: 'hold'},
                                                {label: 'Completed', value: 'completed'},
                                            ]">
                            </v-select>

                            <span class="error" v-if="errors && errors.status">
                                @{{ errors.status[0] }}
                            </span>
                        </div> --}}


                        {{-- <div class="col-md-4">
                            <label class="ul-form__label">{{ __('translate.Progress') }} </label>
                            <vue-slider v-model="recruitment.recruitment_progress" />
                        </div> --}}
                        <div class="col-4"></div>

                        <div class="col-md-4">
                            <label for="skill" class="ul-form__label">{{ __('translate.Skill') }}</label>
                            <textarea type="text" v-model="recruitment.skill" class="form-control" name="skill"
                                id="skill" placeholder="{{ __('translate.Enter_skill') }}"></textarea>

                            <span class="error" v-if="errors && errors.skill">
                                @{{ errors.skill[0] }}
                            </span>
                        </div>

                        <div class="col-md-4">
                            <label for="description" class="ul-form__label">{{ __('translate.Description') }}</label>
                            <textarea type="text" v-model="recruitment.description" class="form-control" name="description"
                                id="description" placeholder="{{ __('translate.Enter_description') }}"></textarea>
                            <span class="error" v-if="errors && errors.description">
                                @{{ errors.description[0] }}
                            </span>
                        </div>

                        <div class="col-md-4">
                            <label for="requirement" class="ul-form__label">{{ __('translate.Requirement') }}</label>
                            <textarea type="text" v-model="recruitment.requirement" class="form-control" name="requirement"
                                id="requirement" placeholder="{{ __('translate.Enter_requirement') }}"></textarea>
                            <span class="error" v-if="errors && errors.requirement">
                                @{{ errors.requirement[0] }}
                            </span>
                        </div>

                    </div>



                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary" :disabled="SubmitProcessing">
                                {{ __('translate.Submit') }}
                            </button>
                            <div v-once class="typo__p" v-if="SubmitProcessing">
                                <div class="spinner spinner-primary mt-3"></div>
                            </div>
                        </div>
                    </div>
            </form>

            <!-- end::form -->
        </div>
    </div>

</div>
@endsection


@section('page-js')

<script src="{{asset('assets/js/vendor/vuejs-datepicker/vuejs-datepicker.min.js')}}"></script>
<script src="{{asset('assets/js/vue-slider-component.min.js')}}"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect)
    var app = new Vue({
    el: '#section_Recruitment_Create',
    components: {
        vuejsDatepicker,
        VueSlider: window['vue-slider-component']
    },
    data: {
        SubmitProcessing:false,
        errors:[],
        employees:[],
        tooltip:'right',
        recruitment: {
            title: "",
            position:"",
            description:"",
            start_date:"",
            end_date:"",
            status:"",
            skill:"",
            requirement:"",
        }, 
    },
   
   
    methods: {


        formatDate(d){
                var m1 = d.getMonth()+1;
                var m2 = m1 < 10 ? '0' + m1 : m1;
                var d1 = d.getDate();
                var d2 = d1 < 10 ? '0' + d1 : d1;
                return [d.getFullYear(), m2, d2].join('-');
            },
            
        Selected_Status(value) {
            if (value === null) {
                this.recruitment.status = "";
            }
        }, 
        
        //------------------------ Create Recruitment ---------------------------\\
        Create_Recruitment() {
            var self = this;
            self.SubmitProcessing = true;
            axios.post("/recruitments", {
                title: self.recruitment.title,
                description: self.recruitment.description,
                position: self.recruitment.position,
                start_date: self.recruitment.start_date,
                end_date: self.recruitment.end_date,
                status: self.recruitment.status,
                skill: self.recruitment.skill,
                requirement: self.recruitment.requirement,
            }).then(response => {
                    self.SubmitProcessing = false;
                    window.location.href = '/recruitments'; 
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

    },
    //-----------------------------Autoload function-------------------
    created () {
    },

})

</script>

@endsection