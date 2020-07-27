<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function paymentManagement()
    {

        $payments=DB::table('payments')->get();
        return view('payments_management')->with('payments',$payments);

    }
}
