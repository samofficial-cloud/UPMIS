@extends('layouts.app')
@section('style')
<style type="text/css">
	#t_id tr td{
		border: 1px solid black;
		background-color: #f1e7c1;
	}

	div.dataTables_filter{
  padding-left:830px;
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
    border: 1px solid #505559;
}

.form-inline .form-control {
    width: 100%;
    height: 103%;
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
		@if ($message = Session::get('errors'))
          <div class="alert alert-danger">
            <p>{{$message}}</p>
          </div>
        @endif

      @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{$message}}</p>
      </div>
    @endif
    <br>
		<h2><center>{{$_GET['vehicle_reg_no']}} DETAILS</center></h2>
		<div class="card">
			 <div class="card-body">
		<b><h3>Vehicle Details</h3></b>
		<hr>
		<table style="font-size: 18px;width: 50%" id="t_id">
			@foreach($details as $details)
			<tr>
				<td style="width: 20%">Vehicle model</td>
				<td style="width: 30%">{{ucfirst(strtolower($details->vehicle_model))}}</td>
			</tr>
			<tr>
				<td>Vehicle status</td>
				<td>{{$details->vehicle_status}}</td>
			</tr>
			<tr>
				<td>Hire rate</td>
				<td>{{number_format($details->hire_rate)}}</td>
			</tr>
			@endforeach
		</table>
	</div>
	</div>
		<br>
		<div class="card">
			 <div class="card-body">
          <b><h3>Operational Expenditures</h3></b>
          <hr>
            <a data-toggle="modal" data-target="#car_operational" class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add new</a>

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

        <input type="text" id="op_vehicle_reg_no" name="op_vehicle_reg_no" class="form-control" required="" value="{{$_GET['vehicle_reg_no']}}" hidden="">

        <div class="form-group" id="lpodiv">
          <div class="form-wrapper">
            <label for="model">LPO Number</label>
            <input type="text" id="lpo_no" name="lpo_no" class="form-control" required="" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>

        <div class="form-group" id="datediv">
          <div class="form-wrapper">
            <label for="date_received">Date Received</label>
            <input type="date" id="date_received" name="date_received" class="form-control" required="" max="{{(date('Y-m-d'))}}">
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
            <label for="model">Fuel Consumed in Litres</label>
            <input type="text" id="fuel" name="fuel" class="form-control" required="" onkeypress="if((this.value.length<5)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>

        <div class="form-group" id="amountdiv">
          <div class="form-wrapper">
            <label for="amount">Amount</label>
            <input type="text" id="amount" name="amount" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>

        <div class="form-group" id="totaldiv">
          <div class="form-wrapper">
            <label for="total">Total</label>
            <input type="text" id="total" name="total" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
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
           <br><br>
           <table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#3490dc; width: 5%;"><center>S/N</center></th>
      {{-- <th scope="col" style="color:#3490dc;"><center>Vehicle No.</center></th> --}}
      <th scope="col" style="color:#3490dc;"><center>LPO No.</center></th>
      <th scope="col" style="color:#3490dc;"><center>Date Received</center></th>
      <th scope="col" style="color:#3490dc;"><center>Description of Work</center></th>
      <th scope="col" style="color:#3490dc;"><center>Service Provider</center></th>
      <th scope="col" style="color:#3490dc;"><center>Fuel Consumed (litres)</center></th>
      <th scope="col" style="color:#3490dc;"><center>Amount</center></th>
      <th scope="col" style="color:#3490dc;"><center>Total</center></th>
      <th scope="col" style="color:#3490dc;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($ops as $operational)
      <tr>
        <td class="counterCell text-center">.</td>
       {{--  <td>{{$operational->vehicle_reg_no}}</td> --}}
        <td>{{$operational->lpo_no}}</td>
        <td><center>{{date("d/m/Y",strtotime($operational->date_received))}}</center></td>
        <td>{{$operational->description}}</td>
        <td>{{$operational->service_provider}}</td>
        <td>{{$operational->fuel_consumed}}</td>
        <td>{{number_format($operational->amount)}}</td>
        <td>{{number_format($operational->total)}}</td>
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
                <form method="get" action="{{ route('editoperational') }}">
        {{csrf_field()}}
         <input type="text" id="op_vehicle_reg_no{{$operational->id}}" name="op_vehicle_reg_no" class="form-control" required="" value="{{$operational->vehicle_reg_no}}" hidden="">

        <div class="form-group" id="lpodiv">
          <div class="form-wrapper">
            <label for="lpo_no{{$operational->id}}">LPO Number</label>
            <input type="text" id="lpo_no{{$operational->id}}" name="lpo_no" class="form-control" required="" value="{{$operational->lpo_no}}"  onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>
        <br>

        <div class="form-group" id="datediv">
          <div class="form-wrapper">
            <label for="date_received{{$operational->id}}">Date Received</label>
            <input type="date" id="date_received{{$operational->id}}" name="date_received" class="form-control" required="" value="{{$operational->date_received}}" max={{date('Y-m-d')}}>
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
            <label for="fuel{{$operational->id}}">Fuel Consumed in Litres</label>
            <input type="text" id="fuel{{$operational->id}}" name="fuel" class="form-control" required="" value="{{$operational->fuel_consumed}}"  onkeypress="if((this.value.length<5)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>
        <br>

        <div class="form-group" id="amountdiv">
          <div class="form-wrapper">
            <label for="amount{{$operational->id}}">Amount</label>
            <input type="text" id="amount{{$operational->id}}" name="amount" class="form-control" required="" value="{{$operational->amount}}"  onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>
        <br>

        <div class="form-group" id="totaldiv">
          <div class="form-wrapper">
            <label for="total{{$operational->id}}">Total</label>
            <input type="text" id="total{{$operational->id}}" name="total" class="form-control" required="" value="{{$operational->total}}"  onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>
        <br>

        <div class="form-group" id="descriptiondiv">
          <div class="form-wrapper">
            <label for="description{{$operational->id}}">Description of Work</label>
            <textarea type="text" id="description{{$operational->id}}" name="description" class="form-control" maxlength="100" required="" value="">{{$operational->description}}</textarea>
          </div>
        </div>
        <br>
        <input type="text" name="id" value="{{$operational->id}}" hidden="">

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
</div>
<br>
<div class="card">
<div class="card-body">
<h3>Bookings</h3>
<hr>
<a class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" href="{{ route('carRentalForm') }}">New Booking</a>
    <br><br>
    <div class="tab">
            <button class="tablinks" onclick="openbookings(event, 'upcoming')" id="defaultOpen"><strong>Upcoming</strong></button>
            <button class="tablinks" onclick="openbookings(event, 'previous')"><strong>Previous</strong></button>
        </div>
     <div id="upcoming" class="tabcontent">
     <br> 
    <table class="hover table table-striped table-bordered" id="myTable1">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#3490dc; width: 5%;"><center>S/N</center></th>
     {{--  <th scope="col" style="color:#3490dc;"><center>Vehicle No.</center></th> --}}
      <th scope="col" style="color:#3490dc;"><center>Client Name</center></th>
       <th scope="col" style="color:#3490dc;"><center>Cost Center</center></th>
      <th scope="col" style="color:#3490dc;"><center>Trip Start Date</center></th>
       <th scope="col" style="color:#3490dc;"><center>Trip End Date</center></th>
      <th scope="col" style="color:#3490dc;"><center>Destination</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($bookings as $bookings)
      <tr>
      	<td class="counterCell text-center">.</td>
      	{{-- <td><center>{{$bookings->vehicle_reg_no}}</center></td> --}}
      	<td><center>{{$bookings->fullName}}</center></td>
      	<td><center>{{$bookings->cost_centre}}</center></td>
      	<td><center>{{date("d/m/Y",strtotime($bookings->start_date))}}</center></td>
      	<td><center>{{date("d/m/Y",strtotime($bookings->end_date))}}</center></td>
      	<td><center>{{$bookings->destination}}</center></td>
      </tr>
      @endforeach
  </tbody>
