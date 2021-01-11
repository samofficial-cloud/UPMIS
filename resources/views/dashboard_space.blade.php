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

            @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

                <li><a href="/businesses"><i class="fa fa-building" aria-hidden="true"></i> Businesses</a></li>
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
                <li><a href="/user_role_management"><i class="fas fa-user-friends hvr-icon" aria-hidden="true"></i>Manage Users</a></li>
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
  $year= date('Y');
  ?>
    <br>

    <div class="container" style="max-width: 1180px;">
      <br>
       @if ($message = Session::get('errors'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>{{$message}}</p>
          </div>
        @endif

      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p>{{$message}}</p>
      </div>
    @endif
 <div class="card">

  <br>
   <div class="col-sm-12">
    <div>
        <form class="form-inline" role="form" method="post" accept-charset="utf-8">

        <div class="form-group" style="margin-right: 5px;">
           
          <select name="activity_year" id="activity_year" class="form-control" required="">
              <option value=" " disabled selected hidden>Select Year</option>
                @for($x=-5;$x<=0; $x++)
                  <option value="{{$year + $x}}">{{$year + $x}}</option>
                @endfor
          </select>
          <span id="activity_error"></span>
        </div>
      
      <div class="form-group"  style="margin-right: 5px;">
          <input type="submit" name="filter" value="Filter" id="activity_filter" class="btn btn-primary">
      </div>

     
    </form>   
  </div>
</div>
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
    <div id="cardData">
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
     <h4 class="card-title" style="font-family: sans-serif;">Contract(s) that are about to expire (Within 30 days prior to date)</h4>
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
            <input type="text" id="inia_greetings" name="greetings" class="form-control" value="Dear " readonly="">
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
          <th scope="col">Action</th>
        </tr>
        </thead>

        <tbody>
          @foreach($contracts as $space)
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
                                          <td>Contract ID</td>
                                          <td colspan="2">{{$space->contract_id}}</td>
                                      </tr>
                                      <tr>
                                          <td>Space ID</td>
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
              <td><a href="{{ route('renew_space_contract_form',$space->contract_id) }}" title="Click to renew this contract"><i class="fa fa-refresh" style="font-size:25px;"></i></a>
                @if($space->email!="")
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
            <input type="text" id="subject{{$space->contract_id}}" name="subject" class="form-control" value="" required="">
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
              <textarea type="text" id="messages{{$space->contract_id}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
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
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
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
                                                            <b><h5 class="modal-title">{{$var->full_name}} Contract Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%">

                                                                <tr>
                                                                    <td>Contract ID</td>
                                                                    <td colspan="2">{{$var->contract_id}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Client </td>
                                                                    <td colspan="2">{{$var->full_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Major Industry</td>
                                                                    <td colspan="2">{{$var->major_industry}} </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Minor Industry</td>
                                                                    <td colspan="2">{{$var->minor_industry}} </td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Space Number</td>
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
                                                                    <td>Payment Cycle</td>
                                                                    <td colspan="2">{{$var->payment_cycle}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract Start Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract End Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle Start Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->programming_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle End Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->programming_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Escalation Rate</td>
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
                                    <td>{{$var->currency_invoice}} {{$var->amount_to_be_paid}}</td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                    <td>
                                      @if($var->email!="")
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
            <input type="text" id="spacesubject{{$var->invoice_number}}" name="subject" class="form-control" value="" required="">
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
            <label for="electric_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="electric_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="electric_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>

        <div class="form-group row">
            <label for="electric_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="electric_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="electric_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="electric_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="electric_message" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="electric_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="electric_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="electric_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="electric_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="electric_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
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
                                                            <b><h5 class="modal-title">{{$var->debtor_name}} Contract Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                              <table style="width: 100%">

                                                                <tr>
                                                                    <td>Contract ID</td>
                                                                    <td colspan="2">{{$var->contract_id}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Client </td>
                                                                    <td colspan="2">{{$var->full_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Major Industry</td>
                                                                    <td colspan="2">{{$var->major_industry}} </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Minor Industry</td>
                                                                    <td colspan="2">{{$var->minor_industry}} </td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Space Number</td>
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
                                                                    <td>Payment Cycle</td>
                                                                    <td colspan="2">{{$var->payment_cycle}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract Start Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract End Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle Start Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->programming_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle End Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->programming_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Escalation Rate</td>
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
                                    <td>{{$var->currency_invoice}} {{$var->cumulative_amount}}</td>
                                   {{--  <td>{{$var->gepg_control_no}}</td> --}}
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                    <td>
                                      @if($var->email!="")
                                      <a title="Send Email to this Client" data-toggle="modal" data-target="#electric_mail{{$var->invoice_number}}" role="button" aria-pressed="true"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
      <div class="modal fade" id="electric_mail{{$var->invoice_number}}" role="dialog">
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
            <label for="electric_client_names{{$var->invoice_number}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="electric_client_names{{$var->invoice_number}}" name="client_name" class="form-control" value="{{$var->debtor_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="electric_subject{{$var->invoice_number}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="electric_subject{{$var->invoice_number}}" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="electric_greetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="electric_greetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear {{$var->debtor_name}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="electric_message{{$var->invoice_number}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="electric_message{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="electric_attachment{{$var->invoice_number}}" class="col-sm-2">Attachments</label>
             <div class="col-sm-9">
              <input type="file" id="electric_attachment{{$var->invoice_number}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="electric_closing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="electric_closing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
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
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
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
            <label for="water_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="water_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="water_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="water_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="water_message" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="water_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="water_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="water_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="water_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="water_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
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
                                                            <b><h5 class="modal-title">{{$var->debtor_name}} Contract Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%">

                                                                <tr>
                                                                    <td>Contract ID</td>
                                                                    <td colspan="2">{{$var->contract_id}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Client </td>
                                                                    <td colspan="2">{{$var->full_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Major Industry</td>
                                                                    <td colspan="2">{{$var->major_industry}} </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Minor Industry</td>
                                                                    <td colspan="2">{{$var->minor_industry}} </td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Space Number</td>
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
                                                                    <td>Payment Cycle</td>
                                                                    <td colspan="2">{{$var->payment_cycle}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract Start Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract End Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle Start Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->programming_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle End Date</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->programming_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Escalation Rate</td>
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
                                    <td>{{$var->currency_invoice}} {{$var->cumulative_amount}}</td>
                                   {{--  <td>{{$var->gepg_control_no}}</td> --}}
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                    <td>
                                      @if($var->email!="")
                                      <a title="Send Email to this Client" data-toggle="modal" data-target="#watermail{{$var->invoice_number}}" role="button" aria-pressed="true"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
      <div class="modal fade" id="watermail{{$var->invoice_number}}" role="dialog">
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
            <label for="waterclient_names{{$var->invoice_number}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="waterclient_names{{$var->invoice_number}}" name="client_name" class="form-control" value="{{$var->debtor_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="watersubject{{$var->invoice_number}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="watersubject{{$var->invoice_number}}" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="watergreetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="watergreetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear {{$var->debtor_name}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="watermessage{{$var->invoice_number}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="watermessage{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="waterattachment{{$var->invoice_number}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="waterattachment{{$var->invoice_number}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="waterclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="waterclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
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
    dom: '<"top"l>rt<"bottom"pi>'
  } );

  var table1 = $('#myTable1').DataTable( {
    dom: '<"top"l>rt<"bottom"pi>'
  } );

  var tablee1 = $('#myTable2').DataTable( {
    dom: '<"top"l>rt<"bottom"pi>'
  } );

  var tablee2 = $('#myTable3').DataTable( {
    dom: '<"top"l>rt<"bottom"pi>'
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

      }
      else{
        $(this).toggleClass('selected');
         var count2=table2.rows('.selected').data().length +' row(s) selected';
        if(count2>'2'){
         $('#notify_all').show();
        }
        else{
          $('#notify_all').hide();
        }
      }



    });
    $('#notify_all').click( function () {
        document.getElementById("inia_par_names").innerHTML="";
      document.getElementById("inia_greetings").value="Dear ";
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

        var salutation6 = document.getElementById("inia_greetings");
        for(var i=0; i< result6.length;i++){
          if(i==(result6.length-1)){
            salutation6.value += result6[i]+ '.';
          }
          else{
            salutation6.value += result6[i] + ', ';
          }

        }
         //console.log(result);
    } );
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

      }
      else{
       $(this).toggleClass('selected');
        var count3=table3.rows('.selected').data().length +' row(s) selected';
        if(count3>'2'){
        $('#debt_notify_all').show();
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
    } );

     var table4 = $('#myTable2').DataTable();

    $('#myTable2 tbody').on( 'click', 'tr', function () {
      document.getElementById("electric_par_names").innerHTML="";
      document.getElementById("electric_greetings").value="Dear ";
       var Ctype2 = $(this).find('td:eq(2)').text();
      if(Ctype2=="Individual"){
        var email2 = $(this).find('td:eq(10)').text();
      }
      else{
         var email2 = $(this).find('td:eq(8)').text();
      }
      if(email2==""){

      }
      else{
        $(this).toggleClass('selected');
         var count4=table4.rows('.selected').data().length +' row(s) selected';
         if(count4>'2'){
          $('#electric_notify_all').show();
        }
        else{
          $('#electric_notify_all').hide();
        }
      }

    });
    $('#electric_notify_all').click( function () {
      document.getElementById("electric_par_names").innerHTML="";
      document.getElementById("electric_greetings").value="Dear ";
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

        var salutation4 = document.getElementById("electric_greetings");
        for(var i=0; i< result4.length;i++){
          if(i==(result4.length-1)){
            salutation4.value += result4[i]+ '.';
          }
          else{
            salutation4.value += result4[i] + ', ';
          }

        }
    });

    var table5 = $('#myTable3').DataTable();

    $('#myTable3 tbody').on( 'click', 'tr', function () {
      document.getElementById("water_par_names").innerHTML="";
      document.getElementById("water_greetings").value="Dear ";
       var Ctype3 = $(this).find('td:eq(2)').text();
      if(Ctype3=="Individual"){
        var email3 = $(this).find('td:eq(10)').text();
      }
      else{
         var email3 = $(this).find('td:eq(8)').text();
      }
      if(email3==""){

      }
      else{
         $(this).toggleClass('selected');
         var count5=table5.rows('.selected').data().length +' row(s) selected';
         if(count5>'2'){
          $('#water_notify_all').show();
        }
        else{
          $('#water_notify_all').hide();
        }
      }

    });
    $('#water_notify_all').click( function () {
      document.getElementById("water_par_names").innerHTML="";
      document.getElementById("water_greetings").value="Dear ";
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

        var salutation5 = document.getElementById("water_greetings");
        for(var i=0; i< result5.length;i++){
          if(i==(result5.length-1)){
            salutation5.value += result5[i]+ '.';
          }
          else{
            salutation5.value += result5[i] + ', ';
          }

        }
    });

        $("#activity_filter").click(function(e){
    e.preventDefault();
    
    var query = $('#activity_year').val();

    if(query==null){
      $('#activity_error').show();
      var message=document.getElementById('activity_error');
      message.style.color='red';
      message.innerHTML="Required";
      $('#activity_year').attr('style','border:1px solid #f00');
    }
    else{
      
      $('#activity_error').hide();
      $('#activity_year').attr('style','border:1px solid #ccc');
      $.ajax({
      url: "/home16/activity_filter?",
      context: document.body,
      async : false,
      data:{year:query}
      })
    .done(function(data) {
      {{$chart->id}}.options.title.text = 'Lease Activities '+query;
      {{ $chart->id }}.data.datasets[0].data =data.activity;
      {{ $chart->id }}.update(); 

      {{$chart1->id}}.options.title.text = 'Space Income Generation '+query;
      {{ $chart1->id }}.data.datasets[0].data =data.income;
      {{ $chart1->id }}.data.datasets[1].data =data.income2;
      {{ $chart1->id }}.update();
      var bodyData = '';
      
      bodyData= "<div>"
      bodyData+="<h5 class='card-title'>Client Statistics "
      bodyData+=query+"</h5>"
      bodyData+="J.K. Nyerere Clients: "+data.main
      bodyData+="<br>Kijitonyama Clients: "+data.knyama
      bodyData+="<br>Kunduchi Clients Clients: "+data.kunduchi
      bodyData+="<br>Mabibo Clients: "+ data.mabibo
      bodyData+="<br>Mikocheni Clients: "+ data.mikocheni
      bodyData+="<br>Mlimani City Clients: "+ data.mlimani
      bodyData+="<br>Ubungo Clients: "+ data.ubungo
      bodyData+="<br>Total Clients: "+ data.total
      bodyData+="</div>";
      $("#cardData").html(bodyData);
      //$("#clientdiv").load(location.href + " #clientdiv");
    });
    }  
    return false;

});
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
