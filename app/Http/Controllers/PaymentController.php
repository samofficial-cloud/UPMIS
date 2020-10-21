<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function paymentManagement()
    {

        $space_payments=DB::table('space_payments')->join('invoices','space_payments.invoice_number','=','invoices.invoice_number')->get();
        $car_rental_payments=DB::table('car_rental_payments')->join('car_rental_invoices','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')->get();
        $insurance_payments=DB::table('insurance_payments')->join('insurance_invoices','insurance_payments.invoice_number','=','insurance_invoices.invoice_number')->get();
        $water_bill_payments=DB::table('water_bill_payments')->join('water_bill_invoices','water_bill_payments.invoice_number','=','water_bill_invoices.invoice_number')->get();
        $electricity_bill_payments=DB::table('electricity_bill_payments')->join('electricity_bill_invoices','electricity_bill_payments.invoice_number','=','electricity_bill_invoices.invoice_number')->get();


        return view('payments_management')->with('space_payments',$space_payments)->with('car_rental_payments',$car_rental_payments)->with('insurance_payments',$insurance_payments)->with('water_bill_payments',$water_bill_payments)->with('electricity_bill_payments',$electricity_bill_payments);

    }


    public function CreateSpacePaymentManually(Request $request)
    {
        $amount_to_be_paid=DB::table('invoices')->where('invoice_number', $request->get('invoice_number'))->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');

        if(DB::table('space_payments')->where('invoice_number',$request->get('invoice_number'))->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }

        DB::table('space_payments')->insert(
            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number')]
        );



        return redirect('/payment_management')
            ->with('success', 'Space payment recorded successfully');

    }



    public function checkAvailabilitySpace(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('invoices')->where('invoice_number', 'LIKE', "%{$query}%")->get();
            if(count($data)!=0){

                echo "1";
            }
            else{
                echo "0";
            }

        }





    }




    public function CreateInsurancePaymentManually(Request $request)
    {
        $amount_to_be_paid=DB::table('insurance_invoices')->where('invoice_number', $request->get('invoice_number'))->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if(DB::table('insurance_payments')->where('invoice_number',$request->get('invoice_number'))->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }

        DB::table('insurance_payments')->insert(
            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number')]
        );



        return redirect('/payment_management')
            ->with('success', 'Insurance payment recorded successfully');

    }




    public function checkAvailabilityInsurance(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('insurance_invoices')->where('invoice_number', 'LIKE', "%{$query}%")->get();
            if(count($data)!=0){

                echo "1";
            }
            else{
                echo "0";
            }

        }





    }




    public function CreateCarPaymentManually(Request $request)
    {

        $amount_to_be_paid=DB::table('car_rental_invoices')->where('invoice_number', $request->get('invoice_number'))->value('amount_to_be_paid');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');

        if(DB::table('car_rental_payments')->where('invoice_number',$request->get('invoice_number'))->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }

        DB::table('car_rental_payments')->insert(
            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number')]
        );



        return redirect('/payment_management')
            ->with('success', 'Car rental payment recorded successfully');

    }





    public function checkAvailabilityCar(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('car_rental_invoices')->where('invoice_number', 'LIKE', "%{$query}%")->get();
            if(count($data)!=0){

                echo "1";
            }
            else{
                echo "0";
            }

        }





    }




    public function CreateWaterPaymentManually(Request $request)
    {

        $amount_to_be_paid=DB::table('water_bill_invoices')->where('invoice_number', $request->get('invoice_number'))->value('cumulative_amount');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');



        if(DB::table('water_bill_payments')->where('invoice_number',$request->get('invoice_number'))->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }

        DB::table('water_bill_payments')->insert(
            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number')]
        );



        return redirect('/payment_management')
            ->with('success', 'Water bill payment recorded successfully');

    }



    public function checkAvailabilityWater(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('water_bill_invoices')->where('invoice_number', 'LIKE', "%{$query}%")->get();
            if(count($data)!=0){

                echo "1";
            }
            else{
                echo "0";
            }

        }





    }




    public function CreateElectricityPaymentManually(Request $request)
    {

        $amount_to_be_paid=DB::table('electricity_bill_invoices')->where('invoice_number', $request->get('invoice_number'))->value('cumulative_amount');
        $amount_not_paid=$amount_to_be_paid-$request->get('amount_paid');


        if(DB::table('electricity_bill_payments')->where('invoice_number',$request->get('invoice_number'))->exists()){


            return redirect()->back()->with("error","Payment record already exists for the specified invoice number");

        }

        DB::table('electricity_bill_payments')->insert(
            ['invoice_number' => $request->get('invoice_number'), 'invoice_number_votebook' => $request->get('invoice_number_votebook'),'amount_paid' => $request->get('amount_paid'),'amount_not_paid' =>$amount_not_paid,'currency_payments' => $request->get('currency_payments'),'receipt_number' => $request->get('receipt_number')]
        );



        return redirect('/payment_management')
            ->with('success', 'Electricity payment recorded successfully');

    }



    public function checkAvailabilityElectricity(Request $request)
    {


        if($request->get('query'))
        {
            $query = $request->get('query');


            $data=DB::table('electricity_bill_invoices')->where('invoice_number', 'LIKE', "%{$query}%")->get();
            if(count($data)!=0){

                echo "1";
            }
            else{
                echo "0";
            }

        }





    }






}
