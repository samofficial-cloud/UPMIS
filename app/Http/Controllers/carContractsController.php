<?php

namespace App\Http\Controllers;

use App\car_rental_invoice;
use App\car_rental_payment;
use Illuminate\Http\Request;
use DB;

use App\carContract;
use App\client;
use PDF;
use Auth;
use App\cost_centre;
use Riskihajar\Terbilang\Facades\Terbilang;
use App\carRental;
use App\Notifications\RequestAccepted;
use Response;
use App\log_sheet;


class carContractsController extends Controller
{
    //
    public function index(){
        if(Auth::user()->role=='CPTU staff'){
        $outbox=carContract::where('cptu_msg_status','outbox')->where('form_completion','0')->get();
        $inbox=carContract::where('cptu_msg_status','inbox')->where('form_completion','0')->get();
        $closed=carContract::where('form_completion','1')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
        return view ('car_contracts2')->with('outbox',$outbox)->with('inbox',$inbox)->with('closed',$closed);
     }
     elseif(Auth::user()->role=='Vote Holder'){
        $inbox=carContract::where('head_msg_status','inbox')->where('form_completion','0')->get();
        $outbox=carContract::where('head_msg_status','outbox')->where('form_completion','0')->get();
        // foreach ($inbox as $msg) {
        //     # code...
        //      DB::table('notifications')
        //         ->where('contract_id', $msg->id)
        //         ->update(['flag' => '0']);

        // }
        return view('car_contracts3')->with('inbox',$inbox)->with('outbox',$outbox);
     }
      elseif(Auth::user()->role=='Accountant'){
         $inbox=carContract::where('acc_msg_status','inbox')->where('form_completion','0')->get();
        $outbox=carContract::where('acc_msg_status','outbox')->where('form_completion','0')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
        return view('car_contracts4')->with('inbox',$inbox)->with('outbox',$outbox);
      }
       elseif(Auth::user()->role=='Head of CPTU'){
         $inbox=carContract::where('head_cptu_msg_status','inbox')->where('form_completion','0')->get();
        $outbox=carContract::where('head_cptu_msg_status','outbox')->where('form_completion','0')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
        return view('car_contracts5')->with('inbox',$inbox)->with('outbox',$outbox);
      }

      elseif(Auth::user()->role=='DVC Administrator'){
         $inbox=carContract::where('dvc_msg_status','inbox')->where('form_completion','0')->get();
        $outbox=carContract::where('dvc_msg_status','outbox')->where('form_completion','0')->get();
        foreach ($inbox as $msg) {
            # code...
             DB::table('notifications')
                ->where('contract_id', $msg->id)
                ->update(['flag' => '0']);

        }
        return view('car_contracts6')->with('inbox',$inbox)->with('outbox',$outbox);
      }

    }

    public function viewmore($id){
        $invoices=DB::table('car_rental_invoices')->where('contract_id',$id)->orderBy('invoice_date','asc')->get();
        $payments = DB::table('car_rental_payments')->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')->where('contract_id',$id)->orderBy('date_of_payment','asc')->get();
        return View('carcontracts_viewmore',compact('invoices','payments'));
    }

    public function addContractFormA(){
        $cost_centres=cost_centre::orderBy('costcentre_id','asc')->get();
         return view('CarRentalForm2')->with('cost_centres',$cost_centres);
    }

    public function addContractFormB($id){
        $contract=carContract::find($id);
        $nature = carContract::select('trip_nature')->where('id',$id)->value('trip_nature');
         return view('CarRentalFormB1')->with('contract',$contract)->with('nature', $nature);
    }

    public function addContractFormC($id){
        $contract=carContract::find($id);
        $nature = carContract::select('trip_nature')->where('id',$id)->value('trip_nature');
         return view('CarRentalFormB2')->with('contract',$contract)->with('nature', $nature);
    }

    public function addContractFormD($id){
        $contract=carContract::find($id);
         $start_date=carContract::select('start_date')->where('id',$id)->value('start_date');
         $data= DB::table('car_rentals')
        ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')->where('vehicle_reg_no','!=',null)->whereDate('end_date','>=', $start_date)->pluck('vehicle_reg_no')->toArray())
        ->where('vehicle_status','!=','Grounded')
        ->where('flag','1')
        ->get();
        $nature = carContract::select('trip_nature')->where('id',$id)->value('trip_nature');
        $payment_status=DB::table('car_rental_invoices')->select('payment_status')->where('contract_id',$id)->orderBy('invoice_number','desc')->limit(1)->value('payment_status');


         return view('CarRentalFormB3')->with('contract',$contract)->with('data',$data)->with('nature', $nature)->with('payment_status',$payment_status);
    }

