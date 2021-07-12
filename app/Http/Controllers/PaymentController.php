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
use App\research_flats_invoice;
use App\research_flats_payment;
use App\space_payment;
use App\water_bill_invoice;
use App\water_bill_payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use View;

class PaymentController extends Controller
{
    public function paymentManagement()
    {
        $space_inbox=null;
        $space_outbox=null;

        $space_payments=DB::table('space_payments')->join('invoices','space_payments.invoice_number','=','invoices.invoice_number')->where('space_payments.stage',0)->where('invoices.payment_status','Partially Paid')->orWhere('invoices.payment_status','Paid')->get();


        $space_approval_stage=DB::table('space_payments')->join('invoices','space_payments.invoice_number','=','invoices.invoice_number')->where('space_payments.stage',1)->where('invoices.payment_status','Partially Paid')->orWhere('invoices.payment_status','Paid')->get();
        $space_rejected_stage=DB::table('space_payments')->join('invoices','space_payments.invoice_number','=','invoices.invoice_number')->where('space_payments.stage',2)->where('invoices.payment_status','Partially Paid')->orWhere('invoices.payment_status','Paid')->get();




        if(Auth::user()->role=='Director DPDI'){
            if(count($space_approval_stage)==0){


            }else{

                $space_inbox=$space_approval_stage;
            }



            if(count($space_rejected_stage)==0){



            }else{

                $space_outbox=$space_rejected_stage;

            }



        }else if (Auth::user()->role=='DPDI Planner'){

            if(count($space_approval_stage)==0){


            }else{

                $space_outbox=$space_approval_stage;
            }

            if(count($space_rejected_stage)==0){


            }else{

                $space_inbox=$space_rejected_stage;
            }




        }else{



        }


        if(Auth::user()->role=='Vote Holder' || Auth::user()->role=='Accountant-Cost Centre'){
            $car_rental_payments=DB::table('car_rental_payments')->join('car_rental_invoices','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')->where('cost_centre',Auth::user()->cost_centre)->where('car_rental_invoices.payment_status','Partially Paid')->orWhere('car_rental_invoices.payment_status','Paid')->get();
        }
        else{
            $car_rental_payments=DB::table('car_rental_payments')->join('car_rental_invoices','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')->where('car_rental_invoices.payment_status','Partially Paid')->orWhere('car_rental_invoices.payment_status','Paid')->get();
        }

        $research_payments=DB::table('research_flats_payments')->join('research_flats_invoices','research_flats_payments.invoice_number','=','research_flats_invoices.invoice_number')->where('research_flats_invoices.payment_status','Partially Paid')->orWhere('research_flats_invoices.payment_status','Paid')->get();
        $insurance_payments=DB::table('insurance_payments')->join('insurance_invoices','insurance_payments.invoice_number','=','insurance_invoices.invoice_number')->where('insurance_invoices.payment_status','Partially Paid')->orWhere('insurance_invoices.payment_status','Paid')->get();
        $insurance_clients_payments=DB::table('insurance_clients_payments')->join('insurance_invoices_clients','insurance_clients_payments.invoice_number','=','insurance_invoices_clients.invoice_number')->where('insurance_invoices_clients.payment_status','Partially Paid')->orWhere('insurance_invoices_clients.payment_status','Paid')->get();

        $water_bill_payments=DB::table('water_bill_payments')->join('water_bill_invoices','water_bill_payments.invoice_number','=','water_bill_invoices.invoice_number')->where('water_bill_invoices.payment_status','Partially Paid')->orWhere('water_bill_invoices.payment_status','Paid')->get();
        $electricity_bill_payments=DB::table('electricity_bill_payments')->join('electricity_bill_invoices','electricity_bill_payments.invoice_number','=','electricity_bill_invoices.invoice_number')->where('electricity_bill_invoices.payment_status','Partially Paid')->orWhere('electricity_bill_invoices.payment_status','Paid')->get();


        return view('payments_management')->with('space_payments',$space_payments)->with('space_inbox',$space_inbox)->with('space_outbox',$space_outbox)->with('car_rental_payments',$car_rental_payments)->with('insurance_payments',$insurance_payments)->with('research_payments',$research_payments)->with('water_bill_payments',$water_bill_payments)->with('electricity_bill_payments',$electricity_bill_payments)->with('insurance_clients_payments',$insurance_clients_payments);

    }




