@extends('layouts.app')
@section('style')
<style type="text/css">
  div.dataTables_filter{
    padding-bottom:20px;
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
    border-bottom: 2px solid #505559;
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

   sub {
   font-size: .50em;
    line-height: 0.5em;
    vertical-align: baseline;
    position: relative;
    bottom: 0px;
    float: right;
    color: blue;
}


  .dataTables_wrapper .dataTables_processing {
      position: relative;
      top: 50%;
      left: 50%;
      width: 200px;
      height: auto;
      margin-bottom: 20px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-left: -100px;
      margin-top: -26px;
      text-align: center;
      padding: 1em 0;
      z-index: 1;
  }





</style>

@endsection

@section('content')
<div class="wrapper">
  <div id="coverScreen"  class="pageLoad">
  </div>
<div class="sidebar">
        <ul style="list-style-type:none;">


            <?php

            $privileges=DB::table('users')->join('general_settings','users.role','=','general_settings.user_roles')->where('users.role',Auth::user()->role)->value('privileges');
            ?>


            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>

            @if($category=='All')
           <li><a href="/"><i class="fas fa-home"></i>Home</a></li>
          @elseif($category=='Insurance only')
          <li><a href="{{ route('home2') }}"><i class="fas fa-home"></i>Home</a></li>
          @elseif($category=='Real Estate only')
          <li><a href="{{ route('home4') }}"><i class="fas fa-home"></i>Home</a></li>
          @elseif($category=='Research Flats only')
          <li><a href="{{ route('home6') }}"><i class="fas fa-home active"></i>Home</a></li>
           @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home3') }}"><i class="fas fa-home"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role=='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home5') }}"><i class="fas fa-home"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role=='Accountant-Cost Centre'))
            <li><a href="{{ route('home5') }}"><i class="fas fa-home"></i>Home</a></li>
          @endif

            @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

                <li><a href="/businesses"><i class="fa fa-building" aria-hidden="true"></i> Businesses</a></li>
                @else
                @endif
    @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
    @endif
            <li class="active_nav_item"><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
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



            @if ($message = Session::get('errors'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <p>{{$message}}</p>
          </div>
        @endif

      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p>{{$message}}</p>
      </div>
    @endif

           <br>



            <div class="tab">




                    @if ($category=='Real Estate only' OR $category=='All')

                        <button class="tablinksOuter  space_identity" onclick="openContractType(event, 'space_contracts')"  ><strong>Real Estate </strong></button>

                    @else
                    @endif


                    @if ($category=='Research Flats only' OR $category=='All')

                      <button class="tablinksOuter  research_flats_identity" onclick="openContractType(event, 'research_flats_contracts')"  ><strong>Research Flats</strong></button>

                    @else
                    @endif




                        @if($category=='Insurance only' OR $category=='All')

                            <button class="tablinksOuter insurance_identity" onclick="openContractType(event, 'insurance_contracts')"><strong>Insurance </strong></button>


                        @else
                        @endif



                        @if ($category=='CPTU only' OR $category=='All')

                            <button class="tablinksOuter car_identity" onclick="openContractType(event, 'car_contracts')" id="carss"><strong>Car Rental </strong></button>

                        @else
                        @endif




            </div>



          @if(Auth::user()->role=='Director DPDI' || Auth::user()->role=='DPDI Planner')

            <div id="space_contracts" class="tabcontentOuter">
                <br>



                <br>
                <div class="tab" style="">

                    <button class="tablinks_deep_inner_space " onclick="openDeepInnerSpace(event, 'space_contract_inbox')" id="defaultOpenDeepInnerSpace"><strong>Inbox</strong></button>
                    <button class="tablinks_deep_inner_space " onclick="openDeepInnerSpace(event, 'space_contract_outbox')"><strong>Outbox</strong></button>
                    <button class="tablinks_deep_inner_space " onclick="openDeepInnerSpace(event, 'space_complete_contracts')"><strong>Contracts</strong></button>
                </div>


                @if(Auth::user()->role=='Director DPDI')

                <div id="space_contract_inbox" style="border-bottom-left-radius: 50px 20px;   border: 1px solid #ccc; padding: 1%;" class="tabcontent_deep_inner_space">
                    <?php
                    $i=1;
                    ?>
@if($space_contract_inbox!='')
                    <table class="table">
                        <thead >
                        <tr>
                            <th scope="col" ><center>S/N</center></th>
                            <th scope="col" >Client Name</th>
                            <th scope="col" ><center>Contract Number</center></th>
                            <th scope="col" ><center>Real Estate Number</center></th>
                            <th scope="col"  ><center>Amount(Academic season)</center></th>
                            <th scope="col"  ><center>Amount(Vacation season)</center></th>
                            <th scope="col"  ><center>Start Date</center></th>
                            <th scope="col"  ><center>End Date</center></th>

                            <th scope="col"  ><center>Description</center></th>
                            <th scope="col"  ><center>Action</center></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($space_contract_inbox as $var)
                            <tr>

                                <td> <center>{{$i}}</center>  </td>

                                <td>{{$var->full_name}}</td>
                                <td>{{$var->contract_id}}</td>
                                <td>{{$var->space_id_contract}}</td>
                                <td>@if($var->has_clients=="1")
                                    @else
                                        @if($var->academic_dependence=='Yes')
                                            {{number_format($var->academic_season)}} {{$var->currency}}
                                        @else
                                            {{number_format($var->amount)}} {{$var->currency}}
                                        @endif

                                    @endif

                                </td>
                                <td>
                                    @if($var->has_clients=="1")
                                    @else

                                        @if($var->academic_dependence=='Yes')
                                            @if($var->vacation_season=="0")
                                                {{number_format($var->academic_season)}} {{$var->currency}}
                                            @else
                                                {{number_format($var->vacation_season)}} {{$var->currency}}
                                            @endif
                                        @else
                                            {{number_format($var->amount)}} {{$var->currency}}
                                        @endif

                                    @endif
                                </td>


                                <td><center>{{date('d/m/Y',strtotime($var->start_date))}}</center></td>
                                <td><center>{{date('d/m/Y',strtotime($var->end_date))}}</center></td>

                                @if($var->edit_status=='1')
                                    <td><center>
                                    <div ><span style="cursor: pointer;  background-color: orange; color:white !important;  padding:3px;   text-align: center;"><a title="View Reason" style="color:white !important; display:inline-block;"  class="" data-toggle="modal"  data-target="#reason{{$var->contract_id}}" style="cursor: pointer;" aria-pressed="true">View Reason</a></span> </div>

                                    <div class="modal fade" id="reason{{$var->contract_id}}" role="dialog">

                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <b><h5 class="modal-title">Reason(s) for Editing the Contract</h5></b>

                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <form method="post" action=""   >
                                                        {{csrf_field()}}


                                                        <div class="form-row">


                                                                <div class="form-group col-12">
                                                                    <div class="form-wrapper">
                                                                        <label for="remarks" style="color: red;"></label>
                                                                        <textarea type="text"  name="reason" class="form-control" readonly="">{{$var->reason_for_forwarding}}</textarea>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <br>



                                                        </div>


                                                        <div align="right">

                                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        </center>  </td>

                                @else
                                    <td><center> <div ><span style="background-color: #0aac19; color:white;  padding:3px;   text-align: center;">{{$var->reason_for_forwarding}}</span> </div></center>  </td>
                                    @endif

                                <td><center>








                                        <a title="Review" href="/space_contract_approval/{{$var->contract_id}}"> <i class="fas fa-reply"></i></a>







                                    </center></td>



                            </tr>
                            <?php
                            $i=$i+1;
                            ?>
                        @endforeach





                        </tbody>
                    </table>

                    @else
                        <p class="mt-4" style="text-align:center;">No records found</p>
                    @endif


                </div>


                @else

                    <div id="space_contract_inbox" style="border-bottom-left-radius: 50px 20px;   border: 1px solid #ccc; padding: 1%;" class="tabcontent_deep_inner_space">
                        <?php
                        $i=1;
                        ?>
                    @if($space_contract_inbox!='')
                        <table class="table">
                            <thead >
                            <tr>
                                <th scope="col" ><center>S/N</center></th>
                                <th scope="col" >Client Name</th>
                                <th scope="col" ><center>Contract Number</center></th>
                                <th scope="col" ><center>Real Estate Number</center></th>
                                <th scope="col"  ><center>Amount(Academic season)</center></th>
                                <th scope="col"  ><center>Amount(Vacation season)</center></th>
                                <th scope="col"  ><center>Start Date</center></th>
                                <th scope="col"  ><center>End Date</center></th>

                                <th scope="col"  ><center>Status</center></th>
                                <th scope="col"  ><center>Reason</center></th>
                                <th scope="col"  ><center>Action</center></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($space_contract_inbox as $var)
                                <tr>

                                    <td> <center>{{$i}}</center>  </td>

                                    <td>{{$var->full_name}}</td>
                                    <td>{{$var->contract_id}}</td>
                                    <td>{{$var->space_id_contract}}</td>
                                    <td>@if($var->has_clients=="1")
                                        @else
                                            @if($var->academic_dependence=='Yes')
                                                {{number_format($var->academic_season)}} {{$var->currency}}
                                            @else
                                                {{number_format($var->amount)}} {{$var->currency}}
                                            @endif

                                        @endif

                                    </td>
                                    <td>
                                        @if($var->has_clients=="1")
                                        @else

                                            @if($var->academic_dependence=='Yes')
                                                @if($var->vacation_season=="0")
                                                    {{number_format($var->academic_season)}} {{$var->currency}}
                                                @else
                                                    {{number_format($var->vacation_season)}} {{$var->currency}}
                                                @endif
                                            @else
                                                {{number_format($var->amount)}} {{$var->currency}}
                                            @endif

                                        @endif
                                    </td>


                                    <td><center>{{date('d/m/Y',strtotime($var->start_date))}}</center></td>
                                    <td><center>{{date('d/m/Y',strtotime($var->end_date))}}</center></td>
                                    <td><center>


                                            <div ><span style="background-color: red; color:white;  padding:3px;   text-align: center;">DECLINED</span> </div>


                                        </center></td>



                                    <td><center>


                                        <a title="View Reason" style="cursor: pointer;"  class="" data-toggle="modal" data-target="#reason{{$var->contract_id}}" style="cursor: pointer;" aria-pressed="true">View Reason</a>

                                        <div class="modal fade" id="reason{{$var->contract_id}}" role="dialog">

                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <b><h5 class="modal-title">Reason</h5></b>

                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form method="post" action=""   >
                                                            {{csrf_field()}}


                                                            <div class="form-row">


                                                                <div class="form-group col-12">
                                                                    <div class="form-wrapper">
                                                                        <label for="remarks" style="color: red;"></label>
                                                                        <textarea type="text"  name="reason" class="form-control" readonly="">{{$var->approval_remarks}}</textarea>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <br>



                                                            </div>


                                                            <div align="right">

                                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        </center></td>

                                    <td><center>







@if($var->has_clients=='1')
                                                <a title="Review" href="/edit_space_contract_parent_client/{{$var->contract_id}}"> <i class="fas fa-reply"></i></a>
    @else
                                            <a title="Review" href="/edit_space_contract/{{$var->contract_id}}"> <i class="fas fa-reply"></i></a>
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
                            <p class="mt-4" style="text-align:center;">No records found</p>
                        @endif

                    </div>

                @endif




                <div id="space_contract_outbox" style="border-bottom-left-radius: 50px 20px;   border: 1px solid #ccc; padding: 1%;" class="tabcontent_deep_inner_space">

                    <?php
                    $i=1;
                    ?>
                    @if($space_contract_outbox!='')

                    <table class="table ">
                        <thead >
                        <tr>
                            <th scope="col" ><center>S/N</center></th>
                            <th scope="col" >Client Name</th>
                            <th scope="col" ><center>Contract Number</center></th>
                            <th scope="col" ><center>Real Estate Number</center></th>
                            <th scope="col"  ><center>Amount(Academic season)</center></th>
                            <th scope="col"  ><center>Amount(Vacation season)</center></th>
                            <th scope="col"  ><center>Start Date</center></th>
                            <th scope="col"  ><center>End Date</center></th>

                            <th scope="col"  ><center>Stage</center></th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($space_contract_outbox as $var)
                            <tr>

                                <td> <center>{{$i}}</center>  </td>

                                <td>{{$var->full_name}}</td>
                                <td>{{$var->contract_id}}</td>
                                <td>{{$var->space_id_contract}}</td>
                                <td>@if($var->has_clients=="1")
                                    @else
                                        @if($var->academic_dependence=='Yes')
                                            {{number_format($var->academic_season)}} {{$var->currency}}
                                        @else
                                            {{number_format($var->amount)}} {{$var->currency}}
                                        @endif

                                    @endif

                                </td>
                                <td>
                                    @if($var->has_clients=="1")
                                    @else

                                        @if($var->academic_dependence=='Yes')
                                            @if($var->vacation_season=="0")
                                                {{number_format($var->academic_season)}} {{$var->currency}}
                                            @else
                                                {{number_format($var->vacation_season)}} {{$var->currency}}
                                            @endif
                                        @else
                                            {{number_format($var->amount)}} {{$var->currency}}
                                        @endif

                                    @endif
                                </td>


                                <td><center>{{date('d/m/Y',strtotime($var->start_date))}}</center></td>
                                <td><center>{{date('d/m/Y',strtotime($var->end_date))}}</center></td>

                                @if(Auth::user()->role=='Director DPDI')
                                <td><center>Planning Officer</center></td>
                                @else
                                    <td><center>Director DPDI</center></td>
                                @endif


                            </tr>
                            <?php
                            $i=$i+1;
                            ?>
                        @endforeach





                        </tbody>
                    </table>
                    @else
                        <p class="mt-4" style="text-align:center;">No records found</p>
                    @endif

                </div>




                <div id="space_complete_contracts" style="border-bottom-left-radius: 50px 20px;    border: 1px solid #ccc; padding: 1%;" class="tabcontent_deep_inner_space">

<br>

                    @if($privileges=='Read only')
                    @else

                        @if(Auth::user()->role=='DPDI Planner')
                        <a href="/space_contract_form" class="btn button_color active" style=" color: white;   background-color: #38c172;
    padding: 10px;
    margin-left: 2px;
    margin-bottom: 15px;
    margin-top: 4px;" role="button" aria-pressed="true" title="Add new Real Estate Contract">Add New Contract</a>
                        @else
                            @endif

                        @endif

{{--                    <h3 style="text-align: center"><strong>Real Estate Contracts</strong></h3>--}}

{{--                    <hr>--}}
                    <?php
                    $i=1;
                    ?>


                    <table style="width: 100%;" class="hover table table-striped table-bordered" id="myTablea">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="color:#fff;"><center>S/N</center></th>
                            <th scope="col" style="color:#fff;">Client Name</th>
                            <th scope="col" style="color:#fff;"><center>Real Estate Number</center></th>
                            <th scope="col" style="color:#fff;" ><center>Amount(Academic season)</center></th>
                            <th scope="col" style="color:#fff;" ><center>Amount(Vacation season)</center></th>

                            <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
                            <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                            <th scope="col"  style="color:#fff;"><center>Contract Creation Date</center></th>

                            <th scope="col"  style="color:#fff;"><center>Status</center></th>
                            <th scope="col"  style="color:#fff;"><center>Action</center></th>
                        </tr>
                        </thead>
                        <tbody>



                        </tbody>
                    </table>





                </div>




            </div>
          @else

              <div id="space_contracts" style="border-bottom-left-radius: 50px 20px;   border: 1px solid #ccc; padding: 1%;" class="tabcontentOuter">
                  <br>



                  @if($privileges=='Read only')
                  @else

                      <div style="float:left;">
                          @if(Auth::user()->role=='DPDI Planner')
                      <a href="/space_contract_form" class="btn button_color active" style=" color: white;   background-color: #38c172;
    padding: 10px;
    margin-left: 2px;
    margin-bottom: 15px;
    margin-top: 4px;" role="button" aria-pressed="true" title="Add new Real Estate Contract">Add New Contract</a>
                          @else
                          @endif

                      </div>

                        @admin
                          <div style="float:right;">
                              <div style="float:left;"> <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#import_data_space" title="Import Data" role="button" aria-pressed="true">Import Data</a></div>

                              <div style="float:right;"><a href="/get_space_contracts_format" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: 5px;  margin-bottom: 5px; margin-top: 4px;"   title="Download Sample">Download Sample</a> </div>
                              <div style="clear: both;"></div>
                          </div>
                        @endadmin

                          <div style="clear: both;"></div>


                      <div class="modal fade" id="import_data_space" role="dialog">

                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <b><h5 class="modal-title">Importing Data</h5></b>

                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>

                                  <div class="modal-body">

                                      <form method="post" enctype="multipart/form-data" action="/import_space_contracts"   >
                                          {{csrf_field()}}

                                          <div class="form-row">


                                              <div  class=" col-md-12 ">
                                                  <div class="">
                                                      <label for="">Select File for Upload (.xls, .xlsx) <span style="color: red;">*</span></label>
                                                      <input type="file" class="" id="" name="import_data" value="" placeholder="" required accept=".xls,.xlsx" autocomplete="off">
                                                      <div class="mt-2"><span style="font-weight: bold;">N.B </span><span class="pl-1" style="color:red;"> The header row as given in the sample must be included as the first row when uploading. Furthermore, the acceptable values as indicated in the header row are case sensitive for instance if acceptable value is "Individual" the value to be inserted should be "Individual" and not "individual" </span></div>
                                                  </div>
                                              </div>
                                              <br>


                                          </div>


                                          <div align="right">
                                              <button  class="btn btn-primary" type="submit">Import</button>
                                              <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                          </div>
                                      </form>









                                  </div>
                              </div>
                          </div>


                      </div>


                  @endif

{{--                  <h3 style="text-align: center"><strong>Real Estate Contracts</strong></h3>--}}

{{--                  <hr>--}}
                  <?php
                  $i=1;
                  ?>


                  <table class="hover table table-striped table-bordered" id="myTablea">
                      <thead class="thead-dark">
                      <tr>
                          <th scope="col" style="color:#fff;"><center>S/N</center></th>
                          <th scope="col" style="color:#fff;">Client Name</th>
                          <th scope="col" style="color:#fff;">Contract Number</th>
                          <th scope="col" style="color:#fff;"><center>Real Estate Number</center></th>
                          <th scope="col"  style="color:#fff;"><center>Start Date</center></th>
                          <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                          <th scope="col" style="color:#fff;" ><center>Amount(Academic season)</center></th>
                          <th scope="col" style="color:#fff;" ><center>Amount(Vacation season)</center></th>




                          <th scope="col"  style="color:#fff;"><center>Status</center></th>
                          <th scope="col"  style="color:#fff;"><center>Action</center></th>
                      </tr>
                      </thead>
                      <tbody>



                      </tbody>
                  </table>





              </div>


          @endif








             <div id="research_flats_contracts" style="border-bottom-left-radius: 50px 20px;   border: 1px solid #ccc; padding: 1%;" class="tabcontentOuter">
              <?php $r =1; ?>
                <br>
                @if($privileges=='Read only')
                @else


<div style="float:left;">
    <a href="{{ route('contractflat') }}" title="Add new contract"  class="btn button_color active" style="  color: white;   background-color: #38c172;
                    padding: 10px;
                    margin-left: 2px;
                    margin-bottom: 15px;
                    margin-top: 4px;" role="button" aria-pressed="true">Add New Contract</a>

</div>
                      @admin
                      <div style="float:right;">
                          <div style="float:left;"> <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#import_data_research" title="Import Data" role="button" aria-pressed="true">Import Data</a></div>
                          <div class="modal fade" id="import_data_research" role="dialog">

                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <b><h5 class="modal-title">Importing Data</h5></b>

                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <div class="modal-body">

                                          <form method="post" enctype="multipart/form-data" action="/import_research_contracts"   >
                                              {{csrf_field()}}

                                              <div class="form-row">


                                                  <div  class=" col-md-12 ">
                                                      <div class="">
                                                          <label for="">Select File for Upload (.xls, .xlsx) <span style="color: red;">*</span></label>
                                                          <input type="file" class="" id="" name="import_data"  placeholder="" required  accept=".xls,.xlsx" autocomplete="off">
                                                          <div class="mt-2"><span style="font-weight: bold;">N.B </span><span class="pl-1" style="color:red;"> The header row as given in the sample must be included as the first row when uploading. Furthermore, the acceptable values as indicated in the header row are case sensitive for instance if acceptable value is "Individual" the value to be inserted should be "Individual" and not "individual" </span></div>
                                                      </div>
                                                  </div>
                                                  <br>


                                              </div>


                                              <div align="right">
                                                  <button  class="btn btn-primary" type="submit">Import</button>
                                                  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                              </div>
                                          </form>









                                      </div>
                                  </div>
                              </div>


                          </div>
                          <div style="float:right;"><a href="/get_research_contracts_format" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: 5px;  margin-bottom: 5px; margin-top: 4px;"   title="Download Sample">Download Sample</a> </div>
                          <div style="clear: both;"></div>
                      </div>
                      @endadmin
                  <div style="clear: both;"></div>

                  @endif

                <div class="">
{{--                    <h3 style="text-align: center"><strong>Research Flats Contracts</strong></h3>--}}
{{--                    <hr>--}}

                    <table class="hover table table-striped table-bordered" id="myTableResearch">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="color:#fff;"><center>S/N</center></th>
                            <th scope="col" style="color:#fff;"><center>Client Name</center></th>
                            <th scope="col" style="color:#fff;"><center>Contract Number</center></th>
                            <th scope="col"  style="color:#fff;"><center>Room No</center></th>
                            <th scope="col" style="color:#fff;"><center>Host Name</center></th>
                            <th scope="col" style="color:#fff;"><center>Arrival Date</center></th>
                            <th scope="col" style="color:#fff;"><center>Departure Date</center></th>

                            <th scope="col"  style="color:#fff;"><center>Total Amount (USD)</center></th>
                            <th scope="col"  style="color:#fff;"><center>Toatal Amount (TZS)</center></th>
                            <th scope="col"  style="color:#fff;"><center>Action</center></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($research_contracts as $var)
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

                              <td style="text-align: right;">{{number_format($var->total_usd)}}</td>
                              <td style="text-align: right;">{{number_format($var->total_tzs)}}</td>
                              <td>
                                  <center>
                                <a title="Edit this contract" href="{{ route('editResearchForm', $var->id) }}"><i class="fa fa-edit" aria-hidden="true" style="font-size:20px; color:green;"></i></a>
{{--                                      <a href="{{ route('renewResearchForm', $var->id)}}" style="display:inline-block;" title="Click to renew this contract"><center><i class="fa fa-refresh" style="font-size:20px;"></i></center></a>--}}
                                <a title="Download this contract" href="{{ route('printResearchForm') }}?id={{$var->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center>
                              </td>
                            </tr>
                            <?php $r = $r +1; ?>
                        @endforeach
                      </tbody>
                    </table>
                  </div>

             </div>



            <div id="insurance_contracts" style="border-bottom-left-radius: 50px 20px;   border: 1px solid #ccc; padding: 1%;" class="tabcontentOuter">
                <br>


                @if($privileges=='Read only')
                @else

<div style="float:left;"><a href="/insurance_contract_form" title="Add new Insurance contract"  class="btn button_color active" style="  color: white;   background-color: #38c172;
    padding: 10px;
    margin-left: 2px;
    margin-bottom: 15px;
    margin-top: 4px;" role="button" aria-pressed="true">Add New Contract</a>
</div>

                    @admin
                    <div style="float:right;">
                        <div style="float:left;"> <a data-toggle="modal" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: -2px;  margin-bottom: 5px; margin-top: 4px;"  data-target="#import_data_insurance" title="Import Data" role="button" aria-pressed="true">Import Data</a></div>
                        <div class="modal fade" id="import_data_insurance" role="dialog">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b><h5 class="modal-title">Importing Data</h5></b>

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <form method="post" enctype="multipart/form-data" action="/import_insurance_contracts"   >
                                            {{csrf_field()}}

                                            <div class="form-row">


                                                <div  class=" col-md-12 ">
                                                    <div class="">
                                                        <label for="">Select File for Upload (.xls, .xlsx) <span style="color: red;">*</span></label>
                                                        <input type="file" class="" id="" name="import_data"  placeholder="" required  accept=".xls,.xlsx" autocomplete="off">

                                                        <div class="mt-2"><span style="font-weight: bold;">N.B </span><span class="pl-1" style="color:red;"> The header row as given in the sample must be included as the first row when uploading. Furthermore, the acceptable values as indicated in the header row are case sensitive for instance if acceptable value is "Individual" the value to be inserted should be "Individual" and not "individual" </span></div>
                                                    </div>

                                                </div>
                                                <br>


                                            </div>


                                            <div align="right">
                                                <button  class="btn btn-primary" type="submit">Import</button>
                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>









                                    </div>
                                </div>
                            </div>


                        </div>
                        <div style="float:right;"><a href="/get_insurance_contracts_format" class="btn button_color active" style="background-color: #38c172; padding: 7px; color:white; margin-left: 5px;  margin-bottom: 5px; margin-top: 4px;"   title="Download Sample">Download Sample</a> </div>
                        <div style="clear: both;"></div>
                    </div>
                    @endadmin
                    <div style="clear: both;"></div>

                @endif

                <div class="">
{{--                    <h3 style="text-align: center"><strong>Insurance Contracts</strong></h3>--}}
{{--                    <hr>--}}


                    <table class="hover table table-striped table-bordered" style="width: 100% !important;" id="myTableInsurance">
                        <thead class="thead-dark">
                        <tr>

                            <th scope="col" style="color:#fff;"><center>S/N</center></th>
                            <th scope="col" style="color:#fff;"><center>Client Name</center></th>
                            <th scope="col" style="color:#fff;"><center>Contract Number</center></th>

                            <th scope="col" style="color:#fff;"><center>Class</center></th>
                            <th scope="col" style="color:#fff;"><center>Principal</center></th>

                            <th scope="col"  style="color:#fff;"><center>Commission Date</center></th>
                            <th scope="col"  style="color:#fff;"><center>End Date</center></th>
                            <th scope="col"  style="color:#fff;"><center>Premium</center></th>

                            <th scope="col"  style="color:#fff;"><center>Status</center></th>
                            <th scope="col"  style="color:#fff;"><center>Action</center></th>

                        </tr>
                        </thead>
                        <tbody>




                        </tbody>
                    </table>

                </div>



            </div>


 @if ($category=='CPTU only' OR $category=='All')

            <div id="car_contracts"  class="tabcontentOuter">

                {{-- <h4 style="text-align: center">Car Rental Contracts</h4> --}}
{{--                <br>--}}
                @if(Auth::user()->role=='Transport Officer-CPTU')
  <a class="btn btn-success" href="{{ route('carRentalForm') }}" role="button" style="
    padding: 10px; margin-bottom: 5px; margin-top: 4px;">Add New Contract
  </a>
<br>
<br>

  <div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
            {{-- <button class="tablinks" onclick="openContracts(event, 'closed')"><strong>Active Contracts</strong></button> --}}
            <button class="tablinks" onclick="openContracts(event, 'closed_2')"><strong>Contracts</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'log_sheet')"><strong>Log Sheet</strong></button>
        </div>
<div id="inbox" class="tabcontent" style="border-bottom-left-radius: 50px 20px; ">
  <br>
  @if(count($inbox)>0)
<table>
    <thead>
      <th style="width: 16%"><center>Contract Number</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Destination</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
 {{--        @if($inbox->start_date< date('Y-m-d'))
        <td>
          <a data-toggle="modal" data-target="#viewcar{{$inbox->id}}" role="button" aria-pressed="true" class="link_style" style="color: blue;"><center>{{$inbox->id}}</center></a>

          <div class="modal fade" id="viewcar{{$inbox->id}}" role="dialog">

            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">
                   <p style="text-align: left; font-size: 16px;">This contract is no longer valid since the start date of the trip has passed.</p>

                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>

                </div>
              </div>
            </div>
          </div>
          </td>
        @else --}}
          <td><center><a href="{{ route('carRentalFormE',$inbox->id) }}">{{$inbox->id}}</a></center></td>


       {{--  @endif --}}


        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($inbox->start_date))}} - {{date("d/m/Y",strtotime($inbox->end_date))}}</center></td>
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
      <th style="width: 14%"><center>Contract Number</center></th>
      <th style="width: 14%"><center>Initiated By</center></th>
      <th style="width: 14%"><center>Client Name</center></th>
      <th style="width: 14%"><center>Department/Faculty/unit</center></th>
      <th style="width: 15%"><center>Trip Date</center></th>
      <th style="width: 14%"><center>Destination</center></th>
      <th style="width: 14%"><center>Form Status</center></th>
      <th style="width: 14%"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($outbox as $outbox)
      <tr>
        <td><center>{{$outbox->id}}</center></td>
        <td><center>{{$outbox->form_initiator}}</center></td>
        <td><center>{{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($outbox->start_date))}} - {{date("d/m/Y",strtotime($outbox->end_date))}}</center></td>
         <td><center>{{$outbox->destination}}</center></td>
        <td><center>{{$outbox->form_status}} Stage</center></td>
         @if($outbox->start_date < date('Y-m-d'))
          <td>
             <a title="Delete this form" data-toggle="modal" data-target="#delete{{$outbox->id}}" role="button" aria-pressed="true" style="color: blue;" class="link_style"><center><i class="fa fa-trash" aria-hidden="true" style="font-size:18px; color:red; cursor: pointer;"></i></center></a>

        <div class="modal fade" id="delete{{$outbox->id}}" role="dialog">

          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">
                   <p style="text-align: left; font-size: 16px;">Are you sure you want to delete this form?</p>
                    <br>
                  <div align="right">
                    <a href="{{ route('deletecontract',$outbox->id) }}" class="btn btn-primary">Proceed</a>
                    <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                  </div>

               </div>
              </div>
            </div>
          </div>
          </td>
        @else
          <td><center>N/A</center></td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif

