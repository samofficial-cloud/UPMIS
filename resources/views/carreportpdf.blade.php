<!DOCTYPE html>
<html>
<head>
	<title>CAR RENTAL</title>
</head>
<style>
table {
  border-collapse: collapse;
   width: 100%;
}

table, td, th {
  border: 1px solid black;
}
table {
  counter-reset: tableCount;
  }

  .counterCell:before {
  content: counter(tableCount);
  counter-increment: tableCount;
  }
</style>
<body>
<?php
$i=1;
use App\carRental;
use App\carContract;
      if($_GET['report_type']=='cars'){
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
        
        }
        else if($_GET['report_type']=='clients'){

        $clients=DB::table('car_contracts')
        ->where('form_completion','1')
    	->orderBy('car_contracts.fullName','asc')
    	->get();
        }

        else if ($_GET['report_type']=='revenue'){
          $revenues=DB::table('car_contracts')
        ->join('car_rental_invoices', 'car_rental_invoices.contract_id', '=', 'car_contracts.id')
        ->where('payment_status','Paid')
        ->whereDate('invoicing_period_start_date','>=',$_GET['start_date'])
        ->whereDate('invoicing_period_end_date','<=',$_GET['end_date'])
        ->orderBy('invoicing_period_start_date','asc')
        ->get();
        }
        $total=0;
