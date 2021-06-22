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


        $hire_rate=new hire_rate();
        $hire_rate->vehicle_model=strtoupper($request->get('vehicle_model'));
        $hire_rate->hire_rate=$request->get('hire_rate');
        $hire_rate->reason_for_forwarding='New';
        $hire_rate->save();

              return redirect()->back()->with('success', 'Request Sent Successfully');
      }


    }

    public function edithirerate(Request $request){


       $hire_rate=hire_rate::where('id', $request->get('id'))->first();
       $hire_rate->vehicle_model=$request->get('hire_vehicle_model');
       $hire_rate->hire_rate=$request->get('hire_hire_rate');

        if($request->get('rejected_by')=='DVC'){

            $hire_rate->stage='1b';
        }else{

            $hire_rate->stage=1;
        }



       $hire_rate->save();

       return redirect()->back()->with('success', 'Request Sent Successfully');


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



    public function deletehireratePermanently($id){

        hire_rate::where('id',$id)->delete();

        return redirect()->back()->with('success', 'Hire Rate Deleted Successfully');
    }


}
