<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
    $today=date('Y-m-d');
    $date=date_create($today);
    date_sub($date,date_interval_create_from_date_string("366 days"));

    if($_GET['criteria']=='space'){
	 $space_invoices=DB::table('invoices')
	 				->join('space_contracts','invoices.contract_id','=','space_contracts.contract_id')
	 				->wherebetween('invoice_date',[ $_GET['start'] ,$_GET['end']])
	 				->orderBy('invoices.invoice_number','desc')
	 				->get();
    }
    elseif($_GET['criteria']=='insurance'){
         $insurance_invoices=DB::table('insurance_invoices')
                            ->orderBy('invoice_number','desc')
                            ->wherebetween('invoice_date',[ $_GET['start'] ,$_GET['end']])
                            ->get();
    }

    elseif($_GET['criteria']=='car'){
        if(Auth::user()->role=='Vote Holder' || Auth::user()->role=='Accountant-Cost Centre'){
            $car_rental_invoices=DB::table('car_rental_invoices')
                                ->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')
                                ->where('cost_centre',Auth::user()->cost_centre)
                                ->wherebetween('invoice_date',[ $_GET['start'] ,$_GET['end']])
                                ->orderBy('car_rental_invoices.invoice_number','desc')
                                ->get();
         }
         else{
           $car_rental_invoices=DB::table('car_rental_invoices')
                                ->join('car_contracts','car_rental_invoices.contract_id','=','car_contracts.id')
                                ->wherebetween('invoice_date',[ $_GET['start'] ,$_GET['end']])
                                ->orderBy('car_rental_invoices.invoice_number','desc')
                                ->get();
         }
    }

    elseif($_GET['criteria']=='water'){
         $water_bill_invoices=DB::table('water_bill_invoices')
                            ->join('space_contracts','water_bill_invoices.contract_id','=','space_contracts.contract_id')
                            ->wherebetween('invoice_date',[ $_GET['start'] ,$_GET['end']])
                            ->orderBy('water_bill_invoices.invoice_number','desc')
                            ->get();
    }

    elseif($_GET['criteria']=='electricity'){
        $electricity_bill_invoices=DB::table('electricity_bill_invoices')
                                    ->join('space_contracts','electricity_bill_invoices.contract_id','=','space_contracts.contract_id')
                                    ->wherebetween('invoice_date',[ $_GET['start'] ,$_GET['end']])
                                    ->orderBy('electricity_bill_invoices.invoice_number','desc')
                                    ->get();
    }
	$i=1;
	?>
@if($_GET['criteria']=='space')
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
                                                <a title="Send invoice" data-toggle="modal" style=" color: #3490dc; cursor: pointer;"  data-target="#send_invoice{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                                @endif

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
                                                                            <label for="course_name">GePG Control Number</label>
                                                                            <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControl(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                            <p id="error_gepg{{$var->invoice_number}}"></p>
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
        <br><br>
        <p style="font-size: 18px;">No records found</p>
    @endif
@elseif($_GET['criteria']=='insurance')
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










                                            @if($var->email_sent_status=='NOT SENT')

                                                @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                                @else
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
                                                                            <label for="course_name">GePG Control Number</label>
                                                                            <input id="gepg{{$var->invoice_number}}"  type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControlInsurance(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                            <p id="error_gepg_insurance{{$var->invoice_number}}"></p>
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
        <br><br>
        <p style="font-size: 18px;">No records found</p>
    @endif

@elseif($_GET['criteria']=='car')
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
                                                <a title="Send invoice" data-toggle="modal" style=" color: #3490dc; cursor: pointer;"  data-target="#send_invoice_car{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                                @endif

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
                                                                            <label for="course_name">GePG Control Number</label>
                                                                            <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControlCar(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control" id="course_name" name="gepg_control_no" value="" Required autocomplete="off">
                                                                            <p id="error_gepg_car{{$var->invoice_number}}"></p>
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
        <br><br>
        <p style="font-size: 18px;">No records found</p>
    @endif

@elseif($_GET['criteria']=='water')
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
                                                <a title="Send invoice" data-toggle="modal" style=" color: #3490dc; cursor: pointer;"  data-target="#send_invoice_water{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                                @endif

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
                                                                            <label for="course_name">GePG Control Number</label>
                                                                            <input id="gepg{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minControlWater(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control"  name="gepg_control_no" value="" Required autocomplete="off">
                                                                            <p id="error_gepg_water{{$var->invoice_number}}"></p>
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
        <br><br>
        <p style="font-size: 18px;">No records found</p>
    @endif

@elseif($_GET['criteria']=='electricity')
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
                                                <a title="Send invoice" data-toggle="modal" style=" color: #3490dc; cursor: pointer;"  data-target="#send_invoice_electricity{{$var->invoice_number}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                                @endif

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
                                                                            <label for="course_name">GePG Control Number</label>
                                                                            <input id="gepg_electricity{{$var->invoice_number}}" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);  minControlElectricity(this.value,{{$var->invoice_number}});" maxlength = "12" class="form-control"  name="gepg_control_no" value="" Required autocomplete="off">
                                                                            <p id="error_gepg_electricity{{$var->invoice_number}}"></p>
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
        <br><br>
        <p style="font-size: 18px;">No records found</p>
    @endif

@endif

</body>
</html>
