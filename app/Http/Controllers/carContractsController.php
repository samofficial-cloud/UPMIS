<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\carContract;
use App\client;

class carContractsController extends Controller
{
    //
    public function index(){
    	$contracts=carContract::select('clients.type','clients.first_name','clients.last_name', 'clients.address','clients.email', 'clients.phone_number', 'car_contracts.vehicle_reg_no', 'car_contracts.start_date', 'car_contracts.end_date', 'car_contracts.amount', 'car_contracts.rate', 'car_contracts.fullName', 'car_contracts.id', 'car_rentals.vehicle_model', 'car_rentals.vehicle_status', 'car_rentals.hire_rate','car_contracts.special_condition', 'car_contracts.currency')
    	->join('clients', 'clients.full_name', '=', 'car_contracts.fullName')
        ->join('car_rentals', 'car_rentals.vehicle_reg_no', '=', 'car_contracts.vehicle_reg_no')
    	->where('clients.contract', 'Car Rental')
        ->where('car_contracts.flag','1')
        ->WhereDate('end_date','>',date('Y-m-d'))
        ->orderBy('car_contracts.fullName','asc')
    	->get();

        $inactive_contracts=carContract::select('clients.type','clients.first_name','clients.last_name', 'clients.address','clients.email', 'clients.phone_number', 'car_contracts.vehicle_reg_no', 'car_contracts.start_date', 'car_contracts.end_date', 'car_contracts.amount', 'car_contracts.rate', 'car_contracts.fullName', 'car_contracts.id', 'car_rentals.vehicle_model', 'car_rentals.vehicle_status', 'car_rentals.hire_rate','car_contracts.special_condition', 'car_contracts.currency','car_contracts.flag')
        ->join('clients', 'clients.full_name', '=', 'car_contracts.fullName')
        ->join('car_rentals', 'car_rentals.vehicle_reg_no', '=', 'car_contracts.vehicle_reg_no')
        ->where('clients.contract', 'Car Rental')
        ->where('car_contracts.flag','0')
        ->orWhereDate('end_date','<',date('Y-m-d'))
        ->orderBy('car_contracts.fullName','asc')
        ->get();
    	return view ('car_contracts')->with('contracts', $contracts)->with('inactive_contracts',$inactive_contracts);
    }

    public function addContractForm(){
    	return view('carRentalForm');
    }

    public function newContract(Request $request){
    $client_typ = $request->input('client_type');
    if($client_typ=='1'){
    	$client_type='Individual';
    }
    else if($client_typ=='2'){
    	$client_type='Company';
    }
    $first_name = $request->input('first_name');
    $last_name = $request->input('last_name');
    $company_name=$request->input('company_name');
    $email=$request->input('email');
    $phone_number = $request->input('phone_number');
    $address = $request->input('address');
    $vehicle_reg_no = $request->input('vehicle_reg');
     $condition = $request->input('condition');
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $rate = $request->input('rate');
    $amount = $request->input('amount');
    $contract_type="Car Rental";
    $currency=$request->input('currency');
    $full_name=$first_name. ' '.$last_name;
    
   if($client_type=='Individual'){
    $contract_data=array('fullName'=>$first_name. ' '.$last_name,"vehicle_reg_no"=>$vehicle_reg_no,'start_date'=>$start_date, 'end_date'=>$end_date, 'special_condition'=>$condition, 'rate'=>$rate, 'amount'=>$amount, 'currency'=>$currency);

    $validate=client::where('full_name',$full_name)->where('contract',$contract_type)->get();

    if (count($validate)>0) {
        DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['address' => $address]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['email' => $email]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['phone_number' => $phone_number]);
    }

    else{
    $client_data=array('first_name'=>$first_name,"last_name"=>$last_name,'address'=>$address, 'email'=>$email, 'phone_number'=>$phone_number, 'type'=>$client_type, 'full_name'=>$first_name. ' '.$last_name, 'contract'=>$contract_type);
    DB::table('clients')->insert($client_data);
}

}

   else if($client_type=='Company'){
    $contract_data=array('fullName'=>$company_name,"vehicle_reg_no"=>$vehicle_reg_no,'start_date'=>$start_date, 'end_date'=>$end_date, 'special_condition'=>$condition, 'rate'=>$rate, 'amount'=>$amount, 'currency'=>$currency);


$validate2=client::where('full_name',$company_name)->where('contract',$contract_type)->get();

   if (count($validate2)>0) {
      DB::table('clients')
                ->where('full_name', $company_name)
                ->update(['address' => $address]);

            DB::table('clients')
                ->where('full_name', $company_name)
                ->update(['email' => $email]);

            DB::table('clients')
                ->where('full_name', $company_name)
                ->update(['phone_number' => $phone_number]);
    }

    else {
    $client_data=array('full_name'=>$company_name,'address'=>$address, 'email'=>$email, 'phone_number'=>$phone_number, 'type'=>$client_type, 'contract'=>$contract_type, 'company _name'=>$company_name);
    DB::table('clients')->insert($client_data);
}

}

    

    DB::table('car_contracts')->insert($contract_data);

   return redirect()->route('carContracts')->with('success', 'Contract Added Successfully');

}

public function editContractForm($id){
    $contract=carContract::select('clients.type','clients.first_name','clients.last_name', 'clients.address','clients.email', 'clients.phone_number', 'clients.client_id', 'car_contracts.vehicle_reg_no', 'car_contracts.start_date', 'car_contracts.end_date', 'car_contracts.amount', 'car_contracts.rate', 'car_contracts.fullName', 'car_contracts.id', 'car_rentals.vehicle_model', 'car_rentals.vehicle_status', 'car_rentals.hire_rate', 'car_contracts.special_condition', 'car_contracts.id','car_contracts.currency')
        ->join('clients', 'clients.full_name', '=', 'car_contracts.fullName')
        ->join('car_rentals', 'car_rentals.vehicle_reg_no', '=', 'car_contracts.vehicle_reg_no')
        ->where('clients.contract', 'Car Rental')
        ->where('car_contracts.id',$id)
        ->first();
        return view('editcarrentalform')->with('contract',$contract);

}

public function editcontract(Request $request){
    $contract_id=$request->input('contract_id');
    $client_id=$request->input('client_id');
    $client_typ = $request->input('client_type');
    $client= client::find($client_id);
    if($client_typ=='1'){
     $client->type='Individual';
     $client->first_name=$request->input('first_name');
     $client->last_name=$request->input('last_name');
     $client->full_name=$request->input('first_name').' '.$request->input('last_name');
     $newfullName=$request->input('first_name').' '.$request->input('last_name');
     $client->company_name=NULL;
    }
    elseif($client_typ=='2'){
     $client->type='Company';
     $client->company_name=$request->input('company_name');
     $client->full_name=$request->input('company_name');
     $client->first_name=NULL;
     $client->last_name=NULL;
     $newfullName=$request->input('company_name');
    }
    
    $client->address=$request->input('address');
    $client->phone_number=$request->input('phone_number');
    $client->email=$request->input('email');
   
    $client->save();
    $contract=carContract::find($contract_id);
    $fullNames=$contract->fullName;
    $contract->vehicle_reg_no=$request->input('vehicle_reg');
    $contract->special_condition=$request->input('condition');
    $contract->start_date=$request->input('start_date');
    $contract->end_date=$request->input('end_date');
    $contract->rate = $request->input('rate');
    $contract->amount = $request->input('amount');
    $contract->currency=$request->input('currency');
    $contract->save();

    DB::table('car_contracts')->where(['fullName' => $fullNames])->update(['fullName' => $newfullName]);

    return redirect()->route('carContracts')->with('success', 'Contract Details Edited Successfully');
}
public function deletecontract($id){
    $contract=carContract::find($id);
    $contract->flag=0;
    $contract->save();
    return redirect()->back()->with('success', 'Contract Deleted Successfully');

}

public function renewContractForm($id){
  $contract=carContract::select('clients.type','clients.first_name','clients.last_name', 'clients.address','clients.email', 'clients.phone_number', 'clients.client_id', 'car_contracts.vehicle_reg_no', 'car_contracts.start_date', 'car_contracts.end_date', 'car_contracts.amount', 'car_contracts.rate', 'car_contracts.fullName', 'car_contracts.id', 'car_rentals.vehicle_model', 'car_rentals.vehicle_status', 'car_rentals.hire_rate', 'car_contracts.special_condition', 'car_contracts.id','car_contracts.currency')
        ->join('clients', 'clients.full_name', '=', 'car_contracts.fullName')
        ->join('car_rentals', 'car_rentals.vehicle_reg_no', '=', 'car_contracts.vehicle_reg_no')
        ->where('clients.contract', 'Car Rental')
        ->where('car_contracts.id',$id)
        ->first();
        return view('renewCarrentalform')->with('contract',$contract);
}
}
