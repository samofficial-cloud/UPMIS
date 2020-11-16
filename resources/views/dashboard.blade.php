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
    border-bottom: 2px solid #505559;
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

/*  .card:hover {
    cursor: not-allowed;
    animation-duration: 20ms;
    animation-timing-function: linear;
    animation-iteration-count: 10;
    animation-name: wiggle;
  }*/
  
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
  use App\carRental;
  use App\insurance;
  use App\cost_centre;
  $total_spaces=space::where('status','1')->count();
  $occupied_spaces=space_contract::select('space_id_contract')->where('contract_status','1')->wheredate('end_date','>',date('Y-m-d'))->distinct()->count();
  $available_spaces=space::select('space_id')
        ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>',date('Y-m-d'))->where('contract_status','1')->distinct()->pluck('space_id_contract')->toArray())
        ->where('status','1')
        ->distinct()
        ->count();
  $total_cars=carRental::where('flag','1')->count();
  $running_cars=carRental::where('flag','1')->where('vehicle_status','Running')->count();
  $minor_cars=carRental::where('flag','1')->where('vehicle_status','Minor Repair')->count();
  $grounded_cars=carRental::where('flag','1')->where('vehicle_status','Grounded')->count();
  $total_insurance=insurance::select('insurance_company')->groupby('insurance_company')->distinct()->get();
  ?>
    <br>

    <div class="container" style="max-width: 100%;">
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
        
        <div class="card-deck" style="font-size: 15px; font-family: sans-serif;">
  <div class="card text-white bg-info">
   
    <div class="card-body" >
      <h5 class="card-title">UDIA <i class="fa fa-line-chart" style="font-size:30px; float: right; color: black;"></i></h5>
      <p>Principals: {{count($total_insurance)}}
      <br>Packages: 5
    </div>
  </div>
  <div class="card card text-white bg-success">
    <div class="card-body">
      <h5 class="card-title">CPTU <i class="fa fa-line-chart" style="font-size:30px; float: right; color: black;"></i></h5>
      <p>Total Vehicles: {{$total_cars}}
      <br>Running Vehicles: {{$running_cars}}
      <br>Minor Repair Vehicles: {{$minor_cars}}
      <br>Grounded Vehicles: {{$grounded_cars}}</p>
    </div>
  </div>
  <div class="card text-white" style="background-color: #eb9025;">
    <div class="card-body">
     <h5 class="card-title">Spaces <i class="fa fa-line-chart" style="font-size:30px; float: right; color: black;"></i></h5>
      <p>Total Spaces: {{$total_spaces}}
      <br>Occupied: {{$occupied_spaces}}
      <br>Available: {{$available_spaces}}
    </div>
  </div>
</div>
        <br>
        <div class="card">
          <div class="card-body">
            <h4 class="card-title" style="font-family: sans-serif;">UDIA, CPTU and Space Activities {{date('Y')}}</h4>
            <hr>
        <div class="card-deck">
  <div class="card border-info">
     {!! $chart->container() !!}
  </div>
  <div class="card border-info">
     {!! $chart2->container() !!}
  </div>
  <div class="card border-info">
     {!! $chart3->container() !!}
  </div>
</div>
 </div>
  </div>
