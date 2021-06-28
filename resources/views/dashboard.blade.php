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
}
</style>

@endsection
@section('content')
<div class="wrapper">
  <?php $a=1; $b=1; $c=1; $d=1;?>
<div class="sidebar">
        <ul style="list-style-type:none;">

            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>

            @if($category=='All')
           <li class="active_nav_item"><a href="/"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Insurance only')
          <li><a href="{{ route('home2') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Real Estate only')
          <li><a href="{{ route('home4') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Research Flats only')
          <li><a href="{{ route('home6') }}"><i class="fas fa-home active"></i>Home</a></li>
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
  use App\carRental;
  use App\insurance;
  use App\cost_centre;
  $total_spaces=space::where('status','1')->count();
  $occupied_spaces=space_contract::select('space_id_contract')->where('contract_status','1')->where('space_id_contract','!=',null)->wheredate('end_date','>=',date('Y-m-d'))->orderBy('space_id_contract','asc')->distinct()->get();
  $available_spaces=space::select('space_id')
        ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>',date('Y-m-d'))->where('contract_status','1')->distinct()->pluck('space_id_contract')->toArray())
        ->where('status','1')
        ->distinct()
        ->count();
  $total_cars=carRental::where('flag','1')->count();
    $hired_cars=carRental::where('flag','1')->where('hire_status','Hired')->count();
    $not_hired_cars=$total_cars-$hired_cars;
  $running_cars=carRental::where('flag','1')->where('vehicle_status','Running')->count();
  $minor_cars=carRental::where('flag','1')->where('vehicle_status','Minor Repair')->count();
  $grounded_cars=carRental::where('flag','1')->where('vehicle_status','Grounded')->count();
  $total_rented_cars=\App\carContract::whereMonth('start_date',\Carbon\Carbon::now()->month)->whereYear('start_date',\Carbon\Carbon::now()->year)->count();

  $total_insurance_covers=\App\insurance_contract::whereMonth('commission_date',\Carbon\Carbon::now()->month)->whereYear('commission_date',\Carbon\Carbon::now()->year)->count();

  $classes=insurance::select('class')->where('status',1)->distinct()->get();
  $single_rooms = DB::table('research_flats_rooms')->where('category','Single Room')->where('status','1')->count();
  $single_rooms_occupied = DB::table('research_flats_rooms')->where('category','Single Room')->where('status','1')->where('occupational_status','Occupied')->count();
  $single_rooms_vacant = $single_rooms-$single_rooms_occupied;

  $shared_rooms = DB::table('research_flats_rooms')->where('category','Shared Room')->where('status','1')->count();
  $shared_rooms_occupied = DB::table('research_flats_rooms')->where('category','Shared Room')->where('status','1')->where('occupational_status','Occupied')->count();
  $shared_rooms_vacant=$shared_rooms-$shared_rooms_occupied;

  $suite_rooms = DB::table('research_flats_rooms')->where('category','Suite Room')->where('status','1')->count();
  $suite_rooms_occupied = DB::table('research_flats_rooms')->where('category','Suite Room')->where('status','1')->where('occupational_status','Occupied')->count();
  $suite_rooms_vacant=$suite_rooms-$suite_rooms_occupied;



  $total_rooms= $single_rooms + $shared_rooms + $suite_rooms;
  $year = date('Y');


  ?>
    <br>

    <div class="container" style="max-width: 100%;">
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

        <div class="card-deck" style="font-size: 15px; font-family: sans-serif;">

            <a class="card text-white bg-info" href="/contracts_management" style="cursor: pointer; text-decoration:none;">


                <div class="">


                    <div class="card-body" >
                        <h5 class="card-title">Insurance <i class="fas fa-umbrella" style="font-size:30px; float: right; color: black;"></i></h5>

                        <p>Insurance Covers Sold This Month: {{$total_insurance_covers}}
                        {{--      <br>Packages: {{count($classes)}}--}}
                    </div>
                </div>

            </a>

<a class="card card text-white bg-success" href="/businesses" style="cursor: pointer; margin-left: 0.04%; text-decoration:none;">

    <div >
        <div class="card-body">
            <h5 class="card-title">Car Rental<i class="fas fa-car" style="font-size:30px; float: right; color: black;"></i></h5>
            <p>Total Vehicles: {{$total_cars}}
                <br>Hired Vehicles: <?php echo e($hired_cars); ?>
                <br>Available Vehicles: <?php echo e($not_hired_cars); ?>

                <br>Running Vehicles: {{$running_cars}}
                <br>Minor Repair Vehicles: {{$minor_cars}}
                <br>Grounded Vehicles: {{$grounded_cars}}
                <br>Total Cars Rented This Month: {{$total_rented_cars}}</p>
        </div>
    </div>