    public function paymentManagementInsurance(){


        $insurance_payments=DB::table('insurance_payments')->join('insurance_invoices','insurance_payments.invoice_number','=','insurance_invoices.invoice_number')->where('insurance_invoices.payment_status','Partially Paid')->orWhere('insurance_invoices.payment_status','Paid')->get();
        $insurance_clients_payments=DB::table('insurance_clients_payments')->join('insurance_invoices_clients','insurance_clients_payments.invoice_number','=','insurance_invoices_clients.invoice_number')->where('insurance_invoices_clients.payment_status','Partially Paid')->orWhere('insurance_invoices_clients.payment_status','Paid')->get();


        return view('payments_management_insurance')->with('insurance_payments',$insurance_payments)->with('insurance_clients_payments',$insurance_clients_payments);

    }

    public function paymentManagementResearch(){


        $research_payments=DB::table('research_flats_payments')->join('research_flats_invoices','research_flats_payments.invoice_number','=','research_flats_invoices.invoice_number')->where('research_flats_invoices.payment_status','Partially Paid')->orWhere('research_flats_invoices.payment_status','Paid')->get();

        return view('payments_management_research')->with('research_payments',$research_payments);

    }


    public function paymentManagementCarRental(){


        if(Auth::user()->role=='Vote Holder' || Auth::user()->role=='Accountant-Cost Centre'){
            $car_rental_payments=DB::table('car_rental_payments')->join('car_rental_invoices','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')->where('cost_centre',Auth::user()->cost_centre)->where('car_rental_invoices.payment_status','Partially Paid')->orWhere('car_rental_invoices.payment_status','Paid')->get();
        }
        else{
            $car_rental_payments=DB::table('car_rental_payments')->join('car_rental_invoices','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')->where('car_rental_invoices.payment_status','Partially Paid')->orWhere('car_rental_invoices.payment_status','Paid')->get();
        }

        return view('payments_management_car_rental')->with('car_rental_payments',$car_rental_payments);

    }

    public function CreateSpacePaymentManually(Request $request)
    {
        $amount_to_be_paid=DB::table('invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');

        if(DB::table('space_payments')->where('invoice_number_votebook',$request->get('invoice_number'))->where('receipt_number','!=','')->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }else{


            $payment_status='';
            $amount_to_be_paid=DB::table('invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('amount_to_be_paid');
            $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


            if($request->get('amount_paid')<$amount_to_be_paid){
                $payment_status='Partially Paid';


            }elseif($request->get('amount_paid')==$amount_to_be_paid) {
                $payment_status='Paid';


            }else{


            }


            $invoice=invoice::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $invoice->payment_status=$payment_status;
            $invoice->save();


            $space_payment= space_payment::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $space_payment->amount_paid=$request->get('amount_paid');
            $space_payment->amount_not_paid=$amount_not_paid;
            $space_payment->currency_payments=$request->get('currency_payments');
            $space_payment->receipt_number=$request->get('receipt_number');
            $space_payment->date_of_payment=$request->get('date_of_payment');
            $space_payment->save();



        }

//        DB::table('space_payments')->insert(
//            ['invoice_number_votebook' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );



        return redirect('/payment_management')
            ->with('success', 'Space payment recorded successfully');

    }



    public function checkAvailabilitySpace(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('invoices')->where('invoice_number_votebook',  $query)->get();
            if(count($data)!=0){
                $data2="";
                foreach($data as $var){
                    $data2=$var->currency_invoice;

                }
                echo $data2;


            }
            else{
                echo "0";
            }

        }





    }




