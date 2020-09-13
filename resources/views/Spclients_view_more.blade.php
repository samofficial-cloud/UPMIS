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


            <li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
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
    <h2><center>{{$clientname}} Details</center></h2>
    <div class="card">
       <div class="card-body">
        <b><h3>Client Details</h3></b>
    <hr>
    <table style="font-size: 18px;width:40%" id="t_id">
      @foreach($details as $details)
      <tr>
        <td style="width: 15%">Client Name</td>
        <td style="width: 20%">{{$details->full_name}}</td>
      </tr>
      <tr>
        <td>Client Type</td>
        <td>{{$details->type}}</td>
      </tr>
      <tr>
        <td>Address</td>
        <td>{{$details->address}}</td>
      </tr>
      <tr>
        <td>Phone Number</td>
        <td>{{$details->phone_number}}</td>
      </tr>
      <tr>
        <td>Email</td>
        <td>{{$details->email}}</td>
      </tr>
      @endforeach
    </table>
       </div>
     </div>
    <br>
     <div class="card">
       <div class="card-body">
        <b><h3>Contract Details</h3></b>
    <hr>
    <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
        <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
        <th scope="col" style="color:#3490dc;"><center>Contract Id</center></th>
        <th scope="col" style="color:#3490dc;"><center>Space Id</center></th>
        <th scope="col" style="color:#3490dc;"><center>Amount</center></th>
       <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
       <th scope="col"  style="color:#3490dc;"><center>Payment Cycle</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Start Date</center></th>
          <th scope="col"  style="color:#3490dc;"><center>End Date</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Escalation Rate</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($contracts as $var)
          <tr>
            <td class="counterCell text-center"></td>
            <td><center>{{$var->contract_id}}</center></td>
            <td><a class="link_style" data-toggle="modal" data-target="#space_id{{$var->contract_id}}" style="color: blue !important; text-decoration: underline !important;  cursor: pointer;" aria-pressed="true"><center>{{$var->space_id_contract}}</center></a>
                  <div class="modal fade" id="space_id{{$var->contract_id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">{{$var->space_id_contract}} Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                  <table style="width: 100%">
                                      <tr>
                                          <td>Space Id:</td>
                                          <td>{{$var->space_id}}</td>
                                      </tr>

                                      <tr>
                                          <td>Space Type :</td>
                                          <td>{{$var->space_type}}</td>
                                      </tr>
                                      <tr>
                                          <td>Location:</td>
                                          <td>{{$var->location}}</td>
                                      </tr>
                                      <tr>
                                          <td>Size (SQM):</td>
                                          <td>{{$var->size}}</td>
                                      </tr>

                                      <tr>
                                          <td>Rent price guide:</td>
                                          <td>

                                              @if($var->rent_price_guide_from==null)
                                                N/A
                                              @else
                                                {{$var->rent_price_guide_currency}} {{number_format($var->rent_price_guide_from)}} - {{number_format($var->rent_price_guide_to)}}
                                              @endif

                                              </td>
                                      </tr>
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                          </div>
                      </div>
                  </div>
              </td>
            <td><center>{{number_format($var->amount)}}</center></td>
            <td><center>{{$var->currency}}</center></td>
            <td><center>{{$var->payment_cycle}}</center></td>
            <td><center>{{date('d/m/Y',strtotime($var->start_date))}}</center></td>
            <td><center>{{date('d/m/Y',strtotime($var->end_date))}}</center></td>
            <td><center>{{$var->escalation_rate}}</center></td>
            <td><center>
              @if($var->contract_status==0 or $var->end_date<date('Y-m-d'))
               <a href="{{ route('renew_space_contract_form',$var->contract_id) }}" title="Click to Renew Contract"><center><i class="fa fa-refresh" style="font-size:36px;"></i></center></a>
              @else
                    <a data-toggle="modal" data-target="#terminate{{$var->contract_id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
                    <a href="/edit_space_contract/{{$var->contract_id}}" ><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>

                    <div class="modal fade" id="terminate{{$var->contract_id}}" role="dialog">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                        <b><h5 class="modal-title">Are you sure you want to terminate {{$var->full_name}}'s contract for space id {{$var->space_id_contract}}?</h5></b>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <form method="get" action="{{ route('terminate_space_contract',$var->contract_id)}}" >
                                        {{csrf_field()}}

                                        <div align="right">
                                            <button class="btn btn-primary" type="submit">Yes</button>
                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">No</button>
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
     <br>
     <div class="card">
       <div class="card-body">
        <b><h3>Invoices Details</h3></b>
        <hr>
        <table class="hover table table-striped  table-bordered" id="myTable1">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                                <th scope="col" style="color:#3490dc;"><center>Invoice Number</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>Start Date</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>End date</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>Period</center></th>
                                <th scope="col" style="color:#3490dc;"><center>Contract Id</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>Amount</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>Created Date</center></th>

                                <th scope="col"  style="color:#3490dc;"><center>Remarks</center></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($invoices as $var)
                                <tr>
                                    <td class="counterCell text-center">.</td>
                                    <td><center>{{$var->invoice_number}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                    <td><center>{{$var->period}}</center></td>
                                    <td><center>
                                            <a  style="color:blue!important;"  class="link_style" data-toggle="modal" data-target="#contract{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center>{{$var->contract_id}}</center></a>
                                            <div class="modal fade" id="contract{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Contract Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%">
                                                                <tr>
                                                                    <td>Full Name:</td>
                                                                    <td>{{$var->full_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Space Id:</td>
                                                                    <td> {{$var->space_id_contract}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Amount:</td>
                                                                    <td>{{$var->currency}}  {{number_format($var->amount)}} </td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle:</td>
                                                                    <td>{{$var->payment_cycle}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract Start Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract End Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle Start Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->programming_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle End Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->programming_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Escalation Rate:</td>
                                                                    <td>{{$var->escalation_rate}} </td>
                                                                </tr>




                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </center></td>
                                    <td><center>{{$var->currency}} {{number_format($var->amount_to_be_paid)}} </center></td>

                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                    @if($var->payment_status=='Paid')
                                    <td><center>{{$var->payment_status}}</center></td>
                                    @elseif(($var->payment_status=='Not Paid') && ($var->email_sent_status=='NOT SENT'))
                                   <td><center>{{$var->payment_status}} (Email Not Sent)</center></td>
                                   @elseif(($var->payment_status=='Not Paid') && ($var->email_sent_status=='SENT'))
                                   <td><center>{{$var->payment_status}}</center></td>
                                   @else
                                   <td></td>
                                   @endif
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
