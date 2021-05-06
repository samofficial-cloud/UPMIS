<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	 $solicited = DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('contract_category','Solicited')->whereRaw('DATEDIFF(end_date,CURDATE()) < '.$_GET["mon"])->whereRaw('DATEDIFF(end_date,CURDATE()) > 0')->get();
?>

<div class="card-body">
     <h4 class="card-title" style="font-family: sans-serif;">Solicited Contract(s) that are about to expire (Within {{$_GET['mon']}} days prior to date)</h4>
     <hr>

      <table class="hover table table-striped table-bordered" id="myTablea">
  <thead class="thead-dark">
        <tr>
          <th scope="col" style="width: 5%;">S/N</th>
          <th scope="col" style="width: 20%;">Client</th>
          <th scope="col">Contract ID</th>
          <th scope="col" style="width: 15%;">Major Industry</th>
          <th scope="col" >MInor Industry</th>
          <th scope="col" style="width: 15%;">Location</th>
          <th scope="col" style="width: 20%;">Sub Location</th>
        </tr>
        </thead>

        <tbody>
          @foreach($solicited as $space)
          <tr>

            <th scope="row" class="counterCell">.</th>

                         <td>
                                      <a title="View More Client Details" class="link_style" data-toggle="modal" data-target="#clienta{{$space->contract_id}}" style="color: blue !important; cursor: pointer;" aria-pressed="true">{{$space->full_name}}</a>
                  <div class="modal fade" id="clienta{{$space->contract_id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">{{$space->full_name}} Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                  <table style="width: 100%">
                                      <tr>
                                          <td>Client Type:</td>
                                          <td>{{$space->type}}</td>
                                      </tr>
                                      @if($space->type=='Individual')
                                          <tr>
                                              <td> First Name:</td>
                                              <td> {{$space->first_name}}</td>
                                          </tr>
                                          <tr>
                                              <td>Last Name:</td>
                                              <td>{{$space->last_name}}</td>
                                          </tr>
                                      @elseif($space->type=='Company/Organization')
                                          <tr>
                                              <td>Company Name:</td>
                                              <td>{{$space->company_name}}</td>
                                          </tr>
                                      @endif
                                      <tr>
                                          <td>Phone Number:</td>
                                          <td>{{$space->phone_number}}</td>
                                      </tr>
                                      <tr>
                                          <td>Email:</td>
                                          <td>{{$space->email}}</td>
                                      </tr>
                                      <tr>
                                          <td>Address:</td>
                                          <td>{{$space->address}}</td>
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
                                      <a title="View More Contract Details" class="link_style" data-toggle="modal" data-target="#contracta{{$space->contract_id}}" style="color: blue !important; cursor: pointer;" aria-pressed="true"><center>{{$space->contract_id}}</center></a>
                  <div class="modal fade" id="contracta{{$space->contract_id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">{{$space->full_name}} Contract Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                 <table style="width: 100%">
                                      <tr>
                                          <td>Contract ID</td>
                                          <td colspan="2">{{$space->contract_id}}</td>
                                      </tr>
                                      <tr>
                                          <td>Real Estate Number</td>
                                          <td colspan="2">{{$space->space_id_contract}}</td>
                                      </tr>
                                      <tr>
                                          <td>Lease Start</td>
                                          <td colspan="2">{{date("d/m/Y",strtotime($space->start_date))}}</td>
                                      </tr>
                                      <tr>
                                          <td>Lease End</td>
                                          <td colspan="2">{{date("d/m/Y",strtotime($space->end_date))}}</td>
                                      </tr>
                                      @if($space->academic_dependence=="Yes")
                                      <tr>
                                          <td rowspan="3">Amount</td>
                                        </tr>
                                        <tr>
                                          <td>Academic Season</td>
                                          <td>Vacation Season</td>
                                        </tr>
                                        <tr>
                                          @if(empty($space->academic_season))
                                          <td><center>-</center></td>
                                          @else
                                          <td>{{$space->currency}} {{number_format($space->academic_season)}}</td>
                                          @endif


                                           @if(empty($space->vacation_season))
                                           <td><center>-</center></td>
                                           @else
                                          <td>{{$space->currency}} {{number_format($space->vacation_season)}}</td>
                                          @endif
                                      </tr>
                                      @else
                                      <tr>
                                        <td>Amount</td>
                                         @if(empty($space->amount))
                                         <td>-</td>
                                         @else
                                        <td colspan="2">{{$space->currency}} {{number_format($space->amount)}}</td>
                                        @endif
                                      </tr>
                                      @endif
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
              <td>{{$space->major_industry}}</td>
              <td>{{$space->minor_industry}}</td>
              <td>{{$space->location}}</td>
              <td>{{$space->sub_location}}</td>
          </tr>

          @endforeach

        </tbody>
</table>
</div>
</body>
</html>
