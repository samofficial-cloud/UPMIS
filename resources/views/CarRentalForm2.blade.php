@extends('layouts.app')
@section('style')
<style type="text/css">
	* {
    margin: 0;
    padding: 0
}

html {
    height: 100%
}

#grad1 {
    background-color: : #9C27B0;
    /*background-image: linear-gradient(120deg, #FF4081, #81D4FA)*/
}

#msform {
    text-align: center;
    position: relative;
    margin-top: 20px
}

#msform fieldset .form-card {
    background: white;
    border: 0 none;
    border-radius: 0px;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    padding: 20px 40px 30px 40px;
    box-sizing: border-box;
    width: 94%;
    margin: 0 3% 20px 3%;
    position: relative
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative
}

#msform fieldset:not(:first-of-type) {
    display: none
}

#msform fieldset .form-card {
    text-align: left;
    color: #212529;
}

#msform input,
#msform textarea {
    padding: 0px 8px 4px 8px;
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    /*font-family: montserrat;*/
    color: #2C3E50;
    font-size: 16px;
    letter-spacing: 1px
}

#msform input:focus,
#msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: none;
    font-weight: bold;
    border-bottom: 2px solid skyblue;
    outline-width: 0
}

#msform .action-button {
    width: 100px;
    background: skyblue;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px
}

#msform .action-button:hover,
#msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
}

#msform .action-button-previous {
    width: 100px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px
}

#msform .action-button-previous:hover,
#msform .action-button-previous:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
}

select.list-dt {
    border: none;
    outline: 0;
    border-bottom: 1px solid #ccc;
    padding: 2px 5px 3px 5px;
    margin: 2px
}

select.list-dt:focus {
    border-bottom: 2px solid skyblue
}

.card {
    z-index: 0;
    border: none;
    border-radius: 0.5rem;
    position: relative
}

.fs-title {
    font-size: 25px;
    color: #2C3E50;
    margin-bottom: 10px;
    font-weight: bold;
    text-align: left
}

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey;
    margin-left: 20%;
}

#progressbar .active {
    color: #000000
}

#progressbar li {
    list-style-type: none;
    font-size: 12px;
    width: 25%;
    float: left;
    position: relative
}

#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f1b9"
}

#progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f007"
}

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f09d"
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f00c"
}

#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 18px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: skyblue
}

.radio-group {
    position: relative;
    margin-bottom: 25px
}

.radio {
    display: inline-block;
    width: 204;
    height: 104;
    border-radius: 0;
    background: lightblue;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    cursor: pointer;
    margin: 8px 2px
}

.radio:hover {
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3)
}

.radio.selected {
    box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1)
}

