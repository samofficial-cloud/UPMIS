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

  #header,
#footer {
  position: fixed;
  left: 0;
  right: 0;
  color: #aaa;
  font-size: 0.9em;
}
#header {
  top: 0;
  border-bottom: 0.1pt solid #aaa;
}
#footer {
  text-align: center;
  bottom: 0;
  color: black;
  font-size: 15px;
  /*border-top: 0.1pt solid #aaa;*/
}
.page-number:before {
  content: counter(page);
}

@page {
            margin: 77px 75px  !important;
            padding: 0px 0px 0px 0px !important;
        }
</style>
<body>
<?php
$i=1;
use App\carRental;
use App\carContract;     

        
        $total=0;
?>
<div id="footer">
  <div class="page-number"></div>
</div>
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
      <th scope="col" style="width: 5%;"><center>S/N</center></th>
      <th scope="col"><center>Vehicle Registration No.</center></th>
      <th scope="col" style="width: 40%;"><center>Vehicle Model</center></th>
      <th scope="col"><center>Vehicle Status</center></th>
      <th scope="col" style="width: 15%;"><center>Hire Rate (TZS)</center></th>
    </tr>
  </thead>
  <tbody>
      <tr>
      <td class="counterCell" style="text-align: center;">.</td>
      <td><center>{{ $cars->vehicle_reg_no}}</center></td>
      <td>{{$cars->vehicle_model}}</td>
      <td><center>{{ $cars->vehicle_status}}</center></td>
      <td style="text-align: right;">{{ number_format($cars->hire_rate)}}</td>
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
      <th scope="col" style="width: 5%;"><center>S/N</center></th>
      <th scope="col" style="width: 30%;"><center>Client Name</center></th>
      <th scope="col"><center>Start Date</center></th>
      <th scope="col"><center>End date</center></th>
      <th scope="col"><center>Destination</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($clients as $client)
      <tr>
      <td style="text-align: center;">{{$j}}.</td>
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
      <th scope="col"><center>Vehicle Reg No.</center></th>
      <th scope="col"><center>Vehicle Model</center></th>
      <th scope="col"><center>Vehicle Status</center></th>
      <th scope="col"><center>Hire Rate/Km (TZS)</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($cars as $cars)
      <tr>
      <td class="counterCell" style="text-align: center;">.</td>
      <td><center>{{ $cars->vehicle_reg_no}}</center></td>
      <td><center>{{$cars->vehicle_model}}</center></td>
      <td><center>{{ $cars->vehicle_status}}</center></td>
      <td style="text-align: right;">{{ number_format($cars->hire_rate)}}</td>
      </tr>
      @endforeach
  </tbody>
</table>
@endif
@else
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="width: 7%;"><center>S/N</center></th>
      <th scope="col" style="width: 18%;"><center>Vehicle Reg No.</center></th>
      <th scope="col"><center>Vehicle Model</center></th>
      <th scope="col" style="width: 18%;"><center>Vehicle Status</center></th>
      <th scope="col" style="width: 15%;"><center>Hire Rate/Km (TZS)</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($cars as $cars)
      <tr>
      <td class="counterCell" style="text-align: center;">.</td>
      <td>{{ $cars->vehicle_reg_no}}</td>
      <td>{{$cars->vehicle_model}}</td>
      <td><center>{{ $cars->vehicle_status}}</center></td>
      <td style="text-align: right;">{{ number_format($cars->hire_rate)}}</td>
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
      <th scope="col"style="width: 5%;"><center>S/N</center></th>
      <th scope="col"><center>Client Name</center></th>
      <th scope="col" style="width: 16%;"><center>Vehicle Reg No.</center></th>
      <th scope="col" style="width: 14%;"><center>Start Date</center></th>
      <th scope="col" style="width: 14%;"><center>End Date</center></th>
      <th scope="col" style="width: 18%;"><center>Destination</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($clients as $client)
    <tr>
    <td scope="row" class="counterCell" style="text-align: center;">.</td>
    <td>{{$client->designation}} {{$client->fullName}}</td>
    <td><center>{{$client->vehicle_reg_no}}</center></td>
    <td><center>{{date("d/m/Y",strtotime($client->start_date))}}</center></td>
    <td><center>{{date("d/m/Y",strtotime($client->end_date))}}</center></td>
    <td>{{$client->destination}}</td>
    {{-- <td><center>{{$client->rate}}</center></td> --}}
</tr>
@endforeach
</tbody>
</table>
@else
<h3>Sorry No clients found for the specified parameters</h3>
@endif
@elseif($_GET['report_type']=='revenue')
<center>
  <b>UNIVERSITY OF DAR ES SALAAM<br><br>
  <img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    <br><br>CPTU Revenue Report For the Duration of <strong>{{date("d/m/Y",strtotime($_GET['start_date']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
</center>
<br>
@if(count($revenues)>0)
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="width: 5%"><center>S/N</center></th>
      <th scope="col"><center>Client Name</center></th>
      <th scope="col" style="width: 18%"><center>Vehicle Reg No.</center></th>
      <th scope="col" style="width: 16%"><center>Invoicing Start Date</center></th>
      <th scope="col" style="width: 16%"><center>Invoicing End Date</center></th>
      <th scope="col" style="width: 16%"><center>Amount Paid</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($revenues as $client)
    <tr>
    <td scope="row" class="counterCell" style="text-align: center;">.</td>
    <td>{{$client->fullName}}</td>
    <td><center>{{$client->vehicle_reg_no}}</center></td>
    <td><center>{{date("d/m/Y",strtotime($client->invoicing_period_start_date))}}</center></td>
    <td><center>{{date("d/m/Y",strtotime($client->invoicing_period_end_date))}}</center></td>
    <td><center>{{$client->currency_invoice}} {{number_format($client->amount_to_be_paid)}}</center></td>
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
  <td style="width: 16%"><center>{{$client->currency_invoice}} {{number_format($total)}}</center></td>
</tr>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif
@endif

        
</body>
</html>