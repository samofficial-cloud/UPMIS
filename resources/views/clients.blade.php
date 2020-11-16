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
.dropdown-menu input {
   margin-right: 10px;
}
.form-inline .form-check {
  justify-content: left;
  padding-left: 10px;
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
  <?php $i='1';
  $k=1;
  $j=1;
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
            <button class="tablinks space_clients" onclick="openClients(event, 'space')" id="defaultOpen"><strong>Space Clients</strong></button>
            @else
            @endif
            @if ($category=='CPTU only' OR $category=='All')
            <button class="tablinks car_clients" onclick="openClients(event, 'car')"><strong>Car Rental Clients</strong></button>
            @else
            @endif
             @if($category=='Insurance only' OR $category=='All')
             <button class="tablinks insurance_clients" onclick="openClients(event, 'insurance')"><strong>Insurance Clients</strong></button>
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
          <br>
    @if(Auth::user()->role=='DPDI Planner' OR Auth::user()->role=='System Administrator')
          <a class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" href="/space_contract_form">Add Client</a>

    <a title="Send email to selected clients" href="#" id="asp_btn_mail" class="btn btn-info btn-sm" data-toggle="modal" data-target="#asp_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="asp_mail" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="asp_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="asp_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="asp_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>    
        
        <div class="form-group row">
            <label for="asp_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label></label>
            <div class="col-sm-9">
            <input type="text" id="asp_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="asp_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="asp_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="asp_message" class="col-sm-2">Body<span style="color: red;">*</span></label></label>
            <div class="col-sm-9">
              <textarea type="text" id="asp_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="asp_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="asp_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM" readonly="">
          </div>
        </div>
        <br>

         <input type="text" name="type" value="space" hidden="">

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
            <label for="phone_number{{$client->client_id}}">Phone Number<span style="color: red;">*</span></label>

            <input type="text" id="phone_number{{$client->client_id}}" name="phone_number" class="form-control" value="{{$client->phone_number}}" required="" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">

          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="email{{$client->client_id}}">Email<span style="color: red;">*</span></label>
            <input type="text" id="email{{$client->client_id}}" name="email" class="form-control" value="{{$client->email}}" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="address{{$client->client_id}}">Address<span style="color: red;">*</span></label>
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
     @if($client->email!='')
      <a title="Send Email to this Client" data-toggle="modal" data-target="#mail{{$client->client_id}}" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="mail{{$client->client_id}}" role="dialog">
              <div class="modal-dialog  modal-lg" role="document">
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
            <label for="subject{{$client->client_id}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="subject{{$client->client_id}}" name="subject" class="form-control" value="" required="" >
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="greetings{{$client->client_id}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="greetings{{$client->client_id}}" name="greetings" class="form-control" value="Dear {{$client->full_name}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="message{{$client->client_id}}" class="col-sm-2">Body<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="message{{$client->client_id}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment{{$client->client_id}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" name="filenames[]" class="myfrm form-control" multiple="">
              <span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span>
          </div>
        </div>
        <br>

         <input type="text" name="type" value="space" hidden="">

         <div class="form-group row">
            <label for="closing{{$client->client_id}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="closing{{$client->client_id}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM" readonly="">
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
     @else
     <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
     @endif
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
  @if(Auth::user()->role=='DPDI Planner' OR Auth::user()->role=='System Administrator')
          <a class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" href="/space_contract_form">Add Client</a>

    <a title="Send email to selected clients" href="#" id="btn_mail" class="btn btn-info btn-sm" data-toggle="modal" data-target="#mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="mail" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="ina_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="ina_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>

        <div class="form-group row">
            <label for="inasp_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="inasp_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

            <div class="form-group row">
            <label for="inasp_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="inasp_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>
        
        

        <div class="form-group row">
            <label for="inasp_message" class="col-sm-2">Body<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="inasp_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="inasp_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="inasp_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center> 
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="inasp_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="inasp_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="space" hidden="">

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
  <center><h3><strong>Inactive Space Clients</strong></h3></center>
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
            <label for="inasp_client_name{{$client->client_id}}">Client Name</label>
            <input type="text" id="inasp_client_name{{$client->client_id}}" name="client_name" class="form-control" value="{{$client->full_name}}" readonly="">
          </div>
        </div>
        <br>

        <div class="form-group">
          <div class="form-wrapper">
            <label for="inasp_client_type{{$client->client_id}}">Client Type</label>
            <input type="text" id="inasp_client_type{{$client->client_id}}" name="client_type" class="form-control" value="{{$client->type}}" readonly="">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="inasp_phone_number{{$client->client_id}}">Phone Number<span style="color: red;">*</span></label>

            <input type="text" id="inasp_phone_number{{$client->client_id}}" name="phone_number" class="form-control" value="{{$client->phone_number}}" required="" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">

          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="inasp_email{{$client->client_id}}">Email<span style="color: red;">*</span></label>
            <input type="text" id="inasp_email{{$client->client_id}}" name="email" class="form-control" value="{{$client->email}}" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="inasp_address{{$client->client_id}}">Address<span style="color: red;">*</span></label>
            <input type="text" id="inasp_address{{$client->client_id}}" name="address" class="form-control" value="{{$client->address}}" required="">
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
     @if($client->email!='')

        <a title="Send Email to this Client" data-toggle="modal" data-target="#mail{{$client->client_id}}" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="mail{{$client->client_id}}" role="dialog">


              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="inasp_client_names{{$client->client_id}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="inasp_client_names{{$client->client_id}}" name="client_name" class="form-control" value="{{$client->full_name}}" readonly="">
          </div>
        </div>
        <br>
      
        <div class="form-group row">
            <label for="inasp_subject{{$client->client_id}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="inasp_subject{{$client->client_id}}" name="subject" class="form-control" value="" required="" >
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="inasp_greetings{{$client->client_id}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="inasp_greetings{{$client->client_id}}" name="greetings" class="form-control" value="Dear {{$client->full_name}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="inasp_message{{$client->client_id}}" class="col-sm-2">Body<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="inasp_message{{$client->client_id}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="inasp_attachment{{$client->client_id}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="inasp_attachment{{$client->client_id}}" name="filenames[]" class="myfrm form-control" multiple="">
              <span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span> 
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="inasp_closing{{$client->client_id}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="inasp_closing{{$client->client_id}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="space" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @else
     <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
     @endif
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
     <div class="tab2">
            <button class="cptulink" onclick="opencptu(event, 'cptu_active')" id="defaultOpencptu"><strong>Active</strong></button>
            <button class="cptulink" onclick="opencptu(event, 'cptu_inactive')"><strong>Inactive</strong></button>
    </div>
     <div id="cptu_active" class="cptucontent">
    <br>
    @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
<a class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" href="{{ route('carRentalForm') }}">Add Client</a>

     <a title="Send email to selected clients" href="#" id="acp_btn_mail" class="btn btn-info btn-sm" data-toggle="modal" data-target="#acp_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="acp_mail" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="acp_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="acp_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="acp_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>    
        
        <div class="form-group row">
            <label for="acp_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="acp_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="acp_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="acp_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="acp_message" class="col-sm-2">Body<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="acp_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="acp_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="acp_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="acp_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="acp_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="car" hidden="">

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
    <center><h3><strong>Active CPTU Clients</strong></h3></center>
<hr>
    <table class="hover table table-striped table-bordered" id="myTable2">
  <thead class="thead-dark">
    <tr>
  <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
  <th scope="col" style="color:#fff;"><center>Client Name</center></th>
  <th scope="col" style="color:#fff;"><center>Cost Center</center></th>
  <th scope="col" style="color:#fff;"><center>Department</center></th>
  <th scope="col" style="color:#fff;"><center>Email</center></th>
 {{--  <th scope="col" style="color:#fff;"><center>Trip Date</center></th> --}}
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($active_carclients as $client)
    <tr>
      <th scope="row" class="counterCell text-center">.</th>
      <td>{{$client->fullName}}</td>
      <td><center>{{$client->cost_centre}}</center></td>
      <td><center>{{$client->faculty}}</center></td>
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
            <label for="Caremail{{$i}}">Email<span style="color: red;">*</span></label>
            <input type="text" id="Caremail{{$i}}" name="email" class="form-control" value="{{$client->email}}" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="Carcentre{{$i}}">Cost Centre<span style="color: red;">*</span></label>
            <input type="text" id="Carcentre{{$i}}" name="cost_centre" class="form-control" value="{{$client->cost_centre}}" required="" onkeypress="if((this.value.length<8)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
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
        @if($client->email!='')
        <a title="Send Email to this Client" data-toggle="modal" data-target="#carmail{{$i}}" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="carmail{{$i}}" role="dialog">
              <div class="modal-dialog  modal-lg" role="document">
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
            <label for="carsubject{{$i}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="carsubject{{$i}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="cargreetings{{$i}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="cargreetings{{$i}}" name="greetings" class="form-control" value="Dear {{$client->fullName}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="carmessage{{$i}}" class="col-sm-2">Body<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="carmessage{{$i}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="carattachment{{$i}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="carattachment{{$i}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="carclosing{{$i}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="carclosing{{$i}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
 <input type="text" name="type" value="car" hidden="">
        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @else
     <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
     @endif
     @endif
   </center>
      </td>
    </tr>
    <?php $i=$i+1;?>
    @endforeach
  </tbody>
</table>
  </div>
  <div id="cptu_inactive" class="cptucontent">
    <br>
    @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
<a class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" href="{{ route('carRentalForm') }}">Add Client</a>

     <a title="Send email to selected clients" href="#" id="incp_btn_mail" class="btn btn-info btn-sm" data-toggle="modal" data-target="#incp_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="incp_mail" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="incp_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="incp_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="incp_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>    
        
        <div class="form-group row">
            <label for="incp_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="incp_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="incp_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="incp_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="incp_message" class="col-sm-2">Body<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="incp_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="incp_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="incp_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
         <input type="text" name="type" value="car" hidden="">
        <div class="form-group row">
            <label for="incp_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="incp_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
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
    <center><h3><strong>Inactive CPTU Clients</strong></h3></center>
<hr>
    <table class="hover table table-striped table-bordered" id="myTable5">
  <thead class="thead-dark">
    <tr>
  <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
  <th scope="col" style="color:#fff;"><center>Client Name</center></th>
  <th scope="col" style="color:#fff;"><center>Cost Center</center></th>
  <th scope="col" style="color:#fff;"><center>Department</center></th>
  <th scope="col" style="color:#fff;"><center>Email</center></th>
 {{--  <th scope="col" style="color:#fff;"><center>Trip Date</center></th> --}}
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($inactive_carclients as $client)
    <tr>
      <th scope="row" class="counterCell text-center">.</th>
      <td>{{$client->fullName}}</td>
      <td><center>{{$client->cost_centre}}</center></td>
      <td>{{$client->faculty}}</td>
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
            <label for="Caremail{{$i}}">Email<span style="color: red;">*</span></label>
            <input type="text" id="Caremail{{$i}}" name="email" class="form-control" value="{{$client->email}}" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="Carcentre{{$i}}">Cost Centre<span style="color: red;">*</span></label>
            <input type="text" id="Carcentre{{$i}}" name="cost_centre" class="form-control" value="{{$client->cost_centre}}" required="" onkeypress="if((this.value.length<8)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
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
        @if($client->email!='')
        <a title="Send Email to this Client" data-toggle="modal" data-target="#carmail{{$i}}" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="carmail{{$i}}" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
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
            <label for="carsubject{{$i}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="carsubject{{$i}}" name="subject" class="form-control" value="" required="" >
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="cargreetings{{$i}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="cargreetings{{$i}}" name="greetings" class="form-control" value="Dear {{$client->fullName}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="carmessage{{$i}}" class="col-sm-2">Body<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="carmessage{{$i}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="carattachment{{$i}}" class="col-sm-3">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="carattachment{{$i}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="carclosing{{$i}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="carclosing{{$i}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="car" hidden="">
        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @else
     <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
     @endif
     @endif
   </center>
      </td>
    </tr>
    <?php $i=$i+1;?>
    @endforeach
  </tbody>
</table>
  </div>
</div>

<div id="insurance" class="tabcontent" >
  <br>
  <div class="tab2">
            <button class="udialink" onclick="openInsurance(event, 'udia_current')" id="defaultOpenIns"><strong>Active</strong></button>
            <button class="udialink" onclick="openInsurance(event, 'udia_previous')"><strong>Inactive</strong></button>
  </div>

  <div id="udia_current" class="udiacontent" >
  <br>
  @if(Auth::user()->role=='Insurance Officer' OR Auth::user()->role=='System Administrator')
  <a class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" href="/insurance_contract_form">Add Client</a>

     <a title="Send email to selected clients" href="#" id="aia_btn_mail" class="btn btn-info btn-sm" data-toggle="modal" data-target="#aia_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="aia_mail" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="aia_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="aia_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="aia_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>    
        
        <div class="form-group row">
            <label for="aia_subject" class="col-sm-2">Subject<span style="color:red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="aia_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="aia_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="aia_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="aia_message" class="col-sm-2">Body<span style="color:red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="aia_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="aia_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="aia_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="aia_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="aia_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
 <input type="text" name="type" value="udia" hidden="">
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
 <center><h3><strong>Active Insurance Clients</strong></h3></center>
 <hr>
<table class="hover table table-striped table-bordered" id="myTable3">
  <thead class="thead-dark">
    <tr>
  <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
  <th scope="col" style="color:#fff;"><center>Client Name</center></th>
   <th scope="col" style="color:#fff;"><center>Phone Number</center></th>
  <th scope="col" style="color:#fff;"><center>Email</center></th>
  <th scope="col"  style="color:#fff;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($active_insuranceclients as $client)
    <tr>
      <th scope="row" class="counterCell text-center">.</th>
      <td>{{$client->full_name}}</td>
      <td>{{$client->phone_number}}</td>
      {{-- <td>{{ucfirst(strtolower($client->principal))}}</td>
      <td>{{ucfirst(strtolower($client->insurance_type))}}</td>
      <td>{{number_format($client->sum_insured)}}</td>
      <td><center>{{date("d/m/Y",strtotime($client->commission_date))}} - {{date("d/m/Y",strtotime($client->end_date))}}</center></td> --}}
      <td>{{$client->email}}</td>
      <td>
        <center>
         <a title="View More Details" role="button" href="{{ route('InsuranceClientsViewMore',[$client->full_name,$client->email,$client->phone_number])}}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc;"></i></a>
        @if(Auth::user()->role=='Insurance Officer' OR Auth::user()->role=='System Administrator')
        <a title="Edit Client Details" data-toggle="modal" data-target="#editIns{{$j}}" role="button" aria-pressed="true" id="{{$j}}"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
         <div class="modal fade" id="editIns{{$j}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to edit client details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('editInsclients') }}">
        {{csrf_field()}}
          <div class="form-group">
          <div class="form-wrapper">
            <label for="client_name{{$j}}">Client Name</label>
            <input type="text" id="udia_act_name{{$j}}" name="client_name" class="form-control" value="{{$client->full_name}}" readonly="">
          </div>
        </div>

        
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="phone_number{{$j}}">Phone Number<span style="color:red;">*</span></label>

            <input type="text" id="udia_act_number{{$j}}" name="phone_number" class="form-control" value="{{$client->phone_number}}" required="" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">

          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="email{{$j}}">Email<span style="color:red;">*</span></label>
            <input type="text" id="udia_act_email{{$j}}" name="email" class="form-control" value="{{$client->email}}" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
          </div>
        </div>
<br>


<br>
        <input type="text" name="id" value="{{$j}}" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Submit</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @if($client->email!='')
      <a title="Send Email to this Client" data-toggle="modal" data-target="#mailIns{{$j}}" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="mailIns{{$j}}" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="client_names{{$j}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="udia_act_names{{$j}}" name="client_name" class="form-control" value="{{$client->full_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="udia_subject{{$j}}" class="col-sm-2">Subject<span style="color:red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="udia_subject{{$j}}" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="udia_greetings{{$j}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="udia_greetings{{$j}}" name="greetings" class="form-control" value="Dear {{$client->full_name}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="udia_message{{$j}}" class="col-sm-2">Message<span style="color:red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="udia_message{{$j}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="udia_attachment{{$j}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="udia_attachment{{$j}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="udia_closing{{$j}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="udia_closing{{$j}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
 <input type="text" name="type" value="udia" hidden="">
        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @else
     <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
     @endif
     @endif
   </center>
      </td>
    </tr>
    <?php $j=$j+1; ?>
    @endforeach
  </tbody>
</table>
</div>
  <div id="udia_previous" class="udiacontent" >
  <br>
  @if(Auth::user()->role=='Insurance Officer' OR Auth::user()->role=='System Administrator')
  <a class="btn btn-success btn-sm" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;" href="/insurance_contract_form">Add Client</a>

     <a title="Send email to selected clients" href="#" id="inia_btn_mail" class="btn btn-info btn-sm" data-toggle="modal" data-target="#inia_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="inia_mail" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="inia_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="inia_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="inia_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>    
        
        <div class="form-group row">
            <label for="inia_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="inia_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="inia_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="inia_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="inia_message" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="inia_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="inia_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="inia_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="inia_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="inia_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="udia" hidden="">

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
 <center><h3><strong>Inactive Insurance Clients</strong></h3></center>
 <hr>
<table class="hover table table-striped table-bordered" id="myTable4">
  <thead class="thead-dark">
    <tr>
  <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
  <th scope="col" style="color:#fff;"><center>Client Name</center></th>
   <th scope="col" style="color:#fff;"><center>Phone Number</center></th>
  <th scope="col" style="color:#fff;"><center>Email</center></th>
  <th scope="col"  style="color:#fff;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($inactive_insuranceclients as $client)
    <tr>
      <th scope="row" class="counterCell text-center">.</th>
      <td>{{$client->full_name}}</td>
      <td>{{$client->phone_number}}</td>
      {{-- <td>{{ucfirst(strtolower($client->principal))}}</td> --}}
      <td>{{$client->email}}</td>
      <td>
        <center>
         <a title="View More Details" role="button" href="#"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc;"></i></a>
        @if(Auth::user()->role=='Insurance Officer' OR Auth::user()->role=='System Administrator')
        <a title="Edit Client Details" data-toggle="modal" data-target="#in_editIns{{$k}}" role="button" aria-pressed="true" id="{{$k}}"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
         <div class="modal fade" id="in_editIns{{$k}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to edit client details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('editInsclients') }}">
        {{csrf_field()}}
          <div class="form-group">
          <div class="form-wrapper">
            <label for="udia_inact_name{{$k}}">Client Name</label>
            <input type="text" id="udia_inact_name{{$k}}" name="client_name" class="form-control" value="{{$client->full_name}}" readonly="">
          </div>
        </div>

        {{-- <div class="form-group">
          <div class="form-wrapper">
            <label for="client_type{{$k}}">Client Type</label>
            <input type="text" id="client_type{{$k}}" name="client_type" class="form-control" value="{{$client->type}}" readonly="">
          </div>
        </div> --}}
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="udia_inact_number{{$k}}">Phone Number<span style="color: red;">*</span></label>

            <input type="text" id="udia_inact_number{{$k}}" name="phone_number" class="form-control" value="{{$client->phone_number}}" required="" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">

          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="udia_inact_email{{$k}}">Email<span style="color: red;">*</span></label>
            <input type="text" id="udia_inact_email{{$k}}" name="email" class="form-control" value="{{$client->email}}" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
          </div>
        </div>
<br>

{{-- <div class="form-group">
          <div class="form-wrapper">
            <label for="address{{$k}}">Address</label>
            <input type="text" id="address{{$k}}" name="address" class="form-control" value="{{$client->address}}" required="">
          </div>
        </div> --}}
<br>
        <input type="text" name="id" value="{{$k}}" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Submit</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @if($client->email!='')
      <a title="Send Email to this Client" data-toggle="modal" data-target="#in_mailIns{{$k}}" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
      <div class="modal fade" id="in_mailIns{{$k}}" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="udia_inact_names{{$k}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="udia_inact_names{{$k}}" name="client_name" class="form-control" value="{{$client->full_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="udia_inact_subject{{$k}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="udia_inact_subject{{$k}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="udia_inact_greetings{{$k}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="udia_inact_greetings{{$k}}" name="greetings" class="form-control" value="Dear {{$client->full_name}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="udia_inact_message{{$k}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="udia_inact_message{{$k}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="udia_inact_attachment{{$k}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="inia_attachment{{$k}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="udia_inact_closing{{$k}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="udia_inact_closing{{$k}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
 <input type="text" name="type" value="udia" hidden="">
        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @else
     <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></a>
     @endif
     @endif
   </center>
      </td>
    </tr>
    <?php $k=$k+1;?>
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

  function opencptu(evt, evtName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("cptucontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("cptulink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(evtName).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpencptu").click();
</script>

<script type="text/javascript">

  function openInsurance(evt, evtName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("udiacontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("udialink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(evtName).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpenIns").click();
</script>
<script>
function myFunction() {
  alert("This client has no email.");
}
</script>
<script type="text/javascript">
  $(document).ready(function(){
     // document.getElementById("dropdowncon").addEventListener('click', function (event) { 
     //        //alert("click outside"); 
     //        event.stopPropagation(); 
     //    }); 
  var table0 = $('#myTable').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );

  var table = $('#myTable1').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );

  var table2 = $('#myTable2').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );

var table3 = $('#myTable3').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );

var table4 = $('#myTable4').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );

var table5 = $('#myTable5').DataTable( {
        dom: '<"top"fl>rt<"bottom"pi>'
    } );


    var table6 = $('#myTable').DataTable();
 
    $('#myTable tbody').on( 'click', 'tr', function () {
      document.getElementById("asp_par_names").innerHTML="";
      document.getElementById("asp_greetings").value="Dear ";
      var emailz = $(this).find('td:eq(2)').text();
      if(emailz==""){

      }
      else{

        $(this).toggleClass('selected');
         var count6=table6.rows('.selected').data().length +' row(s) selected';
      if(count6>'2'){
       $('#asp_btn_mail').show();
      }
      else{
        $('#asp_btn_mail').hide();
      }
    }
    });

    
  
     $('#asp_btn_mail').click( function () {
      document.getElementById("asp_par_names").innerHTML="";
      document.getElementById("asp_greetings").value="Dear ";
        var datas6 = table6.rows('.selected').data();
        var result6 = [];
        for (var i = 0; i < datas6.length; i++)
        {
                result6.push(datas6[i][1]);
        }

        $('#asp_client_names').val(result6).toString();
        
        var content6 = document.getElementById("asp_par_names");
        for(var i=0; i< result6.length;i++){
          if(i==(result6.length-1)){
            content6.innerHTML += result6[i]+ '.';
          }
          else{
            content6.innerHTML += result6[i] + ', ';
          }
          
        }

        var salutation6 = document.getElementById("asp_greetings");
        for(var i=0; i< result6.length;i++){
          if(i==(result6.length-1)){
            salutation6.value += result6[i]+ '.';
          }
          else{
            salutation6.value += result6[i] + ', ';
          }
          
        }
         //console.log(result);
    } );

   
    var table1 = $('#myTable1').DataTable();
 
    $('#myTable1 tbody').on( 'click', 'tr', function () {
      document.getElementById("par_names").innerHTML="";
      document.getElementById("inasp_greetings").value="Dear ";
      var emailz1 = $(this).find('td:eq(2)').text();
      if(emailz1==''){

      }
      else{

        $(this).toggleClass('selected');
         var count=table1.rows('.selected').data().length +' row(s) selected';
         console.log(count);
    if(count>'2'){
      $('#btn_mail').show();
      console.log("show");
    }
    else{
      $('#btn_mail').hide();
      console.log("hide");
    }
  }
    } );

    
  
     $('#btn_mail').click( function () {
      document.getElementById("par_names").innerHTML="";
      document.getElementById("inasp_greetings").value="Dear ";
        var datas = table1.rows('.selected').data();
        var result = [];
        for (var i = 0; i < datas.length; i++)
        {
                result.push(datas[i][1]);
        }

        $('#client_names').val(result).toString();
        
        var content = document.getElementById("par_names");
        for(var i=0; i< result.length;i++){
          if(i==(result.length-1)){
            content.innerHTML += result[i]+ '.';
          }
          else{
            content.innerHTML += result[i] + ', ';
          }
          
        }

        var salutation7 = document.getElementById("inasp_greetings");
        for(var i=0; i< result.length;i++){
          if(i==(result.length-1)){
            salutation7.value += result[i]+ '.';
          }
          else{
            salutation7.value += result[i] + ', ';
          }
          
        }
         //console.log(result);
    } );


     var table7 = $('#myTable2').DataTable();
 
    $('#myTable2 tbody').on( 'click', 'tr', function () {
      document.getElementById("acp_par_names").innerHTML="";
      document.getElementById("acp_greetings").value="Dear ";
      var emailz2 = $(this).find('td:eq(3)').text();
      if(emailz2==''){

      }
      else{
        $(this).toggleClass('selected');
        var count7=table7.rows('.selected').data().length +' row(s) selected';
          if(count7>'2'){
            $('#acp_btn_mail').show();
          }
          else{
            $('#acp_btn_mail').hide();
          }
  }
    });

    
  
     $('#acp_btn_mail').click( function () {
      document.getElementById("acp_par_names").innerHTML="";
      document.getElementById("acp_greetings").value="Dear ";
        var datas7 = table7.rows('.selected').data();
        var result7 = [];
        for (var i = 0; i < datas7.length; i++)
        {
                result7.push(datas7[i][1]);
        }

        $('#acp_client_names').val(result7).toString();
        
        var content7 = document.getElementById("acp_par_names");
        for(var i=0; i< result7.length;i++){
          if(i==(result7.length-1)){
            content7.innerHTML += result7[i]+ '.';
          }
          else{
            content7.innerHTML += result7[i] + ', ';
          }
          
        }

        var salutation8 = document.getElementById("acp_greetings");
        for(var i=0; i< result7.length;i++){
          if(i==(result7.length-1)){
            salutation8.value += result7[i]+ '.';
          }
          else{
            salutation8.value += result7[i] + ', ';
          }
          
        }
         //console.log(result);
    } );


     var table8 = $('#myTable5').DataTable();
 
    $('#myTable5 tbody').on( 'click', 'tr', function () {
      document.getElementById("incp_par_names").innerHTML="";
      document.getElementById("incp_greetings").value="Dear ";
      var emailz3 = $(this).find('td:eq(3)').text();
      if(emailz3==''){

      }
      else{
        $(this).toggleClass('selected');
         var count8=table8.rows('.selected').data().length +' row(s) selected';
          if(count8>'2'){
            $('#incp_btn_mail').show();
          }
          else{
            $('#incp_btn_mail').hide();
          }
      }

        
    });

    
  
     $('#incp_btn_mail').click( function () {
      document.getElementById("incp_par_names").innerHTML="";
      document.getElementById("incp_greetings").value="Dear ";
        var datas8 = table8.rows('.selected').data();
        var result8 = [];
        for (var i = 0; i < datas8.length; i++)
        {
                result8.push(datas8[i][1]);
        }

        $('#incp_client_names').val(result8).toString();
        
        var content8 = document.getElementById("incp_par_names");
        for(var i=0; i< result8.length;i++){
          if(i==(result8.length-1)){
            content8.innerHTML += result8[i]+ '.';
          }
          else{
            content8.innerHTML += result8[i] + ', ';
          }
          
        }

        var salutation9 = document.getElementById("incp_greetings");
        for(var i=0; i< result8.length;i++){
          if(i==(result8.length-1)){
            salutation9.value += result8[i]+ '.';
          }
          else{
            salutation9.value += result8[i] + ', ';
          }
          
        }
         
    } );


     var table9 = $('#myTable3').DataTable();
 
    $('#myTable3 tbody').on( 'click', 'tr', function () {
      document.getElementById("aia_par_names").innerHTML="";
      document.getElementById("aia_greetings").value="Dear ";
       var emailz4 = $(this).find('td:eq(2)').text();
       if(emailz4==""){}
        else{
          $(this).toggleClass('selected');
         var count9=table9.rows('.selected').data().length +' row(s) selected';
            if(count9>'2'){
              $('#aia_btn_mail').show();
            }
            else{
              $('#aia_btn_mail').hide();
            }
        }

        
    });

    
  
     $('#aia_btn_mail').click( function () {
       document.getElementById("aia_par_names").innerHTML="";
      document.getElementById("aia_greetings").value="Dear ";
        var datas9 = table9.rows('.selected').data();
        var result9 = [];
        for (var i = 0; i < datas9.length; i++)
        {
                result9.push(datas9[i][1]);
        }

        $('#aia_client_names').val(result9).toString();
        
        var content9 = document.getElementById("aia_par_names");
        for(var i=0; i< result9.length;i++){
          if(i==(result9.length-1)){
            content9.innerHTML += result9[i]+ '.';
          }
          else{
            content9.innerHTML += result9[i] + ', ';
          }
          
        }

        var salutation10 = document.getElementById("aia_greetings");
        for(var i=0; i< result9.length;i++){
          if(i==(result9.length-1)){
            salutation10.value += result9[i]+ '.';
          }
          else{
            salutation10.value += result9[i] + ', ';
          }
          
        }
         //console.log(result);
    } );


     var table10 = $('#myTable4').DataTable();
 
    $('#myTable4 tbody').on( 'click', 'tr', function () {
      document.getElementById("inia_par_names").innerHTML="";
      document.getElementById("inia_greetings").value="Dear ";
       var emailz5 = $(this).find('td:eq(2)').text();
       if(emailz5==''){}
        else{
          $(this).toggleClass('selected');
         var count10=table10.rows('.selected').data().length +' row(s) selected';
          if(count10>'2'){
            $('#inia_btn_mail').show();
          }
          else{
            $('#inia_btn_mail').hide();
          }
        }
        
    });

    
  
     $('#inia_btn_mail').click( function () {
      document.getElementById("inia_par_names").innerHTML="";
      document.getElementById("inia_greetings").value="Dear ";
        var datas10 = table10.rows('.selected').data();
        var result10 = [];
        for (var i = 0; i < datas10.length; i++)
        {
                result10.push(datas10[i][1]);
        }

        $('#inia_client_names').val(result10).toString();
        
        var content10 = document.getElementById("inia_par_names");
        for(var i=0; i< result10.length;i++){
          if(i==(result10.length-1)){
            content10.innerHTML += result10[i]+ '.';
          }
          else{
            content10.innerHTML += result10[i] + ', ';
          }
          
        }

        var salutation11 = document.getElementById("inia_greetings");
        for(var i=0; i< result10.length;i++){
          if(i==(result10.length-1)){
            salutation11.value += result10[i]+ '.';
          }
          else{
            salutation11.value += result10[i] + ', ';
          }
          
        }
         //console.log(result);
    });

   

});


</script>
@endsection
