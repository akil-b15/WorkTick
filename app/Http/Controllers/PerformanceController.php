<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Performance;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_auth = auth()->user();
		// if ($user_auth->can('training_view')){

            $performances = Performance::where('deleted_at', '=', null)
            ->with('employee:id,username')
            ->orderBy('id', 'desc')
            ->get();
            return view('performance.performance', compact('performances'));

        // }
        // return abort('403', __('You are not authorized'));

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_auth = auth()->user();
		// if ($user_auth->can('training_add')){

            // $trainers = Trainer::where('deleted_at', '=', null)->orderBy('id', 'desc')->get(['id','name']);
            // $training_skills = TrainingSkill::where('deleted_at', '=', null)->orderBy('id', 'desc')->get(['id','training_skill']);
            $employees = Employee::where('deleted_at', '=', null)->orderBy('id', 'desc')->get(['id','username']);

            return view('performance.create_performance', compact('employees'));

        // }
        // return abort('403', __('You are not authorized'));
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
		// if ($user_auth->can('training_add')){

            $request->validate([
                'goal_type'                     => 'required',
                'subject'                       => 'required',
                'start_date'                    => 'required',
                'end_date'                      => 'required',
                'employee_id'                   => 'required',
                'target_achievement'            => 'required',
                // 'company_id'      => 'required',
            ]);

            $training = Performance::create([
                'goal_type'             => $request['goal_type'],
                'start_date'            => $request['start_date'],
                'end_date'              => $request['end_date'],
                'subject'               => $request['subject'],
                'employee_id'           => $request['employee_id'],
                'target_achievement'    => $request['target_achievement'],
            ]);

            // $training->assignedEmployees()->sync($request['assigned_to']);

            return response()->json(['success' => true]);

        // }
        // return abort('403', __('You are not authorized'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function show(Performance $performance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_auth = auth()->user();
		// if ($user_auth->can('training_edit')){

            $performance = Performance::where('deleted_at', '=', null)->findOrFail($id);
            // $assigned_employees = EmployeeTraining::where('training_id', $id)->pluck('employee_id')->toArray();
            // $companies = Company::where('deleted_at', '=', null)->orderBy('id', 'desc')->get(['id','name']);
            $employees = Employee::where('deleted_at', '=', null)->orderBy('id', 'desc')->get(['id','username']);
            // $trainers = Trainer::where('deleted_at', '=', null)->orderBy('id', 'desc')->get(['id','name']);
            // $training_skills = TrainingSkill::where('deleted_at', '=', null)->orderBy('id', 'desc')->get(['id','training_skill']);

            return view('performance.edit_performance', compact('performance', 'employees'));

        // }
        // return abort('403', __('You are not authorized'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_auth = auth()->user();
		// if ($user_auth->can('training_edit')){

            $request->validate([
                'goal_type'                     => 'required',
                'subject'                       => 'required',
                'start_date'                    => 'required',
                'end_date'                      => 'required',
                'employee_id'                   => 'required',
                'target_achievement'            => 'required',
            ]);

            Performance::whereId($id)->update([
                'goal_type'             => $request['goal_type'],
                'start_date'            => $request['start_date'],
                'end_date'              => $request['end_date'],
                'subject'               => $request['subject'],
                'employee_id'           => $request['employee_id'],
                'target_achievement'    => $request['target_achievement'],
                'progress'           => $request['progress'],
                'ratings'           => $request['rating'],
            ]);

            // $training = Training::where('deleted_at', '=', null)->findOrFail($id);
            // $training->assignedEmployees()->sync($request['assigned_to']);

            return response()->json(['success' => true]);

        // }
        // return abort('403', __('You are not authorized'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_auth = auth()->user();
		// if ($user_auth->can('training_delete')){

            Performance::whereId($id)->update([
                'deleted_at' => Carbon::now(),
            ]);

            return response()->json(['success' => true]);

        // }
        // return abort('403', __('You are not authorized'));
    }

    //-------------- Delete by selection  ---------------\\

    public function delete_by_selection(Request $request)
    {
       $user_auth = auth()->user();
    //    if($user_auth->can('training_delete')){
           $selectedIds = $request->selectedIds;
   
           foreach ($selectedIds as $training_id) {
            Performance::whereId($training_id)->update([
                   'deleted_at' => Carbon::now(),
               ]);
           }
           return response()->json(['success' => true]);
    //    }
    //    return abort('403', __('You are not authorized'));
    }
}
