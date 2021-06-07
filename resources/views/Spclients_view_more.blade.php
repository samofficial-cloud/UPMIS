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
            height: auto;
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

                        @if(Auth::user()->role=='DPDI Planner')
                            <a href="/space_contract_form" class="btn button_color active" style=" color: white;   background-color: #38c172;
    padding: 10px;
    margin-left: 2px;
    margin-bottom: 15px;
    margin-top: 4px;" role="button" aria-pressed="true" title="Add new Real Estate Contract">Add New Contract</a>
                        @else
                        @endif


                        <div class="pt-3">

                            <table class="hover table table-striped table-bordered" id="myTable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#fff;"><center>S/N</center></th>
                                    <th scope="col" style="color:#fff;"><center>Contract Id</center></th>
                                    <th scope="col" style="color:#fff;"><center>Real Estate</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Major Industry</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Minor Industry</center></th>
                                    @if(Auth::user()->role=='DPDI Planner' OR (Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
                                        <th scope="col"  style="color:#fff;"><center>Action</center></th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($contracts as $var)
                                    <tr>
                                        <td class="counterCell text-center"></td>
                                        <td>
                                            <a title="View More Contract Details" class="link_style" data-toggle="modal" data-target="#contracta{{$var->contract_id}}" style="color: blue !important; cursor: pointer;" aria-pressed="true"><center>{{$var->contract_id}}</center></a>
                                            <div class="modal fade" id="contracta{{$var->contract_id}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">{{$var->full_name}} Contract Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%">
                                                                <tr>
                                                                    <td style="width: 30%;">Contract ID</td>
                                                                    <td colspan="2">{{$var->contract_id}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Real Estate Number</td>
                                                                    <td colspan="2">{{$var->space_id_contract}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Lease Start</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Lease End</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>
                                                                @if($var->academic_dependence=="Yes")
                                                                    <tr>
                                                                        <td rowspan="3">Amount</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Academic Season</td>
                                                                        <td>Vacation Season</td>
                                                                    </tr>
                                                                    <tr>
                                                                        @if(empty($var->academic_season))
                                                                            <td><center>-</center></td>
                                                                        @else
                                                                            <td>{{$var->currency}} {{number_format($var->academic_season)}}</td>
                                                                        @endif


                                                                        @if(empty($var->vacation_season))
                                                                            <td><center>-</center></td>
                                                                        @else
                                                                            <td>{{$var->currency}} {{number_format($var->vacation_season)}}</td>
                                                                        @endif
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td>Amount</td>
                                                                        @if(empty($var->amount))
                                                                            <td>-</td>
                                                                        @else
                                                                            <td colspan="2">{{$var->currency}} {{number_format($var->amount)}}</td>
                                                                        @endif
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td>Escalation Rate</td>
                                                                    <td colspan="2">{{$var->escalation_rate}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Payment Cycle</td>
                                                                    <td colspan="2">{{$var->payment_cycle}}</td>
                                                                </tr>
                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$var->space_id_contract}}</td>
                                        <td><center>{{date('d/m/Y',strtotime($var->start_date))}}</center></td>
                                        <td><center>{{date('d/m/Y',strtotime($var->end_date))}}</center></td>
                                        <td>{{$var->major_industry}}</td>
                                        <td>{{$var->minor_industry}}</td>
                                        @if(Auth::user()->role=='DPDI Planner' OR (Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
                                            <td><center>
                                                    @if($var->contract_status==0 or $var->end_date<date('Y-m-d'))
                                                        <a title="Renew this Contract" href="{{ route('renew_space_contract_form',$var->contract_id) }}" title="Click to Renew Contract"><center><i class="fa fa-refresh" style="font-size:20px;"></i></center></a>
                                                    @else
                                                        <a title="Edit this Contract Details" href="/edit_space_contract/{{$var->contract_id}}" ><i class="fa fa-edit" style="font-size:20px; color: green;"></i></a>
                                                        <a title="Terminate this Contract" data-toggle="modal" data-target="#terminate{{$var->contract_id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>

                                                        <div class="modal fade" id="terminate{{$var->contract_id}}" role="dialog">

                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 style="color: red;">WARNING !!!</h5>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <b><h5 class="modal-title">Are you sure you want to terminate {{$var->full_name}}'s contract for Real Estate Number {{$var->space_id_contract}}?</h5></b>
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
                        <b><h3>Invoices Details</h3></b>
                        <hr>


                        @if(Auth::user()->role=='DPDI Planner')
                            <div style="margin-bottom: 3%;">
                                <div style="float:left;">
                                    <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice" title="Add new Real Estate invoice" role="button" aria-pressed="true">Add New Invoice</a>
                                </div>
                                <div style="clear: both;"></div>

                            </div>

                            <div class="modal fade" id="new_invoice" role="dialog">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <b><h5 class="modal-title">Create New Real Estate Invoice</h5></b>

                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">

                                            <form method="post" action="{{ route('create_space_invoice_manually')}}"  id="form1" >
                                                {{csrf_field()}}


                                                <div class="form-row">


                                                    <div class="form-group col-md-12">
                                                        <div class="form-wrapper">
                                                            <label for="">Contract ID <span style="color: red;">*</span></label>
                                                            <input type="number" min="1" class="form-control" id="contract_id_space" name="contract_id" value=""  required autocomplete="off">
                                                            <p style="display: none;" class="mt-2 p-1" id="space_contract_availability"></p>
                                                        </div>
                                                    </div>

                                                    {{--                                                <div id="invoice_number_spaceDiv" style="display: none;" class="form-group col-md-12">--}}
                                                    {{--                                                    <div class="form-wrapper">--}}
                                                    {{--                                                        <label for="">Invoice number <span style="color: red;">*</span></label>--}}
                                                    {{--                                                        <input type="number" min="1" class="form-control" id="invoice_number_space" name="invoice_number" value=""  required autocomplete="off">--}}

                                                    {{--                                                    </div>--}}
                                                    {{--                                                </div>--}}

                                                    <div style="display: none;" id="debtor_nameDiv" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Client Full Name <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="debtor_name_space" name="debtor_name" readonly value="" Required autocomplete="off">
                                                        </div>
                                                    </div>





                                                    <div style="display: none;" id="debtor_account_codeDiv" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Client Account Code</label>
                                                            <input type="text" class="form-control" id="debtor_account_code_space" readonly name="debtor_account_code" value=""  autocomplete="off">
                                                        </div>
                                                    </div>




                                                    <div style="display: none;" id="tinDiv" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Client TIN</label>
                                                            <input type="text" class="form-control" id="tin_space" readonly name="tin" value=""  autocomplete="off">
                                                        </div>
                                                    </div>







                                                    <div style="display: none;" id="debtor_addressDiv" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Client Address <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="debtor_address_space" name="debtor_address" value="" readonly Required autocomplete="off">
                                                        </div>
                                                    </div>



                                                    {{--                                                                <div style="display: none;" id="inc_codeDiv" class="form-group col-md-12 mt-1">--}}
                                                    {{--                                                                    <div class="form-wrapper">--}}
                                                    {{--                                                                        <label for=""  >Income(Inc) Code<span style="color: red;">*</span></label>--}}
                                                    {{--                                                                        <input type="text" class="form-control" id="inc_code" name="inc_code" value=""  Required autocomplete="off">--}}
                                                    {{--                                                                    </div>--}}
                                                    {{--                                                                </div>--}}


                                                    <div style="display: none;" id="invoicing_period_start_dateDiv" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                                            <input  class="flatpickr_date form-control" id="" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                                        </div>
                                                    </div>



                                                    <div style="display: none;" id="invoicing_period_end_dateDiv" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                                            <input  class="flatpickr_date form-control" id="" name="invoicing_period_end_date" value="" Required autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div style="display: none;" id="periodDiv" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for="">Period <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="" name="period" value=""  required  autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div style="display: none;" id="project_idDiv"  class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Project ID <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="" name="project_id" value="" Required autocomplete="off">
                                                        </div>
                                                    </div>









                                                    <div id="amount_spaceDiv" style="display: none;" class="form-group col-md-6 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for="">Amount <span style="color: red;">*</span></label>
                                                            <input type="number" min="20" class="form-control" id="" name="amount_to_be_paid" value="" Required  autocomplete="off">
                                                        </div>
                                                    </div>



                                                    <div id="currency_spaceDiv" style="display: none;" class="form-group col-md-6 mt-1">
                                                        <label>Currency <span style="color: red;">*</span></label>
                                                        <div  class="form-wrapper">
                                                            <select id="" class="form-control" required name="currency">
                                                                <option value="" ></option>
                                                                <option value="TZS" >TZS</option>
                                                                <option value="USD" >USD</option>
                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div id="status_spaceDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Status <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="" name="status" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div id="description_spaceDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Description <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="" name="description" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>







                                                </div>


                                                <div align="right">
                                                    <button id="submit_space" class="btn btn-primary" type="submit">Forward</button>
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

                        <table class="hover table table-striped  table-bordered" id="myTable1">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#fff;"><center>S/N</center></th>
                                <th scope="col" style="color:#fff;"><center>Invoice Number</center></th>
                                <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
                                <th scope="col"  style="color:#fff;"><center>End date</center></th>
                                <th scope="col"  style="color:#fff;"><center>Period</center></th>
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
                                                                    <td colspan="2">{{$var->full_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Real Estate Number:</td>
                                                                    <td colspan="2"> {{$var->space_id_contract}}</td>
                                                                </tr>
                                                                @if($var->academic_dependence=="Yes")
                                                                    <tr>
                                                                        <td rowspan="3">Amount</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Academic Season</td>
                                                                        <td>Vacation Season</td>
                                                                    </tr>
                                                                    <tr>
                                                                        @if(empty($var->academic_season))
                                                                            <td><center>-</center></td>
                                                                        @else
                                                                            <td>{{$var->currency}} {{number_format($var->academic_season)}}</td>
                                                                        @endif


                                                                        @if(empty($var->vacation_season))
                                                                            <td><center>-</center></td>
                                                                        @else
                                                                            <td>{{$var->currency}} {{number_format($var->vacation_season)}}</td>
                                                                        @endif
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td>Amount</td>
                                                                        @if(empty($var->amount))
                                                                            <td>-</td>
                                                                        @else
                                                                            <td colspan="2">{{$var->currency}} {{number_format($var->amount)}}</td>
                                                                        @endif
                                                                    </tr>
                                                                @endif


                                                                <tr>
                                                                    <td>Payment Cycle:</td>
                                                                    <td colspan="2">{{$var->payment_cycle}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract Start Date:</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Contract End Date:</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle Start Date:</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->programming_start_date))}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Payment Cycle End Date:</td>
                                                                    <td colspan="2">{{date("d/m/Y",strtotime($var->programming_end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Escalation Rate:</td>
                                                                    <td colspan="2">{{$var->escalation_rate}} </td>
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
                <br>
                <div class="card">
                    <div class="card-body">
                        <br>
                        <b><h3>Payments Details</h3></b>
                        <hr>



                        @if(Auth::user()->role!='Accountant-DPDI')
                        @else
                            <a data-toggle="modal"  style="background-color: #38c172; padding: 10px; cursor: pointer; border-radius: 0.25rem; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_payment_space" title="Record new space payment" role="button" aria-pressed="true">Add New Payment</a>
                            <div class="modal fade" id="new_payment_space" role="dialog">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <b><h5 class="modal-title">Adding New Real Estate Payment</h5></b>

                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">

                                            <form method="post" action="{{ route('create_space_payment_manually')}}"  id="form1" >
                                                {{csrf_field()}}

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                            <input type="number" min="1" class="form-control" id="invoice_number_space" name="invoice_number" value="" Required autocomplete="off">
                                                            <p id="invoice_availability"></p>
                                                        </div>
                                                    </div>
                                                    <br>





                                                    <div class="form-group col-md-12">
                                                        <div class="form-wrapper">
                                                            <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                            <input type="number" min="0" class="form-control" id="amount_paid_space" name="amount_paid" value="" Required  autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <br>





                                                    <div class="form-group col-md-12">
                                                        <label>Currency <span style="color: red;">*</span></label>
                                                        <div  class="form-wrapper">
                                                            {{--                                                    <select id="currency_space" class="form-control" required name="currency_payments">--}}
                                                            {{--                                                        <option value="" ></option>--}}
                                                            {{--                                                        <option value="TZS" >TZS</option>--}}
                                                            {{--                                                        <option value="USD" >USD</option>--}}
                                                            {{--                                                    </select>--}}
                                                            <input type="text"  class="form-control" id="currency_space" name="currency_payments" readonly value="" Required  autocomplete="off">
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
                                                            <input type="text" class="form-control" id="receipt_space" name="receipt_number" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <br>








                                                </div>


                                                <div align="right">
                                                    <button id="submit_space" class="btn btn-primary" type="submit">Save</button>
                                                    <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>









                                        </div>
                                    </div>
                                </div>


                            </div>


                        @endif











                        <?php
                        $i=1;
                        ?>

                        @if(count($payments)>0)
                            <br><br>

                            <div id="space_content" class="pt-3">
                                <table class="hover table table-striped  table-bordered" id="myTable2">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" style="color:#fff;"><center>S/N</center></th>


                                        <th scope="col" style="color:#fff;"><center>Invoice number</center></th>
                                        <th scope="col" style="color:#fff;"><center>Amount Paid</center></th>
                                        <th scope="col"  style="color:#fff;"><center>Amount Not Paid</center></th>
                                        <th scope="col"  style="color:#fff;"><center>Over payment</center></th>
                                        <th scope="col"  style="color:#fff;"><center>Date of payment</center></th>
                                        <th scope="col"  style="color:#fff;"><center>Receipt Number</center></th>
                                        <th scope="col"  style="color:#fff;"><center>Action</center></th>


                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($payments as $var)
                                        <tr>

                                            <td><center>{{$i}}</center></td>

                                            <td><center>{{$var->invoice_number_votebook}} </center></td>
                                            <td><center>{{number_format($var->amount_paid)}} {{$var->currency_payments}}</center></td>
                                            <td><center>{{number_format($var->amount_not_paid)}} {{$var->currency_payments}}</center></td>
                                            <td><center>
                                                    @if($var->over_payment!='')
                                                        {{number_format($var->over_payment)}} {{$var->currency_payments}}
                                                    @else
                                                        0 {{$var->currency_payments}}
                                                    @endif

                                                </center></td>
                                            <td><center>{{date("d/m/Y",strtotime($var->date_of_payment))}}</center></td>
                                            <td><center>{{$var->receipt_number}}</center></td>
                                            <td><center>





                                                    <a title="View more" style="color:#3490dc !important; display: inline-block;"  class="" data-toggle="modal" data-target="#payment_details{{$var->id}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                                    <div class="modal fade" id="payment_details{{$var->id}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">Full Payment Details</h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <table class="table table-striped table-bordered" style="width: 100%">


                                                                        <tr>
                                                                            <td>Invoice number:</td>
                                                                            <td>{{$var->invoice_number_votebook}}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td> Amount paid:</td>
                                                                            <td> {{number_format($var->amount_paid)}} {{$var->currency_payments}}</td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td> Amount not paid:</td>
                                                                            <td> {{number_format($var->amount_not_paid)}} {{$var->currency_payments}}</td>
                                                                        </tr>



                                                                        <tr>
                                                                            <td> Date of payment:</td>
                                                                            <td> {{date("d/m/Y",strtotime($var->date_of_payment))}}</td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td>Receipt number:</td>
                                                                            <td>{{$var->receipt_number}}</td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td> Overpayment/Discount:</td>
                                                                            <td> {{number_format($var->over_payment)}} {{$var->currency_payments}}</td>
                                                                        </tr>

                                                                        @if($var->over_payment!='')

                                                                            <tr>
                                                                                <td> Reason for discount:</td>
                                                                                <td> {{$var->permanent_reason}}</td>
                                                                            </tr>
                                                                        @else
                                                                        @endif


                                                                    </table>
                                                                    <br>
                                                                    <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>






                                                    <a title="View invoice" style="color:#3490dc !important; display: inline-block;"  class="" data-toggle="modal" data-target="#invoice{{$var->id}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fas fa-file-invoice"></i></center></a>
                                                    <div class="modal fade" id="invoice{{$var->id}}" role="dialog">

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




                                                    @if(Auth::user()->role=='DPDI Planner')
                                                        <a data-toggle="modal"  style="display: inline-block; color:#3490dc !important;" data-target="#add_discount_space{{$var->id}}" title="Adding discount" role="button" aria-pressed="true"><i class="fas fa-plus"></i> </a>
                                                        <div class="modal fade" id="add_discount_space{{$var->id}}" role="dialog">

                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b><h5 class="modal-title">Adding discount to the payment made for invoice number: {{$var->invoice_number_votebook}}</h5></b>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">

                                                                        <form method="post" action="{{ route('add_discount_space',$var->id)}}"  id="form1" >
                                                                            {{csrf_field()}}

                                                                            <div class="form-row">



                                                                                <div class="form-group col-6">
                                                                                    <div class="form-wrapper">
                                                                                        <label for="">Amount <span style="color: red;">*</span></label>
                                                                                        <input type="number" min="20" class="form-control" id="over_payment" name="temporary_over_payment" value="" Required autocomplete="off">

                                                                                    </div>
                                                                                </div>
                                                                                <br>


                                                                                <div class="form-group col-6">

                                                                                    <div  class="form-wrapper">
                                                                                        <label>Currency <span style="color: red;">*</span></label>
                                                                                        <input type="text"  class="form-control" id="currency_space_payments" name="currency_payments_discount" readonly value="{{$var->currency_payments}}"   autocomplete="off">
                                                                                    </div>
                                                                                </div>
                                                                                <br>


                                                                                <div class="form-group col-12">
                                                                                    <div class="form-wrapper">
                                                                                        <label for=""><strong>Reason</strong><span style="color: red;">*</span></label>
                                                                                        <textarea style="width: 100%;" required name="reason_for_discount"></textarea>

                                                                                    </div>
                                                                                </div>
                                                                                <br>




                                                                            </div>


                                                                            <div align="right">
                                                                                <button id="submit_space" class="btn btn-primary" type="submit">Forward</button>
                                                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                            </div>
                                                                        </form>









                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    @else
                                                    @endif


                                                </center></td>





                                        </tr>
                                        <?php
                                        $i=$i+1;
                                        ?>

                                    @endforeach





                                    </tbody>
                                </table>
                            </div>

                        @else
                            <p class="mt-4" style="text-align:center;">No records found</p>
                        @endif



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


        $('#contract_id_space').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('contract_availability_space') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='0'){
                            $('#contract_id_space').attr('style','border:1px solid #f00');
                            $("#space_contract_availability").show();
                            $("#space_contract_availability").css("color","red");
                            $("#space_contract_availability").css("background-color","#ccd8e263");
                            $("#space_contract_availability").html("Contract does not exist");

                            $('#amount_spaceDiv').hide();
                            $('#currency_spaceDiv').hide();
                            $('#status_spaceDiv').hide();
                            $('#description_spaceDiv').hide();

                            $('#debtor_nameDiv').hide();
                            $('#invoice_number_spaceDiv').hide();
                            $('#debtor_account_codeDiv').hide();
                            $('#tinDiv').hide();
                            $('#vrnDiv').hide();
                            $('#debtor_addressDiv').hide();
                            $('#inc_codeDiv').hide();
                            $('#invoicing_period_start_dateDiv').hide();
                            $('#invoicing_period_end_dateDiv').hide();
                            $('#periodDiv').hide();
                            $('#project_idDiv').hide();




                            $('#submit_space').prop('disabled', true);

                        }

                        else{


                            $("#space_contract_availability").html("");
                            $("#space_contract_availability").hide();
                            $('#contract_id_space').attr('style','border:1px solid #ced4da');
                            $('#amount_spaceDiv').show();
                            $('#currency_spaceDiv').show();
                            $('#status_spaceDiv').show();
                            $('#description_spaceDiv').show();
                            $('#submit_space').prop('disabled', false);
                            $('#debtor_nameDiv').show();
                            $('#invoice_number_spaceDiv').show();
                            $('#debtor_account_codeDiv').show();
                            $('#tinDiv').show();
                            $('#vrnDiv').show();
                            $('#debtor_addressDiv').show();
                            $('#inc_codeDiv').show();
                            $('#invoicing_period_start_dateDiv').show();
                            $('#invoicing_period_end_dateDiv').show();
                            $('#periodDiv').show();
                            $('#project_idDiv').show();

                            //for data

                            $('#debtor_name_space').val(data[0].full_name);
                            $('#debtor_account_code_space').val(data[0].client_id);
                            $('#tin_space').val(data[0].tin);
                            $('#vrn_space').val(data[0].vrn);
                            $('#debtor_address_space').val(data[0].address);






                        }
                    }
                });
            }
            else if(query==''){

                $('#contract_id_space').attr('style','border:1px solid #ced4da');
            }
        });


        $('#invoice_number_space').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('check_availability_space') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='0'){
                            $('#invoice_number_space').attr('style','border:1px solid #f00');
                            $("#invoice_availability").css("color","red");
                            $("#invoice_availability").html("Invoice number does not exist");


                            $("#amount_paid_space").prop('disabled', true);
                            $("#not_paid_space").prop('disabled', true);
                            $("#currency_space").prop('disabled', true);
                            $("#receipt_space").prop('disabled', true);
                            $("#currency_space").val("");
                            $("#submit_space").prop('disabled', true);


                        }
                        else{
                            $("#invoice_availability").html("");

                            $('#invoice_number_space').attr('style','border:1px solid #ced4da');


                            $("#amount_paid_space").prop('disabled', false);
                            $("#not_paid_space").prop('disabled', false);
                            $("#currency_space").prop('disabled', false);
                            $("#currency_space").val(data);

                            $("#receipt_space").prop('disabled', false);
                            $("#submit_space").prop('disabled', false);

                        }
                    }
                });
            }
            else if(query==''){

                $('#invoice_number_space').attr('style','border:1px solid #ced4da');
            }
        });

    </script>

@endsection
