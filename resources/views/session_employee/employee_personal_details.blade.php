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

<div class="card user-profile o-hidden mb-4" id="section_employee_Profile_list">
    <div class="header-cover"></div>
    <div class="user-info">
        <img class="profile-picture avatar-lg mb-2" src="{{asset('assets/images/avatar/world.jpg')}}"
            alt="">
        <p class="m-0 text-24">{{ __('translate.My_Profile') }}</p>
    </div>
    
    <section class="" >
        <div class="container py-5">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-md-8 mb-4 mb-lg-0">
              <div class="card mb-3" style="border-radius: .5rem;">
                <div class="row g-0">
                  <div class="bg-primary col-md-4 gradient-custom text-center"
                    style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                    <img src="{{asset('assets/images/avatar/'.Auth::user()->avatar)}}"
                      alt="Avatar" class="profile-picture img-fluid mt-5" style="width: 200px;" />
                        <p class="text-white text-24 mt-2 mb-0">@{{ user.username }}<br/></p>
                        <p class="text-white text-16 line-height-1 mb-2">@{{ user.designation }}</p>
                    
                  </div>
                  <div class="col-md-8">
                    <div class="card-body p-4">
                      <h5>Personal Information</h5>
                      <hr class="mt-0 mb-4">
                            <p class="text-muted text-16 line-height-1 mb-2"><b>Department: </b> @{{ user.department }}</p>
                            <p class="text-muted text-16 line-height-1 mb-2"><b>Gender: </b> @{{ user.gender }}</p>
                            <p class="text-muted text-16 line-height-1 mb-2"><b>Email: </b> @{{ user.email }}</p>  
                            <p class="text-muted text-16 line-height-1 mb-2"><b>Phone: </b> @{{ user.phone }}</p>

                            @if ($equity_ss && $employee->country == 'South Sudan')
                                <p class="text-muted text-16 line-height-1 mb-2"><b>Birth State: </b> @{{ user.birthstate }}</p>
                                <p class="text-muted text-16 line-height-1 mb-2"><b>Town: </b> @{{ user.town }}</p>
                                <p class="text-muted text-16 line-height-1 mb-2"><b>Payam 1: </b> @{{ user.payam_one }}</p>
                                <p class="text-muted text-16 line-height-1 mb-2"><b>Payam 2: </b> @{{ user.payam_two }}</p>
                                <p class="text-muted text-16 line-height-1 mb-2"><b>Payam 3: </b> @{{ user.payam_three }}</p>
                                <p class="text-muted text-16 line-height-1 mb-2"><b>Disability: </b> @{{ user.disability }}</p>
                                @if ($equity_ss->disability == 'yes')
                                    <p class="text-muted text-16 line-height-1 mb-2"><b>Disability Type: </b> @{{ user.disability_type }}</p>
                                @endif
                            @elseif ($equity_non_ss)
                                <p class="text-muted text-16 line-height-1 mb-2"><b>Country of Birth: </b> @{{ user.birthcountry }}</p>
                                <p class="text-muted text-16 line-height-1 mb-2"><b>Language (Other than English): </b> @{{ user.language }}</p>
                                <p class="text-muted text-16 line-height-1 mb-2"><b>Arrival Year: </b> @{{ user.arrival_year }}</p>
                                <p class="text-muted text-16 line-height-1 mb-2"><b>Disability: </b> @{{ user.disability }}</p>
                                @if ($equity_non_ss->disability == 'yes')
                                    <p class="text-muted text-16 line-height-1 mb-2"><b>Disability Type: </b> @{{ user.disability_type }}</p>
                                @endif
                            @endif
            
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    
    
</div>



@endsection

@section('page-js')

<script>
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


           //----------------------- Update Profile ---------------------------\\
           Update_Profile() {
                var self = this;
                self.SubmitProcessing = true;
                self.data.append("firstname", self.user.firstname);
                self.data.append("lastname", self.user.lastname);
                self.data.append("country", self.user.country);
                self.data.append("email", self.user.email);
                self.data.append("password", self.user.password);
                self.data.append("phone", self.user.phone);
                self.data.append("avatar", self.user.avatar);
                self.data.append("_method", "put");

                axios
                    .post("/employee_profile/" + self.user.id, self.data)
                    .then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/employee_profile'; 
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