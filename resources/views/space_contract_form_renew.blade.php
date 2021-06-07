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

    $date=date_create($today);

    date_sub($date,date_interval_create_from_date_string("7 days"));

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
            <li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
<div class="main_content">
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-12 col-sm-9 col-md-7 col-lg-9 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Real Estate Contract Information</strong></h2>
                <p>Fill all form fields with (*) to go to the next step</p>
                <div class="row">
                    <div class="col-md-12 mx-0">

                        <form id="msform" onsubmit="return submitFunction()" METHOD="POST" enctype="multipart/form-data" action="{{ route('create_space_contract')}}">
                        {{csrf_field()}}
                            <!-- progressbar -->
                            <ul style="text-align: center;" id="progressbar">
                            	<li class="active" id="personal"><strong>Client</strong></li>
                                <li  id="account"><strong>Real Estate</strong></li>
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
            <select class="form-control" readonly id="client_type" name="client_type">

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
							<label for="first_name">First Name</label>
                            <span id="name1msg"></span>
							<input type="text" readonly id="first_name" value="{{$var->first_name}}" name="first_name" class="form-control"  onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
						</div>
						<div class="form-wrapper col-6">
							<label for="last_name">Last Name</label>
                            <span id="name2msg"></span>
							<input type="text" id="last_name" readonly value="{{$var->last_name}}" name="last_name" class="form-control"  onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
						</div>
					</div>

					<div class="form-group" id="companydiv" style="display: none;">
					<div class="form-wrapper">
						<label for="company_name">Company Name</label>
                        <span id="cnamemsg"></span>
						<input type="text" readonly id="company_name" name="company_name" value="{{$var->first_name}}" class="form-control">
					</div>
				</div>

    <div class="form-group row">


        <div class="form-wrapper col-12">
            <label for="official_client_id">Client ID</label>
            <span id="official_client_id_msg"></span>
            <input type="text" id="official_client_id" readonly value="{{$var->official_client_id}}" name="official_client_id" class="form-control">
        </div>



					<div class="form-wrapper col-6">
						<label for="email">Email</label>
						<input type="text" name="email" readonly value="{{$var->email}}" id="email" class="form-control" placeholder="someone@example.com" >
					</div>


                    <div class="form-wrapper col-6">
                        <label for="phone_number">Phone Number</label>
                        <span id="phone_msg"></span>
                        <input type="text" id="phone_number"  name="phone_number" value="{{$var->phone_number}}" readonly class="form-control" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
                    </div>


				</div>



				<div class="form-group">
					<div class="form-wrapper">
						<label for="address">Address</label>
						<input type="text" readonly id="address" name="address" value="{{$var->address}}" class="form-control">
					</div>
				</div>

                                    <div class="form-group">
                                        <div class="form-wrapper">
                                            <label for="client_type_contract">Client Type </label>
                                            <span id="client_type_contract_msg"></span>
                                            <input type="text" id="client_type_contract" readonly value="{{$var->client_type_contract}}"  name="client_type_contract" class="form-control">
                                        </div>
                                    </div>



                                    @if($var->parent_client!='')
                                        <div class="form-group">
                                            <div class="form-wrapper">
                                                <label for="parent_client">Parent client </label>
                                                <span id="parent_client_msg"></span>
                                              <?php  $parent_client_name=DB::table('clients')->where('client_id',$var->parent_client)->value('full_name');   ?>

                                                <input type="text"  readonly value="{{$parent_client_name}}" class="form-control">
                                            </div>
                                        </div>

                                        <input type="hidden" id="parent_client"  value="{{$var->parent_client}}"  name="parent_client" class="form-control">
                                    @else
                                    @endif



                                </div>
 <input type="button" name="next" id="next1" class="next action-button" value="Next Step" />
  <input type="button" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">
                                    {{-- <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a> --}}
                            </fieldset>
                            {{-- Second Form --}}
                            <fieldset>
                                <div class="form-card">
                                  <h2 class="fs-title">Real Estate Information</h2>

                                    @if($var->has_clients=='1')
                                    @else
                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="major_industry"  ><strong>Category</strong></label>
                                            <input type="text" class="form-control" id="getMajor" name="major_industry" value="{{$var->major_industry}}" readonly  autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for=""  ><strong>Sub Category</strong></label>
                                            <input type="text" class="form-control" id="minor_list" name="minor_industry" value="{{$var->minor_industry}}" readonly  autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="space_location"  ><strong>Location</strong></label>
                                            <input type="text" class="form-control" id="space_location"  name="space_location" value="{{$var->location}}" readonly  autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="space_location"  ><strong>Sub location</strong></label>
                                            <input type="text" readonly class="form-control" id="space_sub_location" name="space_sub_location" value="{{$var->sub_location}}"  autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="" ><strong>Real Estate Number</strong></label>
                                            <input type="text" class="form-control" id="space_id_contract" name="space_id_contract" value="{{$var->space_id}}" readonly Required autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for=""  ><strong>Size (SQM) <span style="color: red;"></span></strong></label>
                                            <input type="number"  step="0.01" class="form-control" id="space_size" name="space_size" value="{{$var->size}}" readonly autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="has_water_bill"  ><strong>Need to also pay Water bill</strong></label>
                                            <input type="text" readonly class="form-control" id="has_water_bill" name="has_water_bill" value="{{$var->has_water_bill_space}}"  autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="has_electricity_bill"  ><strong>Need to also pay Electricity bill</strong></label>
                                            <input type="text" readonly class="form-control" id="has_electricity_bill" name="has_electricity_bill" value="{{$var->has_electricity_bill_space}}"  autocomplete="off">
                                        </div>
                                    </div>
                                    @endif


                                    @endforeach
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="button" id="next2" name="next" class="next action-button" value="Next Step" />
                                 <input type="button" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">
                                {{-- <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a> --}}
                            </fieldset>
                            {{-- Third Form --}}
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Payment Information</h2>
                                    <div class="form-group row">


                                        <div id="contract_categoryDiv" class="form-wrapper col-12" style="display: none">
                                            <label for="contract_category">Category of contract <span style="color: red;"> *</span></label>
                                            <span id="contract_category_msg"></span>
                                            <select id="contract_category" class="form-control" name="contract_category" >
                                                <option value="" ></option>
                                                <option value="Solicited" >Solicited</option>
                                                <option value="Unsolicited" >Unsolicited</option>
                                            </select>
                                        </div>



                                        <div id="tinDiv" class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for="tin">TIN <span style="color: red;"> *</span></label>
                                                <span id="tin_msg"></span>
                                                <input type="number" id="tin" name="tin" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minCharacters(this.value);" maxlength = "9">
                                                <p id="error_tin"></p>
                                            </div>
                                        </div>



                                        <div id="tbs_certificateDiv" style="display: none;" class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for="tbs_certificate">Certificate from TBS(Only pdf format is accepted) <span style="color: red;"> *</span></label>
                                                <span id="tbs_certificate_msg"></span>
                                                <input type="file" id="tbs_certificate"    name="tbs_certificate" >
                                            </div>
                                        </div>


                                        <div id="gpsa_certificateDiv" style="display: none;"  class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for="gpsa_certificate">Certificate from GPSA(Only pdf format is accepted) <span style="color: red;"> *</span></label>
                                                <span id="gpsa_certificate_msg"></span>
                                                <input type="file" id="gpsa_certificate"  name="gpsa_certificate" >
                                            </div>
                                        </div>


                                        <div id="food_business_licenseDiv" style="display: none;" class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for="food_business_license">Food business license(Only pdf format is accepted) <span style="color: red;"> *</span></label>
                                                <span id="food_business_license_msg"></span>
                                                <input type="file" id="food_business_license"  name="food_business_license" >
                                            </div>
                                        </div>


                                        <div style="display: none;" id="business_licenseDiv" class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for="business_license">Business license(Only pdf format is accepted)<span style="color: red;"> *</span></label>
                                                <span id="business_license_msg"></span>
                                                <input type="file" id="business_license"  name="business_license" >
                                            </div>
                                        </div>



                                        <div style="display: none;" id="osha_certificateDiv" class="form-group col-12 pt-4">
                                            <div class="form-wrapper">
                                                <label for="osha_certificate">Certificate from OSHA(Only pdf format is accepted)<span style="color: red;"> *</span></label>
                                                <span id="osha_certificate_msg"></span>
                                                <input type="file" id="osha_certificate"  name="osha_certificate" >
                                            </div>
                                        </div>


                                        <div style="display: none;" id="tcra_registrationDiv"  class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for="tcra_registration">TCRA registration(Only pdf format is accepted)<span style="color: red;"> *</span></label>
                                                <span id="tcra_registration_msg"></span>
                                                <input type="file"  id="tcra_registration"  name="tcra_registration" >
                                            </div>
                                        </div>


                                        <div style="display: none;" id="brela_registrationDiv" class="form-group col-12">
                                            <div class="form-wrapper">
                                                <label for="brela_registration">BRELA registration(Only pdf format is accepted)<span style="color: red;"> *</span></label>
                                                <span id="brela_registration_msg"></span>
                                                <input type="file" id="brela_registration"  name="brela_registration" >
                                            </div>
                                        </div>




                                        <div class="form-wrapper col-12 pt-4" style="margin-top: 4.5rem !important;">
                                            <label for="start_date">Start date of the contract<span style="color: red;"> *</span></label>
                                            <span id="start_date_msg"></span>
                                            <input autocomplete="off" id="start_date"  class="form-control">
                                            <input type="hidden" id="start_date_alternate" name="start_date" class="form-control "  >
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="duration">Duration <span style="color: red;"> *</span></label>
                                            <span id="duration_msg"></span>
                                            <input type="number" id="duration" name="duration" class="form-control">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="currency">Period <span style="color: red;"> *</span></label>
                                            <span id="duration_period_msg"></span>
                                            <select id="duration_period" class="form-control" name="duration_period">
                                                <option value="" ></option>
                                                <option value="Months" >Months</option>
                                                <option value="Years" >Years</option>
                                            </select>
                                        </div>



                                        <div id="percentage_to_payDiv"  class="form-wrapper pt-4 col-12">
                                            <label for="percentage_to_pay">Percentage to be paid(Of total collection) <span style="color: red;"> *</span></label>
                                            <span id="percentage_to_pay_msg"></span>
                                            <input type="number"  step="0.01" id="percentage_to_pay" name="percentage_to_pay" class="form-control">
                                        </div>


                                    </div>

                                    <div class="form-group row">

                                        <div id="academic_dependenceDiv" class="form-wrapper col-12">
                                            <label for="currency">Depend on academic year <span style="color: red;"> *</span></label>
                                            <span id="academic_dependence_msg"></span>
                                            <select id="academic_dependence" class="form-control" name="academic_dependence" >
                                                <option value="" ></option>
                                                <option value="No" >No</option>
                                                <option value="Yes" >Yes</option>
                                            </select>
                                        </div>


                                        <div id="academicDiv" style="display: none" class="form-wrapper pt-4 col-6">
                                            <label for="amount">Amount per payment cycle(Academic season) <span style="color: red;"> *</span></label>
                                            <span id="academic_season_msg"></span>
                                            <input type="number"  id="academic_season" name="academic_season" class="form-control" >
                                        </div>


                                        <div id="vacationDiv" style="display: none" class="form-wrapper pt-4 col-6">
                                            <label for="amount">Amount per payment cycle(Vacation season) <span style="color: red;"> *</span></label>
                                            <span id="vacation_season_msg"></span>
                                            <input type="number"  id="vacation_season" name="vacation_season" class="form-control" >
                                        </div>

                                        <div id="amountDiv" style="display: none" class="form-wrapper pt-4 col-12">
                                            <label for="amount">Amount per payment cycle<span style="color: red;"> *</span></label>
                                            <span id="amount_msg"></span>
                                            <input type="number"  id="amount" name="amount" class="form-control" >
                                        </div>

                                        <div id="rent_sqmDiv"  class="form-wrapper pt-4 col-12">
                                            <label for="rent_sqm">Rent/SQM <span >(Leave empty if not applicable)</span></label>
                                            <input type="number"  id="rent_sqm" name="rent_sqm"  class="form-control">
                                        </div>

                                        <div id="has_additional_businessesDiv" class="form-wrapper pt-4 col-12" style="display: none; text-align: left;">

                                            <label for="has_additional_businesses" style="display: inline-block;">Has additional businesses in the area</label>
                                            <input type="checkbox"  style="display: inline-block;" value="1" id="has_additional_businesses" onchange="showAdditionalBusinesses()"  name="has_additional_businesses" autocomplete="off">

                                        </div>



                                        <div id="additional_businesses_listDiv" class="form-wrapper pt-4 col-12" style="display: none;">
                                            <label for="">List of the businesses (Comma separated):<span style="color: red;"> *</span></label>
                                            <span id="additional_businesses_list_msg"></span>
                                            <textarea style="width: 100%;" id="additional_businesses_list" name="additional_businesses_list"></textarea>

                                        </div>


                                        <div id="additional_businesses_amountDiv" style="display: none;" class="form-wrapper pt-4 col-12">
                                            <label for="additional_businesses_amount">Amount to be paid for additional businesses in the area<span style="color: red;"> *</span></label>
                                            <span id="additional_businesses_amount_msg"></span>
                                            <input type="number"  id="additional_businesses_amount" name="additional_businesses_amount" class="form-control">
                                        </div>

                                        <div id="total_amountDiv" style="display: none;" class="form-wrapper pt-4 col-12">
                                            <label for="total_amount">Total amount per payment cycle<span style="color: red;"> *</span></label>
                                            <span id="total_amount_msg"></span>
                                            <input type="text"  id="total_amount" readonly name="total_amount" class="form-control">
                                        </div>


                                        <div id="academic_season_totalDiv" style="display: none" class="form-wrapper pt-4 col-6">
                                            <label for="academic_season_total">Total amount per payment cycle(Academic season) <span style="color: red;"> *</span></label>
                                            <span id="academic_season_total_msg"></span>
                                            <input type="text" readonly id="academic_season_total" name="academic_season_total" class="form-control">
                                        </div>


                                        <div id="vacation_season_totalDiv" style="display: none" class="form-wrapper pt-4 col-6">
                                            <label for="vacation_season_total">Total amount per payment cycle(Vacation season) <span style="color: red;"> *</span></label>
                                            <span id="vacation_season_total_msg"></span>
                                            <input type="text" readonly id="vacation_season_total" name="vacation_season_total" class="form-control">
                                        </div>


                                        <div id="has_security_depositDiv" class="form-wrapper col-12">
                                            <label for="has_security_deposit">Has security deposit?<span style="color: red;"> *</span></label>
                                            <span id="has_security_deposit_msg"></span>
                                            <select id="has_security_deposit" class="form-control" name="has_security_deposit">
                                                <option value="" ></option>
                                                <option value="No" >No</option>
                                                <option value="Yes" >Yes</option>
                                            </select>
                                        </div>

                                        <div id="security_depositDiv" style="display: none" class="form-wrapper pt-4 col-12">
                                            <label for="security_deposit">Security deposit<span style="color: red;"> *</span></label>
                                            <span id="security_deposit_msg"></span>
                                            <input type="text" readonly id="security_deposit" name="security_deposit" class="form-control">
                                        </div>



                                        <div id="currencydiv" class="form-wrapper col-12 pt-4">
                                            <label for="currency">Currency <span style="color: red;"> *</span></label>
                                            <span id="currency_msg"></span>
                                            <select id="currency" class="form-control"  name="currency">
                                                <option value="" ></option>
                                                <option id="currency_tzs" value="TZS" >TZS</option>
                                                <option id="currency_usd" value="USD" >USD</option>
                                            </select>
                                            <p class="pt-2" style="display: none;" id="currency_clause"><b>N.B This is the currency that will be used for all sub-clients</b></p>
                                        </div>



                                    </div>

                                    <div class="form-group row">

                                        <div class="form-wrapper col-12">
                                            <label for="payment_cycle">Payment cycle duration(in months) <span style="color: red;"> *</span></label>
                                            <span id="payment_cycle_msg"></span>
                                            <input type="number"  id="payment_cycle" name="payment_cycle" class="form-control">

                                        </div>

                                        <div class="form-wrapper col-12" id="escalation_rateDiv" style="display: none;">
                                            <label for="escalation_rate">Escalation Rate <span style="color: red;"> *</span></label>
                                            <span id="escalation_rate_msg"></span>
                                            <input type="number"  id="escalation_rate" name="escalation_rate" class="form-control" >
                                        </div>




                                        <div class="form-wrapper col-6" id="escalation_rate_vacationDiv" style="display: none;">
                                            <label for="escalation_rate_vacation">Escalation Rate(Vacation season) <span style="color: red;"> *</span></label>
                                            <span id="escalation_rate_vacation_msg"></span>
                                            <input type="number"  id="escalation_rate_vacation" name="escalation_rate_vacation" class="form-control" >
                                        </div>




                                        <div class="form-wrapper col-6" id="escalation_rate_academicDiv" style="display: none;">
                                            <label for="escalation_rate_academic">Escalation Rate(Academic season) <span style="color: red;"> *</span></label>
                                            <span id="escalation_rate_academic_msg"></span>
                                            <input type="number"  id="escalation_rate_academic" name="escalation_rate_academic" class="form-control" >
                                        </div>




                                    </div>


                                    <p id="validate_money_msg"></p>
                                    <br>
                                    <br>

                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />

                                <input type="button" id="next3" name="next" class="next action-button" value="Next" />
                                <input type="button" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">
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
                                            <td> Category:</td>
                                            <td id="major_industry_confirm"></td>
                                        </tr>


                                        <tr>
                                            <td> Sub Category:</td>
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
                                            <td>Real Estate number:</td>
                                            <td id="space_number_confirm"></td>
                                        </tr>



                                        <tr>
                                            <td>Real Estate size(SQM):</td>
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
                                <input type="button" id="next4" name="next" class="next action-button" value="Next" />
                                <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a>
                            </fieldset>



                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Invoice Information</h2>
                                    <div class="form-group row">


                                        <div class="form-group col-12 pt-4"  >
                                            <div class="form-wrapper">
                                                <label for="debtor_name">Client Full Name </label>

                                                <input type="text" id="debtor_name" readonly name="debtor_name" class="form-control">
                                            </div>
                                        </div>


                                        <div  class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for=""  >Client Account Code</label>
                                                <input type="text" class="form-control" id="debtor_account_code_space" readonly name="debtor_account_code" value=""  autocomplete="off">
                                            </div>
                                        </div>


                                        <div  class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for="tin">TIN <span style="color: red;"> *</span></label>
                                                <input type="text" readonly id="tin_invoice"  name="tin_invoice" class="form-control">
                                            </div>
                                        </div>



                                        <div class="form-group col-12 pt-4">
                                            <div class="form-wrapper">
                                                <label for=""  >Client Address </label>
                                                <input type="text" class="form-control" id="debtor_address_space" name="debtor_address" value="" readonly autocomplete="off">
                                            </div>
                                        </div>

