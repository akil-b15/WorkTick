@extends('layouts.master')
@section('page-css')
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>{{ __('translate.Employee') }}</h1>
    <ul>
        <li><a href="/employee_profile">{{ __('translate.Profile') }}</a></li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
@if($employee->country == 'South Sudan')
<div class="card user-profile o-hidden mb-4" id="section_employee_Profile_list">
    <div class="header-cover"></div>
    <div class="user-info">
        <img class="profile-picture avatar-lg mb-2" src="{{asset('assets/images/avatar/'.Auth::user()->avatar)}}"
            alt="">
        <p class="m-0 text-24">@{{ user.username }}</p>
    </div>
    <div class="card-body">
        <form @submit.prevent="Update_SouthSudanProfile()">
            <div class="row">
                <div class="col-md-6">
                    <label for="birthstate" class="ul-form__label">{{ __('translate.BirthState') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.birthstate" class="form-control" name="birthstate" id="birthstate"
                        placeholder="{{ __('translate.Enter_BirthState') }}">
                    <span class="error" v-if="errors && errors.birthstate">
                        @{{ errors.birthstate[0] }}
                    </span>
                </div>

                <div class="col-md-6">
                    <label for="town" class="ul-form__label">{{ __('translate.Town') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.town" class="form-control" id="town" id="town"
                        placeholder="{{ __('translate.Enter_Town') }}">
                    <span class="error" v-if="errors && errors.town">
                        @{{ errors.town[0] }}
                    </span>
                </div>

                <div class="col-md-6">
                    <label for="payam_one" class="ul-form__label">{{ __('translate.Payam') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.payam_one" class="form-control" id="payam_one" id="payam_one"
                        placeholder="{{ __('translate.Enter_Payam') }} 1">
                    <span class="error" v-if="errors && errors.payam_one">
                        @{{ errors.payam_one[0] }}
                    </span>
                </div>
                <div class="col-md-6">
                    <label for="payam_two" class="ul-form__label">{{ __('translate.Payam') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.payam_two" class="form-control" id="payam_two" id="payam_two"
                        placeholder="{{ __('translate.Enter_Payam') }} 2">
                    <span class="error" v-if="errors && errors.payam_two">
                        @{{ errors.payam_two[0] }}
                    </span>
                </div>
                <div class="col-md-6">
                    <label for="payam_three" class="ul-form__label">{{ __('translate.Payam') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.payam_three" class="form-control" id="payam_three" id="payam_three"
                        placeholder="{{ __('translate.Enter_Payam') }} 3">
                    <span class="error" v-if="errors && errors.payam_three">
                        @{{ errors.payam_three[0] }}
                    </span>
                </div>
                <div class="col-md-6">
                    <label class="ul-form__label">{{ __('translate.Gender') }} <span
                            class="field_required">*</span></label>
                    <v-select @input="Selected_Gender" placeholder="{{ __('translate.Choose_Gender') }}"
                        v-model="user.gender" :reduce="(option) => option.value" :options="
                            [
                                {label: 'Male', value: 'male'},
                                {label: 'Female', value: 'female'},
                            ]">
                    </v-select>

                    <span class="error" v-if="errors && errors.gender">
                        @{{ errors.gender[0] }}
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
{{-------------------------------------------- NON SOUTH SUDAN ---------------------------------- --}}
{{-- -------------------------------------------------------------------------------------------- --}}
@else
<div class="card user-profile o-hidden mb-4" id="section_employee_Profile_list">
    <div class="header-cover"></div>
    <div class="user-info">
        <img class="profile-picture avatar-lg mb-2" src="{{asset('assets/images/avatar/'.Auth::user()->avatar)}}"
            alt="">
        <p class="m-0 text-24">@{{ user.username }}</p>
    </div>
    <div class="card-body">
        <form @submit.prevent="Update_nonSouthSudanProfile()">
            <div class="row">
                <div class="col-md-6">
                    <label for="bcountry" class="ul-form__label">{{ __('translate.Country_Of_Birth') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.bcountry" class="form-control" name="bcountry" id="bcountry"
                        placeholder="{{ __('translate.Enter_Country_Of_Birth') }}">
                    <span class="error" v-if="errors && errors.bcountry">
                        @{{ errors.bcountry[0] }}
                    </span>
                </div>

                <div class="col-md-6">
                    <label for="arrival" class="ul-form__label">{{ __('translate.South_Sudan_Arrival_Year') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.arrival" class="form-control" id="arrival" id="arrival"
                        placeholder="{{ __('translate.Enter_South_Sudan_Arrival_Year') }}">
                    <span class="error" v-if="errors && errors.arrival">
                        @{{ errors.arrival[0] }}
                    </span>
                </div>

                <div class="col-md-6">
                    <label for="language" class="ul-form__label">{{ __('translate.First_Language') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.language" class="form-control" id="language" id="language"
                        placeholder="{{ __('translate.Enter_First_Language') }}">
                    <span class="error" v-if="errors && errors.language">
                        @{{ errors.language[0] }}
                    </span>
                </div>
                
                <div class="col-md-6">
                    <label class="ul-form__label">{{ __('translate.Gender') }} <span
                            class="field_required">*</span></label>
                    <v-select @input="Selected_Gender" placeholder="{{ __('translate.Choose_Gender') }}"
                        v-model="user.gender" :reduce="(option) => option.value" :options="
                            [
                                {label: 'Male', value: 'male'},
                                {label: 'Female', value: 'female'},
                            ]">
                    </v-select>

                    <span class="error" v-if="errors && errors.gender">
                        @{{ errors.gender[0] }}
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
@endif


@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/vuejs-datepicker/vuejs-datepicker.min.js')}}"></script>


<script>
    Vue.component('v-select', VueSelect.VueSelect)

    var app = new Vue({
        el: '#section_employee_Profile_list',
        data: {
            data: new FormData(),
            SubmitProcessing:false,
            errors:[],
            user: @json($user),
        },
       
        methods: {


            changeAvatar(e){
                let file = e.target.files[0];
                this.user.avatar = file;
            },

            Selected_Gender(value) {
                if (value === null) {
                    this.employee.gender = "";
                }
            },
           //----------------------- Update Profile for South Sudan Employee---------------------------\\
           Update_SouthSudanProfile() {
                var self = this;
                self.SubmitProcessing = true;
                
                axios.post("/self/addequity", {
                    birthstate: self.user.birthstate,
                    town: self.user.town,
                    payam_one: self.user.payam_one,
                    payam_two: self.user.payam_two,
                    payam_three: self.user.payam_three,
                    gender: self.user.gender,
                    

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/self/equity'; 
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

            //----------------------- Update Profile for non South Sudan Employee---------------------------\\
           Update_nonSouthSudanProfile() {
                var self = this;
                self.SubmitProcessing = true;
                
                axios.post("/self/addequitynonss", {
                    bcountry: self.user.bcountry,
                    arrival: self.user.arrival,
                    language: self.user.language,
                    gender: self.user.gender,

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/self/equity'; 
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