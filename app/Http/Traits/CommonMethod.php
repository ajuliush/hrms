<?php


namespace App\Http\traits;
use App\Models\Company;
use App\Models\User;
use Auth;
use DB;


Trait CommonMethod {


    public  function generateInvoiceId()
    {
        //Previous Code
        // $employeeIdPrefix = Company::where('id', '=', Auth::user()->com_id)->first('employee_id_prefix');
        // $prefix =  $employeeIdPrefix->employee_id_prefix ;

        // $invoiceLength = 6 ;
        // $totalEmployee= DB::table('users')->where('com_id', '=', Auth::user()->com_id)->count();
        // $voucherId =  $prefix . str_pad($totalEmployee +1, $invoiceLength, "0", STR_PAD_LEFT);

        // return $voucherId;


       //New Code
        $employeeIdPrefix = Company::where('id', '=', Auth::user()->com_id)->first('employee_id_prefix');
        $prefix =  $employeeIdPrefix->employee_id_prefix;

        $invoiceLength = 6;

        $existingVoucherIds = DB::table('users')->where('com_id', '=', Auth::user()->com_id)->pluck('company_assigned_id')->toArray();

        $count = 1;
        do {
            $voucherId = $prefix . str_pad($count, $invoiceLength, "0", STR_PAD_LEFT);
            $count++;
        } while (in_array($voucherId, $existingVoucherIds));

        return $voucherId;
    }
}
