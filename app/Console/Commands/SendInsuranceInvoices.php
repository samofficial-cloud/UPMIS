<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Riskihajar\Terbilang\Facades\Terbilang;

class SendInsuranceInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */


    protected $signature = 'command:sendInsuranceInvoices';

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




        // Create insurance invoice automatically begin
        $today=date('Y-m-d');

//        $startTime = Carbon::parse($cleanObj->starttime);
//        $diff = $cleanObj->created_at->diffInHours($startTime);
//        $monthly_email_date = Carbon::now()->startOfMonth();
//
        $day_to_send_invoice=date('d');

        $current_year=date('Y');
        $current_month=date('m');

        $insurance_invoice_start_day=DB::table('system_settings')->where('id',1)->value('insurance_invoice_start_day');
        $insurance_invoice_end_day=DB::table('system_settings')->where('id',1)->value('insurance_invoice_end_day');

        $day_to_send_insurance_invoice=DB::table('system_settings')->where('id',1)->value('day_for_insurance_invoice');



        $from=$current_year.'-'.$current_month.'-'.$insurance_invoice_start_day;

        $to=$current_year.'-'.$current_month.'-'.$insurance_invoice_end_day;

        $period= date("d/m/Y",strtotime($from)).' to  '. date("d/m/Y",strtotime($to));


        if($day_to_send_invoice==$day_to_send_insurance_invoice){

            $principals=DB::table('insurance')->get();

            $tempOut = array();
            foreach($principals as $principal){

                $tempoIn=$principal->insurance_company;

                if(!in_array($tempoIn, $tempOut))
                {

                    $total_amount_collected=DB::table('insurance_contracts')->whereBetween('created_at', [$from, $to])->where('principal',$principal->insurance_company)->sum('premium');
                    $percentage_fraction=DB::table('system_settings')->where('id',1)->value('insurance_percentage');

                    $amount_ten_percent=round($total_amount_collected*$percentage_fraction);
                    $extracted_contract=DB::table('insurance_contracts')->whereBetween('created_at', [$from, $to])->where('principal',$principal->insurance_company)->get();



                    $amount_in_words=Terbilang::make($amount_ten_percent,' TZS',' ');


                    $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
                    $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');

                    foreach($extracted_contract as $var){


                        $invoice_to_be_created=DB::select('call invoice_exists_insurance (?,?,?)',[$from,$to,$var->principal]);

                        if(count($invoice_to_be_created)==0){

                            DB::table('insurance_invoices')->insert(
                                ['contract_id' => '', 'invoicing_period_start_date' => $from,'invoicing_period_end_date' => $to,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $var->principal,'debtor_address' => '','amount_to_be_paid' => $amount_ten_percent,'currency_invoice'=>'TZS','gepg_control_no'=>'','tin'=>'','vrn'=>'','max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance Monthly fees','prepared_by'=>'Name','approved_by'=>'Name']
                            );

//                            $users = User::where('role', 'Insurance Agent')->get();
//
//                            Notification::send($users, new InvoiceCreated('Insurance'));

                            $invoice_number_created=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                            DB::table('invoice_notifications')->insert(
                                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'insurance']
                            );






                        }else{




                        }

                    }




                    array_push($tempOut,$tempoIn);
                }




            }




        }else{


        }


//        echo "Insurance invoice created successfully";
        //create insurance invoice automatically end
//        DB::table('testing_table')->insert(
//            ['data' => 'john@insurance']
//        );

    }
}
