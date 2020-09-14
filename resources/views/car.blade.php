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
    border: 1px solid #505559;
}

.form-inline .form-control {
    width: 100%;
    height: auto;
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

            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>
            <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>

            @if($category=='Real Estate only' OR $category=='All')
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            @else
            @endif
            @if($category=='Insurance only' OR $category=='All')
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
    @else
    @endif
            @if($category=='CPTU only' OR $category=='All')
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
    @else
    @endif
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>
<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
@admin
            <li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
    <?php
    use App\hire_rate;
    use App\operational_expenditure;
      $model=hire_rate::select('vehicle_model')->get();
      $model1=hire_rate::select('vehicle_model')->get();
    ?>
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
    <div class="tab">
            <button class="tablinks" onclick="openContracts(event, 'car_list')" id="defaultOpen"><strong>VEHICLE FLEET</strong></button>
            {{-- <button class="tablinks" onclick="openContracts(event, 'Operational')"><strong>OPERATIONAL EXPENDITURE</strong></button> --}}
            <button class="tablinks" onclick="openContracts(event, 'hire')"><strong>HIRE RATE</strong></button>
             <button class="tablinks" onclick="openContracts(event, 'availability')"><strong>VEHICLE AVAILABILITY</strong></button>
        </div>
        <div id="car_list" class="tabcontent">
  <br>
 <center><h3><strong>Vehicle Fleet</strong></h3></center>
  <hr>
  <br>
   @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
        <a title="Add a Vehicle" data-toggle="modal" data-target="#car" class="btn btn-success button_color active" style="
    padding: 10px;

    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add Vehicle</a>

    <div class="modal fade" id="car" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to add new vehicle</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                 	<form method="post" action="{{ route('addCar') }}">
        {{csrf_field()}}
					<div class="form-group" id="regNodiv">
					<div class="form-wrapper">
						<label for="reg_no">Vehicle Registration No</label>
						<input type="text" id="reg_no" name="vehicle_reg_no" class="form-control" required="" onblur="this.value=removeSpaces(this.value); javascript:this.value=this.value.toUpperCase();">
					</div>
				</div>

				<div class="form-group" id="modeldiv">
					<div class="form-wrapper">
						<label for="model">Vehicle Model</label>
            <select class="form-control" required="" id="model" name="model" required="">
              <option value=""disabled selected hidden>select Vehicle Model</option>
              @foreach($model as $model)
              <option value="{{$model->vehicle_model}}">{{$model->vehicle_model}}</option>
              @endforeach
            </select>
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper" id="clientdiv">
          <label for="vehicle_status">Vehicle Status</label>
            <select class="form-control" required="" id="vehicle_status" name="vehicle_status" required="">
              <option value=""disabled selected hidden>select Vehicle status</option>
              <option value="Running">Running</option>
              <option value="Minor Repair">Minor Repair</option>
              <option value="Grounded">Grounded</option>
            </select>

        </div>
    </div>

				<div class="form-group" id="hirediv">
					<div class="form-wrapper">
						<label for="hire_rate">Hire Rate/KM</label>
						<input type="text" id="hire_rate" name="hire_rate" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
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
     @endif
     

     <table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
      <th scope="col" style="color:#fff;"><center>Vehicle Registration No.</center></th>
      <th scope="col" style="color:#fff;"><center>Vehicle Model</center></th>
      <th scope="col" style="color:#fff;"><center>Vehicle Status</center></th>
      <th scope="col" style="color:#fff;"><center>Hire Rate/KM</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
  	@foreach($cars as $cars)
      <tr>
      <th scope="row">{{ $i }}.</th>
      <td><center>{{ $cars->vehicle_reg_no}}</center></td>
      <td>{{$cars->vehicle_model}}</td>
      <td>{{ $cars->vehicle_status}}</td>
      <td><center>TZS {{ number_format($cars->hire_rate)}}</center></td>
        <td><center>
         <a title="View More Details" role="button" href="{{ route('CarViewMore') }}?vehicle_reg_no={{$cars->vehicle_reg_no}}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
          @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
      	<a title="Edit Car Details" data-toggle="modal" data-target="#edit{{$cars->id}}" role="button" aria-pressed="true" id="{{$cars->id}}"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
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
						<input type="text" id="reg_no{{$cars->id}}" name="vehicle_reg_no" class="form-control" value="{{$cars->vehicle_reg_no}}" required="" onblur="this.value=removeSpaces(this.value); javascript:this.value=this.value.toUpperCase();">
					</div>
				</div>
				<br>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="model">Vehicle Model</label>
            <select class="form-control" required="" id="model{{$cars->id}}" name="model" required="">
              <option value="{{$cars->vehicle_model}}">{{$cars->vehicle_model}}</option>
              @foreach($model1 as $model)
              @if($model->vehicle_model != $cars->vehicle_model)
              <option value="{{$model->vehicle_model}}">{{$model->vehicle_model}}</option>
              @endif
              @endforeach
            </select>
					</div>
				</div>
                <br>
				<div class="form-group">
					<div class="form-wrapper">
          <label for="vehicle_status">Vehicle Status</label>
            <select class="form-control" required="" id="vehicle_status{{$cars->id}}" name="vehicle_status" required="">
              <option value="{{$cars->vehicle_status}}">{{$cars->vehicle_status}}</option>
              @if($cars->vehicle_status != 'Running')
              <option value="Running">Running</option>
              @endif
              @if($cars->vehicle_status != 'Minor Repair')
              <option value="Minor Repair">Minor Repair</option>
              @endif
              @if($cars->vehicle_status != 'Grounded')
              <option value="Grounded">Grounded</option>
              @endif
            </select>

        </div>
    </div>
<br>
				<div class="form-group">
					<div class="form-wrapper">
						<label for="hire_rate">Hire Rate/KM</label>
						<input type="text" id="hire_rate{{$cars->id}}" name="hire_rate" class="form-control" value="{{$cars->hire_rate}}" required="" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
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

    

     <a title="Delete this Car" data-toggle="modal" data-target="#Deactivate{{$cars->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>
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
@endif</center>
</td>

      
  </tr>
  <?php
   $i= $i+1;
  ?>
  @endforeach

  </tbody>
</table>
</div>

  <div id="hire" class="tabcontent" >
  <br>
  <center><h3><strong>Hire Rates</strong></h3></center>
  <hr>
  @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
          <a data-toggle="modal" data-target="#hiree" class="btn btn-success button_color active" style="
    padding: 10px;

    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add Rate</a>

    <div class="modal fade" id="hiree" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to add new hire rate</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('addhirerate') }}">
        {{csrf_field()}}
        <div class="form-group" id="modeldiv">
          <div class="form-wrapper">
            <label for="model">Vehicle Model</label>
            <input type="text" id="hire_model" name="vehicle_model" class="form-control" required="">
          </div>
        </div>

        <div class="form-group" id="hirediv">
          <div class="form-wrapper">
            <label for="hire_hire_rate">Hire Rate/Km</label>
            <input type="text" id="hire_hire_rate" name="hire_rate" class="form-control" required="" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
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
     @endif
     <div class="container" style="width: 80%">
     <table class="hover table table-striped table-bordered" id="myTable2" style="width: 90%">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#fff; width: 3%;"><center>S/N</center></th>
      <th scope="col" style="color:#fff;"><center>Vehicle Model</center></th>
      <th scope="col" style="color:#fff;"><center>Hire Rate</center></th>
      @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
      <th scope="col" style="color:#fff;"><center>Action</center></th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach($rate as $rate)
    <tr>
    <th scope="row" class="counterCell text-center">.</th>
    <td>{{$rate->vehicle_model}}</td>
    <td><center>{{number_format($rate->hire_rate)}}</center></td>
    @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
    <td><center>
      <a title="Edit this Hire Rate" data-toggle="modal" data-target="#hire{{$rate->id}}" role="button" aria-pressed="true" id="{{$rate->id}}"><i class="fa fa-edit" style="font-size:20px; color: green;"></i></a>
         <div class="modal fade" id="hire{{$rate->id}}" role="dialog">

              <div class="modal-dialog modal-dialog-scrollable" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to edit hire rate details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('edithirerate') }}">
        {{csrf_field()}}
        <div class="form-group">
          <div class="form-wrapper">
            <label for="hire_vehicle_model{{$rate->id}}">Vehicle Model</label>
            <input type="text" id="hire_vehicle_model{{$rate->id}}" name="hire_vehicle_model" class="form-control" required="" autocomplete="off" value="{{$rate->vehicle_model}}">
          </div>
        </div>
        <br>

        <div class="form-group">
          <div class="form-wrapper">
            <label for="hire_hire_rate{{$rate->id}}">Hire Rate</label>
            <input type="text" id="hire_hire_rate{{$rate->id}}" name="hire_hire_rate" class="form-control" required="" value="{{$rate->hire_rate}}" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>
        <br>
        <input type="text" name="id" value="{{$rate->id}}" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Submit</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>

      </form>

                 </div>
               </div>
             </div>
           </div>

           <a title="Delete this Hire Rate" data-toggle="modal" data-target="#Deactivatehire{{$rate->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>
