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

            <?php

            $privileges=DB::table('users')->join('general_settings','users.role','=','general_settings.user_roles')->where('users.role',Auth::user()->role)->value('privileges');
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
            <div class="container " style="max-width: 100%;">
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

                    @foreach($space_contract as $var)


                        <div class="card">
                            <div class="card-body">
                                <h2 style="text-align: center;">Contract details</h2>
                                <hr>
                    <table class="table table-striped table-bordered" style="width: 100%">

                        <tr>
                            <td>Contract ID:</td>
                            <td>{{$var->contract_id}}</td>
                        </tr>


                        <tr>
                            <td>Client ID:</td>
                            <td>{{$var->official_client_id}}</td>
                        </tr>


                        <tr>
                            <td>Client's TIN:</td>
                            <td>{{$var->tin}}</td>
                        </tr>



                        <tr>
                            <td>Client Name:</td>
                            <td>{{$var->full_name}}</td>
                        </tr>


                        @if($var->has_clients==1)
                        @else
                            <tr>
                                <td> Space Number:</td>
                                <td> {{$var->space_id_contract}}</td>
                            </tr>

                            <tr>
                                <td> Amount(Academic season):</td>
                                <td>

                                    @if($var->academic_dependence=='Yes')
                                        {{number_format($var->academic_season)}} {{$var->currency}}
                                    @else
                                        {{number_format($var->amount)}} {{$var->currency}}
                                    @endif</td>
                            </tr>


                            <tr>
                                <td> Amount(Vacation season):</td>
                                <td> @if($var->academic_dependence=='Yes')
                                        @if($var->vacation_season=="0")
                                            {{number_format($var->academic_season)}} {{$var->currency}}
                                        @else
                                            {{number_format($var->vacation_season)}} {{$var->currency}}
                                        @endif
                                    @else
                                        {{number_format($var->amount)}} {{$var->currency}}
                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <td> Rent/SQM:</td>
                                <td>@if($var->rent_sqm=='')
                                        N/A
                                    @else
                                        {{$var->rent_sqm}}
                                    @endif
                                </td>
                            </tr>

                        @endif


                        <tr>
                            <td>Contract Duration:</td>
                            <td>{{$var->duration}} {{$var->duration_period}}</td>
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
                            <td>Payment Cycle:</td>
                            <td>
                                @if($var->payment_cycle=='1')
                                {{$var->payment_cycle}} Month
                                @else
                                    {{$var->payment_cycle}} Months
                                @endif


                            </td>
                        </tr>




                        <tr>
                            <td>Escalation Rate(%):</td>
                            <td>{{$var->escalation_rate}} </td>
                        </tr>

                        <tr>
                            <td>Contract Creation Date:</td>
                            <td>{{date("d/m/Y",strtotime($var->creation_date))}}</td>
                        </tr>


                        <tr>
                            <td>Contract Status:</td>
                            <td>@if($var->contract_status==0)
                                    TERMINATED
                                @elseif($var->end_date<date('Y-m-d'))
                                    EXPIRED
                                @else
                                    ACTIVE
                                @endif</td>
                        </tr>


                        @if($var->contract_status==0)
                        <tr>
                            <td>Reason for termination:</td>
                            <td>
                                {{$var->reason_for_termination}}
                            </td>
                        </tr>

                        @else
                        @endif



                    </table>
                            </div>
                            </div>
                @endforeach

<br>

                    <div class="card">
                        <div class="card-body">
                    <br>
                    <h2 style="text-align: center">Associated Invoices</h2>
                    <br>


                            @if($privileges=='Read only')
                            @else

                                <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice" title="Add new Space Invoice" role="button" aria-pressed="true">Add New Invoice</a>
