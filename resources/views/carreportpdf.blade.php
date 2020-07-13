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
        ->join('clients', 'clients.full_name', '=', 'car_contracts.fullName')
        ->join('car_rentals', 'car_rentals.vehicle_reg_no', '=', 'car_contracts.vehicle_reg_no')
    	->where('clients.contract', 'Car Rental')
    	->orderBy('car_contracts.fullName','asc')
    	->get();
        }
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
      <th scope="col"><center>Amount</center></th>
      <th scope="col"><center>Rates</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($clients as $client)
    <tr>
    <td class="counterCell text-center">.</td>
    <td>{{$client->fullName}}</td>
    <td>{{$client->vehicle_reg_no}}</td>
    <td><center>{{$client->start_date}}</center></td>
    <td><center>{{$client->end_date}}</center></td>
    <td><center>{{$client->currency}} {{$client->amount}}</center></td>
    <td><center>{{$client->rate}}</center></td>
</tr>
@endforeach
</tbody>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif
@endif

        
</body>
</html>