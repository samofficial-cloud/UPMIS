<!DOCTYPE html>
<html>
<head>
	<title>Space Report</title>
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
	use App\space_contract;
	if($_GET['filter_date']=='true'){
      $space=space_contract::join('spaces', 'spaces.space_id', '=', 'space_contracts.space_id_contract')->where('space_contracts.space_id_contract',$_GET['space_id'])->whereDate('space_contracts.start_date','>=', $_GET['start_date'])->whereDate('space_contracts.end_date','>=',$_GET['end_date'])->get();
	}
	else{
		 $space=space_contract::join('spaces', 'spaces.space_id', '=', 'space_contracts.space_id_contract')->where('space_contracts.space_id_contract',$_GET['space_id'])->get();
	}
	?>
	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    @if($_GET['filter_date']=='true')
    <br><br><strong>{{$_GET['space_id']}} Renting History Report for the Duration of {{$_GET['start_date']}} to {{$_GET['end_date']}}</strong>
     @else
     <br><br><strong>{{$_GET['space_id']}} Renting History Report</strong>
    @endif
</center>
<br><br>

@if(count($space)>0)
<table>
	<thead class="thead-dark">
        <tr>
          <th scope="col"><center>S/N</center></th>
          <th scope="col"><center>Type</center></th>
          <th scope="col" ><center>Location</center></th>
          <th scope="col" ><center>Client</center></th>
          <th scope="col"><center>Contract Duration</center></th>
          <th scope="col" ><center>Amount</center></th>
        </tr>
        </thead>
        <tbody>
        	@foreach($space as $space)
        	<tr>
        		<td class="counterCell">.</td>
        		<td><center>{{$space->space_type}}</center></td>
              <td><center>{{$space->location}}</center></td>
              <td>{{$space->full_name}}</td>
              <td>{{$space->start_date}} to {{$space->end_date}}</td>
              <td>{{$space->currency}} {{$space->amount}}</td>
        	</tr>

        	@endforeach

        </tbody>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif

</body>
</html>