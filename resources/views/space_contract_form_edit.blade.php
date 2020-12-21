@extends('layouts.app')

@section('style')
<style type="text/css">
	* {
    margin: 0;
    padding: 0
}

html {
    height: 100%
}

#grad1 {
    background-color: : #9C27B0;
    /*background-image: linear-gradient(120deg, #FF4081, #81D4FA)*/
}

#msform {
    text-align: center;
    position: relative;
    margin-top: 20px
}

#msform fieldset .form-card {
    background: white;
    border: 0 none;
    border-radius: 0px;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    padding: 20px 40px 30px 40px;
    box-sizing: border-box;
    width: 94%;
    margin: 0 3% 20px 3%;
    position: relative
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative
}

#msform fieldset:not(:first-of-type) {
    display: none
}

#msform fieldset .form-card {
    text-align: left;
    color: #9E9E9E
}

#msform input,
#msform textarea {
    padding: 0px 8px 4px 8px;
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    /*font-family: montserrat;*/
    color: #2C3E50;
    font-size: 16px;
    letter-spacing: 1px
}

#msform input:focus,
#msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: none;
    font-weight: bold;
    border-bottom: 2px solid skyblue;
    outline-width: 0
}

#msform .action-button {
    width: 150px;
    background: skyblue;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px
}

#msform .action-button:hover,
#msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
}

#msform .action-button-previous {
    width: 150px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px
}

#msform .action-button-previous:hover,
#msform .action-button-previous:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
}

select.list-dt {
    border: none;
    outline: 0;
    border-bottom: 1px solid #ccc;
    padding: 2px 5px 3px 5px;
    margin: 2px
}

select.list-dt:focus {
    border-bottom: 2px solid skyblue
}

.card {
    z-index: 0;
    border: none;
    border-radius: 0.5rem;
    position: relative
}

.fs-title {
    font-size: 25px;
    color: #2C3E50;
    margin-bottom: 10px;
    font-weight: bold;
    text-align: left
}

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey;
    margin-left: 0%;
}

#progressbar .active {
    color: #000000
}

#progressbar li {
    list-style-type: none;
    font-size: 12px;
    width: 25%;
    float: left;
    position: relative
}

#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f04d"
}

#progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f007"
}

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f09d"
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f00c"
}

#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 18px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: skyblue
}

.radio-group {
    position: relative;
    margin-bottom: 25px
}

.radio {
    display: inline-block;
    width: 204;
    height: 104;
    border-radius: 0;
    background: lightblue;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    cursor: pointer;
    margin: 8px 2px
}

.radio:hover {
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3)
}

.radio.selected {
    box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1)
}

.fit-image {
    width: 100%;
    object-fit: cover
}
</style>
@endsection

