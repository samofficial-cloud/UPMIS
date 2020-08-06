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
use App\carRental;
use App\carContract;
      if($_GET['report_type']=='cars'){
        
        $cars=carRental::get();
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
    <br><br><strong>List of Rental Cars</strong>
</center>
<br>
@if(count($cars)>0)
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
  	@foreach($cars as $cars)
      <tr>
      <th class="counterCell text-center">.</th>
      <td><center>{{ $cars->vehicle_reg_no}}</center></td>
      <td><center>{{$cars->vehicle_model}}</center></td>
      <td><center>{{ $cars->vehicle_status}}</center></td>
      <td><center>{{ $cars->hire_rate}}</center></td>
      </tr>
      @endforeach
  </tbody>
</table>
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