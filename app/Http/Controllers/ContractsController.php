<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use App\carContract;
use PDF;
use Riskihajar\Terbilang\Facades\Terbilang;

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
        $insurance_contracts=DB::table('insurance_contracts')->get();

        if(Auth::user()->role=='Transport Officer-CPTU'){
        $outbox=carContract::where('cptu_msg_status','outbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $inbox=carContract::where('cptu_msg_status','inbox')->where('form_completion','0')->orderBy('id','dsc')->get();
         $closed_act=carContract::where('form_completion','1')->wheredate('end_date','>=',date('Y-m-d'))->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('form_completion','1')->wheredate('end_date','<',date('Y-m-d'))->orderBy('id','dsc')->get();
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
         $closed_act=carContract::where('cost_centre',Auth::user()->cost_centre)->wheredate('end_date','>=',date('Y-m-d'))->where('form_completion','1')->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('cost_centre',Auth::user()->cost_centre)->wheredate('end_date','<',date('Y-m-d'))->where('form_completion','1')->orderBy('id','dsc')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
     }
      elseif(Auth::user()->role=='Accountant-Cost Centre'){
         $inbox=carContract::where('acc_msg_status','inbox')->where('cost_centre',Auth::user()->cost_centre)->where('form_completion','0')->orderBy('id','dsc')->get();
        $outbox=carContract::where('acc_msg_status','outbox')->where('cost_centre',Auth::user()->cost_centre)->where('form_completion','0')->orderBy('id','dsc')->get();
         $closed_act=carContract::where('cost_centre',Auth::user()->cost_centre)->wheredate('end_date','>=',date('Y-m-d'))->where('form_completion','1')->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('cost_centre',Auth::user()->cost_centre)->wheredate('end_date','<',date('Y-m-d'))->where('form_completion','1')->orderBy('id','dsc')->get();
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
        $closed_act=carContract::wheredate('end_date','>=',date('Y-m-d'))->where('form_completion','1')->orderBy('id','dsc')->get();
         $closed_inact=carContract::wheredate('end_date','<',date('Y-m-d'))->where('form_completion','1')->orderBy('id','dsc')->get();
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
        $closed_act=carContract::wheredate('end_date','>=',date('Y-m-d'))->where('form_completion','1')->orderBy('id','dsc')->get();
         $closed_inact=carContract::wheredate('end_date','<',date('Y-m-d'))->where('form_completion','1')->orderBy('id','dsc')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
      }

      elseif(Auth::user()->role=='Director DPDI'){
       $closed_act=carContract::where('form_completion','1')->wheredate('end_date','>=',date('Y-m-d'))->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('form_completion','1')->wheredate('end_date','<',date('Y-m-d'))->orderBy('id','dsc')->get();
         $outbox=carContract::where('cptu_msg_status','outbox')->where('form_completion','1')->orderBy('id','dsc')->get();
        $inbox=carContract::where('cptu_msg_status','inbox')->where('form_completion','1')->orderBy('id','dsc')->get();
      }

      else{
         $outbox=carContract::where('cptu_msg_status','outbox')->where('form_completion','1')->orderBy('id','dsc')->get();
        $inbox=carContract::where('cptu_msg_status','inbox')->where('form_completion','1')->orderBy('id','dsc')->get();
        $closed_act=carContract::where('form_completion','1')->wheredate('end_date','>=',date('Y-m-d'))->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('form_completion','1')->wheredate('end_date','<',date('Y-m-d'))->orderBy('id','dsc')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }

      }

        return view('contracts_management')->with('space_contracts',$space_contracts)->with('insurance_contracts',$insurance_contracts)->with('outbox',$outbox)->with('inbox',$inbox)->with('closed_inact',$closed_inact)->with('closed_act',$closed_act);

    }


    public function ContractDetails($contract_id)
    {
        $space_contract=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.contract_id',$contract_id)->get();
        $associated_invoices=DB::table('invoices')->where('contract_id',$contract_id)->get();

        return view('contract_details')->with('space_contract',$space_contract)->with('associated_invoices',$associated_invoices)->with('contract_id',$contract_id);

    }

    public function ContractDetailsInsurance($contract_id)
    {
        $insurance_contract=DB::table('insurance_contracts')->where('id',$contract_id)->get();
//        $associated_invoices=DB::table('insurance_invoices')->where('contract_id',$contract_id)->get();

        return view('contract_details_insurance')->with('insurance_contract',$insurance_contract)->with('contract_id',$contract_id);

    }



    public function autofillParameters(Request $request)
    {
        $insurance_parameters='';
        if($request->get('insurance_type')!=''){

            $insurance_parameters=DB::table('insurance')->select('price','commission','commission_percentage','insurance_currency')->where('class',$request->get('insurance_class'))->where('insurance_company',$request->get('insurance_company'))->where('insurance_type',$request->get('insurance_type'))->get();

        }elseif($request->get('insurance_type_na')!=''){
            $insurance_parameters=DB::table('insurance')->select('price','commission','commission_percentage','insurance_currency')->where('class',$request->get('insurance_class'))->where('insurance_company',$request->get('insurance_company'))->where('insurance_type',$request->get('insurance_type_na'))->get();

        }else{


        }

        return $insurance_parameters;

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

        if($request->get('submit')=='Save and print') {

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


                $rent_sqm="";

                if($request->get('rent_sqm')==''){
                    $rent_sqm='N/A';

                }else{

                    $rent_sqm=$request->get('rent_sqm');
                }


                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$request->get('vacation_season'),'academic_season'=>$request->get('academic_season')]
                );

            }else {

                if($request->get('company_name')=="") {



                    DB::table('clients')->insert(
                        ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $full_name, 'type' => $client_type,'contract'=>'Space']
                    );

                    $rent_sqm="";

                    if($request->get('rent_sqm')==''){
                        $rent_sqm='N/A';

                    }else{

                        $rent_sqm=$request->get('rent_sqm');
                    }


                    DB::table('space_contracts')->insert(
                        ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$request->get('vacation_season'),'academic_season'=>$request->get('academic_season')]
                    );

                } else {

                    DB::table('clients')->insert(
                        ['first_name' => $request->get('company_name'), 'last_name' => '', 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $request->get('company_name'), 'type' => $client_type,'contract'=>'Space']
                    );


                    $rent_sqm="";

                    if($request->get('rent_sqm')==''){
                        $rent_sqm='N/A';

                    }else{

                        $rent_sqm=$request->get('rent_sqm');
                    }


                    DB::table('space_contracts')->insert(
                        ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$request->get('vacation_season'),'academic_season'=>$request->get('academic_season')]
                    );


                }
            }



            $data = [

                'first_name'   => $request->get('first_name'),
                'last_name'   => $request->get('last_name'),
                'company_name'   => $request->get('company_name'),
                'client_type'   => $request->get('client_type'),
                'address'   => $request->get('address'),
                'phone_number'   => $request->get('phone_number'),
                'email'   => $request->get('email'),
                'major_industry'   => $request->get('major_industry'),
                'minor_industry'   => $request->get('minor_industry'),
                'location'   => $request->get('space_location'),
                'sub_location'   => $request->get('space_sub_location'),
                'academic_dependence'   => $request->get('academic_dependence'),
                'space_number'   => $request->get('space_id_contract'),
                'space_size'   => $request->get('space_size'),
                'has_water_bill'   => $request->get('has_water_bill'),
                'has_electricity_bill'   => $request->get('has_electricity_bill'),
                'start_date'   => $request->get('start_date'),
                'duration'   => $request->get('duration'),
                'duration_period'   => $request->get('duration_period'),
                'academic_season'   => $request->get('academic_season'),
                'vacation_season'   => $request->get('vacation_season'),
                'amount'   => $request->get('amount'),
                'rent_sqm'   => $request->get('rent_sqm'),
                'payment_cycle'   => $request->get('payment_cycle'),
                'escalation_rate'   => $request->get('escalation_rate'),
                'currency'   => $request->get('currency'),

            ];

            $pdf = PDF::loadView('space_contract_pdf',$data);

            return $pdf->stream();


        }else{

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


                $rent_sqm="";

                if($request->get('rent_sqm')==''){
                    $rent_sqm='N/A';

                }else{

                    $rent_sqm=$request->get('rent_sqm');
                }


                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$request->get('vacation_season'),'academic_season'=>$request->get('academic_season')]
                );

            }else {

                if($request->get('company_name')=="") {



                    DB::table('clients')->insert(
                        ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $full_name, 'type' => $client_type,'contract'=>'Space']
                    );

                    $rent_sqm="";

                    if($request->get('rent_sqm')==''){
                        $rent_sqm='N/A';

                    }else{

                        $rent_sqm=$request->get('rent_sqm');
                    }


                    DB::table('space_contracts')->insert(
                        ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$request->get('vacation_season'),'academic_season'=>$request->get('academic_season')]
                    );

                } else {

                    DB::table('clients')->insert(
                        ['first_name' => $request->get('company_name'), 'last_name' => '', 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $request->get('company_name'), 'type' => $client_type,'contract'=>'Space']
                    );


                    $rent_sqm="";

                    if($request->get('rent_sqm')==''){
                        $rent_sqm='N/A';

                    }else{

                        $rent_sqm=$request->get('rent_sqm');
                    }


                    DB::table('space_contracts')->insert(
                        ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$request->get('vacation_season'),'academic_season'=>$request->get('academic_season')]
                    );


                }
            }



            return redirect('/contracts_management')
                ->with('success', 'Contract created successfully');

        }


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


            $rent_sqm="";

            if($request->get('rent_sqm')==''){
                $rent_sqm='N/A';

            }else{

                $rent_sqm=$request->get('rent_sqm');
            }


            DB::table('space_contracts')->insert(
                ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$request->get('vacation_season'),'academic_season'=>$request->get('academic_season')]
            );

        }else {

            if($request->get('company_name')=="") {



                DB::table('clients')->insert(
                    ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $full_name, 'type' => $client_type,'contract'=>'Space']
                );

                $rent_sqm="";

                if($request->get('rent_sqm')==''){
                    $rent_sqm='N/A';

                }else{

                    $rent_sqm=$request->get('rent_sqm');
                }


                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$request->get('vacation_season'),'academic_season'=>$request->get('academic_season')]
                );

            } else {

                DB::table('clients')->insert(
                    ['first_name' => $request->get('company_name'), 'last_name' => '', 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $request->get('company_name'), 'type' => $client_type,'contract'=>'Space']
                );


                $rent_sqm="";

                if($request->get('rent_sqm')==''){
                    $rent_sqm='N/A';

                }else{

                    $rent_sqm=$request->get('rent_sqm');
                }


                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $request->get('amount'),'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate'),'programming_end_date'=>$programming_end_date,'programming_start_date' => $request->get('start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$request->get('vacation_season'),'academic_season'=>$request->get('academic_season')]
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

        DB::table('space_contracts')
            ->where('contract_id', $id)
            ->update(['reason_for_termination' => $request->get("reason_for_termination")]);


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

        if($request->get('submit')=='Save and print') {


            $end_date = "";
            if ($request->get('duration_period') == "Months") {
                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
                $monthsToAdd = $request->get('duration');
                $end_date = $end_date->addMonths($monthsToAdd);

            } elseif ($request->get('duration_period') == "Years") {

                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
                $yearsToAdd = $request->get('duration');
                $end_date = $end_date->addYears($yearsToAdd);
            } else {


            }


            if ($request->get('company_name') == "") {


                DB::table('clients')
                    ->where('client_id', $client_id)
                    ->update(['first_name' => $request->get('first_name')]);


                DB::table('clients')
                    ->where('client_id', $client_id)
                    ->update(['last_name' => $request->get('last_name')]);

                $full_name = $request->get('first_name') . ' ' . $request->get('last_name');

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

            if ($request->get('client_type') == 1) {
                $client_type = "Individual";

            } else {
                $client_type = "Company/Organization";
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

            $full_name = $request->get('first_name') . ' ' . $request->get('last_name');

            $old_full_name = DB::table('space_contracts')->where('contract_id', $contract_id)->value('full_name');

            if ($request->get('company_name') == "") {
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
                ->update(['academic_dependence' => $request->get('academic_dependence')]);


            if ($request->get('academic_dependence') == 'Yes') {
                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['academic_season' => $request->get('academic_season')]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['vacation_season' => $request->get('vacation_season')]);

                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['amount' => 0]);


            } elseif ($request->get('academic_dependence') == 'No') {

                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['amount' => $request->get('amount')]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['academic_season' => 0]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['vacation_season' => 0]);


            } else {


            }


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

            $daysToAdd = DB::table('payment_cycle_settings')->where('cycle', $request->get('payment_cycle'))->value('days');
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


            $rent_sqm = "";

            if ($request->get('rent_sqm') == '') {
                $rent_sqm = 'N/A';

            } else {

                $rent_sqm = $request->get('rent_sqm');
            }


            DB::table('space_contracts')
                ->where('contract_id', $contract_id)
                ->update(['rent_sqm' => $rent_sqm]);


            $data = [

                'first_name'   => $request->get('first_name'),
                'last_name'   => $request->get('last_name'),
                'company_name'   => $request->get('company_name'),
                'client_type'   => $request->get('client_type'),
                'address'   => $request->get('address'),
                'phone_number'   => $request->get('phone_number'),
                'email'   => $request->get('email'),
                'major_industry'   => $request->get('major_industry'),
                'minor_industry'   => $request->get('minor_industry'),
                'location'   => $request->get('space_location'),
                'sub_location'   => $request->get('space_sub_location'),
                'academic_dependence'   => $request->get('academic_dependence'),
                'space_number'   => $request->get('space_id_contract'),
                'space_size'   => $request->get('space_size'),
                'has_water_bill'   => $request->get('has_water_bill'),
                'has_electricity_bill'   => $request->get('has_electricity_bill'),
                'start_date'   => $request->get('start_date'),
                'duration'   => $request->get('duration'),
                'duration_period'   => $request->get('duration_period'),
                'academic_season'   => $request->get('academic_season'),
                'vacation_season'   => $request->get('vacation_season'),
                'amount'   => $request->get('amount'),
                'rent_sqm'   => $request->get('rent_sqm'),
                'payment_cycle'   => $request->get('payment_cycle'),
                'escalation_rate'   => $request->get('escalation_rate'),
                'currency'   => $request->get('currency'),

            ];

            $pdf = PDF::loadView('space_contract_pdf',$data);

            return $pdf->stream();


        }else{




            $end_date = "";
            if ($request->get('duration_period') == "Months") {
                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
                $monthsToAdd = $request->get('duration');
                $end_date = $end_date->addMonths($monthsToAdd);

            } elseif ($request->get('duration_period') == "Years") {

                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('start_date'));
                $yearsToAdd = $request->get('duration');
                $end_date = $end_date->addYears($yearsToAdd);
            } else {


            }


            if ($request->get('company_name') == "") {


                DB::table('clients')
                    ->where('client_id', $client_id)
                    ->update(['first_name' => $request->get('first_name')]);


                DB::table('clients')
                    ->where('client_id', $client_id)
                    ->update(['last_name' => $request->get('last_name')]);

                $full_name = $request->get('first_name') . ' ' . $request->get('last_name');

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

            if ($request->get('client_type') == 1) {
                $client_type = "Individual";

            } else {
                $client_type = "Company/Organization";
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

            $full_name = $request->get('first_name') . ' ' . $request->get('last_name');

            $old_full_name = DB::table('space_contracts')->where('contract_id', $contract_id)->value('full_name');

            if ($request->get('company_name') == "") {
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
                ->update(['academic_dependence' => $request->get('academic_dependence')]);


            if ($request->get('academic_dependence') == 'Yes') {
                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['academic_season' => $request->get('academic_season')]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['vacation_season' => $request->get('vacation_season')]);

                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['amount' => 0]);


            } elseif ($request->get('academic_dependence') == 'No') {

                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['amount' => $request->get('amount')]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['academic_season' => 0]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id)
                    ->update(['vacation_season' => 0]);


            } else {


            }


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

            $daysToAdd = DB::table('payment_cycle_settings')->where('cycle', $request->get('payment_cycle'))->value('days');
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


            $rent_sqm = "";

            if ($request->get('rent_sqm') == '') {
                $rent_sqm = 'N/A';

            } else {

                $rent_sqm = $request->get('rent_sqm');
            }


            DB::table('space_contracts')
                ->where('contract_id', $contract_id)
                ->update(['rent_sqm' => $rent_sqm]);


            return redirect('/contracts_management')
                ->with('success', 'Contract details edited successfully');



        }




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


        DB::table('insurance_contracts')
            ->where('id', $id)
            ->update(['reason_for_termination' => $request->get("reason_for_termination")]);


        return redirect('/contracts_management')
            ->with('success', 'Contract terminated successfully');


    }


    public function testing()
    {

        $pdf = PDF::loadView('insurance_contract_pdf');
        return $pdf->stream();
//        return view('invoice_pdf');

    }


    public function InsuranceContractForm()
    {

        $insurance_data=DB::table('insurance')->where('status',1)->get();
        return view('insurance_contract_form')->with('insurance_data',$insurance_data);
    }


    public function CreateInsuranceContract(Request $request)
    {

        if($request->get('submit')=='Save and print'){







            $end_date="";
            if($request->get('duration_period')=="Months"){
                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('commission_date'));
                $monthsToAdd = $request->get('duration');
                $end_date = $end_date->addMonths($monthsToAdd);

            }elseif($request->get('duration_period')=="Years"){

                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('commission_date'));
                $yearsToAdd = $request->get('duration');
                $end_date = $end_date->addYears($yearsToAdd);
            }else{


            }


            $vehicle_reg_var="";
            $vehicle_use_var="";
            $cover_note="";
            $sticker_no="";
            $value="";
            $mode_of_payment="";
            $first_installment="";
            $second_installment="";


            if($request->get('vehicle_registration_no')==""){
                $vehicle_reg_var='N/A';

            }else{

                $vehicle_reg_var=$request->get('vehicle_registration_no');

            }


            if($request->get('vehicle_use')==""){
                $vehicle_use_var='N/A';

            }else{

                $vehicle_use_var=$request->get('vehicle_use');

            }


            if($request->get('cover_note')==""){
                $cover_note='N/A';

            }else{

                $cover_note=$request->get('cover_note');

            }


            if($request->get('sticker_no')==""){
                $sticker_no='N/A';

            }else{

                $sticker_no=$request->get('sticker_no');

            }


            if($request->get('value')==""){
                $value='N/A';

            }else{

                $value=$request->get('value');

            }



            if($request->get('mode_payment')==""){
                $mode_of_payment='N/A';

            }else{

                $mode_of_payment=$request->get('mode_of_payment');

            }



            if($request->get('first_installment')==""){
                $first_installment='N/A';

            }else{

                $first_installment=$request->get('first_installment');

            }



            if($request->get('second_installment')==""){
                $second_installment='N/A';

            }else{

                $second_installment=$request->get('second_installment');

            }



