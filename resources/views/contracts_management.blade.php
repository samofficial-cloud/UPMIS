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

            @if($category=='Real Estate only' OR $category=='All')
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            @else
            @endif

            @if($category=='Insurance only' OR $category=='All')
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
    @else
    @endif
            @if(($category=='CPTU only' OR $category=='All') && (Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
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

            <div style="width:100%; text-align: center ">
                <br>
                <h2>CONTRACTS MANAGEMENT</h2>

                <br>

            </div>

            <div class="tab">




                    @if ($category=='Real Estate only' OR $category=='All')
                        <button class="tablinksOuter  space_identity" onclick="openContractType(event, 'space_contracts')"  ><strong>Real Estate Contracts</strong></button>


                


                    @else
                    @endif




                        @if($category=='Insurance only' OR $category=='All')
                            <button class="tablinksOuter insurance_identity" onclick="openContractType(event, 'insurance_contracts')"><strong>Insurance Contracts</strong></button>

                        @else
                        @endif



                        @if ($category=='CPTU only' OR $category=='All')
                            <button class="tablinksOuter car_identity" onclick="openContractType(event, 'car_contracts')" id="carss"><strong>Car Rental Contracts</strong></button>
                        @else
                        @endif




            </div>





            <div id="space_contracts" class="tabcontentOuter">
                <br>
                <h4 style="text-align: center">Real Estate Contracts</h4>


                @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                @else
        <a href="/space_contract_form" class="btn button_color active" style="    background-color: lightgrey;
    padding: 10px;
    margin-left: -2px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true" title="Add new Space Contract"><i  class="fa fa-plus" aria-hidden="true"></i></a>
                @endif


      <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col" style="color:#fff;"><center>S/N</center></th>
          <th scope="col" style="color:#fff;"><center>Client Name</center></th>
          <th scope="col" style="color:#fff;"><center>Space Number</center></th>
          <th scope="col" style="color:#fff;"><center>Amount</center></th>


          <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
          <th scope="col"  style="color:#fff;"><center>End Date</center></th>

          <th scope="col"  style="color:#fff;"><center>Status</center></th>
          <th scope="col"  style="color:#fff;"><center>Action</center></th>
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
                    <a title="View more details"  style="color:#3490dc !important; display:inline-block;" href="{{route('contract_details',$var->contract_id)}}" class=""   style="cursor: pointer;" ><center><i class="fa fa-eye" style="font-size:20px;" aria-hidden="true"></i></center></a>






                    @if(($var->contract_status==1 AND $var->end_date>=date('Y-m-d')))
                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                        @else
                        <a title="Click to edit this contract"   href="/edit_space_contract/{{$var->contract_id}}" ><i class="fa fa-edit" style="font-size:20px; color: green;"></i></a>
                        <a data-toggle="modal" title="Click to terminate this contract" data-target="#terminate{{$var->contract_id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red;"></i></a>
                        @endif

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
                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI')
                        @else
                        <a href="{{ route('renew_space_contract_form',$var->contract_id) }}" style="display:inline-block;" title="Click to renew this contract"><center><i class="fa fa-refresh" style="font-size:20px;"></i></center></a>
                        @endif

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
                <h4 style="text-align: center">Insurance Contracts</h4>


                @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                @else
                <a href="/insurance_contract_form" title="Add new Insurance contract"  class="btn button_color active" style="     background-color: lightgrey;
    padding: 10px;
    margin-left: -2px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true"><i  class="fa fa-plus" aria-hidden="true"></i></a>
                @endif

                <div class="">



                    <table class="hover table table-striped table-bordered" id="myTableInsurance">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="color:#fff;"><center>S/N</center></th>
                            <th scope="col" style="color:#fff;"><center>Client Name</center></th>
                            <th scope="col" style="color:#fff;"><center>Vehicle Reg No</center></th>
                            <th scope="col" style="color:#fff;"><center>Vehicle Use</center></th>
                            <th scope="col" style="color:#fff;"><center>Principal</center></th>
                            <th scope="col"  style="color:#fff;"><center>Insurance Type</center></th>
                            <th scope="col"  style="color:#fff;"><center>Commission Date</center></th>
                            <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                            <th scope="col"  style="color:#fff;"><center>Sum Insured</center></th>
                            <th scope="col"  style="color:#fff;"><center>Premium</center></th>
                            <th scope="col"  style="color:#fff;"><center>Actual(Excluding VAT) </center></th>
                            <th scope="col"  style="color:#fff;"><center>Currency </center></th>
                            <th scope="col"  style="color:#fff;"><center>Commission </center></th>
                            <th scope="col"  style="color:#fff;"><center>Receipt No </center></th>
                            <th scope="col"  style="color:#fff;"><center>Action</center></th>
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

                                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                                        @else
                                        <a href="/edit_insurance_contract/{{$var->id}}" ><i class="fa fa-edit" style="font-size:20px; color: green;"></i></a>
                                        <a data-toggle="modal" data-target="#terminate{{$var->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red;"></i></a>
                                        @endif

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

 @if ($category=='CPTU only' OR $category=='All')
            <div id="car_contracts" class="tabcontentOuter">
               
                {{-- <h4 style="text-align: center">Car Rental Contracts</h4> --}}
                <br>
                @if(Auth::user()->role=='Transport Officer-CPTU')
  <a class="btn btn-success" href="{{ route('carRentalForm') }}" role="button" style="
    padding: 10px; margin-bottom: 5px; margin-top: 4px;">New Contract
  </a>
<br>
<br>

  <div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'closed')"><strong>Active Contract</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'closed_2')"><strong>Inactive Contract</strong></button>
        </div>
<div id="inbox" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
  <br>
  @if(count($inbox)>0)
<table>
    <thead>
      <th style="width: 16%"><center>Form Id</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Destination</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
        <td><center><a href="{{ route('carRentalFormE',$inbox->id) }}">{{$inbox->id}}</a></center></td>
        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->designation}} {{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($inbox->start_date))}} - {{date("d/m/Y",strtotime($inbox->end_date))}}</td>
        <td><center>{{$inbox->destination}}</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif
