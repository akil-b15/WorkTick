<?php
namespace App\Helpers;

use App\Models\PaySlip;
use App\Models\Employee;

class Utility{
    public static function employeePayslipDetail($employeeId, $month)
    {
        // allowance
        $earning['allowance'] = PaySlip::where('employee_id', $employeeId)->where('salary_month', $month)->get();
        $employess = Employee::find($employeeId);
        $totalAllowance = 0;

        $arrayJson = json_decode($earning['allowance']);
        foreach ($arrayJson as $earn) {
            $allowancejson = json_decode($earn->allowance);
            foreach ($allowancejson as $allowances) {
                if ($allowances->type == 'percentage') {
                    $empall  = $allowances->amount * $earn->basic_salary / 100;
                } else {
                    $empall = $allowances->amount;
                }
                $totalAllowance += $empall;
            }
        }

        // commission
        $earning['commission'] = PaySlip::where('employee_id', $employeeId)->where('salary_month', $month)->get();
        $employess = Employee::find($employeeId);
        $totalCommission = 0;

        $arrayJson = json_decode($earning['commission']);
        foreach ($arrayJson as $earn) {
            $commissionjson = json_decode($earn->commission);
            foreach ($commissionjson as $commissions) {
                if ($commissions->type == 'percentage') {
                    $empcom  = $commissions->amount * $earn->basic_salary / 100;
                } else {
                    $empcom = $commissions->amount;
                }
                $totalCommission += $empcom;
            }
        }

        // otherpayment
        $earning['otherPayment']      = PaySlip::where('employee_id', $employeeId)->where('salary_month', $month)->get();
        $employess = Employee::find($employeeId);
        $totalotherpayment = 0;

        $arrayJson = json_decode($earning['otherPayment']);
        foreach ($arrayJson as $earn) {
            $otherpaymentjson = json_decode($earn->other_payment);
            foreach ($otherpaymentjson as $otherpay) {
                if ($otherpay->type == 'percentage') {
                    $empotherpay  = $otherpay->amount * $earn->basic_salary / 100;
                } else {
                    $empotherpay = $otherpay->amount;
                }
                $totalotherpayment += $empotherpay;
            }
        }

        //overtime
        $earning['overTime'] = Payslip::where('employee_id', $employeeId)->where('salary_month', $month)->get();
        $ot = 0;

        $arrayJson = json_decode($earning['overTime']);
        foreach ($arrayJson as $overtime) {
            $overtimes = json_decode($overtime->overtime);
            foreach ($overtimes as $overt) {
                $OverTime = $overt->hour * $overt->rate;
                $ot += $OverTime;
            }
        }

        // loan
        $deduction['loan'] = PaySlip::where('employee_id', $employeeId)->where('salary_month', $month)->get();
        $employess = Employee::find($employeeId);
        $totalloan = 0;

        $arrayJson = json_decode($deduction['loan']);
        foreach ($arrayJson as $loan) {
            $loans = json_decode($loan->loan);
            foreach ($loans as $emploans) {
                if ($emploans->type == 'percentage') {
                    $emploan  = $emploans->amount * $loan->basic_salary / 100;
                } else {
                    $emploan = $emploans->amount;
                }
                $totalloan += $emploan;
            }
        }

        // saturation_deduction
        $deduction['deduction']      = PaySlip::where('employee_id', $employeeId)->where('salary_month', $month)->get();
        $employess = Employee::find($employeeId);
        $totaldeduction = 0;

        $arrayJson = json_decode($deduction['deduction']);
        foreach ($arrayJson as $deductions) {
            $deduc = json_decode($deductions->saturation_deduction);
            foreach ($deduc as $deduction_option) {
                if ($deduction_option->type == 'percentage') {
                    $empdeduction  = $deduction_option->amount * $deductions->basic_salary / 100;
                } else {
                    $empdeduction = $deduction_option->amount;
                }
                $totaldeduction += $empdeduction;
            }
        }

        $payslip['earning']        = $earning;
        $payslip['totalEarning']   = $totalAllowance + $totalCommission + $totalotherpayment + $ot;
        $payslip['deduction']      = $deduction;
        $payslip['totalDeduction'] = $totalloan + $totaldeduction;

        return $payslip;
    }
}