if($request->get('mode_of_payment')=='By installment'){


    DB::table('insurance_contracts')->insert(
        ['vehicle_registration_no' => $vehicle_reg_var, 'vehicle_use' => $vehicle_use_var, 'principal' => $request->get('insurance_company'), 'insurance_type' => $request->get('insurance_type'), 'commission_date' => $request->get('commission_date'), 'end_date' => $end_date, 'sum_insured' => $request->get('sum_insured'), 'premium' => $request->get('premium'),'actual_ex_vat' => $request->get('actual_ex_vat'),'currency' => $request->get('currency'),'commission' => $request->get('commission'),'receipt_no' => $request->get('receipt_no'),'full_name' => $request->get('full_name'),'duration' => $request->get('duration'),'duration_period' => $request->get('duration_period'),'commission_percentage' => $request->get('commission_percentage'),'insurance_class' => $request->get('insurance_class'),'phone_number' => $request->get('phone_number'),'email' => $request->get('email'),'cover_note' => $cover_note,'sticker_no' => $sticker_no,'value' => $value,'mode_of_payment'   => $mode_of_payment,'first_installment'   => $first_installment,'second_installment'   => $second_installment]
    );


    $contract_id_created=DB::table('insurance_contracts')->orderBy('id','desc')->limit(1)->value('id');


    $period= date("d/m/Y",strtotime($request->get('commission_date'))).' to  '. date("d/m/Y",strtotime($end_date));





    $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


    $amount_in_words='';


    if($request->get('currency')=='TZS'){
        $amount_in_words=Terbilang::make($request->get('premium'),' TZS',' ');

    }if ($request->get('currency')=='USD'){

        $amount_in_words=Terbilang::make($request->get('premium'),' USD',' ');
    }

    else{


    }

    $today=date('Y-m-d');
    $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');


    DB::table('insurance_invoices')->insert(
        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'),'invoicing_period_end_date' => $end_date,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $request->get('full_name'),'debtor_address' => '','amount_to_be_paid' => $first_installment,'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>'','vrn'=>$vehicle_reg_var,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>$contract_id_created,'invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance fees','prepared_by'=>Auth::user()->name,'approved_by'=>Auth::user()->name]
    );


    $invoice_number_created_first_installment=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

    DB::table('invoice_notifications')->insert(
        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
    );



    DB::table('insurance_payments')->insert(
        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$first_installment,'currency_payments' => $request->get('currency'),'receipt_number' => '']
    );



    //For second installment
    DB::table('insurance_invoices')->insert(
        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'),'invoicing_period_end_date' => $end_date,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $request->get('full_name'),'debtor_address' => '','amount_to_be_paid' => $second_installment,'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>'','vrn'=>$vehicle_reg_var,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>$contract_id_created,'invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance fees','prepared_by'=>Auth::user()->name,'approved_by'=>Auth::user()->name]
    );


    $invoice_number_created_second_installment=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

    DB::table('invoice_notifications')->insert(
        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
    );



    DB::table('insurance_payments')->insert(
        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$second_installment,'currency_payments' => $request->get('currency'),'receipt_number' => '']
    );


}else{

    DB::table('insurance_contracts')->insert(
        ['vehicle_registration_no' => $vehicle_reg_var, 'vehicle_use' => $vehicle_use_var, 'principal' => $request->get('insurance_company'), 'insurance_type' => $request->get('insurance_type'), 'commission_date' => $request->get('commission_date'), 'end_date' => $end_date, 'sum_insured' => $request->get('sum_insured'), 'premium' => $request->get('premium'),'actual_ex_vat' => $request->get('actual_ex_vat'),'currency' => $request->get('currency'),'commission' => $request->get('commission'),'receipt_no' => $request->get('receipt_no'),'full_name' => $request->get('full_name'),'duration' => $request->get('duration'),'duration_period' => $request->get('duration_period'),'commission_percentage' => $request->get('commission_percentage'),'insurance_class' => $request->get('insurance_class'),'phone_number' => $request->get('phone_number'),'email' => $request->get('email'),'cover_note' => $cover_note,'sticker_no' => $sticker_no,'value' => $value,'mode_of_payment'   => $mode_of_payment,'first_installment'   => $first_installment,'second_installment'   => $second_installment]
    );


    $contract_id_created=DB::table('insurance_contracts')->orderBy('id','desc')->limit(1)->value('id');


    $period= date("d/m/Y",strtotime($request->get('commission_date'))).' to  '. date("d/m/Y",strtotime($end_date));





    $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


    $amount_in_words='';


    if($request->get('currency')=='TZS'){
        $amount_in_words=Terbilang::make($request->get('premium'),' TZS',' ');

    }if ($request->get('currency')=='USD'){

        $amount_in_words=Terbilang::make($request->get('premium'),' USD',' ');
    }

    else{


    }

    $today=date('Y-m-d');
    $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');


    DB::table('insurance_invoices')->insert(
        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'),'invoicing_period_end_date' => $end_date,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $request->get('full_name'),'debtor_address' => '','amount_to_be_paid' => $request->get('premium'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>'','vrn'=>$vehicle_reg_var,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>$contract_id_created,'invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance fees','prepared_by'=>Auth::user()->name,'approved_by'=>Auth::user()->name]
    );


    $invoice_number_created=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

    DB::table('invoice_notifications')->insert(
        ['invoice_id' => $invoice_number_created, 'invoice_category' => 'insurance']
    );



    DB::table('insurance_payments')->insert(
        ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$request->get('premium'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
    );


}






            $data = [
                'insurance_class'   => $request->get('insurance_class'),
                'insurance_type'   => $request->get('insurance_type'),
                'insurance_company'   => $request->get('insurance_company'),
                'vehicle_registration_no'   => $request->get('vehicle_registration_no'),
                'vehicle_use'   => $request->get('vehicle_use'),
                'client_name'   => $request->get('full_name'),
                'phone_number'   => $request->get('phone_number'),
                'email'   => $request->get('email'),
                'commission_date'   => $request->get('commission_date'),
                'sum_insured'   => $request->get('sum_insured'),
                'premium'   => $request->get('premium'),
                'mode_of_payment'   => $request->get('mode_of_payment'),
                'first_installment'   => $request->get('first_installment'),
                'second_installment'   => $request->get('second_installment'),
                'actual_ex_vat'   => $request->get('actual_ex_vat'),
                'value'   => $request->get('value'),
                'commission_percentage'   => $request->get('commission_percentage'),
                'commission'   => $request->get('commission'),
                'cover_note'   => $request->get('cover_note'),
                'sticker_no'   => $request->get('sticker_no'),
                'receipt_no'   => $request->get('receipt_no'),
                'currency'   => $request->get('currency'),

            ];

            $pdf = PDF::loadView('insurance_contract_pdf',$data);

            return $pdf->stream();




        }else{


            $end_date="";
            if($request->get('duration_period')=="Months"){
                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('commission_date'));
                $monthsToAdd = $request->get('duration');
                $end_date = $end_date->addMonths($monthsToAdd);

            }elseif($request->get('duration_period')=="Years"){

                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('commission_date'));
                $yearsToAdd = $request->get('duration');
                $end_date = $end_date->addYears($yearsToAdd);
            }else{


            }


            $vehicle_reg_var="";
            $vehicle_use_var="";
            $cover_note="";
            $sticker_no="";
            $value="";
            $mode_of_payment="";
            $first_installment="";
            $second_installment="";

            if($request->get('vehicle_registration_no')==""){
                $vehicle_reg_var='N/A';

            }else{

                $vehicle_reg_var=$request->get('vehicle_registration_no');

            }


            if($request->get('vehicle_use')==""){
                $vehicle_use_var='N/A';

            }else{

                $vehicle_use_var=$request->get('vehicle_use');

            }


            if($request->get('cover_note')==""){
                $cover_note='N/A';

            }else{

                $cover_note=$request->get('cover_note');

            }


            if($request->get('sticker_no')==""){
                $sticker_no='N/A';

            }else{

                $sticker_no=$request->get('sticker_no');

            }


            if($request->get('value')==""){
                $value='N/A';

            }else{

                $value=$request->get('value');

            }


            if($request->get('mode_payment')==""){
                $mode_of_payment='N/A';

            }else{

                $mode_of_payment=$request->get('mode_of_payment');

            }



            if($request->get('first_installment')==""){
                $first_installment='N/A';

            }else{

                $first_installment=$request->get('first_installment');

            }



            if($request->get('second_installment')==""){
                $second_installment='N/A';

            }else{

                $second_installment=$request->get('second_installment');

            }



            if($request->get('mode_of_payment')=='By installment'){


                DB::table('insurance_contracts')->insert(
                    ['vehicle_registration_no' => $vehicle_reg_var, 'vehicle_use' => $vehicle_use_var, 'principal' => $request->get('insurance_company'), 'insurance_type' => $request->get('insurance_type'), 'commission_date' => $request->get('commission_date'), 'end_date' => $end_date, 'sum_insured' => $request->get('sum_insured'), 'premium' => $request->get('premium'),'actual_ex_vat' => $request->get('actual_ex_vat'),'currency' => $request->get('currency'),'commission' => $request->get('commission'),'receipt_no' => $request->get('receipt_no'),'full_name' => $request->get('full_name'),'duration' => $request->get('duration'),'duration_period' => $request->get('duration_period'),'commission_percentage' => $request->get('commission_percentage'),'insurance_class' => $request->get('insurance_class'),'phone_number' => $request->get('phone_number'),'email' => $request->get('email'),'cover_note' => $cover_note,'sticker_no' => $sticker_no,'value' => $value,'mode_of_payment'   => $mode_of_payment,'first_installment'   => $first_installment,'second_installment'   => $second_installment]
                );


                $contract_id_created=DB::table('insurance_contracts')->orderBy('id','desc')->limit(1)->value('id');


                $period= date("d/m/Y",strtotime($request->get('commission_date'))).' to  '. date("d/m/Y",strtotime($end_date));





                $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


                $amount_in_words='';


                if($request->get('currency')=='TZS'){
                    $amount_in_words=Terbilang::make($request->get('premium'),' TZS',' ');

                }if ($request->get('currency')=='USD'){

                    $amount_in_words=Terbilang::make($request->get('premium'),' USD',' ');
                }

                else{


                }

                $today=date('Y-m-d');
                $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');


                DB::table('insurance_invoices')->insert(
                    ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'),'invoicing_period_end_date' => $end_date,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $request->get('full_name'),'debtor_address' => '','amount_to_be_paid' => $first_installment,'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>'','vrn'=>$vehicle_reg_var,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>$contract_id_created,'invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance fees','prepared_by'=>Auth::user()->name,'approved_by'=>Auth::user()->name]
                );


                $invoice_number_created_first_installment=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                DB::table('invoice_notifications')->insert(
                    ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                );



                DB::table('insurance_payments')->insert(
                    ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$first_installment,'currency_payments' => $request->get('currency'),'receipt_number' => '']
                );



                //For second installment
                DB::table('insurance_invoices')->insert(
                    ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'),'invoicing_period_end_date' => $end_date,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $request->get('full_name'),'debtor_address' => '','amount_to_be_paid' => $second_installment,'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>'','vrn'=>$vehicle_reg_var,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>$contract_id_created,'invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance fees','prepared_by'=>Auth::user()->name,'approved_by'=>Auth::user()->name]
                );


                $invoice_number_created_second_installment=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                DB::table('invoice_notifications')->insert(
                    ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                );



                DB::table('insurance_payments')->insert(
                    ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$second_installment,'currency_payments' => $request->get('currency'),'receipt_number' => '']
                );


            }else{

                DB::table('insurance_contracts')->insert(
                    ['vehicle_registration_no' => $vehicle_reg_var, 'vehicle_use' => $vehicle_use_var, 'principal' => $request->get('insurance_company'), 'insurance_type' => $request->get('insurance_type'), 'commission_date' => $request->get('commission_date'), 'end_date' => $end_date, 'sum_insured' => $request->get('sum_insured'), 'premium' => $request->get('premium'),'actual_ex_vat' => $request->get('actual_ex_vat'),'currency' => $request->get('currency'),'commission' => $request->get('commission'),'receipt_no' => $request->get('receipt_no'),'full_name' => $request->get('full_name'),'duration' => $request->get('duration'),'duration_period' => $request->get('duration_period'),'commission_percentage' => $request->get('commission_percentage'),'insurance_class' => $request->get('insurance_class'),'phone_number' => $request->get('phone_number'),'email' => $request->get('email'),'cover_note' => $cover_note,'sticker_no' => $sticker_no,'value' => $value,'mode_of_payment'   => $mode_of_payment,'first_installment'   => $first_installment,'second_installment'   => $second_installment]
                );


                $contract_id_created=DB::table('insurance_contracts')->orderBy('id','desc')->limit(1)->value('id');


                $period= date("d/m/Y",strtotime($request->get('commission_date'))).' to  '. date("d/m/Y",strtotime($end_date));





                $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


                $amount_in_words='';


                if($request->get('currency')=='TZS'){
                    $amount_in_words=Terbilang::make($request->get('premium'),' TZS',' ');

                }if ($request->get('currency')=='USD'){

                    $amount_in_words=Terbilang::make($request->get('premium'),' USD',' ');
                }

                else{


                }

                $today=date('Y-m-d');
                $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');


                DB::table('insurance_invoices')->insert(
                    ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'),'invoicing_period_end_date' => $end_date,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $request->get('full_name'),'debtor_address' => '','amount_to_be_paid' => $request->get('premium'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>'','vrn'=>$vehicle_reg_var,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>$contract_id_created,'invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance fees','prepared_by'=>Auth::user()->name,'approved_by'=>Auth::user()->name]
                );


                $invoice_number_created=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                DB::table('invoice_notifications')->insert(
                    ['invoice_id' => $invoice_number_created, 'invoice_category' => 'insurance']
                );



                DB::table('insurance_payments')->insert(
                    ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$request->get('premium'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
                );


            }





            return redirect('/contracts_management')
                ->with('success', 'Contract created successfully');

        }


    }


    public function OnFlyInsuranceContractForm(Request $request,$id)
    {

        $insurance_data=DB::table('insurance')->where('status',1)->where('id',$id)->get();
        return view('insurance_contract_form_onfly')->with('insurance_data',$insurance_data);


    }



    public function EditInsuranceContractForm(Request $request,$id)
    {


        $insurance_data=DB::table('insurance')->where('status',1)->get();
        $contract_data=DB::table('insurance_contracts')->where('id',$id)->get();

        return view('insurance_contract_form_edit')->with('insurance_data',$insurance_data)->with('contract_id',$id)->with('contract_data',$contract_data);
    }


    public function RenewInsuranceContractForm($id)
    {

        $contract_data=DB::table('insurance_contracts')->where('id',$id)->get();

        return view('insurance_contract_form_renew')->with('contract_id',$id)->with('contract_data',$contract_data);
    }


    public function EditInsuranceContractFinalProcessing(Request $request,$contract_id)
    {


        if($request->get('submit')=='Save and print') {


            $end_date = "";
            if ($request->get('duration_period') == "Months") {
                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('commission_date'));
                $monthsToAdd = $request->get('duration');
                $end_date = $end_date->addMonths($monthsToAdd);

            } elseif ($request->get('duration_period') == "Years") {

                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('commission_date'));
                $yearsToAdd = $request->get('duration');
                $end_date = $end_date->addYears($yearsToAdd);
            } else {


            }


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['principal' => $request->get('insurance_company')]);

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
                ->update(['commission_percentage' => $request->get('commission_percentage')]);


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['duration' => $request->get('duration')]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['duration_period' => $request->get('duration_period')]);


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['phone_number' => $request->get('phone_number')]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['email' => $request->get('email')]);


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['insurance_class' => $request->get('insurance_class')]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['receipt_no' => $request->get('receipt_no')]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['full_name' => $request->get('full_name')]);


            $vehicle_reg_var = "";
            $vehicle_use_var = "";

            $value = "";
            $sticker_no = "";
            $cover_note = "";


            if ($request->get('vehicle_registration_no') == "") {
                $vehicle_reg_var = 'N/A';

            } else {

                $vehicle_reg_var = $request->get('vehicle_registration_no');

            }


            if ($request->get('vehicle_use') == "") {
                $vehicle_use_var = 'N/A';

            } else {

                $vehicle_use_var = $request->get('vehicle_use');

            }


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['vehicle_use' => $vehicle_use_var]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['vehicle_registration_no' => $vehicle_reg_var]);


            if ($request->get('cover_note') == "") {
                $cover_note = 'N/A';

            } else {

                $cover_note = $request->get('cover_note');

            }


            if ($request->get('sticker_no') == "") {
                $sticker_no = 'N/A';

            } else {

                $sticker_no = $request->get('sticker_no');

            }


            if ($request->get('value') == "") {
                $value = 'N/A';

            } else {

                $value = $request->get('value');

            }


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['value' => $value]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['sticker_no' => $sticker_no]);


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['cover_note' => $cover_note]);



            $data = [
                'insurance_class'   => $request->get('insurance_class'),
                'insurance_type'   => $request->get('insurance_type'),
                'insurance_company'   => $request->get('insurance_company'),
                'vehicle_registration_no'   => $request->get('vehicle_registration_no'),
                'vehicle_use'   => $request->get('vehicle_use'),
                'client_name'   => $request->get('full_name'),
                'phone_number'   => $request->get('phone_number'),
                'email'   => $request->get('email'),
                'commission_date'   => $request->get('commission_date'),
                'sum_insured'   => $request->get('sum_insured'),
                'premium'   => $request->get('premium'),
                'mode_of_payment'   => $request->get('mode_of_payment'),
                'first_installment'   => $request->get('first_installment'),
                'second_installment'   => $request->get('second_installment'),
                'actual_ex_vat'   => $request->get('actual_ex_vat'),
                'value'   => $request->get('value'),
                'commission_percentage'   => $request->get('commission_percentage'),
                'commission'   => $request->get('commission'),
                'cover_note'   => $request->get('cover_note'),
                'sticker_no'   => $request->get('sticker_no'),
                'receipt_no'   => $request->get('receipt_no'),
                'currency'   => $request->get('currency'),

            ];

            $pdf = PDF::loadView('insurance_contract_pdf',$data);

            return $pdf->stream();




