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
                <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
                <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>
            <li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
                <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
@admin
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

                    <div style="width:100%; text-align: center ">
                        <br>
                        <h2>PAYMENTS</h2>

                        <br>

                    </div>


                    <div class="tab">
                        <?php
                        $space_agents=DB::table('general_settings')->where('category','Space')->orwhere('category','All')->get();

                        ?>


                        <?php
                        $insurance_agents=DB::table('general_settings')->where('category','Insurance')->orwhere('category','All')->get();

                        ?>

                        <?php
                        $car_agents=DB::table('general_settings')->where('category','Car rental')->orwhere('category','All')->get();

                        ?>



                            @foreach($space_agents as $space_agent)
                                @if(Auth::user()->role!=$space_agent->user_roles)
                                @else
                        <button class="tablinks space_identity" onclick="openInvoices(event, 'space_payments')" ><strong>Real Estate</strong></button>
                                @endif
                            @endforeach

                            @foreach($car_agents as $car_agent)
                                @if(Auth::user()->role!=$car_agent->user_roles)
                                @else
                        <button class="tablinks car_identity" onclick="openInvoices(event, 'car_rental_payments')"><strong>Car Rental</strong></button>
                                @endif
                            @endforeach

                            @foreach($insurance_agents as $insurance_agent)
                                @if(Auth::user()->role!=$insurance_agent->user_roles)
                                @else
                        <button class="tablinks insurance_identity" onclick="openInvoices(event, 'insurance_payments')"><strong>Insurance</strong></button>
                                @endif
                            @endforeach

                            @foreach($space_agents as $space_agent)
                                @if(Auth::user()->role!=$space_agent->user_roles)
                                @else
                        <button class="tablinks bills" onclick="openInvoices(event, 'water_payments')"><strong>Water Bills</strong></button>
                        <button class="tablinks bills" onclick="openInvoices(event, 'electricity_payments')"><strong>Electricity Bills</strong></button>
                                @endif
                            @endforeach

                    </div>


                    <div id="space_payments" class="tabcontent">
                        <br>
                        <h5>Real Estate Payments</h5>
                        <br>

                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else
                        <a data-toggle="modal"  style="background-color: lightgrey; padding: 10px; color:blue; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_payment_space" title="Record new space payment" role="button" aria-pressed="true"><i  class="fa fa-plus" aria-hidden="true"></i></a>
                        @endif


                        <div class="modal fade" id="new_payment_space" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Record New Space Payment</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <form method="post" action="{{ route('create_space_payment_manually')}}"  id="form1" >
                                            {{csrf_field()}}

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="invoice_number_space" name="invoice_number" value="" Required autocomplete="off">
                                                        <p id="invoice_availability"></p>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Votebook Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>



                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="amount_paid_space" name="amount_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount not paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="not_paid_space" name="amount_not_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-12">
                                                    <label>Currency <span style="color: red;">*</span></label>
                                                    <div  class="form-wrapper">
                                                        <select id="currency_space" class="form-control" required name="currency_payments">
                                                            <option value="" ></option>
                                                            <option value="TZS" >TZS</option>
                                                            <option value="USD" >USD</option>
                                                        </select>
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
                                                <button id="submit_space" class="btn btn-primary" type="submit">Submit</button>
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

                        @if(count($space_payments)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>

                                    <th scope="col" style="color:#3490dc;"><center>Votebook Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Amount Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount Not Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Receipt Number</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Action</center></th>


                                </tr>
                                </thead>
                                <tbody>

                                @foreach($space_payments as $var)
                                    <tr>

                                        <td><center>{{$i}}</center></td>
                                        <td><center>{{$var->invoice_number_votebook}}</center></td>
                                        <td><center>{{$var->amount_paid}}</center></td>
                                        <td><center>{{$var->amount_not_paid}}</center></td>
                                        <td><center> {{$var->currency_payments}}</center></td>
                                        <td><center>{{$var->receipt_number}}</center></td>
                                        <td><center>



                                                <a title="View more details" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="invoice{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Full Payment Details</h5></b>

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
                                                                        <td> {{$var->invoicing_period_start_date}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td> End Date:</td>
                                                                        <td> {{$var->invoicing_period_end_date}}</td>
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
                            <p>No records found</p>
                        @endif

            </div>



                    <div id="car_rental_payments" class="tabcontent">
                        <br>
                        <h5>Car Rental Payments</h5>
                        <br>

                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else
                        <a data-toggle="modal"  style="background-color: lightgrey; padding: 10px; color:blue; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_payment_car" title="Record new car rental payment" role="button" aria-pressed="true"><i  class="fa fa-plus" aria-hidden="true"></i></a>
                        @endif

                        <div class="modal fade" id="new_payment_car" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Record New Car Rental Payment</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <form method="post" action="{{ route('create_car_payment_manually')}}"  id="form1" >
                                            {{csrf_field()}}

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="invoice_number_car" name="invoice_number" value="" Required autocomplete="off">
                                                        <p id="invoice_availability_car" ></p>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Votebook Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="votebook_car" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>



                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="amount_paid_car" name="amount_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount not paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="not_paid_car" name="amount_not_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-12">
                                                    <label>Currency <span style="color: red;">*</span></label>
                                                    <div  class="form-wrapper">
                                                        <select id="currency_car" class="form-control" required name="currency_payments">
                                                            <option value="" ></option>
                                                            <option value="TZS" >TZS</option>
                                                            <option value="USD" >USD</option>
                                                        </select>
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
                                                <button id="submit_car" class="btn btn-primary" type="submit">Submit</button>
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

                        @if(count($car_rental_payments)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable2">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>

                                    <th scope="col" style="color:#3490dc;"><center>Votebook Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Amount Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount Not Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Receipt Number</center></th>
<th scope="col"  style="color:#3490dc;"><center>Action</center></th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($car_rental_payments as $var)
                                    <tr>

                                        <td><center>{{$i}}</center></td>
                                        <td><center>{{$var->invoice_number_votebook}}</center></td>
                                        <td><center>{{$var->amount_paid}}</center></td>
                                        <td><center>{{$var->amount_not_paid}}</center></td>
                                        <td><center> {{$var->currency_payments}}</center></td>
                                        <td><center>{{$var->receipt_number}}</center></td>
                                        <td><center>



                                                <a title="View more details" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="invoice{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Full Payment Details</h5></b>

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
                                                                        <td> {{$var->invoicing_period_start_date}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td> End Date:</td>
                                                                        <td> {{$var->invoicing_period_end_date}}</td>
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
                            <p>No records found</p>
                        @endif

                    </div>


                    <div id="insurance_payments" class="tabcontent">
                        <br>
                        <h5>Insurance Payments</h5>
                        <br>
                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else
                        <a data-toggle="modal"  style="background-color: lightgrey; padding: 10px; color:blue; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_payment_insurance" title="Record new insurance payment" role="button" aria-pressed="true"><i  class="fa fa-plus" aria-hidden="true"></i></a>
                        @endif


                        <div class="modal fade" id="new_payment_insurance" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Record New insurance Payment</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <form method="post" action="{{ route('create_insurance_payment_manually')}}"  id="form1" >
                                            {{csrf_field()}}

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="invoice_number_insurance" name="invoice_number" value="" Required autocomplete="off">
                                                        <p id="invoice_availability_insurance" ></p>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Votebook Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="votebook_insurance" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>



                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="amount_paid_insurance" name="amount_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount not paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="not_paid_insurance" name="amount_not_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-12">
                                                    <label>Currency <span style="color: red;">*</span></label>
                                                    <div  class="form-wrapper">
                                                        <select id="currency_insurance" class="form-control" required name="currency_payments">
                                                            <option value="" ></option>
                                                            <option value="TZS" >TZS</option>
                                                            <option value="USD" >USD</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-12">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Receipt Number <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="receipt_insurance" name="receipt_number" value="" required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>








                                            </div>


                                            <div align="right">
                                                <button id="submit_insurance" class="btn btn-primary" type="submit">Submit</button>
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

                        @if(count($insurance_payments)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable3">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>

                                    <th scope="col" style="color:#3490dc;"><center>Votebook Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Amount Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount Not Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Receipt Number</center></th>
<th scope="col"  style="color:#3490dc;"><center>Action</center></th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($insurance_payments as $var)
                                    <tr>

                                        <td><center>{{$i}}</center></td>
                                        <td><center>{{$var->invoice_number_votebook}}</center></td>
                                        <td><center>{{$var->amount_paid}}</center></td>
                                        <td><center>{{$var->amount_not_paid}}</center></td>
                                        <td><center> {{$var->currency_payments}}</center></td>
                                        <td><center>{{$var->receipt_number}}</center></td>
                                        <td><center>



                                                <a title="View more details" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="invoice{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Full Payment Details</h5></b>

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
                                                                        <td> {{$var->invoicing_period_start_date}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td> End Date:</td>
                                                                        <td> {{$var->invoicing_period_end_date}}</td>
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
                            <p>No records found</p>
                        @endif

                    </div>


                    <div id="water_payments" class="tabcontent">
                        <br>
                        <h5>Water Bill Payments</h5>
                        <br>

                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else
                        <a data-toggle="modal"  style="background-color: lightgrey; padding: 10px; color:blue; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_payment_water" title="Record new water bill payment" role="button" aria-pressed="true"><i  class="fa fa-plus" aria-hidden="true"></i></a>
                        @endif


                        <div class="modal fade" id="new_payment_water" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Record New Water bill Payment</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <form method="post" action="{{ route('create_water_payment_manually')}}"  id="form1" >
                                            {{csrf_field()}}

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="invoice_number_water" name="invoice_number" value="" Required autocomplete="off">
                                                        <p id="invoice_availability_water" ></p>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Votebook Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="votebook_water" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>



                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="amount_paid_water" name="amount_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount not paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="not_paid_water" name="amount_not_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-12">
                                                    <label>Currency <span style="color: red;">*</span></label>
                                                    <div  class="form-wrapper">
                                                        <select id="currency_water" class="form-control" required name="currency_payments">
                                                            <option value="" ></option>
                                                            <option value="TZS" >TZS</option>
                                                            <option value="USD" >USD</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-12">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Receipt Number <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="receipt_water" name="receipt_number" value="" required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>








                                            </div>


                                            <div align="right">
                                                <button id="submit_water" class="btn btn-primary" type="submit">Submit</button>
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

                        @if(count($water_bill_payments)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable4">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>

                                    <th scope="col" style="color:#3490dc;"><center>Votebook Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Amount Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount Not Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Receipt Number</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Action</center></th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($water_bill_payments as $var)
                                    <tr>

                                        <td><center>{{$i}}</center></td>
                                        <td><center>{{$var->invoice_number_votebook}}</center></td>
                                        <td><center>{{$var->amount_paid}}</center></td>
                                        <td><center>{{$var->amount_not_paid}}</center></td>
                                        <td><center> {{$var->currency_payments}}</center></td>
                                        <td><center>{{$var->receipt_number}}</center></td>
                                        <td><center>



                                                <a title="View more details" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice_water{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="invoice_water{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Full Payment Details</h5></b>

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
                                                                        <td> {{$var->invoicing_period_start_date}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td> End Date:</td>
                                                                        <td> {{$var->invoicing_period_end_date}}</td>
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
                                                                        <td>{{$var->debt}} {{$var->currency_invoice}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Current Amount:</td>
                                                                        @if($var->current_amount==0)
                                                                            <td>N/A</td>
                                                                        @else
                                                                            <td>{{$var->current_amount}} {{$var->currency_invoice}}</td>
                                                                        @endif

                                                                    </tr>

                                                                    <tr>

                                                                        <td>Cumulative Amount:</td>
                                                                        @if($var->cumulative_amount==0)
                                                                            <td>N/A</td>
                                                                        @else
                                                                            <td>{{$var->cumulative_amount}} {{$var->currency_invoice}}</td>
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
                            <p>No records found</p>
                        @endif

                    </div>


                    <div id="electricity_payments" class="tabcontent">
                        <br>
                        <h5>Electricity Bill Payments</h5>
                        <br>

                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else
                        <a data-toggle="modal"  style="background-color: lightgrey; padding: 10px; color:blue; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_payment_electricity" title="Record new electricity bill payment" role="button" aria-pressed="true"><i  class="fa fa-plus" aria-hidden="true"></i></a>
                        @endif


                        <div class="modal fade" id="new_payment_electricity" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Record New Electricity bill Payment</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <form method="post" action="{{ route('create_electricity_payment_manually')}}"  id="form1" >
                                            {{csrf_field()}}

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="invoice_number_electricity" name="invoice_number" value="" Required autocomplete="off">
                                                        <p id="invoice_availability_electricity" ></p>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Votebook Invoice Number <span style="color: red;">*</span></label>
                                                        <input type="number" min="1" class="form-control" id="votebook_electricity" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>



                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="amount_paid_electricity" name="amount_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-6">
                                                    <div class="form-wrapper">
                                                        <label for=""> Amount not paid <span style="color: red;">*</span></label>
                                                        <input type="number" min="0" class="form-control" id="not_paid_electricity" name="amount_not_paid" value="" Required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-12">
                                                    <label>Currency <span style="color: red;">*</span></label>
                                                    <div  class="form-wrapper">
                                                        <select id="currency_electricity" class="form-control" required name="currency_payments">
                                                            <option value="" ></option>
                                                            <option value="TZS" >TZS</option>
                                                            <option value="USD" >USD</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group col-md-12">
                                                    <div class="form-wrapper">
                                                        <label for=""  >Receipt Number <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="receipt_electricity" name="receipt_number" value="" required  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>








                                            </div>


                                            <div align="right">
                                                <button id="submit_electricity" class="btn btn-primary" type="submit">Submit</button>
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

                        @if(count($electricity_bill_payments)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable5">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>

                                    <th scope="col" style="color:#3490dc;"><center>Votebook Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Amount Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount Not Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Receipt Number</center></th>
<th scope="col"  style="color:#3490dc;"><center>Action</center></th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($electricity_bill_payments as $var)
                                    <tr>

                                        <td><center>{{$i}}</center></td>
                                        <td><center>{{$var->invoice_number_votebook}}</center></td>
                                        <td><center>{{$var->amount_paid}}</center></td>
                                        <td><center>{{$var->amount_not_paid}}</center></td>
                                        <td><center> {{$var->currency_payments}}</center></td>
                                        <td><center>{{$var->receipt_number}}</center></td>
                                        <td><center>



                                                <a title="View more details" style="color:#3490dc !important;"  class="" data-toggle="modal" data-target="#invoice_electricity{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="invoice_electricity{{$var->invoice_number}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Full Payment Details</h5></b>

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
                                                                        <td> {{$var->invoicing_period_start_date}}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td> End Date:</td>
                                                                        <td> {{$var->invoicing_period_end_date}}</td>
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
                                                                        <td>{{$var->debt}} {{$var->currency_invoice}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Current Amount:</td>
                                                                        @if($var->current_amount==0)
                                                                            <td>N/A</td>
                                                                        @else
                                                                            <td>{{$var->current_amount}} {{$var->currency_invoice}}</td>
                                                                        @endif

                                                                    </tr>

                                                                    <tr>

                                                                        <td>Cumulative Amount:</td>
                                                                        @if($var->cumulative_amount==0)
                                                                            <td>N/A</td>
                                                                        @else
                                                                            <td>{{$var->cumulative_amount}} {{$var->currency_invoice}}</td>
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
                            <p>No records found</p>
                        @endif

                    </div>






        </div>
    </div>
    </div>
@endsection

@section('pagescript')
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

            if(space_x==1){

                $(".insurance_identity").removeClass("defaultPayment");
                $(".car_identity").removeClass("defaultPayment");
                $('.space_identity').addClass('defaultPayment');


            }else if(insurance_x==1){
                $(".space_identity").removeClass("defaultPayment");
                $(".car_identity").removeClass("defaultPayment");
                $('.insurance_identity').addClass('defaultPayment');

            }else if(car_x==1){
                $(".space_identity").removeClass("defaultPayment");
                $(".insurance_identity").removeClass("defaultPayment");
                $('.car_identity').addClass('defaultPayment');

            }else{

            }

            console.log(space_x);

            document.querySelector('.defaultPayment').click();

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


        var table = $('#myTable2').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

        var table = $('#myTable3').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

        var table = $('#myTable4').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

        var table = $('#myTable5').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );


    </script>



    <script>

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

                            $("#votebook_space").prop('disabled', true);
                            $("#amount_paid_space").prop('disabled', true);
                            $("#not_paid_space").prop('disabled', true);
                            $("#currency_space").prop('disabled', true);
                            $("#receipt_space").prop('disabled', true);
                            $("#submit_space").prop('disabled', true);


                        }
                        else{
                            $("#invoice_availability").html("");

                            $('#invoice_number_space').attr('style','border:1px solid #ced4da');

                            $("#votebook_space").prop('disabled', false);
                            $("#amount_paid_space").prop('disabled', false);
                            $("#not_paid_space").prop('disabled', false);
                            $("#currency_space").prop('disabled', false);
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



        $('#invoice_number_insurance').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('check_availability_insurance') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='0'){
                            $('#invoice_number_insurance').attr('style','border:1px solid #f00');
                            $("#invoice_availability_insurance").css("color","red");
                            $("#invoice_availability_insurance").html("Invoice number does not exist");

                            $("#votebook_insurance").prop('disabled', true);
                            $("#amount_paid_insurance").prop('disabled', true);
                            $("#not_paid_insurance").prop('disabled', true);
                            $("#currency_insurance").prop('disabled', true);
                            $("#receipt_insurance").prop('disabled', true);
                            $("#submit_insurance").prop('disabled', true);


                        }
                        else{
                            $("#invoice_availability_insurance").html("");

                            $('#invoice_number_insurance').attr('style','border:1px solid #ced4da');

                            $("#votebook_insurance").prop('disabled', false);
                            $("#amount_paid_insurance").prop('disabled', false);
                            $("#not_paid_insurance").prop('disabled', false);
                            $("#currency_insurance").prop('disabled', false);
                            $("#receipt_insurance").prop('disabled', false);
                            $("#submit_insurance").prop('disabled', false);

                        }
                    }
                });
            }
            else if(query==''){

                $('#invoice_number_insurance').attr('style','border:1px solid #ced4da');
            }
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

                            $("#votebook_car").prop('disabled', true);
                            $("#amount_paid_car").prop('disabled', true);
                            $("#not_paid_car").prop('disabled', true);
                            $("#currency_car").prop('disabled', true);
                            $("#receipt_car").prop('disabled', true);
                            $("#submit_car").prop('disabled', true);


                        }
                        else{
                            $("#invoice_availability_car").html("");

                            $('#invoice_number_car').attr('style','border:1px solid #ced4da');

                            $("#votebook_car").prop('disabled', false);
                            $("#amount_paid_car").prop('disabled', false);
                            $("#not_paid_car").prop('disabled', false);
                            $("#currency_car").prop('disabled', false);
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



        $('#invoice_number_water').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('check_availability_water') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='0'){
                            $('#invoice_number_water').attr('style','border:1px solid #f00');
                            $("#invoice_availability_water").css("color","red");
                            $("#invoice_availability_water").html("Invoice number does not exist");

                            $("#votebook_water").prop('disabled', true);
                            $("#amount_paid_water").prop('disabled', true);
                            $("#not_paid_water").prop('disabled', true);
                            $("#currency_water").prop('disabled', true);
                            $("#receipt_water").prop('disabled', true);
                            $("#submit_water").prop('disabled', true);


                        }
                        else{
                            $("#invoice_availability_water").html("");
                            $('#invoice_number_water').attr('style','border:1px solid #ced4da');

                            $("#votebook_water").prop('disabled', false);
                            $("#amount_paid_water").prop('disabled', false);
                            $("#not_paid_water").prop('disabled', false);
                            $("#currency_water").prop('disabled', false);
                            $("#receipt_water").prop('disabled', false);
                            $("#submit_water").prop('disabled', false);

                        }
                    }
                });
            }
            else if(query==''){

                $('#invoice_number_water').attr('style','border:1px solid #ced4da');
            }
        });



        $('#invoice_number_electricity').on('input', function(e) {

            e.preventDefault();
            var query = $(this).val();
            if(query != '')
            {

                $.ajax({
                    url:"{{ route('check_availability_electricity') }}",
                    method:"GET",
                    data:{query:query},
                    success:function(data){
                        if(data=='0'){
                            $('#invoice_number_electricity').attr('style','border:1px solid #f00');
                            $("#invoice_availability_electricity").css("color","red");
                            $("#invoice_availability_electricity").html("Invoice number does not exist");

                            $("#votebook_electricity").prop('disabled', true);
                            $("#amount_paid_electricity").prop('disabled', true);
                            $("#not_paid_electricity").prop('disabled', true);
                            $("#currency_electricity").prop('disabled', true);
                            $("#receipt_electricity").prop('disabled', true);
                            $("#submit_electricity").prop('disabled', true);


                        }
                        else{
                            $("#invoice_availability_electricity").html("");

                            $('#invoice_number_electricity').attr('style','border:1px solid #ced4da');

                            $("#votebook_electricity").prop('disabled', false);
                            $("#amount_paid_electricity").prop('disabled', false);
                            $("#not_paid_electricity").prop('disabled', false);
                            $("#currency_electricity").prop('disabled', false);
                            $("#receipt_electricity").prop('disabled', false);
                            $("#submit_electricity").prop('disabled', false);

                        }
                    }
                });
            }
            else if(query==''){

                $('#invoice_number_electricity').attr('style','border:1px solid #ced4da');
            }
        });



    </script>

@endsection
