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
    border: 2px solid #505559;
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

  .card:hover {
   /* cursor: not-allowed;*/
    animation-duration: 20ms;
    animation-timing-function: linear;
    animation-iteration-count: 10;
    animation-name: wiggle;
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
            <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>


            @if($category=='Real Estate only' OR $category=='All')
                <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            @else
            @endif

            @if($category=='Insurance only' OR $category=='All')
                <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
            @else
            @endif

            @if($category=='CPTU only' OR $category=='All')
                <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
            @else
            @endif

            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>

            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>
            <li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>

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
  $total_spaces=space::where('status','1')->count();
  $occupied_spaces=space_contract::where('contract_status','1')->wheredate('end_date','>',date('Y-m-d'))->distinct()->count();
  $available_spaces=space::select('space_id')
        ->whereNotIn('space_id',DB::table('space_contracts')->select('space_id_contract')->where('space_id_contract','!=',null)->whereDate('end_date', '>',date('Y-m-d'))->distinct()->pluck('space_id_contract')->toArray())
        ->where('status','1')
        ->count();
  $total_cars=carRental::where('flag','1')->count();
  $running_cars=carRental::where('flag','1')->where('vehicle_status','Running')->count();
  $minor_cars=carRental::where('flag','1')->where('vehicle_status','Minor Repair')->count();
  $grounded_cars=carRental::where('flag','1')->where('vehicle_status','Grounded')->count();
  $total_insurance=insurance::select('insurance_company')->groupby('insurance_company')->distinct()->get();
  ?>
    <br>

    <div class="container">
        <br>
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
  <div class="card text-white" style="background-color: #e3342f;">
    <div class="card-body">
     <h5 class="card-title">Spaces <i class="fa fa-line-chart" style="font-size:30px; float: right; color: black;"></i></h5>
      <p>Total Spaces: {{$total_spaces}}
      <br>Occupied: {{$occupied_spaces}}
      <br>Available: {{$available_spaces}}
    </div>
  </div>
</div>
        <br>
        <div class="card-deck">
  <div class="card">
     {!! $chart->container() !!}
  </div>
  <div class="card">
     {!! $chart2->container() !!}
  </div>
  <div class="card">
     {!! $chart3->container() !!}
  </div>
</div>
<br>
  <div class="card">
    <div class="card-body">
     <h5 class="card-title" style="font-family: sans-serif;">Space Contract(s) that are about to expire</h5>
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
          @foreach($space_contract as $space)
          <tr>

            <th scope="row" class="counterCell">.</th>

              <td>{{$space->full_name}}</td>
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
<div class="card-deck">
  <div class="card">
     {!! $chart4->container() !!}
  </div>
  <div class="card">
     {!! $chart5->container() !!}
  </div>
  <div class="card">
     {!! $chart6->container() !!}
  </div>
</div>
<br>
<div class="card">
    <div class="card-body">
     <h5 class="card-title" style="font-family: sans-serif;">Outstanding Space Debt(s)</h5>
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
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $var)
                                <tr>
                                    <th scope="row" class="counterCell">.</th>
                                    <td>{{$var->debtor_name}}</td>
                                    <td><center>{{$var->invoice_number}}</center></td>

                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                   {{--  <td>{{$var->period}}</td> --}}
                                    <td><center>{{$var->contract_id}}</center></td>
                                    <td>{{$var->currency_invoice}} {{number_format($var->amount_to_be_paid)}}</td>
                                   {{--  <td>{{$var->gepg_control_no}}</td> --}}
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
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
  var table = $('#myTable').DataTable( {
    dom: '<"top"l>rt<"bottom">'
  } );

  var table1 = $('#myTable1').DataTable( {
    dom: '<"top"l>rt<"bottom">'
  } );

</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script> --}}
        {!! $chart->script() !!}
         {!! $chart2->script() !!}
         {!! $chart3->script() !!}
         {!! $chart4->script() !!}
          {!! $chart5->script() !!}
           {!! $chart6->script() !!}
@endsection
