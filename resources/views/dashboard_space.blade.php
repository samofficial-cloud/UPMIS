@extends('layouts.app')

@section('style')
<style type="text/css">
  div.dataTables_filter{
    padding-left:878px;
    padding-bottom:20px;
  }

  div.dataTables_length label {
    font-weight: normal;
    text-align: left;
    white-space: nowrap;
    display: inline-block;
  }

  div.dataTables_length select {
    height:25px;
    width:10px;
    font-size: 70%;
  }
  table.dataTable {
    font-family:"Nunito", sans-serif;
    font-size: 15px;



  }
  table.dataTable.no-footer {
    border-bottom: 0px solid #111;
  }

  hr {
    margin-top: 0rem;
    margin-bottom: 2rem;
    border: 0;
    border: 1px solid #505559;
  }
  .form-inline .form-control {
    width: 100%;
  }

  .form-wrapper{
    width: 100%
  }

  .form-inline label {
    justify-content: left;
  }

  /*.card:hover {
    cursor: not-allowed;
    animation-duration: 20ms;
    animation-timing-function: linear;
    animation-iteration-count: 10;
    animation-name: wiggle;
  }*/

  .modal:hover{
    animation: none !important;
  }
  
  @keyframes wiggle {
  0% { transform: translate(0px, 0); }
 /* 10% { transform: translate(-1px, 0); }
  20% { transform: translate(1px, 0); }
  30% { transform: translate(-1px, 0); }
  40% { transform: translate(1px, 0); }
  50% { transform: translate(-2px, 0); }
  60% { transform: translate(2px, 0); }
  70% { transform: translate(-2px, 0); }*/
  80% { transform: translate(2px, 0); }
  90% { transform: translate(-2px, 0); }
  100% { transform: translate(0, 0); }
}
</style>

