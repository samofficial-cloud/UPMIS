@extends('layouts.app')

@section('style')
<style type="text/css">
	div.dataTables_filter{
  padding-left:852px;
  padding-bottom:20px;
}
#myTable3_filter {
   padding-left:590px;
  padding-bottom:10px;
  }

  #myTable3_length{
    padding-left: 50px;
  }

   #myTable2_length{
    padding-left: 48px;
  }

  #myTable2_filter {
   padding-left:595px;
  padding-bottom:10px;
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
    border-bottom: 2px solid #505559;
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
<div class="wrapper">
	<div class="sidebar">
        <ul style="list-style-type:none;">

            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>
            
            @if($category=='All')
           <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Insurance only')
          <li><a href="{{ route('home2') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Real Estate only')
          <li><a href="{{ route('home4') }}"><i class="fas fa-home active"></i>Home</a></li>
           @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home3') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role=='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home5') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role=='Accountant-Cost Centre'))
            <li><a href="{{ route('home5') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif

            @if($category=='Real Estate only' OR $category=='All')
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            @else
            @endif

            @if($category=='Insurance only' OR $category=='All')
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
    @else
    @endif
            @if(($category=='CPTU only' OR $category=='All') && (Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
    @else
    @endif
    @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
    
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>      
    @endif
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>

<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
 @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
  @endif
@admin
            <li><a href="/user_role_management"><i class="fas fa-user-friends hvr-icon" aria-hidden="true"></i>Manage Users</a></li>
<li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
    <div class="main_content">
    	<div class="container">
	<?php
    
    $i=1;
    $j = 1;
	?>
  <div id="footer">
  <div class="page-number"></div>
</div>
<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT 
     <br><br>History Report for <strong>{{$_GET['reg']}}</strong> 
    </b> 
</center>

<h3>Vehicle Details</h3>
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
				<td>TZS {{number_format($details->hire_rate)}}</td>
			</tr>
			@endforeach
		</table>
		<br>
		<hr>
	<h3>Bookings</h3>
	@if(count($bookings)>0)
	<table class="hover table table-striped table-bordered" id="myTable1">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="width: 5%;"><center>S/N</center></th>
      <th scope="col" style="width: 25%;"><center>Client Name</center></th>
       <th scope="col"><center>Cost Center</center></th>
      <th scope="col"><center>Trip Start Date</center></th>
       <th scope="col"><center>Trip End Date</center></th>
      <th scope="col"><center>Destination</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($bookings as $bookings)
      <tr>
      	<td scope="row" style="text-align: center;">{{$j}}.</td>
      	<td>{{$bookings->fullName}}</td>
      	<td><center>{{$bookings->cost_centre}}</center></td>
      	<td><center>{{date("d/m/Y",strtotime($bookings->start_date))}}</center></td>
      	<td><center>{{date("d/m/Y",strtotime($bookings->end_date))}}</center></td>
      	<td>{{$bookings->destination}}</td>
      </tr>
      <?php $j = $j+1; ?>
      @endforeach
  </tbody>
</table>
@else
<h4>No bookings has been made yet for this vehicle</h4>
@endif
<br>
<hr>
<h3>Operational Expenditure</h3>
@if(count($operations)>0)
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="width: 5%;"><center>S/N</center></th>
      <th scope="col"><center>LPO No.</center></th>
      <th scope="col"><center>Date Received</center></th>
      <th scope="col"><center>Description of Work</center></th>
      <th scope="col"><center>Service Provider</center></th>
      <th scope="col"><center>Fuel Consumed (litres)</center></th>
      <th scope="col"><center>Amount</center></th>
      <th scope="col"><center>Total</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($operations as $operational)
      <tr>
        <td scope="row" style="text-align: center;">{{$i}}.</td>
        <td>{{$operational->lpo_no}}</td>
        <td><center>{{date("d/m/Y",strtotime($operational->date_received))}}</center></td>
        <td style="width: 28%;">{{$operational->description}}</td>
        <td>{{$operational->service_provider}}</td>
        <td>{{$operational->fuel_consumed}}</td>
        <td style="text-align: right;">{{number_format($operational->amount)}}</td>
        <td style="text-align: right;">{{number_format($operational->total)}}</td>
    </tr>
    <?php
    $i=$i+1;
    ?>
    @endforeach
</tbody>
</table>
@else
<h4>No operational expenditure has been addded yet for this vehicle</h4>
@endif
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
        dom: '<"top"Bl>rt<"bottom"pi>',
       buttons: [
                {
                    extend: 'pdf', className: 'btn green btn-outline',  text: 'Export PDF',
                    customize: function (doc) {
                        doc.defaultStyle = 
                            {
                                font: 'alef'
                            }

                          }
                       } 
                   ]
        
    } );

  var table = $('#myTable2').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );
  var table = $('#myTable3').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );


});
</script>
@endsection