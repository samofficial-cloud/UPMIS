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

    $vehicle_model_reg=explode('-', $_GET['vehicle']);

    $vehicle_reg_no=$vehicle_model_reg[1];
    $vehicle_model=$vehicle_model_reg[0];


        $cars= DB::table('car_rentals')
        ->whereNotIn('vehicle_reg_no',DB::table('car_contracts')->select('vehicle_reg_no')->where('vehicle_reg_no',$vehicle_reg_no)->whereDate('end_date', '>=',$_GET['start_date'])->distinct()->pluck('vehicle_reg_no')->toArray())
            ->where('vehicle_reg_no',$vehicle_reg_no)
            ->count();



    	?>

	<div class="container pt-4">
<h5 style="text-align: center;">Availability for Hire for {{$_GET['vehicle']}} from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</h5>
<br>

        @if($cars!=0)
        <h2 style="text-align: center;">Available <i style="font-size: 35px; color:green" class="far fa-check-circle"></i></h2>
        @else
        <h2 style="text-align: center;">Not available <i style="font-size: 35px; color:red;" class="far fa-times-circle"></i></h2>
        @endif

{{--<table class="hover table table-striped table-bordered" id="myTables4">--}}
{{--  <thead class="thead-dark">--}}
{{--    <tr>--}}
{{--      <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>--}}
{{--      <th scope="col" style="color:#fff;"><center>Vehicle Registration No.</center></th>--}}
{{--      <th scope="col" style="color:#fff;"><center>Vehicle Model</center></th>--}}
{{--      <th scope="col" style="color:#fff;"><center>Vehicle Status</center></th>--}}
{{--      <th scope="col" style="color:#fff;"><center>Hire Rate/KM (TZS)</center></th>--}}
{{--    </tr>--}}
{{--  </thead>--}}
{{--  <tbody>--}}
{{--  	@foreach($cars as $cars)--}}
{{--      <tr>--}}
{{--      <th class="counterCell text-center">.</th>--}}
{{--      <td><center>{{ $cars->vehicle_reg_no}}</center></td>--}}
{{--      <td>{{$cars->vehicle_model}}</td>--}}
{{--      <td><center>{{ $cars->vehicle_status}}</center></td>--}}
{{--      <td style="text-align: right;">{{ number_format($cars->hire_rate)}}</td>--}}
{{--      </tr>--}}
{{--      @endforeach--}}
{{--  </tbody>--}}
{{--</table>--}}
</div>
</body>
</html>
