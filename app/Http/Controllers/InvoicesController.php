<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailsSpaceJob;
use App\Jobs\SendEmailsInsuranceJob;
use App\Jobs\SendEmailsWaterJob;
use App\Jobs\SendEmailsElectricityJob;
use App\Jobs\SendEmailsCarJob;
use App\Notifications\SendInvoiceCar;
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
use Auth;
use View;


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


    public function CreateInsuranceInvoice(Request $request)
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
                                ['contract_id' => '', 'invoicing_period_start_date' => $from,'invoicing_period_end_date' => $to,'period' => $period,'project_id' => 'UDIA','debtor_account_code' => '','debtor_name' => $var->principal,'debtor_address' => '','amount_to_be_paid' => $amount_ten_percent,'currency_invoice'=>'TZS','gepg_control_no'=>'','tin'=>'','vrn'=>'','max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>$request->get('inc_code'),'invoice_category'=>'insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Insurance Monthly fees','prepared_by'=>Auth::user()->name,'approved_by'=>Auth::user()->name]
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


    }



    public function CreateSpaceInvoice(Request $request)
    {

        //create space invoice automatically begin

        $today=date('Y-m-d');

//        $startTime = Carbon::parse($cleanObj->starttime);
//        $diff = $cleanObj->created_at->diffInHours($startTime);
//        $monthly_email_date = Carbon::now()->startOfMonth();
//

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

            $amount_not_paid=DB::table('space_payments')->where('invoice_number',$contract_invoice_no)->where('invoice_number_votebook','!=','')->value('amount_not_paid');

            if($amount_not_paid==null){

                $amount_not_paid=0;

            }else{


            }

            $amount_in_words='';

            if($var->currency=='TZS'){
                $amount_in_words=Terbilang::make(($var->amount+$amount_not_paid),' TZS',' ');

            }if ($var->currency=='USD'){

                $amount_in_words=Terbilang::make(($var->amount+$amount_not_paid),' USD',' ');
            }

            else{


            }


            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');



//            $invoice_to_be_created=DB::table('invoices')->where('invoicing_period_start_date',$var->programming_start_date)->where('invoicing_period_end_date',$var->programming_end_date)->where('debtor_name',$var->full_name)->where('amount_to_be_paid',$var->amount)->where('currency',$var->currency)->where('contract_id',$var->contract_id)->get();
            $invoice_to_be_created=DB::select('call invoice_exists_space (?,?,?)',[$var->contract_id,$var->programming_start_date,$var->programming_end_date]);


            if(count($invoice_to_be_created)==0){

                DB::table('invoices')->insert(
                    ['contract_id' => $var->contract_id, 'invoicing_period_start_date' => $var->programming_start_date,'invoicing_period_end_date' => $var->programming_end_date,'period' => $period,'project_id' => 'renting_space','debtor_account_code' => $var->client_id,'debtor_name' => $var->full_name,'debtor_address' => $var->address,'amount_to_be_paid' => ($var->amount+$amount_not_paid),'currency_invoice'=>$var->currency,'gepg_control_no'=>'','tin'=>$var->tin,'vrn'=>$var->vrn,'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>'OK','amount_in_words'=>$amount_in_words,'inc_code'=>$request->get('inc_code'),'invoice_category'=>'Space','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>'Space Rent','prepared_by'=>Auth::user()->name,'approved_by'=>Auth::user()->name]
                );

                $invoice_number_created=DB::table('invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                DB::table('invoice_notifications')->insert(
                    ['invoice_id' => $invoice_number_created, 'invoice_category' => 'space']
                );


            }else{
                echo "invoice already exists";

            }










        }






        //create space invoice automatically end


    }




    public function CreateSpaceInvoiceManually(Request $request)
    {



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
                ['invoice_number_votebook'=>$request->get('invoice_number'),'contract_id' => $request->get('contract_id','N/A'), 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $request->get('period','N/A'),'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'amount_to_be_paid' => $request->get('amount_to_be_paid'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>$request->get('tin','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>$request->get('inc_code'),'invoice_category'=>'Space','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A','stage'=>1]
            );

            $invoice_number_created=DB::table('invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'space']
            );

            DB::table('space_payments')->insert(
                ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => $request->get('invoice_number'),'amount_paid' => 0,'amount_not_paid' =>$request->get('amount_to_be_paid'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
            );


        }else{
            return redirect()->back()->with("error","Invoice already exists. Please try again");

        }


        return redirect('/invoice_management')
            ->with('success', 'Space invoice created Successfully');




    }



    public function index()
    {

        $pdf = PDF::loadView('invoice_pdf');
        return $pdf->stream();
//        return view('invoice_pdf');

    }


    public function PrintSpaceInvoice($id){

        $invoice_data=DB::table('invoices')->where('invoice_number',$id)->get();
        $today=date('d/m/Y');
    foreach ($invoice_data as $var) {

    $data = [
        'invoice_number'   => $var->invoice_number_votebook,
        'project_id' => $var->project_id,
        'debtor_account_code'  => $var->debtor_account_code,
        'debtor_name'   => $var->debtor_name,
        'debtor_address' => $var->debtor_address,
        'amount_to_be_paid'  => $var->amount_to_be_paid,
        'currency'   => $var->currency_invoice,
        'gepg_control_no' => $var->gepg_control_no,
        'tin'  => $var->tin,
        'vrn'   => $var->vrn,
        'invoice_date' =>date("d/m/Y",strtotime($var->invoice_date)) ,
        'period'  => $var->period,
        'financial_year'   => $var->financial_year,
        'max_no_of_days_to_pay' => $var->max_no_of_days_to_pay,
        'status'  => $var->status,
        'inc_code'   => $var->inc_code,
        'amount_in_words' => $var->amount_in_words,
        'description' => $var->description,
        'prepared_by' => $var->prepared_by,
        'approved_by' => $var->approved_by,
        'today' => $today
    ];



}



        $pdf = PDF::loadView('invoice_pdf',$data);


        return $pdf->stream();



    }



    public function PrintWaterInvoice($id){

        $invoice_data=DB::table('water_bill_invoices')->where('invoice_number',$id)->get();
        $today=date('d/m/Y');
        foreach ($invoice_data as $var) {

            $data = [
                'invoice_number'   => $var->invoice_number_votebook,
                'project_id' => $var->project_id,
                'debtor_account_code'  => $var->debtor_account_code,
                'debtor_name'   => $var->debtor_name,
                'debtor_address' => $var->debtor_address,
                'amount_to_be_paid'  => $var->cumulative_amount,
                'currency'   => $var->currency_invoice,
                'gepg_control_no' => $var->gepg_control_no,
                'tin'  => $var->tin,
                'vrn'   => $var->vrn,
                'invoice_date' =>date("d/m/Y",strtotime($var->invoice_date)) ,
                'period'  => $var->period,
                'financial_year'   => $var->financial_year,
                'max_no_of_days_to_pay' => $var->max_no_of_days_to_pay,
                'status'  => $var->status,
                'inc_code'   => $var->inc_code,
                'amount_in_words' => $var->amount_in_words,
                'description' => $var->description,
                'prepared_by' => $var->prepared_by,
                'approved_by' => $var->approved_by,
                'today' => $today
            ];



        }



        $pdf = PDF::loadView('invoice_pdf',$data);


        return $pdf->stream();



    }


    public function PrintElectricityInvoice($id){

        $invoice_data=DB::table('water_bill_invoices')->where('invoice_number',$id)->get();
        $today=date('d/m/Y');
        foreach ($invoice_data as $var) {

            $data = [
                'invoice_number'   => $var->invoice_number_votebook,
                'project_id' => $var->project_id,
                'debtor_account_code'  => $var->debtor_account_code,
                'debtor_name'   => $var->debtor_name,
                'debtor_address' => $var->debtor_address,
                'amount_to_be_paid'  => $var->cumulative_amount,
                'currency'   => $var->currency_invoice,
                'gepg_control_no' => $var->gepg_control_no,
                'tin'  => $var->tin,
                'vrn'   => $var->vrn,
                'invoice_date' =>date("d/m/Y",strtotime($var->invoice_date)) ,
                'period'  => $var->period,
                'financial_year'   => $var->financial_year,
                'max_no_of_days_to_pay' => $var->max_no_of_days_to_pay,
                'status'  => $var->status,
                'inc_code'   => $var->inc_code,
                'amount_in_words' => $var->amount_in_words,
                'description' => $var->description,
                'prepared_by' => $var->prepared_by,
                'approved_by' => $var->approved_by,
                'today' => $today
            ];



        }



        $pdf = PDF::loadView('invoice_pdf',$data);


        return $pdf->stream();



    }




    public function PrintResearchInvoice($id){

        $invoice_data=DB::table('research_flats_invoices')->where('invoice_number',$id)->get();
        $today=date('d/m/Y');
        foreach ($invoice_data as $var) {

            $data = [
                'invoice_number'   => $var->invoice_number_votebook,
                'project_id' => $var->project_id,
                'debtor_account_code'  => $var->debtor_account_code,
                'debtor_name'   => $var->debtor_name,
                'debtor_address' => $var->debtor_address,
                'amount_to_be_paid'  => $var->amount_to_be_paid,
                'currency'   => $var->currency_invoice,
                'gepg_control_no' => $var->gepg_control_no,
                'tin'  => $var->tin,
                'vrn'   => $var->vrn,
                'invoice_date' =>date("d/m/Y",strtotime($var->invoice_date)) ,
                'period'  => $var->period,
                'financial_year'   => $var->financial_year,
                'max_no_of_days_to_pay' => $var->max_no_of_days_to_pay,
                'status'  => $var->status,
                'inc_code'   => $var->inc_code,
                'amount_in_words' => $var->amount_in_words,
                'description' => $var->description,
                'prepared_by' => $var->prepared_by,
                'approved_by' => $var->approved_by,
                'today' => $today
            ];



        }



        $pdf = PDF::loadView('invoice_pdf',$data);


        return $pdf->stream();



    }




    public function PrintCarInvoice($id){

        $invoice_data=DB::table('car_rental_invoices')->where('invoice_number',$id)->get();
        $today=date('d/m/Y');
        foreach ($invoice_data as $var) {

            $data = [
                'invoice_number'   => $var->invoice_number_votebook,
                'project_id' => $var->project_id,
                'debtor_account_code'  => $var->debtor_account_code,
                'debtor_name'   => $var->debtor_name,
                'debtor_address' => $var->debtor_address,
                'amount_to_be_paid'  => $var->amount_to_be_paid,
                'currency'   => $var->currency_invoice,
                'gepg_control_no' => $var->gepg_control_no,
                'tin'  => $var->tin,
                'vrn'   => $var->vrn,
                'invoice_date' =>date("d/m/Y",strtotime($var->invoice_date)) ,
                'period'  => $var->period,
                'financial_year'   => $var->financial_year,
                'max_no_of_days_to_pay' => $var->max_no_of_days_to_pay,
                'status'  => $var->status,
                'inc_code'   => $var->inc_code,
                'amount_in_words' => $var->amount_in_words,
                'description' => $var->description,
                'prepared_by' => $var->prepared_by,
                'approved_by' => $var->approved_by,
                'today' => $today
            ];


        }



        $pdf = PDF::loadView('invoice_pdf',$data);


        return $pdf->stream();



    }



    public function PrintCarInvoiceAccount($id){

        $invoice_data=DB::table('car_rental_invoices')->where('invoice_number',$id)->get();
        $today=date('d/m/Y');
        foreach ($invoice_data as $var) {

            $data = [
                'invoice_number'   => $var->invoice_number_votebook,
                'project_id' => $var->project_id,
                'debtor_account_code'  => $var->debtor_account_code,
                'debtor_name'   => $var->debtor_name,
                'debtor_address' => $var->debtor_address,
                'amount_to_be_paid'  => $var->amount_to_be_paid,
                'currency'   => $var->currency_invoice,
                'gepg_control_no' => $var->account_no,
                'tin'  => $var->tin,
                'vrn'   => $var->vrn,
                'invoice_date' =>date("d/m/Y",strtotime($var->invoice_date)) ,
                'period'  => $var->period,
                'financial_year'   => $var->financial_year,
                'max_no_of_days_to_pay' => $var->max_no_of_days_to_pay,
                'status'  => $var->status,
                'inc_code'   => $var->inc_code,
                'amount_in_words' => $var->amount_in_words,
                'description' => $var->description,
                'prepared_by' => $var->prepared_by,
                'approved_by' => $var->approved_by,
                'today' => $today
            ];


        }



        $pdf = PDF::loadView('invoice_car_pdf',$data);


        return $pdf->stream();



    }





    public function PrintInsuranceInvoiceClients($id){

        $invoice_data=DB::table('insurance_invoices_clients')->where('invoice_number',$id)->get();
        $today=date('d/m/Y');
        foreach ($invoice_data as $var) {

            $data = [
                'invoice_number'   => $var->invoice_number_votebook,
                'project_id' => $var->project_id,
                'debtor_account_code'  => $var->debtor_account_code,
                'debtor_name'   => $var->debtor_name,
                'debtor_address' => $var->debtor_address,
                'amount_to_be_paid'  => $var->amount_to_be_paid,
                'currency'   => $var->currency_invoice,
                'gepg_control_no' => $var->gepg_control_no,
                'tin'  => $var->tin,
                'vrn'   => $var->vrn,
                'invoice_date' =>date("d/m/Y",strtotime($var->invoice_date)) ,
                'period'  => $var->period,
                'financial_year'   => $var->financial_year,
                'max_no_of_days_to_pay' => $var->max_no_of_days_to_pay,
                'status'  => $var->status,
                'inc_code'   => $var->inc_code,
                'amount_in_words' => $var->amount_in_words,
                'description' => $var->description,
                'prepared_by' => $var->prepared_by,
                'approved_by' => $var->approved_by,
                'today' => $today
            ];


        }



        $pdf = PDF::loadView('invoice_pdf',$data);


        return $pdf->stream();



    }




    public function PrintInsuranceInvoicePrincipals($id){

        $invoice_data=DB::table('insurance_invoices')->where('invoice_number',$id)->get();
        $today=date('d/m/Y');
        foreach ($invoice_data as $var) {

            $data = [
                'invoice_number'   => $var->invoice_number_votebook,
                'project_id' => $var->project_id,
                'debtor_account_code'  => $var->debtor_account_code,
                'debtor_name'   => $var->debtor_name,
                'debtor_address' => $var->debtor_address,
                'amount_to_be_paid'  => $var->amount_to_be_paid,
                'currency'   => $var->currency_invoice,
                'gepg_control_no' => $var->gepg_control_no,
                'tin'  => $var->tin,
                'vrn'   => $var->vrn,
                'invoice_date' =>date("d/m/Y",strtotime($var->invoice_date)) ,
                'period'  => $var->period,
                'financial_year'   => $var->financial_year,
                'max_no_of_days_to_pay' => $var->max_no_of_days_to_pay,
                'status'  => $var->status,
                'inc_code'   => $var->inc_code,
                'amount_in_words' => $var->amount_in_words,
                'description' => $var->description,
                'prepared_by' => $var->prepared_by,
                'approved_by' => $var->approved_by,
                'today' => $today
            ];


        }



        $pdf = PDF::loadView('invoice_pdf',$data);


        return $pdf->stream();



    }


    public function CancelSpaceInvoice($id){

        DB::table('invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_status' => 0]);


        DB::table('space_payments')
            ->where('invoice_number', $id)
            ->update(['status_payment' => 0]);

        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }


    public function CancelWaterInvoice($id){

        DB::table('water_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_status' => 0]);

        DB::table('water_bill_payments')
            ->where('invoice_number', $id)
            ->update(['status_payment' => 0]);

        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }




    public function CancelElectricityInvoice($id){

        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_status' => 0]);


        DB::table('electricity_bill_payments')
            ->where('invoice_number', $id)
            ->update(['status_payment' => 0]);


        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }


    public function CancelResearchInvoice($id){

        DB::table('research_flats_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_status' => 0]);


        DB::table('research_flats_payments')
            ->where('invoice_number', $id)
            ->update(['status_payment' => 0]);

        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }


    public function CancelInsuranceClientsInvoice($id){

        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $id)
            ->update(['invoice_status' => 0]);

        DB::table('insurance_clients_payments')
            ->where('invoice_number', $id)
            ->update(['status_payment' => 0]);


        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');


    }

    public function CancelInsurancePrincipalsInvoice($id){

        DB::table('insurance_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_status' => 0]);


        DB::table('insurance_payments')
            ->where('invoice_number', $id)
            ->update(['status_payment' => 0]);


        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }


    public function CancelCarInvoice($id){

        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_status' => 0]);



        DB::table('car_rental_payments')
            ->where('invoice_number', $id)
            ->update(['status_payment' => 0]);


        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }



//For space Invoices
    public function invoiceManagement()
    {
        $space_invoice_inbox=null;
        $space_invoice_outbox=null;



        $created_stage_space_invoices=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->orderBy('invoices.rejected','desc')->orderBy('invoices.updated_at','desc')->orderBy('invoices.invoice_number','desc')->where('invoices.stage',0)->get();
        $fowarded_stage_space_invoices=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->orderBy('invoices.updated_at','desc')->orderBy('invoices.invoice_number','desc')->where('invoices.stage',1)->get();
        $approval_stage_space_invoices=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->orderBy('invoices.updated_at','desc')->orderBy('invoices.invoice_number','desc')->where('invoices.stage',2)->get();
        $rejected_stage_space_invoices=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->orderBy('invoices.updated_at','desc')->orderBy('invoices.invoice_number','desc')->where('invoices.stage',0)->where('invoices.rejected',1)->get();

        $payment_incomplete_space_invoices=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->orderBy('invoices.updated_at','desc')->orderBy('invoices.invoice_number','desc')->where('invoices.stage',3)->orWhere('invoices.stage',2)->where('invoices.payment_status','Not paid')->get();
        $space_invoices=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->orderBy('invoices.invoice_number','desc')->where('invoices.stage',3)->get();


        if(Auth::user()->role=='DPDI Planner'){
            if(count($created_stage_space_invoices)==0){


            }else{

                $space_invoice_inbox=$created_stage_space_invoices;
            }



            if(count($fowarded_stage_space_invoices)==0){



            }else{

                $space_invoice_outbox=$fowarded_stage_space_invoices;

            }



        }else if (Auth::user()->role=='Accountant-DPDI'){

            if(count($fowarded_stage_space_invoices)==0){


            }else{

                $space_invoice_inbox=$fowarded_stage_space_invoices;
            }

            if(count($payment_incomplete_space_invoices)==0){


            }else{

                $space_invoice_outbox=$payment_incomplete_space_invoices;

            }




        }else if (Auth::user()->role=='Director DPDI'){

            if(count($approval_stage_space_invoices)==0){


            }else{

                $space_invoice_inbox=$approval_stage_space_invoices;
            }

            if(count($rejected_stage_space_invoices)==0){


            }else{

                $space_invoice_outbox=$rejected_stage_space_invoices;

            }




        }








        else{



        }








        //research invoices starts

        $research_invoice_inbox=null;
        $research_invoice_outbox=null;



        $created_stage_research_invoices=DB::table('research_flats_invoices')->join('research_flats_contracts','research_flats_invoices.contract_id','=','research_flats_contracts.id')->orderBy('research_flats_invoices.invoice_number','desc')->where('research_flats_invoices.stage',0)->get();
        $fowarded_stage_research_invoices=DB::table('research_flats_invoices')->join('research_flats_contracts','research_flats_invoices.contract_id','=','research_flats_contracts.id')->orderBy('research_flats_invoices.invoice_number','desc')->where('research_flats_invoices.stage',1)->get();
        $payment_incomplete_research_invoices=DB::table('research_flats_invoices')->join('research_flats_contracts','research_flats_invoices.contract_id','=','research_flats_contracts.id')->orderBy('research_flats_invoices.invoice_number','desc')->where('research_flats_invoices.stage',2)->where('research_flats_invoices.payment_status','Not paid')->get();
        $research_invoices=DB::table('research_flats_invoices')->join('research_flats_contracts','research_flats_invoices.contract_id','=','research_flats_contracts.id')->orderBy('research_flats_invoices.invoice_number','desc')->where('research_flats_invoices.stage',2)->get();


        if(Auth::user()->role=='Research Flats Officer'){
            if(count($created_stage_research_invoices)==0){


            }else{

                $research_invoice_inbox=$created_stage_research_invoices;
            }



            if(count($fowarded_stage_research_invoices)==0){



            }else{

                $research_invoice_outbox=$fowarded_stage_research_invoices;

            }



        }else if (Auth::user()->role=='Accountant-DPDI'){

            if(count($fowarded_stage_research_invoices)==0){


            }else{

                $research_invoice_inbox=$fowarded_stage_research_invoices;
            }

            if(count($payment_incomplete_research_invoices)==0){


            }else{

                $research_invoice_outbox=$payment_incomplete_research_invoices;

            }




        }else{



        }

        //research invoices ends




        //insurance invoices starts

        $insurance_invoice_inbox=null;
        $insurance_invoice_outbox=null;



        $created_stage_insurance_invoices=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->where('stage',0)->get();
        $fowarded_stage_insurance_invoices=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->where('stage',1)->get();
        $payment_incomplete_insurance_invoices=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->where('stage',2)->where('payment_status','Not paid')->get();
        $insurance_invoices=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->where('stage',2)->get();


        if(Auth::user()->role=='Insurance Officer'){
            if(count($created_stage_insurance_invoices)==0){


            }else{

                $insurance_invoice_inbox=$created_stage_insurance_invoices;
            }



            if(count($fowarded_stage_insurance_invoices)==0){



            }else{

                $insurance_invoice_outbox=$fowarded_stage_insurance_invoices;

            }



        }else if (Auth::user()->role=='Accountant-DPDI'){

            if(count($fowarded_stage_insurance_invoices)==0){


            }else{

                $insurance_invoice_inbox=$fowarded_stage_insurance_invoices;
            }

            if(count($payment_incomplete_insurance_invoices)==0){


            }else{

                $insurance_invoice_outbox=$payment_incomplete_insurance_invoices;

            }




        }else{



        }

        //insurance invoices ends





        //insurance_clients invoices starts

        $insurance_clients_invoice_inbox=null;
        $insurance_clients_invoice_outbox=null;



        $created_stage_insurance_clients_invoices=DB::table('insurance_invoices_clients')->join('insurance_contracts','insurance_invoices_clients.contract_id','=','insurance_contracts.id')->orderBy('insurance_invoices_clients.invoice_number','desc')->where('insurance_invoices_clients.stage',0)->get();
        $fowarded_stage_insurance_clients_invoices=DB::table('insurance_invoices_clients')->join('insurance_contracts','insurance_invoices_clients.contract_id','=','insurance_contracts.id')->orderBy('insurance_invoices_clients.invoice_number','desc')->where('insurance_invoices_clients.stage',1)->get();
        $payment_incomplete_insurance_clients_invoices=DB::table('insurance_invoices_clients')->join('insurance_contracts','insurance_invoices_clients.contract_id','=','insurance_contracts.id')->orderBy('insurance_invoices_clients.invoice_number','desc')->where('insurance_invoices_clients.stage',2)->where('insurance_invoices_clients.payment_status','Not paid')->get();
        $insurance_clients_invoices=DB::table('insurance_invoices_clients')->join('insurance_contracts','insurance_invoices_clients.contract_id','=','insurance_contracts.id')->orderBy('insurance_invoices_clients.invoice_number','desc')->where('insurance_invoices_clients.stage',2)->get();



        if(Auth::user()->role=='Insurance Officer'){
            if(count($created_stage_insurance_clients_invoices)==0){


            }else{

                $insurance_clients_invoice_inbox=$created_stage_insurance_clients_invoices;
            }



            if(count($fowarded_stage_insurance_clients_invoices)==0){



            }else{

                $insurance_clients_invoice_outbox=$fowarded_stage_insurance_clients_invoices;

            }



        }else if (Auth::user()->role=='Accountant-DPDI'){

            if(count($fowarded_stage_insurance_clients_invoices)==0){


            }else{

                $insurance_clients_invoice_inbox=$fowarded_stage_insurance_clients_invoices;
            }

            if(count($payment_incomplete_insurance_clients_invoices)==0){


            }else{

                $insurance_clients_invoice_outbox=$payment_incomplete_insurance_clients_invoices;

            }




        }else{



        }

        //insurance_clients invoices ends







//        $insurance_invoices_principals=DB::table('insurance_invoices')->orderBy('invoice_number','desc');
//        $insurance_invoices=DB::table('insurance_invoices_clients')->orderBy('invoice_number','desc') ->union($insurance_invoices_principals)->get();

//        dd($insurance_invoices);
        $research_invoices=DB::table('research_flats_invoices')->join('research_flats_contracts','research_flats_invoices.contract_id','=','research_flats_contracts.id')->orderBy('research_flats_invoices.invoice_number','desc')->get();


//        $insurance_invoices=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->get();
//        $insurance_invoices_clients=DB::table('insurance_invoices_clients')->orderBy('invoice_number','desc')->get();





        if(Auth::user()->role=='Vote Holder' || Auth::user()->role=='Accountant-Cost Centre'){
//            $car_rental_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->where('cost_centre',Auth::user()->cost_centre)->orderBy('car_rental_invoices.invoice_number','desc')->get();


            //car rental invoices starts

            $car_invoice_inbox=null;
            $car_invoice_outbox=null;



            $created_stage_car_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->orderBy('car_rental_invoices.invoice_number','desc')->where('car_rental_invoices.stage',0)->where('car_contracts.cost_centre',Auth::user()->cost_centre)->get();
            $fowarded_stage_car_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->orderBy('car_rental_invoices.invoice_number','desc')->where('car_rental_invoices.stage',1)->where('car_contracts.cost_centre',Auth::user()->cost_centre)->get();
            $payment_incomplete_car_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->orderBy('car_rental_invoices.invoice_number','desc')->where('car_rental_invoices.stage',2)->where('car_rental_invoices.payment_status','Not paid')->where('car_contracts.cost_centre',Auth::user()->cost_centre)->get();
            $car_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->orderBy('car_rental_invoices.invoice_number','desc')->where('car_rental_invoices.stage',2)->where('car_contracts.cost_centre',Auth::user()->cost_centre)->get();


            if(Auth::user()->role=='Transport Officer-CPTU' || Auth::user()->role=='Head of CPTU'){
                if(count($created_stage_car_invoices)==0){


                }else{

                    $car_invoice_inbox=$created_stage_car_invoices;
                }



                if(count($fowarded_stage_car_invoices)==0){



                }else{

                    $car_invoice_outbox=$fowarded_stage_car_invoices;

                }



            }else if (Auth::user()->role=='Accountant-DPDI'){

                if(count($fowarded_stage_car_invoices)==0){


                }else{

                    $car_invoice_inbox=$fowarded_stage_car_invoices;
                }

                if(count($payment_incomplete_car_invoices)==0){


                }else{

                    $car_invoice_outbox=$payment_incomplete_car_invoices;

                }




            }else{



            }

            //car rental invoices ends



        }

        else{




//            $car_rental_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->orderBy('car_rental_invoices.invoice_number','desc')->get();


            //car rental invoices starts

            $car_invoice_inbox=null;
            $car_invoice_outbox=null;



            $created_stage_car_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->orderBy('car_rental_invoices.invoice_number','desc')->where('car_rental_invoices.stage',0)->get();
            $fowarded_stage_car_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->orderBy('car_rental_invoices.invoice_number','desc')->where('car_rental_invoices.stage',1)->get();
            $payment_incomplete_car_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->orderBy('car_rental_invoices.invoice_number','desc')->where('car_rental_invoices.stage',2)->where('car_rental_invoices.payment_status','Not paid')->get();
            $car_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->orderBy('car_rental_invoices.invoice_number','desc')->where('car_rental_invoices.stage',2)->get();


            if(Auth::user()->role=='Transport Officer-CPTU' || Auth::user()->role=='Head of CPTU'){
                if(count($created_stage_car_invoices)==0){


                }else{

                    $car_invoice_inbox=$created_stage_car_invoices;
                }



                if(count($fowarded_stage_car_invoices)==0){



                }else{

                    $car_invoice_outbox=$fowarded_stage_car_invoices;

                }



            }else if (Auth::user()->role=='Accountant-DPDI'){

                if(count($fowarded_stage_car_invoices)==0){


                }else{

                    $car_invoice_inbox=$fowarded_stage_car_invoices;
                }

                if(count($payment_incomplete_car_invoices)==0){


                }else{

                    $car_invoice_outbox=$payment_incomplete_car_invoices;

                }




            }else{



            }

            //car rental invoices ends



        }







//        $water_bill_invoices=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('water_bill_invoices.invoice_number','desc')->get();

        $water_invoice_inbox=null;
        $water_invoice_outbox=null;



        $created_stage_water_invoices=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('water_bill_invoices.rejected','desc')->orderBy('water_bill_invoices.updated_at','desc')->orderBy('water_bill_invoices.invoice_number','desc')->where('water_bill_invoices.stage',0)->get();
        $fowarded_stage_water_invoices=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('water_bill_invoices.updated_at','desc')->orderBy('water_bill_invoices.invoice_number','desc')->where('water_bill_invoices.stage',1)->get();
        $approval_stage_water_invoices=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('water_bill_invoices.updated_at','desc')->orderBy('water_bill_invoices.invoice_number','desc')->where('water_bill_invoices.stage',2)->get();
        $rejected_stage_water_invoices=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('water_bill_invoices.updated_at','desc')->orderBy('water_bill_invoices.invoice_number','desc')->where('water_bill_invoices.stage',0)->where('water_bill_invoices.rejected',1)->get();

        $payment_incomplete_water_invoices=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('water_bill_invoices.updated_at','desc')->orderBy('water_bill_invoices.invoice_number','desc')->where('water_bill_invoices.stage',3)->orWhere('water_bill_invoices.stage',2)->where('water_bill_invoices.payment_status','Not paid')->get();
        $water_invoices=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('water_bill_invoices.invoice_number','desc')->where('water_bill_invoices.stage',3)->get();


        if(Auth::user()->role=='DPDI Planner'){
            if(count($created_stage_water_invoices)==0){


            }else{

                $water_invoice_inbox=$created_stage_water_invoices;
            }



            if(count($fowarded_stage_water_invoices)==0){



            }else{

                $water_invoice_outbox=$fowarded_stage_water_invoices;

            }



        }else if (Auth::user()->role=='Accountant-DPDI'){

            if(count($fowarded_stage_water_invoices)==0){


            }else{

                $water_invoice_inbox=$fowarded_stage_water_invoices;
            }

            if(count($payment_incomplete_water_invoices)==0){


            }else{

                $water_invoice_outbox=$payment_incomplete_water_invoices;

            }




        }

        else if (Auth::user()->role=='Director DPDI'){

            if(count($approval_stage_water_invoices)==0){


            }else{

                $water_invoice_inbox=$approval_stage_water_invoices;
            }

            if(count($rejected_stage_water_invoices)==0){


            }else{

                $water_invoice_outbox=$rejected_stage_water_invoices;

            }




        }






        else{



        }










//         $electricity_bill_invoices=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('electricity_bill_invoices.invoice_number','desc')->get();
        $electricity_invoice_inbox=null;
        $electricity_invoice_outbox=null;



        $created_stage_electricity_invoices=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('electricity_bill_invoices.rejected','desc')->orderBy('electricity_bill_invoices.updated_at','desc')->orderBy('electricity_bill_invoices.invoice_number','desc')->where('electricity_bill_invoices.stage',0)->get();
        $fowarded_stage_electricity_invoices=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('electricity_bill_invoices.updated_at','desc')->orderBy('electricity_bill_invoices.invoice_number','desc')->where('electricity_bill_invoices.stage',1)->get();
        $approval_stage_electricity_invoices=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('electricity_bill_invoices.updated_at','desc')->orderBy('electricity_bill_invoices.invoice_number','desc')->where('electricity_bill_invoices.stage',2)->get();
        $rejected_stage_electricity_invoices=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('electricity_bill_invoices.updated_at','desc')->orderBy('electricity_bill_invoices.invoice_number','desc')->where('electricity_bill_invoices.stage',0)->where('electricity_bill_invoices.rejected',1)->get();

        $payment_incomplete_electricity_invoices=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('electricity_bill_invoices.updated_at','desc')->orderBy('electricity_bill_invoices.invoice_number','desc')->where('electricity_bill_invoices.stage',3)->orWhere('electricity_bill_invoices.stage',2)->where('electricity_bill_invoices.payment_status','Not paid')->get();
        $electricity_invoices=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->orderBy('electricity_bill_invoices.invoice_number','desc')->where('electricity_bill_invoices.stage',3)->get();


        if(Auth::user()->role=='DPDI Planner'){
            if(count($created_stage_electricity_invoices)==0){


            }else{

                $electricity_invoice_inbox=$created_stage_electricity_invoices;
            }



            if(count($fowarded_stage_electricity_invoices)==0){



            }else{

                $electricity_invoice_outbox=$fowarded_stage_electricity_invoices;

            }



        }else if (Auth::user()->role=='Accountant-DPDI'){

            if(count($fowarded_stage_electricity_invoices)==0){


            }else{

                $electricity_invoice_inbox=$fowarded_stage_electricity_invoices;
            }

            if(count($payment_incomplete_electricity_invoices)==0){


            }else{

                $electricity_invoice_outbox=$payment_incomplete_electricity_invoices;

            }




        }




        else if (Auth::user()->role=='Director DPDI'){

            if(count($approval_stage_electricity_invoices)==0){


            }else{

                $electricity_invoice_inbox=$approval_stage_electricity_invoices;
            }

            if(count($rejected_stage_electricity_invoices)==0){


            }else{

                $electricity_invoice_outbox=$rejected_stage_electricity_invoices;

            }




        }




        else{



        }



        return view('invoices_management')->with('space_invoices',$space_invoices)->with('research_invoices',$research_invoices)->with('space_invoice_inbox',$space_invoice_inbox)->with('space_invoice_outbox',$space_invoice_outbox)->with('insurance_invoices',$insurance_invoices)->with('insurance_clients_invoices',$insurance_clients_invoices)->with('car_invoices',$car_invoices)->with('water_invoices',$water_invoices)->with('water_invoice_inbox',$water_invoice_inbox)->with('water_invoice_outbox',$water_invoice_outbox)->with('electricity_invoices',$electricity_invoices)->with('electricity_invoice_inbox',$electricity_invoice_inbox)->with('electricity_invoice_outbox',$electricity_invoice_outbox)->with('car_invoice_inbox',$car_invoice_inbox)->with('car_invoice_outbox',$car_invoice_outbox)->with('insurance_invoice_inbox',$insurance_invoice_inbox)->with('insurance_invoice_outbox',$insurance_invoice_outbox)->with('insurance_clients_invoice_inbox',$insurance_clients_invoice_inbox)->with('insurance_clients_invoice_outbox',$insurance_clients_invoice_outbox)->with('research_invoice_inbox',$research_invoice_inbox)->with('research_invoice_outbox',$research_invoice_outbox);

    }

    public function space_filter(){
        return View::make('invoice_filtered');
    }


    public function changePayementStatusSpace(Request $request,$id)
    {
        $payment_status='';
        $amount_to_be_paid=DB::table('invoices')->where('invoice_number', $id)->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if($request->get('amount_paid')<$amount_to_be_paid){
            $payment_status='Partially Paid';


        }elseif($request->get('amount_paid')==$amount_to_be_paid) {
            $payment_status='Paid';


        }else{


        }


        DB::table('invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $payment_status]);

        DB::table('invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);


//        DB::table('space_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );


        DB::table('space_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('space_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_paid' => $request->get('amount_paid')]);

        DB::table('space_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_not_paid' => $amount_not_paid]);

        DB::table('space_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['currency_payments' => $request->get('currency_payments')]);

        DB::table('space_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['receipt_number' => $request->get('receipt_number')]);

        DB::table('space_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['date_of_payment' => $request->get('date_of_payment')]);







        return redirect('/invoice_management')
            ->with('success', 'Payment received successfully');

    }



    public function sendInvoiceSpace(Request $request,$id)
    {



        if($request->get('approval_status')=='Rejected'){

            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['stage' => 0]);

            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['rejected' => 1]);


            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['reason' => $request->get('reason')]);


            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['updated_at' => Carbon::now()->toDateTimeString()]);




            return redirect('/invoice_management')
                ->with('success', 'Operation completed successfully');

        }else{


            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['rejected' => 0]);


            DB::table('space_payments')
                ->where('invoice_number', $id)
                ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);




            $invoice_data=DB::table('invoices')->where('invoice_number', $id)->get();
            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
            $today=date('Y-m-d');

            foreach($invoice_data as $var){

                $amount_in_words='';

                if($var->currency_invoice=='TZS'){
                    $amount_in_words=Terbilang::make($var->amount_to_be_paid,' TZS',' ');

                }if ($var->currency_invoice=='USD'){

                    $amount_in_words=Terbilang::make($var->amount_to_be_paid,' USD',' ');
                }

                else{


                }


                $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');

                $email_address=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.contract_id',$var->contract_id)->value('email');

                if($email_address==''){
                    return redirect()->back()->with("error","No email address provided, Please verify the existence of email address and try again");
                }else{


                }


                Notification::route('mail',$email_address)
                    ->notify(new SendInvoice($var->debtor_name,$request->get('invoice_number_votebook'),$var->project_id,$var->debtor_account_code,$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency_invoice,$request->get('gepg_control_no'),$var->tin,$max_no_of_days_to_pay,$var->status,$var->vrn,$amount_in_words,$var->inc_code,$today,$financial_year,$var->period,$var->description,$var->prepared_by,Auth::user()->name,date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

                DB::table('invoices')
                    ->where('invoice_number', $id)
                    ->update(['invoice_date' => $today]);


                DB::table('invoices')
                    ->where('invoice_number', $id)
                    ->update(['email_sent_status' => 'SENT']);

                DB::table('invoices')
                    ->where('invoice_number', $id)
                    ->update(['gepg_control_no' => $request->get('gepg_control_no')]);



//            DB::table('space_payments')->insert(
//                ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//            );

            }



            DB::table('invoice_notifications')->where('invoice_category',  'space')->where('invoice_id',$id)->delete();



            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['stage' => 3]);


            DB::table('invoices')
                ->where('invoice_number', $id)
                ->update(['updated_at' => Carbon::now()->toDateTimeString()]);



            return redirect('/invoice_management')
                ->with('success', 'Invoice Sent Successfully');


        }




    }




    public function sendInvoiceCarRental(Request $request,$id)
    {

        DB::table('car_rental_payments')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['inc_code' => $request->get('inc_code')]);





        $invoice_data=DB::table('car_rental_invoices')->where('invoice_number', $id)->get();
        $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
        $today=date('Y-m-d');

        foreach($invoice_data as $var){

            $amount_in_words='';

            if($var->currency_invoice=='TZS'){
                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' TZS',' ');

            }if ($var->currency_invoice=='USD'){

                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' USD',' ');
            }

            else{


            }


            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');




            $email_address=DB::table('car_contracts')->where('id',$var->contract_id)->value('email');

            if($email_address==''){
                return redirect()->back()->with("error","No email address provided, Please verify the existence of email address and try again");
            }else{


            }

            Notification::route('mail',$email_address)
                ->notify(new SendInvoice($var->debtor_name,$request->get('invoice_number_votebook'),$var->project_id,$var->debtor_account_code,$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency_invoice,$request->get('gepg_control_no'),$var->tin,$max_no_of_days_to_pay,$var->status,$var->vrn,$amount_in_words,$var->inc_code,$today,$financial_year,$var->period,$var->description,$var->prepared_by,Auth::user()->name,date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

            DB::table('car_rental_invoices')
                ->where('invoice_number', $id)
                ->update(['email_sent_status' => 'SENT']);

            DB::table('car_rental_invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_date' => $today]);


            DB::table('car_rental_invoices')
                ->where('invoice_number', $id)
                ->update(['gepg_control_no' => $request->get('gepg_control_no')]);


//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//        );





        }


        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['stage' => 2]);


        DB::table('invoice_notifications')->where('invoice_category',  'car_rental')->where('invoice_id',$id)->delete();

        return redirect('/invoice_management')
            ->with('success', 'Email Sent Successfully');

    }




    public function sendInvoiceResearch(Request $request,$id)
    {

        DB::table('research_flats_payments')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('research_flats_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


        DB::table('research_flats_invoices')
            ->where('invoice_number', $id)
            ->update(['inc_code' => $request->get('inc_code')]);



        $invoice_data=DB::table('research_flats_invoices')->where('invoice_number', $id)->get();
        $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
        $today=date('Y-m-d');

        foreach($invoice_data as $var){

            $amount_in_words='';

            if($var->currency_invoice=='TZS'){
                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' TZS',' ');

            }if ($var->currency_invoice=='USD'){

                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' USD',' ');
            }

            else{


            }


            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');




            $host_email=DB::table('research_flats_contracts')->where('id',$var->contract_id)->where('host_name',$var->debtor_name)->value('host_email');
            $guest_first_name=DB::table('research_flats_contracts')->where('id',$var->contract_id)->value('first_name');
            $guest_last_name=DB::table('research_flats_contracts')->where('id',$var->contract_id)->value('last_name');
            $guest_full_name=$guest_first_name.' '.$guest_last_name;
            $email_address=null;

            if($host_email!=''){

                $email_address=DB::table('research_flats_contracts')->where('id',$var->contract_id)->where('host_name',$var->debtor_name)->value('host_email');

            }elseif($guest_full_name==$var->debtor_name){
                $email_address=DB::table('research_flats_contracts')->where('id',$var->contract_id)->value('email');

            }else{

                    return redirect()->back()->with("error","No email address provided, Please verify the existence of email address and try again");

            }

            Notification::route('mail',$email_address)
                ->notify(new SendInvoice($var->debtor_name,$request->get('invoice_number_votebook'),$var->project_id,$var->debtor_account_code,$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency_invoice,$request->get('gepg_control_no'),$var->tin,$max_no_of_days_to_pay,$var->status,$var->vrn,$amount_in_words,$var->inc_code,$today,$financial_year,$var->period,$var->description,$var->prepared_by,Auth::user()->name,date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

            DB::table('research_flats_invoices')
                ->where('invoice_number', $id)
                ->update(['email_sent_status' => 'SENT']);

            DB::table('research_flats_invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_date' => $today]);


            DB::table('research_flats_invoices')
                ->where('invoice_number', $id)
                ->update(['gepg_control_no' => $request->get('gepg_control_no')]);


//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//        );





        }


        DB::table('research_flats_invoices')
            ->where('invoice_number', $id)
            ->update(['stage' => 2]);


        DB::table('invoice_notifications')->where('invoice_category',  'research')->where('invoice_id',$id)->delete();

        return redirect('/invoice_management')
            ->with('success', 'Email Sent Successfully');

    }




    public function sendAllInvoicesSpace(Request $request){

        DB::table('invoice_notifications')
            ->where('invoice_category','space')
            ->update(['to_be_sent' => 1]);

        $invoices_sent=DB::table('invoice_notifications')->where('invoice_category','space')->where('to_be_sent',1)->get();

//    SendEmailsSpaceJob::dispatch()->delay(now()->addSeconds(5));

//    SendEmailsSpaceJob::dispatch();

        //
        //

        $email_address='';
        $invoice_to_send='';
        $to_be_sent_space_invoices=DB::table('invoice_notifications')->where('invoice_category','space')->where('to_be_sent',1)->get();



        $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


        foreach($to_be_sent_space_invoices as $var) {

            $debtor_name = DB::table('invoices')->where('invoice_number', $var->invoice_id)->value('debtor_name');

            $invoice_to_send = DB::table('invoices')->where('invoice_number', $var->invoice_id)->where('gepg_control_no', '!=', '')->get();



            foreach ($invoice_to_send as $invoice) {

                $amount_in_words = '';

                if ($invoice->currency_invoice == 'TZS') {
                    $amount_in_words = Terbilang::make($invoice->amount_to_be_paid, ' TZS', ' ');

                }
                if ($invoice->currency_invoice == 'USD') {

                    $amount_in_words = Terbilang::make($invoice->amount_to_be_paid, ' USD', ' ');
                } else {


                }

                $financial_year = DB::table('system_settings')->where('id', 1)->value('financial_year');
                $today = date('Y-m-d');
                $email_address = DB::table('clients')->where('full_name', $debtor_name)->value('email');

                if($email_address!='') {
                    Notification::route('mail', $email_address)
                        ->notify(new SendInvoice($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->amount_to_be_paid, $invoice->currency_invoice, $invoice->gepg_control_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));

                    DB::table('invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['invoice_date' => $today]);


                    DB::table('invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['email_sent_status' => 'SENT']);


                    DB::table('invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['stage' => 2]);


                    DB::table('invoice_notifications')->where('invoice_category', 'space')->where('invoice_id', $invoice->invoice_number)->delete();
                }else{



                }

            }


        }

        //All invoices already sent













        return redirect('/invoice_management')
            ->with('success', 'Emails Sent Successfully');
    }


    public function sendAllInvoicesWater(Request $request){

        DB::table('invoice_notifications')
            ->where('invoice_category','water bill')
            ->update(['to_be_sent' => 1]);

        $invoices_sent=DB::table('invoice_notifications')->where('invoice_category','water bill')->where('to_be_sent',1)->get();

//        SendEmailsWaterJob::dispatch();


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
                        ->notify(new SendInvoice($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->cumulative_amount, $invoice->currency_invoice, $invoice->gepg_control_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));

                    DB::table('water_bill_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['invoice_date' => $today]);


                    DB::table('water_bill_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['email_sent_status' => 'SENT']);


                    DB::table('water_bill_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['stage' => 2]);



                    DB::table('invoice_notifications')->where('invoice_category', 'water bill')->where('invoice_id', $invoice->invoice_number)->delete();
                }else{



                }

            }


        }

        //All invoices already sent











        return redirect('/invoice_management')
            ->with('success', 'Emails Sent Successfully');
    }


    public function sendAllInvoicesElectricity(Request $request){

        DB::table('invoice_notifications')
            ->where('invoice_category','electricity bill')
            ->update(['to_be_sent' => 1]);

        $invoices_sent=DB::table('invoice_notifications')->where('invoice_category','electricity bill')->where('to_be_sent',1)->get();

//        SendEmailsElectricityJob::dispatch();

        //
        //

        $email_address='';
        $invoice_to_send='';
        $to_be_sent_electricity_invoices=DB::table('invoice_notifications')->where('invoice_category','electricity bill')->where('to_be_sent',1)->get();



        $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


        foreach($to_be_sent_electricity_invoices as $var) {

            $debtor_name = DB::table('electricity_bill_invoices')->where('invoice_number', $var->invoice_id)->value('debtor_name');

            $invoice_to_send = DB::table('electricity_bill_invoices')->where('invoice_number', $var->invoice_id)->where('gepg_control_no', '!=', '')->get();



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
                        ->notify(new SendInvoice($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->cumulative_amount, $invoice->currency_invoice, $invoice->gepg_control_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));

                    DB::table('electricity_bill_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['invoice_date' => $today]);


                    DB::table('electricity_bill_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['email_sent_status' => 'SENT']);

                    DB::table('electricity_bill_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['stage' => 2]);


                    DB::table('invoice_notifications')->where('invoice_category', 'electricity bill')->where('invoice_id', $invoice->invoice_number)->delete();

                }else{



                }
            }


        }

        //All invoices already sent








        return redirect('/invoice_management')
            ->with('success', 'Emails Sent Successfully');
    }



    public function sendAllInvoicesInsurance(Request $request){

        DB::table('invoice_notifications')
            ->where('invoice_category','insurance_clients')
            ->update(['to_be_sent' => 1]);

//        SendEmailsInsuranceJob::dispatch();

        //
        //

        $email_address='';
        $invoice_to_send='';
        $to_be_sent_insurance_invoices=DB::table('invoice_notifications')->where('invoice_category','insurance_clients')->where('to_be_sent',1)->get();


        $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


        foreach($to_be_sent_insurance_invoices as $var) {

            $debtor_name = DB::table('insurance_invoices_clients')->where('invoice_number', $var->invoice_id)->value('debtor_name');

            $invoice_to_send = DB::table('insurance_invoices_clients')->where('invoice_number', $var->invoice_id)->where('gepg_control_no', '!=', '')->get();



            foreach ($invoice_to_send as $invoice) {

                $amount_in_words = '';

                if ($invoice->currency_invoice == 'TZS') {
                    $amount_in_words = Terbilang::make($invoice->amount_to_be_paid, ' TZS', ' ');

                }
                if ($invoice->currency_invoice == 'USD') {

                    $amount_in_words = Terbilang::make($invoice->amount_to_be_paid, ' USD', ' ');
                } else {


                }

                $financial_year = DB::table('system_settings')->where('id', 1)->value('financial_year');
                $today = date('Y-m-d');

                $email_address = DB::table('insurance_contracts')->where('id', $invoice->contract_id)->value('email');

                if($email_address!='') {

                    Notification::route('mail', $email_address)
                        ->notify(new SendInvoice($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->amount_to_be_paid, $invoice->currency_invoice, $invoice->gepg_control_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));

                    DB::table('insurance_invoices_clients')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['invoice_date' => $today]);


                    DB::table('insurance_invoices_clients')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['email_sent_status' => 'SENT']);


                    DB::table('insurance_invoices_clients')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['stage' => 2]);


                    DB::table('invoice_notifications')->where('invoice_category', 'insurance')->where('invoice_id', $invoice->invoice_number)->delete();

                }else{



                }

            }


        }

        //All invoices already sent

        return redirect('/invoice_management')
            ->with('success', 'Emails Sent Successfully');
    }



    public function sendAllInvoicesPrincipalsInsurance(Request $request){

        DB::table('invoice_notifications')
            ->where('invoice_category','insurance')
            ->update(['to_be_sent' => 1]);

//        SendEmailsInsuranceJob::dispatch();

        //
        //

        $email_address='';
        $invoice_to_send='';
        $to_be_sent_insurance_invoices=DB::table('invoice_notifications')->where('invoice_category','insurance')->where('to_be_sent',1)->get();


        $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


        foreach($to_be_sent_insurance_invoices as $var) {

            $debtor_name = DB::table('insurance_invoices')->where('invoice_number', $var->invoice_id)->value('debtor_name');

            $invoice_to_send = DB::table('insurance_invoices')->where('invoice_number', $var->invoice_id)->where('gepg_control_no', '!=', '')->get();



            foreach ($invoice_to_send as $invoice) {

                $amount_in_words = '';

                if ($invoice->currency_invoice == 'TZS') {
                    $amount_in_words = Terbilang::make($invoice->amount_to_be_paid, ' TZS', ' ');

                }
                if ($invoice->currency_invoice == 'USD') {

                    $amount_in_words = Terbilang::make($invoice->amount_to_be_paid, ' USD', ' ');
                } else {


                }

                $financial_year = DB::table('system_settings')->where('id', 1)->value('financial_year');
                $today = date('Y-m-d');

                $email_address = DB::table('insurance_parameters')->where('company', $invoice->debtor_name)->value('company_email');

                if($email_address!='') {

                    Notification::route('mail', $email_address)
                        ->notify(new SendInvoice($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->amount_to_be_paid, $invoice->currency_invoice, $invoice->gepg_control_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));

                    DB::table('insurance_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['invoice_date' => $today]);


                    DB::table('insurance_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['email_sent_status' => 'SENT']);

                    DB::table('insurance_invoices')
                        ->where('invoice_number', $invoice->invoice_number)
                        ->update(['stage' => 2]);


                    DB::table('invoice_notifications')->where('invoice_category', 'insurance')->where('invoice_id', $invoice->invoice_number)->delete();

                }else{



                }

            }


        }

        //All invoices already sent

        return redirect('/invoice_management')
            ->with('success', 'Emails Sent Successfully');
    }




    public function sendAllInvoicesCar(Request $request){

        DB::table('invoice_notifications')
            ->where('invoice_category','car_rental')
            ->update(['to_be_sent' => 1]);

//        SendEmailsCarJob::dispatch();

        //
        //

        $email_address='';
        $invoice_to_send='';
        $to_be_sent_car_invoices=DB::table('invoice_notifications')->where('invoice_category','car_rental')->where('to_be_sent',1)->get();



        $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


        foreach($to_be_sent_car_invoices as $var) {

            $debtor_name = DB::table('car_rental_invoices')->where('invoice_number', $var->invoice_id)->value('debtor_name');

            $invoice_to_send = DB::table('car_rental_invoices')->where('invoice_number', $var->invoice_id)->get();



            foreach ($invoice_to_send as $invoice) {

                $amount_in_words = '';

                if ($invoice->currency_invoice == 'TZS') {
                    $amount_in_words = Terbilang::make($invoice->amount_to_be_paid, ' TZS', ' ');

                }
                if ($invoice->currency_invoice == 'USD') {

                    $amount_in_words = Terbilang::make($invoice->amount_to_be_paid, ' USD', ' ');
                } else {


                }

                $financial_year = DB::table('system_settings')->where('id', 1)->value('financial_year');
                $today = date('Y-m-d');
                $email_address = DB::table('car_contracts')->where('id', $invoice->contract_id)->value('email');

                if($email_address!='') {


                    if($invoice->gepg_control_no!='') {
                        Notification::route('mail', $email_address)
                            ->notify(new SendInvoice($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->amount_to_be_paid, $invoice->currency_invoice, $invoice->gepg_control_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));

                        DB::table('car_rental_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['invoice_date' => $today]);


                        DB::table('car_rental_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['email_sent_status' => 'SENT']);


                        DB::table('car_rental_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['stage' => 2]);


                        DB::table('invoice_notifications')->where('invoice_category', 'car_rental')->where('invoice_id', $invoice->invoice_number)->delete();


                    }elseif ($invoice->account_no!='') {
                        Notification::route('mail', $email_address)
                            ->notify(new SendInvoiceCar($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->amount_to_be_paid, $invoice->currency_invoice, $invoice->account_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));


                        DB::table('car_rental_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['invoice_date' => $today]);


                        DB::table('car_rental_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['email_sent_status' => 'SENT']);


                        DB::table('car_rental_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['stage' => 2]);


                        DB::table('invoice_notifications')->where('invoice_category', 'car_rental')->where('invoice_id', $invoice->invoice_number)->delete();


                    } else{


                    }

                }else{




                }

            }


        }

        //All invoices already sent





        return redirect('/invoice_management')
            ->with('success', 'Emails Sent Successfully');
    }



    public function sendAllInvoicesResearch(Request $request){

        DB::table('invoice_notifications')
            ->where('invoice_category','research')
            ->update(['to_be_sent' => 1]);

//        SendEmailsJob::dispatch();

        //
        //

        $email_address='';
        $invoice_to_send='';
        $to_be_sent__invoices=DB::table('invoice_notifications')->where('invoice_category','research')->where('to_be_sent',1)->get();



        $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


        foreach($to_be_sent__invoices as $var) {

            $debtor_name = DB::table('research_flats_invoices')->where('invoice_number', $var->invoice_id)->value('debtor_name');

            $invoice_to_send = DB::table('research_flats_invoices')->where('invoice_number', $var->invoice_id)->get();



            foreach ($invoice_to_send as $invoice) {

                $amount_in_words = '';

                if ($invoice->currency_invoice == 'TZS') {
                    $amount_in_words = Terbilang::make($invoice->amount_to_be_paid, ' TZS', ' ');

                }
                if ($invoice->currency_invoice == 'USD') {

                    $amount_in_words = Terbilang::make($invoice->amount_to_be_paid, ' USD', ' ');
                } else {


                }

                $financial_year = DB::table('system_settings')->where('id', 1)->value('financial_year');
                $today = date('Y-m-d');
                $email_address = DB::table('research_flats_contracts')->where('id', $invoice->contract_id)->value('email');

                if($email_address!='') {


                    if($invoice->gepg_control_no!='') {
                        Notification::route('mail', $email_address)
                            ->notify(new SendInvoice($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->amount_to_be_paid, $invoice->currency_invoice, $invoice->gepg_control_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));

                        DB::table('research_flats_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['invoice_date' => $today]);


                        DB::table('research_flats_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['email_sent_status' => 'SENT']);

                        DB::table('research_flats_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['stage' => 2]);


                        DB::table('invoice_notifications')->where('invoice_category', 'research')->where('invoice_id', $invoice->invoice_number)->delete();


                    }elseif ($invoice->account_no!='') {
                        Notification::route('mail', $email_address)
                            ->notify(new SendInvoiceCar($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->amount_to_be_paid, $invoice->currency_invoice, $invoice->account_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));


                        DB::table(' research_flats_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['invoice_date' => $today]);


                        DB::table('research_flats_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['email_sent_status' => 'SENT']);


                        DB::table('research_flats_invoices')
                            ->where('invoice_number', $invoice->invoice_number)
                            ->update(['stage' => 2]);


                        DB::table('invoice_notifications')->where('invoice_category', 'research')->where('invoice_id', $invoice->invoice_number)->delete();


                    } else{


                    }

                }else{




                }

            }


        }

        //All invoices already sent





        return redirect('/invoice_management')
            ->with('success', 'Emails Sent Successfully');
    }





    public function addControlNumberSpace(Request $request,$id){


        DB::table('invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


        DB::table('invoices')
            ->where('invoice_number',$id)
            ->update(['gepg_control_no' =>$request->get('gepg_control_no')]);


        DB::table('invoices')
            ->where('invoice_number',$id)
            ->update(['inc_code' =>$request->get('inc_code')]);


        DB::table('invoices')
            ->where('invoice_number', $id)
            ->update(['rejected' => 0]);


        DB::table('invoices')
            ->where('invoice_number', $id)
            ->update(['stage' => 2]);

        DB::table('invoices')
            ->where('invoice_number', $id)
            ->update(['updated_at' => Carbon::now()->toDateTimeString()]);



        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }



    public function addControlNumberInsurance(Request $request,$id){

        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


        DB::table('insurance_invoices_clients')
            ->where('invoice_number',$id)
            ->update(['inc_code' =>$request->get('inc_code')]);




        DB::table('insurance_invoices_clients')
            ->where('invoice_number',$id)
            ->update(['gepg_control_no' =>$request->get('gepg_control_no')]);


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }


    public function addControlNumberInsurancePrincipals(Request $request,$id){

        DB::table('insurance_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


        DB::table('insurance_invoices')
            ->where('invoice_number',$id)
            ->update(['inc_code' =>$request->get('inc_code')]);



        DB::table('insurance_invoices')
            ->where('invoice_number',$id)
            ->update(['gepg_control_no' =>$request->get('gepg_control_no')]);


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }




    public function addControlNumberCar(Request $request,$id){


        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('car_rental_invoices')
            ->where('invoice_number',$id)
            ->update(['inc_code' =>$request->get('inc_code')]);

        DB::table('car_rental_invoices')
            ->where('invoice_number',$id)
            ->update(['gepg_control_no' =>$request->get('gepg_control_no')]);


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }



    public function addControlNumberResearch(Request $request,$id){


        DB::table('research_flats_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('research_flats_invoices')
            ->where('invoice_number',$id)
            ->update(['inc_code' =>$request->get('inc_code')]);

        DB::table('research_flats_invoices')
            ->where('invoice_number',$id)
            ->update(['gepg_control_no' =>$request->get('gepg_control_no')]);


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }



    public function addControlNumberWater(Request $request,$id){


        DB::table('water_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('water_bill_invoices')
            ->where('invoice_number',$id)
            ->update(['inc_code' =>$request->get('inc_code')]);


        DB::table('water_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['rejected' => 0]);


        DB::table('water_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['stage' => 2]);


        DB::table('water_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['updated_at' => Carbon::now()->toDateTimeString()]);




        $invoice_data=DB::table('water_bill_invoices')->where('invoice_number', $id)->get();

        foreach($invoice_data as $var){


            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['gepg_control_no' => $request->get('gepg_control_no')]);

//            DB::table('water_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['current_amount' => $request->get('current_amount')]);
//
//
//            DB::table('water_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['cumulative_amount' => ($request->get('current_amount')+$var->debt)]);
//
//
//
//            DB::table('water_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['currency_invoice' => $request->get('currency')]);


//            DB::table('water_bill_payments')->insert(
//                ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->cumulative_amount,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//            );



        }


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }




    public function addControlNumberElectricity(Request $request,$id){

        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


        DB::table('electricity_bill_invoices')
            ->where('invoice_number',$id)
            ->update(['inc_code' =>$request->get('inc_code')]);



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['rejected' => 0]);


        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['stage' => 2]);


        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['updated_at' => Carbon::now()->toDateTimeString()]);






        $invoice_data=DB::table('electricity_bill_invoices')->where('invoice_number', $id)->get();

        foreach($invoice_data as $var){



            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['gepg_control_no' => $request->get('gepg_control_no')]);

//            DB::table('electricity_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['current_amount' => $request->get('current_amount')]);
//
//
//            DB::table('electricity_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['cumulative_amount' => ($request->get('current_amount')+$var->debt)]);
//
//
//
//            DB::table('electricity_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['currency_invoice' => $request->get('currency')]);


//            DB::table('water_bill_payments')->insert(
//                ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->cumulative_amount,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//            );



        }


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }






    //Car Rental invoices

    public function CreateCarInvoiceManually(Request $request)
    {



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


        $period= date("d/m/Y",strtotime($request->get('invoicing_period_start_date'))).' to  '. date("d/m/Y",strtotime($request->get('invoicing_period_end_date')));


        $invoice_to_be_created=DB::select('call invoice_exists_car (?,?,?)',[$request->get('contract_id'),$request->get('invoicing_period_start_date'),$request->get('invoicing_period_end_date')]);


        if(count($invoice_to_be_created)==0){

            DB::table('car_rental_invoices')->insert(
                ['invoice_number_votebook'=>$request->get('invoice_number'),'contract_id' => $request->get('contract_id','N/A'), 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $period,'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'amount_to_be_paid' => $request->get('amount_to_be_paid'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>$request->get('tin','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>$request->get('inc_code'),'invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A','stage'=>1]
            );

            $invoice_number_created=DB::table('car_rental_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'car_rental']
            );

            DB::table('car_rental_payments')->insert(
                ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => $request->get('invoice_number'),'amount_paid' => 0,'amount_not_paid' =>$request->get('amount_to_be_paid'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
            );


        }else{

            return redirect()->back()->with("error","Invoice already exists. Please try again");
        }


        return redirect('/invoice_management')
            ->with('success', 'Car rental invoice created Successfully');




    }




    //Research invoices

    public function CreateResearchInvoiceManually(Request $request)
    {



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


        $period= date("d/m/Y",strtotime($request->get('invoicing_period_start_date'))).' to  '. date("d/m/Y",strtotime($request->get('invoicing_period_end_date')));


        $invoice_to_be_created=DB::select('call invoice_exists_research (?,?,?)',[$request->get('contract_id'),$request->get('invoicing_period_start_date'),$request->get('invoicing_period_end_date')]);


        if(count($invoice_to_be_created)==0){

            DB::table('research_flats_invoices')->insert(
                ['invoice_number_votebook'=>$request->get('invoice_number'),'contract_id' => $request->get('contract_id','N/A'), 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $period,'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'amount_to_be_paid' => $request->get('amount_to_be_paid'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>$request->get('tin','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>$request->get('inc_code'),'invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A','stage'=>1]
            );

            $invoice_number_created=DB::table('research_flats_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'research']
            );

            DB::table('research_flats_payments')->insert(
                ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => $request->get('invoice_number'),'amount_paid' => 0,'amount_not_paid' =>$request->get('amount_to_be_paid'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
            );


        }else{

            return redirect()->back()->with("error","Invoice already exists. Please try again");
        }


        return redirect('/invoice_management')
            ->with('success', 'Research flats invoice created Successfully');




    }



    public function CarRentalInvoiceManagement()
    {

        $invoices_not_sent=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->where('car_rental_invoices.email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->where('car_rental_invoices.email_sent_status','SENT')->where('car_rental_invoices.payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('car_rental_invoices')->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')->where('car_rental_invoices.payment_status','Paid')->where('car_rental_invoices.email_sent_status','SENT')->get();


        return view('car_rental_invoices_management')->with('invoices_not_sent',$invoices_not_sent)->with('invoices_payment_not_complete',$invoices_payment_not_complete)->with('invoices_payment_complete',$invoices_payment_complete);


    }


    public function changePayementStatusCarRental(Request $request,$id)
    {

        $payment_status='';
        $amount_to_be_paid=DB::table('car_rental_invoices')->where('invoice_number', $id)->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if($request->get('amount_paid')<$amount_to_be_paid){
            $payment_status='Partially Paid';


        }elseif($request->get('amount_paid')==$amount_to_be_paid) {
            $payment_status='Paid';


        }else{


        }


        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $payment_status]);

        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);


//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );


        DB::table('car_rental_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('car_rental_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_paid' => $request->get('amount_paid')]);

        DB::table('car_rental_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_not_paid' => $amount_not_paid]);

        DB::table('car_rental_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['currency_payments' => $request->get('currency_payments')]);

        DB::table('car_rental_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['receipt_number' => $request->get('receipt_number')]);

        DB::table('car_rental_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['date_of_payment' => $request->get('date_of_payment')]);


        return redirect('/invoice_management')
            ->with('success', 'Payment received successfully');

    }




    public function changePayementStatusResearch(Request $request,$id)
    {

        $payment_status='';
        $amount_to_be_paid=DB::table('research_flats_invoices')->where('invoice_number', $id)->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if($request->get('amount_paid')<$amount_to_be_paid){
            $payment_status='Partially Paid';


        }elseif($request->get('amount_paid')==$amount_to_be_paid) {
            $payment_status='Paid';


        }else{


        }


        DB::table('research_flats_invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $payment_status]);

        DB::table('research_flats_invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);


//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );


        DB::table('research_flats_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('research_flats_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_paid' => $request->get('amount_paid')]);

        DB::table('research_flats_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_not_paid' => $amount_not_paid]);

        DB::table('research_flats_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['currency_payments' => $request->get('currency_payments')]);

        DB::table('research_flats_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['receipt_number' => $request->get('receipt_number')]);

        DB::table('research_flats_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['date_of_payment' => $request->get('date_of_payment')]);


        return redirect('/invoice_management')
            ->with('success', 'Payment received successfully');

    }



//insurance invoices

    public function insuranceInvoiceManagement()
    {

        $invoices_not_sent=DB::table('insurance_invoices')->where('email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('insurance_invoices')->where('email_sent_status','SENT')->where('payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('insurance_invoices')->where('payment_status','Paid')->where('email_sent_status','SENT')->get();


        return view('insurance_invoices_management')->with('invoices_not_sent',$invoices_not_sent)->with('invoices_payment_not_complete',$invoices_payment_not_complete)->with('invoices_payment_complete',$invoices_payment_complete);


    }







    public function CreateInsuranceInvoiceManually(Request $request)
    {



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


        $period= date("d/m/Y",strtotime($request->get('invoicing_period_start_date'))).' to  '. date("d/m/Y",strtotime($request->get('invoicing_period_end_date')));


        $invoice_to_be_created=DB::select('call invoice_exists_insurance (?,?,?)',[$request->get('invoicing_period_start_date'),$request->get('invoicing_period_end_date'),$request->get('debtor_name')]);


        if(count($invoice_to_be_created)==0){

            DB::table('insurance_invoices')->insert(
                ['invoice_number_votebook'=>$request->get('invoice_number'),'contract_id' => '', 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $period,'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'amount_to_be_paid' => $request->get('amount_to_be_paid'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>$request->get('tin','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>$request->get('inc_code'),'invoice_category'=>'Insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A','stage'=>1]
            );

            $invoice_number_created=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'insurance']
            );

            DB::table('insurance_payments')->insert(
                ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => $request->get('invoice_number'),'amount_paid' => 0,'amount_not_paid' =>$request->get('amount_to_be_paid'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
            );


        }else{
            return redirect()->back()->with("error","Invoice already exists. Please try again");

        }


        return redirect('/invoice_management')
            ->with('success', 'Insurance invoice created Successfully');




    }





    public function CreateInsuranceInvoiceClientsManually(Request $request)
    {



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


        $period= date("d/m/Y",strtotime($request->get('invoicing_period_start_date'))).' to  '. date("d/m/Y",strtotime($request->get('invoicing_period_end_date')));


        $invoice_to_be_created=DB::select('call invoice_exists_insurance_clients (?,?,?)',[$request->get('invoicing_period_start_date'),$request->get('invoicing_period_end_date'),$request->get('debtor_name')]);


        if(count($invoice_to_be_created)==0){

            DB::table('insurance_invoices_clients')->insert(
                ['invoice_number_votebook'=>$request->get('invoice_number'),'contract_id' => $request->get("contract_id"), 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $period,'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'amount_to_be_paid' => $request->get('amount_to_be_paid'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>$request->get('tin','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>$request->get('inc_code'),'invoice_category'=>'Insurance','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A','stage'=>1]
            );

            $invoice_number_created=DB::table('insurance_invoices_clients')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'insurance_clients']
            );

            DB::table('insurance_clients_payments')->insert(
                ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$request->get('amount_to_be_paid'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
            );


        }else{
            return redirect()->back()->with("error","Invoice already exists. Please try again");

        }


        return redirect('/invoice_management')
            ->with('success', 'Insurance invoice created Successfully');




    }








    public function sendInvoiceInsurance(Request $request,$id)
    {

        DB::table('insurance_clients_payments')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);



        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $id)
            ->update(['inc_code' => $request->get('inc_code')]);



        $invoice_data=DB::table('insurance_invoices_clients')->where('invoice_number', $id)->get();
        $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
        $today=date('Y-m-d');

        foreach($invoice_data as $var){

            $amount_in_words='';

            if($var->currency_invoice=='TZS'){
                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' TZS',' ');

            }if ($var->currency_invoice=='USD'){

                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' USD',' ');
            }

            else{



            }


            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


            $email_address=DB::table('insurance_contracts')->where('id',$var->contract_id)->value('email');


            if($email_address==''){
                return redirect()->back()->with("error","No email address provided, Please verify the existence of email address and try again");
            }else{


            }


            Notification::route('mail',$email_address)
                ->notify(new SendInvoice($var->debtor_name,$request->get('invoice_number_votebook'),$var->project_id,$var->debtor_account_code,$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency_invoice,$request->get('gepg_control_no'),$var->tin,$max_no_of_days_to_pay,$var->status,$var->vrn,$amount_in_words,$var->inc_code,$today,$financial_year,$var->period,$var->description,$var->prepared_by,Auth::user()->name,date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

            DB::table('insurance_invoices_clients')
                ->where('invoice_number', $id)
                ->update(['invoice_date' => $today]);


            DB::table('insurance_invoices_clients')
                ->where('invoice_number', $id)
                ->update(['email_sent_status' => 'SENT']);

            DB::table('insurance_invoices_clients')
                ->where('invoice_number', $id)
                ->update(['gepg_control_no' => $request->get('gepg_control_no')]);


//            DB::table('insurance_payments')->insert(
//                ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//            );


        }


        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $id)
            ->update(['stage' => 2]);


        DB::table('invoice_notifications')->where('invoice_category',  'insurance')->where('invoice_id',$id)->delete();


        return redirect('/invoice_management')
            ->with('success', 'Invoice Sent Successfully');

    }




    public function sendInvoiceInsurancePrincipals(Request $request,$id)
    {

        DB::table('insurance_payments')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


        DB::table('insurance_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


        DB::table('insurance_invoices')
            ->where('invoice_number', $id)
            ->update(['inc_code' => $request->get('inc_code')]);



        $invoice_data=DB::table('insurance_invoices')->where('invoice_number', $id)->get();
        $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
        $today=date('Y-m-d');

        foreach($invoice_data as $var){

            $amount_in_words='';

            if($var->currency_invoice=='TZS'){
                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' TZS',' ');

            }if ($var->currency_invoice=='USD'){

                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' USD',' ');
            }

            else{



            }


            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


            $email_address=DB::table('insurance_parameters')->where('company',$var->debtor_name)->value('company_email');

            if($email_address==''){
                return redirect()->back()->with("error","No email address provided, Please verify the existence of email address and try again");
            }else{


            }

            Notification::route('mail',$email_address)
                ->notify(new SendInvoice($var->debtor_name,$request->get('invoice_number_votebook'),$var->project_id,$var->debtor_account_code,$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency_invoice,$request->get('gepg_control_no'),$var->tin,$max_no_of_days_to_pay,$var->status,$var->vrn,$amount_in_words,$var->inc_code,$today,$financial_year,$var->period,$var->description,$var->prepared_by,Auth::user()->name,date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

            DB::table('insurance_invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_date' => $today]);


            DB::table('insurance_invoices')
                ->where('invoice_number', $id)
                ->update(['email_sent_status' => 'SENT']);

            DB::table('insurance_invoices')
                ->where('invoice_number', $id)
                ->update(['gepg_control_no' => $request->get('gepg_control_no')]);


//            DB::table('insurance_payments')->insert(
//                ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//            );


        }


        DB::table('insurance_invoices')
            ->where('invoice_number', $id)
            ->update(['stage' => 2]);

        DB::table('invoice_notifications')->where('invoice_category',  'insurance')->where('invoice_id',$id)->delete();


        return redirect('/invoice_management')
            ->with('success', 'Invoice Sent Successfully');

    }




    public function changePayementStatusInsurance(Request $request,$id)
    {

        $payment_status='';
        $amount_to_be_paid=DB::table('insurance_invoices_clients')->where('invoice_number', $id)->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if($request->get('amount_paid')<$amount_to_be_paid){
            $payment_status='Partially Paid';


        }elseif($request->get('amount_paid')==$amount_to_be_paid) {
            $payment_status='Paid';


        }else{


        }


        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $payment_status]);

        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);


//        DB::table('insurance_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );



        DB::table('insurance_clients_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('insurance_clients_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_paid' => $request->get('amount_paid')]);

        DB::table('insurance_clients_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_not_paid' => $amount_not_paid]);

        DB::table('insurance_clients_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['currency_payments' => $request->get('currency_payments')]);

        DB::table('insurance_clients_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['receipt_number' => $request->get('receipt_number')]);

        DB::table('insurance_clients_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['date_of_payment' => $request->get('date_of_payment')]);


        return redirect('/invoice_management')
            ->with('success', 'Payment received successfully');

    }




    public function changePayementStatusInsurancePrincipals(Request $request,$id)
    {

        $payment_status='';
        $amount_to_be_paid=DB::table('insurance_invoices')->where('invoice_number', $id)->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if($request->get('amount_paid')<$amount_to_be_paid){
            $payment_status='Partially Paid';


        }elseif($request->get('amount_paid')==$amount_to_be_paid) {
            $payment_status='Paid';


        }else{


        }


        DB::table('insurance_invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $payment_status]);

        DB::table('insurance_invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);


//        DB::table('insurance_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );



        DB::table('insurance_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('insurance_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_paid' => $request->get('amount_paid')]);

        DB::table('insurance_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_not_paid' => $amount_not_paid]);

        DB::table('insurance_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['currency_payments' => $request->get('currency_payments')]);

        DB::table('insurance_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['receipt_number' => $request->get('receipt_number')]);

        DB::table('insurance_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['date_of_payment' => $request->get('date_of_payment')]);


        return redirect('/invoice_management')
            ->with('success', 'Payment received successfully');

    }




//Electricity bills


    public function ElectricityBillsInvoiceManagement()
    {
        $invoices_not_sent=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->where('electricity_bill_invoices.email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->where('electricity_bill_invoices.email_sent_status','SENT')->where('electricity_bill_invoices.payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('electricity_bill_invoices')->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')->where('electricity_bill_invoices.payment_status','Paid')->where('electricity_bill_invoices.email_sent_status','SENT')->get();

        return view('electricity_bill_invoices_management')->with('invoices_not_sent', $invoices_not_sent)->with('invoices_payment_not_complete', $invoices_payment_not_complete)->with('invoices_payment_complete', $invoices_payment_complete);


    }

    public function fowardSpaceInvoice(Request $request,$invoice_id)
    {



        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_name' => $request->get('debtor_name')]);






        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_account_code' => $request->get('debtor_account_code')]);


        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['tin' => $request->get('tin')]);

        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_address' => $request->get('debtor_address')]);

        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_start_date' => $request->get('invoicing_period_start_date')]);



        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_end_date' => $request->get('invoicing_period_end_date')]);




        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['period' => $request->get('period')]);


//        DB::table('invoices')
//            ->where('invoice_number', $invoice_id)
//            ->update(['inc_code' => $request->get('inc_code')]);




        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['project_id' => $request->get('project_id')]);



        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['amount_to_be_paid' => $request->get('amount_to_be_paid')]);



        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['currency_invoice' => $request->get('currency')]);





        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['status' => $request->get('status')]);



        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['description' => $request->get('description')]);


        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['prepared_by' => Auth::user()->name]);


        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['stage' => 1]);


        DB::table('invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['updated_at' => Carbon::now()->toDateTimeString()]);



        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }




    public function fowardCarInvoice(Request $request,$invoice_id)
    {



        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_name' => $request->get('debtor_name')]);



        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_account_code' => $request->get('debtor_account_code')]);


        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['tin' => $request->get('tin')]);

        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_address' => $request->get('debtor_address')]);

        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_start_date' => $request->get('invoicing_period_start_date')]);



        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_end_date' => $request->get('invoicing_period_end_date')]);




        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['period' => $request->get('period')]);


        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['inc_code' => $request->get('inc_code')]);




        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['project_id' => $request->get('project_id')]);



        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['amount_to_be_paid' => $request->get('amount_to_be_paid')]);



        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['currency_invoice' => $request->get('currency')]);





        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['status' => $request->get('status')]);



        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['description' => $request->get('description')]);


        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['prepared_by' => Auth::user()->name]);


        DB::table('car_rental_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['stage' => 1]);



        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }




    public function fowardResearchInvoice(Request $request,$invoice_id)
    {



        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_name' => $request->get('debtor_name')]);



        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_account_code' => $request->get('debtor_account_code')]);


        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['tin' => $request->get('tin')]);

        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_address' => $request->get('debtor_address')]);

        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_start_date' => $request->get('invoicing_period_start_date')]);



        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_end_date' => $request->get('invoicing_period_end_date')]);




        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['period' => $request->get('period')]);


        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['inc_code' => $request->get('inc_code')]);




        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['project_id' => $request->get('project_id')]);



        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['amount_to_be_paid' => $request->get('amount_to_be_paid')]);



        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['currency_invoice' => $request->get('currency')]);





        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['status' => $request->get('status')]);



        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['description' => $request->get('description')]);


        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['prepared_by' => Auth::user()->name]);



        DB::table('research_flats_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['stage' => 1]);



        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }




    public function fowardInsuranceInvoice(Request $request,$invoice_id)
    {



        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_name' => $request->get('debtor_name')]);



        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_account_code' => $request->get('debtor_account_code')]);


        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['tin' => $request->get('tin')]);

        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_address' => $request->get('debtor_address')]);

        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_start_date' => $request->get('invoicing_period_start_date')]);



        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_end_date' => $request->get('invoicing_period_end_date')]);




        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['period' => $request->get('period')]);


        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['inc_code' => $request->get('inc_code')]);




        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['project_id' => $request->get('project_id')]);



        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['amount_to_be_paid' => $request->get('amount_to_be_paid')]);



        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['currency_invoice' => $request->get('currency')]);





        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['status' => $request->get('status')]);



        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['description' => $request->get('description')]);


        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['prepared_by' => Auth::user()->name]);


        DB::table('insurance_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['stage' => 1]);



        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }





    public function fowardInsuranceClientsInvoice(Request $request,$invoice_id)
    {



        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_name' => $request->get('debtor_name')]);



        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_account_code' => $request->get('debtor_account_code')]);


        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['tin' => $request->get('tin')]);

        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_address' => $request->get('debtor_address')]);

        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_start_date' => $request->get('invoicing_period_start_date')]);



        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_end_date' => $request->get('invoicing_period_end_date')]);




        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['period' => $request->get('period')]);


        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['inc_code' => $request->get('inc_code')]);




        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['project_id' => $request->get('project_id')]);



        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['amount_to_be_paid' => $request->get('amount_to_be_paid')]);



        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['currency_invoice' => $request->get('currency')]);





        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['status' => $request->get('status')]);



        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['description' => $request->get('description')]);


        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['prepared_by' => Auth::user()->name]);


        DB::table('insurance_invoices_clients')
            ->where('invoice_number', $invoice_id)
            ->update(['stage' => 1]);



        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }



    public function fowardWaterInvoice(Request $request,$invoice_id)
    {



        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_name' => $request->get('debtor_name')]);



        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_account_code' => $request->get('debtor_account_code')]);


        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['tin' => $request->get('tin')]);

        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_address' => $request->get('debtor_address')]);

        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_start_date' => $request->get('invoicing_period_start_date')]);



        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_end_date' => $request->get('invoicing_period_end_date')]);




        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['period' => $request->get('period')]);

