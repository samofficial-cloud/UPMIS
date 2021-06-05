<?php

namespace App\Http\Controllers;

use App\Exports\researchContractsExport;
use App\research_flats_contract;
use App\insurance_contract;
use App\ResearchContractsFormat;
use App\insurance_contracts_format;
use Illuminate\Http\Request;
use App\Exports\spaceContractsExport;
use Maatwebsite\Excel\Excel;
use App;
use App\SpaceContractsFormat;
use App\client;
use App\space_contract;
use App\space;

use Illuminate\Support\Facades\DB;
use Riskihajar\Terbilang\Facades\Terbilang;
use Illuminate\Support\Facades\Hash;


class ImportExcelController extends Controller
{
    //

  public function importSpaceContracts(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();



        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {





//space contract insert code starts

                $has_clients=null;
                $under_client=null;

                if($value["client_typedirectdirect_and_has_clientsindirect"]=='Direct'){
                    $has_clients=0;
                    $under_client=0;

                }elseif ($value["client_typedirectdirect_and_has_clientsindirect"]=='Direct and has clients'){

                    $has_clients=1;
                    $under_client=0;
                }elseif($value["client_typedirectdirect_and_has_clientsindirect"]=='Indirect'){
                    $has_clients=0;
                    $under_client=1;

                }else{


                }


                if($value["client_categorycompanyorganizationindividual"]=='Individual'){
                    $client_type="Individual";
                    $full_name=$value["first_nameempty_for_company_case"].' '.$value["last_nameempty_for_company_case"];


                }else{
                    $client_type="Company/Organization";
                    $full_name=$value["company_nameempty_for_individual_case"];
                }



                if(DB::table('clients')->where('full_name',$full_name)->where('contract','Space')->count()>0){


                    $client=client::where('full_name', $full_name)->first();

                    $client->address=$value["address"];
                    $client->email=$value["email"];
                    $client->phone_number=$value["phone_number"];
                    $client->official_client_id=$value["client_id"];
                    $client->tin=$value["tin"];
                    $client->save();


                    $rent_sqm="";

                    if($value["rentsqm"]==''){
                        $rent_sqm='N/A';

                    }else{

                        $rent_sqm=$value["rentsqm"];
                    }


                    $academic_season_total=0;
                    $vacation_season_total=0;
                    $amount_total=0;

                    if($value["academic_calendar_dependenceyes_or_no"]=='Yes'){

                        $academic_season_total=$value["academic_season_amountincludes_additional_businesses.empty_if_not_applicable"]+$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];
                        $vacation_season_total=$value["vacation_season_amountincludes_additional_businesses.empty_if_not_applicable"]+$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];


                    }else{

                        $amount_total=$value["amountincludes_additional_businesses.leave_empty_if_depends_on_academic_calendar"]+$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];


                    }



//space code starts
                 $final_space_id=null;


                    if($value["space_idleave_empty_if_not_yet_assigned_by_the_system"]==null){


                        $code_name = DB::table('space_classification')->where('minor_industry', $value["minor_industry"])->value('code_name');

                        if ($code_name=='') {

                            return back()->with('errors', 'Space code name does not exist. Please consult with the system Administrator');

                        } else {


                        }


                        $space_id_number = DB::table('spaces')->where('space_id_code', $code_name)->orderBy('id', 'desc')->limit(1)->value('space_id_number');


                        $integer = '';
                        $incremented = '';
                        $new_space_id_number = '';


                        if ($space_id_number != "") {


                            $integer = ltrim($space_id_number, '0');
                            $incremented = $integer + 1;
                            $new_space_id_number = sprintf("%04d", $incremented);

                        } else {


                            $incremented = 1;
                            $new_space_id_number = sprintf("%04d", $incremented);

                        }

                        $final_space_id = $code_name . '' . $new_space_id_number;



                        //create new space starts

                        $space= new space();
                        $space->space_id=$final_space_id;
                        $space->space_id_code=$code_name;
                        $space->space_id_number=$new_space_id_number;
                        $space->major_industry=$value["major_industry"];
                        $space->location=$value["location"];
                        $space->size='';
                        $space->rent_price_guide_checkbox=0;
                        $space->sub_location=$value["sub_location"];
                        $space->minor_industry=$value["minor_industry"];
                        $space->comments='';
                        $space->flag=2;
                        $space->has_water_bill_space=$value["has_water_billyes_or_no"];
                        $space->has_electricity_bill_space=$value["has_electricity_billyes_or_no"];

                        $space->save();

                        //create new space ends


                    }else{


                        $existing_space_id=DB::table('spaces')->where('major_industry',$value["major_industry"])->where('minor_industry',$value["minor_industry"])->where('location',$value["location"])->where('sub_location',$value["sub_location"])->where('space_id',$value["space_idleave_empty_if_not_yet_assigned_by_the_system"])->orderBy('id','desc')->limit(1)->value('space_id');


                        if($existing_space_id==null) {


                            $code_name = DB::table('space_classification')->where('minor_industry', $value["minor_industry"])->value('code_name');

                            if ($code_name == '') {

                                return back()->with('errors', 'Space code name does not exist. Please consult with the system Administrator');

                            } else {


                            }


                            $space_id_number = DB::table('spaces')->where('space_id_code', $code_name)->orderBy('id', 'desc')->limit(1)->value('space_id_number');


                            $integer = '';
                            $incremented = '';
                            $new_space_id_number = '';


                            if ($space_id_number != "") {


                                $integer = ltrim($space_id_number, '0');
                                $incremented = $integer + 1;
                                $new_space_id_number = sprintf("%04d", $incremented);

                            } else {


                                $incremented = 1;
                                $new_space_id_number = sprintf("%04d", $incremented);

                            }

                            $final_space_id = $code_name . '' . $new_space_id_number;



                            //create new space starts

                            $space= new space();
                            $space->space_id=$final_space_id;
                            $space->space_id_code=$code_name;
                            $space->space_id_number=$new_space_id_number;
                            $space->major_industry=$value["major_industry"];
                            $space->location=$value["location"];
                            $space->size='';
                            $space->rent_price_guide_checkbox=0;
                            $space->sub_location=$value["sub_location"];
                            $space->minor_industry=$value["minor_industry"];
                            $space->comments='';
                            $space->flag=2;
                            $space->has_water_bill_space=$value["has_water_billyes_or_no"];
                            $space->has_electricity_bill_space=$value["has_electricity_billyes_or_no"];

                            $space->save();

                            //create new space ends





                        }else{

                            $final_space_id=$existing_space_id;

                        }


                    }

//space code ends






                    $space_contract= new space_contract();

                    $space_contract->space_id_contract=$final_space_id;
                    $space_contract->academic_dependence=$value["academic_calendar_dependenceyes_or_no"];
                    $space_contract->amount=$amount_total;
                    $space_contract->currency=$value["currencytzs_or_usd"];
                    $space_contract->payment_cycle=$value["payment_cycle_in_months123_etc"];
                    $space_contract->start_date=$value["start_date"];
                    $space_contract->end_date=$value["end_date"];
                    $space_contract->full_name=$full_name;
                    $space_contract->escalation_rate=$value["escalation_rateempty_if_depend_on_academic_calendar"];
                    $space_contract->programming_end_date=$value["current_payment_cycle_end_date"];
                    $space_contract->programming_start_date=$value["current_payment_cycle_start_date"];
                    $space_contract->has_water_bill=$value["has_water_billyes_or_no"];
                    $space_contract->has_electricity_bill=$value["has_electricity_billyes_or_no"];
                    $space_contract->duration=$value["contract_duration"];
                    $space_contract->duration_period=$value["contract_durationyears_or_months"];
                    $space_contract->rent_sqm=$value["rentsqm"];
                    $space_contract->vacation_season=$vacation_season_total;
                    $space_contract->academic_season=$academic_season_total;
                    $space_contract->contract_category=$value["contract_categorysolicited_or_unsolicited"];
                    $space_contract->has_additional_businesses=$value["additional_businesses_in_the_areayes_or_no"];
                    $space_contract->additional_businesses_amount=$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];
                    $space_contract->additional_businesses_list=$value["list_of_additional_businessesempty_if_none"];
                    $space_contract->security_deposit=$value["security_deposit0_if_not_applicable"];
                    $space_contract->has_clients=$has_clients;
                    $space_contract->under_client=$under_client;
                    $space_contract->parent_client=$value["parent_client_idempty_if_na"];
                    $space_contract->client_type_contract=$value["client_typedirectdirect_and_has_clientsindirect"];
                    $space_contract->escalation_rate_vacation=$value["escalation_rate_vacation_seasonempty_if_na"];
                    $space_contract->escalation_rate_academic=$value["escalation_rate_academic_seasonempty_if_na"];
                    $space_contract->contract_stage=3;

                    $space_contract->save();



                    if(date('Y-m-d')>$value["end_date"]){

                        $spaces=space::where('space_id', $final_space_id)->first();
                        $spaces->occupation_status=1;
                        $spaces->save();

                    }



                }else {

                    if($value["company_nameempty_for_individual_case"]=="") {


                        $client=new client();

                        $client->first_name=$value["first_nameempty_for_company_case"];
                        $client->last_name=$value["last_nameempty_for_company_case"];
                        $client->full_name=$full_name;
                        $client->type=$client_type;
                        $client->contract='Space';



                        $client->address=$value["address"];
                        $client->email=$value["email"];
                        $client->phone_number=$value["phone_number"];
                        $client->official_client_id=$value["client_id"];
                        $client->tin=$value["tin"];
                        $client->save();



                        $rent_sqm="";

                        if($value["rentsqm"]==''){
                            $rent_sqm='N/A';

                        }else{

                            $rent_sqm=$value["rentsqm"];
                        }


                        $academic_season_total=0;
                        $vacation_season_total=0;
                        $amount_total=0;

                        if($value["academic_calendar_dependenceyes_or_no"]=='Yes'){

                            $academic_season_total=$value["academic_season_amountincludes_additional_businesses.empty_if_not_applicable"]+$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];
                            $vacation_season_total=$value["vacation_season_amountincludes_additional_businesses.empty_if_not_applicable"]+$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];


                        }else{

                            $amount_total=$value["amountincludes_additional_businesses.leave_empty_if_depends_on_academic_calendar"]+$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];


                        }





