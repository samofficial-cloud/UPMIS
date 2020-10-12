@extends('layouts.app')

@section('style')
<style type="text/css">
div.dataTables_filter{
  padding-left:850px;
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
a.title{
  border: none;
}
</style>

@endsection

@section('content')
<?php
$i=1;
?>
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
  <br>
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

    <a class="btn btn-success" href="{{ route('carRentalForm') }}" role="button" style="
    padding: 10px; margin-bottom: 5px; margin-top: 4px;">New Contract
  </a>
<br>
<br>

  <div class="tab">
            <button class="tablinks" onclick="openContracts(event, 'Active_Contracts')" id="defaultOpen"><strong>ACTIVE CONTRACTS</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'Inactive_Contracts')"><strong>INACTIVE CONTRACTS</strong></button>
        </div>
<div id="Active_Contracts" class="tabcontent">
  <br>
  <h3>1. ACTIVE CONTRACTS</h3>
  <br>
  <table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#3490dc; width: 5%;"><center>S/N</center></th>
      <th scope="col" style="color:#3490dc;"><center>Client Name</center></th>
      <th scope="col" style="color:#3490dc;"><center>Vehicle Registration No.</center></th>
      <th scope="col" style="color:#3490dc;"><center>Start Date</center></th>
      <th scope="col" style="color:#3490dc;"><center>End Date</center></th>
      <th scope="col" style="color:#3490dc;"><center>Amount</center></th>
      <th scope="col" style="color:#3490dc;"><center>Rates</center></th>
      <th scope="col" style="color:#3490dc;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($contracts as $contracts)
    <tr>
    <td>{{$i}}.</td>
    <td><a data-toggle="modal" data-target="#client{{$contracts->id}}" style="cursor: pointer;" aria-pressed="true">{{$contracts->fullName}}</a>
      <div class="modal fade" id="client{{$contracts->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">{{$contracts->fullName}} Details.</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%">
                    <tr>
                      <td>Client Type:</td>
                      <td>{{$contracts->type}}</td>
                    </tr>
                    @if($contracts->type=='Individual')
                   <tr>
                     <td> First Name:</td>
                     <td> {{$contracts->first_name}}</td>
                   </tr>
                   <tr>
                     <td>Last Name:</td>
                     <td>{{$contracts->last_name}}</td>
                   </tr>
                   @elseif($contracts->type=='Company')
                   <tr>
                     <td>Company Name:</td>
                     <td>{{$contracts->fullName}}</td>
                   </tr>
                   @endif
                   <tr>
                     <td>Phone Number:</td>
                     <td>{{$contracts->phone_number}}</td>
                   </tr>
                   <tr>
                     <td>Email:</td>
                     <td>{{$contracts->email}}</td>
                   </tr>
                   <tr>
                     <td>Address:</td>
                     <td>{{$contracts->address}}</td>
                   </tr>
                  </table>
                  <br>
                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                 </div>
               </div>
             </div>
           </div>
    </td>
    <td><a data-toggle="modal" data-target="#car{{$contracts->id}}" style="cursor: pointer;" aria-pressed="true">{{$contracts->vehicle_reg_no}}</a>
      <div class="modal fade" id="car{{$contracts->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">{{$contracts->vehicle_reg_no}} Details.</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%">
                    <tr>
                      <td>Vehicle Registration No:</td>
                      <td>{{$contracts->vehicle_reg_no}}</td>
                    </tr>
                   <tr>
                     <td>Vehicle Model:</td>
                     <td> {{$contracts->vehicle_model}}</td>
                   </tr>
                   <tr>
                     <td>Vehicle Status:</td>
                     <td>{{$contracts->vehicle_status}}</td>
                   </tr>
                   <tr>
                     <td>Hire Rate:</td>
                     <td>{{$contracts->hire_rate}}</td>
                   </tr>
                  </table>
                  <br>
                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                 </div>
               </div>
             </div>
           </div>
    </td>
    <td><center>{{$contracts->start_date}}</center></td>
    <td><center>{{$contracts->end_date}}</center></td>
    <td><center>{{$contracts->currency}} {{$contracts->amount}}</center></td>
    <td><center>{{$contracts->rate}}</center></td>
    <td>
      <a href="{{ route('EditcarRentalForm', $contracts->id) }}" role="button"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>
      <a data-toggle="modal" data-target="#Deactivate{{$contracts->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
      <div class="modal fade" id="Deactivate{{$contracts->id}}" role="dialog">
        <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

           <div class="modal-body">
            <p style="font-size: 20px;">Are you sure you want to delete this contract?</p>
            <br>
            <div align="right">
      <a class="btn btn-info" href="{{route('deletecontract',$contracts->id)}}">Proceed</a>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