</div>
<div id="closed" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
  @if(count($closed_act)!=0)
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>

          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a>

         <a title="Terminate this contract" data-toggle="modal" data-target="#terminate{{$closed->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>

        <div class="modal fade" id="terminate{{$closed->id}}" role="dialog">

          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <b><h5 class="modal-title" style="color: red;"><b>Terminating Contract</b></h5></b>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">
                   <p style="text-align: left; font-size: 16px;">You are about to terminate <strong>"{{$closed->fullName}}"</strong> contract. Provide reason for termination to proceed.</p>

                    <form method="get" action="{{ route('terminateCarRental',$closed->id) }}" >
                        {{csrf_field()}}

                          <div class="form-group">
                              <div class="form-wrapper">
                                  <label for=""><strong>Reason:<span style="color: red;">*</span></strong></label>
                                    <textarea required name="reason_for_termination" class="form-control"></textarea>

                              </div>
                          </div>
                            <br>

                            <div align="right">
                              <button class="btn btn-primary" type="submit" id="newdata">Terminate</button>
                              <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                            </div>

                    </form>

                </div>
              </div>
            </div>
          </div>
        </center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <br><br>
  <p style="font-size: 18px;">No record found.</p>
  @endif
</div>
<div id="closed_2" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
  @if(count($closed_inact)!=0)
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar3">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td>{{$closed->destination}}</td>
        <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>

          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <br><br>
  <p style="font-size: 18px;">No record found.</p>
  @endif
