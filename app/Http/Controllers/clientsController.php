<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\client;
use App\space_contract;
use App\Notifications\SendMessage;
use App\Notifications\SendMessage2;
use DB;
use App\Http\Controllers\Controller;
use App\carContract;
use App\insurance_contract;
use App\insurance_parameter;
use Notification;
use App\research_flats_contract;

class clientsController extends Controller
{
    //
    public function index(){
  $SCclients=client::whereIn('full_name',space_contract::select('full_name')->whereDate('end_date','>=',date('Y-m-d'))->where('contract_status','1')->distinct()->pluck('full_name')->toArray())
      ->where('contract','Space')
      ->orderBy('clients.full_name','asc')->get();
  $SPclients=client::select('client_id','email','phone_number','address','clients.full_name','contract_status')->join('space_contracts', 'space_contracts.full_name','=','clients.full_name')->where('contract','Space')->whereDate('end_date','<',date('Y-m-d'))->orwhere('contract_status','0')->orderBy('clients.full_name','asc')->distinct()->get();
  $active_carclients=carContract::select('fullName','email','cost_centre','faculty')->whereDate('end_date','>=',date('Y-m-d'))->where('form_completion','1')->distinct()->orderBy('fullName','asc')->get();
  $inactive_carclients=carContract::select('fullName','email','cost_centre','faculty')->whereDate('end_date','<',date('Y-m-d'))->where('form_completion','1')->distinct()->orderBy('fullName','asc')->get();
   $insuranceclients=insurance_contract::orderBy('full_name','asc')->get();
   $active_insuranceclients=insurance_contract::select('full_name','email','phone_number','insurance_class')->whereDate('end_date','>=',date('Y-m-d'))->distinct()->orderBy('full_name','asc')->get();
   $inactive_insuranceclients=insurance_contract::select('full_name','email','phone_number','insurance_class')->whereDate('end_date','<',date('Y-m-d'))->distinct()->orderBy('full_name','asc')->get();

   $Spemails=client::whereIn('full_name',space_contract::select('full_name')->where('contract_status','1')->distinct()->pluck('full_name')->toArray())
      ->where('contract','Space')
      ->orderBy('clients.full_name','asc')->get();

      $flats_current = research_flats_contract::select('first_name','last_name','address','email','phone_number')->whereDate('departure_date','>=',date('Y-m-d'))->distinct()->orderBy('first_name','asc')->get();

      $flats_previous = research_flats_contract::select('first_name','last_name','address','email','phone_number')->whereDate('departure_date','<',date('Y-m-d'))->distinct()->orderBy('first_name','asc')->get();

    return view('clients')->with('SCclients',$SCclients)->with('SPclients',$SPclients)->with('active_carclients',$active_carclients)->with('inactive_carclients',$inactive_carclients)->with('insuranceclients',$insuranceclients)->with('active_insuranceclients',$active_insuranceclients)->with('inactive_insuranceclients',$inactive_insuranceclients)->with('Spemails',$Spemails)->with('flats_current',$flats_current)->with('flats_previous',$flats_previous);
    }

    public function edit(Request $request){
        $full_name=$request->get('client_name');
        $email=$request->get('email');
        $phone_number=$request->get('phone_number');
        $address=$request->get('address');
    	DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['address' => $address]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['email' => $email]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['phone_number' => $phone_number]);


