<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
    public function SpaceContractsManagement()
    {
        $space_contracts=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','space_contracts.space_id_contract','=','spaces.space_id')->where('space_contracts.contract_status',1)->WhereDate('end_date','>',date('Y-m-d'))->get();
        $space_contracts_inactive=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','space_contracts.space_id_contract','=','spaces.space_id')->where('space_contracts.contract_status',0)->orWhereDate('end_date','<',date('Y-m-d'))->get();

        return view('space_contracts_management')->with('space_contracts',$space_contracts)->with('space_contracts_inactive',$space_contracts_inactive);

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
    $programming_end_date='';
        //for programming purposes
        if($request->get('payment_cycle')=='Monthly') {

            $programming_end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $daysToAdd = 30;
            $programming_end_date = $programming_end_date->addDays($daysToAdd);


        }elseif($request->get('payment_cycle')=='Yearly'){

            $programming_end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $daysToAdd = 365;
            $programming_end_date = $programming_end_date->addDays($daysToAdd);


        }else{


        }


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
                ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $request->get('end_date'),'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $programming_end_date,'programming_start_date' => $request->get('start_date')]
            );

        }else {

            if($request->get('company_name')=="") {



                DB::table('clients')->insert(
                    ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'type' => $request->get('type'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $full_name, 'type' => $client_type,'contract'=>'Space']
                );




                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $request->get('end_date'),'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date')]
                );

            } else {

                DB::table('clients')->insert(
                    ['first_name' => $request->get('company_name'), 'last_name' => '', 'type' => $request->get('type'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $request->get('company_name'), 'type' => $client_type,'contract'=>'Space']
                );





                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $request->get('end_date'),'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date')]
                );


            }
        }



        return redirect('/space_contracts_management')
            ->with('success', 'Contract created successfully');
    }







    public function RenewSpaceContract(Request $request,$id)
    {

        DB::table('space_contracts')->where('contract_id', $id)->delete();


        $programming_end_date='';
        //for programming purposes
        if($request->get('payment_cycle')=='Monthly') {

            $programming_end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $daysToAdd = 30;
            $programming_end_date = $programming_end_date->addDays($daysToAdd);


        }elseif($request->get('payment_cycle')=='Yearly'){

            $programming_end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $daysToAdd = 365;
            $programming_end_date = $programming_end_date->addDays($daysToAdd);


        }else{


        }


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
                ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $request->get('end_date'),'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $programming_end_date,'programming_start_date' => $request->get('start_date')]
            );

        }else {

            if($request->get('company_name')=="") {



                DB::table('clients')->insert(
                    ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'type' => $request->get('type'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $full_name, 'type' => $client_type,'contract'=>'Space']
                );




                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $request->get('end_date'),'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date')]
                );

            } else {

                DB::table('clients')->insert(
                    ['first_name' => $request->get('company_name'), 'last_name' => '', 'type' => $request->get('type'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $request->get('company_name'), 'type' => $client_type,'contract'=>'Space']
                );





                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $request->get('end_date'),'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date')]
                );


            }
        }



        return redirect('/space_contracts_management')
            ->with('success', 'Contract created successfully');
    }






    public function terminateSpaceContract(Request $request,$id)
    {

            DB::table('space_contracts')
                ->where('contract_id', $id)
                ->update(['contract_status' => 0]);

            return redirect('/space_contracts_management')
                ->with('success', 'Contract terminated successfully');


    }

    public function EditSpaceContractForm(Request $request,$id)
    {

        $contract_data = DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_id', $id)->get();

        $client_id = DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_id', $id)->value('clients.client_id');

        return view('space_contract_form_edit')->with('contract_data',$contract_data)->with('contract_id',$id)->with('client_id',$client_id);
    }


    public function EditSpaceContractFinalProcessing(Request $request,$contract_id,$client_id)
    {

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
            ->update(['end_date' => $request->get('end_date')]);

//for programming purposes
        if($request->get('payment_cycle')=='Monthly') {

            $programming_end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $daysToAdd = 30;
            $programming_end_date = $programming_end_date->addDays($daysToAdd);


            DB::table('space_contracts')
                ->where('contract_id', $contract_id)
                ->update(['programming_end_date' => $programming_end_date]);

            DB::table('space_contracts')
                ->where('contract_id', $contract_id)
                ->update(['programming_start_date' => $request->get('start_date')]);



        }elseif($request->get('payment_cycle')=='Yearly'){

            $programming_end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
            $daysToAdd = 365;
            $programming_end_date = $programming_end_date->addDays($daysToAdd);

            DB::table('space_contracts')
                ->where('contract_id', $contract_id)
                ->update(['programming_end_date' => $programming_end_date]);


            DB::table('space_contracts')
                ->where('contract_id', $contract_id)
                ->update(['programming_start_date' => $request->get('start_date')]);





        }else{


        }




        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['escalation_rate' => $request->get('escalation_rate')]);




        return redirect('/space_contracts_management')
            ->with('success', 'Contract details edited successfully');
    }



    //insurance contracts

    public function InsuranceContractsManagement()
    {
        $insurance_contracts=DB::table('insurance_contracts')->where('contract_status',1)->where('expiry_status',1)->get();

        return view('insurance_contracts_management')->with('insurance_contracts',$insurance_contracts);
    }





    public function terminateInsuranceContract(Request $request,$id)
    {



        DB::table('insurance_contracts')
            ->where('id', $id)
            ->update(['contract_status' => 0]);

        return redirect('/insurance_contracts_management')
            ->with('success', 'Contract terminated successfully');


    }


    public function InsuranceContractForm()
    {

        $insurance_data=DB::table('insurance')->where('status',1)->get();
        return view('insurance_contract_form')->with('insurance_data',$insurance_data);
    }


    public function CreateInsuranceContract(Request $request)
    {


        DB::table('insurance_contracts')->insert(
            ['vehicle_registration_no' => $request->get('vehicle_registration_no'), 'vehicle_use' => $request->get('vehicle_use'), 'principal' => $request->get('principal'), 'insurance_type' => $request->get('insurance_type'), 'commission_date' => $request->get('commission_date'), 'end_date' => $request->get('end_date'), 'sum_insured' => $request->get('sum_insured'), 'premium' => $request->get('premium'),'actual_ex_vat' => $request->get('actual_ex_vat'),'currency' => $request->get('currency'),'commission' => $request->get('commission'),'receipt_no' => $request->get('receipt_no'),'full_name' => $request->get('full_name')]
        );





        return redirect('/insurance_contracts_management')
            ->with('success', 'Contract created successfully');
    }


    public function EditInsuranceContractForm(Request $request,$id)
    {


        $insurance_data=DB::table('insurance')->where('status',1)->get();
        $contract_data=DB::table('insurance_contracts')->where('id',$id)->get();

        return view('insurance_contract_form_edit')->with('insurance_data',$insurance_data)->with('contract_id',$id)->with('contract_data',$contract_data);
    }


    public function EditInsuranceContractFinalProcessing(Request $request,$contract_id)
    {

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
            ->update(['end_date' => $request->get('end_date')]);

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



        return redirect('/insurance_contracts_management')
            ->with('success', 'Contract details edited successfully');
    }



}