//        DB::table('water_bill_invoices')
//            ->where('invoice_number', $invoice_id)
//            ->update(['inc_code' => $request->get('inc_code')]);


        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['project_id' => $request->get('project_id')]);



        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['cumulative_amount' => $request->get('amount_to_be_paid')]);






        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['begin_units' => $request->get('begin_units')]);



        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['end_units' => $request->get('end_units')]);

        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['consumed_units' => $request->get('units_usage')]);



        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debt' => $request->get('debt')]);

        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['current_amount' => $request->get('current_amount')]);





        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['currency_invoice' => $request->get('currency')]);





        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['status' => $request->get('status')]);



        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['description' => $request->get('description')]);


        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['prepared_by' => Auth::user()->name]);



        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['stage' => 1]);



        DB::table('water_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['updated_at' => Carbon::now()->toDateTimeString()]);



        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }


    public function fowardElectricityInvoice(Request $request,$invoice_id)
    {



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_name' => $request->get('debtor_name')]);



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_account_code' => $request->get('debtor_account_code')]);


        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['tin' => $request->get('tin')]);

        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debtor_address' => $request->get('debtor_address')]);

        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_start_date' => $request->get('invoicing_period_start_date')]);



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['invoicing_period_end_date' => $request->get('invoicing_period_end_date')]);




        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['period' => $request->get('period')]);


