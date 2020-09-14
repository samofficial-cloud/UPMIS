<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\client;
use App\space_contract;
use App\Notifications\SendMessage;
use DB;
use App\Http\Controllers\Controller;
use App\carContract;
use App\insurance_contract;

class clientsController extends Controller
{
    //
    public function index(){
  $SCclients=client::whereIn('full_name',space_contract::select('full_name')->whereDate('end_date','>=',date('Y-m-d'))->where('contract_status','1')->distinct()->pluck('full_name')->toArray())
      ->where('contract','Space')
      ->orderBy('clients.full_name','asc')->get();
  $SPclients=client::join('space_contracts', 'space_contracts.full_name','=','clients.full_name')->where('contract','Space')->whereDate('end_date','<',date('Y-m-d'))->orwhere('contract_status','0')->orderBy('clients.full_name','asc')->get();
  $carclients=carContract::select('fullName','email','cost_centre')->distinct()->orderBy('fullName','asc')->get();
   $insuranceclients=insurance_contract::orderBy('full_name','asc')->get();
    return view('clients')->with('SCclients',$SCclients)->with('SPclients',$SPclients)->with('carclients',$carclients)->with('insuranceclients',$insuranceclients);
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
       return view('CarClients_view_more')->with('clientname',$name)->with('clientemail',$email)->with('clientcentre',$centre)->with('contracts',$contracts)->with('invoices',$invoices);  
    }

    public function SendMessage(Request $request){
        $name=$request->get('client_name');
        $subject=$request->get('subject');
        $message=$request->get('message');
        if ($request->hasFile('image')) {
        $file = $request->file('image');
        $destinationPath = 'uploads';
        $filename=$file->getClientOriginalName();
        $extension=$file->getClientOriginalExtension();
        $mime=$file->getMimeType();
        $path=$file->getRealPath();
        $file->move($destinationPath,$filename);
    $client=client::where('full_name',$name)->first();
      $client->notify(new SendMessage($name, $subject, $message, $file,$extension,$filename,$mime,$path));
      return redirect()->back()->with('success', 'Message Sent Successfully');
      }
      else{
        return redirect()->back()->with('errors', 'Could not attach file');
      } 
    }
    public function editCarclients(Request $request){
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
