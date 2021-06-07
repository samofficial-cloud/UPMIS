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



                $today=date('Y-m-d');

                $date=date_create($today);

                date_sub($date,date_interval_create_from_date_string("366 days"));



                ?>


                <?php
                $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
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
                                <td>Email</td>
                                <td>{{$clientemail}}</td>
                            </tr>


                            <tr>
                                <td>Phone Number</td>
                                <td>{{$phone_number}}</td>
                            </tr>
                            {{-- <tr>
                              <td>Email</td>
                              <td>{{$details->email}}</td>
                            </tr> --}}
                        </table>
                    </div>
                </div>
                <br>
                <?php $r =1; ?>
                <div class="card">
                    <div class="card-body">
                        <b><h3>Contract Details</h3></b>
                        <hr>

                        @if(Auth::user()->role=='Insurance Officer')
                        <div style="float:left;"><a href="/insurance_contract_form" title="Add new Insurance contract"  class="btn button_color active" style="  color: white;   background-color: #38c172;
    padding: 10px;
    margin-left: 2px;
    margin-bottom: 15px;
    margin-top: 4px;" role="button" aria-pressed="true">Add New Contract</a>
                        </div>
                        @endif

                       <div class="pt-3">

                        <table class="hover table table-striped table-bordered" id="myTable2">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#fff;"><center>S/N</center></th>
                                <th scope="col" style="color:#fff;"><center>Client Name</center></th>
                                <th scope="col" style="color:#fff;"><center>Contract ID</center></th>
                                <th scope="col" style="color:#fff;"><center>Class</center></th>
                                <th scope="col" style="color:#fff;"><center>Principal</center></th>
                                <th scope="col" style="color:#fff;"><center>Insurance Type</center></th>
                                <th scope="col"  style="color:#fff;"><center>Commission Date</center></th>
                                <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                                <th scope="col"  style="color:#fff;"><center>Premium</center></th>
                                <th scope="col"  style="color:#fff;"><center>Commission </center></th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($contracts as $var)
                                <tr>
                                    <td style="text-align: center;">{{$r}}.</td>
                                    <td style="text-align: center;">{{$var->full_name}}</td>
                                    <td style="text-align: center;">{{$var->id}}</td>
                                    <td style="text-align: center;">{{$var->insurance_class}}</td>
                                    <td style="text-align: center;">{{$var->principal}}</td>
                                    <td style="text-align: center;">{{$var->insurance_type}}</td>
                                    <td style="text-align: center;">{{date("d/m/Y",strtotime($var->commission_date))}}</td>
                                    <td style="text-align: center;">{{date("d/m/Y",strtotime($var->end_date))}}</td>

                                    <td style="text-align: center;">{{number_format($var->premium)}} {{$var->currency}}</td>
                                    <td style="text-align: center;">{{number_format($var->commission)}} {{$var->currency}}</td>


                                </tr>
                                <?php $r = $r +1; ?>
                            @endforeach
                            </tbody>
                        </table>
                       </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <b><h3>Invoices Details</h3></b>
                        <hr>

                        @if(Auth::user()->role=='Insurance Officer')
                            <div style="margin-bottom: 3%;">
                                <div style="float:left;">
                                    <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice_insurance_clients" title="Add new insurance_clients invoice" role="button" aria-pressed="true">Add New Invoice</a>
                                </div>
                                <div style="clear: both;"></div>

                            </div>


                            <div class="modal fade" id="new_invoice_insurance_clients" role="dialog">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <b><h5 class="modal-title">Create New Insurance Invoice</h5></b>

                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">

                                            <form method="post" action="{{ route('create_insurance_invoice_clients_manually')}}"  id="form1" >
                                                {{csrf_field()}}



                                                <div class="form-row">


                                                    <div class="form-group col-md-12">
                                                        <div class="form-wrapper">
                                                            <label for="">Contract ID <span style="color: red;">*</span></label>
                                                            <input type="number" min="1" class="form-control" id="contract_id_insurance" name="contract_id" value=""  required autocomplete="off">
                                                            <p style="display: none;" class="mt-2 p-1" id="insurance_contract_availability"></p>
                                                        </div>
                                                    </div>



                                                    {{--                                                    <div id="invoice_number_insurance_clientsDiv" style="display: none;" class="form-group col-md-12">--}}
                                                    {{--                                                        <div class="form-wrapper">--}}
                                                    {{--                                                            <label for="">Invoice number <span style="color: red;">*</span></label>--}}
                                                    {{--                                                            <input type="number" min="1" class="form-control" id="invoice_number_insurance_clients" name="invoice_number" value=""  required autocomplete="off">--}}

                                                    {{--                                                        </div>--}}
                                                    {{--                                                    </div>--}}



                                                    <div style="display: none;" id="debtor_name_insurance_clientsDiv" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Client Full Name <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="debtor_name_insurance_clients" name="debtor_name" readonly value="" Required autocomplete="off">
                                                        </div>
                                                    </div>



                                                    <div class="form-group col-md-12 mt-1" style="display: none;" id="debtor_address_insurance_clientsDiv">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Client Address <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="debtor_address_insurance_clients" name="debtor_address" value="" readonly Required autocomplete="off">
                                                        </div>
                                                    </div>






                                                    {{--                                                    <div style="display: none;" id="inc_code_insuranceDiv" class="form-group col-md-12 mt-1">--}}
                                                    {{--                                                        <div class="form-wrapper">--}}
                                                    {{--                                                            <label for=""  >Income(Inc) Code<span style="color: red;">*</span></label>--}}
                                                    {{--                                                            <input type="text" class="form-control"  name="inc_code" value=""  Required autocomplete="off">--}}
                                                    {{--                                                        </div>--}}
                                                    {{--                                                    </div>--}}









                                                    <div style="display: none;" id="invoicing_period_start_date_insurance_clientsDiv" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                                            <input  class="flatpickr_date form-control" id="" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                                        </div>
                                                    </div>



                                                    <div style="display: none;" id="invoicing_period_end_date_insurance_clientsDiv" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                                            <input  class="flatpickr_date form-control" id="" name="invoicing_period_end_date" value="" Required autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div style="display: none;" id="period_insurance_clientsDiv" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for="">Period <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="" name="period" value=""  required  autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div style="display: none;" id="project_id_insurance_clientsDiv"  class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Project ID <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="" name="project_id" value="" Required autocomplete="off">
                                                        </div>
                                                    </div>









                                                    <div id="amount_insurance_clientsDiv" style="display: none;" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for="">Amount <span style="color: red;">*</span></label>
                                                            <input type="number" min="20" class="form-control" id="" name="amount_to_be_paid" value="" Required  autocomplete="off">
                                                        </div>
                                                    </div>



                                                    <div id="currency_insurance_clientsDiv" style="display: none;" class="form-group col-md-6 mt-1">
                                                        <label>Currency <span style="color: red;">*</span></label>
                                                        <div  class="form-wrapper">
                                                            <select id="" class="form-control" required name="currency">
                                                                <option value="" ></option>
                                                                <option value="TZS" >TZS</option>
                                                                <option value="USD" >USD</option>
                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div id="status_insurance_clientsDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Status <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="" name="status" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div id="description_insurance_clientsDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Description <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="" name="description" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>







                                                </div>







                                                <div align="right">
                                                    <button id="submit_insurance" class="btn btn-primary" type="submit">Save</button>
                                                    <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>









                                        </div>
                                    </div>
                                </div>


                            </div>
                        @else

                        @endif


                        <div class="pt-3"><table class="hover table table-striped  table-bordered" id="myTable1">
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
                            <a data-toggle="modal"  style="background-color: #38c172; padding: 10px; cursor: pointer; border-radius: 0.25rem; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_payment_insurance_clients" title="Record new insurance payment" role="button" aria-pressed="true">Add New Payment</a>
                            <div class="modal fade" id="new_payment_insurance_clients" role="dialog">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <b><h5 class="modal-title">Adding New Insurance Payment(For clients)</h5></b>

                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">

                                            <form method="post" action="{{ route('create_insurance_clients_payment_manually')}}"  id="form1" >
                                                {{csrf_field()}}

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <div class="form-wrapper">
                                                            <label for="">Invoice Number <span style="color: red;">*</span></label>
                                                            <input type="number" min="1" class="form-control" id="invoice_number_insurance_clients" name="invoice_number" value="" Required autocomplete="off">
                                                            <p id="invoice_availability_insurance_clients" ></p>
                                                        </div>
                                                    </div>
                                                    <br>





                                                    <div class="form-group col-md-12">
                                                        <div class="form-wrapper">
                                                            <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                            <input type="number" min="0" class="form-control" id="amount_paid_insurance_clients" name="amount_paid" value="" Required  autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <br>





                                                    <div class="form-group col-md-12">
                                                        <label>Currency <span style="color: red;">*</span></label>
                                                        <div  class="form-wrapper">
                                                            {{--                                                    <select id="currency_insurance" class="form-control" required name="currency_payments">--}}
                                                            {{--                                                        <option value="" ></option>--}}
                                                            {{--                                                        <option value="TZS" >TZS</option>--}}
                                                            {{--                                                        <option value="USD" >USD</option>--}}
                                                            {{--                                                    </select>--}}
                                                            <input type="text"  class="form-control" id="currency_insurance_clients" name="currency_payments" readonly value="" Required  autocomplete="off">
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
                                                            <input type="text" class="form-control" id="receipt_insurance_clients" name="receipt_number" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <br>








                                                </div>


                                                <div align="right">
                                                    <button id="submit_insurance_clients" class="btn btn-primary" type="submit">Save</button>
                                                    <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>









                                        </div>
                                    </div>
                                </div>


                            </div>

                        @else
                        @endif


