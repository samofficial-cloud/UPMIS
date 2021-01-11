<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Riskihajar\Terbilang\Facades\Terbilang;
use App\Notifications\SendInvoice;
use Notification;


class SendEmailsWaterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        //

        $email_address='';
        $invoice_to_send='';
        $to_be_sent_water_invoices=DB::table('invoice_notifications')->where('invoice_category','water bill')->where('to_be_sent',1)->get();



        $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


        foreach($to_be_sent_water_invoices as $var) {

            $debtor_name = DB::table('water_bill_invoices')->where('invoice_number', $var->invoice_id)->value('debtor_name');

            $invoice_to_send = DB::table('water_bill_invoices')->where('invoice_number', $var->invoice_id)->where('gepg_control_no', '!=', '')->get();



            foreach ($invoice_to_send as $invoice) {

                $amount_in_words = '';

                if ($invoice->currency_invoice == 'TZS') {
                    $amount_in_words = Terbilang::make($invoice->cumulative_amount, ' TZS', ' ');

                }
                if ($invoice->currency_invoice == 'USD') {

                    $amount_in_words = Terbilang::make($invoice->cumulative_amount, ' USD', ' ');
                } else {


                }

                $financial_year = DB::table('system_settings')->where('id', 1)->value('financial_year');
                $today = date('Y-m-d');
                $email_address = DB::table('clients')->where('full_name', $debtor_name)->value('email');

                if($email_address!='') {

                    Notification::route('mail', $email_address)
                        ->notify(new SendInvoice($invoice->debtor_name, $invoice->invoice_number, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->cumulative_amount, $invoice->currency_invoice, $invoice->gepg_control_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, '4353', $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, $invoice->approved_by, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));

                    DB::table('water_bill_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['invoice_date' => $today]);


                    DB::table('water_bill_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['email_sent_status' => 'SENT']);


                    DB::table('invoice_notifications')->where('invoice_category', 'water bill')->where('invoice_id', $invoice->invoice_number)->delete();
                }else{



                }

            }


        }

        //All invoices already sent

    }
}
