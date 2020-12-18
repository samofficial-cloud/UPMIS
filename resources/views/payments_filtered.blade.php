<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	$i=1;
	if($_GET['criteria']=='space'){
		$space_payments=DB::table('space_payments')
							->join('invoices','space_payments.invoice_number','=','invoices.invoice_number')
							->where('space_payments.invoice_number_votebook','!=','')
							->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							->get();
	}
	elseif($_GET['criteria']=='car'){
		if(Auth::user()->role=='Vote Holder' || Auth::user()->role=='Accountant-Cost Centre'){
            $car_rental_payments=DB::table('car_rental_payments')
            					->join('car_rental_invoices','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
            					->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')
            					->where('cost_centre',Auth::user()->cost_centre)
            					->where('car_rental_payments.invoice_number_votebook','!=','')
            					->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
            					->get();
        }
        else{
            $car_rental_payments=DB::table('car_rental_payments')
            					->join('car_rental_invoices','car_rental_payments.invoice_number','=','car_rental_invoices.invoice_number')
            					->where('car_rental_payments.invoice_number_votebook','!=','')
            					->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
            					->get();
        }
	}
	elseif($_GET['criteria']=='insurance'){
		$insurance_payments=DB::table('insurance_payments')
							->join('insurance_invoices','insurance_payments.invoice_number','=','insurance_invoices.invoice_number')
							->where('insurance_payments.invoice_number_votebook','!=','')
							->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							->get();
	}
	elseif($_GET['criteria']=='water'){
		$water_bill_payments=DB::table('water_bill_payments')
							->join('water_bill_invoices','water_bill_payments.invoice_number','=','water_bill_invoices.invoice_number')
							->where('water_bill_payments.invoice_number_votebook','!=','')
							->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							->get();
	}
	elseif($_GET['criteria']=='electricity'){
		$electricity_bill_payments=DB::table('electricity_bill_payments')
									->join('electricity_bill_invoices','electricity_bill_payments.invoice_number','=','electricity_bill_invoices.invoice_number')
									->where('electricity_bill_payments.invoice_number_votebook','!=','')
									->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
									->get();
	}
	?>
	@if($_GET['criteria']=='space')
		@if(count($space_payments)>0)
			                       <table class="hover table table-striped  table-bordered" id="myTable">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#fff;"><center>S/N</center></th>

                                <th scope="col" style="color:#fff;"><center>Votebook Invoice Number</center></th>
                                <th scope="col" style="color:#fff;"><center>Amount Paid</center></th>
                                <th scope="col"  style="color:#fff;"><center>Amount Not Paid</center></th>
                                <th scope="col"  style="color:#fff;"><center>Date of payment</center></th>

                                <th scope="col"  style="color:#fff;"><center>Receipt Number</center></th>
                                <th scope="col"  style="color:#fff;"><center>Action</center></th>


                            </tr>
                            </thead>
                            <tbody>

                            @foreach($space_payments as $var)
                                <tr>

                                    <td><center>{{$i}}</center></td>
                                    <td><center>{{$var->invoice_number_votebook}}</center></td>
                                    <td><center>{{number_format($var->amount_paid)}} {{$var->currency_payments}}</center></td>
                                    <td><center>{{number_format($var->amount_not_paid)}} {{$var->currency_payments}}</center></td>

                                    <td><center>{{date("d/m/Y",strtotime($var->date_of_payment))}}</center></td>
                                    <td><center>{{$var->receipt_number}}</center></td>
                                    <td><center>



                                            <a title="View invoice" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                            <div class="modal fade" id="invoice{{$var->invoice_number}}" role="dialog">

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
                                                                    <td> {{$var->amount_to_be_paid}} {{$var->currency_invoice}}</td>
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
		@if(count($car_rental_payments)>0)
			                        <table class="hover table table-striped  table-bordered" id="myTable2">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#fff;"><center>S/N</center></th>

                                <th scope="col" style="color:#fff;"><center>Votebook Invoice Number</center></th>
                                <th scope="col" style="color:#fff;"><center>Amount Paid</center></th>
                                <th scope="col"  style="color:#fff;"><center>Amount Not Paid</center></th>
                                <th scope="col"  style="color:#fff;"><center>Date of payment</center></th>
                                <th scope="col"  style="color:#fff;"><center>Receipt Number</center></th>
                                <th scope="col"  style="color:#fff;"><center>Action</center></th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($car_rental_payments as $var)
                                <tr>

                                    <td><center>{{$i}}</center></td>
                                    <td><center>{{$var->invoice_number_votebook}}</center></td>
                                    <td><center>{{number_format($var->amount_paid)}} {{$var->currency_payments}}</center></td>
                                    <td><center>{{number_format($var->amount_not_paid)}} {{$var->currency_payments}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->date_of_payment))}}</center></td>
                                    <td><center>{{$var->receipt_number}}</center></td>
                                    <td><center>



                                            <a title="View invoice" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                            <div class="modal fade" id="invoice{{$var->invoice_number}}" role="dialog">

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
                                                                    <td> {{$var->amount_to_be_paid}} {{$var->currency_invoice}}</td>
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
		@if(count($insurance_payments)>0)
			<table class="hover table table-striped  table-bordered" id="myTable3">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#fff;"><center>S/N</center></th>

                                <th scope="col" style="color:#fff;"><center>Votebook Invoice Number</center></th>
                                <th scope="col" style="color:#fff;"><center>Amount Paid</center></th>
                                <th scope="col"  style="color:#fff;"><center>Amount Not Paid</center></th>
                                <th scope="col"  style="color:#fff;"><center>Date of payment</center></th>
                                <th scope="col"  style="color:#fff;"><center>Receipt Number</center></th>
                                <th scope="col"  style="color:#fff;"><center>Action</center></th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($insurance_payments as $var)
                                <tr>

                                    <td><center>{{$i}}</center></td>
                                    <td><center>{{$var->invoice_number_votebook}}</center></td>
                                    <td><center>{{number_format($var->amount_paid)}} {{$var->currency_payments}}</center></td>
                                    <td><center>{{number_format($var->amount_not_paid)}} {{$var->currency_payments}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->date_of_payment))}}</center></td>
                                    <td><center>{{$var->receipt_number}}</center></td>
                                    <td><center>



                                            <a title="View invoice" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice_insurance{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                            <div class="modal fade" id="invoice_insurance{{$var->invoice_number}}" role="dialog">

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
                                                                    <td> {{$var->amount_to_be_paid}} {{$var->currency_invoice}}</td>
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
		@if(count($water_bill_payments)>0)
			                        <table class="hover table table-striped  table-bordered" id="myTable4">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#fff;"><center>S/N</center></th>

                                <th scope="col" style="color:#fff;"><center>Votebook Invoice Number</center></th>
                                <th scope="col" style="color:#fff;"><center>Amount Paid</center></th>
                                <th scope="col"  style="color:#fff;"><center>Amount Not Paid</center></th>
                                <th scope="col"  style="color:#fff;"><center>Date of payment</center></th>
                                <th scope="col"  style="color:#fff;"><center>Receipt Number</center></th>
                                <th scope="col"  style="color:#fff;"><center>Action</center></th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($water_bill_payments as $var)
                                <tr>

                                    <td><center>{{$i}}</center></td>
                                    <td><center>{{$var->invoice_number_votebook}}</center></td>
                                    <td><center>{{number_format($var->amount_paid)}} {{$var->currency_payments}}</center></td>
                                    <td><center>{{number_format($var->amount_not_paid)}} {{$var->currency_payments}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->date_of_payment))}}</center></td>
                                    <td><center>{{$var->receipt_number}}</center></td>
                                    <td><center>



                                            <a title="View invoice" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice_water{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                            <div class="modal fade" id="invoice_water{{$var->invoice_number}}" role="dialog">

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
		@if(count($electricity_bill_payments)>0)
			                        <table class="hover table table-striped  table-bordered" id="myTable5">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#fff;"><center>S/N</center></th>

                                <th scope="col" style="color:#fff;"><center>Votebook Invoice Number</center></th>
                                <th scope="col" style="color:#fff;"><center>Amount Paid</center></th>
                                <th scope="col"  style="color:#fff;"><center>Amount Not Paid</center></th>
                                <th scope="col"  style="color:#fff;"><center>Date of payment</center></th>

                                <th scope="col"  style="color:#fff;"><center>Receipt Number</center></th>
                                <th scope="col"  style="color:#fff;"><center>Action</center></th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($electricity_bill_payments as $var)
                                <tr>

                                    <td><center>{{$i}}</center></td>
                                    <td><center>{{$var->invoice_number_votebook}}</center></td>
                                    <td><center>{{number_format($var->amount_paid)}} {{$var->currency_payments}}</center></td>
                                    <td><center>{{number_format($var->amount_not_paid)}} {{$var->currency_payments}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->date_of_payment))}}</center></td>
                                    <td><center>{{$var->receipt_number}}</center></td>
                                    <td><center>



                                            <a title="View invoice" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice_electricity{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                            <div class="modal fade" id="invoice_electricity{{$var->invoice_number}}" role="dialog">

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