</a>


            <a class="card text-white" style="background-color: #eb9025; margin-left: 0.04%; cursor: pointer; text-decoration:none !important;" href="/businesses" ><div >
                    <div class="card-body">
                        <h5 class="card-title">Real Estate <i class="fas fa-city" style="font-size:30px; float: right; color: black;"></i></h5>
                        <p>Total Real Estate: {{$total_spaces}}
                            <br>Occupied: {{count($occupied_spaces)}}
                            <br>Vacant: {{$available_spaces}}
                    </div>
                </div> </a>

  <a href="/businesses" style="cursor: pointer; margin-left: 0.04%; background-color: #eb2553 !important; text-decoration:none;" class="card text-white" >

      <div >
          <div class="card-body" >
              <h5 class="card-title">Research Flats <i class="fas fa-building" style="font-size:30px; float: right; color: black;"></i></h5>

            <div>Total Rooms: {{$total_rooms}}</div>
              <div class="pt-1">Standard Rooms: {{$single_rooms}}
                  <hr style="margin-bottom: 0rem;">
                  <span>Occupied: {{$single_rooms_occupied}}</span>     <span class="pl-4">Vacant: {{$single_rooms_vacant}}</span>
              </div>

              <div class="pt-1"> Shared Rooms: {{$shared_rooms}}
                  <hr style="margin-bottom: 0rem;">
                  <span>Occupied: {{$shared_rooms_occupied}}</span>     <span class="pl-4">Vacant: {{$shared_rooms_vacant}}</span>
              </div>
              <div class="pt-1">Suite Rooms: {{$suite_rooms}}
                    <hr style="margin-bottom: 0rem;">
                    <span>Occupied: {{$suite_rooms_occupied}}</span>     <span class="pl-4">Vacant: {{$suite_rooms_vacant}}</span>
                </div>


          </div>
      </div>

  </a>

</div>
        <br>
        <div class="card">
          <br>

          <div class="card-body">
              <div>

                  <div style="float: left;"><h4 class="card-title" style="font-family: sans-serif; line-height: 36px;">Activities</h4></div>

                  <div style="float: left; margin-left: 1%;" class="">
                      <div>
                          <form class="form-inline" role="form" method="post" accept-charset="utf-8">

                              <div class="form-group" style="margin-right: 5px;">

                                  <select name="activity_year" id="activity_year" class="form-control" required="">
                                      <option value=" " disabled selected hidden>Select Year</option>
                                      @for($x=-5;$x<=0; $x++)
                                          <option value="{{$year + $x}}">{{$year + $x}}</option>
                                      @endfor
                                  </select>
                                  <span id="activity_msg"></span>
                              </div>

                              <div class="form-group"  style="margin-right: 5px;">
                                  <input type="submit" name="filter" value="Filter" id="activity_filter" class="btn btn-primary">
                              </div>


                          </form>
                      </div>
                  </div>

              </div>

<hr style="clear: both; padding-top: 1%;">

        <div class="card-deck" style="display: flex; margin-top: 2% !important; clear: both; flex-direction: column">
            <div style="display: flex; flex-direction: row !important;">

                <div class="card border-info">
                    {!! $chart->container() !!}
                </div>
                <div class="card border-info">
                    {!! $chart2->container() !!}
                </div>


            </div>

            <div class="pt-4" style="display: flex;  flex-direction: row; !important;">

                <div class="card border-info">
                    {!! $chart3->container() !!}
                </div>
                <div class="card border-info">
                    {!! $chart41->container() !!}
                </div>

            </div>


</div>
 </div>
  </div>
