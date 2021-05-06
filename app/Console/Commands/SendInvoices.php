<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Riskihajar\Terbilang\Facades\Terbilang;


class SendInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendInvoices';

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



//        DB::table('testing_table')->insert(
//            ['data' => 'it works']
//        );


        //create space invoice automatically begin

        $today=date('Y-m-d');


        $days_in_advance_for_creating_invoice=DB::table('system_settings')->where('id',1)->value('days_in_advance_for_invoices');

        $expired_space_contracts=DB::select('call get_expired_space_contracts (?,?)',[$today,$days_in_advance_for_creating_invoice]);



        foreach ($expired_space_contracts as $var) {

            //Determining period
            $date_1=strtotime($var->programming_start_date);
            $date_2=strtotime($var->start_date);
            $datediff=$date_1-$date_2;
            $days=round($datediff/(60*60*24));
            $period="";

            if($days>=0 AND $days<90){

                $period="1st Quarter";
            }elseif ($days>=90 AND $days<181) {

                $period="2nd Quarter";
            }elseif ($days>=181 AND $days<273){

                $period="3rd Quarter";
            }elseif ($days>=273 AND $days<=366){

                $period="4th Quarter";
            }else{


            }


            $contract_invoice_no=DB::table('invoices')->where('contract_id',$var->contract_id)->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            $amount_not_paid=DB::table('space_payments')->where('invoice_number',$contract_invoice_no)->value('amount_not_paid');

            if($amount_not_paid==null){

                $amount_not_paid=0;

            }else{


            }

            $amount_in_words='';
            $amount='';
            $sem_one_start_date=DB::table('system_settings')->where('id',1)->value('semester_one_start');
            $sem_one_end_date=DB::table('system_settings')->where('id',1)->value('semester_one_end');

            $sem_two_start_date=DB::table('system_settings')->where('id',1)->value('semester_two_start');
            $sem_two_end_date=DB::table('system_settings')->where('id',1)->value('semester_two_end');




                if($var->academic_dependence=='Yes'){

                    $today_date=$today;

                    $today_date=date('Y-m-d', strtotime($today_date));

                    $sem_one_start_date = date('Y-m-d', strtotime($sem_one_start_date));
                    $sem_one_end_date = date('Y-m-d', strtotime($sem_one_end_date));
                    $sem_two_start_date = date('Y-m-d', strtotime($sem_two_start_date));
                    $sem_two_end_date = date('Y-m-d', strtotime($sem_two_end_date));

                    if (($var->programming_start_date >= $sem_one_start_date) && ($var->programming_end_date <= $sem_one_end_date)){
                        $amount=$var->academic_season;

                        if($var->currency=='TZS'){
                            $amount_in_words=Terbilang::make(($amount+$amount_not_paid),' TZS',' ');

                        }if ($var->currency=='USD'){

                            $amount_in_words=Terbilang::make(($amount+$amount_not_paid),' USD',' ');
                        }
                        else{


                        }



                    }elseif(($var->programming_start_date >= $sem_two_start_date) && ($var->programming_end_date <= $sem_two_end_date))
                    {

                        $amount=$var->academic_season;


                        if($var->currency=='TZS'){
                            $amount_in_words=Terbilang::make(($amount+$amount_not_paid),' TZS',' ');

                        }if ($var->currency=='USD'){

                        $amount_in_words=Terbilang::make(($amount+$amount_not_paid),' USD',' ');
                    }
                    else{


                    }


                    }else{

                        //in the middle or vacation
                        $amount=$var->vacation_season;


                        if($var->currency=='TZS'){
                            $amount_in_words=Terbilang::make(($amount+$amount_not_paid),' TZS',' ');

                        }if ($var->currency=='USD'){

                            $amount_in_words=Terbilang::make(($amount+$amount_not_paid),' USD',' ');
                        }
                        else{


                        }




                    }


                }else{

                    $amount=$var->amount;


                    if($var->currency=='TZS'){
                        $amount_in_words=Terbilang::make(($amount+$amount_not_paid),' TZS',' ');

                    }if ($var->currency=='USD'){

                        $amount_in_words=Terbilang::make(($amount+$amount_not_paid),' USD',' ');
                    }
                    else{


                    }


                }









            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


//            $invoice_to_be_created=DB::table('invoices')->where('invoicing_period_start_date',$var->programming_start_date)->where('invoicing_period_end_date',$var->programming_end_date)->where('debtor_name',$var->full_name)->where('amount_to_be_paid',$var->amount)->where('currency',$var->currency)->where('contract_id',$var->contract_id)->get();
            $invoice_to_be_created=DB::select('call invoice_exists_space (?,?,?)',[$var->contract_id,$var->programming_start_date,$var->programming_end_date]);


            if(count($invoice_to_be_created)==0){

                DB::table('invoices')->insert(
                    ['contract_id' => $var->contract_id, 'invoicing_period_start_date' =>date("Y-m-d",strtotime($var->programming_start_date)),'invoicing_period_end_date' =>date("Y-m-d",strtotime($var->programming_end_date)),'period' => $period,'project_id' => 'renting_space','debtor_account_code' => $var->client_id,'debtor_name' => $var->full_name,'debtor_address' => $var->address,'amount_to_be_paid' => ($amount+$amount_not_paid),'currency_invoice'=>$var->currency,'gepg_control_no'=>'','tin'=>$var->tin,'vrn'=>$var->vrn,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'Space','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Space Rent','prepared_by'=>'Name','approved_by'=>'Name']
                );


                $programming_end_date_old = Carbon::createFromFormat('Y-m-d', $var->programming_end_date);


                $programming_start_date_new = $programming_end_date_old->addDays(1);


                DB::table('space_contracts')
                    ->where('contract_id', $var->contract_id)
                    ->update(['programming_start_date' => date('Y-m-d', strtotime($programming_start_date_new))]);


                $monthsToAdd2 =$var->payment_cycle;

                $programming_end_date_new=$programming_start_date_new->addMonths($monthsToAdd2);

                $programming_end_date_new=date('Y-m-d', strtotime($programming_end_date_new));

                $contract_end_date=$var->end_date;
                $contract_end_date=date('Y-m-d', strtotime($contract_end_date));

                if($programming_end_date_new>$contract_end_date){

                    $programming_end_date_new= $contract_end_date;
                }



                DB::table('space_contracts')
                    ->where('contract_id', $var->contract_id)
                    ->update(['programming_end_date' => $programming_end_date_new]);


                $invoice_number_created=DB::table('invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                DB::table('invoice_notifications')->insert(
                    ['invoice_id' => $invoice_number_created, 'invoice_category' => 'space']
                );

                DB::table('space_payments')->insert(
                    ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>($amount+$amount_not_paid),'currency_payments' => $var->currency,'receipt_number' => '']
                );


            }else{
                echo "invoice already exists";

            }










        }






        //create space invoice automatically end





    }
}