<div class="pt-3">
    <table class="hover table table-striped  table-bordered" id="myTable3">
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



                        <a title="View invoice" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice_insurance_clients{{$var->id}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fas fa-file-invoice"></i></center></a>
                        <div class="modal fade" id="invoice_insurance_clients{{$var->id}}" role="dialog">

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


                                            <tr>
                                                <td>GePG Control Number:</td>
                                                <td>{{$var->gepg_control_no}}</td>
                                            </tr>

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

            var table = $('#myTable3').DataTable( {
                dom: '<"top"l>rt<"bottom"pi>'
            } );
        });




        $('#invoice_number_insurance_clients').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('check_availability_insurance_clients') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='0'){
                            $('#invoice_number_insurance_clients').attr('style','border:1px solid #f00');
                            $("#invoice_availability_insurance_clients").css("color","red");
                            $("#invoice_availability_insurance_clients").html("Invoice number does not exist");


                            $("#amount_paid_insurance_clients").prop('disabled', true);
                            $("#not_paid_insurance_clients").prop('disabled', true);
                            $("#currency_insurance_clients").prop('disabled', true);
                            $("#receipt_insurance_clients").prop('disabled', true);
                            $("#submit_insurance_clients").prop('disabled', true);
                            $("#currency_insurance_clients").val("");

                        }
                        else{
                            $("#invoice_availability_insurance_clients").html("");

                            $('#invoice_number_insurance_clients').attr('style','border:1px solid #ced4da');


                            $("#amount_paid_insurance_clients").prop('disabled', false);
                            $("#not_paid_insurance_clients").prop('disabled', false);
                            $("#currency_insurance_clients").prop('disabled', false);
                            $("#currency_insurance_clients").val(data);
                            $("#receipt_insurance_clients").prop('disabled', false);
                            $("#submit_insurance_clients").prop('disabled', false);

                        }
                    }
                });
            }
            else if(query==''){

                $('#invoice_number_insurance_clients').attr('style','border:1px solid #ced4da');
            }
        });



        $('#contract_id_insurance').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('contract_availability_insurance') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='0'){
                            $('#contract_id_insurance').attr('style','border:1px solid #f00');
                            $("#insurance_contract_availability").show();
                            $("#insurance_contract_availability").css("color","red");
                            $("#insurance_contract_availability").css("background-color","#ccd8e263");
                            $("#insurance_contract_availability").html("Contract does not exist");
                            $('#amount_insurance_clientsDiv').hide();
                            $('#currency_insurance_clientsDiv').hide();
                            $('#status_insurance_clientsDiv').hide();
                            $('#description_insurance_clientsDiv').hide();
                            $('#debtor_name_insurance_clientsDiv').hide();
                            $('#inc_code_insuranceDiv').hide();
                            $('#invoice_number_insurance_clientsDiv').hide();
                            $('#invoicing_period_start_date_insurance_clientsDiv').hide();
                            $('#invoicing_period_end_date_insurance_clientsDiv').hide();
                            $('#period_insurance_clientsDiv').hide();
                            $('#project_id_insurance_clientsDiv').hide();
                            $('#submit_insurance').prop('disabled', true);

                        }

                        else{


                            $("#insurance_contract_availability").html("");
                            $("#insurance_contract_availability").hide();
                            $('#contract_id_insurance').attr('style','border:1px solid #ced4da');
                            $('#amount_insurance_clientsDiv').show();
                            $('#currency_insurance_clientsDiv').show();
                            $('#status_insurance_clientsDiv').show();
                            $('#description_insurance_clientsDiv').show();
                            $('#submit_insurance').prop('disabled', false);
                            $('#debtor_name_insurance_clientsDiv').show();
                            $('#inc_code_insuranceDiv').show();
                            $('#invoice_number_insurance_clientsDiv').show();
                            $('#invoicing_period_start_date_insurance_clientsDiv').show();
                            $('#invoicing_period_end_date_insurance_clientsDiv').show();
                            $('#period_insurance_clientsDiv').show();
                            $('#project_id_insurance_clientsDiv').show();

                            //for data

                            $('#debtor_name_insurance_clients').val(data[0].full_name);



                        }
                    }
                });
            }
            else if(query==''){

                $('#contract_id_insurance').attr('style','border:1px solid #ced4da');
            }
        });




    </script>
@endsection
