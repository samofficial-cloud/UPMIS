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
    height:auto;
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
          @elseif($category=='Research Flats only')
          <li><a href="{{ route('home6') }}"><i class="fas fa-home active"></i>Home</a></li>
           @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li class="active_nav_item"><a href="{{ route('home3') }}"><i class="fas fa-home active"></i>Home</a></li>
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
      <?php
        $single_rooms = DB::table('research_flats_rooms')->where('category','Single Room')->where('status','1')->count();
        $shared_rooms = DB::table('research_flats_rooms')->where('category','Shared Room')->where('status','1')->count();
        $suite_rooms = DB::table('research_flats_rooms')->where('category','Suite Room')->where('status','1')->count();
        $total_rooms= $single_rooms + $shared_rooms + $suite_rooms;
        $single_room_clients = DB::table('research_flats_rooms')->join('research_flats_contracts','research_flats_contracts.room_no','=','research_flats_rooms.room_no')->where('category','Single Room')->whereYear('arrival_date',date('Y'))->count();
        $shared_room_clients = DB::table('research_flats_rooms')->join('research_flats_contracts','research_flats_contracts.room_no','=','research_flats_rooms.room_no')->where('category','Shared Room')->whereYear('arrival_date',date('Y'))->count();
        $suite_room_clients = DB::table('research_flats_rooms')->join('research_flats_contracts','research_flats_contracts.room_no','=','research_flats_rooms.room_no')->where('category','Suite Room')->whereYear('arrival_date',date('Y'))->count();
        $total_clients = $single_room_clients + $shared_room_clients +$suite_room_clients;
        $year= date('Y');
      ?>

         <div class="container" style="max-width: 100%;">
            <br>
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

          <div class="card">
              <br>
   <div class="col-sm-12">
    <div>
        <form class="form-inline" role="form" method="post" accept-charset="utf-8">

        <div class="form-group" style="margin-right: 5px;">

          <select name="activity_year" id="activity_year" class="form-control" required="">
              <option value=" " disabled selected hidden>Select Year</option>
                @for($x=-5;$x<=0; $x++)
                  <option value="{{$year + $x}}">{{$year + $x}}</option>
                @endfor
          </select>
          <span id="activity_error"></span>
        </div>

      <div class="form-group"  style="margin-right: 5px;">
          <input type="submit" name="filter" value="Filter" id="activity_filter" class="btn btn-primary">
      </div>


    </form>
  </div>