@endif
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
                                        @foreach($space_contract as $var)

                                        <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <div class="form-wrapper">
                                                <label for=""  >Client Full Name <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="" name="debtor_name" value="{{$var->full_name}}" readonly Required autocomplete="off">
                                            </div>
                                        </div>
                                        <br>




                                        <div class="form-group col-md-6">
                                            <div class="form-wrapper">
                                                <label for=""  >Client Account Code</label>
                                                <input type="text" class="form-control" id="" name="debtor_account_code" value="{{$var->client_id}}"  readonly autocomplete="off">
                                            </div>
                                        </div>
                                        <br>



                                            <div class="form-group col-md-6">
                                                <div class="form-wrapper">
                                                    <label for=""  >Client TIN</label>
                                                    <input type="text" class="form-control" id="" name="tin" value="{{$var->tin}}" readonly autocomplete="off">
                                                </div>
                                            </div>
                                            <br>


                                            <div class="form-group col-md-6">
                                                <div class="form-wrapper">
                                                    <label for=""  >Client VRN</label>
                                                    <input type="text" class="form-control" id="" name="vrn" value="{{$var->vrn}}" readonly autocomplete="off">
                                                </div>
                                            </div>
                                            <br>


                                        <div class="form-group col-md-12">
                                            <div class="form-wrapper">
                                                <label for=""  >Client Address <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="" name="debtor_address" value="{{$var->address}}" readonly Required autocomplete="off">
                                            </div>
                                        </div>
                                        <br>


                                            <div class="form-group col-md-6">
                                                <div class="form-wrapper">
                                                    <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                                    <input type="date" class="form-control" id="" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                                </div>
                                            </div>
                                            <br>


                                            <div class="form-group col-md-6">
                                                <div class="form-wrapper">
                                                    <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                                    <input type="date" class="form-control" id="" name="invoicing_period_end_date" value="" Required autocomplete="off">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group col-md-12">
                                                <div class="form-wrapper">
                                                    <label for="">Period <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="" name="period" value=""  required  autocomplete="off">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group col-md-6">
                                                <div class="form-wrapper">
                                                    <label for="">Contract ID <span style="color: red;">*</span></label>
                                                    <input type="number" min="1" class="form-control" id="" name="contract_id" value="{{$var->contract_id}}" readonly required autocomplete="off">
                                                </div>
                                            </div>
                                            <br>


                                            <div class="form-group col-md-6">
                                                <div class="form-wrapper">
                                                    <label for=""  >Project ID <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="" name="project_id" value="" Required autocomplete="off">
                                                </div>
                                            </div>
                                            <br>


                                            <div class="form-group col-md-6">
                                                <div class="form-wrapper">
                                                    <label for="">Amount <span style="color: red;">*</span></label>
                                                    <input type="number" min="0" class="form-control" id="" name="amount_to_be_paid" value="" Required  autocomplete="off">
                                                </div>
                                            </div>
                                            <br>


                                            <div class="form-group col-md-6">
                                                <label>Currency <span style="color: red;">*</span></label>
                                                <div  class="form-wrapper">
                                                    <select id="" class="form-control" required name="currency">
                                                        <option value="" ></option>
                                                        <option value="TZS" >TZS</option>
                                                        <option value="USD" >USD</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>


                                            <div class="form-group col-md-12">
                                                <div class="form-wrapper">
                                                    <label for=""  >Status <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="" name="status" value="" required  autocomplete="off">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group col-md-12">
                                                <div class="form-wrapper">
                                                    <label for=""  >Description <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="" name="description" value="" required  autocomplete="off">
                                                </div>
                                            </div>
                                            <br>






                                        </div>
                                        @endforeach


                                        <div align="right">
                                            <button class="btn btn-primary" type="submit">Submit</button>
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

                    @if(count($associated_invoices)>0)



                        <table class="hover table table-striped  table-bordered" id="myTable">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>Client</center></th>
                                <th scope="col" style="color:#3490dc;"><center>Invoice Number</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>Start Date</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>End Date</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>Amount</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>Payment Status</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>Invoice Date</center></th>
                                <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($associated_invoices as $var)
                                <tr>
                                    <td><center>{{$i}}</center></td>
                                    <td><center>{{$var->debtor_name}}</center></td>
                                    <td><center>{{$var->invoice_number}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                    <td><center>{{number_format($var->amount_to_be_paid)}} {{$var->currency_invoice}}</center></td>
                                    <td><center>{{$var->payment_status}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>



                                    <td><center>





                                            <a  style="color:#3490dc !important; display:inline-block;"  class="" data-toggle="modal" data-target="#invoice{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center><i class="fa fa-eye" style="font-size: 20px;" aria-hidden="true"></i></center></a>
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










                                            @if($var->email_sent_status=='NOT SENT')
                                                @if($privileges=='Read only')
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







                                            @else

                                            @endif


                                            @if($var->email_sent_status=='SENT')


                                                @if($privileges=='Read only')
                                                @else
                                            <a title="Receive payment" data-toggle="modal" data-target="#add_comment{{$var->invoice_number}}"  role="button" aria-pressed="true" class=""  name="editC"><i class="fa fa-money" style="font-size:20px;" aria-hidden="true"></i></a>
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

@endsection