</div>

</div>
</div>
</div>
</div>




<a href="/contracts/car_rental/print?id={{$contracts->id}}"><i class="fa fa-print" style="font-size:28px;color: #3490dc;"></i></a>


    </td>
     </tr>
     <?php
      $i=$i+1;
     ?>
    @endforeach

  </tbody>
</table>
</div>
<div id="Inactive_Contracts" class="tabcontent">
  <?php
   $i='1';
  ?>
  <br>
  <h3>2. INACTIVE CONTRACTS</h3>
  <br>
  <table class="hover table table-striped table-bordered" id="myTable2">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#3490dc; width: 5%;"><center>S/N</center></th>
      <th scope="col" style="color:#3490dc;"><center>Client Name</center></th>
      <th scope="col" style="color:#3490dc;"><center>Vehicle Registration No.</center></th>
      <th scope="col" style="color:#3490dc;"><center>Start Date</center></th>
      <th scope="col" style="color:#3490dc;"><center>End Date</center></th>
      <th scope="col" style="color:#3490dc;"><center>Amount</center></th>
      <th scope="col" style="color:#3490dc;"><center>Rates</center></th>
      <th scope="col" style="color:#3490dc;"><center>Status</center></th>
      <th scope="col" style="color:#3490dc;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($inactive_contracts as $contracts)
    <tr>
    <td>{{$i}}.</td>
    <td><a data-toggle="modal" data-target="#client{{$contracts->id}}" style="cursor: pointer;" aria-pressed="true">{{$contracts->fullName}}</a>
      <div class="modal fade" id="client{{$contracts->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">{{$contracts->fullName}} Details.</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%">
                    <tr>
                      <td>Client Type:</td>
                      <td>{{$contracts->type}}</td>
                    </tr>
                    @if($contracts->type=='Individual')
                   <tr>
                     <td> First Name:</td>
                     <td> {{$contracts->first_name}}</td>
                   </tr>
                   <tr>
                     <td>Last Name:</td>
                     <td>{{$contracts->last_name}}</td>
                   </tr>
                   @elseif($contracts->type=='Company')
                   <tr>
                     <td>Company Name:</td>
                     <td>{{$contracts->fullName}}</td>
                   </tr>
                   @endif
                   <tr>
                     <td>Phone Number:</td>
                     <td>{{$contracts->phone_number}}</td>
                   </tr>
                   <tr>
                     <td>Email:</td>
                     <td>{{$contracts->email}}</td>
                   </tr>
                   <tr>
                     <td>Address:</td>
                     <td>{{$contracts->address}}</td>
                   </tr>
                  </table>
                  <br>
                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                 </div>
               </div>
             </div>
           </div>
    </td>
    <td><a data-toggle="modal" data-target="#car{{$contracts->id}}" style="cursor: pointer;" aria-pressed="true">{{$contracts->vehicle_reg_no}}</a>
      <div class="modal fade" id="car{{$contracts->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">{{$contracts->vehicle_reg_no}} Details.</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%">
                    <tr>
                      <td>Vehicle Registration No:</td>
                      <td>{{$contracts->vehicle_reg_no}}</td>
                    </tr>
                   <tr>
                     <td>Vehicle Model:</td>
                     <td> {{$contracts->vehicle_model}}</td>
                   </tr>
                   <tr>
                     <td>Vehicle Status:</td>
                     <td>{{$contracts->vehicle_status}}</td>
                   </tr>
                   <tr>
                     <td>Hire Rate:</td>
                     <td>{{$contracts->hire_rate}}</td>
                   </tr>
                  </table>
                  <br>
                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                 </div>
               </div>
             </div>
           </div>
    </td>
    <td><center>{{$contracts->start_date}}</center></td>
    <td><center>{{$contracts->end_date}}</center></td>
    <td><center>{{$contracts->currency}} {{$contracts->amount}}</center></td>
    <td><center>{{$contracts->rate}}</center></td>
    @if($contracts->flag=='1')
    <td>Expired</td>
    @elseif($contracts->flag=='0')
    <td>Terminated</td>
    @endif
    <td>

<a href="{{ route('RenewcarRentalForm',$contracts->id) }}" title="Click to Renew Contract"><center><i class="fa fa-refresh" style="font-size:36px;"></i></center></a>

    </td>
     </tr>
     <?php
      $i=$i+1;
     ?>
    @endforeach

  </tbody>
</table>
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
@endsection