</div>

<div id="log_sheet" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
  <?php $logsheets = DB::table('log_sheets')->select('contract_id')->distinct('contract_id')->orderBy('id','dsc')->get();
  $d = 1;
  ?>
  <br>
       <a title="Add New Log Sheet" class="btn btn-success" role="button" data-toggle="modal" data-target="#new_log" role="button" aria-pressed="true" style="color: white;">Add New Log Sheet</a>

<div class="modal fade" id="new_log" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <b><h5 class="modal-title">Fill the Contract Number to continue</h5></b>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

           <div class="modal-body">
            <form method="post" action="{{ route('logsheetindex') }}">
              {{csrf_field()}}
                  <div class="form-group">
                    <div class="form-wrapper">
                      <label for="hire_rate">Contract Number<span style="color: red;">*</span></label>
                      <input type="text" id="contract_id" name="contract_id" class="form-control" required="" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                    </div>
                </div>

                <div align="right">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>


          </div>
        </div>
      </div>
</div>
  <br><br>
    <table class="hover table table-bordered  table-striped" id="LogTable">
      <thead class="thead-dark">
          <th scope="col" style="color:#fff;"><center>SN</center></th>
          <th scope="col" style="color:#fff;"><center>Contract Number</center></th>
          <th scope="col" style="color:#fff;"><center>Client Name</center></th>
          <th scope="col" style="color:#fff;"><center>Driver Name</center></th>
          <th scope="col" style="color:#fff;"><center>Vehicle Reg No.</center></th>
          <th scope="col" style="color:#fff;"><center>Destination</center></th>
          <th scope="col" style="color:#fff;"><center>Trip Dates</center></th>
          <th scope="col" style="color:#fff;"><center>Action</center></th>
        </thead>
        <tbody>
          @foreach($logsheets as $log)
            <?php $details = DB::table('car_contracts')->select('vehicle_reg_no','driver_name','fullName','faculty','destination','start_date', 'end_date')->where('id',$log->contract_id)->first(); ?>
            <tr>
              <th style="text-align: center;">{{$d}}.</th>
              <td><center>{{$log->contract_id}}</center></td>
              <td>{{$details->fullName}}</td>
              <td>{{$details->driver_name}}</td>
              <td><center>{{$details->vehicle_reg_no}}</center></td>
              <td><center>{{$details->destination}}</center></td>
              <td><center>{{date("d/m/Y",strtotime($details->start_date))}} - {{date("d/m/Y",strtotime($details->end_date))}}</center></td>
              <td><center><a title="View More Details" role="button" href="{{ route('logsheetmore',$log->contract_id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a></center></td>
            </tr>
            <?php $d = $d+1; ?>
          @endforeach
        </tbody>
    </table>
