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

                <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>

                <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
                <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
                <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
                <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
                <div class="dropdown">
                    <li class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-contract"></i> Contracts
                    </li>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="/contracts/car_rental">Car Rental</a>
                        <a class="dropdown-item" href="/insurance_contracts_management">Insurance</a>
                        <a class="dropdown-item" href="/space_contracts_management">Space</a>
                    </div>
                </div>
                <div class="dropdown">
  <li class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-file-contract"></i> Invoices
  </li>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="/invoice_management">Space</a>
    <a class="dropdown-item" href="/car_rental_invoice_management">Car Rental</a>
    <a class="dropdown-item" href="/insurance_invoice_management">Insurance</a>
<a class="dropdown-item" href="/water_bills_invoice_management">Water</a>
<a class="dropdown-item" href="/electricity_bills_invoice_management">Electricity</a>
  </div>
</div>
            <li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payment</a></li>
                <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
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

                    <div style="width:100%; text-align: center ">
                        <br>
                        <h2>PAYMENTS</h2>

                        <br>

                    </div>


                    <div class="tab">
                        <button class="tablinks" onclick="openInvoices(event, 'space_payments')" id="defaultOpen"><strong>SPACE</strong></button>
                        <button class="tablinks" onclick="openInvoices(event, 'car_rental_payments')"><strong>CAR RENTAL</strong></button>
                        <button class="tablinks" onclick="openInvoices(event, 'insurance_payments')"><strong>INSURANCE</strong></button>
                        <button class="tablinks" onclick="openInvoices(event, 'water_payments')"><strong>WATER BILLS</strong></button>
                        <button class="tablinks" onclick="openInvoices(event, 'electricity_payments')"><strong>ELECTRICITY BILLS</strong></button>

                    </div>


                    <div id="space_payments" class="tabcontent">
                        <br>
                        <h5>1. SPACE PAYMENTS</h5>
                        <br>
                        <?php
                        $i=1;
                        ?>

                        @if(count($space_payments)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Votebook Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Amount Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount Not Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Receipt Number</center></th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($space_payments as $var)
                                    <tr>

                                        <td class="counterCell text-center"></td>
                                        <td><center>{{$var->invoice_number}}</center></td>
                                        <td><center>{{$var->invoice_number_votebook}}</center></td>
                                        <td><center>{{$var->amount_paid}}</center></td>
                                        <td><center>{{$var->amount_not_paid}}</center></td>
                                        <td><center>{{$var->currency}}</center></td>
                                        <td><center>{{$var->receipt_number}}</center></td>

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
                        <h5>2. CAR RENTAL PAYMENTS</h5>
                        <br>
                        <?php
                        $i=1;
                        ?>

                        @if(count($car_rental_payments)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable2">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Votebook Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Amount Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount Not Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Receipt Number</center></th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($car_rental_payments as $var)
                                    <tr>

                                        <td class="counterCell text-center"></td>
                                        <td><center>{{$var->invoice_number}}</center></td>
                                        <td><center>{{$var->invoice_number_votebook}}</center></td>
                                        <td><center>{{$var->amount_paid}}</center></td>
                                        <td><center>{{$var->amount_not_paid}}</center></td>
                                        <td><center>{{$var->currency}}</center></td>
                                        <td><center>{{$var->receipt_number}}</center></td>

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
                        <h5>3. INSURANCE PAYMENTS</h5>
                        <br>
                        <?php
                        $i=1;
                        ?>

                        @if(count($insurance_payments)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable3">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Votebook Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Amount Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount Not Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Receipt Number</center></th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($insurance_payments as $var)
                                    <tr>

                                        <td class="counterCell text-center"></td>
                                        <td><center>{{$var->invoice_number}}</center></td>
                                        <td><center>{{$var->invoice_number_votebook}}</center></td>
                                        <td><center>{{$var->amount_paid}}</center></td>
                                        <td><center>{{$var->amount_not_paid}}</center></td>
                                        <td><center>{{$var->currency}}</center></td>
                                        <td><center>{{$var->receipt_number}}</center></td>

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
                        <h5>4. WATER BILL PAYMENTS</h5>
                        <br>
                        <?php
                        $i=1;
                        ?>

                        @if(count($water_bill_payments)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable4">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Votebook Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Amount Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount Not Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Receipt Number</center></th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($water_bill_payments as $var)
                                    <tr>

                                        <td class="counterCell text-center"></td>
                                        <td><center>{{$var->invoice_number}}</center></td>
                                        <td><center>{{$var->invoice_number_votebook}}</center></td>
                                        <td><center>{{$var->amount_paid}}</center></td>
                                        <td><center>{{$var->amount_not_paid}}</center></td>
                                        <td><center>{{$var->currency}}</center></td>
                                        <td><center>{{$var->receipt_number}}</center></td>

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
                        <h5>5. ELECTRICITY BILL PAYMENTS</h5>
                        <br>
                        <?php
                        $i=1;
                        ?>

                        @if(count($electricity_bill_payments)>0)



                            <table class="hover table table-striped  table-bordered" id="myTable5">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Votebook Invoice Number</center></th>
                                    <th scope="col" style="color:#3490dc;"><center>Amount Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Amount Not Paid</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                                    <th scope="col"  style="color:#3490dc;"><center>Receipt Number</center></th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($electricity_bill_payments as $var)
                                    <tr>

                                        <td class="counterCell text-center"></td>
                                        <td><center>{{$var->invoice_number}}</center></td>
                                        <td><center>{{$var->invoice_number_votebook}}</center></td>
                                        <td><center>{{$var->amount_paid}}</center></td>
                                        <td><center>{{$var->amount_not_paid}}</center></td>
                                        <td><center>{{$var->currency}}</center></td>
                                        <td><center>{{$var->receipt_number}}</center></td>

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

@endsection
