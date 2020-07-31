@extends('layouts.app')
@section('style')
<style type="text/css">
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

div.dataTables_filter{
  padding-left:852px;
  padding-bottom:20px;
}

div.dataTables_length label {
    font-weight: normal;
    text-align: left;
    white-space: nowrap;
    display: inline-block;
}

div.dataTables_length select {
  height:25px;
  width:10px;
  font-size: 70%;
}
table.dataTable {
font-family: "Nunito", sans-serif;
    font-size: 15px;



  }
  table.dataTable.no-footer {
    border-bottom: 0px solid #111;
}

hr {
    margin-top: 0rem;
    margin-bottom: 2rem;
    border: 0;
    border: 2px solid #505559;
}
.form-inline .form-control {
    width: 100%;
}

.form-wrapper{
	width: 100%
}

.form-inline label {
	justify-content: left;
}
</style>

@endsection
@section('content')
<?php
$i='1';
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
<div class="dropdown">
  <li class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-file-contract"></i> Invoices
  </li>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="/invoice_management">Space</a>
    <a class="dropdown-item" href="/car_rental_invoice_management">Car Rental</a>
    <a class="dropdown-item" href="/insurance_invoice_management">Insurance</a>
<a class="dropdown-item" href="/water_bills_invoice_management">Water</a>
<a class="dropdown-item" href="/electricity_bills_invoice_management">Electricity</a>
  </div>
</div>
<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
        </ul>
    </div>
<div class="main_content">
	<div class="container" style="max-width: 1308px;">
    <br>
		@if ($errors->any())
          <div class="alert alert-danger">
            <strong>Sorry!!</strong> Something went Wrong<br>
            <ul>
              @foreach ($errors as $error)
                <li>{{$error}}</li>
              @endforeach
            </ul>
          </div>
        @endif

      @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{$message}}</p>
      </div>
    @endif
<br>
    <div class="tab">
            <button class="tablinks" onclick="openContracts(event, 'car_list')" id="defaultOpen"><strong>CAR RENTAL LIST</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'Operational')"><strong>OPERATIONAL EXPENDITURE</strong></button>
             <button class="tablinks" onclick="openContracts(event, 'availability')"><strong>CAR AVAILABILITY</strong></button>
        </div>
        <div id="car_list" class="tabcontent">
  <br>
  <h3>1. LIST OF CARS</h3>
  <br>
        <a data-toggle="modal" data-target="#car" class="btn btn-success button_color active" style="
    padding: 10px;

    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add Car</a>

    <div class="modal fade" id="car" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to add new car</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                 	<form method="post" action="{{ route('addCar') }}">
        {{csrf_field()}}
					<div class="form-group" id="regNodiv">
					<div class="form-wrapper">
						<label for="reg_no">Vehicle Registration No</label>
						<input type="text" id="reg_no" name="vehicle_reg_no" class="form-control" required="">
					</div>
				</div>

				<div class="form-group" id="modeldiv">
					<div class="form-wrapper">
						<label for="model">Vehicle Model</label>
						<input type="text" id="model" name="model" class="form-control" required="">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper" id="clientdiv">
          <label for="vehicle_status">Vehicle Status</label>
            <select class="form-control" required="" id="vehicle_status" name="vehicle_status" required="">
              <option value=""disabled selected hidden>select type</option>
              <option value="Running">Running</option>
              <option value="Minor Repair">Minor Repair</option>
              <option value="Grounded">Grounded</option>
            </select>

        </div>
    </div>

				<div class="form-group" id="hirediv">
					<div class="form-wrapper">
						<label for="hire_rate">Hire Rate</label>
						<input type="text" id="hire_rate" name="hire_rate" class="form-control" required="">
					</div>
				</div>

				<div align="right">
  <button class="btn btn-primary" type="submit">Submit</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     <br>
     <br>

     <table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#3490dc; width: 5%;"><center>S/N</center></th>
      <th scope="col" style="color:#3490dc;"><center>Vehicle Registration No.</center></th>
      <th scope="col" style="color:#3490dc;"><center>Vehicle Model</center></th>
      <th scope="col" style="color:#3490dc;"><center>Vehicle Status</center></th>
      <th scope="col" style="color:#3490dc;"><center>Hire Rate</center></th>
      <th scope="col" style="color:#3490dc;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
  	@foreach($cars as $cars)
      <tr>
      <th scope="row">{{ $i }}.</th>
      <td><center>{{ $cars->vehicle_reg_no}}</center></td>
      <td><center>{{$cars->vehicle_model}}</center></td>
      <td><center>{{ $cars->vehicle_status}}</center></td>
      <td><center>{{ $cars->hire_rate}}</center></td>
      <td>
      	<a data-toggle="modal" data-target="#edit{{$cars->id}}" role="button" aria-pressed="true" id="{{$cars->id}}"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>
      	 <div class="modal fade" id="edit{{$cars->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to edit car details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                 	<form method="get" action="{{ route('editcar') }}">
        {{csrf_field()}}
					<div class="form-group">
					<div class="form-wrapper">
						<label for="reg_no">Vehicle Registration No</label>
						<input type="text" id="reg_no{{$cars->id}}" name="vehicle_reg_no" class="form-control" value="{{$cars->vehicle_reg_no}}" required="">
					</div>
				</div>
				<br>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="model">Vehicle Model</label>
						<input type="text" id="model{{$cars->id}}" name="model" class="form-control" value="{{$cars->vehicle_model}}" required="">
					</div>
				</div>
                <br>
				<div class="form-group">
					<div class="form-wrapper">
          <label for="vehicle_status">Vehicle Status</label>
            <select class="form-control" required="" id="vehicle_status{{$cars->id}}" name="vehicle_status" required="">
              <option value=""disabled selected hidden>select type</option>
              <option value="Running">Running</option>
              <option value="Minor Repair">Minor Repair</option>
              <option value="Grounded">Grounded</option>
            </select>

        </div>
    </div>