</div>
@elseif(Auth::user()->role=='Vote Holder')
      <div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
            {{-- <button class="tablinks" onclick="openContracts(event, 'closed')"><strong>Active Contract</strong></button> --}}
            <button class="tablinks" onclick="openContracts(event, 'closed_2')"><strong>Contracts</strong></button>
        </div>
<div id="inbox" class="tabcontent">
  <br>
  @if(count($inbox)>0)
<table>
    <thead>
      <th style="width: 16%"><center>Contract Number</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Destination</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
         @if($inbox->start_date< date('Y-m-d'))
        <td>
          <a data-toggle="modal" data-target="#viewcar{{$inbox->id}}" role="button" aria-pressed="true" class="link_style" style="color: blue;"><center>{{$inbox->id}}</center></a>

          <div class="modal fade" id="viewcar{{$inbox->id}}" role="dialog">

            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">
                   <p style="text-align: left; font-size: 16px;">This contract is no longer valid since the start date of the trip has passed.</p>

                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>

                </div>
              </div>
            </div>
          </div>
          </td>
        @else


           <td><center><a href="{{ route('carRentalFormC',$inbox->id) }}">{{$inbox->id}}</a></center></td>
        @endif


        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($inbox->start_date))}} - {{date("d/m/Y",strtotime($inbox->end_date))}}</center></td>
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
      <th style="width: 14%"><center>Contract Number</center></th>
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
        <td><center>{{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($outbox->start_date))}} - {{date("d/m/Y",strtotime($outbox->end_date))}}</center></td>
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
  @if(count($closed_act)!=0)
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>

          <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <br><br>
  <p style="font-size: 18px;">No record found.</p>
  @endif
</div>

<div id="closed_2" class="tabcontent">
   <br>
   @if(count($closed_inact)!=0)
<table class="hover table table-striped table-bordered" id="myTablecar4">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
    <br><br>
    <p style="font-size: 18px;">No record found.</p>
  @endif
</div>
@elseif(Auth::user()->role=='Accountant-Cost Centre')
  <div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
            {{-- <button class="tablinks" onclick="openContracts(event, 'closed')"><strong>Active Contract</strong></button> --}}
            <button class="tablinks" onclick="openContracts(event, 'closed_2')"><strong>Contracts</strong></button>
        </div>
<div id="inbox" class="tabcontent">
  <br>
  @if(count($inbox)>0)
<table>
    <thead>
      <th style="width: 16%"><center>Contract Number</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Destination</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
          @if($inbox->start_date< date('Y-m-d'))
        <td>
          <a data-toggle="modal" data-target="#viewcar{{$inbox->id}}" role="button" aria-pressed="true" class="link_style" style="color: blue;"><center>{{$inbox->id}}</center></a>

          <div class="modal fade" id="viewcar{{$inbox->id}}" role="dialog">

            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">
                   <p style="text-align: left; font-size: 16px;">This contract is no longer valid since the start date of the trip has passed.</p>

                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>

                </div>
              </div>
            </div>
          </div>
          </td>
        @else


            <td><center><a href="{{ route('carRentalFormB',$inbox->id) }}">{{$inbox->id}}</a></center></td>
        @endif

        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($inbox->start_date))}} - {{date("d/m/Y",strtotime($inbox->end_date))}}</center></td>
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
      <th style="width: 14%"><center>Contract Number</center></th>
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
        <td><center>{{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($outbox->start_date))}} - {{date("d/m/Y",strtotime($outbox->end_date))}}</center></td>
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
  @if(count($closed_act)!=0)
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
         <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
    <br><br>
    <p style="font-size: 18px;">No record found.</p>
  @endif
</div>
<div id="closed_2" class="tabcontent">
  @if(count($closed_inact)!=0)
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar5">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
         <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
    <br><br>
    <p style="font-size: 18px;">No record found.</p>
  @endif
</div>
@elseif(Auth::user()->role=='Head of CPTU')
<a class="btn btn-success" href="{{ route('carRentalForm') }}" role="button" style="
    padding: 10px; margin-bottom: 5px; margin-top: 4px;">Add New Contract
  </a>
  <br><br>
  <div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
            {{-- <button class="tablinks" onclick="openContracts(event, 'closed')"><strong>Active Contract</strong></button> --}}
            <button class="tablinks" onclick="openContracts(event, 'closed_2')"><strong>Contracts</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'log_sheet')"><strong>Log Sheet</strong></button>
        </div>
<div id="inbox" class="tabcontent">
  <br>
  @if(count($inbox)>0)
<table>
    <thead>
      <th style="width: 16%"><center>Contract Number</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Destination</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
        @if($inbox->start_date< date('Y-m-d'))
          <td>
          <a data-toggle="modal" data-target="#viewcar{{$inbox->id}}" role="button" aria-pressed="true" class="link_style" style="color: blue;"><center>{{$inbox->id}}</center></a>

          <div class="modal fade" id="viewcar{{$inbox->id}}" role="dialog">

            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">
                   <p style="text-align: left; font-size: 16px;">This contract is no longer valid since the start date of the trip has passed.</p>

                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>

                </div>
              </div>
            </div>
          </div>
          </td>

        @else
          <td><center><a href="{{ route('carRentalFormD',$inbox->id) }}">{{$inbox->id}}</a></center></td>
        @endif

        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($inbox->start_date))}} - {{date("d/m/Y",strtotime($inbox->end_date))}}</center></td>
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
      <th style="width: 14%"><center>Contract Number</center></th>
      <th style="width: 14%"><center>Initiated By</center></th>
      <th style="width: 14%"><center>Client Name</center></th>
      <th style="width: 14%"><center>Department/Faculty/unit</center></th>
      <th style="width: 15%"><center>Trip Date</center></th>
      <th style="width: 14%"><center>Destination</center></th>
      <th style="width: 14%"><center>Form Status</center></th>
      <th style="width: 14%"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($outbox as $outbox)
      <tr>
        <td><center>{{$outbox->id}}</center></td>
        <td><center>{{$outbox->form_initiator}}</center></td>
        <td><center>{{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($outbox->start_date))}} - {{date("d/m/Y",strtotime($outbox->end_date))}}</center></td>
         <td><center>{{$outbox->destination}}</center></td>
        <td><center>{{$outbox->form_status}} Stage</center></td>
       @if($outbox->start_date < date('Y-m-d'))
          <td>
             <a title="Delete this form" data-toggle="modal" data-target="#delete{{$outbox->id}}" role="button" aria-pressed="true" style="color: blue;" class="link_style"><center><i class="fa fa-trash" aria-hidden="true" style="font-size:18px; color:red;"></i></center></a>

        <div class="modal fade" id="delete{{$outbox->id}}" role="dialog">

          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">
                   <p style="text-align: left; font-size: 16px;">Are you sure you want to delete this form?</p>
                    <br>
                  <div align="right">
                    <a href="{{ route('deletecontract',$outbox->id) }}" class="btn btn-primary">Proceed</a>
                    <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                  </div>

               </div>
              </div>
            </div>
          </div>
          </td>
        @else
          <td><center>N/A</center></td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
   @else
  <p style="line-height: 1.5;font-size: 17px;"><i class="fa fa-envelope-o" style="font-size:25px;color:#3490dc;"></i> No new message</p>
  @endif
</div>
<div id="closed" class="tabcontent">
  @if(count($closed_act)!=0)
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
         <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>

          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a>

          <a title="Terminate this contract" data-toggle="modal" data-target="#terminate{{$closed->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>

        <div class="modal fade" id="terminate{{$closed->id}}" role="dialog">

          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <b><h5 class="modal-title" style="color: red;"><b>Terminating Contract</b></h5></b>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">
                   <p style="text-align: left; font-size: 16px;">You are about to terminate <strong>"{{$closed->fullName}}"</strong> contract. Provide reason for termination to proceed.</p>

                    <form method="get" action="{{ route('terminateCarRental',$closed->id) }}" >
                        {{csrf_field()}}

                          <div class="form-group">
                              <div class="form-wrapper">
                                  <label for=""><strong>Reason:<span style="color: red;">*</span></strong></label>
                                    <textarea required name="reason_for_termination" class="form-control"></textarea>

                              </div>
                          </div>
                            <br>

                            <div align="right">
                              <button class="btn btn-primary" type="submit" id="newdata">Terminate</button>
                              <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                            </div>

                    </form>

                </div>
              </div>
            </div>
          </div>
        </center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <br><br>
  <p style="font-size: 18px;">No record found.</p>
  @endif
</div>
<div id="closed_2" class="tabcontent">
  @if(count($closed_inact)!=0)
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar6">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
         <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <br><br>
  <p style="font-size: 18px;">No record found.</p>
  @endif
</div>

<div id="log_sheet" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
  <?php $logsheets = DB::table('log_sheets')->select('contract_id')->distinct('contract_id')->orderBy('id','dsc')->get();
  $d = 1;
  ?>
  <br>
       <a title="Add New Log Sheet" class="btn btn-success" role="button" data-toggle="modal" data-target="#new_log" role="button" aria-pressed="true" style="color: white;">Add New Log Sheet</a>

<div class="modal fade" id="new_log" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <b><h5 class="modal-title">Fill the Contract Number to continue</h5></b>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

           <div class="modal-body">
            <form method="post" action="{{ route('logsheetindex') }}">
              {{csrf_field()}}
                  <div class="form-group">
                    <div class="form-wrapper">
                      <label for="hire_rate">Contract Number<span style="color: red;">*</span></label>
                      <input type="text" id="contract_id" name="contract_id" class="form-control" required="" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                    </div>
                </div>

                <div align="right">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>


          </div>
        </div>
      </div>