    public function CreateInsurancePaymentManually(Request $request)
    {
        $amount_to_be_paid=DB::table('insurance_invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if(DB::table('insurance_payments')->where('invoice_number_votebook',$request->get('invoice_number'))->where('receipt_number','!=','')->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }else{



            $payment_status='';
            $amount_to_be_paid=DB::table('insurance_invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('amount_to_be_paid');
            $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


            if($request->get('amount_paid')<$amount_to_be_paid){
                $payment_status='Partially Paid';


            }elseif($request->get('amount_paid')==$amount_to_be_paid) {
                $payment_status='Paid';


            }else{


            }


            $insurance_invoice= insurance_invoice::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $insurance_invoice->payment_status=$payment_status;
            $insurance_invoice->save();



            $insurance_payment=insurance_payment::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $insurance_payment->amount_paid=$request->get('amount_paid');
            $insurance_payment->amount_not_paid=$amount_not_paid;
            $insurance_payment->currency_payments=$request->get('currency_payments');
            $insurance_payment->receipt_number=$request->get('receipt_number');
            $insurance_payment->date_of_payment=$request->get('date_of_payment');
            $insurance_payment->save();




        }

//        DB::table('insurance_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );



        return redirect('/payment_management')
            ->with('success', 'Insurance payment recorded successfully');

    }



    public function CreateInsuranceClientsPaymentManually(Request $request)
    {
        $amount_to_be_paid=DB::table('insurance_invoices_clients')->where('invoice_number_votebook', $request->get('invoice_number'))->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if(DB::table('insurance_clients_payments')->where('invoice_number_votebook',$request->get('invoice_number'))->where('receipt_number','!=','')->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }else{



            $payment_status='';
            $amount_to_be_paid=DB::table('insurance_invoices_clients')->where('invoice_number_votebook', $request->get('invoice_number'))->value('amount_to_be_paid');
            $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


            if($request->get('amount_paid')<$amount_to_be_paid){
                $payment_status='Partially Paid';


            }elseif($request->get('amount_paid')==$amount_to_be_paid) {
                $payment_status='Paid';


            }else{


            }


            $insurance_invoices_client= insurance_invoices_client::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $insurance_invoices_client->payment_status=$payment_status;
            $insurance_invoices_client->save();



            $insurance_clients_payment= insurance_clients_payment::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $insurance_clients_payment->amount_paid=$request->get('amount_paid');
            $insurance_clients_payment->amount_not_paid=$amount_not_paid;
            $insurance_clients_payment->currency_payments=$request->get('currency_payments');
            $insurance_clients_payment->receipt_number=$request->get('receipt_number');
            $insurance_clients_payment->date_of_payment=$request->get('date_of_payment');
            $insurance_clients_payment->save();





        }

//        DB::table('insurance_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );



        return redirect('/payment_management')
            ->with('success', 'Insurance payment recorded successfully');

    }




    public function checkAvailabilityInsurance(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('insurance_invoices')->where('invoice_number_votebook',  $query)->get();
            if(count($data)!=0){

                $data2="";
                foreach($data as $var){
                    $data2=$var->currency_invoice;

                }
                echo $data2;
            }
            else{
                echo "0";
            }

        }





    }


