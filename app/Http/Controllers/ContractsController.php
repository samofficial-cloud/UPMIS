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
        $space_contracts=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.has_clients',1)->orWhere('space_contracts.under_client',0)->get();
//        $space_contracts_inactive=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','space_contracts.space_id_contract','=','spaces.space_id')->where('space_contracts.contract_status',0)->orWhereDate('end_date','<',date('Y-m-d'))->get();
        $insurance_contracts=DB::table('insurance_contracts')->get();

        $research_contracts=DB::table('research_flats_contracts')->get();

        if(Auth::user()->role=='Transport Officer-CPTU'){
        $outbox=carContract::where('cptu_msg_status','outbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $inbox=carContract::where('cptu_msg_status','inbox')->where('form_completion','0')->orderBy('id','dsc')->get();
         $closed_act=carContract::where('form_completion','1')->where('flag',1)->wheredate('end_date','>=',date('Y-m-d'))->orderBy('id','dsc')->get();

         $closed_inact=carContract::where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();


     }
     elseif(Auth::user()->role=='Vote Holder'){

        $inbox=carContract::where('head_msg_status','inbox')->where('cost_centre',Auth::user()->cost_centre)->where('form_completion','0')->orderBy('id','dsc')->get();
        $outbox=carContract::where('head_msg_status','outbox')->where('cost_centre',Auth::user()->cost_centre)->where('form_completion','0')->orderBy('id','dsc')->get();
         $closed_act=carContract::where('cost_centre',Auth::user()->cost_centre)->wheredate('end_date','>=',date('Y-m-d'))->where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('cost_centre',Auth::user()->cost_centre)->where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
        // foreach ($inbox as $msg) {
        //     # code...
        //      DB::table('notifications')
        //         ->where('contract_id', $msg->id)
        //         ->update(['flag' => '0']);

        // }
     }
      elseif(Auth::user()->role=='Accountant-Cost Centre'){
         $inbox=carContract::where('acc_msg_status','inbox')->where('cost_centre',Auth::user()->cost_centre)->where('form_completion','0')->orderBy('id','dsc')->get();
        $outbox=carContract::where('acc_msg_status','outbox')->where('cost_centre',Auth::user()->cost_centre)->where('form_completion','0')->orderBy('id','dsc')->get();
         $closed_act=carContract::where('cost_centre',Auth::user()->cost_centre)->wheredate('end_date','>=',date('Y-m-d'))->where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('cost_centre',Auth::user()->cost_centre)->where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
        // foreach ($inbox as $msg) {
        //     # code...
        //      DB::table('notifications')
        //         ->where('contract_id', $msg->id)
        //         ->update(['flag' => '0']);

        // }
      }
      elseif(Auth::user()->role=='Head of CPTU'){
         $inbox=carContract::where('head_cptu_msg_status','inbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $outbox=carContract::where('head_cptu_msg_status','outbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $closed_act=carContract::wheredate('end_date','>=',date('Y-m-d'))->where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
        // foreach ($inbox as $msg) {
        //     # code...
        //      DB::table('notifications')
        //         ->where('contract_id', $msg->id)
        //         ->update(['flag' => '0']);

        // }
      }
      elseif(Auth::user()->role=='DVC Administrator'){
         $inbox=carContract::where('dvc_msg_status','inbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $outbox=carContract::where('dvc_msg_status','outbox')->where('form_completion','0')->orderBy('id','dsc')->get();
        $closed_act=carContract::wheredate('end_date','>=',date('Y-m-d'))->where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
        // foreach ($inbox as $msg) {
        //     # code...
        //      DB::table('notifications')
        //         ->where('contract_id', $msg->id)
        //         ->update(['flag' => '0']);

        // }
      }

      elseif(Auth::user()->role=='Director DPDI'){
       $closed_act=carContract::where('form_completion','1')->wheredate('end_date','>=',date('Y-m-d'))->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('form_completion','1')->orderBy('id','dsc')->get();
         $outbox=carContract::where('cptu_msg_status','outbox')->where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
        $inbox=carContract::where('cptu_msg_status','inbox')->where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
      }

      else{
         $outbox=carContract::where('cptu_msg_status','outbox')->where('form_completion','1')->orderBy('id','dsc')->get();
        $inbox=carContract::where('cptu_msg_status','inbox')->where('form_completion','1')->orderBy('id','dsc')->get();
        $closed_act=carContract::where('form_completion','1')->where('flag',1)->orderBy('id','dsc')->get();
         $closed_inact=carContract::where('form_completion','1')->where('flag',1)->wheredate('end_date','<',date('Y-m-d'))->orderBy('id','dsc')->get();
        // foreach ($inbox as $msg) {
        //     # code...
        //      DB::table('notifications')
        //         ->where('contract_id', $msg->id)
        //         ->update(['flag' => '0']);

        // }

      }

        return view('contracts_management')->with('space_contracts',$space_contracts)->with('insurance_contracts',$insurance_contracts)->with('outbox',$outbox)->with('inbox',$inbox)->with('closed_inact',$closed_inact)->with('closed_act',$closed_act)->with('research_contracts',$research_contracts);

    }




    public function SpaceContractsSubClientsManagement($client_id)
    {
        $space_contracts=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.parent_client',$client_id)->get();

        $parent_client_name=DB::table('clients')->where('client_id',$client_id)->value('full_name');


        return view('contracts_management_subclients')->with('space_contracts',$space_contracts)->with('parent_client_name',$parent_client_name);

    }



    public function ContractDetails($contract_id)
    {
        $decrypted_contract_id=base64_decode(base64_decode(base64_decode($contract_id)));

        $space_contract=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.contract_id',$decrypted_contract_id)->get();
        $associated_invoices=DB::table('invoices')->where('contract_id',$decrypted_contract_id)->get();

        return view('contract_details')->with('space_contract',$space_contract)->with('associated_invoices',$associated_invoices);

    }


    public function SpaceDetails($space_id)
    {
        $space=DB::table('spaces')->where('space_id',$space_id)->get();
        return view('space_details')->with('space',$space);

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

            $insurance_parameters=DB::table('insurance')->select('commission_percentage')->where('class',$request->get('insurance_class'))->where('insurance_company',$request->get('insurance_company'))->where('insurance_type',$request->get('insurance_type'))->get();

        }elseif($request->get('insurance_type_na')!=''){
            $insurance_parameters=DB::table('insurance')->select('commission_percentage')->where('class',$request->get('insurance_class'))->where('insurance_company',$request->get('insurance_company'))->where('insurance_type',$request->get('insurance_type_na'))->get();

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

        $has_clients=null;
        $under_client=null;

        if($request->get('client_type_contract')=='Direct'){
            $has_clients=0;
            $under_client=0;

        }elseif ($request->get('client_type_contract')=='Direct and has clients'){

            $has_clients=1;
            $under_client=0;
        }elseif($request->get('client_type_contract')=='Indirect'){
            $has_clients=0;
            $under_client=1;

        }else{


        }



        if($request->get('submit')=='Save and print') {

            $end_date="";
            //for viewing pdf
            $brela_registration_path=null;
            $tbs_certificates_path=null;
            $gpsa_certificates_path=null;
            $business_licenses_path=null;
            $food_business_licenses_path=null;
            $osha_certificates_path=null;
            $tcra_registration_path=null;


            //for saving only
            $brela_registration_path2=null;
            $tbs_certificates_path2=null;
            $gpsa_certificates_path2=null;
            $business_licenses_path2=null;
            $food_business_licenses_path2=null;
            $osha_certificates_path2=null;
            $tcra_registration_path2=null;




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


            $programming_end_date = $programming_end_date->addMonths($request->get('payment_cycle'));







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



                DB::table('clients')
                    ->where('full_name', $full_name)
                    ->update(['official_client_id' => $request->get('official_client_id')]);



                DB::table('clients')
                    ->where('full_name', $full_name)
                    ->update(['tin' => $request->get('tin')]);



                $rent_sqm="";

                if($request->get('rent_sqm')==''){
                    $rent_sqm='N/A';

                }else{

                    $rent_sqm=$request->get('rent_sqm');
                }




                $amount_total=$request->get('amount')+$request->get('additional_businesses_amount');
                $academic_season_total=$request->get('academic_season')+$request->get('additional_businesses_amount');
                $vacation_season_total=$request->get('vacation_season')+$request->get('additional_businesses_amount');

                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $amount_total,'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $request->get('invoicing_period_end_date'),'programming_start_date' => $request->get('invoicing_period_start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$vacation_season_total,'academic_season'=>$academic_season_total,'tbs_certificate'=>$tbs_certificates_path,'gpsa_certificate'=>$gpsa_certificates_path,'food_business_license'=>$gpsa_certificates_path,'business_license'=>$business_licenses_path,'osha_certificate'=>$osha_certificates_path,'tcra_registration'=>$tcra_registration_path,'brela_registration'=>$brela_registration_path,'contract_category'=>$request->get('contract_category'),'has_additional_businesses'=>$request->get('has_additional_businesses'),'additional_businesses_amount'=>$request->get('additional_businesses_amount'),'additional_businesses_list'=>$request->get('additional_businesses_list'),'security_deposit'=>$request->get('security_deposit'),'has_clients'=>$has_clients,'under_client'=>$under_client,'has_additional_businesses'=>$request->get('has_additional_businesses'),'additional_businesses_amount'=>$request->get('additional_businesses_amount'),'additional_businesses_list'=>$request->get('additional_businesses_list'),'security_deposit'=>$request->get('security_deposit'),'has_clients'=>$has_clients,'under_client'=>$under_client,'parent_client'=>$request->get('parent_client'),'client_type_contract'=>$request->get('client_type_contract')]
                );



                //file management starts

                $contract_id_created=DB::table('space_contracts')->orderBy('contract_id','desc')->limit(1)->value('contract_id');

                if($request->hasfile('tbs_certificate')){
                    $file=$request->file('tbs_certificate');
                    $filename=$request->file('tbs_certificate')->getClientOriginalName();
                    $tbs_certificates_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'tbs_certificate.pdf';
                    $tbs_certificates_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($tbs_certificates_path2,'tbs_certificate.pdf');

                }

                if($request->hasfile('gpsa_certificate')){
                    $file=$request->file('gpsa_certificate');
                    $filename=$request->file('gpsa_certificate')->getClientOriginalName();
                    $gpsa_certificates_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'gpsa_certificate.pdf';
                    $gpsa_certificates_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($gpsa_certificates_path2,'gpsa_certificate.pdf');

                }



                if($request->hasfile('food_business_license')){
                    $file=$request->file('food_business_license');
                    $filename=$request->file('food_business_license')->getClientOriginalName();
                    $food_business_licenses_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'food_business_license.pdf';
                    $food_business_licenses_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($food_business_licenses_path2,'food_business_license.pdf');

                }

                if($request->hasfile('business_license')){

                    $file=$request->file('business_license');
                    $filename=$request->file('business_license')->getClientOriginalName();
                    $business_licenses_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'business_license.pdf';
                    $business_licenses_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';

                    $file->move($business_licenses_path2,'business_license.pdf');

                }



                if($request->hasfile('osha_certificate')){
                    $file=$request->file('osha_certificate');
                    $filename=$request->file('osha_certificate')->getClientOriginalName();
                    $osha_certificates_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'osha_certificate.pdf';
                    $osha_certificates_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($osha_certificates_path2,'osha_certificate.pdf');

                }



                if($request->hasfile('tcra_registration')){
                    $file=$request->file('tcra_registration');
                    $filename=$request->file('tcra_registration')->getClientOriginalName();
                    $tcra_registration_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'tcra_registration.pdf';
                    $tcra_registration_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($tcra_registration_path2,'tcra_registration.pdf');

                }

                if($request->hasfile('brela_registration')){
                    $file=$request->file('brela_registration');
                    $filename=$request->file('brela_registration')->getClientOriginalName();
                    $brela_registration_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'brela_registration.pdf';
                    $brela_registration_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($brela_registration_path2,'brela_registration.pdf');

                }


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['tbs_certificate' => $tbs_certificates_path]);



                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['gpsa_certificate' => $gpsa_certificates_path]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['food_business_license' => $food_business_licenses_path]);



                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['business_license' => $business_licenses_path]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['osha_certificate' => $osha_certificates_path]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['tcra_registration' => $tcra_registration_path]);



                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['brela_registration' => $brela_registration_path]);



                //File management ends



            }else {

                if($request->get('company_name')=="") {



                    DB::table('clients')->insert(
                        ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $full_name, 'type' => $client_type,'contract'=>'Space', 'official_client_id' => $request->get("official_client_id"), 'tin' => $request->get("tin")]
                    );

                    $rent_sqm="";

                    if($request->get('rent_sqm')==''){
                        $rent_sqm='N/A';

                    }else{

                        $rent_sqm=$request->get('rent_sqm');
                    }

                    $amount_total=$request->get('amount')+$request->get('additional_businesses_amount');
                    $academic_season_total=$request->get('academic_season')+$request->get('additional_businesses_amount');
                    $vacation_season_total=$request->get('vacation_season')+$request->get('additional_businesses_amount');


                    DB::table('space_contracts')->insert(
                        ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $amount_total,'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $request->get('invoicing_period_end_date'),'programming_start_date' => $request->get('invoicing_period_start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$vacation_season_total,'academic_season'=>$academic_season_total,'tbs_certificate'=>$tbs_certificates_path,'gpsa_certificate'=>$gpsa_certificates_path,'food_business_license'=>$gpsa_certificates_path,'business_license'=>$business_licenses_path,'osha_certificate'=>$osha_certificates_path,'tcra_registration'=>$tcra_registration_path,'brela_registration'=>$brela_registration_path,'contract_category'=>$request->get('contract_category'),'has_additional_businesses'=>$request->get('has_additional_businesses'),'additional_businesses_amount'=>$request->get('additional_businesses_amount'),'additional_businesses_list'=>$request->get('additional_businesses_list'),'security_deposit'=>$request->get('security_deposit'),'has_clients'=>$has_clients,'under_client'=>$under_client,'parent_client'=>$request->get('parent_client'),'client_type_contract'=>$request->get('client_type_contract')]
                    );

                } else {

                    DB::table('clients')->insert(
                        ['first_name' => $request->get('company_name'), 'last_name' => '', 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $request->get('company_name'), 'type' => $client_type,'contract'=>'Space', 'official_client_id' => $request->get("official_client_id"), 'tin' => $request->get("tin")]
                    );


                    $rent_sqm="";

                    if($request->get('rent_sqm')==''){
                        $rent_sqm='N/A';

                    }else{

                        $rent_sqm=$request->get('rent_sqm');
                    }

                    $amount_total=$request->get('amount')+$request->get('additional_businesses_amount');
                    $academic_season_total=$request->get('academic_season')+$request->get('additional_businesses_amount');
                    $vacation_season_total=$request->get('vacation_season')+$request->get('additional_businesses_amount');

                    DB::table('space_contracts')->insert(
                        ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $amount_total,'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $request->get('invoicing_period_end_date'),'programming_start_date' => $request->get('invoicing_period_start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$vacation_season_total,'academic_season'=>$academic_season_total,'tbs_certificate'=>$tbs_certificates_path,'gpsa_certificate'=>$gpsa_certificates_path,'food_business_license'=>$gpsa_certificates_path,'business_license'=>$business_licenses_path,'osha_certificate'=>$osha_certificates_path,'tcra_registration'=>$tcra_registration_path,'brela_registration'=>$brela_registration_path,'contract_category'=>$request->get('contract_category'),'has_additional_businesses'=>$request->get('has_additional_businesses'),'additional_businesses_amount'=>$request->get('additional_businesses_amount'),'additional_businesses_list'=>$request->get('additional_businesses_list'),'security_deposit'=>$request->get('security_deposit'),'has_clients'=>$has_clients,'under_client'=>$under_client,'parent_client'=>$request->get('parent_client'),'client_type_contract'=>$request->get('client_type_contract')]
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


            //invoice creation starts

            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');
            $today=date('Y-m-d');

            $amount_in_words='';

            if($request->get('currency_invoice')=='TZS'){
                $amount_in_words=Terbilang::make($request->get('amount_to_be_paid'),' TZS',' ');

            }if ($request->get('currency_invoice')=='USD'){

                $amount_in_words=Terbilang::make($request->get('amount_to_be_paid'),' USD',' ');
            }

            else{


            }


            $created_contract_id=DB::table('space_contracts')->orderBy('contract_id','desc')->limit(1)->value('contract_id');


            $invoice_to_be_created=DB::select('call invoice_exists_space (?,?,?)',[$created_contract_id,$request->get('invoicing_period_start_date'),$request->get('invoicing_period_end_date')]);


            if(count($invoice_to_be_created)==0){

                DB::table('invoices')->insert(
                    ['invoice_number_votebook'=>'','contract_id' => $created_contract_id, 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $request->get('period','N/A'),'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'amount_to_be_paid' => $request->get('amount_to_be_paid'),'currency_invoice'=>$request->get('currency_invoice'),'gepg_control_no'=>'','tin'=>$request->get('tin_invoice','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'Space','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A','stage'=>1]
                );

                $invoice_number_created=DB::table('invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                DB::table('invoice_notifications')->insert(
                    ['invoice_id' => $invoice_number_created, 'invoice_category' => 'space']
                );

                DB::table('space_payments')->insert(
                    ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => $request->get('invoice_number'),'amount_paid' => 0,'amount_not_paid' =>$request->get('amount_to_be_paid'),'currency_payments' => $request->get('currency_invoice'),'receipt_number' => '']
                );


            }else{
                return redirect()->back()->with("error","Invoice already exists. Please try again");

            }

            //invoice creation ends
            return $pdf->stream();


        }else{

            //for viewing pdf
            $brela_registration_path=null;
            $tbs_certificates_path=null;
            $gpsa_certificates_path=null;
            $business_licenses_path=null;
            $food_business_licenses_path=null;
            $osha_certificates_path=null;
            $tcra_registration_path=null;


            //for saving only
            $brela_registration_path2=null;
            $tbs_certificates_path2=null;
            $gpsa_certificates_path2=null;
            $business_licenses_path2=null;
            $food_business_licenses_path2=null;
            $osha_certificates_path2=null;
            $tcra_registration_path2=null;





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


            $programming_end_date = $programming_end_date->addMonths($request->get('payment_cycle'));







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



                DB::table('clients')
                    ->where('full_name', $full_name)
                    ->update(['tin' => $request->get('tin')]);

                DB::table('clients')
                    ->where('full_name', $full_name)
                    ->update(['official_client_id' => $request->get('official_client_id')]);


                $rent_sqm="";

                if($request->get('rent_sqm')==''){
                    $rent_sqm='N/A';

                }else{

                    $rent_sqm=$request->get('rent_sqm');
                }

                $amount_total=$request->get('amount')+$request->get('additional_businesses_amount');
                $academic_season_total=$request->get('academic_season')+$request->get('additional_businesses_amount');
                $vacation_season_total=$request->get('vacation_season')+$request->get('additional_businesses_amount');


                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $amount_total,'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $request->get('invoicing_period_end_date'),'programming_start_date' => $request->get('invoicing_period_start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$vacation_season_total,'academic_season'=>$academic_season_total,'tbs_certificate'=>$tbs_certificates_path,'gpsa_certificate'=>$gpsa_certificates_path,'food_business_license'=>$gpsa_certificates_path,'business_license'=>$business_licenses_path,'osha_certificate'=>$osha_certificates_path,'tcra_registration'=>$tcra_registration_path,'brela_registration'=>$brela_registration_path,'contract_category'=>$request->get('contract_category'),'has_additional_businesses'=>$request->get('has_additional_businesses'),'additional_businesses_amount'=>$request->get('additional_businesses_amount'),'additional_businesses_list'=>$request->get('additional_businesses_list'),'security_deposit'=>$request->get('security_deposit'),'has_clients'=>$has_clients,'under_client'=>$under_client,'parent_client'=>$request->get('parent_client'),'client_type_contract'=>$request->get('client_type_contract')]
                );