</div>
  <br><br>
    <table class="hover table table-bordered  table-striped" id="LogTable">
      <thead class="thead-dark">
          <th scope="col" style="color:#fff;"><center>SN</center></th>
          <th scope="col" style="color:#fff;"><center>Contract Number</center></th>
          <th scope="col" style="color:#fff;"><center>Client Name</center></th>
          <th scope="col" style="color:#fff;"><center>Driver Name</center></th>
          <th scope="col" style="color:#fff;"><center>Vehicle Reg No.</center></th>
          <th scope="col" style="color:#fff;"><center>Destination</center></th>
          <th scope="col" style="color:#fff;"><center>Trip Dates</center></th>
          <th scope="col" style="color:#fff;"><center>Action</center></th>
        </thead>
        <tbody>
          @foreach($logsheets as $log)
            <?php $details = DB::table('car_contracts')->select('vehicle_reg_no','driver_name','fullName','faculty','destination','start_date', 'end_date')->where('id',$log->contract_id)->first(); ?>
            <tr>
              <th style="text-align: center;">{{$d}}.</th>
              <td><center>{{$log->contract_id}}</center></td>
              <td>{{$details->fullName}}</td>
              <td>{{$details->driver_name}}</td>
              <td><center>{{$details->vehicle_reg_no}}</center></td>
              <td><center>{{$details->destination}}</center></td>
              <td><center>{{date("d/m/Y",strtotime($details->start_date))}} - {{date("d/m/Y",strtotime($details->end_date))}}</center></td>
              <td><center><a title="View More Details" role="button" href="{{ route('logsheetmore',$log->contract_id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a></center></td>
            </tr>
            <?php $d = $d+1; ?>
          @endforeach
        </tbody>
    </table>
</div>
@elseif(Auth::user()->role=='DVC Administrator')
  <div class="tab2">
            <button class="tablinks" onclick="openContracts(event, 'inbox')" id="defaultOpen"><strong>Inbox</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'outbox')"><strong>Outbox</strong></button>
            {{-- <button class="tablinks" onclick="openContracts(event, 'closed')"><strong>Active Contract</strong></button> --}}
            <button class="tablinks" onclick="openContracts(event, 'closed_2')"><strong>Contracts</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'log_sheet')"><strong>Log Sheets</strong></button>
    </div>
<div id="inbox" class="tabcontent">
  <br>
  @if(count($inbox)>0)
<table>
    <thead>
      <th style="width: 16%"><center>Contract Number</center></th>
      <th style="width: 16%"><center>Initiated By</center></th>
      <th style="width: 16%"><center>Client Name</center></th>
      <th style="width: 16%"><center>Department/Faculty/unit</center></th>
      <th style="width: 16%"><center>Trip Date</center></th>
      <th style="width: 16%"><center>Destination</center></th>
    </thead>
    <tbody>
      @foreach($inbox as $inbox)
      <tr>
      @if($inbox->start_date< date('Y-m-d'))
        <td>
          <a data-toggle="modal" data-target="#viewcar{{$inbox->id}}" role="button" aria-pressed="true" class="link_style" style="color: blue;"><center>{{$inbox->id}}</center></a>

          <div class="modal fade" id="viewcar{{$inbox->id}}" role="dialog">

            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">
                   <p style="text-align: left; font-size: 16px;">This contract is no longer valid since the start date of the trip has passed.</p>

                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>

                </div>
              </div>
            </div>
          </div>
          </td>
        @else
           <td><center><a href="{{ route('carRentalFormD1',$inbox->id) }}">{{$inbox->id}}</a></center></td>
        @endif
        <td><center>{{$inbox->form_initiator}}</center></td>
        <td><center>{{$inbox->fullName}}</center></td>
        <td><center>{{$inbox->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($inbox->start_date))}} - {{date("d/m/Y",strtotime($inbox->end_date))}}</center></td>
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
      <th style="width: 14%"><center>Contract Number</center></th>
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
        <td><center>{{$outbox->fullName}}</center></td>
        <td><center>{{$outbox->faculty}}</center></td>
        <td><center>{{date("d/m/Y",strtotime($outbox->start_date))}} - {{date("d/m/Y",strtotime($outbox->end_date))}}</center></td>
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
  @if(count($closed_act)!=0)
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <br><br>
  <p style="font-size: 18px;">No record found.</p>
  @endif
</div>
<div id="closed_2" class="tabcontent">
  @if(count($closed_inact)!=0)
   <br>
<table class="hover table table-striped table-bordered" id="myTablecar7">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td><center>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</center></td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <br><br>
  <p style="font-size: 18px;">No record found.</p>
  @endif
</div>

<div id="log_sheet" class="tabcontent" style="border-bottom-left-radius: 50px 20px;">
  <?php $logsheets = DB::table('log_sheets')->select('contract_id')->distinct('contract_id')->orderBy('id','dsc')->get();
  $d = 1;
  ?>
  <br><br>
    <table class="hover table table-bordered  table-striped" id="LogTable">
      <thead class="thead-dark">
          <th scope="col" style="color:#fff;"><center>SN</center></th>
          <th scope="col" style="color:#fff;"><center>Contract Number</center></th>
          <th scope="col" style="color:#fff;"><center>Client Name</center></th>
          <th scope="col" style="color:#fff;"><center>Driver Name</center></th>
          <th scope="col" style="color:#fff;"><center>Vehicle Reg No.</center></th>
          <th scope="col" style="color:#fff;"><center>Destination</center></th>
          <th scope="col" style="color:#fff;"><center>Trip Dates</center></th>
          <th scope="col" style="color:#fff;"><center>Action</center></th>
        </thead>
        <tbody>
          @foreach($logsheets as $log)
            <?php $details = DB::table('car_contracts')->select('vehicle_reg_no','driver_name','fullName','faculty','destination','start_date', 'end_date')->where('id',$log->contract_id)->first(); ?>
            <tr>
              <th style="text-align: center;">{{$d}}.</th>
              <td><center>{{$log->contract_id}}</center></td>
              <td>{{$details->fullName}}</td>
              <td>{{$details->driver_name}}</td>
              <td><center>{{$details->vehicle_reg_no}}</center></td>
              <td><center>{{$details->destination}}</center></td>
              <td><center>{{date("d/m/Y",strtotime($details->start_date))}} - {{date("d/m/Y",strtotime($details->end_date))}}</center></td>
              <td><center><a title="View More Details" role="button" href="{{ route('logsheetmore',$log->contract_id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a></center></td>
            </tr>
            <?php $d = $d+1; ?>
          @endforeach
        </tbody>
    </table>
</div>
@elseif((Auth::user()->role!='DVC Administrator')&&($category=='All')||(Auth::user()->role!='Accountant')&&($category=='All'))

<div class="tab2" style="margin-top: 12px;">
           {{--  <button class="tablinks" onclick="openContracts(event, 'active')" id="defaultOpen"><strong>Active</strong></button> --}}
            <button class="tablinks" onclick="openContracts(event, 'inactive')" id="defaultOpen"><strong>Contracts</strong></button>
            <button class="tablinks" onclick="openContracts(event, 'log_sheet')"><strong>Log Sheets</strong></button>
</div>
  <div id="active" class="tabcontent" style="border-bottom-left-radius: 50px 20px;   border: 1px solid #ccc; padding: 1%;">
    <br>
    @if($privileges=='Read only')
    @else
      <a class="btn btn-success" href="{{ route('carRentalForm') }}" role="button" style="
        padding: 10px; margin-bottom: 5px; margin-top: 4px;">Add New Contract
      </a>
  @endif
{{--   <h4 style="text-align: center"><strong>Active Car Rental Contracts</strong></h4>--}}
{{--   <hr>--}}
@if(count($closed_act)!=0)
  <table class="hover table table-striped table-bordered" id="myTablecar">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
      <th scope="col" style="color:#fff; width: 17%"><center>Trip Date</center></th>
      <th scope="col" style="color:#fff; width: 13%"><center>Destination</center></th>
       <th scope="col" style="color:#fff; width: 16%"><center>Grand Total (TZS)</center></th>
      <th scope="col" style="color:#fff;  width: 8%"><center>Action</center></th>
    </thead>
    <tbody>
      @foreach($closed_act as $closed)
      <tr>
        <th scope="row" class="counterCell text-center">.</th>
        <td><center>{{$closed->id}}</center></td>
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>

          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a>

          @if($privileges=='Read only')
            @else

          <a title="Terminate this contract" data-toggle="modal" data-target="#terminate{{$closed->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>

        <div class="modal fade" id="terminate{{$closed->id}}" role="dialog">

          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                    <b><h5 class="modal-title" style="color: red;"><b>Terminating Contract</b></h5></b>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <div class="modal-body">
                   <p style="text-align: left; font-size: 16px;">You are about to terminate <strong>"{{$closed->fullName}}"</strong> contract. Provide reason for termination to proceed.</p>

                    <form method="get" action="{{ route('terminateCarRental',$closed->id) }}" >
                        {{csrf_field()}}

                          <div class="form-group">
                              <div class="form-wrapper">
                                  <label for=""><strong>Reason:<span style="color: red;">*</span></strong></label>
                                    <textarea required name="reason_for_termination" class="form-control"></textarea>

                              </div>
                          </div>
                            <br>

                            <div align="right">
                              <button class="btn btn-primary" type="submit" id="newdata">Terminate</button>
                              <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                            </div>

                    </form>

                </div>
              </div>
            </div>
          </div>
          @endif
        </center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <br><br>
  <p style="font-size: 18px;">No record found.</p>
  @endif
  </div>
  <div id="inactive" class="tabcontent" style="border-bottom-left-radius: 50px 20px;   border: 1px solid #ccc; padding: 1%;">
    <br>
     @if($privileges=='Read only')
    @else
       <a class="btn btn-success" href="{{ route('carRentalForm') }}" role="button" style="
          padding: 10px; margin-bottom: 5px; margin-top: 4px;">Add New Contract
        </a>
  @endif
{{--   <h4 style="text-align: center"><strong>Car Rental Contracts</strong></h4>--}}
{{--   <hr>--}}
   @if(count($closed_inact)!=0)
    <table class="hover table table-striped table-bordered" id="myTablecar2">
    <thead class="thead-dark">
      <th scope="col" style="color:#fff; width: 5%"><center>S/N</center></th>
      <th scope="col" style="color:#fff; width: 10%"><center>Contract Number</center></th>
      <th scope="col" style="color:#fff; width: 16%"><center>Client Name</center></th>
      <th scope="col" style="color:#fff; width: 250px;"><center>Department/Faculty/unit</center></th>
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
        <td>{{$closed->fullName}}</td>
        <td>{{$closed->faculty}}</td>
        <td>{{date("d/m/Y",strtotime($closed->start_date))}} - {{date("d/m/Y",strtotime($closed->end_date))}}</td>
         <td>{{$closed->destination}}</td>
         <td style="text-align: right;">{{number_format($closed->grand_total)}}</td>
         <td><center>
          <a title="View More Details" role="button" href="{{ route('carcontractviewmore',$closed->id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
          <a title="Download this contract" href="/contracts/car_rental/print?id={{$closed->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"></i></a></center></td>

      </tr>
      @endforeach
    </tbody>
  </table>
  @else
    <br><br>
    <p style="font-size: 18px;">No record found.</p>
  @endif
  </div>

  <div id="log_sheet" class="tabcontent" style="border-bottom-left-radius: 50px 20px;   border: 1px solid #ccc; padding: 1%;">
  <?php $logsheets = DB::table('log_sheets')->select('contract_id')->distinct('contract_id')->orderBy('id','dsc')->get();
  $d = 1;
  ?>
  <br>
    @if($privileges=='Read only')
    @else
         <a title="Add New Log Sheet" class="btn btn-success" role="button" data-toggle="modal" data-target="#new_log" role="button" aria-pressed="true" style="color: white;">Add New Log Sheet</a>

