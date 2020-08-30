<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use App\carContract;

class ContractsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function ContractsManagement()
    {
        $space_contracts=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','space_contracts.space_id_contract','=','spaces.space_id')->get();
//        $space_contracts_inactive=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','space_contracts.space_id_contract','=','spaces.space_id')->where('space_contracts.contract_status',0)->orWhereDate('end_date','<',date('Y-m-d'))->get();
        $insurance_contracts=DB::table('insurance_contracts')->where('contract_status',1)->where('expiry_status',1)->get();

        if(Auth::user()->role=='CPTU staff'){
        $outbox=carContract::where('cptu_msg_status','outbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $inbox=carContract::where('cptu_msg_status','inbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $closed=carContract::where('form_completion','1')->orderBy('id','dsc')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
     }
     elseif(Auth::user()->role=='Vote Holder'){
        $inbox=carContract::where('head_msg_status','inbox')->where('cost_centre',Auth::user()->cost_centre)->where('form_completion','0')->orderBy('id','dsc')->get();
        $outbox=carContract::where('head_msg_status','outbox')->where('cost_centre',Auth::user()->cost_centre)->where('form_completion','0')->orderBy('id','dsc')->get();
         $closed=carContract::where('cost_centre',Auth::user()->cost_centre)->where('form_completion','1')->orderBy('id','dsc')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
     }
      elseif(Auth::user()->role=='Accountant'){
         $inbox=carContract::where('acc_msg_status','inbox')->where('cost_centre',Auth::user()->cost_centre)->where('form_completion','0')->orderBy('id','dsc')->get();
        $outbox=carContract::where('acc_msg_status','outbox')->where('cost_centre',Auth::user()->cost_centre)->where('form_completion','0')->orderBy('id','dsc')->get();
         $closed=carContract::where('cost_centre',Auth::user()->cost_centre)->where('form_completion','1')->orderBy('id','dsc')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
      }
      elseif(Auth::user()->role=='Head of CPTU'){
         $inbox=carContract::where('head_cptu_msg_status','inbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $outbox=carContract::where('head_cptu_msg_status','outbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $closed=carContract::where('form_completion','1')->orderBy('id','dsc')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
      }
      elseif(Auth::user()->role=='DVC Administrator'){
         $inbox=carContract::where('dvc_msg_status','inbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $outbox=carContract::where('dvc_msg_status','outbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $closed=carContract::where('form_completion','1')->orderBy('id','dsc')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
      }

        return view('contracts_management')->with('space_contracts',$space_contracts)->with('insurance_contracts',$insurance_contracts)->with('outbox',$outbox)->with('inbox',$inbox)->with('closed',$closed);

    }


    public function ContractDetails($contract_id)
    {
        $space_contract=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.contract_id',$contract_id)->get();
        $associated_invoices=DB::table('invoices')->where('contract_id',$contract_id)->get();

        return view('contract_details')->with('space_contract',$space_contract)->with('associated_invoices',$associated_invoices)->with('contract_id',$contract_id);

    }


    public function SpaceContractForm()
    {

        return view('space_contract_form');
    }


    public function renewSpaceContractForm(Request $request,$id)
    {
        $contract_data = DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_id', $id)->get();

        $client_id = DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_id', $id)->value('clients.client_id');

        return view('space_contract_form_renew')->with('contract_data',$contract_data)->with('contract_id',$id)->with('client_id',$client_id);

    }

    public function CreateSpaceContract(Request $request)
    {
        $end_date="";
        if($request->get('duration_period')=="Months"){
            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $monthsToAdd = $request->get('duration');
            $end_date = $end_date->addMonths($monthsToAdd);

        }elseif($request->get('duration_period')=="Years"){

            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $yearsToAdd = $request->get('duration');
            $end_date = $end_date->addYears($yearsToAdd);
        }else{


        }




    $programming_end_date='';
        //for programming purposes



            $programming_end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));

            $daysToAdd = DB::table('payment_cycle_settings')->where('cycle',$request->get('payment_cycle'))->value('days');
            $programming_end_date = $programming_end_date->addDays($daysToAdd);







        if($request->get('client_type')==1){
            $client_type="Individual";
            $full_name=$request->get('first_name').' '.$request->get('last_name');


        }else{
            $client_type="Company/Organization";
            $full_name=$request->get('company_name');
        }




        if(DB::table('clients')->where('full_name',$full_name)->where('contract','Space')->count()>0){

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['address' => $request->get('address')]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['email' => $request->get('email')]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['phone_number' => $request->get('phone_number')]);





            DB::table('space_contracts')->insert(
                ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period')]
            );

        }else {

            if($request->get('company_name')=="") {



                DB::table('clients')->insert(
                    ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $full_name, 'type' => $client_type,'contract'=>'Space']
                );




                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period')]
                );

            } else {

                DB::table('clients')->insert(
                    ['first_name' => $request->get('company_name'), 'last_name' => '', 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $request->get('company_name'), 'type' => $client_type,'contract'=>'Space']
                );





                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period')]
                );


            }
        }



        return redirect('/contracts_management')
            ->with('success', 'Contract created successfully');
    }







    public function RenewSpaceContract(Request $request,$id)
    {

        $end_date="";
        if($request->get('duration_period')=="Months"){
            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $monthsToAdd = $request->get('duration');
            $end_date = $end_date->addMonths($monthsToAdd);

        }elseif($request->get('duration_period')=="Years"){

            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $yearsToAdd = $request->get('duration');
            $end_date = $end_date->addYears($yearsToAdd);
        }else{


        }




        DB::table('space_contracts')->where('contract_id', $id)->delete();


        $programming_end_date='';
        //for programming purposes
        $programming_end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));

        $daysToAdd = DB::table('payment_cycle_settings')->where('cycle',$request->get('payment_cycle'))->value('days');
        $programming_end_date = $programming_end_date->addDays($daysToAdd);



        if($request->get('client_type')==1){
            $client_type="Individual";
            $full_name=$request->get('first_name').' '.$request->get('last_name');


        }else{
            $client_type="Company/Organization";
            $full_name=$request->get('company_name');
        }




        if(DB::table('clients')->where('full_name',$full_name)->where('contract','Space')->count()>0){

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['address' => $request->get('address')]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['email' => $request->get('email')]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['phone_number' => $request->get('phone_number')]);





            DB::table('space_contracts')->insert(
                ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period')]
            );

        }else {

            if($request->get('company_name')=="") {



                DB::table('clients')->insert(
                    ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $full_name, 'type' => $client_type,'contract'=>'Space']
                );




                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period')]
                );

            } else {

                DB::table('clients')->insert(
                    ['first_name' => $request->get('company_name'), 'last_name' => '', 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $request->get('company_name'), 'type' => $client_type,'contract'=>'Space']
                );





                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period')]
                );


            }
        }



        return redirect('/contracts_management')
            ->with('success', 'Contract created successfully');
    }






    public function terminateSpaceContract(Request $request,$id)
    {

            DB::table('space_contracts')
                ->where('contract_id', $id)
                ->update(['contract_status' => 0]);

            return redirect('/contracts_management')
                ->with('success', 'Contract terminated successfully');


    }

    public function EditSpaceContractForm(Request $request,$id)
    {

        $contract_data = DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_id', $id)->get();

        $client_id = DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_id', $id)->value('clients.client_id');

        return view('space_contract_form_edit')->with('contract_data',$contract_data)->with('contract_id',$id)->with('client_id',$client_id);
    }



    public function OnFlySpaceContractForm(Request $request,$id)
    {

        $space_info=DB::table('spaces')->where('id',$id)->get();

        return view('space_contract_form_onfly')->with('space_info',$space_info);
    }


    public function EditSpaceContractFinalProcessing(Request $request,$contract_id,$client_id)
    {

        $end_date="";
        if($request->get('duration_period')=="Months"){
            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $monthsToAdd = $request->get('duration');
            $end_date = $end_date->addMonths($monthsToAdd);

        }elseif($request->get('duration_period')=="Years"){

            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $yearsToAdd = $request->get('duration');
            $end_date = $end_date->addYears($yearsToAdd);
        }else{


        }


        if($request->get('company_name')=="") {


            DB::table('clients')
                ->where('client_id', $client_id)
                ->update(['first_name' => $request->get('first_name')]);


            DB::table('clients')
                ->where('client_id', $client_id)
                ->update(['last_name' => $request->get('last_name')]);

            $full_name=$request->get('first_name').' '.$request->get('last_name');

            DB::table('clients')
                ->where('client_id', $client_id)
                ->update(['full_name' => $full_name]);


        } else {

            DB::table('clients')
                ->where('client_id', $client_id)
                ->update(['first_name' => $request->get('company_name')]);

            DB::table('clients')
                ->where('client_id', $client_id)
                ->update(['last_name' => '']);


            DB::table('clients')
                ->where('client_id', $client_id)
                ->update(['full_name' => $request->get('company_name')]);

        }

        if($request->get('client_type')==1){
            $client_type="Individual";

        }else{
            $client_type="Company/Organization";
        }


        DB::table('clients')
            ->where('client_id', $client_id)
            ->update(['type' => $client_type]);

        DB::table('clients')
            ->where('client_id', $client_id)
            ->update(['address' => $request->get('address')]);
        DB::table('clients')
            ->where('client_id', $client_id)
            ->update(['email' => $request->get('email')]);
        DB::table('clients')
            ->where('client_id', $client_id)
            ->update(['phone_number' => $request->get('phone_number')]);

        //SPACE CONTRACT STARTS

        $full_name=$request->get('first_name').' '.$request->get('last_name');

        $old_full_name=DB::table('space_contracts')->where('contract_id', $contract_id)->value('full_name');

        if($request->get('company_name')=="") {
            DB::table('space_contracts')
                ->where('full_name', $old_full_name)
                ->update(['full_name' => $full_name]);

        } else {

            DB::table('space_contracts')
                ->where('full_name', $old_full_name)
                ->update(['full_name' => $request->get('company_name')]);

        }

        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['space_id_contract' => $request->get('space_id_contract')]);

        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['amount' => $request->get('amount')]);


        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['currency' => $request->get('currency')]);

        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['payment_cycle' => $request->get('payment_cycle')]);


        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['start_date' => $request->get('start_date')]);


        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['end_date' => $end_date]);

        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['duration' => $request->get('duration')]);


        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['duration_period' => $request->get('duration_period')]);


        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['has_water_bill' => $request->get('has_water_bill')]);


        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['has_electricity_bill' => $request->get('has_electricity_bill')]);

