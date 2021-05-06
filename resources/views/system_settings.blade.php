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
          @elseif($category=='Research Flats only')
          <li><a href="{{ route('home6') }}"><i class="fas fa-home active"></i>Home</a></li>
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
<li class="active_nav_item"><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>


    <?php



    $today=date('Y-m-d');

    $date=date_create($today);

    date_sub($date,date_interval_create_from_date_string("732 days"));



    ?>


    <div class="main_content">
      <div class="container " style="max-width: 100%;">
        @if ($message = Session::get('success'))
          <div class="alert alert-success row col-xs-12" style="margin-left: -13px;
    margin-bottom: -1px;
    margin-top: 4px;">
            <p>{{$message}}</p>
          </div>
        @endif

          @if (session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
              <br>
            </div>
          @endif

<p class="mt-1" style="  font-size:30px !important;"> System Settings</p>
          <hr style="margin-bottom: 7px; border-bottom: 1px solid #e5e5e5 !important;">


          <div class="row">
<div class="col-12">
              <form method="post" action="{{ route('edit_system_changes')}}"  id="form1" >
                  {{csrf_field()}}

@foreach($system_settings as $var)

<h4 style="margin-top: 1.3%;">General</h4>
                  <div class="settings_group">

                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>System's default password</strong></label>
                              <input type="text"  style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->default_password}}" id="rent_price_guide_checkbox" name="default_password" required autocomplete="off">

                          </div>
                      </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">




                      <div class="group_children">
                      <div class="form-wrapper">
                          <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Financial year</strong></label>
                          <input type="text"  style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->financial_year}}" id="input_financial_year" name="financial_year" autocomplete="off" required>
                          <p style="display: none;" class="mt-2 p-1"  id="messageFinancialYear"></p>
                      </div>
                  </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">


                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>First semester start date</strong></label>
                              <input type="date" required style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->semester_one_start}}" id="rent_price_guide_checkbox" name="semester_one_start" min="{{date_format($date,"Y-m-d")}}" autocomplete="off">

                          </div>
                      </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">


                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>First semester end date</strong></label>
                              <input type="date" min="{{date_format($date,"Y-m-d")}}" required style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->semester_one_end}}" id="rent_price_guide_checkbox" name="semester_one_end" autocomplete="off">

                          </div>
                      </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">





                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Second semester start date</strong></label>
                              <input type="date" required style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->semester_two_start}}" id="rent_price_guide_checkbox" name="semester_two_start" min="{{date_format($date,"Y-m-d")}}" autocomplete="off">

                          </div>
                      </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">


                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Second semester end date</strong></label>
                              <input type="date" min="{{date_format($date,"Y-m-d")}}" required style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->semester_two_end}}" id="rent_price_guide_checkbox" name="semester_two_end" autocomplete="off">

                          </div>
                      </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">






                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Maximum number of days to pay invoice</strong></label>
                              <input type="number" min="1" max="90"  style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->max_no_of_days_to_pay_invoice}}" id="rent_price_guide_checkbox" name="max_no_of_days_to_pay_invoice" required autocomplete="off">

                          </div>
                      </div>

                  </div>


                  <h4 style="margin-top: 1.3%;">Insurance</h4>
                  <div class="settings_group">





{{--                      <div class="group_children">--}}
{{--                          <div class="form-wrapper">--}}
{{--                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Percentage used when generating invoice to principals</strong></label>--}}
{{--                              <input type="number" min="1" max="100" style="display: inline-block; float: right; clear: both;  text-align: center;" required value="{{($var->insurance_percentage)*100}}" id="rent_price_guide_checkbox" name="insurance_percentage" autocomplete="off">--}}

{{--                          </div>--}}
{{--                      </div>--}}

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">

                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Day in a month for the system to generate insurance invoices automatically</strong></label>
                              <input type="number" min="1"  max="31" style="display: inline-block; float: right; clear: both;   text-align: center;" required value="{{$var->day_for_insurance_invoice}}" id="rent_price_guide_checkbox" name="day_for_insurance_invoice" autocomplete="off">

                          </div>
                      </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">

                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Invoice start day(Day in a month)</strong></label>
                              <input type="number" min="1"  max="31" required style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->insurance_invoice_start_day}}" id="rent_price_guide_checkbox" name="insurance_invoice_start_day" autocomplete="off">

                          </div>
                      </div>
                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">

                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Invoice end day(Day in a month)</strong></label>
                              <input type="number" min="1"  max="31"  style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->insurance_invoice_end_day}}" id="rent_price_guide_checkbox" name="insurance_invoice_end_day" required autocomplete="off">
                          </div>
                      </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">

                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Insurance Companies</strong></label>
                              <a style="float: right;  " href="/insurance_companies">Change</a>

                          </div>
                      </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">

                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Insurance Classes</strong></label>
                              <a style="float: right;  " href="/insurance_classes">Change</a>

                          </div>
                      </div>





                  </div>

<br>

                  <h4>Real Estate</h4>
                  <div class="settings_group">


                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Days before the payment cycle ends for which the system will create space invoices automatically(For Direct clients)</strong></label>
                              <input type="number" min="1"  max="27"  style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->days_in_advance_for_invoices}}" id="rent_price_guide_checkbox" name="days_in_advance_for_invoices" required autocomplete="off">

                          </div>
                      </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">

                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Day in a month for the system to generate space invoices automatically(For Direct clients with sub-clients)</strong></label>
                              <input type="number" min="1"  max="31" style="display: inline-block; float: right; clear: both;   text-align: center;" required value="{{$var->day_to_send_space_invoice}}" id="rent_price_guide_checkbox" name="day_to_send_space_invoice" autocomplete="off">

                          </div>
                      </div>

                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">

                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Invoice start day(Day in a month)</strong></label>
                              <input type="number" min="1"  max="31" required style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->space_invoice_start_day}}"  name="space_invoice_start_day" autocomplete="off">

                          </div>
                      </div>
                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">

                      <div class="group_children">
                          <div class="form-wrapper">
                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Invoice end day(Day in a month)</strong></label>
                              <input type="number" min="1"  max="31"  style="display: inline-block; float: right; clear: both;  text-align: center;" value="{{$var->space_invoice_end_day}}"  name="space_invoice_end_day" required autocomplete="off">
                          </div>
                      </div>

