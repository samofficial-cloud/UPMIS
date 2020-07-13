@extends('layouts.app')
@section('style')
<style type="text/css">
div.dataTables_filter{
  padding-left:878px;
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
            <li><a href="insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
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
	<div class="container" style="max-width: 1308px;">
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
</div>
</div>
@endsection

@section('pagescript')
<script type="text/javascript">
	var table = $('#myTable').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'     
    } );
</script>
@endsection