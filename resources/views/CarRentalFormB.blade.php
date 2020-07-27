@extends('layouts.app')
@section('content')
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">

            <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>

            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <div class="dropdown">
  <li class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <i class="fas fa-file-contract"></i> Contracts
  </li>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="/contracts/car_rental">Car Rental</a>
    <a class="dropdown-item" href="/insurance_contracts_management">Insurance</a>
    <a class="dropdown-item" href="/space_contracts_management">Space</a>
  </div>
</div>
            <li><a href="#"><i class="fas fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
        </ul> 
    </div>
<div class="main_content">
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-12 col-sm-9 col-md-7 col-lg-9  p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
            	<center><h4><strong>UNIVERSITY OF DAR ES SALAAM - MAIN ADMINISTRATION</strong></h4>
                <h4><strong>CENTRAL POOL TRANSPORTATION UNIT<br>VEHICLE REQUISTION FORM</strong></h4></center>
                <br>

            <div style="width: 100%;margin-left: 10px;">
            	<h4><b>A. APPLICATION DETAILS</b></h4>
            <p><b>1. Name of User:  </b>&nbsp;&nbsp;&nbsp;&nbsp;<b>2.Designation:</b></p>
            <p><b>3. Faculty/Department/Unit: </b>&nbsp;&nbsp;<b>[Cost Centre No.<u>&nbsp;&nbsp;</u>]</b></p>
            <p><b>4. Vehicle Required: Date From:&nbsp;&nbsp; to &nbsp;&nbsp;Time: From <u>&nbsp;&nbsp;</u> to <u>&nbsp;&nbsp;</u> </b></p>
            <p><b>5. Estimate overtime: </b></p>
            <p><b>6. Destination (route): </b></p>
            <p><b>7. Purpose/reason of the trip: </b></p>
            <p><b>8. Nature of the trip:</b></p>
            <p><b>9. Estimated Distance in Kms:&nbsp;&nbsp; and Estimated Cost in Tshs.&nbsp;&nbsp;</b></p>
            </div>
                
            
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection