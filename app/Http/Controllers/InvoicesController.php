<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\SendInvoice;
use App\client;
use Carbon\Carbon;
use PDF;
use Riskihajar\Terbilang\Facades\Terbilang;
use Notification;

class InvoicesController extends Controller
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
    public function CreateSpaceInvoice()
    {

        $today=date('Y-m-d');

//        $startTime = Carbon::parse($cleanObj->starttime);
//        $diff = $cleanObj->created_at->diffInHours($startTime);
//        $monthly_email_date = Carbon::now()->startOfMonth();
//
        $expired_space_contracts=DB::select('call get_expired_space_contracts (?)',[$today]);

        foreach ($expired_space_contracts as $var) {


            //determining period

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


            $amount_in_words='';

            if($var->currency=='TZS'){
                $amount_in_words=Terbilang::make($var->amount,' TZS',' ');

            }if ($var->currency=='USD'){

                $amount_in_words=Terbilang::make($var->amount,' USD',' ');
            }

            else{


            }


            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');



            $invoice_to_be_created=DB::table('invoices')->where('invoicing_period_start_date',$var->programming_start_date)->where('invoicing_period_end_date',$var->programming_end_date)->where('debtor_name',$var->full_name)->where('amount_to_be_paid',$var->amount)->where('currency',$var->currency)->where('contract_id',$var->contract_id)->get();


            if(count($invoice_to_be_created)==0){

                DB::table('invoices')->insert(
                    ['contract_id' => $var->contract_id, 'invoicing_period_start_date' => $var->programming_start_date,'invoicing_period_end_date' => $var->programming_end_date,'period' => $period,'project_id' => 'renting_space','debtor_account_code' => $var->client_id,'debtor_name' => $var->full_name,'debtor_address' => $var->address,'amount_to_be_paid' => $var->amount,'currency'=>$var->currency,'gepg_control_no'=>'','tin'=>$var->tin,'vrn'=>$var->vrn,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'Space','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Space Rent','prepared_by'=>'Name','approved_by'=>'Name']
                );
            }else{


            }










        }



    }



    public function index()
    {

        $pdf = PDF::loadView('invoice_pdf');
        return $pdf->stream();
//        return view('invoice_pdf');

    }

//For space Invoices
    public function invoiceManagement()
    {

        $invoices_not_sent=DB::table('invoices')->where('email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('invoices')->where('email_sent_status','SENT')->where('payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('invoices')->where('payment_status','Paid')->where('email_sent_status','SENT')->get();

        return view('invoices_management')->with('invoices_not_sent',$invoices_not_sent)->with('invoices_payment_not_complete',$invoices_payment_not_complete)->with('invoices_payment_complete',$invoices_payment_complete);

    }


    public function changePayementStatusSpace(Request $request,$id)
    {

        DB::table('invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $request->get('payment_status')]);

        DB::table('invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);


        return redirect('/invoice_management')
            ->with('success', 'Changes saved Successfully');

    }



    public function sendInvoiceSpace(Request $request,$id)
    {



        $invoice_data=DB::table('invoices')->where('invoice_number', $id)->get();
        $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
        $today=date('Y-m-d');

        foreach($invoice_data as $var){

            $amount_in_words='';

            if($var->currency=='TZS'){
                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' TZS',' ');

            }if ($var->currency=='USD'){

                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' USD',' ');
            }

            else{


            }


            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


            Notification::route('mail','samforbuilding@gmail.com')
                ->notify(new SendInvoice($var->debtor_name,$var->invoice_number,'CPTU','',$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency,$request->get('gepg_control_no'),'5647768',$max_no_of_days_to_pay,'OK','7868',$amount_in_words,'4353',$today,$financial_year,'4th Quarter','Car Rental Fees','Jacob Peter','John Temu',$var->invoicing_period_start_date,$var->invoicing_period_end_date));

            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_date' => $today]);


            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['email_sent_status' => 'SENT']);

            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['gepg_control_no' => $request->get('gepg_control_no')]);





        }


        return redirect('/invoice_management')
            ->with('success', 'Invoice Sent Successfully');

    }




    public function sendInvoiceCarRental(Request $request,$id)
    {



        $invoice_data=DB::table('car_rental_invoices')->where('invoice_number', $id)->get();
        $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
        $today=date('Y-m-d');

foreach($invoice_data as $var){

    $amount_in_words='';

    if($var->currency=='TZS'){
        $amount_in_words=Terbilang::make($var->amount_to_be_paid,' TZS',' ');

    }if ($var->currency=='USD'){

        $amount_in_words=Terbilang::make($var->amount_to_be_paid,' USD',' ');
    }

    else{


    }


    $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


    Notification::route('mail','samforbuilding@gmail.com')
        ->notify(new SendInvoice($var->debtor_name,$var->invoice_number,'CPTU','',$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency,$request->get('gepg_control_no'),'78775',$max_no_of_days_to_pay,'OK','5654',$amount_in_words,'1234',$today,$financial_year,'3rd Quarter','Car Rental Fees','Jacob Temu','John Peter',$var->invoicing_period_start_date,$var->invoicing_period_end_date));

    DB::table('car_rental_invoices')
        ->where('invoice_number', $id)
        ->update(['email_sent_status' => 'SENT']);

    DB::table('car_rental_invoices')
        ->where('invoice_number', $id)
        ->update(['invoice_date' => $today]);


    DB::table('car_rental_invoices')
        ->where('invoice_number', $id)
        ->update(['gepg_control_no' => $request->get('gepg_control_no')]);








}


        return redirect('/car_rental_invoice_management')
            ->with('success', 'Email Sent Successfully');

    }







    //Car Rental invoices

    public function CarRentalInvoiceManagement()
    {

        $invoices_not_sent=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->where('car_rental_invoices.email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->where('car_rental_invoices.email_sent_status','SENT')->where('car_rental_invoices.payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->where('car_rental_invoices.payment_status','Paid')->where('car_rental_invoices.email_sent_status','SENT')->get();


        return view('car_rental_invoices_management')->with('invoices_not_sent',$invoices_not_sent)->with('invoices_payment_not_complete',$invoices_payment_not_complete)->with('invoices_payment_complete',$invoices_payment_complete);


    }


    public function changePayementStatusCarRental(Request $request,$id)
    {

        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $request->get('payment_status')]);

        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);


        return redirect('/car_rental_invoice_management')
            ->with('success', 'Changes saved Successfully');

    }

