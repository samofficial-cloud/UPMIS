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
.tab button {
      padding: 10px 20px !important;
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


<br>
<br>

  <div class="tab">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
        </div>
<div id="inbox" class="tabcontent">
  <br>
<table>
    <thead>
      <th style="width: 16%"><center>Form Id</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
        <td><center><a href="{{ route('carRentalFormC',$inbox->id) }}">{{$inbox->id}}</a></center></td>
        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->designation}} {{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td>{{$inbox->start_date}} to {{$inbox->end_date}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div id="outbox" class="tabcontent">
  <br>
<table>
    <thead>
      <th style="width: 16%"><center>Form Id</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Form Status</center></th>
    </thead>
    <tbody>
      @foreach($outbox as $outbox)
      <tr>
        <td><center><a href="#">{{$outbox->id}}</a></center></td>
        <td><center>{{$outbox->form_initiator}}</center></td>
        <td><center>{{$outbox->designation}} {{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td>{{$outbox->start_date}} to {{$outbox->end_date}}</td>
        <td><center>{{$outbox->form_status}} Stage</center></td>
      </tr>
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
