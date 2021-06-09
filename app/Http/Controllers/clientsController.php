<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\client;
use App\space_contract;
use App\Notifications\SendMessage;
use App\Notifications\SendMessage2;
use DB;
use Auth;
use App\Http\Controllers\Controller;
use App\carContract;
use App\cost_centre;
use App\insurance_contract;
use App\insurance_parameter;
use Notification;
use App\research_flats_contract;
use DataTables;

class clientsController extends Controller
{
    //
    public function index(){
//  $SCclients=client::whereIn('full_name',space_contract::select('full_name')->whereDate('end_date','>=',date('Y-m-d'))->where('contract_status','1')->distinct()->pluck('full_name')->toArray())
//      ->where('contract','Space')
//      ->orderBy('clients.full_name','asc')->get();

        $SCclients=client::whereIn('full_name',space_contract::select('full_name')->distinct()->pluck('full_name')->toArray())
            ->where('contract','Space')
            ->orderBy('clients.full_name','asc')->get();


//        $names[]=null;
//        foreach ($SCclients as $client) {
//
//
//            $has_active_contract = DB::table('space_contracts')->where('full_name', $client->full_name)->where('end_date', '>', date('Y-m-d'))->where('contract_status', '1')->get();
//
//
//            if (count($has_active_contract) > 0) {
//
//
//                                                $names=[
//
//                                                'full_name'   => $client->full_name,
//                                                'tin' =>$client->tin,
//                                                'phone_number' =>$client->phone_number,
//                                                'email' =>$client->email,
//                                                'address' =>$client->address,
//                                                'client_id' =>$client->client_id
//
//
//                                                    ];
//
//                                        } else {
////                $names=[
////
////                    'full_name'   => $client->full_name,
////                    'tin' =>$client->tin,
////                    'phone_number' =>$client->phone_number,
////                    'email' =>$client->email,
////                    'address' =>$client->address,
////                    'client_id' =>$client->client_id
////
////
////                ];
//                                            }
//
//        }



  $SPclients=client::select('client_id','email','phone_number','address','clients.full_name','contract_status','tin')->join('space_contracts', 'space_contracts.full_name','=','clients.full_name')->where('contract','Space')->whereDate('end_date','<',date('Y-m-d'))->orwhere('contract_status','0')->orderBy('clients.full_name','asc')->distinct()->get();


  $active_carclients=carContract::select('fullName','email','cost_centre','faculty','tin','id')->distinct()->orderBy('fullName','asc')->get();
  $inactive_carclients=carContract::select('fullName','email','cost_centre','faculty','tin','id')->whereDate('end_date','<',date('Y-m-d'))->where('form_completion','1')->distinct()->orderBy('fullName','asc')->get();
   $insuranceclients=insurance_contract::orderBy('full_name','asc')->get();
   $active_insuranceclients=insurance_contract::select('full_name','email','phone_number','insurance_class','tin','id')->distinct()->orderBy('full_name','asc')->get();
   $inactive_insuranceclients=insurance_contract::select('full_name','email','phone_number','insurance_class','tin','id')->whereDate('end_date','<',date('Y-m-d'))->distinct()->orderBy('full_name','asc')->get();

   $Spemails=client::whereIn('full_name',space_contract::select('full_name')->where('contract_status','1')->distinct()->pluck('full_name')->toArray())
      ->where('contract','Space')
      ->orderBy('clients.full_name','asc')->get();

      $flats_current = research_flats_contract::select('first_name','last_name','address','email','phone_number','tin','id')->distinct()->orderBy('first_name','asc')->get();

      $flats_previous = research_flats_contract::select('first_name','last_name','address','email','phone_number','tin','id')->whereDate('departure_date','<',date('Y-m-d'))->distinct()->orderBy('first_name','asc')->get();

    return view('clients')->with('SCclients',$SCclients)->with('SPclients',$SPclients)->with('active_carclients',$active_carclients)->with('inactive_carclients',$inactive_carclients)->with('insuranceclients',$insuranceclients)->with('active_insuranceclients',$active_insuranceclients)->with('inactive_insuranceclients',$inactive_insuranceclients)->with('Spemails',$Spemails)->with('flats_current',$flats_current)->with('flats_previous',$flats_previous);
    }

    public function edit(Request $request){
        $full_name=$request->get('client_name');
        $email=$request->get('email');
        $phone_number=$request->get('phone_number');
        $address=$request->get('address');
        $tin=$request->get('tin');
    	DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['address' => $address]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['email' => $email]);

