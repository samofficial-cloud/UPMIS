<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\operational_expenditure;

class operational_expenditureController extends Controller
{
    //
    public function addOperational(Request $request){
    	DB::table('operational_expenditures')->insert(
            ['vehicle_reg_no' => $request->get('op_vehicle_reg_no'),'lpo_no' => $request->get('lpo_no'), 'service_provider' => $request->get('provider'), 'date_received' => $request->get('date_received'), 'fuel_consumed' => $request->get('fuel'), 'amount' => $request->get('amount'), 'total' => $request->get('total'), 'description' => $request->get('description'), 'flag'=> 1]
        );

         return redirect()->back()->with('success', 'Details Added Successfully');
    }

    public function deleteoperational($id){
    $ops=operational_expenditure::find($id);
    $ops->flag='0';
    $ops->save();
    return redirect()->back()->with('success', 'Operational Expenditure Deleted Successfully');

}
}
