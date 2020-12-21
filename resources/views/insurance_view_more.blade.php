@extends('layouts.app')
@section('style')
<style type="text/css">
	#t_id tr td{
		border: 1px solid black;
		background-color: #f1e7c1;
	}

#t_idd tr td{
        border: 1px solid black;
        background-color: #e9ecef;
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

            @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

                <li><a href="/businesses"><i class="fa fa-building" aria-hidden="true"></i> Businesses</a></li>
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
            <li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
<div class="main_content">
    <br>
    <div class="container" style="max-width: 1308px;">
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
    <h2><center>{{$clientname}} Details</center></h2>
    <div class="card">
       <div class="card-body">
        <b><h3>Client Details</h3></b>
    <hr>
     <table style="font-size: 18px;width:40%" id="t_id">
      <tr>
        <td style="width: 15%">Client Name</td>
        <td style="width: 20%">{{$clientname}}</td>
      </tr>
      <tr>
        <td>Phone Number</td>
        <td>{{$phone_number}}</td>
      </tr>
      <tr>
        <td>Email</td>
        <td>{{$clientemail}}</td>
      </tr>
    </table>
  </div>
</div>
<br>
<div class="card" style="display: flex;
  overflow-x: auto;">
  <div class="card-body">
    <b><h3>Commission Generated and Premium Paid</h3></b>
    <hr style="width: 117%;">
    <table style="font-size: 18px;width:50%" id="t_idd">
        <tr>
            <td></td>
            <td><center>TZS</center></td>
            <td><center>USD</center></td>
        </tr>
        <tr>
        <td>Total Premium Paid</td>
        <td><center>{{number_format($total_premium_tzs)}}</center></td>
        <td><center>{{number_format($total_premium_usd)}}</center></td>
      </tr>
      <tr>
        <td style="width: 15%">Total Commission Generated</td>
        <td style="width: 20%"><center>{{number_format($total_commision_tzs)}}</center></td>
        <td style="width: 20%"><center>{{number_format($total_commision_usd)}}</center></td>
      </tr>
    </table>
    <br>
    <h3>Detailed Information</h3>
    <br>
    <table class="hover table table-striped table-bordered" id="myTable" style="width: 120%;">
        <thead class="thead-dark">
        <tr>
                            <th scope="col" style="color:#fff;"><center>S/N</center></th>
                            <th scope="col" style="color:#fff;width: 12%;"><center>Class</center></th>
                            <th scope="col" style="color:#fff;"><center>Vehicle Reg No</center></th>
                            <th scope="col" style="color:#fff;"><center>Vehicle Use</center></th>
                            <th scope="col" style="color:#fff;"><center>Principal</center></th>
                            <th scope="col"  style="color:#fff;"><center>Insurance Type</center></th>
                            <th scope="col"  style="color:#fff; width: 15%;"><center>Duration</center></th>
                            {{-- <th scope="col"  style="color:#fff;"><center>End Date</center></th> --}}
                            <th scope="col"  style="color:#fff;"><center>Premium Paid</center></th>
                            <th scope="col"  style="color:#fff;"><center>Commission </center></th>
                            <th scope="col"  style="color:#fff;"><center>Receipt No </center></th>
                            {{-- <th scope="col"  style="color:#fff;"><center>Action</center></th> --}}
                        </tr>
    </thead>
    <tbody>

                        @foreach($contracts as $var)
                            <tr>
                                <td class="counterCell text-center">.</td>
                                <td>{{$var->class}}</td>
                                @if($var->class=='MOTOR')
                                <td>{{$var->vehicle_registration_no}}</td>
                                <td>{{$var->vehicle_use}}</td>
                                @else
                                <td>N/A</td>
                                <td>N/A</td>
                                @endif
                                <td>{{$var->principal}}</td>
                                <td>{{$var->insurance_type}}</td>
                                <td><center>{{date("d/m/Y",strtotime($var->commission_date))}} - {{date("d/m/Y",strtotime($var->end_date))}}</center></td>
                                {{-- <td></td> --}}
                                <td>{{$var->currency}} {{number_format($var->premium)}}</td>
                                <td>{{$var->currency}} {{number_format($var->commission)}}</td>
                                <td>{{$var->receipt_no}}</td>
                               {{--  <td></td> --}}
                            </tr>
                            @endforeach
                        </tbody>
</table>
    </div>
</div>

</div>
</div>
</div>
@endsection

@section('pagescript')
<script type="text/javascript">
        var table = $('#myTable').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );
        var table2 = $('#myTable2').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );


        var table2 = $('#myTableInsurance').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

        var table3 = $('#myTablecar').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );
    </script>
@endsection
