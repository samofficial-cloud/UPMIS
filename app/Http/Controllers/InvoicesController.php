<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\SendInvoice;
use App\client;
use Carbon\Carbon;


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
    public function SendSpaceInvoice()
    {
        $today=date('Y-m-d');

//        $startTime = Carbon::parse($cleanObj->starttime);
//        $diff = $cleanObj->created_at->diffInHours($startTime);
//        $monthly_email_date = Carbon::now()->startOfMonth();
//
        $expired_space_contracts=DB::select('call get_expired_space_contracts (?)',[$today]);

        foreach ($expired_space_contracts as $var) {





            $client=client::where('full_name',$var->full_name)->first();
            $first_name = DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('clients.full_name', $var->full_name)->value('first_name');

            $client->notify(new SendInvoice($first_name));

        }

    echo "Email sent Successfully";

    }



    public function index()
    {
      return view('invoice_pdf');

    }




}
