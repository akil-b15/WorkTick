<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Commission;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\OtherPayment;
use App\Models\OverTime;
use App\Models\SaturationDeduction;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index(){

        $employees = Employee::where('deleted_at', '=', null)->get();


        return view('salary.salary', compact('employees'));
    }

    public function show($id)
    {
        $user_auth = auth()->user();
        if($user_auth->can('employee_details')){

            $employee = Employee::where('deleted_at', '=', null)->findOrFail($id);

            $allowances = Allowance::where('deleted_at', '=', null)->where('employee_id','=', $id)->get();
            $commissions = Commission::where('deleted_at', '=', null)->where('employee_id','=', $id)->get();
            $loans = Loan::where('deleted_at', '=', null)->where('employee_id','=', $id)->get();
            $deductions = SaturationDeduction::where('deleted_at', '=', null)->where('employee_id','=', $id)->get();
            $otherpayments = OtherPayment::where('deleted_at', '=', null)->where('employee_id','=', $id)->get();
            $overtimes = OverTime::where('deleted_at', '=', null)->where('employee_id','=', $id)->get();

            

            return view('salary.set_salary',
                compact('employee', 'allowances', 'commissions', 'loans', 'deductions','otherpayments','overtimes')
                        );
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request, $id)
    {
        $user_auth = auth()->user();
        // if($user_auth->can('employee_edit')){
            $request->validate([
                'salary'                        => 'required',
            ]);

            Employee::where('id', '=', $id)->update($request->all());
       
            return response()->json(['success' => true]);
        // }
        // return abort('403', __('You are not authorized'));
    }

    public function update(Request $request, $id)
    {
        $user_auth = auth()->user();
        // if($user_auth->can('employee_edit')){

            Employee::where('id', '=', $id)->update($request->all());
       
            return response()->json(['success' => true]);
        // }
        // return abort('403', __('You are not authorized'));
    }

    

    
}
