<?php

namespace App\Http\Controllers;

use App\car_rental_invoice;
use App\car_rental_payment;
use App\electricity_bill_invoice;
use App\electricity_bill_payment;
use App\insurance_clients_payment;
use App\insurance_invoice;
use App\insurance_invoices_client;
use App\insurance_payment;
use App\invoice;
use App\Jobs\SendEmailsSpaceJob;
use App\Jobs\SendEmailsInsuranceJob;
use App\Jobs\SendEmailsWaterJob;
use App\Jobs\SendEmailsElectricityJob;
use App\Jobs\SendEmailsCarJob;
use App\Notifications\SendInvoiceCar;
use App\research_flats_invoice;
use App\research_flats_payment;
use App\space_payment;
use App\water_bill_invoice;
use App\water_bill_payment;
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



            $invoice= new invoice();
            $invoice->invoice_number_votebook=$request->get('invoice_number');
            $invoice->contract_id=$request->get('contract_id','N/A');
            $invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
            $invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
            $invoice->period=$request->get('period','N/A');
            $invoice->project_id=$request->get('project_id','N/A');
            $invoice->debtor_account_code=$request->get('debtor_account_code','N/A');
            $invoice->debtor_name=$request->get('debtor_name');
            $invoice->debtor_address=$request->get('debtor_address');
            $invoice->amount_to_be_paid=$request->get('amount_to_be_paid');
            $invoice->currency_invoice=$request->get('currency');
            $invoice->gepg_control_no='';
            $invoice->tin=$request->get('tin','N/A');
            $invoice->vrn=$request->get('vrn','N/A');
            $invoice->max_no_of_days_to_pay=$max_no_of_days_to_pay;
            $invoice->status=$request->get('status','N/A');
            $invoice->amount_in_words=$amount_in_words;
            $invoice->inc_code=$request->get('inc_code');
            $invoice->invoice_category='Space';
            $invoice->invoice_date=$today;
            $invoice->financial_year=$financial_year;
            $invoice->payment_status='Not paid';
            $invoice->description=$request->get('description','N/A');
            $invoice->prepared_by=Auth::user()->name;
            $invoice->approved_by='N/A';
            $invoice->stage=1;
            $invoice->save();


            $invoice_number_created=DB::table('invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'space']
            );


            $space_payment= new space_payment();
            $space_payment->invoice_number=$invoice_number_created;
            $space_payment->invoice_number_votebook=$request->get('invoice_number');
            $space_payment->amount_paid=0;
            $space_payment->amount_not_paid=$request->get('amount_to_be_paid');
            $space_payment->currency_payments=$request->get('currency');
            $space_payment->receipt_number='';
            $space_payment->save();


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


        $invoice= invoice::where('invoice_number', $id)->first();
        $invoice->invoice_status=0;
        $invoice->save();

        $space_payment=space_payment::where('invoice_number', $id)->first();
        $space_payment->status_payment=0;
        $space_payment->save();

        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }


    public function CancelWaterInvoice($id){


        $water_bill_invoice= water_bill_invoice::where('invoice_number', $id)->first();
        $water_bill_invoice->invoice_status=0;
        $water_bill_invoice->save();

        $water_bill_payment=water_bill_payment::where('invoice_number', $id)->first();
        $water_bill_payment->status_payment=0;
       $water_bill_payment->save();

        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }




    public function CancelElectricityInvoice($id){


        $electricity_bill_invoice= electricity_bill_invoice::where('invoice_number', $id)->first();
        $electricity_bill_invoice->invoice_status=0;
        $electricity_bill_invoice->save();

        $electricity_bill_payment=electricity_bill_payment::where('invoice_number', $id)->first();
        $electricity_bill_payment->status_payment=0;
        $electricity_bill_payment->save();



        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }


    public function CancelResearchInvoice($id){


        $research_invoice= research_flats_invoice::where('invoice_number', $id)->first();
        $research_invoice->invoice_status=0;
        $research_invoice->save();

        $research_payment=research_flats_payment::where('invoice_number', $id)->first();
        $research_payment->status_payment=0;
        $research_payment->save();


        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }


    public function CancelInsuranceClientsInvoice($id){


        $insurance_invoices_client= insurance_invoices_client::where('invoice_number', $id)->first();
        $insurance_invoices_client->invoice_status=0;
        $insurance_invoices_client->save();

        $insurance_clients_payment=insurance_clients_payment::where('invoice_number', $id)->first();
        $insurance_clients_payment->status_payment=0;
        $insurance_clients_payment->save();



        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');


    }

    public function CancelInsurancePrincipalsInvoice($id){


        $insurance_invoice= insurance_invoice::where('invoice_number', $id)->first();
        $insurance_invoice->invoice_status=0;
        $insurance_invoice->save();


        $insurance_payment=insurance_payment::where('invoice_number', $id)->first();
        $insurance_payment->status_payment=0;
        $insurance_payment->save();


        return redirect('/invoice_management')
            ->with('success', 'Invoice cancelled successfully');

    }


    public function CancelCarInvoice($id){


        $car_rental_invoice= car_rental_invoice::where('invoice_number', $id)->first();
        $car_rental_invoice->invoice_status=0;
        $car_rental_invoice->save();


        $car_rental_payment=car_rental_payment::where('invoice_number', $id)->first();
        $car_rental_payment->status_payment=0;
        $car_rental_payment->save();


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


    public function invoiceManagementCarRental(){




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


        return view('invoices_management_car_rental')->with('car_invoices',$car_invoices)->with('car_invoice_inbox',$car_invoice_inbox)->with('car_invoice_outbox',$car_invoice_outbox);


    }


    public function invoiceManagementResearch(){

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

        return view('invoices_management_research')->with('research_invoices',$research_invoices)->with('research_invoice_inbox',$research_invoice_inbox)->with('research_invoice_outbox',$research_invoice_outbox);


    }

    public function invoiceManagementInsurance(){

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




        return view('invoices_management_insurance')->with('insurance_invoices',$insurance_invoices)->with('insurance_clients_invoices',$insurance_clients_invoices)->with('insurance_invoice_inbox',$insurance_invoice_inbox)->with('insurance_invoice_outbox',$insurance_invoice_outbox)->with('insurance_clients_invoice_inbox',$insurance_clients_invoice_inbox)->with('insurance_clients_invoice_outbox',$insurance_clients_invoice_outbox);


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


        $invoice=invoice::where('invoice_number', $id)->first();
        $invoice->payment_status=$payment_status;
        $invoice->user_comments=$request->get('user_comments');
        $invoice->save();



//        DB::table('space_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );

        $space_payment=space_payment::where('invoice_number', $request->get('invoice_number'))->first();
        $space_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $space_payment->amount_paid=$request->get('amount_paid');
        $space_payment->amount_not_paid=$amount_not_paid;
        $space_payment->currency_payments=$request->get('currency_payments');
        $space_payment->receipt_number=$request->get('receipt_number');
        $space_payment->date_of_payment=$request->get('date_of_payment');
        $space_payment->save();



        return redirect('/invoice_management')
            ->with('success', 'Payment received successfully');

    }



    public function sendInvoiceSpace(Request $request,$id)
    {



        if($request->get('approval_status')=='Rejected'){

            $invoice=invoice::where('invoice_number', $id)->first();
            $invoice->stage=0;
            $invoice->rejected=1;
            $invoice->reason=$request->get('reason');
            $invoice->updated_at=Carbon::now()->toDateTimeString();
            $invoice->save();



            return redirect('/invoice_management')
                ->with('success', 'Operation completed successfully');

        }else{

            $invoice=invoice::where('invoice_number', $id)->first();
            $invoice->rejected=0;
            $invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
            $invoice->save();


            $space_payment=space_payment::where('invoice_number', $id)->first();
            $space_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
            $space_payment->save();


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


                $invoice=invoice::where('invoice_number', $id)->first();
                $invoice->invoice_date=$today;
                $invoice->email_sent_status='SENT';
                $invoice->gepg_control_no=$request->get('gepg_control_no');
                $invoice->save();


//            DB::table('space_payments')->insert(
//                ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//            );

            }



            DB::table('invoice_notifications')->where('invoice_category',  'space')->where('invoice_id',$id)->delete();



            $invoice=invoice::where('invoice_number', $id)->first();
            $invoice->stage=3;
            $invoice->updated_at=Carbon::now()->toDateTimeString();
            $invoice->save();



            return redirect('/invoice_management')
                ->with('success', 'Invoice Sent Successfully');


        }




    }




    public function sendInvoiceCarRental(Request $request,$id)
    {

        $car_rental_payment=car_rental_payment::where('invoice_number', $id)->first();
        $car_rental_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $car_rental_payment->save();

        $car_rental_invoice=car_rental_invoice::where('invoice_number', $id)->first();
        $car_rental_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $car_rental_invoice->inc_code=$request->get('inc_code');
        $car_rental_invoice->save();






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

            $car_rental_invoice=car_rental_invoice::where('invoice_number', $id)->first();
            $car_rental_invoice->email_sent_status='SENT';
            $car_rental_invoice->invoice_date=$today;
            $car_rental_invoice->gepg_control_no=$request->get('gepg_control_no');
            $car_rental_invoice->save();



//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//        );





        }


        $car_rental_invoice=car_rental_invoice::where('invoice_number', $id)->first();
        $car_rental_invoice->stage=2;
        $car_rental_invoice->save();




        DB::table('invoice_notifications')->where('invoice_category',  'car_rental')->where('invoice_id',$id)->delete();

        return redirect('/invoice_management')
            ->with('success', 'Email Sent Successfully');

    }




    public function sendInvoiceResearch(Request $request,$id)
    {

        $research_flats_payment=research_flats_payment::where('invoice_number', $id)->first();
        $research_flats_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $research_flats_payment->save();


        $research_flats_invoice=research_flats_invoice::where('invoice_number', $id)->first();
        $research_flats_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $research_flats_invoice->inc_code=$request->get('inc_code');
        $research_flats_invoice->save();



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


            $research_flats_invoice=research_flats_invoice::where('invoice_number', $id)->first();
            $research_flats_invoice->email_sent_status='SENT';
            $research_flats_invoice->invoice_date=$today;
            $research_flats_invoice->gepg_control_no=$request->get('gepg_control_no');
            $research_flats_invoice->save();

//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//        );





        }

        $research_flats_invoice=research_flats_invoice::where('invoice_number', $id)->first();
        $research_flats_invoice->stage=2;
        $research_flats_invoice->save();


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

                    $invoice= invoice::where('invoice_number', $invoice->invoice_number)->first();
                    $invoice->invoice_date=$today;
                    $invoice->email_sent_status='SENT';
                    $invoice->stage=2;
                    $invoice->save();


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


                    $water_bill_invoice= water_bill_invoice::where('invoice_number', $invoice->invoice_number)->first();
                    $water_bill_invoice->invoice_date=$today;
                    $water_bill_invoice->email_sent_status='SENT';
                    $water_bill_invoice->stage=2;
                    $water_bill_invoice->save();




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


                    $electricity_bill_invoice= electricity_bill_invoice::where('invoice_number', $invoice->invoice_number)->first();
                    $electricity_bill_invoice->invoice_date=$today;
                    $electricity_bill_invoice->email_sent_status='SENT';
                    $electricity_bill_invoice->stage=2;
                    $electricity_bill_invoice->save();




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


                    $insurance_invoices_client= insurance_invoices_client::where('invoice_number', $invoice->invoice_number)->first();
                    $insurance_invoices_client->invoice_date=$today;
                    $insurance_invoices_client->email_sent_status='SENT';
                    $insurance_invoices_client->stage=2;
                    $insurance_invoices_client->save();



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




                    $insurance_invoices_client= insurance_invoice::where('invoice_number', $invoice->invoice_number)->first();
                    $insurance_invoices_client->invoice_date=$today;
                    $insurance_invoices_client->email_sent_status='SENT';
                    $insurance_invoices_client->stage=2;
                    $insurance_invoices_client->save();



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


                        $car_rental_invoice= car_rental_invoice::where('invoice_number', $invoice->invoice_number)->first();
                        $car_rental_invoice->invoice_date=$today;
                        $car_rental_invoice->email_sent_status='SENT';
                        $car_rental_invoice->stage=2;
                        $car_rental_invoice->save();



                        DB::table('invoice_notifications')->where('invoice_category', 'car_rental')->where('invoice_id', $invoice->invoice_number)->delete();


                    }elseif ($invoice->account_no!='') {
                        Notification::route('mail', $email_address)
                            ->notify(new SendInvoiceCar($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->amount_to_be_paid, $invoice->currency_invoice, $invoice->account_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));


                        $car_rental_invoice= car_rental_invoice::where('invoice_number', $invoice->invoice_number)->first();
                        $car_rental_invoice->invoice_date=$today;
                        $car_rental_invoice->email_sent_status='SENT';
                        $car_rental_invoice->stage=2;
                        $car_rental_invoice->save();


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


                        $research_flats_invoice= research_flats_invoice::where('invoice_number', $invoice->invoice_number)->first();
                        $research_flats_invoice->invoice_date=$today;
                        $research_flats_invoice->email_sent_status='SENT';
                        $research_flats_invoice->stage=2;
                        $research_flats_invoice->save();



                        DB::table('invoice_notifications')->where('invoice_category', 'research')->where('invoice_id', $invoice->invoice_number)->delete();


                    }elseif ($invoice->account_no!='') {
                        Notification::route('mail', $email_address)
                            ->notify(new SendInvoiceCar($invoice->debtor_name, $invoice->invoice_number_votebook, $invoice->project_id, $invoice->debtor_account_code, $invoice->debtor_name, $invoice->debtor_address, $invoice->amount_to_be_paid, $invoice->currency_invoice, $invoice->account_no, $invoice->tin, $max_no_of_days_to_pay, $invoice->status, $invoice->vrn, $amount_in_words, $invoice->inc_code, $today, $financial_year, $invoice->period, $invoice->description, $invoice->prepared_by, Auth::user()->name, date("d/m/Y", strtotime($invoice->invoicing_period_start_date)), date("d/m/Y", strtotime($invoice->invoicing_period_end_date))));



                        $research_flats_invoice= research_flats_invoice::where('invoice_number', $invoice->invoice_number)->first();
                        $research_flats_invoice->invoice_date=$today;
                        $research_flats_invoice->email_sent_status='SENT';
                        $research_flats_invoice->stage=2;
                        $research_flats_invoice->save();


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


        $invoice=invoice::where('invoice_number', $id)->first();
        $invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $invoice->gepg_control_no=$request->get('gepg_control_no');
        $invoice->inc_code=$request->get('inc_code');
        $invoice->rejected=0;
        $invoice->stage=2;
        $invoice->updated_at=Carbon::now()->toDateTimeString();
        $invoice->save();


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }



    public function addControlNumberInsurance(Request $request,$id){

        $insurance_invoices_client=insurance_invoices_client::where('invoice_number', $id)->first();
        $insurance_invoices_client->invoice_number_votebook=$request->get('invoice_number_votebook');
        $insurance_invoices_client->inc_code=$request->get('inc_code');
        $insurance_invoices_client->gepg_control_no=$request->get('gepg_control_no');
        $insurance_invoices_client->save();


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }


    public function addControlNumberInsurancePrincipals(Request $request,$id){


        $insurance_invoice=insurance_invoice::where('invoice_number', $id)->first();
        $insurance_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $insurance_invoice->inc_code=$request->get('inc_code');
        $insurance_invoice->gepg_control_no=$request->get('gepg_control_no');
        $insurance_invoice->save();



        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }




    public function addControlNumberCar(Request $request,$id){


        $car_rental_invoice=car_rental_invoice::where('invoice_number', $id)->first();
        $car_rental_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $car_rental_invoice->inc_code=$request->get('inc_code');
        $car_rental_invoice->gepg_control_no=$request->get('gepg_control_no');
        $car_rental_invoice->save();


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }



    public function addControlNumberResearch(Request $request,$id){


        $research_flats_invoice=research_flats_invoice::where('invoice_number', $id)->first();
        $research_flats_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $research_flats_invoice->inc_code=$request->get('inc_code');
        $research_flats_invoice->gepg_control_no=$request->get('gepg_control_no');
        $research_flats_invoice->save();


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');
    }



    public function addControlNumberWater(Request $request,$id){


        $water_bill_invoice=water_bill_invoice::where('invoice_number', $id)->first();
        $water_bill_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $water_bill_invoice->inc_code=$request->get('inc_code');
        $water_bill_invoice->rejected=0;
        $water_bill_invoice->stage=2;
        $water_bill_invoice->updated_at=Carbon::now()->toDateTimeString();
        $water_bill_invoice->save();


        $invoice_data=DB::table('water_bill_invoices')->where('invoice_number', $id)->get();

        foreach($invoice_data as $var){


            $water_bill_invoice=water_bill_invoice::where('invoice_number', $id)->first();
            $water_bill_invoice->gepg_control_no=$request->get('gepg_control_no');
            $water_bill_invoice->save();


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


        $electricity_bill_invoice=electricity_bill_invoice::where('invoice_number', $id)->first();
        $electricity_bill_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $electricity_bill_invoice->inc_code=$request->get('inc_code');
        $electricity_bill_invoice->rejected=0;
        $electricity_bill_invoice->stage=2;
        $electricity_bill_invoice->updated_at=Carbon::now()->toDateTimeString();
        $electricity_bill_invoice->save();



        $invoice_data=DB::table('electricity_bill_invoices')->where('invoice_number', $id)->get();

        foreach($invoice_data as $var){






            $electricity_bill_invoice=electricity_bill_invoice::where('invoice_number', $id)->first();
            $electricity_bill_invoice->gepg_control_no=$request->get('gepg_control_no');
            $electricity_bill_invoice->save();

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


            $car_rental_invoice= new car_rental_invoice();
            $car_rental_invoice->invoice_number_votebook=$request->get('invoice_number');
            $car_rental_invoice->contract_id=$request->get('contract_id','N/A');
            $car_rental_invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
            $car_rental_invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
            $car_rental_invoice->period=$period;
            $car_rental_invoice->project_id=$request->get('project_id','N/A');
            $car_rental_invoice->debtor_account_code=$request->get('debtor_account_code','N/A');
            $car_rental_invoice->debtor_name=$request->get('debtor_name');
            $car_rental_invoice->debtor_address=$request->get('debtor_address');
            $car_rental_invoice->amount_to_be_paid=$request->get('amount_to_be_paid');
            $car_rental_invoice->currency_invoice=$request->get('currency');
            $car_rental_invoice->gepg_control_no='';
            $car_rental_invoice->tin=$request->get('tin','N/A');
            $car_rental_invoice->vrn=$request->get('vrn','N/A');
            $car_rental_invoice->max_no_of_days_to_pay=$max_no_of_days_to_pay;
            $car_rental_invoice->status=$request->get('status','N/A');
            $car_rental_invoice->amount_in_words=$amount_in_words;
            $car_rental_invoice->inc_code=$request->get('inc_code');
            $car_rental_invoice->invoice_date=$today;
            $car_rental_invoice->financial_year=$financial_year;
            $car_rental_invoice->payment_status='Not paid';
            $car_rental_invoice->description=$request->get('description','N/A');
            $car_rental_invoice->prepared_by=Auth::user()->name;
            $car_rental_invoice->approved_by='N/A';
            $car_rental_invoice->stage=1;
            $car_rental_invoice->save();




            $invoice_number_created=DB::table('car_rental_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'car_rental']
            );


            $car_rental_payment=new car_rental_payment();
            $car_rental_payment->invoice_number=$invoice_number_created;
            $car_rental_payment->invoice_number_votebook=$request->get('invoice_number');
            $car_rental_payment->amount_paid=0;
            $car_rental_payment->amount_not_paid=$request->get('amount_to_be_paid');
            $car_rental_payment->currency_payments=$request->get('currency');
            $car_rental_payment->receipt_number='';
            $car_rental_payment->save();


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

            $research_flats_invoice= new research_flats_invoice();
            $research_flats_invoice->invoice_number_votebook=$request->get('invoice_number');
            $research_flats_invoice->contract_id=$request->get('contract_id','N/A');
            $research_flats_invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
            $research_flats_invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
            $research_flats_invoice->period=$period;
            $research_flats_invoice->project_id=$request->get('project_id','N/A');
            $research_flats_invoice->debtor_account_code=$request->get('debtor_account_code','N/A');
            $research_flats_invoice->debtor_name=$request->get('debtor_name');
            $research_flats_invoice->debtor_address=$request->get('debtor_address');
            $research_flats_invoice->amount_to_be_paid=$request->get('amount_to_be_paid');
            $research_flats_invoice->currency_invoice=$request->get('currency');
            $research_flats_invoice->gepg_control_no='';
            $research_flats_invoice->tin=$request->get('tin','N/A');
            $research_flats_invoice->vrn=$request->get('vrn','N/A');
            $research_flats_invoice->max_no_of_days_to_pay=$max_no_of_days_to_pay;
            $research_flats_invoice->status=$request->get('status','N/A');
            $research_flats_invoice->amount_in_words=$amount_in_words;
            $research_flats_invoice->inc_code=$request->get('inc_code');
            $research_flats_invoice->invoice_date=$today;
            $research_flats_invoice->financial_year=$financial_year;
            $research_flats_invoice->payment_status='Not paid';
            $research_flats_invoice->description=$request->get('description','N/A');
            $research_flats_invoice->prepared_by=Auth::user()->name;
            $research_flats_invoice->approved_by='N/A';
            $research_flats_invoice->stage=1;
            $research_flats_invoice->save();



            $invoice_number_created=DB::table('research_flats_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'research']
            );


            $research_flats_payment= new research_flats_payment();
            $research_flats_payment->invoice_number=$invoice_number_created;
            $research_flats_payment->invoice_number_votebook=$request->get('invoice_number');
            $research_flats_payment->amount_paid=0;
            $research_flats_payment->amount_not_paid=$request->get('amount_to_be_paid');
            $research_flats_payment->currency_payments=$request->get('currency');
            $research_flats_payment->receipt_number='';
            $research_flats_payment->save();




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

        $car_rental_invoice= car_rental_invoice::where('invoice_number',$id)->first();
        $car_rental_invoice->payment_status=$payment_status;
        $car_rental_invoice->user_comments=$request->get('user_comments');
        $car_rental_invoice->save();




//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );

        $car_rental_payment=car_rental_payment::where('invoice_number', $request->get('invoice_number'))->first();
        $car_rental_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $car_rental_payment->amount_paid=$request->get('amount_paid');
        $car_rental_payment->amount_not_paid=$amount_not_paid;
        $car_rental_payment->currency_payments=$request->get('currency_payments');
        $car_rental_payment->receipt_number=$request->get('receipt_number');
        $car_rental_payment->date_of_payment=$request->get('date_of_payment');
        $car_rental_payment->save();




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

        $research_flats_invoice=research_flats_invoice::where('invoice_number', $id)->first();
        $research_flats_invoice->payment_status=$payment_status;
        $research_flats_invoice->user_comments=$request->get('user_comments');
        $research_flats_invoice->save();




//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );


        $research_flats_payment=research_flats_payment::where('invoice_number', $request->get('invoice_number'))->first();
        $research_flats_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $research_flats_payment->amount_paid=$request->get('amount_paid');
        $research_flats_payment->amount_not_paid=$amount_not_paid;
        $research_flats_payment->currency_payments=$request->get('currency_payments');
        $research_flats_payment->receipt_number=$request->get('receipt_number');
        $research_flats_payment->date_of_payment=$request->get('date_of_payment');
        $research_flats_payment->save();


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


            $insurance_invoice= new insurance_invoice();
            $insurance_invoice->invoice_number_votebook=$request->get('invoice_number');
            $insurance_invoice->contract_id='';
            $insurance_invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
            $insurance_invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
            $insurance_invoice->period=$period;
            $insurance_invoice->project_id=$request->get('project_id','N/A');
            $insurance_invoice->debtor_account_code=$request->get('debtor_account_code','N/A');
            $insurance_invoice->debtor_name=$request->get('debtor_name');
            $insurance_invoice->debtor_address=$request->get('debtor_address');
            $insurance_invoice->amount_to_be_paid=$request->get('amount_to_be_paid');
            $insurance_invoice->currency_invoice=$request->get('currency');
            $insurance_invoice->gepg_control_no='';
            $insurance_invoice->tin=$request->get('tin','N/A');
            $insurance_invoice->vrn=$request->get('vrn','N/A');
            $insurance_invoice->max_no_of_days_to_pay=$max_no_of_days_to_pay;
            $insurance_invoice->status=$request->get('status','N/A');
            $insurance_invoice->amount_in_words=$amount_in_words;
            $insurance_invoice->inc_code=$request->get('inc_code');
            $insurance_invoice->invoice_category='Insurance';
            $insurance_invoice->invoice_date=$today;
            $insurance_invoice->financial_year=$financial_year;
            $insurance_invoice->payment_status='Not paid';
            $insurance_invoice->description=$request->get('description','N/A');
            $insurance_invoice->prepared_by=Auth::user()->name;
            $insurance_invoice->approved_by='N/A';
            $insurance_invoice->stage=1;
            $insurance_invoice->save();


            $invoice_number_created=DB::table('insurance_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'insurance']
            );



            $insurance_payment= new insurance_payment();
            $insurance_payment->invoice_number=$invoice_number_created;
            $insurance_payment->invoice_number_votebook=$request->get('invoice_number');
            $insurance_payment->amount_paid=0;
            $insurance_payment->amount_not_paid=$request->get('amount_to_be_paid');
            $insurance_payment->currency_payments=$request->get('currency');
            $insurance_payment->receipt_number='';
            $insurance_payment->save();




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


            $insurance_invoices_client= new insurance_invoices_client();
            $insurance_invoices_client->invoice_number_votebook=$request->get('invoice_number');
            $insurance_invoices_client->contract_id=$request->get("contract_id");
            $insurance_invoices_client->invoicing_period_start_date=$request->get('invoicing_period_start_date');
            $insurance_invoices_client->invoicing_period_end_date=$request->get('invoicing_period_end_date');
            $insurance_invoices_client->period=$period;
            $insurance_invoices_client->project_id=$request->get('project_id','N/A');
            $insurance_invoices_client->debtor_account_code=$request->get('debtor_account_code','N/A');
            $insurance_invoices_client->debtor_name=$request->get('debtor_name');
            $insurance_invoices_client->debtor_address=$request->get('debtor_address');
            $insurance_invoices_client->amount_to_be_paid=$request->get('amount_to_be_paid');
            $insurance_invoices_client->currency_invoice=$request->get('currency');
            $insurance_invoices_client->gepg_control_no='';
            $insurance_invoices_client->tin=$request->get('tin','N/A');
            $insurance_invoices_client->vrn=$request->get('vrn','N/A');
            $insurance_invoices_client->max_no_of_days_to_pay=$max_no_of_days_to_pay;
            $insurance_invoices_client->status=$request->get('status','N/A');
            $insurance_invoices_client->amount_in_words=$amount_in_words;
            $insurance_invoices_client->inc_code=$request->get('inc_code');
            $insurance_invoices_client->invoice_category='Insurance';
            $insurance_invoices_client->invoice_date=$today;
            $insurance_invoices_client->financial_year=$financial_year;
            $insurance_invoices_client->payment_status='Not paid';
            $insurance_invoices_client->description=$request->get('description','N/A');
            $insurance_invoices_client->prepared_by=Auth::user()->name;
            $insurance_invoices_client->approved_by='N/A';
            $insurance_invoices_client->stage=1;
            $insurance_invoices_client->save();


            $invoice_number_created=DB::table('insurance_invoices_clients')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'insurance_clients']
            );

            $insurance_clients_payment= new insurance_clients_payment();
            $insurance_clients_payment->invoice_number=$invoice_number_created;
            $insurance_clients_payment->invoice_number_votebook='';
            $insurance_clients_payment->amount_paid=0;
            $insurance_clients_payment->amount_not_paid=$request->get('amount_to_be_paid');
            $insurance_clients_payment->currency_payments=$request->get('currency');
            $insurance_clients_payment->receipt_number='';
            $insurance_clients_payment->save();


        }else{
            return redirect()->back()->with("error","Invoice already exists. Please try again");

        }


        return redirect('/invoice_management')
            ->with('success', 'Insurance invoice created Successfully');




    }








    public function sendInvoiceInsurance(Request $request,$id)
    {

        $insurance_clients_payment= insurance_clients_payment::where('invoice_number', $id)->first();
        $insurance_clients_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $insurance_clients_payment->save();


        $insurance_invoices_client=insurance_invoices_client::where('invoice_number', $id)->first();
        $insurance_invoices_client->invoice_number_votebook=$request->get('invoice_number_votebook');
        $insurance_invoices_client->inc_code=$request->get('inc_code');
        $insurance_invoices_client->save();


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


            $insurance_invoices_client=insurance_invoices_client::where('invoice_number', $id)->first();
            $insurance_invoices_client->invoice_date=$today;
            $insurance_invoices_client->email_sent_status='SENT';
            $insurance_invoices_client->gepg_control_no=$request->get('gepg_control_no');
            $insurance_invoices_client->save();

//            DB::table('insurance_payments')->insert(
//                ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//            );


        }



        $insurance_invoices_client=insurance_invoices_client::where('invoice_number', $id)->first();
        $insurance_invoices_client->stage=2;
        $insurance_invoices_client->save();



        DB::table('invoice_notifications')->where('invoice_category',  'insurance')->where('invoice_id',$id)->delete();


        return redirect('/invoice_management')
            ->with('success', 'Invoice Sent Successfully');

    }




    public function sendInvoiceInsurancePrincipals(Request $request,$id)
    {

        $insurance_payment=insurance_payment::where('invoice_number', $id)->first();
        $insurance_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $insurance_payment->save();


        $insurance_invoice=insurance_invoice::where('invoice_number', $id)->first();
        $insurance_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $insurance_invoice->inc_code=$request->get('inc_code');
        $insurance_invoice->save();



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


            $insurance_invoice=insurance_invoice::where('invoice_number', $id)->first();
            $insurance_invoice->invoice_date=$today;
            $insurance_invoice->email_sent_status='SENT';
            $insurance_invoice->gepg_control_no=$request->get('gepg_control_no');
            $insurance_invoice->save();

//            DB::table('insurance_payments')->insert(
//                ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//            );


        }


        $insurance_invoice=insurance_invoice::where('invoice_number', $id)->first();
        $insurance_invoice->stage=2;
        $insurance_invoice->save();


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

        $insurance_invoices_client= insurance_invoices_client::where('invoice_number', $id)->first();
        $insurance_invoices_client->payment_status=$payment_status;
        $insurance_invoices_client->user_comments=$request->get('user_comments');
        $insurance_invoices_client->save();



