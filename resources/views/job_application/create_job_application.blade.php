@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/vue-slider-component.css')}}">

@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Create_Job_application') }}</h1>
    <ul>
        <li><a href="/job_applications">{{ __('translate.Job_application') }}</a></li>
        <li>{{ __('translate.Create_Job_application') }}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<!-- begin::main-row -->
<div class="row" id="section_Job_application_Create">
    <div class="col-lg-12 mb-3">
        <div class="card">

            <!--begin::form-->
            <form @submit.prevent="Create_Job_application()">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="first_name" class="ul-form__label">{{ __('translate.Firstname') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" v-model="job_application.first_name" class="form-control" name="first_name" id="first_name"
                                placeholder="{{ __('translate.Enter_Firstname') }}">
                            <span class="error" v-if="errors && errors.first_name">
                                @{{ errors.first_name[0] }}
                            </span>
                        </div>

                        <div class="col-md-4">
                            <label for="last_name" class="ul-form__label">{{ __('translate.Lastname') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" v-model="job_application.last_name" class="form-control" name="last_name" id="last_name"
                                placeholder="{{ __('translate.Enter_Lastname') }}">
                            <span class="error" v-if="errors && errors.last_name">
                                @{{ errors.last_name[0] }}
                            </span>
                        </div>

                        <div class="col-md-6">
                            <label class="ul-form__label">{{ __('translate.Stage') }} <span
                                    class="field_required">*</span></label>
                            <v-select @input="Selected_Stage" placeholder="{{ __('translate.Choose_Stage') }}"
                                v-model="job_application.stage" :reduce="(option) => option.value" :options="
                                    [
                                        {label: 'Applied', value: 1},
                                        {label: 'Phone Screen', value: 2},
                                        {label: 'Interview', value: 3},
                                        {label: 'Hired', value: 4},
                                    ]">
                            </v-select>
                            <span class="error" v-if="errors && errors.stage">
                                @{{ errors.stage[0] }}
                            </span>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="ul-form__label">{{ __('translate.Job') }} <span
                                    class="field_required">*</span></label>
                            <v-select @input="Selected_Job" placeholder="{{ __('translate.Choose_Job') }}"
                                v-model="job_application.job_id" :reduce="label => label.value"
                                :options="jobs.map(jobs => ({label: jobs.title, value: jobs.id}))">
                            </v-select>
                            <span class="error" v-if="errors && errors.job_id">
                                @{{ errors.job_id[0] }}
                            </span>
                        </div>

                        <div class="col-md-6">
                            <label class="ul-form__label">{{ __('translate.Gender') }} <span
                                    class="field_required">*</span></label>
                            <v-select @input="Selected_Gender" placeholder="{{ __('translate.Choose_Gender') }}"
                                v-model="job_application.gender" :reduce="(option) => option.value" :options="
                                    [
                                        {label: 'Male', value: 'male'},
                                        {label: 'Female', value: 'female'},
                                    ]">
                            </v-select>
                            <span class="error" v-if="errors && errors.gender">
                                @{{ errors.gender[0] }}
                            </span>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="ul-form__label" for="picker3">{{ __('translate.Birth_date') }}<span
                                class="field_required">*</span></label>
                            <vuejs-datepicker id="birth_date" name="birth_date"
                                placeholder="{{ __('translate.Enter_Birth_date') }}" v-model="job_application.birth_date"
                                input-class="form-control" format="yyyy-MM-dd"
                                @closed="job_application.birth_date=formatDate(job_application.birth_date)">
                            </vuejs-datepicker>

                            <span class="error" v-if="errors && errors.birth_date">
                                @{{ errors.birth_date[0] }}
                            </span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4" class="ul-form__label">{{ __('translate.Email_Address') }} <span
                                    class="field_required">*</span></label>
                            <input type="email" class="form-control" id="inputtext4"
                                placeholder="{{ __('translate.Enter_email_address') }}" v-model="job_application.email">
                            <span class="error" v-if="errors && errors.email">
                                @{{ errors.email[0] }}
                            </span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone" class="ul-form__label">{{ __('translate.Phone_Number') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control" id="phone"
                                placeholder="{{ __('translate.Enter_Phone_Number') }}" v-model="job_application.phone">
                            <span class="error" v-if="errors && errors.phone">
                                @{{ errors.phone[0] }}
                            </span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="country" class="ul-form__label">{{ __('translate.Country') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control" id="country"
                                placeholder="{{ __('translate.Enter_Country') }}" v-model="job_application.country">
                            <span class="error" v-if="errors && errors.country">
                                @{{ errors.country[0] }}
                            </span>
                        </div>

                        <div class="col-md-4">
                            <label for="skill" class="ul-form__label">{{ __('translate.Skill') }}</label>
                            <textarea type="text" v-model="job_application.skill" class="form-control" name="skill"
                                id="skill" placeholder="{{ __('translate.Enter_skill') }}"></textarea>

                            <span class="error" v-if="errors && errors.skill">
                                @{{ errors.skill[0] }}
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
    el: '#section_Job_application_Create',
    components: {
        vuejsDatepicker,
        VueSlider: window['vue-slider-component']
    },
    data: {
        SubmitProcessing:false,
        errors:[],
        jobs:@json($jobs), 
        tooltip:'right',
        job_application: {
            job_id: "",
            first_name: "",
            last_name:"",
            stage:"",
            gender:"",
            birth_date:"",
            phone:"",
            country:"",
            skill:"",
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

        Selected_Gender(value) {
            if (value === null) {
                this.job_application.gender = "";
            }
        }, 

        Selected_Stage(value) {
            if (value === null) {
                this.job_application.stage = "";
            }
        },

        Selected_Job(value) {
            if (value === null) {
                this.job_application.job_id = "";
            }
        },
        
        //------------------------ Create Job_application ---------------------------\\
        Create_Job_application() {
            var self = this;
            self.SubmitProcessing = true;
            axios.post("/job_applications", {
                first_name: self.job_application.first_name,
                last_name: self.job_application.last_name,
                stage: self.job_application.stage,
                email: self.job_application.email,
                gender: self.job_application.gender,
                birth_date: self.job_application.birth_date,
                phone: self.job_application.phone,
                country: self.job_application.country,
                skill: self.job_application.skill,
                job_id: self.job_application.job_id,
            }).then(response => {
                self.SubmitProcessing = false;
                window.location.href = '/job_applications'; 
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