</div>

<div id="outbox" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
  <br>
  @if(count($outbox)>0)
  <table>
    <thead>
      <th style="width: 14%"><center>Form Id</center></th>
      <th style="width: 14%"><center>Initiated By</center></th>
      <th style="width: 14%"><center>Client Name</center></th>
      <th style="width: 14%"><center>Department/Faculty/unit</center></th>
      <th style="width: 15%"><center>Trip Date</center></th>
      <th style="width: 14%"><center>Destination</center></th>
      <th style="width: 14%"><center>Form Status</center></th>
    </thead>
    <tbody>
      @foreach($outbox as $outbox)
      <tr>
        <td><center>{{$outbox->id}}</center></td>
        <td><center>{{$outbox->form_initiator}}</center></td>
        <td><center>{{$outbox->designation}} {{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($outbox->start_date))}} - {{date("d/m/Y",strtotime($outbox->end_date))}}</td>
         <td><center>{{$outbox->destination}}</center></td>
        <td><center>{{$outbox->form_status}} Stage</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif

</div>
<div id="closed" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_act as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td><center>{{$closed->destination}}</center></td>
         <td>{{number_format($closed->grand_total)}}</td>
         <td><center>
            <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a title="Print this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div id="closed_2" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar3">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_inact as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td><center>{{$closed->destination}}</center></td>
         <td>{{number_format($closed->grand_total)}}</td>
         <td><center>
            <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a title="Print this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@elseif(Auth::user()->role=='Vote Holder')
  <div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'closed')"><strong>Active Contract</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'closed_2')"><strong>Inactive Contract</strong></button>
        </div>
<div id="inbox" class="tabcontent">
  <br>
  @if(count($inbox)>0)
