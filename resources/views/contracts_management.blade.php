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
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>
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

            {{--<div style="width:100%; text-align: center ">--}}
                {{--<br>--}}
                {{--<h2>CONTRACTS</h2>--}}

                {{--<br>--}}

            {{--</div>--}}

            <div class="tab">
                <button class="tablinksOuter" onclick="openContractType(event, 'space_contracts')"  id="defaultContract"><strong>SPACE CONTRACTS</strong></button>
                <button class="tablinksOuter" onclick="openContractType(event, 'insurance_contracts')"><strong>INSURANCE CONTRACTS</strong></button>
                <button class="tablinksOuter" onclick="openContractType(event, 'car_contracts')" ><strong>CAR RENTAL CONTRACTS</strong></button>
            </div>





            <div id="space_contracts" class="tabcontentOuter">
                <br>
                <h4 style="text-align: center">REAL ESTATE CONTRACTS</h4>



        <a href="/space_contract_form" class="btn button_color active" style="    background-color: lightgrey;
    padding: 10px;
    margin-left: -2px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true" title="Add new Space Contract"><i  class="fa fa-plus" aria-hidden="true"></i></a>



      <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
          <th scope="col" style="color:#3490dc;"><center>Client Name</center></th>
          <th scope="col" style="color:#3490dc;"><center>Space Number</center></th>
          <th scope="col" style="color:#3490dc;"><center>Amount</center></th>


          <th scope="col"  style="color:#3490dc;"><center>Start Date</center></th>
          <th scope="col"  style="color:#3490dc;"><center>End Date</center></th>

          <th scope="col"  style="color:#3490dc;"><center>Status</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($space_contracts as $var)
          <tr>

            <td class="counterCell text-center"></td>
              <td><a class="link_style" data-toggle="modal" data-target="#client{{$var->contract_id}}" style="color: blue !important; text-decoration: underline !important;  cursor: pointer;" aria-pressed="true"><center>{{$var->full_name}}</center></a>
                  <div class="modal fade" id="client{{$var->contract_id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">{{$var->full_name}} Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                  <table style="width: 100%">
                                      <tr>
                                          <td>Client Type:</td>
                                          <td>{{$var->type}}</td>
                                      </tr>
                                      @if($var->type=='Individual')
                                          <tr>
                                              <td> First Name:</td>
                                              <td> {{$var->first_name}}</td>
                                          </tr>
                                          <tr>
                                              <td>Last Name:</td>
                                              <td>{{$var->last_name}}</td>
                                          </tr>
                                      @elseif($var->type=='Company/Organization')
                                          <tr>
                                              <td>Company Name:</td>
                                              <td>{{$var->first_name}}</td>
                                          </tr>
                                      @endif
                                      <tr>
                                          <td>Phone Number:</td>
                                          <td>{{$var->phone_number}}</td>
                                      </tr>
                                      <tr>
                                          <td>Email:</td>
                                          <td>{{$var->email}}</td>
                                      </tr>
                                      <tr>
                                          <td>Address:</td>
                                          <td>{{$var->address}}</td>
                                      </tr>
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                          </div>
                      </div>
                  </div>
              </td>
              <td><a class="link_style" data-toggle="modal" data-target="#space_id{{$var->contract_id}}" style="color: blue !important; text-decoration: underline !important;  cursor: pointer;" aria-pressed="true"><center>{{$var->space_id_contract}}</center></a>
                  <div class="modal fade" id="space_id{{$var->contract_id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">{{$var->space_id_contract}} Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                  <table style="width: 100%">
                                      <tr>
                                          <td>Space number:</td>
                                          <td>{{$var->space_id}}</td>
                                      </tr>

                                      <tr>
                                          <td>Major industry :</td>
                                          <td>{{$var->major_industry}}</td>
                                      </tr>

                                      <tr>
                                          <td>Minor industry :</td>
                                          <td>{{$var->minor_industry}}</td>
                                      </tr>

                                      <tr>
                                          <td>Location:</td>
                                          <td>{{$var->location}}</td>
                                      </tr>

                                      <tr>
                                          <td>Sub location:</td>
                                          <td>{{$var->sub_location}}</td>
                                      </tr>

                                      <tr>
                                          <td>Size (SQM):</td>
                                          <td>{{$var->size}}</td>
                                      </tr>

                                      <tr>
                                          <td>Rent price guide:</td>
                                          <td>

                                              @if($var->rent_price_guide_from==null)
                                                N/A
                                              @else
                                                {{$var->rent_price_guide_from}} - {{$var->rent_price_guide_to}} {{$var->rent_price_guide_currency}}
                                              @endif

                                              </td>
                                      </tr>


                                      <tr>
                                          <td>Required to also pay electricity bill:</td>
                                          <td>{{$var->has_electricity_bill_space}}</td>
                                      </tr>

                                      <tr>
                                          <td>Required to also pay water bill:</td>
                                          <td>{{$var->has_water_bill_space}}</td>
                                      </tr>






                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                          </div>
                      </div>
                  </div>
              </td>
            <td><center>{{$var->amount}} {{$var->currency}}</center></td>


            <td><center>{{date('d/m/Y',strtotime($var->start_date))}}</center></td>
            <td><center>{{date('d/m/Y',strtotime($var->end_date))}}</center></td>

            <td><center>
                    @if($var->contract_status==0)
                      TERMINATED
                    @elseif($var->end_date<date('Y-m-d'))
                        EXPIRED
                        @else
                        ACTIVE
                        @endif
                    </center></td>
            <td><center>
                    <a  style="color:#3490dc !important; display:inline-block;" href="{{route('contract_details',$var->contract_id)}}" class=""   style="cursor: pointer;" ><center><i class="fa fa-eye" aria-hidden="true"></i></center></a>






                    @if(($var->contract_status==1 AND $var->end_date>=date('Y-m-d')))
                    <a data-toggle="modal" title="Click to terminate this contract" data-target="#terminate{{$var->contract_id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
                        <a title="Click to edit this contract"   href="/edit_space_contract/{{$var->contract_id}}" ><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>
                    @else
                    @endif



                    <div class="modal fade" id="terminate{{$var->contract_id}}" role="dialog">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                        <b><h5 class="modal-title">Are you sure you want to terminate {{$var->full_name}}'s contract for space id {{$var->space_id_contract}}?</h5></b>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <form method="get" action="{{ route('terminate_space_contract',$var->contract_id)}}" >
                                        {{csrf_field()}}

                                        <div align="right">
                                            <button class="btn btn-primary" type="submit" id="newdata">Yes</button>
                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">No</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>

                    @if($var->contract_status==0 OR $var->end_date<date('Y-m-d'))

