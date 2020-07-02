<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $space_contracts=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.contract_status',1)->where('space_contracts.expiry_status',1)->get();

        return view('space_contracts_management')->with('space_contracts',$space_contracts);

    }

    public function SpaceContractForm()
    {

        return view('space_contract_form');
    }

    public function CreateSpaceContract(Request $request)
    {

        if($request->get('client_type')==1){
            $client_type="Individual";

        }else{
            $client_type="Company/Organization";
        }


        $full_name=$request->get('first_name').' '.$request->get('last_name');

        if(DB::table('clients')->where('full_name',$full_name)->count()>0){

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['address' => $request->get('address')]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['email' => $request->get('email')]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['phone_number' => $request->get('phone_number')]);

        }else {

            if($request->get('company_name')=="") {
                DB::table('clients')->insert(
                    ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'type' => $request->get('type'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $full_name, 'type' => $client_type]
                );


                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $request->get('end_date'),'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate')]
                );

            } else {

                DB::table('clients')->insert(
                    ['first_name' => $request->get('company_name'), 'last_name' => '', 'type' => $request->get('type'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $request->get('company_name'), 'type' => $client_type]
                );

                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $request->get('end_date'),'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate')]
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



        DB::table('space_contracts')
            ->where('contract_id', $contract_id)
            ->update(['escalation_rate' => $request->get('escalation_rate')]);




        return redirect('/space_contracts_management')
            ->with('success', 'Contract details edited successfully');
    }



}