//file management starts

                $contract_id_created=DB::table('space_contracts')->orderBy('contract_id','desc')->limit(1)->value('contract_id');

                if($request->hasfile('tbs_certificate')){
                    $file=$request->file('tbs_certificate');
                    $filename=$request->file('tbs_certificate')->getClientOriginalName();
                    $tbs_certificates_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'tbs_certificate.pdf';
                    $tbs_certificates_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($tbs_certificates_path2,'tbs_certificate.pdf');

                }

                if($request->hasfile('gpsa_certificate')){
                    $file=$request->file('gpsa_certificate');
                    $filename=$request->file('gpsa_certificate')->getClientOriginalName();
                    $gpsa_certificates_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'gpsa_certificate.pdf';
                    $gpsa_certificates_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($gpsa_certificates_path2,'gpsa_certificate.pdf');

                }



                if($request->hasfile('food_business_license')){
                    $file=$request->file('food_business_license');
                    $filename=$request->file('food_business_license')->getClientOriginalName();
                    $food_business_licenses_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'food_business_license.pdf';
                    $food_business_licenses_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($food_business_licenses_path2,'food_business_license.pdf');

                }

                if($request->hasfile('business_license')){


                    $file=$request->file('business_license');
                    $filename=$request->file('business_license')->getClientOriginalName();
                    $business_licenses_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'business_license.pdf';
                    $business_licenses_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';

                    $file->move($business_licenses_path2,'business_license.pdf');

                }



                if($request->hasfile('osha_certificate')){
                    $file=$request->file('osha_certificate');
                    $filename=$request->file('osha_certificate')->getClientOriginalName();
                    $osha_certificates_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'osha_certificate.pdf';
                    $osha_certificates_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($osha_certificates_path2,'osha_certificate.pdf');

                }



                if($request->hasfile('tcra_registration')){
                    $file=$request->file('tcra_registration');
                    $filename=$request->file('tcra_registration')->getClientOriginalName();
                    $tcra_registration_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'tcra_registration.pdf';
                    $tcra_registration_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($tcra_registration_path2,'tcra_registration.pdf');

                }

                if($request->hasfile('brela_registration')){
                    $file=$request->file('brela_registration');
                    $filename=$request->file('brela_registration')->getClientOriginalName();
                    $brela_registration_path='uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/'.'brela_registration.pdf';
                    $brela_registration_path2=public_path().'/'.'uploads'.'/'.'space_contracts'.'/'.$contract_id_created.'/'.'certificates/';
                    $file->move($brela_registration_path2,'brela_registration.pdf');

                }


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['tbs_certificate' => $tbs_certificates_path]);



                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['gpsa_certificate' => $gpsa_certificates_path]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['food_business_license' => $food_business_licenses_path]);



                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['business_license' => $business_licenses_path]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['osha_certificate' => $osha_certificates_path]);


                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['tcra_registration' => $tcra_registration_path]);



                DB::table('space_contracts')
                    ->where('contract_id', $contract_id_created)
                    ->update(['brela_registration' => $brela_registration_path]);



                //File management ends





            }else {

                if($request->get('company_name')=="") {



                    DB::table('clients')->insert(
                        ['first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $full_name, 'type' => $client_type,'contract'=>'Space', 'official_client_id' => $request->get("official_client_id"), 'tin' => $request->get("tin")]
                    );

                    $rent_sqm="";

                    if($request->get('rent_sqm')==''){
                        $rent_sqm='N/A';

                    }else{

                        $rent_sqm=$request->get('rent_sqm');
                    }

                    $amount_total=$request->get('amount')+$request->get('additional_businesses_amount');
                    $academic_season_total=$request->get('academic_season')+$request->get('additional_businesses_amount');
                    $vacation_season_total=$request->get('vacation_season')+$request->get('additional_businesses_amount');


                    DB::table('space_contracts')->insert(
                        ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $amount_total,'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $request->get('invoicing_period_end_date'),'programming_start_date' => $request->get('invoicing_period_start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$vacation_season_total,'academic_season'=>$academic_season_total,'tbs_certificate'=>$tbs_certificates_path,'gpsa_certificate'=>$gpsa_certificates_path,'food_business_license'=>$gpsa_certificates_path,'business_license'=>$business_licenses_path,'osha_certificate'=>$osha_certificates_path,'tcra_registration'=>$tcra_registration_path,'brela_registration'=>$brela_registration_path,'contract_category'=>$request->get('contract_category'),'has_additional_businesses'=>$request->get('has_additional_businesses'),'additional_businesses_amount'=>$request->get('additional_businesses_amount'),'additional_businesses_list'=>$request->get('additional_businesses_list'),'security_deposit'=>$request->get('security_deposit'),'has_clients'=>$has_clients,'under_client'=>$under_client,'parent_client'=>$request->get('parent_client'),'client_type_contract'=>$request->get('client_type_contract')]
                    );

                } else {

                    DB::table('clients')->insert(
                        ['first_name' => $request->get('company_name'), 'last_name' => '', 'address' => $request->get('address'), 'email' => $request->get('email'), 'phone_number' => $request->get('phone_number'), 'full_name' => $request->get('company_name'), 'type' => $client_type,'contract'=>'Space', 'official_client_id' => $request->get("official_client_id"), 'tin' => $request->get("tin")]
                    );


                    $rent_sqm="";

                    if($request->get('rent_sqm')==''){
                        $rent_sqm='N/A';

                    }else{

                        $rent_sqm=$request->get('rent_sqm');
                    }


                    $amount_total=$request->get('amount')+$request->get('additional_businesses_amount');
                    $academic_season_total=$request->get('academic_season')+$request->get('additional_businesses_amount');
                    $vacation_season_total=$request->get('vacation_season')+$request->get('additional_businesses_amount');

                    DB::table('space_contracts')->insert(
                        ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $amount_total,'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $request->get('invoicing_period_end_date'),'programming_start_date' => $request->get('invoicing_period_start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$vacation_season_total,'academic_season'=>$academic_season_total,'tbs_certificate'=>$tbs_certificates_path,'gpsa_certificate'=>$gpsa_certificates_path,'food_business_license'=>$gpsa_certificates_path,'business_license'=>$business_licenses_path,'osha_certificate'=>$osha_certificates_path,'tcra_registration'=>$tcra_registration_path,'brela_registration'=>$brela_registration_path,'contract_category'=>$request->get('contract_category'),'has_additional_businesses'=>$request->get('has_additional_businesses'),'additional_businesses_amount'=>$request->get('additional_businesses_amount'),'additional_businesses_list'=>$request->get('additional_businesses_list'),'security_deposit'=>$request->get('security_deposit'),'has_clients'=>$has_clients,'under_client'=>$under_client,'parent_client'=>$request->get('parent_client'),'client_type_contract'=>$request->get('client_type_contract')]
                    );


                }
            }




            //Invoice creation starts

            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');
            $today=date('Y-m-d');

            $amount_in_words='';

            if($request->get('currency_invoice')=='TZS'){
                $amount_in_words=Terbilang::make($request->get('amount_to_be_paid'),' TZS',' ');

            }if ($request->get('currency_invoice')=='USD'){

                $amount_in_words=Terbilang::make($request->get('amount_to_be_paid'),' USD',' ');
            }

            else{


            }


            $created_contract_id=DB::table('space_contracts')->orderBy('contract_id','desc')->limit(1)->value('contract_id');


            $invoice_to_be_created=DB::select('call invoice_exists_space (?,?,?)',[$created_contract_id,$request->get('invoicing_period_start_date'),$request->get('invoicing_period_end_date')]);


            if(count($invoice_to_be_created)==0){

                DB::table('invoices')->insert(
                    ['invoice_number_votebook'=>'','contract_id' => $created_contract_id, 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $request->get('period','N/A'),'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'amount_to_be_paid' => $request->get('amount_to_be_paid'),'currency_invoice'=>$request->get('currency_invoice'),'gepg_control_no'=>'','tin'=>$request->get('tin_invoice','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'Space','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A','stage'=>1]
                );

                $invoice_number_created=DB::table('invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                DB::table('invoice_notifications')->insert(
                    ['invoice_id' => $invoice_number_created, 'invoice_category' => 'space']
                );

                DB::table('space_payments')->insert(
                    ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => $request->get('invoice_number'),'amount_paid' => 0,'amount_not_paid' =>$request->get('amount_to_be_paid'),'currency_payments' => $request->get('currency_invoice'),'receipt_number' => '']
                );


            }else{
                return redirect()->back()->with("error","Invoice already exists. Please try again");

            }

            //Invoice creation ends




            return redirect('/contracts_management')
                ->with('success', 'Contract created successfully');

        }


    }


    public function ViewPdf($contract_id,$type)
    {
        $decrypted_contract_id=base64_decode(base64_decode(base64_decode($contract_id)));

        $path=DB::table('space_contracts')->where('contract_id',$decrypted_contract_id)->value($type);

        return response()->file(public_path().'/'.$path);

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


        $programming_end_date = $programming_end_date->addMonths($request->get('payment_cycle'));



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

            $amount_total=$request->get('amount')+$request->get('additional_businesses_amount');
            $academic_season_total=$request->get('academic_season')+$request->get('additional_businesses_amount');
            $vacation_season_total=$request->get('vacation_season')+$request->get('additional_businesses_amount');


            DB::table('space_contracts')->insert(
                ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $amount_total,'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $request->get('invoicing_period_end_date'),'programming_start_date' => $request->get('invoicing_period_start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$vacation_season_total,'academic_season'=>$academic_season_total]
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

                $amount_total=$request->get('amount')+$request->get('additional_businesses_amount');
                $academic_season_total=$request->get('academic_season')+$request->get('additional_businesses_amount');
                $vacation_season_total=$request->get('vacation_season')+$request->get('additional_businesses_amount');

                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $amount_total,'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $full_name,'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $request->get('invoicing_period_end_date'),'programming_start_date' => $request->get('invoicing_period_start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$vacation_season_total,'academic_season'=>$academic_season_total]
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

                $amount_total=$request->get('amount')+$request->get('additional_businesses_amount');
                $academic_season_total=$request->get('academic_season')+$request->get('additional_businesses_amount');
                $vacation_season_total=$request->get('vacation_season')+$request->get('additional_businesses_amount');

                DB::table('space_contracts')->insert(
                    ['space_id_contract' => $request->get('space_id_contract'),'academic_dependence' => $request->get('academic_dependence'), 'amount' => $amount_total,'currency' => $request->get('currency'),'payment_cycle' => $request->get('payment_cycle'),'start_date' => $request->get('start_date'),'end_date' => $end_date,'full_name' => $request->get('company_name'),'escalation_rate' => $request->get('escalation_rate'),'programming_end_date' => $request->get('invoicing_period_end_date'),'programming_start_date' => $request->get('invoicing_period_start_date'),'has_water_bill'=>$request->get('has_water_bill'),'has_electricity_bill'=>$request->get('has_electricity_bill'),'duration'=>$request->get('duration'),'duration_period'=>$request->get('duration_period'),'rent_sqm'=>$rent_sqm,'vacation_season'=>$vacation_season_total,'academic_season'=>$academic_season_total]
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



        if($request->get("generate_invoice_checkbox")=="generate_invoice_selected"){

            if ($request->get('invoicing_period_start_date')>$request->get('invoicing_period_end_date')) {

                return redirect()->back()->with("error","Invoice start date cannot be greater than invoice end date. Please try again");
            }



            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');
            $today=date('Y-m-d');

            $amount_in_words='';

            if($request->get('currency')=='TZS'){
                $amount_in_words=Terbilang::make($request->get('amount_to_be_paid'),' TZS',' ');

            }if ($request->get('currency')=='USD'){

                $amount_in_words=Terbilang::make($request->get('amount_to_be_paid'),' USD',' ');
            }

            else{


            }



            $invoice_to_be_created=DB::select('call invoice_exists_space (?,?,?)',[$request->get('contract_id'),$request->get('invoicing_period_start_date'),$request->get('invoicing_period_end_date')]);


            if(count($invoice_to_be_created)==0){

                DB::table('invoices')->insert(
                    ['contract_id' => $request->get('contract_id','N/A'), 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $request->get('period','N/A'),'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'amount_to_be_paid' => $request->get('amount_to_be_paid'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>$request->get('tin','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'Space','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A']
                );

                $invoice_number_created=DB::table('invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                DB::table('invoice_notifications')->insert(
                    ['invoice_id' => $invoice_number_created, 'invoice_category' => 'space']
                );

                DB::table('space_payments')->insert(
                    ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$request->get('amount_to_be_paid'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
                );


            }else{
                return redirect()->back()->with("error","Invoice already exists. Please try again");

            }

        }else{





        }





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


            $programming_end_date = $programming_end_date->addMonths($request->get('payment_cycle'));

//            DB::table('space_contracts')
//                ->where('contract_id', $contract_id)
//                ->update(['programming_end_date' => $programming_end_date]);


//            DB::table('space_contracts')
//                ->where('contract_id', $contract_id)
//                ->update(['programming_start_date' => $request->get('start_date')]);


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


            $programming_end_date = $programming_end_date->addMonths($request->get('payment_cycle'));

//            DB::table('space_contracts')
//                ->where('contract_id', $contract_id)
//                ->update(['programming_end_date' => $programming_end_date]);


//            DB::table('space_contracts')
//                ->where('contract_id', $contract_id)
//                ->update(['programming_start_date' => $request->get('start_date')]);


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



//        if($request->get("generate_invoice_checkbox")=="generate_invoice_selected"){
//
//            if ($request->get('invoicing_period_start_date')>$request->get('invoicing_period_end_date')) {
//
//                return redirect()->back()->with("error","Invoice start date cannot be greater than invoice end date. Please try again");
//            }
//
//
//
//            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
//            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');
//            $today=date('Y-m-d');
//
//            $amount_in_words='';
//
//            if($request->get('currency')=='TZS'){
//                $amount_in_words=Terbilang::make($request->get('amount_to_be_paid'),' TZS',' ');
//
//            }if ($request->get('currency')=='USD'){
//
//                $amount_in_words=Terbilang::make($request->get('amount_to_be_paid'),' USD',' ');
//            }
//
//            else{
//
//
//            }
//
//
//            $period= date("d/m/Y",strtotime($request->get('invoicing_period_start_date'))).' to  '. date("d/m/Y",strtotime($request->get('invoicing_period_end_date')));
//
//
//            $invoice_to_be_created=DB::select('call invoice_exists_insurance (?,?,?)',[$request->get('invoicing_period_start_date'),$request->get('invoicing_period_end_date'),$request->get('debtor_name')]);
//
//
//            if(count($invoice_to_be_created)==0){
//
//                DB::table('insurance_invoices_clients')->insert(
//                    ['contract_id' => $request->get("contract_id"), 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $period,'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'amount_to_be_paid' => $request->get('amount_to_be_paid'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>$request->get('tin','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'Insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A']
//                );
//
//                $invoice_number_created=DB::table('insurance_invoices_clients')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');
//
//                DB::table('invoice_notifications')->insert(
//                    ['invoice_id' => $invoice_number_created, 'invoice_category' => 'insurance']
//                );
//
//                DB::table('insurance_payments')->insert(
//                    ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$request->get('amount_to_be_paid'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
//                );
//
//
//            }else{
//                return redirect()->back()->with("error","Invoice already exists. Please try again");
//
//            }
//
//        }else{
//
//
//
//
//        }





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


            $remarks='Client will be assisted in case of anything only after paying the full amount';




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
            $third_installment="";
            $fourth_installment="";
            $fifth_installment="";
            $sixth_installment="";
            $seventh_installment="";
            $eighth_installment="";
            $ninth_installment="";
            $tenth_installment="";
            $eleventh_installment="";
            $twelfth_installment="";


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



            if($request->get('third_installment')==""){
                $third_installment='N/A';

            }else{

                $third_installment=$request->get('third_installment');

            }



            if($request->get('fourth_installment')==""){
                $fourth_installment='N/A';

            }else{

                $fourth_installment=$request->get('fourth_installment');

            }


            if($request->get('fifth_installment')==""){
                $fifth_installment='N/A';

            }else{

                $fifth_installment=$request->get('fifth_installment');

            }


            if($request->get('sixth_installment')==""){
                $sixth_installment='N/A';

            }else{

                $sixth_installment=$request->get('sixth_installment');

            }


            if($request->get('seventh_installment')==""){
                $seventh_installment='N/A';

            }else{

                $seventh_installment=$request->get('seventh_installment');

            }

            if($request->get('eighth_installment')==""){
                $eighth_installment='N/A';

            }else{

                $eighth_installment=$request->get('eighth_installment');

            }


            if($request->get('ninth_installment')==""){
                $ninth_installment='N/A';

            }else{

                $ninth_installment=$request->get('ninth_installment');

            }


            if($request->get('tenth_installment')==""){
                $tenth_installment='N/A';

            }else{

                $tenth_installment=$request->get('tenth_installment');

            }



            if($request->get('eleventh_installment')==""){
                $eleventh_installment='N/A';

            }else{

                $eleventh_installment=$request->get('eleventh_installment');

            }


            if($request->get('twelfth_installment')==""){
                $twelfth_installment='N/A';

            }else{

                $twelfth_installment=$request->get('twelfth_installment');

            }



if($request->get('mode_of_payment')=='By installment'){

    $mode_of_payment='';

    if($request->get('mode_payment')==""){
        $mode_of_payment='N/A';

    }else{

        $mode_of_payment=$request->get('mode_of_payment');

    }

//ended here today

    DB::table('insurance_contracts')->insert(
        ['vehicle_registration_no' => $vehicle_reg_var, 'vehicle_use' => $vehicle_use_var, 'principal' => $request->get('insurance_company'), 'insurance_type' => $request->get('insurance_type'), 'commission_date' => $request->get('commission_date'), 'end_date' => $end_date, 'sum_insured' => $request->get('sum_insured'), 'premium' => $request->get('premium'),'actual_ex_vat' => $request->get('actual_ex_vat'),'currency' => $request->get('currency'),'commission' => $request->get('commission'),'receipt_no' => $request->get('receipt_no'),'full_name' => $request->get('full_name'),'duration' => $request->get('duration'),'duration_period' => $request->get('duration_period'),'commission_percentage' => $request->get('commission_percentage'),'insurance_class' => $request->get('insurance_class'),'phone_number' => $request->get('phone_number'),'email' => $request->get('email'),'cover_note' => $cover_note,'sticker_no' => $sticker_no,'value' => $value,'mode_of_payment'   => $mode_of_payment,'first_installment'   => $first_installment,'second_installment'   => $second_installment,'third_installment'=>$third_installment,'fourth_installment'=>$fourth_installment,'fifth_installment'=>$fifth_installment,'sixth_installment'=>$sixth_installment,'seventh_installment'=>$seventh_installment,'eighth_installment'=>$eighth_installment,'ninth_installment'=>$ninth_installment,'tenth_installment'=>$tenth_installment,'eleventh_installment'=>$eleventh_installment,'twelfth_installment'=>$twelfth_installment,'number_of_installments'=>$request->get('number_of_installments'),'remarks'=>$remarks]
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


    if($request->get('number_of_installments')=='2') {

//first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


    }elseif ($request->get('number_of_installments')=='3'){





//first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );





        //For third installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );





    }elseif ($request->get('number_of_installments')=='4'){





//first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );





        //For third installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );

        //Fourth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


    }elseif($request->get('number_of_installments')=='5'){


        //first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For third installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );

        //Fourth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Fifth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



    }elseif($request->get('number_of_installments')=='6'){


        //first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For third installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );

        //Fourth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Fifth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Sixth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


    }elseif($request->get('number_of_installments')=='7'){


        //first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For third installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );

        //Fourth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Fifth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Sixth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Seventh installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );





    }elseif($request->get('number_of_installments')=='8'){


        //first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For third installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );

        //Fourth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Fifth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //Sixth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //Seventh installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Eighth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eighth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_eighth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_eighth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_eighth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eighth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );





    }elseif($request->get('number_of_installments')=='9'){


        //first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For third installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );

        //Fourth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Fifth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //Sixth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //Seventh installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Eighth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eighth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_eighth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_eighth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_eighth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eighth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Ninth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $ninth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_ninth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_ninth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_ninth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $ninth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );





    }elseif($request->get('number_of_installments')=='10'){


        //first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For third installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );

        //Fourth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Fifth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //Sixth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //Seventh installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Eighth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eighth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_eighth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_eighth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_eighth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eighth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Ninth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $ninth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_ninth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_ninth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_ninth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $ninth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Tenth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $tenth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_tenth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_tenth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_tenth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $tenth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



    }elseif($request->get('number_of_installments')=='11'){


        //first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For third installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );

        //Fourth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Fifth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //Sixth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //Seventh installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Eighth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eighth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_eighth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_eighth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_eighth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eighth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Ninth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $ninth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_ninth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_ninth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_ninth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $ninth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Tenth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $tenth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_tenth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_tenth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_tenth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $tenth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Eleventh installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eleventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_eleventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_eleventh_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_eleventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eleventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




    }elseif($request->get('number_of_installments')=='12'){


        //first_installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For second installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //For third installment
        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );

        //Fourth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Fifth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //Sixth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );


        //Seventh installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Eighth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eighth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_eighth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_eighth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_eighth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eighth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Ninth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $ninth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_ninth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_ninth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_ninth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $ninth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //Tenth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $tenth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_tenth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_tenth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_tenth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $tenth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



        //Eleventh installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eleventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_eleventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_eleventh_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_eleventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eleventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );




        //twelfth installment

        DB::table('insurance_invoices_clients')->insert(
            ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $twelfth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
        );


        $invoice_number_created_twelfth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created_twelfth_installment, 'invoice_category' => 'insurance']
        );


        DB::table('insurance_payments')->insert(
            ['invoice_number' => $invoice_number_created_twelfth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $twelfth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
        );



    }else{




    }


}else{


    $mode_of_payment='';

    if($request->get('mode_payment')==""){
        $mode_of_payment='N/A';

    }else{

        $mode_of_payment=$request->get('mode_of_payment');

    }


    DB::table('insurance_contracts')->insert(
        ['vehicle_registration_no' => $vehicle_reg_var, 'vehicle_use' => $vehicle_use_var, 'principal' => $request->get('insurance_company'), 'insurance_type' => $request->get('insurance_type'), 'commission_date' => $request->get('commission_date'), 'end_date' => $end_date, 'sum_insured' => $request->get('sum_insured'), 'premium' => $request->get('premium'),'actual_ex_vat' => $request->get('actual_ex_vat'),'currency' => $request->get('currency'),'commission' => $request->get('commission'),'receipt_no' => $request->get('receipt_no'),'full_name' => $request->get('full_name'),'duration' => $request->get('duration'),'duration_period' => $request->get('duration_period'),'commission_percentage' => $request->get('commission_percentage'),'insurance_class' => $request->get('insurance_class'),'phone_number' => $request->get('phone_number'),'email' => $request->get('email'),'cover_note' => $cover_note,'sticker_no' => $sticker_no,'value' => $value,'mode_of_payment'   => $mode_of_payment,'first_installment'   => $first_installment,'second_installment'   => $second_installment,'third_installment'=>$third_installment,'fourth_installment'=>$fourth_installment,'fifth_installment'=>$fifth_installment,'sixth_installment'=>$sixth_installment,'seventh_installment'=>$seventh_installment,'eighth_installment'=>$eighth_installment,'ninth_installment'=>$ninth_installment,'tenth_installment'=>$tenth_installment,'eleventh_installment'=>$eleventh_installment,'twelfth_installment'=>$twelfth_installment,'number_of_installments'=>$request->get('number_of_installments')]
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


    DB::table('insurance_invoices_clients')->insert(
        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'),'invoicing_period_end_date' => $end_date,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $request->get('full_name'),'debtor_address' => '','amount_to_be_paid' => $request->get('premium'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>'','vrn'=>$vehicle_reg_var,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>$contract_id_created,'invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance fees','prepared_by'=>Auth::user()->name,'approved_by'=>Auth::user()->name]
    );


    $invoice_number_created=DB::table('insurance_invoices_clients')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

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
                'number_of_installments'   => $request->get('number_of_installments'),
                'first_installment'   => $request->get('first_installment'),
                'second_installment'   => $request->get('second_installment'),

                'third_installment'   => $request->get('third_installment'),
                'fourth_installment'   => $request->get('fourth_installment'),
                'fifth_installment'   => $request->get('fifth_installment'),
                'sixth_installment'   => $request->get('sixth_installment'),
                'seventh_installment'   => $request->get('seventh_installment'),
                'eighth_installment'   => $request->get('eighth_installment'),
                'ninth_installment'   => $request->get('ninth_installment'),
                'tenth_installment'   => $request->get('tenth_installment'),
                'eleventh_installment'   => $request->get('eleventh_installment'),
                'twelfth_installment'   => $request->get('twelfth_installment'),

                'actual_ex_vat'   => $request->get('actual_ex_vat'),
                'value'   => $request->get('value'),
                'commission_percentage'   => $request->get('commission_percentage'),
                'commission'   => $request->get('commission'),
                'cover_note'   => $request->get('cover_note'),
                'sticker_no'   => $request->get('sticker_no'),
                'receipt_no'   => $request->get('receipt_no'),
                'remarks'   => $remarks,
                'currency'   => $request->get('currency'),

            ];

            $pdf = PDF::loadView('insurance_contract_pdf',$data);

            return $pdf->stream();




        }else{

            $remarks='Client will be assisted in case of anything only after paying the full amount';

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
            $third_installment="";
            $fourth_installment="";
            $fifth_installment="";
            $sixth_installment="";
            $seventh_installment="";
            $eighth_installment="";
            $ninth_installment="";
            $tenth_installment="";
            $eleventh_installment="";
            $twelfth_installment="";

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



            if($request->get('third_installment')==""){
                $third_installment='N/A';

            }else{

                $third_installment=$request->get('third_installment');

            }



            if($request->get('fourth_installment')==""){
                $fourth_installment='N/A';

            }else{

                $fourth_installment=$request->get('fourth_installment');

            }


            if($request->get('fifth_installment')==""){
                $fifth_installment='N/A';

            }else{

                $fifth_installment=$request->get('fifth_installment');

            }


            if($request->get('sixth_installment')==""){
                $sixth_installment='N/A';

            }else{

                $sixth_installment=$request->get('sixth_installment');

            }


            if($request->get('seventh_installment')==""){
                $seventh_installment='N/A';

            }else{

                $seventh_installment=$request->get('seventh_installment');

            }

            if($request->get('eighth_installment')==""){
                $eighth_installment='N/A';

            }else{

                $eighth_installment=$request->get('eighth_installment');

            }


            if($request->get('ninth_installment')==""){
                $ninth_installment='N/A';

            }else{

                $ninth_installment=$request->get('ninth_installment');

            }


            if($request->get('tenth_installment')==""){
                $tenth_installment='N/A';

            }else{

                $tenth_installment=$request->get('tenth_installment');

            }

            if($request->get('eleventh_installment')==""){
                $eleventh_installment='N/A';

            }else{

                $eleventh_installment=$request->get('eleventh_installment');

            }


            if($request->get('twelfth_installment')==""){
                $twelfth_installment='N/A';

            }else{

                $twelfth_installment=$request->get('twelfth_installment');

            }


            if($request->get('mode_of_payment')=='By installment'){


                $mode_of_payment='';

                if($request->get('mode_payment')==""){
                    $mode_of_payment='N/A';

                }else{

                    $mode_of_payment=$request->get('mode_of_payment');

                }


                DB::table('insurance_contracts')->insert(
                    ['vehicle_registration_no' => $vehicle_reg_var, 'vehicle_use' => $vehicle_use_var, 'principal' => $request->get('insurance_company'), 'insurance_type' => $request->get('insurance_type'), 'commission_date' => $request->get('commission_date'), 'end_date' => $end_date, 'sum_insured' => $request->get('sum_insured'), 'premium' => $request->get('premium'),'actual_ex_vat' => $request->get('actual_ex_vat'),'currency' => $request->get('currency'),'commission' => $request->get('commission'),'receipt_no' => $request->get('receipt_no'),'full_name' => $request->get('full_name'),'duration' => $request->get('duration'),'duration_period' => $request->get('duration_period'),'commission_percentage' => $request->get('commission_percentage'),'insurance_class' => $request->get('insurance_class'),'phone_number' => $request->get('phone_number'),'email' => $request->get('email'),'cover_note' => $cover_note,'sticker_no' => $sticker_no,'value' => $value,'mode_of_payment'   => $mode_of_payment,'first_installment'   => $first_installment,'second_installment'   => $second_installment,'third_installment'=>$third_installment,'fourth_installment'=>$fourth_installment,'fifth_installment'=>$fifth_installment,'sixth_installment'=>$sixth_installment,'seventh_installment'=>$seventh_installment,'eighth_installment'=>$eighth_installment,'ninth_installment'=>$ninth_installment,'tenth_installment'=>$tenth_installment,'eleventh_installment'=>$eleventh_installment,'twelfth_installment'=>$twelfth_installment,'number_of_installments'=>$request->get('number_of_installments'),'remarks'=>$remarks]
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


                if($request->get('number_of_installments')=='2') {

//first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                }elseif ($request->get('number_of_installments')=='3'){





//first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );





                    //For third installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );





                }elseif ($request->get('number_of_installments')=='4'){





//first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );





                    //For third installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );

                    //Fourth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                }elseif($request->get('number_of_installments')=='5'){


                    //first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For third installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );

                    //Fourth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                    //Fifth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                }elseif($request->get('number_of_installments')=='6'){


                    //first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For third installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );

                    //Fourth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                    //Fifth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Sixth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                }elseif($request->get('number_of_installments')=='7'){


                    //first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For third installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );

                    //Fourth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                    //Fifth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Sixth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



            //Seventh installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );





                }elseif($request->get('number_of_installments')=='8'){


                    //first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For third installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );

                    //Fourth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                    //Fifth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //Sixth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //Seventh installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Eighth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eighth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_eighth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_eighth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_eighth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eighth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );





                }elseif($request->get('number_of_installments')=='9'){


                    //first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For third installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );

                    //Fourth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                    //Fifth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //Sixth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //Seventh installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Eighth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eighth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_eighth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_eighth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_eighth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eighth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Ninth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $ninth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_ninth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_ninth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_ninth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $ninth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );





                }elseif($request->get('number_of_installments')=='10'){


                    //first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For third installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );

                    //Fourth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                    //Fifth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //Sixth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //Seventh installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Eighth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eighth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_eighth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_eighth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_eighth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eighth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Ninth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $ninth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_ninth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_ninth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_ninth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $ninth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Tenth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $tenth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_tenth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_tenth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_tenth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $tenth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                }elseif($request->get('number_of_installments')=='11'){


                    //first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For third installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );

                    //Fourth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                    //Fifth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //Sixth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //Seventh installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Eighth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eighth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_eighth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_eighth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_eighth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eighth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Ninth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $ninth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_ninth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_ninth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_ninth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $ninth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Tenth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $tenth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_tenth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_tenth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_tenth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $tenth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                    //Eleventh installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eleventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_eleventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_eleventh_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_eleventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eleventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                }elseif($request->get('number_of_installments')=='12'){


                    //first_installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $first_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_first_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_first_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_first_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $first_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For second installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $second_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_second_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_second_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_second_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $second_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //For third installment
                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $third_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_third_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_third_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_third_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $third_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );

                    //Fourth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fourth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fourth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fourth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fourth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fourth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                    //Fifth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $fifth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_fifth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_fifth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_fifth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $fifth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //Sixth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $sixth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_sixth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_sixth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_sixth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $sixth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );


                    //Seventh installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $seventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_seventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_seventh_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_seventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $seventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Eighth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eighth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_eighth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_eighth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_eighth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eighth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Ninth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $ninth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_ninth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_ninth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_ninth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $ninth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //Tenth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $tenth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_tenth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_tenth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_tenth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $tenth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                    //Eleventh installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $eleventh_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_eleventh_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_eleventh_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_eleventh_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $eleventh_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );




                    //twelfth installment

                    DB::table('insurance_invoices_clients')->insert(
                        ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'), 'invoicing_period_end_date' => $end_date, 'period' => $period, 'project_id' => 'UDIA', 'debtor_account_code' => '', 'debtor_name' => $request->get('full_name'), 'debtor_address' => '', 'amount_to_be_paid' => $twelfth_installment, 'currency_invoice' => $request->get('currency'), 'gepg_control_no' => '', 'tin' => '', 'vrn' => $vehicle_reg_var, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => $contract_id_created, 'invoice_category' => 'insurance', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Insurance fees', 'prepared_by' => Auth::user()->name, 'approved_by' => Auth::user()->name]
                    );


                    $invoice_number_created_twelfth_installment = DB::table('insurance_invoices_clients')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created_twelfth_installment, 'invoice_category' => 'insurance']
                    );


                    DB::table('insurance_payments')->insert(
                        ['invoice_number' => $invoice_number_created_twelfth_installment, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => $twelfth_installment, 'currency_payments' => $request->get('currency'), 'receipt_number' => '']
                    );



                }else{




                }





            }else{



                $mode_of_payment='';

                if($request->get('mode_payment')==""){
                    $mode_of_payment='N/A';

                }else{

                    $mode_of_payment=$request->get('mode_of_payment');

                }


                DB::table('insurance_contracts')->insert(
                    ['vehicle_registration_no' => $vehicle_reg_var, 'vehicle_use' => $vehicle_use_var, 'principal' => $request->get('insurance_company'), 'insurance_type' => $request->get('insurance_type'), 'commission_date' => $request->get('commission_date'), 'end_date' => $end_date, 'sum_insured' => $request->get('sum_insured'), 'premium' => $request->get('premium'),'actual_ex_vat' => $request->get('actual_ex_vat'),'currency' => $request->get('currency'),'commission' => $request->get('commission'),'receipt_no' => $request->get('receipt_no'),'full_name' => $request->get('full_name'),'duration' => $request->get('duration'),'duration_period' => $request->get('duration_period'),'commission_percentage' => $request->get('commission_percentage'),'insurance_class' => $request->get('insurance_class'),'phone_number' => $request->get('phone_number'),'email' => $request->get('email'),'cover_note' => $cover_note,'sticker_no' => $sticker_no,'value' => $value,'mode_of_payment'   => $mode_of_payment,'first_installment'   => $first_installment,'second_installment'   => $second_installment,'third_installment'=>$third_installment,'fourth_installment'=>$fourth_installment,'fifth_installment'=>$fifth_installment,'sixth_installment'=>$sixth_installment,'seventh_installment'=>$seventh_installment,'eighth_installment'=>$eighth_installment,'ninth_installment'=>$ninth_installment,'tenth_installment'=>$tenth_installment,'eleventh_installment'=>$eleventh_installment,'twelfth_installment'=>$twelfth_installment,'number_of_installments'=>$request->get('number_of_installments')]
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


                DB::table('insurance_invoices_clients')->insert(
                    ['contract_id' => $contract_id_created, 'invoicing_period_start_date' => $request->get('commission_date'),'invoicing_period_end_date' => $end_date,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $request->get('full_name'),'debtor_address' => '','amount_to_be_paid' => $request->get('premium'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>'','vrn'=>$vehicle_reg_var,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>$contract_id_created,'invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance fees','prepared_by'=>Auth::user()->name,'approved_by'=>Auth::user()->name]
                );


                $invoice_number_created=DB::table('insurance_invoices_clients')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

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
                'number_of_installments'   => $request->get('number_of_installments'),
                'first_installment'   => $request->get('first_installment'),
                'second_installment'   => $request->get('second_installment'),
                'third_installment'   => $request->get('third_installment'),
                'fourth_installment'   => $request->get('fourth_installment'),
                'fifth_installment'   => $request->get('fifth_installment'),
                'sixth_installment'   => $request->get('sixth_installment'),
                'seventh_installment'   => $request->get('seventh_installment'),
                'eighth_installment'   => $request->get('eighth_installment'),
                'ninth_installment'   => $request->get('ninth_installment'),
                'tenth_installment'   => $request->get('tenth_installment'),
                'eleventh_installment'   => $request->get('eleventh_installment'),
                'twelfth_installment'   => $request->get('twelfth_installment'),
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