<br>
				<div class="form-group">
					<div class="form-wrapper">
						<label for="hire_rate">Hire Rate</label>
						<input type="text" id="hire_rate{{$cars->id}}" name="hire_rate" class="form-control" value="{{$cars->hire_rate}}" required="">
					</div>
				</div>
<br>
				<input type="text" name="id" value="{{$cars->id}}" hidden="">

				<div align="right">
  <button class="btn btn-primary" type="submit">Submit</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>

     <a data-toggle="modal" data-target="#Deactivate{{$cars->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
<div class="modal fade" id="Deactivate{{$cars->id}}" role="dialog">

        <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

           <div class="modal-body">
            <p style="font-size: 20px;">Are you sure you want to delete this car?</p>
            <br>
            <div align="right">
      <a class="btn btn-info" href="{{route('deletecar',$cars->id)}}">Proceed</a>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
</div>

</div>
</div>
</div>
</div>
      </td>
  </tr>
  <?php
   $i= $i+1;
  ?>
  @endforeach

  </tbody>
</table>
</div>
<div id="Operational" class="tabcontent">

  <br>
  <h3>2. OPERATIONAL EXPENDITURE</h3>
  <br>
   <a data-toggle="modal" data-target="#car_operational" class="btn btn-success button_color active" style="
    padding: 10px;

    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add</a>

    <div class="modal fade" id="car_operational" role="dialog">

              <div class="modal-dialog   modal-dialog-scrollable" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to add operational expenditures</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('addOperational') }}">
        {{csrf_field()}}
        <div class="form-group" id="OpregNodiv">
          <div class="form-wrapper">
            <label for="op_vehicle_reg_no">Vehicle Registration No</label>
            <input type="text" id="op_vehicle_reg_no" name="op_vehicle_reg_no" class="form-control" required="" autocomplete="off">
            <div id="nameList"></div>
          </div>
        </div>

        <div class="form-group" id="lpodiv">
          <div class="form-wrapper">
            <label for="model">LPO Number</label>
            <input type="text" id="lpo_no" name="lpo_no" class="form-control" required="">
          </div>
        </div>

        <div class="form-group" id="datediv">
          <div class="form-wrapper">
            <label for="date_received">Date Received</label>
            <input type="date" id="date_received" name="date_received" class="form-control" required="">
          </div>
        </div>

        <div class="form-group" id="providerdiv">
          <div class="form-wrapper">
            <label for="model">Service Provider</label>
            <input type="text" id="provider" name="provider" class="form-control" required="">
          </div>
        </div>


        <div class="form-group" id="fueldiv">
          <div class="form-wrapper">
            <label for="model">Fuel Consumed</label>
            <input type="text" id="fuel" name="fuel" class="form-control" required="">
          </div>
        </div>

        <div class="form-group" id="amountdiv">
          <div class="form-wrapper">
            <label for="amount">Amount</label>
            <input type="text" id="amount" name="amount" class="form-control" required="">
          </div>
        </div>

        <div class="form-group" id="totaldiv">
          <div class="form-wrapper">
            <label for="total">Total</label>
            <input type="text" id="total" name="total" class="form-control" required="">
          </div>
        </div>

        <div class="form-group" id="descriptiondiv">
          <div class="form-wrapper">
            <label for="description">Description of Work</label>
            <textarea type="text" id="description" name="description" class="form-control" maxlength="100" required=""></textarea>
          </div>
        </div>

        <div align="right">
  <button class="btn btn-primary" type="submit">Submit</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>

      </form>

                 </div>
               </div>
             </div>
           </div>
           <table class="hover table table-striped table-bordered" id="myTable1">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#3490dc; width: 5%;"><center>S/N</center></th>
      <th scope="col" style="color:#3490dc;"><center>Vehicle No.</center></th>
      <th scope="col" style="color:#3490dc;"><center>LPO No.</center></th>
      <th scope="col" style="color:#3490dc;"><center>Date Received</center></th>
      <th scope="col" style="color:#3490dc;"><center>Description of Work</center></th>
      <th scope="col" style="color:#3490dc;"><center>Service Provider</center></th>
      <th scope="col" style="color:#3490dc;"><center>Fuel Consumed</center></th>
      <th scope="col" style="color:#3490dc;"><center>Amount</center></th>
      <th scope="col" style="color:#3490dc;"><center>Total</center></th>
      <th scope="col" style="color:#3490dc;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($operational as $operational)
      <tr>
        <td class="counterCell text-center">.</td>
        <td>{{$operational->vehicle_reg_no}}</td>
        <td>{{$operational->lpo_no}}</td>
        <td><center>{{$operational->date_received}}</center></td>
        <td>{{$operational->description}}</td>
        <td>{{$operational->service_provider}}</td>
        <td>{{$operational->fuel_consumed}}</td>
        <td>{{$operational->amount}}</td>
        <td>{{$operational->total}}</td>
        <td>
          <a data-toggle="modal" data-target="#editops{{$operational->id}}" role="button" aria-pressed="true" id="{{$operational->id}}"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>
         <div class="modal fade" id="editops{{$operational->id}}" role="dialog">

              <div class="modal-dialog modal-dialog-scrollable" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to edit car details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="#">
        {{csrf_field()}}
        <div class="form-group" id="OpregNodiv">
          <div class="form-wrapper">
            <label for="op_vehicle_reg_no{{$operational->id}}">Vehicle Registration No</label>
            <input type="text" id="op_vehicle_reg_no{{$operational->id}}" name="op_vehicle_reg_no" class="form-control" required="" autocomplete="off" value="{{$operational->vehicle_reg_no}}">
            <div id="nameList2"></div>
          </div>
        </div>
        <br>

        <div class="form-group" id="lpodiv">
          <div class="form-wrapper">
            <label for="lpo_no{{$operational->id}}">LPO Number</label>
            <input type="text" id="lpo_no{{$operational->id}}" name="lpo_no" class="form-control" required="" value="{{$operational->lpo_no}}">
          </div>
        </div>
        <br>

        <div class="form-group" id="datediv">
          <div class="form-wrapper">
            <label for="date_received{{$operational->id}}">Date Received</label>
            <input type="date" id="date_received{{$operational->id}}" name="date_received" class="form-control" required="" value="{{$operational->date_received}}">
          </div>
        </div>
        <br>

        <div class="form-group" id="providerdiv">
          <div class="form-wrapper">
            <label for="provider{{$operational->id}}">Service Provider</label>
            <input type="text" id="provider{{$operational->id}}" name="provider" class="form-control" required="" value="{{$operational->service_provider}}">
          </div>
        </div>
        <br>


        <div class="form-group" id="fueldiv">
          <div class="form-wrapper">
            <label for="fuel{{$operational->id}}">Fuel Consumed</label>
            <input type="text" id="fuel{{$operational->id}}" name="fuel" class="form-control" required="" value="{{$operational->fuel_consumed}}">
          </div>
        </div>
        <br>

        <div class="form-group" id="amountdiv">
          <div class="form-wrapper">
            <label for="amount{{$operational->id}}">Amount</label>
            <input type="text" id="amount{{$operational->id}}" name="amount" class="form-control" required="" value="{{$operational->amount}}">
          </div>
        </div>
        <br>

        <div class="form-group" id="totaldiv">
          <div class="form-wrapper">
            <label for="total{{$operational->id}}">Total</label>
            <input type="text" id="total{{$operational->id}}" name="total" class="form-control" required="" value="{{$operational->total}}">
          </div>
        </div>
        <br>

        <div class="form-group" id="descriptiondiv">
          <div class="form-wrapper">
            <label for="description{{$operational->id}}">Description of Work</label>
            <textarea type="text" id="description{{$operational->id}}" name="description" class="form-control" maxlength="100" required="" value="{{$operational->description}}"></textarea>
          </div>
        </div>
        <br>

        <div align="right">
  <button class="btn btn-primary" type="submit">Submit</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>

      </form>

                 </div>
               </div>
             </div>
           </div>

            <a data-toggle="modal" data-target="#Deactivateop{{$operational->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
