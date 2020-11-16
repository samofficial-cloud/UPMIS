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
  padding:5px;
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

        sub {
   font-size: .50em;
    line-height: 0.5em;
    vertical-align: baseline;
    position: relative;
    top: 0px;
    float: right;
    color: blue;
    margin-left: 5px;
    margin-bottom: 10px;
}
</style>
<body>
  <div id="footer">
  <div class="page-number"></div>
</div>
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
    <p style="font-size: 13px;">Note: <span style="color: blue">(A.S)</span> - Academic Season <span style="color: blue">(V.S)</span> - Vacation Season</p>
<table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col"><center>S/N</center></th>
          <th scope="col"><center>Client Name</center></th>
          <th scope="col"><center>Space Id</center></th>
           <th scope="col"><center>Currency</center></th>
          <th scope="col" colspan="2"><center>Amount</center></th>
          <th scope="col" ><center>Payment Cycle</center></th>
          <th scope="col" ><center>Start Date</center></th>
          <th scope="col" ><center>End Date</center></th>
          <th scope="col" ><center>Escalation Rate</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($contracts as $var)
          <tr>
          	<td scope="row" class="counterCell" style="text-align: center;">.</td>
          	<td>{{$var->full_name}}</td>
          	<td>{{$var->space_id_contract}}</td>
            <td><center>{{$var->currency}}</center></td>
          	{{-- <td style="text-align: right;">{{number_format($var->amount)}}</td> --}}
             @if($var->academic_dependence=="Yes")
              @if(empty($var->academic_season)&&empty($var->vacation_season))
              <td>{{$var->academic_season}}<sub>(A.S)</sub></td>
              <td>{{$var->vacation_season}}<sub>(V.S)</sub> </td>
              @else
              <td>{{number_format($var->academic_season)}}<sub>(A.S)</sub></td>
              <td>{{number_format($var->vacation_season)}}<sub>(V.S)</sub> </td>
              @endif
              @else
              @if(empty($var->amount))
              <td colspan="2" style="text-align: right;">{{$var->amount}}</td>
              @else
               <td colspan="2" style="text-align: right;">{{number_format($var->amount)}}</td>
              @endif
              @endif
          	<td>{{$var->payment_cycle}}</td>
          	<td><center>{{date("d/m/Y",strtotime($var->start_date))}}</center></td>
          	<td><center>{{date("d/m/Y",strtotime($var->end_date))}}</center></td>
          	<td>
              @if($var->escalation_rate==null)
              <center>N/A</center>
              @else
              <center>{{$var->escalation_rate}}</center>
              @endif
            </td>
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
          <th scope="col"><center>Client Name</center></th>
          <th scope="col"><center>Principal</center></th>
           <th scope="col" ><center>Insurance Package</center></th>
          <th scope="col" ><center>Insurance Type</center></th>
           <th scope="col"><center>Vehicle Reg No</center></th>
          <th scope="col" ><center>Commission Date</center></th>
          <th scope="col" style="width: 10%;"><center>End Date</center></th>
          <th scope="col" ><center>Premium</center></th>
          {{-- <th scope="col" style="width: 8%;"><center>Actual(Excluding VAT) </center></th> --}}
            <th scope="col" ><center>Cover Note</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($contracts as $var)
          <tr>

            <td scope="row" class="counterCell" style="text-align: center;"></td>
            <td>{{$var->full_name}}</td>
            <td>{{$var->principal}}</td>
            <td>{{$var->insurance_class}}</td>
            <td>{{ucfirst(strtolower($var->insurance_type))}}</td>
             <td>{{$var->vehicle_registration_no}}</td>
            <td><center>{{date("d/m/Y",strtotime($var->commission_date))}}</center></td>
            <td><center>{{date("d/m/Y",strtotime($var->end_date))}}</center></td>
              <td style="text-align: right;">{{$var->currency}} {{number_format($var->premium)}}</td>
            {{-- <td style="text-align: right;">{{$var->currency}} {{number_format($var->actual_ex_vat)}}</td> --}}
              <td><center>{{$var->cover_note}}</center></td>
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
      <th scope="col"><center>Amount (TZS)</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($contracts as $var)
    <tr>
    	<td class="counterCell" style="text-align: center;">.</td>
    	<td>{{$var->fullName}}</td>
      <td><center>{{$var->cost_centre}}</center></td>
    	<td>{{$var->vehicle_reg_no}}</td>
      <td>{{$var->destination}}</td>
    	<td><center>{{date("d/m/Y",strtotime($var->start_date))}}</center></td>
    	<td><center>{{date("d/m/Y",strtotime($var->end_date))}}</center></td>
    	<td style="text-align: right;">{{number_format($var->grand_total)}}</td>
    </tr>
    @endforeach
</tbody>
</table>
@endif

</body>
</html>