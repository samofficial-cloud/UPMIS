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






}