.fit-image {
    width: 100%;
    object-fit: cover
}
</style>
@endsection
@section('content')
<?php 
$today=date('Y-m-d');
?>
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
        <div class="col-12 col-sm-9 col-md-7 col-lg-9 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
            	<h4><strong>UNIVERSITY OF DAR ES SALAAM - MAIN ADMINISTRATION</strong></h4>
                <h4><strong>CENTRAL POOL TRANSPORTATION UNIT<br>VEHICLE REQUISTION FORM</strong></h4>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" method="post" action="{{ route('newCarcontractA') }}">
                            {{csrf_field()}}
                            <fieldset>
                                <div class="form-card">
                                   <h2 class="fs-title">A. APPLICATION DETAILS</h2>
                                   <p>Fill all form field with (*)</p>
                                   <div class="form-group">
					<div class="form-wrapper" id="areadiv">
          <label for="area">Area of Travel*</label>
          <span id="areamsg"></span>
            <select class="form-control" required="" id="area" name="area">
              <option value="0" disabled selected hidden>select area of travel</option>
              <option value="Within">Within Dar es Salaam/Kibaha</option>
              <option value="Outside">Outside Dar es Salaam/Kibaha</option>
            </select>
        
        </div>
    </div> 

    <div class="form-group row" id="namediv">
                        <div class="form-wrapper col-2">
                            <label for="designation">Designation*</label>
                            <span id="designationmsg"></span>
                            <select class="form-control" required="" id="designation" name="designation">
              <option value="0" disabled selected hidden> </option>
              <option value="Prof.">Prof.</option>
              <option value="Dr.">Dr.</option>
              <option value="Eng.">Eng.</option>
              <option value="Mr.">Mr.</option>
              <option value="Mrs.">Mrs.</option>
              <option value="Miss">Miss</option>
            </select>
                        </div>

						<div class="form-wrapper col-5">
							<label for="first_name">First Name*</label>
                            <span id="name1msg"></span>
							<input type="text" id="first_name" name="first_name" class="form-control"  onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
						</div>
						<div class="form-wrapper col-5">
							<label for="last_name">Last Name*</label>
                            <span id="name2msg"></span>
							<input type="text" id="last_name" name="last_name" class="form-control" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
						</div>
					</div>

					<div class="form-group row" id="facultydiv">
						<div class="form-wrapper col-6">
							<label for="faculty_name">Faculty/Department/Unit*</label>
                            <span id="name1msg"></span>
							<input type="text" id="faculty_name" name="faculty_name" class="form-control"  onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
						</div>
						<div class="form-wrapper col-6">
							<label for="centre_name">Cost Centre No.*</label>
                            <span id="name2msg"></span>
							<input type="text" id="centre_name" name="centre_name" class="form-control">
						</div>
					</div>

					<div class="form-group row">
						<div class="form-wrapper col-6">
							<label for="start_date">Start Date*</label>
							<input type="date" id="start_date" name="start_date" class="form-control" required="" min="{{$today}}">
						</div>
						<div class="form-wrapper col-6">
							<label for="end_date">End Date*</label>
							<input type="date" id="end_date" name="end_date" class="form-control" required="" min="{{$today}}">
						</div>
					</div>

					<div class="form-group row">
						<div class="form-wrapper col-6">
							<label for="start_time">Start Time*</label>
							<input type="time" id="start_time" name="start_time" class="form-control" required="">
						</div>
						<div class="form-wrapper col-6">
							<label for="end_time">End Time*</label>
							<input type="time" id="end_time" name="end_time" class="form-control" required="">
						</div>
					</div>

					<div class="form-group">
					<div class="form-wrapper">
						<label for="overtime">Estimate Overtime</label>
						<input type="text" id="overtime" name="overtime" class="form-control">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="destination">Destination</label>
						<input type="text" id="destination" name="destination" class="form-control">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="purpose">Purpose/reason of the trip</label>
						<input type="text" id="purpose" name="purpose" class="form-control">
					</div>
				</div>

               <div class="form-group">
					<div class="form-wrapper" id="naturediv">
          <label for="trip_nature">Nature of the trip*</label>
          <span id="trip_naturemsg"></span>
            <select class="form-control" required="" id="trip_nature" name="trip_nature">
              <option value="0" disabled selected hidden>select nature of the trip</option>
              <option value="Departmental">Department/Unit Duty</option>
              <option value="Private">Private</option>
              <option value="Emergency">Emergency</option>
            </select>
        
        </div>
    </div>

    <div class="form-group row" id="estimationdiv">
						<div class="form-wrapper col-6">
							<label for="estimated_distance">Estimated Distance in Kms*</label>
                            <span id="estimated_distancemsg"></span>
							<input type="text" id="estimated_distance" name="estimated_distance" class="form-control"  onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
						</div>
						<div class="form-wrapper col-6">
							<label for="estimated_cost">Estimated Cost in Tshs.*</label>
                            <span id="estimated_costmsg"></span>
							<input type="text" id="estimated_cost" name="estimated_cost" class="form-control" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
						</div>
					</div>

                                </div> 
 <button class="btn btn-primary" type="submit">Forward</button>
                            </fieldset>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection