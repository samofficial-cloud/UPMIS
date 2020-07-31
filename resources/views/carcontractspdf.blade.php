<!DOCTYPE html>
<html>
<head>
	<title>Vehicle Requistion Form</title>
</head>
<body>
	<?php
	Use App\carContract;
    $contract=carContract::find($_GET['id']);
	?>
	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b><br><hr>
    <strong>CENTRAL POOL TRANSPORT UNIT
    	<br>VEHICLE REQUISTION FORM FOR TRAVEL <u>{{strtoupper($contract['area_of_travel'])}}</u> DAR ES SALAAM/KIBAHA</strong>
</center>
<br>
<div>
<strong>A. APPLICATION DETAILS</strong>
<p style="font-size: 19px;">
	1. Name of User: <b>{{$contract->fullName}}</b><span style="padding-left: 40px;"> 2. Designation: <b>{{$contract->designation}}</b></span>
	<br>
	3. Faculty/Department/Unit: <b>{{$contract->faculty}}</b><span style="padding-left: 15px;">[Cost Centre No.<b>{{$contract->cost_centre}}</b>]</span>
	<br>
	4. Vehicle Required: Date From: <b>{{$contract->start_date}}</b> to <b>{{$contract->end_date}}</b> Time: From <b>{{$contract->start_time}}</b> to <b>{{$contract->end_time}}</b>
	<br>
	5. Estimate Overtime: <b>{{$contract->overtime}} hrs</b>
	<br>
	6. Destination(route): <b>{{$contract->destination}}</b>
	<br>
	7. Purpose/reason of the trip: <b>{{$contract->purpose}}</b>
	<br>
	8. Nature of the trip: <b>{{$contract->trip_nature}}</b>
	<br>
	9. Estimated Distance in Kms: <b>{{$contract->estimated_distance}}</b><span style="padding-left: 30px;">Estimated Cost in Tshs: <b>{{$contract->estimated_cost}}</b></span>
</p>
<hr>
</div>
<div>
	<strong>B. AVAILABITY OF FUNDS</strong>
	<p style="font-size: 19px;">
		1. I confirm that under Travel/Transport Activity Code No.<b>{{$contract->transport_code}}</b> the funds available for further use is Tshs. <b>{{$contract->funds_available}}</b>. This Balance is <b>{{$contract->balance_status}}</b> for this application
		<br>
		2. Vote Holder (Trip Authorizing Officer) Tittle: <b>{{$contract->vote_title}}</b>.<br> I commit the fund to the tune of Tshs.<b>{{$contract->fund_committed}}</b> for this Application/Trip
		<br><br>
		Name: <b>{{$contract->acc_name}}</b> <span style="padding-left: 30px;">Date: <b>{{$contract->acc_date}}</b></span>
	</p>
	<hr>
</div>
<div>
	<strong>C. CONFIRMATION OF FUNDS FOR FUTURE PAYMENT</strong>
	<p style="font-size: 19px;">
		We confirm that the cost centre No. <b>{{$contract->cost_centre}}</b> has a balance of Tshs. <b>{{$contract->funds_available}}</b> for transport code No.<b> {{$contract->transport_code}}</b>. This amount is <b>{{$contract->balance_status}}</b> to meet the requirement as stated in <b>B</b> above.<br>
        This APPLICATION is therefore <b>{{$contract->head_approval_status}}</b><br><br>
        Name: <b>{{$contract->head_name}}</b> <span style="padding-left: 30px;">Date: <b>{{$contract->head_date}}</b></span>
	</p>
	<hr>
</div>
<div>
	@if($contract->area_of_travel=='Within')
	<strong>D. HEAD OF CPTU</strong>
	<p style="font-size: 19px;">
		{{-- <b>{{$contract->head_cptu_approval_status}}</b>  - --}} Vehicle Reg No: <b>{{$contract->vehicle_reg_no}}</b><br><br>
		Name: <b>{{$contract->head_cptu_name}}</b> <span style="padding-left: 30px;">Date: <b>{{$contract->head_cptu_date}}</b></span>

	</p>
	@elseif($contract->area_of_travel=='Outside')
	<strong>D. DVC: (Administration)</strong>
	<p style="font-size: 19px;">
		{{-- <b>{{$contract->dvc_approval_status}}</b>  - --}} Vehicle Reg No: <b>{{$contract->vehicle_reg_no}}</b><br><br>
		Name: <b>{{$contract->dvc_name}}</b> <span style="padding-left: 30px;">Date: <b>{{$contract->dvc_date}}</b></span>

	</p>
	@endif
	<hr>
</div>
<div>
	<br>
	<br><br>
	<strong>E. MILEAGE COVERAGE AFTER THE TRIP</strong>
	<p style="font-size: 19px;">
		1. Beginning Speedmeter reading: <b>{{$contract->initial_speedmeter}} km</b><span style="padding-left: 10px"> Time: <b>{{$contract->initial_speedmeter_time}}</b> </span><br>
		2. Ending Speedmeter reading: <b>{{$contract->ending_speedmeter}} km</b><span style="padding-left: 10px"> Time: <b>{{$contract->ending_speedmeter_time}}</b> </span><br>
		3. Overtime Hours: <b>{{$contract->overtime_hrs}}</b><br>
		4. Name of user: <b>{{$contract->fullName}}</b> <span style="padding-left: 30px;">Date: <b>{{$contract->driver_date}}</b></span><br>
		<span style="padding-left: 20px;">Name of driver: <b>{{$contract->driver_name}}</b> <span style="padding-left: 30px;">Date: <b>{{$contract->driver_date}}</b></span></span>
	</p>
	<hr>
</div>
<div>
	<strong>F. FOR OFFICIAL CPTU USE</strong>
	<p style="font-size: 19px;">
		1. Charge per mile/km: <b>{{$contract->charge_km}} </b><span style="padding-left: 10px;"> Mileage covered km: <b>{{$contract->mileage_km}}</b> </span><span style="padding-left: 10px;">Mileages charges Tshs. <b>{{$contract->mileage_tshs}}</b></span><br>
		2. Penalty hours: <b>{{$contract->penalty_hrs}} hrs</b><span style="padding-left: 10px"> Amount Tshs: <b>{{$contract->penalty_amount}}</b> </span><br>
		3. Overtime charges Tshs: <b>{{$contract->overtime_charges}}</b><span style="padding-left: 10px;">Total charges Tshs: <b>{{$contract->total_charges}}</b></span><br>
		4. Head of CPTU: Signature  <span style= "padding-left: 90px;">Date: <b>{{$contract->driver_date}}</b></span><br>
		5. Vehicle Standing Charge: <b>{{$contract->standing_charges}}</b><br>
		6. GRAND TOTAL: <b>{{$contract->grand_total}}</b>
	</p>
</div>
</body>
</html>