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
  padding:4px;
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
    bottom: 0px;
    float: right;
    color: blue;
}
</style>
<body>
  <div id="footer">
  <div class="page-number"></div>
</div>
	<?php
	use App\Real Estate_contract;
  use App\space;


  $i=1;
	?>
	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT
    </b>
    @if($_GET['filter_date']=='true')
    <br><br><strong>{{$_GET['space_id']}} Renting History Report for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
     @else
     <br><br><strong>{{$_GET['space_id']}} Renting History Report</strong>
    @endif
</center>
<br>
<h3>1. General Information</h3>
<table style="width: 50%">
  @foreach($details as $details)
  <tr>
    <td>Real Estate Type</td>
    <td>{{$details->major_industry}}</td>
  </tr>
  <tr>
    <td>Location</td>
    <td>{{$details->location}}</td>
  </tr>
  <tr>
    <td>Size in m2</td>
    <td>{{$details->size}}</td>
  </tr>
  {{-- <tr>
    <td>Rent Price Guide</td>
    @if(empty($details->rent_price_guide_from) &&empty($details->rent_price_guide_to))
    <td>{{$details->rent_price_guide_currency}} {{$details->rent_price_guide_from}} - {{$details->rent_price_guide_to}}</td>
    @else
    <td>{{$details->rent_price_guide_currency}} {{number_format($details->rent_price_guide_from)}} - {{number_format($details->rent_price_guide_to)}}</td>
    @endif
  </tr> --}}
  @endforeach
</table>
<br>
  <hr>
  <h3>2. Occupation History</h3>
@if(count($space)>0)
<p style="font-size: 13px;">Note: <span style="color: blue">(A.S)</span> - Academic Season <span style="color: blue">(V.S)</span> - Vacation Season</p>
<table>
	<thead class="thead-dark">
        <tr>
          <th scope="col" style="width: 5%;"><center>S/N</center></th>
          <th scope="col" style="width: 25%;"><center>Client</center></th>
          <th scope="col"><center>Lease Start</center></th>
          <th scope="col" ><center>Lease End</center></th>
          <th scope="col" ><center>Currency</center></th>
          <th scope="col" colspan="2"><center>Rent Price</center></th>
          <th scope="col" ><center>Escalation Rate</center></th>
        </tr>
        </thead>
        <tbody>
        	@foreach($space as $space)
        	<tr>

        		<td scope="row" class="counterCell" style="text-align: center;">.</td>
              <td>{{$space->full_name}}</td>
              <td><center>{{date("d/m/Y",strtotime($space->start_date))}}</center></td>
              <td><center>{{date("d/m/Y",strtotime($space->end_date))}}</center></td>
              <td><center>{{$space->currency}}</center></td>
              @if($space->academic_dependence=="Yes")
              @if(empty($space->academic_season)&&empty($space->vacation_season))
              <td>{{$space->academic_season}}<sub>(A.S)</sub></td>
              <td>{{$space->vacation_season}}<sub>(V.S)</sub> </td>
              @else
              <td>{{number_format($space->academic_season)}}<sub>(A.S)</sub></td>
              <td>{{number_format($space->vacation_season)}}<sub>(V.S)</sub> </td>
              @endif
              @else
              @if(empty($space->amount))
              <td colspan="2" style="text-align: right;">{{$space->amount}}</td>
              @else
               <td colspan="2" style="text-align: right;">{{number_format($space->amount)}}</td>
              @endif
              @endif
              <td><center>{{$space->escalation_rate}}</center></td>
        	</tr>

        	@endforeach

        </tbody>
</table>
@else
<h3>This Real Estate has/was not been lease yet for the specified duration</h3>
@endif
<br>
<hr>
<h3>3. Debts</h3>
@if(count($invoices)>0)
<table class="hover table table-striped  table-bordered" id="myTable3">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width:5%"><center>S/N</center></th>
                                <th scope="col" style="width: 25%"><center>Debtor Name</center></th>
                                <th scope="col"><center>Invoice Number</center></th>
                                <th scope="col" style="width: 25%"><center>Invoice Duration</center></th>
                                <th scope="col"><center>Contract Id</center></th>
                                <th scope="col" ><center>Amount</center></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $var)
                                <tr>
                                    <td scope="row" style="text-align: center;">{{ $i }}.</td>
                                    <td>{{$var->debtor_name}}</td>
                                    <td><center>{{$var->invoice_number}}</center></td>

                                    <td>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}} - {{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</td>
                                    <td><center>{{$var->contract_id}}</center></td>
                                    <td><center>{{$var->currency}} {{number_format($var->amount_to_be_paid)}}</center></td>
                                  </tr>
                                  <?php
                                  $i=$i+1;
                                  ?>
                                  @endforeach
                                </tbody>
                              </table>
                              @else
<h3>This Real Estate has no  previous debts</h3>
@endif
</body>
</html>