<div class="modal fade" id="Deactivatehire{{$rate->id}}" role="dialog">
        <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

           <div class="modal-body">
            <p style="font-size: 20px;">Are you sure you want to delete this hire rate?</p>
            <br>
            <div align="right">
      <a class="btn btn-info" href="{{route('deletehirerate',$rate->id)}}">Proceed</a>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
</div>

</div>
</div>
</div>
</div></center>
    </td>
    @endif
  </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>

  <?php
  $today=date('Y-m-d');
  ?>

    <div id="availability" class="tabcontent">
  <br>
  <center><h3><strong>Vehicle Availability</strong></h3></center>
  <hr>
  <form id="msform">
    <fieldset>
    <div class="form-card">
   {{--  <h4 class="fs-title">Please fill the form below</h4> --}}
      <div class="form-group row">
            <div class="form-wrapper col-6">
              <label for="start_date">Start Date<span style="color: red;">*</span></label>
              <input type="date" id="start_date" name="start_date" class="form-control" required="" min="{{$today}}">
            </div>
            <div class="form-wrapper col-6">
              <label for="end_date">End Date<span style="color: red;">*</span></label>
              <input type="date" id="end_date" name="end_date" class="form-control" required="" min="{{$today}}">
            </div>
          </div>
          <center><button class="btn btn-primary" type="submit" id="check">Submit</button></center>
    </div>
    </fieldset>
  </form>
  <br>
  <div id="content">
    <center><div id="loading"></div></center>
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
        dom: '<"top"l>rt<"bottom"pi>'
    } );

  var table = $('#myTable2').DataTable( {
        dom: '<"top"l>rt<"bottom"pi>'
    } );


});
</script>

<script type="text/javascript">

  function removeSpaces(string) {
 return string.split(' ').join('');
}

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
        dom: '<"top"l>rt<"bottom"pi>'
    });
    });
    return false;

  }

});

$("#model").click(function(){
        var query = $(this).val();
        if(query!=''){
        var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.hirerate') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#hire_rate').val(data);
          }
          });
    }

    });

$('#myTable').on('click', '[name="model"]', function(e){
        e.preventDefault();
        var query = $(this).val();
        var id = $("#"+e.target.id).val();
      let reg = e.target.id.replace(/\D/g,'');

      if(query!=''){
        var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.hirerate') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#hire_rate'+reg).val(data);
          }
          });
    }
      });

    });



</script>
@endsection