{{--                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">--}}

{{--                      <div class="group_children">--}}
{{--                          <div class="form-wrapper">--}}
{{--                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Bills invoice start day</strong></label>--}}
{{--                              <input type="text"  style="display: inline-block; float: right; clear: both;  text-align: center;" value="1" id="rent_price_guide_checkbox" name="default_password" autocomplete="off">--}}

{{--                          </div>--}}
{{--                      </div>--}}

{{--                      <hr style="border:0; border-top: 1px solid rgba(0, 0, 0, 0.1); margin-bottom: 0 !important;">--}}

{{--                      <div class="group_children">--}}
{{--                          <div class="form-wrapper">--}}
{{--                              <label class="label_styles" for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Bills invoice end day</strong></label>--}}
{{--                              <input type="text"  style="display: inline-block; float: right; clear: both;  text-align: center;" value="20" id="rent_price_guide_checkbox" name="default_password" autocomplete="off">--}}

{{--                          </div>--}}
{{--                      </div>--}}

                  </div>


<br>

                  @endforeach
                  <div align="right">
                      <button class="btn btn-primary" id="save_btn" type="submit">Save changes</button>
                      <a href="/"  class="btn btn-danger" >Cancel</a>
                  </div>
              </form>
</div>

          </div>

    </div>
  </div>
</div>
</div>
@endsection

@section('pagescript')
<script>

    $(document).ready(function() {

    //Put our input DOM element into a jQuery Object
    var $input = jQuery('input[name="financial_year"]');

    //Bind keyup/keydown to the input
    $input.bind('keyup','keydown', function(e){

    //To accomdate for backspacing, we detect which key was pressed - if backspace, do nothing:
    if(e.which !== 8) {
    var value=$input.val();

    if(value.charAt(0)==0 ||value.charAt(0)==1){

    document.getElementById("messageFinancialYear").style.display ='block';
    document.getElementById("messageFinancialYear").style.backgroundColor ='#ccd8e263';
    document.getElementById("messageFinancialYear").style.color ='red';
    document.getElementById("messageFinancialYear").innerHTML ='Invalid input';
    document.getElementById("save_btn").disabled=true;


    }

    else{
        document.getElementById("messageFinancialYear").style.display ='none';
    document.getElementById("messageFinancialYear").innerHTML ='';
    document.getElementById("save_btn").disabled=false;
    document.getElementById("messageFinancialYear").style.backgroundColor ='';

    if(value.length===4){

    var year=document.getElementById('input_financial_year').value;

    var current_year=new Date().getFullYear();
    var diff;

    if (current_year > year) {
    diff=current_year-year;
    } else {
    diff=year-current_year;
    }

    if (diff===0 || diff===1 ){

    document.getElementById("input_financial_year").setAttribute("maxlength", "9");
    document.getElementById("input_financial_year").value =value+'/';
        document.getElementById("messageFinancialYear").style.display ='none';

    }else{
    document.getElementById("input_financial_year").setAttribute("maxlength", "4");
        document.getElementById("messageFinancialYear").style.display ='block';
    document.getElementById("messageFinancialYear").style.backgroundColor ='#ccd8e263';
    document.getElementById("messageFinancialYear").style.color ='red';
    document.getElementById("messageFinancialYear").innerHTML ='Invalid input';
    document.getElementById("save_btn").disabled=true;

    }

    // document.getElementById("input_financial_year").value =value+'/';
    }

    if(value.length<9){
    // document.getElementById("messageFinancialYear").style.backgroundColor ='#ccd8e263';
    // document.getElementById("messageFinancialYear").style.color ='red';
    // document.getElementById("messageFinancialYear").innerHTML ='Invalid input';
    document.getElementById("save_btn").disabled=true;

    }


    if(value.length===9){

    var value2=$input.val();
    var small=Number(value2.slice(0, 4));
    var big=Number(value2.slice(-4));
    var difference=big-small;


    if (difference===1){
        document.getElementById("messageFinancialYear").style.display ='none';
    document.getElementById("messageFinancialYear").innerHTML ='';
    document.getElementById("save_btn").disabled=false;
    document.getElementById("messageFinancialYear").style.backgroundColor ='';


    }
    else {
        document.getElementById("messageFinancialYear").style.display ='block';
    document.getElementById("messageFinancialYear").style.backgroundColor ='#ccd8e263';
    document.getElementById("messageFinancialYear").style.color ='red';
    document.getElementById("messageFinancialYear").innerHTML ='Invalid input';
    document.getElementById("save_btn").disabled=true;


    }

    }


    }




    }
    });


    });
</script>


{{--<script>--}}


{{--    $( ".days").datepicker({--}}
{{--        format: "dd",--}}

{{--        calendarWeeks: true,--}}
{{--        autoclose: true,--}}
{{--        todayHighlight: true,--}}
{{--        rtl: true,--}}
{{--        orientation: "auto"--}}
{{--    });--}}


{{--</script>--}}



@endsection
