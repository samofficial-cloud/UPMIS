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
    font-family:"Nunito", sans-serif;
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
  }

  .form-wrapper{
    width: 100%
  }

  .form-inline label {
    justify-content: left;
  }

  /*.card:hover {
    cursor: not-allowed;
    animation-duration: 20ms;
    animation-timing-function: linear;
    animation-iteration-count: 10;
    animation-name: wiggle;
  }*/

  .modal:hover{
    animation: none !important;
  }

  @keyframes wiggle {
  0% { transform: translate(0px, 0); }
 /* 10% { transform: translate(-1px, 0); }
  20% { transform: translate(1px, 0); }
  30% { transform: translate(-1px, 0); }
  40% { transform: translate(1px, 0); }
  50% { transform: translate(-2px, 0); }
  60% { transform: translate(2px, 0); }
  70% { transform: translate(-2px, 0); }*/
  80% { transform: translate(2px, 0); }
  90% { transform: translate(-2px, 0); }
  100% { transform: translate(0, 0); }
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
            <li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
<div class="main_content">
  <?php
  use App\insurance;
  use App\insurance_contract;
  $packages=insurance::select('class')->distinct()->count();
  $total_insurance=insurance::select('insurance_company')->groupby('insurance_company')->distinct()->count();
  $motor_client=insurance_contract::where('insurance_class','MOTOR')->whereYear('commission_date',date('Y'))->count();
  $fire_client=insurance_contract::where('insurance_class','FIRE')->whereYear('commission_date',date('Y'))->count();
  $money_client=insurance_contract::where('insurance_class','MONEY')->whereYear('commission_date',date('Y'))->count();
  $fidelity_client=insurance_contract::where('insurance_class','FIDELTY GUARANTEE')->whereYear('commission_date',date('Y'))->count();
  $public_client=insurance_contract::where('insurance_class','PUBLIC LIABILITY')->whereYear('commission_date',date('Y'))->count();
  $marine_client=insurance_contract::where('insurance_class','MARINE HULL')->whereYear('commission_date',date('Y'))->count();
  $prof_client=insurance_contract::where('insurance_class','PROFFESIONAL INDEMNITY')->whereYear('commission_date',date('Y'))->count();
  $i='1';
  ?>
    <br>

    <div class="container">
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
  <div class="card">
  <div class="card-body">
<div class="card-columns" style="margin-top: 10px;">
  <div class="card border-primary">
    {!! $chart->container() !!}
  </div>
  <div class="card bg-primary text-white">
    <div class="card-body" style="line-height: 25px;" >
      <h5 class="card-title">General Statistics<i class="fa fa-line-chart" style="font-size:30px; float: right; color: black;"></i></h5>
      Principals: {{$total_insurance}}
      <br>Packages: {{$packages}}
      <hr style="margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border: 1px solid #505559;">
    <h5 class="card-title">Client Statistics {{date('Y')}}</h5>
      Fire Package Clients: {{$fire_client}}
      <br>Fidelity Clients: {{$fidelity_client}}
      <br>Marine Hull Clients: {{$marine_client}}
      <br>Motor Package Clients: {{$motor_client}}
      <br>Proffesional Indemnity Clients: {{$prof_client}}
      <br>Public Liabilty Clients: {{$public_client}}
      <br>Total Clients: {{$motor_client + $fire_client + $fidelity_client +  $marine_client + $prof_client + $public_client}}
    </div>
  </div>
   <div class="card border-primary">
    {!! $chart1->container() !!}
  </div>
</div>
</div>
</div>
    <br>
    <div class="card ">
      <div class="card-body">
        <h4 class="card-title" style="font-family: sans-serif;">Income Collected from Cover Note Sales per each Class {{date('Y')}}</h4>
            <hr>
          <div class="card ">
    {!! $chart2->container() !!}
  </div>
    </div>
  </div>
  <br>
    <div class="card">
    <div class="card-body">
     <h4 class="card-title" style="font-family: sans-serif;">Cover(s) that are about to expire (Within 30 days prior to date)</h4>
     <hr>
     <a title="Send email to selected clients" href="#" id="notify_all" class="btn btn-info btn-sm" data-toggle="modal" data-target="#inia_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="inia_mail" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="inia_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="inia_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="inia_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>

        <div class="form-group row">
            <label for="inia_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="inia_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="inia_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="inia_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="inia_message" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="inia_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="inia_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="inia_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="udia" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     <table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
        <tr>
          <th scope="col" style="width: 5%;"><center>S/N</center></th>
          <th scope="col" style="width: 25%;"><center>Client Name</center></th>
          <th scope="col"><center>Class</center></th>
          <th scope="col" ><center>Cover Note</center></th>
          <th scope="col" ><center>Commission Date</center></th>
          <th scope="col" ><center>End Date</center></th>
          <th scope="col"><center>Action</center></th>
        </tr>
        </thead>
        <tbody>
          @foreach($contracts as $contract)
          <tr>
            <td><center>{{$i}}.</center></td>
            <td><a title="View More Details" class="link_style" data-toggle="modal" data-target="#client{{$contract->id}}" style="color: blue !important;  cursor: pointer;" aria-pressed="true">{{$contract->full_name}}</a>
                  <div class="modal fade" id="client{{$contract->id}}" role="dialog">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">Additional Client Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                  <table style="width: 100%">
                                    <tr>
                                          <td style="width: 30%;">Client Name</td>
                                          <td>{{$contract->full_name}}</td>
                                      </tr>
                                      <tr>
                                          <td>Phone Number</td>
                                          <td>{{$contract->phone_number}}</td>
                                      </tr>
                                      <tr>
                                          <td>Email</td>
                                          <td>{{$contract->email}}</td>
                                      </tr>
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                          </div>
                      </div>
                  </div>
              </td>
              @if($contract->insurance_class!='MOTOR')
            <td>
              {{$contract->insurance_class}}
              </td>
              @else
              <td>
                <a title="View More Details" class="link_style" data-toggle="modal" data-target="#ins_class{{$contract->id}}" style="color: blue !important;  cursor: pointer;" aria-pressed="true">{{$contract->insurance_class}}</a>
                  <div class="modal fade" id="ins_class{{$contract->id}}" role="dialog">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <b><h5 class="modal-title">Additional Details.</h5></b>

                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <div class="modal-body">
                                  <table style="width: 100%">
                                    <tr>
                                          <td style="width: 30%;">Class</td>
                                          <td>{{$contract->insurance_class}}</td>
                                      </tr>
                                      <tr>
                                          <td>Vehicle Reg No.</td>
                                          <td>{{$contract->vehicle_registration_no}}</td>
                                      </tr>
                                      <tr>
                                          <td>Vehicle Use</td>
                                          <td>{{$contract->vehicle_use}}</td>
                                      </tr>
                                      <tr>
                                          <td>Principal</td>
                                          <td>{{$contract->principal}}</td>
                                      </tr>
                                      <tr>
                                          <td>Insurance Type</td>
                                          <td>{{$contract->insurance_type}}</td>
                                      </tr>
                                  </table>
                                  <br>
                                  <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                              </div>
                          </div>
                      </div>
                  </div>
              </td>
            @endif
             <td>{{$contract->cover_note}}</td>
            <td><center>{{date("d/m/Y",strtotime($contract->commission_date))}}</center></td>
            <td><center>{{date("d/m/Y",strtotime($contract->end_date))}}</center></td>
            <td>
              @if($contract->email!="")
              <a title="Send Email to this Client" data-toggle="modal" data-target="#mailIns{{$contract->id}}" role="button" aria-pressed="true"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
      <div class="modal fade" id="mailIns{{$contract->id}}" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="client_names{{$contract->id}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="udia_act_names{{$contract->id}}" name="client_name" class="form-control" value="{{$contract->full_name}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="udia_subject{{$contract->id}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="udia_subject{{$contract->id}}" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="udia_greetings{{$contract->id}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="udia_greetings{{$contract->id}}" name="greetings" class="form-control" value="Dear {{$contract->full_name}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="udia_message{{$contract->id}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="udia_message{{$contract->id}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="udia_attachment{{$contract->id}}" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="udia_attachment{{$contract->id}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="udia_closing{{$contract->id}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="udia_closing{{$contract->id}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="udia" hidden="">

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
     <a title="Send Email to this Client" role="button" aria-pressed="true" onclick="myFunction()"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
     @endif
            </td>
          </tr>
          <?php $i=$i+1; ?>
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
<script>
function myFunction() {
  alert("This client has no email.");
}
</script>

<script type="text/javascript">
   $(document).ready(function(){
  var table = $('#myTable').DataTable( {
    dom: '<"top"l>rt<"bottom"pi>'
  } );

  var table1 = $('#myTable1').DataTable( {
    dom: '<"top"l>rt<"bottom">'
  } );

  var table2 = $('#myTable').DataTable();

    $('#myTable tbody').on( 'click', 'tr', function () {
      document.getElementById("inia_par_names").innerHTML="";
       document.getElementById("inia_greetings").value="Dear ";
       var email0 = $(this).find('td:eq(7)').text();
       if(email0==""){

       }
       else{
        $(this).toggleClass('selected');
         var count2=table2.rows('.selected').data().length +' row(s) selected';
        if(count2>'2'){
        $('#notify_all').show();
        }
        else{
        $('#notify_all').hide();
        }
     }

    });

    $('#notify_all').click( function () {
      document.getElementById("inia_par_names").innerHTML="";
       document.getElementById("inia_greetings").value="Dear ";
        var datas6 = table2.rows('.selected').data();
        var link = datas6[0][1];
        var result6 = [];
        for (var i = 0; i < datas6.length; i++)
        {
                result6.push(datas6[i][1].split('"true">').pop().split('</a>')[0]);
        }

        $('#inia_client_names').val(result6).toString();

        var content6 = document.getElementById("inia_par_names");
        for(var i=0; i< result6.length;i++){
          if(i==(result6.length-1)){
            content6.innerHTML += result6[i]+ '.';
          }
          else{
            content6.innerHTML += result6[i] + ', ';
          }

        }

        var salutation6 = document.getElementById("inia_greetings");
        for(var i=0; i< result6.length;i++){
          if(i==(result6.length-1)){
            salutation6.value += result6[i]+ '.';
          }
          else{
            salutation6.value += result6[i] + ', ';
          }

        }
         //console.log(result);
    } );
    });

</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script> --}}
        {!! $chart->script() !!}
         {!! $chart1->script() !!}
         {!! $chart2->script() !!}
        {{--  {!! $chart4->script() !!} --}}
          {{-- {!! $chart5->script() !!}
           {!! $chart6->script() !!} --}}
@endsection
