<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\carRental;
use App\operational_expenditure;
use App\hire_rate;
use App\carContract;
use App\cost_centre;
use View;
use Carbon\Carbon;

class carRentalController extends Controller
{
    //
    public function index(){
    	$cars=carRental::where('flag','1')->orderBy('vehicle_status','dsc')->get();
      $operational=operational_expenditure::where('flag','1')->get();
      $rate=hire_rate::where('flag','1')->orderBy('vehicle_model','asc')->get();
        $costcentres=cost_centre::orderBy('costcentre_id','asc')->where('status',1)->get();
    	return view('car')->with('cars',$cars)->with('operational',$operational)->with('rate',$rate)->with('costcentres',$costcentres);
    }

    public function newcar(Request $request){
      $vehicle_reg_no = strtoupper($request->input('vehicle_reg_no'));

       $validate=carRental::select('vehicle_reg_no')->where('vehicle_reg_no',$vehicle_reg_no)->where('flag','1')->value('vehicle_reg_no');

       if(is_null($validate)){

            $car= new carRental();
            $car->vehicle_model = $request->input('model');
            $car->hire_rate=$request->input('hire_rate');
            $car->hire_status=$request->input('hire_status');
            $car->vehicle_status=$request->input('vehicle_status');
            $car->vehicle_reg_no=$vehicle_reg_no;
            $car->save();

           $id = DB::table('car_rentals')->orderBy('id','desc')->limit(1)->value('id');

           DB::table('car_notifications')->insert(['role'=>'DVC Administrator', 'message'=>'You have a new pending car to approve', 'flag'=>'1','car_id'=>$id]);

            return redirect()->back()->with('success', 'Car Details Forwarded Successfully');
       }
       else{
        return redirect()->back()->with('errors', "This vehicle '$vehicle_reg_no'  could not be added because it already exists in the system");
       }


    }

    public function newcar_step2(Request $request){
      $id = $request->get('vehicle_id');
      $vehicle=carRental::find($request->get('vehicle_id'));
      $status = $request->get('approval_status');
        if($status=='Accepted'){
          $vehicle->remarks=$status;
          $vehicle->flag = '1';
          DB::table('car_notifications')
                ->where('car_id', $id)
                ->update(['flag' => '0']);
        }
        elseif($status=='Rejected'){
          $vehicle->remarks=$status;
          $vehicle->comments=$request->get('reason');
          $vehicle->cptu_msg_status = 'inbox';
          DB::table('car_notifications')
                ->where('car_id', $id)
                ->where('role', 'DVC Administrator')
                ->update(['flag' => '0']);

          DB::table('car_notifications')->insert(['role'=>'Transport Officer-CPTU', 'message'=>'You have a new pending car to review', 'flag'=>'1','car_id'=>$id]);
        }
      $vehicle->form_status='Transport Officer-CPTU';
      $vehicle->dvc_msg_status = 'outbox';
      $vehicle->save();
      return redirect()->back()->with('success', 'Car Details Forwarded Successfully');

    }

    public function newcar_step3(Request $request){
      $vehicle=carRental::find($request->get('vehicle_id'));
      $vehicle->vehicle_reg_no=$request->get('vehicle_reg_no');
      $vehicle->vehicle_model = $request->get('model');
      $vehicle->vehicle_status = $request->get('vehicle_status');
      $vehicle->hire_rate = $request->get('hire_rate');
      $vehicle->form_status = 'DVC Administrator';
      $vehicle->dvc_msg_status = 'inbox';
      $vehicle->cptu_msg_status = 'outbox';
      $vehicle->save();
      return redirect()->back()->with('success', 'Car Details Forwarded Successfully');
    }

    public function newcar_step4($id){
      DB::table('car_notifications')
                ->where('car_id', $id)
                ->update(['flag' => '0']);

      $vehicle=carRental::find($id);
      $vehicle->delete();
      return redirect()->back()->with('success', 'Car Details Deleted Successfully');
    }

    public function newcar2(Request $request){
    $vehicle_reg_no = strtoupper($request->input('vehicle_reg_no'));

    $validate=carRental::select('vehicle_reg_no')->where('vehicle_reg_no',$vehicle_reg_no)->where('flag','1')->value('vehicle_reg_no');


    if(is_null($validate)){
      $deactivated = carRental::where('vehicle_reg_no',$vehicle_reg_no)->where('flag','0')->first();
      if(is_null($deactivated)){
        $vehicle_model = $request->input('model');
        $vehicle_status = $request->input('vehicle_status');
        $hire_rate = $request->input('hire_rate');
        $data=array('vehicle_reg_no'=>$vehicle_reg_no,"vehicle_model"=>$vehicle_model,'vehicle_status'=>$vehicle_status, 'hire_rate'=>$hire_rate);
        DB::table('car_rentals')->insert($data);
      }
      else{
        $deactivated->flag = 1;
        $deactivated->hire_rate=$request->input('hire_rate');

        $deactivated->save();
      }

        return redirect()->back()->with('success', 'Car Details Added Successfully');
    }
    else{
      return redirect()->back()->with('errors', "This vehicle '$vehicle_reg_no'  could not be added because it already exists in the system");
    }

}



