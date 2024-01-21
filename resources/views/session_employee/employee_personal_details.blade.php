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
        <img class="profile-picture avatar-lg mb-2" src="{{asset('assets/images/avatar/'.Auth::user()->avatar)}}"
            alt="">
        <p class="m-0 text-24">{{ __('translate.Personal_Information') }}</p>
    </div>
    <div class="card-body">
        
        <div class="">
            <p class="text-primary text-24 mt-2 mb-0">@{{ user.username }}<br/></p>
            <p class="text-muted text-16 line-height-1 mb-2"><b>Gender: </b> @{{ user.gender }}</p>
            <p class="text-muted text-16 line-height-1 mb-2"><b>Job Title: </b> @{{ user.designation }}</p>
            <p class="text-muted text-16 line-height-1 mb-2"><b>Department: </b> @{{ user.department }}</p>
            <p class="text-muted text-16 line-height-1 mb-2"><b>Phone: </b> @{{ user.phone }}</p>
            <p class="text-muted text-16 line-height-1 mb-2"><b>Email: </b> @{{ user.email }}</p>
        </div>
    </div>
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