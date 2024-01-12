<?php $plugins = \Nwidart\Modules\Facades\Module::allEnabled(); ?>
<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            @if (auth()->user()->role_users_id == 1)
                <li class="nav-item {{ request()->is('dashboard/admin') ? 'active' : '' }}">
                    <a class="nav-item-hold row" href="/dashboard/admin">
                        <i class="col-2 sidebar-icon i-Bar-Chart" style="margin: 0 10px 0 16px;"></i>
                        <span class="nav-text col-5">{{ __('translate.Home') }}</span>
                    </a>
                    {{-- <div class="triangle"></div> --}}
                </li>
            @elseif(auth()->user()->role_users_id == 3)
                <li class="nav-item {{ request()->is('dashboard/client') ? 'active' : '' }}">
                    <a class="nav-item-hold row" href="/dashboard/client">
                        <i class="col-2 sidebar-icon i-Bar-Chart" style="margin: 0 10px 0 16px;"></i>
                        <span class="nav-text col-5">{{ __('translate.Home') }}</span>
                    </a>
                    {{-- <div class="triangle"></div> --}}
                </li>
            @else
                <li class="nav-item {{ request()->is('dashboard/employee') ? 'active' : '' }}">
                    <a class="nav-item-hold row" href="/dashboard/employee">
                        <i class="col-2 sidebar-icon i-Bar-Chart" style="margin: 0 10px 0 16px;"></i>
                        <span class="nav-text col-5">{{ __('translate.Home') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif

            

            @if (auth()->user()->can('employee_view') ||
                    auth()->user()->can('employee_add'))
                <li class="nav-item {{ request()->is('employees') || request()->is('employees/*') ? 'active' : '' }}">
                    <div class="accordion" id="accordionExample">
                        <div>
                            <div id="headingTwo">
                                <h2 class="mb-0">
                                    <button style="border:none;background-color:white"
                                        class=" btn-block text-left collapsed" type="button" data-toggle="collapse"
                                        data-target="#employees" aria-expanded="false" aria-controls="collapseTwo">
                                        <a class="nav-item-hold row" href="#">
                                            <i class="col-2 sidebar-icon i-Engineering"  style="padding-left: 8px"></i>
                                            <span class="col-5 nav-text"
                                                style="font-size:12px;">{{ __('translate.Employees') }}</span>
                                            <i class="col-2 dd-arrow i-Arrow-Down"
                                                style="
                                            font-size: 15px;"></i>
                                        </a>
                                        <div class="triangle"></div>
                                    </button>
                                </h2>
                            </div>
                            <div id="employees" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <ul style="padding:0">
                                    @can('employee_add')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'employees.create' ? 'open' : '' }}"
                                                href="{{ route('employees.create') }}">
                                                <i class="nav-icon sidebar-icon i-Add-User"></i>
                                                <span class="item-name">{{ __('translate.Create_Employee') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('employee_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a href="{{ route('employees.index') }}"
                                                class="{{ Route::currentRouteName() == 'employees.index' ? 'open' : '' }}">
                                                <i class="nav-icon sidebar-icon i-Business-Mens"></i>
                                                <span class="item-name">{{ __('translate.Employee_List') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="triangle"></div>
                </li>
            @endif

            @if (auth()->user()->can('leave_view') ||
                    auth()->user()->can('leave_type') ||
                        auth()->user()->can('attendance_view') ||
                            auth()->user()->can('attendance_view'))
                <li class="nav-item {{ request()->is('leave') || request()->is('leave_type') ? 'active' : '' }} {{ request()->is('daily_attendance') || request()->is('attendances/*') ? 'active' : '' }}">
                    <div class="accordion" id="accordionExample">
                        <div>
                            <div id="headingTwo">
                                <h2 class="mb-0">
                                    <button style="border:none;background-color:white"
                                        class=" btn-block text-left collapsed" type="button" data-toggle="collapse"
                                        data-target="#leave" aria-expanded="false" aria-controls="collapseTwo">
                                        <a class="nav-item-hold row" href="#">
                                            <i class="col-2 sidebar-icon i-Calendar" style="padding-left: 8px"></i>
                                            <span class="col-5 nav-text"
                                                style="font-size:12px;">{{ __('translate.Leave_Request_And_Attendance') }}</span>
                                            <i class=" col-2 dd-arrow i-Arrow-Down"
                                                style="
                                            font-size: 15px;"></i>
                                        </a>
                                        <div class="triangle"></div>
                                    </button>
                                </h2>
                            </div>
                            <div id="leave" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <ul style="padding: 0">
                                    @can('leave_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'leave.index' ? 'open' : '' }}"
                                                href="{{ route('leave.index') }}">
                                                <i class="nav-icon sidebar-icon i-Wallet"></i>
                                                <span class="item-name">{{ __('translate.Request_leave') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('leave_type')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'leave_type.index' ? 'open' : '' }}"
                                                href="{{ route('leave_type.index') }}">
                                                <i class="nav-icon sidebar-icon i-Wallet"></i>
                                                <span class="item-name">{{ __('translate.Leave_Type') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('attendance_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'daily_attendance' ? 'open' : '' }}"
                                                href="{{ route('daily_attendance') }}">
                                                <i class="nav-icon sidebar-icon i-Clock"></i>
                                                <span class="item-name">{{ __('translate.Daily_Attendance') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item sidebar-collapse">
                                            <a href="{{ route('attendances.index') }}"
                                                class="{{ Route::currentRouteName() == 'attendances.index' ? 'open' : '' }}">
                                                <i class="nav-icon sidebar-icon i-Clock-4"></i>
                                                <span class="item-name">{{ __('translate.Attendances') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                            {{-- <div id="attendance" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <ul style="padding: 0">
                                    @can('attendance_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'daily_attendance' ? 'open' : '' }}"
                                                href="{{ route('daily_attendance') }}">
                                                <i class="nav-icon sidebar-icon i-Clock"></i>
                                                <span class="item-name">{{ __('translate.Daily_Attendance') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item sidebar-collapse">
                                            <a href="{{ route('attendances.index') }}"
                                                class="{{ Route::currentRouteName() == 'attendances.index' ? 'open' : '' }}">
                                                <i class="nav-icon sidebar-icon i-Clock-4"></i>
                                                <span class="item-name">{{ __('translate.Attendances') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                </li>
            @endif

            {{-- @can('attendance_view')
                <li
                    class="nav-item {{ request()->is('daily_attendance') || request()->is('attendances/*') ? 'active' : '' }}">
                    <div class="accordion" id="accordionExample">
                        <div>
                            <div id="headingTwo">
                                <h2 class="mb-0">
                                    <button style="border:none;background-color:white"
                                        class=" btn-block text-left collapsed" type="button" data-toggle="collapse"
                                        data-target="#attendance" aria-expanded="false" aria-controls="collapseTwo">
                                        <a class="nav-item-hold row" href="#">
                                            <i class="col-2 sidebar-icon i-Clock" style="padding-left: 8px"></i>
                                            <span class="col-5 nav-text"
                                                style="font-size:12px;">{{ __('translate.Attendance') }}</span>
                                            <i class="col-2 dd-arrow i-Arrow-Down"
                                                style="
                                            font-size: 15px;"></i>
                                        </a>
                                        <div class="triangle"></div>
                                    </button>
                                </h2>
                            </div>
                            <div id="attendance" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <ul style="padding: 0">
                                    @can('attendance_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'daily_attendance' ? 'open' : '' }}"
                                                href="{{ route('daily_attendance') }}">
                                                <i class="nav-icon sidebar-icon i-Clock"></i>
                                                <span class="item-name">{{ __('translate.Daily_Attendance') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item sidebar-collapse">
                                            <a href="{{ route('attendances.index') }}"
                                                class="{{ Route::currentRouteName() == 'attendances.index' ? 'open' : '' }}">
                                                <i class="nav-icon sidebar-icon i-Clock-4"></i>
                                                <span class="item-name">{{ __('translate.Attendances') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="triangle"></div>
                </li>
            @endcan --}}

            @if (auth()->user()->role_users_id != 1 && auth()->user()->role_users_id != 3)
                <li class="nav-item {{ request()->is('employee/overview') ? 'active' : '' }}">
                    <a class="nav-item-hold row" href="/employee/overview">
                        <i class="col-2 sidebar-icon i-Bar-Chart" style="margin: 0 10px 0 16px;"></i>
                        <span class="col-5 nav-text">{{ __('translate.Overview') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif

            @if (auth()->user()->role_users_id == 3)
                <li class="nav-item {{ request()->is('client_projects') ? 'active' : '' }}">
                    <a class="nav-item-hold row" href="/client_projects">
                        <i class="col-2 sidebar-icon i-Dropbox" style="margin: 0 10px 0 16px;"></i>
                        <span class="col-5 nav-text">{{ __('translate.Projects') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>

                <li class="nav-item {{ request()->is('client_tasks') ? 'active' : '' }}">
                    <a class="nav-item-hold row" href="/client_tasks">
                        <i class="col-2 sidebar-icon i-Check" style="margin: 0 10px 0 16px;"></i>
                        <span class="col-5 nav-text">{{ __('translate.Tasks') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif

            @can('project_view')
                <li class="nav-item {{ request()->is('projects') ? 'active' : '' }}">
                    <a class="nav-item-hold row" href="/projects">
                        <i class="col-2 sidebar-icon i-Dropbox" style="margin: 0 10px 0 16px;"></i>
                        <span class="col-5 nav-text">{{ __('translate.Projects') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
 
            @can('task_view')
                <li class="nav-item {{ request()->is('tasks') ? 'active' : '' }}">
                    <a class="nav-item-hold row" href="/tasks">
                        <i class="col-2 sidebar-icon i-Check" style="margin: 0 10px 0 16px;"></i>
                        <span class="col-5 nav-text">{{ __('translate.Tasks') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan

            @if (auth()->user()->can('office_shift_view') ||
                    auth()->user()->can('event_view') ||
                    auth()->user()->can('holiday_view') ||
                    auth()->user()->can('award_view') ||
                    auth()->user()->can('complaint_view') ||
                    auth()->user()->can('travel_view'))
                <li class="nav-item {{ request()->is('hr/*') ? 'active' : '' }}">
                    <div class="accordion" id="accordionExample">
                        <div>
                            <div id="headingTwo">
                                <h2 class="mb-0">
                                    <button style="border:none;background-color:white"
                                        class=" btn-block text-left collapsed" type="button" data-toggle="collapse"
                                        data-target="#hrm" aria-expanded="false" aria-controls="collapseTwo">
                                        <a class="nav-item-hold row" href="#">
                                            <i class="col-2 sidebar-icon i-Library" style="padding-left:8px"></i>
                                            <span class="col-5 nav-text">{{ __('translate.Hr_Management') }}</span>
                                            <i class="col-2 dd-arrow i-Arrow-Down" style="font-size: 15px"></i>
                                        </a>
                                        <div class="triangle"></div>
                                    </button>
                                </h2>
                            </div>
                            <div id="hrm" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <div>
                                    <ul style="padding:0">

                                        @can('office_shift_view')
                                            <li class="nav-item sidebar-collapse">
                                                <a href="{{ route('office_shift.index') }}"
                                                    class="{{ Route::currentRouteName() == 'office_shift.index' ? 'open' : '' }}">
                                                    <i class="nav-icon sidebar-icon i-Clock"></i>
                                                    <span class="item-name">{{ __('translate.Office_Shift') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('event_view')
                                            <li class="nav-item sidebar-collapse">
                                                <a href="{{ route('event.index') }}"
                                                    class="{{ Route::currentRouteName() == 'event.index' ? 'open' : '' }}">
                                                    <i class="nav-icon sidebar-icon i-Clock-4"></i>
                                                    <span class="item-name">{{ __('translate.Events') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('holiday_view')
                                            <li class="nav-item sidebar-collapse">
                                                <a class="{{ Route::currentRouteName() == 'holiday.index' ? 'open' : '' }}"
                                                    href="{{ route('holiday.index') }}">
                                                    <i class="nav-icon sidebar-icon i-Christmas-Bell"></i>
                                                    <span class="item-name">{{ __('translate.Holidays') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @if (auth()->user()->can('award_view') ||
                                                auth()->user()->can('award_type'))
                                            <li class="nav-item dropdown-sidemenu sidebar-collapse">
                                                <div id="awardaccordion">
                                                    <div>
                                                        <div id="headingOne">
                                                            <h5 class="mb-0">
                                                                <button class="btn"
                                                                    style="padding:0;border:none;background-color:white;color:#8b5cf6"
                                                                    data-toggle="collapse" data-target="#collapseOne"
                                                                    aria-expanded="false" aria-controls="collapseOne">
                                                                    <a>
                                                                        <i
                                                                            class="nav-icon sidebar-icon i-Gift-Box"></i>
                                                                        <span
                                                                            class="item-name" style="font-size: 15px">{{ __('translate.Awards') }}</span>
                                                                        <i class="dd-arrow i-Arrow-Down"
                                                                            style="padding-left: 1.5rem;
                                                                font-size: 15px;"></i>
                                                                    </a>
                                                                </button>
                                                            </h5>
                                                        </div>

                                                        <div id="collapseOne" class="collapse"
                                                            aria-labelledby="headingOne"
                                                            data-parent="#awardaccordion">
                                                            <div >
                                                                <ul class="submenu" style="padding-left: 47px">
                                                                    @can('award_view')
                                                                        <li><a class="{{ Route::currentRouteName() == 'award.index' ? 'open' : '' }}"
                                                                                href="{{ route('award.index') }}">{{ __('translate.Award_List') }}</a>
                                                                        </li>
                                                                    @endcan
                                                                    @can('award_type')
                                                                        <li><a class="{{ Route::currentRouteName() == 'award_type.index' ? 'open' : '' }}"
                                                                                href="{{ route('award_type.index') }}">{{ __('translate.Award_Type') }}</a>
                                                                        </li>
                                                                    @endcan
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>


                                            </li>
                                        @endif

                                        @can('complaint_view')
                                            <li class="nav-item sidebar-collapse">
                                                <a class="{{ Route::currentRouteName() == 'complaint.index' ? 'open' : '' }}"
                                                    href="{{ route('complaint.index') }}">
                                                    <i class="nav-icon sidebar-icon i-Danger"></i>
                                                    <span class="item-name">{{ __('translate.Complaints') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @if (auth()->user()->can('travel_view') ||
                                                auth()->user()->can('arrangement_type'))
                                            <li class="nav-item dropdown-sidemenu sidebar-collapse">
                                                <div id="travelaccordion">
                                                    <div>
                                                        <div id="headingOne">
                                                            <h5 class="mb-0">
                                                                <button class="btn"
                                                                    style="padding:0;border:none;background-color:white;color:#8b5cf6"
                                                                    data-toggle="collapse" data-target="#travelOne"
                                                                    aria-expanded="false" aria-controls="collapseOne">
                                                                    <a>
                                                                        <i
                                                                            class="nav-icon sidebar-icon i-Map-Marker"></i>
                                                                        <span
                                                                            class="item-name" style="font-size: 15px">{{ __('translate.Travels') }}</span>
                                                                        <i class="dd-arrow i-Arrow-Down"
                                                                            style="padding-left: 1.8rem;
                                                                font-size: 15px;"></i>
                                                                    </a>
                                                                </button>
                                                            </h5>
                                                        </div>

                                                        <div id="travelOne" class="collapse"
                                                            aria-labelledby="headingOne"
                                                            data-parent="#travelaccordion">
                                                            <div>
                                                                <ul class="submenu" style="padding-left: 47px">
                                                                    @can('travel_view')
                                                                        <li><a class="{{ Route::currentRouteName() == 'travel.index' ? 'open' : '' }}"
                                                                                href="{{ route('travel.index') }}">{{ __('translate.Travel_List') }}</a>
                                                                        </li>
                                                                    @endcan
                                                                    @can('arrangement_type')
                                                                        <li><a class="{{ Route::currentRouteName() == 'arrangement_type.index' ? 'open' : '' }}"
                                                                                href="{{ route('arrangement_type.index') }}">{{ __('translate.Arrangement_Type') }}</a>
                                                                        </li>
                                                                    @endcan
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endif



            @foreach ($plugins as $item)
                @if (View::exists(strtolower($item) . '::layouts.large-vertical-sidebar.sidebar'))
                    @include(strtolower($item) . '::layouts.large-vertical-sidebar.sidebar')
                @endif
            @endforeach


            @if (auth()->user()->can('company_view') ||
                    auth()->user()->can('department_view') ||
                    auth()->user()->can('designation_view') ||
                    auth()->user()->can('policy_view') ||
                    auth()->user()->can('announcement_view'))
                <li class="nav-item {{ request()->is('core/*') ? 'active' : '' }}">
                    <div class="accordion" id="accordionExample">
                        <div>
                            <div id="headingTwo">
                                <h2 class="mb-0">
                                    <button style="border:none;background-color:white"
                                        class=" btn-block text-left collapsed" type="button" data-toggle="collapse"
                                        data-target="#company" aria-expanded="false" aria-controls="collapseTwo">
                                        <a class="nav-item-hold row" href="#">
                                            <i class="col-2 sidebar-icon i-Management" style="padding-left:8px"></i>
                                            <span class="nav-text col-5"
                                                style="font-size:12px;">{{ __('translate.Company_Management') }}</span>
                                            <i class="col-2 dd-arrow i-Arrow-Down"
                                                style="font-size: 15px;"></i>
                                        </a>
                                        <div class="triangle"></div>
                                    </button>
                                </h2>
                            </div>
                            <div id="company" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <ul style="padding:0">

                                    @can('company_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'company.index' ? 'open' : '' }}"
                                                href="{{ route('company.index') }}">
                                                <i class="nav-icon sidebar-icon i-Management"></i>
                                                <span class="item-name">{{ __('translate.Company') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('department_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'departments.index' ? 'open' : '' }}"
                                                href="{{ route('departments.index') }}">
                                                <i class="nav-icon sidebar-icon i-Shop"></i>
                                                <span class="item-name">{{ __('translate.Departments') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('designation_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'designations.index' ? 'open' : '' }}"
                                                href="{{ route('designations.index') }}">
                                                <i class="nav-icon sidebar-icon i-Shutter"></i>
                                                <span class="item-name">{{ __('translate.Designations') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('policy_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a href="{{ route('policies.index') }}"
                                                class="{{ Route::currentRouteName() == 'policies.index' ? 'open' : '' }}">
                                                <i class="nav-icon sidebar-icon i-Danger"></i>
                                                <span class="item-name">{{ __('translate.Policies') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('announcement_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'announcements.index' ? 'open' : '' }}"
                                                href="{{ route('announcements.index') }}">
                                                <i class="nav-icon sidebar-icon i-Letter-Open"></i>
                                                <span class="item-name">{{ __('translate.Announcements') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>

                        </div>
                    </div>

                </li>
            @endif

            @can('user_view')
                <li class="nav-item {{ request()->is('/users') ? 'active' : '' }}">
                    <a class="nav-item-hold row" href="/users">
                        <i class="col-2 sidebar-icon i-Business-Mens" style="margin: 0 12px 0 16px;"></i>
                        <span class="col-5 nav-text">{{ __('translate.User_Controller') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan




            @can('client_view')
                <li class="nav-item {{ request()->is('clients') ? 'active' : '' }}">
                    <a class="nav-item-hold row" href="/clients">
                        <i class="col-2 sidebar-icon i-Boy" style="margin: 0 10px 0 16px;"></i>
                        <span class="col-5 nav-text">{{ __('translate.Clients') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan





            {{-- @can('attendance_view')
                <li
                    class="nav-item {{ request()->is('daily_attendance') || request()->is('attendances/*') ? 'active' : '' }}">
                    <div class="accordion" id="accordionExample">
                        <div>
                            <div id="headingTwo">
                                <h2 class="mb-0">
                                    <button style="border:none;background-color:white"
                                        class=" btn-block text-left collapsed" type="button" data-toggle="collapse"
                                        data-target="#attendance" aria-expanded="false" aria-controls="collapseTwo">
                                        <a class="nav-item-hold row" href="#">
                                            <i class="col-2 sidebar-icon i-Clock" style="padding-left: 8px"></i>
                                            <span class="col-5 nav-text"
                                                style="font-size:12px;">{{ __('translate.Attendance') }}</span>
                                            <i class="col-2 dd-arrow i-Arrow-Down"
                                                style="
                                            font-size: 15px;"></i>
                                        </a>
                                        <div class="triangle"></div>
                                    </button>
                                </h2>
                            </div>
                            <div id="attendance" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <ul style="padding: 0">
                                    @can('attendance_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'daily_attendance' ? 'open' : '' }}"
                                                href="{{ route('daily_attendance') }}">
                                                <i class="nav-icon sidebar-icon i-Clock"></i>
                                                <span class="item-name">{{ __('translate.Daily_Attendance') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item sidebar-collapse">
                                            <a href="{{ route('attendances.index') }}"
                                                class="{{ Route::currentRouteName() == 'attendances.index' ? 'open' : '' }}">
                                                <i class="nav-icon sidebar-icon i-Clock-4"></i>
                                                <span class="item-name">{{ __('translate.Attendances') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="triangle"></div>
                </li>
            @endcan --}}

                <li class="nav-item">
                    <a class="nav-item-hold row" href="#">
                        <i class="col-2 sidebar-icon i-Library" style="margin: 0 10px 0 16px;"></i>
                        <span class="col-5 nav-text">Payroll</span>
                    </a>
                    <div class="triangle"></div>
                </li>

            @if (auth()->user()->can('account_view') ||
                    auth()->user()->can('deposit_view') ||
                    auth()->user()->can('expense_view') ||
                    auth()->user()->can('expense_category') ||
                    auth()->user()->can('deposit_category') ||
                    auth()->user()->can('payment_method'))
                <li
                    class="nav-item {{ request()->is('accounting') || request()->is('accounting/*') ? 'active' : '' }}">
                    <div class="accordion" id="accordionExample">
                        <div>
                            <div id="headingTwo">
                                <h2 class="mb-0">
                                    <button style="border:none;background-color:white"
                                        class=" btn-block text-left collapsed" type="button" data-toggle="collapse"
                                        data-target="#accounting" aria-expanded="false" aria-controls="collapseTwo">
                                        <a class="nav-item-hold row" href="#">
                                            <i class="col-2 sidebar-icon i-Financial" style="padding-left: 8px"></i>
                                            <span class="col-5 nav-text"
                                                style="font-size:12px;">{{ __('translate.Accounting') }}</span>
                                            <i class="col-2 dd-arrow i-Arrow-Down"
                                                style="
                                            font-size: 15px;"></i>
                                        </a>
                                        <div class="triangle"></div>
                                    </button>
                                </h2>
                            </div>
                            <div id="accounting" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <ul style="padding: 0">
                                    @can('account_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a href="{{ route('account.index') }}"
                                                class="{{ Route::currentRouteName() == 'account.index' ? 'open' : '' }}">
                                                <i class="nav-icon sidebar-icon i-Financial"></i>
                                                <span class="item-name">{{ __('translate.Account') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('deposit_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a href="{{ route('deposit.index') }}"
                                                class="{{ Route::currentRouteName() == 'deposit.index' ? 'open' : '' }}">
                                                <i class="nav-icon sidebar-icon i-Money-2"></i>
                                                <span class="item-name">{{ __('translate.Deposit') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('expense_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a href="{{ route('expense.index') }}"
                                                class="{{ Route::currentRouteName() == 'expense.index' ? 'open' : '' }}">
                                                <i class="nav-icon sidebar-icon i-Money-Bag"></i>
                                                <span class="item-name">{{ __('translate.Expense') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @if (auth()->user()->can('expense_category') ||
                                            auth()->user()->can('deposit_category') ||
                                            auth()->user()->can('payment_method'))
                                        <li class="nav-item dropdown-sidemenu sidebar-collapse">
                                            <div id="awardaccordion">
                                                <div>
                                                    <div id="headingOne">
                                                        <h5 class="mb-0">
                                                            <button class="btn"
                                                                style="padding:0;border:none;background-color:white;color:#8b5cf6"
                                                                data-toggle="collapse" data-target="#accountingOne"
                                                                aria-expanded="false" aria-controls="collapseOne">
                                                                <a style="display: flex;align-items:center">
                                                                    <i class="nav-icon sidebar-icon i-Gear"></i>
                                                                    <span
                                                                        class="item-name" style="font-size: 15px">{{ __('translate.Account_Settings') }}</span>
                                                                    <i class="dd-arrow i-Arrow-Down"
                                                                        style="font-size: 15px;padding-left:0.5rem"></i>
                                                                </a>
                                                            </button>
                                                        </h5>
                                                    </div>

                                                    <div id="accountingOne" class="collapse"
                                                        aria-labelledby="headingOne" data-parent="#awardaccordion">
                                                        <div>
                                                            <ul class="submenu" style="padding-left: 3rem">
                                                                @can('expense_category')
                                                                    <li><a class="{{ Route::currentRouteName() == 'expense_category.index' ? 'open' : '' }}"
                                                                            href="{{ route('expense_category.index') }}">{{ __('translate.Expense_Category') }}</a>
                                                                    </li>
                                                                @endcan

                                                                @can('deposit_category')
                                                                    <li><a class="{{ Route::currentRouteName() == 'deposit_category.index' ? 'open' : '' }}"
                                                                            href="{{ route('deposit_category.index') }}">{{ __('translate.Deposit_Category') }}</a>
                                                                    </li>
                                                                @endcan
                                                                @can('payment_method')
                                                                    <li><a class="{{ Route::currentRouteName() == 'payment_methods.index' ? 'open' : '' }}"
                                                                            href="{{ route('payment_methods.index') }}">{{ __('translate.Payment_Methods') }}</a>
                                                                    </li>
                                                                @endcan
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="triangle"></div>
                </li>
            @endif

            

            @if (auth()->user()->can('training_view') ||
                    auth()->user()->can('trainer') ||
                    auth()->user()->can('training_skills'))
                <li
                    class="nav-item {{ request()->is('trainings') || request()->is('trainers') || request()->is('training_skills') ? 'active' : '' }}">
                    <div class="accordion" id="accordionExample">
                        <div>
                            <div id="headingTwo">
                                <h2 class="mb-0">
                                    <button style="border:none;background-color:white"
                                        class=" btn-block text-left collapsed" type="button" data-toggle="collapse"
                                        data-target="#training" aria-expanded="false" aria-controls="collapseTwo">
                                        <a class="nav-item-hold row" href="#">
                                            <i class="col-2 sidebar-icon i-Windows-Microsoft" style="padding-left: 8px"></i>
                                            <span class="col-5 nav-text"
                                                style="font-size:12px;">{{ __('translate.Training') }}</span>
                                            <i class=" col-2 dd-arrow i-Arrow-Down"
                                                style="
                                            font-size: 15px;"></i>
                                        </a>
                                        <div class="triangle"></div>
                                    </button>
                                </h2>
                            </div>
                            <div id="training" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <ul style="padding: 0">
                                    @can('training_view')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'trainings.index' ? 'open' : '' }}"
                                                href="{{ route('trainings.index') }}">
                                                <i class="nav-icon sidebar-icon i-Windows-Microsoft"></i>
                                                <span class="item-name">{{ __('translate.Training_List') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('trainer')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'trainers.index' ? 'open' : '' }}"
                                                href="{{ route('trainers.index') }}">
                                                <i class="nav-icon sidebar-icon i-Business-Mens"></i>
                                                <span class="item-name">{{ __('translate.Trainers') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('training_skills')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'training_skills.index' ? 'open' : '' }}"
                                                href="{{ route('training_skills.index') }}">
                                                <i class="nav-icon sidebar-icon i-Wallet"></i>
                                                <span class="item-name">{{ __('translate.Training_Skills') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="triangle"></div>
                </li>
            @endif


            @if (auth()->user()->can('settings') ||
                    auth()->user()->can('group_permission') ||
                    auth()->user()->can('currency') ||
                    auth()->user()->can('backup') ||
                    auth()->user()->can('module_settings'))
                <li class="nav-item {{ request()->is('settings/*') ? 'active' : '' }}">
                    <div class="accordion" id="accordionExample">
                        <div>
                            <div id="headingTwo">
                                <h2 class="mb-0">
                                    <button style="border:none;background-color:white"
                                        class=" btn-block text-left collapsed" type="button" data-toggle="collapse"
                                        data-target="#settings" aria-expanded="false" aria-controls="collapseTwo">
                                        <a class="nav-item-hold row" href="#">
                                            <i class="col-2 sidebar-icon i-Data-Settings" style="padding-left: 8px"></i>
                                            <span class="col-5 nav-text"
                                                style="font-size:12px;">{{ __('translate.Settings') }}</span>
                                            <i class="col-2 dd-arrow i-Arrow-Down"
                                                style="
                                            font-size: 15px;"></i>
                                        </a>
                                        <div class="triangle"></div>
                                    </button>
                                </h2>
                            </div>
                            <div id="settings" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <ul style="padding: 0">
                                    @can('settings')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'system_settings.index' ? 'open' : '' }}"
                                                href="{{ route('system_settings.index') }}">
                                                <i class="nav-icon sidebar-icon i-Gear"></i>
                                                <span class="item-name">{{ __('translate.System_Settings') }}</span>
                                            </a>
                                        </li>

                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'update_settings.index' ? 'open' : '' }}"
                                                href="{{ route('update_settings.index') }}">
                                                <i class="nav-icon sidebar-icon i-Data"></i>
                                                <span class="item-name">{{ __('translate.Update_Log') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('module_settings')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'module_settings.index' ? 'open' : '' }}"
                                                href="{{ route('module_settings.index') }}">
                                                <i class="nav-icon sidebar-icon i-Clock-3"></i>
                                                <span class="item-name">{{ __('translate.Module_settings') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('group_permission')
                                        <li class="nav-item sidebar-collapse">
                                            <a href="{{ route('permissions.index') }}"
                                                class="{{ Route::currentRouteName() == 'permissions.index' ? 'open' : '' }}">
                                                <i class="nav-icon sidebar-icon i-Lock-2"></i>
                                                <span class="item-name">{{ __('translate.Permissions') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('currency')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'currency.index' ? 'open' : '' }}"
                                                href="{{ route('currency.index') }}">
                                                <i class="nav-icon sidebar-icon i-Dollar-Sign"></i>
                                                <span class="item-name">{{ __('translate.Currency') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('backup')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'backup.index' ? 'open' : '' }}"
                                                href="{{ route('backup.index') }}">
                                                <i class="nav-icon sidebar-icon i-Download"></i>
                                                <span class="item-name">{{ __('translate.Backup') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="triangle"></div>
                </li>
            @endif

            @if (auth()->user()->can('attendance_report') ||
                    auth()->user()->can('employee_report') ||
                    auth()->user()->can('project_report') ||
                    auth()->user()->can('task_report') ||
                    auth()->user()->can('expense_report') ||
                    auth()->user()->can('deposit_report'))
                <li class="nav-item {{ request()->is('report/*') ? 'active' : '' }}">
                    <div class="accordion" id="accordionExample">
                        <div>
                            <div id="headingTwo">
                                <h2 class="mb-0">
                                    <button style="border:none;background-color:white"
                                        class=" btn-block text-left collapsed" type="button" data-toggle="collapse"
                                        data-target="#report" aria-expanded="false" aria-controls="collapseTwo">
                                        <a class="nav-item-hold row" href="#">
                                            <i class="col-2 sidebar-icon i-Line-Chart" style="padding-left: 8px"></i>
                                            <span class="col-5 nav-text"
                                                style="font-size:12px;">{{ __('translate.Reports') }}</span>
                                            <i class="col-2 dd-arrow i-Arrow-Down"
                                                style="
                                            font-size: 15px;"></i>
                                        </a>
                                        <div class="triangle"></div>
                                    </button>
                                </h2>
                            </div>
                            <div id="report" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <ul style="padding: 0">
                                    @can('attendance_report')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'attendance_report_index' ? 'open' : '' }}"
                                                href="{{ route('attendance_report_index') }}">
                                                <i class="nav-icon sidebar-icon i-Wallet"></i>
                                                <span class="item-name">{{ __('translate.Attendance_Report') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('employee_report')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'employee_report_index' ? 'open' : '' }}"
                                                href="{{ route('employee_report_index') }}">
                                                <i class="nav-icon sidebar-icon i-Wallet"></i>
                                                <span class="item-name">{{ __('translate.Employee_Report') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('project_report')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'project_report_index' ? 'open' : '' }}"
                                                href="{{ route('project_report_index') }}">
                                                <i class="nav-icon sidebar-icon i-Wallet"></i>
                                                <span class="item-name">{{ __('translate.Project_Report') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('task_report')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'task_report_index' ? 'open' : '' }}"
                                                href="{{ route('task_report_index') }}">
                                                <i class="nav-icon sidebar-icon i-Wallet"></i>
                                                <span class="item-name">{{ __('translate.Task_Report') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('expense_report')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'expense_report_index' ? 'open' : '' }}"
                                                href="{{ route('expense_report_index') }}">
                                                <i class="nav-icon sidebar-icon i-Wallet"></i>
                                                <span class="item-name">{{ __('translate.Expense_Report') }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('deposit_report')
                                        <li class="nav-item sidebar-collapse">
                                            <a class="{{ Route::currentRouteName() == 'deposit_report_index' ? 'open' : '' }}"
                                                href="{{ route('deposit_report_index') }}">
                                                <i class="nav-icon sidebar-icon i-Wallet"></i>
                                                <span class="item-name">{{ __('translate.Deposit_Report') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="triangle"></div>
                </li>
            @endif





        </ul>
    </div>

    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        @yield('childNav')
        <!-- Submenu Employee -->
        {{-- <ul class="childNav" data-parent="employees">
            @can('employee_add')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'employees.create' ? 'open' : '' }}"
                        href="{{ route('employees.create') }}">
                        <i class="nav-icon sidebar-icon i-Add-User"></i>
                        <span class="item-name">{{ __('translate.Create_Employee') }}</span>
                    </a>
                </li>
            @endcan
            @can('employee_view')
                <li class="nav-item">
                    <a href="{{ route('employees.index') }}"
                        class="{{ Route::currentRouteName() == 'employees.index' ? 'open' : '' }}">
                        <i class="nav-icon sidebar-icon i-Business-Mens"></i>
                        <span class="item-name">{{ __('translate.Employee_List') }}</span>
                    </a>
                </li>
            @endcan

        </ul> --}}



        <!-- Submenu Attendance -->
        {{-- <ul class="childNav" data-parent="attendances">
            @can('attendance_view')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'daily_attendance' ? 'open' : '' }}"
                        href="{{ route('daily_attendance') }}">
                        <i class="nav-icon sidebar-icon i-Clock"></i>
                        <span class="item-name">{{ __('translate.Daily_Attendance') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('attendances.index') }}"
                        class="{{ Route::currentRouteName() == 'attendances.index' ? 'open' : '' }}">
                        <i class="nav-icon sidebar-icon i-Clock-4"></i>
                        <span class="item-name">{{ __('translate.Attendances') }}</span>
                    </a>
                </li>
            @endcan
        </ul> --}}


        <!-- Submenu Hr Management -->
        {{-- <ul class="childNav" data-parent="core">

            @can('company_view')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'company.index' ? 'open' : '' }}"
                        href="{{ route('company.index') }}">
                        <i class="nav-icon sidebar-icon i-Management"></i>
                        <span class="item-name">{{ __('translate.Company') }}</span>
                    </a>
                </li>
            @endcan

            @can('department_view')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'departments.index' ? 'open' : '' }}"
                        href="{{ route('departments.index') }}">
                        <i class="nav-icon sidebar-icon i-Shop"></i>
                        <span class="item-name">{{ __('translate.Departments') }}</span>
                    </a>
                </li>
            @endcan

            @can('designation_view')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'designations.index' ? 'open' : '' }}"
                        href="{{ route('designations.index') }}">
                        <i class="nav-icon sidebar-icon i-Shutter"></i>
                        <span class="item-name">{{ __('translate.Designations') }}</span>
                    </a>
                </li>
            @endcan

            @can('policy_view')
                <li class="nav-item">
                    <a href="{{ route('policies.index') }}"
                        class="{{ Route::currentRouteName() == 'policies.index' ? 'open' : '' }}">
                        <i class="nav-icon sidebar-icon i-Danger"></i>
                        <span class="item-name">{{ __('translate.Policies') }}</span>
                    </a>
                </li>
            @endcan

            @can('announcement_view')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'announcements.index' ? 'open' : '' }}"
                        href="{{ route('announcements.index') }}">
                        <i class="nav-icon sidebar-icon i-Letter-Open"></i>
                        <span class="item-name">{{ __('translate.Announcements') }}</span>
                    </a>
                </li>
            @endcan
        </ul> --}}

        <!-- Submenu accounting -->
        {{-- <ul class="childNav" data-parent="accounting">

            @can('account_view')
                <li class="nav-item">
                    <a href="{{ route('account.index') }}"
                        class="{{ Route::currentRouteName() == 'account.index' ? 'open' : '' }}">
                        <i class="nav-icon sidebar-icon i-Financial"></i>
                        <span class="item-name">{{ __('translate.Account') }}</span>
                    </a>
                </li>
            @endcan

            @can('deposit_view')
                <li class="nav-item">
                    <a href="{{ route('deposit.index') }}"
                        class="{{ Route::currentRouteName() == 'deposit.index' ? 'open' : '' }}">
                        <i class="nav-icon sidebar-icon i-Money-2"></i>
                        <span class="item-name">{{ __('translate.Deposit') }}</span>
                    </a>
                </li>
            @endcan

            @can('expense_view')
                <li class="nav-item">
                    <a href="{{ route('expense.index') }}"
                        class="{{ Route::currentRouteName() == 'expense.index' ? 'open' : '' }}">
                        <i class="nav-icon sidebar-icon i-Money-Bag"></i>
                        <span class="item-name">{{ __('translate.Expense') }}</span>
                    </a>
                </li>
            @endcan

            @if (auth()->user()->can('expense_category') ||
    auth()->user()->can('deposit_category') ||
    auth()->user()->can('payment_method'))
                <li class="nav-item dropdown-sidemenu">
                    <a>
                        <i class="nav-icon sidebar-icon i-Gear"></i>
                        <span class="item-name">{{ __('translate.Account_Settings') }}</span>
                        <i class="dd-arrow i-Arrow-Down"></i>
                    </a>
                    <ul class="submenu">
                        @can('expense_category')
                            <li><a class="{{ Route::currentRouteName() == 'expense_category.index' ? 'open' : '' }}"
                                    href="{{ route('expense_category.index') }}">{{ __('translate.Expense_Category') }}</a>
                            </li>
                        @endcan

                        @can('deposit_category')
                            <li><a class="{{ Route::currentRouteName() == 'deposit_category.index' ? 'open' : '' }}"
                                    href="{{ route('deposit_category.index') }}">{{ __('translate.Deposit_Category') }}</a>
                            </li>
                        @endcan
                        @can('payment_method')
                            <li><a class="{{ Route::currentRouteName() == 'payment_methods.index' ? 'open' : '' }}"
                                    href="{{ route('payment_methods.index') }}">{{ __('translate.Payment_Methods') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

        </ul> --}}

        <!-- Submenu Request Leave -->
        {{-- <ul class="childNav" data-parent="leave">

            @can('leave_view')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'leave.index' ? 'open' : '' }}"
                        href="{{ route('leave.index') }}">
                        <i class="nav-icon sidebar-icon i-Wallet"></i>
                        <span class="item-name">{{ __('translate.Request_leave') }}</span>
                    </a>
                </li>
            @endcan

            @can('leave_type')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'leave_type.index' ? 'open' : '' }}"
                        href="{{ route('leave_type.index') }}">
                        <i class="nav-icon sidebar-icon i-Wallet"></i>
                        <span class="item-name">{{ __('translate.Leave_Type') }}</span>
                    </a>
                </li>
            @endcan
        </ul> --}}

        <!-- Submenu Training -->
        {{-- <ul class="childNav" data-parent="training">

            @can('training_view')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'trainings.index' ? 'open' : '' }}"
                        href="{{ route('trainings.index') }}">
                        <i class="nav-icon sidebar-icon i-Windows-Microsoft"></i>
                        <span class="item-name">{{ __('translate.Training_List') }}</span>
                    </a>
                </li>
            @endcan

            @can('trainer')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'trainers.index' ? 'open' : '' }}"
                        href="{{ route('trainers.index') }}">
                        <i class="nav-icon sidebar-icon i-Business-Mens"></i>
                        <span class="item-name">{{ __('translate.Trainers') }}</span>
                    </a>
                </li>
            @endcan

            @can('training_skills')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'training_skills.index' ? 'open' : '' }}"
                        href="{{ route('training_skills.index') }}">
                        <i class="nav-icon sidebar-icon i-Wallet"></i>
                        <span class="item-name">{{ __('translate.Training_Skills') }}</span>
                    </a>
                </li>
            @endcan
        </ul> --}}

        <!-- Submenu HR -->
        {{-- <ul class="childNav" data-parent="hr">

            @can('office_shift_view')
                <li class="nav-item">
                    <a href="{{ route('office_shift.index') }}"
                        class="{{ Route::currentRouteName() == 'office_shift.index' ? 'open' : '' }}">
                        <i class="nav-icon sidebar-icon i-Clock"></i>
                        <span class="item-name">{{ __('translate.Office_Shift') }}</span>
                    </a>
                </li>
            @endcan

            @can('event_view')
                <li class="nav-item">
                    <a href="{{ route('event.index') }}"
                        class="{{ Route::currentRouteName() == 'event.index' ? 'open' : '' }}">
                        <i class="nav-icon sidebar-icon i-Clock-4"></i>
                        <span class="item-name">{{ __('translate.Events') }}</span>
                    </a>
                </li>
            @endcan

            @can('holiday_view')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'holiday.index' ? 'open' : '' }}"
                        href="{{ route('holiday.index') }}">
                        <i class="nav-icon sidebar-icon i-Christmas-Bell"></i>
                        <span class="item-name">{{ __('translate.Holidays') }}</span>
                    </a>
                </li>
            @endcan

            @if (auth()->user()->can('award_view') ||
    auth()->user()->can('award_type'))
                <li class="nav-item dropdown-sidemenu">
                    <a>
                        <i class="nav-icon sidebar-icon i-Gift-Box"></i>
                        <span class="item-name">{{ __('translate.Awards') }}</span>
                        <i class="dd-arrow i-Arrow-Down"></i>
                    </a>
                    <ul class="submenu">
                        @can('award_view')
                            <li><a class="{{ Route::currentRouteName() == 'award.index' ? 'open' : '' }}"
                                    href="{{ route('award.index') }}">{{ __('translate.Award_List') }}</a></li>
                        @endcan
                        @can('award_type')
                            <li><a class="{{ Route::currentRouteName() == 'award_type.index' ? 'open' : '' }}"
                                    href="{{ route('award_type.index') }}">{{ __('translate.Award_Type') }}</a></li>
                        @endcan
                    </ul>
                </li>
            @endif

            @can('complaint_view')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'complaint.index' ? 'open' : '' }}"
                        href="{{ route('complaint.index') }}">
                        <i class="nav-icon sidebar-icon i-Danger"></i>
                        <span class="item-name">{{ __('translate.Complaints') }}</span>
                    </a>
                </li>
            @endcan

            @if (auth()->user()->can('travel_view') ||
    auth()->user()->can('arrangement_type'))
                <li class="nav-item dropdown-sidemenu">
                    <a>
                        <i class="nav-icon sidebar-icon i-Map-Marker"></i>
                        <span class="item-name">{{ __('translate.Travels') }}</span>
                        <i class="dd-arrow i-Arrow-Down"></i>
                    </a>
                    <ul class="submenu">
                        @can('travel_view')
                            <li><a class="{{ Route::currentRouteName() == 'travel.index' ? 'open' : '' }}"
                                    href="{{ route('travel.index') }}">{{ __('translate.Travel_List') }}</a></li>
                        @endcan
                        @can('arrangement_type')
                            <li><a class="{{ Route::currentRouteName() == 'arrangement_type.index' ? 'open' : '' }}"
                                    href="{{ route('arrangement_type.index') }}">{{ __('translate.Arrangement_Type') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

        </ul> --}}




        <!-- Submenu settings -->
        {{-- <ul class="childNav" data-parent="settings">
            @can('settings')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'system_settings.index' ? 'open' : '' }}"
                        href="{{ route('system_settings.index') }}">
                        <i class="nav-icon sidebar-icon i-Gear"></i>
                        <span class="item-name">{{ __('translate.System_Settings') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'update_settings.index' ? 'open' : '' }}"
                        href="{{ route('update_settings.index') }}">
                        <i class="nav-icon sidebar-icon i-Data"></i>
                        <span class="item-name">{{ __('translate.Update_Log') }}</span>
                    </a>
                </li>
            @endcan

            @can('module_settings')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'module_settings.index' ? 'open' : '' }}"
                        href="{{ route('module_settings.index') }}">
                        <i class="nav-icon sidebar-icon i-Clock-3"></i>
                        <span class="item-name">{{ __('translate.Module_settings') }}</span>
                    </a>
                </li>
            @endcan

            @can('group_permission')
                <li class="nav-item">
                    <a href="{{ route('permissions.index') }}"
                        class="{{ Route::currentRouteName() == 'permissions.index' ? 'open' : '' }}">
                        <i class="nav-icon sidebar-icon i-Lock-2"></i>
                        <span class="item-name">{{ __('translate.Permissions') }}</span>
                    </a>
                </li>
            @endcan

            @can('currency')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'currency.index' ? 'open' : '' }}"
                        href="{{ route('currency.index') }}">
                        <i class="nav-icon sidebar-icon i-Dollar-Sign"></i>
                        <span class="item-name">{{ __('translate.Currency') }}</span>
                    </a>
                </li>
            @endcan

            @can('backup')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'backup.index' ? 'open' : '' }}"
                        href="{{ route('backup.index') }}">
                        <i class="nav-icon sidebar-icon i-Download"></i>
                        <span class="item-name">{{ __('translate.Backup') }}</span>
                    </a>
                </li>
            @endcan
        </ul> --}}


        <!-- Submenu Reports -->
        <ul class="childNav" data-parent="report">
            @can('attendance_report')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'attendance_report_index' ? 'open' : '' }}"
                        href="{{ route('attendance_report_index') }}">
                        <i class="nav-icon sidebar-icon i-Wallet"></i>
                        <span class="item-name">{{ __('translate.Attendance_Report') }}</span>
                    </a>
                </li>
            @endcan

            @can('employee_report')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'employee_report_index' ? 'open' : '' }}"
                        href="{{ route('employee_report_index') }}">
                        <i class="nav-icon sidebar-icon i-Wallet"></i>
                        <span class="item-name">{{ __('translate.Employee_Report') }}</span>
                    </a>
                </li>
            @endcan

            @can('project_report')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'project_report_index' ? 'open' : '' }}"
                        href="{{ route('project_report_index') }}">
                        <i class="nav-icon sidebar-icon i-Wallet"></i>
                        <span class="item-name">{{ __('translate.Project_Report') }}</span>
                    </a>
                </li>
            @endcan

            @can('task_report')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'task_report_index' ? 'open' : '' }}"
                        href="{{ route('task_report_index') }}">
                        <i class="nav-icon sidebar-icon i-Wallet"></i>
                        <span class="item-name">{{ __('translate.Task_Report') }}</span>
                    </a>
                </li>
            @endcan

            @can('expense_report')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'expense_report_index' ? 'open' : '' }}"
                        href="{{ route('expense_report_index') }}">
                        <i class="nav-icon sidebar-icon i-Wallet"></i>
                        <span class="item-name">{{ __('translate.Expense_Report') }}</span>
                    </a>
                </li>
            @endcan

            @can('deposit_report')
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'deposit_report_index' ? 'open' : '' }}"
                        href="{{ route('deposit_report_index') }}">
                        <i class="nav-icon sidebar-icon i-Wallet"></i>
                        <span class="item-name">{{ __('translate.Deposit_Report') }}</span>
                    </a>
                </li>
            @endcan
        </ul>




        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
