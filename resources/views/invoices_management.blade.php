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
            <li class="active_nav_item"><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>

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
            <div class="container " style="max-width: 1308px;">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success row col-xs-12" style="margin-left: -13px;
    margin-bottom: -1px;
    margin-top: 4px;">
                        <p>{{$message}}</p>
                    </div>
                @endif

                    @if (session('error'))
                        <div class="alert alert-danger row col-xs-12" style="margin-left: -13px; margin-bottom: -1px; margin-top: 4px;">
                            {{ session('error') }}
                            <br>
                        </div>
                    @endif

                <br>


                <div class="tab">




                        @if ($category=='Real Estate only' OR $category=='All')
                            <button class="tablinks space_identity" onclick="openInvoices(event, 'space_invoices')" ><strong>Real Estate</strong></button>
                        @else
                        @endif


                        @if($category=='Insurance only' OR $category=='All')
                            <button class="tablinks insurance_identity" onclick="openInvoices(event, 'insurance_invoices')"><strong>Insurance</strong></button>

                        @else
                        @endif


                        @if ($category=='CPTU only' OR $category=='All')
                            <button class="tablinks car_identity" onclick="openInvoices(event, 'car_invoices')"><strong>Car Rental</strong></button>
                        @else
                        @endif







                </div>


                <div id="space_invoices"  class="tabcontent">
                    <br>


                    <div class="tab" style="">

                        <button class="tablinks_inner " onclick="openInnerInvoices(event, 'space_invoices_inner')" id="defaultOpen"><strong>Space</strong></button>
                        <button class="tablinks_inner bills" onclick="openInnerInvoices(event, 'water_invoices')"><strong>Water Bills</strong></button>
                        <button class="tablinks_inner bills" onclick="openInnerInvoices(event, 'electricity_invoices')"><strong>Electricity Bills</strong></button>
                    </div>


                    <div id="space_invoices_inner" style="border: 1px solid #ccc; padding: 1%;" class="tabcontent_inner">
                        <br>


                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else
                            <div><div style="float:left;"></div> <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice" title="Add new space invoice" role="button" aria-pressed="true">Add New Invoice</a>  <div style="float:right;"><a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#send_invoice_space"  role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true"></i> Send All Invoices</a></div>

                            <div style="clear: both;"></div>

                            </div>

                        @endif

                        <center><h3><strong>Space Invoices</strong></h3></center>
                        <hr>

                        <div class="modal fade" id="send_invoice_space" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Sending all invoices to respective clients</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <form method="get" action="" >
                                            {{csrf_field()}}

                                            <div align="right">
                                                <button id="send_all_space" class="btn btn-primary" type="button" id="newdata">Send</button>
                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="modal fade" id="new_invoice" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Create New Space Invoice</h5></b>

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




                                                <div style="display: none;" id="tinDiv" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client TIN</label>
                                                        <input type="text" class="form-control" id="tin_space" readonly name="tin" value=""  autocomplete="off">
                                                    </div>
                                                </div>







                                                <div style="display: none;" id="debtor_addressDiv" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client Address <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="debtor_address_space" name="debtor_address" value="" readonly Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div style="display: none;" id="invoicing_period_start_dateDiv" class="form-group col-md-6 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                                        <input type="date" class="form-control" id="" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div style="display: none;" id="invoicing_period_end_dateDiv" class="form-group col-md-6 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                                        <input type="date" class="form-control" id="" name="invoicing_period_end_date" value="" Required autocomplete="off">
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
                                                <button id="submit_space" class="btn btn-primary" type="submit">Save</button>
                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>









                                    </div>
                                </div>
                            </div>


                        </div>


                        <?php
                        $i=1;
                        ?>

                        @if(count($space_invoices)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#fff;">S/N</th>
                                    <th scope="col"  style="color:#fff;">Client</th>
                                    <th scope="col" style="color:#fff;"><center>Invoice Number</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Amount</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Payment Status</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Invoice Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Action</center></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($space_invoices as $var)
                                    <tr>

                                        <td> <center>{{$i}}</center>  </td>

                                        <td>{{$var->debtor_name}}</td>
                                        <td><center>{{$var->invoice_number}}
                                            </center>
                                        </td>

                                        <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                        <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                        <td><center>{{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</center></td>
                                        <td><center>{{$var->payment_status}}</center></td>
                                        <td>{{date("d/m/Y",strtotime($var->invoice_date))}} @if($var->email_sent_status=='NOT SENT')

                                                <span style="float: right !important; " class="badge badge-danger">New</span>
                                            @else
                                            @endif </td>




                                        <td><center>





                                                <a  title="View invoice" style="color:#3490dc !important; display:inline-block;"  class="" data-toggle="modal" data-target="#invoice{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="invoice{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Full Invoice Details.</h5></b>

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
                                                                        <td>{{$var->invoice_number}}</td>
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
                                                                        <td> {{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td>GEPG Control Number:</td>
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






                                                <a title="View contract" style="color:#3490dc !important; display:inline-block;"  class="" data-toggle="modal" data-target="#contract{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-file-text" aria-hidden="true"></i></center></a>
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
                                                                        <td>Contract ID:</td>
                                                                        <td>{{$var->contract_id}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td>Client :</td>
                                                                        <td>{{$var->full_name}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> Space Number:</td>
                                                                        <td> {{$var->space_id_contract}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> Amount:</td>
                                                                        <td> {{number_format($var->amount)}} {{$var->currency}}</td>
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



                                                @if($var->email_sent_status=='NOT SENT')
                                                    @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                    @else

                                                        @if($var->gepg_control_no=='')
                                                        <a title="Add control number" data-toggle="modal" style="color: #3490dc; cursor: pointer;"  data-target="#add_control_number{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fas fa-file-medical"></i></a>
                                                        @else
                                                        @endif

                                                        <a title="Send invoice" data-toggle="modal" style=" color: #3490dc; cursor: pointer;"  data-target="#send_invoice{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                                    @endif


                                                        <div class="modal fade" id="add_control_number{{$var->invoice_number}}" role="dialog">

                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b><h5 class="modal-title">Adding control number for invoice number {{$var->invoice_number}} </h5></b>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form method="post" action="{{ route('add_control_no_space',$var->invoice_number)}}"  id="form1" >
                                                                            {{csrf_field()}}

                                                                            <div class="form-group">
                                                                                <div class="form-wrapper">
                                                                                    <label for="course_name">GEPG Control Number</label>

                                                                                        <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControl(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                                        <p id="error_gepg{{$var->invoice_number}}"></p>

                                                                                </div>
                                                                            </div>



                                                                            <br>
                                                                            <div align="right">
                                                                                <button id="sendbtn{{$var->invoice_number}}" class="btn btn-primary" type="submit">Save</button>
                                                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                            </div>
                                                                        </form>


                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>



                                                    <div class="modal fade" id="send_invoice{{$var->invoice_number}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">Sending Invoice to {{$var->debtor_name}} </h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="{{ route('send_invoice_space',$var->invoice_number)}}"  id="form1" >
                                                                        {{csrf_field()}}

                                                                        <div class="form-group">
                                                                            <div class="form-wrapper">
                                                                                <label for="course_name">GEPG Control Number</label>
                                                                                @if($var->gepg_control_no=='')
                                                                                <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControl(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                                <p id="error_gepg{{$var->invoice_number}}"></p>

                                                                                @else
                                                                                    <input   type="number" class="form-control"  name="gepg_control_no" value="{{$var->gepg_control_no}}" readonly autocomplete="off">
                                                                                @endif
                                                                            </div>
                                                                        </div>


                                                                        <br>
                                                                        <div align="right">
                                                                            <button id="sendbtn{{$var->invoice_number}}" class="btn btn-primary" type="submit">Send</button>
                                                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </form>


                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>







                                                @else

                                                @endif


                                                @if($var->email_sent_status=='SENT')

                                                    @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                    @else

                                                        @if($var->payment_status=='Not paid')
                                                            <a title="Receive payment" data-toggle="modal" data-target="#add_comment{{$var->invoice_number}}"  role="button" aria-pressed="true"   name="editC"><i class="fa fa-money" style="font-size:20px; color:#3490dc !important;" aria-hidden="true"></i></a>
                                                        @else
                                                        @endif

                                                    @endif

                                                    <div class="modal fade" id="add_comment{{$var->invoice_number}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">Invoice Number: {{$var->invoice_number}} </h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="{{ route('change_payment_status_space',$var->invoice_number)}}"  id="form1" >
                                                                        {{csrf_field()}}
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                                                    <input type="number" min="1" class="form-control" id="invoice_number_space" readonly name="invoice_number" value="{{$var->invoice_number}}" Required autocomplete="off">

                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div style="padding-top: 2%;" class="form-group col-md-6">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Votebook Invoice Number <span style="color: red;">*</span></label>
                                                                                    <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>



                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                                                    <input type="number" min="10" class="form-control" id="amount_paid_space" name="amount_paid" value="" Required  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>





                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <label>Currency <span style="color: red;">*</span></label>
                                                                                <div  class="form-wrapper">
                                                                                    <input type="text"  class="form-control" id="currency_space" name="currency_payments" value="{{$var->currency_invoice}}"  readonly autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div class="form-group col-md-12 pt-2">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Date the payment was made by the client<span style="color: red;">*</span></label>
                                                                                    <input type="date" min="{{date_format($date,"Y-m-d")}}" max="{{date("Y-m-d")}}" class="form-control" id="receipt_space" name="date_of_payment" value="" required  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>


                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Receipt Number <span style="color: red;">*</span></label>
                                                                                    <input type="text" class="form-control" id="receipt_space" name="receipt_number" value="" required  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>


                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <div class="form-wrapper">
                                                                                    <label for="course_name">Comments</label>
                                                                                    <input type="text" class="form-control" id="course_name" name="user_comments" value="{{$var->user_comments}}"  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>





                                                                        </div>






                                                                        <div style="padding-top: 2%;" align="right">
                                                                            <button class="btn btn-primary" type="submit">Save</button>
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

                        @else
                            <p>No records found</p>
                        @endif




                    </div>



                    <div id="water_invoices" class="tabcontent_inner" style="border: 1px solid #ccc; padding: 1%;">
                        <br>




                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else
                            <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice_water" title="Add new water bill invoice" role="button" aria-pressed="true">Add New Invoice</a>
                        @endif

                        <center><h3><strong>Water bill Invoices</strong></h3></center>
                        <hr>

                        <div class="modal fade" id="new_invoice_water" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Create New Water Bill Invoice</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <form method="post" action="{{ route('create_water_invoice_manually')}}"  id="form1" >
                                            {{csrf_field()}}

                                            <div class="form-row">

                                                <div class="form-group col-md-12">
                                                    <div class="form-wrapper">
                                                        <label for="">Contract ID <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="contract_id_water" name="contract_id" value=""  required autocomplete="off">
                                                        <p style="display: none;" class="mt-2 p-1" id="water_contract_availability"></p>
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="debtor_name_waterDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client Full Name <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="debtor_name_water" name="debtor_name" readonly value="" Required autocomplete="off">
                                                    </div>
                                                </div>





                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="debtor_account_code_waterDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client Account Code</label>
                                                        <input type="text" class="form-control" id="debtor_account_code_water" readonly name="debtor_account_code" value=""  autocomplete="off">
                                                    </div>
                                                </div>




                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="tin_waterDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client TIN</label>
                                                        <input type="text" class="form-control" id="tin_water" name="tin" readonly value=""  autocomplete="off">
                                                    </div>
                                                </div>






                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="debtor_address_waterDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client Address <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="debtor_address_water" readonly name="debtor_address" value="" Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="invoicing_period_start_date_waterDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                                        <input type="date" class="form-control" id="" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="invoicing_period_end_date_waterDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                                        <input type="date" class="form-control" id="" name="invoicing_period_end_date" value="" Required autocomplete="off">
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="project_id_waterDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Project ID <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="" name="project_id" value="" Required autocomplete="off">
                                                    </div>
                                                </div>









                                                <div id="debt_waterDiv" style="display: none;" class="form-group col-md-6 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for="">Debt <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" readonly id="debt_water" name="debt" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>


                                                <div id="current_amount_waterDiv" style="display: none;" class="form-group col-md-6 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for="">Current Amount <span style="color: red;">*</span></label>
                                                        <input type="number" min="20" class="form-control" id="current_amount_water" name="current_amount" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>


                                                <div id="cumulative_amount_waterDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for="">Cumulative Amount <span style="color: red;">*</span></label>
                                                        <input type="number" min="20" readonly class="form-control" id="cumulative_amount_water" name="cumulative_amount" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>



                                                <div id="currency_waterDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                    <label>Currency <span style="color: red;">*</span></label>
                                                    <div id="changable_currency_water" class="form-wrapper">
                                                        <input type="text" class="form-control" readonly id="currency_water" required name="currency" autocomplete="off">
                                                    </div>
                                                </div>



                                                <div id="status_waterDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Status <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="" name="status" value="" required  autocomplete="off">
                                                    </div>
                                                </div>


                                                <div id="description_waterDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for="">Description <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="" name="description" value="" required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>






                                            </div>


                                            <div align="right">
                                                <button id="submit_water" class="btn btn-primary" type="submit">Save</button>
                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>









                                    </div>
                                </div>
                            </div>


                        </div>




                        <?php
                        $i=1;
                        ?>





                        @if(count($water_bill_invoices)>0)



                            <table class="hover table table-striped  table-bordered" id="myTableWater">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#fff;"><center>S/N</center></th>
                                    <th scope="col"  style="color:#fff;">Client</th>
                                    <th scope="col" style="color:#fff;"><center>Invoice Number</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Debt</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Current Amount</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Cumulative Amount</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Payment Status</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Invoice Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Action</center></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($water_bill_invoices as $var)
                                    <tr>
                                        <td><center>{{$i}}</center></td>
                                        <td>{{$var->debtor_name}}</td>
                                        <td><center>{{$var->invoice_number}}</center></td>
                                        <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                        <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                        <td><center>{{number_format($var->debt)}} {{$var->currency_invoice}}</center></td>
                                        @if($var->current_amount==0)
                                            <td><center>N/A</center></td>
                                        @else
                                            <td><center>{{number_format($var->current_amount)}} {{$var->currency_invoice}}</center></td>
                                        @endif
                                        @if($var->cumulative_amount==0)
                                            <td><center>N/A</center></td>
                                        @else
                                            <td><center>{{number_format($var->cumulative_amount)}} {{$var->currency_invoice}}</center></td>
                                        @endif
                                        <td><center>{{$var->payment_status}}</center></td>
                                        <td>{{date("d/m/Y",strtotime($var->invoice_date))}} @if($var->email_sent_status=='NOT SENT')

                                                <span style="float: right !important; " class="badge badge-danger">New</span>
                                            @else
                                            @endif</td>




                                        <td><center>





                                                <a title="View invoice" style="color:#3490dc !important; display:inline-block;"  class="" data-toggle="modal" data-target="#invoice_water{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" style="font-size: 20px;" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="invoice_water{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Full Invoice Details.</h5></b>

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
                                                                        <td>{{$var->invoice_number}}</td>
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
                                                                        <td> Debt:</td>
                                                                        <td>{{number_format($var->debt)}} {{$var->currency_invoice}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Current Amount:</td>
                                                                        @if($var->current_amount==0)
                                                                            <td>N/A</td>
                                                                        @else
                                                                            <td>{{number_format($var->current_amount)}} {{$var->currency_invoice}}</td>
                                                                        @endif

                                                                    </tr>

                                                                    <tr>

                                                                        <td>Cumulative Amount:</td>
                                                                        @if($var->cumulative_amount==0)
                                                                            <td>N/A</td>
                                                                        @else
                                                                            <td>{{number_format($var->cumulative_amount)}} {{$var->currency_invoice}}</td>
                                                                        @endif
                                                                    </tr>


                                                                    <tr>
                                                                        <td>GEPG Control Number:</td>
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






                                                <a title="View contract" style="color:#3490dc !important; display:inline-block;"  class="" data-toggle="modal" data-target="#contract_water{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-file-text" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="contract_water{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Contract Details</h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <table style="width: 100%">

                                                                    <tr>
                                                                        <td>Contract ID:</td>
                                                                        <td>{{$var->contract_id}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td>Client:</td>
                                                                        <td>{{$var->full_name}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> Space Number:</td>
                                                                        <td> {{$var->space_id_contract}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> Amount:</td>
                                                                        <td> {{number_format($var->amount)}} {{$var->currency}}</td>
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

                                                                    <tr>
                                                                        <td>Has Water Bill:</td>
                                                                        <td>{{$var->has_water_bill}} </td>
                                                                    </tr>




                                                                </table>
                                                                <br>
                                                                <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                @if($var->email_sent_status=='NOT SENT')
                                                    @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                    @else

                                                        @if($var->gepg_control_no=='')
                                                        <a title="Add control number" data-toggle="modal" style="color: #3490dc; cursor: pointer;"  data-target="#add_control_number_water{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fas fa-file-medical"></i></a>
                                                        @else
                                                        @endif

                                                        <a title="Send invoice" data-toggle="modal" style=" color: #3490dc; cursor: pointer;"  data-target="#send_invoice_water{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                                    @endif



                                                        <div class="modal fade" id="add_control_number_water{{$var->invoice_number}}" role="dialog">

                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b><h5 class="modal-title">Adding control number for invoice number {{$var->invoice_number}} </h5></b>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form method="post" action="{{ route('add_control_no_water',$var->invoice_number)}}"  id="form1" >
                                                                            {{csrf_field()}}

                                                                            <div class="form-group">
                                                                                <div class="form-wrapper">
                                                                                    <label for="course_name">GEPG Control Number</label>

                                                                                    <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControl(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                                    <p id="error_gepg{{$var->invoice_number}}"></p>

                                                                                </div>
                                                                            </div>



                                                                            <br>
                                                                            <div align="right">
                                                                                <button id="sendbtn{{$var->invoice_number}}" class="btn btn-primary" type="submit">Save</button>
                                                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                            </div>
                                                                        </form>


                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>





                                                    <div class="modal fade" id="send_invoice_water{{$var->invoice_number}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">Sending Invoice to {{$var->debtor_name}} </h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="{{ route('send_invoice_water_bills',$var->invoice_number)}}"  id="form1" >
                                                                        {{csrf_field()}}

                                                                        <div class="form-group row">

                                                                            <div class="form-wrapper col-6">
                                                                                <label for="amount">Current Amount</label>
                                                                                <input id="gepg{{$var->invoice_number}}" type="number" min="0" id="amount" name="current_amount" class="form-control" required="">
                                                                            </div>

                                                                            <div class="form-wrapper col-6">
                                                                                <label for="currency">Currency</label>
                                                                                <select id="currency" class="form-control" name="currency" >
                                                                                    <option value="{{$var->currency_invoice}}" >{{$var->currency_invoice}}</option>

                                                                                </select>
                                                                            </div>



                                                                        </div>

                                                                        <br>

                                                                        <div class="form-group">
                                                                            <div class="form-wrapper">
                                                                                <label for="course_name">GEPG Control Number</label>
                                                                                @if($var->gepg_control_no=='')
                                                                                <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControlWater(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control"  name="gepg_control_no" value="" Required autocomplete="off">
                                                                                <p id="error_gepg_water{{$var->invoice_number}}"></p>
                                                                                @else
                                                                                    <input   type="number" class="form-control"  name="gepg_control_no" value="{{$var->gepg_control_no}}" readonly autocomplete="off">
                                                                                @endif


                                                                            </div>
                                                                        </div>





                                                                        <br>
                                                                        <div align="right">
                                                                            <button id="sendbtn_water{{$var->invoice_number}}" class="btn btn-primary" type="submit">Send</button>
                                                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </form>


                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>







                                                @else

                                                @endif


                                                @if($var->email_sent_status=='SENT')

                                                    @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                    @else
                                                        @if($var->payment_status=='Not paid')
                                                            <a title="Receive payment" data-toggle="modal" data-target="#add_comment_water{{$var->invoice_number}}"  role="button" aria-pressed="true"   name="editC"><i class="fa fa-money" style="font-size:20px; color:#3490dc !important;" aria-hidden="true"></i></a>
                                                        @else
                                                        @endif


                                                    @endif

                                                    <div class="modal fade" id="add_comment_water{{$var->invoice_number}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">Invoice Number: {{$var->invoice_number}} </h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="{{ route('change_payment_status_water_bills',$var->invoice_number)}}"  id="form1" >
                                                                        {{csrf_field()}}
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                                                    <input type="number" min="1" class="form-control" id="invoice_number_space" readonly name="invoice_number" value="{{$var->invoice_number}}" Required autocomplete="off">

                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div style="padding-top: 2%;" class="form-group col-md-6">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Votebook Invoice Number <span style="color: red;">*</span></label>
                                                                                    <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>



                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                                                    <input type="number" min="10" class="form-control" id="amount_paid_space" name="amount_paid" value="" Required  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>





                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <label>Currency <span style="color: red;">*</span></label>
                                                                                <div  class="form-wrapper">

                                                                                    <input type="text"  class="form-control" id="currency_space" name="currency_payments" value="{{$var->currency_invoice}}"  readonly autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div class="form-group col-md-12 pt-2">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Date the payment was made by the client<span style="color: red;">*</span></label>
                                                                                    <input type="date" min="{{date_format($date,"Y-m-d")}}" max="{{date("Y-m-d")}}" class="form-control" id="receipt_space" name="date_of_payment" value="" required  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>


                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Receipt Number <span style="color: red;">*</span></label>
                                                                                    <input type="text" class="form-control" id="receipt_space" name="receipt_number" value="" required  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>


                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <div class="form-wrapper">
                                                                                    <label for="course_name">Comments</label>
                                                                                    <input type="text" class="form-control" id="course_name" name="user_comments" value="{{$var->user_comments}}"  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>





                                                                        </div>







                                                                        <div style="padding-top: 2%;" align="right">
                                                                            <button class="btn btn-primary" type="submit">Save</button>
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

                        @else
                            <p>No records found</p>
                        @endif

                    </div>



                    <div id="electricity_invoices" class="tabcontent_inner" style="border: 1px solid #ccc; padding: 1%;">
                        <br>

                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else
                            <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice_electricity" title="Add new electricity bill invoice" role="button" aria-pressed="true">Add New Invoice</a>
                        @endif

                        <center><h3><strong>Electricity bill Invoices</strong></h3></center>
                        <hr>

                        <div class="modal fade" id="new_invoice_electricity" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Create New Electricity Bill Invoice</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <form method="post" action="{{ route('create_electricity_invoice_manually')}}"  id="form1" >
                                            {{csrf_field()}}

                                            <div class="form-row">


                                                <div class="form-group col-md-12">
                                                    <div class="form-wrapper">
                                                        <label for="">Contract ID <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="contract_id_electricity" name="contract_id" value=""  required autocomplete="off">
                                                        <p style="display: none;" class="mt-2 p-1" id="electricity_contract_availability"></p>
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="debtor_name_electricityDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client Full Name <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="debtor_name_electricity" name="debtor_name" value="" readonly Required autocomplete="off">
                                                    </div>
                                                </div>




                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="debtor_account_code_electricityDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client Account Code</label>
                                                        <input type="text" class="form-control" id="debtor_account_code_electricity" name="debtor_account_code" value="" readonly  autocomplete="off">
                                                    </div>
                                                </div>




                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="tin_electricityDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client TIN</label>
                                                        <input type="text" class="form-control" id="tin_electricity" name="tin" value=""  readonly autocomplete="off">
                                                    </div>
                                                </div>







                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="debtor_address_electricityDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client Address <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="debtor_address_electricity" name="debtor_address" value="" readonly Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="invoicing_period_start_date_electricityDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                                        <input type="date" class="form-control" id="invoicing_period_start_date_electricity" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="invoicing_period_end_date_electricityDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                                        <input type="date" class="form-control" id="invoicing_period_end_date_electricity" name="invoicing_period_end_date" value="" Required autocomplete="off">
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="project_id_electricityDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Project ID <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="project_id_electricity" name="project_id" value="" Required autocomplete="off">
                                                    </div>
                                                </div>









                                                <div id="debt_electricityDiv" style="display: none;" class="form-group col-md-6 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for="">Debt <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="debt_electricity" readonly name="debt" value="" Required  autocomplete="off">


                                                    </div>
                                                </div>


                                                <div id="current_amount_electricityDiv" class="form-group col-md-6 mt-1" style="display: none;">
                                                    <div class="form-wrapper">
                                                        <label for="">Current Amount <span style="color: red;">*</span></label>
                                                        <input type="number" min="20" class="form-control" id="current_amount_electricity" name="current_amount" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>


                                                <div id="cumulative_amount_electricityDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for="">Cumulative Amount <span style="color: red;">*</span></label>
                                                        <input type="number" min="20" class="form-control" id="cumulative_amount_electricity" readonly name="cumulative_amount" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>



                                                <div id="currency_electricityDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                    <label>Currency <span style="color: red;">*</span></label>
                                                    <div id="changable_currency_electricity" class="form-wrapper">
                                                        <input type="text" class="form-control" id="currency_electricity" readonly required name="currency"  autocomplete="off">
                                                    </div>
                                                </div>



                                                <div id="status_electricityDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Status <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="" name="status" value="" required  autocomplete="off">
                                                    </div>
                                                </div>


                                                <div id="description_electricityDiv" style="display: none;" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for="" >Description <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="" name="description" value="" required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>



                                            </div>


                                            <div align="right">
                                                <button id="submit_electricity" class="btn btn-primary" type="submit">Save</button>
                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>









                                    </div>
                                </div>
                            </div>


                        </div>



                        <?php
                        $i=1;
                        ?>

                        @if(count($electricity_bill_invoices)>0)



                            <table class="hover table table-striped  table-bordered" id="myTableElectricity">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#fff;"><center>S/N</center></th>
                                    <th scope="col"  style="color:#fff;">Client</th>
                                    <th scope="col" style="color:#fff;"><center>Invoice Number</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Debt</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Current Amount</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Cumulative Amount</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Payment Status</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Invoice Date</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Action</center></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($electricity_bill_invoices as $var)
                                    <tr>
                                        <td><center>{{$i}}</center></td>
                                        <td>{{$var->debtor_name}}</td>
                                        <td><center>{{$var->invoice_number}}</center></td>
                                        <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                        <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                        <td><center>{{number_format($var->debt)}} {{$var->currency_invoice}}</center></td>
                                        @if($var->current_amount==0)
                                            <td><center>N/A</center></td>
                                        @else
                                            <td><center>{{number_format($var->current_amount)}} {{$var->currency_invoice}}</center></td>
                                        @endif
                                        @if($var->cumulative_amount==0)
                                            <td><center>N/A</center></td>
                                        @else
                                            <td><center>{{number_format($var->cumulative_amount)}} {{$var->currency_invoice}}</center></td>
                                        @endif
                                        <td><center>{{$var->payment_status}}</center></td>
                                        <td>{{date("d/m/Y",strtotime($var->invoice_date))}} @if($var->email_sent_status=='NOT SENT')

                                                <span style="float: right !important; " class="badge badge-danger">New</span>
                                            @else
                                            @endif</td>




                                        <td><center>





                                                <a title="View invoice" style="color:#3490dc !important;  "  class="" data-toggle="modal" data-target="#invoice_electricity{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" style="font-size: 20px;" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="invoice_electricity{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Full Invoice Details.</h5></b>

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
                                                                        <td>{{$var->invoice_number}}</td>
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
                                                                        <td> Debt:</td>
                                                                        <td>{{number_format($var->debt)}} {{$var->currency_invoice}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Current Amount:</td>
                                                                        @if($var->current_amount==0)
                                                                            <td>N/A</td>
                                                                        @else
                                                                            <td>{{number_format($var->current_amount)}} {{$var->currency_invoice}}</td>
                                                                        @endif

                                                                    </tr>

                                                                    <tr>

                                                                        <td>Cumulative Amount:</td>
                                                                        @if($var->cumulative_amount==0)
                                                                            <td>N/A</td>
                                                                        @else
                                                                            <td>{{number_format($var->cumulative_amount)}} {{$var->currency_invoice}}</td>
                                                                        @endif
                                                                    </tr>



                                                                    <tr>
                                                                        <td>GEPG Control Number:</td>
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






                                                <a title="View contract" style="color:#3490dc !important; display:inline-block;     margin-top: 3px;
    "  class="" data-toggle="modal" data-target="#contract_electricity{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-file-text" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="contract_electricity{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Contract Details.</h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <table style="width: 100%">

                                                                    <tr>
                                                                        <td>Contract ID:</td>
                                                                        <td>{{$var->contract_id}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td>Client:</td>
                                                                        <td>{{$var->full_name}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> Space Number:</td>
                                                                        <td> {{$var->space_id_contract}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> Amount:</td>
                                                                        <td> {{number_format($var->amount)}} {{$var->currency}}</td>
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

                                                                    <tr>
                                                                        <td>Has Electricity Bill:</td>
                                                                        <td>{{$var->has_electricity_bill}} </td>
                                                                    </tr>




                                                                </table>
                                                                <br>
                                                                <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                @if($var->email_sent_status=='NOT SENT')
                                                    @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                    @else
                                                        @if($var->gepg_control_no=='')
                                                        <a title="Add control number" data-toggle="modal" style="color: #3490dc; cursor: pointer;"  data-target="#add_control_number_electricity{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fas fa-file-medical"></i></a>
                                                        @else
                                                        @endif

                                                        <a title="Send invoice" data-toggle="modal" style=" color: #3490dc; cursor: pointer;"  data-target="#send_invoice_electricity{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                                    @endif


                                                        <div class="modal fade" id="add_control_number_electricity{{$var->invoice_number}}" role="dialog">

                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b><h5 class="modal-title">Adding control number for invoice number {{$var->invoice_number}} </h5></b>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form method="post" action="{{ route('add_control_no_electricity',$var->invoice_number)}}"  id="form1" >
                                                                            {{csrf_field()}}

                                                                            <div class="form-group">
                                                                                <div class="form-wrapper">
                                                                                    <label for="course_name">GEPG Control Number</label>

                                                                                    <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControl(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                                    <p id="error_gepg{{$var->invoice_number}}"></p>

                                                                                </div>
                                                                            </div>



                                                                            <br>
                                                                            <div align="right">
                                                                                <button id="sendbtn{{$var->invoice_number}}" class="btn btn-primary" type="submit">Save</button>
                                                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                            </div>
                                                                        </form>


                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>


                                                    <div class="modal fade" id="send_invoice_electricity{{$var->invoice_number}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">Sending Invoice to {{$var->debtor_name}} </h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="{{ route('send_invoice_electricity_bills',$var->invoice_number)}}"  id="form1" >
                                                                        {{csrf_field()}}


                                                                        <div class="form-group row">

                                                                            <div class="form-wrapper col-6">
                                                                                <label for="amount">Current Amount</label>
                                                                                <input type="number" min="0" id="amount" name="current_amount" class="form-control" required="">
                                                                            </div>

                                                                            <div class="form-wrapper col-6">
                                                                                <label for="currency">Currency</label>
                                                                                <select id="currency" class="form-control" name="currency" >
                                                                                    <option value="{{$var->currency_invoice}}">{{$var->currency_invoice}}</option>
                                                                                </select>
                                                                            </div>



                                                                        </div>

                                                                        <br>



                                                                        <div class="form-group">
                                                                            <div class="form-wrapper">
                                                                                <label for="course_name">GEPG Control Number</label>

                                                                                @if($var->gepg_control_no=='')
                                                                                <input id="gepg_electricity{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);  minControlElectricity(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control"  name="gepg_control_no" value="" Required autocomplete="off">
                                                                                <p id="error_gepg_electricity{{$var->invoice_number}}"></p>
                                                                                @else
                                                                                    <input   type="number" class="form-control"  name="gepg_control_no" value="{{$var->gepg_control_no}}" readonly autocomplete="off">
                                                                                @endif

                                                                            </div>
                                                                        </div>



                                                                        <br>
                                                                        <div align="right">
                                                                            <button id="sendbtn_electricity{{$var->invoice_number}}" class="btn btn-primary" type="submit">Send</button>
                                                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </form>


                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>







                                                @else

                                                @endif


                                                @if($var->email_sent_status=='SENT')


                                                    @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                    @else

                                                        @if($var->payment_status=='Not paid')
                                                            <a title="Receive payment" data-toggle="modal" data-target="#add_comment_electricity{{$var->invoice_number}}"  role="button" aria-pressed="true"   name="editC"><i class="fa fa-money" style="font-size:20px; color:#3490dc !important;" aria-hidden="true"></i></a>
                                                        @else
                                                        @endif
                                                    @endif

                                                    <div class="modal fade" id="add_comment_electricity{{$var->invoice_number}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">Invoice Number: {{$var->invoice_number}} </h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="{{ route('change_payment_status_electricity_bills',$var->invoice_number)}}"  id="form1" >
                                                                        {{csrf_field()}}
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                                                    <input type="number" min="1" class="form-control" id="invoice_number_space" readonly name="invoice_number" value="{{$var->invoice_number}}" Required autocomplete="off">

                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div style="padding-top: 2%;" class="form-group col-md-6">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Votebook Invoice Number <span style="color: red;">*</span></label>
                                                                                    <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>



                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                                                    <input type="number" min="10" class="form-control" id="amount_paid_space" name="amount_paid" value="" Required  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>





                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <label>Currency <span style="color: red;">*</span></label>
                                                                                <div  class="form-wrapper">

                                                                                    <input type="text"  class="form-control" id="currency_space" name="currency_payments" value="{{$var->currency_invoice}}"  readonly autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div class="form-group col-md-12 pt-2">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Date the payment was made by the client<span style="color: red;">*</span></label>
                                                                                    <input type="date" min="{{date_format($date,"Y-m-d")}}" max="{{date("Y-m-d")}}" class="form-control" id="receipt_space" name="date_of_payment" value="" required  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <div class="form-wrapper">
                                                                                    <label for=""  >Receipt Number <span style="color: red;">*</span></label>
                                                                                    <input type="text" class="form-control" id="receipt_space" name="receipt_number" value="" required  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>


                                                                            <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                <div class="form-wrapper">
                                                                                    <label for="course_name">Comments</label>
                                                                                    <input type="text" class="form-control" id="course_name" name="user_comments" value="{{$var->user_comments}}"  autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <br>





                                                                        </div>







                                                                        <div style="padding-top: 2%;" align="right">
                                                                            <button class="btn btn-primary" type="submit">Save</button>
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

                        @else
                            <p>No records found</p>
                        @endif

                    </div>





                </div>


                    <div id="insurance_invoices" class="tabcontent">
                    <br>

                    <?php
                    $i=1;
                    ?>
                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else



                            <div><div style="float:left;"></div> <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice_insurance" title="Add new insurance invoice" role="button" aria-pressed="true">Add New Invoice</a>  <div style="float:right;"><a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#send_invoice_insurance" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true"></i> Send All Invoices</a></div>

                                <div style="clear: both;"></div>

                            </div>

                        @endif

                        <center><h3><strong>Insurance Invoices</strong></h3></center>
                        <hr>
                        <div class="modal fade" id="send_invoice_insurance" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Sending all invoices to respective clients</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <form method="get" action="" >
                                            {{csrf_field()}}

                                            <div align="right">
                                                <button id="send_all_insurance" class="btn btn-primary" type="button" id="newdata">Send</button>
                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="modal fade" id="new_invoice_insurance" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Create New Insurance Invoice</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <form method="post" action="{{ route('create_insurance_invoice_manually')}}"  id="form1" >
                                            {{csrf_field()}}

                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Principal <span style="color: red;">*</span></label>
                                                        <select class="form-control"  id="principal" required name="debtor_name">
                                                            <option value="" ></option>

                                                            <?php
                                                            $insurance_data=DB::table('insurance')->where('status',1)->get();

                                                            $tempOut = array();
                                                            foreach($insurance_data as $values){
                                                                $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($values));
                                                                $val = (iterator_to_array($iterator,true));
                                                                $tempoIn=$val['insurance_company'];

                                                                if(!in_array($tempoIn, $tempOut))
                                                                {
                                                                    print('<option value="'.$val['insurance_company'].'">'.$val['insurance_company'].'</option>');
                                                                    array_push($tempOut,$tempoIn);
                                                                }

                                                            }
                                                            ?>



                                                        </select>
                                                    </div>
                                                </div>





                                                <div class="form-group col-md-6 mt-1"  style="display: none;" id="debtor_account_code_insuranceDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Principal Account Code</label>
                                                        <input type="text" class="form-control" id="debtor_account_code_insurance" readonly name="debtor_account_code" value=""  autocomplete="off">
                                                    </div>
                                                </div>




                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="tin_insuranceDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Principal TIN</label>
                                                        <input type="text" class="form-control" id="tin_insurance" readonly name="tin" value=""  autocomplete="off">
                                                    </div>
                                                </div>





                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="debtor_address_insuranceDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Principal Address <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="debtor_address_insurance" name="debtor_address" value="" readonly Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="invoicing_period_start_date_insuranceDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                                        <input type="date" class="form-control" id="invoicing_period_start_date_insurance" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="invoicing_period_end_date_insuranceDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                                        <input type="date" class="form-control" id="invoicing_period_end_date_insurance" name="invoicing_period_end_date" value="" Required autocomplete="off">
                                                    </div>
                                                </div>







                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="project_id_insuranceDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Project ID <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="project_id_insurance" name="project_id" value="" Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="amount_to_be_paid_insuranceDiv">
                                                    <div class="form-wrapper">
                                                        <label for="">Amount <span style="color: red;">*</span></label>
                                                        <input type="number" min="20" class="form-control" id="amount_to_be_paid_insurance" name="amount_to_be_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>



                                                <div class="form-group col-md-6 mt-1" style="display: none;" id="currency_insuranceDiv">
                                                    <label>Currency <span style="color: red;">*</span></label>
                                                    <div  class="form-wrapper">
                                                        <select id="currency_insurance" class="form-control" required name="currency">
                                                            <option value="" ></option>
                                                            <option value="TZS" >TZS</option>
                                                            <option value="USD" >USD</option>
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="status_insuranceDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Status <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="status_insurance" name="status" value="" required  autocomplete="off">
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="description_insuranceDiv">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Description <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="description_insurance" name="description" value="" required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>






                                            </div>


                                            <div align="right">
                                                <button class="btn btn-primary" type="submit">Save</button>
                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>









                                    </div>
                                </div>
                            </div>


                        </div>



                    @if(count($insurance_invoices)>0)



                        <table class="hover table table-striped  table-bordered" id="myTableInsurance">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#fff;"><center>S/N</center></th>
                                <th scope="col"  style="color:#fff;">Client</th>
                                <th scope="col" style="color:#fff;"><center>Invoice Number</center></th>
                                <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
                                <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                                <th scope="col"  style="color:#fff;"><center>Amount</center></th>
                                <th scope="col"  style="color:#fff;"><center>Payment Status</center></th>
                                <th scope="col"  style="color:#fff;"><center>Invoice Date</center></th>
                                <th scope="col"  style="color:#fff;"><center>Action</center></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($insurance_invoices as $var)
                                <tr>
                                    <td><center>{{$i}}</center></td>
                                    <td>{{$var->debtor_name}}</td>
                                    <td><center>{{$var->invoice_number}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                    <td><center>{{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</center></td>
                                    <td><center>{{$var->payment_status}}</center></td>
                                    <td>{{date("d/m/Y",strtotime($var->invoice_date))}} @if($var->email_sent_status=='NOT SENT')

                                            <span style="float: right !important; " class="badge badge-danger">New</span>
                                        @else
                                        @endif</td>




                                    <td><center>





                                            <a title="View invoice" style="color:#3490dc !important; display:inline-block;"  class="" data-toggle="modal" data-target="#invoice_insurance{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true" style="font-size: 20px;"></i></center></a>
                                            <div class="modal fade" id="invoice_insurance{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Full Invoice Details.</h5></b>

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
                                                                    <td>{{$var->invoice_number}}</td>
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
                                                                    <td> {{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>GEPG Control Number:</td>
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










                                            @if($var->email_sent_status=='NOT SENT')

                                                @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                @else

                                                    @if($var->gepg_control_no=='')
                                                    <a title="Add control number" data-toggle="modal" style="color: #3490dc; cursor: pointer;"  data-target="#add_control_number_insurance{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fas fa-file-medical"></i></a>
                                                    @else
                                                    @endif


                                                        <div class="modal fade" id="add_control_number_insurance{{$var->invoice_number}}" role="dialog">

                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b><h5 class="modal-title">Adding control number for invoice number {{$var->invoice_number}} </h5></b>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form method="post" action="{{ route('add_control_no_insurance',$var->invoice_number)}}"  id="form1" >
                                                                            {{csrf_field()}}

                                                                            <div class="form-group">
                                                                                <div class="form-wrapper">
                                                                                    <label for="course_name">GEPG Control Number</label>

                                                                                    <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControl(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                                    <p id="error_gepg{{$var->invoice_number}}"></p>

                                                                                </div>
                                                                            </div>



                                                                            <br>
                                                                            <div align="right">
                                                                                <button id="sendbtn{{$var->invoice_number}}" class="btn btn-primary" type="submit">Save</button>
                                                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                            </div>
                                                                        </form>


                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                <a title="Send invoice" data-toggle="modal" style=" color: #3490dc; cursor: pointer;"  data-target="#send_invoice_insurance{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                                @endif

                                                <div class="modal fade" id="send_invoice_insurance{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Sending Invoice to {{$var->debtor_name}} </h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form method="post" action="{{ route('send_invoice_insurance',$var->invoice_number)}}"  id="form1" >
                                                                    {{csrf_field()}}

                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="course_name">GEPG Control Number</label>

                                                                            @if($var->gepg_control_no=='')
                                                                            <input id="gepg{{$var->invoice_number}}"  type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControlInsurance(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                                <p id="error_gepg_insurance{{$var->invoice_number}}"></p>
                                                                            @else
                                                                                <input   type="number" class="form-control"  name="gepg_control_no" value="{{$var->gepg_control_no}}" readonly autocomplete="off">
                                                                            @endif

                                                                        </div>
                                                                    </div>



                                                                    <br>
                                                                    <div align="right">
                                                                        <button id="sendbtn_insurance{{$var->invoice_number}}" class="btn btn-primary" type="submit">Send</button>
                                                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>


                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>







                                            @else

                                            @endif


                                            @if($var->email_sent_status=='SENT')

                                                @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                @else
                                                    @if($var->payment_status=='Not paid')
                                            <a title="Receive payment" data-toggle="modal" data-target="#add_comment_insurance{{$var->invoice_number}}"  role="button" aria-pressed="true"   name="editC"><i class="fa fa-money" style="font-size:20px; color:#3490dc !important;" aria-hidden="true"></i></a>
                                                    @else
                                                        @endif

                                                    @endif

                                            <div class="modal fade" id="add_comment_insurance{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Invoice Number: {{$var->invoice_number}} </h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form method="post" action="{{ route('change_payment_status_insurance',$var->invoice_number)}}"  id="form1" >
                                                                {{csrf_field()}}
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                                            <input type="number" min="1" class="form-control" id="invoice_number_space" readonly name="invoice_number" value="{{$var->invoice_number}}" Required autocomplete="off">

                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div style="padding-top: 2%;" class="form-group col-md-6">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  >Votebook Invoice Number <span style="color: red;">*</span></label>
                                                                            <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>



                                                                    <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                        <div class="form-wrapper">
                                                                            <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                                            <input type="number" min="10" class="form-control" id="amount_paid_space" name="amount_paid" value="" Required  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>





                                                                    <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                        <label>Currency <span style="color: red;">*</span></label>
                                                                        <div  class="form-wrapper">

                                                                            <input type="text"  class="form-control" id="currency_space" name="currency_payments" value="{{$var->currency_invoice}}"  readonly autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div class="form-group col-md-12 pt-2">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  >Date the payment was made by the client<span style="color: red;">*</span></label>
                                                                            <input type="date" min="{{date_format($date,"Y-m-d")}}" max="{{date("Y-m-d")}}" class="form-control" id="receipt_space" name="date_of_payment" value="" required  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  >Receipt Number <span style="color: red;">*</span></label>
                                                                            <input type="text" class="form-control" id="receipt_space" name="receipt_number" value="" required  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                        <div class="form-wrapper">
                                                                            <label for="course_name">Comments</label>
                                                                            <input type="text" class="form-control" id="course_name" name="user_comments" value="{{$var->user_comments}}"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>





                                                                </div>







                                                                <div style="padding-top: 2%;" align="right">
                                                                    <button class="btn btn-primary" type="submit">Save</button>
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

                    @else
                        <p>No records found</p>
                    @endif

                </div>

                    <div id="car_invoices" class="tabcontent">
                    <br>

                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else

                            <div><div style="float:left;"></div> <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice_car" title="Add new car rental invoice" role="button" aria-pressed="true">Add New Invoice</a>  <div style="float:right;"><a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#send_invoice_car" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true"></i> Send All Invoices</a></div>

                                <div style="clear: both;"></div>

                            </div>

                        @endif

                        <center><h3><strong>Car Rental Invoices</strong></h3></center>
                        <hr>

                        <div class="modal fade" id="send_invoice_car" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Sending all invoices to respective clients</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <form method="get" action="" >
                                            {{csrf_field()}}

                                            <div align="right">
                                                <button id="send_all_car" class="btn btn-primary" type="button" id="newdata">Send</button>
                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div>


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



                                                <div id="debtor_name_carDiv" style="display:none;" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client Full Name <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="debtor_name_car" name="debtor_name" readonly value="" Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div id="vrn_carDiv" style="display:none;" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Vehicle Registration Number (VRN)</label>
                                                        <input type="text" class="form-control" id="vrn_car" name="vrn" value="" readonly  autocomplete="off">
                                                    </div>
                                                </div>



                                                <div id="debtor_address_carDiv" style="display:none;" class="form-group col-md-12 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Client Address <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="debtor_address_car" name="debtor_address" value="" Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div style="display:none;" id="invoicing_period_start_date_carDiv" class="form-group col-md-6 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                                        <input type="date" class="form-control" id="invoicing_period_start_date_car" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                                    </div>
                                                </div>



                                                <div style="display:none;" id="invoicing_period_end_date_carDiv" class="form-group col-md-6 mt-1">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                                        <input type="date" class="form-control" id="invoicing_period_end_date_car" name="invoicing_period_end_date" value="" Required autocomplete="off">
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
                                                <button id="submit_car" class="btn btn-primary" type="submit">Save</button>
                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>









                                    </div>
                                </div>
                            </div>


                        </div>

                    <?php
                    $i=1;
                    ?>

                    @if(count($car_rental_invoices)>0)



                        <table class="hover table table-striped  table-bordered" id="myTableCar">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#fff;"><center>S/N</center></th>
                                <th scope="col"  style="color:#fff;">Client</th>
                                <th scope="col" style="color:#fff;"><center>Invoice Number</center></th>
                                <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
                                <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                                <th scope="col"  style="color:#fff;"><center>Amount</center></th>
                                <th scope="col"  style="color:#fff;"><center>Payment Status</center></th>
                                <th scope="col"  style="color:#fff;"><center>Invoice Date</center></th>
                                <th scope="col"  style="color:#fff;"><center>Action</center></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($car_rental_invoices as $var)
                                <tr>
                                    <td><center>{{$i}}</center></td>
                                    <td>{{$var->debtor_name}}</td>
                                    <td><center>{{$var->invoice_number}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                    <td><center>{{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</center></td>
                                    <td><center>{{$var->payment_status}}</center></td>
                                    <td>{{date("d/m/Y",strtotime($var->invoice_date))}} @if($var->email_sent_status=='NOT SENT')

                                            <span style="float: right !important; " class="badge badge-danger">New</span>
                                        @else
                                        @endif </td>




                                    <td><center>





                                            <a title="View invoice" style="color:#3490dc !important; display:inline-block; cursor: pointer;"  class="" data-toggle="modal" data-target="#invoice_car{{$var->invoice_number}}"  aria-pressed="true"><i class="fa fa-eye" style="font-size: 20px;" aria-hidden="true"></i></a>
                                            <div class="modal fade" id="invoice_car{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Full Invoice Details.</h5></b>

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
                                                                    <td>{{$var->invoice_number}}</td>
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
                                                                    <td> {{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>GEPG Control Number:</td>
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






                                            <a title="View contract" style="color:#3490dc !important; display:inline-block;"  class="" data-toggle="modal" data-target="#contract_car{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><i class="fa fa-file-text" aria-hidden="true"></i></a>
                                            <div class="modal fade" id="contract_car{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Contract Details</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%">

                                                                <tr>
                                                                    <td>Contract ID:</td>
                                                                    <td>{{$var->contract_id}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Client:</td>
                                                                    <td>{{$var->fullName}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Vehicle Registration Number:</td>
                                                                    <td> {{$var->vehicle_reg_no}}</td>
                                                                </tr>




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
                                                                    <td>{{number_format($var->grand_total)}} TZS</td>
{{--                                                                    <td>{{number_format($var->amount)}} {{$var->currency}}</td>--}}
                                                                </tr>
{{--                                                                <tr>--}}
{{--                                                                    <td>Rate:</td>--}}
{{--                                                                    <td>{{$var->rate}}</td>--}}
{{--                                                                </tr>--}}

                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            @if($var->email_sent_status=='NOT SENT')
                                                @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                @else

                                                    @if($var->gepg_control_no=='')
                                                    <a title="Add control number" data-toggle="modal" style="color: #3490dc; cursor: pointer;"  data-target="#add_control_number_car{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fas fa-file-medical"></i></a>
                                                    @else
                                                    @endif


                                                <a title="Send invoice" data-toggle="modal" style=" color: #3490dc; cursor: pointer;"  data-target="#send_invoice_car{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                                @endif


                                                    <div class="modal fade" id="add_control_number_car{{$var->invoice_number}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">Adding control number for invoice number {{$var->invoice_number}} </h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="{{ route('add_control_no_car',$var->invoice_number)}}"  id="form1" >
                                                                        {{csrf_field()}}

                                                                        <div class="form-group">
                                                                            <div class="form-wrapper">
                                                                                <label for="course_name">GEPG Control Number</label>

                                                                                <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControl(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                                <p id="error_gepg{{$var->invoice_number}}"></p>

                                                                            </div>
                                                                        </div>



                                                                        <br>
                                                                        <div align="right">
                                                                            <button id="sendbtn{{$var->invoice_number}}" class="btn btn-primary" type="submit">Save</button>
                                                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </form>


                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>




                                                <div class="modal fade" id="send_invoice_car{{$var->invoice_number}}" role="dialog">

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
                                                                            @if($var->gepg_control_no=='')
                                                                            <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControlCar(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                            <p id="error_gepg_car{{$var->invoice_number}}"></p>
                                                                            @else
                                                                                <input   type="number" class="form-control"  name="gepg_control_no" value="{{$var->gepg_control_no}}" readonly autocomplete="off">
                                                                            @endif

                                                                        </div>
                                                                    </div>



                                                                    <br>
                                                                    <div align="right">
                                                                        <button id="sendbtn_car{{$var->invoice_number}}" class="btn btn-primary" type="submit">Send</button>
                                                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>


                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>







                                            @else

                                            @endif


                                            @if($var->email_sent_status=='SENT')

                                                @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                @else
                                                    @if($var->payment_status=='Not paid')
                                            <a title="Receive payment" data-toggle="modal" data-target="#add_comment_car{{$var->invoice_number}}"  role="button" aria-pressed="true"   name="editC"><i class="fa fa-money" style="font-size:20px; color:#3490dc !important;" aria-hidden="true"></i></a>
                                                    @else
                                                        @endif

                                            @endif

                                            <div class="modal fade" id="add_comment_car{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Invoice Number: {{$var->invoice_number}} </h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form method="post" action="{{ route('change_payment_status_car_rental',$var->invoice_number)}}"  id="form1" >
                                                                {{csrf_field()}}
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                                            <input type="number" min="1" class="form-control" id="invoice_number_space" readonly name="invoice_number" value="{{$var->invoice_number}}" Required autocomplete="off">

                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div style="padding-top: 2%;" class="form-group col-md-6">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  >Votebook Invoice Number <span style="color: red;">*</span></label>
                                                                            <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>



                                                                    <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                        <div class="form-wrapper">
                                                                            <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                                            <input type="number" min="10" class="form-control" id="amount_paid_space" name="amount_paid" value="" Required  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>





                                                                    <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                        <label>Currency <span style="color: red;">*</span></label>
                                                                        <div  class="form-wrapper">

                                                                            <input type="text"  class="form-control" id="currency_space" name="currency_payments" value="{{$var->currency_invoice}}"  readonly autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div class="form-group col-md-12 pt-2">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  >Date the payment was made by the client<span style="color: red;">*</span></label>
                                                                            <input type="date" min="{{date_format($date,"Y-m-d")}}" max="{{date("Y-m-d")}}" class="form-control" id="receipt_space" name="date_of_payment" value="" required  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  >Receipt Number <span style="color: red;">*</span></label>
                                                                            <input type="text" class="form-control" id="receipt_space" name="receipt_number" value="" required  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                        <div class="form-wrapper">
                                                                            <label for="course_name">Comments</label>
                                                                            <input type="text" class="form-control" id="course_name" name="user_comments" value="{{$var->user_comments}}"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>





                                                                </div>







                                                                <div style="padding-top: 2%;" align="right">
                                                                    <button class="btn btn-primary" type="submit">Save</button>
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

                    @else
                        <p>No records found</p>
                    @endif

                </div>












            </div>
        </div>
    </div>
@endsection

@section('pagescript')
<script>

    function minControl(value,id){



if(value.length<12){

    document.getElementById("sendbtn"+id).disabled = true;
    document.getElementById("error_gepg"+id).style.color = 'red';
    document.getElementById("error_gepg"+id).style.float = 'left';
    document.getElementById("error_gepg"+id).style.paddingTop = '1%';
    document.getElementById("error_gepg"+id).innerHTML ='GEPG Control number cannot be less than 12 digits';

}else{
    document.getElementById("error_gepg"+id).innerHTML ='';
    document.getElementById("sendbtn"+id).disabled = false;
}

    }


    function minControlInsurance(value,id){



        if(value.length<12){

            document.getElementById("sendbtn_insurance"+id).disabled = true;
            document.getElementById("error_gepg_insurance"+id).style.color = 'red';
            document.getElementById("error_gepg_insurance"+id).style.float = 'left';
            document.getElementById("error_gepg_insurance"+id).style.paddingTop = '1%';
            document.getElementById("error_gepg_insurance"+id).innerHTML ='GEPG Control number cannot be less than 12 digits';

        }else{
            document.getElementById("error_gepg_insurance"+id).innerHTML ='';
            document.getElementById("sendbtn_insurance"+id).disabled = false;
        }

    }


    function minControlWater(value,id){




        if(value.length<12){

            document.getElementById("sendbtn_water"+id).disabled = true;
            document.getElementById("error_gepg_water"+id).style.color = 'red';
            document.getElementById("error_gepg_water"+id).style.float = 'left';
            document.getElementById("error_gepg_water"+id).style.paddingTop = '1%';
            document.getElementById("error_gepg_water"+id).innerHTML ='GEPG Control number cannot be less than 12 digits';

        }else{
            document.getElementById("error_gepg_water"+id).innerHTML ='';
            document.getElementById("sendbtn_water"+id).disabled = false;
        }

    }

    function minControlElectricity(value,id){
        console.log('executed');


        if(value.length<12){

            document.getElementById("sendbtn_electricity"+id).disabled = true;
            document.getElementById("error_gepg_electricity"+id).style.color = 'red';
            document.getElementById("error_gepg_electricity"+id).style.float = 'left';
            document.getElementById("error_gepg_electricity"+id).style.paddingTop = '1%';
            document.getElementById("error_gepg_electricity"+id).innerHTML ='GEPG Control number cannot be less than 12 digits';

        }else{
            document.getElementById("error_gepg_electricity"+id).innerHTML ='';
            document.getElementById("sendbtn_electricity"+id).disabled = false;
        }

    }


    function minControlCar(value,id){



        if(value.length<12){

            document.getElementById("sendbtn_car"+id).disabled = true;
            document.getElementById("error_gepg_car"+id).style.color = 'red';
            document.getElementById("error_gepg_car"+id).style.float = 'left';
            document.getElementById("error_gepg_car"+id).style.paddingTop = '1%';
            document.getElementById("error_gepg_car"+id).innerHTML ='GEPG Control number cannot be less than 12 digits';

        }else{
            document.getElementById("error_gepg_car"+id).innerHTML ='';
            document.getElementById("sendbtn_car"+id).disabled = false;
        }

    }
</script>




    <script type="text/javascript">
        window.onload=function(){
                <?php
                $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
                $space_status=0;
                $insurance_status=0;
                $car_status=0;

                if ($category=='Real Estate only' OR $category=='All') {
                    $space_status=1;
                }
                else{

                }

                if ($category=='CPTU only' OR $category=='All') {
                    $car_status=1;
                }
                else{

                }

                if ($category=='Insurance only' OR $category=='All') {
                    $insurance_status=1;
                }
                else{

                }

                ?>



            var space_x={!! json_encode($space_status) !!};
            var insurance_x={!! json_encode($insurance_status) !!};
            var car_x={!! json_encode($car_status) !!};

            console.log('space'+space_x);
            console.log('insurance'+insurance_x);
            console.log('car'+car_x);

            if(space_x==1){

                $(".insurance_identity").removeClass("defaultInvoice");
                $(".car_identity").removeClass("defaultInvoice");
                $('.space_identity').addClass('defaultInvoice');
                console.log('insuracne executed');

            }else if(insurance_x==1){
                $(".space_identity").removeClass("defaultInvoice");
                $(".car_identity").removeClass("defaultInvoice");
                $('.insurance_identity').addClass('defaultInvoice');
                console.log('insuracne executed');

            }else if(car_x==1){
                $(".space_identity").removeClass("defaultInvoice");
                $(".insurance_identity").removeClass("defaultInvoice");
                $('.car_identity').addClass('defaultInvoice');
                console.log('car executed');


            }else{

            }



            document.querySelector('.defaultInvoice').click();

        };
    </script>



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

    </script>




<script type="text/javascript">
    function openInnerInvoices(evt, evtName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent_inner");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks_inner");

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
            dom: '<"top"fl>rt<"bottom"pi>',



        } );



        // var t = $('#myTable').DataTable( {
        //     dom: '<"top"fl>rt<"bottom"pi>',
        //     "columnDefs": [ {
        //         "searchable": false,
        //         "orderable": false,
        //         "targets": 0
        //     } ],
        //     "order": [[ 1, 'asc' ]]
        //
        //
        // } );
        //
        // t.on( 'order.dt search.dt', function () {
        //     t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        //         cell.innerHTML = i+1;
        //     } );
        // } ).draw();


        var table = $('#myTableCar').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

        var table = $('#myTableInsurance').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

        var table = $('#myTableWater').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

        var table = $('#myTableElectricity').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );


    </script>


    <script>


        $('#principal').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('get_info_insurance') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='0'){





                        }
                        else{


                            $('#amount_to_be_paid_insuranceDiv').show();
                            $('#currency_insuranceDiv').show();
                            $('#description_insuranceDiv').show();
                            $('#status_insuranceDiv').show();
                            $('#debtor_name_insuranceDiv').show();
                            $('#debtor_account_code_insuranceDiv').show();
                            $('#tin_insuranceDiv').show();
                            $('#vrn_insuranceDiv').show();
                            $('#debtor_address_insuranceDiv').show();
                            $('#invoicing_period_start_date_insuranceDiv').show();
                            $('#invoicing_period_end_date_insuranceDiv').show();
                            $('#project_id_insuranceDiv').show();

                            //for data

                            $('#debtor_account_code_insurance').val(data[0].id);
                            $('#tin_insurance').val(data[0].company_tin);
                            $('#vrn_insurance').val(data[0].company_vrn);
                            $('#debtor_address_insurance').val(data[0].company_address);


                            // if(final_data.currency_payments=='default'){
                            //
                            //     $('#changable_currency_insurance').html("<select id=\"\" class=\"form-control\" required name=\"currency\">\n" +
                            //         "                                                        <option value=\"\" ></option>\n" +
                            //         "                                                        <option value=\"TZS\" >TZS</option>\n" +
                            //         "                                                        <option value=\"USD\" >USD</option>\n" +
                            //         "                                                    </select>");
                            //
                            // }else{
                            //     $('#changable_currency_insurance').html("<input type=\"text\" class=\"form-control\" id=\"currency_electricity\" readonly required name=\"currency\"  autocomplete=\"off\">");
                            //
                            //     $('#currency_insurance').val(final_data.currency_payments);
                            // }

                            $('#status_insuranceDiv').show();




                        }
                    }
                });
            }
            else if(query==''){

                $('#amount_to_be_paid_insuranceDiv').hide();
                $('#currency_insuranceDiv').hide();
                $('#description_insuranceDiv').hide();
                $('#status_insuranceDiv').hide();
                $('#debtor_name_insuranceDiv').hide();
                $('#debtor_account_code_insuranceDiv').hide();
                $('#tin_insuranceDiv').hide();
                $('#vrn_insuranceDiv').hide();
                $('#debtor_address_insuranceDiv').hide();
                $('#invoicing_period_start_date_insuranceDiv').hide();
                $('#invoicing_period_end_date_insuranceDiv').hide();
                $('#project_id_insuranceDiv').hide();

            }
        });




        $('#contract_id_electricity').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('contract_availability_electricity') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='x'){
                            $('#contract_id_electricity').attr('style','border:1px solid #f00');
                            $("#electricity_contract_availability").css("color","red");
                            $("#electricity_contract_availability").css("display","block");
                            $("#electricity_contract_availability").css("background-color","#ccd8e263");
                            $("#electricity_contract_availability").html("Contract does not exist or does not include electricity bill");
                            $('#debt_electricityDiv').hide();
                            $('#current_amount_electricityDiv').hide();
                            $('#cumulative_amount_electricityDiv').hide();
                            $('#currency_electricityDiv').hide();
                            $('#description_electricityDiv').hide();
                            $('#status_electricityDiv').hide();
                            $('#submit_electricity').prop('disabled', true);

                            $('#debtor_name_electricityDiv').hide();
                            $('#debtor_account_code_electricityDiv').hide();
                            $('#tin_electricityDiv').hide();
                            $('#vrn_electricityDiv').hide();
                            $('#debtor_address_electricityDiv').hide();
                            $('#invoicing_period_start_date_electricityDiv').hide();
                            $('#invoicing_period_end_date_electricityDiv').hide();
                            $('#project_id_electricityDiv').hide();



                        }
                        else{
                            var final_data=JSON.parse(data);

                            $("#electricity_contract_availability").html("");
                            $('#contract_id_electricity').attr('style','border:1px solid #ced4da');
                            $('#debt_electricityDiv').show();

                            $('#debt_electricity').val(final_data.amount_not_paid);

                            $('#current_amount_electricityDiv').show();
                            $('#cumulative_amount_electricityDiv').show();
                            $('#currency_electricityDiv').show();
                            $('#description_electricityDiv').show();

                            $('#debtor_name_electricityDiv').show();
                            $('#debtor_account_code_electricityDiv').show();
                            $('#tin_electricityDiv').show();
                            $('#vrn_electricityDiv').show();
                            $('#debtor_address_electricityDiv').show();
                            $('#invoicing_period_start_date_electricityDiv').show();
                            $('#invoicing_period_end_date_electricityDiv').show();
                            $('#project_id_electricityDiv').show();

                            //for data
                            $('#debtor_name_electricity').val(final_data.full_name);
                            $('#debtor_account_code_electricity').val(final_data.client_id);
                            $('#tin_electricity').val(final_data.tin);
                            $('#vrn_electricity').val(final_data.vrn);
                            $('#debtor_address_electricity').val(final_data.address);


                            if(final_data.currency_payments=='default'){

                                $('#changable_currency_electricity').html("<select id=\"\" class=\"form-control\" required name=\"currency\">\n" +
                                    "                                                        <option value=\"\" ></option>\n" +
                                    "                                                        <option value=\"TZS\" >TZS</option>\n" +
                                    "                                                        <option value=\"USD\" >USD</option>\n" +
                                    "                                                    </select>");

                            }else{
                                $('#changable_currency_electricity').html("<input type=\"text\" class=\"form-control\" id=\"currency_electricity\" readonly required name=\"currency\"  autocomplete=\"off\">");

                                $('#currency_electricity').val(final_data.currency_payments);
                            }

                            $('#status_electricityDiv').show();
                            $('#submit_electricity').prop('disabled', false);
                            $("#electricity_contract_availability").css("display","none");


                        }
                    }
                });
            }
            else if(query==''){

                $('#contract_id_electricity').attr('style','border:1px solid #ced4da');
            }
        });




        $('#current_amount_electricity').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();

            var current=$('#current_amount_electricity').val();
            var debt=$('#debt_electricity').val();
            if(query != '')
            {
                $('#cumulative_amount_electricity').val(parseInt(debt, 10)+parseInt(current, 10));


            }
            else {
                $('#cumulative_amount_electricity').val("");


            }
        });

        $('#current_amount_water').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();

            var current=$('#current_amount_water').val();
            var debt=$('#debt_water').val();
            if(query != '')
            {
                $('#cumulative_amount_water').val(parseInt(debt, 10)+parseInt(current, 10));


            }
            else {
                $('#cumulative_amount_water').val("");


            }
        });


        $('#contract_id_water').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('contract_availability_water') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='x'){
                            $('#contract_id_water').attr('style','border:1px solid #f00');
                            $("#water_contract_availability").css("color","red");
                            $("#water_contract_availability").css("background-color","#ccd8e263");
                            $("#water_contract_availability").css("display","block");
                            $("#water_contract_availability").html("Contract does not exist or does not include water bill");
                            $('#debt_waterDiv').hide();
                            $('#current_amount_waterDiv').hide();
                            $('#cumulative_amount_waterDiv').hide();
                            $('#currency_waterDiv').hide();
                            $('#description_waterDiv').hide();
                            $('#status_waterDiv').hide();
                            $('#submit_water').prop('disabled', true);


                            $('#debtor_name_waterDiv').hide();
                            $('#debtor_account_code_waterDiv').hide();
                            $('#tin_waterDiv').hide();
                            $('#vrn_waterDiv').hide();
                            $('#debtor_address_waterDiv').hide();
                            $('#invoicing_period_start_date_waterDiv').hide();
                            $('#invoicing_period_end_date_waterDiv').hide();
                            $('#project_id_waterDiv').hide();



                        }
                        else{
                            $("#water_contract_availability").html("");
                            $('#contract_id_water').attr('style','border:1px solid #ced4da');
                            $('#debt_waterDiv').show();
                            $('#description_waterDiv').show();

                            var final_data=JSON.parse(data);



                            $('#debt_water').val(final_data.amount_not_paid);

                            $('#current_amount_waterDiv').show();
                            $('#cumulative_amount_waterDiv').show();
                            $('#currency_waterDiv').show();
                            $('#status_waterDiv').show();

                            $('#debtor_name_waterDiv').show();
                            $('#debtor_account_code_waterDiv').show();
                            $('#tin_waterDiv').show();
                            $('#vrn_waterDiv').show();
                            $('#debtor_address_waterDiv').show();
                            $('#invoicing_period_start_date_waterDiv').show();
                            $('#invoicing_period_end_date_waterDiv').show();
                            $('#project_id_waterDiv').show();


                            //for data
                            $('#debtor_name_water').val(final_data.full_name);
                            $('#debtor_account_code_water').val(final_data.client_id);
                            $('#tin_water').val(final_data.tin);
                            $('#vrn_water').val(final_data.vrn);
                            $('#debtor_address_water').val(final_data.address);



                            if(final_data.currency_payments=='default'){

                                $('#changable_currency_water').html("<select id=\"\" class=\"form-control\" required name=\"currency\">\n" +
                                    "                                                        <option value=\"\" ></option>\n" +
                                    "                                                        <option value=\"TZS\" >TZS</option>\n" +
                                    "                                                        <option value=\"USD\" >USD</option>\n" +
                                    "                                                    </select>");

                            }else{
                                $('#changable_currency_water').html("<input type=\"text\" class=\"form-control\" id=\"currency_water\" readonly required name=\"currency\"  autocomplete=\"off\">");
                                $('#currency_water').val(final_data.currency_payments);

                            }


                            $('#submit_water').prop('disabled', false);
                            $("#water_contract_availability").css("display","none");

                        }
                    }
                });
            }
            else if(query==''){

                $('#contract_id_water').attr('style','border:1px solid #ced4da');
            }
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
                            $('#debtor_account_codeDiv').hide();
                            $('#tinDiv').hide();
                            $('#vrnDiv').hide();
                            $('#debtor_addressDiv').hide();
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
                            $('#debtor_account_codeDiv').show();
                            $('#tinDiv').show();
                            $('#vrnDiv').show();
                            $('#debtor_addressDiv').show();
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
                            $('#debtor_account_code_carDiv').hide();
                            $('#tin_carDiv').hide();
                            $('#vrn_carDiv').hide();
                            $('#debtor_address_carDiv').hide();
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
                            $('#debtor_account_code_carDiv').show();
                            $('#tin_carDiv').show();
                            $('#vrn_carDiv').show();
                            $('#debtor_address_carDiv').show();
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

        $('#myTableCar tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        } );


        $('#myTableCar tbody').on( 'click', 'tr', function () {
            document.getElementById("aia_par_names").innerHTML="";
            document.getElementById("aia_greetings").value="Dear ";
            var email2 = $(this).find('td:eq(8)').text();
            if(email2==" "){
                //alert("This client has no email");
            }
            else{
                $(this).toggleClass('selected');
                var count4=table4.rows('.selected').data().length +' row(s) selected';
                if(count4>'2'){
                        <?php $role=Auth::user()->role;?>
                    var role={!! json_encode($role) !!};
                    if(role=='System Administrator'){
                        $('#notify_all_cptu').show();
                    }
                    else{
                        $('#notify_all_cptu').hide();
                    }
                }
                else{
                    $('#notify_all_cptu').hide();
                }
            }

        });


        $('#send_all_space').click(function() {

            $.ajax({
                url:"{{ route('send_all_invoices_space') }}",
                method:"GET",
                success:function(data){
                    console.log(data);
                }
            });

        });



        $('#send_all_car').click(function() {

            $.ajax({
                url:"{{ route('send_all_invoices_car') }}",
                method:"GET",
                success:function(data){
                    console.log(data);
                }
            });

        });


        $('#send_all_insurance').click(function() {

            $.ajax({
                url:"{{ route('send_all_invoices_insurance') }}",
                method:"GET",
                success:function(data){
                    console.log(data);
                }
            });

        });




    </script>




@endsection
