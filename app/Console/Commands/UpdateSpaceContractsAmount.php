<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use DateTime;

class UpdateSpaceContractsAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdateSpaceContractsAmount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $today=date('Y-m-d');
        $current_year=date('Y');
        $current_month=date('m');

        $contracts=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.has_clients','!=',1)->where('end_date','>=',$today)->where('contract_status',1)->get();



        foreach($contracts as $contract){

            if($contract->academic_dependence=='Yes'){


                if($contract->escalation_rate_vacation=='0' ||  is_numeric($contract->escalation_rate_vacation)!=1 || $contract->amount_updated_at==$current_year ){


                }else{





                    $contract_start_day=date("d",strtotime($contract->start_date));
                    $contract_start_month=date("m",strtotime($contract->start_date));


                    $start_date= Carbon::createFromFormat('Y-m-d', $contract->start_date);
                    $starting_day= Carbon::createFromFormat('Y-m-d', $contract->start_date)->day;
                    $today_date = Carbon::createFromFormat('Y-m-d', $today);

                    $days_difference = $start_date->diffInDays($today_date);



                    if($days_difference>=365){

                        if($starting_day>=16){


                            $next_month_temp = Carbon::createFromFormat('Y-m-d', $contract->start_date);

                            $next_month = $next_month_temp->addMonths(1)->month;

                            $present_month=Carbon::now()->month;
                            $present_day=Carbon::now()->day;


                            if($present_month==$next_month AND $present_day==1){


                                $new_amount=round(($contract->vacation_season)*(100+$contract->escalation_rate_vacation)/100);

                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['vacation_season' => $new_amount]);

                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['amount_updated_at' => $current_year]);


                            }else{



                            }


                        }else{


                            $month_date2= Carbon::createFromFormat('Y-m-d', ($current_year.'-'.$contract_start_month.'-'.$contract_start_day));
                            $today_date = Carbon::createFromFormat('Y-m-d', $today);





                            if($today_date->eq($month_date2)){


                                $new_amount=round(($contract->vacation_season)*(100+$contract->escalation_rate_vacation)/100);

                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['vacation_season' => $new_amount]);


                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['amount_updated_at' => $current_year]);



                            }else{



                            }






                        }




                    }else{



                    }




                }





                if($contract->escalation_rate_academic=='0' ||  is_numeric($contract->escalation_rate_academic)!=1 || $contract->amount_updated_at==$current_year){


                }else{





                    $contract_start_day=date("d",strtotime($contract->start_date));
                    $contract_start_month=date("m",strtotime($contract->start_date));

                    $starting_day= Carbon::createFromFormat('Y-m-d', $contract->start_date)->day;
                    $start_date= Carbon::createFromFormat('Y-m-d', $contract->start_date);
                    $today_date = Carbon::createFromFormat('Y-m-d', $today);
                    $days_difference = $start_date->diffInDays($today_date);



                    if($days_difference>=365){

                        if($starting_day>=16){


                            $next_month_temp = Carbon::createFromFormat('Y-m-d', $contract->start_date);

                            $next_month = $next_month_temp->addMonths(1)->month;

                            $present_month=Carbon::now()->month;

                            $present_day=Carbon::now()->day;


                            if($present_month==$next_month AND $present_day==1){


                                $new_amount=round(($contract->academic_season)*(100+$contract->escalation_rate_academic)/100);

                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['academic_season' => $new_amount]);


                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['amount_updated_at' => $current_year]);



                            }else{



                            }


                        }else{









                            $month_date2= Carbon::createFromFormat('Y-m-d', ($current_year.'-'.$contract_start_month.'-'.$contract_start_day));
                            $today_date = Carbon::createFromFormat('Y-m-d', $today);




                            if($today_date->eq($month_date2)){


                                $new_amount=round(($contract->academic_season)*(100+$contract->escalation_rate_academic)/100);

                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['academic_season' => $new_amount]);


                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['amount_updated_at' => $current_year]);



                            }else{



                            }






                        }




                    }else{



                    }




                }




            }else{


                if($contract->escalation_rate=='0' ||  is_numeric($contract->escalation_rate)!=1 || $contract->amount_updated_at==$current_year){


                }else{

                    $today_date = Carbon::createFromFormat('Y-m-d', $today);
                    $start_date = Carbon::createFromFormat('Y-m-d', $contract->start_date);
                    $starting_day= Carbon::createFromFormat('Y-m-d', $contract->start_date)->day;
                    $days_difference = $start_date->diffInDays($today_date);


                    $contract_start_day=date("d",strtotime($contract->start_date));
                    $contract_start_month=date("m",strtotime($contract->start_date));






                    if($days_difference>=365){

                        if($starting_day>=16){


                            $next_month_temp = Carbon::createFromFormat('Y-m-d', $contract->start_date);

                            $next_month = $next_month_temp->addMonths(1)->month;

                            $present_month=Carbon::now()->month;

                            $present_day=Carbon::now()->day;


                            if($present_month==$next_month AND $present_day==1){


                                $new_amount=round(($contract->amount)*(100+$contract->escalation_rate)/100);

                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['amount' => $new_amount]);


                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['amount_updated_at' => $current_year]);



                            }else{



                            }


                        }else{









                            $month_date2= Carbon::createFromFormat('Y-m-d', ($current_year.'-'.$contract_start_month.'-'.$contract_start_day));

                            $today_date = Carbon::createFromFormat('Y-m-d', $today);





                            if($today_date->eq($month_date2)){


                                $new_amount=round(($contract->amount)*(100+$contract->escalation_rate)/100);

                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['amount' => $new_amount]);


                                DB::table('space_contracts')
                                    ->where('contract_id',$contract->contract_id)
                                    ->update(['amount_updated_at' => $current_year]);



                            }else{



                            }






                        }




                    }else{



                    }




                }


            }





        }


    }
}
