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
            /*background-color: #9C27B0;*/
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

        #progressbar #renting_space:before {
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



        #progressbar #invoice:before {
            font-family: FontAwesome;
            content: "\f15b"
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
                                    <form id="msform" METHOD="POST" enctype="multipart/form-data"  action="{{ route('create_space_contract')}}">

                                    {{csrf_field()}}

                                    <!-- progressbar -->
                                        <ul id="progressbar">
                                            <li class="active" id="personal"><strong>Client</strong></li>
                                            <li  id="renting_space"><strong>Renting Space</strong></li>
                                            <li id="payment"><strong>Payment</strong></li>
                                            <li id="confirm"><strong>Confirm</strong></li>
{{--                                            <li id="invoice"><strong>Invoice</strong></li>--}}
                                        </ul>
                                        <!-- fieldsets -->
                                        <fieldset>
                                            <div class="form-card">
                                                <h2 class="fs-title">Client Information</h2> <div class="form-group">
                                                    <div class="form-wrapper" id="clientdiv">
                                                        <label for="client_type">Client Category <span style="color: red;"> *</span></label>
                                                        <span id="ctypemsg"></span>
                                                        <select class="form-control"  id="client_type" name="client_type">
                                                            <option value="0" disabled selected hidden>select client category</option>
                                                            <option value="1">Individual</option>
                                                            <option value="2">Company/Organization</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-group row" id="namediv" style="display: none;">







                                                    <div class="form-wrapper col-6">
                                                        <label for="first_name">First Name <span style="color: red;"> *</span></label>
                                                        <span id="name1msg"></span>
                                                        <input type="text" id="first_name" name="first_name" class="form-control"  onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                                                    </div>
                                                    <div class="form-wrapper col-6">
                                                        <label for="last_name">Last Name <span style="color: red;"> *</span></label>
                                                        <span id="name2msg"></span>
                                                        <input type="text" id="last_name"  name="last_name" class="form-control"  onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                                                    </div>
                                                </div>

                                                <div class="form-group" id="companydiv" style="display: none;">
                                                    <div class="form-wrapper">
                                                        <label for="company_name">Company Name <span style="color: red;"> *</span></label>
                                                        <span id="cnamemsg"></span>
                                                        <input type="text" id="company_name"  name="company_name" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">


                                                    <div class="form-wrapper col-12">
                                                        <label for="official_client_id">Client ID<span style="color: red;"> *</span></label>
                                                        <span id="official_client_id_msg"></span>
                                                        <input type="number" id="official_client_id" min="0" name="official_client_id" class="form-control">
                                                    </div>


                                                    <div class="form-wrapper col-6 pt-1">
                                                        <label for="email">Email <span style="color: red;"> *</span></label>
                                                        <span id="email_msg"></span>
                                                        <input type="text" name="email"  id="email" class="form-control" placeholder="someone@example.com" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
                                                    </div>


                                                    <div class="form-wrapper col-6 pt-1">
                                                        <label for="phone_number">Phone Number <span style="color: red;"> *</span></label>
                                                        <span id="phone_msg"></span>
                                                        <input type="text" id="phone_number"  name="phone_number" class="form-control" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
                                                    </div>


                                                </div>


                                                <div class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for="address">Address <span style="color: red;"> *</span></label>
                                                        <span id="address_msg"></span>
                                                        <input type="text" id="address"  name="address" class="form-control">
                                                    </div>
                                                </div>




                                                <div class="form-group">
                                                    <div class="form-wrapper" >
                                                        <label for="client_type_contract">Client Type<span style="color: red;"> *</span></label>
                                                        <span id="ctype_contract_msg"></span>
                                                        <select class="form-control"  id="client_type_contract" name="client_type_contract">
                                                            <option value=""></option>
                                                            <option value="Direct">Direct</option>
                                                            <option value="Direct and has clients">Direct and has clients</option>
                                                            <option value="Indirect">Indirect</option>
                                                        </select>

                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <div id="parent_clientDiv" style="display: none;" class="form-wrapper  pt-1">
                                                        <label for="parent_client"  ><strong>Parent client <span style="color: red;"> *</span></strong></label>
                                                        <span id="parent_client_msg"></span>
                                                        <select id="parent_client"  class="form-control" name="parent_client" >
                                                            <option value="" selected></option>

                                                            <?php
                                                            $parent_clients=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->where('space_contracts.has_clients',1)->get();


                                                            $tempOut = array();
                                                            foreach($parent_clients as $values){
                                                                $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($values));
                                                                $val = (iterator_to_array($iterator,true));
                                                                $tempoIn=$val['full_name'];

                                                                if(!in_array($tempoIn, $tempOut))
                                                                {
                                                                    print('<option value="'.$val['client_id'].'">'.$val['full_name'].'</option>');
                                                                    array_push($tempOut,$tempoIn);
                                                                }

                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>








                                            </div>
                                            <input type="button" name="next" id="next1" class="next action-button" value="Next Step" />
                                            <input type="button" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">
                                            {{-- <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a> --}}
                                        </fieldset>
                                        {{-- Second Form --}}
                                        <fieldset>
                                            <div class="form-card">
                                                <h2 class="fs-title">Renting Space Information</h2>



                                                <div class="form-group row">




                                                    <div class="form-wrapper col-12 pt-1">
                                                        <label for="major_industry"  ><strong>Major industry <span style="color: red;"> *</span></strong></label>
                                                        <span id="major_msg"></span>
                                                        <select id="getMajor"  class="form-control" name="major_industry" >
                                                            <option value="" selected></option>

                                                            <?php
                                                            $major_industries=DB::table('space_classification')->get();


                                                            $tempOut = array();
                                                            foreach($major_industries as $values){
                                                                $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($values));
                                                                $val = (iterator_to_array($iterator,true));
                                                                $tempoIn=$val['major_industry'];

                                                                if(!in_array($tempoIn, $tempOut))
                                                                {
                                                                    print('<option value="'.$val['major_industry'].'">'.$val['major_industry'].'</option>');
                                                                    array_push($tempOut,$tempoIn);
                                                                }

                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-wrapper col-12 pt-2">
                                                        <label for=""  ><strong>Minor industry <span style="color: red;"> *</span></strong></label>
                                                        <span id="minor_msg"></span>
                                                        <select id="minor_list"  class="form-control" name="minor_industry" >


                                                        </select>
                                                    </div>


                                                    <div class="form-wrapper col-12 pt-2">
                                                        <label for="space_location"  ><strong>Location <span style="color: red;"> *</span></strong></label>
                                                        <span id="location_msg"></span>
                                                        <select class="form-control" id="space_location"  name="space_location" >

                                                        </select>
                                                    </div>



                                                    <div class="form-wrapper col-12 pt-2">
                                                        <label for="space_location"  ><strong>Sub location <span style="color: red;"> *</span></strong></label>
                                                        <span id="sub_location_msg"></span>
                                                        <select class="form-control" id="space_sub_location"  name="space_sub_location" >

                                                        </select>


                                                    </div>



                                                    <div class="form-wrapper col-12 pt-2">
                                                        <label for="" ><strong>Space Number <span style="color: red;"> *</span></strong></label>
                                                        <span id="space_id_msg"></span>

                                                        <select class="form-control" id="space_id_contract"  name="space_id_contract" >

                                                        </select>
                                                    </div>




                                                    <input type="hidden" min="1" step="0.01" class="form-control" id="space_size" name="space_size" value=""  autocomplete="off">

                                                    <input type="hidden"  class="form-control" id="has_water_bill" name="has_water_bill" value=""  autocomplete="off">

                                                    <input type="hidden"  class="form-control" id="has_electricity_bill" name="has_electricity_bill" value=""  autocomplete="off">






                                                </div>











                                            </div>
                                            <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                            <input type="button" id="next2" name="next" class="next action-button" value="Next Step" />
                                            <input type="button" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;" />
                                            {{--  <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a> --}}
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
                                                            <input type="number" id="tin" min="0" name="tin" class="form-control">
                                                        </div>
                                                    </div>



                                                    <div id="tbs_certificateDiv" style="display: none;" class="form-group col-6 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for="tbs_certificate">Certificate from TBS(Only pdf format is accepted) <span style="color: red;"> *</span></label>
                                                            <span id="tbs_certificate_msg"></span>
                                                            <input type="file" id="tbs_certificate"  accept=".pdf"  name="tbs_certificate" class="form-control">
                                                        </div>
                                                    </div>


                                                    <div id="gpsa_certificateDiv" style="display: none;"  class="form-group col-6 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for="gpsa_certificate">Certificate from GPSA(Only pdf format is accepted) <span style="color: red;"> *</span></label>
                                                            <span id="gpsa_certificate_msg"></span>
                                                            <input type="file" id="gpsa_certificate" accept=".pdf" name="gpsa_certificate" class="form-control">
                                                        </div>
                                                    </div>


                                                    <div id="food_business_licenseDiv" style="display: none;" class="form-group col-6 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for="food_business_license">Food business license(Only pdf format is accepted) <span style="color: red;"> *</span></label>
                                                            <span id="food_business_license_msg"></span>
                                                            <input type="file" id="food_business_license" accept=".pdf" name="food_business_license" class="form-control">
                                                        </div>
                                                    </div>


                                                    <div style="display: none;" id="business_licenseDiv" class="form-group col-6 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for="business_license">Business license(Only pdf format is accepted)<span style="color: red;"> *</span></label>
                                                            <span id="business_license_msg"></span>
                                                            <input type="file" id="business_license" accept=".pdf" name="business_license" class="form-control">
                                                        </div>
                                                    </div>



                                                    <div style="display: none;" id="osha_certificateDiv" class="form-group col-12 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for="osha_certificate">Certificate from OSHA(Only pdf format is accepted)<span style="color: red;"> *</span></label>
                                                            <span id="osha_certificate_msg"></span>
                                                            <input type="file" id="osha_certificate" accept=".pdf" name="osha_certificate" class="form-control">
                                                        </div>
                                                    </div>


                                                    <div style="display: none;" id="tcra_registrationDiv"  class="form-group col-6 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for="tcra_registration">TCRA registration(Only pdf format is accepted)<span style="color: red;"> *</span></label>
                                                            <span id="tcra_registration_msg"></span>
                                                            <input type="file" accept=".pdf" id="tcra_registration" min="0" name="tcra_registration" class="form-control">
                                                        </div>
                                                    </div>


                                                    <div style="display: none;" id="brela_registrationDiv" class="form-group col-12">
                                                        <div class="form-wrapper">
                                                            <label for="brela_registration">BRELA registration(Only pdf format is accepted)<span style="color: red;"> *</span></label>
                                                            <span id="brela_registration_msg"></span>
                                                            <input type="file" id="brela_registration" accept=".pdf" name="brela_registration" class="form-control">
                                                        </div>
                                                    </div>




                                                    <div class="form-wrapper col-12 pt-4">
                                                        <label for="start_date">Start date of the contract<span style="color: red;"> *</span></label>
                                                        <span id="start_date_msg"></span>
                                                        <input type="date" id="start_date" name="start_date" class="form-control"  min="{{$today}}">
                                                    </div>

                                                    <div class="form-wrapper col-6">
                                                        <label for="duration">Duration <span style="color: red;"> *</span></label>
                                                        <span id="duration_msg"></span>
                                                        <input type="number"  min="1" max="50" id="duration" name="duration" class="form-control"  >
                                                    </div>

                                                    <div class="form-wrapper col-6">
                                                        <label for="currency">Period <span style="color: red;"> *</span></label>
                                                        <span id="duration_period_msg"></span>
                                                        <select id="duration_period" class="form-control" name="duration_period" >
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
                                                        <label for="amount">Amount(Academic season) <span style="color: red;"> *</span></label>
                                                        <span id="academic_season_msg"></span>
                                                        <input type="number" min="20" id="academic_season" name="academic_season" class="form-control" >
                                                    </div>


                                                    <div id="vacationDiv" style="display: none" class="form-wrapper pt-4 col-6">
                                                        <label for="amount">Amount(Vacation season) <span style="color: red;"> *</span></label>
                                                        <span id="vacation_season_msg"></span>
                                                        <input type="number" min="20" id="vacation_season" name="vacation_season" class="form-control" >
                                                    </div>

                                                    <div id="amountDiv" style="display: none" class="form-wrapper pt-4 col-12">
                                                        <label for="amount">Amount <span style="color: red;"> *</span></label>
                                                        <span id="amount_msg"></span>
                                                        <input type="number" min="20" id="amount" name="amount" class="form-control" >
                                                    </div>

                                                    <div id="rent_sqmDiv"  class="form-wrapper pt-4 col-12">
                                                        <label for="rent_sqm">Rent/SQM <span >(Leave empty if not applicable)</span></label>
                                                        <input type="number" min="1" id="rent_sqm" name="rent_sqm"  class="form-control">
                                                    </div>

                                                    <div id="has_additional_businessesDiv" class="form-wrapper pt-4 col-12" style="display: none; text-align: left;">

                                                        <label for="has_additional_businesses" style="display: inline-block;">Has additional businesses in the area</label>
                                                        <input type="checkbox"  style="display: inline-block;" value="1" id="has_additional_businesses" onchange="showAdditionalBusinesses()"  name="has_additional_businesses" autocomplete="off">

                                                    </div>



                                                    <div id="additional_businesses_listDiv" class="form-wrapper pt-4 col-12" style="display: none;">
                                                        <label for="">List of the businesses (Comma separated):</label>
                                                        <span id="additional_businesses_list_msg"></span>
                                                        <textarea style="width: 100%;" id="additional_businesses_list" name="additional_businesses_list"></textarea>

                                                    </div>


                                                    <div id="additional_businesses_amountDiv" style="display: none;" class="form-wrapper pt-4 col-12">
                                                        <label for="additional_businesses_amount">Amount expected from the businesses<span style="color: red;"> *</span></label>
                                                        <span id="additional_businesses_amount_msg"></span>
                                                        <input type="number" min="20" id="additional_businesses_amount" name="additional_businesses_amount" class="form-control">
                                                    </div>

                                                    <div id="total_amountDiv" style="display: none;" class="form-wrapper pt-4 col-12">
                                                        <label for="total_amount">Total amount<span style="color: red;"> *</span></label>
                                                        <span id="total_amount_msg"></span>
                                                        <input type="text" min="20" id="total_amount" readonly name="total_amount" class="form-control">
                                                    </div>


                                                    <div id="academic_season_totalDiv" style="display: none" class="form-wrapper pt-4 col-6">
                                                        <label for="academic_season_total">Total amount(Academic season) <span style="color: red;"> *</span></label>
                                                        <span id="academic_season_total_msg"></span>
                                                        <input type="text" readonly id="academic_season_total" name="academic_season_total" class="form-control">
                                                    </div>


                                                    <div id="vacation_season_totalDiv" style="display: none" class="form-wrapper pt-4 col-6">
                                                        <label for="vacation_season_total">Total amount(Vacation season) <span style="color: red;"> *</span></label>
                                                        <span id="vacation_season_total_msg"></span>
                                                        <input type="text" readonly id="vacation_season_total" name="vacation_season_total" class="form-control">
                                                    </div>


                                                    <div id="security_depositDiv" style="display: none" class="form-wrapper pt-4 col-12">
                                                        <label for="security_deposit">Security deposit<span style="color: red;"> *</span></label>
                                                        <span id="security_deposit_msg"></span>
                                                        <input type="number" min="20" id="security_deposit" name="security_deposit" class="form-control" >
                                                    </div>



                                                    <div id="currencydiv" class="form-wrapper col-12">
                                                        <label for="currency">Currency <span style="color: red;"> *</span></label>
                                                        <span id="currency_msg"></span>
                                                        <select id="currency" class="form-control"  name="currency">
                                                            <option value="" ></option>
                                                            <option value="TZS" >TZS</option>
                                                            <option value="USD" >USD</option>
                                                        </select>
                                                    </div>



                                                </div>

                                                <div class="form-group row">

                                                    <div class="form-wrapper col-6">
                                                        <label for="payment_cycle">Payment cycle duration(in months) <span style="color: red;"> *</span></label>
                                                        <span id="payment_cycle_msg"></span>
                                                        <input type="number" min="1" id="payment_cycle" name="payment_cycle" class="form-control">

                                                    </div>

                                                    <div class="form-wrapper col-6">
                                                        <label for="escalation_rate">Escalation Rate <span style="color: red;"> *</span></label>
                                                        <span id="escalation_rate_msg"></span>
                                                        <input type="number" min="0" id="escalation_rate" name="escalation_rate" class="form-control" >
                                                    </div>


                                                </div>




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
                                            <input type="button" id="next4" name="next" class="next action-button" value="Next" />
                                            <input type="button" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">
                                            {{-- <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a> --}}

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



                                                    <div class="form-group col-6 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Invoice Start Date</label>
                                                            <input type="date" class="form-control" id="invoicing_period_start_date" name="invoicing_period_start_date" value="" required autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div  class="form-group col-6 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for="">Invoice End Date</label>
                                                            <input type="date" class="form-control" id="invoicing_period_end_date" name="invoicing_period_end_date" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div class="form-group col-6 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for="">Period </label>
                                                            <input type="text" class="form-control" id="" name="period" value=""  required  autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div   class="form-group col-6 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for=""  >Project ID </label>
                                                            <input type="text" class="form-control" id="" name="project_id" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>




                                                    <div  class="form-group col-6 pt-4">
                                                        <div class="form-wrapper">
                                                            <label for="">Amount </label>
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
                                                            <label for="" >Status </label>
                                                            <input type="text" class="form-control" id="status" name="status" value="" required  autocomplete="off">
                                                        </div>
                                                    </div>


                                                    <div  class="form-group col-md-12 mt-1">
                                                        <div class="form-wrapper">
                                                            <label for="" >Description</label>
                                                            <input type="text" class="form-control" id="description" name="description" value="" required autocomplete="off">
                                                        </div>
                                                    </div>


                                                </div>








                                            </div>
                                            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                            <input type="submit" name="submit" class="submit action-button" value="Save"/>
                                            <input type="submit" name="submit" class="submit action-button" value="Save and print"/>
                                            <input type="button" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">


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





        $('#client_type_contract').on('change',function(e){
            e.preventDefault();
            var client_type_contract = $(this).val();

            if (client_type_contract=='Indirect'){
                $('#parent_clientDiv').show();


            }else{

                $('#parent_clientDiv').hide();

            }



        });







    </script>




    <script type="text/javascript">
        $(document).ready(function(){

            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;
            var p1, p2,p3,p4,p5,p6,p7;


            var temp;

            $('#client_type_contract').on('change',function(e){
                e.preventDefault();
                var query=$(this).val();
                if(query=='Direct and has clients'){

                    $('#renting_space').hide();
                    properNext();

                }else{

                    $('#renting_space').show();
                    properNextZero();

                }


            });


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

                }else{

                    $('#total_amount').val(+amount  +  +additional_businesses_amount);

                }






            });




            function properNext(){
                temp=1;
            }

            function properNextZero(){
                temp=0;
            }



            $("#next1").click(function(){

                if(temp==1) {
                    next_fs = $(this).parent().next().next();
                }else{
                    next_fs = $(this).parent().next();
                }

                current_fs = $(this).parent();


                var clientType=$("#client_type").val(),
                    firstName=$("#first_name").val(),
                    lastName=$("#last_name").val(),
                    companyName=$("#company_name").val();
                var email=$("#email").val();
                var address=$("#address").val();

                var official_client_id=$("#official_client_id").val();
                var client_type_contract=$("#client_type_contract").val();
                var parent_client=$("#parent_client").val();


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


                    if(email==""){
                        p1=0;
                        $('#email_msg').show();
                        var message=document.getElementById('email_msg');
                        message.style.color='red';
                        message.innerHTML="Required";
                        $('#email').attr('style','border-bottom:1px solid #f00');
                    }
                    else{
                        p1=1;
                        $('#email_msg').hide();
                        $('#email').attr('style','border-bottom: 1px solid #ccc');

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


                    if(email==""){
                        p1=0;
                        $('#email_msg').show();
                        var message=document.getElementById('email_msg');
                        message.style.color='red';
                        message.innerHTML="Required";
                        $('#email').attr('style','border-bottom:1px solid #f00');
                    }
                    else{
                        p1=1;
                        $('#email_msg').hide();
                        $('#email').attr('style','border-bottom: 1px solid #ccc');

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


                if(address==""){
                    p3=0;
                    $('#address_msg').show();
                    var message=document.getElementById('address_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#address').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p3=1;
                    $('#address_msg').hide();
                    $('#address').attr('style','border-bottom: 1px solid #ccc');

                }








                if(official_client_id==""){
                    p5=0;
                    $('#official_client_id_msg').show();
                    var message=document.getElementById('official_client_id_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#official_client_id').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p5=1;
                    $('#official_client_id_msg').hide();
                    $('#official_client_id').attr('style','border-bottom: 1px solid #ccc');

                }



                if(client_type_contract==""){
                    p6=0;
                    $('#ctype_contract_msg').show();
                    var message=document.getElementById('ctype_contract_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#client_type_contract').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p6=1;
                    $('#ctype_contract_msg').hide();
                    $('#client_type_contract').attr('style','border-bottom: 1px solid #ccc');

                }


                if(parent_client==""){
                    p7=0;
                    $('#parent_client_msg').show();
                    var message=document.getElementById('parent_client_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#parent_client').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p7=1;
                    $('#parent_client_msg').hide();
                    $('#parent_client').attr('style','border-bottom: 1px solid #ccc');

                }

                if (client_type_contract=='Indirect'){

                    $('#business_licenseDiv').hide();
                    $('#contract_categoryDiv').hide();
                    $('#has_additional_businessesDiv').hide();

                    $('#security_depositDiv').hide();


                    $('#percentage_to_payDiv').hide();
                    $('#academic_dependenceDiv').show();
                    // $('#academicDiv').show();
                    // $('#vacationDiv').show();
                    // $('#amountDiv').show();
                    $('#rent_sqmDiv').show();
                    $('#currencydiv').show();


                    if(p1=='1' & p2=='1' & p3=='1'  & p5=='1' & p6=='1' & p7=='1' ){
                        gonext();
                    }


                }else if(client_type_contract=='Direct and has clients'){







                    $('#percentage_to_payDiv').show();
                    $('#business_licenseDiv').show();

                    $('#academic_dependenceDiv').hide();
                    $('#academicDiv').hide();
                    $('#vacationDiv').hide();
                    $('#amountDiv').hide();
                    $('#rent_sqmDiv').hide();
                    $('#currencydiv').hide();

                    $('#contract_categoryDiv').hide();
                    $('#has_additional_businessesDiv').hide();

                    $('#security_depositDiv').hide();


                    if(p1=='1' & p2=='1' & p3=='1'  & p5=='1' & p6=='1' ){
                        gonext();
                    }

                }

                else{
                    $('#business_licenseDiv').hide();
                    $('#percentage_to_payDiv').hide();
                    $('#academic_dependenceDiv').show();
                    $('#contract_categoryDiv').show();
                    $('#has_additional_businessesDiv').show();
                    $('#security_depositDiv').show();

                    $('#rent_sqmDiv').show();
                    $('#currencydiv').show();


                    if(p1=='1' & p2=='1' & p3=='1'  & p5=='1' & p6=='1' ){
                        gonext();
                    }

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
                var p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19,p20,p21,p22,p23,p26;
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
                    p10=0;
                    $('#escalation_rate_msg').show();
                    var message=document.getElementById('escalation_rate_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#escalation_rate').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p10=1;
                    $('#escalation_rate_msg').hide();
                    $('#escalation_rate').attr('style','border-bottom: 1px solid #ccc');

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



                if(tbs_certificate==""){
                    p14=0;
                    $('#tbs_certificate_msg').show();
                    var message=document.getElementById('tbs_certificate_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#tbs_certificate').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p14=1;
                    $('#tbs_certificate_msg').hide();
                    $('#tbs_certificate').attr('style','border-bottom: 1px solid #ccc');

                }



                if(gpsa_certificate==""){
                    p15=0;
                    $('#gpsa_certificate_msg').show();
                    var message=document.getElementById('gpsa_certificate_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#gpsa_certificate').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p15=1;
                    $('#gpsa_certificate_msg').hide();
                    $('#gpsa_certificate').attr('style','border-bottom: 1px solid #ccc');

                }


                if(food_business_license==""){
                    p16=0;
                    $('#food_business_license_msg').show();
                    var message=document.getElementById('food_business_license_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#food_business_license').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p16=1;
                    $('#food_business_license_msg').hide();
                    $('#food_business_license').attr('style','border-bottom: 1px solid #ccc');

                }


                if(business_license==""){
                    p17=0;
                    $('#business_license_msg').show();
                    var message=document.getElementById('business_license_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#business_license').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p17=1;
                    $('#business_license_msg').hide();
                    $('#business_license').attr('style','border-bottom: 1px solid #ccc');

                }


                if(osha_certificate==""){
                    p18=0;
                    $('#osha_certificate_msg').show();
                    var message=document.getElementById('osha_certificate_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#osha_certificate').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p18=1;
                    $('#osha_certificate_msg').hide();
                    $('#osha_certificate').attr('style','border-bottom: 1px solid #ccc');

                }



                if(tcra_registration==""){
                    p19=0;
                    $('#tcra_registration_msg').show();
                    var message=document.getElementById('tcra_registration_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#tcra_registration').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p19=1;
                    $('#tcra_registration_msg').hide();
                    $('#tcra_registration').attr('style','border-bottom: 1px solid #ccc');

                }




                if(brela_registration==""){
                    p20=0;
                    $('#brela_registration_msg').show();
                    var message=document.getElementById('brela_registration_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#brela_registration').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p20=1;
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




                if(security_deposit==""){
                    p26=0;
                    $('#security_deposit_msg').show();
                    var message=document.getElementById('security_deposit_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#security_deposit').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p26=1;
                    $('#security_deposit_msg').hide();
                    $('#security_deposit').attr('style','border-bottom: 1px solid #ccc');

                }


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



        if(academic_dependence=='Yes'){

            if(client_type_contract=='Direct and has clients'){


                //Additional businesses start

                if( $('#has_additional_businesses').prop('checked') ) {


                    var academic_dependence=$('#academic_dependence').val();

                    if(academic_dependence=='Yes'){

                        if(minor=="Canteen"){


                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1'  & p14=='1' & p15=='1' & p16=='1' & p26=='1'){
                                gonext();
                            }




                        }else if(major=='Banking'){


                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1'    & p17=='1' & p18=='1'  & p26=='1'){
                                gonext();
                            }

                        }else if (minor=="Postal services"){


                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1'   & p15=='1'  & p17=='1' & p19=='1' & p20=='1' & p26=='1'){
                                gonext();
                            }


                        }else{

                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1'   & p17=='1'  & p26=='1'){
                                gonext();
                            }

                        }



                    }else{




                        if(minor=="Canteen"){



                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1'  & p14=='1' & p15=='1' & p16=='1'  & p23=='1' & p26=='1'){
                                gonext();
                            }




                        }else if(major=='Banking'){


                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1'    & p17=='1' & p18=='1' & p23=='1' & p26=='1'){
                                gonext();
                            }

                        }else if (minor=="Postal services"){


                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1'   & p15=='1'  & p17=='1' & p19=='1' & p20=='1' & p23=='1' & p26=='1'){
                                gonext();
                            }


                        }else{

                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1'     & p17=='1' & p23=='1' & p26=='1'){
                                gonext();
                            }

                        }









                    }





                }else{




                }

                //Additional businesses end








            }

            else{


                //Additional businesses start

                if( $('#has_additional_businesses').prop('checked') ) {


                    var academic_dependence=$('#academic_dependence').val();

                    if(academic_dependence=='Yes'){

                        if(minor=="Canteen"){



                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p5=='1' & p6=='1' & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1' & p26=='1'){
                                gonext();
                            }




                        }else if(major=='Banking'){



                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p5=='1' & p6=='1' & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p17=='1' & p18=='1' & p26=='1'){
                                gonext();
                            }


                        }else if (minor=="Postal services"){


                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1' & p13=='1'  & p15=='1'  & p17=='1' & p19=='1' & p20=='1' & p26=='1'){
                                gonext();
                            }


                        }else{

                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1' & p13=='1'  & p17=='1'  & p26=='1'){
                                gonext();
                            }

                        }



                    }else{




                        if(minor=="Canteen"){



                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1'  & p23=='1' & p26=='1'){
                                gonext();
                            }




                        }else if(major=='Banking'){


                            if(p1=='1' & p2=='1' & p3=='1'    & p9=='1' & p10=='1' & p11=='1' & p12=='1' & p13=='1'   & p17=='1' & p18=='1' & p23=='1' & p26=='1'){
                                gonext();
                            }

                        }else if (minor=="Postal services"){





                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p5=='1' & p6=='1' & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p15=='1'  & p17=='1' & p19=='1' & p20=='1' & p23=='1' & p26=='1'){
                                gonext();
                            }



                        }else{




                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p5=='1' & p6=='1' & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p17=='1' & p23=='1' & p26=='1'){
                                gonext();
                            }


                        }









                    }





                }else{




                }

                //Additional businesses end





            }



        }else if(academic_dependence=='No'){


            if(client_type_contract=='Direct and has clients'){


                if(p1=='1' & p2=='1' & p3=='1'  & p9=='1' & p10=='1' & p11=='1' & p12=='1'  & p26=='1'){
                    gonext();
                }


            }

            else{

                //Additional businesses start

                if( $('#has_additional_businesses').prop('checked') ) {


                    var academic_dependence=$('#academic_dependence').val();

                    if(academic_dependence=='Yes'){

                        if(minor=="Canteen"){





                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1' & p26=='1'){
                                gonext();
                            }




                        }else if(major=='Banking'){



                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p17=='1' & p18=='1' & p26=='1'){
                                gonext();
                            }


                        }else if (minor=="Postal services"){





                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p15=='1'  & p17=='1' & p19=='1' & p20=='1' & p26=='1'){
                                gonext();
                            }


                        }else{



                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p17=='1' & p26=='1'){
                                gonext();
                            }

                        }



                    }else{




                        if(minor=="Canteen"){





                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1'  & p23=='1' & p26=='1'){
                                gonext();
                            }




                        }else if(major=='Banking'){





                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p17=='1' & p18=='1' & p23=='1' & p26=='1'){
                                gonext();
                            }


                        }else if (minor=="Postal services"){








                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p15=='1'  & p17=='1' & p19=='1' & p20=='1' & p23=='1' & p26=='1'){
                                gonext();
                            }



                        }else{






                            if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p7=='1'  & p8=='1' & p9=='1' & p10=='1' & p12=='1' & p13=='1' & p17=='1' & p23=='1' & p26=='1'){
                                gonext();
                            }


                        }









                    }





                }else{




                }

                //Additional businesses end








            }




        }else{
//logically cannot be excecuted
            if(p1=='1' & p2=='1' & p3=='1'  & p9=='1' & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p26=='1'){
                gonext();
            }

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

                var start_date2=new Date(start_date);

                var calculated_end_date = new Date(start_date2.setMonth(start_date2.getMonth()+ +payment_cycle));

               var MyDateString = (calculated_end_date.getFullYear() + '-'
                    + ('0' + (calculated_end_date.getMonth()+1)).slice(-2) + '-'+('0' + calculated_end_date.getDate()).slice(-2));








                $("#invoicing_period_end_date").val(MyDateString);

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









            $('#client_type').click(function(){
                var query = $(this).val();
                if(query=='1'){
                    $('#namediv').show();
                    $('#companydiv').hide();
                    var ele4 = document.getElementById("company_name");
                    ele4.required = false;

                    var ele5 = document.getElementById("first_name");
                    ele5.required = true;

                    var ele6 = document.getElementById("last_name");
                    ele6.required = true;


                    $('#company_name').val("");
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

        $('#getMajor').on('input',function(e){
            e.preventDefault();
            var major = $(this).val();


            if(major != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('generate_minor_list') }}",
                    method:"POST",
                    data:{major:major, _token:_token},
                    success:function(data){
                        if(data=='0'){

                        }
                        else{


                            $('#minor_list').html(data);
                        }
                    }
                });
            }
            else if(major==''){

            }
        });



        $('#minor_list').on('input',function(e){
            e.preventDefault();
            var minor = $(this).val();
            var major = $('#getMajor').val();

            if(minor != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('generate_location_list') }}",
                    method:"POST",
                    data:{minor:minor,major:major, _token:_token},
                    success:function(data){
                        if(data=='0'){

                        }
                        else{


                            $('#space_location').html(data);
                        }
                    }
                });
            }
            else if(minor==''){

            }
        });



        $('#space_location').on('input',function(e){
            e.preventDefault();
            var location = $(this).val();
            var minor = $('#minor_list').val();
            var major = $('#getMajor').val();

            if(location != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('generate_sub_location_list') }}",
                    method:"POST",
                    data:{location:location,major:major,minor:minor, _token:_token},
                    success:function(data){
                        if(data=='0'){

                        }
                        else{

                            $('#space_sub_location').html(data);
                        }
                    }
                });
            }
            else if(location==''){

            }
        });



        $('#space_sub_location').on('click',function(e){
            e.preventDefault();
            var sub_location = $(this).val();
            var location = $('#space_location').val();
            var minor = $('#minor_list').val();
            var major = $('#getMajor').val();


            if(sub_location != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('generate_space_id_list') }}",
                    method:"POST",
                    data:{sub_location:sub_location,location:location,major:major,minor:minor, _token:_token},
                    success:function(data){
                        if(data=='0'){

                        }
                        else{

                            $('#space_id_contract').html(data);
                        }
                    }
                });
            }
            else if(sub_location==''){

            }
        });



    </script>




@endsection
