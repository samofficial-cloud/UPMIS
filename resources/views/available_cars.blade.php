<!DOCTYPE html>
<html>
<head>
	<title>Available Cars</title>
</head>
<style type="text/css">
  .counterCell:before {
  content: counter(tableCount);
  counter-increment: tableCount;
  }
</style>
<body>

	<?php
  use Illuminate\Support\Facades\DB;
        $cars= DB::table('car_rentals')
        ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')->where('vehicle_reg_no','!=',null)->whereDate('end_date', '>=',$_GET['start_date'])->distinct()->pluck('vehicle_reg_no')->toArray())
        ->where('vehicle_status','!=','Grounded')
        ->get();
    	?>
    
	<div class="container">
<h4>Available Car(s) for Hire from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</h4>
<br>
<table class="hover table table-striped table-bordered" id="myTable4">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#3490dc; width: 5%;"><center>S/N</center></th>
      <th scope="col" style="color:#3490dc;"><center>Vehicle Registration No.</center></th>
      <th scope="col" style="color:#3490dc;"><center>Vehicle Model</center></th>
      <th scope="col" style="color:#3490dc;"><center>Vehicle Status</center></th>
      <th scope="col" style="color:#3490dc;"><center>Hire Rate</center></th>
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
</div>
</body>
</html>