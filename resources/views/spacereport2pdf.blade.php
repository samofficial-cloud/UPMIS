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
  use App\space;

  $details=space::where('space_id',$_GET['space_id'])->get();
	if($_GET['filter_date']=='true'){
      $space=space_contract::join('spaces', 'spaces.space_id', '=', 'space_contracts.space_id_contract')->where('space_contracts.space_id_contract',$_GET['space_id'])->whereDate('space_contracts.start_date','>=', $_GET['start_date'])->whereDate('space_contracts.end_date','>=',$_GET['end_date'])->get();
      $invoices=space_contract::join('invoices', 'invoices.contract_id', '=', 'space_contracts.contract_id')->where('space_contracts.space_id_contract',$_GET['space_id'])->whereDate('space_contracts.start_date','>=', $_GET['start_date'])->whereDate('space_contracts.end_date','>=',$_GET['end_date'])->where('invoices.payment_status','Not Paid')->get();
	}
	else{
		 $space=space_contract::join('spaces', 'spaces.space_id', '=', 'space_contracts.space_id_contract')->where('space_contracts.space_id_contract',$_GET['space_id'])->get();

     $invoices=space_contract::join('invoices', 'invoices.contract_id', '=', 'space_contracts.contract_id')->where('space_contracts.space_id_contract',$_GET['space_id'])->where('invoices.payment_status','Not Paid')->get();
	}
  $i=1;
	?>
	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    @if($_GET['filter_date']=='true')
    <br><br><strong>{{$_GET['space_id']}} Renting History Report for the Duration from {{$_GET['start_date']}} to {{$_GET['end_date']}}</strong>
     @else
     <br><br><strong>{{$_GET['space_id']}} Renting History Report</strong>
    @endif
</center>
<br>
<h3>1. General Information</h3>
<table style="width: 50%">
  @foreach($details as $details)
  <tr>
    <td>Space Type</td>
    <td>{{$details->space_type}}</td>
  </tr>
  <tr>
    <td>Location</td>
    <td>{{$details->location}}</td>
  </tr>
  <tr>
    <td>Size in m2</td>
    <td>{{$details->size}}</td>
  </tr>
  <tr>
    <td>Rent Price Guide</td>
    <td>{{$details->rent_price_guide_currency}} {{number_format($details->rent_price_guide_from)}} - {{number_format($details->rent_price_guide_to)}}</td>
  </tr>
  @endforeach
</table>
<br>
  <hr>
  <h3>2. Occupation History</h3>
@if(count($space)>0)
<table>
	<thead class="thead-dark">
        <tr>
          <th scope="col" style="width: 5%;"><center>S/N</center></th>
          <th scope="col" style="width: 25%;"><center>Client</center></th>
          <th scope="col"><center>Lease Start</center></th>
          <th scope="col" ><center>Lease End</center></th>
          <th scope="col" ><center>Rent Price</center></th>
          <th scope="col" ><center>Escalation Rate</center></th>
        </tr>
        </thead>
        <tbody>
        	@foreach($space as $space)
        	<tr>
        		<th scope="row" class="counterCell">.</th>
              <td>{{$space->full_name}}</td>
              <td><center>{{date("d/m/Y",strtotime($space->start_date))}}</center></td>
              <td><center>{{date("d/m/Y",strtotime($space->end_date))}}</center></td>
              <td>{{$space->currency}} {{number_format($space->amount)}}</td>
              <td>{{$space->escalation_rate}}</td>
        	</tr>

        	@endforeach

        </tbody>
</table>
@else
<h3>This space has not been lease yet</h3>
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
                                    <th scope="row">{{ $i }}.</th>
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
<h3>This space has no  previous debts</h3>
@endif
</body>
</html>