</div>

                        <div class="card-body">
                            <div class="card-columns" style="font-size: 15px; font-family: sans-serif;">

                              <div class="card border-success">
                                {!! $chart->container() !!}
                              </div>

                      <div class="card card text-white bg-success">
                        <div class="card-body">
                          <h5 class="card-title">General Statistics <i class="fas fa-building" style="font-size:30px; float: right; color: black;"></i></h5>
                          Total Rooms: {{$total_rooms}}
                          <br>Standard Rooms: {{$single_rooms}}
                          <br>Shared Rooms: {{$shared_rooms}}
                          <br>Suite Rooms: {{$suite_rooms}}
                          <hr style="margin-top: 1rem;
                        margin-bottom: 1rem;
                        border: 0;
                        border: 1px solid #505559;">
                        <div id="cardData">
                          <h5>Clients Statistics {{date('Y')}}</h5>
                              Standard Room Clients: {{$single_room_clients}}
                          <br>Shared Room Clients: {{$shared_room_clients}}
                          <br>Suite Room Clients: {{$suite_room_clients}}
                          <br>Total Clients: {{$total_clients}}
                        </div>
                        </div>
                      </div>
                      <div class="card border-success">
                         {!! $chart2->container() !!}
                      </div>
                    </div>
                </div>
              </div>
              <br>
                  <div class="card">
                    <div class="card-body">
                     <h3 class="card-title" style="font-family: sans-serif;">Outstanding Debt(s)</h3>
                     <hr>
                          <a title="Send email to selected clients" href="#" id="debt_notify_all" class="btn btn-info btn-sm" data-toggle="modal" data-target="#debt_mail" role="button" aria-pressed="true" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    margin-top: 4px;
    display: none;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
    <div class="modal fade" id="debt_mail" role="dialog">
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
            <label for="debt_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="debt_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="debt_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>

        <div class="form-group row">
            <label for="debt_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="debt_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="debt_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="debt_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="debt_message" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="debt_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="debt_attachment" class="col-sm-2">Attachments</label>
            <div class="col-sm-9">
              <input type="file" id="debt_attachment" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="debt_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="debt_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
         <input type="text" name="type" value="space" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     @if(count($invoices)!=0)
                     <table class="hover table table-striped table-bordered" id="myTable1">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"><center>S/N</center></th>
                                <th scope="col" >Debtor Name</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col" >Arrival Date</th>
                                <th scope="col" >Departure date</th>
                                <th scope="col">Contract Id</th>
                                <th scope="col" style="width: 12%;">Amount</th>
                                <th scope="col" >Invoice Date</th>
                                <th scope="col" >Debt Age</th>
                                <th scope="col" >Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $var)
                                <tr>
                                    <th scope="row" class="counterCell">.</th>
                                    <td>{{$var->debtor_name}}</td>
                                    <td><center>{{$var->invoice_number}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->arrival_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->departure_date))}}</center></td>
                                    <td><center>{{$var->id}}</center></td>
                                    <td style="text-align: right;">{{$var->currency_invoice}} {{number_format($var->amount_not_paid)}}</td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                    <td style="text-align: right;">{{$diff = Carbon\Carbon::parse($var->invoice_date)->diffForHumans(null, true) }}</td>
                                    <td>
                                      @if(($var->invoice_debtor=='individual' && $var->email!='') || ($var->invoice_debtor=='host' && $var->host_email!=''))
                                          <a title="Send Email to this Client" data-toggle="modal" data-target="#spacemail{{$var->invoice_number}}" role="button" aria-pressed="true"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>

                        <div class="modal fade" id="spacemail{{$var->invoice_number}}" role="dialog">
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
                              <label for="flatsclient_names{{$var->invoice_number}}" class="col-sm-2">To</label>
                              <div class="col-sm-9">
                              <input type="text" id="flatsclient_names{{$var->invoice_number}}" name="client_name" class="form-control" value="{{$var->debtor_name}}" readonly="">
                            </div>
                          </div>
                          <br>
                          <div class="form-group row">
                              <label for="flatssubject{{$var->invoice_number}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
                              <div class="col-sm-9">
                              <input type="text" id="flatssubject{{$var->invoice_number}}" name="subject" class="form-control" value="" required="">
                            </div>
                          </div>
                           <br>
                           <div class="form-group row">
                              <label for="flatsgreetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
                              <div class="col-sm-9">
                              <input type="text" id="flatsgreetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear {{$var->debtor_name}}," readonly="">
                            </div>
                          </div>
                           <br>

                          <div class="form-group row">
                              <label for="flatsmessage{{$var->invoice_number}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
                              <div class="col-sm-9">
                                <textarea type="text" id="flatsmessage{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7" required=""></textarea>
                            </div>
                          </div>
                          <br>

                          <div class="form-group row">
                              <label for="flatsattachment{{$var->invoice_number}}" class="col-sm-2">Attachments</label>
                               <div class="col-sm-9">
                                <input type="file" id="flatsattachment{{$var->invoice_number}}" name="filenames[]" class="myfrm form-control" multiple="">
                                <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
                            </div>
                          </div>
                          <br>

                          <div class="form-group row">
                              <label for="flatsclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
                              <div class="col-sm-9">
                              <input type="text" id="flatsclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
                            </div>
                          </div>
                          <br>
                          <input type="text" name="type" value="flats" hidden="">
                          <input type="text" name="debtor" value="{{$var->invoice_debtor}}" hidden="">
                          <input type="text" name="contract_id" value="{{$var->id}}" hidden>


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
                                    </td>
                                  </tr>
                            @endforeach
                            </tbody>
                              </table>
                              @else
<br><br>
<p style="font-size: 18px;">No data to display.</p>
                              @endif
                   </div>
                  </div>




        </div>
    </div>
</div>
@endsection

@section('pagescript')
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#myTable1').DataTable( {
        dom: '<"top"l><"top"<"pull-right" >>rt<"bottom"pi>'
      });
  $("#activity_filter").click(function(e){
    e.preventDefault();

    var query = $('#activity_year').val();

    if(query==null){
      $('#activity_error').show();
      var message=document.getElementById('activity_error');
      message.style.color='red';
      message.innerHTML="Required";
      $('#activity_year').attr('style','border:1px solid #f00');
    }
    else{

      $('#activity_error').hide();
      $('#activity_year').attr('style','border:1px solid #ccc');
      $.ajax({
      url: "/home30/activity_filter?",
      context: document.body,
      async : false,
      data:{year:query}
      })
    .done(function(data) {
      {{$chart->id}}.options.title.text = 'Rental Activities '+query;
      {{ $chart->id }}.data.datasets[0].data =data.activity;
      {{ $chart->id }}.update();

      {{$chart2->id}}.options.title.text = 'Income Generation '+query;
      {{ $chart2->id }}.data.datasets[0].data =data.income;
      {{ $chart2->id }}.data.datasets[1].data =data.income2;
      {{ $chart2->id }}.update();
      var bodyData = '';

      bodyData= "<div>"
      bodyData+="<h5 class='card-title'>Client Statistics "
      bodyData+=query+"</h5>"
      bodyData+="Single Room Clients: "+data.single_room_clients
      bodyData+="<br>Shared Room Clients: "+data.shared_room_clients
      bodyData+="<br>Suite Room Clients: "+data.suite_room_clients
      bodyData+="<br>Total Clients: "+ data.total
      bodyData+="</div>";
      $("#cardData").html(bodyData);
      //$("#clientdiv").load(location.href + " #clientdiv");
    });
    }
    return false;
});
  });
</script>
{!! $chart->script() !!}
{!! $chart2->script() !!}
@endsection
