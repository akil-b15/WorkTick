@extends('layouts.employee')
@section('main-content')

<div class="breadcrumb">
    <h1>{{ __('translate.Dashboard') }}</h1>

</div>

<div class="separator-breadcrumb border-top"></div>

<div id="section_Dashboard_employee">

    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <!-- ICON BG -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card o-hidden mb-4">
                        <div class="card-header  border-0">
                            @if(!$punch_in)
                            <span class="float-left card-title m-0">{{ __('translate.No_Shift_Today') }}</span>
                            @else
                            <span class="clock_in float-left card-title m-0">{{$punch_in}} - {{$punch_out}}</span>
                            @endif

                            <form method="post" action="{{route('attendance_by_employee.post',$employee->id)}}"
                                accept-charset="utf-8">
                                @csrf
                                <input type="hidden" value="{{$punch_in}}" id="punch_in" name="office_punch_in">
                                <input type="hidden" value="{{$punch_out}}" id="punch_out" name="office_punch_out">
                                <input type="hidden" value="" id="in_out" name="in_out_value">
                                @if(!$employee_attendance || $employee_attendance->clock_in_out == 0)
                                <button type="submit"
                                    class="btn btn-primary btn-rounded btn-md m-1 text-right float-right"><i
                                        class="i-Arrow-UpinCircle text-white mr-2"></i>
                                    {{ __('translate.Punch_In') }}</button>
                                @else
                                <button type="submit"
                                    class="btn btn-danger btn-rounded btn-md m-1 text-right float-right"><i
                                        class="i-Arrow-DowninCircle text-white mr-2"></i>
                                    {{ __('translate.Punch_Out') }}</button>
                                @endif
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Dropbox"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">{{ __('translate.Projects') }}</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$count_projects}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Check"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">{{ __('translate.Tasks') }}</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$count_tasks}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Gift-Box"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">{{ __('translate.Awards') }}</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$count_awards}}</p>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Letter-Open"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">{{ __('translate.Announcements') }}</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$count_announcement}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Letter-Open"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">{{ __('translate.Urgent_Task') }}</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$urgent_tasks}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">{{ __('translate.Leave_taken_vs_remaining') }}</div>
                    <div id="echart_leave"></div>
                </div>
            </div>
        </div>


    </div>


    <div class="row">

        <div class="col-12 col-sm-12">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="attendance_list_table" class="display table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('translate.Employee') }}</th>
                                    <th>{{ __('translate.Company') }}</th>
                                    <th>{{ __('translate.Date') }}</th>
                                    <th>{{ __('translate.Time_In') }}</th>
                                    <th>{{ __('translate.Time_Out') }}</th>
                                    <th>{{ __('translate.Work_Duration') }}</th>
                                    <th>{{ __('translate.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                <tr>
                                    <td @click="selected_row( {{ $attendance->id}})"></td>
                                    <td>{{$attendance->employee->username}}</td>
                                    <td>{{$attendance->company->name}}</td>
                                    <td>{{$attendance->date}}</td>
                                    <td>{{$attendance->clock_in}}</td>
                                    <td>{{$attendance->clock_out}}</td>
                                    <td>{{$attendance->total_work}}</td>
    
                                    <td>
                                        @can('attendance_edit')
                                        <a @click="Edit_Attendance( {{ $attendance}})" class="ul-link-action text-success"
                                            data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="i-Edit"></i>
                                        </a>
                                        @endcan
                                        @can('attendance_delete')
                                        <a @click="Remove_Attendance( {{ $attendance->id}})"
                                            class="ul-link-action text-danger mr-1" data-toggle="tooltip"
                                            data-placement="top" title="Delete">
                                            <i class="i-Close-Window"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
    
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/echart.options.min.js')}}"></script>

<script>
    let echartElemleave = document.getElementById('echart_leave');
        if (echartElemleave) {
            let echart_leave = echarts.init(echartElemleave);
            echart_leave.setOption({
                ...echartOptions.defaultOptions,
                ... {
                    legend: {
                        show: true,
                        bottom: 0,
                    },
                    series: [{
                        type: 'pie',
                        ...echartOptions.pieRing,
        
                        label: echartOptions.pieLabelCenterHover,
                        data: [{
                            name: 'Taken',
                            value: @json($total_leave_taken),
                            itemStyle: {
                                color: '#663399',
                            }
                        }, {
                            name: 'remaining',
                            value: @json($total_leave_remaining),
                            itemStyle: {
                                color: '#ced4da',
                            }
                        }]
                    }]
                }
            });
            $(window).on('resize', function() {
                setTimeout(() => {
                    echart_leave.resize();
                }, 500);
            });
        }
        
        
</script>

@endsection