//insurance invoices

    public function insuranceInvoiceManagement()
    {

        $invoices_not_sent=DB::table('insurance_invoices')->join('insurance_contracts','insurance_invoices.contract_id','=','insurance_contracts.id')->where('insurance_invoices.email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('insurance_invoices')->join('insurance_contracts','insurance_invoices.contract_id','=','insurance_contracts.id')->where('insurance_invoices.email_sent_status','SENT')->where('insurance_invoices.payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('insurance_invoices')->join('insurance_contracts','insurance_invoices.contract_id','=','insurance_contracts.id')->where('insurance_invoices.payment_status','Paid')->where('insurance_invoices.email_sent_status','SENT')->get();


        return view('insurance_invoices_management')->with('invoices_not_sent',$invoices_not_sent)->with('invoices_payment_not_complete',$invoices_payment_not_complete)->with('invoices_payment_complete',$invoices_payment_complete);


    }



    public function CreateSpaceInsurance()
    {

        $today=date('Y-m-d');

//        $startTime = Carbon::parse($cleanObj->starttime);
//        $diff = $cleanObj->created_at->diffInHours($startTime);
//        $monthly_email_date = Carbon::now()->startOfMonth();
//
        $expired_insurance_contracts=DB::select('call get_expired_insurance_contracts (?)',[$today]);

        foreach ($expired_insurance_contracts as $var) {


            //determining period

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


            $amount_in_words='';

            if($var->currency=='TZS'){
                $amount_in_words=Terbilang::make($var->amount,' TZS',' ');

            }if ($var->currency=='USD'){

                $amount_in_words=Terbilang::make($var->amount,' USD',' ');
            }

            else{


            }


            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');



            $invoice_to_be_created=DB::table('insurance_invoices')->where('invoicing_period_start_date',$var->commission_date)->where('invoicing_period_end_date',$var->end_date)->where('debtor_name',$var->full_name)->where('amount_to_be_paid',$var->amount)->where('currency',$var->currency)->where('contract_id',$var->contract_id)->get();


            if(count($invoice_to_be_created)==0){

                DB::table('invoices')->insert(
                    ['contract_id' => $var->contract_id, 'invoicing_period_start_date' => $var->programming_start_date,'invoicing_period_end_date' => $var->programming_end_date,'period' => $period,'project_id' => 'renting_space','debtor_account_code' => $var->client_id,'debtor_name' => $var->full_name,'debtor_address' => $var->address,'amount_to_be_paid' => $var->amount,'currency'=>$var->currency,'gepg_control_no'=>'','tin'=>$var->tin,'vrn'=>$var->vrn,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'Space','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Space Rent','prepared_by'=>'Name','approved_by'=>'Name']
                );
            }else{


            }










        }



    }





    public function sendInvoiceInsurance(Request $request,$id)
    {



        $invoice_data=DB::table('invoices')->where('invoice_number', $id)->get();
        $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
        $today=date('Y-m-d');

        foreach($invoice_data as $var){

            $amount_in_words='';

            if($var->currency=='TZS'){
                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' TZS',' ');

            }if ($var->currency=='USD'){

                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' USD',' ');
            }

            else{


            }


            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


            Notification::route('mail','samforbuilding@gmail.com')
                ->notify(new SendInvoice($var->debtor_name,$var->invoice_number,'CPTU','',$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency,$request->get('gepg_control_no'),'',$max_no_of_days_to_pay,'OK','',$amount_in_words,'inc_code',$today,$financial_year,'','Car Rental Fees','Name','Name',$var->invoicing_period_start_date,$var->invoicing_period_end_date));

            DB::table('insurance_invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_date' => $today]);


            DB::table('insurance_invoices')
                ->where('invoice_number', $id)
                ->update(['email_sent_status' => 'SENT']);

            DB::table('insurance_invoices')
                ->where('invoice_number', $id)
                ->update(['gepg_control_no' => $request->get('gepg_control_no')]);



        }


        return redirect('/insurance_invoice_management')
            ->with('success', 'Invoice Sent Successfully');

    }


    public function changePayementStatusInsurance(Request $request,$id)
    {

        DB::table('insurance_invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $request->get('payment_status')]);

        DB::table('insurance_invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);


        return redirect('/insurance_invoice_management')
            ->with('success', 'Changes saved Successfully');

    }




}