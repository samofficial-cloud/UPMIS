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


            <?php



            $today=date('Y-m-d');

            $date=date_create($today);

            date_sub($date,date_interval_create_from_date_string("366 days"));



            ?>

            @if($category=='All')
           <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Insurance only')
          <li><a href="{{ route('home2') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Real Estate only')
          <li><a href="{{ route('home4') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Research Flats only')
          <li><a href="{{ route('home6') }}"><i class="fas fa-home active"></i>Home</a></li>
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
            <li><a href="/user_role_management"><i class="fas fa-user-friends hvr-icon" aria-hidden="true"></i>Manage Users</a></li>
<li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
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
      <tr>
        <td style="width: 15%">Client Name</td>
        <td style="width: 20%">{{$clientname}}</td>
      </tr>
      <tr>
        <td>Cost Centre</td>
        <td>{{$clientcentre}}</td>
      </tr>
      <tr>
        <td>Email</td>
        <td>{{$clientemail}}</td>
      </tr>
      {{-- <tr>
        <td>Email</td>
        <td>{{$details->email}}</td>
      </tr> --}}
    </table>
  </div>
</div>
<br>




        <div class="card">
       <div class="card-body">
        <b><h3>Contract Details</h3></b>
    <hr>

           @if(Auth::user()->role=='Transport Officer-CPTU')
               <a class="btn btn-success" href="{{ route('carRentalForm') }}" role="button" style="
    padding: 10px; margin-bottom: 5px; margin-top: 4px;">Add New Contract
               </a>
           @endif


        <div class="pt-3"> <table class="hover table table-striped table-bordered" id="myTable">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" style="color:#fff;"><center>S/N</center></th>
                    <th scope="col" style="color:#fff;"><center>Contract Id</center></th>
                    <th scope="col" style="color:#fff;"><center>Destination</center></th>
                    <th scope="col" style="color:#fff;"><center>Vehicle Reg. No</center></th>
                    <th scope="col" style="color:#fff;"><center>Date</center></th>
                    <th scope="col" style="color:#fff;"><center>Grand Total</center></th>
                </tr>
                </thead>
                <tbody>
                @foreach($contracts as $var)
                    <tr>
                        <td class="counterCell text-center">.</td>
                        <td><center>{{$var->id}}</center></td>
                        <td>{{$var->destination}}</td>
                        <td>
                            <a class="link_style" data-toggle="modal" data-target="#car_id{{$var->id}}" style="color: blue !important; text-decoration: underline !important;  cursor: pointer;" aria-pressed="true"><center>{{$var->vehicle_reg_no}}</center></a>
                            <div class="modal fade" id="car_id{{$var->id}}" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <b><h5 class="modal-title">{{$var->vehicle_reg_no}} Details.</h5></b>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <table style="width: 100%">
                                                <tr>
                                                    <td>Vehicle Model:</td>
                                                    <td>{{$var->vehicle_model}}</td>
                                                </tr>

                                                <tr>
                                                    <td>Hire Rate :</td>
                                                    <td>{{number_format($var->hire_rate)}}</td>
                                                </tr>


                                                <tr>
                                                    <td>Status:</td>
                                                    <td>{{$var->vehicle_status}}</td>
                                                </tr>
                                            </table>
                                            <br>
                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td><center>{{date("d/m/Y",strtotime($var->start_date))}} - {{date("d/m/Y",strtotime($var->end_date))}}</center></td>
                        <td>TZS {{number_format($var->grand_total)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table></div>

</div>
</div>
<br>
<div class="card">
       <div class="card-body">
        <b><h3>Invoices Details</h3></b>
        <hr>

           @if(Auth::user()->role=='Transport Officer-CPTU')
               <div style="margin-bottom: 3%;">
                   <div style="float:left;">
                       <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice_car" title="Add new car invoice" role="button" aria-pressed="true">Add New Invoice</a>
                   </div>
                   <div style="clear: both;"></div>

               </div>

               <div class="modal fade" id="new_invoice_car" role="dialog">

                   <div class="modal-dialog" role="document">
                       <div class="modal-content">
                           <div class="modal-header">
                               <b><h5 class="modal-title">Create New Car Rental Invoice</h5></b>

                               <button type="button" class="close" data-dismiss="modal">&times;</button>
                           </div>

                           <div class="modal-body">

                               <form method="post" action="{{ route('create_car_invoice_manually')}}"  id="form1" >
                                   {{csrf_field()}}

                                   <div class="form-row">


                                       <div class="form-group col-md-12">
                                           <div class="form-wrapper">
                                               <label for="">Contract ID <span style="color: red;">*</span></label>
                                               <input type="number" min="1" class="form-control" id="contract_id_car" name="contract_id" value=""  required autocomplete="off">
                                               <p style="display: none;" class="mt-2 p-1" id="car_contract_availability"></p>
                                           </div>
                                       </div>


                                       {{--                                                                    <div id="invoice_number_carDiv" style="display: none;" class="form-group col-md-12">--}}
                                       {{--                                                                        <div class="form-wrapper">--}}
                                       {{--                                                                            <label for="">Invoice number <span style="color: red;">*</span></label>--}}
                                       {{--                                                                            <input type="number" min="0" class="form-control" id="invoice_number_car" name="invoice_number" value=""  required autocomplete="off">--}}

                                       {{--                                                                        </div>--}}
                                       {{--                                                                    </div>--}}



                                       <div id="debtor_name_carDiv" style="display:none;" class="form-group col-md-12 mt-1">
                                           <div class="form-wrapper">
                                               <label for=""  >Client Full Name <span style="color: red;">*</span></label>
                                               <input type="text" class="form-control" id="debtor_name_car" name="debtor_name" readonly value="" Required autocomplete="off">
                                           </div>
                                       </div>



                                       <div id="vrn_car2Div" style="display:none;" class="form-group col-md-12 mt-1">
                                           <div class="form-wrapper">
                                               <label for=""  >Vehicle Registration Number (VRN)<span style="color: red;">*</span></label>
                                               <input type="text" class="form-control"  name="vrn" value="" required  autocomplete="off">
                                           </div>
                                       </div>



                                       <div id="debtor_address_carDiv" style="display:none;" class="form-group col-md-12 mt-1">
                                           <div class="form-wrapper">
                                               <label for=""  >Client Address <span style="color: red;">*</span></label>
                                               <input type="text" class="form-control" id="debtor_address_car" name="debtor_address" value="" Required autocomplete="off">
                                           </div>
                                       </div>

                                       {{--                                                                    <div style="display: none;" id="inc_code_carDiv" class="form-group col-md-12 mt-1">--}}
                                       {{--                                                                        <div class="form-wrapper">--}}
                                       {{--                                                                            <label for=""  >Income(Inc) Code<span style="color: red;">*</span></label>--}}
                                       {{--                                                                            <input type="text" class="form-control"  name="inc_code" value=""  Required autocomplete="off">--}}
                                       {{--                                                                        </div>--}}
                                       {{--                                                                    </div>--}}

                                       <div style="display:none;" id="invoicing_period_start_date_carDiv" class="form-group col-md-6 mt-1">
                                           <div class="form-wrapper">
                                               <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                               <input  class="flatpickr_date form-control" id="invoicing_period_start_date_car" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                           </div>
                                       </div>



                                       <div style="display:none;" id="invoicing_period_end_date_carDiv" class="form-group col-md-6 mt-1">
                                           <div class="form-wrapper">
                                               <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                               <input  class="flatpickr_date form-control" id="invoicing_period_end_date_car" name="invoicing_period_end_date" value="" Required autocomplete="off">
                                           </div>
                                       </div>



                                       <div style="display:none;" id="project_id_carDiv" class="form-group col-md-12 mt-1">
                                           <div class="form-wrapper">
                                               <label for=""  >Project ID <span style="color: red;">*</span></label>
                                               <input type="text" class="form-control" id="project_id_car" name="project_id" value="" Required autocomplete="off">
                                           </div>
                                       </div>








                                       <div id="amount_carDiv" style="display: none;"  class="form-group col-md-6 mt-1">
                                           <div class="form-wrapper">
                                               <label for="">Amount <span style="color: red;">*</span></label>
                                               <input type="number" min="20" class="form-control" id="" name="amount_to_be_paid" value="" Required  autocomplete="off">
                                           </div>
                                       </div>



                                       <div id="currency_carDiv" style="display: none;" class="form-group col-md-6 mt-1">
                                           <label>Currency <span style="color: red;">*</span></label>
                                           <div  class="form-wrapper">
                                               <select id="" class="form-control" required name="currency">
                                                   <option value="" ></option>
                                                   <option value="TZS" >TZS</option>
                                                   <option value="USD" >USD</option>
                                               </select>
                                           </div>
                                       </div>



                                       <div id="status_carDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                           <div class="form-wrapper">
                                               <label for=""  >Status <span style="color: red;">*</span></label>
                                               <input type="text" class="form-control" id="" name="status" value="" required  autocomplete="off">
                                           </div>
                                       </div>


                                       <div id="description_carDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                           <div class="form-wrapper">
                                               <label for=""  >Description <span style="color: red;">*</span></label>
                                               <input type="text" class="form-control" id="" name="description" value="" required  autocomplete="off">
                                           </div>
                                       </div>
                                       <br>






                                   </div>


                                   <div align="right">
                                       <button id="submit_car" class="btn btn-primary" type="submit">Submit</button>
                                       <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                   </div>
                               </form>









                           </div>
                       </div>
                   </div>


               </div>

           @else
               @endif


           <div class="pt-1">


               <table class="hover table table-striped  table-bordered" id="myTable1">
                   <thead class="thead-dark">
                   <tr>
                       <th scope="col" style="color:#fff;"><center>S/N</center></th>
                       <th scope="col" style="color:#fff;"><center>Invoice Number</center></th>
                       <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
                       <th scope="col"  style="color:#fff;"><center>End date</center></th>
                       {{-- <th scope="col"  style="color:#fff;"><center>Period</center></th> --}}
                       <th scope="col" style="color:#fff;"><center>Contract Id</center></th>
                       <th scope="col"  style="color:#fff;"><center>Amount</center></th>
                       <th scope="col"  style="color:#fff;"><center>Created Date</center></th>

                       <th scope="col"  style="color:#fff;"><center>Remarks</center></th>
                   </tr>
                   </thead>
                   <tbody>

                   @foreach($invoices as $var)
                       <tr>
                           <td class="counterCell text-center">.</td>
                           <td><center>{{$var->invoice_number_votebook}}</center></td>
                           <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                           <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                           {{--  <td><center>{{$var->period}}</center></td> --}}
                           <td><center>{{$var->contract_id}}</center></td>
                           <td><center>{{$var->currency_invoice}} {{number_format($var->amount_to_be_paid)}} </center></td>

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




        <br>
        <div class="card">
            <div class="card-body">
                <b><h3>Payments Details</h3></b>
                <hr>


                @if(Auth::user()->role=='Accountant-DPDI')
                    <a data-toggle="modal"  style="background-color: #38c172; padding: 10px; cursor: pointer; border-radius: 0.25rem; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_payment_car" title="Record new car rental payment" role="button" aria-pressed="true">Add New Payment</a>
                @else
                @endif

                <div class="modal fade" id="new_payment_car" role="dialog">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <b><h5 class="modal-title">Adding New Car Rental Payment</h5></b>

                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">

                                <form method="post" action="{{ route('create_car_payment_manually')}}"  id="form1" >
                                    {{csrf_field()}}

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="form-wrapper">
                                                <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                <input type="number" min="1" class="form-control" id="invoice_number_car" name="invoice_number" value="" Required autocomplete="off">
                                                <p id="invoice_availability_car" ></p>
                                            </div>
                                        </div>
                                        <br>





                                        <div class="form-group col-md-12">
                                            <div class="form-wrapper">
                                                <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                <input type="number" min="0" class="form-control" id="amount_paid_car" name="amount_paid" value="" Required  autocomplete="off">
                                            </div>
                                        </div>
                                        <br>





                                        <div class="form-group col-md-12">
                                            <label>Currency <span style="color: red;">*</span></label>
                                            <div  class="form-wrapper">
                                                {{--                                                    <select id="currency_car" class="form-control" required name="currency_payments">--}}
                                                {{--                                                        <option value="" ></option>--}}
                                                {{--                                                        <option value="TZS" >TZS</option>--}}
                                                {{--                                                        <option value="USD" >USD</option>--}}
                                                {{--                                                    </select>--}}

                                                <input type="text"  class="form-control" id="currency_car" name="currency_payments" readonly value="" Required  autocomplete="off">
                                            </div>
                                        </div>
                                        <br>


                                        <div class="form-group col-md-12">
                                            <div class="form-wrapper">
                                                <label for=""  >Date the payment was made by the client<span style="color: red;">*</span></label>
                                                <input  min="{{date_format($date,"Y-m-d")}}" max="{{date("Y-m-d")}}" class="flatpickr_date form-control" id="receipt_space" name="date_of_payment" value="" required  autocomplete="off">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group col-md-12">
                                            <div class="form-wrapper">
                                                <label for=""  >Receipt Number <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="receipt_car" name="receipt_number" value="" required  autocomplete="off">
                                            </div>
                                        </div>
                                        <br>








                                    </div>


                                    <div align="right">
                                        <button id="submit_car" class="btn btn-primary" type="submit">Save</button>
                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>









                            </div>
                        </div>
                    </div>


                </div>

                <div class="pt-3">
                    <table class="hover table table-striped  table-bordered" id="myTable2">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="color:#fff;"><center>S/N</center></th>


                            <th scope="col" style="color:#fff;"><center>Invoice number</center></th>
                            <th scope="col" style="color:#fff;"><center>Amount Paid</center></th>
                            <th scope="col"  style="color:#fff;"><center>Amount Not Paid</center></th>
                            <th scope="col"  style="color:#fff;"><center>Date of payment</center></th>
                            <th scope="col"  style="color:#fff;"><center>Receipt Number</center></th>
                            <th scope="col"  style="color:#fff;"><center>Status</center></th>
                            <th scope="col"  style="color:#fff;"><center>Action</center></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        ?>
                        @foreach($payments as $var)
                            <tr>

                                <td><center>{{$i}}</center></td>
                                <td><center>{{$var->invoice_number_votebook}} </center></td>
                                <td><center>{{number_format($var->amount_paid)}} {{$var->currency_payments}}</center></td>
                                <td><center>{{number_format($var->amount_not_paid)}} {{$var->currency_payments}}</center></td>
                                <td><center>{{date("d/m/Y",strtotime($var->date_of_payment))}}</center></td>
                                <td><center>{{$var->receipt_number}}</center></td>
                                <td><center>@if($var->status_payment=='0')
                                            CANCELLED
                                        @elseif($var->status_payment=='1')
                                            OK
                                        @else
                                        @endif
                                    </center></td>
                                <td><center>



                                        <a title="View invoice" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice_car{{$var->id}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fas fa-file-invoice"></i></center></a>
                                        <div class="modal fade" id="invoice_car{{$var->id}}" role="dialog">

                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <b><h5 class="modal-title">Invoice Details</h5></b>

                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <table style="width: 100%">

                                                            <tr>
                                                                <td>Client:</td>
                                                                <td>{{$var->debtor_name}}</td>
                                                            </tr>


                                                            <tr>
                                                                <td>Invoice Number:</td>
                                                                <td>{{$var->invoice_number_votebook}}</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Inc Code:</td>
                                                                <td>{{$var->inc_code}}</td>
                                                            </tr>

                                                            <tr>
                                                                <td> Start Date:</td>
                                                                <td> {{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</td>
                                                            </tr>


                                                            <tr>
                                                                <td> End Date:</td>
                                                                <td> {{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</td>
                                                            </tr>

                                                            <tr>
                                                                <td> Period:</td>
                                                                <td> {{$var->period}}</td>
                                                            </tr>


                                                            <tr>
                                                                <td> Project ID:</td>
                                                                <td> {{$var->project_id}}</td>
                                                            </tr>

                                                            <tr>
                                                                <td> Amount:</td>
                                                                <td> {{$var->amount_to_be_paid}} {{$var->currency_invoice}}</td>
                                                            </tr>


                                                            @if($var->gepg_control_no!='')
                                                                <tr>
                                                                    <td>GePG Control Number:</td>
                                                                    <td>{{$var->gepg_control_no}}</td>
                                                                </tr>
                                                            @else
                                                            @endif



                                                            @if($var->account_no!='')
                                                                <tr>
                                                                    <td>Account Number:</td>
                                                                    <td>{{$var->account_no}}</td>
                                                                </tr>
                                                            @else
                                                            @endif

                                                            <tr>
                                                                <td>Payment Status:</td>
                                                                <td>{{$var->payment_status}}</td>
                                                            </tr>


                                                            <tr>
                                                                <td>Invoice Date:</td>
                                                                <td>{{date("d/m/Y",strtotime($var->invoice_date))}}</td>
                                                            </tr>



                                                            <tr>
                                                                <td>Comments:</td>
                                                                <td>{{$var->user_comments}}</td>
                                                            </tr>






                                                        </table>
                                                        <br>
                                                        <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </center></td>





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



  $('#invoice_number_car').on('input', function(e) {

      e.preventDefault();
      var query = $(this).val();
      if(query != '')
      {

          $.ajax({
              url:"{{ route('check_availability_car') }}",
              method:"GET",
              data:{query:query},
              success:function(data){
                  if(data=='0'){
                      $('#invoice_number_car').attr('style','border:1px solid #f00');
                      $("#invoice_availability_car").css("color","red");
                      $("#invoice_availability_car").html("Invoice number does not exist");


                      $("#amount_paid_car").prop('disabled', true);
                      $("#not_paid_car").prop('disabled', true);
                      $("#currency_car").prop('disabled', true);
                      $("#receipt_car").prop('disabled', true);
                      $("#submit_car").prop('disabled', true);
                      $("#currency_car").val("");

                  }
                  else{
                      $("#invoice_availability_car").html("");

                      $('#invoice_number_car').attr('style','border:1px solid #ced4da');


                      $("#amount_paid_car").prop('disabled', false);
                      $("#not_paid_car").prop('disabled', false);
                      $("#currency_car").prop('disabled', false);
                      $("#currency_car").val(data);
                      $("#receipt_car").prop('disabled', false);
                      $("#submit_car").prop('disabled', false);

                  }
              }
          });
      }
      else if(query==''){

          $('#invoice_number_car').attr('style','border:1px solid #ced4da');
      }
  });



  $('#contract_id_car').on('input', function(e) {

      e.preventDefault();
      var query = $(this).val();
      if(query != '')
      {

          $.ajax({
              url:"{{ route('contract_availability_car') }}",
              method:"GET",
              data:{query:query},
              success:function(data){
                  if(data=='0'){
                      $('#contract_id_car').attr('style','border:1px solid #f00');
                      $("#car_contract_availability").show();
                      $("#car_contract_availability").css("color","red");
                      $("#car_contract_availability").css("background-color","#ccd8e263");
                      $("#car_contract_availability").html("Contract does not exist");

                      $('#amount_carDiv').hide();
                      $('#currency_carDiv').hide();
                      $('#status_carDiv').hide();
                      $('#description_carDiv').hide();
                      $('#submit_car').prop('disabled', true);

                      $('#debtor_name_carDiv').hide();
                      $('#vrn_car2Div').hide();
                      // $('#invoice_number_carDiv').hide();
                      $('#debtor_account_code_carDiv').hide();
                      $('#tin_carDiv').hide();
                      $('#vrn_carDiv').hide();
                      $('#debtor_address_carDiv').hide();
                      $('#inc_code_carDiv').hide();
                      $('#invoicing_period_start_date_carDiv').hide();
                      $('#invoicing_period_end_date_carDiv').hide();
                      $('#project_id_carDiv').hide();


                  }

                  else{
                      $("#car_contract_availability").html("");
                      $("#car_contract_availability").hide();
                      $('#contract_id_car').attr('style','border:1px solid #ced4da');
                      $('#amount_carDiv').show();
                      $('#currency_carDiv').show();
                      $('#status_carDiv').show();
                      $('#description_carDiv').show();
                      $('#submit_car').prop('disabled', false);

                      $('#debtor_name_carDiv').show();
                      $('#vrn_car2Div').show();
                      // $('#invoice_number_carDiv').show();
                      $('#debtor_account_code_carDiv').show();
                      $('#tin_carDiv').show();
                      $('#vrn_carDiv').show();
                      $('#debtor_address_carDiv').show();
                      $('#inc_code_carDiv').show();
                      $('#invoicing_period_start_date_carDiv').show();
                      $('#invoicing_period_end_date_carDiv').show();
                      $('#project_id_carDiv').show();

                      //for data
                      $('#debtor_name_car').val(data[0].fullName);
                      // $('#debtor_account_code_car').val(data[0].client_id);
                      // $('#tin_car').val(data[0].tin);
                      $('#vrn_car').val(data[0].vehicle_reg_no);
                      // $('#debtor_address_car').val(data[0].address);

                  }
              }
          });
      }
      else if(query==''){

          $('#contract_id_car').attr('style','border:1px solid #ced4da');
      }
  });




</script>
@endsection