    public function CarApprovalResponse(Request $request)
    {
        if($request->get('approval_status')=='Rejected'){

            $car=carRental::where('id',$request->get('id'))->first();
            $car->stage=2;
            $car->rejected_by='DIRECTOR';
            $car->updated_at=Carbon::now()->toDateTimeString();
            $car->approval_remarks=$request->get('approval_remarks');
            $car->save();

            return redirect('/businesses/car_rental')
                ->with('success', 'Operation completed successfully');

        }else{

            $car=carRental::where('id',$request->get('id'))->first();
            $car->stage='1b';

            $car->updated_at=Carbon::now()->toDateTimeString();
            $car->save();

            return redirect('/businesses/car_rental')
                ->with('success', 'Operation completed successfully');
        }


    }


    public function CarSecondApprovalResponse(Request $request)
    {

        if($request->get('approval_status')=='Rejected'){

            $car=carRental::where('id',$request->get('id'))->first();
            $car->stage=2;

            $car->rejected_by='DVC';
            $car->updated_at=Carbon::now()->toDateTimeString();
            $car->approval_remarks=$request->get('approval_remarks');
            $car->save();

            return redirect('/businesses/car_rental')
                ->with('success', 'Operation completed successfully');

        }else{

            $car=carRental::where('id',$request->get('id'))->first();
            $car->stage=3;
            $car->edit_status=0;


            if($car->terminated_stage=='1'){

                $car->flag=0;
                $car->terminated_stage=0;

            }else{


            }



            $car->rejected_by=0;
            $car->updated_at=Carbon::now()->toDateTimeString();
            $car->save();

            return redirect('/businesses/car_rental')
                ->with('success', 'Operation completed successfully');
        }


    }



public function editcar(Request $request){
	$id=$request->get('id');
	$car=carRental::find($id);
	$car->vehicle_reg_no=$request->get('vehicle_reg_no');
	$car->vehicle_model=$request->get('model');
	$car->vehicle_status=$request->get('vehicle_status');
	$car->hire_rate=$request->get('hire_rate');
	$car->hire_status=$request->get('hire_status');

//    if($request->get('rejected_by')=='DVC'){
//
//        $car->stage='1b';
//    }else{
//
//        $car->stage=1;
//    }



    if($request->get('edit_case')=='True'){

            $car->edit_status=1;

    }else{


    }



    $car->stage=1;

	$car->save();
	return redirect()->back()->with('success', 'Car Details Edited Successfully');
}







public function deletecar($id){
    $car=carRental::find($id);
    $car->terminated_stage=1;
    $car->stage=1;
    $car->save();
    return redirect()->back()->with('success', 'Request Sent Successfully');

}



    public function deletecarPermanently($id){
        $car=carRental::where('id',$id)->delete();

        return redirect()->back()->with('success', 'Request Deleted Successfully');

    }


    public function revokeDeleteCar($id){

        $car=carRental::where('id',$id)->first();
        $car->stage=3;
        $car->terminated_stage=0;
        $car->rejected_by=0;
        $car->save();


        return redirect()->back()->with('success', 'Operation Completed Successfully');

    }


public function addcentre(Request $request){
 $centre_id=$request->get('costcentreid');
 $check=cost_centre::where('costcentre_id',$centre_id)->get();
 if(count($check)>0){
  return redirect()->back()->with('errors', "This cost centre '$centre_id' already exists");
 }
 else{
  $centre_name=$request->get('centrename');
     $cost_centre= new cost_centre();
     $cost_centre->costcentre_id=$centre_id;
     $cost_centre->costcentre=$centre_name;
     $cost_centre->division_id=$request->division_id;
     $cost_centre->status=1;
     $cost_centre->save();
  return redirect()->back()->with('success', 'Cost Centre Added Successfully');
 }
}

public function editcentre(Request $request){
  $id=$request->get('centreid');

    $cost_centre= cost_centre::find($id);
    $cost_centre->costcentre_id=$request->get('costcentre_id');
    $cost_centre->costcentre=$request->get('centrename');
    $cost_centre->division_id=$request->division_id;
    $cost_centre->save();



      return redirect()->back()->with('success', 'Cost Centre Details Edited Successfully');
}

public function deletecentre($id){
    $cost_centre= cost_centre::find($id);
    $cost_centre->status=0;
    $cost_centre->save();

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
      $data = hire_rate::select('hire_rate')->where('vehicle_model',$query)->where('flag','1')->value('hire_rate');

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
  $bookings=carContract::where('vehicle_reg_no',$_GET['vehicle_reg_no'])->whereDate('end_date','>=',date('Y-m-d'))->where('form_completion','1')->get();
  $bookings2=carContract::where('vehicle_reg_no',$_GET['vehicle_reg_no'])->whereDate('end_date','<',date('Y-m-d'))->where('form_completion','1')->get();
  $details=carRental::where('vehicle_reg_no',$_GET['vehicle_reg_no'])->get();
  return view('car_view_more')->with('ops',$ops)->with('bookings',$bookings)->with('details',$details)->with('bookings2',$bookings2);
 }

 public function viewMore2(){

  return View::make('car_expenditure_filtered');
 }

 public function viewMore3(){

  return View::make('car_booking_filtered2');
 }

 public function viewMore4(){

  return View::make('car_booking_filtered');
 }



    public function costCentresManagement(){

        $costcentres=cost_centre::orderBy('costcentre_id','asc')->where('status',1)->get();
        return view('cost_centres_management')->with('costcentres',$costcentres);
    }

    public function hireRatesManagement(){

        $rate=hire_rate::where('flag','1')->orderBy('vehicle_model','asc')->get();

        return view('hire_rates_management')->with('rate',$rate);
    }

}