<div class="modal fade" id="new_log" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <b><h5 class="modal-title">Fill the Contract Number to continue</h5></b>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

           <div class="modal-body">
            <form method="post" action="{{ route('logsheetindex') }}">
              {{csrf_field()}}
                  <div class="form-group">
                    <div class="form-wrapper">
                      <label for="hire_rate">Contract Number<span style="color: red;">*</span></label>
                      <input type="text" id="contract_id" name="contract_id" class="form-control" required="" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                    </div>
                </div>

                <div align="right">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>


          </div>
        </div>
      </div>
</div>
    @endif
    <br><br>
    <table class="hover table table-bordered  table-striped" id="LogTable">
      <thead class="thead-dark">
          <th scope="col" style="color:#fff;"><center>SN</center></th>
          <th scope="col" style="color:#fff;"><center>Contract Number</center></th>
          <th scope="col" style="color:#fff;"><center>Client Name</center></th>
          <th scope="col" style="color:#fff;"><center>Driver Name</center></th>
          <th scope="col" style="color:#fff;"><center>Vehicle Reg No.</center></th>
          <th scope="col" style="color:#fff;"><center>Destination</center></th>
          <th scope="col" style="color:#fff;"><center>Trip Dates</center></th>
          <th scope="col" style="color:#fff;"><center>Action</center></th>
        </thead>
        <tbody>
          @foreach($logsheets as $log)
            <?php $details = DB::table('car_contracts')->select('vehicle_reg_no','driver_name','fullName','faculty','destination','start_date', 'end_date')->where('id',$log->contract_id)->first(); ?>
            <tr>
              <th style="text-align: center;">{{$d}}.</th>
              <td><center>{{$log->contract_id}}</center></td>
              <td>{{$details->fullName}}</td>
              <td>{{$details->driver_name}}</td>
              <td><center>{{$details->vehicle_reg_no}}</center></td>
              <td><center>{{$details->destination}}</center></td>
              <td><center>{{date("d/m/Y",strtotime($details->start_date))}} - {{date("d/m/Y",strtotime($details->end_date))}}</center></td>
              <td><center><a title="View More Details" role="button" href="{{ route('logsheetmore',$log->contract_id) }}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a></center></td>
            </tr>
            <?php $d = $d+1; ?>
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
  $(window).on('load', function () {
    $("#coverScreen").hide();
  });

    window.onload=function(){
            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            $space_status=0;
            $insurance_status=0;
            $car_status=0;
            $research_status=0;

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


            if ($category=='Research Flats only' OR $category=='All') {
                $research_status=1;
            }
            else{

            }


            ?>

        var space_x={!! json_encode($space_status) !!};
        var insurance_x={!! json_encode($insurance_status) !!};
        var car_x={!! json_encode($car_status) !!};
        var research_x={!! json_encode($research_status) !!};

        if(space_x==1){

            $(".insurance_identity").removeClass("defaultContract");
            $(".car_identity").removeClass("defaultContract");
            $('.research_flats_identity').removeClass('defaultContract');
            $('.space_identity').addClass('defaultContract');


        }else if(insurance_x==1){
            $(".space_identity").removeClass("defaultContract");
            $(".car_identity").removeClass("defaultContract");
            $('.research_flats_identity').removeClass('defaultContract');
            $('.insurance_identity').addClass('defaultContract');

        }else if(car_x==1){
            $(".space_identity").removeClass("defaultContract");
            $(".insurance_identity").removeClass("defaultContract");
            $('.research_flats_identity').removeClass('defaultContract');
            $('.car_identity').addClass('defaultContract');

        }else if(research_x==1){
            $(".space_identity").removeClass("defaultContract");
            $(".insurance_identity").removeClass("defaultContract");
            $('.car_identity').removeClass('defaultContract');
            $('.research_flats_identity').addClass('defaultContract');


        }




        else{

        }


        document.querySelector('.defaultContract').click();

    };