    public function checkAvailabilityInsuranceClients(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('insurance_invoices_clients')->where('invoice_number_votebook',  $query)->get();
            if(count($data)!=0){

                $data2="";
                foreach($data as $var){
                    $data2=$var->currency_invoice;

                }
                echo $data2;
            }
            else{
                echo "0";
            }

        }





    }

    public function CreateCarPaymentManually(Request $request)
    {

        $amount_to_be_paid=DB::table('car_rental_invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');

        if(DB::table('car_rental_payments')->where('invoice_number_votebook',$request->get('invoice_number'))->where('receipt_number','!=','')->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }else{


            $payment_status='';
            $amount_to_be_paid=DB::table('car_rental_invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('amount_to_be_paid');
            $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


            if($request->get('amount_paid')<$amount_to_be_paid){
                $payment_status='Partially Paid';


            }elseif($request->get('amount_paid')==$amount_to_be_paid) {
                $payment_status='Paid';


            }else{


            }


            $car_rental_invoice=car_rental_invoice::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $car_rental_invoice->payment_status=$payment_status;
            $car_rental_invoice->save();


            $car_rental_payment=car_rental_payment::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $car_rental_payment->amount_paid=$request->get('amount_paid');
            $car_rental_payment->amount_not_paid=$amount_not_paid;
            $car_rental_payment->currency_payments=$request->get('currency_payments');
            $car_rental_payment->receipt_number=$request->get('receipt_number');
            $car_rental_payment->date_of_payment=$request->get('date_of_payment');
            $car_rental_payment->save();






        }

//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );



        return redirect('/payment_management')
            ->with('success', 'Car rental payment recorded successfully');

    }




    public function CreateResearchPaymentManually(Request $request)
    {

        $amount_to_be_paid=DB::table('research_flats_invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');

        if(DB::table('research_flats_payments')->where('invoice_number_votebook',$request->get('invoice_number'))->where('receipt_number','!=','')->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }else{


            $payment_status='';
            $amount_to_be_paid=DB::table('research_flats_invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('amount_to_be_paid');
            $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


            if($request->get('amount_paid')<$amount_to_be_paid){
                $payment_status='Partially Paid';


            }elseif($request->get('amount_paid')==$amount_to_be_paid) {
                $payment_status='Paid';


            }else{


            }

            $research_flats_invoice= research_flats_invoice::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $research_flats_invoice->payment_status=$payment_status;
            $research_flats_invoice->save();


            $research_flats_payment= research_flats_payment::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $research_flats_payment->amount_paid=$request->get('amount_paid');
            $research_flats_payment->amount_not_paid=$amount_not_paid;
            $research_flats_payment->currency_payments=$request->get('currency_payments');
            $research_flats_payment->receipt_number=$request->get('receipt_number');
            $research_flats_payment->date_of_payment=$request->get('date_of_payment');
            $research_flats_payment->save();








        }

//        DB::table('car_rental_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );



        return redirect('/payment_management')
            ->with('success', 'Research Flats payment recorded successfully');

    }






    public function checkAvailabilityCar(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('car_rental_invoices')->where('invoice_number_votebook',  $query)->get();
            if(count($data)!=0){

                $data2="";
                foreach($data as $var){
                    $data2=$var->currency_invoice;

                }
                echo $data2;
            }
            else{
                echo "0";
            }

        }





    }



    public function checkAvailabilityResearch(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('research_flats_invoices')->where('invoice_number_votebook',  $query)->get();
            if(count($data)!=0){

                $data2="";
                foreach($data as $var){
                    $data2=$var->currency_invoice;

                }
                echo $data2;
            }
            else{
                echo "0";
            }

        }





    }




    public function CreateWaterPaymentManually(Request $request)
    {

        $amount_to_be_paid=DB::table('water_bill_invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('cumulative_amount');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');



        if(DB::table('water_bill_payments')->where('invoice_number_votebook',$request->get('invoice_number'))->where('receipt_number','!=','')->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }else{

            $payment_status='';
            $amount_to_be_paid=DB::table('water_bill_invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('cumulative_amount');
            $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


            if($request->get('amount_paid')<$amount_to_be_paid){
                $payment_status='Partially Paid';


            }elseif($request->get('amount_paid')==$amount_to_be_paid) {
                $payment_status='Paid';


            }else{


            }


            $water_bill_invoice= water_bill_invoice::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $water_bill_invoice->payment_status=$payment_status;
            $water_bill_invoice->save();



            $water_bill_payment=water_bill_payment::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $water_bill_payment->amount_paid=$request->get('amount_paid');
            $water_bill_payment->amount_not_paid=$amount_not_paid;
            $water_bill_payment->currency_payments=$request->get('currency_payments');
            $water_bill_payment->receipt_number=$request->get('receipt_number');
            $water_bill_payment->date_of_payment=$request->get('date_of_payment');
            $water_bill_payment->save();



        }

//        DB::table('water_bill_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );



        return redirect('/payment_management')
            ->with('success', 'Water bill payment recorded successfully');

    }



    public function checkAvailabilityWater(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('water_bill_invoices')->where('invoice_number_votebook',  $query)->get();
            if(count($data)!=0){

                $data2="";
                foreach($data as $var){
                    $data2=$var->currency_invoice;

                }
                echo $data2;
            }
            else{
                echo "0";
            }

        }





    }




    public function CreateElectricityPaymentManually(Request $request)
    {

        $amount_to_be_paid=DB::table('electricity_bill_invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('cumulative_amount');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if(DB::table('electricity_bill_payments')->where('invoice_number_votebook',$request->get('invoice_number'))->where('receipt_number','!=','')->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }else{


            $payment_status='';
            $amount_to_be_paid=DB::table('electricity_bill_invoices')->where('invoice_number_votebook', $request->get('invoice_number'))->value('cumulative_amount');
            $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


            if($request->get('amount_paid')<$amount_to_be_paid){
                $payment_status='Partially Paid';


            }elseif($request->get('amount_paid')==$amount_to_be_paid) {
                $payment_status='Paid';


            }else{


            }


            $electricity_bill_invoice=electricity_bill_invoice::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $electricity_bill_invoice->payment_status=$payment_status;
            $electricity_bill_invoice->save();


            $electricity_bill_payment=electricity_bill_payment::where('invoice_number_votebook', $request->get('invoice_number'))->first();
            $electricity_bill_payment->amount_paid=$request->get('amount_paid');
            $electricity_bill_payment->amount_not_paid=$amount_not_paid;
            $electricity_bill_payment->currency_payments=$request->get('currency_payments');
            $electricity_bill_payment->receipt_number=$request->get('receipt_number');
            $electricity_bill_payment->date_of_payment=$request->get('date_of_payment');
            $electricity_bill_payment->save();



        }

//        DB::table('electricity_bill_payments')->insert(
//            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number'),'date_of_payment' => $request->get('date_of_payment')]
//        );



        return redirect('/payment_management')
            ->with('success', 'Electricity payment recorded successfully');

    }



    public function checkAvailabilityElectricity(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('electricity_bill_invoices')->where('invoice_number_votebook',  $query)->get();
            if(count($data)!=0){

                $data2="";
                foreach($data as $var){
                    $data2=$var->currency_invoice;

                }
                echo $data2;
            }
            else{
                echo "0";
            }

        }





    }



    public function addDiscountSpace(Request $request,$id)
    {

        $space_payment=space_payment::where('id', $id)->first();
        $space_payment->temporary_over_payment=$request->get('temporary_over_payment');
        $space_payment->reason=$request->get('reason_for_discount');
        $space_payment->stage=1;
        $space_payment->save();


        return redirect('/payment_management')
            ->with('success', 'Request forwarded successfully');


    }


    public function approveDiscountRequest(Request $request,$id)
    {

        $space_payment=space_payment::where('id', $id)->first();

        if($request->get('approval_status')=='Rejected'){

            $space_payment->stage=2;
            $space_payment->approval_remarks=$request->get('approval_remarks');

        }else{

            $space_payment->stage=0;


            $temporary_over_payment=DB::table('space_payments')->where('id',$id)->value('temporary_over_payment');
            $temporary_reason=DB::table('space_payments')->where('id',$id)->value('reason');


            $space_payment->over_payment=$temporary_over_payment;
            $space_payment->permanent_reason=$temporary_reason;

        }



        $space_payment->save();

        return redirect('/payment_management')
            ->with('success', 'Operation completed successfully');


    }



    public function editDiscountSpace(Request $request,$id)
    {

        $space_payment=space_payment::where('id', $id)->first();
        $space_payment->temporary_over_payment=$request->get('temporary_over_payment');
        $space_payment->reason=$request->get('reason_for_discount');
        $space_payment->stage=1;
        $space_payment->save();


        return redirect('/payment_management')
            ->with('success', 'Request forwarded successfully');


    }


    public function cancelDiscountAdditionRequest(Request $request,$id)
    {

        $space_payment=space_payment::where('id', $id)->first();
        $space_payment->stage=0;
        $space_payment->save();

        return redirect('/payment_management')
            ->with('success', 'Request cancelled successfully');





    }




    public function payment_filtered(){
        return View::make('payments_filtered');
    }






}