//        DB::table('electricity_bill_invoices')
//            ->where('invoice_number', $invoice_id)
//            ->update(['inc_code' => $request->get('inc_code')]);


        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['project_id' => $request->get('project_id')]);



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['cumulative_amount' => $request->get('amount_to_be_paid')]);




        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['begin_units' => $request->get('begin_units')]);



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['end_units' => $request->get('end_units')]);

        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['consumed_units' => $request->get('units_usage')]);



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['debt' => $request->get('debt')]);

        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['current_amount' => $request->get('current_amount')]);



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['currency_invoice' => $request->get('currency')]);





        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['status' => $request->get('status')]);



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['description' => $request->get('description')]);


        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['prepared_by' => Auth::user()->name]);



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['stage' => 1]);



        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $invoice_id)
            ->update(['updated_at' => Carbon::now()->toDateTimeString()]);



        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }


    public function CreateElectricityBillInvoiceManually(Request $request)
    {



        if ($request->get('invoicing_period_start_date')>$request->get('invoicing_period_end_date')) {

            return redirect()->back()->with("error","Invoice start date cannot be greater than invoice end date. Please try again");
        }



        $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
        $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');
        $today=date('Y-m-d');

        $amount_in_words='';

        if($request->get('currency')=='TZS'){
            $amount_in_words=Terbilang::make($request->get('cumulative_amount'),' TZS',' ');

        }if ($request->get('currency')=='USD'){

        $amount_in_words=Terbilang::make($request->get('cumulative_amount'),' USD',' ');
    }

    else{


    }


        $period= date("d/m/Y",strtotime($request->get('invoicing_period_start_date'))).' to  '. date("d/m/Y",strtotime($request->get('invoicing_period_end_date')));


        $invoice_to_be_created=DB::select('call invoice_exists_electricity (?,?,?)',[$request->get('contract_id'),$request->get('invoicing_period_start_date'),$request->get('invoicing_period_end_date')]);


        if(count($invoice_to_be_created)==0){

            DB::table('electricity_bill_invoices')->insert(
                ['invoice_number_votebook'=>$request->get('invoice_number'),'contract_id' => $request->get('contract_id','N/A'), 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $period,'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'current_amount' => $request->get('current_amount'),'cumulative_amount' => $request->get('cumulative_amount'),'debt' => $request->get('debt'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>$request->get('tin','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>$request->get('inc_code'),'invoice_category'=>'Electricity','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A','stage'=>1,'begin_units'=>$request->get('begin_units'),'end_units'=>$request->get('end_units'),'consumed_units'=>$request->get('units_usage'),'unit_price'=>$request->get('unit_price')]
            );

            $invoice_number_created=DB::table('electricity_bill_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'electricity bill']
            );

            DB::table('electricity_bill_payments')->insert(
                ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => $request->get('invoice_number'),'amount_paid' => 0,'amount_not_paid' =>$request->get('cumulative_amount'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
            );



        }else{

            return redirect()->back()->with("error","Invoice already exists. Please try again");
        }


        return redirect('/invoice_management')
            ->with('success', 'Electricity bill invoice created Successfully');




    }




    public function sendInvoiceElectricityBills(Request $request,$id)
    {


        if($request->get('approval_status_electricity')=='Rejected'){

            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['stage' => 0]);

            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['rejected' => 1]);


            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['reason' => $request->get('reason')]);


            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['updated_at' => Carbon::now()->toDateTimeString()]);




            return redirect('/invoice_management')
                ->with('success', 'Operation completed successfully');

        }else{




            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['rejected' => 0]);



            DB::table('electricity_bill_payments')
                ->where('invoice_number', $id)
                ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


            $invoice_data=DB::table('electricity_bill_invoices')->where('invoice_number', $id)->get();
            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
            $today=date('Y-m-d');

            foreach($invoice_data as $var){

                $amount_in_words='';

                if($var->currency_invoice=='TZS'){
                    $amount_in_words=Terbilang::make(($var->cumulative_amount),' TZS',' ');

                }if ($var->currency_invoice=='USD'){

                    $amount_in_words=Terbilang::make(($var->cumulative_amount),' USD',' ');
                }

                else{



                }


                $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');

                $email_address=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.contract_id',$var->contract_id)->value('email');


                if($email_address==''){
                    return redirect()->back()->with("error","No email address provided, Please verify the existence of email address and try again");
                }else{


                }

                Notification::route('mail',$email_address)
                    ->notify(new SendInvoice($var->debtor_name,$request->get('invoice_number_votebook'),$var->project_id,$var->debtor_account_code,$var->debtor_name,$var->debtor_address,$var->cumulative_amount,$var->currency_invoice,$request->get('gepg_control_no'),$var->tin,$max_no_of_days_to_pay,$var->status,$var->vrn,$amount_in_words,$var->inc_code,$today,$financial_year,$var->period,$var->description,$var->prepared_by,Auth::user()->name,date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

                DB::table('electricity_bill_invoices')
                    ->where('invoice_number', $id)
                    ->update(['invoice_date' => $today]);


                DB::table('electricity_bill_invoices')
                    ->where('invoice_number', $id)
                    ->update(['email_sent_status' => 'SENT']);

                DB::table('electricity_bill_invoices')
                    ->where('invoice_number', $id)
                    ->update(['gepg_control_no' => $request->get('gepg_control_no')]);

//            DB::table('electricity_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['current_amount' => $request->get('current_amount')]);
//
//
//            DB::table('electricity_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['cumulative_amount' => ($request->get('current_amount')+$var->debt)]);
//
//
//
//            DB::table('electricity_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['currency_invoice' => $request->get('currency')]);


//            DB::table('electricity_bill_payments')->insert(
//                ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->cumulative_amount,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//            );



            }

            DB::table('invoice_notifications')->where('invoice_category',  'electricity bill')->where('invoice_id',$id)->delete();




            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['stage' => 3]);


            DB::table('electricity_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['updated_at' => Carbon::now()->toDateTimeString()]);





            return redirect('/invoice_management')
                ->with('success', 'Invoice Sent Successfully');



        }






    }


    public function changePaymentStatusElectricityBills(Request $request,$id)
    {

        $payment_status='';
        $amount_to_be_paid=DB::table('electricity_bill_invoices')->where('invoice_number', $id)->value('cumulative_amount');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if($request->get('amount_paid')<$amount_to_be_paid){
            $payment_status='Partially Paid';


        }elseif($request->get('amount_paid')==$amount_to_be_paid) {
            $payment_status='Paid';


        }else{


        }


        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $payment_status]);

        DB::table('electricity_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);


//        DB::table('electricity_bill_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );

        DB::table('electricity_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('electricity_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_paid' => $request->get('amount_paid')]);

        DB::table('electricity_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_not_paid' => $amount_not_paid]);

        DB::table('electricity_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['currency_payments' => $request->get('currency_payments')]);

        DB::table('electricity_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['receipt_number' => $request->get('receipt_number')]);

        DB::table('electricity_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['date_of_payment' => $request->get('date_of_payment')]);




        return redirect('/invoice_management')
            ->with('success', 'Payment received Successfully');

    }





    public function sendInvoiceCarRentalAccount(Request $request,$id)
    {

        DB::table('car_rental_payments')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);


        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['inc_code' => $request->get('inc_code')]);




        $invoice_data=DB::table('car_rental_invoices')->where('invoice_number', $id)->get();
        $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
        $today=date('Y-m-d');

        foreach($invoice_data as $var){

            $amount_in_words='';

            if($var->currency_invoice=='TZS'){
                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' TZS',' ');

            }if ($var->currency_invoice=='USD'){

                $amount_in_words=Terbilang::make($var->amount_to_be_paid,' USD',' ');
            }

            else{


            }


            $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');




            $email_address=DB::table('car_contracts')->where('id',$var->contract_id)->value('email');

            if($email_address==''){
                return redirect()->back()->with("error","No email address provided, Please verify the existence of email address and try again");
            }else{


            }

            Notification::route('mail',$email_address)
                ->notify(new SendInvoiceCar($var->debtor_name,$request->get('invoice_number_votebook'),$var->project_id,$var->debtor_account_code,$var->debtor_name,$var->debtor_address,$var->amount_to_be_paid,$var->currency_invoice,$request->get('account_no'),$var->tin,$max_no_of_days_to_pay,$var->status,$var->vrn,$amount_in_words,$var->inc_code,$today,$financial_year,$var->period,$var->description,$var->prepared_by,Auth::user()->name,date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

            DB::table('car_rental_invoices')
                ->where('invoice_number', $id)
                ->update(['email_sent_status' => 'SENT']);

            DB::table('car_rental_invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_date' => $today]);


            DB::table('car_rental_invoices')
                ->where('invoice_number', $id)
                ->update(['account_no' => $request->get('account_no')]);


//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//        );





        }


        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['stage' => 2]);



        DB::table('invoice_notifications')->where('invoice_category',  'car_rental')->where('invoice_id',$id)->delete();

        return redirect('/invoice_management')
            ->with('success', 'Email Sent Successfully');

    }



    public function addAccountNumberCar(Request $request,$id){


        DB::table('car_rental_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);



        DB::table('car_rental_invoices')
            ->where('invoice_number',$id)
            ->update(['account_no' =>$request->get('account_no')]);


        return redirect('/invoice_management')
            ->with('success', 'Account number saved successfully');
    }


    public function addAccountNumberResearch(Request $request,$id){


        DB::table('research_flats_invoices')
            ->where('invoice_number', $id)
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);



        DB::table('research_flats_invoices')
            ->where('invoice_number',$id)
            ->update(['account_no' =>$request->get('account_no')]);


        return redirect('/invoice_management')
            ->with('success', 'Account number saved successfully');
    }



