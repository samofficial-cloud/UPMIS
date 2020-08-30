<!DOCTYPE html>
<html>
<head>
	<title>Car Rental Operational Report</title>
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
	Use App\operational_expenditure;
    $operational=operational_expenditure::where('flag',1)->get();
	?>
	<br>
	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    <br><br><strong>Revenue Report For Service, Repairs and Fuel For Motor Vehicles</strong>
</center>
<br>
<table class="hover table table-striped table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><center>S/N</center></th>
      <th scope="col"><center>Vehicle No.</center></th>
      <th scope="col"><center>LPO No.</center></th>
      <th scope="col"><center>Date Received</center></th>
      <th scope="col"><center>Description of Work</center></th>
      <th scope="col"><center>Service Provider</center></th>
      <th scope="col"><center>Fuel Consumed (Ltrs)</center></th>
      <th scope="col"><center>Amount (TZS)</center></th>
      <th scope="col"><center>Total (TZS)</center></th>
    </tr>
  </thead>
  <tbody>
  	@foreach($operational as $operational)
  	<tr>
  	 <th scope="row" class="counterCell text-center">.</th>
        <td>{{$operational->vehicle_reg_no}}</td>
        <td>{{$operational->lpo_no}}</td>
        <td><center>{{date("d/m/Y",strtotime($operational->date_received))}}</center></td>
        <td>{{$operational->description}}</td>
        <td>{{$operational->service_provider}}</td>
        <td>{{$operational->fuel_consumed}}</td>
        <td>{{number_format($operational->amount)}}</td>
        <td>{{number_format($operational->total)}}</td>	
  	</tr>
  	@endforeach
  </tbody>
</table>

</body>
</html>