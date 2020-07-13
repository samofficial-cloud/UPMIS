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
a.title{
  border: none;
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
            <li><a href="#"><i class="fas fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
        </ul> 
    </div>
<div class="main_content">
  <?php $i='1';
  use App\client;
  ?>
<div class="container" style="max-width: 1308px;">
  <br>
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
     <table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#3490dc; width: 5%;"><center>S/N</center></th>
      <th scope="col" style="color:#3490dc;"><center>Client Name</center></th>
      <th scope="col" style="color:#3490dc;"><center>Client Type</center></th>
      <th scope="col" style="color:#3490dc;"><center>Contract Type</center></th>
      <th scope="col" style="color:#3490dc;"><center>Phone Number</center></th>
      <th scope="col" style="color:#3490dc;"><center>Email</center></th>
      <th scope="col" style="color:#3490dc;"><center>Address</center></th>
      <th scope="col" style="color:#3490dc;"><center>Action</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($clients as $client)
    <tr>
      <td>{{$i}}.</td>
      <td>{{$client->full_name}}</td>
      <td>{{$client->type}}</td>
      <td>
        <?php $j='1';
                    $contract=client::select('contract')->where('full_name',$client->full_name)->get()?>

        <center><a data-toggle="modal" data-target="#contracts{{$client->client_id}}" role="button" aria-pressed="true" id="{{$client->client_id}}" class="btn btn-info">View</a></center>
         <div class="modal fade" id="contracts{{$client->client_id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">This Client has the Following Contracts</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                 
                    @foreach($contract as $contract)
                      <ol><li>{{$contract->contract}}</li></ol>
                    @endforeach
                  <br>
                   <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button></center>
                 </div>
               </div>
             </div>
           </div>
        </td>
      <td>{{$client->phone_number}}</td>
      <td>{{$client->email}}</td>
      <td>{{$client->address}}</td>
      <td>
        <a data-toggle="modal" data-target="#edit{{$client->client_id}}" role="button" aria-pressed="true" id="{{$client->client_id}}"><center><i class="fa fa-edit" style="font-size:30px; color: green;"></i></center></a>
         <div class="modal fade" id="edit{{$client->client_id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to edit client details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="get" action="{{ route('editclients') }}">
        {{csrf_field()}}
          <div class="form-group">
          <div class="form-wrapper">
            <label for="client_name">Client Name</label>
            <input type="text" id="client_name{{$client->client_id}}" name="client_name" class="form-control" value="{{$client->full_name}}" readonly="">
          </div>
        </div>
        <br>

        <div class="form-group">
          <div class="form-wrapper">
            <label for="client_type">Client Type</label>
            <input type="text" id="client_type{{$client->client_id}}" name="client_type" class="form-control" value="{{$client->type}}" readonly="">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="phone_number">Phone Number</label>
            <input type="text" id="phone_number{{$client->client_id}}" name="phone_number" class="form-control" value="{{$client->phone_number}}" required="">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="email">Email</label>
            <input type="text" id="email{{$client->client_id}}" name="email" class="form-control" value="{{$client->email}}" required="" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
          </div>
        </div>
<br>

<div class="form-group">
          <div class="form-wrapper">
            <label for="address">Address</label>
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
      </td>
    </tr>
    <?php $i=$i+1;?>
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