</table>
</div>
<div id="previous" class="tabcontent">
	<br><br>
<table class="hover table table-striped table-bordered" id="myTable2">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#3490dc; width: 5%;"><center>S/N</center></th>
      {{-- <th scope="col" style="color:#3490dc;"><center>Vehicle No.</center></th> --}}
      <th scope="col" style="color:#3490dc;"><center>Client Name</center></th>
       <th scope="col" style="color:#3490dc;"><center>Cost Center</center></th>
      <th scope="col" style="color:#3490dc;"><center>Trip Start Date</center></th>
       <th scope="col" style="color:#3490dc;"><center>Trip End Date</center></th>
      <th scope="col" style="color:#3490dc;"><center>Destination</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($bookings2 as $bookings)
      <tr>
      	<td class="counterCell text-center">.</td>
      	{{-- <td><center>{{$bookings->vehicle_reg_no}}</center></td> --}}
      	<td><center>{{$bookings->fullName}}</center></td>
      	<td><center>{{$bookings->cost_centre}}</center></td>
      	<td><center>{{date("d/m/Y",strtotime($bookings->start_date))}}</center></td>
      	<td><center>{{date("d/m/Y",strtotime($bookings->end_date))}}</center></td>
      	<td><center>{{$bookings->destination}}</center></td>
      </tr>
      @endforeach
  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@section('pagescript')
<script type="text/javascript">

  function openbookings(evt, evtName) {
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
	var table = $('#myTable').DataTable( {
        dom: '<"top"l>rt<"bottom"pi>'
    } );

  var table = $('#myTable1').DataTable( {
        dom: '<"top"l>rt<"bottom"pi>'
    } );

  var table = $('#myTable2').DataTable( {
        dom: '<"top"l>rt<"bottom"pi>'
    } );


});
</script>
@endsection