//space code starts
                        $final_space_id=null;


                        if($value["space_idleave_empty_if_not_yet_assigned_by_the_system"]==null){


                            $code_name = DB::table('space_classification')->where('minor_industry', $value["minor_industry"])->value('code_name');

                            if ($code_name == '') {

                                return back()->with('errors', 'Space code name does not exist. Please consult with the system Administrator');

                            } else {


                            }


                            $space_id_number = DB::table('spaces')->where('space_id_code', $code_name)->orderBy('id', 'desc')->limit(1)->value('space_id_number');


                            $integer = '';
                            $incremented = '';
                            $new_space_id_number = '';


                            if ($space_id_number != "") {


                                $integer = ltrim($space_id_number, '0');
                                $incremented = $integer + 1;
                                $new_space_id_number = sprintf("%04d", $incremented);

                            } else {


                                $incremented = 1;
                                $new_space_id_number = sprintf("%04d", $incremented);

                            }

                            $final_space_id = $code_name . '' . $new_space_id_number;



                            //create new space starts

                            $space= new space();
                            $space->space_id=$final_space_id;
                            $space->space_id_code=$code_name;
                            $space->space_id_number=$new_space_id_number;
                            $space->major_industry=$value["major_industry"];
                            $space->location=$value["location"];
                            $space->size='';
                            $space->rent_price_guide_checkbox=0;
                            $space->sub_location=$value["sub_location"];
                            $space->minor_industry=$value["minor_industry"];
                            $space->comments='';
                            $space->flag=2;
                            $space->has_water_bill_space=$value["has_water_billyes_or_no"];
                            $space->has_electricity_bill_space=$value["has_electricity_billyes_or_no"];

                            $space->save();

                            //create new space ends


                        }else{


                            $existing_space_id=DB::table('spaces')->where('major_industry',$value["major_industry"])->where('minor_industry',$value["minor_industry"])->where('location',$value["location"])->where('sub_location',$value["sub_location"])->where('space_id',$value["space_idleave_empty_if_not_yet_assigned_by_the_system"])->orderBy('id','desc')->limit(1)->value('space_id');


                            if($existing_space_id==null) {


                                $code_name = DB::table('space_classification')->where('minor_industry', $value["minor_industry"])->value('code_name');

                                if ($code_name == '') {

                                    return back()->with('errors', 'Space code name does not exist. Please consult with the system Administrator');

                                } else {


                                }


                                $space_id_number = DB::table('spaces')->where('space_id_code', $code_name)->orderBy('id', 'desc')->limit(1)->value('space_id_number');


                                $integer = '';
                                $incremented = '';
                                $new_space_id_number = '';


                                if ($space_id_number != "") {


                                    $integer = ltrim($space_id_number, '0');
                                    $incremented = $integer + 1;
                                    $new_space_id_number = sprintf("%04d", $incremented);

                                } else {


                                    $incremented = 1;
                                    $new_space_id_number = sprintf("%04d", $incremented);

                                }

                                $final_space_id = $code_name . '' . $new_space_id_number;



                                //create new space starts

                                $space= new space();
                                $space->space_id=$final_space_id;
                                $space->space_id_code=$code_name;
                                $space->space_id_number=$new_space_id_number;
                                $space->major_industry=$value["major_industry"];
                                $space->location=$value["location"];
                                $space->size='';
                                $space->rent_price_guide_checkbox=0;
                                $space->sub_location=$value["sub_location"];
                                $space->minor_industry=$value["minor_industry"];
                                $space->comments='';
                                $space->flag=2;
                                $space->has_water_bill_space=$value["has_water_billyes_or_no"];
                                $space->has_electricity_bill_space=$value["has_electricity_billyes_or_no"];

                                $space->save();

                                //create new space ends





                            }else{

                                $final_space_id=$existing_space_id;

                            }


                        }

//space code ends




                        $space_contract= new space_contract();

                        $space_contract->space_id_contract=$final_space_id;
                        $space_contract->academic_dependence=$value["academic_calendar_dependenceyes_or_no"];
                        $space_contract->amount=$amount_total;
                        $space_contract->currency=$value["currencytzs_or_usd"];
                        $space_contract->payment_cycle=$value["payment_cycle_in_months123_etc"];
                        $space_contract->start_date=$value["start_date"];
                        $space_contract->end_date=$value["end_date"];
                        $space_contract->full_name=$full_name;
                        $space_contract->escalation_rate=$value["escalation_rateempty_if_depend_on_academic_calendar"];
                        $space_contract->programming_end_date=$value["current_payment_cycle_end_date"];
                        $space_contract->programming_start_date=$value["current_payment_cycle_start_date"];
                        $space_contract->has_water_bill=$value["has_water_billyes_or_no"];
                        $space_contract->has_electricity_bill=$value["has_electricity_billyes_or_no"];
                        $space_contract->duration=$value["contract_duration"];
                        $space_contract->duration_period=$value["contract_durationyears_or_months"];
                        $space_contract->rent_sqm=$value["rentsqm"];
                        $space_contract->vacation_season=$vacation_season_total;
                        $space_contract->academic_season=$academic_season_total;
                        $space_contract->contract_category=$value["contract_categorysolicited_or_unsolicited"];
                        $space_contract->has_additional_businesses=$value["additional_businesses_in_the_areayes_or_no"];
                        $space_contract->additional_businesses_amount=$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];
                        $space_contract->additional_businesses_list=$value["list_of_additional_businessesempty_if_none"];
                        $space_contract->security_deposit=$value["security_deposit0_if_not_applicable"];
                        $space_contract->has_clients=$has_clients;
                        $space_contract->under_client=$under_client;
                        $space_contract->parent_client=$value["parent_client_idempty_if_na"];
                        $space_contract->client_type_contract=$value["client_typedirectdirect_and_has_clientsindirect"];
                        $space_contract->escalation_rate_vacation=$value["escalation_rate_vacation_seasonempty_if_na"];
                        $space_contract->escalation_rate_academic=$value["escalation_rate_academic_seasonempty_if_na"];
                        $space_contract->contract_stage=3;

                        $space_contract->save();


                        if(date('Y-m-d')>$value["end_date"]){

                            $spaces=space::where('space_id', $final_space_id)->first();
                            $spaces->occupation_status=1;
                            $spaces->save();

                        }





                    } else {





                        $client=new client();

                        $client->first_name=$value["company_nameempty_for_individual_case"];
                        $client->last_name='';
                        $client->full_name=$value["company_nameempty_for_individual_case"];
                        $client->type=$client_type;
                        $client->contract='Space';



                        $client->address=$value["address"];
                        $client->email=$value["email"];
                        $client->phone_number=$value["phone_number"];
                        $client->official_client_id=$value["client_id"];
                        $client->tin=$value["tin"];
                        $client->save();



                        $rent_sqm="";

                        if($value["rentsqm"]==''){
                            $rent_sqm='N/A';

                        }else{

                            $rent_sqm=$value["rentsqm"];
                        }


                        $academic_season_total=0;
                        $vacation_season_total=0;
                        $amount_total=0;

                        if($value["academic_calendar_dependenceyes_or_no"]=='Yes'){

                            $academic_season_total=$value["academic_season_amountincludes_additional_businesses.empty_if_not_applicable"]+$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];
                            $vacation_season_total=$value["vacation_season_amountincludes_additional_businesses.empty_if_not_applicable"]+$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];


                        }else{

                            $amount_total=$value["amountincludes_additional_businesses.leave_empty_if_depends_on_academic_calendar"]+$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];


                        }





//space code starts
                        $final_space_id=null;


                        if($value["space_idleave_empty_if_not_yet_assigned_by_the_system"]==null){


                            $code_name = DB::table('space_classification')->where('minor_industry', $value["minor_industry"])->value('code_name');

                            if ($code_name == '') {

                                return back()->with('errors', 'Space code name does not exist. Please consult with the system Administrator');

                            } else {


                            }


                            $space_id_number = DB::table('spaces')->where('space_id_code', $code_name)->orderBy('id', 'desc')->limit(1)->value('space_id_number');


                            $integer = '';
                            $incremented = '';
                            $new_space_id_number = '';


                            if ($space_id_number != "") {


                                $integer = ltrim($space_id_number, '0');
                                $incremented = $integer + 1;
                                $new_space_id_number = sprintf("%04d", $incremented);

                            } else {


                                $incremented = 1;
                                $new_space_id_number = sprintf("%04d", $incremented);

                            }

                            $final_space_id = $code_name . '' . $new_space_id_number;



                            //create new space starts

                            $space= new space();
                            $space->space_id=$final_space_id;
                            $space->space_id_code=$code_name;
                            $space->space_id_number=$new_space_id_number;
                            $space->major_industry=$value["major_industry"];
                            $space->location=$value["location"];
                            $space->size='';
                            $space->rent_price_guide_checkbox=0;
                            $space->sub_location=$value["sub_location"];
                            $space->minor_industry=$value["minor_industry"];
                            $space->comments='';
                            $space->flag=2;
                            $space->has_water_bill_space=$value["has_water_billyes_or_no"];
                            $space->has_electricity_bill_space=$value["has_electricity_billyes_or_no"];

                            $space->save();

                            //create new space ends


                        }else{


                            $existing_space_id=DB::table('spaces')->where('major_industry',$value["major_industry"])->where('minor_industry',$value["minor_industry"])->where('location',$value["location"])->where('sub_location',$value["sub_location"])->where('space_id',$value["space_idleave_empty_if_not_yet_assigned_by_the_system"])->orderBy('id','desc')->limit(1)->value('space_id');


                            if($existing_space_id==null) {


                                $code_name = DB::table('space_classification')->where('minor_industry', $value["minor_industry"])->value('code_name');

                                if ($code_name == '') {

                                    return back()->with('errors', 'Space code name does not exist. Please consult with the system Administrator');

                                } else {


                                }


                                $space_id_number = DB::table('spaces')->where('space_id_code', $code_name)->orderBy('id', 'desc')->limit(1)->value('space_id_number');


                                $integer = '';
                                $incremented = '';
                                $new_space_id_number = '';


                                if ($space_id_number != "") {


                                    $integer = ltrim($space_id_number, '0');
                                    $incremented = $integer + 1;
                                    $new_space_id_number = sprintf("%04d", $incremented);

                                } else {


                                    $incremented = 1;
                                    $new_space_id_number = sprintf("%04d", $incremented);

                                }

                                $final_space_id = $code_name . '' . $new_space_id_number;



                                //create new space starts

                                $space= new space();
                                $space->space_id=$final_space_id;
                                $space->space_id_code=$code_name;
                                $space->space_id_number=$new_space_id_number;
                                $space->major_industry=$value["major_industry"];
                                $space->location=$value["location"];
                                $space->size='';
                                $space->rent_price_guide_checkbox=0;
                                $space->sub_location=$value["sub_location"];
                                $space->minor_industry=$value["minor_industry"];
                                $space->comments='';
                                $space->flag=2;
                                $space->has_water_bill_space=$value["has_water_billyes_or_no"];
                                $space->has_electricity_bill_space=$value["has_electricity_billyes_or_no"];

                                $space->save();

                                //create new space ends





                            }else{

                                $final_space_id=$existing_space_id;

                            }


                        }

//space code ends




                        $space_contract= new space_contract();

                        $space_contract->space_id_contract=$final_space_id;
                        $space_contract->academic_dependence=$value["academic_calendar_dependenceyes_or_no"];
                        $space_contract->amount=$amount_total;
                        $space_contract->currency=$value["currencytzs_or_usd"];
                        $space_contract->payment_cycle=$value["payment_cycle_in_months123_etc"];
                        $space_contract->start_date=$value["start_date"];
                        $space_contract->end_date=$value["end_date"];
                        $space_contract->full_name=$full_name;
                        $space_contract->escalation_rate=$value["escalation_rateempty_if_depend_on_academic_calendar"];
                        $space_contract->programming_end_date=$value["current_payment_cycle_end_date"];
                        $space_contract->programming_start_date=$value["current_payment_cycle_start_date"];
                        $space_contract->has_water_bill=$value["has_water_billyes_or_no"];
                        $space_contract->has_electricity_bill=$value["has_electricity_billyes_or_no"];
                        $space_contract->duration=$value["contract_duration"];
                        $space_contract->duration_period=$value["contract_durationyears_or_months"];
                        $space_contract->rent_sqm=$value["rentsqm"];
                        $space_contract->vacation_season=$vacation_season_total;
                        $space_contract->academic_season=$academic_season_total;
                        $space_contract->contract_category=$value["contract_categorysolicited_or_unsolicited"];
                        $space_contract->has_additional_businesses=$value["additional_businesses_in_the_areayes_or_no"];
                        $space_contract->additional_businesses_amount=$value["amount_to_be_paid_for_additional_businesses_in_the_areaempty_if_no_additional_businesses"];
                        $space_contract->additional_businesses_list=$value["list_of_additional_businessesempty_if_none"];
                        $space_contract->security_deposit=$value["security_deposit0_if_not_applicable"];
                        $space_contract->has_clients=$has_clients;
                        $space_contract->under_client=$under_client;
                        $space_contract->parent_client=$value["parent_client_idempty_if_na"];
                        $space_contract->client_type_contract=$value["client_typedirectdirect_and_has_clientsindirect"];
                        $space_contract->escalation_rate_vacation=$value["escalation_rate_vacation_seasonempty_if_na"];
                        $space_contract->escalation_rate_academic=$value["escalation_rate_academic_seasonempty_if_na"];
                        $space_contract->contract_stage=3;

                        $space_contract->save();



                        if(date('Y-m-d')>$value["end_date"]){

                            $spaces=space::where('space_id', $final_space_id)->first();
                            $spaces->occupation_status=1;
                            $spaces->save();

                        }


                    }
                }



                //space contract insert code ends



            }

