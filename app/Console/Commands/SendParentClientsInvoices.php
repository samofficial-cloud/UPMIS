<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Riskihajar\Terbilang\Facades\Terbilang;

class SendParentClientsInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendParentClientsInvoices';

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


//        DB::table('testing_table')->insert(
//            ['data' => 'it works']
//        );


        $today=date('Y-m-d');


        $day_to_send_invoice=date('d');

        $current_year=date('Y');
        $current_month=date('m');

        $space_invoice_start_day=DB::table('system_settings')->where('id',1)->value('space_invoice_start_day');
        $space_invoice_end_day=DB::table('system_settings')->where('id',1)->value('space_invoice_end_day');

        $day_to_send_space_invoice=DB::table('system_settings')->where('id',1)->value('day_to_send_space_invoice');



        if($day_to_send_invoice==$day_to_send_space_invoice){


            $space_contracts=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.has_clients',1)->where('space_contracts.end_date','>=',$today)->where('space_contracts.contract_status',1)->get();



            foreach ($space_contracts as $var) {


                $from=$current_year.'-'.$current_month.'-'.$space_invoice_start_day;

                $to=$current_year.'-'.$current_month.'-'.$space_invoice_end_day;

                $period= date("d/m/Y",strtotime($from)).' to  '. date("d/m/Y",strtotime($to));


                $contract_invoice_no=DB::table('invoices')->where('contract_id',$var->contract_id)->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                $amount_not_paid=DB::table('space_payments')->where('invoice_number',$contract_invoice_no)->value('amount_not_paid');

                if($amount_not_paid==null){

                    $amount_not_paid=0;

                }else{


                }

                $amount_in_words='';
                $amount='';


                $total_amount=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('parent_client',$var->client_id)->where('end_date','>=',$today)->where('contract_status',1)->sum('amount');

                $percentage=$var->percentage;
                $total_amount=round($total_amount*$percentage/100);

if($total_amount==0){



}else {


    $amount = $total_amount;

    if ($var->currency == 'TZS') {
        $amount_in_words = Terbilang::make(($amount + $amount_not_paid), ' TZS', ' ');

    }
    if ($var->currency == 'USD') {

        $amount_in_words = Terbilang::make(($amount + $amount_not_paid), ' USD', ' ');
    } else {


    }


    $financial_year = DB::table('system_settings')->where('id', 1)->value('financial_year');
    $max_no_of_days_to_pay = DB::table('system_settings')->where('id', 1)->value('max_no_of_days_to_pay_invoice');


//            $invoice_to_be_created=DB::table('invoices')->where('invoicing_period_start_date',$var->programming_start_date)->where('invoicing_period_end_date',$var->programming_end_date)->where('debtor_name',$var->full_name)->where('amount_to_be_paid',$var->amount)->where('currency',$var->currency)->where('contract_id',$var->contract_id)->get();
    $invoice_to_be_created = DB::select('call invoice_exists_space (?,?,?)', [$var->contract_id, $from, $to]);


    if (count($invoice_to_be_created) == 0) {

        DB::table('invoices')->insert(
            ['contract_id' => $var->contract_id, 'invoicing_period_start_date' => date("Y-m-d", strtotime($from)), 'invoicing_period_end_date' => date("Y-m-d", strtotime($to)), 'period' => $period, 'project_id' => 'Real Estate', 'debtor_account_code' => $var->official_client_id, 'debtor_name' => $var->full_name, 'debtor_address' => $var->address, 'amount_to_be_paid' => ($amount + $amount_not_paid), 'currency_invoice' => $var->currency, 'gepg_control_no' => '', 'tin' => $var->tin, 'vrn' => $var->vrn, 'max_no_of_days_to_pay' => $max_no_of_days_to_pay, 'status' => 'OK', 'amount_in_words' => $amount_in_words, 'inc_code' => '', 'invoice_category' => 'Space', 'invoice_date' => $today, 'financial_year' => $financial_year, 'payment_status' => 'Not paid', 'description' => 'Real Estate Rent', 'prepared_by' => 'Name', 'approved_by' => 'Name']
        );


        $invoice_number_created = DB::table('invoices')->orderBy('invoice_number', 'desc')->limit(1)->value('invoice_number');

        DB::table('invoice_notifications')->insert(
            ['invoice_id' => $invoice_number_created, 'invoice_category' => 'space']
        );

        DB::table('space_payments')->insert(
            ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => '', 'amount_paid' => 0, 'amount_not_paid' => ($amount + $amount_not_paid), 'currency_payments' => $var->currency, 'receipt_number' => '']
        );


    } else {
        echo "invoice already exists";

    }


}

            }


        }else{



        }



        //create space invoice automatically end


    }
}