</script>


    <script type="text/javascript">

        $("#generate_invoice_checkbox").trigger('change');




        function  generateInvoice(contract_id){



            if( $('#'+'generate_invoice_checkbox'+contract_id).prop('checked') ){

                $('#'+'invoiceDiv'+contract_id).show();
                $("#invoicing_period_start_date"+contract_id).attr("required", true);
                $("#invoicing_period_end_date"+contract_id).attr("required", true);
                $("#period"+contract_id).attr("required", true);
                $("#project_id"+contract_id).attr("required", true);
                $("#amount_to_be_paid"+contract_id).attr("required", true);
                $("#currency_invoice"+contract_id).attr("required", true);
                $("#status"+contract_id).attr("required", true);
                $("#description"+contract_id).attr("required", true);




            } else {


                $('#'+'invoiceDiv'+contract_id).hide();
                $("#invoicing_period_start_date"+contract_id).attr('required',false);
                $("#invoicing_period_end_date"+contract_id).attr('required',false);
                $("#period"+contract_id).attr('required',false);
                $("#project_id"+contract_id).attr('required',false);
                $("#amount_to_be_paid"+contract_id).attr('required',false);
                $("#currency_invoice"+contract_id).attr('required',false);
                $("#status"+contract_id).attr('required',false);
                $("#description"+contract_id).attr('required',false);


            }





        }




        $("#generate_invoice_insurance_checkbox").trigger('change');




        function  generateInsuranceInvoice(contract_id){



            if( $('#'+'generate_invoice_insurance_checkbox'+contract_id).prop('checked') ){

                $('#'+'invoice_insuranceDiv'+contract_id).show();
                $("#invoicing_period_start_date_insurance"+contract_id).attr("required", true);
                $("#invoicing_period_end_date_insurance"+contract_id).attr("required", true);
                $("#period_insurance"+contract_id).attr("required", true);
                $("#project_id_insurance"+contract_id).attr("required", true);
                $("#amount_to_be_paid_insurance"+contract_id).attr("required", true);
                $("#currency_invoice_insurance"+contract_id).attr("required", true);
                $("#status_insurance"+contract_id).attr("required", true);
                $("#description_insurance"+contract_id).attr("required", true);




            } else {
                $('#'+'invoice_insuranceDiv'+contract_id).hide();
                $("#invoicing_period_start_date_insurance"+contract_id).attr('required',false);
                $("#invoicing_period_end_date_insurance"+contract_id).attr('required',false);
                $("#period_insurance"+contract_id).attr('required',false);
                $("#project_id_insurance"+contract_id).attr('required',false);
                $("#amount_to_be_paid_insurance"+contract_id).attr('required',false);
                $("#currency_invoice_insurance"+contract_id).attr('required',false);
                $("#status_insurance"+contract_id).attr('required',false);
                $("#description_insurance"+contract_id).attr('required',false);
            }





        }






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
       $(document).ready(function(){
        pdfMake.fonts = {
        Times: {
                normal: 'times new roman.ttf',
                bold: 'times new roman bold.ttf',
                italics: 'times new roman italic.ttf',
                bolditalics: 'times new roman bold italic.ttf'
        }
};

var base64 = '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';


var tablelog = $('#LogTable').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>',
    "pageLength": 100,
    "bLengthChange": false
        });


        var table = $('#myTablea').DataTable( {
            dom:
    "<'top'<'pt-3 pull-left'B><'text-center pull-right'f>>"+
    "<'top'<tr>>" +
    "<'top'<'pull-left 'p>>",
            "pageLength": 100,
            "bLengthChange": false,
            processing:true,
            serverSide:true,
            ajax: {
                url:"{{ route('get_space_contracts') }}"

            },
            columnDefs: [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]],

            columns: [

                {data: 'DT_RowIndex', className: 'text-center', name: 'DT_RowIndex'},
                {data: 'full_name' , className: 'text-center',searchable: true},
                {data: 'contract_id' , className: 'text-center',searchable: true},
                {data: 'space_id_contract', className: 'text-center'},
                {data: 'start_date', className: 'text-center'},
                {data: 'end_date', className: 'text-center'},
                {data: 'amount_academic_season', className: 'text-center'},
                {data: 'amount_vacation_season', className: 'text-center'},


                {data: 'contract_status', className: 'text-center'},
                {data: 'action', className: 'text-center',  orderable: false, searchable: false},

            ],




        buttons: [
            {   extend: 'pdfHtml5',
                filename:'Real Estate Contracts',
                download: 'open',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'excelButton',
                orientation: 'Landscape',
                title: 'UNIVERSITY OF DAR ES SALAAM',
                //messageTop: '',
                pageSize: 'A4',
                //layout: 'lightHorizontalLines',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8]
                },



                customize: function ( doc ) {
                  var form_data  = table.rows().data();

                  doc.defaultStyle.font = 'Times';

                  doc['footer'] = (function (page, pages) {
                                    return {
                                        alignment: 'center',
                                        text: [{ text: page.toString() }]

                                    }
                  });

                  doc.content[1].table.widths=[22, '*', 70, 80, 80,60,60,60,60];
                  var rowCount = doc.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                         doc.content[1].table.body[i][0]=i+'.';
                      // doc.content[1].table.body[i][1] = form_data[i-1][1].split('"true">').pop().split('</a>')[0];
                      // doc.content[1].table.body[i][2] =form_data[i-1][2].split('"true"><center>').pop().split('</center>')[0] ;
                      doc.content[1].table.body[i][5].alignment = 'center';
                      doc.content[1].table.body[i][6].alignment = 'center';
                      doc.content[1].table.body[i][7].alignment = 'center';
                    };


                  //doc.defaultStyle.alignment = 'center';

                  doc.content[1].table.body[0].forEach(function (h) {
                    h.fillColor = 'white';
                    alignment: 'center';
                  });

                  doc.styles.title = {
                    bold: 'true',
                      fontSize: '12',
                      alignment: 'center'
                    };

        doc.styles.tableHeader.color = 'black';
        doc.styles.tableHeader.bold = 'false';
        doc.styles.tableBodyOdd.fillColor='';
        doc.styles.tableHeader.fontSize = 10;
        doc.content[1].layout ={
          hLineWidth: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        },
        vLineWidth: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        },
        hLineColor: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        },
        vLineColor: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        },
        fillColor: function (rowIndex, node, columnIndex) {
          return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        }
        };


                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+base64,
                         fit: [40, 40],
                    } );

                    doc.content.splice( 2, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                         text: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \n Real Estate Contracts'
                    } );
                }
            },

            {   extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                className: 'excelButton',
                title: 'Real Estate Contracts',
                exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8]
                },
            },
        ]
        });

        var table2 = $('#myTable2').DataTable( {
            dom: '<"top"fl>rt<"bottom"pi>',
            "pageLength": 100,
            "bLengthChange": false
        });

        var table_research = $('#myTableResearch').DataTable( {
            dom:
    "<'top'<'pt-3 pull-left'B><'text-center pull-right'f>>"+
    "<'top'<tr>>" +
    "<'top'<'pull-left 'p>>",
            "pageLength": 100,
            "bLengthChange": false,
            buttons: [
            {   extend: 'pdfHtml5',
                filename:'Research Flats Contracts',
                download: 'open',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'excelButton',
                orientation: 'Landscape',
                title: 'UNIVERSITY OF DAR ES SALAAM',
                //messageTop: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT \n \n Research Flats Contracts',
                pageSize: 'A4',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4,5, 6, 7,8]
                },

                customize: function ( doc ) {
                  var form_datas  = table_research.rows().data();

                  doc.defaultStyle.font = 'Times';

                  doc['footer'] = (function (page, pages) {
                                    return {
                                        alignment: 'center',
                                        text: [{ text: page.toString() }]

                                    }
                  });



                  doc.content[1].table.widths = [22, '*', 50, 80, 80, 100, 80, 80,80];
                  var rowCount = doc.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                      doc.content[1].table.body[i][0]=i+'.';
                      doc.content[1].table.body[i][1] = form_datas[i-1][1].split('"true">').pop().split('</a>')[0];
                      doc.content[1].table.body[i][2] = form_datas[i-1][2].split('"true">').pop().split('</a>')[0];
                      doc.content[1].table.body[i][5] = form_datas[i-1][5].split('"true">').pop().split('</a>')[0];
                      doc.content[1].table.body[i][0].alignment = 'center';
                      doc.content[1].table.body[i][3].alignment = 'center';
                      doc.content[1].table.body[i][4].alignment = 'center';
                      doc.content[1].table.body[i][5].alignment = 'center';
                      doc.content[1].table.body[i][6].alignment = 'right';
                      doc.content[1].table.body[i][7].alignment = 'right';
                    };

                 // doc.defaultStyle.alignment = 'center';

                  doc.content[1].table.body[0].forEach(function (h) {
                    h.fillColor = 'white';
                    alignment: 'center';
                  });

                  doc.styles.title = {
                    bold: 'true',
                      fontSize: '12',
                      alignment: 'center'
                    };

        doc.styles.tableHeader.color = 'black';
        doc.styles.tableHeader.bold = 'false';
        doc.styles.tableBodyOdd.fillColor='';
        doc.styles.tableHeader.fontSize = 10;
        doc.content[1].layout ={
          hLineWidth: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        },
        vLineWidth: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        },
        hLineColor: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        },
        vLineColor: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        },
        fillColor: function (rowIndex, node, columnIndex) {
          return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        }
        };


                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+base64,
                         fit: [40, 40],

                    } );

                    doc.content.splice( 2, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        text: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \n Research Flats Contracts'
                    });
                }
            },
            {   extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                className: 'excelButton',
                title: 'Research Flats Contracts',
                exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7,8]
                },
            },
          ]
        });

        var myTableInsurance = $('#myTableInsurance').DataTable( {

            // deferRender:true,
            dom:
    "<'top'<'pt-3 pull-left'B><'text-center pull-right'f>>"+
    "<'top'<tr>>" +
    "<'top'<'pull-left 'p>>",
            "pageLength": 100,
            "bLengthChange": false,
            processing:true,
            serverSide:true,
            ajax: {
                url:"{{ route('get_insurance_contracts') }}"

            },
            columnDefs: [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]],

            columns: [

                {data: 'DT_RowIndex', className: 'text-center', name: 'DT_RowIndex'},
           {data: 'full_name' , className: 'text-center'},
           {data: 'id' , className: 'text-center'},
           {data: 'insurance_class', className: 'text-center'},
           {data: 'principal', className: 'text-center'},

           {data: 'commission_date', className: 'text-center'},
           {data: 'end_date', className: 'text-center'},
           {data: 'premium', className: 'text-center'},


           {data: 'contract_status', className: 'text-center'},
                {data: 'action', className: 'text-center', name: 'action', orderable: false, searchable: false},



            ],


        buttons: [
            {   extend: 'pdfHtml5',
                filename:'Insurance Contracts',
                download: 'open',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'excelButton',
                orientation: 'Landscape',
                title: 'UNIVERSITY OF DAR ES SALAAM',
                //messageTop: '',
                pageSize: 'A4',
                //layout: 'lightHorizontalLines',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                },



                customize: function ( doc ) {

                  doc.defaultStyle.font = 'Times';

                  doc['footer'] = (function (page, pages) {
                                    return {
                                        alignment: 'center',
                                        text: [{ text: page.toString() }]

                                    }
                  });

                  doc.content[1].table.widths=[22, '*', 60, 90, 70,60,60,70,80];
                  var rowCount = doc.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                         doc.content[1].table.body[i][0]=i+'.';
                      doc.content[1].table.body[i][5].alignment = 'center';
                      doc.content[1].table.body[i][6].alignment = 'center';
                      // doc.content[1].table.body[i][9].alignment = 'center';
                    };


                  //doc.defaultStyle.alignment = 'center';

                  doc.content[1].table.body[0].forEach(function (h) {
                    h.fillColor = 'white';
                    alignment: 'center';
                  });

                  doc.styles.title = {
                    bold: 'true',
                      fontSize: '12',
                      alignment: 'center'
                    };

        doc.styles.tableHeader.color = 'black';
        doc.styles.tableHeader.bold = 'false';
        doc.styles.tableBodyOdd.fillColor='';
        doc.styles.tableHeader.fontSize = 10;
        doc.content[1].layout ={
          hLineWidth: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        },
        vLineWidth: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        },
        hLineColor: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        },
        vLineColor: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        },
        fillColor: function (rowIndex, node, columnIndex) {
          return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        }
        };


                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+base64,
                         fit: [40, 40],
                    } );

                    doc.content.splice( 2, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                         text: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \n Insurance Contracts'
                    } );
                }
            },

            {   extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                className: 'excelButton',
                title: 'Insurance Contracts',
                exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8]
                },
            },
        ]
        });





        var table3 = $('#myTablecar').DataTable( {
            dom:
    "<'top'<'pt-3 pull-left'B><'text-center pull-right'f>>"+
    "<'top'<tr>>" +
    "<'top'<'pull-left 'p>>",
            "pageLength": 100,
            "bLengthChange": false,
        buttons: [
            {   extend: 'pdfHtml5',
                filename:'Active Car Rental Contracts',
                download: 'open',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'excelButton',
                orientation: 'Landscape',
                title: 'UNIVERSITY OF DAR ES SALAAM',
                //messageTop: '',
                pageSize: 'A4',
                //layout: 'lightHorizontalLines',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                },



                customize: function ( doc ) {

                  doc.defaultStyle.font = 'Times';

                  doc['footer'] = (function (page, pages) {
                                    return {
                                        alignment: 'center',
                                        text: [{ text: page.toString() }]

                                    }
                  });

                  doc.content[1].table.widths=[22, 50, 140, '*', 110,90,80];
                  var rowCount = doc.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                         doc.content[1].table.body[i][0]=i+'.';
                      doc.content[1].table.body[i][1].alignment = 'center';
                      doc.content[1].table.body[i][6].alignment = 'right';
                      doc.content[1].table.body[i][4].alignment = 'center';
                    };


                  //doc.defaultStyle.alignment = 'center';

                  doc.content[1].table.body[0].forEach(function (h) {
                    h.fillColor = 'white';
                    alignment: 'center';
                  });

                  doc.styles.title = {
                    bold: 'true',
                      fontSize: '12',
                      alignment: 'center'
                    };

        doc.styles.tableHeader.color = 'black';
        doc.styles.tableHeader.bold = 'false';
        doc.styles.tableBodyOdd.fillColor='';
        doc.styles.tableHeader.fontSize = 10;
        doc.content[1].layout ={
          hLineWidth: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        },
        vLineWidth: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        },
        hLineColor: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        },
        vLineColor: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        },
        fillColor: function (rowIndex, node, columnIndex) {
          return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        }
        };


                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+base64,
                         fit: [40, 40],
                    } );

                    doc.content.splice( 2, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                         text: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \n Active Car Rental Contracts'
                    } );
                }
            },

            {   extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                className: 'excelButton',
                title: 'Active Car Rental Contracts',
                exportOptions: {
                columns: [1, 2, 3, 4, 5, 6]
                },
            },
        ]
        });

         var table4 = $('#myTablecar2').DataTable( {
            dom:
    "<'top'<'pt-3 pull-left'B><'text-center pull-right'f>>"+
    "<'top'<tr>>" +
    "<'top'<'pull-left 'p>>",
            "pageLength": 100,
            "bLengthChange": false,
        buttons: [
            {   extend: 'pdfHtml5',
                filename:'Car Rental Contracts',
                download: 'open',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'excelButton',
                orientation: 'Landscape',
                title: 'UNIVERSITY OF DAR ES SALAAM',
                //messageTop: '',
                pageSize: 'A4',
                //layout: 'lightHorizontalLines',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                },



                customize: function ( doc ) {

                  doc.defaultStyle.font = 'Times';

                  doc['footer'] = (function (page, pages) {
                                    return {
                                        alignment: 'center',
                                        text: [{ text: page.toString() }]

                                    }
                  });

                  doc.content[1].table.widths=[22, 50, 140, '*', 110,90,80];
                  var rowCount = doc.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                         doc.content[1].table.body[i][0]=i+'.';
                      doc.content[1].table.body[i][1].alignment = 'center';
                      doc.content[1].table.body[i][6].alignment = 'right';
                      doc.content[1].table.body[i][4].alignment = 'center';
                    };


                  //doc.defaultStyle.alignment = 'center';

                  doc.content[1].table.body[0].forEach(function (h) {
                    h.fillColor = 'white';
                    alignment: 'center';
                  });

                  doc.styles.title = {
                    bold: 'true',
                      fontSize: '12',
                      alignment: 'center'
                    };

        doc.styles.tableHeader.color = 'black';
        doc.styles.tableHeader.bold = 'false';
        doc.styles.tableBodyOdd.fillColor='';
        doc.styles.tableHeader.fontSize = 10;
        doc.content[1].layout ={
          hLineWidth: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        },
        vLineWidth: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        },
        hLineColor: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        },
        vLineColor: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        },
        fillColor: function (rowIndex, node, columnIndex) {
          return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        }
        };


                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+base64,
                         fit: [40, 40],
                    } );

                    doc.content.splice( 2, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                         text: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \nCar Rental Contracts'
                    } );
                }
            },

            {   extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                className: 'excelButton',
                title: 'Car Rental Contracts',
                exportOptions: {
                columns: [1, 2, 3, 4, 5, 6]
                },
            },
        ]
        });

        var table5 = $('#myTablecar3').DataTable( {
            dom:
    "<'top'<'pt-3 pull-left'B><'text-center pull-right'f>>"+
    "<'top'<tr>>" +
    "<'top'<'pull-left 'p>>",
            "pageLength": 100,
            "bLengthChange": false,
        buttons: [
            {   extend: 'pdfHtml5',
                filename:'Car Rental Contracts',
                download: 'open',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'excelButton',
                orientation: 'Landscape',
                title: 'UNIVERSITY OF DAR ES SALAAM',
                //messageTop: '',
                pageSize: 'A4',
                //layout: 'lightHorizontalLines',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                },



                customize: function ( doc ) {

                  doc.defaultStyle.font = 'Times';

                  doc['footer'] = (function (page, pages) {
                                    return {
                                        alignment: 'center',
                                        text: [{ text: page.toString() }]

                                    }
                  });

                  doc.content[1].table.widths=[22, 50, 140, '*', 110,90,80];
                  var rowCount = doc.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                         doc.content[1].table.body[i][0]=i+'.';
                      doc.content[1].table.body[i][1].alignment = 'center';
                      doc.content[1].table.body[i][6].alignment = 'right';
                      doc.content[1].table.body[i][4].alignment = 'center';
                    };


                  //doc.defaultStyle.alignment = 'center';

                  doc.content[1].table.body[0].forEach(function (h) {
                    h.fillColor = 'white';
                    alignment: 'center';
                  });

                  doc.styles.title = {
                    bold: 'true',
                      fontSize: '12',
                      alignment: 'center'
                    };

        doc.styles.tableHeader.color = 'black';
        doc.styles.tableHeader.bold = 'false';
        doc.styles.tableBodyOdd.fillColor='';
        doc.styles.tableHeader.fontSize = 10;
        doc.content[1].layout ={
          hLineWidth: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        },
        vLineWidth: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        },
        hLineColor: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        },
        vLineColor: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        },
        fillColor: function (rowIndex, node, columnIndex) {
          return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        }
        };


                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+base64,
                         fit: [40, 40],
                    } );

                    doc.content.splice( 2, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                         text: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \nCar Rental Contracts'
                    } );
                }
            },

            {   extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                className: 'excelButton',
                title: 'Car Rental Contracts',
                exportOptions: {
                columns: [1, 2, 3, 4, 5, 6]
                },
            },
        ]
          });

        var table6 = $('#myTablecar4').DataTable( {
            dom:
    "<'top'<'pt-3 pull-left'B><'text-center pull-right'f>>"+
    "<'top'<tr>>" +
    "<'top'<'pull-left 'p>>",
            "pageLength": 100,
            "bLengthChange": false,
        buttons: [
            {   extend: 'pdfHtml5',
                filename:'Car Rental Contracts',
                download: 'open',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'excelButton',
                orientation: 'Landscape',
                title: 'UNIVERSITY OF DAR ES SALAAM',
                //messageTop: '',
                pageSize: 'A4',
                //layout: 'lightHorizontalLines',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                },



                customize: function ( doc ) {

                  doc.defaultStyle.font = 'Times';

                  doc['footer'] = (function (page, pages) {
                                    return {
                                        alignment: 'center',
                                        text: [{ text: page.toString() }]

                                    }
                  });

                  doc.content[1].table.widths=[22, 50, 140, '*', 110,90,80];
                  var rowCount = doc.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                         doc.content[1].table.body[i][0]=i+'.';
                      doc.content[1].table.body[i][1].alignment = 'center';
                      doc.content[1].table.body[i][6].alignment = 'right';
                      doc.content[1].table.body[i][4].alignment = 'center';
                    };


                  //doc.defaultStyle.alignment = 'center';

                  doc.content[1].table.body[0].forEach(function (h) {
                    h.fillColor = 'white';
                    alignment: 'center';
                  });

                  doc.styles.title = {
                    bold: 'true',
                      fontSize: '12',
                      alignment: 'center'
                    };

        doc.styles.tableHeader.color = 'black';
        doc.styles.tableHeader.bold = 'false';
        doc.styles.tableBodyOdd.fillColor='';
        doc.styles.tableHeader.fontSize = 10;
        doc.content[1].layout ={
          hLineWidth: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        },
        vLineWidth: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        },
        hLineColor: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        },
        vLineColor: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        },
        fillColor: function (rowIndex, node, columnIndex) {
          return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        }
        };


                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+base64,
                         fit: [40, 40],
                    } );

                    doc.content.splice( 2, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                         text: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \n Car Rental Contracts'
                    } );
                }
            },

            {   extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                className: 'excelButton',
                title: 'Car Rental Contracts',
                exportOptions: {
                columns: [1, 2, 3, 4, 5, 6]
                },
            },
        ]
        });

        var table7 = $('#myTablecar5').DataTable( {
           dom:
    "<'top'<'pt-3 pull-left'B><'text-center pull-right'f>>"+
    "<'top'<tr>>" +
    "<'top'<'pull-left 'p>>",
            "pageLength": 100,
            "bLengthChange": false,
        buttons: [
            {   extend: 'pdfHtml5',
                filename:'Car Rental Contracts',
                download: 'open',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'excelButton',
                orientation: 'Landscape',
                title: 'UNIVERSITY OF DAR ES SALAAM',
                //messageTop: '',
                pageSize: 'A4',
                //layout: 'lightHorizontalLines',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                },



                customize: function ( doc ) {

                  doc.defaultStyle.font = 'Times';

                  doc['footer'] = (function (page, pages) {
                                    return {
                                        alignment: 'center',
                                        text: [{ text: page.toString() }]

                                    }
                  });

                  doc.content[1].table.widths=[22, 50, 140, '*', 110,90,80];
                  var rowCount = doc.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                         doc.content[1].table.body[i][0]=i+'.';
                      doc.content[1].table.body[i][1].alignment = 'center';
                      doc.content[1].table.body[i][6].alignment = 'right';
                      doc.content[1].table.body[i][4].alignment = 'center';
                    };


                  //doc.defaultStyle.alignment = 'center';

                  doc.content[1].table.body[0].forEach(function (h) {
                    h.fillColor = 'white';
                    alignment: 'center';
                  });

                  doc.styles.title = {
                    bold: 'true',
                      fontSize: '12',
                      alignment: 'center'
                    };

        doc.styles.tableHeader.color = 'black';
        doc.styles.tableHeader.bold = 'false';
        doc.styles.tableBodyOdd.fillColor='';
        doc.styles.tableHeader.fontSize = 10;
        doc.content[1].layout ={
          hLineWidth: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        },
        vLineWidth: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        },
        hLineColor: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        },
        vLineColor: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        },
        fillColor: function (rowIndex, node, columnIndex) {
          return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        }
        };


                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+base64,
                         fit: [40, 40],
                    } );

                    doc.content.splice( 2, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                         text: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \n Car Rental Contracts'
                    } );
                }
            },

            {   extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                className: 'excelButton',
                title: 'Car Rental Contracts',
                exportOptions: {
                columns: [1, 2, 3, 4, 5, 6]
                },
            },
        ]
        });

           var table8 = $('#myTablecar6').DataTable( {
            dom:
    "<'top'<'pt-3 pull-left'B><'text-center pull-right'f>>"+
    "<'top'<tr>>" +
    "<'top'<'pull-left 'p>>",
            "pageLength": 100,
            "bLengthChange": false,
        buttons: [
            {   extend: 'pdfHtml5',
                filename:'Car Rental Contracts',
                download: 'open',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'excelButton',
                orientation: 'Landscape',
                title: 'UNIVERSITY OF DAR ES SALAAM',
                //messageTop: '',
                pageSize: 'A4',
                //layout: 'lightHorizontalLines',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                },



                customize: function ( doc ) {

                  doc.defaultStyle.font = 'Times';

                  doc['footer'] = (function (page, pages) {
                                    return {
                                        alignment: 'center',
                                        text: [{ text: page.toString() }]

                                    }
                  });

                  doc.content[1].table.widths=[22, 50, 140, '*', 110,90,80];
                  var rowCount = doc.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                         doc.content[1].table.body[i][0]=i+'.';
                      doc.content[1].table.body[i][1].alignment = 'center';
                      doc.content[1].table.body[i][6].alignment = 'right';
                      doc.content[1].table.body[i][4].alignment = 'center';
                    };


                  //doc.defaultStyle.alignment = 'center';

                  doc.content[1].table.body[0].forEach(function (h) {
                    h.fillColor = 'white';
                    alignment: 'center';
                  });

                  doc.styles.title = {
                    bold: 'true',
                      fontSize: '12',
                      alignment: 'center'
                    };

        doc.styles.tableHeader.color = 'black';
        doc.styles.tableHeader.bold = 'false';
        doc.styles.tableBodyOdd.fillColor='';
        doc.styles.tableHeader.fontSize = 10;
        doc.content[1].layout ={
          hLineWidth: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        },
        vLineWidth: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        },
        hLineColor: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        },
        vLineColor: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        },
        fillColor: function (rowIndex, node, columnIndex) {
          return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        }
        };


                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+base64,
                         fit: [40, 40],
                    } );

                    doc.content.splice( 2, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                         text: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \n Car Rental Contracts'
                    } );
                }
            },

            {   extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                className: 'excelButton',
                title: 'Car Rental Contracts',
                exportOptions: {
                columns: [1, 2, 3, 4, 5, 6]
                },
            },
        ]
        });

            var table9 = $('#myTablecar7').DataTable( {
            dom:
    "<'top'<'pt-3 pull-left'B><'text-center pull-right'f>>"+
    "<'top'<tr>>" +
    "<'top'<'pull-left 'p>>",
            "pageLength": 100,
            "bLengthChange": false,
        buttons: [
            {   extend: 'pdfHtml5',
                filename:'Car Rental Contracts',
                download: 'open',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'excelButton',
                orientation: 'Landscape',
                title: 'UNIVERSITY OF DAR ES SALAAM',
                //messageTop: '',
                pageSize: 'A4',
                //layout: 'lightHorizontalLines',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                },



                customize: function ( doc ) {

                  doc.defaultStyle.font = 'Times';

                  doc['footer'] = (function (page, pages) {
                                    return {
                                        alignment: 'center',
                                        text: [{ text: page.toString() }]

                                    }
                  });

                  doc.content[1].table.widths=[22, 50, 140, '*', 110,90,80];
                  var rowCount = doc.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                         doc.content[1].table.body[i][0]=i+'.';
                      doc.content[1].table.body[i][1].alignment = 'center';
                      doc.content[1].table.body[i][6].alignment = 'right';
                      doc.content[1].table.body[i][4].alignment = 'center';
                    };


                  //doc.defaultStyle.alignment = 'center';

                  doc.content[1].table.body[0].forEach(function (h) {
                    h.fillColor = 'white';
                    alignment: 'center';
                  });

                  doc.styles.title = {
                    bold: 'true',
                      fontSize: '12',
                      alignment: 'center'
                    };

        doc.styles.tableHeader.color = 'black';
        doc.styles.tableHeader.bold = 'false';
        doc.styles.tableBodyOdd.fillColor='';
        doc.styles.tableHeader.fontSize = 10;
        doc.content[1].layout ={
          hLineWidth: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 0.5 : 0.5;
        },
        vLineWidth: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 0.5 : 0.5;
        },
        hLineColor: function (i, node) {
          return (i === 0 || i === node.table.body.length) ? 'black' : 'black';
        },
        vLineColor: function (i, node) {
          return (i === 0 || i === node.table.widths.length) ? 'black' : 'black';
        },
        fillColor: function (rowIndex, node, columnIndex) {
          return (rowIndex % 2 === 0) ? '#ffffff' : '#ffffff';
        }
        };


                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+base64,
                         fit: [40, 40],
                    } );

                    doc.content.splice( 2, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                         text: 'DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT\n \n Car Rental Contracts'
                    } );
                }
            },

            {   extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                className: 'excelButton',
                title: 'Car Rental Contracts',
                exportOptions: {
                columns: [1, 2, 3, 4, 5, 6]
                },
            },
        ]
        });
      });
    </script>



<script type="text/javascript">
    function openDeepInnerSpace(evt, evtName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent_deep_inner_space");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks_deep_inner_space");

        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(evtName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    document.getElementById("defaultOpenDeepInnerSpace").click();
</script>



@endsection
