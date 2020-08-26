<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class hireRateController extends Controller
{
    //
    public function addhirerate( Request $request){
        DB::table('hire_rates')
             ->insert(['vehicle_model' => $request->get('vehicle_model'), 'hire_rate' => $request->get('hire_rate')]);

              return redirect()->back()->with('success', 'Hire Rate Details Added Successfully');

    }

    public function edithirerate(Request $request){
    	DB::table('hire_rates')
       ->where('id', $request->get('id'))
       ->update(['vehicle_model' => $request->get('hire_vehicle_model')]);

       DB::table('hire_rates')
       ->where('id', $request->get('id'))
       ->update(['hire_rate' => $request->get('hire_hire_rate')]);

       return redirect()->back()->with('success', 'Hire Rate Details Edited Successfully');


    }

    public function deletehirerate($id){
    DB::table('hire_rates')
       ->where('id', $id)
       ->update(['flag' => '0']);
   return redirect()->back()->with('success', 'Hire Rate Deleted Successfully');
    }
}
