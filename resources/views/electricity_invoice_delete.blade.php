<div id="electricity_invoices" class="tabcontent_inner" style="border-bottom-left-radius: 50px 20px;  border: 1px solid #ccc; padding: 1%;">
    <br>
    <h3 style="text-align: center"><strong>Electricity bill Invoices</strong></h3>

    <hr>
    @if($privileges=='Read only')
    @else

        <div style="margin-bottom: 3%;"><div style="float:left;"></div><a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice_electricity" title="Add new electricity bill invoice" role="button" aria-pressed="true">Add New Invoice</a>

            <div style="float:right;"><a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#send_invoice_electricity" role="button" aria-pressed="true"><i class="fa fa-envelope" aria-hidden="true"></i> Send All Invoices</a></div>

            <div style="clear: both;"></div>

        </div>

    @endif





    <div class="modal fade" id="send_invoice_electricity" role="dialog">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b><h5 class="modal-title">Sending all invoices to respective clients</h5></b>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form method="get" action="{{ route('send_all_invoices_electricity')}}">
                        {{csrf_field()}}

                        <div align="right">
                            <button id="send_all_electricity" class="btn btn-primary" type="submit" id="newdata">Send</button>
                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>


    </div>




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


                            <div id="invoice_number_electricitybillDiv" style="display: none;" class="form-group col-md-12">
                                <div class="form-wrapper">
                                    <label for="">Invoice number <span style="color: red;">*</span></label>
                                    <input type="number" min="1" class="form-control" id="invoice_number_electricitybill" name="invoice_number" value=""  required autocomplete="off">

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




                            {{--                                                <div class="form-group col-md-12 mt-1" style="display: none;" id="tin_electricityDiv">--}}
                            {{--                                                    <div class="form-wrapper">--}}
                            {{--                                                        <label for=""  >Client TIN</label>--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            <input type="hidden" class="form-control" id="tin_electricity" name="tin" value=""  readonly autocomplete="off">







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

        <div class="col-sm-12">
            <div class="pull-right">
                <form class="form-inline" role="form" method="post" accept-charset="utf-8">

                    <div class="form-group row" style="margin-right: 5px;">
                        <div style="padding: 0px 7px;">
                            From
                        </div>
                        <div >
                            <input type="date" id="start_date5" name="start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
                            <span id="start_msg5"></span>
                        </div>

                        <div style="padding: 0px 7px;">
                            To
                        </div>

                        <div >
                            <input type="date" id="end_date5" name="end_date" class="form-control"  max="<?php echo(date('Y-m-d'))?>">
                            <span id="end_msg5"></span>
                        </div>
                    </div>

                    <div class="form-group"  style="margin-right: -13px;">
                        <input type="submit" name="filter" value="Filter" id="electricity_filter" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <div id="electricity_content">
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
                        <td><center>{{$var->invoice_number_votebook}}</center></td>
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
                                                <table class="table table-striped table-bordered " style="width: 100%">

                                                    <tr>
                                                        <td>Client:</td>
                                                        <td>{{$var->debtor_name}}</td>
                                                    </tr>


                                                    <tr>
                                                        <td>Invoice Number:</td>
                                                        <td>{{$var->invoice_number_votebook}}</td>
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
                                                <table class="table table-striped table-bordered " style="width: 100%">

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
                                    @if($privileges=='Read only')
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
                                                    <b><h5 class="modal-title">Adding control number</h5></b>

                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('add_control_no_electricity',$var->invoice_number)}}"  id="form1" >
                                                        {{csrf_field()}}

                                                        {{--                                                                                <div class="form-group row">--}}

                                                        {{--                                                                                    <div class="form-wrapper col-6">--}}
                                                        {{--                                                                                        <label for="amount">Current Amount</label>--}}
                                                        {{--                                                                                        <input type="number" min="0" id="amount" name="current_amount" class="form-control" required="">--}}
                                                        {{--                                                                                    </div>--}}

                                                        {{--                                                                                    <div class="form-wrapper col-6">--}}
                                                        {{--                                                                                        <label for="currency">Currency</label>--}}
                                                        {{--                                                                                        <select id="currency" class="form-control" name="currency" >--}}
                                                        {{--                                                                                            <option value="{{$var->currency_invoice}}">{{$var->currency_invoice}}</option>--}}
                                                        {{--                                                                                        </select>--}}
                                                        {{--                                                                                    </div>--}}



                                                        {{--                                                                                </div>--}}

                                                        {{--                                                                                <br>--}}

                                                        @if($var->invoice_number_votebook=='')
                                                            <div style="padding-top: 2%;" class="form-group ">
                                                                <div class="form-wrapper">
                                                                    <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                                    <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <br>

                                                        @else
                                                            <div style="padding-top: 2%;" class="form-group">
                                                                <div class="form-wrapper">
                                                                    <label for="">Invoice Number <span style="color: red;">*</span></label>
                                                                    <input type="number" min="1" readonly class="form-control" id="votebook_space" name="invoice_number_votebook" value="{{$var->invoice_number_votebook}}" Required autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <br>
                                                        @endif

                                                        <div class="form-group">
                                                            <div class="form-wrapper">
                                                                <label for="course_name">GePG Control Number</label>
                                                                <input id="gepg_electricity{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);  minControlElectricityAll(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control"  name="gepg_control_no" value="" Required autocomplete="off">
                                                                <p id="error_gepg_electricity_all{{$var->invoice_number}}"></p>
                                                            </div>
                                                        </div>



                                                        <br>
                                                        <div align="right">
                                                            <button id="sendbtn_electricity_all{{$var->invoice_number}}" class="btn btn-primary" type="submit">Save</button>
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


                                                        {{--                                                                            <div class="form-group row">--}}

                                                        {{--                                                                                <div class="form-wrapper col-6">--}}
                                                        {{--                                                                                    <label for="amount">Current Amount</label>--}}
                                                        {{--                                                                                    <input type="number" min="0" id="amount" name="current_amount" class="form-control" required="">--}}
                                                        {{--                                                                                </div>--}}

                                                        {{--                                                                                <div class="form-wrapper col-6">--}}
                                                        {{--                                                                                    <label for="currency">Currency</label>--}}
                                                        {{--                                                                                    <select id="currency" class="form-control" name="currency" >--}}
                                                        {{--                                                                                        <option value="{{$var->currency_invoice}}">{{$var->currency_invoice}}</option>--}}
                                                        {{--                                                                                    </select>--}}
                                                        {{--                                                                                </div>--}}



                                                        {{--                                                                            </div>--}}

                                                        {{--                                                                            <br>--}}

                                                        @if($var->invoice_number_votebook=='')
                                                            <div style="padding-top: 2%;" class="form-group ">
                                                                <div class="form-wrapper">
                                                                    <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                                    <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <br>

                                                        @else
                                                            <div style="padding-top: 2%;" class="form-group ">
                                                                <div class="form-wrapper">
                                                                    <label for="">Invoice Number <span style="color: red;">*</span></label>
                                                                    <input type="number" min="1" readonly class="form-control" id="votebook_space" name="invoice_number_votebook" value="{{$var->invoice_number_votebook}}" Required autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <br>
                                                        @endif



                                                        @if($var->gepg_control_no=='')
                                                            <div class="form-group">
                                                                <div class="form-wrapper">
                                                                    <label for="course_name">GePG Control Number</label>
                                                                    <input id="gepg_electricity{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);  minControlElectricity(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control"  name="gepg_control_no" value="" Required autocomplete="off">
                                                                    <p id="error_gepg_electricity{{$var->invoice_number}}"></p>
                                                                </div>
                                                            </div>
                                                        @else

                                                            <div class="form-group">
                                                                <div class="form-wrapper">
                                                                    <label for="course_name">GePG Control Number</label>
                                                                    <input id="gepg_electricity{{$var->invoice_number}}" readonly type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);  minControlElectricity(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control"  name="gepg_control_no" value="{{$var->gepg_control_no}}"  autocomplete="off">

                                                                </div>
                                                            </div>


                                                        @endif



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


                                    @if($privileges=='Read only')
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
                                                    <b><h5 class="modal-title">Invoice Number: {{$var->invoice_number_votebook}} </h5></b>

                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('change_payment_status_electricity_bills',$var->invoice_number)}}"  id="form1" >
                                                        {{csrf_field()}}
                                                        <div style="text-align: left;" class="form-row">

                                                            <input type="hidden" min="1" class="form-control" id="invoice_number_space" readonly name="invoice_number" value="{{$var->invoice_number}}" Required autocomplete="off">


                                                            @if($var->invoice_number_votebook=='')
                                                                <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                    <div class="form-wrapper">
                                                                        <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                                        <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <br>

                                                            @else
                                                                <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                    <div class="form-wrapper">
                                                                        <label for="">Invoice Number <span style="color: red;">*</span></label>
                                                                        <input type="number" min="1" readonly class="form-control" id="votebook_space" name="invoice_number_votebook" value="{{$var->invoice_number_votebook}}" Required autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <br>
                                                            @endif



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
        </div>

    @else
        <p class="mt-4" style="text-align:center;">No records found</p>
    @endif

</div>