//        DB::table('insurance_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );


        $insurance_clients_payment= insurance_clients_payment::where('invoice_number', $request->get('invoice_number'))->first();
        $insurance_clients_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $insurance_clients_payment->amount_paid=$request->get('amount_paid');
        $insurance_clients_payment->amount_not_paid=$amount_not_paid;
        $insurance_clients_payment->currency_payments=$request->get('currency_payments');
        $insurance_clients_payment->receipt_number=$request->get('receipt_number');
        $insurance_clients_payment->date_of_payment=$request->get('date_of_payment');
        $insurance_clients_payment->save();


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


        $insurance_invoice= insurance_invoice::where('invoice_number', $id)->first();
        $insurance_invoice->payment_status=$payment_status;
        $insurance_invoice->user_comments=$request->get('user_comments');
        $insurance_invoice->save();



//        DB::table('insurance_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );


        $insurance_payment=insurance_payment::where('invoice_number', $request->get('invoice_number'))->first();
        $insurance_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $insurance_payment->amount_paid=$request->get('amount_paid');
        $insurance_payment->amount_not_paid=$amount_not_paid;
        $insurance_payment->currency_payments=$request->get('currency_payments');
        $insurance_payment->receipt_number=$request->get('receipt_number');
        $insurance_payment->date_of_payment=$request->get('date_of_payment');
        $insurance_payment->save();


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

        $invoice=invoice::where('invoice_number', $invoice_id)->first();
        $invoice->debtor_name=$request->get('debtor_name');
        $invoice->debtor_account_code=$request->get('debtor_account_code');
        $invoice->tin=$request->get('tin');
        $invoice->debtor_address=$request->get('debtor_address');
        $invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
        $invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
        $invoice->period=$request->get('period');
        $invoice->project_id=$request->get('project_id');
        $invoice->amount_to_be_paid=$request->get('amount_to_be_paid');
        $invoice->currency_invoice=$request->get('currency');
        $invoice->status=$request->get('status');
        $invoice->description=$request->get('description');
        $invoice->prepared_by=Auth::user()->name;
        $invoice->stage=1;
        $invoice->updated_at=Carbon::now()->toDateTimeString();
        $invoice->save();

