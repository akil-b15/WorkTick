<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_auth = auth()->user();
		if ($user_auth->can('recruitment_view')){
            $total = Job::where('deleted_at', '=', null)
            ->count();
            $active = Job::where('deleted_at', '=', null)
            ->where('status', '=', 'active')
            ->count();
            $inactive = Job::where('deleted_at', '=', null)
            ->where('status', '=', 'inactive')
            ->count();

            $jobs = Job::where('deleted_at', '=', null)
            // ->with('company:id,name','client:id,username')
            ->orderBy('id', 'desc')
            ->get();
           
            return view('recruitment.recruitment_list', compact('total','active','inactive','jobs'));

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
		if ($user_auth->can('recruitment_add')){

            return view('recruitment.create_recruitment');

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
		if ($user_auth->can('recruitment_add')){

            $request->validate([
                'title'           => 'required|string|max:255',
                'position'          => 'required',
                'description'      => 'required',
                'skill'     => 'required',
                'start_date'      => 'required',
                'end_date'        => 'required',
                'requirement'        => 'required',
                'status'          => 'required',
            ]);

            $job  = Job::create([
                'title'            => $request['title'],
                'position'          => $request['position'],
                'start_date'       => $request['start_date'],
                'end_date'         => $request['end_date'],
                'skill'       => $request['skill'],
                'requirement'        => $request['requirement'],
                'status'           => $request['status'],
                'description'      => $request['description'],
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