    public function addContractFormD1($id){
        $contract=carContract::find($id);
        $start_date=carContract::select('start_date')->where('id',$id)->value('start_date');
         $data= DB::table('car_rentals')
        ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')->where('vehicle_reg_no','!=',null)->whereDate('end_date','>=', $start_date)->pluck('vehicle_reg_no')->toArray())
        ->where('vehicle_status','!=','Grounded')
        ->where('flag','1')
        ->get();
        $nature = carContract::select('trip_nature')->where('id',$id)->value('trip_nature');
        $payment_status=DB::table('car_rental_invoices')->select('payment_status')->where('contract_id',$id)->orderBy('invoice_number','desc')->limit(1)->value('payment_status');
         return view('CarRentalFormB31')->with('contract',$contract)->with('data',$data)->with('nature', $nature)->with('payment_status',$payment_status);
    }

    public function addContractFormE($id){
        $contract=carContract::find($id);
        $nature = carContract::select('trip_nature')->where('id',$id)->value('trip_nature');
         return view('CarRentalFormB4')->with('contract',$contract)->with('nature', $nature);
    }

    // public function addContractForm(){
    //     return view('carRentalForm2');
    // }

    public function newContractA(Request $request){
    $first_name = $request->input('first_name');
    $last_name = $request->input('last_name');
    $full_name=$first_name. ' '.$last_name;
    $start_date=strtotime($request->input('start_date'));
    $end_date=strtotime($request->input('end_date'));
    if($start_date>$end_date){
        $start_date=$request->input('end_date');
        $end_date=$request->input('start_date');
    }
    else{
      $start_date=$request->input('start_date');
      $end_date=$request->input('end_date');
    }

        if($request->get('trip_nature')=='Private'){



            $carContract= new carContract();
            $carContract->fullName=$full_name;
            $carContract->area_of_travel=$request->get('area');
            $carContract->faculty=$request->get('faculty_name');
            $carContract->cost_centre=$request->get('centre_name');
            $carContract->designation=$request->get('designation');
            $carContract->start_date=$start_date;
            $carContract->end_date=$end_date;
            $carContract->start_time=$request->get('start_time');
            $carContract->end_time=$request->get('end_time');
            $carContract->overtime=$request->get('overtime');
            $carContract->destination=$request->get('destination');
            $carContract->purpose=$request->get('purpose');
            $carContract->trip_nature=$request->get('trip_nature');
            $carContract->estimated_distance=$request->get('estimated_distance');
            $carContract->estimated_cost=$request->get('estimated_cost');
            $carContract->form_initiator=Auth::user()->name;
            $carContract->cptu_msg_status='inbox';
            $carContract->form_status='Transport Officer-CPTU';
            $carContract->form_completion='0';
            $carContract->email=$request->get('email');
            $carContract->first_name=$request->input('first_name');
            $carContract->last_name=$request->input('last_name');
            $carContract->initial_payment=$request->get('initial_amount');
            $carContract->tin=$request->get('tin');
            $carContract->save();



            $id=DB::table('car_contracts')->orderBy('id','desc')->limit(1)->value('id');


           $inserted_contract=DB::table('car_contracts')->where('id',$id)->get();

            foreach($inserted_contract as $var) {

                $period= date("d/m/Y",strtotime($var->start_date)).' to  '. date("d/m/Y",strtotime($var->end_date));

                $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


                $amount_in_words='';

                $amount_in_words=Terbilang::make($var->initial_payment,' TZS',' ');


                $today=date('Y-m-d');

                $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');


                $car_rental_invoice= new car_rental_invoice();
                $car_rental_invoice->contract_id=$var->id;
                $car_rental_invoice->invoicing_period_start_date=$var->start_date;
                $car_rental_invoice->invoicing_period_end_date=$var->end_date;
                $car_rental_invoice->period=$period;
                $car_rental_invoice->project_id='Car rental';
                $car_rental_invoice->debtor_account_code='';
                $car_rental_invoice->debtor_name=$var->fullName;
                $car_rental_invoice->debtor_address='';
                $car_rental_invoice->amount_to_be_paid=$var->initial_payment;
                $car_rental_invoice->currency_invoice='TZS';
                $car_rental_invoice->gepg_control_no='';
                $car_rental_invoice->tin='';
                $car_rental_invoice->vrn='';
                $car_rental_invoice->max_no_of_days_to_pay=$max_no_of_days_to_pay;
                $car_rental_invoice->status='OK';
                $car_rental_invoice->amount_in_words=$amount_in_words;
                $car_rental_invoice->inc_code='';
                $car_rental_invoice->invoice_date=$today;
                $car_rental_invoice->financial_year=$financial_year;
                $car_rental_invoice->payment_status='Not paid';
                $car_rental_invoice->description='Car Rental';
                $car_rental_invoice->prepared_by=Auth::user()->name;
                $car_rental_invoice->approved_by='N/A';
                $car_rental_invoice->save();



            }

            $invoice_number_created=DB::table('car_rental_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'car_rental']
            );


               $car_rental_payment=new car_rental_payment();
               $car_rental_payment->invoice_number=$invoice_number_created;
               $car_rental_payment->invoice_number_votebook=null;
               $car_rental_payment->amount_paid=0;
               $car_rental_payment->amount_not_paid=$var->initial_payment;
               $car_rental_payment->currency_payments='TZS';
               $car_rental_payment->receipt_number='';
               $car_rental_payment->save();


            $nature = 'Private';
            $contract=carContract::find($id);
          return redirect()->route('carRentalFormB',['id' => $id]);

        }
        else{


            $carContract= new carContract();
            $carContract->fullName=$full_name;
            $carContract->area_of_travel=$request->get('area');
            $carContract->faculty=$request->get('faculty_name');
            $carContract->cost_centre=$request->get('centre_name');
            $carContract->designation=$request->get('designation');
            $carContract->start_date=$start_date;
            $carContract->end_date=$end_date;
            $carContract->start_time=$request->get('start_time');
            $carContract->end_time=$request->get('end_time');
            $carContract->overtime=$request->get('overtime');
            $carContract->destination=$request->get('destination');
            $carContract->purpose=$request->get('purpose');
            $carContract->trip_nature=$request->get('trip_nature');
            $carContract->estimated_distance=$request->get('estimated_distance');
            $carContract->estimated_cost=$request->get('estimated_cost');
            $carContract->form_initiator=Auth::user()->name;
            $carContract->cptu_msg_status='outbox';
            $carContract->form_status='Accountant';
            $carContract->form_completion='0';
            $carContract->acc_msg_status='inbox';
            $carContract->email=$request->get('email');
            $carContract->first_name=$request->input('first_name');
            $carContract->last_name=$request->input('last_name');
            $carContract->initial_payment=$request->get('initial_amount');
            $carContract->tin=$request->get('tin');
            $carContract->save();



            $id=DB::table('car_contracts')->orderBy('id','desc')->limit(1)->value('id');









            // DB::table('notifications')->insert(['role'=>'Vote Holder', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract', 'contract_id'=>$id]);
           DB::table('notifications')->insert(['role'=>'Accountant-Cost Centre', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);
            return redirect()->route('contracts_management')->with('success', 'Details Forwaded Successfully');
        }

    }


    public function newContractB(Request $request){
        $id=$request->get('contract_id');
        $area=carContract::select('area_of_travel')->where('id',$id)->value('area_of_travel');


        $nature = carContract::select('trip_nature')->where('id',$id)->value('trip_nature');


        $carContract=carContract::find($id);
        $carContract->transport_code=$request->get('code_no');
        $carContract->funds_available=$request->get('fund_available');
        $carContract->balance_status=$request->get('balance_status');
        $carContract->vote_title=$request->get('vote_holder');
        $carContract->fund_committed=$request->get('commited_fund');
        $carContract->acc_name=$request->get('approve_name');
        $carContract->acc_date=$request->get('approve_date');
        $carContract->vote_remarks=$request->get('vote_remarks');
        $carContract->vote_holder_signature=Auth::user()->signature;




        if($nature=='Private'){

            $carContract->cptu_msg_status='outbox';

        }
        else{


                  DB::table('notifications')
                ->where('contract_id', $id)
                ->where('role', 'Vote Holder')
                ->update(['flag' => '0']);


            $carContract->head_msg_status='outbox';

            }

                if($area=='Within'){

                    $carContract->form_status='Head of CPTU';
                    $carContract->head_cptu_msg_status='inbox';

                    DB::table('notifications')->insert(['role'=>'Head of CPTU', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);
                }

                elseif($area=='Outside'){

                    $carContract->form_status='DVC Administrator';
                    $carContract->dvc_msg_status='inbox';


                    DB::table('notifications')->insert(['role'=>'DVC Administrator', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);
                }

                $carContract->save();

                 return redirect()->route('contracts_management')->with('success', 'Details Forwaded Successfully');


    }

    public function newcontractC(Request $request){
        $id=$request->get('contract_id');
        $area=carContract::select('area_of_travel')->where('id',$id)->value('area_of_travel');
        $nature=carContract::select('trip_nature')->where('id',$id)->value('trip_nature');

        $carContract=carContract::find($id);
        $carContract->transport_code=$request->get('code_no');
        $carContract->funds_available=$request->get('fund_available');
        $carContract->balance_status=$request->get('balance_status');
        $carContract->head_name=$request->get('head_name');
        $carContract->head_date=$request->get('head_date');
        $carContract->head_approval_status=$request->get('head_approval_status');
        $carContract->accountant_signature=Auth::user()->signature;
        $carContract->save();



                if($nature=='Private'){
                    $carContract=carContract::find($id);
                    $carContract->form_status='Transport Officer-CPTU';
                    $carContract->cptu_msg_status='inbox';
                    $carContract->save();

                return redirect()->route('carRentalFormC',['id' => $id]);

                }
                else{

                    $carContract=carContract::find($id);
                    $carContract->acc_msg_status='outbox';
                    $carContract->save();


                            DB::table('notifications')
                            ->where('contract_id', $id)
                            ->where('role','Accountant-Cost Centre')
                            ->update(['flag' => '0']);

                        if($request->get('head_approval_status')=='Rejected'){
                            // DB::table('car_contracts')
                            // ->where('id', $id)
                            // ->update(['form_status' => 'Vote Holder']);

                            //  DB::table('car_contracts')
                            // ->where('id', $id)
                            // ->update(['head_msg_status' => 'inbox']);
                            $carContract=carContract::find($id);
                            $carContract->acc_remark=$request->get('acc_remark');
                            $carContract->form_status='Transport Officer-CPTU';
                            $carContract->cptu_msg_status='inbox';
                            $carContract->save();


                             // DB::table('notifications')->insert(['role'=>'Vote Holder', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);



                            DB::table('notifications')->insert(['role'=>'Transport Officer-CPTU', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);

                            }

                            else{

                                $carContract=carContract::find($id);
                                $carContract->form_status='Vote Holder';
                                $carContract->head_msg_status='inbox';
                                $carContract->save();

                                DB::table('notifications')->insert(['role'=>'Vote Holder', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract', 'contract_id'=>$id]);

                        }
                        return redirect()->route('contracts_management')->with('success', 'Details Forwaded Successfully');
                    }
      }

      public function newContractD(Request $request){
        $id=$request->get('contract_id');



          $carContract=carContract::find($id);
          $carContract->head_cptu_name=$request->get('head_cptu_name');
          $carContract->head_cptu_date=$request->get('head_cptu_date');
          $carContract->vehicle_reg_no=$request->get('vehicle_reg');
          $carContract->head_cptu_msg_status='outbox';
          $carContract->cptu_msg_status='inbox';
          $carContract->form_status='Transport Officer-CPTU';
          $carContract->head_cptu_signature=Auth::user()->signature;




                // DB::table('car_contracts')
                // ->where('id', $id)
                // ->update(['head_cptu_approval_status' => $request->get('head_cptu_approval_status')]);



                $hire_rate=carRental::
                 where('vehicle_reg_no',$request->get('vehicle_reg'))
                 ->value('hire_rate');
          $carContract->charge_km=$hire_rate;
            $carContract->save();

                $client = carContract::where('id', $id)->first();
                $start = carContract::select('start_date')->where('id', $id)->value('start_date');
                $end = carContract::select('end_date')->where('id', $id)->value('end_date');
                $dest = carContract::select('destination')->where('id', $id)->value('destination');
                $vehicle = $request->get('vehicle_reg');
                $name = carContract::select('fullName')->where('id', $id)->value('fullName');
                $salutation = 'Central Pool Transport Unit UDSM.';

                $client->notify(new RequestAccepted($start, $end, $dest, $vehicle, $name, $salutation));

                 DB::table('notifications')
                            ->where('contract_id', $id)
                            ->where('role','Head of CPTU')
                            ->update(['flag' => '0']);



                 DB::table('notifications')->insert(['role'=>'Transport Officer-CPTU', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);

                return redirect()->route('contracts_management')->with('success', 'Details Forwaded Successfully');

              }

               public function newContractD1(Request $request){
        $id=$request->get('contract_id');

                   $carContract=carContract::find($id);
                   $carContract->dvc_name=$request->get('head_cptu_name');
                   $carContract->dvc_date=$request->get('head_cptu_date');
                   $carContract->vehicle_reg_no=$request->get('vehicle_reg');
                   $carContract->dvc_msg_status='outbox';
                   $carContract->cptu_msg_status='inbox';
                   $carContract->form_status='Transport Officer-CPTU';






                // DB::table('car_contracts')
                // ->where('id', $id)
                // ->update(['dvc_approval_status' => $request->get('head_cptu_approval_status')]);






                $hire_rate=carRental::
                 where('vehicle_reg_no',$request->get('vehicle_reg'))
                 ->value('hire_rate');

                   $carContract->charge_km=$hire_rate;
                   $carContract->save();


                $client = carContract::where('id', $id)->first();
                $start = carContract::select('start_date')->where('id', $id)->value('start_date');
                $end = carContract::select('end_date')->where('id', $id)->value('end_date');
                $dest = carContract::select('destination')->where('id', $id)->value('destination');
                $vehicle = $request->get('vehicle_reg');
                $name = carContract::select('fullName')->where('id', $id)->value('fullName');
                 $salutation = 'Central Pool Transport Unit UDSM.';
                $client->notify(new RequestAccepted($start, $end, $dest, $vehicle, $name, $salutation));

                 DB::table('notifications')
                            ->where('contract_id', $id)
                            ->where('role','DVC Administrator')
                            ->update(['flag' => '0']);

                 DB::table('notifications')->insert(['role'=>'Transport Officer-CPTU', 'message'=>'You have a new pending car rental application', 'flag'=>'1', 'type'=>'car contract','contract_id'=>$id]);

                return redirect()->route('contracts_management')->with('success', 'Details Forwaded Successfully');

              }

        public function newContractE(Request $request){
        $id=$request->get('contract_id');

        $head_sign = DB::table('car_contracts')->select('head_cptu_signature')->where('id', $id)->value('head_cptu_signature');
        if(is_null($head_sign)){

            $head_cptu_signature = DB::table('users')->select('signature')->where('role','Head of CPTU')->value('signature');

            $carContract=carContract::find($id);
            $carContract->head_cptu_signature=$head_cptu_signature;
            $carContract->save();

        }
            $carContract=carContract::find($id);
            $carContract->initial_speedmeter=$request->get('speedmeter_km');
            $carContract->initial_speedmeter_time=$request->get('speedmeter_time');
            $carContract->ending_speedmeter=$request->get('end_speedmeter_km');
            $carContract->ending_speedmeter_time=$request->get('end_speedmeter_time');
            $carContract->overtime_hrs=$request->get('end_overtime');
            $carContract->driver_name=$request->get('driver_name');
            $carContract->driver_date=$request->get('driver_date');
            $carContract->charge_km=$request->get('charge_km');
            $carContract->mileage_km=$request->get('mileage_km');
            $carContract->mileage_tshs=$request->get('mileage_tshs');
            $carContract->penalty_hrs=$request->get('penalty_hrs');
            $carContract->penalty_amount=$request->get('penalty_amount');
            $carContract->overtime_charges=$request->get('overtime_charges');
            $carContract->total_charges=$request->get('total_charges');
            $carContract->standing_charges=$request->get('standing_charges');
            $carContract->grand_total=$request->get('grand_total');
            $carContract->save();


           if(($request->get('button_value'))=='save_close'){
               $carContract=carContract::find($id);
               $carContract->form_completion='1';
               $carContract->save();

           $inserted_contract=DB::table('car_contracts')->where('id',$id)->get();

            foreach($inserted_contract as $var) {


                $period= date("d/m/Y",strtotime($var->start_date)).' to  '. date("d/m/Y",strtotime($var->end_date));

                $max_no_of_days_to_pay=DB::table('system_settings')->where('id',1)->value('max_no_of_days_to_pay_invoice');


                $amount_in_words='';

                $amount_in_words=Terbilang::make($var->grand_total,' TZS',' ');


                $today=date('Y-m-d');

                $financial_year=DB::table('system_settings')->where('id',1)->value('financial_year');



                $car_rental_invoice= new car_rental_invoice();
                $car_rental_invoice->contract_id=$var->id;
                $car_rental_invoice->invoicing_period_start_date=$var->start_date;
                $car_rental_invoice->invoicing_period_end_date=$var->end_date;
                $car_rental_invoice->period=$period;
                $car_rental_invoice->project_id='Car rental';
                $car_rental_invoice->debtor_account_code='';
                $car_rental_invoice->debtor_name=$var->fullName;
                $car_rental_invoice->debtor_address='';
                $car_rental_invoice->amount_to_be_paid=$var->grand_total;
                $car_rental_invoice->currency_invoice='TZS';
                $car_rental_invoice->gepg_control_no='';
                $car_rental_invoice->tin='';
                $car_rental_invoice->vrn='';
                $car_rental_invoice->max_no_of_days_to_pay=$max_no_of_days_to_pay;
                $car_rental_invoice->status='OK';
                $car_rental_invoice->amount_in_words=$amount_in_words;
                $car_rental_invoice->inc_code='';
                $car_rental_invoice->invoice_date=$today;
                $car_rental_invoice->financial_year=$financial_year;
                $car_rental_invoice->payment_status='Not paid';
                $car_rental_invoice->description='Car Rental';
                $car_rental_invoice->prepared_by=Auth::user()->name;
                $car_rental_invoice->approved_by='N/A';
                $car_rental_invoice->save();





            }

            $invoice_number_created=DB::table('car_rental_invoices')->orderBy('invoice_number','desc')->limit(1)->value('invoice_number');

            DB::table('invoice_notifications')->insert(
                ['invoice_id' => $invoice_number_created, 'invoice_category' => 'car_rental']
            );

               $car_rental_payment=new car_rental_payment();
               $car_rental_payment->invoice_number=$invoice_number_created;
               $car_rental_payment->invoice_number_votebook=null;
               $car_rental_payment->amount_paid=0;
               $car_rental_payment->amount_not_paid=$var->grand_total;
               $car_rental_payment->currency_payments='TZS';
               $car_rental_payment->receipt_number='';
               $car_rental_payment->save();


               DB::table('notifications')
                            ->where('contract_id', $id)
                            ->where('role','Transport Officer-CPTU')
                            ->update(['flag' => '0']);

             return redirect()->route('contracts_management')->with('success', 'Details Saved and Closed Successfully');
       }
       else{


          return redirect()->route('contracts_management')->with('success', 'Details Saved Successfully');
       }

              }



    public function newContract(Request $request){
    $client_typ = $request->input('client_type');
    if($client_typ=='1'){
    	$client_type='Individual';
    }
    else if($client_typ=='2'){
    	$client_type='Company';
    }
    $first_name = $request->input('first_name');
    $last_name = $request->input('last_name');
    $company_name=$request->input('company_name');
    $email=$request->input('email');
    $phone_number = $request->input('phone_number');
    $address = $request->input('address');
    $vehicle_reg_no = $request->input('vehicle_reg');
     $condition = $request->input('condition');
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $rate = $request->input('rate');
    $amount = $request->input('amount');
    $contract_type="Car Rental";
    $currency=$request->input('currency');
    $full_name=$first_name. ' '.$last_name;

   if($client_type=='Individual'){
    $contract_data=array('fullName'=>$first_name. ' '.$last_name,"vehicle_reg_no"=>$vehicle_reg_no,'start_date'=>$start_date, 'end_date'=>$end_date, 'special_condition'=>$condition, 'rate'=>$rate, 'amount'=>$amount, 'currency'=>$currency);

    $validate=client::where('full_name',$full_name)->where('contract',$contract_type)->get();

    if (count($validate)>0) {
        DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['address' => $address]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['email' => $email]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['phone_number' => $phone_number]);
    }

    else{
    $client_data=array('first_name'=>$first_name,"last_name"=>$last_name,'address'=>$address, 'email'=>$email, 'phone_number'=>$phone_number, 'type'=>$client_type, 'full_name'=>$first_name. ' '.$last_name, 'contract'=>$contract_type);
    DB::table('clients')->insert($client_data);
}

}

   else if($client_type=='Company'){
    $contract_data=array('fullName'=>$company_name,"vehicle_reg_no"=>$vehicle_reg_no,'start_date'=>$start_date, 'end_date'=>$end_date, 'special_condition'=>$condition, 'rate'=>$rate, 'amount'=>$amount, 'currency'=>$currency);


$validate2=client::where('full_name',$company_name)->where('contract',$contract_type)->get();

   if (count($validate2)>0) {
      DB::table('clients')
                ->where('full_name', $company_name)
                ->update(['address' => $address]);

            DB::table('clients')
                ->where('full_name', $company_name)
                ->update(['email' => $email]);

            DB::table('clients')
                ->where('full_name', $company_name)
                ->update(['phone_number' => $phone_number]);
    }

    else {
    $client_data=array('full_name'=>$company_name,'address'=>$address, 'email'=>$email, 'phone_number'=>$phone_number, 'type'=>$client_type, 'contract'=>$contract_type, 'company _name'=>$company_name);
    DB::table('clients')->insert($client_data);
}

}



    DB::table('car_contracts')->insert($contract_data);

   //create invoice



   return redirect()->route('carContracts')->with('success', 'Contract Added Successfully');

}

public function editContractForm($id){
    $contract=carContract::select('clients.type','clients.first_name','clients.last_name', 'clients.address','clients.email', 'clients.phone_number', 'clients.client_id', 'car_contracts.vehicle_reg_no', 'car_contracts.start_date', 'car_contracts.end_date', 'car_contracts.amount', 'car_contracts.rate', 'car_contracts.fullName', 'car_contracts.id', 'car_rentals.vehicle_model', 'car_rentals.vehicle_status', 'car_rentals.hire_rate', 'car_contracts.special_condition', 'car_contracts.id','car_contracts.currency')
        ->join('clients', 'clients.full_name', '=', 'car_contracts.fullName')
        ->join('car_rentals', 'car_rentals.vehicle_reg_no', '=', 'car_contracts.vehicle_reg_no')
        ->where('clients.contract', 'Car Rental')
        ->where('car_contracts.id',$id)
        ->first();
        return view('editcarrentalform')->with('contract',$contract);

}

public function editcontract(Request $request){
    $contract_id=$request->input('contract_id');
    $client_id=$request->input('client_id');
    $client_typ = $request->input('client_type');
    $client= client::find($client_id);
    if($client_typ=='1'){
     $client->type='Individual';
     $client->first_name=$request->input('first_name');
     $client->last_name=$request->input('last_name');
     $client->full_name=$request->input('first_name').' '.$request->input('last_name');
     $newfullName=$request->input('first_name').' '.$request->input('last_name');
     $client->company_name=NULL;
    }
    elseif($client_typ=='2'){
     $client->type='Company';
     $client->company_name=$request->input('company_name');
     $client->full_name=$request->input('company_name');
     $client->first_name=NULL;
     $client->last_name=NULL;
     $newfullName=$request->input('company_name');
    }

    $client->address=$request->input('address');
    $client->phone_number=$request->input('phone_number');
    $client->email=$request->input('email');

    $client->save();
    $contract=carContract::find($contract_id);
    $fullNames=$contract->fullName;
    $contract->vehicle_reg_no=$request->input('vehicle_reg');
    $contract->special_condition=$request->input('condition');
    $contract->start_date=$request->input('start_date');
    $contract->end_date=$request->input('end_date');
    $contract->rate = $request->input('rate');
    $contract->amount = $request->input('amount');
    $contract->currency=$request->input('currency');
    $contract->save();

    DB::table('car_contracts')->where(['fullName' => $fullNames])->update(['fullName' => $newfullName]);

    return redirect()->route('carContracts')->with('success', 'Contract Details Edited Successfully');
}
public function terminateContract($id, Request $request){
    $contract=carContract::find($id);
    $contract->flag=0;
    $contract->reason_for_termination=$request->get('reason_for_termination');
    $contract->save();
    return redirect()->back()->with('success', 'Contract Terminated Successfully');

}

public function deletecontract($id){
    DB::table('notifications')
        ->where('contract_id', $id)
        //->where('role','Transport Officer-CPTU')
        ->update(['flag' => '0']);

    $form=carContract::find($id);
    $form->delete();
     return redirect()->route('contracts_management')->with('success', 'Application Deleted Successfully');
}

public function fetchclient_details(Request $request){
  if($request->get('query')){
      $query = $request->get('query');
      $data = carContract::select('first_name', 'last_name')->where('first_name', 'LIKE', "%{$query}%")->distinct()->get();
      if(count($data)!=0){
      $output = '<ul class="dropdown-menu form-card" style="display: block;
    width: 100%; margin-left: 0%; position:absolute;margin-top: -8%;">';
      foreach($data as $row)
      {
       $output .= '
       <li id="list" style="margin-left: -3%;">'.$row->first_name. " ".$row->last_name.'</li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
     else{
      echo "0";
     }

   }
}

public function fetchallclient_details(Request $request){
  //if($request->get('name')){
    $names = $request->get('name');
    $details= carContract::where('first_name', $request->get('first'))->where('last_name', $request->get('last'))->distinct()->first();
    //dd($names);
    //dd($details);
    return response()->json(['first'=>$details->first_name, 'last'=>$details->last_name, 'email'=>$details->email, 'centre'=>$details->cost_centre, 'dep'=>$details->faculty, 'designation'=>$details->designation]);


//return $names;

}

public function renewContractForm($id){
  $contract=carContract::select('clients.type','clients.first_name','clients.last_name', 'clients.address','clients.email', 'clients.phone_number', 'clients.client_id', 'car_contracts.vehicle_reg_no', 'car_contracts.start_date', 'car_contracts.end_date', 'car_contracts.amount', 'car_contracts.rate', 'car_contracts.fullName', 'car_contracts.id', 'car_rentals.vehicle_model', 'car_rentals.vehicle_status', 'car_rentals.hire_rate', 'car_contracts.special_condition', 'car_contracts.id','car_contracts.currency')
        ->join('clients', 'clients.full_name', '=', 'car_contracts.fullName')
        ->join('car_rentals', 'car_rentals.vehicle_reg_no', '=', 'car_contracts.vehicle_reg_no')
        ->where('clients.contract', 'Car Rental')
        ->where('car_contracts.id',$id)
        ->first();
        return view('renewCarrentalform')->with('contract',$contract);
}
public function printContractForm(){
    $pdf=PDF::loadView('carcontractspdf');
    return $pdf->stream('Vehicle Requistion Form.pdf');
}

public function logsheetindex(Request $request){
    $contract=carContract::find($request->get('contract_id'));

    if(is_null($contract)){
       return redirect()->back()->with('errors', 'The specified contract not found.');
    }
    else{
        $details = carContract::select('vehicle_reg_no','driver_name','fullName','faculty','id','area_of_travel')->where('id',$request->get('contract_id'))->first();
        $model = carRental::select('vehicle_model')->where('vehicle_reg_no',$details->vehicle_reg_no)->value('vehicle_model');
     return view('logsheet', compact('details','model'));
    }

}

public function addlogsheet(Request $request){
    $totalrows=$request->get('totalrows');
        $j=2;

        for($i=0; $i<$totalrows; $i++){
            $date=$request->get('date'.$j);
                $j++;
            $start_time = $request->get('start_time'.$j);
                $j++;
            $mileage_out = $request->get('mileage_out'.$j);
                $j++;
            $closing_time = $request->get('time_closing'.$j);
                $j++;
            $mileage_in = $request->get('mileage_in'.$j);
                $j++;
            $mileage = $request->get('mileage'.$j);
                $j++;
            $standing_hrs = $request->get('standing_hrs'.$j);
                $j++;
            $standing_km = $request->get('standing_km'.$j);
                $j = $j+2;

                $logSheet= new log_sheet();
                $logSheet->date=$date;
                $logSheet->start_time=$start_time;
                $logSheet->mileage_out=$mileage_out;
                $logSheet->closing_time=$closing_time;
                $logSheet->mileage_in=$mileage_in;
                $logSheet->mileage=$mileage;
                $logSheet->standing_hrs=$standing_hrs;
                $logSheet->standing_km=$standing_km;
                $logSheet->contract_id=$request->get('contract_id');
                $logSheet->save();




        }



    return redirect()->route('contracts_management_car_rental')->with('success', 'Details Added Successfully');
}

public function logsheet_view_more($id){
    $logsheets = DB::table('log_sheets')->where('contract_id',$id)->get();
    $area = DB::table('car_contracts')->select('area_of_travel')->where('id', $id)->value('area_of_travel');
     $details = carContract::select('fullName','destination','start_date','end_date')->where('id',$id)->first();
    return View('logsheet_view_more',compact('logsheets','area','details'));
}

public function editlogsheet(Request $request){
    $sheet= log_sheet::where('id',$request->get('log_id'))->first();
    $sheet->date = $request->get('date');
    $sheet->start_time = $request->get('start_time');
    $sheet->mileage_out = $request->get('mileage_out');
    $sheet->closing_time = $request->get('closing_time');
    $sheet->mileage_in = $request->get('mileage_in');
    $sheet->mileage = $request->get('mileage');
    $sheet->standing_hrs = $request->get('standing_hrs');
    $sheet->standing_km = $request->get('standing_km');
    $sheet->save();
    return redirect()->back()->with('success', 'Details Edited Successfully');
}

public function deletelogsheet($id){
    $sheet=log_sheet::find($id);
    $sheet->delete();
    return redirect()->back()->with('success', 'Details Deleted Successfully');

}

}
