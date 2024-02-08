<?php

namespace App\Http\Controllers;

use App\Models\PaySlip;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaySlipController extends Controller
{
    public function index()
    {
        $month = [
            '01' => 'JAN',
            '02' => 'FEB',
            '03' => 'MAR',
            '04' => 'APR',
            '05' => 'MAY',
            '06' => 'JUN',
            '07' => 'JUL',
            '08' => 'AUG',
            '09' => 'SEP',
            '10' => 'OCT',
            '11' => 'NOV',
            '12' => 'DEC',
        ];
        $currentyear = date("Y"); 
        $tempyear = intval($currentyear) - 2;
        $year = [];
        for($i = 0;$i<10;$i++){
            $year[$tempyear + $i] = $tempyear + $i;
        }

        // $year = [

        //     '2021' => '2021',
        //     '2022' => '2022',
        //     '2023' => '2023',
        //     '2024' => '2024',
        //     '2025' => '2025',
        //     '2026' => '2026',
        //     '2027' => '2027',
        //     '2028' => '2028',
        //     '2029' => '2029',
        //     '2030' => '2030',
        //     '2031' => '2031',
        //     '2032' => '2032',
        // ];

        $payslips = $this->search_json(now()->format('Y-m'));

        return view('payslip.index', compact('payslips', 'month', 'year'));
    }

    public function search_json($formate_month_year)
    {
        $validatePaysilp    = PaySlip::where('salary_month', '=', $formate_month_year)->get()->toarray();
        $data = [];
        if (empty($validatePaysilp)) {
            $data = [];
            return $data;
        } else {
            $paylip_employee = PaySlip::select(
                [
                    'employees.id',
                    'employees.employee_id',
                    'employees.name',
                    'employees.salary',
                    'payslip_types.name as payroll_type',
                    'pay_slips.basic_salary',
                    'pay_slips.net_payble',
                    'pay_slips.id as pay_slip_id',
                    'pay_slips.status',
                    'employees.user_id',
                ]
            )->leftjoin(
                'employees',
                function ($join) use ($formate_month_year) {
                    $join->on('employees.id', '=', 'pay_slips.employee_id');
                    $join->on('pay_slips.salary_month', '=', DB::raw("'" . $formate_month_year . "'"));
                }
            )->get();

            foreach ($paylip_employee as $employee) {
                // if (Auth::user()->type == 'employee') {
                    if (Auth::user()->id == $employee->user_id) {
                        $tmp   = [];
                        $tmp['id'] = $employee->id;
                        $tmp['name'] = $employee->name;
                        // $tmp[] = $employee->payroll_type;
                        // $tmp[] = $employee->pay_slip_id;
                        $tmp['salary'] = !empty($employee->basic_salary) ? $employee->salary : '-';
                        $tmp['net_salary'] = !empty($employee->net_payble) ? $employee->net_payble : '-';
                        $tmp['status'] = $employee->status;
                        // $tmp[]  = !empty($employee->pay_slip_id) ? $employee->pay_slip_id : 0;
                        // $tmp['url']  = route('employee.show', Crypt::encrypt($employee->id));
                        $tmp['url']  = "";
                        $data[] = $tmp;
                    }
                // } else {

                //     $tmp   = [];
                //     $tmp[] = $employee->id;
                //     $tmp[] = \Auth::user()->employeeIdFormat($employee->employee_id);
                //     $tmp[] = $employee->name;
                //     $tmp[] = $employee->payroll_type;
                //     $tmp[] = !empty($employee->basic_salary) ? \Auth::user()->priceFormat($employee->basic_salary) : '-';
                //     $tmp[] = !empty($employee->net_payble) ? \Auth::user()->priceFormat($employee->net_payble) : '-';
                //     if ($employee->status == 1) {
                //         $tmp[] = 'Paid';
                //     } else {
                //         $tmp[] = 'UnPaid';
                //     }
                //     $tmp[]  = !empty($employee->pay_slip_id) ? $employee->pay_slip_id : 0;
                //     $tmp['url']  = route('employee.show', Crypt::encrypt($employee->id));
                //     $data[] = $tmp;
                // }
            }

            return $data;
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required',
        ]);

        $month = $request->month;
        $year  = $request->year;

        $formate_month_year = $year . '-' . $month;
        $validatePaysilp    = PaySlip::where('salary_month', '=', $formate_month_year)->pluck('employee_id');
        $payslip_employee   = Employee::where('joining_date', '<=', date($year . '-' . $month . '-t'))->count();

        if ($payslip_employee > count($validatePaysilp)) {
            $employees = Employee::where('joining_date', '<=', date($year . '-' . $month . '-t'))->whereNotIn('employee_id', $validatePaysilp)->get();
            $employeesSalary = Employee::where('salary', '<=', 0)->first();

            if (!empty($employeesSalary)) {
                return response()->json(['success' => false]);
            }

            foreach ($employees as $employee) {

                $chek = PaySlip::where(['employee_id' => $employee->id, 'salary_month' => $formate_month_year])->first();
                if (!$chek && $chek == null) {
                    $payslipEmployee                       = new PaySlip();
                    $payslipEmployee->employee_id          = $employee->id;
                    $payslipEmployee->net_payble           = $employee->get_net_salary();
                    $payslipEmployee->salary_month         = $formate_month_year;
                    $payslipEmployee->status               = 0;
                    $payslipEmployee->basic_salary         = !empty($employee->salary) ? $employee->salary : 0;
                    $payslipEmployee->allowance            = Employee::allowance($employee->id);
                    $payslipEmployee->commission           = Employee::commission($employee->id);
                    $payslipEmployee->loan                 = Employee::loan($employee->id);
                    $payslipEmployee->saturation_deduction = Employee::saturation_deduction($employee->id);
                    $payslipEmployee->other_payment        = Employee::other_payment($employee->id);
                    $payslipEmployee->overtime             = Employee::overtime($employee->id);
                    $payslipEmployee->created_by           = Auth::id();
                    $payslipEmployee->save();
                }
            }
            return redirect()->route('payslip.index')->with('success', __('Payslip successfully created.'));
        } else {
            return redirect()->route('payslip.index')->with('error', __('Payslip Already created.'));
        }
    }
}