{{--                    <a href="#"><i class="fa fa-print" style="font-size:28px;color: #3490dc;"></i></a>--}}
                        <a href="{{ route('renew_space_contract_form',$var->contract_id) }}" title="Click to renew this contract"><center><i class="fa fa-refresh" style="font-size:36px;"></i></center></a>
                        @else

                    @endif
              </center>
            </td>
          </tr>
        @endforeach


        </tbody>
      </table>





            </div>



            <div id="insurance_contracts" class="tabcontentOuter">
                <br>
                <h4 style="text-align: center">INSURANCE CONTRACTS</h4>



                <a href="/insurance_contract_form" title="Add new Insurance contract"  class="btn button_color active" style="     background-color: lightgrey;
    padding: 10px;
    margin-left: -2px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true"><i  class="fa fa-plus" aria-hidden="true"></i></a>


                <div class="">



                    <table class="hover table table-striped table-bordered" id="myTableInsurance">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                            <th scope="col" style="color:#3490dc;"><center>Client Name</center></th>
                            <th scope="col" style="color:#3490dc;"><center>Vehicle Reg No</center></th>
                            <th scope="col" style="color:#3490dc;"><center>Vehicle Use</center></th>
                            <th scope="col" style="color:#3490dc;"><center>Principal</center></th>
                            <th scope="col"  style="color:#3490dc;"><center>Insurance Type</center></th>
                            <th scope="col"  style="color:#3490dc;"><center>Commission Date</center></th>
                            <th scope="col"  style="color:#3490dc;"><center>End Date</center></th>
                            <th scope="col"  style="color:#3490dc;"><center>Sum Insured</center></th>
                            <th scope="col"  style="color:#3490dc;"><center>Premium</center></th>
                            <th scope="col"  style="color:#3490dc;"><center>Actual(Excluding VAT) </center></th>
                            <th scope="col"  style="color:#3490dc;"><center>Currency </center></th>
                            <th scope="col"  style="color:#3490dc;"><center>Commission </center></th>
                            <th scope="col"  style="color:#3490dc;"><center>Receipt No </center></th>
                            <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($insurance_contracts as $var)
                            <tr>

                                <td class="counterCell text-center"></td>
                                <td><center>{{$var->full_name}}</center></td>
                                <td><center>{{$var->vehicle_registration_no}}</center></td>
                                <td><center>{{$var->vehicle_use}}</center></td>
                                <td><center>{{$var->principal}}</center></td>
                                <td><center>{{$var->insurance_type}}</center></td>
                                <td><center>{{$var->commission_date}}</center></td>
                                <td><center>{{$var->end_date}}</center></td>
                                <td><center>{{$var->sum_insured}}</center></td>
                                <td><center>{{$var->premium}}</center></td>
                                <td><center>{{$var->actual_ex_vat}}</center></td>
                                <td><center>{{$var->currency}}</center></td>
                                <td><center>{{$var->commission}}</center></td>
                                <td><center>{{$var->receipt_no}}</center></td>
                                <td><center>
                                        <a data-toggle="modal" data-target="#terminate{{$var->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
                                        <a href="/edit_insurance_contract/{{$var->id}}" ><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>

                                        <div class="modal fade" id="terminate{{$var->id}}" role="dialog">

                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <b><h5 class="modal-title">Are you sure you want to terminate insurance contract for vehicle with registration number {{$var->vehicle_registration_no}}?</h5></b>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form method="get" action="{{ route('terminate_insurance_contract',$var->id)}}" >
                                                            {{csrf_field()}}

                                                            <div align="right">
                                                                <button class="btn btn-primary" type="submit" id="newdata">Yes</button>
                                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">No</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                    </center>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>

                </div>



            </div>



            {{--<div id="car_contracts" class="tabcontent">--}}
                {{--<br>--}}
                {{--<h3>CAR RENTAL CONTRACTS</h3>--}}
                {{--<br>--}}



            {{--</div>--}}







    </div>
  </div>
</div>
</div>
@endsection

@section('pagescript')
    <script type="text/javascript">
        function openContracts(evt, evtName) {
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


    <script type="text/javascript">
        function openContractType(evt, evtName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontentOuter");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinksOuter");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(evtName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        document.getElementById("defaultContract").click();
    </script>



    <script type="text/javascript">
        var table = $('#myTable').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );
        var table2 = $('#myTable2').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );


        var table2 = $('#myTableInsurance').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );
    </script>
@endsection
