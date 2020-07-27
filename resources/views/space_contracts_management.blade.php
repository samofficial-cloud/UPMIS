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
<li><a href="/invoice_management"><i class="fas fa-file-invoice"></i>Invoice</a></li>
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

        <a href="/space_contract_form" class="btn button_color active" style="    background-color: lightgrey;
    padding: 10px;
    margin-left: -2px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">New Contract</a>

            <br>
            <div class="tab">
                <button class="tablinks" onclick="openContracts(event, 'Active_Contracts')" id="defaultOpen"><strong>ACTIVE CONTRACTS</strong></button>
                <button class="tablinks" onclick="openContracts(event, 'Inactive_Contracts')"><strong>INACTIVE CONTRACTS</strong></button>
            </div>

  <div id="Active_Contracts" class="tabcontent">
      <br>
      <h3>1.ACTIVE CONTRACTS</h3>
      <br>


      <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
          <th scope="col" style="color:#3490dc;"><center>Client Name</center></th>
          <th scope="col" style="color:#3490dc;"><center>Space Id</center></th>
          <th scope="col" style="color:#3490dc;"><center>Amount</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Payment Cycle</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Start Date</center></th>
          <th scope="col"  style="color:#3490dc;"><center>End Date</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Escalation Rate</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($space_contracts as $var)
          <tr>

            <td class="counterCell text-center"></td>
              <td><a class="link_style" data-toggle="modal" data-target="#client{{$var->contract_id}}" style="cursor: pointer;" aria-pressed="true"><center>{{$var->full_name}}</center></a>
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
                                      @elseif($var->type=='Company')
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
              <td><a class="link_style" data-toggle="modal" data-target="#space_id{{$var->contract_id}}" style="cursor: pointer;" aria-pressed="true"><center>{{$var->space_id_contract}}</center></a>
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
                                          <td>Space Id:</td>
                                          <td>{{$var->space_id}}</td>
                                      </tr>

                                      <tr>
                                          <td>Space Type :</td>
                                          <td>{{$var->space_type}}</td>
                                      </tr>
                                      <tr>
                                          <td>Location:</td>
                                          <td>{{$var->location}}</td>
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
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                          </div>
                      </div>
                  </div>
              </td>
            <td><center>{{$var->amount}}</center></td>
            <td><center>{{$var->currency}}</center></td>
            <td><center>{{$var->payment_cycle}}</center></td>
            <td><center>{{date('d/m/Y',strtotime($var->start_date))}}</center></td>
            <td><center>{{date('d/m/Y',strtotime($var->end_date))}}</center></td>
            <td><center>{{$var->escalation_rate}}</center></td>
            <td><center>
                    <a data-toggle="modal" data-target="#terminate{{$var->contract_id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
                    <a href="/edit_space_contract/{{$var->contract_id}}" ><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>

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

                    <a href="#"><i class="fa fa-print" style="font-size:28px;color: #3490dc;"></i></a>
              </center>
            </td>
          </tr>
        @endforeach


        </tbody>
      </table>

      </div>


            <div id="Inactive_Contracts" class="tabcontent">
                <br>
                <h3>2.INACTIVE CONTRACTS</h3>
                <br>


                <table class="hover table table-striped table-bordered" id="myTable2">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                        <th scope="col" style="color:#3490dc;"><center>Client Name</center></th>
                        <th scope="col" style="color:#3490dc;"><center>Space Id</center></th>
                        <th scope="col" style="color:#3490dc;"><center>Amount</center></th>
                        <th scope="col"  style="color:#3490dc;"><center>Currency</center></th>
                        <th scope="col"  style="color:#3490dc;"><center>Payment Cycle</center></th>
                        <th scope="col"  style="color:#3490dc;"><center>Start Date</center></th>
                        <th scope="col"  style="color:#3490dc;"><center>End Date</center></th>
                        <th scope="col"  style="color:#3490dc;"><center>Escalation Rate</center></th>
                        <th scope="col"  style="color:#3490dc;"><center>Status</center></th>
                        <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($space_contracts_inactive as $var)
                        <tr>

                            <td class="counterCell text-center"></td>
                            <td><a class="link_style"  data-toggle="modal" data-target="#client{{$var->contract_id}}"  aria-pressed="true"><center>{{$var->full_name}}</center></a>
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
                                                    @elseif($var->type=='Company')
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
                            <td><a class="link_style" data-toggle="modal" data-target="#space_id{{$var->contract_id}}" style="cursor: pointer;" aria-pressed="true"><center>{{$var->space_id_contract}}</center></a>
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
                                                        <td>Space Id:</td>
                                                        <td>{{$var->space_id}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Space Type :</td>
                                                        <td>{{$var->space_type}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Location:</td>
                                                        <td>{{$var->location}}</td>
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
                                                </table>
                                                <br>
                                                <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><center>{{$var->amount}}</center></td>
                            <td><center>{{$var->currency}}</center></td>
                            <td><center>{{$var->payment_cycle}}</center></td>
                            <td><center>{{date('d/m/Y',strtotime($var->start_date))}}</center></td>
                            <td><center>{{date('d/m/Y',strtotime($var->end_date))}}</center></td>
                            <td><center>{{$var->escalation_rate}}</center></td>
                            @if($var->contract_status==1)
                                <td>Expired</td>
                            @elseif($var->contract_status==0)
                                <td>Terminated</td>
                                @else

                            @endif

                            <td><center>
                                    <a href="{{ route('renew_space_contract_form',$var->contract_id) }}" title="Click to Renew Contract"><center><i class="fa fa-refresh" style="font-size:36px;"></i></center></a>

                                </center>
                            </td>
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
        var table = $('#myTable').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );
        var table2 = $('#myTable2').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );
    </script>
@endsection
