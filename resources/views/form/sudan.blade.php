<div class="card user-profile o-hidden mb-4" id="section_employee_Profile_list">
    <div class="header-cover"></div>
    <div class="user-info">
        <img class="profile-picture avatar-lg mb-2" src="{{asset('assets/images/avatar/'.Auth::user()->avatar)}}"
            alt="">
        <p class="m-0 text-24">@{{ user.username }}</p>
    </div>
    <div class="card-body">
        <form @submit.prevent="Update_Profile()" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <label for="FirstName" class="ul-form__label">{{ __('translate.FirstName') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.firstname" class="form-control" name="FirstName" id="FirstName"
                        placeholder="{{ __('translate.Enter_FirstName') }}">
                    <span class="error" v-if="errors && errors.firstname">
                        @{{ errors.firstname[0] }}
                    </span>
                </div>

                <div class="col-md-6">
                    <label for="lastname" class="ul-form__label">{{ __('translate.LastName') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.lastname" class="form-control" id="lastname" id="lastname"
                        placeholder="{{ __('translate.Enter_LastName') }}">
                    <span class="error" v-if="errors && errors.lastname">
                        @{{ errors.lastname[0] }}
                    </span>
                </div>


                <div class="col-md-6">
                    <label for="Phone" class="ul-form__label">{{ __('translate.Phone') }}</label>
                    <input type="text" v-model="user.phone" class="form-control" id="Phone"
                        placeholder="{{ __('translate.Enter_Phone') }}">

                </div>

                <div class="col-md-6">
                    <label for="country" class="ul-form__label">{{ __('translate.Country') }}</label>
                    <input type="text" v-model="user.country" class="form-control" id="country"
                        placeholder="{{ __('translate.Enter_Country') }}">
                    <span class="error" v-if="errors && errors.country">
                        @{{ errors.country[0] }}
                    </span>
                </div>


                <div class="col-md-6">
                    <label for="email" class="ul-form__label">{{ __('translate.Email') }} <span
                            class="field_required">*</span></label>
                    <input type="text" v-model="user.email" class="form-control" id="email"
                        placeholder="{{ __('translate.Enter_email_address') }}">
                    <span class="error" v-if="errors && errors.email">
                        @{{ errors.email[0] }}
                    </span>
                </div>

                <div class="col-md-6">
                    <label for="password" class="ul-form__label">{{ __('translate.Password') }} <span
                            class="field_required">*</span></label>
                    <input type="password" v-model="user.password" class="form-control" id="password"
                        placeholder="{{ __('translate.min_6_characters') }}">
                    <span class="error" v-if="errors && errors.password">
                        @{{ errors.password[0] }}
                    </span>
                </div>

                <div class="col-md-6">
                    <label for="Avatar" class="ul-form__label">{{ __('translate.Avatar') }}</label>
                    <input name="Avatar" @change="changeAvatar" type="file" class="form-control" id="Avatar">
                    <span class="error" v-if="errors && errors.avatar">
                        @{{ errors.avatar[0] }}
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