//        DB::table('invoices')
//            ->where('invoice_number', $invoice_id)
//            ->update(['inc_code' => $request->get('inc_code')]);

        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }




    public function fowardCarInvoice(Request $request,$invoice_id)
    {

        $car_rental_invoice= car_rental_invoice::where('invoice_number', $invoice_id)->first();
        $car_rental_invoice->debtor_name=$request->get('debtor_name');
        $car_rental_invoice->debtor_account_code=$request->get('debtor_account_code');
        $car_rental_invoice->tin=$request->get('tin');
        $car_rental_invoice->debtor_address=$request->get('debtor_address');
        $car_rental_invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
        $car_rental_invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
        $car_rental_invoice->period=$request->get('period');
        $car_rental_invoice->inc_code=$request->get('inc_code');
        $car_rental_invoice->vrn=$request->get('vrn');
        $car_rental_invoice->project_id=$request->get('project_id');
        $car_rental_invoice->amount_to_be_paid=$request->get('amount_to_be_paid');
        $car_rental_invoice->currency_invoice=$request->get('currency');
        $car_rental_invoice->status=$request->get('status');
        $car_rental_invoice->description=$request->get('description');
        $car_rental_invoice->prepared_by=Auth::user()->name;
        $car_rental_invoice->stage=1;
        $car_rental_invoice->save();



        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }




    public function fowardResearchInvoice(Request $request,$invoice_id)
    {


        $research_flats_invoice=research_flats_invoice::where('invoice_number', $invoice_id)->first();
        $research_flats_invoice->debtor_name=$request->get('debtor_name');
        $research_flats_invoice->debtor_account_code=$request->get('debtor_account_code');
        $research_flats_invoice->tin=$request->get('tin');
        $research_flats_invoice->debtor_address=$request->get('debtor_address');
        $research_flats_invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
        $research_flats_invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
        $research_flats_invoice->period=$request->get('period');
        $research_flats_invoice->inc_code=$request->get('inc_code');
        $research_flats_invoice->project_id=$request->get('project_id');
        $research_flats_invoice->amount_to_be_paid=$request->get('amount_to_be_paid');
        $research_flats_invoice->currency_invoice=$request->get('currency');
        $research_flats_invoice->status=$request->get('status');
        $research_flats_invoice->description=$request->get('description');
        $research_flats_invoice->prepared_by=Auth::user()->name;
        $research_flats_invoice->stage=1;
        $research_flats_invoice->save();


        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }




    public function fowardInsuranceInvoice(Request $request,$invoice_id)
    {

        $insurance_invoice=insurance_invoice::where('invoice_number', $invoice_id)->first();
        $insurance_invoice->debtor_name=$request->get('debtor_name');
        $insurance_invoice->debtor_account_code=$request->get('debtor_account_code');
        $insurance_invoice->tin=$request->get('tin');
        $insurance_invoice->debtor_address=$request->get('debtor_address');
        $insurance_invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
        $insurance_invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
        $insurance_invoice->period=$request->get('period');
        $insurance_invoice->inc_code=$request->get('inc_code');
        $insurance_invoice->project_id=$request->get('project_id');
        $insurance_invoice->amount_to_be_paid=$request->get('amount_to_be_paid');
        $insurance_invoice->currency_invoice=$request->get('currency');
        $insurance_invoice->status=$request->get('status');
        $insurance_invoice->description=$request->get('description');
        $insurance_invoice->prepared_by=Auth::user()->name;
        $insurance_invoice->stage=1;
        $insurance_invoice->save();




        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }





    public function fowardInsuranceClientsInvoice(Request $request,$invoice_id)
    {


        $insurance_invoices_client=insurance_invoices_client::where('invoice_number', $invoice_id)->first();
        $insurance_invoices_client->debtor_name=$request->get('debtor_name');
        $insurance_invoices_client->debtor_account_code=$request->get('debtor_account_code');
        $insurance_invoices_client->tin=$request->get('tin');
        $insurance_invoices_client->debtor_address=$request->get('debtor_address');
        $insurance_invoices_client->invoicing_period_start_date=$request->get('invoicing_period_start_date');
        $insurance_invoices_client->invoicing_period_end_date=$request->get('invoicing_period_end_date');
        $insurance_invoices_client->period=$request->get('period');
        $insurance_invoices_client->inc_code=$request->get('inc_code');
        $insurance_invoices_client->project_id=$request->get('project_id');
        $insurance_invoices_client->amount_to_be_paid=$request->get('amount_to_be_paid');
        $insurance_invoices_client->currency_invoice=$request->get('currency');
        $insurance_invoices_client->status=$request->get('status');
        $insurance_invoices_client->description=$request->get('description');
        $insurance_invoices_client->prepared_by=Auth::user()->name;
        $insurance_invoices_client->stage=1;
        $insurance_invoices_client->save();




        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }



    public function fowardWaterInvoice(Request $request,$invoice_id)
    {


        $water_bill_invoice=water_bill_invoice::where('invoice_number', $invoice_id)->first();
        $water_bill_invoice->debtor_name=$request->get('debtor_name');
        $water_bill_invoice->debtor_account_code=$request->get('debtor_account_code');
        $water_bill_invoice->tin=$request->get('tin');
        $water_bill_invoice->debtor_address=$request->get('debtor_address');
        $water_bill_invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
        $water_bill_invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
        $water_bill_invoice->period=$request->get('period');
        $water_bill_invoice->project_id=$request->get('project_id');
        $water_bill_invoice->cumulative_amount=$request->get('amount_to_be_paid');
        $water_bill_invoice->begin_units=$request->get('begin_units');
        $water_bill_invoice->end_units=$request->get('end_units');
        $water_bill_invoice->consumed_units=$request->get('units_usage');
        $water_bill_invoice->debt=$request->get('debt');
        $water_bill_invoice->current_amount=$request->get('current_amount');
        $water_bill_invoice->currency_invoice=$request->get('currency');
        $water_bill_invoice->status=$request->get('status');
        $water_bill_invoice->description=$request->get('description');
        $water_bill_invoice->prepared_by=Auth::user()->name;
        $water_bill_invoice->stage=1;
        $water_bill_invoice->updated_at=Carbon::now()->toDateTimeString();
        $water_bill_invoice->save();



//        DB::table('water_bill_invoices')
//            ->where('invoice_number', $invoice_id)
//            ->update(['inc_code' => $request->get('inc_code')]);







        return redirect('/invoice_management')
            ->with('success', 'Operation completed successfully');

    }


    public function fowardElectricityInvoice(Request $request,$invoice_id)
    {

        $electricity_bill_invoice=electricity_bill_invoice::where('invoice_number', $invoice_id)->first();
        $electricity_bill_invoice->debtor_name=$request->get('debtor_name');
        $electricity_bill_invoice->debtor_account_code=$request->get('debtor_account_code');
        $electricity_bill_invoice->tin=$request->get('tin');
        $electricity_bill_invoice->debtor_address=$request->get('debtor_address');
        $electricity_bill_invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
        $electricity_bill_invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
        $electricity_bill_invoice->period=$request->get('period');
        $electricity_bill_invoice->project_id=$request->get('project_id');
        $electricity_bill_invoice->cumulative_amount=$request->get('amount_to_be_paid');
        $electricity_bill_invoice->begin_units=$request->get('begin_units');
        $electricity_bill_invoice->end_units=$request->get('end_units');
        $electricity_bill_invoice->consumed_units=$request->get('units_usage');
        $electricity_bill_invoice->debt=$request->get('debt');
        $electricity_bill_invoice->current_amount=$request->get('current_amount');
        $electricity_bill_invoice->currency_invoice=$request->get('currency');
        $electricity_bill_invoice->status=$request->get('status');
        $electricity_bill_invoice->description=$request->get('description');
        $electricity_bill_invoice->prepared_by=Auth::user()->name;
        $electricity_bill_invoice->stage=1;
        $electricity_bill_invoice->updated_at=Carbon::now()->toDateTimeString();
        $electricity_bill_invoice->save();

//        DB::table('electricity_bill_invoices')
//            ->where('invoice_number', $invoice_id)
//            ->update(['inc_code' => $request->get('inc_code')]);





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


            $electricity_bill_invoice= new electricity_bill_invoice();
            $electricity_bill_invoice->invoice_number_votebook=$request->get('invoice_number');
            $electricity_bill_invoice->contract_id=$request->get('contract_id','N/A');
            $electricity_bill_invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
            $electricity_bill_invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
            $electricity_bill_invoice->period=$period;
            $electricity_bill_invoice->project_id=$request->get('project_id','N/A');
            $electricity_bill_invoice->debtor_account_code=$request->get('debtor_account_code','N/A');
            $electricity_bill_invoice->debtor_name=$request->get('debtor_name');
            $electricity_bill_invoice->debtor_address=$request->get('debtor_address');
            $electricity_bill_invoice->current_amount=$request->get('current_amount');
            $electricity_bill_invoice->cumulative_amount=$request->get('cumulative_amount');
            $electricity_bill_invoice->debt=$request->get('debt');
            $electricity_bill_invoice->currency_invoice=$request->get('currency');
            $electricity_bill_invoice->gepg_control_no='';
            $electricity_bill_invoice->tin=$request->get('tin','N/A');
            $electricity_bill_invoice->vrn=$request->get('vrn','N/A');
            $electricity_bill_invoice->max_no_of_days_to_pay=$max_no_of_days_to_pay;
            $electricity_bill_invoice->status=$request->get('status','N/A');
            $electricity_bill_invoice->amount_in_words=$amount_in_words;
            $electricity_bill_invoice->inc_code=$request->get('inc_code');
            $electricity_bill_invoice->invoice_category='Electricity';
            $electricity_bill_invoice->invoice_date=$today;
            $electricity_bill_invoice->financial_year=$financial_year;
            $electricity_bill_invoice->payment_status='Not paid';
            $electricity_bill_invoice->description=$request->get('description','N/A');
            $electricity_bill_invoice->prepared_by=Auth::user()->name;
            $electricity_bill_invoice->approved_by='N/A';
            $electricity_bill_invoice->stage=1;
            $electricity_bill_invoice->begin_units=$request->get('begin_units');
            $electricity_bill_invoice->end_units=$request->get('end_units');
            $electricity_bill_invoice->consumed_units=$request->get('units_usage');
            $electricity_bill_invoice->unit_price=$request->get('unit_price');
            $electricity_bill_invoice->save();



            $invoice_number_created=DB::table('electricity_bill_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'electricity bill']
            );



            $electricity_bill_payment= new electricity_bill_payment();
            $electricity_bill_payment->invoice_number=$invoice_number_created;
            $electricity_bill_payment->invoice_number_votebook=$request->get('invoice_number');
            $electricity_bill_payment->amount_paid=0;
            $electricity_bill_payment->amount_not_paid=$request->get('cumulative_amount');
            $electricity_bill_payment->currency_payments=$request->get('currency');
            $electricity_bill_payment->receipt_number='';
            $electricity_bill_payment->save();


        }else{

            return redirect()->back()->with("error","Invoice already exists. Please try again");
        }


        return redirect('/invoice_management')
            ->with('success', 'Electricity bill invoice created Successfully');




    }




    public function sendInvoiceElectricityBills(Request $request,$id)
    {


        if($request->get('approval_status_electricity')=='Rejected'){

            $electricity_bill_invoice=electricity_bill_invoice::where('invoice_number', $id)->first();
            $electricity_bill_invoice->stage=0;
            $electricity_bill_invoice->rejected=1;
            $electricity_bill_invoice->reason=$request->get('reason');
            $electricity_bill_invoice->updated_at=Carbon::now()->toDateTimeString();
            $electricity_bill_invoice->save();





            return redirect('/invoice_management')
                ->with('success', 'Operation completed successfully');

        }else{

            $electricity_bill_invoice=electricity_bill_invoice::where('invoice_number', $id)->first();
            $electricity_bill_invoice->rejected=0;
            $electricity_bill_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
            $electricity_bill_invoice->save();


            $electricity_bill_payment=electricity_bill_payment::where('invoice_number', $id)->first();
            $electricity_bill_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
            $electricity_bill_payment->save();





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


                $electricity_bill_invoice=electricity_bill_invoice::where('invoice_number', $id)->first();
                $electricity_bill_invoice->invoice_date=$today;
                $electricity_bill_invoice->email_sent_status='SENT';
                $electricity_bill_invoice->gepg_control_no=$request->get('gepg_control_no');
                $electricity_bill_invoice->save();



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



            $electricity_bill_invoice=electricity_bill_invoice::where('invoice_number', $id)->first();
            $electricity_bill_invoice->stage=3;
            $electricity_bill_invoice->updated_at=Carbon::now()->toDateTimeString();
            $electricity_bill_invoice->save();





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



        $electricity_bill_invoice=electricity_bill_invoice::where('invoice_number', $id)->first();
        $electricity_bill_invoice->payment_status=$payment_status;
        $electricity_bill_invoice->user_comments=$request->get('user_comments');
        $electricity_bill_invoice->save();





//        DB::table('electricity_bill_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );

        $electricity_bill_payment=electricity_bill_payment::where('invoice_number', $request->get('invoice_number'))->first();
        $electricity_bill_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $electricity_bill_payment->amount_paid=$request->get('amount_paid');
        $electricity_bill_payment->amount_not_paid=$amount_not_paid;
        $electricity_bill_payment->currency_payments=$request->get('currency_payments');
        $electricity_bill_payment->receipt_number=$request->get('receipt_number');
        $electricity_bill_payment->date_of_payment=$request->get('date_of_payment');
        $electricity_bill_payment->save();





        return redirect('/invoice_management')
            ->with('success', 'Payment received Successfully');

    }





    public function sendInvoiceCarRentalAccount(Request $request,$id)
    {


        $car_rental_payment= car_rental_payment::where('invoice_number', $id)->first();
        $car_rental_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $car_rental_payment->save();


        $car_rental_invoice=car_rental_invoice::where('invoice_number', $id)->first();
        $car_rental_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $car_rental_invoice->inc_code=$request->get('inc_code');
        $car_rental_invoice->save();







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


            $car_rental_invoice=car_rental_invoice::where('invoice_number', $id)->first();
            $car_rental_invoice->email_sent_status='SENT';
            $car_rental_invoice->invoice_date=$today;
            $car_rental_invoice->account_no=$request->get('account_no');
            $car_rental_invoice->save();



//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $var->invoice_number, 'invoice_number_votebook' => '','amount_paid' => 0,'amount_not_paid' =>$var->amount_to_be_paid,'currency_payments' => $var->currency_invoice,'receipt_number' => '']
//        );





        }



        $car_rental_invoice=car_rental_invoice::where('invoice_number', $id)->first();
        $car_rental_invoice->stage=2;
        $car_rental_invoice->save();





        DB::table('invoice_notifications')->where('invoice_category',  'car_rental')->where('invoice_id',$id)->delete();

        return redirect('/invoice_management')
            ->with('success', 'Email Sent Successfully');

    }



    public function addAccountNumberCar(Request $request,$id){



        $car_rental_invoice=car_rental_invoice::where('invoice_number', $id)->first();
        $car_rental_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $car_rental_invoice->account_no=$request->get('account_no');
        $car_rental_invoice->save();


        return redirect('/invoice_management')
            ->with('success', 'Account number saved successfully');
    }


    public function addAccountNumberResearch(Request $request,$id){


        $research_flats_invoice= research_flats_invoice::where('invoice_number', $id)->first();
        $research_flats_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
        $research_flats_invoice->account_no=$request->get('account_no');
        $research_flats_invoice->save();


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


            $water_bill_invoice= new water_bill_invoice();
            $water_bill_invoice->invoice_number_votebook=$request->get('invoice_number');
            $water_bill_invoice->contract_id=$request->get('contract_id','N/A');
            $water_bill_invoice->invoicing_period_start_date=$request->get('invoicing_period_start_date');
            $water_bill_invoice->invoicing_period_end_date=$request->get('invoicing_period_end_date');
            $water_bill_invoice->period=$period;
            $water_bill_invoice->project_id=$request->get('project_id','N/A');
            $water_bill_invoice->debtor_account_code=$request->get('debtor_account_code','N/A');
            $water_bill_invoice->debtor_name=$request->get('debtor_name');
            $water_bill_invoice->debtor_address=$request->get('debtor_address');
            $water_bill_invoice->current_amount=$request->get('current_amount');
            $water_bill_invoice->cumulative_amount=$request->get('cumulative_amount');
            $water_bill_invoice->debt=$request->get('debt');
            $water_bill_invoice->currency_invoice=$request->get('currency');
            $water_bill_invoice->gepg_control_no='';
            $water_bill_invoice->tin=$request->get('tin','N/A');
            $water_bill_invoice->vrn=$request->get('vrn','N/A');
            $water_bill_invoice->max_no_of_days_to_pay=$max_no_of_days_to_pay;
            $water_bill_invoice->status=$request->get('status','N/A');
            $water_bill_invoice->amount_in_words=$amount_in_words;
            $water_bill_invoice->inc_code=$request->get('inc_code');
            $water_bill_invoice->invoice_category='Water';
            $water_bill_invoice->invoice_date=$today;
            $water_bill_invoice->financial_year=$financial_year;
            $water_bill_invoice->payment_status='Not paid';
            $water_bill_invoice->description=$request->get('description','N/A');
            $water_bill_invoice->prepared_by=Auth::user()->name;
            $water_bill_invoice->approved_by='N/A';
            $water_bill_invoice->stage=1;
            $water_bill_invoice->begin_units=$request->get('begin_units');
            $water_bill_invoice->end_units=$request->get('end_units');
            $water_bill_invoice->consumed_units=$request->get('units_usage');
            $water_bill_invoice->unit_price=$request->get('unit_price');
            $water_bill_invoice->save();


            $invoice_number_created=DB::table('water_bill_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'water bill']
            );


            $water_bill_payment=new water_bill_payment();
            $water_bill_payment->invoice_number=$invoice_number_created;
            $water_bill_payment->invoice_number_votebook=$request->get('invoice_number');
            $water_bill_payment->amount_paid=0;
            $water_bill_payment->amount_not_paid=$request->get('cumulative_amount');
            $water_bill_payment->currency_payments=$request->get('currency');
            $water_bill_payment->receipt_number='';
            $water_bill_payment->save();





        }else{

            return redirect()->back()->with("error","Invoice already exists. Please try again");
        }


        return redirect('/invoice_management')
            ->with('success', 'Water bill invoice created Successfully');




    }






    public function sendInvoiceWaterBills(Request $request,$id)
    {


        if($request->get('approval_status_water')=='Rejected'){


            $water_bill_invoice= water_bill_invoice::where('invoice_number', $id)->first();
            $water_bill_invoice->stage=0;
            $water_bill_invoice->rejected=1;
            $water_bill_invoice->reason=$request->get('reason');
            $water_bill_invoice->updated_at=Carbon::now()->toDateTimeString();
            $water_bill_invoice->save();



            return redirect('/invoice_management')
                ->with('success', 'Operation completed successfully');

        }else{



            $water_bill_invoice= water_bill_invoice::where('invoice_number', $id)->first();
            $water_bill_invoice->rejected=0;
            $water_bill_invoice->invoice_number_votebook=$request->get('invoice_number_votebook');
            $water_bill_invoice->save();

            $water_bill_payment=water_bill_payment::where('invoice_number', $id)->first();
            $water_bill_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
            $water_bill_payment->save();



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


                $water_bill_invoice= water_bill_invoice::where('invoice_number', $id)->first();
                $water_bill_invoice->invoice_date=$today;
                $water_bill_invoice->email_sent_status='SENT';
                $water_bill_invoice->gepg_control_no=$request->get('gepg_control_no');
                $water_bill_invoice->save();






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



            $water_bill_invoice= water_bill_invoice::where('invoice_number', $id)->first();
            $water_bill_invoice->stage=3;
            $water_bill_invoice->updated_at=Carbon::now()->toDateTimeString();
            $water_bill_invoice->save();






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


        $water_bill_invoice= water_bill_invoice::where('invoice_number', $id)->first();
        $water_bill_invoice->payment_status=$payment_status;
        $water_bill_invoice->user_comments=$request->get('user_comments');
        $water_bill_invoice->save();



//        DB::table('water_bill_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );


        $water_bill_payment=water_bill_payment::where('invoice_number', $request->get('invoice_number'))->first();
        $water_bill_payment->invoice_number_votebook=$request->get('invoice_number_votebook');
        $water_bill_payment->amount_paid=$request->get('amount_paid');
        $water_bill_payment->amount_not_paid=$amount_not_paid;
        $water_bill_payment->currency_payments=$request->get('currency_payments');
        $water_bill_payment->receipt_number=$request->get('receipt_number');
        $water_bill_payment->date_of_payment=$request->get('date_of_payment');
        $water_bill_payment->save();



        return redirect('/invoice_management')
            ->with('success', 'Payment received successfully');

    }




}
