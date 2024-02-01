@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/vue-slider-component.css')}}">

@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Training_View') }}</h1>
    <ul>
        <li><a href="/trainings">{{ __('translate.Trainings') }}</a></li>
        <li>{{ __('translate.Training') }}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<!-- begin::main-row -->
<div class="row" id="section_Training_Edit">
    <div class="col-lg-12 mb-3">
        <div class="card">

            <!--begin::form-->
            <form @submit.prevent="Update_Training()">
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">
                            <label class="ul-form__label">{{ __('translate.Trainer') }} <span
                                    class="field_required">*</span></label>
                            <p class="text-muted text-16 line-height-1 mb-2">{{ $training->trainer->name }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="ul-form__label">{{ __('translate.Training_Skill') }} <span
                                    class="field_required">*</span></label>
                            <p class="text-muted text-16 line-height-1 mb-2">{{ $training->TrainingSkill->training_skill }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="ul-form__label">{{ __('translate.Company') }} <span
                                    class="field_required">*</span></label>
                            <p class="text-muted text-16 line-height-1 mb-2">{{ $training->company->name }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="ul-form__label">{{ __('translate.Employees') }} <span
                                    class="field_required">*</span></label>                                    
                            <div class="d-flex">
                                @foreach ($training->assignedEmployees as $employee)
                                <span class="badge badge-primary text-16 line-height-1 m-2">{{ $employee->username }}</span>
                                @endforeach
                            </div>
                        </div>


                        <div class="col-md-6">
                            <label for="start_date" class="ul-form__label">{{ __('translate.Start_Date') }} <span
                                    class="field_required">*</span></label>
                            <p class="text-muted text-16 line-height-1 mb-2">{{ $training->start_date }}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="end_date" class="ul-form__label">{{ __('translate.Finish_Date') }} <span
                                    class="field_required">*</span></label>
                            <p class="text-muted text-16 line-height-1 mb-2">{{ $training->end_date }}</p>
                        </div>


                        <div class="col-md-6">
                            <label for="training_cost" class="ul-form__label">{{ __('translate.Training_Cost') }}
                            </label>
                            <p class="text-muted text-16 line-height-1 mb-2">{{ $training->training_cost }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="ul-form__label">{{ __('translate.Status') }} <span
                                    class="field_required">*</span></label>
                            <div><span class="badge badge-{{ $employee->status ? 'primary' : 'danger' }} text-16 line-height-1 m-2">{{ $employee->status ? 'Active' : 'Inactive' }}</span></div>
                            {{-- <v-select @input="Selected_Status" placeholder="{{ __('translate.Choose_status') }}"
                                v-model="training.status" :reduce="(option) => option.value" :options="
                                            [
                                                {label: 'Active', value: 1},
                                                {label: 'Inactive', value: 0},
                                            ]">
                            </v-select>

                            <span class="error" v-if="errors && errors.status">
                                @{{ errors.status[0] }}
                            </span> --}}
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="ul-form__label">{{ __('translate.Description') }}</label>
                            <p class="text-muted text-16 line-height-1 mb-2">{{ $training->description }}</p>
                        </div>

                        <div class="col-md-4">
                            <label class="ul-form__label">{{ __('translate.Progress') }}</label>
                            <vue-slider v-model="training.progress" />
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
    el: '#section_Training_Edit',
    components: {
        vuejsDatepicker,
        VueSlider: window['vue-slider-component']
    },
    data: {
        SubmitProcessing:false,
        errors:[],
        trainers: @json($trainers), 
        companies: @json($companies),
        training_skills: @json($training_skills),
        employees: @json($employees),
        assigned_employees:@json($assigned_employees),
        training:@json($training), 
    },
   
   
    methods: {

        formatDate(d){
                var m1 = d.getMonth()+1;
                var m2 = m1 < 10 ? '0' + m1 : m1;
                var d1 = d.getDate();
                var d2 = d1 < 10 ? '0' + d1 : d1;
                return [d.getFullYear(), m2, d2].join('-');
            },

            Selected_Trainer(value) {
                if (value === null) {
                    this.training.trainer_id = "";
                }
            },

            Selected_Trainer_Skill(value) {
                if (value === null) {
                    this.training.training_skill_id = "";
                }
            },

            Selected_Employee(value) {
                if (value === null) {
                    this.assigned_employees = [];
                }
            },

            Selected_Status(value) {
                if (value === null) {
                    this.training.status = "";
                }
            },

            Selected_Company(value) {
                if (value === null) {
                    this.training.company_id = "";
                }
                this.employees = [];
                this.assigned_employees = [];
                this.Get_employees_by_company(value);
            },

             //---------------------- Get_employees_by_company ------------------------------\\
            
             Get_employees_by_company(value) {
                axios
                .get("/Get_employees_by_company?id=" + value)
                .then(({ data }) => (this.employees = data));
            },



           //----------------------- Update Training ---------------------------\\
            Update_Training() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/trainings/" + self.training.id + '/progress', {
                    progress: self.training.progress,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/trainings/' + self.training.id; 
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

           
        },
        //-----------------------------Autoload function-------------------
        created() {
        }

    })

</script>

@endsection