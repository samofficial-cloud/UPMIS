<?php

namespace App\Http\Controllers;

use App\cost_centre;
use App\hire_rate;
use Illuminate\Http\Request;
use PDF;
use App\carRental;
use App\carContract;
use App\operational_expenditure;
use DB;
use App\space_contract;
use App\insurance_contract;
use App\insurance;
use App\space;
Use App\User;
use Hash;
use Auth;


class HomeController extends Controller
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
    public function index()
    {
        return view('index');
    }


    public function businesses()
    {
        $spaces=DB::table('spaces')->where('status',1)->get();
        $insurance=DB::table('insurance')->where('status',1)->get();
        $cars=carRental::where('flag','1')->orderBy('vehicle_status','dsc')->get();
        $operational=operational_expenditure::where('flag','1')->get();
        $rate=hire_rate::where('flag','1')->orderBy('vehicle_model','asc')->get();
        $costcentres=cost_centre::orderBy('costcentre_id','asc')->get();

        return view('businesses')->with('spaces',$spaces)->with('insurance',$insurance)->with('cars',$cars)->with('operational',$operational)->with('rate',$rate)->with('costcentres',$costcentres);
    }


    public function report()
    {

        return view('reports');
    }

    public function tenancyreport(){


    $invoice=[];
    $contract_id=[];

  if(($_GET['b_fil']=='true') && ($_GET['l_fil']=='true')){
    
     $details=DB::table('invoices')
        ->select('debtor_name','invoices.contract_id','space_id_contract','currency','escalation_rate','start_date','end_date')
        ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
        ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
        ->where('spaces.major_industry',$_GET['b_type'])
        ->where('spaces.location',$_GET['loc'])
        ->whereYear('invoicing_period_start_date',$_GET['year'])
        ->distinct()->orderBy('invoices.contract_id')
        ->get();
  }

  elseif(($_GET['b_fil']=='true') && ($_GET['l_fil']!='true')){
     $details=DB::table('invoices')
        ->select('debtor_name','invoices.contract_id','space_id_contract','currency','escalation_rate','start_date','end_date')
        ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
        ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
        ->where('spaces.major_industry',$_GET['b_type'])
        ->whereYear('invoicing_period_start_date',$_GET['year'])
        ->distinct()->orderBy('invoices.contract_id')
        ->get();
  }

  elseif(($_GET['b_fil']!='true') && ($_GET['l_fil']=='true')){
     $details=DB::table('invoices')
        ->select('debtor_name','invoices.contract_id','space_id_contract','currency','escalation_rate','start_date','end_date')
        ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
        ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
        ->where('spaces.location',$_GET['loc'])
        ->whereYear('invoicing_period_start_date',$_GET['year'])
        ->distinct()->orderBy('invoices.contract_id')
        ->get();
  }

  elseif(($_GET['b_fil']!='true') && ($_GET['l_fil']!='true')){
     $details=DB::table('invoices')
        ->select('debtor_name','invoices.contract_id','space_id_contract','currency','escalation_rate','start_date','end_date')
        ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
        ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
        ->whereYear('invoicing_period_start_date',$_GET['year'])
        ->distinct()->orderBy('invoices.contract_id')
        ->get();
  }

    $x1= $_GET['start'];
    $x2= $_GET['duration'];
    if($x2>5){
     $x2=5;
    }
    $x3=$x1+$x2-1;
    $k=0;

    foreach($details as $detail){
      $k =$k+1;
        $contract_id= array();
        $invoice= array();
        $contract_id[] = DB::table('invoices')
                ->select('contract_id')
                ->where('contract_id',$detail->contract_id)
                ->distinct()->pluck('contract_id')
                ->toArray();

        foreach($contract_id[0] as $id){

              for ($days_backwards = $x1; $days_backwards <= $x3; $days_backwards++) {

              $invoice[] = DB::table('space_payments')
                    ->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
                    ->select('amount_paid')
                    ->where('contract_id',$id)
                    ->whereMonth('invoicing_period_start_date',$days_backwards)
                    ->whereYear('invoicing_period_start_date',$_GET['year'])
                    ->where('payment_status','!=','Not Paid')
                    ->pluck('amount_paid')
                    ->toArray();
              }

          }
    }
      if(count($invoice)==0){
         return redirect()->back()->with('errors', "No data found to generate the requested report");
      }
      else{

        return View('tenancyschedule_new',compact('details'));
        // $pdf = PDF::loadView('tenancyschedule',['details'=>$details])->setPaper('a4', 'landscape');
  
        // return $pdf->stream('Tenancy Schedule.pdf');

      }

    }

    public function spacereport1(){

         return view('reports');
    }

    public function editprofile(){

         return view('edit_profile');
    }

    public function viewprofile(){

         return view('view_profile');
    }

    public function changepassword(){

         return view('change_password');
    }

    public function changepasswordlogin(){
       return view('change_password_first_login');
    }



     public function editprofiledetails(Request $request){

    $users = User::where('id',$request->get('user_id'))->first();
    $users->email = $request->get('email');
    $users->phone_number = $request->get('phoneNumber');
    $users->save();
    return redirect()->route('viewprofile')
                    ->with('success', 'Profile Details Updated Successfully');
    }

    public function changepassworddetails(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        else{
           $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");
        }

    }


    public function changepassworddetailslogin(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("errorz","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("errorz","New Password cannot be same as your current password. Please choose a different password.");
        }

        else{
           $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->password_flag=1;
        $user->save();
        $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
        if($category=='All'){
           return redirect()->route('home')->with("success","Password changed successfully !");
          }

          elseif($category=='Insurance only'){
             return redirect()->route('home2')->with("success","Password changed successfully !");
          }

          elseif($category=='Real Estate only'){
            return redirect()->route('home4')->with("success","Password changed successfully !");
          }

          if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre')){
            return redirect()->route('home3')->with("success","Password changed successfully !");
          }

          if(($category=='CPTU only') && (Auth::user()->role=='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre')){
            return redirect()->route('home5')->with("success","Password changed successfully !");
          }

          if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role=='Accountant-Cost Centre')){
            return redirect()->route('home5')->with("success","Password changed successfully !");
          }

        }

    }

    public function debtsummaryPDF(){
      $contract_id = [];
      if($_GET['b_type']=='Space'){
        if($_GET['criteria']=='space'){
          if($_GET['show']=='clients'){
            if(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true')){
              $contract_id[]= DB::table('invoices')
                            ->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->join('space_payments','invoices.invoice_number','=','space_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            ->where('major_industry',$_GET['biz'])
                            ->where('location',$_GET['loc'])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

            elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true')){
              $contract_id[]= DB::table('invoices')
                            ->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('major_industry',$_GET['biz'])
                            ->where('location',$_GET['loc'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

            elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true')){
              $contract_id[]= DB::table('invoices')
                            ->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->join('space_payments','invoices.invoice_number','=','space_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            ->where('major_industry',$_GET['biz'])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

            elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true')){
              $contract_id[]= DB::table('invoices')
                            ->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('major_industry',$_GET['biz'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

            elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true')){
               $contract_id[]= DB::table('invoices')
                            ->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->join('space_payments','invoices.invoice_number','=','space_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            ->where('location',$_GET['loc'])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

             elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true')){
              $contract_id[]= DB::table('invoices')
                            ->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('location',$_GET['loc'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
             }

             elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true')){
              $contract_id[]= DB::table('invoices')
                            ->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                             ->join('space_payments','invoices.invoice_number','=','space_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
             }

             elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true')){
                $contract_id[]= DB::table('invoices')
                            ->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
             }
          }
          elseif($_GET['show']=='industry'){
            return View('debtsummaryreport2_new');
            //  $pdf = PDF::loadView('debtsummaryreport2pdf');
            // return $pdf->stream('Debt Summary.pdf');
          }
        }
        elseif($_GET['criteria']=='electricity'){
          if($_GET['show']=='clients'){

            if(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true')){
              $contract_id[]= DB::table('electricity_bill_invoices')
                            ->select('electricity_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                             ->join('electricity_bill_payments','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            ->where('major_industry',$_GET['biz'])
                            ->where('location',$_GET['loc'])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }
            elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true')){
              $contract_id[]= DB::table('electricity_bill_invoices')
                            ->select('electricity_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('major_industry',$_GET['biz'])
                            ->where('location',$_GET['loc'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }
            elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true')){
              $contract_id[]= DB::table('electricity_bill_invoices')
                            ->select('electricity_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                             ->join('electricity_bill_payments','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            ->where('major_industry',$_GET['biz'])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

            elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true')){
              $contract_id[]= DB::table('electricity_bill_invoices')
                            ->select('electricity_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('major_industry',$_GET['biz'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

            elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true')){
               $contract_id[]= DB::table('electricity_bill_invoices')
                            ->select('electricity_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                             ->join('electricity_bill_payments','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            ->where('location',$_GET['loc'])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

            elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true')){
              $contract_id[]= DB::table('electricity_bill_invoices')
                            ->select('electricity_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('location',$_GET['loc'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
             }

             elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true')){
              $contract_id[]= DB::table('electricity_bill_invoices')
                            ->select('electricity_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->join('electricity_bill_payments','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
             }

             elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true')){
                $contract_id[]= DB::table('electricity_bill_invoices')
                            ->select('electricity_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
             }

          }
          elseif($_GET['show']=='industry'){
            $pdf = PDF::loadView('debtsummaryreport2pdf');
            return $pdf->stream('Debt Summary.pdf');
          }
        }
        elseif($_GET['criteria']=='water'){
          if($_GET['show']=='clients'){
            if(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true')){
              $contract_id[]= DB::table('water_bill_invoices')
                            ->select('water_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->join('water_bill_payments','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            ->where('major_industry',$_GET['biz'])
                            ->where('location',$_GET['loc'])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }
            elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true')){
              $contract_id[]= DB::table('water_bill_invoices')
                            ->select('water_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('major_industry',$_GET['biz'])
                            ->where('location',$_GET['loc'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }
            elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true')){
              $contract_id[]= DB::table('water_bill_invoices')
                            ->select('water_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->join('water_bill_payments','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            ->where('major_industry',$_GET['biz'])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

            elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true')){
              $contract_id[]= DB::table('water_bill_invoices')
                            ->select('water_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('major_industry',$_GET['biz'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

            elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true')){
               $contract_id[]= DB::table('water_bill_invoices')
                            ->select('water_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('location',$_GET['loc'])
                            ->join('water_bill_payments','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
            }

            elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true')){
              $contract_id[]= DB::table('water_bill_invoices')
                            ->select('water_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('location',$_GET['loc'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
             }

             elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true')){
              $contract_id[]= DB::table('water_bill_invoices')
                            ->select('water_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->join('water_bill_payments','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
             }

             elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true')){
                $contract_id[]= DB::table('water_bill_invoices')
                            ->select('water_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
             }

          }
          elseif($_GET['show']=='industry'){
            $pdf = PDF::loadView('debtsummaryreport2pdf');
            return $pdf->stream('Debt Summary.pdf');
          }
        }
      }
      elseif($_GET['b_type']=='Insurance'){
        if($_GET['yr2_fil']=='true'){
           $contract_id[]= DB::table('insurance_invoices')
                              ->join('insurance_payments','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
                              ->select('debtor_name','currency_invoice')
                              ->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr2'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
        }
        else{
          $contract_id[]= DB::table('insurance_invoices')
                            ->select('debtor_name','currency_invoice')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
        }

      }
      elseif($_GET['b_type']=='Car Rental'){
        if($_GET['yr2_fil']=='true'){
           $contract_id[]= DB::table('car_rental_invoices')
                            ->select('car_rental_invoices.contract_id','debtor_name','cost_centre','destination')
                            ->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')
                             ->join('car_rental_payments','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
                            // ->whereYear('invoicing_period_start_date',$_GET['yr2'])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
        }
        else{
           $contract_id[]= DB::table('car_rental_invoices')
                            ->select('car_rental_invoices.contract_id','debtor_name','cost_centre','destination')
                            ->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();
        }

      }
      elseif($_GET['b_type']=='All'){
        if($_GET['yr2_fil']=='true'){
        $contract_id[]= DB::table('invoices')
                            ->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->join('space_payments','invoices.invoice_number','=','space_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();

        $contract_id2[]= DB::table('water_bill_invoices')
                            ->select('water_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->join('water_bill_payments','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
                            ->where('has_water_bill','Yes')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();

        $contract_id3[]= DB::table('electricity_bill_invoices')
                            ->select('electricity_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->join('electricity_bill_payments','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
                            ->where('has_electricity_bill','Yes')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();

        $contract_id4[]= DB::table('car_rental_invoices')
                            ->select('car_rental_invoices.contract_id','debtor_name','cost_centre','destination')
                            ->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')
                            ->join('car_rental_payments','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
                            ->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();


        $contract_id5[]= DB::table('insurance_invoices')
                            ->join('insurance_payments','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
                            ->select('debtor_name','currency_invoice')
                            ->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();

          }
          else{
            $contract_id[]= DB::table('invoices')
                            ->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();

        $contract_id2[]= DB::table('water_bill_invoices')
                            ->select('water_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('has_water_bill','Yes')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();

        $contract_id3[]= DB::table('electricity_bill_invoices')
                            ->select('electricity_bill_invoices.contract_id','debtor_name','major_industry','sub_location','currency')
                            ->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')
                            ->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
                            ->where('has_electricity_bill','Yes')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();

        $contract_id4[]= DB::table('car_rental_invoices')
                            ->select('car_rental_invoices.contract_id','debtor_name','cost_centre','destination')
                            ->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();


        $contract_id5[]= DB::table('insurance_invoices')
                            ->select('debtor_name','currency_invoice')
                            ->orderBy('debtor_name','asc')
                            ->distinct()
                            ->get();

          }
      }

      if($_GET['b_type']=='Insurance'){
         //$pdf = PDF::loadView('debtsummaryreportpdf',['contract_id'=>$contract_id]);
        return View('debtsummaryreport_new',compact('contract_id'));
      }
      elseif($_GET['b_type']=='All'){
        $pdf = PDF::loadView('debtsummaryreportpdf',['contract_id'=>$contract_id, 'contract_id2'=>$contract_id2, 'contract_id3'=>$contract_id3, 'contract_id4'=>$contract_id4, 'contract_id5'=>$contract_id5])->setPaper('a4', 'landscape');
        return $pdf->stream('Debt Summary.pdf');
         // return View('debtsummaryreport_new',compact('contract_id','contract_id2', 'contract_id3','contract_id4','contract_id5'));
      }
      else{

         return View('debtsummaryreport_new',compact('contract_id'));
       // $pdf = PDF::loadView('debtsummaryreportpdf',['contract_id'=>$contract_id])->setPaper('a4', 'landscape'); 
      }
      
  

    }

    public function spacereport1PDF(){
      $today= date('Y-m-d');
      if($_GET['module']=='space'){
        if($_GET['major_industry']=='list'){
            if(($_GET['space_prize']=='true') && ($_GET['status']=='true') && ($_GET['location_status']=='true') && ($_GET['ind_fil']=='true')){
                if($_GET['space_status']=='1'){
                $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry','minor_industry','rent_price_guide_currency')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])->whereDate('end_date', '>=', $today)->where('location',$_GET['location'])->where('major_industry',$_GET['ind'])->orderby('space_id','asc')->distinct()->get();
                }

                elseif($_GET['space_status']=='0'){
                  $spaces= DB::table('spaces')
                  ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
                  ->where('status','1')
                  ->where('location',$_GET['location'])
                  ->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])
                  ->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])
                  ->where('major_industry',$_GET['ind'])
                  ->orderBy('space_id','asc')
                  ->get();
                }
            }

            elseif(($_GET['space_prize']=='true') && ($_GET['status']=='true') && ($_GET['location_status']=='true') && ($_GET['ind_fil']!='true')){
              if($_GET['space_status']=='1'){
                $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry','minor_industry','rent_price_guide_currency')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])->whereDate('end_date', '>=', $today)->where('location',$_GET['location'])->orderby('space_id','asc')->distinct()->get();
                }

                elseif($_GET['space_status']=='0'){
                  $spaces= DB::table('spaces')
                  ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
                  ->where('status','1')
                  ->where('location',$_GET['location'])
                  ->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])
                  ->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])
                  ->orderBy('space_id','asc')
                  ->get();
                }
            }

            elseif(($_GET['space_prize']=='true') && ($_GET['status']=='true') && ($_GET['location_status']!='true') && ($_GET['ind_fil']=='true')){
              if($_GET['space_status']=='1'){
                $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry','minor_industry','rent_price_guide_currency')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])->whereDate('end_date', '>=', $today)->where('major_industry',$_GET['ind'])->orderby('space_id','asc')->distinct()->get();

                }

                elseif($_GET['space_status']=='0'){
                $spaces= DB::table('spaces')
                ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
                ->where('status','1')
                ->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])
                ->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])
                ->where('major_industry',$_GET['ind'])
                ->orderBy('space_id','asc')
                ->get();
                }
            }

            elseif(($_GET['space_prize']=='true') && ($_GET['status']=='true') && ($_GET['location_status']!='true') && ($_GET['ind_fil']!='true')){
                $spaces=space::where('rent_price_guide_from','>=',$_GET['min_price'])->where('rent_price_guide_to','<=',$_GET['max_price'])->where('status','1')->where('location',$_GET['location'])->orderby('space_id','asc')->get();
            }


            elseif(($_GET['space_prize']=='true') && ($_GET['status']!='true') && ($_GET['location_status']=='true') && ($_GET['ind_fil']=='true')){
                if($_GET['space_status']=='1'){
                $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry','minor_industry','rent_price_guide_currency')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])->whereDate('end_date', '>=', $today)->where('major_industry',$_GET['ind'])->orderby('space_id','asc')->distinct()->get();

                }
                elseif($_GET['space_status']=='0'){
                  $spaces= DB::table('spaces')
                  ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
                  ->where('status','1')
                  ->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])
                  ->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])
                  ->where('major_industry',$_GET['ind'])
                  ->orderBy('space_id','asc')
                  ->get();
                }
            }


            elseif(($_GET['space_prize']=='true') && ($_GET['status']!='true') && ($_GET['location_status']=='true') && ($_GET['ind_fil']!='true')){
              if($_GET['space_status']=='1'){
              $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry','minor_industry','rent_price_guide_currency')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])->whereDate('end_date', '>=', $today)->orderby('space_id','asc')->distinct()->get();

              }
              elseif($_GET['space_status']=='0'){
               $spaces= DB::table('spaces')
                ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
                ->where('status','1')
                ->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])
                ->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])
                ->orderBy('space_id','asc')
                 ->get();
            }
          }


          elseif(($_GET['space_prize']=='true') && ($_GET['status']!='true') && ($_GET['location_status']!='true') && ($_GET['ind_fil']=='true')){
             $spaces=space::where('status','1')
             ->where('rent_price_guide_from','>=',$_GET['min_price'])
             ->where('rent_price_guide_to','<=',$_GET['max_price'])
             ->where('major_industry',$_GET['ind'])
             ->orderBy('space_id','asc')->get();
          }


          elseif(($_GET['space_prize']=='true') && ($_GET['status']!='true') && ($_GET['location_status']!='true') && ($_GET['ind_fil']!='true')){
            $spaces=space::where('status','1')
            ->where('rent_price_guide_from','>=',$_GET['min_price'])
            ->where('rent_price_guide_to','<=',$_GET['max_price'])
            ->orderBy('space_id','asc')
            ->get();
          }


          elseif(($_GET['space_prize']!='true') && ($_GET['status']=='true') && ($_GET['location_status']=='true') && ($_GET['ind_fil']=='true')){
            if($_GET['space_status']=='1'){
              $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry','minor_industry','rent_price_guide_currency')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->whereDate('end_date', '>=', $today)->where('location',$_GET['location'])->where('major_industry',$_GET['ind'])->orderby('space_id','asc')->distinct()->get();
            }

            elseif($_GET['space_status']=='0'){
             $spaces= DB::table('spaces')
              ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
              ->where('status','1')
              ->where('location',$_GET['location'])
              ->where('major_industry',$_GET['ind'])
              ->orderBy('space_id','asc')
              ->get();
            }
          }

          elseif(($_GET['space_prize']!='true') && ($_GET['status']=='true') && ($_GET['location_status']=='true') && ($_GET['ind_fil']!='true')){
            if($_GET['space_status']=='1'){
              $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry','minor_industry','rent_price_guide_currency')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->whereDate('end_date', '>=', $today)->where('location',$_GET['location'])->orderby('space_id','asc')->distinct()->get();
            }

            elseif($_GET['space_status']=='0'){
              $spaces= DB::table('spaces')
              ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
              ->where('status','1')
              ->where('location',$_GET['location'])
              ->orderBy('space_id','asc')
              ->get();
            }
           }


          elseif(($_GET['space_prize']!='true') && ($_GET['status']=='true') && ($_GET['location_status']!='true') && ($_GET['ind_fil']=='true')){
            if($_GET['space_status']=='1'){
              $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry','minor_industry','rent_price_guide_currency')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->whereDate('end_date', '>=', $today)->where('major_industry',$_GET['ind'])->orderby('space_id','asc')->distinct()->get();
            }

            elseif($_GET['space_status']=='0'){
              $spaces= DB::table('spaces')
              ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
              ->where('status','1')
              ->where('major_industry',$_GET['ind'])
              ->orderBy('space_id','asc')
              ->get();
            }
          }

          elseif(($_GET['space_prize']!='true') && ($_GET['status']=='true') && ($_GET['location_status']!='true') && ($_GET['ind_fil']!='true')){
            if($_GET['space_status']=='1'){
              $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry','minor_industry','rent_price_guide_currency')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->whereDate('end_date', '>=', $today)->orderby('space_id','asc')->distinct()->get();
            }

            elseif($_GET['space_status']=='0'){
              $spaces= DB::table('spaces')
              ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
              ->where('status','1')
              ->orderBy('space_id','asc')
              ->get();
            }
          }

          elseif(($_GET['space_prize']!='true') && ($_GET['status']!='true') && ($_GET['location_status']=='true') && ($_GET['ind_fil']=='true')){
            $spaces=space::where('status','1')->where('location',$_GET['location'])->where('major_industry',$_GET['ind'])->orderBy('space_id','asc')->get();
          }

          elseif(($_GET['space_prize']!='true') && ($_GET['status']!='true') && ($_GET['location_status']=='true') && ($_GET['ind_fil']!='true')){
           $spaces=space::where('status','1')->where('location',$_GET['location'])->orderBy('space_id','asc')->get();
          }



          elseif(($_GET['space_prize']!='true') && ($_GET['status']!='true') && ($_GET['location_status']!='true') && ($_GET['ind_fil']=='true')){
            $spaces=space::where('status','1')->where('major_industry',$_GET['ind'])->orderBy('space_id','asc')->get();
          }


          elseif(($_GET['space_prize']!='true') && ($_GET['status']!='true') && ($_GET['location_status']!='true') && ($_GET['ind_fil']!='true')){
             $spaces=space::where('status','1')->orderBy('space_id','asc')->get();
          }

        }
      }
      if(count($spaces)==0){
         return redirect()->back()->with('errors', "No data found to generate the requested report");
      }
      else{


        return View('spacereport1_new', compact('spaces'));
        // $pdf = PDF::loadView('spacereport1pdf',['spaces'=>$spaces])->setPaper('a4', 'landscape');
  
        // return $pdf->stream('List of Spaces.pdf');

      }


      }

      public function spacereport2PDF(){
       $details=space::where('space_id',$_GET['space_id'])->get();
       $from=date('Y-m-d',strtotime($_GET['start_date']));
$to=date('Y-m-d',strtotime($_GET['end_date']));
  if($_GET['filter_date']=='true'){
      $space=space_contract::join('spaces', 'spaces.space_id', '=', 'space_contracts.space_id_contract')
      ->where('space_contracts.space_id_contract',$_GET['space_id'])->wherebetween('space_contracts.start_date',[ $from ,$to ])
      ->orwherebetween('space_contracts.end_date',[ $from ,$to ])->where('space_contracts.space_id_contract',$_GET['space_id'])
      ->get();

      $invoices=space_contract::join('invoices', 'invoices.contract_id', '=', 'space_contracts.contract_id')
      ->join('space_payments', 'space_payments.invoice_number', '=', 'invoices.invoice_number')
      ->where('space_contracts.space_id_contract',$_GET['space_id'])
      ->wherebetween('space_contracts.start_date',[ $from ,$to ])->where('invoices.payment_status','!=','Paid')
      ->orwherebetween('space_contracts.end_date',[ $from ,$to ])->where('invoices.payment_status','!=','Paid')
      ->where('space_contracts.space_id_contract',$_GET['space_id'])
      ->get();
  }
  else{
     $space=space_contract::join('spaces', 'spaces.space_id', '=', 'space_contracts.space_id_contract')->where('space_contracts.space_id_contract',$_GET['space_id'])->get();

     $invoices=space_contract::join('invoices', 'invoices.contract_id', '=', 'space_contracts.contract_id')
      ->join('space_payments', 'space_payments.invoice_number', '=', 'invoices.invoice_number')
      ->where('space_contracts.space_id_contract',$_GET['space_id'])
      ->where('invoices.payment_status','!=','Paid')
      ->get();
  }
  if((count($space)==0) && (count($invoices)==0)){
   return redirect()->back()->with('errors', "No data found to generate the requested report");
  }
  else{


     // $pdf = PDF::loadView('spacereport2pdf',['details'=>$details, 'space'=>$space,'invoices'=>$invoices])->setPaper('a4', 'landscape');
  
     //    return $pdf->stream('Spaces History.pdf');

    return View('spacereport2_new', compact('details','space','invoices'));

  }

      }

      public function systemreportPDF(){
        if($_GET['report_type']=='user'){
          if($_GET['st_fil']=='true'){
            if($_GET['user']=='active'){
              $users=DB::table('users')->where('status',1)->orderBy('first_name','asc')->get();
            }
            elseif($_GET['user']=='inactive'){
              $users=DB::table('users')->where('status',0)->orderBy('first_name','asc')->get();
            }

          }
          else{
            $users=DB::table('users')->orderBy('first_name','asc')->get();
          }
        }
        if(count($users)==0){
           return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
        else{

          return View('userreport_new',compact('users'));
           // $pdf = PDF::loadView('userreportpdf',['users'=>$users])->setPaper('a4', 'landscape');
  
           //  return $pdf->stream('System User Report.pdf');

        }
      }

      public function insurancereportPDF(){
       if($_GET['report_type']=='sales'){
        if(($_GET['principal_filter']=='true') && ($_GET['package_filter']=='true')&&($_GET['yr_fil']=='true')){
          if($_GET['insurance_typefilter']=='true'){
            if($_GET['yr_cat']=='start'){
               $insurance=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->whereYear('commission_date',$_GET['yr'])->get();
            }
            elseif($_GET['yr_cat']=='end'){
              $insurance=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->whereYear('end_date',$_GET['yr'])->get();
            }
          }
          else{
            if($_GET['yr_cat']=='start'){
            $insurance=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->whereYear('commission_date',$_GET['yr'])->get();
          }
          elseif($_GET['yr_cat']=='end'){
            $insurance=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->whereYear('end_date',$_GET['yr'])->get();
          }
          }
        }

        elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']=='true') && ($_GET['yr_fil']!='true')){
          if($_GET['insurance_typefilter']=='true'){
             $insurance=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->get();
          }
          else{
            $insurance=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->get();
          }

        }

        elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']!='true') && ($_GET['yr_fil']=='true')){
            if($_GET['yr_cat']=='start'){
               $insurance=insurance_contract::where('principal',$_GET['principaltype'])->whereYear('commission_date',$_GET['yr'])->get();
            }
            elseif($_GET['yr_cat']=='end'){
              $insurance=insurance_contract::where('principal',$_GET['principaltype'])->whereYear('end_date',$_GET['yr'])->get();
            }

        }

        elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']!='true') && ($_GET['yr_fil']!='true')){
           $insurance=insurance_contract::where('principal',$_GET['principaltype'])->get();
        }

        elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']=='true') && ($_GET['yr_fil']=='true')){
          if($_GET['insurance_typefilter']=='true'){
            if($_GET['yr_cat']=='start'){
               $insurance=insurance_contract::where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->whereYear('commission_date',$_GET['yr'])->get();
            }
            elseif($_GET['yr_cat']=='end'){
              $insurance=insurance_contract::where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->whereYear('end_date',$_GET['yr'])->get();
            }
          }
          else{
            if($_GET['yr_cat']=='start'){
            $insurance=insurance_contract::where('insurance_class',$_GET['package'])->whereYear('commission_date',$_GET['yr'])->get();
          }
          elseif($_GET['yr_cat']=='end'){
            $insurance=insurance_contract::where('insurance_class',$_GET['package'])->whereYear('end_date',$_GET['yr'])->get();
          }
          }
        }


        elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']=='true') && ($_GET['yr_fil']!='true')){
          if($_GET['insurance_typefilter']=='true'){
               $insurance=insurance_contract::where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->get();
            }

          else{
            $insurance=insurance_contract::where('insurance_class',$_GET['package'])->get();
          }
        }

         elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']!='true') && ($_GET['yr_fil']=='true')){
          if($_GET['yr_cat']=='start'){
               $insurance=insurance_contract::whereYear('commission_date',$_GET['yr'])->get();
            }
            elseif($_GET['yr_cat']=='end'){
              $insurance=insurance_contract::whereYear('end_date',$_GET['yr'])->get();
            }

         }

      elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']!='true') &&($_GET['yr_fil']!='true')){
        $insurance=insurance_contract::get();
      }

      if(count($insurance)==0){
        return redirect()->back()->with('errors', "No data found to generate the requested report");
      }
      else{
        return View('insurancereport_new',compact('insurance'));
        // $pdf = PDF::loadView('insurancereportpdf',['insurance'=>$insurance])->setPaper('a4', 'landscape');
      }

      }

      else if($_GET['report_type']=='principals'){
      $principal=insurance::where('status','1')->orderBy('insurance_company','asc')->get();
      if(count($principal)==0){
        return redirect()->back()->with('errors', "No data found to generate the requested report");
      }
      else{
        return View('insurancereport_new',compact('principal'));
        //$pdf = PDF::loadView('insurancereportpdf',['principal'=>$principal]);
      }
    }

     else if($_GET['report_type']=='clients'){
        if(($_GET['principal_filter']=='true') && ($_GET['package_filter']=='true')&&($_GET['yr_fil']=='true')){
          if($_GET['insurance_typefilter']=='true'){
            if($_GET['yr_cat']=='start'){
               $clients=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->whereYear('commission_date',$_GET['yr'])->get();
            }
            elseif($_GET['yr_cat']=='end'){
              $clients=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->whereYear('end_date',$_GET['yr'])->get();
            }
          }
          else{
            if($_GET['yr_cat']=='start'){
            $clients=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->whereYear('commission_date',$_GET['yr'])->get();
          }
          elseif($_GET['yr_cat']=='end'){
            $clients=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->whereYear('end_date',$_GET['yr'])->get();
          }
          }
        }

        elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']=='true') && ($_GET['yr_fil']!='true')){
          if($_GET['insurance_typefilter']=='true'){
             $clients=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->get();
          }
          else{
            $clients=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_class',$_GET['package'])->get();
          }

        }

        elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']!='true') && ($_GET['yr_fil']=='true')){
            if($_GET['yr_cat']=='start'){
               $clients=insurance_contract::where('principal',$_GET['principaltype'])->whereYear('commission_date',$_GET['yr'])->get();
            }
            elseif($_GET['yr_cat']=='end'){
              $clients=insurance_contract::where('principal',$_GET['principaltype'])->whereYear('end_date',$_GET['yr'])->get();
            }

        }

        elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']!='true') && ($_GET['yr_fil']!='true')){
           $clients=insurance_contract::where('principal',$_GET['principaltype'])->get();
        }

        elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']=='true') && ($_GET['yr_fil']=='true')){
          if($_GET['insurance_typefilter']=='true'){
            if($_GET['yr_cat']=='start'){
               $clients=insurance_contract::where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->whereYear('commission_date',$_GET['yr'])->get();
            }
            elseif($_GET['yr_cat']=='end'){
              $clients=insurance_contract::where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->whereYear('end_date',$_GET['yr'])->get();
            }
          }
          else{
            if($_GET['yr_cat']=='start'){
            $clients=insurance_contract::where('insurance_class',$_GET['package'])->whereYear('commission_date',$_GET['yr'])->get();
          }
          elseif($_GET['yr_cat']=='end'){
            $clients=insurance_contract::where('insurance_class',$_GET['package'])->whereYear('end_date',$_GET['yr'])->get();
          }
          }
        }


        elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']=='true') && ($_GET['yr_fil']!='true')){
          if($_GET['insurance_typefilter']=='true'){
               $clients=insurance_contract::where('insurance_class',$_GET['package'])->where('insurance_type',$_GET['insurance_type'])->get();
            }

          else{
            $clients=insurance_contract::where('insurance_class',$_GET['package'])->get();
          }
        }

         elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']!='true') && ($_GET['yr_fil']=='true')){
          if($_GET['yr_cat']=='start'){
               $clients=insurance_contract::whereYear('commission_date',$_GET['yr'])->get();
            }
            elseif($_GET['yr_cat']=='end'){
              $clients=insurance_contract::whereYear('end_date',$_GET['yr'])->get();
            }

         }

      elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']!='true') &&($_GET['yr_fil']!='true')){
        $clients=insurance_contract::get();
      }
      //******************
      // $clients=insurance_contract::orderBy('commission_date','dsc')->get();
      if(count($clients)==0){
        return redirect()->back()->with('errors', "No data found to generate the requested report");
      }
      else{
        return View('insurancereport_new',compact('clients'));
        // $pdf = PDF::loadView('insurancereportpdf',['clients'=>$clients])->setPaper('a4', 'landscape');
      }
    }

  
        //return $pdf->stream('Insurance Report.pdf');

      }

      public function tenantreportPDF(){
        $today=date('Y-m-d');
        if($_GET['report_type']=='list'){
          if(($_GET['business_filter']=='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']=='true')){
  if($_GET['contract_status']==1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','>=',$today)->where('spaces.major_industry',$_GET['business_type'])->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==0){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','<',$today)->where('spaces.major_industry',$_GET['business_type'])->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==-1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('space_contracts.contract_status',0)->where('spaces.major_industry',$_GET['business_type'])->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }

}
if(($_GET['business_filter']=='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']!='true')){
    if($_GET['contract_status']==1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','>=',$today)->where('spaces.major_industry',$_GET['business_type'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==0){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->whereDate('end_date','<',$today)->where('spaces.major_industry',$_GET['business_type'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==-1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',0)->where('spaces.major_industry',$_GET['business_type'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
}
if(($_GET['business_filter']=='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']=='true')){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('clients.contract','Space')->where('spaces.major_industry',$_GET['business_type'])->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
}
if(($_GET['business_filter']=='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']!='true')){
  $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('clients.contract','Space')->where('spaces.major_industry',$_GET['business_type'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
}
if(($_GET['business_filter']!='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']=='true')){
      if($_GET['contract_status']==1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('clients.contract','Space')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','>=',$today)->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==0){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('clients.contract','Space')->where('space_contracts.contract_status',1)->whereDate('end_date','<',$today)->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==-1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('clients.contract','Space')->where('space_contracts.contract_status',0)->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
}
if(($_GET['business_filter']!='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']!='true')){
if($_GET['contract_status']==1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('clients.contract','Space')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','>=',$today)->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==0){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('clients.contract','Space')->where('space_contracts.contract_status',1)->whereDate('end_date','<',$today)->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==-1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('clients.contract','Space')->where('space_contracts.contract_status',0)->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
}
if(($_GET['business_filter']!='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']=='true')){
  $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('clients.contract','Space')->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
}
if(($_GET['business_filter']!='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']!='true')){
  $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('clients.contract','Space')->orderBy('space_contracts.full_name','asc')->distinct()->get();
}
          if(count($tenants)==0){
               return redirect()->back()->with('errors', "No data found to generate the requested report");
          }
          else{
            return View('tenantreport_new',compact('tenants'));
           //   $pdf=PDF::loadView('tenantreportpdf',['tenants'=>$tenants])->setPaper('a4', 'landscape');
           // return $pdf->stream('Tenant Report.pdf');
          }

        }
        elseif($_GET['report_type']=='invoice'){
          if($_GET['payment_filter']=='true'){
    if($_GET['criteria']=='rent'){
     $invoices=DB::table('invoices')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('invoice_date','asc')->get();
    }
    elseif($_GET['criteria']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')->join('electricity_bill_payments','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('invoice_date','asc')->get();
    }
    elseif($_GET['criteria']=='water'){
       $invoices=DB::table('water_bill_invoices')->join('water_bill_payments','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('invoice_date','asc')->get();
    }
  }
  else{
    if($_GET['criteria']=='rent'){
     $invoices=DB::table('invoices')->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('invoice_date','asc')->get();
    }
    elseif($_GET['criteria']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('invoice_date','asc')->get();
    }
    elseif($_GET['criteria']=='water'){
       $invoices=DB::table('water_bill_invoices')->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('invoice_date','asc')->get();
    }
  }
  if(count($invoices)==0){
  return redirect()->back()->with('errors', "No data found to generate the requested report");
  }
  else{
    return View('tenantreport_new',compact('invoices'));
     // $pdf=PDF::loadView('tenantreportpdf',['invoices'=>$invoices])->setPaper('a4', 'landscape');;
     //       return $pdf->stream('Tenant Invoice Report.pdf');
  }

        }

      }

      public function carreportPDF(){
        if($_GET['report_type']=='clients'){

          if($_GET['centre_fil']=='true' && $_GET['cont_fil']=='true' && $_GET['date_fil']=='true' && $_GET['pay_fil']=='true'){
            if($_GET['cont']=='Active'){
            $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                     ->where('payment_status',$_GET['pay'])
                    ->where('cost_centre',$_GET['centre'])
                    ->whereDate('end_date','>=',date('Y-m-d'))
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
            elseif($_GET['cont']=='Inactive'){
              $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                     ->where('payment_status',$_GET['pay'])
                    ->where('cost_centre',$_GET['centre'])
                    ->whereDate('end_date','<',date('Y-m-d'))
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
          }


          elseif($_GET['centre_fil']=='true' && $_GET['cont_fil']=='true' && $_GET['date_fil']=='true' && $_GET['pay_fil']!='true'){
            if($_GET['cont']=='Active'){
            $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->where('cost_centre',$_GET['centre'])
                    ->whereDate('end_date','>=',date('Y-m-d'))
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
            elseif($_GET['cont']=='Inactive'){
              $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->where('cost_centre',$_GET['centre'])
                    ->whereDate('end_date','<',date('Y-m-d'))
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
          }

          elseif($_GET['centre_fil']=='true' && $_GET['cont_fil']=='true' && $_GET['date_fil']!='true' && $_GET['pay_fil']=='true'){
            if($_GET['cont']=='Active'){
            $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                     ->where('payment_status',$_GET['pay'])
                    ->where('cost_centre',$_GET['centre'])
                    ->whereDate('end_date','>=',date('Y-m-d'))
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
            elseif($_GET['cont']=='Inactive'){
              $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                     ->where('payment_status',$_GET['pay'])
                    ->where('cost_centre',$_GET['centre'])
                    ->whereDate('end_date','<',date('Y-m-d'))
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
          }


          elseif($_GET['centre_fil']=='true' && $_GET['cont_fil']=='true' && $_GET['date_fil']!='true' && $_GET['pay_fil']!='true'){
            if($_GET['cont']=='Active'){
            $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->where('cost_centre',$_GET['centre'])
                    ->whereDate('end_date','>=',date('Y-m-d'))
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
            elseif($_GET['cont']=='Inactive'){
              $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->where('cost_centre',$_GET['centre'])
                    ->whereDate('end_date','<',date('Y-m-d'))
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
          }

          elseif($_GET['centre_fil']=='true' && $_GET['cont_fil']!='true' && $_GET['date_fil']=='true' && $_GET['pay_fil']=='true'){

            $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                     ->where('payment_status',$_GET['pay'])
                    ->where('cost_centre',$_GET['centre'])
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
          }


          elseif($_GET['centre_fil']=='true' && $_GET['cont_fil']!='true' && $_GET['date_fil']=='true' && $_GET['pay_fil']!='true'){

            $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->where('cost_centre',$_GET['centre'])
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
          }

          elseif($_GET['centre_fil']=='true' && $_GET['cont_fil']!='true' && $_GET['date_fil']!='true' && $_GET['pay_fil']=='true'){

            $clients = DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                     ->where('payment_status',$_GET['pay'])
                    ->where('cost_centre',$_GET['centre'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();


          }

          elseif($_GET['centre_fil']=='true' && $_GET['cont_fil']!='true' && $_GET['date_fil']!='true' && $_GET['pay_fil']!='true'){

                   $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->where('cost_centre',$_GET['centre'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
          }

          elseif($_GET['centre_fil']!='true' && $_GET['cont_fil']=='true' && $_GET['date_fil']=='true' && $_GET['pay_fil']=='true'){
            if($_GET['cont']=='Active'){
            $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                    ->whereDate('end_date','>=',date('Y-m-d'))
                     ->where('payment_status',$_GET['pay'])
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
            elseif($_GET['cont']=='Inactive'){
              $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                     ->where('payment_status',$_GET['pay'])
                    ->whereDate('end_date','<',date('Y-m-d'))
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
          }

          elseif($_GET['centre_fil']!='true' && $_GET['cont_fil']=='true' && $_GET['date_fil']=='true' && $_GET['pay_fil']!='true'){
            if($_GET['cont']=='Active'){
            $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->whereDate('end_date','>=',date('Y-m-d'))
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
            else if($_GET['cont']=='Inactive'){
              $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->whereDate('end_date','<',date('Y-m-d'))
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
          }

          elseif($_GET['centre_fil']!='true' && $_GET['cont_fil']=='true' && $_GET['date_fil']!='true' && $_GET['pay_fil']=='true'){
            if($_GET['cont']=='Active'){
            $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                     ->where('payment_status',$_GET['pay'])
                    ->whereDate('end_date','>=',date('Y-m-d'))
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
            else if($_GET['cont']=='Inactive'){
              $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                     ->where('payment_status',$_GET['pay'])
                    ->whereDate('end_date','<',date('Y-m-d'))
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
          }

          elseif($_GET['centre_fil']!='true' && $_GET['cont_fil']=='true' && $_GET['date_fil']!='true' && $_GET['pay_fil']!='true'){
            if($_GET['cont']=='Active'){
            $clients=DB::table('car_contracts')
                    ->whereDate('end_date','>=',date('Y-m-d'))
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
            else if($_GET['cont']=='Inactive'){
              $clients=DB::table('car_contracts')
                    ->whereDate('end_date','<',date('Y-m-d'))
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
            }
          }

           elseif($_GET['centre_fil']!='true' && $_GET['cont_fil']!='true' && $_GET['date_fil']=='true' && $_GET['pay_fil']=='true'){
               $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                    ->whereDate('start_date','>=',$_GET['start'])
                     ->where('payment_status',$_GET['pay'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();

           }

          elseif($_GET['centre_fil']!='true' && $_GET['cont_fil']!='true' && $_GET['date_fil']=='true' && $_GET['pay_fil']!='true'){

            $clients=DB::table('car_contracts')
                    ->whereDate('start_date','>=',$_GET['start'])
                    ->whereDate('end_date','<=',$_GET['end'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
          }

          elseif($_GET['centre_fil']!='true' && $_GET['cont_fil']!='true' && $_GET['date_fil']!='true' && $_GET['pay_fil']=='true'){

            $clients=DB::table('car_contracts')
                    ->join('car_rental_invoices','car_rental_invoices.contract_id','=','car_contracts.id')
                    ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
                    ->where('payment_status',$_GET['pay'])
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
          }

          elseif($_GET['centre_fil']!='true' && $_GET['cont_fil']!='true' && $_GET['date_fil']!='true' && $_GET['pay_fil']!='true'){
              $clients=DB::table('car_contracts')
                    ->where('form_completion','1')
                    ->orderBy('car_contracts.fullName','asc')
                    ->get();
          }







         if(count($clients)==0){
           return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
        else{
        //   $pdf=PDF::loadView('carreportpdf',['clients'=>$clients])->setPaper('a4', 'landscape');
        // return $pdf->stream('Car Rental Report.pdf');
          return View('carreport_new',compact('clients'));
        }
        }
         elseif($_GET['report_type']=='cars'){
        if(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('vehicle_status',$_GET['status'])
          ->whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->wherebetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
              ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('vehicle_status',$_GET['status'])
           ->whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
          ->where('flag','1')
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereBetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwhereBetween('end_date',[ $_GET['start'] ,$_GET['end'] ])
            ->where('vehicle_reg_no','!=',null)
            ->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        }
         else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true')){
           $cars=carRental::where('vehicle_model',$_GET['model'])
           ->where('flag','1')
          ->where('vehicle_status',$_GET['status'])
          ->whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
          ->get();
         }
        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('vehicle_status',$_GET['status'])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
             ->wherebetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('vehicle_status',$_GET['status'])
          ->where('flag','1')
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereBetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwhereBetween('end_date',[ $_GET['start'] ,$_GET['end'] ])
            ->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        }

        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true')){
           $cars=carRental::where('vehicle_model',$_GET['model'])
           ->where('flag','1')
          ->where('vehicle_status',$_GET['status'])
          ->get();
        }

        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
             ->wherebetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
          ->where('flag','1')
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereBetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwhereBetween('end_date',[ $_GET['start'] ,$_GET['end'] ])
            ->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        }
        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true')){
          $cars=carRental::where('vehicle_model',$_GET['model'])
           ->whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
          ->where('flag','1')
          ->get();
        }
        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
             ->wherebetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('flag','1')
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereBetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])
            ->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        }
        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true')){
           $cars=carRental::where('vehicle_model',$_GET['model'])->where('flag','1')->get();
        }
        else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_status',$_GET['status'])
          ->whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->wherebetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_status',$_GET['status'])
           ->whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
          ->where('flag','1')
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereBetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])
            ->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        }
         else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true')){
          $cars=carRental::where('vehicle_status',$_GET['status'])
          ->where('flag','1')
          ->whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
          ->get();
         }

         else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_status',$_GET['status'])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
             ->wherebetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_status',$_GET['status'])
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereBetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])
            ->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
           ->where('flag','1')
          ->get();
        }
         }
         else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true')){
           $cars=carRental::where('vehicle_status',$_GET['status'])->where('flag','1')->get();
         }

          else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true')){
            if($_GET['rent']=='Rented'){
          $cars=carRental::whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
             ->wherebetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
          ->where('flag','1')
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
             ->whereBetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
              ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])
             ->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
          }

          else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true')){
             $cars=carRental::whereBetween('hire_rate',[ $_GET['min'], $_GET['max'] ])
             ->where('flag','1')
             ->get();
          }
           else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true')){
            if($_GET['rent']=='Rented'){
          // $cars=carRental::whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
          //   ->where('vehicle_reg_no','!=',null)
          //   ->whereDate('start_date','>=',$_GET['start'])
          //   ->orwhereDate('end_date', '<=',$_GET['end'])
          //   ->distinct()
          //   ->pluck('vehicle_reg_no')->toArray())
          // ->get();

            $cars=carRental::whereIn('vehicle_reg_no',DB::table('car_contracts')
              ->select('vehicle_reg_no')
              ->where('vehicle_reg_no','!=',null)
              ->wherebetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
              ->orwherebetween('end_date',[ $_GET['start'] ,$_GET['end'] ])->where('vehicle_reg_no','!=',null)
              ->distinct()
              ->pluck('vehicle_reg_no')->toArray())
              ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            // ->whereDate('start_date','>=',$_GET['start'])
            // ->whereDate('end_date', '<=',$_GET['start'])
            ->whereBetween('start_date',[ $_GET['start'] ,$_GET['end'] ])
            ->orwhereBetween('end_date',[ $_GET['start'] ,$_GET['end'] ])
            ->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->where('flag','1')
          ->get();
        }
           }

           else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true')){
            $cars=carRental::where('flag','1')->get();
           }

           if(count($cars)==0){
           return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
        else{
        //   $pdf=PDF::loadView('carreportpdf',['cars'=>$cars]);
        // return $pdf->stream('Car Rental Report.pdf');
          return View('carreport_new',compact('cars'));
        }

        }
        elseif ($_GET['report_type']=='revenue'){
          $revenues=DB::table('car_contracts')
        ->join('car_rental_invoices', 'car_rental_invoices.contract_id', '=', 'car_contracts.id')
        ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
        ->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])
        ->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])
        ->where('payment_status','!=', 'Not paid')
        ->orderBy('invoicing_period_start_date','asc')
        ->get();
        if(count($revenues)==0){
           return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
        else{
        //   $pdf=PDF::loadView('carreportpdf',['revenues'=>$revenues]);
        // return $pdf->stream('Car Rental Report.pdf');
          return View('carreport_new',compact('revenues'));
        }
        }
      }

      public function carreportPDF2(){
         if($_GET['date_fil']=='true' && $_GET['model_fil']=='true' && $_GET['reg_fil']=='true'){
           $operational=operational_expenditure::
           join('car_rentals','car_rentals.vehicle_reg_no','=','operational_expenditures.vehicle_reg_no')
           ->whereBetween(DB::raw('DATE(date_received)'), array($_GET['start'], $_GET['end']))
           ->where('vehicle_model',$_GET['model'])
           ->where('operational_expenditures.vehicle_reg_no',$_GET['reg'])
           ->where('operational_expenditures.flag',1)
           ->get();
         }

         elseif($_GET['date_fil']=='true' && $_GET['model_fil']=='true' && $_GET['reg_fil']!='true'){
           $operational=operational_expenditure::
           join('car_rentals','car_rentals.vehicle_reg_no','=','operational_expenditures.vehicle_reg_no')
           ->whereBetween(DB::raw('DATE(date_received)'), array($_GET['start'], $_GET['end']))
           ->where('vehicle_model',$_GET['model'])
           ->where('operational_expenditures.flag',1)
           ->get();
         }

         elseif($_GET['date_fil']=='true' && $_GET['model_fil']!='true' && $_GET['reg_fil']=='true'){
           $operational=operational_expenditure::
            whereBetween(DB::raw('DATE(date_received)'), array($_GET['start'], $_GET['end']))
           ->where('operational_expenditures.vehicle_reg_no',$_GET['reg'])
           ->where('operational_expenditures.flag',1)
           ->get();
         }

         elseif($_GET['date_fil']=='true' && $_GET['model_fil']!='true' && $_GET['reg_fil']!='true'){
           $operational=operational_expenditure::
           whereBetween(DB::raw('DATE(date_received)'), array($_GET['start'], $_GET['end']))
          ->where('operational_expenditures.flag',1)
          ->get();
         }

         elseif($_GET['date_fil']!='true' && $_GET['model_fil']=='true' && $_GET['reg_fil']=='true'){
           $operational=operational_expenditure::
           join('car_rentals','car_rentals.vehicle_reg_no','=','operational_expenditures.vehicle_reg_no')
           ->where('vehicle_model',$_GET['model'])
           ->where('operational_expenditures.vehicle_reg_no',$_GET['reg'])
           ->where('operational_expenditures.flag',1)->get();
         }

         elseif($_GET['date_fil']!='true' && $_GET['model_fil']=='true' && $_GET['reg_fil']!='true'){
           $operational=operational_expenditure::
           join('car_rentals','car_rentals.vehicle_reg_no','=','operational_expenditures.vehicle_reg_no')
           ->where('vehicle_model',$_GET['model'])
           ->where('operational_expenditures.flag',1)->get();
         }

         elseif($_GET['date_fil']!='true' && $_GET['model_fil']!='true' && $_GET['reg_fil']=='true'){
           $operational=operational_expenditure::
           where('operational_expenditures.vehicle_reg_no',$_GET['reg'])
           ->where('operational_expenditures.flag',1)
           ->get();
         }

         elseif($_GET['date_fil']!='true' && $_GET['model_fil']!='true' && $_GET['reg_fil']!='true'){
           $operational=operational_expenditure::
           where('operational_expenditures.flag',1)
           ->get();
         }

         if(count($operational)==0){
           return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
        else{


         //  $pdf=PDF::loadView('operationalreportpdf',['operational'=>$operational])->setPaper('a4', 'landscape');    
         // return $pdf->stream('Car Rental Operational Report.pdf');
          return View('operationalreport_new',compact('operational'));

        }


      }

      public function carreportPDF3(){
         $details=carRental::where('vehicle_reg_no',$_GET['reg'])->get();
         if($_GET['date_fil']=='true'){
           $bookings=carContract::where('vehicle_reg_no',$_GET['reg'])->whereBetween(DB::raw('DATE(start_date)'), array($_GET['start'], $_GET['end']))->orderby('start_date','asc')->get();
           $operations=operational_expenditure::where('vehicle_reg_no',$_GET['reg'])->whereBetween(DB::raw('DATE(date_received)'), array($_GET['start'], $_GET['end']))->orderby('date_received','asc')->get();
         }
         else{
          $bookings=carContract::where('vehicle_reg_no',$_GET['reg'])->orderby('start_date','asc')->get();
          $operations=operational_expenditure::where('vehicle_reg_no',$_GET['reg'])->orderby('date_received','asc')->get();
         }
         
        if((count($bookings)==0) &&(count($operations)==0)){
            return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
       else{


        // $pdf=PDF::loadView('carhistoryreportpdf',['details'=>$details,'bookings'=>$bookings,'operations'=>$operations])->setPaper('a4', 'landscape');    
        //  return $pdf->stream('Car History Report.pdf');
         return view('carhistoryreport',compact('details','bookings','operations'));

       }
      }

      public function contractreportPDF(){
        if(($_GET['c_filter']!='true') && ($_GET['con_filter']!='true') && ($_GET['y_filter']!='true')){
if($_GET['business_type']=='Space'){
   $contracts=space_contract::where('contract_status',1)->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Insurance'){
  $contracts=insurance_contract::orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Car Rental'){
  $contracts=carContract::where('form_completion','1')->orderBy('car_contracts.fullName','asc')->get();
}
}
elseif(($_GET['c_filter']!='true') && ($_GET['con_filter']!='true') && ($_GET['y_filter']=='true')){
  if($_GET['business_type']=='Space'){
    if($_GET['lease']=='start'){
      $contracts=space_contract::where('contract_status',1)->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
    }
    elseif($_GET['lease']=='end'){
       $contracts=space_contract::where('contract_status',1)->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
    }

}
elseif($_GET['business_type']=='Insurance'){
   if($_GET['lease']=='start'){
  $contracts=insurance_contract::whereYear('commission_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif($_GET['lease']=='end'){
   $contracts=insurance_contract::whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
  }
}
elseif($_GET['business_type']=='Car Rental'){
   if($_GET['lease']=='start'){
  $contracts=carContract::where('form_completion','1')->whereYear('start_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
}
elseif($_GET['lease']=='end'){
   $contracts=carContract::where('form_completion','1')->whereYear('end_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
  }
}
  }

  elseif(($_GET['c_filter']!='true') && ($_GET['con_filter']=='true') && ($_GET['y_filter']!='true')){
    if($_GET['con_status']=='Active'){
    if($_GET['business_type']=='Space'){
        $contracts=space_contract::where('contract_status',1)->whereDate('end_date','>=',date('Y-m-d'))->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Insurance'){
  $contracts=insurance_contract::whereDate('end_date','>=',date('Y-m-d'))->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Car Rental'){
  $contracts=carContract::where('form_completion','1')->whereDate('end_date','>=',date('Y-m-d'))->orderBy('car_contracts.fullName','asc')->get();
}
}
elseif($_GET['con_status']=='Expired'){
if($_GET['business_type']=='Space'){
        $contracts=space_contract::where('contract_status',1)->whereDate('end_date','<',date('Y-m-d'))->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Insurance'){
  $contracts=insurance_contract::whereDate('end_date','<',date('Y-m-d'))->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Car Rental'){
  $contracts=carContract::where('form_completion','1')->whereDate('end_date','<',date('Y-m-d'))->orderBy('car_contracts.fullName','asc')->get();
}
}

  }
  elseif(($_GET['c_filter']!='true') && ($_GET['con_filter']=='true') && ($_GET['y_filter']=='true')){
    if($_GET['con_status']=='Active'){
    if(($_GET['business_type']=='Space')&&($_GET['lease']=='start')){
        $contracts=space_contract::where('contract_status',1)->whereDate('end_date','>=',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Space')&&($_GET['lease']=='end')){
        $contracts=space_contract::where('contract_status',1)->whereDate('end_date','>=',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Insurance')&&($_GET['lease']=='start')){
  $contracts=insurance_contract::whereDate('end_date','>=',date('Y-m-d'))->whereYear('commission_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Insurance')&&($_GET['lease']=='end')){
  $contracts=insurance_contract::whereDate('end_date','>=',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Car Rental')&&($_GET['lease']=='start')){
  $contracts=carContract::where('form_completion','1')->whereDate('end_date','>=',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
}
elseif(($_GET['business_type']=='Car Rental')&&($_GET['lease']=='end')){
  $contracts=carContract::where('form_completion','1')->whereDate('end_date','>=',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
}
}
elseif($_GET['con_status']=='Expired'){
    if(($_GET['business_type']=='Space')&&($_GET['lease']=='start')){
        $contracts=space_contract::where('contract_status',1)->whereDate('end_date','<',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Space')&&($_GET['lease']=='end')){
        $contracts=space_contract::where('contract_status',1)->whereDate('end_date','<',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Insurance')&&($_GET['lease']=='start')){
  $contracts=insurance_contract::whereDate('end_date','<',date('Y-m-d'))->whereYear('commission_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Insurance')&&($_GET['lease']=='end')){
  $contracts=insurance_contract::whereDate('end_date','<',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Car Rental')&&($_GET['lease']=='start')){
  $contracts=carContract::where('form_completion','1')->whereDate('end_date','<',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
}
elseif(($_GET['business_type']=='Car Rental')&&($_GET['lease']=='end')){
  $contracts=carContract::where('form_completion','1')->whereDate('end_date','<',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
}
}
  }
   elseif(($_GET['c_filter']=='true') && ($_GET['con_filter']!='true') && ($_GET['y_filter']!='true')){
    if($_GET['business_type']=='Space'){
   $contracts=space_contract::where('full_name',$_GET['c_name'])->where('contract_status',1)->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Insurance'){
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Car Rental'){
  $contracts=carContract::where('fullName',$_GET['c_name'])->where('form_completion','1')->orderBy('car_contracts.fullName','asc')->get();
}
   }

   elseif(($_GET['c_filter']=='true') && ($_GET['con_filter']!='true') && ($_GET['y_filter']=='true')){
      if($_GET['business_type']=='Space'){
    if($_GET['lease']=='start'){
      $contracts=space_contract::where('full_name',$_GET['c_name'])->where('contract_status',1)->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
    }
    elseif($_GET['lease']=='end'){
       $contracts=space_contract::where('full_name',$_GET['c_name'])->where('contract_status',1)->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
    }

}
elseif($_GET['business_type']=='Insurance'){
   if($_GET['lease']=='start'){
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereYear('commission_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif($_GET['lease']=='end'){
   $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
  }
}
elseif($_GET['business_type']=='Car Rental'){
   if($_GET['lease']=='start'){
  $contracts=carContract::where('fullName',$_GET['c_name'])->where('form_completion','1')->whereYear('start_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
}
elseif($_GET['lease']=='end'){
   $contracts=carContract::where('fullName',$_GET['c_name'])->where('form_completion','1')->whereYear('end_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
  }
}
   }
   elseif(($_GET['c_filter']=='true') && ($_GET['con_filter']=='true') && ($_GET['y_filter']!='true')){
       if($_GET['con_status']=='Active'){
    if($_GET['business_type']=='Space'){
        $contracts=space_contract::where('full_name',$_GET['c_name'])->where('contract_status',1)->whereDate('end_date','>=',date('Y-m-d'))->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Insurance'){
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereDate('end_date','>=',date('Y-m-d'))->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Car Rental'){
  $contracts=carContract::where('fullName',$_GET['c_name'])->where('form_completion','1')->whereDate('end_date','>=',date('Y-m-d'))->orderBy('car_contracts.fullName','asc')->get();
}
}
elseif($_GET['con_status']=='Expired'){
if($_GET['business_type']=='Space'){
        $contracts=space_contract::where('full_name',$_GET['c_name'])->where('contract_status',1)->whereDate('end_date','<',date('Y-m-d'))->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Insurance'){
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereDate('end_date','<',date('Y-m-d'))->orderBy('full_name','asc')->get();
}
elseif($_GET['business_type']=='Car Rental'){
  $contracts=carContract::where('fullName',$_GET['c_name'])->where('form_completion','1')->whereDate('end_date','<',date('Y-m-d'))->orderBy('car_contracts.fullName','asc')->get();
}
}
   }
   elseif(($_GET['c_filter']=='true') && ($_GET['con_filter']=='true') && ($_GET['y_filter']=='true')){
     if($_GET['con_status']=='Active'){
    if(($_GET['business_type']=='Space')&&($_GET['lease']=='start')){
        $contracts=space_contract::where('full_name',$_GET['c_name'])->where('contract_status',1)->whereDate('end_date','>=',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Space')&&($_GET['lease']=='end')){
        $contracts=space_contract::where('full_name',$_GET['c_name'])->where('contract_status',1)->whereDate('end_date','>=',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Insurance')&&($_GET['lease']=='start')){
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereDate('end_date','>=',date('Y-m-d'))->whereYear('commission_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Insurance')&&($_GET['lease']=='end')){
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereDate('end_date','>=',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Car Rental')&&($_GET['lease']=='start')){
  $contracts=carContract::where('fullName',$_GET['c_name'])->where('form_completion','1')->whereDate('end_date','>=',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
}
elseif(($_GET['business_type']=='Car Rental')&&($_GET['lease']=='end')){
  $contracts=carContract::where('fullName',$_GET['c_name'])->where('form_completion','1')->whereDate('end_date','>=',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
}
}
elseif($_GET['con_status']=='Expired'){
    if(($_GET['business_type']=='Space')&&($_GET['lease']=='start')){
        $contracts=space_contract::where('full_name',$_GET['c_name'])->where('contract_status',1)->whereDate('end_date','<',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Space')&&($_GET['lease']=='end')){
        $contracts=space_contract::where('full_name',$_GET['c_name'])->where('contract_status',1)->whereDate('end_date','<',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Insurance')&&($_GET['lease']=='start')){
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereDate('end_date','<',date('Y-m-d'))->whereYear('commission_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Insurance')&&($_GET['lease']=='end')){
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereDate('end_date','<',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('full_name','asc')->get();
}
elseif(($_GET['business_type']=='Car Rental')&&($_GET['lease']=='start')){
  $contracts=carContract::where('fullName',$_GET['c_name'])->where('form_completion','1')->whereDate('end_date','<',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
}
elseif(($_GET['business_type']=='Car Rental')&&($_GET['lease']=='end')){
  $contracts=carContract::where('fullName',$_GET['c_name'])->where('form_completion','1')->whereDate('end_date','<',date('Y-m-d'))->whereYear('end_date',$_GET['year'])->orderBy('car_contracts.fullName','asc')->get();
}
}
   }
        if(count($contracts)==0){
            return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
       else{
        return View('contractreport_new',compact('contracts'));
        // $pdf=PDF::loadView('contractreportpdf',['contracts'=>$contracts])->setPaper('a4', 'landscape');
        // return $pdf->stream('Contract Report.pdf');
       }


      }

      public function invoicereportPDF(){
        if($_GET['report_type']=='list'){
    if(($_GET['c_filter']!='true')&&($_GET['payment_filter']!='true')&&($_GET['year_filter']!='true')){
      if($_GET['b_type']=='Space'){
        if($_GET['In_type']=='rent'){
           $invoices=DB::table('invoices')->orderBy('invoice_date','dsc')->get();
        }
        elseif($_GET['In_type']=='electricity'){
          $invoices=DB::table('electricity_bill_invoices')->orderBy('invoice_date','dsc')->get();
        }
        elseif($_GET['In_type']=='water'){
          $invoices=DB::table('water_bill_invoices')->orderBy('invoice_date','dsc')->get();
        }
      }
      elseif($_GET['b_type']=='Insurance'){
        $invoices=DB::table('insurance_invoices')->orderBy('invoice_date','dsc')->get();
      }
      elseif($_GET['b_type']=='Car Rental'){
        $invoices=DB::table('car_rental_invoices')->orderBy('invoice_date','dsc')->get();
      }
}
elseif(($_GET['c_filter']!='true')&&($_GET['payment_filter']!='true')&&($_GET['year_filter']=='true')){
  if($_GET['b_type']=='Space'){
    if($_GET['In_type']=='rent'){
       $invoices=DB::table('invoices')->whereYear('invoicing_period_start_date',$_GET['year'])->orwhereYear('invoicing_period_end_date',$_GET['year'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')->whereYear('invoicing_period_start_date',$_GET['year'])->orwhereYear('invoicing_period_end_date',$_GET['year'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')->whereYear('invoicing_period_start_date',$_GET['year'])->orwhereYear('invoicing_period_end_date',$_GET['year'])->orderBy('invoice_date','dsc')->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')->whereYear('invoicing_period_start_date',$_GET['year'])->orwhereYear('invoicing_period_end_date',$_GET['year'])->orderBy('invoice_date','dsc')->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')->whereYear('invoicing_period_start_date',$_GET['year'])->orwhereYear('invoicing_period_end_date',$_GET['year'])->orderBy('invoice_date','dsc')->get();
  }

  }
  elseif(($_GET['c_filter']!='true')&&($_GET['payment_filter']=='true')&&($_GET['year_filter']!='true')){
    if($_GET['b_type']=='Space'){
    if($_GET['In_type']=='rent'){
       $invoices=DB::table('invoices')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')->join('electricity_bill_payments','electricity_bill_payments.invoice_number','=','electricity_bill_invoices.invoice_number')->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')->join('water_bill_payments','water_bill_payments.invoice_number','=','water_bill_invoices.invoice_number')->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')->join('insurance_payments','insurance_payments.invoice_number','=','insurance_invoices.invoice_number')->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
  }
  }
  elseif(($_GET['c_filter']!='true')&&($_GET['payment_filter']=='true')&&($_GET['year_filter']=='true')){
    if($_GET['b_type']=='Space'){
    if($_GET['In_type']=='rent'){
       $invoices=DB::table('invoices')
       ->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')
       ->where('payment_status',$_GET['payment_status'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
       ->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')
      ->join('electricity_bill_payments','electricity_bill_payments.invoice_number','=','electricity_bill_invoices.invoice_number')
      ->where('payment_status',$_GET['payment_status'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
       ->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')
      ->join('water_bill_payments','water_bill_payments.invoice_number','=','water_bill_invoices.invoice_number')
      ->where('payment_status',$_GET['payment_status'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
       ->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')
         ->join('insurance_payments','insurance_payments.invoice_number','=','insurance_invoices.invoice_number')
         ->where('payment_status',$_GET['payment_status'])->whereYear('invoicing_period_start_date',$_GET['year'])
         ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('payment_status',$_GET['payment_status'])
         ->orderBy('invoice_date','dsc')
         ->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')
      ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
      ->where('payment_status',$_GET['payment_status'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
       ->get();
  }
  }
  elseif(($_GET['c_filter']=='true')&&($_GET['payment_filter']!='true')&&($_GET['year_filter']!='true')){
    if($_GET['b_type']=='Space'){
    if($_GET['In_type']=='rent'){
       $invoices=DB::table('invoices')->where('debtor_name',$_GET['c_name'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')->where('debtor_name',$_GET['c_name'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')->where('debtor_name',$_GET['c_name'])->orderBy('invoice_date','dsc')->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')->where('debtor_name',$_GET['c_name'])->orderBy('invoice_date','dsc')->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')->where('debtor_name',$_GET['c_name'])->orderBy('invoice_date','dsc')->get();
  }
  }
  elseif(($_GET['c_filter']=='true')&&($_GET['payment_filter']!='true')&&($_GET['year_filter']=='true')){
    if($_GET['b_type']=='Space'){
    if($_GET['In_type']=='rent'){
       $invoices=DB::table('invoices')
       ->where('debtor_name',$_GET['c_name'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])
       ->orderBy('invoice_date','dsc')
       ->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')
      ->where('debtor_name',$_GET['c_name'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])
       ->orderBy('invoice_date','dsc')
      ->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')
      ->where('debtor_name',$_GET['c_name'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])
       ->orderBy('invoice_date','dsc')
      ->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')
         ->where('debtor_name',$_GET['c_name'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])
       ->orderBy('invoice_date','dsc')
         ->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')
      ->where('debtor_name',$_GET['c_name'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])
       ->orderBy('invoice_date','dsc')
      ->get();
  }
  }
  elseif(($_GET['c_filter']=='true')&&($_GET['payment_filter']=='true')&&($_GET['year_filter']!='true')){
    if($_GET['b_type']=='Space'){
    if($_GET['In_type']=='rent'){
       $invoices=DB::table('invoices')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')->join('electricity_bill_payments','electricity_bill_payments.invoice_number','=','electricity_bill_invoices.invoice_number')->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')->join('water_bill_payments','water_bill_payments.invoice_number','=','water_bill_invoices.invoice_number')->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')->join('insurance_payments','insurance_payments.invoice_number','=','insurance_invoices.invoice_number')->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
  }

  }
  elseif(($_GET['c_filter']=='true')&&($_GET['payment_filter']=='true')&&($_GET['year_filter']=='true')){
    if($_GET['b_type']=='Space'){
    if($_GET['In_type']=='rent'){
       $invoices=DB::table('invoices')
       ->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')
       ->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
       ->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')
      ->join('electricity_bill_payments','electricity_bill_payments.invoice_number','=','electricity_bill_invoices.invoice_number')
      ->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
      ->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')
      ->join('water_bill_payments','water_bill_payments.invoice_number','=','water_bill_invoices.invoice_number')
      ->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
      ->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')
         ->join('insurance_payments','insurance_payments.invoice_number','=','insurance_invoices.invoice_number')
         ->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
         ->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')
      ->join('car_rental_payments','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
      ->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
      ->get();
  }
  }
}
if(count($invoices)==0){
 return redirect()->back()->with('errors', "No data found to generate the requested report");
}
else{
  return View('invoicereportpdf_new',compact('invoices'));
   // $pdf=PDF::loadView('invoicereportpdf',['invoices'=>$invoices])->setPaper('a4', 'landscape');
   //      return $pdf->stream('Invoice Report.pdf');
}

      }

}