<br>
  <div class="card">
    <div class="card-body">
     <h4 class="card-title" style="font-family: sans-serif;">Space Contract(s) that are about to expire (Within 30 days prior to date)</h4>
     <hr>
        <a title="Send email to selected clients" href="#" id="notify_all" class="btn btn-info btn-sm" data-toggle="modal" data-target="#inia_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="inia_mail" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
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
            <label for="inia_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
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
            <label for="inia_message" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="inia_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="inia_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="inia_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="inia_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="inia_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
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
          <th scope="col">Contract ID</th>
          <th scope="col">Major Industry</th>
          <th scope="col" >MInor Industry</th>
          <th scope="col" >Location</th>
          @if(Auth::user()->role=='System Administrator')
          <th scope="col">Action</th>
          @endif
        </tr>
        </thead>
        <tbody>
          @foreach($space_contract as $space)
          <tr>

            <th scope="row" class="counterCell">.</th>

                         <td>
                                      <a title="View More Client Details" class="link_style" data-toggle="modal" data-target="#clienta{{$space->contract_id}}" style="color: blue !important; cursor: pointer;" aria-pressed="true">{{$space->full_name}}</a>
                  <div class="modal fade" id="clienta{{$space->contract_id}}" role="dialog">

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
                                    <td>
                                      <a title="View More Contract Details" class="link_style" data-toggle="modal" data-target="#contracta{{$space->contract_id}}" style="color: blue !important; cursor: pointer;" aria-pressed="true"><center>{{$space->contract_id}}</center></a>
                  <div class="modal fade" id="contracta{{$space->contract_id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">{{$space->full_name}} Contract Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                 <table style="width: 100%">
                                      <tr>
                                          <td>Contract ID:</td>
                                          <td colspan="2">{{$space->contract_id}}</td>
                                      </tr>
                                      <tr>
                                          <td>Space ID:</td>
                                          <td colspan="2">{{$space->space_id_contract}}</td>
                                      </tr>
                                      <tr>
                                          <td>Lease Start</td>
                                          <td colspan="2">{{date("d/m/Y",strtotime($space->start_date))}}</td>
                                      </tr>
                                      <tr>
                                          <td>Lease End</td>
                                          <td colspan="2">{{date("d/m/Y",strtotime($space->end_date))}}</td>
                                      </tr>
                                      @if($space->academic_dependence=="Yes")
                                      <tr>
                                          <td rowspan="3">Amount</td>
                                        </tr>
                                        <tr>
                                          <td>Academic Season</td>
                                          <td>Vacation Season</td>
                                        </tr>
                                        <tr>
                                          @if(empty($space->academic_season))
                                          <td><center>-</center></td>
                                          @else
                                          <td>{{$space->currency}} {{number_format($space->academic_season)}}</td>
                                          @endif
                                      
                                          
                                           @if(empty($space->vacation_season))
                                           <td><center>-</center></td>
                                           @else
                                          <td>{{$space->currency}} {{number_format($space->vacation_season)}}</td>
                                          @endif
                                      </tr>
                                      @else
                                      <tr>
                                        <td>Amount</td>
                                         @if(empty($space->amount))
                                         <td>-</td>
                                         @else
                                        <td colspan="2">{{$space->currency}} {{number_format($space->amount)}}</td>
                                        @endif
                                      </tr>
                                      @endif
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
              <td>{{$space->major_industry}}</td>
              <td>{{$space->minor_industry}}</td>
              <td>{{$space->location}}</td>
              @if(Auth::user()->role=='System Administrator')
              <td><a href="{{ route('renew_space_contract_form',$space->contract_id) }}" title="Click to renew this contract"><i class="fa fa-refresh" style="font-size:25px;"></i></a>
                @if($space->email!='')
                 <a data-toggle="modal" data-target="#mail{{$space->contract_id}}" role="button" aria-pressed="true" title="Click to notify this client"><i class="fa fa-envelope" aria-hidden="true" style="font-size:25px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="mail{{$space->contract_id}}" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="client_names{{$space->contract_id}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="client_names{{$space->contract_id}}" name="client_name" class="form-control" value="{{$space->full_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="subject{{$space->contract_id}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="subject{{$space->contract_id}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="greetings{{$space->contract_id}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="greetings{{$space->contract_id}}" name="greetings" class="form-control" value="Dear {{$space->full_name}}," readonly="">
          </div>
        </div>
         <br>
         
        <div class="form-group row">
            <label for="messages{{$space->contract_id}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="messages{{$space->contract_id}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment{{$space->contract_id}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="attachment{{$space->contract_id}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="closing{{$space->contract_id}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="closing{{$space->contract_id}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
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
     @else
     <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
     @endif
              </td>
              @endif
          </tr>

          @endforeach

        </tbody>
</table>
</div>
  </div>
<br>
<div class="card">
          <div class="card-body">
            <h4 class="card-title" style="font-family: sans-serif;">UDIA, CPTU and Space Income Generation {{date('Y')}}</h4>
            <hr>
<div class="card-deck">
  <div class="card border-info">
     {!! $chart4->container() !!}
  </div>
  <div class="card border-info">
     {!! $chart5->container() !!}
  </div>
  <div class="card border-info">
     {!! $chart6->container() !!}
  </div>
</div>
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
              <div class="modal-dialog modal-lg" role="document">
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
            <label for="debt_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="debt_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="debt_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="debt_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="debt_message" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="debt_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="debt_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="debt_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="debt_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="debt_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
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
                               {{--  <th scope="col" >Period</th> --}}
                                <th scope="col">Contract Id</th>
                                <th scope="col" >Amount</th>
                                {{-- <th scope="col" >GEPG Control No</th> --}}
                                <th scope="col" >Invoice Date</th>
                                @if(Auth::user()->role=='System Administrator')
                                <th scope="col" >Action</th>
                                @endif
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
                                                                    <td colspan="2">{{$var->contract_id}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Client :</td>
                                                                    <td colspan="2">{{$var->full_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Space Number:</td>
                                                                    <td colspan="2"> {{$var->space_id_contract}}</td>
                                                                </tr>

                                    @if($var->academic_dependence=="Yes")
                                      <tr>
                                          <td rowspan="3">Amount</td>
                                        </tr>
                                        <tr>
                                          <td>Academic Season</td>
                                          <td>Vacation Season</td>
                                        </tr>
                                        <tr>
                                          @if(empty($var->academic_season))
                                          <td><center>-</center></td>
                                          @else
                                          <td>{{$var->currency}} {{number_format($var->academic_season)}}</td>
                                          @endif
                                      
                                          
                                           @if(empty($var->vacation_season))
                                           <td><center>-</center></td>
                                           @else
                                          <td>{{$var->currency}} {{number_format($var->vacation_season)}}</td>
                                          @endif
                                      </tr>
                                      @else
                                      <tr>
                                        <td>Amount</td>
                                         @if(empty($var->amount))
                                         <td>-</td>
                                         @else
                                        <td colspan="2">{{$var->currency}} {{number_format($var->amount)}}</td>
                                        @endif
                                      </tr>
                                      @endif


                                                                <tr>
                                                                    <td>Payment Cycle:</td>
                                                                    <td colspan="2">{{$var->payment_cycle}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract Start Date:</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract End Date:</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle Start Date:</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->programming_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle End Date:</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->programming_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Escalation Rate:</td>
                                                                    <td colspan="2">{{$var->escalation_rate}} </td>
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
                                    @if(Auth::user()->role=='System Administrator')
                                    <td>
                                      @if($var->email!='')
                                      <a title="Send Email to this Client" data-toggle="modal" data-target="#spacemail{{$var->invoice_number}}" role="button" aria-pressed="true"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
      <div class="modal fade" id="spacemail{{$var->invoice_number}}" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
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
            <label for="spacesubject{{$var->invoice_number}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="spacesubject{{$var->invoice_number}}" name="subject" class="form-control" value="" required="" >
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="spacegreetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="spacegreetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear {{$var->debtor_name}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="spacemessage{{$var->invoice_number}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="spacemessage{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="spaceattachment{{$var->invoice_number}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="spaceattachment{{$var->invoice_number}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="spaceclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="spaceclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
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
     @else
     <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
     @endif
                                    </td>
                                    @endif  
                                  </tr>
                                  
                                  @endforeach
                                </tbody>
</table>
</div>
</div>
<br>
<div class="card">
    <div class="card-body">
     <h3 class="card-title" style="font-family: sans-serif;">Outstanding CPTU Debt(s)</h3>
     <hr>
    <a title="Send email to selected clients" href="#" id="notify_all_cptu" class="btn btn-info btn-sm" data-toggle="modal" data-target="#mail_all" role="button" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    display: none;
    margin-top: 4px;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
        <div class="modal fade" id="mail_all" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content" style="width: 115%;">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="aia_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="aia_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="aia_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>    
        
        <div class="form-group row">
            <label for="aia_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="aia_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="aia_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="aia_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="aia_message" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="aia_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="aia_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="aia_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="aia_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="aia_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
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
     </div>
     <table class="hover table table-striped table-bordered" id="myTable2">
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
                                @if(Auth::user()->role=='System Administrator')
                                <th scope="col" >Action</th>
                                @endif 
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cptu_invoices as $var)
                                <tr>
                                    <th scope="row" class="counterCell">.</th>
                                    <td>
                                      <?php $centre_name=cost_centre::select('costcentre')->where('costcentre_id',$var->cost_centre)->value('costcentre');?>
                                      <a title="View Client Details" class="link_style" style="color: blue !important; cursor: pointer;"  class="" data-toggle="modal" data-target="#clienta{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true">{{$var->debtor_name}}</a>
                                            <div class="modal fade" id="clienta{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Client Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%;">

                                                                <tr>
                                                                    <td style="width:30%;">Client Name:</td>
                                                                    <td>{{$var->fullName}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Cost Centre No:</td>
                                                                    <td>{{$var->cost_centre}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Cost Centre Name:</td>
                                                                    <td>{{$centre_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Email:</td>
                                                                    <td> {{$var->email}}</td>
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
                                    {{-- <td>{{$var->period}}</td> --}}
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
                                                            <table style="width: 100%;">

                                                                <tr>
                                                                    <td style="width:30%;">Client Name:</td>
                                                                    <td>{{$var->fullName}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Destination</td>
                                                                    <td>{{$var->destination}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Vehicle Reg No:</td>
                                                                    <td> {{$var->vehicle_reg_no}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Start Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>End Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Purpose:</td>
                                                                    <td> {{$var->purpose}}</td>
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
                                  {{--  <td>{{$var->gepg_control_no}}</td> --}}
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                    @if(Auth::user()->role=='System Administrator')
                                    <td>
                                      @if($var->email!='')
                                       <a title="Send Email to this Client" data-toggle="modal" data-target="#carmail{{$var->invoice_number}}" role="button" aria-pressed="true"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
      <div class="modal fade" id="carmail{{$var->invoice_number}}" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="carclient_names{{$var->invoice_number}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="carclient_names{{$var->invoice_number}}" name="client_name" class="form-control" value="{{$var->fullName}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="carsubject{{$var->invoice_number}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="carsubject{{$var->invoice_number}}" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="cargreetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="cargreetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear {{$var->fullName}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="carmessage{{$var->invoice_number}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="carmessage{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="carattachment{{$var->invoice_number}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="carattachment{{$var->invoice_number}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="carclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="carclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, DPDI." readonly="">
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
     </div>
     @else
    <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
     @endif
                                    </td>
                                    @endif 
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
<script>
function myFunction() {
  alert("This client has no email.");
}
</script>
<script type="text/javascript">
  $(document).ready(function(){
  var table = $('#myTable').DataTable( {
    dom: '<"top"l>rt<"bottom">'
  } );

  var table1 = $('#myTable1').DataTable( {
    dom: '<"top"l>rt<"bottom">'
  } );

  var tablee = $('#myTable2').DataTable( {
    dom: '<"top"l>rt<"bottom">'
  } );

  var table2 = $('#myTable').DataTable();
 
    $('#myTable tbody').on( 'click', 'tr', function () {
      document.getElementById("inia_par_names").innerHTML="";
      document.getElementById("inia_greetings").value="Dear ";
      var Ctype = $(this).find('td:eq(2)').text();
      if(Ctype=="Individual"){
        var email0 = $(this).find('td:eq(10)').text();
      }
      else{
         var email0 = $(this).find('td:eq(8)').text();
      }
      if(email0==" "){
        //alert("This client has no email");
      }
      else{
        $(this).toggleClass('selected');
         var count2=table2.rows('.selected').data().length +' row(s) selected';
      
      if(count2>'2'){
        <?php $role=Auth::user()->role;?>
        var role={!! json_encode($role) !!};
        if(role=='System Administrator'){
          $('#notify_all').show();
        }
        else{
          $('#notify_all').hide();
        }   
      }
      else{
        $('#notify_all').hide();
      }
    }
    });
    $('#notify_all').click( function () {
      document.getElementById("inia_par_names").innerHTML="";
      document.getElementById("inia_greetings").value="Dear ";
        var datas0 = table2.rows('.selected').data();
        var link = datas0[0][1];
        var result0 = [];
        for (var i = 0; i < datas0.length; i++)
        {
                result0.push(datas0[i][1].split('"true">').pop().split('</a>')[0]);
        }

        $('#inia_client_names').val(result0).toString();
        
        var content0 = document.getElementById("inia_par_names");
        for(var i=0; i< result0.length;i++){
          if(i==(result0.length-1)){
            content0.innerHTML += result0[i]+ '.';
          }
          else{
            content0.innerHTML += result0[i] + ', ';
          }
          
        }

        var salutation0 = document.getElementById("inia_greetings");
        for(var i=0; i< result0.length;i++){
          if(i==(result0.length-1)){
            salutation0.value += result0[i]+ '.';
          }
          else{
            salutation0.value += result0[i] + ', ';
          }
          
        }
    });


    var table3 = $('#myTable1').DataTable();
 
    $('#myTable1 tbody').on( 'click', 'tr', function () {
      document.getElementById("debt_par_names").innerHTML="";
      document.getElementById("debt_greetings").value="Dear ";
      var Ctype1 = $(this).find('td:eq(2)').text();
      if(Ctype1=="Individual"){
        var email1 = $(this).find('td:eq(10)').text();
      }
      else{
         var email1 = $(this).find('td:eq(8)').text();
      }
       
      if(email1==""){
        //alert("This client has no email");
      }
      else{
        $(this).toggleClass('selected');
         var count3=table3.rows('.selected').data().length +' row(s) selected';
      
      if(count3>'2'){
        <?php $role=Auth::user()->role;?>
        var role={!! json_encode($role) !!};
      if(role=='System Administrator'){
        $('#debt_notify_all').show();
      }
      else{
        $('#debt_notify_all').hide();
      }   
      }
      else{
      $('#debt_notify_all').hide();
      }
  }
    });
    $('#debt_notify_all').click( function () {
       document.getElementById("debt_par_names").innerHTML="";
      document.getElementById("debt_greetings").value="Dear ";
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

         var salutation3 = document.getElementById("debt_greetings");
        for(var i=0; i< result3.length;i++){
          if(i==(result3.length-1)){
            salutation3.value += result3[i]+ '.';
          }
          else{
            salutation3.value += result3[i] + ', ';
          }
          
        }
         //console.log(result);
    });

    var table4 = $('#myTable2').DataTable();
 
    $('#myTable2 tbody').on( 'click', 'tr', function () {
      document.getElementById("aia_par_names").innerHTML="";
      document.getElementById("aia_greetings").value="Dear ";
       var email2 = $(this).find('td:eq(8)').text();
      if(email2==" "){
        //alert("This client has no email");
      }
      else{
        $(this).toggleClass('selected');
         var count4=table4.rows('.selected').data().length +' row(s) selected';
         if(count4>'2'){
      <?php $role=Auth::user()->role;?>
       var role={!! json_encode($role) !!};
        if(role=='System Administrator'){
        $('#notify_all_cptu').show();
        }
      else{
        $('#notify_all_cptu').hide();
        }   
      }
      else{
      $('#notify_all_cptu').hide();
      }
    }
    
    });

    
  
     $('#notify_all_cptu').click( function () {
      document.getElementById("aia_par_names").innerHTML="";
      document.getElementById("aia_greetings").value="Dear ";
        var datas6 = table4.rows('.selected').data();
        var result6 = [];
        for (var i = 0; i < datas6.length; i++)
        {
                result6.push(datas6[i][1].split('"true">').pop().split('</a>')[0]);
        }

        $('#aia_client_names').val(result6).toString();
        
        var content6 = document.getElementById("aia_par_names");
        for(var i=0; i< result6.length;i++){
          if(i==(result6.length-1)){
            content6.innerHTML += result6[i]+ '.';
          }
          else{
            content6.innerHTML += result6[i] + ', ';
          }
          
        }

        var salutation6 = document.getElementById("aia_greetings");
        for(var i=0; i< result6.length;i++){
          if(i==(result6.length-1)){
            salutation6.value += result6[i]+ '.';
          }
          else{
            salutation6.value += result6[i] + ', ';
          }
          
        }
         
    });
});
</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script> --}}
        {!! $chart->script() !!}
         {!! $chart2->script() !!}
         {!! $chart3->script() !!}
         {!! $chart4->script() !!}
          {!! $chart5->script() !!}
           {!! $chart6->script() !!}
@endsection
