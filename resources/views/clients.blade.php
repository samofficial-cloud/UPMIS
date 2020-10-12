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
a.title{
  border: none;
}
hr {
    margin-top: 0rem;
    margin-bottom: 2rem;
    border: 1px solid #505559;
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
            <li><a href="/user_role_management"><i class="fas fa-user-friends hvr-icon" aria-hidden="true"></i>Manage Users</a></li>
<li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
<div class="main_content">
  <?php $i='1';
  use App\client;
  ?>
<div class="container" style="max-width: 1308px;">
  <br>
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
      @if ($category=='Real Estate only' OR $category=='All')
            <button class="tablinks space_clients" onclick="openClients(event, 'space')" id="defaultOpen"><strong>Space</strong></button>
            @else
            @endif
            @if ($category=='CPTU only' OR $category=='All')
            <button class="tablinks car_clients" onclick="openClients(event, 'car')"><strong>Car Rental</strong></button>
            @else
            @endif
             @if($category=='Insurance only' OR $category=='All')
             <button class="tablinks insurance_clients" onclick="openClients(event, 'insurance')"><strong>Insurance</strong></button>
             @else
             @endif
        </div>

  <div id="space" class="tabcontent">
  <div style="width:100%; text-align: center ">
                <br>
                {{-- <h3>Space Clients</h3> --}}
            </div>
  <div class="tab2">
            <button class="tablinks2" onclick="openSpace(event, 'sp_current')" id="defaultOpen2"><strong>Active</strong></button>
            <button class="tablinks2" onclick="openSpace(event, 'Sp_previous')"><strong>Inactive</strong></button>
        </div>
        <div id="sp_current" class="tabcontent2">
    @if(Auth::user()->role=='DPDI Planner' OR Auth::user()->role=='System Administrator')
          <a class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" href="/space_contract_form">Add Client</a>
    @endif

    <center><h3><strong>Active Space Clients</strong></h3></center>
  <hr>
 <table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
  <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
  <th scope="col" style="color:#fff;"><center>Client Name</center></th>
  <th scope="col" style="color:#fff;"><center>Phone Number</center></th>
      <th scope="col" style="color:#fff;"><center>Email</center></th>
      <th scope="col" style="color:#fff;"><center>Address</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($SCclients as $client)
    <tr>
      <th scope="row" class="counterCell text-center">.</th>
      <td>{{$client->full_name}}</td>
      <td>{{$client->phone_number}}</td>
      <td>{{$client->email}}</td>
      <td>{{$client->address}}</td>
      <td><center>
         <a title="View More Details" role="button" href="{{ route('ClientViewMore',$client->client_id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc;"></i></a>
        @if(Auth::user()->role=='DPDI Planner' OR Auth::user()->role=='System Administrator')
        <a title="Edit Client Details" data-toggle="modal" data-target="#edit{{$client->client_id}}" role="button" aria-pressed="true" id="{{$client->client_id}}"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
         <div class="modal fade" id="edit{{$client->client_id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to edit client details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('editclients') }}">
        {{csrf_field()}}
          <div class="form-group">
          <div class="form-wrapper">
            <label for="client_name{{$client->client_id}}">Client Name</label>
            <input type="text" id="client_name{{$client->client_id}}" name="client_name" class="form-control" value="{{$client->full_name}}" readonly="">
          </div>
        </div>
        <br>

        <div class="form-group">
          <div class="form-wrapper">
            <label for="client_type{{$client->client_id}}">Client Type</label>
            <input type="text" id="client_type{{$client->client_id}}" name="client_type" class="form-control" value="{{$client->type}}" readonly="">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="phone_number{{$client->client_id}}">Phone Number</label>

            <input type="text" id="phone_number{{$client->client_id}}" name="phone_number" class="form-control" value="{{$client->phone_number}}" required="" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">

          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="email{{$client->client_id}}">Email</label>
            <input type="text" id="email{{$client->client_id}}" name="email" class="form-control" value="{{$client->email}}" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="address{{$client->client_id}}">Address</label>
            <input type="text" id="address{{$client->client_id}}" name="address" class="form-control" value="{{$client->address}}" required="">
          </div>
        </div>
<br>
        <input type="text" name="id" value="{{$client->client_id}}" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Submit</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
      <a title="Send Email to this Client" data-toggle="modal" data-target="#mail{{$client->client_id}}" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="mail{{$client->client_id}}" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="client_names{{$client->client_id}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="client_names{{$client->client_id}}" name="client_name" class="form-control" value="{{$client->full_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="subject{{$client->client_id}}" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="subject{{$client->client_id}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="message{{$client->client_id}}" class="col-sm-2">Message</label>
            <div class="col-sm-9">
              <textarea type="text" id="message{{$client->client_id}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment{{$client->client_id}}" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         //echo 'Select the file to upload.';
         echo Form::file('image');
         //echo Form::submit('Upload File');
         //echo Form::close();
      ?>
          </div>
        </div>
        <br>

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @endif
   </center>
      </td>
    </tr>
    <?php $i=$i+1;?>
    @endforeach
  </tbody>
</table>
</div>

 <div id="Sp_previous" class="tabcontent2">
  <br>
  <center><h3>Inactive Space Clients</h3></center>
  <hr style="margin-top: 0rem;
    margin-bottom: 2rem;
    border: 0;
    border: 1px solid #505559">
   <table class="hover table table-striped table-bordered" id="myTable1">
  <thead class="thead-dark">
    <tr>
  <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
  <th scope="col" style="color:#fff;"><center>Client Name</center></th>
  <th scope="col" style="color:#fff;"><center>Phone Number</center></th>
      <th scope="col" style="color:#fff;"><center>Email</center></th>
      <th scope="col" style="color:#fff;"><center>Address</center></th>
      <th scope="col" style="color:#fff;"><center>Remarks</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($SPclients as $client)
    <tr>
     <th scope="row" class="counterCell text-center">.</th>
      <td>{{$client->full_name}}</td>
      <td>{{$client->phone_number}}</td>
      <td>{{$client->email}}</td>
      <td>{{$client->address}}</td>
      @if($client->contract_status==0)
      <td>Terminated</td>
      @else
      <td>Expired</td>
      @endif
      <td><center>
         <a title="View More Details" role="button" href="{{ route('ClientViewMore',$client->client_id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc;"></i></a>
          @if(Auth::user()->role=='DPDI Planner' OR Auth::user()->role=='System Administrator')
        <a title="Send Email to this Client" data-toggle="modal" data-target="#mail{{$client->client_id}}" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="mail{{$client->client_id}}" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="client_names{{$client->client_id}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="client_names{{$client->client_id}}" name="client_name" class="form-control" value="{{$client->full_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="subject{{$client->client_id}}" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="subject{{$client->client_id}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="message{{$client->client_id}}" class="col-sm-2">Message</label>
            <div class="col-sm-9">
              <textarea type="text" id="message{{$client->client_id}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment{{$client->client_id}}" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         //echo 'Select the file to upload.';
         echo Form::file('image');
         //echo Form::submit('Upload File');
         //echo Form::close();
      ?>
          </div>
        </div>
        <br>

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @endif
   </center>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>

<div id="car" class="tabcontent">
  <br>
<center><h3><strong>CPTU Clients</strong></h3></center>
<hr>
@if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
<a class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" href="{{ route('carRentalForm') }}">Add Client</a>
    @endif
<table class="hover table table-striped table-bordered" id="myTable2">
  <thead class="thead-dark">
    <tr>
  <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
  <th scope="col" style="color:#fff;"><center>Client Name</center></th>
  <th scope="col" style="color:#fff;"><center>Cost Center</center></th>
  <th scope="col" style="color:#fff;"><center>Email</center></th>
 {{--  <th scope="col" style="color:#fff;"><center>Trip Date</center></th> --}}
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($carclients as $client)
    <tr>
      <th scope="row" class="counterCell text-center">.</th>
      <td>{{$client->fullName}}</td>
      <td><center>{{$client->cost_centre}}</center></td>
      <td>{{$client->email}}</td>
      {{-- <td><center>{{date("d/m/Y",strtotime($client->start_date))}} - {{date("d/m/Y",strtotime($client->end_date))}}</center></td> --}}
      <td><center>
        <a title="View More Details" role="button" href="{{ route('CarClientsViewMore',[$client->fullName,$client->email,$client->cost_centre])}}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
        @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
        <a title="Edit Client Details" data-toggle="modal" data-target="#Caredit{{$i}}" role="button" aria-pressed="true" id="{{$i}}"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
         <div class="modal fade" id="Caredit{{$i}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to edit client details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('editCarclients') }}">
        {{csrf_field()}}
          <div class="form-group">
          <div class="form-wrapper">
            <label for="carclient_name{{$i}}">Client Name</label>
            <input type="text" id="carclient_name{{$i}}" name="client_name" class="form-control" value="{{$client->fullName}}" readonly="">
          </div>
        </div>
        <br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="Caremail{{$i}}">Email</label>
            <input type="text" id="Caremail{{$i}}" name="email" class="form-control" value="{{$client->email}}" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="Carcentre{{$i}}">Cost Centre</label>
            <input type="text" id="Carcentre{{$i}}" name="cost_centre" class="form-control" value="{{$client->cost_centre}}" required="">
          </div>
        </div>
<br>
<input type="text" name="Caremail" value="{{$client->email}}" hidden="">
<input type="text" name="Carcostcentre" value="{{$client->cost_centre}}" hidden="">
<input type="text" name="Carfullname" value="{{$client->fullName}}" hidden="">

     <div align="right">
  <button class="btn btn-primary" type="submit">Submit</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>

        <a title="Send Email to this Client" data-toggle="modal" data-target="#carmail{{$i}}" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="carmail{{$i}}" role="dialog">
              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="carclient_names{{$i}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="carclient_names{{$i}}" name="client_name" class="form-control" value="{{$client->fullName}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="carsubject{{$i}}" class="col-sm-2">Subject</label>
            <div class="col-sm-9">
            <input type="text" id="carsubject{{$i}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="carmessage{{$i}}" class="col-sm-2">Message</label>
            <div class="col-sm-9">
              <textarea type="text" id="carmessage{{$i}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="carattachment{{$i}}" class="col-sm-3">Attachments</label>
            <div class="col-sm-8">
              <?php
         echo Form::open(array('url' => '/uploadfile','files'=>'true'));
         echo Form::file('image');
      ?>
          </div>
        </div>
        <br>

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @endif
   </center>
      </td>
    </tr>
    <?php $i=$i+1;?>
    @endforeach
  </tbody>
</table>
</div>

<div id="insurance" class="tabcontent">
  <br>
 <center><h3><strong>Insurance Clients</strong></h3></center>
 <hr>
  @if(Auth::user()->role=='Insurance Officer' OR Auth::user()->role=='System Administrator')
  <a class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" href="/insurance_contract_form">Add Client</a>
    @endif
<table class="hover table table-striped table-bordered" id="myTable3">
  <thead class="thead-dark">
    <tr>
  <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
  <th scope="col" style="color:#fff;"><center>Client Name</center></th>
   <th scope="col" style="color:#fff;"><center>Vehicle Reg No</center></th>
  <th scope="col" style="color:#fff;"><center>Principal</center></th>
<th scope="col"  style="color:#fff;"><center>Insurance Type</center></th>
      <th scope="col" style="color:#fff;"><center>Amount</center></th>
      <th scope="col"  style="color:#fff;"><center>Date</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($insuranceclients as $client)
    <tr>
      <th scope="row" class="counterCell text-center">.</th>
      <td>{{$client->full_name}}</td>
      <td>{{$client->vehicle_registration_no}}</td>
      <td>{{ucfirst(strtolower($client->principal))}}</td>
      <td>{{ucfirst(strtolower($client->insurance_type))}}</td>
      <td>{{number_format($client->sum_insured)}}</td>
      <td><center>{{date("d/m/Y",strtotime($client->commission_date))}} - {{date("d/m/Y",strtotime($client->end_date))}}</center></td>
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
    window.onload=function(){
            <?php $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>
             var category={!! json_encode($category) !!}
            if (category=='Real Estate only' || category=='All') {
            $(".insurance_clients").removeClass("defaultContract");
            $(".car_clients").removeClass("defaultContract");
            $('.space_clients').addClass('defaultContract');
            }


            else if (category=='CPTU only' || category=='All') {
               $(".space_clients").removeClass("defaultContract");
              $(".insurance_clients").removeClass("defaultContract");
              $('.car_clients').addClass('defaultContract');
            }


            else if (category=='Insurance only' || category=='All') {
                $(".space_clients").removeClass("defaultContract");
            $(".car_clients").removeClass("defaultContract");
            $('.insurance_clients').addClass('defaultContract');
            }
            else{

            }

        document.querySelector('.defaultContract').click();

    };
</script>
<script type="text/javascript">

  function openClients(evt, evtName) {
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

  function openSpace(evt, evtName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent2");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks2");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(evtName).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen2").click();
</script>
<script type="text/javascript">
  $(document).ready(function(){
  var table = $('#myTable').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );

  var table = $('#myTable1').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
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