@section('content')
<?php
$today=date('Y-m-d');
?>
<!-- MultiStep Form -->
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
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-12 col-sm-9 col-md-7 col-lg-9 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Renting Space Contract Information</strong></h2>
                <p>Fill all form fields with (*) to go to the next step</p>
                <div class="row">
                    <div class="col-md-12 mx-0">

                        <form id="msform" METHOD="GET" action="{{ route('edit_space_contract_final',['contract_id'=>$contract_id,'client_id'=>$client_id])}}">

                            <!-- progressbar -->
                            <ul id="progressbar">
                            	<li class="active" id="personal"><strong>Client</strong></li>
                                <li  id="account"><strong>Renting Space</strong></li>
                                <li id="payment"><strong>Payment</strong></li>
                                <li id="confirm"><strong>Confirm</strong></li>
                            </ul>
                             <!-- fieldsets -->
                            <fieldset>
                                @foreach ($contract_data as $var)


                                <div class="form-card">
                                   <h2 class="fs-title">Client Information</h2> <div class="form-group">
					<div class="form-wrapper" id="clientdiv">
          <label for="client_type">Client Type*</label>
          <span id="ctypemsg"></span>
            <select class="form-control"  id="client_type" name="client_type">

              <option value="1">Individual</option>
              <option value="2">Company/Organization</option>
                @if($var->type=="Individual")
                    <option value="1" selected>{{$var->type}}</option>
                @else
                    <option value="2" selected>{{$var->type}}</option>
                @endif

            </select>

        </div>
    </div>

        <div class="form-group row" id="namediv" style="display: none;">
						<div class="form-wrapper col-6">
							<label for="first_name">First Name <span style="color: red;"> *</span></label>
                            <span id="name1msg"></span>
							<input type="text" required id="first_name" value="{{$var->first_name}}" name="first_name" class="form-control"  onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
						</div>
						<div class="form-wrapper col-6">
							<label for="last_name">Last Name <span style="color: red;"> *</span></label>
                            <span id="name2msg"></span>
							<input type="text" id="last_name" required value="{{$var->last_name}}" name="last_name" class="form-control"  onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
						</div>
					</div>

					<div class="form-group" id="companydiv" style="display: none;">
					<div class="form-wrapper">
						<label for="company_name">Company Name <span style="color: red;"> *</span></label>
                        <span id="cnamemsg"></span>
						<input type="text" id="company_name" required name="company_name" value="{{$var->first_name}}" class="form-control">
					</div>
				</div>

    <div class="form-group">
					<div class="form-wrapper">
						<label for="email">Email <span style="color: red;"> *</span></label>
						<input type="text" required name="email" value="{{$var->email}}" id="email" class="form-control" placeholder="someone@example.com" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="phone_number">Phone Number <span style="color: red;"> *</span></label>
                        <span id="phone_msg"></span>
                        <input type="text" id="phone_number" required name="phone_number" value="{{$var->phone_number}}" class="form-control" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="address">Address <span style="color: red;"> *</span></label>
						<input type="text" required id="address" name="address" value="{{$var->address}}" class="form-control">
					</div>
				</div>
                                </div>
 <input type="button" name="next" id="next1" class="next action-button" value="Next Step" />
                                    <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a>
                            </fieldset>
                            {{-- Second Form --}}
                            <fieldset>
                                <div class="form-card">
                                  <h2 class="fs-title">Renting Space Information</h2>




                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="major_industry"  ><strong>Major industry</strong></label>
                                            <input type="text" class="form-control" id="getMajor" name="major_industry" value="{{$var->major_industry}}" readonly  autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for=""  ><strong>Minor industry</strong></label>
                                            <input type="text" class="form-control" id="minor_list" name="minor_industry" value="{{$var->minor_industry}}" readonly  autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="space_location"  ><strong>Location</strong></label>
                                            <input type="text" class="form-control" id="space_location" name="space_location" value="{{$var->location}}" readonly  autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="space_location"  ><strong>Sub location</strong></label>
                                            <input type="text" readonly class="form-control" id="space_sub_location" name="space_sub_location" value="{{$var->sub_location}}"  autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="" ><strong>Space Number</strong></label>
                                            <input type="text" class="form-control" id="space_id_contract" name="space_id_contract" value="{{$var->space_id}}" readonly Required autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for=""  ><strong>Size (SQM) <span style="color: red;"></span></strong></label>
                                            <input type="number" min="1" step="0.01" class="form-control" id="space_size" name="space_size" value="{{$var->size}}" readonly autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="has_water_bill"  ><strong>Required to also pay Water bill</strong></label>
                                            <input type="text" readonly class="form-control" id="has_water_bill" name="has_water_bill" value="{{$var->has_water_bill_space}}"  autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="has_electricity_bill"  ><strong>Required to also pay Electricity bill</strong></label>
                                            <input type="text" readonly class="form-control" id="has_electricity_bill" name="has_electricity_bill" value="{{$var->has_electricity_bill_space}}"  autocomplete="off">
                                        </div>
                                    </div>





                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="button" id="next2" name="next" class="next action-button" value="Next Step" />
                                <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a>
                            </fieldset>
                            {{-- Third Form --}}
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Payment Information</h2>



                                    <div class="form-group row">
                                        <div class="form-wrapper col-12">
                                            <label for="start_date">Start Date <span style="color: red;"> *</span></label>
                                            <input type="date" id="start_date"  name="start_date" value="{{$var->start_date}}" class="form-control" required="" min="{{$var->start_date}}">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="duration">Duration <span style="color: red;"> *</span></label>
                                            <input type="number"  min="1" max="50"  id="duration" name="duration" value="{{$var->duration}}" class="form-control" required="" >
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="currency">Period <span style="color: red;"> *</span></label>
                                            <select id="duration_period" class="form-control" name="duration_period"  required>
                                               @if($var->duration_period=="Months")
                                                    <option value="Years" >Years</option>
                                                    <option value="{{$var->duration_period}}" selected>{{$var->duration_period}}</option>
                                                @elseif($var->duration_period=="Years")
                                                <option value="Months" >Months</option>
                                                <option value="{{$var->duration_period}}" selected>{{$var->duration_period}}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

					<div class="form-group row">

                        <div class="form-wrapper col-12">
                            <label for="currency">Depend on academic year <span style="color: red;"> *</span></label>
                            <select id="academic_dependence" class="form-control" name="academic_dependence" required>
                                @if($var->academic_dependence=='Yes')
                                <option value="No" >No</option>
                                <option value="{{$var->academic_dependence}}" selected>{{$var->academic_dependence}}</option>
                                @elseif($var->academic_dependence=='No')
                                    <option value="{{$var->academic_dependence}}" selected>{{$var->academic_dependence}}</option>
                                <option value="Yes" >Yes</option>
                                    @else
                                    <option value="" ></option>
                                    <option value="No" >No</option>
                                    <option value="Yes" >Yes</option>

                                @endif
                            </select>
                        </div>


                        <div id="academicDiv" style="display: none" class="form-wrapper pt-4 col-6">
                            <label for="amount">Amount(Academic season) <span style="color: red;"> *</span></label>
                            <input type="number" min="20" id="academic_season" value="{{$var->academic_season}}" name="academic_season" class="form-control" >
                        </div>


                        <div id="vacationDiv" style="display: none" class="form-wrapper pt-4 col-6">
                            <label for="amount">Amount(Vacation season) <span style="color: red;"> *</span></label>
                            <input type="number" min="20" id="vacation_season" value="{{$var->vacation_season}}" name="vacation_season" class="form-control" >
                        </div>

                        <div id="amountDiv" style="display: none" class="form-wrapper pt-4 col-12">
                            <label for="amount">Amount <span style="color: red;"> *</span></label>
                            <input type="number" min="20" id="amount" name="amount" value="{{$var->amount}}" class="form-control" >
                        </div>


                        <div id="rent_sqmDiv"  class="form-wrapper pt-4 col-12">
                            <label for="rent_sqm">Rent/SQM <span >(Leave empty if not applicable)</span></label>
                            <input type="number" min="1" id="rent_sqm" name="rent_sqm" value="{{$var->rent_sqm}}"  class="form-control">
                        </div>


                        <div class="form-wrapper col-12">
                            <label for="currency">Currency <span style="color: red;"> *</span></label>
                            <select id="currency" class="form-control" name="currency" required>

                                @if($var->currency=="TZS")
                                    <option value="USD" >USD</option>
                                    <option value="{{$var->currency}}" selected >{{$var->currency}}</option>
                                @elseif($var->currency=="USD")
                                <option value="TZS" >TZS</option>
                                <option value="{{$var->currency}}" selected >{{$var->currency}}</option>

                                    @else
                                    @endif
                            </select>
                        </div>



				</div>

                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="payment_cycle">Payment cycle <span style="color: red;"> *</span></label>
                                            <select id="payment_cycle" class="form-control" name="payment_cycle" required>
                                                <?php
                                                $payment_cycles=DB::table('payment_cycle_settings')->get();
                                                ?>

                                                <option value="{{$var->payment_cycle}}" selected>{{$var->payment_cycle}}</option>

                                                    @foreach($payment_cycles as $payment_cycle)
                                                        @if($payment_cycle->cycle!=$var->payment_cycle)
                                                    <option value="{{$payment_cycle->cycle}}" >{{$payment_cycle->cycle}}</option>
                                                        @else
                                                        @endif
                                                    @endforeach



                                            </select>
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="escalation_rate">Escalation Rate <span style="color: red;"> *</span></label>
                                            <input type="number" min="0" id="escalation_rate" name="escalation_rate" value="{{$var->escalation_rate}}" class="form-control" required>
                                        </div>


                                    </div>


                                    @endforeach
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="button" name="next" id="next3" class="next action-button" value="Next" />
                                <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a>
                            </fieldset>




                            <fieldset>
                                <div class="form-card">
                                    <h2 style="text-align: center !important;" class="fs-title">Full contract details</h2>
                                    <table class="table table-bordered table-striped" style="width: 100%; margin-top:3%;">



                                        <tr>
                                            <td>Client type</td>
                                            <td id="client_type_confirm"></td>
                                        </tr>


                                        <tr id="first_name_row_confirm" style="display: none;">
                                            <td>First name:</td>
                                            <td id="first_name_confirm"></td>
                                        </tr>


                                        <tr id="last_name_row_confirm" style="display: none;">
                                            <td>Last name:</td>
                                            <td id="last_name_confirm"></td>
                                        </tr>


                                        <tr id="company_name_row_confirm" style="display: none;">
                                            <td>Company name:</td>
                                            <td id="company_name_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td> Email:</td>
                                            <td id="email_confirm"> </td>
                                        </tr>

                                        <tr>
                                            <td> Phone number:</td>
                                            <td id="phone_number_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td> Address:</td>
                                            <td id="address_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td> Major industry:</td>
                                            <td id="major_industry_confirm"></td>
                                        </tr>


                                        <tr>
                                            <td> Minor industry:</td>
                                            <td id="minor_industry_confirm"></td>
                                        </tr>


                                        <tr>
                                            <td> Location:</td>
                                            <td id="location_confirm"></td>
                                        </tr>


                                        <tr>
                                            <td>Sub location:</td>
                                            <td id="sub_location_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td>Space number:</td>
                                            <td id="space_number_confirm"></td>
                                        </tr>



                                        <tr>
                                            <td>Space size(SQM):</td>
                                            <td id="space_size_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td>Has electricity bill:</td>
                                            <td id="has_electricity_bill_confirm"></td>
                                        </tr>


                                        <tr>
                                            <td>Has water bill:</td>
                                            <td id="has_water_bill_confirm"></td>
                                        </tr>


                                        <tr>
                                            <td>Start date:</td>
                                            <td id="start_date_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td>Duration:</td>
                                            <td id="duration_confirm"></td>
                                        </tr>



                                        <tr>
                                            <td>Depend on academic year:</td>
                                            <td id="academic_dependance_confirm"></td>
                                        </tr>


                                        <tr id="amount_academic_row_confirm" style="display: none;" >
                                            <td>Amount(Academic season):</td>
                                            <td id="amount_academic_confirm"></td>
                                        </tr>

                                        <tr id="amount_vacation_row_confirm" style="display: none;">
                                            <td>Amount(Vacation season):</td>
                                            <td id="amount_vacation_confirm"></td>
                                        </tr>

                                        <tr id="amount_row_confirm" style="display: none;">
                                            <td>Amount:</td>
                                            <td id="amount_confirm"></td>
                                        </tr>


                                        <tr >
                                            <td>Rent/SQM:</td>
                                            <td id="rent_sqm_confirm"></td>
                                        </tr>



                                        <tr>
                                            <td>Payment cycle:</td>
                                            <td id="payment_cycle_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td>Escalation Rate:</td>
                                            <td id="escalation_rate_confirm"></td>
                                        </tr>





                                    </table>


                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="submit" name="submit" class="submit action-button" value="Save"/>
                                <input type="submit" name="submit" class="submit action-button" value="Save and print"/>
                                <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a>
                            </fieldset>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection

@section('pagescript')
    <?php
    $academic_dependence='';
    foreach($contract_data as $var)
    {

        $academic_dependence=$var->academic_dependence;

    }

    ?>
    <script type="text/javascript">
        window.onload=function(){
            document.getElementById("client_type").click();



            var academic_dependence={!! json_encode($academic_dependence) !!};

            if (academic_dependence=='Yes') {

                $('#academicDiv').show();
                document.getElementById("academic_season").disabled = false;
                var ele = document.getElementById("academic_season");
                ele.required = true;


                $('#vacationDiv').show();
                document.getElementById("vacation_season").disabled = false;
                var ele = document.getElementById("vacation_season");
                ele.required = true;


                $('#amountDiv').hide();
                // $('#amount').val("");
                document.getElementById("amount").innerHTML = '';
                document.getElementById("amount").disabled = true;
                var ele = document.getElementById("amount");
                ele.required = false;

            }else if(academic_dependence=='No'){

                $('#academicDiv').hide();
                // $('#academic_season').val("");
                document.getElementById("academic_season").innerHTML = '';
                document.getElementById("academic_season").disabled = true;
                var ele = document.getElementById("academic_season");
                ele.required = false;

                $('#vacationDiv').hide();
                // $('#vacation_season').val("");
                document.getElementById("vacation_season").innerHTML = '';
                document.getElementById("vacation_season").disabled = true;
                var ele = document.getElementById("vacation_season");
                ele.required = false;


                $('#amountDiv').show();
                document.getElementById("amount").disabled = false;
                var ele = document.getElementById("amount");
                ele.required = true;


            }else{


            }


        };
    </script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#academic_dependence').click(function() {
                var query=$(this).val();
                if(query=='Yes') {

                    $('#academicDiv').show();
                    document.getElementById("academic_season").disabled = false;
                    var ele = document.getElementById("academic_season");
                    ele.required = true;


                    $('#vacationDiv').show();
                    document.getElementById("vacation_season").disabled = false;
                    var ele = document.getElementById("vacation_season");
                    ele.required = true;


                    $('#amountDiv').hide();
                    document.getElementById("amount").disabled = true;
                    var ele = document.getElementById("amount");
                    ele.required = false;



                }else if(query=='No'){

                    $('#academicDiv').hide();
                    document.getElementById("academic_season").disabled = true;
                    var ele = document.getElementById("academic_season");
                    ele.required = false;

                    $('#vacationDiv').hide();
                    document.getElementById("vacation_season").disabled = true;
                    var ele = document.getElementById("vacation_season");
                    ele.required = false;

                    $('#amountDiv').show();
                    document.getElementById("amount").disabled = false;
                    var ele = document.getElementById("amount");
                    ele.required = true;

                }else{
                    $('#vacationDiv').hide();
                    $('#academicDiv').hide();
                    $('#amountDiv').hide();

                }



            });





            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;
            var p1, p2;
            $("#next1").click(function(){
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                var clientType=$("#client_type").val(),
                    firstName=$("#first_name").val(),
                    lastName=$("#last_name").val(),
                    companyName=$("#company_name").val();

                if(clientType=="1"){
                    $('#ctypemsg').hide();
                    $('#client_type').attr('style','border: 1px solid #ccc');
                    if(firstName==""){
                        p1=0;
                        $('#name1msg').show();
                        var message=document.getElementById('name1msg');
                        message.style.color='red';
                        message.innerHTML="Required";
                        $('#first_name').attr('style','border-bottom:1px solid #f00');
                    }
                    else{
                        p1=1;
                        $('#name1msg').hide();
                        $('#first_name').attr('style','border-bottom: 1px solid #ccc');

                    }

                    if(lastName==""){
                        p2=0;
                        $('#name2msg').show();
                        var message=document.getElementById('name2msg');
                        message.style.color='red';
                        message.innerHTML="Required";
                        $('#last_name').attr('style','border-bottom:1px solid #f00');
                    }

                    else{
                        p2=1;
                        $('#name2msg').hide();
                        $('#last_name').attr('style','border-bottom: 1px solid #ccc');

                    }


                }

                else if(clientType=="2"){
                    $('#ctypemsg').hide();
                    $('#client_type').attr('style','border: 1px solid #ccc');
                    if(companyName==""){
                        $('#cnamemsg').show();
                        var message=document.getElementById('cnamemsg');
                        message.style.color='red';
                        message.innerHTML="Required";
                        $('#company_name').attr('style','border-bottom:1px solid #f00');
                    }
                    else{
                        p1=1;
                        p2=1;
                        $('#cnamemsg').hide();
                        $('#company_name').attr('style','border-bottom: 1px solid #ccc');

                    }
                }

                else{
                    $('#ctypemsg').show();
                    var message=document.getElementById('ctypemsg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#client_type').attr('style','border:1px solid #f00');


                }
                var phone_digits=$('#phone_number').val().length;

                if(phone_digits<10) {
                    p2=0;
                    $('#phone_msg').show();
                    var message = document.getElementById('phone_msg');
                    message.style.color = 'red';
                    message.innerHTML = "Digits cannot be less than 10";
                    $('#phone_number').attr('style', 'border-bottom:1px solid #f00');

                }else{
                    $('#phone_msg').hide();
                    $('#phone_number').attr('style','border-bottom: 1px solid #ccc');
                }


                if(p1=='1' & p2=='1'){
                    gonext();
                }



            });

            $("#next2").click(function(){
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                gonext();

            });


            $("#next3").click(function(){
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

                var first_name=document.getElementById('first_name').value;
                var last_name=document.getElementById('last_name').value;
                var company_name=document.getElementById('company_name').value;
                var client_type=document.getElementById('client_type').value;
                var email=$("#email").val();
                var phone_number=document.getElementById('phone_number').value;
                var address=document.getElementById('address').value;
                var sub_location = $('#space_sub_location').val();
                var location = $('#space_location').val();
                var minor = $('#minor_list').val();
                var major = $('#getMajor').val();
                var space_id = $('#space_id_contract').val();






                var start_date=document.getElementById('start_date').value;
                var duration=document.getElementById('duration').value;
                var duration_period=document.getElementById('duration_period').value;

                var academic_dependence=document.getElementById('academic_dependence').value;
                var vacation_season=document.getElementById('vacation_season').value;
                var academic_season=document.getElementById('academic_season').value;
                var amount=document.getElementById('amount').value;
                var rent_sqm=document.getElementById('rent_sqm').value;
                var currency=document.getElementById('currency').value;
                var payment_cycle=document.getElementById('payment_cycle').value;
                var escalation_rate=document.getElementById('escalation_rate').value;
                var space_size=document.getElementById('space_size').value;
                var has_water_bill=document.getElementById('has_water_bill').value;
                var has_electricity_bill=document.getElementById('has_electricity_bill').value;


                const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"];
                const dateObj = new Date(start_date);
                const month = dateObj.getMonth()+1;
                const day = String(dateObj.getDate()).padStart(2, '0');
                const year = dateObj.getFullYear();
                const output = day  + '/'+ month  + '/' + year;


                function thousands_separators(num)
                {
                    var num_parts = num.toString().split(".");
                    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    return num_parts.join(".");
                }



                // document.getElementById("client").innerHTML ='';






                $("#first_name_confirm").html(first_name);
                $("#first_name_confirm").css('font-weight', 'bold');

                $("#last_name_confirm").html(last_name);
                $("#last_name_confirm").css('font-weight', 'bold');



                $("#company_name_confirm").html(company_name);
                $("#company_name_confirm").css('font-weight', 'bold');


                $("#email_confirm").html(email);
                $("#email_confirm").css('font-weight', 'bold');

                $("#phone_number_confirm").html(phone_number);
                $("#phone_number_confirm").css('font-weight', 'bold');


                $("#address_confirm").html(address);
                $("#address_confirm").css('font-weight', 'bold');

                $("#major_industry_confirm").html(major);
                $("#major_industry_confirm").css('font-weight', 'bold');

                $("#minor_industry_confirm").html(minor);
                $("#minor_industry_confirm").css('font-weight', 'bold');


                $("#location_confirm").html(location);
                $("#location_confirm").css('font-weight', 'bold');

                $("#sub_location_confirm").html(sub_location);
                $("#sub_location_confirm").css('font-weight', 'bold');


                $("#space_number_confirm").html(space_id);
                $("#space_number_confirm").css('font-weight', 'bold');

                $("#space_size_confirm").html(space_size);
                $("#space_size_confirm").css('font-weight', 'bold');


                $("#has_electricity_bill_confirm").html(has_electricity_bill);
                $("#has_electricity_bill_confirm").css('font-weight', 'bold');


                $("#has_water_bill_confirm").html(has_water_bill);
                $("#has_water_bill_confirm").css('font-weight', 'bold');




                $("#start_date_confirm").html(output);
                $("#start_date_confirm").css('font-weight', 'bold');


                $("#duration_confirm").html(duration+" "+duration_period);
                $("#duration_confirm").css('font-weight', 'bold');

                $("#academic_dependance_confirm").html(academic_dependence);
                $("#academic_dependance_confirm").css('font-weight', 'bold');


                $("#amount_academic_confirm").html(thousands_separators(academic_season)+" "+currency);
                $("#amount_academic_confirm").css('font-weight', 'bold');


                $("#amount_vacation_confirm").html(thousands_separators(vacation_season)+" "+currency);
                $("#amount_vacation_confirm").css('font-weight', 'bold');

                $("#amount_confirm").html(thousands_separators(amount)+" "+currency);
                $("#amount_confirm").css('font-weight', 'bold');

                if(rent_sqm==''){

                    $("#rent_sqm_confirm").html('N/A');
                    $("#rent_sqm_confirm").css('font-weight', 'bold');


                }else{

                    $("#rent_sqm_confirm").html(thousands_separators(rent_sqm)+" "+currency);
                    $("#rent_sqm_confirm").css('font-weight', 'bold');


                }



                $("#payment_cycle_confirm").html(payment_cycle);
                $("#payment_cycle_confirm").css('font-weight', 'bold');


                $("#escalation_rate_confirm").html(escalation_rate);
                $("#escalation_rate_confirm").css('font-weight', 'bold');



                if(client_type=='1'){

                    $("#client_type_confirm").html("Individual");
                    $("#client_type_confirm").css('font-weight', 'bold');


                    $("#first_name_row_confirm").show();
                    $("#last_name_row_confirm").show();
                    $("#company_name_row_confirm").hide();


                }else if(client_type=='2'){

                    $("#client_type_confirm").html("Company");
                    $("#client_type_confirm").css('font-weight', 'bold');

                    $("#first_name_row_confirm").hide();
                    $("#last_name_row_confirm").hide();
                    $("#company_name_row_confirm").show();

                }else{

                    $("#first_name_row_confirm").hide();
                    $("#last_name_row_confirm").hide();
                    $("#company_name_row_confirm").hide();

                }


                if(academic_dependence=='Yes'){

                    $("#amount_academic_row_confirm").show();
                    $("#amount_vacation_row_confirm").show();
                    $("#amount_row_confirm").hide();

                }else if(academic_dependence=='No'){

                    $("#amount_academic_row_confirm").hide();
                    $("#amount_vacation_row_confirm").hide();
                    $("#amount_row_confirm").show();

                }else{
                    $("#amount_academic_row_confirm").hide();
                    $("#amount_vacation_row_confirm").hide();
                    $("#amount_row_confirm").hide();
                }




                gonext();


            });




            function gonext(){
                console.log(3);


//Add Class Active
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
                next_fs.show();
//hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function(now) {
// for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({'opacity': opacity});
                    },
                    duration: 600
                });
            }

