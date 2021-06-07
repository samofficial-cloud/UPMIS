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


                        @if(Auth::user()->role=='Research Flats Officer')

                        <a href="{{ route('contractflat') }}" title="Add new contract"  class="btn button_color active" style="  color: white;   background-color: #38c172;
                    padding: 10px;
                    margin-left: 2px;
                    margin-bottom: 15px;
                    margin-top: 4px;" role="button" aria-pressed="true">Add New Contract</a>
                        @endif

                        <div class="pt-3">


                            <table class="hover table table-striped table-bordered" id="myTable4">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#fff;"><center>S/N</center></th>
                                    <th scope="col" style="color:#fff;"><center>Client Name</center></th>
                                    <th scope="col" style="color:#fff;"><center>Contract ID</center></th>
                                    <th scope="col" style="color:#fff;"><center>Host Name</center></th>
                                    <th scope="col" style="color:#fff;"><center>Arrival Date</center></th>
                                    <th scope="col" style="color:#fff;"><center>Departure Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Room No</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Total Amount (USD)</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Toatal Amount (TZS)</center></th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($contracts as $var)
                                    <tr>
                                        <td style="text-align: center;">{{$r}}.</td>
                                        <td>

                                            <a class="link_style" data-toggle="modal" data-target="#flat_client{{$var->id}}" style="color: blue !important; text-decoration: underline !important;  cursor: pointer;" aria-pressed="true">{{$var->first_name}} {{$var->last_name}}</a>

                                            <div class="modal fade" id="flat_client{{$var->id}}" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">{{$var->first_name}} {{$var->last_name}} Details.</h5></b>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%;">
                                                                <tr>
                                                                    <td>Client Name</td>
                                                                    <td>{{$var->first_name}} {{$var->last_name}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Professional</td>
                                                                    <td>{{$var->professional}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Address</td>
                                                                    <td>{{$var->address}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email</td>
                                                                    <td>{{$var->email}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Phone Number</td>
                                                                    <td>{{$var->phone_number}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Passport No</td>
                                                                    <td>

                                                                        @if($var->passport_no=='')
                                                                            N/A
                                                                        @else
                                                                            {{$var->passport_no}}
                                                                        @endif


                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Passport Issue Date</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->issue_date))}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Passport Issue Place</td>
                                                                    <td>{{$var->issue_place}}</td>
                                                                </tr>
                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">{{$var->id}}</td>
                                        <td>

                                            @if($var->host_name=='')
                                                N/A
                                            @else




                                                <a class="link_style" data-toggle="modal" data-target="#flat_host{{$var->id}}" style="color: blue !important; text-decoration: underline !important;  cursor: pointer;" aria-pressed="true">{{$var->host_name}}</a>

                                                <div class="modal fade" id="flat_host{{$var->id}}" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">{{$var->host_name}} Details.</h5></b>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <table style="width: 100%;">
                                                                    <tr>
                                                                        <td>Host Name</td>
                                                                        <td>{{$var->host_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>College</td>
                                                                        <td>{{$var->college_host}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Department</td>
                                                                        <td>{{$var->department_host}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Address</td>
                                                                        <td>{{$var->host_address}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email</td>
                                                                        <td>{{$var->host_email}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Phone Number</td>
                                                                        <td>{{$var->host_phone}}</td>
                                                                    </tr>
                                                                </table>
                                                                <br>
                                                                <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </td>

                                        <td style="text-align: center;">{{date("d/m/Y",strtotime($var->arrival_date))}}</td>
                                        <td style="text-align: center;">{{date("d/m/Y",strtotime($var->departure_date))}}</td>
                                        <td>
                                            <a class="link_style" data-toggle="modal" data-target="#flat_room{{$var->id}}" style="color: blue !important; text-decoration: underline !important;  cursor: pointer;" aria-pressed="true">{{$var->room_no}}</a>

                                            <div class="modal fade" id="flat_room{{$var->id}}" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">{{$var->room_no}} Details.</h5></b>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <?php $room=DB::table('research_flats_rooms')->where('room_no',$var->room_no)->first(); ?>
                                                            <table style="width: 100%;">
                                                                <tr>
                                                                    <td>Room Number</td>
                                                                    <td>{{$room->room_no}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Category</td>
                                                                    <td>{{$room->category}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Charging price for workers</td>
                                                                    <td>{{$room->currency}} {{number_format($room->charge_workers)}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Charging price for students</td>
                                                                    <td>{{$room->currency}} {{number_format($room->charge_students)}}</td>
                                                                </tr>
                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: right;">{{number_format($var->total_usd)}}</td>
                                        <td style="text-align: right;">{{number_format($var->total_tzs)}}</td>

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

                        @if(Auth::user()->role=='Research Flats Officer')
                            <div style="margin-bottom: 3%;">
                                <div style="float:left;">
                                    <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice_research" title="Add new research invoice" role="button" aria-pressed="true">Add New Invoice</a>
                                </div>
                                <div style="clear: both;"></div>

                            </div>


                            <div class="modal fade" id="new_invoice_research" role="dialog">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <b><h5 class="modal-title">Create New Research Flats Invoice</h5></b>

                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">

                                            <form method="post" action="{{ route('create_research_invoice_manually')}}"  id="form1" >
                                                {{csrf_field()}}

                                                <div class="form-row">


                                                    <div class="form-group col-md-12">
                                                        <div class="form-wrapper">
                                                            <label for="">Contract ID <span style="color: red;">*</span></label>
                                                            <input type="number" min="1" class="form-control" id="contract_id_research" name="contract_id" value=""  required autocomplete="off">
                                                            <p style="display: none;" class="mt-2 p-1" id="research_contract_availability"></p>
                                                        </div>
                                                    </div>


                                                    {{--                                                    <div id="invoice_number_researchDiv" style="display: none;" class="form-group col-md-12">--}}
                                                    {{--                                                        <div class="form-wrapper">--}}
                                                    {{--                                                            <label for="">Invoice number <span style="color: red;">*</span></label>--}}
                                                    {{--                                                            <input type="number" min="0" class="form-control" id="invoice_number_research" name="invoice_number" value=""  required autocomplete="off">--}}

                                                    {{--                                                        </div>--}}
                                                    {{--                                                    </div>--}}



                                                    <div id="debtor_name_researchDiv" style="display:none;" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Client Full Name <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="debtor_name_research" name="debtor_name" readonly value="" Required autocomplete="off">
                                                        </div>
                                                    </div>







                                                    <div id="debtor_address_researchDiv" style="display:none;" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Client Address <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="debtor_address_research" name="debtor_address" value="" Required autocomplete="off">
                                                        </div>
                                                    </div>

                                                    {{--                                                    <div style="display: none;" id="inc_code_researchDiv" class="form-group col-md-12 mt-1">--}}
                                                    {{--                                                        <div class="form-wrapper">--}}
                                                    {{--                                                            <label for=""  >Income(Inc) Code<span style="color: red;">*</span></label>--}}
                                                    {{--                                                            <input type="text" class="form-control"  name="inc_code" value=""  Required autocomplete="off">--}}
                                                    {{--                                                        </div>--}}
                                                    {{--                                                    </div>--}}

                                                    <div style="display:none;" id="invoicing_period_start_date_researchDiv" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                                            <input  class="flatpickr_date form-control" id="invoicing_period_start_date_research" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                                        </div>
                                                    </div>



                                                    <div style="display:none;" id="invoicing_period_end_date_researchDiv" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                                            <input  class="flatpickr_date form-control" id="invoicing_period_end_date_research" name="invoicing_period_end_date" value="" Required autocomplete="off">
                                                        </div>
                                                    </div>



                                                    <div style="display:none;" id="project_id_researchDiv" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Project ID <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="project_id_research" name="project_id" value="" Required autocomplete="off">
                                                        </div>
                                                    </div>








                                                    <div id="amount_researchDiv" style="display: none;"  class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for="">Amount <span style="color: red;">*</span></label>
                                                            <input type="number" min="20" class="form-control" id="" name="amount_to_be_paid" value="" Required  autocomplete="off">
                                                        </div>
                                                    </div>



                                                    <div id="currency_researchDiv" style="display: none;" class="form-group col-md-6 mt-1">
                                                        <label>Currency <span style="color: red;">*</span></label>
                                                        <div  class="form-wrapper">
                                                            <select id="" class="form-control" required name="currency">
                                                                <option value="" ></option>
                                                                <option value="TZS" >TZS</option>
                                                                <option value="USD" >USD</option>
                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div id="status_researchDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Status <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="" name="status" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div id="description_researchDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Description <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="" name="description" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <br>






                                                </div>


                                                <div align="right">
                                                    <button id="submit_research" class="btn btn-primary" type="submit">Submit</button>
                                                    <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>









                                        </div>
                                    </div>
                                </div>


                            </div>
                        @else

                        @endif

                        <div class=""><table class="hover table table-striped  table-bordered" id="myTable1">
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
                            </table></div>


                    </div>
                </div>


                <br>

                <br>
                <div class="card">
                    <div class="card-body">
                        <b><h3>Payments Details</h3></b>
                        <hr>

                        @if(Auth::user()->role=='Accountant-DPDI')
                            <a data-toggle="modal"  style="background-color: #38c172; padding: 10px; cursor: pointer; border-radius: 0.25rem; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_payment_research" title="Record new Research Flats payment" role="button" aria-pressed="true">Add New Payment</a>
                        @else
                        @endif

                        <div class="modal fade" id="new_payment_research" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Adding New Research Flats Payment</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <form method="post" action="{{ route('create_research_payment_manually')}}"  id="form1" >
                                            {{csrf_field()}}

                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="invoice_number_research" name="invoice_number" value="" Required autocomplete="off">
                                                        <p id="invoice_availability_research" ></p>
                                                    </div>
                                                </div>
                                                <br>





                                                <div class="form-group col-md-12">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="amount_paid_research" name="amount_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>





                                                <div class="form-group col-md-12">
                                                    <label>Currency <span style="color: red;">*</span></label>
                                                    <div  class="form-wrapper">
                                                        {{--                                                    <select id="currency_research" class="form-control" required name="currency_payments">--}}
                                                        {{--                                                        <option value="" ></option>--}}
                                                        {{--                                                        <option value="TZS" >TZS</option>--}}
                                                        {{--                                                        <option value="USD" >USD</option>--}}
                                                        {{--                                                    </select>--}}

                                                        <input type="text"  class="form-control" id="currency_research" name="currency_payments" readonly value="" Required  autocomplete="off">
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
                                                        <input type="text" class="form-control" id="receipt_research" name="receipt_number" value="" required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>








                                            </div>


                                            <div align="right">
                                                <button id="submit_research" class="btn btn-primary" type="submit">Save</button>
                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>









                                    </div>
                                </div>
                            </div>


                        </div>

                        <div id="research_content" class="pt-3">
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



                                                <a title="View invoice" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice_research{{$var->id}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fas fa-file-invoice"></i></center></a>
                                                <div class="modal fade" id="invoice_research{{$var->id}}" role="dialog">

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


            var table = $('#myTable4').DataTable( {
                dom: '<"top"l>rt<"bottom"pi>'
            } );

        });


        $('#contract_id_research').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('contract_availability_research') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='0'){
                            $('#contract_id_research').attr('style','border:1px solid #f00');
                            $("#research_contract_availability").show();
                            $("#research_contract_availability").css("color","red");
                            $("#research_contract_availability").css("background-color","#ccd8e263");
                            $("#research_contract_availability").html("Contract does not exist");

                            $('#amount_researchDiv').hide();
                            $('#currency_researchDiv').hide();
                            $('#status_researchDiv').hide();
                            $('#description_researchDiv').hide();
                            $('#submit_research').prop('disabled', true);

                            $('#debtor_name_researchDiv').hide();
                            // $('#invoice_number_researchDiv').hide();
                            $('#debtor_account_code_researchDiv').hide();
                            $('#tin_researchDiv').hide();
                            $('#vrn_researchDiv').hide();
                            $('#debtor_address_researchDiv').hide();
                            $('#inc_code_researchDiv').hide();
                            $('#invoicing_period_start_date_researchDiv').hide();
                            $('#invoicing_period_end_date_researchDiv').hide();
                            $('#project_id_researchDiv').hide();


                        }

                        else{
                            $("#research_contract_availability").html("");
                            $("#research_contract_availability").hide();
                            $('#contract_id_research').attr('style','border:1px solid #ced4da');
                            $('#amount_researchDiv').show();
                            $('#currency_researchDiv').show();
                            $('#status_researchDiv').show();
                            $('#description_researchDiv').show();
                            $('#submit_research').prop('disabled', false);

                            $('#debtor_name_researchDiv').show();
                            // $('#invoice_number_researchDiv').show();
                            $('#debtor_account_code_researchDiv').show();
                            $('#tin_researchDiv').show();

                            $('#debtor_address_researchDiv').show();
                            $('#inc_code_researchDiv').show();
                            $('#invoicing_period_start_date_researchDiv').show();
                            $('#invoicing_period_end_date_researchDiv').show();
                            $('#project_id_researchDiv').show();

                            //for data
                            $('#debtor_name_research').val(data[0].first_name+" "+data[0].last_name);
                            // $('#debtor_account_code_research').val(data[0].client_id);
                            // $('#tin_research').val(data[0].tin);

                            // $('#debtor_address_research').val(data[0].address);

                        }
                    }
                });
            }
            else if(query==''){

                $('#contract_id_research').attr('style','border:1px solid #ced4da');
            }
        });

        $('#invoice_number_research').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('check_availability_research') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='0'){
                            $('#invoice_number_research').attr('style','border:1px solid #f00');
                            $("#invoice_availability_research").css("color","red");
                            $("#invoice_availability_research").html("Invoice number does not exist");


                            $("#amount_paid_research").prop('disabled', true);
                            $("#not_paid_research").prop('disabled', true);
                            $("#currency_research").prop('disabled', true);
                            $("#receipt_research").prop('disabled', true);
                            $("#submit_research").prop('disabled', true);
                            $("#currency_research").val("");

                        }
                        else{
                            $("#invoice_availability_research").html("");

                            $('#invoice_number_research').attr('style','border:1px solid #ced4da');


                            $("#amount_paid_research").prop('disabled', false);
                            $("#not_paid_research").prop('disabled', false);
                            $("#currency_research").prop('disabled', false);
                            $("#currency_research").val(data);
                            $("#receipt_research").prop('disabled', false);
                            $("#submit_research").prop('disabled', false);

                        }
                    }
                });
            }
            else if(query==''){

                $('#invoice_number_research').attr('style','border:1px solid #ced4da');
            }
        });



    </script>
@endsection