<div class="modal fade" id="Deactivateop{{$operational->id}}" role="dialog">

        <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

           <div class="modal-body">
            <p style="font-size: 20px;">Are you sure you want to delete this operational expenditure?</p>
            <br>
            <div align="right">
      <a class="btn btn-info" href="{{route('deleteops',$operational->id)}}">Proceed</a>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
</div>

</div>
</div>
</div>
</div>

        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>

  <?php
  $today=date('Y-m-d');
  ?>

    <div id="availability" class="tabcontent">
  <br>
  <h3>3. CAR AVAILABILITY</h3>
  <form id="msform">
    <fieldset>
    <div class="form-card">
   {{--  <h4 class="fs-title">Please fill the form below</h4> --}}
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
          <center><button class="btn btn-primary" type="submit" id="check">Submit</button></center>
    </div>
    </fieldset>
  </form>
  <br>
  <div id="content">
    <div id="loading"></div>
  </div>

</div>

</div>
</div>
</div>
@endsection

@section('pagescript')
<script type="text/javascript">
  $(document).ready(function(){
	var table = $('#myTable').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );

  var table = $('#myTable1').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );


});
</script>

<script type="text/javascript">
  function openContracts(evt, evtName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(evtName).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script>
<script type="text/javascript">
  $(document).ready(function(){
  $('#op_vehicle_reg_no').keyup(function(e){
        e.preventDefault();
        var query = $(this).val();
        if(query != ''){
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.fetch2') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            console.log(2);
            if(data=='0'){
              console.log(3);
             $('#op_vehicle_reg_no').attr('style','border:1px solid #f00');
             a = '0';
            }
            else{
              console.log(4);
              a ='1';
              //$('#message2').hide();
              $('#op_vehicle_reg_no').attr('style','border:1px solid #ced4da');
              $('#nameList').fadeIn();
              $('#nameList').html(data);
          }
        }
         });
        }
        else if(query==''){
          a ='1';
              //$('#message2').hide();
              $('#op_vehicle_reg_no').attr('style','border:1px solid #ced4da');
        }
     });

  $(document).on('click', '#list', function(){
    console.log(5);
   a ='1';
  $('#op_vehicle_reg_no').attr('style','border:1px solid #ced4da');
  $('#op_vehicle_reg_no').val($(this).text());
  $('#nameList').fadeOut();

    });

   $(document).on('click', 'form', function(){

     $('#nameList').fadeOut();
    });

   $(document).ajaxSend(function(){
    $("#loading").fadeIn(250);
    });
$(document).ajaxComplete(function(){
    $("#loading").fadeOut(250);
    });

$("#check").click(function(e){
    $("#error").hide();
    var query = $('#start_date').val();
    var query2 = $('#end_date').val();
    if(query!='' && query2!=''){
      if(new Date(query2) <= new Date(query)){
        var query3=query2;
        query2=query;
        query=query3;
      }
      $.ajax({
      url: "/car/available_cars?",
      context: document.body,
      data:{start_date:query,end_date:query2}
    })
    .done(function(fragment) {
      $("#content").html(fragment);
      var table = $('#myTable4').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    });
    });
    return false;

  }

});

    });



</script>
@endsection
