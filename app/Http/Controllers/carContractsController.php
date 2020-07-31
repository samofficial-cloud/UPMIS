<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\carContract;
use App\client;
use PDF;
use Auth;

class carContractsController extends Controller
{
    //
    public function index(){
        if(Auth::user()->role=='CPTU staff'){
        $outbox=carContract::where('cptu_msg_status','outbox')->where('form_completion','0')->get();
        $inbox=carContract::where('cptu_msg_status','inbox')->where('form_completion','0')->get();
        $closed=carContract::where('form_completion','1')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
        return view ('car_contracts2')->with('outbox',$outbox)->with('inbox',$inbox)->with('closed',$closed);
     }
     elseif(Auth::user()->role=='Vote Holder'){
        $inbox=carContract::where('head_msg_status','inbox')->where('form_completion','0')->get();
        $outbox=carContract::where('head_msg_status','outbox')->where('form_completion','0')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
        return view('car_contracts3')->with('inbox',$inbox)->with('outbox',$outbox);
     }
      elseif(Auth::user()->role=='Accountant'){
         $inbox=carContract::where('acc_msg_status','inbox')->where('form_completion','0')->get();
        $outbox=carContract::where('acc_msg_status','outbox')->where('form_completion','0')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
        return view('car_contracts4')->with('inbox',$inbox)->with('outbox',$outbox);
      }
       elseif(Auth::user()->role=='Head of CPTU'){
         $inbox=carContract::where('head_cptu_msg_status','inbox')->where('form_completion','0')->get();
        $outbox=carContract::where('head_cptu_msg_status','outbox')->where('form_completion','0')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
        return view('car_contracts5')->with('inbox',$inbox)->with('outbox',$outbox);
      }

      elseif(Auth::user()->role=='DVC Administrator'){
         $inbox=carContract::where('dvc_msg_status','inbox')->where('form_completion','0')->get();
        $outbox=carContract::where('dvc_msg_status','outbox')->where('form_completion','0')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
        return view('car_contracts6')->with('inbox',$inbox)->with('outbox',$outbox);
      }

    }

    public function addContractFormA(){
        
         return view('carRentalForm2');        	
    }

    public function addContractFormB($id){
        $contract=carContract::find($id);
         return view('carRentalFormB1')->with('contract',$contract);         
    }

    public function addContractFormC($id){
        $contract=carContract::find($id);
         return view('carRentalFormB2')->with('contract',$contract);         
    }

    public function addContractFormD($id){
        $contract=carContract::find($id);
         return view('carRentalFormB3')->with('contract',$contract);         
    }

    public function addContractFormD1($id){
        $contract=carContract::find($id);
         return view('carRentalFormB31')->with('contract',$contract);         
    }

    public function addContractFormE($id){
        $contract=carContract::find($id);
         return view('carRentalFormB4')->with('contract',$contract);         
    }

    // public function addContractForm(){
    //     return view('carRentalForm2');
    // }

    public function newContractA(Request $request){
    $first_name = $request->input('first_name');
    $last_name = $request->input('last_name');
    $full_name=$first_name. ' '.$last_name;
        DB::table('car_contracts')->insert(
                    ['fullName' => $full_name, 'area_of_travel' => $request->get('area'), 'faculty' => $request->get('faculty_name'), 'cost_centre' => $request->get('centre_name'),'designation' => $request->get('designation'), 'start_date' => $request->get('start_date'), 'end_date' => $request->get('end_date'), 'start_time' => $request->get('start_time'), 'end_time' => $request->get('end_time'),'overtime'=>$request->get('overtime'), 'destination'=>$request->get('destination'), 'purpose'=>$request->get('purpose'), 'trip_nature'=>$request->get('trip_nature'), 'estimated_distance'=>$request->get('estimated_distance'), 'estimated_cost'=>$request->get('estimated_cost'), 'form_initiator' => Auth::user()->name, 'cptu_msg_status'=>'outbox', 'form_status'=>'Vote Holder', 'head_msg_status'=> 'inbox', 'form_completion'=>'0', 'email'=> $request->get('email'), 'first_name'=> $request->input('first_name'), 'last_name'=> $request->input('last_name')]
                );
        DB::table('notifications')->insert(['role'=>'Vote Holder', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract']);
        return redirect()->route('carContracts')->with('success', 'Details Forwaded Successfully');
    }

    public function newContractB(Request $request){
        $id=$request->get('contract_id');
        DB::table('car_contracts')
                ->where('id', $id)
                ->update(['transport_code' => $request->get('code_no')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['funds_available' => $request->get('fund_available')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['balance_status' => $request->get('balance_status')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['vote_title' => $request->get('vote_holder')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['fund_committed' => $request->get('commited_fund')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['acc_name' => $request->get('approve_name')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['acc_date' => $request->get('approve_date')]);

                 DB::table('car_contracts')
                ->where('id', $id)
                ->update(['head_msg_status' => 'outbox']);

                 DB::table('car_contracts')
                ->where('id', $id)
                ->update(['form_status' => 'Accountant']);

                 DB::table('car_contracts')
                ->where('id', $id)
                ->update(['acc_msg_status' => 'inbox']);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['vote_remarks' =>  $request->get('vote_remarks')]);

                 DB::table('notifications')->insert(['role'=>'Accountant', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);


                 return redirect()->route('carContracts')->with('success', 'Details Forwaded Successfully');
    }

    public function newContractC(Request $request){
        $id=$request->get('contract_id');
        $area=carContract::select('area_of_travel')->where('id',$id)->value('area_of_travel');

        DB::table('car_contracts')
                ->where('id', $id)
                ->update(['transport_code' => $request->get('code_no')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['funds_available' => $request->get('fund_available')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['balance_status' => $request->get('balance_status')]);
                
                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['head_name' => $request->get('head_name')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['head_date' => $request->get('head_date')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['head_approval_status' => $request->get('head_approval_status')]);

              DB::table('car_contracts')
                ->where('id', $id)
                ->update(['acc_msg_status' => 'outbox']);

                if($request->get('head_approval_status')=='Rejected'){
                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['form_status' => 'Vote Holder']); 

                 DB::table('car_contracts')
                ->where('id', $id)
                ->update(['head_msg_status' => 'inbox']);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['acc_remark' => $request->get('acc_remark')]);

                 DB::table('notifications')->insert(['role'=>'Vote Holder', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);

                }
                else{
                   if($area=='Within'){
                  DB::table('car_contracts')
                ->where('id', $id)
                ->update(['form_status' => 'Head of CPTU']);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['head_cptu_msg_status' => 'inbox']);

                 DB::table('notifications')->insert(['role'=>'Head of CPTU', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);
                }

                elseif($area=='Outside'){

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['form_status' => 'DVC Administrator']);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['dvc_msg_status' => 'inbox']);

                 DB::table('notifications')->insert(['role'=>'DVC Administrator', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);
                } 
                }
                

                return redirect()->route('carContracts')->with('success', 'Details Forwaded Successfully');

      }

      public function newContractD(Request $request){
        $id=$request->get('contract_id');
        DB::table('car_contracts')
                ->where('id', $id)
                ->update(['head_cptu_name' => $request->get('head_cptu_name')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['head_cptu_date' => $request->get('head_cptu_date')]);

                // DB::table('car_contracts')
                // ->where('id', $id)
                // ->update(['head_cptu_approval_status' => $request->get('head_cptu_approval_status')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['vehicle_reg_no' => $request->get('vehicle_reg')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['head_cptu_msg_status' => 'outbox']);

                  DB::table('car_contracts')
                ->where('id', $id)
                ->update(['cptu_msg_status' => 'inbox']);

                 DB::table('car_contracts')
                ->where('id', $id)
                ->update(['form_status' => 'CPTU Staff']);

                 DB::table('notifications')->insert(['role'=>'CPTU Staff', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);

                return redirect()->route('carContracts')->with('success', 'Details Forwaded Successfully');

              }

               public function newContractD1(Request $request){
        $id=$request->get('contract_id');
        DB::table('car_contracts')
                ->where('id', $id)
                ->update(['dvc_name' => $request->get('head_cptu_name')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['dvc_date' => $request->get('head_cptu_date')]);

                // DB::table('car_contracts')
                // ->where('id', $id)
                // ->update(['dvc_approval_status' => $request->get('head_cptu_approval_status')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['vehicle_reg_no' => $request->get('vehicle_reg')]);

                DB::table('car_contracts')
                ->where('id', $id)
                ->update(['dvc_msg_status' => 'outbox']);

                  DB::table('car_contracts')
                ->where('id', $id)
                ->update(['cptu_msg_status' => 'inbox']);

                 DB::table('car_contracts')
                ->where('id', $id)
                ->update(['form_status' => 'CPTU Staff']);

                 DB::table('notifications')->insert(['role'=>'CPTU Staff', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);

                return redirect()->route('carContracts')->with('success', 'Details Forwaded Successfully');

              }

        public function newContractE(Request $request){
        $id=$request->get('contract_id');
        DB::table('car_contracts')
                ->where('id', $id)
                ->update(['initial_speedmeter' => $request->get('speedmeter_km')]);

          DB::table('car_contracts')
           ->where('id', $id)
           ->update(['initial_speedmeter_time' => $request->get('speedmeter_time')]);

            DB::table('car_contracts')
                ->where('id', $id)
                ->update(['ending_speedmeter' => $request->get('end_speedmeter_km')]);

          DB::table('car_contracts')
           ->where('id', $id)
           ->update(['ending_speedmeter_time' => $request->get('end_speedmeter_time')]);

            DB::table('car_contracts')
           ->where('id', $id)
           ->update(['overtime_hrs' => $request->get('end_overtime')]);
            
            DB::table('car_contracts')
           ->where('id', $id)
           ->update(['driver_name' => $request->get('driver_name')]);

           DB::table('car_contracts')
           ->where('id', $id)
           ->update(['driver_date' => $request->get('driver_date')]);

           DB::table('car_contracts')
           ->where('id', $id)
           ->update(['charge_km' => $request->get('charge_km')]);

           DB::table('car_contracts')
           ->where('id', $id)
           ->update(['mileage_km' => $request->get('mileage_km')]);

           DB::table('car_contracts')
           ->where('id', $id)
           ->update(['mileage_tshs' => $request->get('mileage_tshs')]);

           DB::table('car_contracts')
           ->where('id', $id)
           ->update(['penalty_hrs' => $request->get('penalty_hrs')]);

           DB::table('car_contracts')
           ->where('id', $id)
           ->update(['overtime_charges' => $request->get('overtime_charges')]);

           DB::table('car_contracts')
           ->where('id', $id)
           ->update(['total_charges' => $request->get('total_charges')]);

           DB::table('car_contracts')
           ->where('id', $id)
           ->update(['standing_charges' => $request->get('standing_charges')]);

           DB::table('car_contracts')
           ->where('id', $id)
           ->update(['grand_total' => $request->get('grand_total')]);

            DB::table('car_contracts')
           ->where('id', $id)
           ->update(['form_completion' => '1']);

           return redirect()->route('carContracts')->with('success', 'Details submitted Successfully');

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

   //create invoice



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
public function printContractForm(){
    $pdf=PDF::loadView('carcontractspdf');    
    return $pdf->stream('Vehicle Requistion Form.pdf');
}
}