// $(".next").click(function(){

// current_fs = $(this).parent();
// next_fs = $(this).parent().next();

// //Add Class Active
// $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

// //show the next fieldset
// next_fs.show();
// //hide the current fieldset with style
// current_fs.animate({opacity: 0}, {
// step: function(now) {
// // for making fielset appear animation
// opacity = 1 - now;

// current_fs.css({
// 'display': 'none',
// 'position': 'relative'
// });
// next_fs.css({'opacity': opacity});
// },
// duration: 600
// });
// });

            $(".previous").click(function(){

                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

//Remove class active
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
                previous_fs.show();

//hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function(now) {
// for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        previous_fs.css({'opacity': opacity});
                    },
                    duration: 600
                });
            });

            $(".submit").click(function(){
                console.log(2);
                return true;
            })

        });
    </script>

<script type="text/javascript">
	$(document).ready(function() {
    $('#client_type').click(function(){
       var query = $(this).val();
       if(query=='1'){
        $('#namediv').show();
        $('#companydiv').hide();
        $('#company_name').val("");
           var ele4 = document.getElementById("company_name");
           ele4.required = false;

           var ele5 = document.getElementById("first_name");
           ele5.required = true;

           var ele6 = document.getElementById("last_name");
           ele6.required = true;


       }
       else if(query=='2'){
        $('#companydiv').show();
        $('#namediv').hide();
        $('#first_name').val("");
        $('#last_name').val("");
           var ele4 = document.getElementById("company_name");
           ele4.required = true;

           var ele5 = document.getElementById("first_name");
           ele5.required = false;

           var ele6 = document.getElementById("last_name");
           ele6.required = false;


       }
       else{
        $('#namediv').hide();
        $('#companydiv').hide();
        $('#first_name').val("");
        $('#last_name').val("");
        $('#company_name').val("");
       }

      });
    });