<table>
    <thead>
      <th style="width: 16%"><center>Form Id</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Destination</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
        <td><center><a href="{{ route('carRentalFormB',$inbox->id) }}">{{$inbox->id}}</a></center></td>
        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->designation}} {{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($inbox->start_date))}} to {{date("d/m/Y",strtotime($inbox->end_date))}}</td>
         <td><center>{{$inbox->destination}}</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
   @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif
</div>

<div id="outbox" class="tabcontent">
  <br>
  @if(count($outbox)>0)
<table>
   <thead>
      <th style="width: 14%"><center>Form Id</center></th>
      <th style="width: 14%"><center>Initiated By</center></th>
      <th style="width: 14%"><center>Client Name</center></th>
      <th style="width: 14%"><center>Department/Faculty/unit</center></th>
      <th style="width: 15%"><center>Trip Date</center></th>
      <th style="width: 14%"><center>Destination</center></th>
      <th style="width: 14%"><center>Form Status</center></th>
    </thead>
    <tbody>
      @foreach($outbox as $outbox)
      <tr>
        <td><center>{{$outbox->id}}</center></td>
        <td><center>{{$outbox->form_initiator}}</center></td>
        <td><center>{{$outbox->designation}} {{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($outbox->start_date))}} to {{date("d/m/Y",strtotime($outbox->end_date))}}</td>
         <td><center>{{$outbox->destination}}</center></td>
        <td><center>{{$outbox->form_status}} Stage</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
   @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif
</div>
<div id="closed" class="tabcontent">
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_act as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td><center>{{$closed->destination}}</center></td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a title="Print this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div id="closed_2" class="tabcontent">
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar4">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_inact as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td><center>{{$closed->destination}}</center></td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a title="Print this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@elseif(Auth::user()->role=='Accountant-Cost Centre')
  <div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'closed')"><strong>Active Contract</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'closed_2')"><strong>Inactive Contract</strong></button>
        </div>
<div id="inbox" class="tabcontent">
  <br>
  @if(count($inbox)>0)
<table>
    <thead>
      <th style="width: 16%"><center>Form Id</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Destination</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
        <td><center><a href="{{ route('carRentalFormC',$inbox->id) }}">{{$inbox->id}}</a></center></td>
        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->designation}} {{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($inbox->start_date))}} to {{date("d/m/Y",strtotime($inbox->end_date))}}</td>
         <td><center>{{$inbox->destination}}</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
   @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif
</div>

<div id="outbox" class="tabcontent">
  <br>
  @if(count($outbox)>0)
<table>
   <thead>
      <th style="width: 14%"><center>Form Id</center></th>
      <th style="width: 14%"><center>Initiated By</center></th>
      <th style="width: 14%"><center>Client Name</center></th>
      <th style="width: 14%"><center>Department/Faculty/unit</center></th>
      <th style="width: 15%"><center>Trip Date</center></th>
      <th style="width: 14%"><center>Destination</center></th>
      <th style="width: 14%"><center>Form Status</center></th>
    </thead>
    <tbody>
      @foreach($outbox as $outbox)
      <tr>
        <td><center>{{$outbox->id}}</center></td>
        <td><center>{{$outbox->form_initiator}}</center></td>
        <td><center>{{$outbox->designation}} {{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($outbox->start_date))}} to {{date("d/m/Y",strtotime($outbox->end_date))}}</td>
         <td><center>{{$outbox->destination}}</center></td>
        <td><center>{{$outbox->form_status}} Stage</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
   @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif
</div>
<div id="closed" class="tabcontent">
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_act as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td><center>{{$closed->destination}}</center></td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc;cursor: pointer;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a title="Print this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div id="closed_2" class="tabcontent">
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar5">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_inact as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td><center>{{$closed->destination}}</center></td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc;cursor: pointer;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a title="Print this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@elseif(Auth::user()->role=='Head of CPTU')
<a class="btn btn-success" href="{{ route('carRentalForm') }}" role="button" style="
    padding: 10px; margin-bottom: 5px; margin-top: 4px;">New Contract
  </a>
  <br><br>
  <div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'closed')"><strong>Active Contract</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'closed_2')"><strong>Inactive Contract</strong></button>
        </div>
