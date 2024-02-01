<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use Spatie\Permission\Models\Role;
use App\Models\Company;

class JobOnBoardingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_auth = auth()->user();
		if ($user_auth->can('job_application_view')){
            $job_applications = JobApplication::with('jobs')->where('deleted_at', '=', null)
            ->where('stage',4)
            ->orderBy('id', 'desc')
            ->get();

            return view('job_on_boarding.job_on_boarding_list', compact('job_applications'));

        }
        return abort('403', __('You are not authorized'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function on_board($application_id)
    {
        $user_auth = auth()->user();
        if($user_auth->can('employee_add')){  

            $roles = Role::where('deleted_at', '=', null)->get(['id','name']);
            $companies = Company::where('deleted_at', '=', null)->get(['id','name']);
            $job_application = JobApplication::find($application_id);
            return view('employee.create_employee', compact('companies','roles', 'job_application'));
        }
        return abort('403', __('You are not authorized'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