//for programming purposes

        $programming_end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));

        $daysToAdd = DB::table('payment_cycle_settings')->where('cycle',$request->get('payment_cycle'))->value('days');
        $programming_end_date = $programming_end_date->addDays($daysToAdd);

        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['programming_end_date' => $programming_end_date]);


        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['programming_start_date' => $request->get('start_date')]);




        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['escalation_rate' => $request->get('escalation_rate')]);




        return redirect('/contracts_management')
            ->with('success', 'Contract details edited successfully');
    }



    //insurance contracts

//    public function InsuranceContractsManagement()
//    {
//        $insurance_contracts=DB::table('insurance_contracts')->where('contract_status',1)->where('expiry_status',1)->get();
//
//        return view('insurance_contracts_management')->with('insurance_contracts',$insurance_contracts);
//    }





    public function terminateInsuranceContract(Request $request,$id)
    {



        DB::table('insurance_contracts')
            ->where('id', $id)
            ->update(['contract_status' => 0]);

        return redirect('/contracts_management')
            ->with('success', 'Contract terminated successfully');


    }


    public function InsuranceContractForm()
    {

        $insurance_data=DB::table('insurance')->where('status',1)->get();
        return view('insurance_contract_form')->with('insurance_data',$insurance_data);
    }


    public function CreateInsuranceContract(Request $request)
    {

        $end_date="";
        if($request->get('duration_period')=="Months"){
            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $monthsToAdd = $request->get('duration');
            $end_date = $end_date->addMonths($monthsToAdd);

        }elseif($request->get('duration_period')=="Years"){

            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $yearsToAdd = $request->get('duration');
            $end_date = $end_date->addYears($yearsToAdd);
        }else{


        }



        DB::table('insurance_contracts')->insert(
            ['vehicle_registration_no' => $request->get('vehicle_registration_no'), 'vehicle_use' => $request->get('vehicle_use'), 'principal' => $request->get('principal'), 'insurance_type' => $request->get('insurance_type'), 'commission_date' => $request->get('commission_date'), 'end_date' => $end_date, 'sum_insured' => $request->get('sum_insured'), 'premium' => $request->get('premium'),'actual_ex_vat' => $request->get('actual_ex_vat'),'currency' => $request->get('currency'),'commission' => $request->get('commission'),'receipt_no' => $request->get('receipt_no'),'full_name' => $request->get('full_name')]
        );





        return redirect('/contracts_management')
            ->with('success', 'Contract created successfully');
    }


    public function OnFlyInsuranceContractForm(Request $request,$id)
    {

        $insurance_data=DB::table('insurance')->where('status',1)->get();
        return view('insurance_contract_form_onfly')->with('insurance_data',$insurance_data);


    }



    public function EditInsuranceContractForm(Request $request,$id)
    {


        $insurance_data=DB::table('insurance')->where('status',1)->get();
        $contract_data=DB::table('insurance_contracts')->where('id',$id)->get();

        return view('insurance_contract_form_edit')->with('insurance_data',$insurance_data)->with('contract_id',$id)->with('contract_data',$contract_data);
    }


    public function EditInsuranceContractFinalProcessing(Request $request,$contract_id)
    {
        $end_date="";
        if($request->get('duration_period')=="Months"){
            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $monthsToAdd = $request->get('duration');
            $end_date = $end_date->addMonths($monthsToAdd);

        }elseif($request->get('duration_period')=="Years"){

            $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $yearsToAdd = $request->get('duration');
            $end_date = $end_date->addYears($yearsToAdd);
        }else{


        }

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['vehicle_registration_no' => $request->get('vehicle_registration_no')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['vehicle_use' => $request->get('vehicle_use')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['principal' => $request->get('principal')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['insurance_type' => $request->get('insurance_type')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['commission_date' => $request->get('commission_date')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['end_date' => $end_date]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['sum_insured' => $request->get('sum_insured')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['premium' => $request->get('premium')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['actual_ex_vat' => $request->get('actual_ex_vat')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['currency' => $request->get('currency')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['commission' => $request->get('commission')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['receipt_no' => $request->get('receipt_no')]);

        DB::table('insurance_contracts')
            ->where('id', $contract_id)
            ->update(['full_name' => $request->get('full_name')]);



        return redirect('/contracts_management')
            ->with('success', 'Contract details edited successfully');
    }



}
