<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\SendInvoice;
use App\Notifications\InvoiceCreated;
use App\client;
use App\User;
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

                $invoice_number_created=DB::table('invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                DB::table('invoice_notifications')->insert(
                    ['invoice_id' => $invoice_number_created, 'invoice_category' => 'space']
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

        $invoices_not_sent=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->where('invoices.email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->where('invoices.email_sent_status','SENT')->where('invoices.payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->where('invoices.payment_status','Paid')->where('invoices.email_sent_status','SENT')->get();


        return view('invoices_management')->with('invoices_not_sent',$invoices_not_sent)->with('invoices_payment_not_complete',$invoices_payment_not_complete)->with('invoices_payment_complete',$invoices_payment_complete);

    }


    public function changePayementStatusSpace(Request $request,$id)
    {

        DB::table('invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $request->get('payment_status')]);

        if($request->get('payment_status')=='Paid'){


        }else {



        }



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


            Notification::route('mail','upmistesting@gmail.com')
                ->notify(new SendInvoice($var->debtor_name,$var->invoice_number,'Renting Space','',$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency,$request->get('gepg_control_no'),'5647768',$max_no_of_days_to_pay,'OK','7868',$amount_in_words,'4353',$today,$financial_year,'4th Quarter','Renting Space Fees','Jacob Peter','John Temu',date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

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


        DB::table('invoice_notifications')->where('invoice_category',  'space')->where('invoice_id',$id)->delete();

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


    Notification::route('mail','upmistesting@gmail.com')
        ->notify(new SendInvoice($var->debtor_name,$var->invoice_number,'Car Rental','',$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency,$request->get('gepg_control_no'),'78775',$max_no_of_days_to_pay,'OK','5654',$amount_in_words,'1234',$today,$financial_year,'3rd Quarter','Car Rental Fees','Jacob Temu','John Peter',date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

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

        DB::table('invoice_notifications')->where('invoice_category',  'car_rental')->where('invoice_id',$id)->delete();

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

        $invoices_not_sent=DB::table('insurance_invoices')->where('email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('insurance_invoices')->where('email_sent_status','SENT')->where('payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('insurance_invoices')->where('payment_status','Paid')->where('email_sent_status','SENT')->get();


        return view('insurance_invoices_management')->with('invoices_not_sent',$invoices_not_sent)->with('invoices_payment_not_complete',$invoices_payment_not_complete)->with('invoices_payment_complete',$invoices_payment_complete);


    }



    public function CreateInsuranceInvoice()
    {

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

                    $total_amount_collected=DB::table('insurance_contracts')->whereBetween('created_at', [$from, $to])->where('principal',$principal->insurance_company)->sum('actual_ex_vat');
                    $percentage_fraction=DB::table('system_settings')->where('id',1)->value('insurance_percentage');

                    $amount_ten_percent=round($total_amount_collected*$percentage_fraction);
                    $extracted_contract=DB::table('insurance_contracts')->whereBetween('created_at', [$from, $to])->where('principal',$principal->insurance_company)->get();



                    $amount_in_words=Terbilang::make($amount_ten_percent,' TZS',' ');



                    $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
                    $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');

                    foreach($extracted_contract as $var){

                        $invoice_to_be_created=DB::table('insurance_invoices')->where('invoicing_period_start_date',$from)->where('invoicing_period_end_date',$to)->where('debtor_name',$var->principal)->where('amount_to_be_paid',$amount_ten_percent)->where('currency','TZS')->get();


                        if(count($invoice_to_be_created)==0){

                            DB::table('insurance_invoices')->insert(
                                ['contract_id' => '', 'invoicing_period_start_date' => $from,'invoicing_period_end_date' => $to,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $var->principal,'debtor_address' => '','amount_to_be_paid' => $amount_ten_percent,'currency'=>'TZS','gepg_control_no'=>'','tin'=>'','vrn'=>'','max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance Monthly fees','prepared_by'=>'Name','approved_by'=>'Name']
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


        echo "Insurance invoice created successfully";


    }





    public function sendInvoiceInsurance(Request $request,$id)
    {



        $invoice_data=DB::table('insurance_invoices')->where('invoice_number', $id)->get();
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


            Notification::route('mail','upmistesting@gmail.com')
                ->notify(new SendInvoice($var->debtor_name,$var->invoice_number,'UDIA','',$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency,$request->get('gepg_control_no'),'',$max_no_of_days_to_pay,'OK','',$amount_in_words,'inc_code',date("d/m/Y",strtotime($today)),$financial_year,$var->period,'Insurance Monthly Fees','Name','Name',date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

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

        DB::table('invoice_notifications')->where('invoice_category',  'insurance')->where('invoice_id',$id)->delete();


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

//Electricity bills


    public function ElectricityBillsInvoiceManagement()
    {
        $invoices_not_sent=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->where('electricity_bill_invoices.email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->where('electricity_bill_invoices.email_sent_status','SENT')->where('electricity_bill_invoices.payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->where('electricity_bill_invoices.payment_status','Paid')->where('electricity_bill_invoices.email_sent_status','SENT')->get();

        return view('electricity_bill_invoices_management')->with('invoices_not_sent', $invoices_not_sent)->with('invoices_payment_not_complete', $invoices_payment_not_complete)->with('invoices_payment_complete', $invoices_payment_complete);


    }


    public function CreateElectricityBillsInvoice()
    {

        $today=date('Y-m-d');

//        $startTime = Carbon::parse($cleanObj->starttime);
//        $diff = $cleanObj->created_at->diffInHours($startTime);
//        $monthly_email_date = Carbon::now()->startOfMonth();
//
        $day_to_send_invoice=date('d');


        $current_year=date('Y');
        $current_month=date('m');

        $bills_invoice_start_day=DB::table('system_settings')->where('id',1)->value('bills_invoice_start_day');
        $bills_invoice_end_day=DB::table('system_settings')->where('id',1)->value('bills_invoice_end_day');

        $day_to_send_bills_invoice=DB::table('system_settings')->where('id',1)->value('day_to_send_bills_invoice');




        $from=$current_year.'-'.$current_month.'-'.$bills_invoice_start_day;

        $to=$current_year.'-'.$current_month.'-'.$bills_invoice_end_day;

        $period= date("d/m/Y",strtotime($from)).' to  '. date("d/m/Y",strtotime($to));


        if($day_to_send_invoice==$day_to_send_bills_invoice){

            $contracts=DB::table('space_contracts')->where('has_electricity_bill','YES')->WhereDate('end_date','>',date('Y-m-d'))->get();




                    foreach($contracts as $var){


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



                        $invoice_to_be_created=DB::table('electricity_bill_invoices')->where('invoicing_period_start_date',$from)->where('invoicing_period_end_date',$to)->where('debtor_name',$var->full_name)->where('amount_to_be_paid',$var->amount)->where('currency',$var->currency)->where('contract_id',$var->contract_id)->get();


                        if(count($invoice_to_be_created)==0){

                            DB::table('electricity_bill_invoices')->insert(
                                ['contract_id' => $var->contract_id, 'invoicing_period_start_date' => $from,'invoicing_period_end_date' => $to,'period' => $period,'project_id' => 'Renting space','debtor_account_code' => '','debtor_name' => $var->full_name,'debtor_address' => '','amount_to_be_paid' => $var->amount,'currency'=>$var->currency,'gepg_control_no'=>'','tin'=>'','vrn'=>'','max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'electricity bill','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Electricity bill','prepared_by'=>'Name','approved_by'=>'Name']
                            );


                            $invoice_number_created=DB::table('electricity_bill_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                            DB::table('invoice_notifications')->insert(
                                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'electricity bill']
                            );



                        }else{




                        }

                    }





                }else{


        }






        echo "Electricity invoice created successfully";


    }



    public function sendInvoiceElectricityBills(Request $request,$id)
    {


        $invoice_data=DB::table('electricity_bill_invoices')->where('invoice_number', $id)->get();
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


            Notification::route('mail','upmistesting@gmail.com')
                ->notify(new SendInvoice($var->debtor_name,$var->invoice_number,'Renting Space','',$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency,$request->get('gepg_control_no'),'',$max_no_of_days_to_pay,'OK','',$amount_in_words,'inc_code',date("d/m/Y",strtotime($today)),$financial_year,$var->period,'Water bill','Name','Name',date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_date' => $today]);


            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['email_sent_status' => 'SENT']);

            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['gepg_control_no' => $request->get('gepg_control_no')]);



        }

        DB::table('invoice_notifications')->where('invoice_category',  'electricity bill')->where('invoice_id',$id)->delete();


        return redirect('/electricity_bills_invoice_management')
            ->with('success', 'Invoice Sent Successfully');

    }


    public function changePaymentStatusElectricityBills(Request $request,$id)
    {

        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $request->get('payment_status')]);

        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);

        return redirect('/electricity_bills_invoice_management')
            ->with('success', 'Changes saved Successfully');

    }





//water bills
    public function WaterBillsInvoiceManagement()
    {
        $invoices_not_sent=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->where('water_bill_invoices.email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->where('water_bill_invoices.email_sent_status','SENT')->where('water_bill_invoices.payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->where('water_bill_invoices.payment_status','Paid')->where('water_bill_invoices.email_sent_status','SENT')->get();

        return view('water_bill_invoices_management')->with('invoices_not_sent',$invoices_not_sent)->with('invoices_payment_not_complete',$invoices_payment_not_complete)->with('invoices_payment_complete',$invoices_payment_complete);



    }


    public function CreateWaterBillsInvoice()
    {

        $today=date('Y-m-d');

//        $startTime = Carbon::parse($cleanObj->starttime);
//        $diff = $cleanObj->created_at->diffInHours($startTime);
//        $monthly_email_date = Carbon::now()->startOfMonth();
//
        $day_to_send_invoice=date('d');


        $current_year=date('Y');
        $current_month=date('m');

        $water_bills_invoice_start_day=DB::table('system_settings')->where('id',1)->value('bills_invoice_start_day');
        $water_bills_invoice_end_day=DB::table('system_settings')->where('id',1)->value('bills_invoice_end_day');

        $day_to_send_bills_invoice=DB::table('system_settings')->where('id',1)->value('day_to_send_bills_invoice');




        $from=$current_year.'-'.$current_month.'-'.$water_bills_invoice_start_day;

        $to=$current_year.'-'.$current_month.'-'.$water_bills_invoice_end_day;

        $period= date("d/m/Y",strtotime($from)).' to  '. date("d/m/Y",strtotime($to));


        if($day_to_send_invoice==$day_to_send_bills_invoice){

            $contracts=DB::table('space_contracts')->where('has_water_bill','YES')->WhereDate('end_date','>',date('Y-m-d'))->get();


            foreach($contracts as $var){


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



                $invoice_to_be_created=DB::table('water_bill_invoices')->where('invoicing_period_start_date',$from)->where('invoicing_period_end_date',$to)->where('debtor_name',$var->full_name)->where('amount_to_be_paid',$var->amount)->where('currency',$var->currency)->where('contract_id',$var->contract_id)->get();


                if(count($invoice_to_be_created)==0){

                    DB::table('water_bill_invoices')->insert(
                        ['contract_id' => $var->contract_id, 'invoicing_period_start_date' => $from,'invoicing_period_end_date' => $to,'period' => $period,'project_id' => 'Renting space','debtor_account_code' => '','debtor_name' => $var->full_name,'debtor_address' => '','amount_to_be_paid' => $var->amount,'currency'=>$var->currency,'gepg_control_no'=>'','tin'=>'','vrn'=>'','max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>'inc_code','invoice_category'=>'water bill','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Water bill','prepared_by'=>'Name','approved_by'=>'Name']
                    );


                    $invoice_number_created=DB::table('water_bill_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                    DB::table('invoice_notifications')->insert(
                        ['invoice_id' => $invoice_number_created, 'invoice_category' => 'water bill']
                    );



                }else{




                }

            }





        }else{


        }






        echo "Water invoice created successfully";


    }



    public function sendInvoiceWaterBills(Request $request,$id)
    {



        $invoice_data=DB::table('water_bill_invoices')->where('invoice_number', $id)->get();
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


            Notification::route('mail','upmistesting@gmail.com')
                ->notify(new SendInvoice($var->debtor_name,$var->invoice_number,'Renting Space','',$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency,$request->get('gepg_control_no'),'',$max_no_of_days_to_pay,'OK','',$amount_in_words,'inc_code',date("d/m/Y",strtotime($today)),$financial_year,$var->period,'Water bill','Name','Name',date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_date' => $today]);


            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['email_sent_status' => 'SENT']);

            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['gepg_control_no' => $request->get('gepg_control_no')]);



        }

        DB::table('invoice_notifications')->where('invoice_category',  'water bill')->where('invoice_id',$id)->delete();


        return redirect('/water_bills_invoice_management')
            ->with('success', 'Invoice Sent Successfully');

    }


    public function changePaymentStatusWaterBills(Request $request,$id)
    {

        DB::table('water_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $request->get('payment_status')]);

        DB::table('water_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);

        return redirect('/water_bills_invoice_management')
            ->with('success', 'Changes saved Successfully');

    }




}
