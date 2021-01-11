<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\hire_rate;

class hireRateController extends Controller
{
    //
    public function addhirerate( Request $request){
      $model=$request->get('vehicle_model');
      $check=hire_rate::where('vehicle_model',$model)->where('flag',1)->get();
      if(count($check)>0){
        return redirect()->back()->with('errors', "'$model' Model Already Exists.");
      }
      else{
        $deactivated = hire_rate::where('vehicle_model',$model)->where('flag',0)->first();
        if(is_null($deactivated)){
            DB::table('hire_rates')
             ->insert(['vehicle_model' => strtoupper($request->get('vehicle_model')), 'hire_rate' => $request->get('hire_rate')]);
        }
        else{
          $deactivated->flag = '1';
          $deactivated->hire_rate = $request->get('hire_rate');
          $deactivated->save();
        }
      

              return redirect()->back()->with('success', 'Hire Rate Details Added Successfully');
      }
      

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
    // DB::table('hire_rates')
    //    ->where('id', $id)
    //    ->update(['flag' => '0']);
      $hire=hire_rate::find($id);
      $hire->flag=0;
      $hire->save();
   return redirect()->back()->with('success', 'Hire Rate Deleted Successfully');
    }
}
