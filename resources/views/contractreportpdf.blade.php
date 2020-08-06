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
use App\space_contract;
use App\insurance_contract;
use App\carContract;
if($_GET['business_type']=='Space'){
  if(($_GET['client_filter']=='true') && ($_GET['client_type']=='Company')){
    $contracts=DB::table('space_contracts')
        ->join('clients', 'clients.full_name', '=', 'space_contracts.full_name')
        ->where('type','Company')
        ->where('contract_status',1)->get();
  }
  else if(($_GET['client_filter']=='true') && ($_GET['client_type']=='Individual')){
    $contracts=DB::table('space_contracts')
        ->join('clients', 'clients.full_name', '=', 'space_contracts.full_name')
        ->where('type','Individual')
        ->where('contract_status',1)->get();
  }
  else{
   $contracts=space_contract::where('contract_status',1)->get();
  }

}
elseif($_GET['business_type']=='Insurance'){
	$contracts=insurance_contract::get();
}
elseif($_GET['business_type']=='Car Rental'){
	$contracts=carContract::where('form_completion','1')->orderBy('car_contracts.fullName','asc')->get();
}
?>
@if($_GET['business_type']=='Space')
<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
  @if(($_GET['client_filter']=='true') && ($_GET['client_type']=='Company'))
      <br><br><strong>List of Space Contracts Whose Client Type is Company</strong>
  @elseif(($_GET['client_filter']=='true') && ($_GET['client_type']=='Individual'))
  <br><br><strong>List of Space Contracts Whose Client Type is Individual</strong>
  @else
  <br><br><strong>List of Space Contracts</strong>
  @endif  
</center>
    <br><br>
<table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col"><center>S/N</center></th>
          <th scope="col"><center>Client Name</center></th>
          <th scope="col"><center>Space Id</center></th>
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
          	<td class="counterCell text-center">.</td>
          	<td>{{$var->full_name}}</td>
          	<td><center>{{$var->space_id_contract}}</center></td>
          	<td>{{$var->currency}} {{$var->amount}}</td>
          	<td><center>{{$var->payment_cycle}}</center></td>
          	<td><center>{{$var->start_date}}</center></td>
          	<td><center>{{$var->end_date}}</center></td>
          	<td><center>{{$var->escalation_rate}}</center></td>
          </tr>
          @endforeach
      </tbody>
  </table>
  @elseif($_GET['business_type']=='Insurance')
  <center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    <br><br><strong>List of Insurance Contracts</strong>
</center>
    <br><br>
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

            <td class="counterCell text-center"></td>
            <td>{{$var->vehicle_registration_no}}</td>
            {{-- <td><center>{{$var->vehicle_use}}</center></td> --}}
            <td>{{$var->principal}}</td>
            <td>{{$var->insurance_type}}</td>
            <td><center>{{$var->commission_date}}</center></td>
            <td><center>{{$var->end_date}}</center></td>
              <td><center>{{$var->sum_insured}}</center></td>
              <td><center>{{$var->premium}}</center></td>
            <td><center>{{$var->actual_ex_vat}}</center></td>
            <td><center>{{$var->currency}}</center></td>
              {{-- <td>{{$var->commission}}</td> --}}
              <td><center>{{$var->receipt_no}}</center></td>
          </tr>
          @endforeach
      </tbody>
  </table>
  @elseif($_GET['business_type']=='Car Rental')
<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    <br><br><strong>List of Car Rental Contracts</strong>
</center>
    <br><br>
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
    	<td><center>{{$var->start_date}}</center></td>
    	<td><center>{{$var->end_date}}</center></td>
    	<td>TZS {{$var->grand_total}}</td>
    </tr>
    @endforeach
</tbody>
</table>
@endif

</body>
</html>