//            if(!empty($insert_data))
//            {
//                DB::table('tbl_customer')->insert($insert_data);
//            }
        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function spaceContractsFormat()
    {



        $data=SpaceContractsFormat::join('clients','clients.full_name','=','space_contracts_format.full_name')->join('spaces','spaces.space_id','=','space_contracts_format.space_id_contract')->select('type as Client Category(Company/Organization,Individual)','first_name as First Name(Empty for company case)','last_name as Last Name(Empty for company case)','company_name as Company Name(Empty for Individual case)','official_client_id as Client ID','email as Email','phone_number as Phone Number','address as Address','client_type_contract as Client Type(Direct,Direct and has clients,Indirect)','space_id as Space ID(Leave Empty if not yet assigned by the system)','major_industry as Major Industry','minor_industry as Minor Industry','location as Location','sub_location as Sub Location','has_water_bill_space as Has Water Bill?(Yes or No)','has_electricity_bill_space as Has Electricity Bill?(Yes or No)','contract_category as Contract Category(Solicited or Unsolicited)','tin as TIN','duration as Contract Duration','duration_period as Contract Duration(Years or Months)','start_date as Start Date','end_date as End Date','academic_dependence as Academic Calendar Dependence(Yes or No)','academic_season as Academic Season Amount(Includes additional businesses.Empty if not applicable)','vacation_season as Vacation Season Amount(Includes additional businesses.Empty if not applicable)','amount as Amount(Includes additional businesses.Leave Empty if depends on academic calendar)','rent_sqm as Rent/SQM','has_additional_businesses as Additional Businesses in the Area?(Yes or No)','additional_businesses_list as List of Additional Businesses(Empty if none)','additional_businesses_amount as Amount to be paid for additional businesses in the area(Empty if no additional businesses)','security_deposit as Security Deposit(0 if not applicable)','currency as Currency(TZS or USD)','payment_cycle as Payment Cycle in Months(1,2,3 etc)','escalation_rate as Escalation Rate(Empty if depend on academic calendar)','escalation_rate_vacation as Escalation Rate Vacation Season(Empty if N/A)','escalation_rate_academic as Escalation Rate Academic Season(Empty if N/A)','parent_client as Parent Client ID(Empty if N/A)','programming_start_date as Current Payment Cycle Start Date','programming_end_date as Current Payment Cycle End Date','contract_status as Contract Status(0 for Terminated, 1 for either Active or Expired)')->get();


        $excel = App::make('excel');
        $excel->create('real_estate_contracts_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');




    }






    public function importResearchContracts(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();



        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {



                $research_flats_contract= new research_flats_contract();
                $research_flats_contract->client_category=$value['client_category'];
                $research_flats_contract->client_type=$value['client_type'];
                $research_flats_contract->campus_individual=$value['campusclient'];
                $research_flats_contract->college_individual=$value['collegeclient'];
                $research_flats_contract->department_individual=$value['departmentclient'];
                $research_flats_contract->first_name=$value['first_nameclient'];
                $research_flats_contract->last_name=$value['last_nameclient'];
                $research_flats_contract->gender=$value['genderclient'];
                $research_flats_contract->professional=$value["professionalclient"];
                $research_flats_contract->address=$value["addressclient"];
                $research_flats_contract->email=$value["emailclient"];
                $research_flats_contract->phone_number=$value["phone_numberclient"];
                $research_flats_contract->tin=$value["tinclient"];
                $research_flats_contract->nationality=$value["nationalityclient"];
                $research_flats_contract->purpose=$value["purpose_of_visit"];
                $research_flats_contract->passport_no=$value["passport_numberclient"];
                $research_flats_contract->issue_date=$value["issue_date"];
                $research_flats_contract->issue_place=$value["issue_place"];
                $research_flats_contract->id_type=$value["type_of_identification_card"];
                $research_flats_contract->id_number=$value["identification_card_number"];
                $research_flats_contract->host_name=$value["full_namehost"];
                $research_flats_contract->campus_host=$value["campushost"];
                $research_flats_contract->college_host=$value["collegehost"];
                $research_flats_contract->department_host=$value["departmenthost"];
                $research_flats_contract->host_address=$value["addresshost"];
                $research_flats_contract->host_email=$value["emailhost"];
                $research_flats_contract->host_phone=$value["phone_numberhost"];
                $research_flats_contract->room_no=$value["room_no"];
                $research_flats_contract->arrival_date=$value["date_of_arrival"];
                $research_flats_contract->arrival_time=$value["time_of_arrival"];
                $research_flats_contract->departure_date=$value["date_of_departure"];
                $research_flats_contract->payment_mode=$value["mode_of_payment"];
                $research_flats_contract->amount_usd=$value["room_rateusd"];
                $research_flats_contract->amount_tzs=$value["room_ratetzs"];
                $research_flats_contract->total_usd=$value["total_usd"];
                $research_flats_contract->total_tzs=$value["total_tzs"];
                $research_flats_contract->receipt_no=$value["receipt_no"];
                $research_flats_contract->receipt_date=$value["receipt_date" ];
                $research_flats_contract->total_days=$value["total_no._of_days"];
                $research_flats_contract->invoice_debtor=$value["invoice_debtor" ];
                $research_flats_contract->invoice_currency=$value["invoice_currency"];

                $research_flats_contract->save();


            }

//            if(!empty($insert_data))
//            {
//                DB::table('tbl_customer')->insert($insert_data);
//            }
        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function researchContractsFormat()
    {


        $data=ResearchContractsFormat::select('client_category as Client Category(Domestic or Foreigner)','client_type as Client Type(Internal or External)','campus_individual as Campus(Client)','college_individual as College(Client)','department_individual as Department(Client)','first_name as First Name(Client)','last_name as Last Name(Client)','gender as Gender(Client)-Female or Male','professional as Professional(Client)','address as Address(Client)','email as Email(Client)','phone_number as Phone Number(Client)','tin as TIN(Client)','nationality as Nationality(Client)','purpose as Purpose of Visit','passport_no as Passport Number(Client)','issue_date as Issue Date','issue_place as Issue Place','id_type as Type of Identification Card(National Identity Card, Driving Licence, Voters Card, Workers Identity Card)','id_number as Identification Card Number','host_name as Full name(Host)','campus_host as Campus(Host)','college_host as College(Host)','department_host as Department(Host)','host_address as Address(Host)','host_email as Email(Host)','host_phone as Phone Number(Host)','room_no as Room No(Room 01,Room 02, Room 03, Room 04 or Room 05)','arrival_date as Date of Arrival','arrival_time as Time of Arrival','departure_date as Date of Departure','payment_mode as Mode of Payment','amount_usd as Room Rate(USD)','amount_tzs as Room Rate(TZS)','total_usd as Total (USD)','total_tzs as Total (TZS)','receipt_no as Receipt No','receipt_date as Receipt Date','total_days as Total No. of days','invoice_debtor as Invoice Debtor(Individual or Host)','invoice_currency as Invoice Currency(USD or TZS)')->get();


        $excel = App::make('excel');
        $excel->create('research_contracts_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');




    }






    public function importInsuranceContracts(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();



        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {


                $insurance_contract= new insurance_contract();
                $insurance_contract->full_name=$value["client_full_name"];
                $insurance_contract->phone_number=$value["phone_number"];
                $insurance_contract->email=$value["email"];
                $insurance_contract->tin=$value["tin"];
                $insurance_contract->insurance_class=$value["insurance_classmotor_money_marine_liability_fidelity_guarantee_or_fire"];
                $insurance_contract->principal=$value["principal"];
                $insurance_contract->vehicle_use=$value["vehicle_classprivate_carsmcycle3_wheelerscommercial_vehiclespassenger_carrying_or_special_type_vehicles"];
                $insurance_contract->insurance_type=$value["insurance_type"];
                $insurance_contract->vehicle_registration_no=$value["vehicle_registration_no"];
                $insurance_contract->commission_date=$value["commission_date"];
                $insurance_contract->end_date=$value["end_date"];
                $insurance_contract->duration=$value["duration"];
                $insurance_contract->duration_period=$value["durationyears_or_months"];
                $insurance_contract->value=$value["value"];
                $insurance_contract->sum_insured=$value["sum_insured"];
                $insurance_contract->premium=$value["premium"];
                $insurance_contract->mode_of_payment=$value["payment_modeby_installment_or_full_payment"];
                $insurance_contract->number_of_installments=$value["number_of_installments"];
                $insurance_contract->first_installment=$value["first_installment"];
                $insurance_contract->second_installment=$value["second_installment"];
                $insurance_contract->third_installment=$value["third_installment"];
                $insurance_contract->fourth_installment=$value["fourth_installment"];
                $insurance_contract->fifth_installment=$value["fifth_installment"];
                $insurance_contract->sixth_installment=$value["sixth_installment"];
                $insurance_contract->seventh_installment=$value["seventh_installment"];
                $insurance_contract->eighth_installment=$value["eighth_installment"];
                $insurance_contract->ninth_installment=$value["ninth_installment"];
                $insurance_contract->tenth_installment=$value["tenth_installment"];
                $insurance_contract->eleventh_installment=$value["eleventh_installment"];
                $insurance_contract->twelfth_installment=$value["twelfth_installment"];
                $insurance_contract->actual_ex_vat=$value["actual_excluding_vat"];
                $insurance_contract->commission_percentage=$value["commission_percentage"];
                $insurance_contract->commission=$value["commission"];
                $insurance_contract->currency=$value["currencytzs_or_usd"];
                $insurance_contract->receipt_no=$value["receipt_no"];
                $insurance_contract->cover_note=$value["cover_note"];
                $insurance_contract->sticker_no=$value["sticker_no"];
                $insurance_contract->remarks=$value["remarks" ];


                $insurance_contract->save();


            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function insuranceContractsFormat()
    {


        $data=insurance_contracts_format::select('full_name as Client Full Name','phone_number as Phone Number','email as Email','tin as TIN','insurance_class as Insurance Class(MOTOR, MONEY, MARINE, LIABILITY, FIDELITY GUARANTEE or FIRE)','principal as Principal','vehicle_use as Vehicle Class(Private cars,M/cycle/3 Wheelers,commercial vehicles,passenger carrying or special type vehicles)','insurance_type as Insurance Type','vehicle_registration_no as Vehicle Registration No','commission_date as Commission Date','end_date as End Date','duration as Duration','duration_period as Duration(Years or Months)','value as Value','sum_insured as Sum Insured','premium as Premium','mode_of_payment as Payment Mode(By installment or Full payment)','number_of_installments as Number of Installments','first_installment as First Installment','second_installment as Second Installment','third_installment as Third Installment','fourth_installment as Fourth Installment','fifth_installment as Fifth Installment','sixth_installment as Sixth Installment','seventh_installment as Seventh Installment','eighth_installment as Eighth Installment','ninth_installment as Ninth Installment','tenth_installment as Tenth Installment','eleventh_installment as Eleventh Installment','twelfth_installment as Twelfth Installment','actual_ex_vat as Actual (Excluding VAT)','commission_percentage as Commission Percentage','commission as Commission','currency as Currency(TZS OR USD)','receipt_no as Receipt No','cover_note as Cover Note','sticker_no as Sticker No','remarks as Remarks')->get();


        $excel = App::make('excel');
        $excel->create('insurance_contracts_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');




    }




    public function importSpacePayments(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();



        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {



                $research_flats_contract= new research_flats_contract();
                $research_flats_contract->client_category=$value['client_category'];
                $research_flats_contract->client_type=$value['client_type'];
                $research_flats_contract->campus_individual=$value['campusclient'];
                $research_flats_contract->college_individual=$value['collegeclient'];
                $research_flats_contract->department_individual=$value['departmentclient'];
                $research_flats_contract->first_name=$value['first_nameclient'];
                $research_flats_contract->last_name=$value['last_nameclient'];
                $research_flats_contract->gender=$value['genderclient'];
                $research_flats_contract->professional=$value["professionalclient"];
                $research_flats_contract->address=$value["addressclient"];
                $research_flats_contract->email=$value["emailclient"];
                $research_flats_contract->phone_number=$value["phone_numberclient"];
                $research_flats_contract->tin=$value["tinclient"];
                $research_flats_contract->nationality=$value["nationalityclient"];
                $research_flats_contract->purpose=$value["purpose_of_visit"];
                $research_flats_contract->passport_no=$value["passport_numberclient"];
                $research_flats_contract->issue_date=$value["issue_date"];
                $research_flats_contract->issue_place=$value["issue_place"];
                $research_flats_contract->id_type=$value["type_of_identification_card"];
                $research_flats_contract->id_number=$value["identification_card_number"];
                $research_flats_contract->host_name=$value["full_namehost"];
                $research_flats_contract->campus_host=$value["campushost"];
                $research_flats_contract->college_host=$value["collegehost"];
                $research_flats_contract->department_host=$value["departmenthost"];
                $research_flats_contract->host_address=$value["addresshost"];
                $research_flats_contract->host_email=$value["emailhost"];
                $research_flats_contract->host_phone=$value["phone_numberhost"];
                $research_flats_contract->room_no=$value["room_no"];
                $research_flats_contract->arrival_date=$value["date_of_arrival"];
                $research_flats_contract->arrival_time=$value["time_of_arrival"];
                $research_flats_contract->departure_date=$value["date_of_departure"];
                $research_flats_contract->payment_mode=$value["mode_of_payment"];
                $research_flats_contract->amount_usd=$value["room_rateusd"];
                $research_flats_contract->amount_tzs=$value["room_ratetzs"];
                $research_flats_contract->total_usd=$value["total_usd"];
                $research_flats_contract->total_tzs=$value["total_tzs"];
                $research_flats_contract->receipt_no=$value["receipt_no"];
                $research_flats_contract->receipt_date=$value["receipt_date" ];
                $research_flats_contract->total_days=$value["total_no._of_days"];
                $research_flats_contract->invoice_debtor=$value["invoice_debtor" ];
                $research_flats_contract->invoice_currency=$value["invoice_currency"];

                $research_flats_contract->save();


            }

//            if(!empty($insert_data))
//            {
//                DB::table('tbl_customer')->insert($insert_data);
//            }
        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function spacePaymentsFormat()
    {


        $data=App\space_payment::select('client_category as Client Category(Domestic or Foreigner)','client_type as Client Type(Internal or External)','campus_individual as Campus(Client)','college_individual as College(Client)','department_individual as Department(Client)','first_name as First Name(Client)','last_name as Last Name(Client)','gender as Gender(Client)-Female or Male','professional as Professional(Client)','address as Address(Client)','email as Email(Client)','phone_number as Phone Number(Client)','tin as TIN(Client)','nationality as Nationality(Client)','purpose as Purpose of Visit','passport_no as Passport Number(Client)','issue_date as Issue Date','issue_place as Issue Place','id_type as Type of Identification Card(National Identity Card, Driving Licence, Voters Card, Workers Identity Card)','id_number as Identification Card Number','host_name as Full name(Host)','campus_host as Campus(Host)','college_host as College(Host)','department_host as Department(Host)','host_address as Address(Host)','host_email as Email(Host)','host_phone as Phone Number(Host)','room_no as Room No(Room 01,Room 02, Room 03, Room 04 or Room 05)','arrival_date as Date of Arrival','arrival_time as Time of Arrival','departure_date as Date of Departure','payment_mode as Mode of Payment','amount_usd as Room Rate(USD)','amount_tzs as Room Rate(TZS)','total_usd as Total (USD)','total_tzs as Total (TZS)','receipt_no as Receipt No','receipt_date as Receipt Date','total_days as Total No. of days','invoice_debtor as Invoice Debtor(Individual or Host)','invoice_currency as Invoice Currency(USD or TZS)')->get();


        $excel = App::make('excel');
        $excel->create('research_contracts_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');




    }





    public function importSpaces(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();



        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {


                if($value["space_idleave_empty_if_not_yet_generated_by_the_system"]==null){


                    $code_name = DB::table('space_classification')->where('minor_industry', $value["sub_category"])->value('code_name');

                    if ($code_name == '') {

                        return back()->with('errors', 'Space code name does not exist. Please consult with the system Administrator');

                    } else {


                    }


                    $space_id_number = DB::table('spaces')->where('space_id_code', $code_name)->orderBy('id', 'desc')->limit(1)->value('space_id_number');


                    $integer = '';
                    $incremented = '';
                    $new_space_id_number = '';


                    if ($space_id_number != "") {


                        $integer = ltrim($space_id_number, '0');
                        $incremented = $integer + 1;
                        $new_space_id_number = sprintf("%04d", $incremented);

                    } else {


                        $incremented = 1;
                        $new_space_id_number = sprintf("%04d", $incremented);

                    }

                    $final_space_id = $code_name . '' . $new_space_id_number;



                    //create new space starts

                    $space= new space();
                    $space->space_id=$final_space_id;
                    $space->space_id_code=$code_name;
                    $space->space_id_number=$new_space_id_number;
                    $space->major_industry=$value["category"];
                    $space->location=$value["locationj.k_nyereremabibomikochenikijitonyamaubungokunduchi_or_mlimani_city"];
                    $space->sub_location=$value["sub_location"];
                    $space->size=$value["sizesqm"];
                    $space->rent_price_guide_checkbox=$value["has_rent_price_guide1_for_yes_or_0_for_no"];
                    $space->rent_price_guide_from=$value["rent_price_guidefrom_leave_empty_if_na"];
                    $space->rent_price_guide_to=$value["rent_price_guideto_leave_empty_if_na"];
                    $space->rent_price_guide_currency=$value["rent_price_guidecurrency"];
                    $space->minor_industry=$value["sub_category"];
                    $space->comments=$value["remarks"];
                    $space->flag=2;
                    $space->has_water_bill_space=$value["has_water_billyes_or_no"];
                    $space->has_electricity_bill_space=$value["has_electricity_billyes_or_no"];
                    $space->occupation_status=$value["occupational_status1_for_occupied_0_for_vacant"];

                    $space->save();

                    //create new space ends

                }else{

                    $existing_space_id=DB::table('spaces')->where('major_industry',$value["category"])->where('minor_industry',$value["sub_category"])->where('location',$value["locationj.k_nyereremabibomikochenikijitonyamaubungokunduchi_or_mlimani_city"])->where('sub_location',$value["sub_location"])->where('space_id',$value["space_idleave_empty_if_not_yet_generated_by_the_system"])->orderBy('id','desc')->limit(1)->value('space_id');


                    if($existing_space_id==null) {



                        $code_name = DB::table('space_classification')->where('minor_industry', $value["sub_category"])->value('code_name');

                        if ($code_name == '') {

                            return back()->with('errors', 'Space code name does not exist. Please consult with the system Administrator');

                        } else {


                        }


                        $space_id_number = DB::table('spaces')->where('space_id_code', $code_name)->orderBy('id', 'desc')->limit(1)->value('space_id_number');


                        $integer = '';
                        $incremented = '';
                        $new_space_id_number = '';


                        if ($space_id_number != "") {


                            $integer = ltrim($space_id_number, '0');
                            $incremented = $integer + 1;
                            $new_space_id_number = sprintf("%04d", $incremented);

                        } else {


                            $incremented = 1;
                            $new_space_id_number = sprintf("%04d", $incremented);

                        }

                        $final_space_id = $code_name . '' . $new_space_id_number;



                        //create new space starts

                        $space= new space();
                        $space->space_id=$final_space_id;
                        $space->space_id_code=$code_name;
                        $space->space_id_number=$new_space_id_number;
                        $space->major_industry=$value["category"];
                        $space->location=$value["locationj.k_nyereremabibomikochenikijitonyamaubungokunduchi_or_mlimani_city"];
                        $space->sub_location=$value["sub_location"];
                        $space->size=$value["sizesqm"];
                        $space->rent_price_guide_checkbox=$value["has_rent_price_guide1_for_yes_or_0_for_no"];
                        $space->rent_price_guide_from=$value["rent_price_guidefrom_leave_empty_if_na"];
                        $space->rent_price_guide_to=$value["rent_price_guideto_leave_empty_if_na"];
                        $space->rent_price_guide_currency=$value["rent_price_guidecurrency"];
                        $space->minor_industry=$value["sub_category"];
                        $space->comments=$value["remarks"];
                        $space->flag=2;
                        $space->has_water_bill_space=$value["has_water_billyes_or_no"];
                        $space->has_electricity_bill_space=$value["has_electricity_billyes_or_no"];
                        $space->occupation_status=$value["occupational_status1_for_occupied_0_for_vacant"];

                        $space->save();

                        //create new space ends


                    }else{




                    }



                }







            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function spacesFormat()
    {


        $data=App\spaces_format::select('space_id as Space ID(Leave Empty if not yet generated by the system)','major_industry as Category','minor_industry as Sub Category','location as Location(J.K Nyerere,Mabibo,Mikocheni,Kijitonyama,Ubungo,Kunduchi or Mlimani city)','sub_location as Sub Location','size as Size(SQM)','has_electricity_bill_space as Has Electricity Bill?(Yes or No)','has_water_bill_space as Has Water Bill?(Yes or No)','rent_price_guide_checkbox as Has Rent Price Guide?(1 for Yes or 0 for No)','rent_price_guide_from as Rent Price Guide(From)-Leave Empty if N/A','rent_price_guide_to as Rent Price Guide(To)-Leave Empty if N/A','rent_price_guide_currency as Rent Price Guide(Currency)','occupation_status as Occupational status(1 for Occupied, 0 for Vacant)','comments as Remarks')->get();


        $excel = App::make('excel');
        $excel->create('real_estate_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');




    }





    public function importCarContracts(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();



        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {






                $car_contract= new App\carContract();
                $car_contract->first_name=$value["first_name"];
                $car_contract->last_name=$value["last_name"];
                $car_contract->fullName=$value["first_name"].' '.$value["last_name"];
                $car_contract->area_of_travel=$value["area_of_travelwithin_or_outside"];
                $car_contract->designation=$value["designation"];
                $car_contract->email=$value["email"];
                $car_contract->tin=$value["tin"];
                $car_contract->cost_centre=$value["cost_centre_id"];
                $car_contract->faculty=$value["facultydepartmentunit"];
                $car_contract->start_date=$value["start_date"];
                $car_contract->end_date=$value["end_date"];
                $car_contract->start_time=$value["start_time"];
                $car_contract->end_time=$value["end_time"];
                $car_contract->overtime=$value["estimated_overtime_in_hrs"];
                $car_contract->overtime_hrs=$value["overtime_hours"];
                $car_contract->destination=$value["destination"];
                $car_contract->purpose=$value["purposereason_of_the_trip"];
                $car_contract->trip_nature=$value["nature_of_the_tripdepartmentalprivate_or_emergency"];
                $car_contract->estimated_distance=$value["estimated_distance_in_km"];
                $car_contract->estimated_cost=$value["estimated_cost_in_tshs"];
                $car_contract->initial_payment=$value["initial_amountleave_empty_if_nature_of_trip_is_not_private"];
                $car_contract->funds_available=$value["funds_available"];
                $car_contract->transport_code=$value["transport_code_no"];
                $car_contract->balance_status=$value["are_the_funds_sufficientsufficient_or_not_sufficient"];
                $car_contract->vote_title=$value["vote_holder_title"];
                $car_contract->vehicle_reg_no=$value["vehicle_reg._no"];
                $car_contract->initial_speedmeter=$value["beginning_speedmeter_reading_in_km"];
                $car_contract->initial_speedmeter_time=$value["beginning_speedmeter_readingtime"];
                $car_contract->ending_speedmeter=$value["ending_speedmeter_reading_in_km"];
                $car_contract->ending_speedmeter_time=$value["ending_speedmeter_readingtime"];
                $car_contract->overtime_hrs=$value["overtime_hours"];
                $car_contract->driver_name=$value["name_of_driver"];
                $car_contract->charge_km=$value["charge_per_milekm"];
                $car_contract->mileage_km=$value["mileage_covered_in_km"];
                $car_contract->mileage_tshs=$value["mileage_charges_tshs"];
                $car_contract->penalty_hrs=$value["penalty_hours"];
                $car_contract->penalty_amount=$value["penaltyamount"];
                $car_contract->overtime_charges=$value["overtime_charges_tshs"];
                $car_contract->total_charges=$value["total_charges"];
                $car_contract->standing_charges=$value["vehicle_standing_charge"];
                $car_contract->grand_total=$value["grand_total"];
                $car_contract->flag=1;
                $car_contract->form_completion=1;
                $car_contract->cptu_msg_status='inbox';
                $car_contract->head_approval_status='Accepted';
                $car_contract->form_status='Transport Officer-CPTU';
                $car_contract->save();


            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function carContractsFormat()
    {


        $data=App\car_contracts_format::select('area_of_travel as Area of Travel(Within or Outside)','first_name as First Name','last_name as Last Name','designation as Designation','email as Email','tin as TIN','cost_centre as Cost Centre ID','faculty as Faculty/Department/Unit','start_date as Start Date','end_date as End Date','start_time as Start Time','end_time as End Time','overtime as Estimated Overtime in Hrs','destination as Destination','purpose as Purpose/reason of the trip','trip_nature as Nature of the trip(Departmental,Private or Emergency)','estimated_distance as Estimated Distance in Km','estimated_cost as Estimated Cost in Tshs','initial_payment as Initial Amount(Leave Empty if nature of Trip is not Private)','funds_available as Funds Available','transport_code as Transport Code No','balance_status as Are the Funds Sufficient(Sufficient or Not Sufficient)','head_name as Name(The one who confirms the availability of funds for future payment- Transport officer or Accountant cost-centre)','head_date as Confirmation Date','vote_title as Vote Holder Title','fund_committed as Funds Committed','acc_name as Name(The one who confirms availability of funds- Transport officer or Accountant cost-centre)','acc_date as Confirmation Date','vehicle_reg_no as Vehicle Reg. No','dvc_name as Name(DVC Administration)','dvc_date as Date(DVC Administration)','initial_speedmeter as Beginning Speedmeter Reading in Km','initial_speedmeter_time as Beginning Speedmeter Reading(Time)','ending_speedmeter as Ending Speedmeter Reading in Km','ending_speedmeter_time as Ending Speedmeter Reading(Time)','overtime_hrs as Overtime hours','driver_name as Name of driver','driver_date as Date(For Driver)','charge_km as Charge per mile/Km','mileage_km as Mileage covered in Km','mileage_tshs as Mileage charges Tshs','penalty_hrs as Penalty hours','penalty_amount as Penalty(Amount)','overtime_charges as Overtime charges Tshs','total_charges as Total charges','standing_charges as Vehicle Standing charge','grand_total as GRAND TOTAL')->get();

        $excel = App::make('excel');
        $excel->create('car_contracts_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');



    }







    public function importLogSheets(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {



                $log_sheet= new App\log_sheet();
                $log_sheet->contract_id=$value["contract_number"];
                $log_sheet->date=$value["date"];
                $log_sheet->start_time=$value["start_time"];
                $log_sheet->mileage_out=$value["mileage_out"];
                $log_sheet->closing_time=$value["closing_time"];
                $log_sheet->mileage_in=$value["mileage_in"];
                $log_sheet->mileage=$value["mileage"];
                $log_sheet->standing_hrs=$value["standing_hours"];
                $log_sheet->standing_km=$value["standing_km"];
                $log_sheet->save();



            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function logSheetsFormat()
    {


        $data=App\log_sheets_format::select('contract_id as Contract Number','date as Date','start_time as Start Time','mileage_out as Mileage Out','closing_time as Closing Time','mileage_in as Mileage In','mileage as Mileage','standing_hrs as Standing Hours','standing_km as Standing Km')->get();

        $excel = App::make('excel');
        $excel->create('log_sheets_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }





    public function importResearchRooms(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {



                $research_flats_room= new App\research_flats_room();
                $research_flats_room->room_no=$value["room_number"];
                $research_flats_room->category=$value["categoryshared_roomsingle_room_or_suit_room"];
                $research_flats_room->charge_workers=$value["charging_price_for_workers"];
                $research_flats_room->charge_students=$value["charging_price_for_students"];
                $research_flats_room->currency=$value["currencytzs_or_usd"];
                $research_flats_room->status=1;

                $research_flats_room->save();



            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function researchRoomsFormat()
    {


        $data=App\research_flats_rooms_format::select('room_no as Room Number','category as Category(Shared Room,Single Room or Suit Room)','charge_workers as Charging Price for Workers','charge_students as Charging Price for Students','currency as Currency(TZS or USD)')->get();

        $excel = App::make('excel');
        $excel->create('rooms_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }









    public function importInsurancePackages(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {

                $insurance= new App\insurance();
                $insurance->class=$value["insurance_classmotormoneymarineliabilityfidelity_guarantee_or_fire"];
                $insurance->insurance_company=$value["insurance_companybritamnic_or_icea_lion"];
                $insurance->insurance_type=$value["insurance_typethird_partycomprehensive_or_na"];
                $insurance->commission_percentage=$value["commission_percentage"];
                $insurance->status=1;
                $insurance->save();


            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function insurancePackagesFormat()
    {


        $data=App\insurance_format::select('class as Insurance Class(MOTOR,MONEY,MARINE,LIABILITY,FIDELITY GUARANTEE or FIRE)','insurance_company as Insurance Company(BRITAM,NIC or ICEA LION)','insurance_type as Insurance Type(THIRD PARTY,COMPREHENSIVE or N/A)','commission_percentage as Commission Percentage')->get();

        $excel = App::make('excel');
        $excel->create('insurance_packages_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }





    public function importHireRate(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {

                $insurance= new App\hire_rate();
                $insurance->vehicle_model=$value["vehicle_model"];
                $insurance->hire_rate=$value["hire_rate"];
                $insurance->flag=1;
                $insurance->save();


            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function hireRateFormat()
    {


        $data=App\hire_rate_format::select('vehicle_model as Vehicle Model','hire_rate as Hire Rate')->get();

        $excel = App::make('excel');
        $excel->create('hire_rates_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }







    public function importVehicles(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {




                $insurance= new App\carRental();
                $insurance->vehicle_reg_no=$value["vehicle_registration_number"];
                $insurance->vehicle_model=$value["vehicle_model"];
                $insurance->vehicle_status=$value["vehicle_statusrunningminor_repair_or_grounded"];
                $insurance->hire_rate=$value["hire_rate"];
                $insurance->flag=1;
                $insurance->save();


            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function vehiclesFormat()
    {


        $data=App\car_rental_format::select('vehicle_reg_no as Vehicle Registration Number','vehicle_model as Vehicle Model','vehicle_status as Vehicle Status(Running,Minor Repair or Grounded)','hire_rate as Hire Rate')->get();

        $excel = App::make('excel');
        $excel->create('vehicles_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }





    public function importCostCentres(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {

                $cost_centre= new App\cost_centre();
                $cost_centre->costcentre_id=$value["cost_centre_id"];
                $cost_centre->costcentre=$value["cost_centre_name"];
                $cost_centre->division_id=$value["division_id"];
                $cost_centre->status=1;
                $cost_centre->save();

            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function CostCentresFormat()
    {


        $data=App\cost_centres_format::select('costcentre_id as Cost Centre ID','costcentre as Cost Centre Name','division_id as Division ID')->get();

        $excel = App::make('excel');
        $excel->create('cost_centres_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }







    public function importInsuranceCompanies(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {

                $company= new App\insurance_parameter();
                $company->company=$value["company_name"];
                $company->company_email=$value["email"];
                $company->company_address=$value["address"];
                $company->company_tin=$value["tin"];
                $company->save();

            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function insuranceCompaniesFormat()
    {


        $data=App\insurance_companies_format::select('company as Company Name','company_email as Email','company_address as Address','company_tin as TIN')->get();

        $excel = App::make('excel');
        $excel->create('insurance_companies_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }






    public function importInsuranceClasses(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {

                $insurance_class= new App\insurance_parameter();
                $insurance_class->classes=$value["insurance_class"];
                $insurance_class->save();

            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function insuranceClassesFormat()
    {


        $data=App\insurance_classes_format::select('classes as Insurance Class')->get();

        $excel = App::make('excel');
        $excel->create('insurance_classes_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }







    public function importRoles(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {

                $role= new App\role();
                $role->user_roles=$value["role"];
                $role->category=$value["category"];
                $role->privileges=$value["privilegesread_only_or_read_add_edit_and_delete"];
                $role->save();

            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function rolesFormat()
    {


        $data=App\role_format::select('user_roles as Role','category as Category','privileges as Privileges(Read only or (Read, add, edit and delete))')->get();

        $excel = App::make('excel');
        $excel->create('roles_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }







    public function importUsers(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count() > 0)
        {
            foreach($data as  $value)
            {


                      $cost_centre='';

        if($value["cost_centrena_if_not_applicable"]==''){
            $cost_centre='N/A';

        }else{

            $cost_centre=$value["cost_centrena_if_not_applicable"];
        }

        $name=$value["first_name"].' '.$value["last_name"];

        $user_name=strtolower($value["first_name"][0]).strtolower($value["last_name"]);
        $existing_roles=DB::table('users')->where('user_name',$user_name)->get();

        foreach($existing_roles as $role){
            if (DB::table('users')->where('user_name', $user_name)->where('role',$value["role"])->exists()) {


                return redirect()->back()->with("error",'User with user name "'.$user_name.'" already exists in the system, Please Try again');

            }
        }

        $default_password=DB::table('system_settings')->where('id',1)->value('default_password');

                $user= new App\User();
                $user->name=$name;
                $user->first_name=$value["first_name"];
                $user->last_name=$value["last_name"];
                $user->user_name=$user_name;
                $user->email=$value["email"];
                $user->phone_number=$value["phone_number"];
                $user->role=$value["role"];
                $user->cost_centre=$cost_centre;
                $user->password=Hash::make($default_password);
                $user->password_flag=0;
                $user->save();

            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function usersFormat()
    {


        $data=App\users_format::select('first_name as First Name','last_name as Last Name','email as Email','phone_number as Phone Number','role as Role','cost_centre as Cost Centre(N/A if not applicable)')->get();

        $excel = App::make('excel');
        $excel->create('users_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }



    public function importSpaceInvoices(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count()> 0)
        {
            foreach($data as  $value)
            {



                $amount_in_words='';

                if($value["currencytzs_or_usd"]=='TZS'){
                    $amount_in_words=Terbilang::make($value["amount"],' TZS',' ');

                }

                if ($value["currencytzs_or_usd"]=='USD'){

                $amount_in_words=Terbilang::make($value["amount"],' USD',' ');
             }

            else{


            }


                $invoice= new App\invoice();
                $invoice->debtor_name=$value["debtor_name"];
                $invoice->debtor_account_code=$value["debtor_account_code"];
                $invoice->debtor_address=$value["debtor_address"];
                $invoice->tin=$value["tin"];
                $invoice->contract_id=$value["contract_number"];
                $invoice->invoice_number_votebook=$value["invoice_number"];
                $invoice->invoicing_period_start_date=$value["start_date"];
                $invoice->invoicing_period_end_date=$value["end_date"];
                $invoice->amount_to_be_paid=$value["amount"];
                $invoice->currency_invoice=$value["currencytzs_or_usd"];
                $invoice->period=$value["period"];
                $invoice->description=$value["description"];
                $invoice->status=$value["status"];
                $invoice->gepg_control_no=$value["gepg_control_number"];
                $invoice->payment_status=$value["payment_statuspaid_partially_paid_or_not_paid"];
                $invoice->inc_code=$value["incomeinc_code"];
                $invoice->project_id=$value["project_id"];
                $invoice->invoice_date=$value["invoice_date"];
                $invoice->financial_year=$value["financial_year"];
                $invoice->max_no_of_days_to_pay=$value["max_number_of_days_to_pay"];
                $invoice->prepared_by=$value["prepared_by"];
                $invoice->approved_by=$value["approved_by"];
                $invoice->user_comments=$value["comments"];
                $invoice->email_sent_status=$value["already_sent_to_clientnot_sent_or_sent"];
                $invoice->stage=3;
                $invoice->amount_in_words=$amount_in_words;

                $invoice->invoice_category='Space';

                if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                    $invoice->invoice_status=0;

                }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                    $invoice->invoice_status=1;
                }else{

                    return back()->with('error', 'Status of the invoice must be specified');


                }


                $invoice->save();



                if(strtolower($value["has_paymentyes_or_no"])=='yes'){

                    $invoice_number_created=DB::table('invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                    $space_payment= new App\space_payment();
                    $space_payment->invoice_number=$invoice_number_created;
                    $space_payment->invoice_number_votebook=$value["invoice_number"];
                    $space_payment->amount_paid=$value["amount_paid"];
                    $space_payment->amount_not_paid=$value["amount_not_paid"];
                    $space_payment->currency_payments=$value["currency_paymentstzs_or_usd"];
                    $space_payment->receipt_number=$value["receipt_number"];

                    if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                        $space_payment->status_payment=0;

                    }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                        $space_payment->status_payment=1;
                    }


                    $space_payment->stage=0;
                    $space_payment->date_of_payment=$value["date_of_payment"];
                    $space_payment->save();

                }else{



                }





            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function spaceInvoicesFormat()
    {

//        DB::table('invoices')->insert(
//            ['invoice_category'=>'Space'=>'stage'=>1]
//        );



        $data=App\invoices_format::join('space_payments_format','invoices_format.invoice_number','=','space_payments_format.invoice_number')->select('debtor_name as Debtor Name','debtor_account_code as Debtor Account Code','debtor_address as Debtor Address','tin as TIN','contract_id as Contract Number','invoices_format.invoice_number_votebook as Invoice Number','invoicing_period_start_date as Start Date','invoicing_period_end_date as End Date','amount_to_be_paid as Amount','currency_invoice as Currency(TZS or USD)','period as Period','project_id as Project ID','description as Description','status as Status','gepg_control_no as GePG Control Number','payment_status as Payment Status(Paid, Partially Paid or Not paid','inc_code as Income(inc) Code','invoice_date as Invoice Date','financial_year as Financial Year','max_no_of_days_to_pay as Max Number of Days to pay','prepared_by as Prepared By','approved_by as Approved By','user_comments as Comments','email_sent_status as Already sent to client?(NOT SENT or SENT)','invoice_status as Status of the invoice(OK or CANCELLED)','has_payment as Has Payment?(Yes or No)','amount_paid as Amount Paid','amount_not_paid as Amount Not Paid','space_payments_format.currency_payments as Currency Payments(TZS or USD)','receipt_number as Receipt Number','date_of_payment as Date of Payment')->get();

        $excel = App::make('excel');
        $excel->create('real_estate_invoices_payments_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }






    public function importWaterBillInvoices(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count()> 0)
        {
            foreach($data as  $value)
            {



                $amount_in_words='';

                if($value["currencytzs_or_usd"]=='TZS'){
                    $amount_in_words=Terbilang::make($value["amount_to_be_paidcumulative"],' TZS',' ');

                }

                if ($value["currencytzs_or_usd"]=='USD'){

                    $amount_in_words=Terbilang::make($value["amount_to_be_paidcumulative"],' USD',' ');
                }

                else{


                }


                $invoice= new App\water_bill_invoice();
                $invoice->debtor_name=$value["debtor_name"];
                $invoice->debtor_account_code=$value["debtor_account_code"];
                $invoice->debtor_address=$value["debtor_address"];
                $invoice->tin=$value["tin"];
                $invoice->contract_id=$value["contract_number"];
                $invoice->invoice_number_votebook=$value["invoice_number"];
                $invoice->invoicing_period_start_date=$value["start_date"];
                $invoice->invoicing_period_end_date=$value["end_date"];
                $invoice->debt=$value["debt"];
                $invoice->current_amount=$value["current_bill"];
                $invoice->cumulative_amount=$value["amount_to_be_paidcumulative"];
                $invoice->currency_invoice=$value["currencytzs_or_usd"];
                $invoice->period=$value["period"];
                $invoice->description=$value["description"];
                $invoice->status=$value["status"];
                $invoice->gepg_control_no=$value["gepg_control_number"];
                $invoice->payment_status=$value["payment_statuspaid_partially_paid_or_not_paid"];
                $invoice->inc_code=$value["incomeinc_code"];
                $invoice->project_id=$value["project_id"];
                $invoice->invoice_date=$value["invoice_date"];
                $invoice->financial_year=$value["financial_year"];
                $invoice->max_no_of_days_to_pay=$value["max_number_of_days_to_pay"];
                $invoice->prepared_by=$value["prepared_by"];
                $invoice->approved_by=$value["approved_by"];
                $invoice->user_comments=$value["comments"];
                $invoice->email_sent_status=$value["already_sent_to_clientnot_sent_or_sent"];

                $invoice->amount_in_words=$amount_in_words;

                $invoice->begin_units=$value["beginning_period_units"];
                $invoice->end_units=$value["ending_period_units"];
                $invoice->consumed_units=$value["units_consumed"];
                $invoice->unit_price=$value["unit_price"];

                $invoice->invoice_category='Water';
                $invoice->stage=3;

                if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                    $invoice->invoice_status=0;

                }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                    $invoice->invoice_status=1;
                }else{

                    return back()->with('error', 'Status of the invoice must be specified');


                }


                $invoice->save();



                if(strtolower($value["has_paymentyes_or_no"])=='yes'){

                    $invoice_number_created=DB::table('water_bill_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                    $payment= new App\water_bill_payment();
                    $payment->invoice_number=$invoice_number_created;
                    $payment->invoice_number_votebook=$value["invoice_number"];
                    $payment->amount_paid=$value["amount_paid"];
                    $payment->amount_not_paid=$value["amount_not_paid"];
                    $payment->currency_payments=$value["currency_paymentstzs_or_usd"];
                    $payment->receipt_number=$value["receipt_number"];

                    if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                        $payment->status_payment=0;

                    }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                        $payment->status_payment=1;
                    }



                    $payment->date_of_payment=$value["date_of_payment"];
                    $payment->save();

                }else{



                }





            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function waterBillInvoicesFormat()
    {

//        DB::table('invoices')->insert(
//            ['invoice_category'=>'Space'=>'stage'=>1]
//        );


        $data=App\water_bill_invoices_format::join('water_bill_payments_format','water_bill_invoices_format.invoice_number','=','water_bill_payments_format.invoice_number')->select('debtor_name as Debtor Name','debtor_account_code as Debtor Account Code','debtor_address as Debtor Address','tin as TIN','contract_id as Contract Number','water_bill_invoices_format.invoice_number_votebook as Invoice Number','invoicing_period_start_date as Start Date','invoicing_period_end_date as End Date','water_bill_invoices_format.debt as Debt','current_amount as Current Bill','cumulative_amount as Amount to be paid(Cumulative)','currency_invoice as Currency(TZS or USD)','begin_units as Beginning Period Units','end_units as Ending Period Units','consumed_units as Units Consumed','unit_price as Unit Price','period as Period','project_id as Project ID','description as Description','status as Status','gepg_control_no as GePG Control Number','payment_status as Payment Status(Paid, Partially Paid or Not paid','inc_code as Income(inc) Code','invoice_date as Invoice Date','financial_year as Financial Year','max_no_of_days_to_pay as Max Number of Days to pay','prepared_by as Prepared By','approved_by as Approved By','user_comments as Comments','email_sent_status as Already sent to client?(NOT SENT or SENT)','invoice_status as Status of the invoice(OK or CANCELLED)','has_payment as Has Payment?(Yes or No)','amount_paid as Amount Paid','amount_not_paid as Amount Not Paid','water_bill_payments_format.currency_payments as Currency Payments(TZS or USD)','receipt_number as Receipt Number','date_of_payment as Date of Payment')->get();

        $excel = App::make('excel');
        $excel->create('water_bill_invoices_payments_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }






    public function importElectricityBillInvoices(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count()> 0)
        {
            foreach($data as  $value)
            {



                $amount_in_words='';

                if($value["currencytzs_or_usd"]=='TZS'){
                    $amount_in_words=Terbilang::make($value["amount_to_be_paidcumulative"],' TZS',' ');

                }

                if ($value["currencytzs_or_usd"]=='USD'){

                    $amount_in_words=Terbilang::make($value["amount_to_be_paidcumulative"],' USD',' ');
                }

                else{


                }


                $invoice= new App\electricity_bill_invoice();
                $invoice->debtor_name=$value["debtor_name"];
                $invoice->debtor_account_code=$value["debtor_account_code"];
                $invoice->debtor_address=$value["debtor_address"];
                $invoice->tin=$value["tin"];
                $invoice->contract_id=$value["contract_number"];
                $invoice->invoice_number_votebook=$value["invoice_number"];
                $invoice->invoicing_period_start_date=$value["start_date"];
                $invoice->invoicing_period_end_date=$value["end_date"];
                $invoice->debt=$value["debt"];
                $invoice->current_amount=$value["current_bill"];
                $invoice->cumulative_amount=$value["amount_to_be_paidcumulative"];
                $invoice->currency_invoice=$value["currencytzs_or_usd"];
                $invoice->period=$value["period"];
                $invoice->description=$value["description"];
                $invoice->status=$value["status"];
                $invoice->gepg_control_no=$value["gepg_control_number"];
                $invoice->payment_status=$value["payment_statuspaid_partially_paid_or_not_paid"];
                $invoice->inc_code=$value["incomeinc_code"];
                $invoice->project_id=$value["project_id"];
                $invoice->invoice_date=$value["invoice_date"];
                $invoice->financial_year=$value["financial_year"];
                $invoice->max_no_of_days_to_pay=$value["max_number_of_days_to_pay"];
                $invoice->prepared_by=$value["prepared_by"];
                $invoice->approved_by=$value["approved_by"];
                $invoice->user_comments=$value["comments"];
                $invoice->email_sent_status=$value["already_sent_to_clientnot_sent_or_sent"];

                $invoice->amount_in_words=$amount_in_words;

                $invoice->begin_units=$value["beginning_period_units"];
                $invoice->end_units=$value["ending_period_units"];
                $invoice->consumed_units=$value["units_consumed"];
                $invoice->unit_price=$value["unit_price"];

                $invoice->invoice_category='Electricity';
                $invoice->stage=3;

                if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                    $invoice->invoice_status=0;

                }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                    $invoice->invoice_status=1;
                }else{

                    return back()->with('error', 'Status of the invoice must be specified');


                }


                $invoice->save();



                if(strtolower($value["has_paymentyes_or_no"])=='yes'){

                    $invoice_number_created=DB::table('electricity_bill_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                    $payment= new App\electricity_bill_payment();
                    $payment->invoice_number=$invoice_number_created;
                    $payment->invoice_number_votebook=$value["invoice_number"];
                    $payment->amount_paid=$value["amount_paid"];
                    $payment->amount_not_paid=$value["amount_not_paid"];
                    $payment->currency_payments=$value["currency_paymentstzs_or_usd"];
                    $payment->receipt_number=$value["receipt_number"];

                    if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                        $payment->status_payment=0;

                    }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                        $payment->status_payment=1;
                    }



                    $payment->date_of_payment=$value["date_of_payment"];
                    $payment->save();

                }else{



                }





            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function electricityBillInvoicesFormat()
    {

//        DB::table('invoices')->insert(
//            ['invoice_category'=>'Space'=>'stage'=>1]
//        );


        $data=App\electricity_bill_invoices_format::join('electricity_bill_payments_format','electricity_bill_invoices_format.invoice_number','=','electricity_bill_payments_format.invoice_number')->select('debtor_name as Debtor Name','debtor_account_code as Debtor Account Code','debtor_address as Debtor Address','tin as TIN','contract_id as Contract Number','electricity_bill_invoices_format.invoice_number_votebook as Invoice Number','invoicing_period_start_date as Start Date','invoicing_period_end_date as End Date','electricity_bill_invoices_format.debt as Debt','current_amount as Current Bill','cumulative_amount as Amount to be paid(Cumulative)','currency_invoice as Currency(TZS or USD)','begin_units as Beginning Period Units','end_units as Ending Period Units','consumed_units as Units Consumed','unit_price as Unit Price','period as Period','project_id as Project ID','description as Description','status as Status','gepg_control_no as GePG Control Number','payment_status as Payment Status(Paid, Partially Paid or Not paid','inc_code as Income(inc) Code','invoice_date as Invoice Date','financial_year as Financial Year','max_no_of_days_to_pay as Max Number of Days to pay','prepared_by as Prepared By','approved_by as Approved By','user_comments as Comments','email_sent_status as Already sent to client?(NOT SENT or SENT)','invoice_status as Status of the invoice(OK or CANCELLED)','has_payment as Has Payment?(Yes or No)','amount_paid as Amount Paid','amount_not_paid as Amount Not Paid','electricity_bill_payments_format.currency_payments as Currency Payments(TZS or USD)','receipt_number as Receipt Number','date_of_payment as Date of Payment')->get();

        $excel = App::make('excel');
        $excel->create('electricity_bill_invoices_payments_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }





    public function importCarInvoices(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count()> 0)
        {
            foreach($data as  $value)
            {



                $amount_in_words='';

                if($value["currencytzs_or_usd"]=='TZS'){
                    $amount_in_words=Terbilang::make($value["amount"],' TZS',' ');

                }

                if ($value["currencytzs_or_usd"]=='USD'){

                    $amount_in_words=Terbilang::make($value["amount"],' USD',' ');
                }

                else{


                }


                $invoice= new App\car_rental_invoice();
                $invoice->debtor_name=$value["debtor_name"];
                $invoice->debtor_account_code=$value["debtor_account_code"];
                $invoice->debtor_address=$value["debtor_address"];
                $invoice->tin=$value["tin"];
                $invoice->vrn=$value["vrn"];
                $invoice->contract_id=$value["contract_number"];
                $invoice->invoice_number_votebook=$value["invoice_number"];
                $invoice->invoicing_period_start_date=$value["start_date"];
                $invoice->invoicing_period_end_date=$value["end_date"];
                $invoice->amount_to_be_paid=$value["amount"];
                $invoice->currency_invoice=$value["currencytzs_or_usd"];
                $invoice->period=$value["period"];
                $invoice->description=$value["description"];
                $invoice->status=$value["status"];
                $invoice->gepg_control_no=$value["gepg_control_numberleave_empty_if_na"];
                $invoice->account_no=$value["account_numberleave_empty_if_na"];
                $invoice->payment_status=$value["payment_statuspaid_partially_paid_or_not_paid"];
                $invoice->inc_code=$value["incomeinc_code"];
                $invoice->project_id=$value["project_id"];
                $invoice->invoice_date=$value["invoice_date"];
                $invoice->financial_year=$value["financial_year"];
                $invoice->max_no_of_days_to_pay=$value["max_number_of_days_to_pay"];
                $invoice->prepared_by=$value["prepared_by"];
                $invoice->approved_by=$value["approved_by"];
                $invoice->user_comments=$value["comments"];
                $invoice->email_sent_status=$value["already_sent_to_clientnot_sent_or_sent"];
                $invoice->stage=2;
                $invoice->amount_in_words=$amount_in_words;

                $invoice->invoice_category='Car Rental';

                if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                    $invoice->invoice_status=0;

                }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                    $invoice->invoice_status=1;
                }else{

                    return back()->with('error', 'Status of the invoice must be specified');


                }


                $invoice->save();



                if(strtolower($value["has_paymentyes_or_no"])=='yes'){

                    $invoice_number_created=DB::table('car_rental_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                    $payment= new App\car_rental_payment();
                    $payment->invoice_number=$invoice_number_created;
                    $payment->invoice_number_votebook=$value["invoice_number"];
                    $payment->amount_paid=$value["amount_paid"];
                    $payment->amount_not_paid=$value["amount_not_paid"];
                    $payment->currency_payments=$value["currency_paymentstzs_or_usd"];
                    $payment->receipt_number=$value["receipt_number"];

                    if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                        $payment->status_payment=0;

                    }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                        $payment->status_payment=1;
                    }



                    $payment->date_of_payment=$value["date_of_payment"];
                    $payment->save();

                }else{



                }





            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function carInvoicesFormat()
    {

//        DB::table('invoices')->insert(
//            ['invoice_category'=>'Space'=>'stage'=>1]
//        );



        $data=App\car_rental_invoices_format::join('car_rental_payments_format','car_rental_invoices_format.invoice_number','=','car_rental_payments_format.invoice_number')->select('debtor_name as Debtor Name','debtor_account_code as Debtor Account Code','debtor_address as Debtor Address','tin as TIN','vrn as VRN','contract_id as Contract Number','car_rental_invoices_format.invoice_number_votebook as Invoice Number','invoicing_period_start_date as Start Date','invoicing_period_end_date as End Date','amount_to_be_paid as Amount','currency_invoice as Currency(TZS or USD)','period as Period','project_id as Project ID','description as Description','status as Status','gepg_control_no as GePG Control Number(Leave empty if N/A)','account_no as Account Number(Leave empty if N/A)','payment_status as Payment Status(Paid, Partially Paid or Not paid','inc_code as Income(inc) Code','invoice_date as Invoice Date','financial_year as Financial Year','max_no_of_days_to_pay as Max Number of Days to pay','prepared_by as Prepared By','approved_by as Approved By','user_comments as Comments','email_sent_status as Already sent to client?(NOT SENT or SENT)','invoice_status as Status of the invoice(OK or CANCELLED)','has_payment as Has Payment?(Yes or No)','amount_paid as Amount Paid','amount_not_paid as Amount Not Paid','car_rental_payments_format.currency_payments as Currency Payments(TZS or USD)','receipt_number as Receipt Number','date_of_payment as Date of Payment')->get();

        $excel = App::make('excel');
        $excel->create('car_rental_invoices_payments_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }






    public function importResearchInvoices(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count()> 0)
        {
            foreach($data as  $value)
            {



                $amount_in_words='';

                if($value["currencytzs_or_usd"]=='TZS'){
                    $amount_in_words=Terbilang::make($value["amount"],' TZS',' ');

                }

                if ($value["currencytzs_or_usd"]=='USD'){

                    $amount_in_words=Terbilang::make($value["amount"],' USD',' ');
                }

                else{


                }


                $invoice= new App\research_flats_invoice();
                $invoice->debtor_name=$value["debtor_name"];
                $invoice->debtor_account_code=$value["debtor_account_code"];
                $invoice->debtor_address=$value["debtor_address"];
                $invoice->tin=$value["tin"];
                $invoice->contract_id=$value["contract_number"];
                $invoice->invoice_number_votebook=$value["invoice_number"];
                $invoice->invoicing_period_start_date=$value["start_date"];
                $invoice->invoicing_period_end_date=$value["end_date"];
                $invoice->amount_to_be_paid=$value["amount"];
                $invoice->currency_invoice=$value["currencytzs_or_usd"];
                $invoice->period=$value["period"];
                $invoice->description=$value["description"];
                $invoice->status=$value["status"];
                $invoice->gepg_control_no=$value["gepg_control_number"];
                $invoice->payment_status=$value["payment_statuspaid_partially_paid_or_not_paid"];
                $invoice->inc_code=$value["incomeinc_code"];
                $invoice->project_id=$value["project_id"];
                $invoice->invoice_date=$value["invoice_date"];
                $invoice->financial_year=$value["financial_year"];
                $invoice->max_no_of_days_to_pay=$value["max_number_of_days_to_pay"];
                $invoice->prepared_by=$value["prepared_by"];
                $invoice->approved_by=$value["approved_by"];
                $invoice->user_comments=$value["comments"];
                $invoice->email_sent_status=$value["already_sent_to_clientnot_sent_or_sent"];
                $invoice->stage=2;
                $invoice->amount_in_words=$amount_in_words;

                $invoice->invoice_category='Car Rental';

                if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                    $invoice->invoice_status=0;

                }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                    $invoice->invoice_status=1;
                }else{

                    return back()->with('error', 'Status of the invoice must be specified');


                }


                $invoice->save();



                if(strtolower($value["has_paymentyes_or_no"])=='yes'){

                    $invoice_number_created=DB::table('research_flats_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                    $payment= new App\research_flats_payment();
                    $payment->invoice_number=$invoice_number_created;
                    $payment->invoice_number_votebook=$value["invoice_number"];
                    $payment->amount_paid=$value["amount_paid"];
                    $payment->amount_not_paid=$value["amount_not_paid"];
                    $payment->currency_payments=$value["currency_paymentstzs_or_usd"];
                    $payment->receipt_number=$value["receipt_number"];

                    if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                        $payment->status_payment=0;

                    }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                        $payment->status_payment=1;
                    }



                    $payment->date_of_payment=$value["date_of_payment"];
                    $payment->save();

                }else{



                }





            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function researchInvoicesFormat()
    {

//        DB::table('invoices')->insert(
//            ['invoice_category'=>'Space'=>'stage'=>1]
//        );



        $data=App\research_flats_invoices_format::join('research_flats_payments_format','research_flats_invoices_format.invoice_number','=','research_flats_payments_format.invoice_number')->select('debtor_name as Debtor Name','debtor_account_code as Debtor Account Code','debtor_address as Debtor Address','tin as TIN','contract_id as Contract Number','research_flats_invoices_format.invoice_number_votebook as Invoice Number','invoicing_period_start_date as Start Date','invoicing_period_end_date as End Date','amount_to_be_paid as Amount','currency_invoice as Currency(TZS or USD)','period as Period','project_id as Project ID','description as Description','status as Status','gepg_control_no as GePG Control Number','payment_status as Payment Status(Paid, Partially Paid or Not paid','inc_code as Income(inc) Code','invoice_date as Invoice Date','financial_year as Financial Year','max_no_of_days_to_pay as Max Number of Days to pay','prepared_by as Prepared By','approved_by as Approved By','user_comments as Comments','email_sent_status as Already sent to client?(NOT SENT or SENT)','invoice_status as Status of the invoice(OK or CANCELLED)','has_payment as Has Payment?(Yes or No)','amount_paid as Amount Paid','amount_not_paid as Amount Not Paid','research_flats_payments_format.currency_payments as Currency Payments(TZS or USD)','receipt_number as Receipt Number','date_of_payment as Date of Payment')->get();

        $excel = App::make('excel');
        $excel->create('research_flats_invoices_payments_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }






    public function importInsuranceInvoices(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count()> 0)
        {
            foreach($data as  $value)
            {



                $amount_in_words='';

                if($value["currencytzs_or_usd"]=='TZS'){
                    $amount_in_words=Terbilang::make($value["amount"],' TZS',' ');

                }

                if ($value["currencytzs_or_usd"]=='USD'){

                    $amount_in_words=Terbilang::make($value["amount"],' USD',' ');
                }

                else{


                }


                $invoice= new App\insurance_invoice();
                $invoice->debtor_name=$value["debtor_name"];
                $invoice->debtor_account_code=$value["debtor_account_code"];
                $invoice->debtor_address=$value["debtor_address"];
                $invoice->tin=$value["tin"];
                $invoice->invoice_number_votebook=$value["invoice_number"];
                $invoice->invoicing_period_start_date=$value["start_date"];
                $invoice->invoicing_period_end_date=$value["end_date"];
                $invoice->amount_to_be_paid=$value["amount"];
                $invoice->currency_invoice=$value["currencytzs_or_usd"];
                $invoice->period=$value["period"];
                $invoice->description=$value["description"];
                $invoice->status=$value["status"];
                $invoice->gepg_control_no=$value["gepg_control_number"];
                $invoice->payment_status=$value["payment_statuspaid_partially_paid_or_not_paid"];
                $invoice->inc_code=$value["incomeinc_code"];
                $invoice->project_id=$value["project_id"];
                $invoice->invoice_date=$value["invoice_date"];
                $invoice->financial_year=$value["financial_year"];
                $invoice->max_no_of_days_to_pay=$value["max_number_of_days_to_pay"];
                $invoice->prepared_by=$value["prepared_by"];
                $invoice->approved_by=$value["approved_by"];
                $invoice->user_comments=$value["comments"];
                $invoice->email_sent_status=$value["already_sent_to_clientnot_sent_or_sent"];
                $invoice->stage=2;
                $invoice->amount_in_words=$amount_in_words;

                $invoice->invoice_category='Car Rental';

                if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                    $invoice->invoice_status=0;

                }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                    $invoice->invoice_status=1;
                }else{

                    return back()->with('error', 'Status of the invoice must be specified');


                }


                $invoice->save();



                if(strtolower($value["has_paymentyes_or_no"])=='yes'){

                    $invoice_number_created=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                    $payment= new App\insurance_payment();
                    $payment->invoice_number=$invoice_number_created;
                    $payment->invoice_number_votebook=$value["invoice_number"];
                    $payment->amount_paid=$value["amount_paid"];
                    $payment->amount_not_paid=$value["amount_not_paid"];
                    $payment->currency_payments=$value["currency_paymentstzs_or_usd"];
                    $payment->receipt_number=$value["receipt_number"];

                    if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                        $payment->status_payment=0;

                    }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                        $payment->status_payment=1;
                    }



                    $payment->date_of_payment=$value["date_of_payment"];
                    $payment->save();

                }else{



                }





            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function insuranceInvoicesFormat()
    {

//        DB::table('invoices')->insert(
//            ['invoice_category'=>'Space'=>'stage'=>1]
//        );



        $data=App\insurance_invoices_format::join('insurance_payments_format','insurance_invoices_format.invoice_number','=','insurance_payments_format.invoice_number')->select('debtor_name as Debtor Name','debtor_account_code as Debtor Account Code','debtor_address as Debtor Address','tin as TIN','insurance_invoices_format.invoice_number_votebook as Invoice Number','invoicing_period_start_date as Start Date','invoicing_period_end_date as End Date','amount_to_be_paid as Amount','currency_invoice as Currency(TZS or USD)','period as Period','project_id as Project ID','description as Description','status as Status','gepg_control_no as GePG Control Number','payment_status as Payment Status(Paid, Partially Paid or Not paid','inc_code as Income(inc) Code','invoice_date as Invoice Date','financial_year as Financial Year','max_no_of_days_to_pay as Max Number of Days to pay','prepared_by as Prepared By','approved_by as Approved By','user_comments as Comments','email_sent_status as Already sent to client?(NOT SENT or SENT)','invoice_status as Status of the invoice(OK or CANCELLED)','has_payment as Has Payment?(Yes or No)','amount_paid as Amount Paid','amount_not_paid as Amount Not Paid','insurance_payments_format.currency_payments as Currency Payments(TZS or USD)','receipt_number as Receipt Number','date_of_payment as Date of Payment')->get();

        $excel = App::make('excel');
        $excel->create('insurance_invoices_payments_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }





    public function importInsuranceClientsInvoices(Request $request)
    {
        $this->validate($request, [
            'import_data'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_data')->getRealPath();


        $excel = App::make('excel');

        $data=$excel->load($path)->get();

        if($data->count()> 0)
        {
            foreach($data as  $value)
            {



                $amount_in_words='';

                if($value["currencytzs_or_usd"]=='TZS'){
                    $amount_in_words=Terbilang::make($value["amount"],' TZS',' ');

                }

                if ($value["currencytzs_or_usd"]=='USD'){

                    $amount_in_words=Terbilang::make($value["amount"],' USD',' ');
                }

                else{


                }


                $invoice= new App\insurance_invoices_client();
                $invoice->debtor_name=$value["debtor_name"];
                $invoice->debtor_account_code=$value["debtor_account_code"];
                $invoice->debtor_address=$value["debtor_address"];
                $invoice->tin=$value["tin"];
                $invoice->contract_id=$value["contract_number"];
                $invoice->invoice_number_votebook=$value["invoice_number"];
                $invoice->invoicing_period_start_date=$value["start_date"];
                $invoice->invoicing_period_end_date=$value["end_date"];
                $invoice->amount_to_be_paid=$value["amount"];
                $invoice->currency_invoice=$value["currencytzs_or_usd"];
                $invoice->period=$value["period"];
                $invoice->description=$value["description"];
                $invoice->status=$value["status"];
                $invoice->gepg_control_no=$value["gepg_control_number"];
                $invoice->payment_status=$value["payment_statuspaid_partially_paid_or_not_paid"];
                $invoice->inc_code=$value["incomeinc_code"];
                $invoice->project_id=$value["project_id"];
                $invoice->invoice_date=$value["invoice_date"];
                $invoice->financial_year=$value["financial_year"];
                $invoice->max_no_of_days_to_pay=$value["max_number_of_days_to_pay"];
                $invoice->prepared_by=$value["prepared_by"];
                $invoice->approved_by=$value["approved_by"];
                $invoice->user_comments=$value["comments"];
                $invoice->email_sent_status=$value["already_sent_to_clientnot_sent_or_sent"];
                $invoice->stage=2;
                $invoice->amount_in_words=$amount_in_words;

                $invoice->invoice_category='Car Rental';

                if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                    $invoice->invoice_status=0;

                }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                    $invoice->invoice_status=1;
                }else{

                    return back()->with('error', 'Status of the invoice must be specified');


                }


                $invoice->save();



                if(strtolower($value["has_paymentyes_or_no"])=='yes'){

                    $invoice_number_created=DB::table('insurance_invoices_clients')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                    $payment= new App\insurance_clients_payment();
                    $payment->invoice_number=$invoice_number_created;
                    $payment->invoice_number_votebook=$value["invoice_number"];
                    $payment->amount_paid=$value["amount_paid"];
                    $payment->amount_not_paid=$value["amount_not_paid"];
                    $payment->currency_payments=$value["currency_paymentstzs_or_usd"];
                    $payment->receipt_number=$value["receipt_number"];

                    if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='cancelled'){

                        $payment->status_payment=0;

                    }else if(strtolower($value["status_of_the_invoiceok_or_cancelled"])=='ok'){

                        $payment->status_payment=1;
                    }



                    $payment->date_of_payment=$value["date_of_payment"];
                    $payment->save();

                }else{



                }





            }


        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }


    public function insuranceClientsInvoicesFormat()
    {

//        DB::table('invoices')->insert(
//            ['invoice_category'=>'Space'=>'stage'=>1]
//        );



        $data=App\insurance_invoices_clients_format::join('insurance_clients_payments_format','insurance_invoices_clients_format.invoice_number','=','insurance_clients_payments_format.invoice_number')->select('debtor_name as Debtor Name','debtor_account_code as Debtor Account Code','debtor_address as Debtor Address','tin as TIN','contract_id as Contract Number','insurance_invoices_clients_format.invoice_number_votebook as Invoice Number','invoicing_period_start_date as Start Date','invoicing_period_end_date as End Date','amount_to_be_paid as Amount','currency_invoice as Currency(TZS or USD)','period as Period','project_id as Project ID','description as Description','status as Status','gepg_control_no as GePG Control Number','payment_status as Payment Status(Paid, Partially Paid or Not paid','inc_code as Income(inc) Code','invoice_date as Invoice Date','financial_year as Financial Year','max_no_of_days_to_pay as Max Number of Days to pay','prepared_by as Prepared By','approved_by as Approved By','user_comments as Comments','email_sent_status as Already sent to client?(NOT SENT or SENT)','invoice_status as Status of the invoice(OK or CANCELLED)','has_payment as Has Payment?(Yes or No)','amount_paid as Amount Paid','amount_not_paid as Amount Not Paid','insurance_clients_payments_format.currency_payments as Currency Payments(TZS or USD)','receipt_number as Receipt Number','date_of_payment as Date of Payment')->get();

        $excel = App::make('excel');
        $excel->create('insurance_invoices_clients_payments_format', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromModel($data);


            });

        })->export('xlsx');


    }




}
