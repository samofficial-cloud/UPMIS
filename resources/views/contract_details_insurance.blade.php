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

                    @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

                        <li><a href="/businesses"><i class="fa fa-building" aria-hidden="true"></i> Businesses</a></li>
                    @else
                    @endif
                <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
                <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
                <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>
                <li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
                <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
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

                    @foreach($insurance_contract as $var)


                        <div class="card">
                            <div class="card-body">
                                <h2 style="text-align: center;">Contract details</h2>
                                <hr>
                    <table class="table table-striped table-bordered" style="width: 100%">

                        <tr>
                            <td>Contract ID:</td>
                            <td>{{$var->id}}</td>
                        </tr>


                        <tr>
                            <td>Client Name:</td>
                            <td>{{$var->full_name}}</td>
                        </tr>

                        <tr>
                            <td>Phone Number:</td>
                            <td>{{$var->phone_number}}</td>
                        </tr>

                        <tr>
                            <td>Email:</td>
                            <td>{{$var->email}}</td>
                        </tr>


                        @if($var->vehicle_registration_no!='N/A')
                            <tr>
                                <td>Vehicle Registration Number:</td>
                                <td>{{$var->vehicle_registration_no}}</td>
                            </tr>

                            <tr>
                                <td>Vehicle use:</td>
                                <td>{{$var->vehicle_use}}</td>
                            </tr>

                        @else
                            @endif

                        <tr>
                            <td>Insurance class:</td>
                            <td>{{$var->insurance_class}}</td>
                        </tr>

                        <tr>
                            <td>Principal:</td>
                            <td>{{$var->principal}}</td>
                        </tr>

                        <tr>
                            <td>Insurance Type:</td>
                            <td>{{$var->insurance_type}}</td>
                        </tr>


                        <tr>
                            <td>Contract Duration:</td>
                            <td>{{$var->duration}} {{$var->duration_period}}</td>
                        </tr>

                        <tr>
                            <td>Commission Date:</td>
                            <td>{{date("d/m/Y",strtotime($var->commission_date))}}</td>
                        </tr>

                        <tr>
                            <td>End Date:</td>
                            <td>{{date("d/m/Y",strtotime($var->end_date))}}</td>
                        </tr>


                        <tr>
                            <td> Premium:</td>
                            <td> {{number_format($var->premium)}} {{$var->currency}}</td>
                        </tr>

                        <tr>
                            <td> Commission:</td>
                            <td> {{number_format($var->commission)}} {{$var->currency}}</td>
                        </tr>

                        <tr>
                            <td> Commission(%):</td>
                            <td> {{$var->commission_percentage}} </td>
                        </tr>

                        <tr>
                            <td> Sum insured:</td>
                            <td> {{number_format($var->sum_insured)}} {{$var->currency}}</td>
                        </tr>

                        <tr>
                            <td> Actual(Excluding VAT):</td>
                            <td> {{number_format($var->actual_ex_vat)}} {{$var->currency}}</td>
                        </tr>


                        <tr>
                            <td>Receipt Number:</td>
                            <td>{{$var->receipt_no}}</td>
                        </tr>


                        <tr>
                            <td>Contract Creation Date:</td>
                            <td>{{date("d/m/Y",strtotime($var->created_at))}}</td>
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
