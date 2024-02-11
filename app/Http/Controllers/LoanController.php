<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        // if($user_auth->can('employee_edit')){

            $request->validate([
                'loan_option'                   => 'required',
                'title'                         => 'required',
                'type'                          => 'required',
                'amount'                        => 'required',
                'reason'                        => 'required',
            ]);

            Loan::create([
                'employee_id' => $request->employee_id,
                'loan_option' => $request->loan_option,
                'title' => $request->title,
                'type' => $request->type,
                'amount' => $request->amount,
                'reason' => $request->reason,
            ]);
            
       
            return response()->json(['success' => true]);
        // }
        // return abort('403', __('You are not authorized'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_auth = auth()->user();
        // if($user_auth->can('employee_edit')){

            $request->validate([
                'loan_option'                   => 'required',
                'title'                         => 'required',
                'type'                          => 'required',
                'amount'                        => 'required',
                'reason'                        => 'required',
            ]);

            Loan::where('id', '=', $id)->update($request->all());

            return response()->json(['success' => true]);
        // }
        // return abort('403', __('You are not authorized'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_auth = auth()->user();

        Loan::where('id', '=', $id)->update([
            'deleted_at' => Carbon::now(),
        ]);

        return response()->json(['success' => true]);
    }
}