<div id="inbox" class="tabcontent">
  <br>
  @if(count($inbox)>0)
<table>
    <thead>
      <th style="width: 16%"><center>Form Id</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Destination</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
        <td><center><a href="{{ route('carRentalFormD',$inbox->id) }}">{{$inbox->id}}</a></center></td>
        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->designation}} {{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($inbox->start_date))}} to {{date("d/m/Y",strtotime($inbox->end_date))}}</td>
        <td><center>{{$inbox->destination}}</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
   @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif
</div>

<div id="outbox" class="tabcontent">
  <br>
  @if(count($outbox)>0)
<table>
   <thead>
      <th style="width: 14%"><center>Form Id</center></th>
      <th style="width: 14%"><center>Initiated By</center></th>
      <th style="width: 14%"><center>Client Name</center></th>
      <th style="width: 14%"><center>Department/Faculty/unit</center></th>
      <th style="width: 15%"><center>Trip Date</center></th>
      <th style="width: 14%"><center>Destination</center></th>
      <th style="width: 14%"><center>Form Status</center></th>
    </thead>
    <tbody>
      @foreach($outbox as $outbox)
      <tr>
        <td><center>{{$outbox->id}}</center></td>
        <td><center>{{$outbox->form_initiator}}</center></td>
        <td><center>{{$outbox->designation}} {{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($outbox->start_date))}} to {{date("d/m/Y",strtotime($outbox->end_date))}}</td>
         <td><center>{{$outbox->destination}}</center></td>
        <td><center>{{$outbox->form_status}} Stage</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
   @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif
</div>
<div id="closed" class="tabcontent">
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_act as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td><center>{{$closed->destination}}</center></td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a title="Print this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div id="closed_2" class="tabcontent">
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar6">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_inact as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td><center>{{$closed->destination}}</center></td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a title="Print this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@elseif(Auth::user()->role=='DVC Administrator')
  <div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'closed')"><strong>Active Contract</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'closed_2')"><strong>Inactive Contract</strong></button>
        </div>
<div id="inbox" class="tabcontent">
  <br>
  @if(count($inbox)>0)
<table>
    <thead>
      <th style="width: 16%"><center>Form Id</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Destination</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
        <td><center><a href="{{ route('carRentalFormD1',$inbox->id) }}">{{$inbox->id}}</a></center></td>
        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->designation}} {{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($inbox->start_date))}} to {{date("d/m/Y",strtotime($inbox->end_date))}}</td>
         <td><center>{{$inbox->destination}}</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
   @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif
</div>

<div id="outbox" class="tabcontent">
  <br>
  @if(count($outbox)>0)
<table>
   <thead>
      <th style="width: 14%"><center>Form Id</center></th>
      <th style="width: 14%"><center>Initiated By</center></th>
      <th style="width: 14%"><center>Client Name</center></th>
      <th style="width: 14%"><center>Department/Faculty/unit</center></th>
      <th style="width: 15%"><center>Trip Date</center></th>
      <th style="width: 14%"><center>Destination</center></th>
      <th style="width: 14%"><center>Form Status</center></th>
    </thead>
    <tbody>
      @foreach($outbox as $outbox)
      <tr>
        <td><center>{{$outbox->id}}</center></td>
        <td><center>{{$outbox->form_initiator}}</center></td>
        <td><center>{{$outbox->designation}} {{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($outbox->start_date))}} to {{date("d/m/Y",strtotime($outbox->end_date))}}</td>
         <td><center>{{$outbox->destination}}</center></td>
        <td><center>{{$outbox->form_status}} Stage</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
   @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif
