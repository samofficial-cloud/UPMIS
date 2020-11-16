<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\carRental;
use App\operational_expenditure;
use App\hire_rate;
use App\carContract;
use App\cost_centre;

class carRentalController extends Controller
{
    //
    public function index(){
    	$cars=carRental::where('flag','1')->orderBy('vehicle_status','dsc')->get();
      $operational=operational_expenditure::where('flag','1')->get();
      $rate=hire_rate::where('flag','1')->orderBy('vehicle_model','asc')->get();
      $costcentres=cost_centre::orderBy('costcentre_id','asc')->get();
    	return view('car')->with('cars',$cars)->with('operational',$operational)->with('rate',$rate)->with('costcentres',$costcentres);
    }

    public function newcar(Request $request){
    $vehicle_reg_no = $request->input('vehicle_reg_no');

    $validate=carRental::select('vehicle_reg_no')->where('vehicle_reg_no',$vehicle_reg_no)->where('flag','1')->value('vehicle_reg_no');

    if(is_null($validate)){
      $vehicle_model = $request->input('model');
    $vehicle_status = $request->input('vehicle_status');
    $hire_rate = $request->input('hire_rate');

    $data=array('vehicle_reg_no'=>$vehicle_reg_no,"vehicle_model"=>$vehicle_model,'vehicle_status'=>$vehicle_status, 'hire_rate'=>$hire_rate);

    DB::table('car_rentals')->insert($data);

    return redirect()->back()->with('success', 'Car Details Added Successfully'); 
    }
    else{
    return redirect()->back()->with('errors', "This vehicle '$vehicle_reg_no'  could not be added because it already exists in the system");
  }

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
    $car->flag='0';
    $car->save();
    return redirect()->back()->with('success', 'Car Deleted Successfully');

}

public function addcentre(Request $request){
 $centre_id=$request->get('costcentreid');
 $check=cost_centre::where('costcentre_id',$centre_id)->get();
 if(count($check)>0){
  return redirect()->back()->with('errors', "This cost centre '$centre_id' already exists");
 }
 else{
  $centre_name=$request->get('centrename');
  $data=array('costcentre_id'=>$centre_id,"costcentre"=>$centre_name);
  DB::table('cost_centres')->insert($data);
  return redirect()->back()->with('success', 'Cost Centre Added Successfully');
 }
}

public function editcentre(Request $request){
  $id=$request->get('centreid');

      DB::table('cost_centres')
      ->where('id', $id)
      ->update(['costcentre_id' => $request->get('costcentre_id')]);

       DB::table('cost_centres')
      ->where('id', $id)
      ->update(['costcentre' => $request->get('centrename')]);

      return redirect()->back()->with('success', 'Cost Centre Details Edited Successfully');
}

public function deletecentre($id){
  $centre=cost_centre::find($id);
  $centre->delete();
  return redirect()->back()->with('success', 'Cost Centre Deleted Successfully');
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

 public function fetchs2(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      $start_date=$request->get('start_date');
      $data= DB::table('car_rentals')
        ->where('vehicle_reg_no', 'LIKE', "%{$query}%")
        ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')->where('vehicle_reg_no','!=',null)->whereDate('end_date','>=', $start_date)->pluck('vehicle_reg_no')->toArray())
        ->where('vehicle_status','!=','Grounded')
        ->get();
      if(count($data)!=0){
      $output = '<ul class="dropdown-menu form-card" style="display: block;
    width: 100%; margin-left: 0%; margin-top: -3%;">';
      foreach($data as $row)
      {
       $output .= '
       <li id="list" style="margin-left: -3%;">'.$row->vehicle_reg_no.' - '.$row->vehicle_model.'</li>
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

 public function fetch2(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = carRental::where('vehicle_reg_no', 'LIKE', "%{$query}%")->where('vehicle_status','!=','Grounded')->get();
      if(count($data)!=0){
      $output = '<ul class="dropdown-menu_custom" style="display: block;
    width: 100%; margin-left: 0%; margin-top: 0%; margin-bottom: 1%;">';
      foreach($data as $row)
      {
       $output .= '
       <li id="list" style="margin-left: 1%; margin-right: 1%;">'.$row->vehicle_reg_no.'</li>
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
      $data = hire_rate::select('hire_rate')->where('vehicle_model',$query)->value('hire_rate');
     
       $output = $data;
     
      echo $output;
     
   }
 }

 public function faculty(Request $request){

     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = cost_centre::select('costcentre')->where('costcentre_id',$query)->value('costcentre');
     
       $output = $data;
     
      echo $output;
     
   }
 }

 public function fetchcostcentres(Request $request){
  if($request->get('query'))
     {
      $query = $request->get('query');
      $data = cost_centre::where('costcentre_id', 'LIKE', "%{$query}%")->get();
      if(count($data)!=0){
      $output = '<ul class="dropdown-menu_custom" style="display: block;
    width: 100%; margin-left: 0%; margin-top: 0%; margin-bottom: 1%;">';
      foreach($data as $row)
      {
       $output .= '
       <li id="list" style="margin-left: 1%; margin-right: 1%;">'.$row->costcentre_id.' - '.$row->costcentre.'</li>
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

 public function viewMore(){
  $ops=operational_expenditure::where('vehicle_reg_no',$_GET['vehicle_reg_no'])->get();
  $bookings=carContract::where('vehicle_reg_no',$_GET['vehicle_reg_no'])->whereDate('end_date','>=',date('Y-m-d'))->get();
  $bookings2=carContract::where('vehicle_reg_no',$_GET['vehicle_reg_no'])->whereDate('end_date','<',date('Y-m-d'))->get();
  $details=carRental::where('vehicle_reg_no',$_GET['vehicle_reg_no'])->get();
  return view('car_view_more')->with('ops',$ops)->with('bookings',$bookings)->with('details',$details)->with('bookings2',$bookings2);
 }
}
