<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function paymentManagement()
    {

        $space_payments=DB::table('payments')->where('category','space')->get();
        $car_rental_payments=DB::table('payments')->where('category','car rental')->get();
        $insurance_payments=DB::table('payments')->where('category','insurance')->get();
        $water_bill_payments=DB::table('payments')->where('category','water bill')->get();
        $electricity_bill_payments=DB::table('payments')->where('category','electricity bill')->get();


        return view('payments_management')->with('space_payments',$space_payments)->with('car_rental_payments',$car_rental_payments)->with('insurance_payments',$insurance_payments)->with('water_bill_payments',$water_bill_payments)->with('electricity_bill_payments',$electricity_bill_payments);

    }
}