@endsection
@section('content')
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">

            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>
            
            @if($category=='All')
           <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Insurance only')
          <li><a href="{{ route('home2') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Real Estate only')
          <li><a href="{{ route('home4') }}"><i class="fas fa-home active"></i>Home</a></li>
           @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home3') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role=='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home5') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role=='Accountant-Cost Centre'))
            <li><a href="{{ route('home5') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif

            @if($category=='Real Estate only' OR $category=='All')
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            @else
            @endif

            @if($category=='Insurance only' OR $category=='All')
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
    @else
    @endif
            @if(($category=='CPTU only' OR $category=='All') && (Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
    @else
    @endif
    @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
    
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>      
    @endif
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>

<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
 @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
  @endif
@admin
            <li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
<div class="main_content">
  <?php
   use App\space;
  use App\space_contract;
  $total_spaces=space::where('status','1')->count();
  $occupied_spaces=space_contract::select('space_id_contract')->where('contract_status','1')->wheredate('end_date','>',date('Y-m-d'))->distinct()->count();
  $available_spaces=space::select('space_id')
        ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>',date('Y-m-d'))->where('contract_status','1')->distinct()->pluck('space_id_contract')->toArray())
        ->where('status','1')
        ->distinct()
        ->count();
  $main=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','J.K Nyerere')->whereDate('end_date','>=',date('Y-m-d'))->count();
  $knyama=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Kijitonyama')->whereDate('end_date','>=',date('Y-m-d'))->count();
  $kunduchi=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Kunduchi')->whereDate('end_date','>=',date('Y-m-d'))->count();
  $mabibo=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Mabibo')->whereDate('end_date','>=',date('Y-m-d'))->count();
  $mikocheni=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Mikocheni')->whereDate('end_date','>=',date('Y-m-d'))->count();
  $mlimani=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Mlimani City')->whereDate('end_date','>=',date('Y-m-d'))->count();
  $ubungo=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Ubungo')->whereDate('end_date','>=',date('Y-m-d'))->count();

  $i='1';
  ?>
    <br>

    <div class="container" style="max-width: 1180px;">
      <br>
      @if ($message = Session::get('errors'))
          <div class="alert alert-danger">
            <p>{{$message}}</p>
          </div>
        @endif

      @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{$message}}</p>
      </div>
    @endif
 <div class="card">
   <div class="card-body">  
<div class="card-columns" style="margin-top: 10px;">
  <div class="card border-primary">
    {!! $chart->container() !!}
  </div>
  <div class="card bg-primary text-white">
    <div class="card-body" style="line-height: 25px;" >
      <h5 class="card-title">General Statistics<i class="fa fa-line-chart" style="font-size:30px; float: right; color: black;"></i></h5>
       Available Spaces: {{$available_spaces}}
      <br>Occupied Spaces: {{$occupied_spaces}}
      <br>Total Spaces: {{$total_spaces}}
      <hr style="margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border: 1px solid #505559;">
    <h5 class="card-title">Client Statistics {{date('Y')}}</h5>
      J.K. Nyerere Clients: {{$main}}
      <br>Kijitonyama Clients: {{$knyama}}
      <br>Kunduchi Clients: {{$kunduchi}}
      <br>Mabibo Clients: {{$mabibo}}
      <br>Mikocheni Clients: {{$mikocheni}}
      <br>Mlimani City Clients: {{$mlimani}}
      <br>Ubungo Clients: {{$ubungo}}
      <br>Total Clients: {{$main + $knyama + $kunduchi +  $mabibo +$mikocheni + $mlimani + $ubungo}}
    </div>
  </div>
  
   <div class="card border-primary">
    {!! $chart1->container() !!}
  </div>
</div>
</div>
 </div> 
   
  <br>
    <div class="card">
    <div class="card-body">
     <h4 class="card-title" style="font-family: sans-serif;">Contract(s) that are about to expire</h4>
     <hr>
     <a title="Send email to selected clients" href="#" id="notify_all" class="btn btn-info btn-sm" data-toggle="modal" data-target="#inia_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="inia_mail" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content" style="width: 115%;">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="inia_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="inia_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="inia_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>    
        
        <div class="form-group row">
            <label for="inia_subject" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="inia_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="inia_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="inia_greetings" name="greetings" class="form-control" value="Dear," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="inia_message" class="col-sm-2">Body</label>
            <div class="col-sm-9">
              <textarea type="text" id="inia_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         //echo 'Select the file to upload.';
         echo Form::file('image');
         //echo Form::submit('Upload File');
         //echo Form::close();
      ?>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="inia_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="inia_closing" name="closing" class="form-control" value="Regards, DPDI." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="space" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
      <table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
        <tr>
          <th scope="col" style="width: 5%;">S/N</th>
          <th scope="col" style="width: 25%;">Client</th>
          <th scope="col">Lease Start</th>
          <th scope="col" >Lease End</th>
          <th scope="col" >Rent Price</th>
          <th scope="col" >Escalation Rate</th>
          <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
          @foreach($contracts as $space)
          <tr>

            <th scope="row" class="counterCell">.</th>

              
               <td>
                                      <a title="View More Client Details" class="link_style" data-toggle="modal" data-target="#clientaz{{$space->contract_id}}" style="color: blue !important; cursor: pointer;" aria-pressed="true">{{$space->full_name}}</a>
                  <div class="modal fade" id="clientaz{{$space->contract_id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">{{$space->full_name}} Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                  <table style="width: 100%">
                                      <tr>
                                          <td>Client Type:</td>
                                          <td>{{$space->type}}</td>
                                      </tr>
                                      @if($space->type=='Individual')
                                          <tr>
                                              <td> First Name:</td>
                                              <td> {{$space->first_name}}</td>
                                          </tr>
                                          <tr>
                                              <td>Last Name:</td>
                                              <td>{{$space->last_name}}</td>
                                          </tr>
                                      @elseif($space->type=='Company/Organization')
                                          <tr>
                                              <td>Company Name:</td>
                                              <td>{{$space->company_name}}</td>
                                          </tr>
                                      @endif
                                      <tr>
                                          <td>Phone Number:</td>
                                          <td>{{$space->phone_number}}</td>
                                      </tr>
                                      <tr>
                                          <td>Email:</td>
                                          <td>{{$space->email}}</td>
                                      </tr>
                                      <tr>
                                          <td>Address:</td>
                                          <td>{{$space->address}}</td>
                                      </tr>
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                          </div>
                      </div>
                  </div>
                                    </td>
              <td><center>{{date("d/m/Y",strtotime($space->start_date))}}</center></td>
              <td><center>{{date("d/m/Y",strtotime($space->end_date))}}</center></td>
              <td>{{$space->currency}} {{number_format($space->amount)}}</td>
              <td>{{$space->escalation_rate}}</td>
              <td><a href="{{ route('renew_space_contract_form',$space->contract_id) }}" title="Click to renew this contract"><i class="fa fa-refresh" style="font-size:25px;"></i></a>
                 <a data-toggle="modal" data-target="#mail{{$space->client_id}}" role="button" aria-pressed="true" title="Click to notify this client"><i class="fa fa-envelope" aria-hidden="true" style="font-size:25px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="mail{{$space->client_id}}" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="client_names{{$space->client_id}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="client_names{{$space->client_id}}" name="client_name" class="form-control" value="{{$space->full_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="subject{{$space->client_id}}" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="subject{{$space->client_id}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>
         
        <div class="form-group row">
            <label for="message{{$space->client_id}}" class="col-sm-2">Message</label>
            <div class="col-sm-9">
              <textarea type="text" id="message{{$space->client_id}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment{{$space->client_id}}" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         //echo 'Select the file to upload.';
         echo Form::file('image');
         //echo Form::submit('Upload File');
         //echo Form::close();
      ?>
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
     </div>
              </td>
          </tr>

          @endforeach

        </tbody>
</table>
    </div>
  </div>
   <br>
   <div class="card">
    <div class="card-body">
     <h4 class="card-title" style="font-family: sans-serif;">Outstanding Space Debt(s)</h4>
     <hr>
     <a title="Send email to selected clients" href="#" id="debt_notify_all" class="btn btn-info btn-sm" data-toggle="modal" data-target="#debt_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="debt_mail" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content" style="width: 115%;">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="debt_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="debt_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="debt_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>    
        
        <div class="form-group row">
            <label for="debt_subject" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="debt_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="debt_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="debt_greetings" name="greetings" class="form-control" value="Dear," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="debt_message" class="col-sm-2">Body</label>
            <div class="col-sm-9">
              <textarea type="text" id="debt_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         //echo 'Select the file to upload.';
         echo Form::file('image');
         //echo Form::submit('Upload File');
         //echo Form::close();
      ?>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="debt_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="debt_closing" name="closing" class="form-control" value="Regards, DPDI." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="space" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     <table class="hover table table-striped table-bordered" id="myTable1">
  <thead class="thead-dark">
                            <tr>
                                <th scope="col"><center>S/N</center></th>
                                <th scope="col" >Debtor Name</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col" >Start Date</th>
                                <th scope="col" >End date</th>
                                <th scope="col">Contract Id</th>
                                <th scope="col" style="width: 12%;">Amount</th>
                                <th scope="col" >Invoice Date</th>
                                <th scope="col" >Action</th>  
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $var)
                                <tr>
                                    <th scope="row" class="counterCell">.</th>
                                    <td>
                                      <a title="View More Client Details" class="link_style" data-toggle="modal" data-target="#clienta{{$var->contract_id}}" style="color: blue !important; cursor: pointer;" aria-pressed="true">{{$var->debtor_name}}</a>
                  <div class="modal fade" id="clienta{{$var->contract_id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">{{$var->full_name}} Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                  <table style="width: 100%">
                                      <tr>
                                          <td>Client Type:</td>
                                          <td>{{$var->type}}</td>
                                      </tr>
                                      @if($var->type=='Individual')
                                          <tr>
                                              <td> First Name:</td>
                                              <td> {{$var->first_name}}</td>
                                          </tr>
                                          <tr>
                                              <td>Last Name:</td>
                                              <td>{{$var->last_name}}</td>
                                          </tr>
                                      @elseif($var->type=='Company/Organization')
                                          <tr>
                                              <td>Company Name:</td>
                                              <td>{{$var->company_name}}</td>
                                          </tr>
                                      @endif
                                      <tr>
                                          <td>Phone Number:</td>
                                          <td>{{$var->phone_number}}</td>
                                      </tr>
                                      <tr>
                                          <td>Email:</td>
                                          <td>{{$var->email}}</td>
                                      </tr>
                                      <tr>
                                          <td>Address:</td>
                                          <td>{{$var->address}}</td>
                                      </tr>
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                          </div>
                      </div>
                  </div>
                                    </td>
                                    <td><center>{{$var->invoice_number}}</center></td>

                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                    <td>
                                       <a title="View contract" class="link_style" style="color: blue !important; cursor: pointer;"  class="" data-toggle="modal" data-target="#contracta{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center>{{$var->contract_id}}</center></a>
                                            <div class="modal fade" id="contracta{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Contract Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%">

                                                                <tr>
                                                                    <td>Contract ID:</td>
                                                                    <td>{{$var->contract_id}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Client :</td>
                                                                    <td>{{$var->full_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Space Number:</td>
                                                                    <td> {{$var->space_id_contract}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Amount:</td>
                                                                    <td> {{$var->currency}} {{number_format($var->amount)}} </td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle:</td>
                                                                    <td>{{$var->payment_cycle}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract Start Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract End Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle Start Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->programming_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle End Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->programming_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Escalation Rate:</td>
                                                                    <td>{{$var->escalation_rate}} </td>
                                                                </tr>




                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </td>
                                    <td>{{$var->currency_invoice}} {{number_format($var->amount_to_be_paid)}}</td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                    <td>
                                      <a title="Send Email to this Client" data-toggle="modal" data-target="#spacemail{{$var->invoice_number}}" role="button" aria-pressed="true"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
      <div class="modal fade" id="spacemail{{$var->invoice_number}}" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="spaceclient_names{{$var->invoice_number}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="spaceclient_names{{$var->invoice_number}}" name="client_name" class="form-control" value="{{$var->debtor_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="spacesubject{{$var->invoice_number}}" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="spacesubject{{$var->invoice_number}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="spacegreetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="spacegreetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="spacemessage{{$var->invoice_number}}" class="col-sm-2">Body</label>
            <div class="col-sm-9">
              <textarea type="text" id="spacemessage{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="spaceattachment{{$var->invoice_number}}" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         echo Form::file('image');
      ?>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="spaceclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="spaceclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, DPDI." readonly="">
          </div>
        </div>
        <br>
        <input type="text" name="type" value="space" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
                                    </td>  
                                  </tr>
                                  
                                  @endforeach
                                </tbody>
</table>
</div>
</div>
<br>
   <div class="card">
    <div class="card-body">
     <h4 class="card-title" style="font-family: sans-serif;">Outstanding Electricity Bill Debt(s)</h4>
     <hr>
     <a title="Send email to selected clients" href="#" id="electric_notify_all" class="btn btn-info btn-sm" data-toggle="modal" data-target="#electric_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="electric_mail" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content" style="width: 115%;">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="electric_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="electric_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="electric_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>    
        
        <div class="form-group row">
            <label for="electric_subject" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="electric_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="electric_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="electric_greetings" name="greetings" class="form-control" value="Dear," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="electric_message" class="col-sm-2">Body</label>
            <div class="col-sm-9">
              <textarea type="text" id="electric_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         //echo 'Select the file to upload.';
         echo Form::file('image');
         //echo Form::submit('Upload File');
         //echo Form::close();
      ?>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="electric_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="electric_closing" name="closing" class="form-control" value="Regards, DPDI." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="space" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     <table class="hover table table-striped table-bordered" id="myTable2">
  <thead class="thead-dark">
                            <tr>
                                <th scope="col"><center>S/N</center></th>
                                <th scope="col" >Debtor Name</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col" >Start Date</th>
                                <th scope="col" >End date</th>
                                <th scope="col">Contract Id</th>
                                <th scope="col" >Amount</th>
                                <th scope="col" >Invoice Date</th>
                                <th scope="col" >Action</th>  
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($electric_invoices as $var)
                                <tr>
                                    <th scope="row" class="counterCell">.</th>
                                    <td>
                                      <a title="View More Client Details" class="link_style" data-toggle="modal" data-target="#clientb{{$var->contract_id}}" style="color: blue !important; cursor: pointer;" aria-pressed="true">{{$var->debtor_name}}</a>
                  <div class="modal fade" id="clientb{{$var->contract_id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">{{$var->full_name}} Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                  <table style="width: 100%">
                                      <tr>
                                          <td>Client Type:</td>
                                          <td>{{$var->type}}</td>
                                      </tr>
                                      @if($var->type=='Individual')
                                          <tr>
                                              <td> First Name:</td>
                                              <td> {{$var->first_name}}</td>
                                          </tr>
                                          <tr>
                                              <td>Last Name:</td>
                                              <td>{{$var->last_name}}</td>
                                          </tr>
                                      @elseif($var->type=='Company/Organization')
                                          <tr>
                                              <td>Company Name:</td>
                                              <td>{{$var->company_name}}</td>
                                          </tr>
                                      @endif
                                      <tr>
                                          <td>Phone Number:</td>
                                          <td>{{$var->phone_number}}</td>
                                      </tr>
                                      <tr>
                                          <td>Email:</td>
                                          <td>{{$var->email}}</td>
                                      </tr>
                                      <tr>
                                          <td>Address:</td>
                                          <td>{{$var->address}}</td>
                                      </tr>
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                          </div>
                      </div>
                  </div>
                                      </td>
                                    <td><center>{{$var->invoice_number}}</center></td>

                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                   {{--  <td>{{$var->period}}</td> --}}
                                    <td>
                                      <a title="View contract" class="link_style" style="color: blue !important; cursor: pointer;"  class="" data-toggle="modal" data-target="#contractb{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center>{{$var->contract_id}}</center></a>
                                            <div class="modal fade" id="contractb{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Contract Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%">

                                                                <tr>
                                                                    <td>Contract ID:</td>
                                                                    <td>{{$var->contract_id}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Client :</td>
                                                                    <td>{{$var->full_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Space Number:</td>
                                                                    <td> {{$var->space_id_contract}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Amount:</td>
                                                                    <td> {{$var->currency}} {{number_format($var->amount)}} </td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle:</td>
                                                                    <td>{{$var->payment_cycle}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract Start Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract End Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle Start Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->programming_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle End Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->programming_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Escalation Rate:</td>
                                                                    <td>{{$var->escalation_rate}} </td>
                                                                </tr>




                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                      </td>
                                    <td>{{$var->currency_invoice}} {{number_format($var->cumulative_amount)}}</td>
                                   {{--  <td>{{$var->gepg_control_no}}</td> --}}
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                    <td>
                                      <a title="Send Email to this Client" data-toggle="modal" data-target="#electric_mail{{$var->invoice_number}}" role="button" aria-pressed="true"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
      <div class="modal fade" id="electric_mail{{$var->invoice_number}}" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="electric_client_names{{$var->invoice_number}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="electric_client_names{{$var->invoice_number}}" name="client_name" class="form-control" value="{{$var->debtor_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="electric_subject{{$var->invoice_number}}" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="electric_subject{{$var->invoice_number}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="electric_greetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="electric_greetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="electric_message{{$var->invoice_number}}" class="col-sm-2">Body</label>
            <div class="col-sm-9">
              <textarea type="text" id="electric_message{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="electric_attachment{{$var->invoice_number}}" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         echo Form::file('image');
      ?>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="electric_closing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="electric_closing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, DPDI." readonly="">
          </div>
        </div>
        <br>
        <input type="text" name="type" value="space" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
                                    </td>  
                                  </tr>
                                  
                                  @endforeach
                                </tbody>
</table>
</div>
</div>
<br>
   <div class="card">
    <div class="card-body">
     <h4 class="card-title" style="font-family: sans-serif;">Outstanding Water Bill Debt(s)</h4>
     <hr>
     <a title="Send email to selected clients" href="#" id="water_notify_all" class="btn btn-info btn-sm" data-toggle="modal" data-target="#water_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="water_mail" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content" style="width: 115%;">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="water_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="water_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="water_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>    
        
        <div class="form-group row">
            <label for="water_subject" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="water_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="water_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="water_greetings" name="greetings" class="form-control" value="Dear," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="water_message" class="col-sm-2">Body</label>
            <div class="col-sm-9">
              <textarea type="text" id="water_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         //echo 'Select the file to upload.';
         echo Form::file('image');
         //echo Form::submit('Upload File');
         //echo Form::close();
      ?>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="water_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="water_closing" name="closing" class="form-control" value="Regards, DPDI." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="space" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     <table class="hover table table-striped table-bordered" id="myTable3">
  <thead class="thead-dark">
                            <tr>
                                <th scope="col"><center>S/N</center></th>
                                <th scope="col" >Debtor Name</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col" >Start Date</th>
                                <th scope="col" >End date</th>
                               {{--  <th scope="col" >Period</th> --}}
                                <th scope="col">Contract Id</th>
                                <th scope="col" >Amount</th>
                                {{-- <th scope="col" >GEPG Control No</th> --}}
                                <th scope="col" >Invoice Date</th>
                                <th scope="col" >Action</th>  
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($water_invoices as $var)
                                <tr>
                                    <th scope="row" class="counterCell">.</th>
                                    <td>
                                       <a title="View More Client Details" class="link_style" data-toggle="modal" data-target="#clientc{{$var->contract_id}}" style="color: blue !important; cursor: pointer;" aria-pressed="true">{{$var->debtor_name}}</a>
                  <div class="modal fade" id="clientc{{$var->contract_id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">{{$var->full_name}} Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                  <table style="width: 100%">
                                      <tr>
                                          <td>Client Type:</td>
                                          <td>{{$var->type}}</td>
                                      </tr>
                                      @if($var->type=='Individual')
                                          <tr>
                                              <td> First Name:</td>
                                              <td> {{$var->first_name}}</td>
                                          </tr>
                                          <tr>
                                              <td>Last Name:</td>
                                              <td>{{$var->last_name}}</td>
                                          </tr>
                                      @elseif($var->type=='Company/Organization')
                                          <tr>
                                              <td>Company Name:</td>
                                              <td>{{$var->company_name}}</td>
                                          </tr>
                                      @endif
                                      <tr>
                                          <td>Phone Number:</td>
                                          <td>{{$var->phone_number}}</td>
                                      </tr>
                                      <tr>
                                          <td>Email:</td>
                                          <td>{{$var->email}}</td>
                                      </tr>
                                      <tr>
                                          <td>Address:</td>
                                          <td>{{$var->address}}</td>
                                      </tr>
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                          </div>
                      </div>
                  </div>
                                    </td>
                                    <td><center>{{$var->invoice_number}}</center></td>

                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                   {{--  <td>{{$var->period}}</td> --}}
                                    <td>
                                       <a title="View contract" class="link_style" style="color: blue !important; cursor: pointer;"  class="" data-toggle="modal" data-target="#contractc{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center>{{$var->contract_id}}</center></a>
                                            <div class="modal fade" id="contractc{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Contract Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%">

                                                                <tr>
                                                                    <td>Contract ID:</td>
                                                                    <td>{{$var->contract_id}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Client :</td>
                                                                    <td>{{$var->full_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Space Number:</td>
                                                                    <td> {{$var->space_id_contract}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Amount:</td>
                                                                    <td> {{$var->currency}} {{number_format($var->amount)}} </td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle:</td>
                                                                    <td>{{$var->payment_cycle}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract Start Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract End Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle Start Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->programming_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle End Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->programming_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Escalation Rate:</td>
                                                                    <td>{{$var->escalation_rate}} </td>
                                                                </tr>




                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </td>
                                    <td>{{$var->currency_invoice}} {{number_format($var->cumulative_amount)}}</td>
                                   {{--  <td>{{$var->gepg_control_no}}</td> --}}
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                    <td>
                                      <a title="Send Email to this Client" data-toggle="modal" data-target="#watermail{{$var->invoice_number}}" role="button" aria-pressed="true"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
      <div class="modal fade" id="watermail{{$var->invoice_number}}" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="waterclient_names{{$var->invoice_number}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="waterclient_names{{$var->invoice_number}}" name="client_name" class="form-control" value="{{$var->debtor_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="watersubject{{$var->invoice_number}}" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="watersubject{{$var->invoice_number}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="watergreetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="watergreetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="watermessage{{$var->invoice_number}}" class="col-sm-2">Body</label>
            <div class="col-sm-9">
              <textarea type="text" id="watermessage{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="waterattachment{{$var->invoice_number}}" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         echo Form::file('image');
      ?>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="waterclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="waterclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, DPDI." readonly="">
          </div>
        </div>
        <br>
        <input type="text" name="type" value="space" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
                                    </td>  
                                  </tr>
                                  
                                  @endforeach
                                </tbody>
</table>
</div>
</div>
      
    </div>
</div>
</div>
@endsection

@section('pagescript')
<script type="text/javascript">
   $(document).ready(function(){
  var table = $('#myTable').DataTable( {
    dom: '<"top"l>rt<"bottom">'
  } );

  var table1 = $('#myTable1').DataTable( {
    dom: '<"top"l>rt<"bottom">'
  } );

  var tablee1 = $('#myTable2').DataTable( {
    dom: '<"top"l>rt<"bottom">'
  } );

  var tablee2 = $('#myTable3').DataTable( {
    dom: '<"top"l>rt<"bottom">'
  } );

  var table2 = $('#myTable').DataTable();
 
    $('#myTable tbody').on( 'click', 'tr', function () {
      document.getElementById("inia_par_names").innerHTML="";
        $(this).toggleClass('selected');
         var count2=table2.rows('.selected').data().length +' row(s) selected';
    if(count2>'2'){
      $('#notify_all').show();
    }
    else{
      $('#notify_all').hide();
    }
    });
    $('#notify_all').click( function () {
        var datas6 = table2.rows('.selected').data();
        var link = datas6[0][1];
        var result6 = [];
        for (var i = 0; i < datas6.length; i++)
        {
                result6.push(datas6[i][1].split('"true">').pop().split('</a>')[0]);
        }

        $('#inia_client_names').val(result6).toString();
        
        var content6 = document.getElementById("inia_par_names");
        for(var i=0; i< result6.length;i++){
          if(i==(result6.length-1)){
            content6.innerHTML += result6[i]+ '.';
          }
          else{
            content6.innerHTML += result6[i] + ', ';
          }
          
        }
         //console.log(result);
    } );
    var table3 = $('#myTable1').DataTable();
 
    $('#myTable1 tbody').on( 'click', 'tr', function () {
      document.getElementById("debt_par_names").innerHTML="";
        $(this).toggleClass('selected');
         var count3=table3.rows('.selected').data().length +' row(s) selected';
    if(count3>'2'){
      $('#debt_notify_all').show();
    }
    else{
      $('#debt_notify_all').hide();
    }
    });
    $('#debt_notify_all').click( function () {
        var datas3 = table3.rows('.selected').data();
        var link = datas3[0][1];
        var result3 = [];
        for (var i = 0; i < datas3.length; i++)
        {
                result3.push(datas3[i][1].split('"true">').pop().split('</a>')[0]);
        }

        $('#debt_client_names').val(result3).toString();
        
        var content3 = document.getElementById("debt_par_names");
        for(var i=0; i< result3.length;i++){
          if(i==(result3.length-1)){
            content3.innerHTML += result3[i]+ '.';
          }
          else{
            content3.innerHTML += result3[i] + ', ';
          }
          
        }
         //console.log(result);
    } );

     var table4 = $('#myTable2').DataTable();
 
    $('#myTable2 tbody').on( 'click', 'tr', function () {
      document.getElementById("electric_par_names").innerHTML="";
        $(this).toggleClass('selected');
         var count4=table4.rows('.selected').data().length +' row(s) selected';
    if(count4>'2'){
      $('#electric_notify_all').show();
    }
    else{
      $('#electric_notify_all').hide();
    }
    });
    $('#electric_notify_all').click( function () {
        var datas4 = table4.rows('.selected').data();
        var result4 = [];
        for (var i = 0; i < datas4.length; i++)
        {
                result4.push(datas4[i][1].split('"true">').pop().split('</a>')[0]);
        }

        $('#electric_client_names').val(result4).toString();
        
        var content4 = document.getElementById("electric_par_names");
        for(var i=0; i< result4.length;i++){
          if(i==(result4.length-1)){
            content4.innerHTML += result4[i]+ '.';
          }
          else{
            content4.innerHTML += result4[i] + ', ';
          }
          
        }
    } );

    var table5 = $('#myTable3').DataTable();
 
    $('#myTable3 tbody').on( 'click', 'tr', function () {
      document.getElementById("water_par_names").innerHTML="";
        $(this).toggleClass('selected');
         var count5=table5.rows('.selected').data().length +' row(s) selected';
    if(count5>'2'){
      $('#water_notify_all').show();
    }
    else{
      $('#water_notify_all').hide();
    }
    });
    $('#water_notify_all').click( function () {
        var datas5 = table5.rows('.selected').data();
        var result5 = [];
        for (var i = 0; i < datas5.length; i++)
        {
                result5.push(datas5[i][1].split('"true">').pop().split('</a>')[0]);
        }

        $('#water_client_names').val(result5).toString();
        
        var content5 = document.getElementById("water_par_names");
        for(var i=0; i< result5.length;i++){
          if(i==(result5.length-1)){
            content5.innerHTML += result5[i]+ '.';
          }
          else{
            content5.innerHTML += result5[i] + ', ';
          }
          
        }
    } );
    });

</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script> --}}
        {!! $chart->script() !!}
         {!! $chart1->script() !!}
         {{-- {!! $chart2->script() !!} --}}
        {{--  {!! $chart4->script() !!} --}}
          {{-- {!! $chart5->script() !!}
           {!! $chart6->script() !!} --}}
@endsection