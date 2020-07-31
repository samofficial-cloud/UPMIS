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
                <li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payment</a></li>
                <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
            </ul>
        </div>

        <div class="main_content">
            <div class="container " style="max-width: 1308px;">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success row col-xs-12" style="margin-left: -13px;
    margin-bottom: -1px;
    margin-top: 4px;">
                        <p>{{$message}}</p>
                    </div>
                @endif
                    <div style="width:100%; text-align: center ">
                        <br>
                        <h2>CAR RENTAL INVOICES</h2>

                        <br>

                    </div>


                <div class="">
                    <div class="modal fade" id="space" role="dialog">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <b><h5 class="modal-title">Add New Renting Space</h5></b>

                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">

                                    <form method="post" action="{{ route('add_space')}}"  id="form1" >
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="form-wrapper">
                                                <label for="course_name"  ><strong>Space Id <span style="color: red;">*</span> </strong></label>
                                                <input type="text" class="form-control" id="course_name" name="space_id" value="" Required autocomplete="off">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <div class="form-wrapper">
                                                <label for="space_type"  ><strong>Type</strong></label>
                                                <select id="space_type" class="form-control" name="space_type" >

                                                    <option value="Mall-shop" id="Option" >Mall-shop</option>
                                                    <option value="Villa" id="Option">Villa</option>
                                                    <option value="Office block" id="Option">Office block</option>
                                                    <option value="Cafeteria" id="Option">Cafeteria</option>
                                                    <option value="Stationery" id="Option">Stationery</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <div class="form-wrapper">
                                                <label for="space_location"  ><strong>Location</strong></label>
                                                <select class="form-control" id="space_location" name="space_location" >
                                                    <option value="Mlimani City" id="Option" >Mlimani City</option>
                                                    <option value="UDSM Main Campus" id="Option">UDSM Main Campus</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="form-wrapper">
                                                <label for="course_name"  ><strong>Size (SQM) <span style="color: red;"></span></strong></label>
                                                <input type="number" min="1" class="form-control" id="course_name" name="space_size" value=""  autocomplete="off">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <div class="form-wrapper">
                                                <label for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Rent Price Guide</strong></label>
                                                <input type="checkbox"  style="display: inline-block;" value="rent_price_guide_selected" id="rent_price_guide_checkbox" name="rent_price_guide_checkbox" autocomplete="off">
                                                <div  id="rent_price_guide_div" style="display: none;" class="form-group row">

                                                    <div class="col-4 inline_block form-wrapper">
                                                        <label  for="rent_price_guide_from" class=" col-form-label">From:</label>
                                                        <div class="">
                                                            <input type="number" min="1" class="form-control" id="rent_price_guide_from" name="rent_price_guide_from" value=""  autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="col-4 inline_block form-wrapper">
                                                        <label  for="rent_price_guide_to" class=" col-form-label">To:</label>
                                                        <div  class="">
                                                            <input type="number" min="1" class="form-control" id="rent_price_guide_to" name="rent_price_guide_to" value=""  autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div class="col-3 inline_block form-wrapper">
                                                        <label  for="rent_price_guide_currency" class="col-form-label">Currency:</label>
                                                        <div  class="">
                                                            <select id="rent_price_guide_currency" class="form-control" name="rent_price_guide_currency" >
                                                                <option value=""></option>
                                                                <option value="TZS" >TZS</option>
                                                                <option value="USD" >USD</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                </div>




                                            </div>
                                        </div>


                                        <div align="right">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>









                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="tab">
                        <button class="tablinks" onclick="openInvoices(event, 'not_sent')" id="defaultOpen"><strong>NOT SENT</strong></button>
                        <button class="tablinks" onclick="openInvoices(event, 'payment_not_complete')"><strong>PAYMENT NOT COMPLETE</strong></button>
                        <button class="tablinks" onclick="openInvoices(event, 'payment_complete')"><strong>PAYMENT COMPLETE</strong></button>
                    </div>

                    <div id="not_sent" class="tabcontent">
                        <br>
                        <h5>1. INVOICES NOT YET SENT TO CLIENTS</h5>
                        <br>
                        <?php
                        $i=1;
                        ?>
                        @if(count($invoices_not_sent)>0)


                            <table class="hover table table-striped  table-bordered" id="myTable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Debtor Name</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Invoice Number</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Start Date</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>End date</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Period</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Contract Id</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Created Date</center></th>

                                    <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($invoices_not_sent as $var)
                                    <tr>
                                        <td><center>{{$i}}</center></td>
                                        <td><center>{{$var->debtor_name}}</center></td>
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
                                                                        <td>{{$var->fullName}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> Vehicle Registration Number:</td>
                                                                        <td> {{$var->vehicle_reg_no}}</td>
                                                                    </tr>

                                                                    {{--<tr>--}}
                                                                        {{--<td> Vehicle Use:</td>--}}
                                                                        {{--<td> {{$var->vehicle_use}}</td>--}}
                                                                    {{--</tr>--}}


                                                                    <tr>
                                                                        <td>Start Date:</td>
                                                                        <td>{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>End Date:</td>
                                                                        <td>{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Start Time:</td>
                                                                        <td>{{$var->start_time}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>End Time:</td>
                                                                        <td>{{$var->end_time}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Area of Travel:</td>
                                                                        <td>{{$var->area_of_travel}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Faculty:</td>
                                                                        <td>{{$var->faculty}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Destination:</td>
                                                                        <td>{{$var->destination}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Purpose:</td>
                                                                        <td>{{$var->purpose}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Trip Nature:</td>
                                                                        <td>{{$var->trip_nature}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td>Amount:</td>
                                                                        <td>{{$var->amount}} {{$var->currency}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Rate:</td>
                                                                        <td>{{$var->rate}}</td>
                                                                    </tr>

                                                                </table>
                                                                <br>
                                                                <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>







                                            </center></td>
                                        <td><center>{{$var->amount_to_be_paid}} {{$var->currency}}</center></td>

                                        <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>

                                        <td>
                                            <center> <a data-toggle="modal" style=" color: #3490dc; cursor: pointer;"  data-target="#send_invoice{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-envelope" aria-hidden="true"></i></a>


                                                <div class="modal fade" id="send_invoice{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Sending Invoice to {{$var->debtor_name}} </h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form method="post" action="{{ route('send_invoice_car_rental',$var->invoice_number)}}"  id="form1" >
                                                                    {{csrf_field()}}

                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="course_name">GEPG Control Number</label>
                                                                            <input type="text" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
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






                                            </center>
                                        </td>
                                    </tr>
                                    <?php
                                    $i=$i+1;
                                    ?>
                                @endforeach





                                </tbody>
                            </table>

                        @else
                            <p>There are no any invoices in this section</p>
                        @endif
                    </div>





                    <div id="payment_not_complete" class="tabcontent">
                        <br>
                        <h5>2. INVOICES WHOSE PAYMENT IS NOT COMPLETE</h5>
                        <br>
                        <?php
                        $i=1;
                        ?>

                        @if(count($invoices_payment_not_complete)>0)

                            <table class="hover table table-striped  table-bordered" id="myTable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Debtor Name</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Invoice Number</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Start Date</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>End date</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Period</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Contract Id</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>GEPG Control No</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Invoice Date</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Payment Status</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Comments</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($invoices_payment_not_complete as $var)
                                    <tr>
                                        <td><center>{{$i}}</center></td>
                                        <td><center>{{$var->debtor_name}}</center></td>
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
                                                                        <td>{{$var->fullName}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> Vehicle Registration Number:</td>
                                                                        <td> {{$var->vehicle_reg_no}}</td>
                                                                    </tr>

                                                                    {{--<tr>--}}
                                                                    {{--<td> Vehicle Use:</td>--}}
                                                                    {{--<td> {{$var->vehicle_use}}</td>--}}
                                                                    {{--</tr>--}}


                                                                    <tr>
                                                                        <td>Start Date:</td>
                                                                        <td>{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>End Date:</td>
                                                                        <td>{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Start Time:</td>
                                                                        <td>{{$var->start_time}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>End Time:</td>
                                                                        <td>{{$var->end_time}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Area of Travel:</td>
                                                                        <td>{{$var->area_of_travel}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Faculty:</td>
                                                                        <td>{{$var->faculty}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Destination:</td>
                                                                        <td>{{$var->destination}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Purpose:</td>
                                                                        <td>{{$var->purpose}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Trip Nature:</td>
                                                                        <td>{{$var->trip_nature}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td>Amount:</td>
                                                                        <td>{{$var->amount}} {{$var->currency}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Rate:</td>
                                                                        <td>{{$var->rate}}</td>
                                                                    </tr>

                                                                </table>
                                                                <br>
                                                                <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>







                                            </center></td>
                                        <td><center>{{$var->amount_to_be_paid}} {{$var->currency}}</center></td>
                                        <td><center>{{$var->gepg_control_no}}</center></td>
                                        <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                        <td><center>{{$var->payment_status}}</center></td>
                                        <td><center>
                                                @if($var->user_comments==null)
                                                    N/A
                                                @else
                                                    {{$var->user_comments}}
                                                @endif


                                            </center></td>
                                        <td>
                                            <center>
                                                <a data-toggle="modal" data-target="#add_comment{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>


                                                <div class="modal fade" id="add_comment{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Invoice Number: {{$var->invoice_number}} </h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form method="post" action="{{ route('change_payment_status_car_rental',$var->invoice_number)}}"  id="form1" >
                                                                    {{csrf_field()}}
                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="course_name">Payment Status</label>
                                                                            <select  class="form-control"  name="payment_status" >

                                                                                <option value="Paid" id="Option">Paid</option>
                                                                                <option value="Partially Paid" id="Option">Partially Paid</option>
                                                                                <option value="Not Paid" id="Option">Not Paid</option>
                                                                                <option value="{{$var->payment_status}}" id="Option" selected >{{$var->payment_status}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="course_name">Comments</label>
                                                                            <input type="text" class="form-control" id="course_name" name="user_comments" value="{{$var->user_comments}}"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>




                                                                    <div align="right">
                                                                        <button class="btn btn-primary" type="submit">Save</button>
                                                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>


                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>






                                            </center>
                                        </td>
                                    </tr>
                                    <?php
                                    $i=$i+1;
                                    ?>

                                @endforeach





                                </tbody>
                            </table>

                        @else
                            <p>There are no any invoices in this section</p>
                        @endif

                    </div>



                    <div id="payment_complete" class="tabcontent">
                        <br>
                        <h5>3. INVOICES WHOSE PAYMENT IS COMPLETE</h5>
                        <br>
                        <?php
                        $i=1;
                        ?>

                        @if(count($invoices_payment_complete)>0)

                            <table class="hover table table-striped  table-bordered" id="myTable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Debtor Name</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Invoice Number</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Start Date</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>End date</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Period</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Contract Id</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>GEPG Control No</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Invoice Date</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Payment Status</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Comments</center></th>
                                    {{--<th scope="col"  style="color:#3490dc;"><center>Action</center></th>--}}
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($invoices_payment_complete as $var)
                                    <tr>
                                        <td><center>{{$i}}</center></td>
                                        <td><center>{{$var->debtor_name}}</center></td>
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
                                                                        <td>{{$var->fullName}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> Vehicle Registration Number:</td>
                                                                        <td> {{$var->vehicle_reg_no}}</td>
                                                                    </tr>

                                                                    {{--<tr>--}}
                                                                    {{--<td> Vehicle Use:</td>--}}
                                                                    {{--<td> {{$var->vehicle_use}}</td>--}}
                                                                    {{--</tr>--}}


                                                                    <tr>
                                                                        <td>Start Date:</td>
                                                                        <td>{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>End Date:</td>
                                                                        <td>{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Start Time:</td>
                                                                        <td>{{$var->start_time}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>End Time:</td>
                                                                        <td>{{$var->end_time}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Area of Travel:</td>
                                                                        <td>{{$var->area_of_travel}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Faculty:</td>
                                                                        <td>{{$var->faculty}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Destination:</td>
                                                                        <td>{{$var->destination}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Purpose:</td>
                                                                        <td>{{$var->purpose}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Trip Nature:</td>
                                                                        <td>{{$var->trip_nature}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td>Amount:</td>
                                                                        <td>{{$var->amount}} {{$var->currency}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Rate:</td>
                                                                        <td>{{$var->rate}}</td>
                                                                    </tr>

                                                                </table>
                                                                <br>
                                                                <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>







                                            </center></td>
                                        <td><center>{{$var->amount_to_be_paid}} {{$var->currency}}</center></td>
                                        <td><center>{{$var->gepg_control_no}}</center></td>
                                        <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                        <td><center>{{$var->payment_status}}</center></td>
                                        <td><center>
                                                @if($var->user_comments==null)
                                                    N/A
                                                @else
                                                    {{$var->user_comments}}
                                                @endif


                                            </center></td>
                                        {{--<td>--}}
                                        {{--<a data-toggle="modal" data-target="#add_comment{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>--}}


                                        {{--<div class="modal fade" id="add_comment{{$var->invoice_number}}" role="dialog">--}}

                                        {{--<div class="modal-dialog" role="document">--}}
                                        {{--<div class="modal-content">--}}
                                        {{--<div class="modal-header">--}}
                                        {{--<b><h5 class="modal-title">Add comment</h5></b>--}}

                                        {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                                        {{--</div>--}}

                                        {{--<div class="modal-body">--}}
                                        {{--<form method="post" action=""  id="form1" >--}}
                                        {{--{{csrf_field()}}--}}
                                        {{--<div class="form-group">--}}
                                        {{--<div class="form-wrapper">--}}
                                        {{--<label for="course_name">Comments</label>--}}
                                        {{--<input type="text" class="form-control" id="course_name" name="user_comments" value="{{$var->user_comments}}" Required autocomplete="off">--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<br>--}}


                                        {{--<div align="right">--}}
                                        {{--<button class="btn btn-primary" type="submit">Save</button>--}}
                                        {{--<button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>--}}
                                        {{--</div>--}}

                                        {{--</form>--}}


                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}


                                        {{--</div>--}}







                                        {{--</td>--}}
                                    </tr>
                                    <?php
                                    $i=$i+1;
                                    ?>
                                @endforeach





                                </tbody>
                            </table>

                        @else
                            <p>There are no any invoices in this section</p>
                        @endif




                    </div>



                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('pagescript')


    <script type="text/javascript">
        function openInvoices(evt, evtName) {
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




    <script>


        $("#rent_price_guide_checkbox").trigger('change');

        $('#rent_price_guide_checkbox').change(function(){

            if( $('#rent_price_guide_checkbox').prop('checked') ){

                document.getElementById("rent_price_guide_div").style.display = "block";

            } else {
                document.getElementById("rent_price_guide_div").style.display = "none";

                var input_from = document.getElementById("rent_price_guide_from");
                input_from.value = "";

                var input_to = document.getElementById("rent_price_guide_to");
                input_to.value = "";

            }


        });







        function checkbox(id) {
            //for edit case checkbox not selected
            $("#rent_price_guide_checkbox_edit_zero"+id).trigger('change');

            $('#rent_price_guide_checkbox_edit_zero'+id).change(function () {

                if ($('#rent_price_guide_checkbox_edit_zero'+id).prop('checked')) {
                    document.getElementById("rent_price_guide_div_edit"+id).style.display = "block";

                } else {
                    document.getElementById("rent_price_guide_div_edit"+id).style.display = "none";

                    var input_from = document.getElementById("rent_price_guide_from_edit"+id);
                    input_from.value = "";

                    var input_to = document.getElementById("rent_price_guide_to_edit"+id);
                    input_to.value = "";

                    var input_currency_edit = document.getElementById("rent_price_guide_currency_edit"+id);
                    input_currency_edit.value = "";



                }


            });

            //for edit case checkbox selected
            $("#rent_price_guide_checkbox_edit_one"+id).trigger('change');

            $('#rent_price_guide_checkbox_edit_one'+id).change(function () {

                if ($('#rent_price_guide_checkbox_edit_one'+id).prop('checked')) {
                    document.getElementById("rent_price_guide_div_edit"+id).style.display = "block";


                } else {
                    document.getElementById("rent_price_guide_div_edit"+id).style.display = "none";

                    var input_from = document.getElementById("rent_price_guide_from_edit"+id);
                    input_from.value = "";

                    var input_to = document.getElementById("rent_price_guide_to_edit"+id);
                    input_to.value = "";

                    var input_currency_edit = document.getElementById("rent_price_guide_currency_edit"+id);
                    input_currency_edit.value = "";


                }


            });

        }
    </script>

    <script type="text/javascript">
        var table = $('#myTable').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

    </script>



@endsection