         return redirect()->back()->with('success', 'Client Details Edited Successfully');  
    }


    public function editIns(Request $request){
        $full_name=$request->get('client_name');
        $email=$request->get('email');
        $phone_number=$request->get('phone_number');
        //$address=$request->get('address');
      DB::table('insurance_contracts')
                ->where('full_name', $full_name)
                ->update(['email' => $email]);


            DB::table('insurance_contracts')
                ->where('full_name', $full_name)
                ->update(['phone_number' => $phone_number]);


         return redirect()->back()->with('success', 'Client Details Edited Successfully');  
    }

    public function ClientViewMore($id){
    $clientname=client::select('full_name')->where('client_id',$id)->value('full_name');
    $details=client::where('client_id',$id)->get();
    $contracts=space_contract::join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','space_contracts.space_id_contract','=','spaces.space_id')->where('space_contracts.full_name',$clientname)->orderBy('contract_id','dsc')->get();
    $invoices=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->where('debtor_name',$clientname)->orderBy('invoice_number','dsc')->get();
    return view('Spclients_view_more')->with('clientname',$clientname)->with('details',$details)->with('contracts',$contracts)->with('invoices',$invoices);
    }

    public function CarViewMore($name, $email, $centre){
        $contracts=carContract::select('car_contracts.*','vehicle_model','hire_rate','vehicle_status')->join('car_rentals','car_contracts.vehicle_reg_no','=','car_rentals.vehicle_reg_no')->where('email',$email)->where('fullName',$name)->where('cost_centre',$centre)->get();
        $invoices= DB::table('car_rental_invoices')
                   ->whereIn('contract_id',DB::table('car_contracts')->select('id')->where('email',$email)->where('fullName',$name)->where('cost_centre',$centre)->pluck('id')->toArray())
                   ->get();
       return view('carClients_view_more')->with('clientname',$name)->with('clientemail',$email)->with('clientcentre',$centre)->with('contracts',$contracts)->with('invoices',$invoices);  
    }

    public function InsuranceViewMore($name, $email, $phone_number){
      $contracts=insurance_contract::where('email',$email)->where('full_name',$name)->where('phone_number',$phone_number)->get();
      $total_commision_tzs=insurance_contract::select('commission')->where('email',$email)->where('full_name',$name)->where('phone_number',$phone_number)->where('currency','TZS')->sum('commission');
      $total_commision_usd=insurance_contract::select('commission')->where('email',$email)->where('full_name',$name)->where('phone_number',$phone_number)->where('currency','USD')->sum('commission');
      $total_premium_tzs=insurance_contract::select('premium')->where('email',$email)->where('full_name',$name)->where('phone_number',$phone_number)->where('currency','TZS')->sum('premium');
      $total_premium_usd=insurance_contract::select('premium')->where('email',$email)->where('full_name',$name)->where('phone_number',$phone_number)->where('currency','USD')->sum('premium');
       return view('insurance_view_more')->with('clientname',$name)->with('clientemail',$email)->with('phone_number',$phone_number)->with('contracts',$contracts)->with('total_commision_tzs',$total_commision_tzs)->with('total_commision_usd',$total_commision_usd)->with('total_premium_tzs',$total_premium_tzs)->with('total_premium_usd',$total_premium_usd);  
    }

    public function SendMessage(Request $request){
        $name=$request->get('client_name');
        $subject=$request->get('subject');
        $message=$request->get('message');
        $type=$request->get('type');
       

        if($request->hasfile('filenames')){

          foreach($request->file('filenames') as $file) {
              //$filename = $file->getClientOriginalName().'.'.$file->extension();
              $filename = $file->getClientOriginalName();
              $filepaths[]=public_path().'/'.'uploads'.'/'.$filename;
              // $filename[]=$file->getClientOriginalName();
              // $mime[]=$file->getMimeType();
              $file->move(public_path().'/uploads/', $filename);
            }

        // $file = $request->file('image');
        // $destinationPath = 'uploads';
        // $filename=$file->getClientOriginalName();
        // $extension=$file->getClientOriginalExtension();
        // $mime=$file->getMimeType();
        // $path=$file->getRealPath();
        // $file->move($destinationPath,$filename);
        if($type=='space'){
           $client=client::where('full_name',$name)->first();
           $salutation = "Real Estate Department UDSM.";
           $client->notify(new SendMessage($name, $subject, $message, $filepaths, $salutation));
          return redirect()->back()->with('success', 'Message Sent Successfully');
        }
        elseif ($type=='car') {
          $client=carContract::where('fullName',$name)->first();
          $salutation = "Central Pool Transport Unit UDSM.";
          $client->notify(new SendMessage($name, $subject, $message, $filepaths, $salutation));
          return redirect()->back()->with('success', 'Message Sent Successfully');
        }
        elseif($type=='udia'){
           $client=insurance_contract::where('full_name',$name)->first();
           $salutation = "University of Dar es Salaam Insurance Agency.";
           $client->notify(new SendMessage($name, $subject, $message, $filepaths, $salutation));
          return redirect()->back()->with('success', 'Message Sent Successfully');
        }
        elseif($type=='principals'){
          $client = insurance_parameter::select('company_email as email')->where('company',$name)->first();
          $salutation = "University of Dar es Salaam Insurance Agency.";
           $client->notify(new SendMessage($name, $subject, $message, $filepaths, $salutation));
           return redirect()->back()->with('success', 'Message Sent Successfully');
        }
        elseif($type=='flats'){
          $debtor = $request->get('debtor');
          $contract_id = $request->get('contract_id');
          if($debtor=='individual'){
            $client = research_flat_contract::where('id',$contract_id)->first();
          }
          elseif($debtor=='host'){
            $client = research_flat_contract::select('host_email as email')->where('id',$contract_id)->first();
          }
            $salutation = "Research Flats UDSM";
            $client->notify(new SendMessage($name, $subject, $message, $filepaths, $salutation));
            return redirect()->back()->with('success', 'Message Sent Successfully');

        }

      
      }
      else{
        if($type=='space'){
           $client=client::where('full_name',$name)->first();
           $salutation = "Real Estate Department UDSM.";
            $client->notify(new SendMessage2($name, $subject, $message, $salutation));
            return redirect()->back()->with('success', 'Message Sent Successfully');
        }
        elseif ($type=='car') {
          $client=carContract::where('fullName',$name)->first();
          $salutation = "Central Pool Transport Unit UDSM.";
          $client->notify(new SendMessage2($name, $subject, $message, $salutation));
          return redirect()->back()->with('success', 'Message Sent Successfully');
        }
        elseif($type=='udia'){
           $client=insurance_contract::where('full_name',$name)->first();
           $salutation = "University of Dar es Salaam Insurance Agency.";
            $client->notify(new SendMessage2($name, $subject, $message, $salutation));
            return redirect()->back()->with('success', 'Message Sent Successfully');
        }
        elseif($type=='principals'){
          $email_address = DB::table('insurance_parameters')->where('company',$name)->value('company_email');
          $salutation = "University of Dar es Salaam Insurance Agency.";
          Notification::route('mail', $email_address)->notify(new SendMessage2($name, $subject, $message, $salutation));
          return redirect()->back()->with('success', 'Message Sent Successfully');
        }

         elseif($type=='flats'){
          $debtor = $request->get('debtor');
          $contract_id = $request->get('contract_id');
          if($debtor=='individual'){
            $client = research_flat_contract::where('id',$contract_id)->first();
          }
          elseif($debtor=='host'){
            $client = research_flat_contract::select('host_email as email')->where('id',$contract_id)->first();
          }
            $salutation = "Research Flats UDSM";
            $client->notify(new SendMessage($name, $subject, $message, $salutation));
            return redirect()->back()->with('success', 'Message Sent Successfully');
        }
        
      } 
    }

    public function SendMessage2(Request $request){
        $raw_names=$request->get('client_name');
        $names = explode (",", $raw_names);  
        $subject=$request->get('subject');
        $message=$request->get('message');
        $type=$request->get('type');

        if($request->hasfile('filenames')) {
          foreach($request->file('filenames') as $file) {
              //$filename = $file->getClientOriginalName().'.'.$file->extension();
              $filename = $file->getClientOriginalName();
                
              $filepaths[]=public_path().'/'.'uploads'.'/'.$filename;
              // $filename[]=$file->getClientOriginalName();
              // $mime[]=$file->getMimeType();
              $file->move(public_path().'/uploads/', $filename);
            }
        
        foreach($names as $name){
          if($type=='space'){
           $client=client::where('full_name',$name)->first();
           $salutation = "Real Estate Department UDSM.";
        }
        elseif ($type=='car') {
          $client=carContract::where('fullName',$name)->first();
          $salutation = "Central Pool Transport Unit UDSM.";
        }
        elseif($type=='udia'){
           $client=insurance_contract::where('full_name',$name)->first();
           $salutation = "University of Dar es Salaam Insurance Agency.";
        }
        elseif($type=='principals'){
          $client=insurance_parameter::select('company_email as email')->where('company',$name)->first();
          $salutation = "University of Dar es Salaam Insurance Agency.";
        }

         elseif($type=='flats'){
          
        }
    // \Notification::send($recipients, new Announcement($centre));
        $client->notify(new SendMessage($name, $subject, $message, $filepaths, $salutation));
     
        }
    
      return redirect()->back()->with('success', 'Message Sent Successfully');
      }
      else{
        foreach($names as $name){
          if($type=='space'){
           $client=client::where('full_name',$name)->first();
           $salutation = "Real Estate Department UDSM.";
        }
        elseif ($type=='car') {
          $client=carContract::where('fullName',$name)->first();
          $salutation = "Central Pool Transport Unit UDSM.";
        }
        elseif($type=='udia'){
           $client=insurance_contract::where('full_name',$name)->first();
           $salutation = "University of Dar es Salaam Insurance Agency.";
        }
        elseif($type=='principals'){
          $client=insurance_parameter::select('company_email as email')->where('company',$name)->first();
          $salutation = "University of Dar es Salaam Insurance Agency.";
        }
        elseif($type=='flats'){
          
        }
    // \Notification::send($recipients, new Announcement($centre));
        $client->notify(new SendMessage2($name, $subject, $message, $salutation));
        }
         return redirect()->back()->with('success', 'Message Sent Successfully');
      } 
    }
    public function editCarclients(Request $request){
      
       DB::table('car_contracts')
            ->where('email',$request->get('Caremail'))
            ->where('fullName',$request->get('Carfullname'))
            ->where('cost_centre',$request->get('Carcostcentre'))
            ->update(['faculty' =>$request->get('department')]);

        DB::table('car_contracts')
            ->where('email',$request->get('Caremail'))
            ->where('fullName',$request->get('Carfullname'))
            ->where('cost_centre',$request->get('Carcostcentre'))
            ->update(['email' => $request->get('email')]);

            DB::table('car_contracts')
            ->where('email',$request->get('Caremail'))
            ->where('fullName',$request->get('Carfullname'))
            ->where('cost_centre',$request->get('Carcostcentre'))
            ->update(['cost_centre' => $request->get('cost_centre')]);


           

             return redirect()->back()->with('success', 'Details Edited Successfully');
    }

    public function ajaxclient_names(Request $request){
       
      $query = $request->get('query');
      $queryy= $request->get('queryy');

      if($queryy=='Space'){
        if($query== ''){
          $data = space_contract::select('full_name')->distinct()->orderBy('full_name','asc')->limit(10)->get();
        }
        else{
         $data = space_contract::select('full_name')->where('full_name', 'LIKE', "%{$query}%")->distinct()->orderBy('full_name','asc')->limit(10)->get(); 
        }
        
      }

      elseif ($queryy=='Insurance') {
        if($query== ''){
          $data = insurance_contract::select('full_name')->distinct()->orderBy('full_name','asc')->limit(10)->get();
        }
        else{
          $data = insurance_contract::select('full_name')->where('full_name', 'LIKE', "%{$query}%")->distinct()->orderBy('full_name','asc')->limit(10)->get();
        }
       
      }

      elseif($queryy=='Car Rental'){
        if($query== ''){
          $data = carContract::select('fullName')->where('form_completion','1')->distinct()->orderBy('fullName','asc')->limit(10)->get();
        }
        else{
          $data = carContract::select('fullName')->where('form_completion','1')->where('fullName', 'LIKE', "%{$query}%")->distinct()->orderBy('fullName','asc')->limit(10)->get();
        }
    
      }

     
    if($queryy=='Car Rental'){

         $response = array();

      foreach($data as $client){
         $response[] = array(
            "id"=>$client->fullName,
            "text"=>$client->fullName
         );
      }
    }

    else{
      $response = array();
      foreach($data as $client){
         $response[] = array(
              "id"=>$client->full_name,
              "text"=>$client->full_name
         );
      }
    }
     

      echo json_encode($response);
      exit;
    }

    public function fetchclient_name(Request $request){
     if($request->get('query')){
      $query = $request->get('query');
      $queryy= $request->get('queryy');
      if($queryy=='Space'){
    $data = space_contract::select('full_name')->where('full_name', 'LIKE', "%{$query}%")->distinct()->orderBy('full_name','asc')->get();
  }
  elseif ($queryy=='Insurance') {
    $data = insurance_contract::select('full_name')->where('full_name', 'LIKE', "%{$query}%")->distinct()->orderBy('full_name','asc')->get();
  }
  elseif($queryy=='Car Rental'){
    $data = carContract::select('fullName')->where('form_completion','1')->where('fullName', 'LIKE', "%{$query}%")->distinct()->orderBy('fullName','asc')->get();
  }
      if(count($data)!=0){
      $output = '<ul class="dropdown-menu form-card" style="display: block;
    width: 100%; margin-left: 0%; margin-top: -3%;">';
      foreach($data as $row)
      {
        if($queryy=='Car Rental'){
          $output .= '
       <li id="list" style="margin-left: -3%;">'.$row->fullName.'</li>
       ';
        }
        else{
       $output .= '
       <li id="list" style="margin-left: -3%;">'.$row->full_name.'</li>
       ';
     }
      }
      $output .= '</ul>';
      echo $output;
     }
     else{
      echo "0";
     }

   }
 }
}