</div>
<div id="closed" class="tabcontent">
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_act as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td><center>{{$closed->destination}}</center></td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a title="Print this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div id="closed_2" class="tabcontent">
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar7">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_inact as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td><center>{{$closed->destination}}</center></td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a title="Print this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@elseif((Auth::user()->role!='DVC Administrator')&&($category=='All')||(Auth::user()->role!='Accountant')&&($category=='All'))
<div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'active')" id="defaultOpen"><strong>Active</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'inactive')"><strong>Inactive</strong></button>
  </div>
  <div id="active" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
    <br>
    @if(Auth::user()->role=='System Administrator')
 <a class="btn btn-success" href="{{ route('carRentalForm') }}" role="button" style="
    padding: 10px; margin-bottom: 5px; margin-top: 4px;">New Contract
  </a>
  @endif
   <h4 style="text-align: center"><strong>Active Car Rental Contracts</strong></h4>
   <hr>
  <table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 17%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 13%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_act as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</td>
         <td><center>{{$closed->destination}}</center></td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  <div id="inactive" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
    <br>
    @if(Auth::user()->role=='System Administrator')
 <a class="btn btn-success" href="{{ route('carRentalForm') }}" role="button" style="
    padding: 10px; margin-bottom: 5px; margin-top: 4px;">New Contract
  </a>
  @endif
   <h4 style="text-align: center"><strong>Inactive Car Rental Contracts</strong></h4>
   <hr>
    <table class="hover table table-striped table-bordered" id="myTablecar2">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Form Id</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 14%"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 17%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 13%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_inact as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->designation}} {{$closed->fullName}}</td>
        <td><center>{{$closed->faculty}}</center></td>
        <td>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</td>
         <td><center>{{$closed->destination}}</center></td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View Invoice Details" data-toggle="modal" data-target="#carinvoice{{$closed->id}}" role="button" aria-pressed="true" id="{{$closed->id}}"><i class="fa fa-eye" style="font-size:20px; color:#3490dc;"></i></a>
           <div class="modal fade" id="carinvoice{{$closed->id}}" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Invoice Details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <table style="width: 100%;">
                                   <tr>
                                          <td>Client Name:</td>
                                          <td>{{$closed->debtor_name}}</td>
                                      </tr>

                                      <tr>
                                          <td>Start Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_start_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>End Date:</td>
                                          <td>{{date("d/m/Y",strtotime($closed->invoicing_period_end_date))}}</td>
                                      </tr>

                                      <tr>
                                          <td>Amount:</td>
                                          <td>{{$closed->currency_invoice}} {{number_format($closed->amount_to_be_paid)}}</td>
                                      </tr>

                                      <tr>
                                          <td>Payment Status:</td>
                                          <td>{{$closed->payment_status}}</td>
                                      </tr>
                  </table>
                  <br>
                  <div><center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center></div>
                 </div>
               </div>
             </div>
           </div>
          <a href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>

@endif

  </div>
@endif










    </div>
  </div>
</div>
</div>
@endsection

@section('pagescript')
<script type="text/javascript">
   $(document).ready(function(){
    var cid = location.search.split('cid=')[1];
    if(cid==31){
      <?php $CPTU=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category'); ?>
      if($CPTU=='CPTU only'|| $CPTU=='All'){
    var tablink = document.getElementById("carss");
       tablink.click();
     }
     }
     });
</script>
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

            $(".insurance_identity").removeClass("defaultContract");
            $(".car_identity").removeClass("defaultContract");
            $('.space_identity').addClass('defaultContract');


        }else if(insurance_x==1){
            $(".space_identity").removeClass("defaultContract");
            $(".car_identity").removeClass("defaultContract");
            $('.insurance_identity').addClass('defaultContract');

        }else if(car_x==1){
            $(".space_identity").removeClass("defaultContract");
            $(".insurance_identity").removeClass("defaultContract");
            $('.car_identity').addClass('defaultContract');

        }else{

        }


        document.querySelector('.defaultContract').click();

    };
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

        var table3 = $('#myTablecar').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

         var table4 = $('#myTablecar2').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

          var table5 = $('#myTablecar3').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

          var table6 = $('#myTablecar4').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

          var table7 = $('#myTablecar5').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

           var table8 = $('#myTablecar6').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );

            var table9 = $('#myTablecar7').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>'
        } );
    </script>
@endsection
