@extends('layouts.master')
@section('main-content')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">


@endsection

<div class="breadcrumb">
    <h1>{{ __('translate.Set_Salary') }}</h1>
</div>

<div class="separator-breadcrumb border-top"></div>


<div class="row" id="section_set_salary">
    {{-- Salary --}}
    <div class="col-md-5 mb-2">
        <div class="card text-left">
            {{-- @can('contacts') --}}
            <div class="row card-header">
            <div class="mt-2 col-md-8 text-left"><h4>{{ __('translate.Employee_Salary') }}</h4></div>
            <div class="col-md-4 text-right bg-transparent">
                <a class="btn btn-primary btn-md m-1" @click="New_salary"><i class="i-Add text-white mr-2"></i>
                    {{ __('translate.Create') }}</a>
                <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                        class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a>
            </div>
                
            </div>
            {{-- @endcan --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table id="salary_table" class="display table">
                        <thead>
                            <tr>
                                <th>{{ __('translate.Employee_Name') }}</th>
                                <th>{{ __('translate.Salary') }}</th>
                                {{-- <th>{{ __('translate.Action') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td>{{$employee->username}}</td>
                                <td>{{$employee->salary}}</td>
                                {{-- <td>
                                    <a @click="Edit_salary( {{ $employee}})" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>

                                    <a @click="Remove_salary( {{ $employee->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>
                                </td> --}}
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Add & Edit salary -->
        <div class="modal fade" id="salary_Modal" tabindex="-1" role="dialog" aria-labelledby="salary_Modal"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editmode" class="modal-title">{{ __('translate.Edit') }}</h5>
                        <h5 v-else class="modal-title">{{ __('translate.Create') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form @submit.prevent="editmode?Update_salary():Create_salary()">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="salary" class="ul-form__label">{{ __('translate.Salary') }} <span
                                            class="field_required">*</span></label>
                                    <input type="number" v-model="salary.salary" min="0" class="form-control" name="salary"
                                        id="salary" placeholder="{{ __('translate.Salary') }}">
                                    <span class="error" v-if="errors && errors.salary">
                                        @{{ errors.salary[0] }}
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
            </div>
        </div>
    </div>
    {{-- Allowance --}}
    <div class="col-md-7 mb-2">
        <div class="card text-left">
            <div class="row card-header">
                <div class="mt-2 col-md-8 text-left"><h4>{{ __('translate.Allowance') }}</h4></div>
                <div class="col-md-4 text-right bg-transparent">
                    <a class="btn btn-primary btn-md m-1" @click="New_allowance"><i class="i-Add text-white mr-2"></i>
                        {{ __('translate.Create') }}</a>
                    {{-- <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                            class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="allowance_table" class="display table">
                        <thead>
                            <tr>
                                <th>{{ __('translate.Employee_Name') }}</th>
                                <th>{{ __('translate.Allowance_Option') }}</th>
                                <th>{{ __('translate.Title') }}</th>
                                <th>{{ __('translate.Type') }}</th>
                                <th>{{ __('translate.Amount') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allowances as $allowance)
                            <tr>
                                <td>{{$employee->username}}</td>
                                <td>{{$allowance->allowance_option}}</td>
                                <td>{{$allowance->title}}</td>
                                <td>{{$allowance->type}}</td>
                                <td>{{$allowance->amount}}</td>
                                <td>
                                    <a @click="Edit_allowance( {{ $allowance }})" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>

                                    <a @click="Remove_allowance({{ $allowance->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Add & Edit Allowance -->
        <div class="modal fade" id="allowance_Modal" tabindex="-1" role="dialog" aria-labelledby="allowance_Modal"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editmode" class="modal-title">{{ __('translate.Edit') }}</h5>
                        <h5 v-else class="modal-title">{{ __('translate.Create') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form @submit.prevent="editmode?Update_allowance():Create_allowance()">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="allowance_option" class="ul-form__label">{{ __('translate.Allowance_Option') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" v-model="allowance.allowance_option" class="form-control" name="allowance_option"
                                        id="allowance_option" placeholder="{{ __('translate.Enter_Allowance_Option') }}">
                                    <span class="error" v-if="errors && errors.allowance_option">
                                        @{{ errors.allowance_option[0] }}
                                    </span>

                                    <label for="title" class="ul-form__label">{{ __('translate.Title') }} <span
                                        class="field_required">*</span></label>
                                    <input type="text" v-model="allowance.title" class="form-control" name="title"
                                        id="title" placeholder="{{ __('translate.Enter_Title') }}">
                                    <span class="error" v-if="errors && errors.title">
                                        @{{ errors.title[0] }}
                                    </span>

                                    <label class="ul-form__label">{{ __('translate.Type') }}<span class="field_required">*</span></label>
                                    <v-select @input="Selected_allowance_type"
                                        placeholder="{{ __('translate.Select_Allowance_Type') }}"
                                        v-model="allowance.type"
                                        :reduce="label => label.value" :options="
                                        [
                                            {label: 'Fixed', value: 'fixed'},
                                            {label: 'Percentage', value: 'percentage'},
                                        ]">
                                    </v-select>

                                    <span class="error"
                                        v-if="errors && errors.type">
                                        @{{ errors.type[0] }}
                                    </span>

                                    <label for="amount" class="ul-form__label">{{ __('translate.Amount') }} <span
                                        class="field_required">*</span></label>
                                    <input type="number" v-model="allowance.amount" min="0" class="form-control" name="amount"
                                        id="amount" placeholder="{{ __('translate.Amount') }}">
                                    <span class="error" v-if="errors && errors.amount">
                                        @{{ errors.amount[0] }}
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
            </div>
        </div>
    </div>
    {{-- Loan --}}
    <div class="col-md-12 mb-2">
        <div class="card text-left">
            <div class="row card-header">
                <div class="mt-2 col-md-8 text-left"><h4>{{ __('translate.Loan') }}</h4></div>
                <div class="col-md-4 text-right bg-transparent">
                    <a class="btn btn-primary btn-md m-1" @click="New_loan"><i class="i-Add text-white mr-2"></i>
                        {{ __('translate.Create') }}</a>
                    {{-- <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                            class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="loan_table" class="display table">
                        <thead>
                            <tr>
                                <th>{{ __('translate.Employee_Name') }}</th>
                                <th>{{ __('translate.Loan_Option') }}</th>
                                <th>{{ __('translate.Title') }}</th>
                                <th>{{ __('translate.Type') }}</th>
                                <th>{{ __('translate.Amount') }}</th>
                                <th>{{ __('translate.Reason') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                            <tr>
                                <td>{{$employee->username}}</td>
                                <td>{{$loan->loan_option}}</td>
                                <td>{{$loan->title}}</td>
                                <td>{{$loan->type}}</td>
                                <td>{{$loan->amount}}</td>
                                <td>{{$loan->reason}}</td>
                                <td>
                                    <a @click="Edit_loan( {{ $loan }})" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>

                                    <a @click="Remove_loan({{ $loan->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Add & Edit loan -->
        <div class="modal fade" id="loan_Modal" tabindex="-1" role="dialog" aria-labelledby="loan_Modal"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editmode" class="modal-title">{{ __('translate.Edit') }}</h5>
                        <h5 v-else class="modal-title">{{ __('translate.Create') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form @submit.prevent="editmode?Update_loan():Create_loan()">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="loan_option" class="ul-form__label">{{ __('translate.Loan_Option') }} <span
                                        class="field_required">*</span></label>
                                    <input type="text" v-model="loan.loan_option" class="form-control" name="loan_option"
                                        id="loan_option" placeholder="{{ __('translate.Enter_Loan_Option') }}">
                                    <span class="error" v-if="errors && errors.loan_option">
                                        @{{ errors.loan_option[0] }}
                                    </span>

                                    <label for="title" class="ul-form__label">{{ __('translate.Title') }} <span
                                        class="field_required">*</span></label>
                                    <input type="text" v-model="loan.title" class="form-control" name="title"
                                        id="title" placeholder="{{ __('translate.Enter_Title') }}">
                                    <span class="error" v-if="errors && errors.title">
                                        @{{ errors.title[0] }}
                                    </span>

                                    <label class="ul-form__label">{{ __('translate.Type') }}<span class="field_required">*</span></label>
                                    <v-select @input="Selected_loan_type"
                                        placeholder="{{ __('translate.Select_Loan_Type') }}"
                                        v-model="loan.type"
                                        :reduce="label => label.value" :options="
                                        [
                                            {label: 'Fixed', value: 'fixed'},
                                            {label: 'Percentage', value: 'percentage'},
                                        ]">
                                    </v-select>

                                    <span class="error"
                                        v-if="errors && errors.type">
                                        @{{ errors.type[0] }}
                                    </span>

                                    <label for="amount" class="ul-form__label">{{ __('translate.Amount') }} <span
                                        class="field_required">*</span></label>
                                    <input type="number" v-model="loan.amount" min="0" class="form-control" name="amount"
                                        id="amount" placeholder="{{ __('translate.Amount') }}">
                                    <span class="error" v-if="errors && errors.amount">
                                        @{{ errors.amount[0] }}
                                    </span>

                                    <label for="reason" class="ul-form__label">{{ __('translate.Reason') }} <span
                                        class="field_required">*</span></label>
                                    <textarea v-model="loan.reason" class="form-control" name="reason"
                                        id="reason">hi</textarea>
                                    <span class="error" v-if="errors && errors.reason">
                                        @{{ errors.reason[0] }}
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
            </div>
        </div>
    </div>

    {{-- Over Time --}}
    <div class="col-md-5 mb-2">
        <div class="card text-left">
            <div class="row card-header">
                <div class="mt-2 col-md-8 text-left"><h4>{{ __('translate.Overtime') }}</h4></div>
                <div class="col-md-4 text-right bg-transparent">
                    <a class="btn btn-primary btn-md m-1" @click="New_overtime"><i class="i-Add text-white mr-2"></i>
                        {{ __('translate.Create') }}</a>
                    {{-- <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                            class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="overtime_table" class="display table">
                        <thead>
                            <tr>
                                <th>{{ __('translate.Employee_Name') }}</th>
                                {{-- <th>{{ __('translate.overtime_Option') }}</th> --}}
                                <th>{{ __('translate.Title') }}</th>
                                <th>{{ __('translate.Hour') }}</th>
                                <th>{{ __('translate.Rate') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($overtimes as $overtime)
                            <tr>
                                <td>{{$employee->username}}</td>
                                {{-- <td>{{$overtime->overtime_option}}</td> --}}
                                <td>{{$overtime->title}}</td>
                                <td>{{$overtime->hour}}</td>
                                <td>{{$overtime->rate}}</td>
                                <td>
                                    <a @click="Edit_overtime( {{ $overtime }})" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>

                                    <a @click="Remove_overtime({{ $overtime->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Add & Edit overtime -->
        <div class="modal fade" id="overtime_Modal" tabindex="-1" role="dialog" aria-labelledby="overtime_Modal"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editmode" class="modal-title">{{ __('translate.Edit') }}</h5>
                        <h5 v-else class="modal-title">{{ __('translate.Create') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form @submit.prevent="editmode?Update_overtime():Create_overtime()">
                            <div class="row">
                                <div class="col-md-12">
                                    

                                    <label for="title" class="ul-form__label">{{ __('translate.Title') }} <span
                                        class="field_required">*</span></label>
                                    <input type="text" v-model="overtime.title" class="form-control" name="title"
                                        id="title" placeholder="{{ __('translate.Enter_Title') }}">
                                    <span class="error" v-if="errors && errors.title">
                                        @{{ errors.title[0] }}
                                    </span>

                                    

                                    <label for="hour" class="ul-form__label">{{ __('translate.Hour') }} <span
                                        class="field_required">*</span></label>
                                    <input type="number" v-model="overtime.hour" min="0" class="form-control" name="hour"
                                        id="hour" placeholder="{{ __('translate.Hour') }}">
                                    <span class="error" v-if="errors && errors.hour">
                                        @{{ errors.hour[0] }}
                                    </span>

                                    <label for="rate" class="ul-form__label">{{ __('translate.Rate') }} <span
                                        class="field_required">*</span></label>
                                    <input type="number" v-model="overtime.rate" min="0" class="form-control" name="rate"
                                        id="rate" placeholder="{{ __('translate.Rate') }}">
                                    <span class="error" v-if="errors && errors.rate">
                                        @{{ errors.rate[0] }}
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
            </div>
        </div>
    </div>    
    {{-- Saturation Deduction --}}
    <div class="col-md-7 mb-2">
        <div class="card text-left">
            <div class="row card-header">
                <div class="mt-2 col-md-8 text-left"><h4>{{ __('translate.Deduction') }}</h4></div>
                <div class="col-md-4 text-right bg-transparent">
                    <a class="btn btn-primary btn-md m-1" @click="New_deduction"><i class="i-Add text-white mr-2"></i>
                        {{ __('translate.Create') }}</a>
                    {{-- <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                            class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="deduction_table" class="display table">
                        <thead>
                            <tr>
                                <th>{{ __('translate.Employee_Name') }}</th>
                                <th>{{ __('translate.Deduction_Option') }}</th>
                                <th>{{ __('translate.Title') }}</th>
                                <th>{{ __('translate.Type') }}</th>
                                <th>{{ __('translate.Amount') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deductions as $deduction)
                            <tr>
                                <td>{{$employee->username}}</td>
                                <td>{{$deduction->deduction_option}}</td>
                                <td>{{$deduction->title}}</td>
                                <td>{{$deduction->type}}</td>
                                <td>{{$deduction->amount}}</td>
                                <td>
                                    <a @click="Edit_deduction( {{ $deduction }})" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>

                                    <a @click="Remove_deduction({{ $deduction->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Add & Edit deduction -->
        <div class="modal fade" id="deduction_Modal" tabindex="-1" role="dialog" aria-labelledby="deduction_Modal"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editmode" class="modal-title">{{ __('translate.Edit') }}</h5>
                        <h5 v-else class="modal-title">{{ __('translate.Create') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form @submit.prevent="editmode?Update_deduction():Create_deduction()">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="deduction_option" class="ul-form__label">{{ __('translate.Deduction_Option') }} <span
                                        class="field_required">*</span></label>
                                    <input type="text" v-model="deduction.deduction_option" class="form-control" name="deduction_option"
                                        id="deduction_option" placeholder="{{ __('translate.Enter_Deduction_Option') }}">
                                    <span class="error" v-if="errors && errors.deduction_option">
                                        @{{ errors.deduction_option[0] }}
                                    </span>

                                    <label for="title" class="ul-form__label">{{ __('translate.Title') }} <span
                                        class="field_required">*</span></label>
                                    <input type="text" v-model="deduction.title" class="form-control" name="title"
                                        id="title" placeholder="{{ __('translate.Enter_Title') }}">
                                    <span class="error" v-if="errors && errors.title">
                                        @{{ errors.title[0] }}
                                    </span>

                                    <label class="ul-form__label">{{ __('translate.Type') }}<span class="field_required">*</span></label>
                                    <v-select @input="Selected_deduction_type"
                                        placeholder="{{ __('translate.Select_Deduction_Type') }}"
                                        v-model="deduction.type"
                                        :reduce="label => label.value" :options="
                                        [
                                            {label: 'Fixed', value: 'fixed'},
                                            {label: 'Percentage', value: 'percentage'},
                                        ]">
                                    </v-select>

                                    <span class="error"
                                        v-if="errors && errors.type">
                                        @{{ errors.type[0] }}
                                    </span>

                                    <label for="amount" class="ul-form__label">{{ __('translate.Amount') }} <span
                                        class="field_required">*</span></label>
                                    <input type="number" v-model="deduction.amount" min="0" class="form-control" name="amount"
                                        id="amount" placeholder="{{ __('translate.Amount') }}">
                                    <span class="error" v-if="errors && errors.amount">
                                        @{{ errors.amount[0] }}
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
            </div>
        </div>
    </div>
    {{-- Commission --}}
    <div class="col-md-6 mb-2">
        <div class="card text-left">
            <div class="row card-header">
                <div class="mt-2 col-md-8 text-left"><h4>{{ __('translate.Commission') }}</h4></div>
                <div class="col-md-4 text-right bg-transparent">
                    <a class="btn btn-primary btn-md m-1" @click="New_commission"><i class="i-Add text-white mr-2"></i>
                        {{ __('translate.Create') }}</a>
                    {{-- <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                            class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="commission_table" class="display table">
                        <thead>
                            <tr>
                                <th>{{ __('translate.Employee_Name') }}</th>
                                {{-- <th>{{ __('translate.commission_Option') }}</th> --}}
                                <th>{{ __('translate.Title') }}</th>
                                <th>{{ __('translate.Type') }}</th>
                                <th>{{ __('translate.Amount') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commissions as $commission)
                            <tr>
                                <td>{{$employee->username}}</td>
                                {{-- <td>{{$commission->commission_option}}</td> --}}
                                <td>{{$commission->title}}</td>
                                <td>{{$commission->type}}</td>
                                <td>{{$commission->amount}}</td>
                                <td>
                                    <a @click="Edit_commission( {{ $commission }})" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>

                                    <a @click="Remove_commission({{ $commission->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Add & Edit commission -->
        <div class="modal fade" id="commission_Modal" tabindex="-1" role="dialog" aria-labelledby="commission_Modal"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editmode" class="modal-title">{{ __('translate.Edit') }}</h5>
                        <h5 v-else class="modal-title">{{ __('translate.Create') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form @submit.prevent="editmode?Update_commission():Create_commission()">
                            <div class="row">
                                <div class="col-md-12">
                                    

                                    <label for="title" class="ul-form__label">{{ __('translate.Title') }} <span
                                        class="field_required">*</span></label>
                                    <input type="text" v-model="commission.title" class="form-control" name="title"
                                        id="title" placeholder="{{ __('translate.Enter_Title') }}">
                                    <span class="error" v-if="errors && errors.title">
                                        @{{ errors.title[0] }}
                                    </span>

                                    <label class="ul-form__label">{{ __('translate.Type') }}<span class="field_required">*</span></label>
                                    <v-select @input="Selected_commission_type"
                                        placeholder="{{ __('translate.Select_Commission_Type') }}"
                                        v-model="commission.type"
                                        :reduce="label => label.value" :options="
                                        [
                                            {label: 'Fixed', value: 'fixed'},
                                            {label: 'Percentage', value: 'percentage'},
                                        ]">
                                    </v-select>

                                    <span class="error"
                                        v-if="errors && errors.type">
                                        @{{ errors.type[0] }}
                                    </span>

                                    <label for="amount" class="ul-form__label">{{ __('translate.Amount') }} <span
                                        class="field_required">*</span></label>
                                    <input type="number" v-model="commission.amount" min="0" class="form-control" name="amount"
                                        id="amount" placeholder="{{ __('translate.Amount') }}">
                                    <span class="error" v-if="errors && errors.amount">
                                        @{{ errors.amount[0] }}
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
            </div>
        </div>
    </div>
    {{-- Other Payment --}}
    <div class="col-md-6 mb-2">
        <div class="card text-left">
            <div class="row card-header">
                <div class="mt-2 col-md-8 text-left"><h4>{{ __('translate.Other_Payment') }}</h4></div>
                <div class="col-md-4 text-right bg-transparent">
                    <a class="btn btn-primary btn-md m-1" @click="New_otherpayment"><i class="i-Add text-white mr-2"></i>
                        {{ __('translate.Create') }}</a>
                    {{-- <a v-if="selectedIds.length > 0" class="btn btn-danger btn-md m-1" @click="delete_selected()"><i
                            class="i-Close-Window text-white mr-2"></i> {{ __('translate.Delete') }}</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="otherpayment_table" class="display table">
                        <thead>
                            <tr>
                                <th>{{ __('translate.Employee_Name') }}</th>
                                {{-- <th>{{ __('translate.otherpayment_Option') }}</th> --}}
                                <th>{{ __('translate.Title') }}</th>
                                <th>{{ __('translate.Type') }}</th>
                                <th>{{ __('translate.Amount') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($otherpayments as $otherpayment)
                            <tr>
                                <td>{{$employee->username}}</td>
                                {{-- <td>{{$otherpayment->otherpayment_option}}</td> --}}
                                <td>{{$otherpayment->title}}</td>
                                <td>{{$otherpayment->type}}</td>
                                <td>{{$otherpayment->amount}}</td>
                                <td>
                                    <a @click="Edit_otherpayment( {{ $otherpayment }})" class="ul-link-action text-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="i-Edit"></i>
                                    </a>

                                    <a @click="Remove_otherpayment({{ $otherpayment->id}})"
                                        class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="i-Close-Window"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Add & Edit otherpayment -->
        <div class="modal fade" id="otherpayment_Modal" tabindex="-1" role="dialog" aria-labelledby="otherpayment_Modal"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editmode" class="modal-title">{{ __('translate.Edit') }}</h5>
                        <h5 v-else class="modal-title">{{ __('translate.Create') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form @submit.prevent="editmode?Update_otherpayment():Create_otherpayment()">
                            <div class="row">
                                <div class="col-md-12">
                                    

                                    <label for="title" class="ul-form__label">{{ __('translate.Title') }} <span
                                        class="field_required">*</span></label>
                                    <input type="text" v-model="otherpayment.title" class="form-control" name="title"
                                        id="title" placeholder="{{ __('translate.Enter_Title') }}">
                                    <span class="error" v-if="errors && errors.title">
                                        @{{ errors.title[0] }}
                                    </span>

                                    <label class="ul-form__label">{{ __('translate.Type') }}<span class="field_required">*</span></label>
                                    <v-select @input="Selected_otherpayment_type"
                                        placeholder="{{ __('translate.Select_Other_Payment_Type') }}"
                                        v-model="otherpayment.type"
                                        :reduce="label => label.value" :options="
                                        [
                                            {label: 'Fixed', value: 'fixed'},
                                            {label: 'Percentage', value: 'percentage'},
                                        ]">
                                    </v-select>

                                    <span class="error"
                                        v-if="errors && errors.type">
                                        @{{ errors.type[0] }}
                                    </span>

                                    <label for="amount" class="ul-form__label">{{ __('translate.Amount') }} <span
                                        class="field_required">*</span></label>
                                    <input type="number" v-model="otherpayment.amount" min="0" class="form-control" name="amount"
                                        id="amount" placeholder="{{ __('translate.Amount') }}">
                                    <span class="error" v-if="errors && errors.amount">
                                        @{{ errors.amount[0] }}
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
        el: '#section_set_salary',
        data: {
            selectedIds:[],
            editmode: false,
            SubmitProcessing:false,
            employee: @json($employee),
            allowances: @json($allowances),
            allowance: @json($allowances),
            allowances: [],
            commissions: @json($commissions),
            commission: @json($commissions),           
            commissions: [],
            loans: @json($loans),
            loan: @json($loans),           
            loans: [],
            deductions: @json($deductions),
            deduction: @json($deductions),           
            deductions: [],
            
            errors:[],
            // salarys: [], 
            salary: {
                salary: "",
            }, 

            allowance: {
                allowance_option: "",
                title: "",
                type: "",
                amount: "",
            }, 
            commission: {
                title: "",
                type: "",
                amount: "",
            },
            loan: {
                loan_option: "",
                title: "",
                type: "",
                amount: "",
                reason:"",
            },
            deduction: {
                deduction_option: "",
                title: "",
                type: "",
                amount: "",
            },
            otherpayment: {
                otherpayment_option: "",
                title: "",
                type: "",
            },
            overtime: {
                title: "",
                hour: "",
                rate: "",
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


            //------------------------------ Show Modal (Create salary) -------------------------------\\
            New_salary() {
                this.reset_Form();
                this.editmode = false;
                $('#salary_Modal').modal('show');
            },

            //------------------------------ Show Modal (Update salary) -------------------------------\\
            Edit_salary(salary) {
                this.editmode = true;
                this.reset_Form();
                this.salary = salary;
                $('#salary_Modal').modal('show');
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_Form() {
                this.salary = {
                    salary: "",
                };
                this.errors = {};
            },

            //------------------------ Create salary ---------------------------\\
            Create_salary() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/salary/create/"+ self.employee.id , {
                    salary: self.salary.salary,

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

           //----------------------- Update salary ---------------------------\\
            Update_salary() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/salary/update/" + self.employee.id, {
                    salary: self.salary.salary,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

             //--------------------------------- Remove salary ---------------------------\\
            Remove_salary(id) {

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
                            .delete("/salary/delete/" + id)
                            .then(() => {
                                window.location.href = '/set_salary/'+ self.employee.id; 
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
                        .post("/salary/delete/by_selection", {
                            selectedIds: self.selectedIds
                        })
                            .then(() => {
                                window.location.href = '/salary/show'; 
                                toastr.success('{{ __('translate.Deleted_in_successfully') }}');

                            })
                            .catch(() => {
                                toastr.error('{{ __('translate.There_was_something_wronge') }}');
                            });
                    });
            },



             //--------------------------------------- Allowance ----------------------------------------\\
            //------------------------------ Show Modal (Create allowance) -------------------------------\\
            New_allowance() {
                this.reset_allowance_Form();
                this.editmode = false;
                $('#allowance_Modal').modal('show');
            },

            Selected_allowance_type (value) {
                if (value === null) {
                    this.allowance.type = "";
                }
            },

            //------------------------------ Show Modal (Update salary) -------------------------------\\
            Edit_allowance(allowance) {
                this.editmode = true;
                this.reset_allowance_Form();
                this.allowance = allowance;
                $('#allowance_Modal').modal('show');
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_allowance_Form() {
                this.allowance = {
                    allowance_option: "",
                    title: "",
                    type: "",
                    amount: "",
                };
                this.errors = {};
            },

            //------------------------ Create allowance ---------------------------\\
            Create_allowance() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/allowance" , {
                    employee_id: self.employee.id,
                    allowance_option: self.allowance.allowance_option,
                    title: self.allowance.title,
                    type: self.allowance.type,
                    amount: self.allowance.amount,

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

           //----------------------- Update allowance ---------------------------\\
            Update_allowance() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/allowance/" + self.allowance.id, {
                    employee_id: self.employee.id,
                    allowance_option: self.allowance.allowance_option,
                    title: self.allowance.title,
                    type: self.allowance.type,
                    amount: self.allowance.amount,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

             //--------------------------------- Remove allowance ---------------------------\\
            Remove_allowance(allowance_id) {
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
                            .delete("/allowance/" + allowance_id)
                            .then(() => {
                                window.location.href = '/set_salary/'+ self.employee.id; 
                                toastr.success('{{ __('translate.Deleted_in_successfully') }}');

                            })
                            .catch(() => {
                                toastr.error('{{ __('translate.There_was_something_wronge') }}');
                            });
                    });
            },


            //--------------------------------------- commission ----------------------------------------\\
            //------------------------------ Show Modal (Create commission) -------------------------------\\
            New_commission() {
                this.reset_commission_Form();
                this.editmode = false;
                $('#commission_Modal').modal('show');
            },

            Selected_commission_type (value) {
                if (value === null) {
                    this.commission.type = "";
                }
            },

            //------------------------------ Show Modal (Update salary) -------------------------------\\
            Edit_commission(commission) {
                this.editmode = true;
                this.reset_commission_Form();
                this.commission = commission;
                $('#commission_Modal').modal('show');
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_commission_Form() {
                this.commission = {
                    title: "",
                    type: "",
                    amount: "",
                };
                this.errors = {};
            },

            //------------------------ Create commission ---------------------------\\
            Create_commission() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/commission" , {
                    employee_id: self.employee.id,
                    title: self.commission.title,
                    type: self.commission.type,
                    amount: self.commission.amount,

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

           //----------------------- Update commission ---------------------------\\
            Update_commission() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/commission/" + self.commission.id, {
                    employee_id: self.employee.id,
                    title: self.commission.title,
                    type: self.commission.type,
                    amount: self.commission.amount,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

             //--------------------------------- Remove commission ---------------------------\\
            Remove_commission(commission_id) {
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
                            .delete("/commission/" + commission_id)
                            .then(() => {
                                window.location.href = '/set_salary/'+ self.employee.id; 
                                toastr.success('{{ __('translate.Deleted_in_successfully') }}');

                            })
                            .catch(() => {
                                toastr.error('{{ __('translate.There_was_something_wronge') }}');
                            });
                    });
            },

            //--------------------------------------- loan ----------------------------------------\\
            //------------------------------ Show Modal (Create loan) -------------------------------\\
            New_loan() {
                this.reset_loan_Form();
                this.editmode = false;
                $('#loan_Modal').modal('show');
            },

            Selected_loan_type (value) {
                if (value === null) {
                    this.loan.type = "";
                }
            },

            //------------------------------ Show Modal (Update salary) -------------------------------\\
            Edit_loan(loan) {
                this.editmode = true;
                this.reset_loan_Form();
                this.loan = loan;
                $('#loan_Modal').modal('show');
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_loan_Form() {
                this.loan = {
                    loan_option: "",
                    title: "",
                    type: "",
                    amount: "",
                    reason: "",
                };
                this.errors = {};
            },

            //------------------------ Create loan ---------------------------\\
            Create_loan() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/loan" , {
                    employee_id: self.employee.id,
                    loan_option: self.loan.loan_option,
                    title: self.loan.title,
                    type: self.loan.type,
                    amount: self.loan.amount,
                    reason: self.loan.reason,

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

           //----------------------- Update loan ---------------------------\\
            Update_loan() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/loan/" + self.loan.id, {
                    employee_id: self.employee.id,
                    loan_option: self.loan.loan_option,
                    title: self.loan.title,
                    type: self.loan.type,
                    amount: self.loan.amount,
                    reason: self.loan.reason,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

             //--------------------------------- Remove loan ---------------------------\\
            Remove_loan(loan_id) {
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
                            .delete("/loan/" + loan_id)
                            .then(() => {
                                window.location.href = '/set_salary/'+ self.employee.id; 
                                toastr.success('{{ __('translate.Deleted_in_successfully') }}');

                            })
                            .catch(() => {
                                toastr.error('{{ __('translate.There_was_something_wronge') }}');
                            });
                    });
            },

            //--------------------------------------- deduction ----------------------------------------\\
            //------------------------------ Show Modal (Create deduction) -------------------------------\\
            New_deduction() {
                this.reset_deduction_Form();
                this.editmode = false;
                $('#deduction_Modal').modal('show');
            },

            Selected_deduction_type (value) {
                if (value === null) {
                    this.deduction.type = "";
                }
            },

            //------------------------------ Show Modal (Update salary) -------------------------------\\
            Edit_deduction(deduction) {
                this.editmode = true;
                this.reset_deduction_Form();
                this.deduction = deduction;
                $('#deduction_Modal').modal('show');
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_deduction_Form() {
                this.deduction = {
                    deduction_option: "",
                    title: "",
                    type: "",
                    amount: "",
                };
                this.errors = {};
            },

            //------------------------ Create deduction ---------------------------\\
            Create_deduction() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/deduction" , {
                    employee_id: self.employee.id,
                    deduction_option: self.deduction.deduction_option,
                    title: self.deduction.title,
                    type: self.deduction.type,
                    amount: self.deduction.amount,

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

           //----------------------- Update deduction ---------------------------\\
            Update_deduction() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/deduction/" + self.deduction.id, {
                    employee_id: self.employee.id,
                    deduction_option: self.deduction.deduction_option,
                    title: self.deduction.title,
                    type: self.deduction.type,
                    amount: self.deduction.amount,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

             //--------------------------------- Remove deduction ---------------------------\\
            Remove_deduction(deduction_id) {
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
                            .delete("/deduction/" + deduction_id)
                            .then(() => {
                                window.location.href = '/set_salary/'+ self.employee.id; 
                                toastr.success('{{ __('translate.Deleted_in_successfully') }}');

                            })
                            .catch(() => {
                                toastr.error('{{ __('translate.There_was_something_wronge') }}');
                            });
                    });
            },

            //--------------------------------------- otherpayment ----------------------------------------\\
            //------------------------------ Show Modal (Create otherpayment) -------------------------------\\
            New_otherpayment() {
                this.reset_otherpayment_Form();
                this.editmode = false;
                $('#otherpayment_Modal').modal('show');
            },

            Selected_otherpayment_type (value) {
                if (value === null) {
                    this.otherpayment.type = "";
                }
            },

            //------------------------------ Show Modal (Update salary) -------------------------------\\
            Edit_otherpayment(otherpayment) {
                this.editmode = true;
                this.reset_otherpayment_Form();
                this.otherpayment = otherpayment;
                $('#otherpayment_Modal').modal('show');
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_otherpayment_Form() {
                this.otherpayment = {
                    title: "",
                    type: "",
                    amount: "",
                };
                this.errors = {};
            },

            //------------------------ Create otherpayment ---------------------------\\
            Create_otherpayment() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/otherpayment" , {
                    employee_id: self.employee.id,
                    title: self.otherpayment.title,
                    type: self.otherpayment.type,
                    amount: self.otherpayment.amount,

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

           //----------------------- Update otherpayment ---------------------------\\
            Update_otherpayment() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/otherpayment/" + self.otherpayment.id, {
                    employee_id: self.employee.id,
                    title: self.otherpayment.title,
                    type: self.otherpayment.type,
                    amount: self.otherpayment.amount,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

             //--------------------------------- Remove otherpayment ---------------------------\\
            Remove_otherpayment(otherpayment_id) {
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
                            .delete("/otherpayment/" + otherpayment_id)
                            .then(() => {
                                window.location.href = '/set_salary/'+ self.employee.id; 
                                toastr.success('{{ __('translate.Deleted_in_successfully') }}');

                            })
                            .catch(() => {
                                toastr.error('{{ __('translate.There_was_something_wronge') }}');
                            });
                    });
            },

            //--------------------------------------- overtime ----------------------------------------\\
            //------------------------------ Show Modal (Create overtime) -------------------------------\\
            New_overtime() {
                this.reset_overtime_Form();
                this.editmode = false;
                $('#overtime_Modal').modal('show');
            },

            Selected_overtime_type (value) {
                if (value === null) {
                    this.overtime.type = "";
                }
            },

            //------------------------------ Show Modal (Update salary) -------------------------------\\
            Edit_overtime(overtime) {
                this.editmode = true;
                this.reset_overtime_Form();
                this.overtime = overtime;
                $('#overtime_Modal').modal('show');
            },

            //----------------------------- Reset Form ---------------------------\\
            reset_overtime_Form() {
                this.overtime = {
                    title: "",
                    hour: "",
                    rate: "",
                };
                this.errors = {};
            },

            //------------------------ Create overtime ---------------------------\\
            Create_overtime() {
                var self = this;
                self.SubmitProcessing = true;
                axios.post("/overtime" , {
                    employee_id: self.employee.id,
                    title: self.overtime.title,
                    hour: self.overtime.hour,
                    rate: self.overtime.rate,

                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

           //----------------------- Update overtime ---------------------------\\
            Update_overtime() {
                var self = this;
                self.SubmitProcessing = true;
                axios.put("/overtime/" + self.overtime.id, {
                    employee_id: self.employee.id,
                    title: self.overtime.title,
                    hour: self.overtime.hour,
                    rate: self.overtime.rate,
                }).then(response => {
                        self.SubmitProcessing = false;
                        window.location.href = '/set_salary/'+ self.employee.id; 
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

             //--------------------------------- Remove overtime ---------------------------\\
            Remove_overtime(overtime_id) {
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
                            .delete("/overtime/" + overtime_id)
                            .then(() => {
                                window.location.href = '/set_salary/'+ self.employee.id; 
                                toastr.success('{{ __('translate.Deleted_in_successfully') }}');

                            })
                            .catch(() => {
                                toastr.error('{{ __('translate.There_was_something_wronge') }}');
                            });
                    });
            },



            //--------------------------------- delete_selected ---------------------------\\
            // delete_selected() {
            //     var self = this;
            //     swal({
            //         title: '{{ __('translate.Are_you_sure') }}',
            //         text: '{{ __('translate.You_wont_be_able_to_revert_this') }}',
            //         type: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#0CC27E',
            //         cancelButtonColor: '#FF586B',
            //         confirmButtonText: '{{ __('translate.Yes_delete_it') }}',
            //         cancelButtonText: '{{ __('translate.No_cancel') }}',
            //         confirmButtonClass: 'btn btn-primary mr-5',
            //         cancelButtonClass: 'btn btn-danger',
            //         buttonsStyling: false
            //     }).then(function () {
            //             axios
            //             .post("/salary/delete/by_selection", {
            //                 selectedIds: self.selectedIds
            //             })
            //                 .then(() => {
            //                     window.location.href = '/salary/show'; 
            //                     toastr.success('{{ __('translate.Deleted_in_successfully') }}');

            //                 })
            //                 .catch(() => {
            //                     toastr.error('{{ __('translate.There_was_something_wronge') }}');
            //                 });
            //         });
            // },

           
        },
        //-----------------------------Autoload function-------------------
        created() {
        }

    })

</script>

<script type="text/javascript">
    $(function () {
      "use strict";

        $('#salary_table').DataTable( {
            "processing": true, // for show progress bar
            // select: {
            //     style: 'multi',
            //     selector: '.select-checkbox',
            //     items: 'row',
            // },
            // columnDefs: [
            //     {
            //         targets: 0,
            //         className: 'select-checkbox'
            //     },
            //     {
            //         targets: [0],
            //         orderable: false
            //     }
            // ],
        
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
        $('#allowance_table').DataTable( {
            
            "processing": true, // for show progress bar
            // select: {
            //     style: 'multi',
            //     selector: '.select-checkbox',
            //     items: 'row',
            // },
            // columnDefs: [
            //     {
            //         targets: 0,
            //         className: 'select-checkbox'
            //     },
            //     {
            //         targets: [0],
            //         orderable: false
            //     }
            // ],
        
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

        $('#commission_table').DataTable( {
            "processing": true, // for show progress bar
            // select: {
            //     style: 'multi',
            //     selector: '.select-checkbox',
            //     items: 'row',
            // },
            // columnDefs: [
            //     {
            //         targets: 0,
            //         className: 'select-checkbox'
            //     },
            //     {
            //         targets: [0],
            //         orderable: false
            //     }
            // ],
        
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

        $('#loan_table').DataTable( {
            "processing": true, // for show progress bar
            // select: {
            //     style: 'multi',
            //     selector: '.select-checkbox',
            //     items: 'row',
            // },
            // columnDefs: [
            //     {
            //         targets: 0,
            //         className: 'select-checkbox'
            //     },
            //     {
            //         targets: [0],
            //         orderable: false
            //     }
            // ],
        
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

        $('#deduction_table').DataTable( {
            "processing": true, // for show progress bar
            // select: {
            //     style: 'multi',
            //     selector: '.select-checkbox',
            //     items: 'row',
            // },
            // columnDefs: [
            //     {
            //         targets: 0,
            //         className: 'select-checkbox'
            //     },
            //     {
            //         targets: [0],
            //         orderable: false
            //     }
            // ],
        
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

        $('#otherpayment_table').DataTable( {
            "processing": true, // for show progress bar
            // select: {
            //     style: 'multi',
            //     selector: '.select-checkbox',
            //     items: 'row',
            // },
            // columnDefs: [
            //     {
            //         targets: 0,
            //         className: 'select-checkbox'
            //     },
            //     {
            //         targets: [0],
            //         orderable: false
            //     }
            // ],
        
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

        $('#overtime_table').DataTable( {
            "processing": true, // for show progress bar
            // select: {
            //     style: 'multi',
            //     selector: '.select-checkbox',
            //     items: 'row',
            // },
            // columnDefs: [
            //     {
            //         targets: 0,
            //         className: 'select-checkbox'
            //     },
            //     {
            //         targets: [0],
            //         orderable: false
            //     }
            // ],
        
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