<br>
  <div class="card">
    <div class="card-body">
     <h4 class="card-title" style="font-family: sans-serif;">Real Estate Contract(s) that are about to expire (Within 30 days prior to date)</h4>
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
              <input type="file" id="inia_attachment" name="filenames[]" class="myfrm form-control" multiple="" accept=".xls,.xlsx, .pdf, .doc, .docx, .png, .jpeg, .jpg">
              <center><span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="inia_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="inia_closing" name="closing" class="form-control" value="Regards, Real Estate Department UDSM." readonly="">
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
          <th scope="col" class="text-right">Contract ID</th>
          <th scope="col" >Expiration Date</th>
          @if((Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
          <th scope="col" class="text-center">Action</th>
          @endif
        </tr>
        </thead>
        <tbody>
          @foreach($space_contract as $space)
          <tr>

            <td  class="text-center">{{$a}}.</td>

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
                                    <td style="text-align: right!important; ">
                                      <a title="View More Contract Details" class="link_style " data-toggle="modal" data-target="#contracta{{$space->contract_id}}" style="color: blue !important; cursor: pointer;" aria-pressed="true">{{$space->contract_id}}</a>
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
                                          <td>Real Estate ID:</td>
                                          <td colspan="2">{{$space->space_id_contract}}</td>
                                      </tr>

                                     <tr>
                                         <td>Category:</td>
                                         <td colspan="2">{{$space->major_industry}}</td>
                                     </tr>

                                     <tr>
                                         <td>Sub Category:</td>
                                         <td colspan="2">{{$space->minor_industry}}</td>
                                     </tr>


                                     <tr>
                                         <td>Location:</td>
                                         <td colspan="2">{{$space->location}}</td>
                                     </tr>


                                     <tr>
                                         <td>Sub Location:</td>
                                         <td colspan="2">{{$space->sub_location}}</td>
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

                                  <br><br>
                                  <p style="text-align: center">Go to <a href="/contracts_management">Contracts</a></p>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>

              <td>{{date("d/m/Y",strtotime($space->end_date))}}</td>
              @if((Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
              <td class="text-center"><a href="{{ route('renew_space_contract_form',$space->contract_id) }}" title="Click to renew this contract"><i class="fa fa-refresh" style="font-size:25px;"></i></a>
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
              <input type="file" id="attachment{{$space->contract_id}}" name="filenames[]" class="myfrm form-control" multiple="" accept=".xls,.xlsx, .pdf, .doc, .docx, .png, .jpeg, .jpg">
              <center><span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="closing{{$space->contract_id}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="closing{{$space->contract_id}}" name="closing" class="form-control" value="Regards, Real Estate Department UDSM." readonly="">
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
          <?php $a = $a+1; ?>
          @endforeach

        </tbody>
</table>
</div>
  </div>
<br>
<div class="card">
  <br>

          <div class="card-body" >
            <div id="content">

                <div style="float: left;"><h4 class="card-title" style="font-family: sans-serif; line-height: 36px;">Income Generation</h4></div>

                <div style="float: left; margin-left: 1%;"> <div class="">
                        <div>
                            <form class="form-inline" role="form" method="post" accept-charset="utf-8">

                                <div class="form-group" style="margin-right: 5px;">

                                    <select name="income_year" id="income_year" class="form-control" required="">
                                        <option value=" " disabled selected hidden>Select Year</option>
                                        @for($x=-5;$x<=0; $x++)
                                            <option value="{{$year + $x}}">{{$year + $x}}</option>
                                        @endfor
                                    </select>
                                    <span id="error_msg"></span>
                                </div>

                                <div class="form-group"  style="margin-right: 5px;">
                                    <input type="submit" name="filter" value="Filter" id="income_filter" class="btn btn-primary">
                                </div>


                            </form>
                        </div>
                    </div></div>


            <hr style="clear: both; padding-top: 1%;">
            <div >
    <center><div id="loading"></div></center>
  </div>
<div class="card-deck" style="display: flex; flex-direction: column;">

    <div style="display: flex; flex-direction: row;">

        <div class="card border-info">
            {!! $chart4->container() !!}
        </div>
        <div class="card border-info">
            {!! $chart5->container() !!}
        </div>

    </div>


    <div class="pt-4" style="display: flex; flex-direction: row;">

        <div class="card border-info">
            {!! $chart6->container() !!}
        </div>

        <div class="card border-info">
            {!! $chart7->container() !!}
        </div>

    </div>






</div>
</div>
</div>
</div>
<br>
<div class="card">
    <div class="card-body">
     <h4 class="card-title" style="font-family: sans-serif;">Outstanding Real Estate Debt(s)</h4>
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
              <input type="file" id="debt_attachment" name="filenames[]" class="myfrm form-control" multiple="" accept=".xls,.xlsx, .pdf, .doc, .docx, .png, .jpeg, .jpg">
              <center><span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="debt_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="debt_closing" name="closing" class="form-control" value="Regards, Real Estate Department UDSM." readonly="">
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
                                <th scope="col" class="text-center"><center>S/N</center></th>
                                <th scope="col" >Debtor Name</th>
                                <th scope="col" class="text-right">Invoice Number</th>
{{--                                <th scope="col" >Start Date</th>--}}
{{--                                <th scope="col" >End date</th>--}}
                               {{--  <th scope="col" >Period</th> --}}
                                <th scope="col" class="text-right">Contract Id</th>
                                <th scope="col" class="text-right">Amount</th>
                                {{-- <th scope="col" >GePG Control No</th> --}}
{{--                                <th scope="col" >Invoice Date</th>--}}
                                <th scope="col" class="text-right">Time Overdue</th>
                                @if((Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
                                <th scope="col" class="text-center">Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $var)
                                 <tr>
                                    <th scope="row" class="text-center">{{$b}}.</th>
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
                                    <td class="text-right">
                                            <a  title="View invoice" style="color:#3490dc !important; display:inline-block; cursor: pointer;"  class="" data-toggle="modal" data-target="#invoice{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center>
                                                {{$var->invoice_number_votebook}}</center></a>
                                            <div class="modal fade" id="invoice{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Full Invoice Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table class="table table-striped table-bordered " style="width: 100%">

                                                                <tr>
                                                                    <td>Client:</td>
                                                                    <td>{{$var->debtor_name}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Invoice Number:</td>
                                                                    <td>{{$var->invoice_number_votebook}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Income(Inc) Code:</td>
                                                                    <td>{{$var->inc_code}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td> Start Date:</td>
                                                                    <td> {{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td> End Date:</td>
                                                                    <td> {{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Period:</td>
                                                                    <td> {{$var->period}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td> Project ID:</td>
                                                                    <td> {{$var->project_id}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Amount:</td>
                                                                    <td> {{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>GePG Control Number:</td>
                                                                    <td>{{$var->gepg_control_no}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Payment Status:</td>
                                                                    <td>{{$var->payment_status}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Invoice Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->invoice_date))}}</td>
                                                                </tr>



                                                                <tr>
                                                                    <td>Comments:</td>
                                                                    <td>{{$var->user_comments}}</td>
                                                                </tr>






                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div></td>

{{--                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>--}}
{{--                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>--}}
                                    <td class="text-right">
                                       <a title="View contract" class="link_style" style="color: blue !important; cursor: pointer;"  class="" data-toggle="modal" data-target="#contracta{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true">{{$var->contract_id}}</a>
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
                                                                    <td> Real Estate Number:</td>
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
                                    <td class="text-right">{{$var->currency_invoice}} {{number_format($var->amount_not_paid)}}</td>
{{--                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>--}}
                                    <td style="text-align: right;" class="text-right">{{$diff = Carbon\Carbon::parse($var->invoice_date)->diffForHumans(null, true) }}</td>
                                    @if((Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
                                    <td class="text-center">
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
              <input type="file" id="spaceattachment{{$var->invoice_number}}" name="filenames[]" class="myfrm form-control" multiple="" accept=".xls,.xlsx, .pdf, .doc, .docx, .png, .jpeg, .jpg">
              <center><span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="spaceclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="spaceclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, Real Estate Department UDSM." readonly="">
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
                                    <?php $b = $b+1; ?>
                                  @endforeach
                                </tbody>
</table>
</div>
</div>
<br>
<div class="card">
    <div class="card-body">
     <h3 class="card-title" style="font-family: sans-serif;">Outstanding Car Rental Debt(s)</h3>
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
              <input type="file" id="aia_attachment" name="filenames[]" class="myfrm form-control" multiple="" accept=".xls,.xlsx, .pdf, .doc, .docx, .png, .jpeg, .jpg">
              <center><span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="aia_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="aia_closing" name="closing" class="form-control" value="Regards, Central Pool Transport Unit UDSM." readonly="">
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
                                <th scope="col" class="text-right">Invoice Number</th>
{{--                                <th scope="col" >Start Date</th>--}}
{{--                                <th scope="col" >End date</th>--}}
                               {{--  <th scope="col" >Period</th> --}}
                                <th scope="col" class="text-right">Contract Id</th>
                                <th scope="col" class="text-right">Amount</th>
                                {{-- <th scope="col" >GePG Control No</th> --}}
{{--                                <th scope="col" >Invoice Date</th>--}}
                                <th scope="col" class="text-right">Time Overdue</th>
                                @if((Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
                                <th scope="col" class="text-center">Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cptu_invoices as $var)
                                <tr>
                                    <td class="text-center">{{$c}}.</td>
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
                                    <td class="text-right">  <a title="View invoice" style="color:#3490dc !important; display:inline-block; cursor: pointer;"  class="" data-toggle="modal" data-target="#invoice_car{{$var->invoice_number}}"  aria-pressed="true">{{$var->invoice_number_votebook}}</a>
                                            <div class="modal fade" id="invoice_car{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Full Invoice Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table class="table table-striped table-bordered" style="width: 100%">

                                                                <tr>
                                                                    <td>Client:</td>
                                                                    <td>{{$var->debtor_name}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Invoice Number:</td>
                                                                    <td>{{$var->invoice_number_votebook}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Income(Inc) Code:</td>
                                                                    <td>{{$var->inc_code}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Start Date:</td>
                                                                    <td> {{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td> End Date:</td>
                                                                    <td> {{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Period:</td>
                                                                    <td> {{$var->period}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td> Project ID:</td>
                                                                    <td> {{$var->project_id}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Amount:</td>
                                                                    <td> {{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</td>
                                                                </tr>


                                                                @if($var->gepg_control_no!='')
                                                                    <tr>
                                                                        <td>GePG Control Number:</td>
                                                                        <td>{{$var->gepg_control_no}}</td>
                                                                    </tr>
                                                                @else
                                                                @endif



                                                                @if($var->account_no!='')
                                                                    <tr>
                                                                        <td>Account Number:</td>
                                                                        <td>{{$var->account_no}}</td>
                                                                    </tr>
                                                                @else
                                                                @endif




                                                                <tr>
                                                                    <td>Payment Status:</td>
                                                                    <td>{{$var->payment_status}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Invoice Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->invoice_date))}}</td>
                                                                </tr>



                                                                <tr>
                                                                    <td>Comments:</td>
                                                                    <td>{{$var->user_comments}}</td>
                                                                </tr>






                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div></td>

{{--                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>--}}
{{--                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>--}}
                                    {{-- <td>{{$var->period}}</td> --}}
                                    <td class="text-right">
                                      <a title="View contract" class="link_style" style="color: blue !important; cursor: pointer;"  class="" data-toggle="modal" data-target="#contracta{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true">{{$var->contract_id}}</a>
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
                                    <td class="text-right">{{$var->currency_invoice}} {{number_format($var->amount_not_paid)}}</td>
                                  {{--  <td>{{$var->gepg_control_no}}</td> --}}
{{--                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>--}}
                                    <td style="text-align: right;" class="text-right">{{$diff = Carbon\Carbon::parse($var->invoice_date)->diffForHumans(null, true) }}</td>
                                    @if((Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
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
              <input type="file" id="carattachment{{$var->invoice_number}}" name="filenames[]" class="myfrm form-control" multiple="" accept=".xls,.xlsx, .pdf, .doc, .docx, .png, .jpeg, .jpg">
              <center><span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="carclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="carclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, Central Pool Transport Unit UDSM." readonly="">
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
                                    <?php $c = $c + 1; ?>
                                  @endforeach
                                </tbody>
</table>
</div>
</div>
<br>
<div class="card">
    <div class="card-body">
     <h3 class="card-title" style="font-family: sans-serif;">Outstanding Insurance Debt(s)</h3>
     <hr>
         <a title="Send email to selected clients" href="#" id="notify_all_udia" class="btn btn-info btn-sm" data-toggle="modal" data-target="#mail_all_udia" role="button" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    display: none;
    margin-top: 4px;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
        <div class="modal fade" id="mail_all_udia" role="dialog">
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
            <input type="text" id="udia_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="udia_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>

        <div class="form-group row">
            <label for="udia_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="udia_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="udia_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="udia_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="udia_message" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="udia_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="udia_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="udia_attachment" name="filenames[]" class="myfrm form-control" multiple="" accept=".xls,.xlsx, .pdf, .doc, .docx, .png, .jpeg, .jpg">
              <center><span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="udia_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="aia_closing" name="closing" class="form-control" value="Regards, Central Pool Transport Unit UDSM." readonly="">
          </div>
        </div>
        <br>
 <input type="text" name="type" value="principals" hidden="">
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
                                <th scope="col" class="text-right">Invoice Number</th>
{{--                                <th scope="col" >Start Date</th>--}}
{{--                                <th scope="col" >End date</th>--}}
                                <th scope="col" class="text-right">Amount</th>
{{--                                <th scope="col" >Invoice Date</th>--}}
                                <th scope="col" class="text-right">Time Overdue</th>
                                @if((Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
                                <th scope="col" class="text-center">Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($insurance_invoices as $var)
                                <tr>
                                    <td class="text-center">{{$d}}.</td>
                                    <td>
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
                                                                    <td>{{$var->debtor_name}}</td>
                                                                </tr>
                                                                <?php $email = DB::table('insurance_parameters')->select('company_email')->where('company',$var->debtor_name)->value('company_email')?>
                                                                <tr>
                                                                    <td> Email:</td>
                                                                    <td>{{$email}}</td>
                                                                </tr>
                                                                <?php $address = DB::table('insurance_parameters')->select('company_address')->where('company',$var->debtor_name)->value('company_address')?>
                                                                <tr>
                                                                  <td>Address:</td>
                                                                  <td>{{$address}}</td>
                                                                </tr>
                                                                <?php $tin = DB::table('insurance_parameters')->select('company_tin')->where('company',$var->debtor_name)->value('company_tin')?>
                                                                <tr>
                                                                  <td>TIN No:</td>
                                                                  <td>{{$tin}}</td>
                                                                </tr>

                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </td>
                                    <td class="text-right">  <a title="View invoice" style="cursor: pointer; color:#3490dc !important; display:inline-block;"  class="" data-toggle="modal" data-target="#invoice_insurance_principals{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center>{{$var->invoice_number_votebook}}</center></a>
                                            <div class="modal fade" id="invoice_insurance_principals{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Full Invoice Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table class="table table-striped table-bordered " style="width: 100%">

                                                                <tr>
                                                                    <td>Client:</td>
                                                                    <td>{{$var->debtor_name}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Invoice Number:</td>
                                                                    <td>{{$var->invoice_number_votebook}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Income(Inc) Code:</td>
                                                                    <td>{{$var->inc_code}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Start Date:</td>
                                                                    <td> {{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td> End Date:</td>
                                                                    <td> {{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Period:</td>
                                                                    <td> {{$var->period}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td> Project ID:</td>
                                                                    <td> {{$var->project_id}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Amount:</td>
                                                                    <td> {{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>GePG Control Number:</td>
                                                                    <td>{{$var->gepg_control_no}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Payment Status:</td>
                                                                    <td>{{$var->payment_status}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Invoice Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->invoice_date))}}</td>
                                                                </tr>



                                                                <tr>
                                                                    <td>Comments:</td>
                                                                    <td>{{$var->user_comments}}</td>
                                                                </tr>






                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div></td>

{{--                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>--}}
{{--                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>--}}
{{--                                    --}}{{-- <td>{{$var->period}}</td> --}}
                                    <td class="text-right">{{$var->currency_invoice}} {{number_format($var->amount_not_paid)}}</td>
                                  {{--  <td>{{$var->gepg_control_no}}</td> --}}
{{--                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>--}}
                                    <td style="text-align: right;" class="text-right">{{$diff = Carbon\Carbon::parse($var->invoice_date)->diffForHumans(null, true) }}</td>
                                                                       @if((Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
                                    <td>
                                      @if($email!='')
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
            <label for="udiaclient_names{{$var->invoice_number}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="udiaclient_names{{$var->invoice_number}}" name="client_name" class="form-control" value="{{$var->debtor_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="udiasubject{{$var->invoice_number}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="udiasubject{{$var->invoice_number}}" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="udiagreetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="udiagreetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear {{$var->debtor_name}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="udiamessage{{$var->invoice_number}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="udiamessage{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="udiaattachment{{$var->invoice_number}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="udiaattachment{{$var->invoice_number}}" name="filenames[]" class="myfrm form-control" multiple="" accept=".xls,.xlsx, .pdf, .doc, .docx, .png, .jpeg, .jpg" >
              <center><span style="font-size: 11px; color: red;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="udiaclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="udiaclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, University of Dar es Salaam Insurance Agency." readonly="">
          </div>
        </div>
        <br>
        <input type="text" name="type" value="principals" hidden="">

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
                                    <?php $d = $d + 1; ?>
                                  @endforeach
                                </tbody>
</table>
     </div>
   </div>
   <br>


                     <div class="card">
                    <div class="card-body">
                     <h3 class="card-title" style="font-family: sans-serif;">Outstanding Research Flats Debt(s)</h3>
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
                     <table class="hover table table-striped table-bordered" id="flats_Table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"><center>S/N</center></th>
                                <th scope="col" >Debtor Name</th>
                                <th scope="col" class="text-right">Invoice Number</th>
{{--                                <th scope="col" >Arrival Date</th>--}}
{{--                                <th scope="col" >Departure date</th>--}}
                                <th scope="col" class="text-right">Contract Id</th>
                                <th scope="col" style="width: 12%;" class="text-right">Amount</th>
{{--                                <th scope="col" >Invoice Date</th>--}}
                                <th scope="col" class="text-right">Time Overdue</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($flats_invoices as $var)
                                <tr>
                                    <td  class="counterCell text-center">.</td>
                                    <td>{{$var->debtor_name}}</td>
                                    <td class="text-right"> <a title="View invoice" style="color:#3490dc !important; display:inline-block; cursor: pointer;"  class="" data-toggle="modal" data-target="#invoice_research{{$var->invoice_number}}"  aria-pressed="true">{{$var->invoice_number_votebook}}</a>
                                            <div class="modal fade" id="invoice_research{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Full Invoice Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%">

                                                                <tr>
                                                                    <td>Client:</td>
                                                                    <td>{{$var->debtor_name}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Invoice Number:</td>
                                                                    <td>{{$var->invoice_number_votebook}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Income(Inc) Code:</td>
                                                                    <td>{{$var->inc_code}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Start Date:</td>
                                                                    <td> {{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td> End Date:</td>
                                                                    <td> {{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Period:</td>
                                                                    <td> {{$var->period}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td> Project ID:</td>
                                                                    <td> {{$var->project_id}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Amount:</td>
                                                                    <td> {{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</td>
                                                                </tr>



                                                                <tr>
                                                                    <td>GePG Control Number:</td>
                                                                    <td>{{$var->gepg_control_no}}</td>
                                                                </tr>









                                                                <tr>
                                                                    <td>Payment Status:</td>
                                                                    <td>{{$var->payment_status}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Invoice Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->invoice_date))}}</td>
                                                                </tr>



                                                                <tr>
                                                                    <td>Comments:</td>
                                                                    <td>{{$var->user_comments}}</td>
                                                                </tr>






                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div></td>
{{--                                    <td><center>{{date("d/m/Y",strtotime($var->arrival_date))}}</center></td>--}}
{{--                                    <td><center>{{date("d/m/Y",strtotime($var->departure_date))}}</center></td>--}}
                                    <td class="text-right">  <a title="View contract" style="cursor: pointer; color:#3490dc !important; display:inline-block;"  class="" data-toggle="modal" data-target="#contract_research{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true">{{$var->id}}</a>
                                            <div class="modal fade" id="contract_research{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Contract Details</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%">

                                                                <tr>
                                                                    <td>Contract ID:</td>
                                                                    <td>{{$var->id}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Client:</td>
                                                                    <td>{{$var->first_name}} {{$var->last_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Host Name:</td>
                                                                    <td> {{$var->host_name}}</td>
                                                                </tr>




                                                                <tr>
                                                                    <td>Arrival Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->arrival_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Departure Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->departure_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Room Number:</td>
                                                                    <td>{{$var->room_no}}</td>
                                                                </tr>




                                                                <tr>
                                                                    <td>Total Amount(TZS):</td>
                                                                    <td>{{number_format($var->total_tzs)}} TZS</td>
                                                                    {{--                                                                    <td>{{number_format($var->amount)}} {{$var->currency}}</td>--}}
                                                                </tr>


                                                                <tr>
                                                                    <td>Total Amount(USD):</td>
                                                                    <td>{{number_format($var->total_usd)}} USD</td>
                                                                    {{--                                                                    <td>{{number_format($var->amount)}} {{$var->currency}}</td>--}}
                                                                </tr>

                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div></td>

                                    <td style="text-align: right;" class="text-right">{{$var->currency_invoice}} {{number_format($var->amount_not_paid)}}</td>
{{--                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>--}}
                                    <td style="text-align: right;" class="text-right">{{$diff = Carbon\Carbon::parse($var->invoice_date)->diffForHumans(null, true) }}</td>
                                    <td class="text-center">
                                      @if(($var->invoice_debtor=='individual' && $var->email!='') || ($var->invoice_debtor=='host' && $var->host_email!=''))
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
                              <label for="flatsclient_names{{$var->invoice_number}}" class="col-sm-2">To</label>
                              <div class="col-sm-9">
                              <input type="text" id="flatsclient_names{{$var->invoice_number}}" name="client_name" class="form-control" value="{{$var->debtor_name}}" readonly="">
                            </div>
                          </div>
                          <br>
                          <div class="form-group row">
                              <label for="flatssubject{{$var->invoice_number}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
                              <div class="col-sm-9">
                              <input type="text" id="flatssubject{{$var->invoice_number}}" name="subject" class="form-control" value="" required="">
                            </div>
                          </div>
                           <br>
                           <div class="form-group row">
                              <label for="flatsgreetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
                              <div class="col-sm-9">
                              <input type="text" id="flatsgreetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear {{$var->debtor_name}}," readonly="">
                            </div>
                          </div>
                           <br>

                          <div class="form-group row">
                              <label for="flatsmessage{{$var->invoice_number}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
                              <div class="col-sm-9">
                                <textarea type="text" id="flatsmessage{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
                            </div>
                          </div>
                          <br>

                          <div class="form-group row">
                              <label for="flatsattachment{{$var->invoice_number}}" class="col-sm-2">Attachments</label>
                               <div class="col-sm-9">
                                <input type="file" id="flatsattachment{{$var->invoice_number}}" name="filenames[]" class="myfrm form-control" multiple="">
                                <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
                            </div>
                          </div>
                          <br>

                          <div class="form-group row">
                              <label for="flatsclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
                              <div class="col-sm-9">
                              <input type="text" id="flatsclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
                            </div>
                          </div>
                          <br>
                          <input type="text" name="type" value="flats" hidden="">
                          <input type="text" name="debtor" value="{{$var->invoice_debtor}}" hidden="">
                          <input type="text" name="contract_id" value="{{$var->id}}" hidden>


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

  var tablee = $('#myTable2').DataTable( {
    dom: '<"top"l>rt<"bottom"pi>'
  } );

  var table30 = $('#myTable3').DataTable( {
    dom: '<"top"l>rt<"bottom"pi>'
  } );

  var table32 = $('#flats_Table').DataTable( {
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
        //alert("This client has no email");
      }
      else{
        $(this).toggleClass('selected');
         var count2=table2.rows('.selected').data().length +' row(s) selected';

      if(count2>='2'){
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

      if(count3>='2'){
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
         if(count4>='2'){
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


    $('#myTable3 tbody').on( 'click', 'tr', function () {
      document.getElementById("udia_par_names").innerHTML="";
      document.getElementById("udia_greetings").value="Dear ";
       var email30 = $(this).find('td:eq(4)').text();
      if(email30==" "){
        //alert("This client has no email");
      }
      else{
        $(this).toggleClass('selected');
         var count30=table30.rows('.selected').data().length;
         if(count30>='2'){
      <?php $role=Auth::user()->role;?>
       var role={!! json_encode($role) !!};
        if(role=='System Administrator'){
          $('#notify_all_udia').show();
        }
        else{
          $('#notify_all_udia').hide();
        }
      }
      else{
        $('#notify_all_udia').hide();
      }
    }

    });

     $('#notify_all_udia').click( function () {
      document.getElementById("udia_par_names").innerHTML="";
      document.getElementById("udia_greetings").value="Dear ";
        var datas30 = table30.rows('.selected').data();
        var result30 = [];
        for (var i = 0; i < datas30.length; i++)
        {
                result30.push(datas30[i][1].split('"true">').pop().split('</a>')[0]);
        }

        $('#udia_client_names').val(result30).toString();

        var content30 = document.getElementById("udia_par_names");
        for(var i=0; i< result30.length;i++){
          if(i==(result30.length-1)){
            content30.innerHTML += result30[i]+ '.';
          }
          else{
            content30.innerHTML += result30[i] + ', ';
          }

        }

        var salutation30 = document.getElementById("udia_greetings");
        for(var i=0; i< result30.length;i++){
          if(i==(result30.length-1)){
            salutation30.value += result30[i]+ '.';
          }
          else{
            salutation30.value += result30[i] + ', ';
          }

        }

    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
  $(document).ajaxSend(function(){
    $("#loading").fadeIn(250);
    });
$(document).ajaxComplete(function(){
    $("#loading").fadeOut(250);
    });

$("#income_filter").click(function(e){
  e.preventDefault();

    var query = $('#income_year').val();

    if(query==null){
      $('#error_msg').show();
      var message=document.getElementById('error_msg');
      message.style.color='red';
      message.innerHTML="Required";
      $('#income_year').attr('style','border:1px solid #f00');
    }
    else{
      $('#error_msg').hide();
      $('#income_year').attr('style','border:1px solid #ccc');
      $.ajax({
      url: "/dashboard/income_filter?",
      context: document.body,
      async : false,
      data:{year:query}
      })
    .done(function(data) {
      {{$chart4->id}}.options.title.text = 'UDIA Income Generation '+query;
      {{ $chart4->id }}.data.datasets[0].data =data.britam;
      {{ $chart4->id }}.data.datasets[1].data =data.nic;
      {{ $chart4->id }}.data.datasets[2].data =data.icea;
      {{ $chart4->id }}.update();

      {{$chart5->id}}.options.title.text = 'CPTU Income Generation '+query;
      {{ $chart5->id }}.data.datasets[0].data =data.cptu;
      // $chart5->id.data.datasets.label = 'CPTU Income';
      {{ $chart5->id }}.update();

      {{$chart6->id}}.options.title.text = 'Real Estate Income Generation '+query;
      {{ $chart6->id }}.data.datasets[0].data =data.space;

      {{ $chart6->id }}.update();

      {{$chart7->id}}.options.title.text = 'Research Flats Income Generation '+query;
      {{ $chart7->id }}.data.datasets[0].data =data.flats1;
      {{ $chart7->id }}.data.datasets[1].data =data.flats2;
      {{ $chart7->id }}.update();

    });
    }
    return false;



});

$("#activity_filter").click(function(e){
  e.preventDefault();

    var query = $('#activity_year').val();

    if(query==null){
      $('#activity_msg').show();
      var message=document.getElementById('activity_msg');
      message.style.color='red';
      message.innerHTML="Required";
      $('#activity_year').attr('style','border:1px solid #f00');
    }
    else{
      $('#activity_msg').hide();
      $('#activity_year').attr('style','border:1px solid #ccc');
      $.ajax({
      url: "/dashboard/activity_filter?",
      context: document.body,
      async : false,
      data:{year:query}
      })
    .done(function(data) {
      {{$chart->id}}.options.title.text = 'UDIA Activities '+query;
      {{ $chart->id }}.data.datasets[0].data =data.udia;
      {{ $chart->id }}.update();

      {{$chart2->id}}.options.title.text = 'CPTU Activities '+query;
      {{ $chart2->id }}.data.datasets[0].data =data.cptu;
      {{ $chart2->id }}.update();

      {{$chart3->id}}.options.title.text = 'Real Estate Activities '+query;
      {{ $chart3->id }}.data.datasets[0].data =data.space;

      {{ $chart3->id }}.update();

      {{$chart41->id}}.options.title.text = 'Research Flats Activities '+query;
      {{ $chart41->id }}.data.datasets[0].data =data.flats;
      {{ $chart41->id }}.update();

    });
    }
    return false;

});

});
</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script> --}}
        {!! $chart->script() !!}
         {!! $chart2->script() !!}
         {!! $chart3->script() !!}
         {!! $chart4->script() !!}
         {!! $chart41->script() !!}
          {!! $chart5->script() !!}
           {!! $chart6->script() !!}
           {!! $chart7->script() !!}
@endsection
