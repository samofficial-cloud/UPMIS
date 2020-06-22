<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\carRental;

class carRentalController extends Controller
{
    //
    public function index(){
    	$cars=carRental::get();
    	return view('car')->with('cars',$cars);
    }

    public function newcar(Request $request){
    $vehicle_reg_no = $request->input('vehicle_reg_no');
    $vehicle_model = $request->input('model');
    $vehicle_status = $request->input('vehicle_status');
    $hire_rate = $request->input('hire_rate');

    $data=array('vehicle_reg_no'=>$vehicle_reg_no,"vehicle_model"=>$vehicle_model,'vehicle_status'=>$vehicle_status, 'hire_rate'=>$hire_rate);

    DB::table('car_rentals')->insert($data);

    return redirect()->back()->with('success', 'Car Details Added Successfully');

}

public function editcar(Request $request){
	$id=$request->get('id');
	$car=carRental::find($id);
	$car->vehicle_reg_no=$request->get('vehicle_reg_no');
	$car->vehicle_model=$request->get('model');
	$car->vehicle_status=$request->get('vehicle_status');
	$car->hire_rate=$request->get('hire_rate');

	$car->save();
	return redirect()->back()->with('success', 'Car Details Edited Successfully');
}

public function deletecar($id){
    $car=carRental::find($id);
    // $car->flag='0';
    // $car->save();
    return redirect()->back()->with('success', 'Car Deleted Successfully');

}

   public function fetch(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = carRental::where('vehicle_reg_no', 'LIKE', "%{$query}%")->where('vehicle_status','!=','Grounded')->get();
      if(count($data)!=0){
      $output = '<ul class="dropdown-menu form-card" style="display: block;
    width: 100%; margin-left: 0%; margin-top: -3%;">';
      foreach($data as $row)
      {
       $output .= '
       <li id="list" style="margin-left: -3%;">'.$row->vehicle_reg_no.'</li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
     else{
      echo "0";
     }

   }
 }


 public function model(Request $request){

     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = carRental::select('vehicle_model')->where('vehicle_reg_no',$query)->value('vehicle_model');
     
       $output = $data;
     
      echo $output;
     
   }
 }

 public function hirerate(Request $request){

     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = carRental::select('hire_rate')->where('vehicle_reg_no',$query)->value('hire_rate');
     
       $output = $data;
     
      echo $output;
     
   }
 }
}