        DB::table('clients')
            ->where('full_name', $full_name)
            ->update(['tin' => $tin]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['phone_number' => $phone_number]);


         return redirect()->back()->with('success', 'Client Details Edited Successfully');
    }


    public function editIns(Request $request){
        $full_name=$request->get('client_name');
        $email=$request->get('email');
        $phone_number=$request->get('phone_number');
        $tin=$request->get('tin');
        //$address=$request->get('address');
      DB::table('insurance_contracts')
                ->where('full_name', $full_name)
                ->update(['email' => $email]);


        DB::table('insurance_contracts')
            ->where('full_name', $full_name)
            ->update(['tin' => $tin]);



            DB::table('insurance_contracts')
                ->where('full_name', $full_name)
                ->update(['phone_number' => $phone_number]);


         return redirect()->back()->with('success', 'Client Details Edited Successfully');
    }




    public function editResearchclients(Request $request,$id){

        $email=$request->get('email');
        $phone_number=$request->get('phone_number');
        $tin=$request->get('tin');
        $address=$request->get('address');

        DB::table('research_flats_contracts')
            ->where('id', $id)
            ->update(['email' => $email]);


        DB::table('research_flats_contracts')
            ->where('id', $id)
            ->update(['tin' => $tin]);



        DB::table('research_flats_contracts')
            ->where('id', $id)
            ->update(['phone_number' => $phone_number]);


        DB::table('research_flats_contracts')
            ->where('id', $id)
            ->update(['address' => $address]);


        return redirect()->back()->with('success', 'Client Details Edited Successfully');
    }



    public function ClientViewMore($id){
    $clientname=client::select('full_name')->where('client_id',$id)->value('full_name');
    $details=client::where('client_id',$id)->get();
    $contracts=space_contract::join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','space_contracts.space_id_contract','=','spaces.space_id')->where('space_contracts.full_name',$clientname)->orderBy('contract_id','dsc')->get();
    $invoices=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->where('debtor_name',$clientname)->orderBy('invoice_number','dsc')->get();

    $payments=DB::table('invoices')->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')->join('space_payments','space_payments.invoice_number','=','invoices.invoice_number')->where('debtor_name',$clientname)->orderBy('space_payments.id','desc')->get();



    return view('Spclients_view_more')->with('clientname',$clientname)->with('details',$details)->with('contracts',$contracts)->with('invoices',$invoices)->with('payments',$payments);
    }


    public function getInsuranceClients(Request $request){



        return datatables()->of(DB::table('insurance_contracts')->select('full_name','email','phone_number','insurance_class','tin','id')->distinct()->orderBy('full_name','asc'))->addIndexColumn()
            ->editColumn('tin', function($row){

                if($row->tin==''){

                    return 'N/A';
                }else{

                    return $row->tin;
                }

            })->addColumn('status', function($row){

                                        $has_active_contract=DB::table('insurance_contracts')->where('full_name',$row->full_name)->where('end_date','>',date('Y-m-d'))->where('contract_status','1')->get();

                                        if(count($has_active_contract)>0){

                                          return 'ACTIVE';

                                        }else{
                                            return 'INACTIVE';
                                        }


            })->addColumn('action', function($row){

            $action = '
<a title="View More Details" role="button" href="/clients/insurance/view_more/'.$row->full_name.'/'.$row->email.'/'.$row->phone_number.'"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc;"></i></a>

';

            $privileges=DB::table('users')->join('general_settings','users.role','=','general_settings.user_roles')->where('users.role',Auth::user()->role)->value('privileges');

            if($privileges=='Read only') {


            }else{


                $action.=' <a title="Edit Client Details" data-toggle="modal" data-target="#editIns'.$row->id.'" role="button" aria-pressed="true" id="'.$row->id.'"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
                                                <div class="modal fade" id="editIns'.$row->id.'" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Fill the form below to edit client details</h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form method="post" action="/clients/Insurance/edit">
                                                                    ' . csrf_field() . '
                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="client_name">Client Name</label>
                                                                            <input type="text" id="udia_act_name" name="client_name" class="form-control" value="'.$row->full_name.'" readonly="">
                                                                        </div>
                                                                    </div>


                                                                    <br>

                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="client_name">Insurance Class</label>
                                                                            <input type="text" id="udia_act_class" name="client_class" class="form-control" value="'.$row->insurance_class.'" readonly="">
                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="phone_number">Phone Number<span style="color:red;">*</span></label>

                                                                            <input type="text" id="udia_act_number" name="phone_number" class="form-control" value="'.$row->phone_number.'" required="" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                                   maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">

                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="email">Email<span style="color:red;">*</span></label>
                                                                            <input type="text" id="udia_act_email" name="email" class="form-control" value="'.$row->email.'" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div  class="form-group ">
                                                                        <div class="form-wrapper">
                                                                            <label for="tin">TIN <span style="color: red;"> *</span></label>
                                                                            <span id="tin_msg"></span>
                                                                            <input type="number" id="tin" name="tin" required class="form-control"  value="'.$row->tin.'" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minCharactersInsuranceActive(this.value,'.$row->id.';"  maxlength = "9">
                                                                            <p id="error_tin_insurance_active'.$row->id.'"></p>
                                                                        </div>
                                                                    </div>

                                                                    <br>


                                                                    <br>
                                                                    <input type="text" name="id" value="'.$row->id.'" hidden="">

                                                                    <div align="right">
                                                                        <button class="btn btn-primary" id="insurance_active'.$row->id.'"  type="submit">Save</button>
                                                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';


                if($row->email!=''){

                    $action.='  <a title="Send Email to this Client" data-toggle="modal" data-target="#mailIns'.$row->id.'" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
                                                    <div class="modal fade" id="mailIns'.$row->id.'" role="dialog">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">New Message</h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="/clients/Space/SendMessage" enctype="multipart/form-data">
                                                                        '.csrf_field().'
                                                                        <div class="form-group row">
                                                                            <label for="client_names" class="col-sm-2">To</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="udia_act_names" name="client_name" class="form-control" value="'.$row->full_name.'" readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row">
                                                                            <label for="udia_subject" class="col-sm-2">Subject<span style="color:red;">*</span></label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="udia_subject" name="subject" class="form-control" value="" required="">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row">
                                                                            <label for="udia_greetings" class="col-sm-2">Salutation</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="udia_greetings" name="greetings" class="form-control" value="Dear '.$row->full_name.'" readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="form-group row">
                                                                            <label for="udia_message" class="col-sm-2">Message<span style="color:red;">*</span></label>
                                                                            <div class="col-sm-9">
                                                                                <textarea type="text" id="udia_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="form-group row">
                                                                            <label for="udia_attachment" class="col-sm-2">Attachments</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="file" id="udia_attachment" name="filenames[]" class="myfrm form-control" multiple="">
                                                                                <center><span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="form-group row">
                                                                            <label for="udia_closing" class="col-sm-2">Closing</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="udia_closing" name="closing" class="form-control" value="Regards, University of Dar es Salaam Insurance Agency." readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <input type="text" name="type" value="udia" hidden="">
                                                                        <div align="right">
                                                                            <button class="btn btn-primary" type="submit">Send</button>
                                                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';

                }else{

                $action.='      <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>';

                }

            }

            return $action;

        })->rawColumns(['action','status'])
            ->make(true);



    }




    public function getCarClients(Request $request){



        return datatables()->of(carContract::select('fullName','email','cost_centre','faculty','tin','id')->distinct()->orderBy('fullName','asc'))->addIndexColumn()
            ->editColumn('tin', function($row){

                if($row->tin==''){

                    return 'N/A';
                }else{

                    return $row->tin;
                }

            })->addColumn('status', function($row){


                $has_active_contract=DB::table('car_contracts')->where('fullName',$row->fullName)->where('end_date','>=',date('Y-m-d'))->where('form_completion','1')->get();


                if(count($has_active_contract)>0){

                    return 'ACTIVE';

                }else{
                    return 'INACTIVE';
                }


            })->addColumn('action', function($row){

                $action = '
<a title="View More Details" role="button" href="/clients/car_rental/view_more/'.$row->fullName.'/'.$row->email.'/'.$row->cost_centre.'"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>

';

                $privileges=DB::table('users')->join('general_settings','users.role','=','general_settings.user_roles')->where('users.role',Auth::user()->role)->value('privileges');

                if($privileges=='Read only') {


                }else{


                    $action.=' <a title="Edit Client Details" data-toggle="modal" data-target="#Caredit'.$row->id.'" role="button" aria-pressed="true" id="{{$i}}"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
                                                <div class="modal fade" id="Caredit'.$row->id.'" role="dialog">

                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Fill the form below to edit client details</h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form method="post" action="/clients/Car/edit">
                                                                    '.csrf_field().'
                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="carclient_name{{$i}}">Client Name</label>
                                                                            <input type="text" id="carclient_name{{$i}}" name="client_name" class="form-control" value="'.$row->fullName.'" readonly="">
                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div  class="form-group ">
                                                                        <div class="form-wrapper">
                                                                            <label for="tin">TIN <span style="color: red;"> *</span></label>
                                                                            <span id="tin_msg"></span>
                                                                            <input type="number" id="tin" name="tin" required class="form-control"  value="'.$row->tin.'" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minCharactersCarActive(this.value,'.$row->id.');"  maxlength = "9">
                                                                            <p id="error_tin_car_active'.$row->id.'"></p>
                                                                        </div>
                                                                    </div>

                                                                    <br>

                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="Caremail{{$i}}">Email<span style="color: red;">*</span></label>
                                                                            <input type="text" id="Caremail{{$i}}" name="email" class="form-control" value="'.$row->email.'" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="Carcentre{{$i}}">Cost Centre<span style="color: red;">*</span></label>
                                                                            <select type="text" id="Carcentre{{$i}}" name="cost_centre" class="form-control" required="" onkeyup="filterFunction()">
                                                                                <option value="'.$row->cost_centre.'">'.$row->cost_centre.'-'.$row->faculty.'</option>
                                                                                ';

                                                                                $cost_centres=cost_centre::orderBy('costcentre_id','asc')->get();

                                                                                foreach($cost_centres as $cost_centre){
                                                                                    if($cost_centre->costcentre_id !=$row->cost_centre ){
                                                                                        $action.='<option value="'.$cost_centre->costcentre_id.'">'.$cost_centre->costcentre_id.'-'.$cost_centre->costcentre.'</option>';
                                                                                    }

                                                                                    }
                                                      $action.='
                                                                            </select>


                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="carclient_department{{$i}}">Department/Faculty</label>
                                                                            <input type="text" id="carclient_department{{$i}}" name="department" class="form-control"  readonly="" value="'.$row->faculty.'">
                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <input type="text" name="Caremail" value="'.$row->email.'" hidden="">
                                                                    <input type="text" name="Carcostcentre" value="'.$row->cost_centre.'" hidden="">
                                                                    <input type="text" name="Carfullname" value="'.$row->fullName.'" hidden="">

                                                                    <div align="right">
                                                                        <button class="btn btn-primary" id="car_active'.$row->id.'" type="submit">Save</button>
                                                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';


                    if($row->email!=''){

                        $action.='  <a title="Send Email to this Client" data-toggle="modal" data-target="#carmail{{$i}}" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
                                                    <div class="modal fade" id="carmail{{$i}}" role="dialog">
                                                        <div class="modal-dialog  modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">New Message</h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="/clients/Space/SendMessage" enctype="multipart/form-data">
                                                                        '.csrf_field().'
                                                                        <div class="form-group row">
                                                                            <label for="carclient_names{{$i}}" class="col-sm-2">To</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="carclient_names{{$i}}" name="client_name" class="form-control" value="'.$row->fullName.'" readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row">
                                                                            <label for="carsubject{{$i}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="carsubject{{$i}}" name="subject" class="form-control" value="" >
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="form-group row">
                                                                            <label for="cargreetings{{$i}}" class="col-sm-2">Salutation</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="cargreetings{{$i}}" name="greetings" class="form-control" value="Dear '.$row->fullName.'," readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="form-group row">
                                                                            <label for="carmessage{{$i}}" class="col-sm-2">Body<span style="color: red;">*</span></label>
                                                                            <div class="col-sm-9">
                                                                                <textarea type="text" id="carmessage{{$i}}" name="message" class="form-control" value="" rows="7"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="form-group row">
                                                                            <label for="carattachment{{$i}}" class="col-sm-2">Attachments</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="file" id="carattachment{{$i}}" name="filenames[]" class="myfrm form-control" multiple="">
                                                                                <center><span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row">
                                                                            <label for="carclosing{{$i}}" class="col-sm-2">Closing</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="carclosing{{$i}}" name="closing" class="form-control" value="Regards, Central Pool Transport Unit UDSM." readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <input type="text" name="type" value="car" hidden="">
                                                                        <div align="right">
                                                                            <button class="btn btn-primary" type="submit">Send</button>
                                                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';

                    }else{

                        $action.='      <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>';

                    }

                }

                return $action;

            })->rawColumns(['action','status'])
            ->make(true);



    }


    public function getSpaceClients(Request $request){



        return datatables()->of($SCclients=client::whereIn('full_name',space_contract::select('full_name')->distinct()->pluck('full_name')->toArray())
            ->where('contract','Space')
            ->orderBy('clients.full_name','asc'))->addIndexColumn()
            ->editColumn('tin', function($row){

                if($row->tin==''){

                    return 'N/A';
                }else{

                    return $row->tin;
                }

            })->addColumn('status', function($row){

                $has_active_contract=DB::table('space_contracts')->where('full_name',$row->full_name)->where('end_date','>',date('Y-m-d'))->where('contract_status','1')->get();

                if(count($has_active_contract)>0){

                    return 'ACTIVE';

                }else{
                    return 'INACTIVE';
                }


            })->addColumn('action', function($row){

                $action = '
<a title="View More Details" role="button" href="/clients/Space/view_more/'.$row->client_id.'"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc;"></i></a>
';

                $privileges=DB::table('users')->join('general_settings','users.role','=','general_settings.user_roles')->where('users.role',Auth::user()->role)->value('privileges');

                if($privileges=='Read only') {


                }else{


                    $action.='<a title="Edit Client Details" data-toggle="modal" data-target="#edit'.$row->client_id.'" role="button" aria-pressed="true" id="'.$row->client_id.'"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
                                                <div class="modal fade" id="edit'.$row->client_id.'" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Fill the form below to edit client details</h5></b>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="/clients/Space/edit">
                                                                   ' . csrf_field() . '
                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="client_name'.$row->client_id.'">Client Name</label>
                                                                            <input type="text" id="client_name'.$row->client_id.'" name="client_name" class="form-control" value="'.$row->full_name.'" readonly="">
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="client_type'.$row->client_id.'">Client Type</label>
                                                                            <input type="text" id="client_type'.$row->client_id.'" name="client_type" class="form-control" value="'.$row->type.'" readonly="">
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div  class="form-group ">
                                                                        <div class="form-wrapper">
                                                                            <label for="tin">TIN <span style="color: red;"> *</span></label>
                                                                            <span id="tin_msg"></span>
                                                                            <input type="number" id="tin" name="tin" required class="form-control"  value="'.$row->tin.'" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minCharactersSpaceActive(this.value,'.$row->client_id.');"  maxlength = "9">
                                                                            <p id="error_tin_space_active'.$row->client_id.'"></p>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="phone_number'.$row->client_id.'">Phone Number<span style="color: red;">*</span></label>
                                                                            <input type="text" id="phone_number'.$row->client_id.'" name="phone_number" class="form-control" value="'.$row->phone_number.'" required="" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                                   maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="email'.$row->client_id.'">Email<span style="color: red;">*</span></label>
                                                                            <input type="text" id="email'.$row->client_id.'" name="email" class="form-control" value="'.$row->email.'" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="address'.$row->client_id.'">Address<span style="color: red;">*</span></label>
                                                                            <input type="text" id="address'.$row->client_id.'" name="address" class="form-control" value="'.$row->address.'" required="">
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <input type="text" name="id" value="'.$row->client_id.'" hidden="">
                                                                    <div align="right">
                                                                        <button class="btn btn-primary" id="space_active'.$row->client_id.'" type="submit">Save</button>
                                                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';


                    if($row->email!=''){

                        $action.='   <a title="Send Email to this Client" data-toggle="modal" data-target="#mail'.$row->client_id.'" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
                                                    <div class="modal fade" id="mail'.$row->client_id.'" role="dialog">
                                                        <div class="modal-dialog  modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">New Message</h5></b>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" action="/clients/Space/SendMessage" enctype="multipart/form-data">
                                                                        ' . csrf_field() . '
                                                                        <div class="form-group row">
                                                                            <label for="client_names'.$row->client_id.'" class="col-sm-2">To</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="client_names'.$row->client_id.'" name="client_name" class="form-control" value="'.$row->full_name.'" readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row">
                                                                            <label for="subject'.$row->client_id.'" class="col-sm-2">Subject<span style="color: red;">*</span></label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="subject'.$row->client_id.'" name="subject" class="form-control" value="" required="" >
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row">
                                                                            <label for="greetings'.$row->client_id.'" class="col-sm-2">Salutation</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="greetings'.$row->client_id.'" name="greetings" class="form-control" value="Dear '.$row->full_name.'," readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row">
                                                                            <label for="message'.$row->client_id.'" class="col-sm-2">Body<span style="color: red;">*</span></label>
                                                                            <div class="col-sm-9">
                                                                                <textarea type="text" id="message'.$row->client_id.'" name="message" class="form-control" value="" rows="7" required=""></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row">
                                                                            <label for="attachment'.$row->client_id.'" class="col-sm-2">Attachments</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="file" name="filenames[]" class="myfrm form-control" multiple="">
                                                                                <span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <input type="text" name="type" value="space" hidden="">
                                                                        <div class="form-group row">
                                                                            <label for="closing'.$row->client_id.'" class="col-sm-2">Closing</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="closing'.$row->client_id.'" name="closing" class="form-control" value="Regards, Real Estate Department UDSM." readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div align="right">
                                                                            <button class="btn btn-primary" type="submit">Send</button>
                                                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';

                    }else{

                        $action.='      <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>';

                    }

                }

                return $action;

            })->rawColumns(['action','status'])
            ->make(true);



    }





    public function getResearchClients(Request $request){



        return datatables()->of(research_flats_contract::select('first_name','last_name','address','email','phone_number','tin','id')->distinct()->orderBy('first_name','asc'))->addIndexColumn()
            ->editColumn('tin', function($row){

                if($row->tin==''){

                    return 'N/A';
                }else{

                    return $row->tin;
                }

            })->addColumn('status', function($row){

                $has_active_contract=DB::table('research_flats_contracts')->where('first_name',$row->first_name)->where('last_name',$row->last_name)->where('email',$row->email)->where('departure_date','>=',date('Y-m-d'))->where('contract_status','1')->get();

                if(count($has_active_contract)>0){

                    return 'ACTIVE';

                }else{
                    return 'INACTIVE';
                }


            })->addColumn('action', function($row){

                $action = '
 <a title="View More Details" role="button" href="/clients/Research/view_more/'.$row->first_name.'/'.$row->last_name.'/'.$row->email.'/'.$row->phone_number.'"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc;"></i></a>
';

                $privileges=DB::table('users')->join('general_settings','users.role','=','general_settings.user_roles')->where('users.role',Auth::user()->role)->value('privileges');

                if($privileges=='Read only') {


                }else{


                    $action.='<a title="Edit Client Details" data-toggle="modal" data-target="#edit_research'.$row->id.'" role="button" aria-pressed="true" id="'.$row->client_id.'"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
                                                <div class="modal fade" id="edit_research'.$row->id.'" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Fill the form below to edit client details</h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form method="post" action="/clients/Research/edit/'.$row->id.'">
                                                                    ' . csrf_field() . '
                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="client_name{{$client->id}}">Client Name</label>
                                                                            <input type="text" id="client_name{{$client->id}}" name="client_name" class="form-control" value="'.$row->first_name.' '.$row->last_name.'" readonly="">
                                                                        </div>
                                                                    </div>
                                                                    <br>



                                                                    <div  class="form-group ">
                                                                        <div class="form-wrapper">
                                                                            <label for="tin">TIN <span style="color: red;"> *</span></label>
                                                                            <span id="tin_msg"></span>
                                                                            <input type="number" id="tin" name="tin" required class="form-control"  value="'.$row->tin.'" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minCharactersResearchActive(this.value,'.$row->id.');"  maxlength = "9">
                                                                            <p id="error_tin_research_active'.$row->id.'"></p>
                                                                        </div>
                                                                    </div>

                                                                    <br>


                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="phone_number{{$client->id}}">Phone Number<span style="color: red;">*</span></label>

                                                                            <input type="text" id="phone_number{{$client->id}}" name="phone_number" class="form-control" value="'.$row->phone_number.'" required="" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                                   maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">

                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="email{{$client->id}}">Email<span style="color: red;">*</span></label>
                                                                            <input type="text" id="email{{$client->id}}" name="email" class="form-control" value="'.$row->email.'" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="address{{$client->id}}">Address<span style="color: red;">*</span></label>
                                                                            <input type="text" id="address{{$client->id}}" name="address" class="form-control" value="'.$row->address.'" required="">
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <input type="text" name="id" value="'.$row->id.'" hidden="">

                                                                    <div align="right">
                                                                        <button class="btn btn-primary" id="research_active{{$client->id}}" type="submit">Save</button>
                                                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';


                    if($row->email!=''){

                        $action.='  <a title="Send Email to this Client" data-toggle="modal" data-target="#mail'.$row->id.'" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
                                                    <div class="modal fade" id="mail'.$row->id.'" role="dialog">
                                                        <div class="modal-dialog  modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">New Message</h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="/clients/Space/SendMessage" enctype="multipart/form-data">
                                                                        ' . csrf_field() . '
                                                                        <div class="form-group row">
                                                                            <label for="client_names{{$client->id}}" class="col-sm-2">To</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="client_names{{$client->id}}" name="client_name" class="form-control" value="'.$row->first_name.' '.$row->last_name.'" readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row">
                                                                            <label for="subject{{$client->id}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="subject{{$client->id}}" name="subject" class="form-control" value="" required="" >
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row">
                                                                            <label for="greetings{{$client->id}}" class="col-sm-2">Salutation</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="greetings{{$client->id}}" name="greetings" class="form-control" value="Dear '.$row->first_name.' '.$row->last_name.'," readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="form-group row">
                                                                            <label for="message{{$client->id}}" class="col-sm-2">Body<span style="color: red;">*</span></label>
                                                                            <div class="col-sm-9">
                                                                                <textarea type="text" id="message{{$client->id}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="form-group row">
                                                                            <label for="attachment{{$client->id}}" class="col-sm-2">Attachments</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="file" name="filenames[]" class="myfrm form-control" multiple="">
                                                                                <span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span>
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <input type="text" name="type" value="flats" hidden="">
                                                                        <input type="text" name="contract_id" value="'.$row->id.'" hidden="">

                                                                        <div class="form-group row">
                                                                            <label for="closing{{$client->id}}" class="col-sm-2">Closing</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" id="closing{{$client->id}}" name="closing" class="form-control" value="Regards, Research Flats UDSM." readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div align="right">
                                                                            <button class="btn btn-primary" type="submit">Send</button>
                                                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';

                    }else{

                        $action.=' <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>';

                    }

                }

                return $action;

            })->addColumn('full_name',function ($row){

                return $row->first_name.' '.$row->last_name;


            })->rawColumns(['action','status','full_name'])
            ->make(true);



    }






    public function CarViewMore($name, $email, $centre){
        $contracts=carContract::select('car_contracts.*','vehicle_model','hire_rate','vehicle_status')->join('car_rentals','car_contracts.vehicle_reg_no','=','car_rentals.vehicle_reg_no')->where('email',$email)->where('fullName',$name)->where('cost_centre',$centre)->get();
        $invoices= DB::table('car_rental_invoices')
                   ->whereIn('contract_id',DB::table('car_contracts')->select('id')->where('email',$email)->where('fullName',$name)->where('cost_centre',$centre)->pluck('id')->toArray())
                   ->get();


        $payments= DB::table('car_rental_invoices')
            ->whereIn('contract_id',DB::table('car_contracts')->select('id')->where('email',$email)->where('fullName',$name)->where('cost_centre',$centre)->pluck('id')->toArray())->join('car_rental_payments','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
            ->get();


       return view('carClients_view_more')->with('clientname',$name)->with('clientemail',$email)->with('clientcentre',$centre)->with('contracts',$contracts)->with('invoices',$invoices)->with('payments',$payments);
    }


    public function InsuranceViewMore($name, $email, $phone_number){
      $contracts=insurance_contract::where('email',$email)->where('full_name',$name)->where('phone_number',$phone_number)->get();
      $total_commision_tzs=insurance_contract::select('commission')->where('email',$email)->where('full_name',$name)->where('phone_number',$phone_number)->where('currency','TZS')->sum('commission');
      $total_commision_usd=insurance_contract::select('commission')->where('email',$email)->where('full_name',$name)->where('phone_number',$phone_number)->where('currency','USD')->sum('commission');
      $total_premium_tzs=insurance_contract::select('premium')->where('email',$email)->where('full_name',$name)->where('phone_number',$phone_number)->where('currency','TZS')->sum('premium');
      $total_premium_usd=insurance_contract::select('premium')->where('email',$email)->where('full_name',$name)->where('phone_number',$phone_number)->where('currency','USD')->sum('premium');
       return view('insurance_view_more')->with('clientname',$name)->with('clientemail',$email)->with('phone_number',$phone_number)->with('contracts',$contracts)->with('total_commision_tzs',$total_commision_tzs)->with('total_commision_usd',$total_commision_usd)->with('total_premium_tzs',$total_premium_tzs)->with('total_premium_usd',$total_premium_usd);
    }



    public function ResearchClientsViewMore($first_name,$last_name, $email, $phone_number){
        $contracts=DB::table('research_flats_contracts')->where('email',$email)->where('first_name',$first_name)->where('last_name',$last_name)->where('phone_number',$phone_number)->get();

        $invoices=DB::table('research_flats_invoices')->whereIn('contract_id',DB::table('research_flats_contracts')->select('id')->where('email',$email)->where('first_name',$first_name)->where('last_name',$last_name)->where('phone_number',$phone_number))->get();

        $payments=DB::table('research_flats_invoices')->whereIn('contract_id',DB::table('research_flats_contracts')->select('id')->where('email',$email)->where('first_name',$first_name)->where('last_name',$last_name)->where('phone_number',$phone_number))->join('research_flats_payments','research_flats_invoices.invoice_number','=','research_flats_payments.invoice_number')->get();

        return view('research_clients_view_more')->with('clientname',$first_name.' '.$last_name)->with('clientemail',$email)->with('phone_number',$phone_number)->with('contracts',$contracts)->with('invoices',$invoices)->with('payments',$payments);
    }

    public function InsuranceClientsViewMore($full_name, $email, $phone_number){
        $contracts=DB::table('insurance_contracts')->where('email',$email)->where('full_name',$full_name)->where('phone_number',$phone_number)->get();

        $invoices=DB::table('insurance_invoices_clients')->whereIn('contract_id',DB::table('insurance_contracts')->select('id')->where('email',$email)->where('full_name',$full_name)->where('phone_number',$phone_number))->get();

        $payments=DB::table('insurance_invoices_clients')->whereIn('contract_id',DB::table('insurance_contracts')->select('id')->where('email',$email)->where('full_name',$full_name)->where('phone_number',$phone_number))->join('insurance_clients_payments','insurance_invoices_clients.invoice_number','=','insurance_clients_payments.invoice_number')->get();

        return view('insurance_clients_view_more')->with('clientname',$full_name)->with('clientemail',$email)->with('phone_number',$phone_number)->with('contracts',$contracts)->with('invoices',$invoices)->with('payments',$payments);
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
            //          $debtor = $request->get('debtor');
            $contract_id = $request->get('contract_id');
            $client = research_flats_contract::where('id',$contract_id)->first();
//          if($debtor=='individual'){
//            $client = research_flat_contract::where('id',$contract_id)->first();
//          }
//          elseif($debtor=='host'){
//            $client = research_flat_contract::select('host_email as email')->where('id',$contract_id)->first();
//          }


            $salutation = "Research Flats UDSM";
            $client->notify(new SendMessage($name, $subject, $message,$filepaths,$salutation));
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
//          $debtor = $request->get('debtor');
          $contract_id = $request->get('contract_id');
          $client = research_flats_contract::where('id',$contract_id)->first();
//          if($debtor=='individual'){
//            $client = research_flat_contract::where('id',$contract_id)->first();
//          }
//          elseif($debtor=='host'){
//            $client = research_flat_contract::select('host_email as email')->where('id',$contract_id)->first();
//          }
            $salutation = "Research Flats UDSM";
            $client->notify(new SendMessage2($name, $subject, $message, $salutation));
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
             $spilted_name=explode(' ', $name);
             $first_name=$spilted_name[0];
             $last_name=$spilted_name[1];

             $client=research_flats_contract::select('email')->where('first_name',$first_name)->where('last_name',$last_name)->latest('id')->first();
             $salutation = "Research Flats UDSM.";
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
            $spilted_name=explode(' ', $name);
            $first_name=$spilted_name[0];
            $last_name=$spilted_name[1];

            $client=research_flats_contract::select('email')->where('first_name',$first_name)->where('last_name',$last_name)->latest('id')->first();
            $salutation = "Research Flats UDSM.";
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



        DB::table('car_contracts')
            ->where('email',$request->get('Caremail'))
            ->where('fullName',$request->get('Carfullname'))
            ->where('cost_centre',$request->get('Carcostcentre'))
            ->update(['tin' => $request->get('tin')]);



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
