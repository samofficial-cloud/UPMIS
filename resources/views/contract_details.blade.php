@extends('layouts.app')
@section('style')
    <style type="text/css">
        div.dataTables_filter{
            padding-bottom:10px;
        }

        div.top{
            width: 100%;
        }

        div.dt-buttons{
            padding-bottom: 10px;
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


        <?php

        $today=date('Y-m-d');

        $date=date_create($today);

        date_sub($date,date_interval_create_from_date_string("366 days"));
        ?>



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



                        @if($var->tbs_certificate!='')
                            <tr>
                                <td>TBS Certificate:</td>
                                <td><a href="/view_pdf/{{base64_encode(base64_encode(base64_encode($var->contract_id)))}}/tbs_certificate">TBS Certificate <i style="color: red;" class="fas fa-file-pdf"></i></a></td>
                            </tr>
                        @else
                        @endif


                        @if($var->gpsa_certificate!='')
                            <tr>
                                <td>GPSA Certificate:</td>
                                <td><a href="/view_pdf/{{base64_encode(base64_encode(base64_encode($var->contract_id)))}}/gpsa_certificate">GPSA Certificate <i style="color: red;" class="fas fa-file-pdf"></i></a></td>
                            </tr>
                        @else
                        @endif


                        @if($var->food_business_license!='')
                            <tr>
                                <td>Food business licence:</td>
                                <td><a href="/view_pdf/{{base64_encode(base64_encode(base64_encode($var->contract_id)))}}/food_business_license">Food business licence <i style="color: red;" class="fas fa-file-pdf"></i></a></td>
                            </tr>
                        @else
                        @endif


                        @if($var->business_license!='')
                            <tr>
                                <td>Business licence:</td>
                                <td><a href="/view_pdf/{{base64_encode(base64_encode(base64_encode($var->contract_id)))}}/business_license">Business licence <i style="color: red;" class="fas fa-file-pdf"></i></a></td>
                            </tr>
                        @else
                        @endif


                        @if($var->osha_certificate!='')
                            <tr>
                                <td>OSHA Certificate:</td>
                                <td><a href="/view_pdf/{{base64_encode(base64_encode(base64_encode($var->contract_id)))}}/osha_certificate">OSHA Certificate <i style="color: red;" class="fas fa-file-pdf"></i></a></td>
                            </tr>
                        @else
                        @endif


                        @if($var->tcra_registration!='')
                            <tr>
                                <td>TCRA Registration:</td>
                                <td><a href="/view_pdf/{{base64_encode(base64_encode(base64_encode($var->contract_id)))}}/tcra_registration">TCRA Registration <i style="color: red;" class="fas fa-file-pdf"></i></a></td>
                            </tr>
                        @else
                        @endif


                        @if($var->brela_registration!='')
                            <tr>
                                <td>BRELA Registration:</td>
                                <td><a href="/view_pdf/{{base64_encode(base64_encode(base64_encode($var->contract_id)))}}/brela_registration">BRELA Registration <i style="color: red;" class="fas fa-file-pdf"></i></a></td>
                            </tr>
                        @else
                        @endif




                        <tr>
                            <td>Client Name:</td>
                            <td>{{$var->full_name}}</td>
                        </tr>


                        @if($var->has_clients==1)
                        @else
                            <tr>
                                <td> Real Estate Number:</td>
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
                                @if(Auth::user()->role=='DPDI Planner')
                                <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#new_invoice" title="Add new Real Estate Invoice" role="button" aria-pressed="true">Add New Invoice</a>

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



                                                                <div class="form-group col-md-12">
                                                                    <div class="form-wrapper">
                                                                        <label for=""  >Client TIN</label>
                                                                        <input type="text" class="form-control" id="" name="tin" value="{{$var->tin}}" readonly autocomplete="off">
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

                                                                <div   class="form-group col-md-12 mt-1">
                                                                    <div class="form-wrapper">
                                                                        <label for=""  >Inc Code<span style="color: red;">*</span></label>
                                                                        <input type="text" class="form-control" id="inc_code" name="inc_code" value=""  Required autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <div class="form-wrapper">
                                                                        <label for=""  >Invoice Start Date <span style="color: red;">*</span></label>
                                                                        <input  class="flatpickr_date form-control" id="" name="invoicing_period_start_date" value="" Required autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <br>


                                                                <div class="form-group col-md-6">
                                                                    <div class="form-wrapper">
                                                                        <label for=""  >Invoice End Date <span style="color: red;">*</span></label>
                                                                        <input  class="flatpickr_date form-control" id="" name="invoicing_period_end_date" value="" Required autocomplete="off">
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
@endif



                    <?php
                    $i=1;
                    ?>

                    @if(count($associated_invoices)>0)


<div class="pt-4">
                        <table class="hover table table-striped  table-bordered" id="myTable">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"><center>S/N</center></th>
                                <th scope="col" ><center>Client</center></th>
                                <th scope="col"><center>Invoice Number</center></th>
                                <th scope="col" ><center>Start Date</center></th>
                                <th scope="col" ><center>End Date</center></th>
                                <th scope="col" ><center>Amount</center></th>
                                <th scope="col" ><center>Payment Status</center></th>
                                <th scope="col" ><center>Invoice Date</center></th>
                                <th scope="col" ><center>Action</center></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($associated_invoices as $var)
                                <tr>
                                    <td><center>{{$i}}</center></td>
                                    <td><center>{{$var->debtor_name}}</center></td>
                                    <td><center>{{$var->invoice_number_votebook}}</center></td>
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
                                                                            <label for="course_name">GePG Control Number</label>
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

                                                    @if($var->payment_status=='Not paid' AND Auth::user()->role=='Accountant-DPDI')
                                                        <a title="Receive payment" data-toggle="modal" data-target="#add_comment{{$var->invoice_number}}"  role="button" aria-pressed="true"   name="editC"><i class="fa fa-money" style="font-size:20px; color:#3490dc !important;" aria-hidden="true"></i></a>
                                                        <div class="modal fade" id="add_comment{{$var->invoice_number}}" role="dialog">

                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b><h5 class="modal-title">Invoice Number: {{$var->invoice_number_votebook}} </h5></b>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form method="post" action="{{ route('change_payment_status_space',$var->invoice_number)}}"  id="form1" >
                                                                            {{csrf_field()}}
                                                                            <div style="text-align: left;" class="form-row">

                                                                                <input type="hidden" min="1" class="form-control" id="invoice_number_space" readonly name="invoice_number" value="{{$var->invoice_number}}" Required autocomplete="off">

                                                                                @if($var->invoice_number_votebook=='')
                                                                                    <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                        <div class="form-wrapper">
                                                                                            <label for="">Invoice Number <span style="color: red;">*</span></label>
                                                                                            <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" value="" Required autocomplete="off">
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                @else
                                                                                    <div style="padding-top: 2%;" class="form-group col-md-12">
                                                                                        <div class="form-wrapper">
                                                                                            <label for="">Invoice Number <span style="color: red;">*</span></label>
                                                                                            <input type="number" min="1" class="form-control" id="votebook_space" name="invoice_number_votebook" readonly value="{{$var->invoice_number_votebook}}" Required autocomplete="off">
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
                                                                                        <input  min="{{date_format($date,"Y-m-d")}}" max="{{date("Y-m-d")}}" class="flatpickr_date form-control" id="receipt_space" name="date_of_payment" value="" required  autocomplete="off">
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

                                                @endif

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






                    <br>

                    <div class="card">
                        <div class="card-body">
                            <br>
                            <h2 style="text-align: center">Associated Payments</h2>
                            <br>



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

                                @if(count($associated_payments)>0)
                                    <br><br>

                                    <div id="space_content">
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

                                            @foreach($associated_payments as $var)
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


        var table = $('#myTable2').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );


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




        // var table = $('#myTable2').DataTable( {
        //     dom: '<"top"fl><"top"<"pull-right" B>>rt<"bottom"pi>',
        //     buttons: [
        //         {   extend: 'pdfHtml5',
        //             filename:'Real Estate Payments',
        //             download: 'open',
        //             text: '<i class="fa fa-file-pdf-o"></i> PDF',
        //             className: 'excelButton',
        //             orientation: 'Potrait',
        //             title: 'UNIVERSITY OF DAR ES SALAAM',
        //             messageTop: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \n Real Estate Payments',
        //             pageSize: 'A4',
        //             //layout: 'lightHorizontalLines',
        //             exportOptions: {
        //                 columns: [ 0, 1, 2, 3, 4, 5]
        //             },
        //
        //
        //
        //             customize: function ( doc ) {
        //
        //                 doc.defaultStyle.font = 'Times';
        //
        //                 doc['footer'] = (function (page, pages) {
        //                     return {
        //                         alignment: 'center',
        //                         text: [{ text: page.toString() }]
        //
        //                     }
        //                 });
        //
        //                 doc.content[2].table.widths=[22, 80, 100, 80, 100, 80];
        //                 var rowCount = doc.content[2].table.body.length;
        //                 for (i = 1; i < rowCount; i++) {
        //                     doc.content[2].table.body[i][0]=i+'.';
        //                     doc.content[2].table.body[i][1].alignment = 'left';
        //                     doc.content[2].table.body[i][2].alignment = 'left';
        //                     doc.content[2].table.body[i][3].alignment = 'left';
        //                     doc.content[2].table.body[i][5].alignment = 'left';
        //
        //                 };
        //
        //                 doc.defaultStyle.alignment = 'center';
        //
        //                 doc.content[2].table.body[0].forEach(function (h) {
        //                     h.fillColor = 'white';
        //                     alignment: 'center';
        //                 });
        //
        //                 doc.styles.title = {
        //                     bold: 'true',
        //                     fontSize: '12',
        //                     alignment: 'center'
        //                 };
        //
        //                 doc.styles.tableHeader.color = 'black';
        //                 doc.styles.tableHeader.bold = 'false';
        //                 doc.styles.tableBodyOdd.fillColor='';
        //                 doc.styles.tableHeader.fontSize = 10;
        //                 doc.content[2].layout ={
        //                     hLineWidth: function (i, node) {
        //                         return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        //                     },
        //                     vLineWidth: function (i, node) {
        //                         return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        //                     },
        //                     hLineColor: function (i, node) {
        //                         return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        //                     },
        //                     vLineColor: function (i, node) {
        //                         return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        //                     },
        //                     fillColor: function (rowIndex, node, columnIndex) {
        //                         return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        //                     }
        //                 };
        //
        //
        //                 doc.content.splice( 1, 0, {
        //                     margin: [ 0, 0, 0, 12 ],
        //                     alignment: 'center',
        //                     image: 'data:image/png;base64,'+base64,
        //                     fit: [40, 40]
        //                 } );
        //             }
        //         },
        //
        //         {   extend: 'excelHtml5',
        //             text: '<i class="fa fa-file-excel-o"></i> EXCEL',
        //             className: 'excelButton',
        //             title: 'Real Estate Payments',
        //             exportOptions: {
        //                 columns: [1, 2, 3, 4, 5]
        //             },
        //         },
        //     ]
        // } );


    </script>

@endsection
