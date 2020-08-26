<!DOCTYPE html>
<html>
<head>
	<title>Car Rental History Report</title>
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
    use App\operational_expenditure;

    $details=carRental::where('vehicle_reg_no',$_GET['reg'])->get();
    $bookings=carContract::where('vehicle_reg_no',$_GET['reg'])->orderby('start_date','asc')->get();
    $operations=operational_expenditure::where('vehicle_reg_no',$_GET['reg'])->orderby('date_received','asc')->get();
    $i=1;
	?>
<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT 
     <br><br>History Report for <strong>{{$_GET['reg']}}</strong> 
    </b> 
</center>
<br>
<h4>Vehicle Details</h4>
		<table style="font-size: 18px;width: 50%" id="t_id">
			@foreach($details as $details)
			<tr>
				<td style="width: 20%">Vehicle model</td>
				<td style="width: 30%">{{ucfirst(strtolower($details->vehicle_model))}}</td>
			</tr>
			<tr>
				<td>Vehicle status</td>
				<td>{{$details->vehicle_status}}</td>
			</tr>
			<tr>
				<td>Hire rate</td>
				<td>{{number_format($details->hire_rate)}}</td>
			</tr>
			@endforeach
		</table>
		<br>
		<hr>
	<h4>Bookings</h4>
	@if(count($bookings)>0)
	<table class="hover table table-striped table-bordered" id="myTable1">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="width: 5%;"><center>S/N</center></th>
      <th scope="col"><center>Client Name</center></th>
       <th scope="col"><center>Cost Center</center></th>
      <th scope="col"><center>Trip Start Date</center></th>
       <th scope="col"><center>Trip End Date</center></th>
      <th scope="col"><center>Destination</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($bookings as $bookings)
      <tr>
      	<th scope="row" class="counterCell text-center">.</th>
      	<td>{{$bookings->fullName}}</td>
      	<td><center>{{$bookings->cost_centre}}</center></td>
      	<td><center>{{date("d/m/Y",strtotime($bookings->start_date))}}</center></td>
      	<td><center>{{date("d/m/Y",strtotime($bookings->end_date))}}</center></td>
      	<td><center>{{$bookings->destination}}</center></td>
      </tr>
      @endforeach
  </tbody>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif
<br>
<hr>
<h4>Operational Expenditure</h4>
@if(count($operations)>0)
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="width: 5%;"><center>S/N</center></th>
      <th scope="col"><center>LPO No.</center></th>
      <th scope="col"><center>Date Received</center></th>
      <th scope="col"><center>Description of Work</center></th>
      <th scope="col"><center>Service Provider</center></th>
      <th scope="col"><center>Fuel Consumed (litres)</center></th>
      <th scope="col"><center>Amount</center></th>
      <th scope="col"><center>Total</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($operations as $operational)
      <tr>
        <th scope="row">{{$i}}.</th>
        <td>{{$operational->lpo_no}}</td>
        <td><center>{{date("d/m/Y",strtotime($operational->date_received))}}</center></td>
        <td>{{$operational->description}}</td>
        <td>{{$operational->service_provider}}</td>
        <td>{{$operational->fuel_consumed}}</td>
        <td>{{number_format($operational->amount)}}</td>
        <td>{{number_format($operational->total)}}</td>
    </tr>
    <?php
    $i=$i+1;
    ?>
    @endforeach
</tbody>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif
</body>
</html>