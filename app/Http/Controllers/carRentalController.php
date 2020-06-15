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
}
