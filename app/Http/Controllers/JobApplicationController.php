<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
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
            // ->with('company:id,name','client:id,username')
            ->orderBy('id', 'desc')
            ->get();

            return view('job_application.job_application_list', compact('job_applications'));

        }
        return abort('403', __('You are not authorized'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_auth = auth()->user();
		if ($user_auth->can('job_application_add')){

            $jobs = Job::where('deleted_at', '=', null)
            ->orderBy('id', 'desc')
            ->get();
            return view('job_application.create_job_application', compact('jobs'));

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
        $user_auth = auth()->user();
		if ($user_auth->can('job_application_add')){

            $request->validate([
                'first_name'           => 'required|string|max:255',
                'last_name'          => 'required',
                'job_id'          => 'required',
                'stage'      => 'required',
                'email'     => 'required',
                'gender'     => 'required',
                'birth_date'      => 'required',
                'phone'        => 'required',
                'country'        => 'required',
            ]);

            $job_application  = JobApplication::create([
                'first_name'            => $request['first_name'],
                'last_name'          => $request['last_name'],
                'job_id'          => $request['job_id'],
                'birth_date'       => $request['birth_date'],
                'phone'         => $request['phone'],
                'gender'       => $request['gender'],
                'email'       => $request['email'],
                'country'        => $request['country'],
                'stage'      => $request['stage'],
            ]);

             return response()->json(['success' => true]);

        }
        return abort('403', __('You are not authorized'));
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
        $user_auth = auth()->user();
		if ($user_auth->can('job_application_edit')){

            $job_application = JobApplication::where('deleted_at', '=', null)->findOrFail($id);
            $jobs = Job::where('deleted_at', '=', null)
            ->orderBy('id', 'desc')
            ->get();

            return view('job_application.edit_job_application', compact('job_application','jobs'));

        }
        return abort('403', __('You are not authorized'));
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
        $user_auth = auth()->user();
		if ($user_auth->can('job_application_edit')){
            $job_application = JobApplication::where('id', $id)->update([
                'first_name'            => $request['first_name'],
                'last_name'          => $request['last_name'],
                'job_id'          => $request['job_id'],
                'birth_date'       => $request['birth_date'],
                'phone'         => $request['phone'],
                'gender'       => $request['gender'],
                'email'       => $request['email'],
                'country'        => $request['country'],
                'stage'      => $request['stage'],
            ]);

            return response()->json(['success' => true]);
        }
        return abort('403', __('You are not authorized'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_auth = auth()->user();
		if ($user_auth->can('job_application_delete')){
            JobApplication::where('id', $id)->delete();
            return response()->json(['success' => true]);
        }
        
        return abort('403', __('You are not authorized'));
    }
}
