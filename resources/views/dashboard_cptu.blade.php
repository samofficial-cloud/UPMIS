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
  <?php
  use App\space;
  use App\cost_centre;
  use App\carRental;
  use App\insurance;
  use App\carContract;
  $total_cars=carRental::where('flag','1')->count();
  $running_cars=carRental::where('flag','1')->where('vehicle_status','Running')->count();
  $minor_cars=carRental::where('flag','1')->where('vehicle_status','Minor Repair')->count();
  $grounded_cars=carRental::where('flag','1')->where('vehicle_status','Grounded')->count();
  $within=carContract::where('area_of_travel','Within')->whereYear('start_date',date('Y'))->where('form_completion','1')->count();
  $outside=carContract::where('area_of_travel','Outside')->whereYear('start_date',date('Y'))->where('form_completion','1')->count();
  $year= date('Y');
  ?>
    <br>

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
          <input type="submit" name="filter" value="Filter" id="activity_filter" class="btn btn-success">
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
      <h5 class="card-title">General Statistics <i class="fa fa-line-chart" style="font-size:30px; float: right; color: black;"></i></h5>
      Total Vehicles: {{$total_cars}}
      <br>Running Vehicles: {{$running_cars}}
      <br>Minor Repair Vehicles: {{$minor_cars}}
      <br>Grounded Vehicles: {{$grounded_cars}}
      <hr style="margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border: 1px solid #505559;">
    <div id="cardData">
      <h5>Clients Statistics {{date('Y')}}</h5>
      Within Dar es Salaam: {{$within}}
      <br>Outside Dar es Salaam: {{$outside}}
      <br>Total Clients: {{$within + $outside}}
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
    <a title="Send email to selected clients" href="#" id="notify_all" class="btn btn-info btn-sm" data-toggle="modal" data-target="#mail_all" role="button" style="
    padding: 10px;
    color: #fff;font-size: 16px;
    margin-bottom: 5px;
    display: none;
    margin-top: 4px;
    float: right;"><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #f8fafc; cursor: pointer;"></i> Mail</a>
        <div class="modal fade" id="mail_all" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content" style="width: 115%;">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('SendMessage2') }}" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="aia_client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="aia_client_names" name="client_name" class="form-control" value="" readonly="" hidden="">
            <p id="aia_par_names" style="display: block;border: 1px solid #ced4da;border-radius: 0.25rem;padding: 0.375rem 0.75rem;"></p>
          </div>
        </div>

        <div class="form-group row">
            <label for="aia_subject" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="aia_subject" name="subject" class="form-control" value="" required="">
          </div>
        </div>
         <br>

         <div class="form-group row">
            <label for="aia_greetings" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="aia_greetings" name="greetings" class="form-control" value="Dear " readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="aia_message" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="aia_message" name="message" class="form-control" value="" rows="7" required=""></textarea>
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
            <label for="aia_closing" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="aia_closing" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
 <input type="text" name="type" value="car" hidden="">
        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
     <table class="hover table table-striped table-bordered" id="myTable1">
  <thead class="thead-dark">
                            <tr>
                                <th scope="col"><center>S/N</center></th>
                                <th scope="col" >Debtor Name</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col" >Start Date</th>
                                <th scope="col" >End date</th>
                               {{--  <th scope="col" >Period</th> --}}
                                <th scope="col">Contract Id</th>
                                <th scope="col" >Amount</th>
                                {{-- <th scope="col" >GEPG Control No</th> --}}
                                <th scope="col" >Invoice Date</th>
                                <th scope="col" >Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $var)
                                <tr>
                                    <th scope="row" class="counterCell">.</th>
                                    <td>
                                      <?php $centre_name=cost_centre::select('costcentre')->where('costcentre_id',$var->cost_centre)->value('costcentre');?>
                                      <a title="View Client Details" class="link_style" style="color: blue !important; cursor: pointer;"  class="" data-toggle="modal" data-target="#clienta{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true">{{$var->debtor_name}}</a>
                                            <div class="modal fade" id="clienta{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Client Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%;">

                                                                <tr>
                                                                    <td style="width:30%;">Client Name:</td>
                                                                    <td>{{$var->fullName}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Cost Centre No:</td>
                                                                    <td>{{$var->cost_centre}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Cost Centre Name:</td>
                                                                    <td>{{$centre_name}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Email:</td>
                                                                    <td> {{$var->email}}</td>
                                                                </tr>

                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </td>
                                    <td><center>{{$var->invoice_number}}</center></td>

                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                    {{-- <td>{{$var->period}}</td> --}}
                                    <td>
                                      <a title="View contract" class="link_style" style="color: blue !important; cursor: pointer;"  class="" data-toggle="modal" data-target="#contracta{{$var->invoice_number}}" style="cursor: pointer;" aria-pressed="true"><center>{{$var->contract_id}}</center></a>
                                            <div class="modal fade" id="contracta{{$var->invoice_number}}" role="dialog">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <b><h5 class="modal-title">Contract Details.</h5></b>

                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <table style="width: 100%;">

                                                                <tr>
                                                                    <td style="width:30%;">Client Name:</td>
                                                                    <td>{{$var->fullName}}</td>
                                                                </tr>


                                                                <tr>
                                                                    <td>Destination</td>
                                                                    <td>{{$var->destination}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Vehicle Reg No:</td>
                                                                    <td> {{$var->vehicle_reg_no}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Start Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->start_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>End Date:</td>
                                                                    <td>{{date("d/m/Y",strtotime($var->end_date))}}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td> Purpose:</td>
                                                                    <td> {{$var->purpose}}</td>
                                                                </tr>

                                                            </table>
                                                            <br>
                                                            <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </td>
                                    <td>{{$var->currency_invoice}} {{number_format($var->amount_not_paid)}}</td>
                                  {{--  <td>{{$var->gepg_control_no}}</td> --}}
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                    <td>
                                      @if($var->email!="")
                                       <a title="Send Email to this Client" data-toggle="modal" data-target="#carmail{{$var->invoice_number}}" role="button" aria-pressed="true"><center><i class="fa fa-envelope" aria-hidden="true" style="font-size:20px; color: #3490dc; cursor: pointer;"></i></center></a>
      <div class="modal fade" id="carmail{{$var->invoice_number}}" role="dialog">
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
            <label for="carclient_names{{$var->invoice_number}}" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <input type="text" id="carclient_names{{$var->invoice_number}}" name="client_name" class="form-control" value="{{$var->fullName}}" readonly="">
          </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="carsubject{{$var->invoice_number}}" class="col-sm-2">Subject<span style="color: red;">*</span></label>
            <div class="col-sm-9">
            <input type="text" id="carsubject{{$var->invoice_number}}" name="subject" class="form-control" value="" >
          </div>
        </div>
         <br>
         <div class="form-group row">
            <label for="cargreetings{{$var->invoice_number}}" class="col-sm-2">Salutation</label>
            <div class="col-sm-9">
            <input type="text" id="cargreetings{{$var->invoice_number}}" name="greetings" class="form-control" value="Dear {{$var->fullName}}," readonly="">
          </div>
        </div>
         <br>

        <div class="form-group row">
            <label for="carmessage{{$var->invoice_number}}" class="col-sm-2">Message<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <textarea type="text" id="carmessage{{$var->invoice_number}}" name="message" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="carattachment{{$var->invoice_number}}" class="col-sm-2">Attachments</label>
           <div class="col-sm-9">
              <input type="file" id="carattachment{{$var->invoice_number}}" name="filenames[]" class="myfrm form-control" multiple="">
              <center><span style="font-size: 11px; color: #69b88c;margin-bottom: -1rem;">(Attachments should be less than 30MB)</span></center>
          </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="carclosing{{$var->invoice_number}}" class="col-sm-2">Closing</label>
            <div class="col-sm-9">
            <input type="text" id="carclosing{{$var->invoice_number}}" name="closing" class="form-control" value="Regards, Directorate of Planning, Development and Investment, UDSM." readonly="">
          </div>
        </div>
        <br>
        <input type="text" name="type" value="car" hidden="">

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
    dom: '<"top"l>rt<"bottom"pi>'
  } );

  var table2 = $('#myTable1').DataTable();

    $('#myTable1 tbody').on( 'click', 'tr', function () {
      document.getElementById("aia_par_names").innerHTML=" ";
      document.getElementById("aia_greetings").value="Dear ";
      var email0 = $(this).find('td:eq(8)').text();
       if(email0==" "){

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
      document.getElementById("aia_par_names").innerHTML=" ";
      document.getElementById("aia_greetings").value="Dear ";
        var datas6 = table2.rows('.selected').data();
        var result6 = [];
        for (var i = 0; i < datas6.length; i++)
        {
                result6.push(datas6[i][1].split('"true">').pop().split('</a>')[0]);
        }

        $('#aia_client_names').val(result6).toString();

        var content6 = document.getElementById("aia_par_names");
        for(var i=0; i< result6.length;i++){
          if(i==(result6.length-1)){
            content6.innerHTML += result6[i]+ '.';
          }
          else{
            content6.innerHTML += result6[i] + ', ';
          }

        }

        var salutation6 = document.getElementById("aia_greetings");
        for(var i=0; i< result6.length;i++){
          if(i==(result6.length-1)){
            salutation6.value += result6[i]+ '.';
          }
          else{
            salutation6.value += result6[i] + ', ';
          }

        }
         //console.log(result);
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
      url: "/home9/activity_filter?",
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
      {{ $chart2->id }}.update();
      var bodyData0 = '';
      var bodyData = '';
      console.log(query);
      bodyData= "<div>"
      bodyData+="<h5 class='card-title'>Client Statistics "
      bodyData+=query+"</h5>"
      bodyData+="Within Dar es Salaam: "+data.within
      bodyData+="<br>Outside Dar es Salaam: "+data.outside
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
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script> --}}
        {!! $chart->script() !!}
         {!! $chart2->script() !!}
         {{-- {!! $chart3->script() !!}
         {!! $chart4->script() !!}
          {!! $chart5->script() !!}
           {!! $chart6->script() !!} --}}
@endsection
