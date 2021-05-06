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
                        <table class="hover table table-striped table-bordered" id="myTableResearch">
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
                <br>
                <div class="card">
                    <div class="card-body">
                        <b><h3>Invoices Details</h3></b>
                        <hr>
                        <table class="hover table table-striped  table-bordered" id="myTable1">
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
                        </table>
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
    </script>
@endsection