?>
@if($_GET['report_type']=='cars')
<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    @if(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true'))
    <br><br>List of <strong>{{$_GET['rent']}}</strong> vehicles between <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> and <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong> whose model is <strong>{{$_GET['model']}}</strong>, vehicle status is <strong>{{$_GET['status']}}</strong> and hire rate is between <strong>TZS {{number_format($_GET['min'])}}</strong> and <strong> TZS {{number_format($_GET['max'])}}</strong>
    @elseif(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true'))
    <br><br>List of vehicles whose model is <strong>{{$_GET['model']}}</strong>, vehicle status is <strong>{{$_GET['status']}}</strong> and hire rate is between <strong>TZS {{number_format($_GET['min'])}}</strong> and <strong> TZS {{number_format($_GET['max'])}}</strong>
    @elseif(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true'))
    <br><br>List of <strong>{{$_GET['rent']}}</strong> vehicles between <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> and <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong> whose model is <strong>{{$_GET['model']}}</strong> and vehicle status is <strong>{{$_GET['status']}}</strong>
    @elseif(($_GET['model_fil']=='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true'))
    <br><br>List of vehicles whose model is <strong>{{$_GET['model']}}</strong> and vehicle status is <strong>{{$_GET['status']}}</strong>
     @elseif(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true'))
      <br><br>List of <strong>{{$_GET['rent']}}</strong> vehicles between <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> and <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong> whose model is <strong>{{$_GET['model']}}</strong> and hire rate is between <strong>TZS {{number_format($_GET['min'])}}</strong> and <strong> TZS {{number_format($_GET['max'])}}</strong>
       @elseif(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true'))
       <br><br>List of vehicles whose model is <strong>{{$_GET['model']}}</strong> and hire rate is between <strong>TZS {{number_format($_GET['min'])}}</strong> and <strong> TZS {{number_format($_GET['max'])}}</strong>
        @elseif(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true'))
        <br><br>List of <strong>{{$_GET['rent']}}</strong> vehicles between <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> and <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong> whose model is <strong>{{$_GET['model']}}</strong>
        @elseif(($_GET['model_fil']=='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true'))
        <br><br>List of vehicles whose model is <strong>{{$_GET['model']}}</strong>
        @elseif(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true'))
    <br><br>List of <strong>{{$_GET['rent']}}</strong> vehicles between <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> and <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong> whose vehicle status is <strong>{{$_GET['status']}}</strong> and hire rate is between <strong>TZS {{number_format($_GET['min'])}}</strong> and <strong> TZS {{number_format($_GET['max'])}}</strong>
     @elseif(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true'))
     <br><br>List of vehicles whose vehicle status is <strong>{{$_GET['status']}}</strong> and hire rate is between <strong>TZS {{number_format($_GET['min'])}}</strong> and <strong> TZS {{number_format($_GET['max'])}}</strong>
      @elseif(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true'))
      <br><br>List of <strong>{{$_GET['rent']}}</strong> vehicles between <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> and <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong> whose vehicle status is <strong>{{$_GET['status']}}</strong>
       @elseif(($_GET['model_fil']!='true')&&($_GET['stat_fil']=='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true'))
       <br><br>List of vehicles whose vehicle status is <strong>{{$_GET['status']}}</strong>
       @elseif(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']=='true'))
       <br><br>List of <strong>{{$_GET['rent']}}</strong> vehicles between <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> and <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong> whose hire rate is between <strong>TZS {{number_format($_GET['min'])}}</strong> and <strong> TZS {{number_format($_GET['max'])}}</strong>
       @elseif(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']=='true')&&($_GET['rent_fil']!='true'))
        <br><br>List of vehicles whose hire rate is between <strong>TZS {{number_format($_GET['min'])}}</strong> and <strong> TZS {{number_format($_GET['max'])}}</strong>
        @elseif(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']=='true'))
        <br><br>List of <strong>{{$_GET['rent']}}</strong> vehicles between <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> and <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>
         @elseif(($_GET['model_fil']!='true')&&($_GET['stat_fil']!='true')&&($_GET['range_fil']!='true')&&($_GET['rent_fil']!='true'))
          <br><br>List of Rental Vehicles
    @endif
</center>
<br>
@if(count($cars)>0)
@if(($_GET['rent_fil']=='true'))
@if($_GET['rent']=='Rented')
@foreach($cars as $cars)
<b>{{$i}}. {{ $cars->vehicle_reg_no}}</b>
<br>
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><center>S/N</center></th>
      <th scope="col"><center>Vehicle Registration No.</center></th>
      <th scope="col"><center>Vehicle Model</center></th>
      <th scope="col"><center>Vehicle Status</center></th>
      <th scope="col"><center>Hire Rate</center></th>
    </tr>
  </thead>
  <tbody>
      <tr>
      <th class="counterCell text-center">.</th>
      <td><center>{{ $cars->vehicle_reg_no}}</center></td>
      <td>{{$cars->vehicle_model}}</td>
      <td><center>{{ $cars->vehicle_status}}</center></td>
      <td><center>{{ number_format($cars->hire_rate)}}</center></td>
      </tr>
  </tbody>
</table>
<?php
$i=$i+1;
$j=1;
$from=date('Y-m-d',strtotime($_GET['start']));
$to=date('Y-m-d',strtotime($_GET['end']));
$clients=carContract::wherebetween('start_date',[ $from ,$to ])->where('vehicle_reg_no',$cars->vehicle_reg_no)
  ->orwherebetween('end_date',[ $from ,$to ])->where('vehicle_reg_no',$cars->vehicle_reg_no)
  ->orderBy('start_date','asc')
  ->get();
?>
<br>
Detailed Information:
<table>
  <thead class="thead-dark">
    <tr>
      <th scope="col"><center>S/N</center></th>
      <th scope="col"><center>Client Name</center></th>
      <th scope="col"><center>Start Date</center></th>
      <th scope="col"><center>End date</center></th>
      <th scope="col"><center>Destination</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($clients as $client)
      <tr>
      <th>{{$j}}.</th>
      <td>{{ $client->fullName}}</td>
      <td><center>{{date("d/m/Y",strtotime($client->start_date))}}</center></td>
      <td><center>{{ date("d/m/Y",strtotime($client->end_date))}}</center></td>
      <td>{{ $client->destination}}</td>
      </tr>
      <?php
      $j=$j+1;
      ?>
      @endforeach
  </tbody>
</table>
<br>
<hr>
@endforeach
@elseif($_GET['rent']=='Available')
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><center>S/N</center></th>
      <th scope="col"><center>Vehicle Registration No.</center></th>
      <th scope="col"><center>Vehicle Model</center></th>
      <th scope="col"><center>Vehicle Status</center></th>
      <th scope="col"><center>Hire Rate/Km</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($cars as $cars)
      <tr>
      <th class="counterCell text-center">.</th>
      <td><center>{{ $cars->vehicle_reg_no}}</center></td>
      <td><center>{{$cars->vehicle_model}}</center></td>
      <td><center>{{ $cars->vehicle_status}}</center></td>
      <td><center>{{ number_format($cars->hire_rate)}}</center></td>
      </tr>
      @endforeach
  </tbody>
</table>
@endif
@else
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><center>S/N</center></th>
      <th scope="col"><center>Vehicle Registration No.</center></th>
      <th scope="col"><center>Vehicle Model</center></th>
      <th scope="col"><center>Vehicle Status</center></th>
      <th scope="col"><center>Hire Rate/Km</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($cars as $cars)
      <tr>
      <th class="counterCell text-center">.</th>
      <td>{{ $cars->vehicle_reg_no}}</td>
      <td>{{$cars->vehicle_model}}</td>
      <td>{{ $cars->vehicle_status}}</td>
      <td>{{ number_format($cars->hire_rate)}}</td>
      </tr>
      @endforeach
  </tbody>
</table>
@endif
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif
        
@elseif($_GET['report_type']=='clients')
<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    <br><br><strong>List of Car Rental Clients</strong>
</center>
<br>
@if(count($clients)>0)
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><center>S/N</center></th>
      <th scope="col"><center>Client Name</center></th>
      <th scope="col"><center>Vehicle Registration No.</center></th>
      <th scope="col"><center>Start Date</center></th>
      <th scope="col"><center>End Date</center></th>
      <th scope="col"><center>Destination</center></th>
      {{-- <th scope="col"><center>Rates</center></th> --}}
    </tr>
  </thead>
  <tbody>
    @foreach($clients as $client)
    <tr>
    <td class="counterCell text-center">.</td>
    <td>{{$client->designation}} {{$client->fullName}}</td>
    <td>{{$client->vehicle_reg_no}}</td>
    <td><center>{{$client->start_date}}</center></td>
    <td><center>{{$client->end_date}}</center></td>
    <td><center>{{$client->destination}}</center></td>
    {{-- <td><center>{{$client->rate}}</center></td> --}}
</tr>
@endforeach
</tbody>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif
@elseif($_GET['report_type']=='revenue')
<center>
  <b>UNIVERSITY OF DAR ES SALAAM<br><br>
  <img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    <br><br><strong>CPTU Revenue Report For the Duration of {{$_GET['start_date']}} to {{$_GET['end_date']}}</strong>
</center>
<br>
@if(count($revenues)>0)
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="width: 5%"><center>S/N</center></th>
      <th scope="col"><center>Client Name</center></th>
      <th scope="col"><center>Vehicle Registration No.</center></th>
      <th scope="col"><center>Invoicing Start Date</center></th>
      <th scope="col"><center>Invoicing End Date</center></th>
      <th scope="col" style="width: 16%"><center>Amount Paid</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($revenues as $client)
    <tr>
    <td class="counterCell text-center">.</td>
    <td>{{$client->fullName}}</td>
    <td>{{$client->vehicle_reg_no}}</td>
    <td><center>{{$client->invoicing_period_start_date}}</center></td>
    <td><center>{{$client->invoicing_period_end_date}}</center></td>
    <td><center>{{$client->currency}} {{$client->amount_to_be_paid}}</center></td>
</tr>
<?php
$total=$total + $client->amount_to_be_paid;
?>
@endforeach
</tbody>
</table>
<table>
  <tr style="width: 100%">
  <td><b>TOTAL</b></td>
  <td style="width: 16%"><center>{{$client->currency}} {{$total}}</center></td>
</tr>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif
@endif

        
</body>
</html>