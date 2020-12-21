<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php 
use App\carContract;
$bookings2=carContract::where('vehicle_reg_no',$_GET['reg_no'])
						->wherebetween('start_date',[ $_GET['start'] ,$_GET['end']])
						->whereDate('end_date','<',date('Y-m-d'))
						 ->where('form_completion','1')
						->get();
$i=1;
?>
<table class="hover table table-striped table-bordered" id="myTable2">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
      {{-- <th scope="col" style="color:#fff;"><center>Vehicle No.</center></th> --}}
      <th scope="col" style="color:#fff;"><center>Client Name</center></th>
      <th scope="col" style="color:#fff;"><center>Department/Faculty</center></th>
       <th scope="col" style="color:#fff;"><center>Cost Center</center></th>
      <th scope="col" style="color:#fff;"><center>Trip Start Date</center></th>
       <th scope="col" style="color:#fff;"><center>Trip End Date</center></th>
      <th scope="col" style="color:#fff;"><center>Destination</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($bookings2 as $bookings)
      <tr>
      	<td style="text-align: center;">{{$i}}.</td>
      	{{-- <td><center>{{$bookings->vehicle_reg_no}}</center></td> --}}
      	<td>{{$bookings->fullName}}</td>
        <td>{{$bookings->faculty}}</td>
      	<td><center>{{$bookings->cost_centre}}</center></td>
      	<td><center>{{date("d/m/Y",strtotime($bookings->start_date))}}</center></td>
      	<td><center>{{date("d/m/Y",strtotime($bookings->end_date))}}</center></td>
      	<td>{{$bookings->destination}}</td>
      </tr>
      <?php $i= $i+1; ?>
      @endforeach
  </tbody>
</table>
</body>
</html>