{{--                                        <div class="form-group col-12 pt-4">--}}
{{--                                            <div class="form-wrapper">--}}
{{--                                                <label for=""  >Inc Code<span style="color: red;">*</span></label>--}}
{{--                                                <input type="text" class="form-control"  name="inc_code" value=""  Required autocomplete="off">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for=""  >Invoice Start Date <span style="color: red;"> *</span></label>
                                                <input  class="form-control " id="invoicing_period_start_date"   required autocomplete="off">
                                                <input  type="hidden" id="invoicing_period_start_date_alternate" name="invoicing_period_start_date" value="" required autocomplete="off">
                                            </div>
                                        </div>


                                        <div  class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for="">Invoice End Date <span style="color: red;"> *</span></label>
                                                <input  class="form-control " id="invoicing_period_end_date"  value="" required  autocomplete="off">
                                                <input  type="hidden" id="invoicing_period_end_date_alternate" name="invoicing_period_end_date" value="" required  autocomplete="off">
                                            </div>
                                        </div>


                                        <div class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for="">Period <span style="color: red;"> *</span></label>
                                                <input type="text" class="form-control" id="" name="period" value=""  required  autocomplete="off">
                                            </div>
                                        </div>


                                        <div   class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for=""  >Project ID <span style="color: red;"> *</span></label>
                                                <input type="text" class="form-control" id="" name="project_id" value="" required  autocomplete="off">
                                            </div>
                                        </div>




                                        <div  class="form-group col-6 pt-4">
                                            <div class="form-wrapper">
                                                <label for="">Amount <span style="color: red;"> *</span></label>
                                                <input type="number" min="20" class="form-control" id="amount_to_be_paid" name="amount_to_be_paid" value="" required  autocomplete="off">
                                            </div>
                                        </div>



                                        <div  class="form-group col-6 pt-4">
                                            <div  class="form-wrapper">
                                                <label>Currency </label>
                                                <input type="text" class="form-control" id="currency_invoice" name="currency_invoice" value="" readonly  autocomplete="off">
                                            </div>
                                        </div>



                                        <div  class="form-group col-md-12 mt-1">
                                            <div class="form-wrapper">
                                                <label for="" >Status <span style="color: red;"> *</span></label>
                                                <input type="text" class="form-control" id="status" name="status" value="" required  autocomplete="off">
                                            </div>
                                        </div>


                                        <div  class="form-group col-md-12 mt-1">
                                            <div class="form-wrapper">
                                                <label for="" >Description <span style="color: red;"> *</span></label>
                                                <input type="text" class="form-control" id="description" name="description" value="" required autocomplete="off">
                                            </div>
                                        </div>


                                    </div>








                                </div>
                                <input type="button" id="previous5" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="submit" id="submit5" name="submit" class="submit action-button" value="Save"/>
                                <input type="submit" id="save_and_print_btn" onclick="openNewTab();" name="submit" class="submit action-button" value="Save and print"/>
                                <input type="button" id="cancel5" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">


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

    <script>

        $('#has_security_deposit').click(function() {
            var query=$(this).val();
            var academic_dependence=$('#academic_dependence').val();
            var academic_season=$('#academic_season').val();
            var amount=$('#amount').val();
            var additional_businesses_amount=$('#additional_businesses_amount').val();
            if(query=='Yes') {
                $('#security_depositDiv').show();

                if(academic_dependence=='Yes'){

                    $('#security_deposit').val((+academic_season  +  +additional_businesses_amount)*6);

                }else{

                    $('#security_deposit').val((+amount  +  +additional_businesses_amount)*6);
                }



            }else if(query=='No'){
                $('#security_depositDiv').hide();
                $('#security_deposit').val("0");

            }else{
                $('#security_depositDiv').hide();
                $('#security_deposit').val("0");

            }



        });

    </script>

    <script>

        function minCharacters(value){



            if(value.length<9){

                document.getElementById("next3").disabled = true;
                document.getElementById("error_tin").style.color = 'red';
                document.getElementById("error_tin").style.float = 'left';
                document.getElementById("error_tin").style.paddingTop = '1%';
                document.getElementById("error_tin").innerHTML ='TIN number cannot be less than 9 digits';

            }else{
                document.getElementById("error_tin").innerHTML ='';
                document.getElementById("next3").disabled = false;
            }

        }


    </script>


    <script type="text/javascript">

        function showAdditionalBusinesses() {


            if( $('#has_additional_businesses').prop('checked') ) {


                var academic_dependence=$('#academic_dependence').val();

                if(academic_dependence=='Yes'){

                    $('#total_amountDiv').hide();
                    $('#academic_season_totalDiv').show();
                    $('#vacation_season_totalDiv').show();

                    $('#academic_season_total').val("");
                    $('#vacation_season_total').val("");
                    $('#total_amount').val("");
                }else{
                    $('#total_amountDiv').show();
                    $('#academic_season_totalDiv').hide();
                    $('#vacation_season_totalDiv').hide();

                    $('#academic_season_total').val("");
                    $('#vacation_season_total').val("");
                    $('#total_amount').val("");

                }


                $('#additional_businesses_listDiv').show();
                $('#additional_businesses_amountDiv').show();


                $('#additional_businesses_list').val("");
                $('#additional_businesses_amount').val("");


            }else{


                $('#additional_businesses_listDiv').hide();
                $('#additional_businesses_amountDiv').hide();
                $('#total_amountDiv').hide();
                $('#academic_season_totalDiv').hide();
                $('#vacation_season_totalDiv').hide();

                $('#additional_businesses_list').val("");
                $('#additional_businesses_amount').val("");
                $('#total_amount').val("");


            }

        }


        $('#additional_businesses_amount').on('input',function(e){
            e.preventDefault();
            var additional_businesses_amount=$(this).val();
            var amount=$('#amount').val();

            var academic_season=$('#academic_season').val();
            var vacation_season=$('#vacation_season').val();

            var academic_dependence=$('#academic_dependence').val();

            if(academic_dependence=='Yes'){
                $('#academic_season_total').val(+academic_season  +  +additional_businesses_amount);
                $('#vacation_season_total').val(+vacation_season  +  +additional_businesses_amount);
                $('#security_deposit').val((+academic_season  +  +additional_businesses_amount)*6);


            }else{

                $('#total_amount').val(+amount  +  +additional_businesses_amount);
                $('#security_deposit').val((+amount  +  +additional_businesses_amount)*6);

            }






        });



        var button_clicked=null;

        function openNewTab() {

            button_clicked='Save and print';
        }

        function submitFunction(){
            $("#cancel5").css("background-color", "#87ceeb");
            $("#cancel5").val('Finish');
            $("#previous5").hide();
            $("#submit5").hide();
            $("#save_and_print_btn").hide();

            if(button_clicked=='Save and print'){

                $("#msform").attr("target","_blank");

            }else{


            }


            return true;

        }



        window.onload=function(){
            document.getElementById("client_type").click();
        };
    </script>

    <script type="text/javascript">

        var temp;
        function properNext(){
            temp=1;
        }

        function properNextZero(){
            temp=0;
        }

        $(document).ready(function(){

            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;
            var p1, p2,p3,p4,p5,p6,p7,p14,p15,p16,p17,p18,p19,p20;



            p14=0;
            p15=0;
            p16=0;
            p17=0;
            p18=0;
            p19=0;
            p20=0;





            //File pond starts

            FilePond.registerPlugin(FilePondPluginFileValidateType);

            FilePond.registerPlugin(FilePondPluginFileValidateSize);



            const tbs_certificateinputElement = document.querySelector('#tbs_certificate');
            const tbs_certificatepond = FilePond.create(tbs_certificateinputElement, {
                onaddfile: (error, file) => {

                    if(error==null){


                        checkRequired(14);

                    }else{



                    }


                }
                ,onremovefile: (error, file) => {

                    if(error==null){
                        onFileRemove(14);

                    }else{



                    }


                }

            });


            const gpsa_certificateinputElement = document.querySelector('#gpsa_certificate');
            const gpsa_certificatepond = FilePond.create(gpsa_certificateinputElement, {
                onaddfile: (error, file) => {

                    if(error==null){


                        checkRequired(15);

                    }else{



                    }


                }
                ,onremovefile: (error, file) => {

                    if(error==null){
                        onFileRemove(15);

                    }else{



                    }


                }

            });





            const food_business_licenseinputElement = document.querySelector('#food_business_license');
            const food_business_licensepond = FilePond.create(food_business_licenseinputElement, {
                onaddfile: (error, file) => {

                    if(error==null){

                        checkRequired(16);

                    }else{



                    }


                }
                ,onremovefile: (error, file) => {

                    if(error==null){
                        onFileRemove(16);

                    }else{



                    }


                }

            });




            const business_licenseinputElement = document.querySelector('#business_license');
            const business_licensepond = FilePond.create(business_licenseinputElement, {
                onaddfile: (error, file) => {

                    if(error==null){

                        checkRequired(17);
                    }else{



                    }


                }
                ,onremovefile: (error, file) => {

                    if(error==null){
                        onFileRemove(17);

                    }else{



                    }


                }

            });








            const osha_certificateinputElement = document.querySelector('#osha_certificate');
            const osha_certificatepond = FilePond.create(osha_certificateinputElement, {
                onaddfile: (error, file) => {

                    if(error==null){
                        checkRequired(18);

                    }else{



                    }


                }
                ,onremovefile: (error, file) => {

                    if(error==null){
                        onFileRemove(18);

                    }else{



                    }


                }

            });




            const tcra_registrationinputElement = document.querySelector('#tcra_registration');
            const tcra_registrationpond = FilePond.create(tcra_registrationinputElement, {
                onaddfile: (error, file) => {

                    if(error==null){
                        checkRequired(19);

                    }else{



                    }


                }
                ,onremovefile: (error, file) => {

                    if(error==null){
                        onFileRemove(19);

                    }else{



                    }


                }

            });




            const brela_registrationinputElement = document.querySelector('#brela_registration');
            const brela_registrationpond = FilePond.create(brela_registrationinputElement, {
                onaddfile: (error, file) => {

                    if(error==null){
                        checkRequired(20);

                    }else{



                    }


                }

                ,onremovefile: (error, file) => {

                    if(error==null){
                        onFileRemove(20);

                    }else{



                    }


                }





            });





            $(function(){

                // Turn input element into a pond with configuration options
                $('input[type="file"]').filepond({
                    allowMultiple: false
                });



                // Listen for addfile event
                $('input[type="file"]').on('FilePond:addfile', function(error, file) {
                    console.log('file added event');
                });

                // Manually add a file using the addfile method
                // $('input[type="file"]').filepond('addFile', 'index.html').then(function(file){
                //     console.log('file added', file);
                // });





                FilePond.setOptions({
                    server: {
                        url: '/upload',
                        headers: {

                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },

                        revert:{

                            url: '/revert_upload',
                            headers: {

                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },


                            onload: function (responce) {
                                console.log(responce);

                            },



                        }



                    },

                    labelFileProcessing: 'Uploading',

                    acceptedFileTypes: ['application/pdf'],

                    fileValidateTypeLabelExpectedTypes: 'Expects pdf',

                    maxFileSize: '15MB'


                });









            });



            function checkRequired(number){
                if(number=='14'){
                    p14=1;
                }else if(number=='15'){
                    p15=1;

                }else if(number=='16'){

                    p16=1;

                }else if(number=='17'){

                    p17=1;
                }else if(number=='18'){

                    p18=1;

                }else if(number=='19'){

                    p19=1;
                }else if(number=='20'){

                    p20=1;
                }else{



                }
            }



            function onFileRemove(number){
                if(number=='14'){
                    p14=0;
                }else if(number=='15'){
                    p15=0;

                }else if(number=='16'){

                    p16=0;

                }else if(number=='17'){

                    p17=0;
                }else if(number=='18'){

                    p18=0;

                }else if(number=='19'){

                    p19=0;
                }else if(number=='20'){

                    p20=0;
                }else{



                }
            }

//Filepond ends






            $("#next1").click(function(){


                if(temp==1) {
                    next_fs = $(this).parent().next().next();
                }else{
                    next_fs = $(this).parent().next();
                }


                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                var clientType=$("#client_type").val(),
                    firstName=$("#first_name").val(),
                    lastName=$("#last_name").val(),
                    companyName=$("#company_name").val();

                var client_type_contract=$("#client_type_contract").val();
                var parent_client=$("#parent_client").val();


                if(client_type_contract=='Direct and has clients'){

                    $('#renting_space').hide();
                    properNext();

                }else{

                    $('#renting_space').show();
                    properNextZero();

                }


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



                if (client_type_contract=='Indirect'){

                    //old indirect code starts
                    $('#business_licenseDiv').hide();
                    $('#contract_categoryDiv').hide();
                    $('#has_additional_businessesDiv').show();

                    $('#has_security_depositDiv').hide();



                    $('#percentage_to_payDiv').hide();
                    $('#academic_dependenceDiv').show();
                    // $('#academicDiv').show();
                    // $('#vacationDiv').show();
                    // $('#amountDiv').show();
                    $('#rent_sqmDiv').show();
                    $('#currencydiv').show();
                    $('#currency_clause').hide();

                    //old indirect code ends





                    var query=parent_client;

                    $.ajax({
                        url:"{{ route('get_parent_currency') }}",
                        method:"get",
                        data:{query:query},
                        success:function(data){
                            if(data=='0'){


                                $('#currency_tzs').show();
                                $('#currency_usd').show();

                            }
                            else{





                                if(data=='TZS'){




                                    $('#currency_usd').hide();
                                    $('#currency_tzs').show();
                                }else if(data=='USD'){

                                    $('#currency_tzs').hide();
                                    $('#currency_usd').show();

                                }else{

                                    $('#currency_tzs').show();
                                    $('#currency_usd').show();

                                }





                            }
                        }
                    });






                }else if(client_type_contract=='Direct and has clients'){



                    $('#currency_tzs').show();
                    $('#currency_usd').show();



                    $('#percentage_to_payDiv').show();
                    $('#business_licenseDiv').show();

                    $('#academic_dependenceDiv').hide();
                    $('#academicDiv').hide();
                    $('#vacationDiv').hide();
                    $('#amountDiv').hide();
                    $('#rent_sqmDiv').hide();
                    $('#currencydiv').show();
                    $('#currency_clause').show();
                    $('#contract_categoryDiv').hide();
                    $('#has_additional_businessesDiv').hide();
                    $('#has_security_depositDiv').hide();





                }

                else{



                    $('#currency_tzs').show();
                    $('#currency_usd').show();


                    $('#business_licenseDiv').hide();
                    $('#percentage_to_payDiv').hide();
                    $('#academic_dependenceDiv').show();
                    $('#contract_categoryDiv').show();
                    $('#has_additional_businessesDiv').show();

                    $('#has_security_depositDiv').show();


                    $('#rent_sqmDiv').show();
                    $('#currencydiv').show();
                    $('#currency_clause').hide();




                }




                if(p1=='1' & p2=='1'){
                    gonext();
                }



            });

            $("#next2").click(function(){
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                var p1, p2,p3,p4,p5;
                var sub_location = $('#space_sub_location').val();
                var location = $('#space_location').val();
                var minor = $('#minor_list').val();
                var major = $('#getMajor').val();
                var space_id = $('#space_id_contract').val();

                if(major==""){
                    p1=0;
                    $('#major_msg').show();
                    var message=document.getElementById('major_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#getMajor').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p1=1;
                    $('#major_msg').hide();
                    $('#getMajor').attr('style','border-bottom: 1px solid #ccc');

                }


                if(minor==""){
                    p2=0;
                    $('#minor_msg').show();
                    var message=document.getElementById('minor_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#minor_list').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p2=1;
                    $('#minor_msg').hide();
                    $('#minor_list').attr('style','border-bottom: 1px solid #ccc');

                }


                if(location==""){
                    p3=0;
                    $('#location_msg').show();
                    var message=document.getElementById('location_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#space_location').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p3=1;
                    $('#location_msg').hide();
                    $('#space_location').attr('style','border-bottom: 1px solid #ccc');

                }


                if(sub_location==""){
                    p4=0;
                    $('#sub_location_msg').show();
                    var message=document.getElementById('sub_location_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#space_sub_location').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p4=1;
                    $('#sub_location_msg').hide();
                    $('#space_sub_location').attr('style','border-bottom: 1px solid #ccc');

                }


                if(space_id==""){
                    p5=0;
                    $('#space_id_msg').show();
                    var message=document.getElementById('space_id_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#space_id_contract').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p5=1;
                    $('#space_id_msg').hide();
                    $('#space_id_contract').attr('style','border-bottom: 1px solid #ccc');

                }




                if(minor=="Canteen"){

                    $('#tbs_certificateDiv').show();
                    $('#gpsa_certificateDiv').show();
                    $('#food_business_licenseDiv').show();

                    $('#business_licenseDiv').hide();
                    $('#osha_certificateDiv').hide();
                    $('#tcra_registrationDiv').hide();
                    $('#brela_registrationDiv').hide();


                }else if(major=='Banking'){
                    $('#osha_certificateDiv').show();

                    $('#tbs_certificateDiv').hide();
                    $('#gpsa_certificateDiv').hide();
                    $('#food_business_licenseDiv').hide();
                    $('#business_licenseDiv').show();
                    $('#tcra_registrationDiv').hide();
                    $('#brela_registrationDiv').hide();



                }else if (minor=="Postal services"){
                    $('#tcra_registrationDiv').show();
                    $('#brela_registrationDiv').show();
                    $('#gpsa_certificateDiv').show();


                    $('#tbs_certificateDiv').hide();
                    $('#food_business_licenseDiv').hide();
                    $('#business_licenseDiv').show();
                    $('#osha_certificateDiv').hide();


                }else{
                    $('#business_licenseDiv').show();


                    $('#tbs_certificateDiv').hide();
                    $('#gpsa_certificateDiv').hide();
                    $('#food_business_licenseDiv').hide();
                    $('#osha_certificateDiv').hide();
                    $('#tcra_registrationDiv').hide();
                    $('#brela_registrationDiv').hide();


                }




                if(p1=='1' & p2=='1' & p3=='1'  & p4=='1'  & p5=='1'){

                    var selected_space_id=$('#space_id_contract').val();

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
                                $('#has_water_bill').val(final_data.has_water_bill);
                                $('#has_electricity_bill').val(final_data.has_electricity_bill);



                            }
                        }
                    });


                    gonext();
                }

            });


            $("#next3").click(function(){
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                var p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p21,p22,p23,p26;
                var first_name=document.getElementById('first_name').value;
                var last_name=document.getElementById('last_name').value;
                var company_name=document.getElementById('company_name').value;
                var client_type=document.getElementById('client_type').value;
                var email=$("#email").val();
                var client_type_contract=$("#client_type_contract").val();

                var percentage_to_pay=$("#percentage_to_pay").val();
                var phone_number=document.getElementById('phone_number').value;
                var address=document.getElementById('address').value;
                var sub_location = $('#space_sub_location').val();
                var location = $('#space_location').val();
                var minor = $('#minor_list').val();
                var major = $('#getMajor').val();
                var space_id = $('#space_id_contract').val();

                var start_date=document.getElementById('start_date').value;
                var start_date_alternate=document.getElementById('start_date_alternate').value;

                var duration= $('#duration').val();
                var duration_period=$('#duration_period').val();

                var academic_dependence=document.getElementById('academic_dependence').value;
                var vacation_season=document.getElementById('vacation_season').value;
                var academic_season=document.getElementById('academic_season').value;
                var amount=document.getElementById('amount').value;
                var rent_sqm=document.getElementById('rent_sqm').value;
                var currency=document.getElementById('currency').value;
                var payment_cycle=document.getElementById('payment_cycle').value;
                var escalation_rate=document.getElementById('escalation_rate').value;
                var escalation_rate_vacation=document.getElementById('escalation_rate_vacation').value;
                var escalation_rate_academic=document.getElementById('escalation_rate_academic').value;
                var space_size=document.getElementById('space_size').value;
                var has_water_bill=document.getElementById('has_water_bill').value;
                var has_electricity_bill=document.getElementById('has_electricity_bill').value;


                var tin=$("#tin").val();
                var contract_category=$("#contract_category").val();
                var tbs_certificate=$("#tbs_certificate").val();
                var gpsa_certificate=$("#gpsa_certificate").val();
                var food_business_license=$("#food_business_license").val();
                var business_license=$("#business_license").val();
                var osha_certificate=$("#osha_certificate").val();
                var tcra_registration=$("#tcra_registration").val();
                var brela_registration=$("#brela_registration").val();
                var additional_businesses_list=$("#additional_businesses_list").val();
                var additional_businesses_amount=$("#additional_businesses_amount").val();
                var total_amount=$("#total_amount").val();
                var academic_season_total=$("#academic_season_total").val();
                var vacation_season_total=$("#vacation_season_total").val();
                var security_deposit=$("#security_deposit").val();
                var has_security_deposit=$("#has_security_deposit").val();


                if(start_date==""){
                    p1=0;
                    $('#start_date_msg').show();
                    var message=document.getElementById('start_date_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#start_date').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p1=1;
                    $('#start_date_msg').hide();
                    $('#start_date').attr('style','border-bottom: 1px solid #ccc');

                }



                if(duration==""){
                    p2=0;
                    $('#duration_msg').show();
                    var message=document.getElementById('duration_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#duration').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p2=1;
                    $('#duration_msg').hide();
                    $('#duration').attr('style','border-bottom: 1px solid #ccc');

                }



                if(duration_period==""){
                    p3=0;
                    $('#duration_period_msg').show();
                    var message=document.getElementById('duration_period_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#duration_period').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p3=1;
                    $('#duration_period_msg').hide();
                    $('#duration_period').attr('style','border-bottom: 1px solid #ccc');

                }



                if(academic_dependence==""){
                    p4=0;
                    $('#academic_dependence_msg').show();
                    var message=document.getElementById('academic_dependence_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#academic_dependence').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p4=1;
                    $('#academic_dependence_msg').hide();
                    $('#academic_dependence').attr('style','border-bottom: 1px solid #ccc');

                }



                if(academic_season==""){
                    p5=0;
                    $('#academic_season_msg').show();
                    var message=document.getElementById('academic_season_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#academic_season').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p5=1;
                    $('#academic_season_msg').hide();
                    $('#academic_season').attr('style','border-bottom: 1px solid #ccc');

                }



                if(vacation_season==""){
                    p6=0;
                    $('#vacation_season_msg').show();
                    var message=document.getElementById('vacation_season_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#vacation_season').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p6=1;
                    $('#vacation_season_msg').hide();
                    $('#vacation_season').attr('style','border-bottom: 1px solid #ccc');

                }


                if(amount==""){
                    p7=0;
                    $('#amount_msg').show();
                    var message=document.getElementById('amount_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#amount').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p7=1;
                    $('#amount_msg').hide();
                    $('#amount').attr('style','border-bottom: 1px solid #ccc');

                }


                if(currency==""){
                    p8=0;
                    $('#currency_msg').show();
                    var message=document.getElementById('currency_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#currency').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p8=1;
                    $('#currency_msg').hide();
                    $('#currency').attr('style','border-bottom: 1px solid #ccc');

                }


                if(payment_cycle==""){
                    p9=0;
                    $('#payment_cycle_msg').show();
                    var message=document.getElementById('payment_cycle_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#payment_cycle').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p9=1;
                    $('#payment_cycle_msg').hide();
                    $('#payment_cycle').attr('style','border-bottom: 1px solid #ccc');

                }


                if(escalation_rate==""){

                    $('#escalation_rate_msg').show();
                    var message=document.getElementById('escalation_rate_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#escalation_rate').attr('style','border-bottom:1px solid #f00');
                }
                else{

                    $('#escalation_rate_msg').hide();
                    $('#escalation_rate').attr('style','border-bottom: 1px solid #ccc');

                }



                if(escalation_rate_vacation==""){

                    $('#escalation_rate_vacation_msg').show();
                    var message=document.getElementById('escalation_rate_vacation_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#escalation_rate_vacation').attr('style','border-bottom:1px solid #f00');
                }
                else{

                    $('#escalation_rate_vacation_msg').hide();
                    $('#escalation_rate_vacation').attr('style','border-bottom: 1px solid #ccc');

                }


                if(escalation_rate_academic==""){

                    $('#escalation_rate_academic_msg').show();
                    var message=document.getElementById('escalation_rate_academic_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#escalation_rate_academic').attr('style','border-bottom:1px solid #f00');
                }
                else{

                    $('#escalation_rate_academic_msg').hide();
                    $('#escalation_rate_academic').attr('style','border-bottom: 1px solid #ccc');

                }


                if(escalation_rate=='' && $('#escalation_rateDiv:visible').length !=0) {

                    p10=0;
                }
                else if(escalation_rate_vacation=='' && $('#escalation_rate_vacationDiv:visible').length !=0) {
                    p10=0;

                }
                else if(escalation_rate_academic=='' && $('#escalation_rate_academicDiv:visible').length !=0) {
                    p10=0;

                }
                else{

                    p10=1;
                }


                if(percentage_to_pay==""){
                    p11=0;
                    $('#percentage_to_pay_msg').show();
                    var message=document.getElementById('percentage_to_pay_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#percentage_to_pay').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p11=1;
                    $('#percentage_to_pay_msg').hide();
                    $('#percentage_to_pay').attr('style','border-bottom: 1px solid #ccc');

                }




                if(tin==""){
                    p12=0;
                    $('#tin_msg').show();
                    var message=document.getElementById('tin_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#tin').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p12=1;
                    $('#tin_msg').hide();
                    $('#tin').attr('style','border-bottom: 1px solid #ccc');

                }



                if(contract_category==""){
                    p13=0;
                    $('#contract_category_msg').show();
                    var message=document.getElementById('contract_category_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#contract_category').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p13=1;
                    $('#contract_category_msg').hide();
                    $('#contract_category').attr('style','border-bottom: 1px solid #ccc');

                }



                if(p14=="0"){

                    $('#tbs_certificate_msg').show();
                    var message=document.getElementById('tbs_certificate_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#tbs_certificate').attr('style','border-bottom:1px solid #f00');
                }
                else{

                    $('#tbs_certificate_msg').hide();
                    $('#tbs_certificate').attr('style','border-bottom: 1px solid #ccc');

                }



                if(p15=="0"){

                    $('#gpsa_certificate_msg').show();
                    var message=document.getElementById('gpsa_certificate_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#gpsa_certificate').attr('style','border-bottom:1px solid #f00');
                }
                else{

                    $('#gpsa_certificate_msg').hide();
                    $('#gpsa_certificate').attr('style','border-bottom: 1px solid #ccc');

                }


                if(p16=="0"){

                    $('#food_business_license_msg').show();
                    var message=document.getElementById('food_business_license_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#food_business_license').attr('style','border-bottom:1px solid #f00');
                }
                else{

                    $('#food_business_license_msg').hide();
                    $('#food_business_license').attr('style','border-bottom: 1px solid #ccc');

                }


                if(p17=="0"){

                    $('#business_license_msg').show();
                    var message=document.getElementById('business_license_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#business_license').attr('style','border-bottom:1px solid #f00');
                }
                else{

                    $('#business_license_msg').hide();
                    $('#business_license').attr('style','border-bottom: 1px solid #ccc');

                }


                if(p18=="0"){

                    $('#osha_certificate_msg').show();
                    var message=document.getElementById('osha_certificate_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#osha_certificate').attr('style','border-bottom:1px solid #f00');
                }
                else{

                    $('#osha_certificate_msg').hide();
                    $('#osha_certificate').attr('style','border-bottom: 1px solid #ccc');

                }



                if(p19=="0"){

                    $('#tcra_registration_msg').show();
                    var message=document.getElementById('tcra_registration_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#tcra_registration').attr('style','border-bottom:1px solid #f00');
                }
                else{

                    $('#tcra_registration_msg').hide();
                    $('#tcra_registration').attr('style','border-bottom: 1px solid #ccc');

                }




                if(p20=="0"){

                    $('#brela_registration_msg').show();
                    var message=document.getElementById('brela_registration_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#brela_registration').attr('style','border-bottom:1px solid #f00');
                }
                else{

                    $('#brela_registration_msg').hide();
                    $('#brela_registration').attr('style','border-bottom: 1px solid #ccc');

                }


                if(additional_businesses_list==""){
                    p21=0;
                    $('#additional_businesses_list_msg').show();
                    var message=document.getElementById('additional_businesses_list_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#additional_businesses_list').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p21=1;
                    $('#additional_businesses_list_msg').hide();
                    $('#additional_businesses_list').attr('style','border-bottom: 1px solid #ccc');

                }

                if(additional_businesses_amount==""){
                    p22=0;
                    $('#additional_businesses_amount_msg').show();
                    var message=document.getElementById('additional_businesses_amount_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#additional_businesses_amount').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p22=1;
                    $('#additional_businesses_amount_msg').hide();
                    $('#additional_businesses_amount').attr('style','border-bottom: 1px solid #ccc');

                }



                if(total_amount==""){
                    p23=0;
                    $('#total_amount_msg').show();
                    var message=document.getElementById('total_amount_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#total_amount').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p23=1;
                    $('#total_amount_msg').hide();
                    $('#total_amount').attr('style','border-bottom: 1px solid #ccc');

                }




                if(has_security_deposit==""){
                    p26=0;
                    $('#has_security_deposit_msg').show();
                    var message=document.getElementById('has_security_deposit_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#has_security_deposit').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p26=1;
                    $('#has_security_deposit_msg').hide();
                    $('#has_security_deposit').attr('style','border-bottom: 1px solid #ccc');

                }


                const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"];
                const dateObj = new Date(start_date);
                const month = dateObj.getMonth()+1;
                const day = String(dateObj.getDate()).padStart(2, '0');
                const year = dateObj.getFullYear();

                var new_start_date_alternate = new Date(start_date_alternate);


                const output = (('0' + new_start_date_alternate.getDate()).slice(-2) + '/'
                    + ('0' + (new_start_date_alternate.getMonth()+1)).slice(-2) + '/'+new_start_date_alternate.getFullYear());





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



                if(client_type_contract=='Direct and has clients'){


                    if(p12=='1' & p17=='1' & p1=='1' & p2=='1' & p3=='1' & p11=='1' & p9=='1' & p10=='1' ){

                        //check validity
                        if (duration>=1 & percentage_to_pay>=1 & payment_cycle>=1 & escalation_rate>=0){

                            document.getElementById("validate_money_msg").innerHTML ='';
                            gonext();

                        }else{

                            document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries';
                            document.getElementById("validate_money_msg").style.color='Red';
                        }

                    }else{



                    }



                }else if(client_type_contract=='Direct'){

                    //direct code starts


                    if(minor=="Canteen"){

                        //canteen code starts

                        if(academic_dependence=='Yes'){

                            if( $('#has_additional_businesses').prop('checked') ) {

                                if(p13=='1' & p12=='1' & p14=='1' & p15=='1' & p16=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1' & p21=='1' & p22=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }

                            }else{


                                if(p13=='1' & p12=='1' & p14=='1' & p15=='1' & p16=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1'  & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20   & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }


                            }


                        }else if(academic_dependence=='No'){



                            if( $('#has_additional_businesses').prop('checked') ) {

                                if(p13=='1' & p12=='1' & p14=='1' & p15=='1' & p16=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p21=='1' & p22=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{
                                    document.getElementById("validate_money_msg").innerHTML ='';


                                }

                            }else{


                                if(p13=='1' & p12=='1' & p14=='1' & p15=='1' & p16=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{

                                    document.getElementById("validate_money_msg").innerHTML ='';

                                }


                            }



                        }else{


                        }

                        //canteen code ends






                    }else if(major=='Banking'){
//bank code starts

                        if(academic_dependence=='Yes'){

                            if( $('#has_additional_businesses').prop('checked') ) {

                                if(p13=='1' & p12=='1' & p17=='1' & p18=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1' & p21=='1' & p22=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }

                            }else{


                                if(p13=='1' & p12=='1' & p17=='1' & p18=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1'  & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20   & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }


                            }


                        }else if(academic_dependence=='No'){



                            if( $('#has_additional_businesses').prop('checked') ) {

                                if(p13=='1' & p12=='1' & p17=='1' & p18=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p21=='1' & p22=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{
                                    document.getElementById("validate_money_msg").innerHTML ='';


                                }

                            }else{


                                if(p13=='1' & p12=='1' & p17=='1' & p18=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{

                                    document.getElementById("validate_money_msg").innerHTML ='';

                                }


                            }



                        }else{


                        }

//bank code ends
                    }else if (minor=="Postal services"){

//postal services code starts
                        if(academic_dependence=='Yes'){

                            if( $('#has_additional_businesses').prop('checked') ) {

                                if(p13=='1' & p12=='1' & p15=='1' & p17=='1'  & p19=='1' & p20=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1' & p21=='1' & p22=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }

                            }else{


                                if(p13=='1' & p12=='1' & p15=='1' & p17=='1'  & p19=='1' & p20=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1'  & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20   & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }


                            }


                        }else if(academic_dependence=='No'){



                            if( $('#has_additional_businesses').prop('checked') ) {

                                if(p13=='1' & p12=='1' & p15=='1' & p17=='1'  & p19=='1' & p20=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p21=='1' & p22=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{
                                    document.getElementById("validate_money_msg").innerHTML ='';


                                }

                            }else{


                                if(p13=='1' & p12=='1' & p15=='1' & p17=='1'  & p19=='1' & p20=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{

                                    document.getElementById("validate_money_msg").innerHTML ='';

                                }


                            }



                        }else{


                        }
                        //postal services code ends



                    }else{
//rest of the businesses start
                        if(academic_dependence=='Yes'){

                            if( $('#has_additional_businesses').prop('checked') ) {

                                if(p13=='1' & p12=='1' & p17=='1'  & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1' & p21=='1' & p22=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }

                            }else{


                                if(p13=='1' & p12=='1' & p17=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1'  & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20   & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }


                            }


                        }else if(academic_dependence=='No'){



                            if( $('#has_additional_businesses').prop('checked') ) {

                                if(p13=='1' & p12=='1' & p17=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p21=='1' & p22=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{
                                    document.getElementById("validate_money_msg").innerHTML ='';


                                }

                            }else{


                                if(p13=='1' & p12=='1' & p17=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1' & p26=='1' & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{

                                    document.getElementById("validate_money_msg").innerHTML ='';

                                }


                            }



                        }else{


                        }
                        //rest of the businesses ends


                    }





//direct code ends

                }else{
//indirect code starts


                    if(minor=="Canteen"){

                        //canteen code starts

                        if(academic_dependence=='Yes'){

                            if( $('#has_additional_businesses').prop('checked') ) {

                                if( p12=='1' & p14=='1' & p15=='1' & p16=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1' & p21=='1' & p22=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }

                            }else{


                                if( p12=='1' & p14=='1' & p15=='1' & p16=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1'   & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20   & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }


                            }


                        }else if(academic_dependence=='No'){



                            if( $('#has_additional_businesses').prop('checked') ) {

                                if( p12=='1' & p14=='1' & p15=='1' & p16=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p21=='1' & p22=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{
                                    document.getElementById("validate_money_msg").innerHTML ='';


                                }

                            }else{


                                if( p12=='1' & p14=='1' & p15=='1' & p16=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{

                                    document.getElementById("validate_money_msg").innerHTML ='';

                                }


                            }



                        }else{


                        }

                        //canteen code ends






                    }else if(major=='Banking'){
//bank code starts

                        if(academic_dependence=='Yes'){

                            if( $('#has_additional_businesses').prop('checked') ) {

                                if( p12=='1' & p17=='1' & p18=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1' & p21=='1' & p22=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }

                            }else{


                                if( p12=='1' & p17=='1' & p18=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1'   & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20   & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }


                            }


                        }else if(academic_dependence=='No'){



                            if( $('#has_additional_businesses').prop('checked') ) {

                                if( p12=='1' & p17=='1' & p18=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p21=='1' & p22=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{
                                    document.getElementById("validate_money_msg").innerHTML ='';


                                }

                            }else{


                                if( p12=='1' & p17=='1' & p18=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{

                                    document.getElementById("validate_money_msg").innerHTML ='';

                                }


                            }



                        }else{


                        }

//bank code ends
                    }else if (minor=="Postal services"){

//postal services code starts
                        if(academic_dependence=='Yes'){

                            if( $('#has_additional_businesses').prop('checked') ) {

                                if( p12=='1' & p15=='1' & p17=='1'  & p19=='1' & p20=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1' & p21=='1' & p22=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }

                            }else{


                                if( p12=='1' & p15=='1' & p17=='1'  & p19=='1' & p20=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1'   & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20   & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }


                            }


                        }else if(academic_dependence=='No'){



                            if( $('#has_additional_businesses').prop('checked') ) {

                                if( p12=='1' & p15=='1' & p17=='1'  & p19=='1' & p20=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p21=='1' & p22=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{
                                    document.getElementById("validate_money_msg").innerHTML ='';


                                }

                            }else{


                                if( p12=='1' & p15=='1' & p17=='1'  & p19=='1' & p20=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{

                                    document.getElementById("validate_money_msg").innerHTML ='';

                                }


                            }



                        }else{


                        }
                        //postal services code ends



                    }else{
//rest of the businesses start
                        if(academic_dependence=='Yes'){

                            if( $('#has_additional_businesses').prop('checked') ) {

                                if( p12=='1' & p17=='1'  & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1' & p21=='1' & p22=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }

                            }else{


                                if( p12=='1' & p17=='1' & p1=='1' & p2=='1' & p3=='1' & p5=='1' & p6=='1'   & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & academic_season>=20 & vacation_season>=20   & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{



                                }


                            }


                        }else if(academic_dependence=='No'){



                            if( $('#has_additional_businesses').prop('checked') ) {

                                if( p12=='1' & p17=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p21=='1' & p22=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20 & additional_businesses_amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{
                                    document.getElementById("validate_money_msg").innerHTML ='';


                                }

                            }else{


                                if( p12=='1' & p17=='1' & p1=='1' & p2=='1' & p3=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1'){

                                    //check for validity

                                    if (duration>=1 & amount>=20  & escalation_rate>=0 & payment_cycle>=1 ){

                                        document.getElementById("validate_money_msg").innerHTML ='';
                                        gonext();

                                    }else{

                                        document.getElementById("validate_money_msg").innerHTML ='Invalid entry, please make sure all the fields are filled with valid entries. For amounts the minumum is 20';
                                        document.getElementById("validate_money_msg").style.color='Red';
                                    }



                                }else{

                                    document.getElementById("validate_money_msg").innerHTML ='';

                                }


                            }



                        }else{


                        }
                        //rest of the businesses ends


                    }


//indirect code ends
                }









            });




            $("#next4").click(function(){
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                var p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19,p20,p21,p22,p23,p26;
                var first_name=document.getElementById('first_name').value;
                var last_name=document.getElementById('last_name').value;
                var company_name=document.getElementById('company_name').value;
                var client_type=document.getElementById('client_type').value;
                var email=$("#email").val();
                var official_client_id=$("#official_client_id").val();

                var percentage_to_pay=$("#percentage_to_pay").val();
                var phone_number=document.getElementById('phone_number').value;
                var address=document.getElementById('address').value;
                var sub_location = $('#space_sub_location').val();
                var location = $('#space_location').val();
                var minor = $('#minor_list').val();
                var major = $('#getMajor').val();
                var space_id = $('#space_id_contract').val();

                var start_date=document.getElementById('start_date').value;
                var start_date_alternate=document.getElementById('start_date_alternate').value;
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


                var tin=$("#tin").val();
                var contract_category=$("#contract_category").val();
                var tbs_certificate=$("#tbs_certificate").val();
                var gpsa_certificate=$("#gpsa_certificate").val();
                var food_business_license=$("#food_business_license").val();
                var business_license=$("#business_license").val();
                var osha_certificate=$("#osha_certificate").val();
                var tcra_registration=$("#tcra_registration").val();
                var brela_registration=$("#brela_registration").val();
                var additional_businesses_list=$("#additional_businesses_list").val();
                var additional_businesses_amount=$("#additional_businesses_amount").val();
                var total_amount=$("#total_amount").val();
                var academic_season_total=$("#academic_season_total").val();
                var vacation_season_total=$("#vacation_season_total").val();
                var security_deposit=$("#security_deposit").val();
                var clientType=$("#client_type").val();




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




                if(client_type=='1'){

                    $("#debtor_name").val(first_name+" "+last_name);

                }else if(client_type=='2'){

                    $("#debtor_name").val(company_name);

                }else{


                }




                $("#debtor_account_code_space").val(official_client_id);
                $("#tin_invoice").val(tin);
                $("#debtor_address_space").val(address);

                $("#invoicing_period_start_date").val(start_date);




                $("#invoicing_period_start_date_alternate").val(start_date_alternate);

                var start_date2=new Date(start_date_alternate);

                var calculated_end_date = new Date(start_date2.setMonth(start_date2.getMonth()+ +payment_cycle));

                var invoicing_period_end_date_alternate = (calculated_end_date.getFullYear() + '-'
                    + ('0' + (calculated_end_date.getMonth()+1)).slice(-2) + '-'+('0' + calculated_end_date.getDate()).slice(-2));



                var invoicing_period_end_date = (('0' + calculated_end_date.getDate()).slice(-2) + '/'
                    + ('0' + (calculated_end_date.getMonth()+1)).slice(-2) + '/'+calculated_end_date.getFullYear());





                $("#invoicing_period_end_date").val(invoicing_period_end_date);
                $("#invoicing_period_end_date_alternate").val(invoicing_period_end_date_alternate);


                $("#currency_invoice").val(currency);


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



        $('#academic_season').on('input',function(e){
            e.preventDefault();
            var academic_season=$(this).val();
            var additional_businesses_amount=$('#additional_businesses_amount').val();

            $('#security_deposit').val((+academic_season  +  +additional_businesses_amount)*6);

        });


        $('#amount').on('input',function(e){
            e.preventDefault();
            var amount=$(this).val();
            var additional_businesses_amount=$('#additional_businesses_amount').val();

            $('#security_deposit').val((+amount  +  +additional_businesses_amount)*6);

        });









    $('#client_type').click(function(){
       var query = $(this).val();
       if(query=='1'){
        $('#namediv').show();
        $('#companydiv').hide();
        $('#company_name').val("");
       }
       else if(query=='2'){
        $('#companydiv').show();
        $('#namediv').hide();
        $('#first_name').val("");
        $('#last_name').val("");
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


            $('#academic_dependence').click(function() {
                var query=$(this).val();

                var academic_season=$('#academic_season').val();
                var amount=$('#amount').val();
                var additional_businesses_amount=$('#additional_businesses_amount').val();
                var has_security_deposit=$('#has_security_deposit').val();


                $('#total_amountDiv').hide();
                $('#academic_season_totalDiv').hide();
                $('#vacation_season_totalDiv').hide();




                if(query=='Yes') {


                    $('#escalation_rate_vacationDiv').show();
                    $('#escalation_rate_academicDiv').show();
                    $('#escalation_rateDiv').hide();

                    document.getElementById("escalation_rate").disabled = true;
                    document.getElementById("escalation_rate_academic").disabled = false;
                    document.getElementById("escalation_rate_vacation").disabled = false;



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


                    if(has_security_deposit=='Yes')
                    {
                        $('#security_deposit').val((+academic_season + +additional_businesses_amount) * 6);
                    }else{
                        //Do Nothing
                    }



                }else if(query=='No'){


                    $('#escalation_rate_vacationDiv').hide();
                    $('#escalation_rate_academicDiv').hide();
                    $('#escalation_rateDiv').show();


                    document.getElementById("escalation_rate").disabled = false;
                    document.getElementById("escalation_rate_academic").disabled = true;
                    document.getElementById("escalation_rate_vacation").disabled = true;







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


                    if(has_security_deposit=='Yes') {
                        $('#security_deposit').val((+amount + +additional_businesses_amount) * 6);
                    }else{
                        //Do Nothing
                    }


                }else{
                    $('#vacationDiv').hide();
                    $('#academicDiv').hide();
                    $('#amountDiv').hide();

                    $('#escalation_rate_vacationDiv').hide();
                    $('#escalation_rate_academicDiv').hide();
                    $('#escalation_rateDiv').hide();


                }



            });




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


    <script>

        $( "#start_date").datepicker({

            dateFormat: 'dd/mm/yy',

            autoclose: true,
            altField: "#start_date_alternate",
            altFormat: "yy-mm-dd",
            todayHighlight: true,
            rtl: true,


            orientation:"auto"
        });



        $( "#invoicing_period_start_date").datepicker({

            dateFormat: 'dd/mm/yy',
            calendarWeeks: true,
            autoclose: true,
            altField: "#invoicing_period_start_date_alternate",
            altFormat: "yy-mm-dd",
            todayHighlight: true,
            rtl: true,

            orientation:"auto"
        });





        $( "#invoicing_period_end_date").datepicker({

            dateFormat: 'dd/mm/yy',
            calendarWeeks: true,
            autoclose: true,

            altField: "#invoicing_period_end_date_alternate",
            altFormat: "yy-mm-dd",
            todayHighlight: true,
            rtl: true,
            orientation:"auto"
        });





    </script>

@endsection
