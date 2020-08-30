<!DOCTYPE html>
<html>
<head>
	<title>CONTRACT REPORT</title>
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

?>

<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
  @if(($_GET['c_filter']!='true') && ($_GET['con_filter']!='true') && ($_GET['y_filter']!='true'))
  <br><br>List of <b>{{$_GET['business_type']}}</b> Contracts
  @elseif(($_GET['c_filter']!='true') && ($_GET['con_filter']!='true') && ($_GET['y_filter']=='true'))
  <br><br>List of <b>{{$_GET['business_type']}}</b> Contracts whose Lease <b>{{ucfirst(strtolower($_GET['lease']))}}</b> Year is <b>{{$_GET['year']}}</b>
  @elseif(($_GET['c_filter']!='true') && ($_GET['con_filter']=='true') && ($_GET['y_filter']!='true'))
  <br><br>List of <b>{{$_GET['business_type']}} {{$_GET['con_status']}}</b> Contracts
  @elseif(($_GET['c_filter']!='true') && ($_GET['con_filter']=='true') && ($_GET['y_filter']=='true'))
   <br><br>List of <b>{{$_GET['business_type']}} {{$_GET['con_status']}}</b> Contracts whose Lease <b>{{ucfirst(strtolower($_GET['lease']))}}</b> Year is <b>{{$_GET['year']}}</b>
   @elseif(($_GET['c_filter']=='true') && ($_GET['con_filter']!='true') && ($_GET['y_filter']!='true'))
   <br><br>List of <b>{{$_GET['c_name']}} {{$_GET['business_type']}}</b> Contracts
   @elseif(($_GET['c_filter']=='true') && ($_GET['con_filter']!='true') && ($_GET['y_filter']=='true'))
    <br><br>List of <b>{{$_GET['c_name']}} {{$_GET['business_type']}}</b> Contracts whose Lease <b>{{ucfirst(strtolower($_GET['lease']))}}</b> Year is <b>{{$_GET['year']}}</b>
    @elseif(($_GET['c_filter']=='true') && ($_GET['con_filter']=='true') && ($_GET['y_filter']!='true'))
     <br><br>List of <b>{{$_GET['c_name']}} {{$_GET['business_type']}} {{$_GET['con_status']}}</b> Contracts
      @elseif(($_GET['c_filter']=='true') && ($_GET['con_filter']=='true') && ($_GET['y_filter']=='true'))
       <br><br>List of <b>{{$_GET['c_name']}} {{$_GET['business_type']}} {{$_GET['con_status']}}</b> Contracts whose Lease <b>{{ucfirst(strtolower($_GET['lease']))}}</b> Year is <b>{{$_GET['year']}}</b>
  @endif
</center>
@if($_GET['business_type']=='Space')
    <br>
<table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col"><center>S/N</center></th>
          <th scope="col"><center>Client Name</center></th>
          <th scope="col"><center>Space Id</center></th>
           <th scope="col"><center>Currency</center></th>
          <th scope="col"><center>Amount</center></th>
          <th scope="col" ><center>Payment Cycle</center></th>
          <th scope="col" ><center>Start Date</center></th>
          <th scope="col" ><center>End Date</center></th>
          <th scope="col" ><center>Escalation Rate</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($contracts as $var)
          <tr>
          	<th scope="row" class="counterCell text-center">.</th>
          	<td>{{$var->full_name}}</td>
          	<td><center>{{$var->space_id_contract}}</center></td>
            <td><center>{{$var->currency}}</center></td>
          	<td>{{number_format($var->amount)}}</td>
          	<td><center>{{$var->payment_cycle}}</center></td>
          	<td><center>{{date("d/m/Y",strtotime($var->start_date))}}</center></td>
          	<td><center>{{date("d/m/Y",strtotime($var->end_date))}}</center></td>
          	<td><center>{{$var->escalation_rate}}</center></td>
          </tr>
          @endforeach
      </tbody>
  </table>
  @elseif($_GET['business_type']=='Insurance')
    <br>
     <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col"><center>S/N</center></th>
          <th scope="col"><center>Vehicle Reg No</center></th>
          {{-- <th scope="col"><center>Vehicle Use</center></th> --}}
          <th scope="col"><center>Principal</center></th>
          <th scope="col" ><center>Insurance Type</center></th>
          <th scope="col" ><center>Commission Date</center></th>
          <th scope="col" style="width: 10%;"><center>End Date</center></th>
          <th scope="col" ><center>Sum Insured</center></th>
          <th scope="col" ><center>Premium</center></th>
            <th scope="col" style="width: 8%;"><center>Actual(Excluding VAT) </center></th>
            <th scope="col" style="width: 7%;"><center>Currency </center></th>
            {{-- <th scope="col" ><center>Commission </center></th> --}}
            <th scope="col" ><center>Receipt No </center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($contracts as $var)
          <tr>

            <th scope="row" class="counterCell text-center">.</th>
            <td>{{$var->vehicle_registration_no}}</td>
            {{-- <td><center>{{$var->vehicle_use}}</center></td> --}}
            <td>{{$var->principal}}</td>
            <td>{{ucfirst(strtolower($var->insurance_type))}}</td>
            <td><center>{{date("d/m/Y",strtotime($var->commission_date))}}</center></td>
            <td><center>{{date("d/m/Y",strtotime($var->end_date))}}</center></td>
              <td><center>{{number_format($var->sum_insured)}}</center></td>
              <td><center>{{number_format($var->premium)}}</center></td>
            <td><center>{{number_format($var->actual_ex_vat)}}</center></td>
            <td><center>{{$var->currency}}</center></td>
              {{-- <td>{{$var->commission}}</td> --}}
              <td><center>{{$var->receipt_no}}</center></td>
          </tr>
          @endforeach
      </tbody>
  </table>
  @elseif($_GET['business_type']=='Car Rental')
    <br>
     <table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><center>S/N</center></th>
      <th scope="col"><center>Client Name</center></th>
      <th scope="col"><center>Cost Centre</center></th>
      <th scope="col"><center>Vehicle Registration No.</center></th>
      <th scope="col"><center>Destination</center></th>
      <th scope="col"><center>Start Date</center></th>
      <th scope="col"><center>End Date</center></th>
      <th scope="col"><center>Amount</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($contracts as $var)
    <tr>
    	<td class="counterCell text-center">.</td>
    	<td>{{$var->designation}} {{$var->fullName}}</td>
      <td>{{$var->cost_centre}}</td>
    	<td>{{$var->vehicle_reg_no}}</td>
      <td>{{$var->destination}}</td>
    	<td><center>{{date("d/m/Y",strtotime($var->start_date))}}</center></td>
    	<td><center>{{date("d/m/Y",strtotime($var->end_date))}}</center></td>
    	<td>TZS {{number_format($var->grand_total)}}</td>
    </tr>
    @endforeach
</tbody>
</table>
@endif

</body>
</html>