//water bills
    public function WaterBillsInvoiceManagement()
    {
        $invoices_not_sent=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->where('water_bill_invoices.email_sent_status','NOT SENT')->get();
        $invoices_payment_not_complete=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->where('water_bill_invoices.email_sent_status','SENT')->where('water_bill_invoices.payment_status','!=','Paid')->get();
        $invoices_payment_complete=DB::table('water_bill_invoices')->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')->where('water_bill_invoices.payment_status','Paid')->where('water_bill_invoices.email_sent_status','SENT')->get();

        return view('water_bill_invoices_management')->with('invoices_not_sent',$invoices_not_sent)->with('invoices_payment_not_complete',$invoices_payment_not_complete)->with('invoices_payment_complete',$invoices_payment_complete);



    }


    public function contractAvailabilityElectricity(Request $request)
    {



        if($request->get('query'))
        {
            $query = $request->get('query');


            $contract_data=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.contract_id', $query)->where('space_contracts.has_electricity_bill','Yes')->get();

            if(count($contract_data)!=0){

                $contract_invoice_no=DB::table('electricity_bill_invoices')->where('contract_id',$query)->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');
                $amount_not_paid=DB::table('electricity_bill_payments')->where('invoice_number',$contract_invoice_no)->where('invoice_number_votebook','!=','')->value('amount_not_paid');
                $currency=DB::table('electricity_bill_payments')->where('invoice_number',$contract_invoice_no)->value('currency_payments');

                $data="";
                if($amount_not_paid==null){

                    foreach($contract_data as $var) {
                        $data = [
                            'amount_not_paid' => 0,
                            'currency_payments' => 'default',
                            'full_name'=> $var->full_name,
                            'client_id'=>$var->client_id,
                            'tin'=>$var->tin,
                            'vrn'=>$var->vrn,
                            'address'=>$var->address,

                        ];
                    }

                }else{
                    foreach($contract_data as $var) {
                        $data = [
                            'amount_not_paid' => $amount_not_paid,
                            'currency_payments' => $currency,

                            'full_name' => $var->full_name,
                            'client_id' => $var->client_id,
                            'tin' => $var->tin,
                            'vrn' => $var->vrn,
                            'address' => $var->address,

                        ];
                    }
                }

                $final_value=json_encode($data);
                return $final_value;
            }
            else{
                echo "x";
            }



        }


    }




    public function contractAvailabilityWater(Request $request)
    {



        if($request->get('query'))
        {
            $query = $request->get('query');



            $contract_data=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.contract_id', $query)->where('space_contracts.has_water_bill','Yes')->get();

            if(count($contract_data)!=0){


                $contract_invoice_no=DB::table('water_bill_invoices')->where('contract_id',$query)->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

                $amount_not_paid=DB::table('water_bill_payments')->where('invoice_number',$contract_invoice_no)->where('invoice_number_votebook','!=','')->value('amount_not_paid');
                $currency=DB::table('water_bill_payments')->where('invoice_number',$contract_invoice_no)->value('currency_payments');
                $data="";
                if($amount_not_paid==null){

                    foreach($contract_data as $var ){

                        $data = [
                            'full_name'=> $var->full_name,
                            'client_id'=>$var->client_id,
                            'tin'=>$var->tin,
                            'vrn'=>$var->vrn,
                            'address'=>$var->address,

                            'amount_not_paid' => 0,
                            'currency_payments' => 'default'

                        ];
                    }

                }else{
                    foreach($contract_data as $var ) {
                        $data = [
                            'full_name' => $var->full_name,
                            'client_id' => $var->client_id,
                            'tin' => $var->tin,
                            'vrn' => $var->vrn,
                            'address' => $var->address,
                            'amount_not_paid' => $amount_not_paid,
                            'currency_payments' => $currency

                        ];
                    }
                }

                $final_value=json_encode($data);
                return $final_value;

            }
            else{
                echo "x";
            }










        }





    }


    public function contractAvailabilitySpace(Request $request)
    {



        if($request->get('query'))
        {
            $query = $request->get('query');



            $data=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.contract_id', $query)->get();

            if(count($data)!=0){


                return $data;
            }
            else{
                echo "0";
            }










        }





    }



    public function contractAvailabilityCar(Request $request)
    {



        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('car_contracts')->where('id',$query)->get();


            if(count($data)!=0){


                return $data;
            }
            else{
                echo "0";
            }










        }





    }



    public function contractAvailabilityResearch(Request $request)
    {



        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('research_flats_contracts')->where('id',$query)->get();


            if(count($data)!=0){


                return $data;
            }
            else{
                echo "0";
            }










        }





    }



    public function getInfoInsurance(Request $request)
    {



        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('insurance_parameters')->where('company',$query)->get();


            if(count($data)!=0){


                return $data;
            }
            else{
                echo "0";
            }










        }





    }



    public function CreateWaterBillInvoiceManually(Request $request)
    {



        if ($request->get('invoicing_period_start_date')>$request->get('invoicing_period_end_date')) {

            return redirect()->back()->with("error","Invoice start date cannot be greater than invoice end date. Please try again");
        }



        $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
        $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');
        $today=date('Y-m-d');

        $amount_in_words='';

        if($request->get('currency')=='TZS'){
            $amount_in_words=Terbilang::make($request->get('cumulative_amount'),' TZS',' ');

        }if ($request->get('currency')=='USD'){

        $amount_in_words=Terbilang::make($request->get('cumulative_amount'),' USD',' ');
    }

    else{


    }


        $period= date("d/m/Y",strtotime($request->get('invoicing_period_start_date'))).' to  '. date("d/m/Y",strtotime($request->get('invoicing_period_end_date')));


        $invoice_to_be_created=DB::select('call invoice_exists_water (?,?,?)',[$request->get('contract_id'),$request->get('invoicing_period_start_date'),$request->get('invoicing_period_end_date')]);


        if(count($invoice_to_be_created)==0){

            DB::table('water_bill_invoices')->insert(
                ['invoice_number_votebook'=>$request->get('invoice_number'),'contract_id' => $request->get('contract_id','N/A'), 'invoicing_period_start_date' => $request->get('invoicing_period_start_date'),'invoicing_period_end_date' => $request->get('invoicing_period_end_date'),'period' => $period,'project_id' => $request->get('project_id','N/A'),'debtor_account_code' => $request->get('debtor_account_code','N/A'),'debtor_name' => $request->get('debtor_name'),'debtor_address' => $request->get('debtor_address'),'current_amount' => $request->get('current_amount'),'cumulative_amount' => $request->get('cumulative_amount'),'debt' => $request->get('debt'),'currency_invoice'=>$request->get('currency'),'gepg_control_no'=>'','tin'=>$request->get('tin','N/A'),'vrn'=>$request->get('vrn','N/A'),'max_no_of_days_to_pay'=>$max_no_of_days_to_pay,'status'=>$request->get('status','N/A'),'amount_in_words'=>$amount_in_words,'inc_code'=>$request->get('inc_code'),'invoice_category'=>'Water','invoice_date'=>$today,'financial_year'=>$financial_year,'payment_status'=>'Not paid','description'=>$request->get('description','N/A'),'prepared_by'=>Auth::user()->name,'approved_by'=>'N/A','stage'=>1,'begin_units'=>$request->get('begin_units'),'end_units'=>$request->get('end_units'),'consumed_units'=>$request->get('units_usage'),'unit_price'=>$request->get('unit_price')]
            );

            $invoice_number_created=DB::table('water_bill_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'water bill']
            );

            DB::table('water_bill_payments')->insert(
                ['invoice_number' => $invoice_number_created, 'invoice_number_votebook' => $request->get('invoice_number'),'amount_paid' => 0,'amount_not_paid' =>$request->get('cumulative_amount'),'currency_payments' => $request->get('currency'),'receipt_number' => '']
            );



        }else{

            return redirect()->back()->with("error","Invoice already exists. Please try again");
        }


        return redirect('/invoice_management')
            ->with('success', 'Water bill invoice created Successfully');




    }






    public function sendInvoiceWaterBills(Request $request,$id)
    {


        if($request->get('approval_status_water')=='Rejected'){

            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['stage' => 0]);

            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['rejected' => 1]);


            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['reason' => $request->get('reason')]);


            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['updated_at' => Carbon::now()->toDateTimeString()]);




            return redirect('/invoice_management')
                ->with('success', 'Operation completed successfully');

        }else{


            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['rejected' => 0]);




            DB::table('water_bill_payments')
                ->where('invoice_number', $id)
                ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);



            $invoice_data=DB::table('water_bill_invoices')->where('invoice_number', $id)->get();
            $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');
            $today=date('Y-m-d');

            foreach($invoice_data as $var){

                $amount_in_words='';

                if($var->currency_invoice=='TZS'){
                    $amount_in_words=Terbilang::make(($var->cumulative_amount),' TZS',' ');

                }if ($var->currency_invoice=='USD'){

                    $amount_in_words=Terbilang::make(($var->cumulative_amount),' USD',' ');
                }

                else{



                }


                $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');

                $email_address=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.contract_id',$var->contract_id)->value('email');


                if($email_address==''){
                    return redirect()->back()->with("error","No email address provided, Please verify the existence of email address and try again");
                }else{


                }

                Notification::route('mail',$email_address)
                    ->notify(new SendInvoice($var->debtor_name,$request->get('invoice_number_votebook'),$var->project_id,$var->debtor_account_code,$var->debtor_name,$var->debtor_address,($var->cumulative_amount),$var->currency_invoice,$request->get('gepg_control_no'),$var->tin,$max_no_of_days_to_pay,$var->status,$var->vrn,$amount_in_words,$var->inc_code,$today,$financial_year,$var->period,$var->description,$var->prepared_by,Auth::user()->name,date("d/m/Y",strtotime($var->invoicing_period_start_date)) ,date("d/m/Y",strtotime($var->invoicing_period_end_date))));

                DB::table('water_bill_invoices')
                    ->where('invoice_number', $id)
                    ->update(['invoice_date' => $today]);


                DB::table('water_bill_invoices')
                    ->where('invoice_number', $id)
                    ->update(['email_sent_status' => 'SENT']);

                DB::table('water_bill_invoices')
                    ->where('invoice_number', $id)
                    ->update(['gepg_control_no' => $request->get('gepg_control_no')]);

//            DB::table('water_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['current_amount' => $request->get('current_amount')]);
//
//
//            DB::table('water_bill_invoices')
//                       ->where('invoice_number', $id)
//                       ->update(['cumulative_amount' => ($request->get('current_amount')+$var->debt)]);
//
//
//
//            DB::table('water_bill_invoices')
//                ->where('invoice_number', $id)
//                ->update(['currency_invoice' => $request->get('currency')]);


//            DB::table('water_bill_payments')->insert(
//                ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->cumulative_amount,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//            );



            }

            DB::table('invoice_notifications')->where('invoice_category',  'water bill')->where('invoice_id',$id)->delete();


            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['stage' => 3]);



            DB::table('water_bill_invoices')
                ->where('invoice_number', $id)
                ->update(['updated_at' => Carbon::now()->toDateTimeString()]);




            return redirect('/invoice_management')
                ->with('success', 'Invoice Sent Successfully');




        }




    }


    public function changePaymentStatusWaterBills(Request $request,$id)
    {


        $payment_status='';
        $amount_to_be_paid=DB::table('water_bill_invoices')->where('invoice_number', $id)->value('cumulative_amount');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if($request->get('amount_paid')<$amount_to_be_paid){
            $payment_status='Partially Paid';


        }elseif($request->get('amount_paid')==$amount_to_be_paid) {
            $payment_status='Paid';


        }else{


        }


        DB::table('water_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['payment_status' => $payment_status]);

        DB::table('water_bill_invoices')
            ->where('invoice_number', $id)
            ->update(['user_comments' => $request->get('user_comments')]);

//        DB::table('water_bill_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );


        DB::table('water_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['invoice_number_votebook' => $request->get('invoice_number_votebook')]);

        DB::table('water_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_paid' => $request->get('amount_paid')]);

        DB::table('water_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['amount_not_paid' => $amount_not_paid]);

        DB::table('water_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['currency_payments' => $request->get('currency_payments')]);

        DB::table('water_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['receipt_number' => $request->get('receipt_number')]);

        DB::table('water_bill_payments')
            ->where('invoice_number', $request->get('invoice_number'))
            ->update(['date_of_payment' => $request->get('date_of_payment')]);





        return redirect('/invoice_management')
            ->with('success', 'Payment received successfully');

    }




}