//            return redirect('/contracts_management')
//                ->with('success', 'Contract details edited successfully');






        }else{



            $end_date = "";
            if ($request->get('duration_period') == "Months") {
                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('commission_date'));
                $monthsToAdd = $request->get('duration');
                $end_date = $end_date->addMonths($monthsToAdd);

            } elseif ($request->get('duration_period') == "Years") {

                $end_date = Carbon::createFromFormat('Y-m-d', $request->get('commission_date'));
                $yearsToAdd = $request->get('duration');
                $end_date = $end_date->addYears($yearsToAdd);
            } else {


            }


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['principal' => $request->get('insurance_company')]);

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
                ->update(['commission_percentage' => $request->get('commission_percentage')]);


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['duration' => $request->get('duration')]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['duration_period' => $request->get('duration_period')]);


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['phone_number' => $request->get('phone_number')]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['email' => $request->get('email')]);


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['insurance_class' => $request->get('insurance_class')]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['receipt_no' => $request->get('receipt_no')]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['full_name' => $request->get('full_name')]);


            $vehicle_reg_var = "";
            $vehicle_use_var = "";

            $value = "";
            $sticker_no = "";
            $cover_note = "";


            if ($request->get('vehicle_registration_no') == "") {
                $vehicle_reg_var = 'N/A';

            } else {

                $vehicle_reg_var = $request->get('vehicle_registration_no');

            }


            if ($request->get('vehicle_use') == "") {
                $vehicle_use_var = 'N/A';

            } else {

                $vehicle_use_var = $request->get('vehicle_use');

            }


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['vehicle_use' => $vehicle_use_var]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['vehicle_registration_no' => $vehicle_reg_var]);


            if ($request->get('cover_note') == "") {
                $cover_note = 'N/A';

            } else {

                $cover_note = $request->get('cover_note');

            }


            if ($request->get('sticker_no') == "") {
                $sticker_no = 'N/A';

            } else {

                $sticker_no = $request->get('sticker_no');

            }


            if ($request->get('value') == "") {
                $value = 'N/A';

            } else {

                $value = $request->get('value');

            }


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['value' => $value]);

            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['sticker_no' => $sticker_no]);


            DB::table('insurance_contracts')
                ->where('id', $contract_id)
                ->update(['cover_note' => $cover_note]);


            return redirect('/contracts_management')
                ->with('success', 'Contract details edited successfully');




        }
    }



}
