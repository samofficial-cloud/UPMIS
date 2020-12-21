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

  #t_id tr td{
    border: 1px solid black;
    background-color: #f1e7c1;
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
            $year= date('Y');
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
  ?>
    <br>

    <div class="container">
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
       <div class="card-body">
    <b><h3>Cost Centre Details</h3></b>
    <hr>
    <table style="font-size: 18px;width: 75%" id="t_id">
      <tr>
        <td style="width: 27%;">Cost Centre No</td>
        <td>{{$centre}}</td>
      </tr>
      <tr>
        <td>Department/Faculty/Unit</td>
        <td>{{$centre_name}}</td>
      </tr>
    </table>
  </div>
  </div>
  <br>
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

        <div class="card-deck" style="font-size: 15px; font-family: sans-serif;">

          <div class="card border-success">
     {!! $chart->container() !!}
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
     <h3 class="card-title" style="font-family: sans-serif;">Unpaid Invoice(s)</h3>
     <hr>
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
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($unpaid as $var)
                                <tr>
                                    <th scope="row" class="counterCell">.</th>
                                    <td>{{$var->debtor_name}}</td>
                                    <td><center>{{$var->invoice_number}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
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
                                    <td>{{$var->currency_invoice}} {{number_format($var->amount_to_be_paid)}}</td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>

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
   $(document).ready(function(){
  var table = $('#myTable').DataTable( {
    dom: '<"top"l>rt<"bottom"pi>'
  } );

  var table1 = $('#myTable1').DataTable( {
    dom: '<"top"l>rt<"bottom"pi>'
  } );

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
      url: "/home23/activity_filter?",
      context: document.body,
      async : false,
      data:{year:query}
      })
    .done(function(data) {
      {{$chart->id}}.options.title.text = 'Rental Activities '+query;
      {{ $chart->id }}.data.datasets[0].data =data.activity;
      {{ $chart->id }}.update(); 

      {{$chart2->id}}.options.title.text = 'Amount Paid to CPTU '+query;
      {{ $chart2->id }}.data.datasets[0].data =data.income;
      {{ $chart2->id }}.update();
      //$("#clientdiv").load(location.href + " #clientdiv");
    });
    }  
    return false;

});
  } );
</script>

        {!! $chart->script() !!}
         {!! $chart2->script() !!}
   @endsection
