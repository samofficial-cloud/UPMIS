<?php

namespace App\Http\Controllers;

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

    public function report()
    {
        return view('reports');
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
            'new-password' => 'required|string|min:6|confirmed',
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
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        else{
           $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
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

    public function spacereport1PDF(){
      $today= date('Y-m-d');
      if($_GET['module']=='space'){
        if($_GET['major_industry']=='list'){
          if(($_GET['space_prize']=='true') && ($_GET['status']=='true') &&($_GET['location_status']=='true')){
            if($_GET['space_status']=='1'){
            $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])->whereDate('end_date', '>=', $today)->where('location',$_GET['location'])->orderby('space_id','asc')->distinct()->get();
            }
            elseif($_GET['space_status']=='0'){
          $spaces= DB::table('spaces')
        ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
        ->where('status','1')
        ->where('location',$_GET['location'])->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])
        ->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])
        ->orderBy('space_id','asc')
        ->get();
            }
            
            }

            if(($_GET['space_prize']=='true') &&($_GET['location_status']=='true')&& ($_GET['status']!='true')){
              $spaces=space::where('rent_price_guide_from','>=',$_GET['min_price'])->where('rent_price_guide_to','<=',$_GET['max_price'])->where('status','1')->where('location',$_GET['location'])->orderby('space_id','asc')->get();
            }

            if(($_GET['space_prize']=='true') &&($_GET['location_status']!='true')&& ($_GET['status']=='true')){
               if($_GET['space_status']=='1'){
            $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('spaces.rent_price_guide_to','<=',$_GET['max_price'])->where('spaces.rent_price_guide_from','>=',$_GET['min_price'])->whereDate('end_date', '>=', $today)->orderby('space_id','asc')->distinct()->get();
        
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


            if(($_GET['space_prize']=='true') &&($_GET['location_status']!='true')&& ($_GET['status']!='true')){
              $spaces=space::where('rent_price_guide_from','>=',$_GET['min_price'])->where('rent_price_guide_to','<=',$_GET['max_price'])->where('status','1')->orderBy('space_id','asc')->get();
            }
            
          
          if(($_GET['space_prize']!='true') && ($_GET['location_status']=='true') && ($_GET['status']=='true')){
            if($_GET['space_status']=='1'){
            $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->whereDate('end_date', '>=', $today)->where('location',$_GET['location'])->orderby('space_id','asc')->distinct()->get();
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

          if(($_GET['space_prize']!='true')&&($_GET['location_status']=='true') && ($_GET['status']!='true')){
            $spaces=space::where('status','1')->where('location',$_GET['location'])->orderBy('space_id','asc')->get();
          }

          if(($_GET['space_prize']!='true')&&($_GET['location_status']!='true') && ($_GET['status']=='true')){
            if($_GET['space_status']=='1'){    
           $spaces= space_contract::select('location','size','rent_price_guide_from', 'rent_price_guide_to','space_id','major_industry')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->whereDate('end_date', '>=', $today)->orderBy('space_id','asc')->distinct()->get();
            }

            elseif($_GET['space_status']=='0'){
        $spaces= DB::table('spaces')
        ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>=',$today)->distinct()->pluck('space_id_contract')->toArray())
        ->where('status','1')
        ->orderBy('space_id','asc')
        ->get();
            }    
          }

          if(($_GET['status']!='true') &&($_GET['location_status']!='true')&& ($_GET['space_prize']!='true')){
            $spaces=space::where('status','1')->orderBy('space_id','asc')->get();
          }
          
        }
      }
      if(count($spaces)==0){
         return redirect()->back()->with('errors', "No data found to generate the requested report");
      }
      else{
        $pdf = PDF::loadView('spacereport1pdf',['spaces'=>$spaces])->setPaper('a4', 'landscape');
  
        return $pdf->stream('List of Spaces.pdf');
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
      ->where('space_contracts.space_id_contract',$_GET['space_id'])->wherebetween('space_contracts.start_date',[ $from ,$to ])->where('invoices.payment_status','Not Paid')
      ->orwherebetween('space_contracts.end_date',[ $from ,$to ])->where('invoices.payment_status','Not Paid')->where('space_contracts.space_id_contract',$_GET['space_id'])
      ->get();
  }
  else{
     $space=space_contract::join('spaces', 'spaces.space_id', '=', 'space_contracts.space_id_contract')->where('space_contracts.space_id_contract',$_GET['space_id'])->get();

     $invoices=space_contract::join('invoices', 'invoices.contract_id', '=', 'space_contracts.contract_id')->where('space_contracts.space_id_contract',$_GET['space_id'])->where('invoices.payment_status','Not Paid')->get();
  }
  if((count($space)==0) && (count($invoices)==0)){
   return redirect()->back()->with('errors', "No data found to generate the requested report");
  }
  else{
     $pdf = PDF::loadView('spacereport2pdf',['details'=>$details, 'space'=>$space,'invoices'=>$invoices]);
  
        return $pdf->stream('Spaces History.pdf');
  }
       
      }

      public function insurancereportPDF(){
       if($_GET['report_type']=='sales'){
        if(($_GET['principal_filter']=='true') && ($_GET['insurance_typefilter']=='true')){
        $insurance=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_type',$_GET['insurance_type'])->get();
      }
      if(($_GET['principal_filter']=='true') && ($_GET['insurance_typefilter']!='true')){
        $insurance=insurance_contract::where('principal',$_GET['principaltype'])->get();
      }
      if(($_GET['insurance_typefilter']=='true') && ($_GET['principal_filter']!='true')){
        $insurance=insurance_contract::where('insurance_type',$_GET['insurance_type'])->get();
      }

      if(($_GET['insurance_typefilter']!='true') && ($_GET['principal_filter']!='true')){
        $insurance=insurance_contract::get();
      }

      if(count($insurance)==0){
        return redirect()->back()->with('errors', "No data found to generate the requested report");
      }
      else{
        $pdf = PDF::loadView('insurancereportpdf',['insurance'=>$insurance])->setPaper('a4', 'landscape');
      }
        
      }

      else if($_GET['report_type']=='principals'){
      $principal=insurance::where('status','1')->orderBy('insurance_company','asc')->get();
      if(count($principal)==0){
        return redirect()->back()->with('errors', "No data found to generate the requested report");
      }
      else{
        $pdf = PDF::loadView('insurancereportpdf',['principal'=>$principal]);
      }
    }

     else if($_GET['report_type']=='clients'){
      $clients=insurance_contract::orderBy('commission_date','dsc')->get();
      if(count($clients)==0){
        return redirect()->back()->with('errors', "No data found to generate the requested report");
      }
      else{
        $pdf = PDF::loadView('insurancereportpdf',['clients'=>$clients])->setPaper('a4', 'landscape');
      }
    }
  
        return $pdf->stream('Insurance Report.pdf');
      }

      public function tenantreportPDF(){
        $today=date('Y-m-d');
        if($_GET['report_type']=='list'){
          if(($_GET['business_filter']=='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']=='true')){
  if($_GET['contract_status']==1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','>=',$today)->where('spaces.major_industry',$_GET['business_type'])->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==0){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','<',$today)->where('spaces.major_industry',$_GET['business_type'])->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==-1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->where('space_contracts.contract_status',0)->where('spaces.major_industry',$_GET['business_type'])->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
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
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->where('clients.contract','Space')->where('spaces.major_industry',$_GET['business_type'])->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
}
if(($_GET['business_filter']=='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']!='true')){
  $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('clients.contract','Space')->where('spaces.major_industry',$_GET['business_type'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
}
if(($_GET['business_filter']!='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']=='true')){
      if($_GET['contract_status']==1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->where('clients.contract','Space')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','>=',$today)->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==0){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->where('clients.contract','Space')->where('space_contracts.contract_status',1)->whereDate('end_date','<',$today)->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
  }
  else if($_GET['contract_status']==-1){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->where('clients.contract','Space')->where('space_contracts.contract_status',0)->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
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
  $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->join('invoices','invoices.contract_id','=','space_contracts.contract_id')->where('clients.contract','Space')->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('space_contracts.full_name','asc')->distinct()->get();
}
if(($_GET['business_filter']!='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']!='true')){
  $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('clients.contract','Space')->orderBy('space_contracts.full_name','asc')->distinct()->get();
}
          if(count($tenants)==0){
               return redirect()->back()->with('errors', "No data found to generate the requested report");
          }
          else{
             $pdf=PDF::loadView('tenantreportpdf',['tenants'=>$tenants])->setPaper('a4', 'landscape');
           return $pdf->stream('Tenant Report.pdf');
          }
          
        }
        elseif($_GET['report_type']=='invoice'){
          if($_GET['payment_filter']=='true'){
    if($_GET['criteria']=='rent'){
     $invoices=DB::table('invoices')->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('invoice_date','asc')->get();
    }
    elseif($_GET['criteria']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('invoice_date','asc')->get();
    }
    elseif($_GET['criteria']=='water'){
       $invoices=DB::table('water_bill_invoices')->where('payment_status',$_GET['payment_status'])->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])->orderBy('invoice_date','asc')->get();
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
     $pdf=PDF::loadView('tenantreportpdf',['invoices'=>$invoices])->setPaper('a4', 'landscape');;
           return $pdf->stream('Tenant Invoice Report.pdf');
  }
         
        }
       
      }

      public function carreportPDF(){
        if($_GET['report_type']=='clients'){

        $clients=DB::table('car_contracts')
        ->where('form_completion','1')
      ->orderBy('car_contracts.fullName','asc')
      ->get();

         if(count($clients)==0){
           return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
        else{
          $pdf=PDF::loadView('carreportpdf',['clients'=>$clients]);
        return $pdf->stream('Car Rental Report.pdf');
        }
        }
         elseif($_GET['report_type']=='cars'){
        if(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('vehicle_status',$_GET['status'])
          ->where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['end'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('vehicle_status',$_GET['status'])
          ->where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->wherebetween('start_date',[$_GET['start'] , $_GET['end'] ])
            ->orwherebetween('end_date',[$_GET['start'] , $_GET['end'] ])
            ->where('vehicle_reg_no','!=',null)
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        }
         else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true')){
           $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('vehicle_status',$_GET['status'])
          ->where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
          ->get();
         }
        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('vehicle_status',$_GET['status'])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['end'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('vehicle_status',$_GET['status'])
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['start'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        }

        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true')){
           $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('vehicle_status',$_GET['status'])
          ->get();
        }

        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['end'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['start'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        }
        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true')){
          $cars=carRental::where('vehicle_model',$_GET['model'])
          ->where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
          ->get();
        }
        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['end'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_model',$_GET['model'])
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->OrwhereDate('end_date', '<=',$_GET['end'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        }
        else if(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true')){
           $cars=carRental::where('vehicle_model',$_GET['model'])->get();
        }
        else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_status',$_GET['status'])
          ->where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['end'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_status',$_GET['status'])
          ->where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['start'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        }
         else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true')){
          $cars=carRental::where('vehicle_status',$_GET['status'])
          ->where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
          ->get();
         }
         else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true')){
          if($_GET['rent']=='Rented'){
          $cars=carRental::where('vehicle_status',$_GET['status'])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['end'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('vehicle_status',$_GET['status'])
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['start'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
         }
         else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true')){
           $cars=carRental::where('vehicle_status',$_GET['status'])->get();
         }

          else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true')){
            if($_GET['rent']=='Rented'){
          $cars=carRental::where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
           ->whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['end'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::where('hire_rate','>=',$_GET['min'])
          ->where('hire_rate','<=',$_GET['max'])
           ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['start'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
          }

          else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true')){
             $cars=carRental::where('hire_rate','>=',$_GET['min'])
             ->where('hire_rate','<=',$_GET['max'])
             ->get();
          }
           else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true')){
            if($_GET['rent']=='Rented'){
          $cars=carRental::whereIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['end'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
        else if($_GET['rent']=='Available'){
          $cars=carRental::whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')
            ->where('vehicle_reg_no','!=',null)
            ->whereDate('start_date','>=',$_GET['start'])
            ->orwhereDate('end_date', '<=',$_GET['start'])
            ->distinct()
            ->pluck('vehicle_reg_no')->toArray())
          ->get();
        }
           }

           else if(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true')){
            $cars=carRental::get();
           }

           if(count($cars)==0){
           return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
        else{
          $pdf=PDF::loadView('carreportpdf',['cars'=>$cars]);
        return $pdf->stream('Car Rental Report.pdf');
        }
        
        }
        elseif ($_GET['report_type']=='revenue'){
          $revenues=DB::table('car_contracts')
        ->join('car_rental_invoices', 'car_rental_invoices.contract_id', '=', 'car_contracts.id')
        ->where('payment_status','Paid')
        ->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])
        ->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])
        ->orderBy('invoicing_period_start_date','asc')
        ->get();
        if(count($revenues)==0){
           return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
        else{
          $pdf=PDF::loadView('carreportpdf',['revenues'=>$revenues]);
        return $pdf->stream('Car Rental Report.pdf');
        }
        }
      }

      public function carreportPDF2(){
         $pdf=PDF::loadView('operationalreportpdf')->setPaper('a4', 'landscape');    
         return $pdf->stream('Car Rental Operational Report.pdf');
      }

      public function carreportPDF3(){
         $details=carRental::where('vehicle_reg_no',$_GET['reg'])->get();
         $bookings=carContract::where('vehicle_reg_no',$_GET['reg'])->orderby('start_date','asc')->get();
        $operations=operational_expenditure::where('vehicle_reg_no',$_GET['reg'])->orderby('date_received','asc')->get();
        if((count($bookings)==0) &&(count($operations)==0)){
            return redirect()->back()->with('errors', "No data found to generate the requested report");
        }
       else{
        $pdf=PDF::loadView('carhistoryreportpdf',['details'=>$details,'bookings'=>$bookings,'operations'=>$operations])->setPaper('a4', 'landscape');    
         return $pdf->stream('Car History Report.pdf');
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
  $contracts=insurance_contract::whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
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
  $contracts=insurance_contract::whereDate('end_date','>=',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
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
  $contracts=insurance_contract::whereDate('end_date','<',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
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
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
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
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereDate('end_date','>=',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
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
  $contracts=insurance_contract::where('full_name',$_GET['c_name'])->whereDate('end_date','<',date('Y-m-d'))->whereYear('start_date',$_GET['year'])->orderBy('full_name','asc')->get();
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
        $pdf=PDF::loadView('contractreportpdf',['contracts'=>$contracts])->setPaper('a4', 'landscape');
        return $pdf->stream('Contract Report.pdf');
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
       $invoices=DB::table('invoices')->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
  }
  }
  elseif(($_GET['c_filter']!='true')&&($_GET['payment_filter']=='true')&&($_GET['year_filter']=='true')){
    if($_GET['b_type']=='Space'){
    if($_GET['In_type']=='rent'){
       $invoices=DB::table('invoices')
       ->where('payment_status',$_GET['payment_status'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
       ->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')
      ->where('payment_status',$_GET['payment_status'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
       ->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')
      ->where('payment_status',$_GET['payment_status'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
       ->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')
         ->where('payment_status',$_GET['payment_status'])->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
       ->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')
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
       $invoices=DB::table('invoices')->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])->orderBy('invoice_date','dsc')->get();
  }

  }
  elseif(($_GET['c_filter']=='true')&&($_GET['payment_filter']=='true')&&($_GET['year_filter']=='true')){
    if($_GET['b_type']=='Space'){
    if($_GET['In_type']=='rent'){
       $invoices=DB::table('invoices')
       ->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
       ->get();
    }
    elseif($_GET['In_type']=='electricity'){
      $invoices=DB::table('electricity_bill_invoices')
      ->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
      ->get();
    }
    elseif($_GET['In_type']=='water'){
      $invoices=DB::table('water_bill_invoices')
      ->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
      ->get();
    }
  }
  elseif($_GET['b_type']=='Insurance'){
         $invoices=DB::table('insurance_invoices')
         ->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->whereYear('invoicing_period_start_date',$_GET['year'])
       ->orwhereYear('invoicing_period_end_date',$_GET['year'])->where('debtor_name',$_GET['c_name'])->where('payment_status',$_GET['payment_status'])
       ->orderBy('invoice_date','dsc')
         ->get();
  }
  elseif($_GET['b_type']=='Car Rental'){
      $invoices=DB::table('car_rental_invoices')
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
   $pdf=PDF::loadView('invoicereportpdf',['invoices'=>$invoices])->setPaper('a4', 'landscape');
        return $pdf->stream('Invoice Report.pdf');
}
       
      }
    
}