</script>

    <script>
        $( document ).ready(function() {


            $('#space_id_contract').keyup(function(e){
                e.preventDefault();
                var query = $(this).val();



                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();




                    $.ajax({
                        url:"{{ route('space_id_suggestions') }}",
                        method:"GET",
                        data:{query:query,_token:_token},
                        success:function(data){
                            if(data=='0'){
                                $('#space_id_contract').attr('style','border:1px solid #f00');

                            }
                            else{

                                $('#space_id_contract').attr('style','border:1px solid #ced4da');
                                $('#nameListSpaceId').fadeIn();
                                $('#nameListSpaceId').html(data);
                            }
                        }
                    });
                }
                else if(query==''){

                    $('#space_id_contract').attr('style','border:1px solid #ced4da');
                    $('#nameListSpaceId').fadeOut();
                }
            });

            $(document).on('click', '#listSpacePerTypeLocation', function(){


                $('#space_id_contract').attr('style','border:1px solid #ced4da');

                $('#space_id_contract').val($(this).text());



                $('#nameListSpaceId').fadeOut();

                //space already selected, fill size automatically
                var selected_space_id=$(this).text();

                $.ajax({
                    url:"{{ route('autocomplete.space_fields') }}",
                    method:"get",
                    data:{selected_space_id:selected_space_id},
                    success:function(data){
                        if(data=='0'){
                            $('#space_size').attr('style','border:1px solid #f00');


                        }
                        else{



                            var final_data=JSON.parse(data);


                            $('#space_size').val(final_data.size);
                            $('#major_industry').val(final_data.major_industry);
                            $('#minor_industry').val(final_data.minor_industry);
                            $('#location').val(final_data.location);
                            $('#sub_location').val(final_data.sub_location);
                            $('#has_water_bill').val(final_data.has_water_bill);
                            $('#has_electricity_bill').val(final_data.has_electricity_bill);



                        }
                    }
                });




            });








        });


    </script>




@endsection
