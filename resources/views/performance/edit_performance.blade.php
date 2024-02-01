@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/vue-slider-component.css')}}">
@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Edit_Performance') }}</h1>
    <ul>
        <li><a href="/performance">{{ __('translate.Performances') }}</a></li>
        <li>{{ __('translate.Edit_Performance') }}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<!-- begin::main-row -->
<div class="row" id="section_Performance_Edit">
    <div class="col-lg-12 mb-3">
        <div class="card">

            <!--begin::form-->
            <form @submit.prevent="Update_Performance()">
                <div class="card-body">

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="goal_type"
                                class="ul-form__label">{{ __('translate.Goal_Type') }}</label>
                            <input type="text" class="form-control" id="goal_type"
                                placeholder="{{ __('translate.Enter_Goal_Type') }}"
                                v-model="performance.goal_type">
                            <span class="error" v-if="errors && errors.goal_type">
                                @{{ errors.goal_type[0] }}
                            </span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="subject"
                                class="ul-form__label">{{ __('translate.Subject') }}</label>
                            <input type="text" class="form-control" id="subject"
                                placeholder="{{ __('translate.Enter_Subject') }}"
                                v-model="performance.subject">
                            <span class="error" v-if="errors && errors.subject">
                                @{{ errors.subject[0] }}
                            </span>
                        </div>

                        <div class="col-md-6">
                            <label class="ul-form__label">{{ __('translate.Employees') }} <span
                                    class="field_required">*</span></label>
                            <v-select @input="Selected_Employee"
                                placeholder="{{ __('translate.Choose_Employees') }}" v-model="performance.employee_id"
                                :reduce="label => label.value"
                                :options="employees.map(employees => ({label: employees.username, value: employees.id}))">
                            </v-select>
                            <span class="error" v-if="errors && errors.assigned_to">
                                @{{ errors.assigned_to[0] }}
                            </span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="target_achievement"
                                class="ul-form__label">{{ __('translate.Target_Achievement') }}</label>
                            <input type="text" class="form-control" id="target_achievement"
                                placeholder="{{ __('translate.Enter_Target_Achievement') }}"
                                v-model="performance.target_achievement">
                            <span class="error" v-if="errors && errors.target_achievement">
                                @{{ errors.target_achievement[0] }}
                            </span>
                        </div>


                        <div class="col-md-6">
                            <label for="start_date" class="ul-form__label">{{ __('translate.Start_Date') }} <span
                                    class="field_required">*</span></label>

                            <vuejs-datepicker id="start_date" name="start_date"
                                placeholder="{{ __('translate.Enter_Start_date') }}" v-model="performance.start_date"
                                input-class="form-control" format="yyyy-MM-dd"
                                @closed="performance.start_date=formatDate(performance.start_date)">
                            </vuejs-datepicker>

                            <span class="error" v-if="errors && errors.start_date">
                                @{{ errors.start_date[0] }}
                            </span>
                        </div>

                        <div class="col-md-6">
                            <label for="end_date" class="ul-form__label">{{ __('translate.Finish_Date') }} <span
                                    class="field_required">*</span></label>

                            <vuejs-datepicker id="end_date" name="end_date"
                                placeholder="{{ __('translate.Enter_Finish_date') }}" v-model="performance.end_date"
                                input-class="form-control" format="yyyy-MM-dd"
                                @closed="performance.end_date=formatDate(performance.end_date)">
                            </vuejs-datepicker>

                            <span class="error" v-if="errors && errors.end_date">
                                @{{ errors.end_date[0] }}
                            </span>
                        </div>
                    
                        <div class="col-md-6">
                            <label class="ul-form__label">{{ __('translate.Progress') }}</label>
                            <vue-slider v-model="performance.progress" />
                        </div>

                        

                        <div class="form-group col-md-6">
                            <label class="ul-form__label">{{ __('translate.Rating_Out_Five') }}</label>
                            <input type="number" class="form-control" min="0" max="5" id="rating"
                                placeholder="{{ __('translate.Rating_Out_Five') }}"
                                v-model="performance.rating">
                            <span class="error" v-if="errors && errors.rating">
                                @{{ errors.rating[0] }}
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
    el: '#section_Performance_Edit',
    components: {
        vuejsDatepicker,
        VueSlider: window['vue-slider-component']
    },
    data: {
        SubmitProcessing:false,
        errors:[],
        
        employees: @json($employees),
        performance:@json($performance), 
    },
   
   
    methods: {

        formatDate(d){
                var m1 = d.getMonth()+1;
                var m2 = m1 < 10 ? '0' + m1 : m1;
                var d1 = d.getDate();
                var d2 = d1 < 10 ? '0' + d1 : d1;
                return [d.getFullYear(), m2, d2].join('-');
            },

            // Selected_Trainer(value) {
            //     if (value === null) {
            //         this.performance.trainer_id = "";
            //     }
            // },

            // Selected_Trainer_Skill(value) {
            //     if (value === null) {
            //         this.performance.performance_skill_id = "";
            //     }
            // },

            Selected_Employee(value) {
                if (value === null) {
                    this.performance.employee_id = "";
                }
            },

            // Selected_Status(value) {
            //     if (value === null) {
            //         this.performance.status = "";
            //     }
            // },

            // Selected_Company(value) {
            //     if (value === null) {
            //         this.performance.company_id = "";
            //     }
            //     this.employees = [];
            //     this.assigned_employees = [];
            //     this.Get_employees_by_company(value);
            // },

            //  //---------------------- Get_employees_by_company ------------------------------\\
            
            //  Get_employees_by_company(value) {
            //     axios
            //     .get("/Get_employees_by_company?id=" + value)
            //     .then(({ data }) => (this.employees = data));
            // },



           //----------------------- Update performance ---------------------------\\
            Update_Performance() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/performance/" + self.performance.id, {
                    goal_type: self.performance.goal_type,
                    subject: self.performance.subject,
                    employee_id: self.performance.employee_id,
                    target_achievement: self.performance.target_achievement,
                    start_date: self.performance.start_date,
                    end_date: self.performance.end_date,
                    progress: self.performance.progress,
                    rating: self.performance.rating,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/performance'; 
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