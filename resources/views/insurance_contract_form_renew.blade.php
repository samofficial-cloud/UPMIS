
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
            margin-left: 20%;
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

        #progressbar #vehicle:before {
            font-family: FontAwesome;
            content: "\f1b9"
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
            <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>

                @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

                    <li><a href="/businesses"><i class="fa fa-building" aria-hidden="true"></i> Businesses</a></li>
                @else
                @endif

            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
                <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="#"><i class="fas fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
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
                            <h2><strong>Insurance Contract Information</strong></h2>

                            <div class="row">
                                <div class="col-md-12 mx-0">
                                    <form id="msform" METHOD="GET" action="{{ route('create_insurance_contract')}}">
                                        <!-- progressbar -->
                                        <ul id="progressbar">
                                            <li class="active" id="personal"><strong>Insurance</strong></li>
                                            <li id="payment"><strong>Payment</strong></li>
                                            <li id="confirm"><strong>Confirm</strong></li>
                                        </ul>
                                        <!-- fieldsets -->
                                        @foreach($contract_data as $var)

                                        <fieldset>
                                            <div class="form-card">
                                                <h2 style="text-align: center" class="fs-title">Insurance Information</h2>
                                                <div class="form-group">


                                                    <div class="form-group row">

                                                        <div class="form-wrapper col-12">
                                                            <br>
                                                            <label for="insurance_class"><strong>Class <span style="color: red;"> *</span></strong></label>
                                                            <span id="class_msg"></span>
                                                            <select id="insurance_class" class="form-control" readonly Required name="insurance_class">

                                                                <option value="{{$var->insurance_class}}" selected>{{$var->insurance_class}}</option>

                                                            </select>


                                                        </div>



                                                        <div class="form-wrapper col-12">
                                                            <br>
                                                            <label for="client_type"><strong>Principal <span style="color: red;"> *</span></strong></label>
                                                            <span id="principal_msg"></span>
                                                            <?php
                                                            $companies=DB::table('insurance_parameters')->get();
                                                            ?>
                                                            <select id="insurance_company" class="form-control" readonly name="insurance_company">
                                                                <option value="{{$var->principal}}">{{$var->principal}}</option>

                                                            </select>
                                                        </div>



                                                        <div id="TypeDiv" style="display: none;" class="form-wrapper col-12">
                                                            <br>
                                                            <label for="insurance_type"  ><strong>Type <span style="color: red;"> *</span></strong></label>
                                                            <span id="itype_msg"></span>
                                                            <select id="insurance_type"  class="form-control" readonly name="insurance_type" >

                                                                @if($var->insurance_type=="N/A")
                                                                    <option value="{{$var->insurance_type}}" id="Option" selected>{{$var->insurance_type}}</option>
                                                                @elseif($var->insurance_type=="THIRD PARTY")
                                                                    <option value="{{$var->insurance_type}}" id="Option" selected>{{$var->insurance_type}}</option>
                                                                @elseif($var->insurance_type=="COMPREHENSIVE")
                                                                    <option value="{{$var->insurance_type}}" id="Option" selected>{{$var->insurance_type}}</option>
                                                                @else
                                                                @endif

                                                            </select>
                                                        </div>

                                                        <div id="TypeDivNA" style="display: none;" class="form-wrapper col-12">
                                                            <br>
                                                            <label for="insurance_type_na"><strong>Type <span style="color: red;"> *</span></strong></label>
                                                            <input type="text" class="form-control" id="insurance_type_na" name="insurance_type" readonly  value="N/A" autocomplete="off">

                                                        </div>





                                                        <div class="form-wrapper col-12">
                                                            <br>
                                                            <label for="space_location"  ><strong>Client Name</strong> <span style="color: red;"> *</span></label>
                                                            <span id="client_msg"></span>
                                                            <input type="text" id="full_name" value="{{$var->full_name}}" name="full_name" readonly class="form-control" required>
                                                            <div id="nameListClientName"></div>
                                                        </div>






                                                        <div class="form-wrapper col-6 pt-4">
                                                            <label for="phone_number">Phone Number <span style="color: red;"> *</span></label>
                                                            <span id="phone_msg"></span>
                                                            <input type="text" id="phone_number" readonly value="{{$var->phone_number}}" name="phone_number" class="form-control" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
                                                        </div>

                                                        <div class="form-wrapper col-6 pt-4">
                                                            <label for="email">Email <span style="color: red;"> *</span></label>
                                                            <span id="email_msg"></span>
                                                            <input type="text" name="email" value="{{$var->email}}" id="email" readonly class="form-control" placeholder="someone@example.com" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="50">
                                                        </div>


                                                        @if($var->vehicle_registration_no=='')
                                                            @else
                                                        <div class="form-wrapper col-12">
                                                            <br>
                                                            <label for="client_type"><strong>Vehicle Registration Number</strong></label>
                                                            <span id="v_regno_msg"></span>

                                                            <input type="text" id="vehicle_registration_no" value="{{$var->vehicle_registration_no}}" name="vehicle_registration_no" readonly class="form-control" >
                                                            <div id="nameListVehicleRegistrationNumber"></div>
                                                        </div>

                                                        <br>
                                                        <div class="form-wrapper col-12">
                                                            <label for="vehicle_use"  ><strong>Vehicle Use</strong></label>
                                                            <span id="v_use_msg"></span>
                                                            <select class="form-control" id="vehicle_use" readonly name="vehicle_use">
                                                                <option value="{{$var->vehicle_use}}" selected id="Option">{{$var->vehicle_use}}</option>

                                                            </select>
                                                        </div>

                                                        @endif






                                                    </div>





                                                </div>

                                                <p id="availability_status"></p>
                                                <br>
                                                <br>

                                            </div>
                                            <input type="button" name="next" id="next1" class="next action-button" value="Next Step" />
                                            <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a>
                                        </fieldset>




                                            {{-- Third Form --}}
                                            <fieldset>
                                                <div class="form-card">
                                                    <h2 class="fs-title">Payment Information</h2>
                                                    <div class="form-group row">
                                                        <div class="form-wrapper col-12">
                                                            <label for="start_date">Commission Date <span style="color: red;"> *</span></label>
                                                            <span id="commission_date_msg"></span>
                                                            <input type="date" id="commission_date" name="commission_date" class="form-control" required="" min="{{$today}}">
                                                        </div>
                                                        {{--                    <div class="form-wrapper col-6">--}}
                                                        {{--                        <label for="duration">Duration <span style="color: red;"> *</span></label>--}}
                                                        {{--                    </div>--}}
                                                        <input type="hidden"  min="1" max="50" id="duration" name="duration" class="form-control" value="1" >



                                                        <input type="hidden"  id="duration_period" name="duration_period" class="form-control" value="Years" >


                                                    </div>

                                                    <div class="form-group row">

                                                        <div class="form-wrapper col-12">
                                                            <label for="amount">Sum Insured <span style="color: red;"> *</span></label>
                                                            <span id="sum_insured_msg"></span>
                                                            <input type="number" min="20" id="sum_insured" name="sum_insured" class="form-control" required="">
                                                        </div>

                                                        {{--                        <div class="form-wrapper col-6">--}}
                                                        {{--                            <label for="amount">Premium <span style="color: red;"> *</span></label>--}}
                                                        {{--                        </div>--}}
                                                        <div id="premiumDiv" class="form-wrapper col-12" style="display: none;">
                                                            <label for="amount">Premium </label>
                                                            <span id="premium_msg"></span>
                                                            <input type="number" min="0" id="premium" readonly name="premium" class="form-control" >
                                                        </div>

                                                        <div id="mode_of_paymentDiv" class="form-wrapper col-12" style="display: none;">
                                                            <label for="mode_of_payment">Mode of payment <span style="color: red;"> *</span></label>
                                                            <span id="mode_of_payment_msg"></span>
                                                            <select id="mode_of_payment" class="form-control" name="mode_of_payment" >
                                                                <option value="" ></option>
                                                                <option value="By installment" >By installment</option>
                                                                <option value="Full payment" >Full payment</option>
                                                            </select>
                                                        </div>




                                                        <div id="first_installmentDiv" class="form-wrapper col-6 pt-4" style="display: none;">
                                                            <label for="amount">First installment(60%) </label>
                                                            <input type="text" id="first_installment" readonly name="first_installment" class="form-control">
                                                        </div>


                                                        <div id="second_installmentDiv" class="form-wrapper col-6 pt-4" style="display: none;">
                                                            <label for="amount">Second installment(40%) </label>
                                                            <input type="text" id="second_installment" readonly name="second_installment" class="form-control">
                                                        </div>




                                                    </div>

                                                    <div class="form-group row">

                                                        <div class="form-wrapper col-12">
                                                            <label for="amount">Actual (Excluding VAT) <span style="color: red;"> *</span></label>
                                                            <span id="actual_ex_vat_msg"></span>
                                                            <input type="number" min="20" id="actual_ex_vat" name="actual_ex_vat" class="form-control" required="">
                                                        </div>

                                                        @if($var->vehicle_registration_no=='N/A')
                                                            <div id="valueDiv"  class="form-wrapper col-12">
                                                                <label for="amount">Value <span style="color: red;"> *</span></label>
                                                                <span id="value_msg"></span>
                                                                <input type="number" min="20" id="value" name="value" class="form-control" >
                                                            </div>
                                                        @else
                                                        @endif




                                                    </div>

                                                    <div class="form-group row">

                                                        {{--                                        <div class="form-wrapper col-6">--}}
                                                        {{--                                            <label for="amount">Commission(%) <span style="color: red;"> *</span></label>--}}
                                                        {{--                                        </div>--}}
                                                        <input type="hidden" min="1"  step="0.01" class="form-control"  readonly name="commission_percentage"  value=""  id="commission_percentage" autocomplete="off">

                                                        {{--                                        <div class="form-wrapper col-6">--}}
                                                        {{--                                            <label for="amount">Commission <span style="color: red;"> *</span></label>--}}
                                                        {{--                                        </div>--}}
                                                        <input type="hidden" min="10" step="0.01" id="commission" readonly class="form-control" name="commission" value=""  autocomplete="off">


                                                        <div class="form-wrapper col-12">
                                                            <label for="currency">Currency <span style="color: red;"> *</span></label>
                                                            <span id="currency_msg"></span>

                                                            <input type="text" id="currency" class="form-control" readonly required name="currency">
                                                        </div>

                                                        @if($var->vehicle_registration_no=='N/A')
                                                        @else
                                                        <div id="cover_noteDiv"  class="form-wrapper col-6">
                                                            <label for="amount">Cover note<span style="color: red;"> *</span></label>
                                                            <span id="cover_note_msg"></span>
                                                            <input type="text" id="cover_note" name="cover_note" class="form-control">
                                                        </div>

                                                        <div id="sticker_noDiv"  class="form-wrapper col-6">
                                                            <label for="amount">Sticker number <span style="color: red;"> *</span></label>
                                                            <span id="sticker_no_msg"></span>
                                                            <input type="text" id="sticker_no" name="sticker_no" class="form-control">
                                                        </div>
                                                        @endif


                                                        <div class="form-wrapper col-12">
                                                            <label for="amount">Receipt Number <span style="color: red;"> *</span></label>
                                                            <span id="receipt_no_msg"></span>
                                                            <input type="text" id="receipt_no" name="receipt_no" class="form-control" required="">
                                                        </div>


                                                    </div>


                                                </div>
                                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                                <input type="button" id="next2" name="next" class="next action-button" value="Next"/>
                                                <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a>
                                            </fieldset>




                                            <fieldset>
                                                <div class="form-card">
                                                    <h2 style="text-align: center !important;" class="fs-title">Full contract details</h2>
                                                    <table class="table table-bordered table-striped" style="width: 100%; margin-top:3%;">



                                                        <tr>
                                                            <td>Insurance class</td>
                                                            <td id="insurance_class_confirm"></td>
                                                        </tr>


                                                        <tr>
                                                            <td>Principal:</td>
                                                            <td id="insurance_company_confirm"></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Insurance type</td>
                                                            <td id="insurance_type_confirm"> </td>
                                                        </tr>


                                                        <tr>
                                                            <td>Client name:</td>
                                                            <td id="client_name_confirm"> </td>
                                                        </tr>

                                                        <tr>
                                                            <td> Phone number:</td>
                                                            <td id="phone_number_confirm"></td>
                                                        </tr>


                                                        <tr>
                                                            <td> Email:</td>
                                                            <td id="email_confirm"> </td>
                                                        </tr>

                                                        <tr id="vehicle_registration_no_row_confirm" style="display: none;">
                                                            <td> Vehicle Registration Number:</td>
                                                            <td id="vehicle_registration_no_confirm"> </td>
                                                        </tr>


                                                        <tr id="vehicle_use_row_confirm" style="display: none;">
                                                            <td>Vehicle Use:</td>
                                                            <td id="vehicle_use_confirm"></td>
                                                        </tr>



                                                        <tr>
                                                            <td>Commission date:</td>
                                                            <td id="commission_date_confirm"></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Duration:</td>
                                                            <td><b>1 year</b></td>
                                                        </tr>


                                                        <tr>
                                                            <td>Sum insured:</td>
                                                            <td id="sum_insured_confirm"></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Premium:</td>
                                                            <td id="premium_confirm"></td>
                                                        </tr>



                                                        <tr id="mode_of_payment_row_confirm" style="display: none;">
                                                            <td>Mode of payment:</td>
                                                            <td id="mode_of_payment_confirm"></td>
                                                        </tr>


                                                        <tr id="first_installment_row_confirm" style="display: none;">
                                                            <td>First installment:</td>
                                                            <td id="first_installment_confirm"></td>
                                                        </tr>


                                                        <tr id="second_installment_row_confirm" style="display: none;">
                                                            <td>Second installment:</td>
                                                            <td id="second_installment_confirm"></td>
                                                        </tr>



                                                        <tr>
                                                            <td>Actual (Excluding VAT):</td>
                                                            <td id="actual_ex_vat_confirm"></td>
                                                        </tr>


                                                        <tr id="value_row_confirm" style="display: none;" >
                                                            <td>Value:</td>
                                                            <td id="value_confirm"></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Commission percentage:</td>
                                                            <td id="commission_percentage_confirm"></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Commission:</td>
                                                            <td id="commission_confirm"></td>
                                                        </tr>


                                                        <tr id="cover_note_row_confirm" style="display: none;">
                                                            <td>Cover note:</td>
                                                            <td id="cover_note_confirm"></td>
                                                        </tr>

                                                        <tr id="sticker_no_row_confirm" style="display: none;">
                                                            <td>Sticker number:</td>
                                                            <td id="sticker_no_confirm"></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Receipt number:</td>
                                                            <td id="receipt_no_confirm"></td>
                                                        </tr>







                                                    </table>


                                                </div>
                                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                                <input type="submit" name="submit" class="submit action-button" value="Save"/>
                                                <input type="submit" name="submit" class="submit action-button" value="Save and print"/>
                                                <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a>
                                            </fieldset>



                                        @endforeach

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

    <script type="text/javascript">
        window.onload=function(){


            var query=$('#insurance_class').val();
            // if(query=='MOTOR'){
            //     $('#vehicle').show();
            //     properNextZero();
            // }else{
            //     $('#vehicle').hide();
            //     properNext();
            //     $('#vehicle_registration_no').val("");
            //     $('#vehicle_use').val("");
            // }



                var query3=$('#insurance_class').val();
                if(query3!=''){

                    $('#insurance_companyDiv').show();

                }
                else{
                    $('#insurance_companyDiv').hide();
                    $('#TypeDiv').hide();

                    var ele4 = document.getElementById("insurance_type");
                    ele4.required = false;
                    $('#TypeDivNA').hide();
                    document.getElementById("insurance_type_na").disabled = true;
                    $('#priceDiv').hide();
                    $('#commissionDiv').hide();
                    $('#insurance_currencyDiv').hide();

                }

                if($('#TypeDivNA:visible').length!=0) {
                    var query=$('#insurance_class').val();
                    if(query=='MOTOR'){
                        $('#TypeDiv').show();
                        $('#TypeDivNA').hide();

                        document.getElementById("insurance_type_na").disabled = true;
                    }else{
                        $('#TypeDiv').hide();
                        var ele5 = document.getElementById("insurance_type");
                        ele5.required = false;
                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;


                    }
                }else if($('#TypeDiv:visible').length!=0){
                    //starts
                    var query=$('#insurance_class').val();
                    if(query=='MOTOR'){
                        $('#TypeDiv').show();
                        $('#TypeDivNA').hide();
                        document.getElementById("insurance_type_na").disabled = true;

                    }else{
                        $('#TypeDiv').hide();
                        var ele6 = document.getElementById("insurance_type");
                        ele6.required = false;
                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;


                    }
                    //ends
                }else{


                }




                var query5=$('#insurance_company').val();
                if(query5!=''){
                    var insurance_class=document.getElementById("insurance_class").value;
                    if(insurance_class=='MOTOR'){


                        $('#TypeDiv').show();

                    }else{

                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;
                    }

                    $('#priceDiv').show();
                    $('#commissionDiv').show();
                    $('#insurance_currencyDiv').show();
                    $('#billing').show();
                }
                else{
                    $('#TypeDiv').hide();
                    var ele7 = document.getElementById("insurance_type");
                    ele7.required = false;
                    $('#priceDiv').hide();
                    $('#commissionDiv').hide();
                    $('#insurance_currencyDiv').hide();
                    $('#TypeDivNA').hide();
                    $('#billing').hide();
                    document.getElementById("insurance_type_na").disabled = true;
                }




        };
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

            $('#full_name').keyup(function(e){
                e.preventDefault();
                var query = $(this).val();



                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url:"{{ route('client_name_suggestions') }}",
                        method:"GET",
                        data:{query:query,_token:_token},
                        success:function(data){
                            if(data=='0'){
                                // $('#space_id_contract').attr('style','border:1px solid #f00');

                            }
                            else{

                                // $('#space_id_contract').attr('style','border:1px solid #ced4da');
                                $('#nameListClientName').fadeIn();
                                $('#nameListClientName').html(data);
                            }
                        }
                    });
                }
                else if(query==''){

                    // $('#space_id_contract').attr('style','border:1px solid #ced4da');
                    $('#nameListClientName').fadeOut();
                }
            });

            $(document).on('click', '#listClientName', function(){

                $('#full_name').val($(this).text());

                $('#nameListClientName').fadeOut();

            });

            $(document).on('blur', '#full_name', function(){



                $('#nameListClientName').fadeOut();

            });



            //For vehicle registration number
            $('#vehicle_registration_no').keyup(function(e){
                e.preventDefault();
                var query = $('#full_name').val();



                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url:"{{ route('vehicle_registration_no_suggestions') }}",
                        method:"GET",
                        data:{query:query,_token:_token},
                        success:function(data){
                            if(data=='0'){
                                // $('#space_id_contract').attr('style','border:1px solid #f00');

                            }
                            else{

                                // $('#space_id_contract').attr('style','border:1px solid #ced4da');
                                $('#nameListVehicleRegistrationNumber').fadeIn();
                                $('#nameListVehicleRegistrationNumber').html(data);
                            }
                        }
                    });
                }
                else if(query==''){

                    // $('#space_id_contract').attr('style','border:1px solid #ced4da');
                    $('#nameListVehicleRegistrationNumber').fadeOut();
                }
            });

            $(document).on('click', '#listVehicleRegistrationNumber', function(){

                $('#vehicle_registration_no').val($(this).text());

                $('#nameListVehicleRegistrationNumber').fadeOut();

            });

            $(document).on('blur', '#vehicle_registration_no', function(){


                $('#nameListVehicleRegistrationNumber').fadeOut();

            });



            // $('#insurance_class').click(function(){
            //     var query3=$(this).val();
            //     if(query3!=''){
            //
            //         $('#insurance_companyDiv').show();
            //
            //     }
            //     else{
            //         $('#insurance_companyDiv').hide();
            //         $('#TypeDiv').hide();
            //
            //         var ele4 = document.getElementById("insurance_type");
            //         ele4.required = false;
            //         $('#TypeDivNA').hide();
            //         document.getElementById("insurance_type_na").disabled = true;
            //         $('#priceDiv').hide();
            //         $('#commissionDiv').hide();
            //         $('#insurance_currencyDiv').hide();
            //
            //     }
            //
            //     if($('#TypeDivNA:visible').length!=0) {
            //         var query=$('#insurance_class').val();
            //         if(query=='MOTOR'){
            //             $('#TypeDiv').show();
            //             $('#TypeDivNA').hide();
            //
            //             document.getElementById("insurance_type_na").disabled = true;
            //         }else{
            //             $('#TypeDiv').hide();
            //             var ele5 = document.getElementById("insurance_type");
            //             ele5.required = false;
            //             $('#TypeDivNA').show();
            //             document.getElementById("insurance_type_na").disabled = false;
            //
            //
            //         }
            //     }else if($('#TypeDiv:visible').length!=0){
            //         //starts
            //         var query=$('#insurance_class').val();
            //         if(query=='MOTOR'){
            //             $('#TypeDiv').show();
            //             $('#TypeDivNA').hide();
            //             document.getElementById("insurance_type_na").disabled = true;
            //
            //         }else{
            //             $('#TypeDiv').hide();
            //             var ele6 = document.getElementById("insurance_type");
            //             ele6.required = false;
            //             $('#TypeDivNA').show();
            //             document.getElementById("insurance_type_na").disabled = false;
            //
            //
            //         }
            //         //ends
            //     }else{
            //
            //
            //     }
            //
            // });

            // $('#insurance_company').click(function(){
            //     var query3=$(this).val();
            //     if(query3!=''){
            //         var insurance_class=document.getElementById("insurance_class").value;
            //         if(insurance_class=='MOTOR'){
            //
            //
            //             $('#TypeDiv').show();
            //
            //         }else{
            //
            //             $('#TypeDivNA').show();
            //             document.getElementById("insurance_type_na").disabled = false;
            //         }
            //
            //         $('#priceDiv').show();
            //         $('#commissionDiv').show();
            //         $('#insurance_currencyDiv').show();
            //         $('#billing').show();
            //     }
            //     else{
            //         $('#TypeDiv').hide();
            //         var ele7 = document.getElementById("insurance_type");
            //         ele7.required = false;
            //         $('#priceDiv').hide();
            //         $('#commissionDiv').hide();
            //         $('#insurance_currencyDiv').hide();
            //         $('#TypeDivNA').hide();
            //         $('#billing').hide();
            //         document.getElementById("insurance_type_na").disabled = true;
            //     }
            // });


            // $('#insurance_class').click(function() {
            //     var query=$(this).val();
            //     if(query=='MOTOR'){
            //         $('#vehicle').show();
            //         properNextZero();
            //     }else{
            //         $('#vehicle').hide();
            //         properNext();
            //         $('#vehicle_registration_no').val("");
            //         $('#vehicle_use').val("");
            //
            //     }
            //
            //
            // });

        });


    </script>



    <script type="text/javascript">

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var p1, p2,p3,p4,p5,p6,p7,p8;
        var temp;

        function properNext(){
            temp=1;
        }

        function properNextZero(){
            temp=0;
        }

        $(document).ready(function(){


            $("#next1").click(function(){

                if(temp==1) {
                    next_fs = $(this).parent().next().next();
                }else{
                    next_fs = $(this).parent().next();
                }

                current_fs = $(this).parent();


                var client_name=document.getElementById('full_name').value;
                var insurance_class=document.getElementById('insurance_class').value;
                var insurance_company=document.getElementById('insurance_company').value;
                var insurance_type=document.getElementById('insurance_type').value;
                var insurance_type_na=document.getElementById('insurance_type_na').value;
                var email=$("#email").val();
                var insurance_typ=$("#insurance_type").val();






                if(insurance_type=='COMPREHENSIVE'){
                    $('#mode_of_paymentDiv').show();
                    $('#premiumDiv').show();

                }else{
                    $('#premiumDiv').hide();
                    $('#mode_of_paymentDiv').hide();

                    $('#first_installmentDiv').hide();
                    $('#second_installmentDiv').hide();

                    $('#first_installment').val("");
                    $('#second_installment').val("");

                }



                if (client_name==""){
                    p1=0;
                    $('#client_msg').show();
                    var message=document.getElementById('client_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#full_name').attr('style','border-bottom:1px solid #f00');

                }else{
                    p1=1;
                    $('#client_msg').hide();
                    $('#full_name').attr('style','border-bottom: 1px solid #ccc');

                }

                if (insurance_class==""){
                    p2=0;
                    $('#class_msg').show();
                    var message=document.getElementById('class_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#insurance_class').attr('style','border-bottom:1px solid #f00');

                }else{
                    p2=1;
                    $('#class_msg').hide();
                    $('#insurance_class').attr('style','border-bottom: 1px solid #ccc');

                }


                if (insurance_company==""){
                    p3=0;
                    $('#principal_msg').show();
                    var message=document.getElementById('principal_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#insurance_company').attr('style','border-bottom:1px solid #f00');

                }else{
                    p3=1;
                    $('#principal_msg').hide();
                    $('#insurance_company').attr('style','border-bottom: 1px solid #ccc');



                }


                if(email==""){
                    p4=0;
                    $('#email_msg').show();
                    var message=document.getElementById('email_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#email').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p4=1;
                    $('#email_msg').hide();
                    $('#email').attr('style','border-bottom: 1px solid #ccc');

                }








                var phone_digits=$('#phone_number').val().length;

                if(phone_digits<10) {
                    p6=0;
                    $('#phone_msg').show();
                    var message = document.getElementById('phone_msg');
                    message.style.color = 'red';
                    message.innerHTML = "Digits cannot be less than 10";
                    $('#phone_number').attr('style', 'border-bottom:1px solid #f00');

                }else{
                    p6=1;
                    $('#phone_msg').hide();
                    $('#phone_number').attr('style','border-bottom: 1px solid #ccc');
                }


                if($('#TypeDiv:visible').length!=0) {

                    if (insurance_typ == "") {
                        p5 = 0;
                        $('#itype_msg').show();
                        var message = document.getElementById('itype_msg');
                        message.style.color = 'red';
                        message.innerHTML = "Required";
                        $('#insurance_type').attr('style', 'border-bottom:1px solid #f00');
                    } else {
                        p5 = 1;
                        $('#itype_msg').hide();
                        $('#insurance_type').attr('style', 'border-bottom: 1px solid #ccc');

                    }

                    var visible_status=$('#TypeDivNA:visible').length;

                    if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p5=='1' & p6=='1'){


                        var type_var= document.getElementById("insurance_type").value;
                        var type_na_var=document.getElementById("insurance_type_na").value;

                        var _token = $('input[name="_token"]').val();

                        if(visible_status!=0) {
                            console.log('type_na');
                            var type_var
                            $.ajax({
                                url: "{{ route('autofill_insurance_parameters') }}",
                                method: "GET",
                                data: {
                                    insurance_class: insurance_class,
                                    insurance_company: insurance_company,
                                    insurance_type_na: insurance_type_na,
                                    _token: _token
                                },
                                success: function (data) {
                                    if(data!=""){
                                        gonext();
                                        document.getElementById("premium").value=data[0].price;
                                        document.getElementById("commission_percentage").value=data[0].commission_percentage;
                                        document.getElementById("commission").value=data[0].commission;
                                        document.getElementById("currency").value=data[0].insurance_currency;
                                        document.getElementById("availability_status").innerHTML ='';

                                    }else{
                                        document.getElementById("availability_status").style.color='Red';
                                        document.getElementById("availability_status").innerHTML ='Selected insurance package does not exist for the given principal, please try again';

                                    }
                                },

                                error : function(data) {



                                }
                            });
                        }else {
                            console.log('type');
                            $.ajax({
                                url: "{{ route('autofill_insurance_parameters') }}",
                                method: "GET",
                                data: {
                                    insurance_class: insurance_class,
                                    insurance_company: insurance_company,
                                    insurance_type: insurance_type,
                                    _token: _token
                                },
                                success: function (data) {

                                    if(data!=""){
                                        gonext();
                                        document.getElementById("premium").value=data[0].price;
                                        document.getElementById("commission_percentage").value=data[0].commission_percentage;
                                        document.getElementById("commission").value=data[0].commission;
                                        document.getElementById("currency").value=data[0].insurance_currency;
                                        document.getElementById("availability_status").innerHTML ='';

                                    }else{

                                        document.getElementById("availability_status").style.color='Red';
                                        document.getElementById("availability_status").innerHTML ='Selected insurance package does not exist for the given principal, please try again';

                                    }

                                },

                                error : function(data) {



                                }
                            });

                        }



                    }






                }else{


                    var visible_status=$('#TypeDivNA:visible').length;

                    if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p6=='1'){


                        var type_var= document.getElementById("insurance_type").value;
                        var type_na_var=document.getElementById("insurance_type_na").value;

                        var _token = $('input[name="_token"]').val();

                        if(visible_status!=0) {
                            console.log('type_na');
                            var type_var
                            $.ajax({
                                url: "{{ route('autofill_insurance_parameters') }}",
                                method: "GET",
                                data: {
                                    insurance_class: insurance_class,
                                    insurance_company: insurance_company,
                                    insurance_type_na: insurance_type_na,
                                    _token: _token
                                },
                                success: function (data) {
                                    if(data!=""){
                                        gonext();
                                        document.getElementById("premium").value=data[0].price;
                                        document.getElementById("commission_percentage").value=data[0].commission_percentage;
                                        document.getElementById("commission").value=data[0].commission;
                                        document.getElementById("currency").value=data[0].insurance_currency;
                                        document.getElementById("availability_status").innerHTML ='';

                                    }else{
                                        document.getElementById("availability_status").style.color='Red';
                                        document.getElementById("availability_status").innerHTML ='Selected insurance package does not exist for the given principal, please try again';

                                    }
                                },

                                error : function(data) {



                                }
                            });
                        }else {
                            console.log('type');
                            $.ajax({
                                url: "{{ route('autofill_insurance_parameters') }}",
                                method: "GET",
                                data: {
                                    insurance_class: insurance_class,
                                    insurance_company: insurance_company,
                                    insurance_type: insurance_type,
                                    _token: _token
                                },
                                success: function (data) {

                                    if(data!=""){
                                        gonext();
                                        document.getElementById("premium").value=data[0].price;
                                        document.getElementById("commission_percentage").value=data[0].commission_percentage;
                                        document.getElementById("commission").value=data[0].commission;
                                        document.getElementById("currency").value=data[0].insurance_currency;
                                        document.getElementById("availability_status").innerHTML ='';

                                    }else{

                                        document.getElementById("availability_status").style.color='Red';
                                        document.getElementById("availability_status").innerHTML ='Selected insurance package does not exist for the given principal, please try again';

                                    }

                                },

                                error : function(data) {



                                }
                            });

                        }



                    }


                }





            });


            $("#next2").click(function(){
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

                var client_name=document.getElementById('full_name').value;
                var insurance_class=document.getElementById('insurance_class').value;
                var insurance_company=document.getElementById('insurance_company').value;
                var insurance_type=document.getElementById('insurance_type').value;
                var vehicle_registration_no=document.getElementById('vehicle_registration_no').value;
                var vehicle_use=document.getElementById('vehicle_use').value;
                var insurance_type_na=document.getElementById('insurance_type_na').value;
                var phone_number=document.getElementById('phone_number').value;
                var commission_date=document.getElementById('commission_date').value;
                var sum_insured=document.getElementById('sum_insured').value;
                var premium=document.getElementById('premium').value;
                var actual_ex_vat=document.getElementById('actual_ex_vat').value;
                var value=$("#value").val();
                var commission_percentage=document.getElementById('commission_percentage').value;
                var commission=document.getElementById('commission').value;
                var cover_note=$("#cover_note").val();
                var sticker_no=$("#sticker_no").val();
                var receipt_no=$("#receipt_no").val();
                var currency=document.getElementById('currency').value;
                var email=$("#email").val();
                var mode_of_payment=$("#mode_of_payment").val();
                var first_installment=$("#first_installment").val();
                var second_installment=$("#second_installment").val();


                if(commission_date==""){
                    p1=0;
                    $('#commission_date_msg').show();
                    var message=document.getElementById('commission_date_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#commission_date').attr('style','border-bottom:1px solid #f00');
                }
            else{
                    p1=1;
                    $('#commission_date_msg').hide();
                    $('#commission_date').attr('style','border-bottom: 1px solid #ccc');

                }



                if(sum_insured==""){
                    p2=0;
                    $('#sum_insured_msg').show();
                    var message=document.getElementById('sum_insured_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#sum_insured').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p2=1;
                    $('#sum_insured_msg').hide();
                    $('#sum_insured').attr('style','border-bottom: 1px solid #ccc');

                }



                if(mode_of_payment==""){
                    p3=0;
                    $('#mode_of_payment_msg').show();
                    var message=document.getElementById('mode_of_payment_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#mode_of_payment').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p3=1;
                    $('#mode_of_payment_msg').hide();
                    $('#mode_of_payment').attr('style','border-bottom: 1px solid #ccc');

                }



                if(actual_ex_vat==""){
                    p4=0;
                    $('#actual_ex_vat_msg').show();
                    var message=document.getElementById('actual_ex_vat_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#actual_ex_vat').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p4=1;
                    $('#actual_ex_vat_msg').hide();
                    $('#actual_ex_vat').attr('style','border-bottom: 1px solid #ccc');

                }


                if(cover_note==""){
                    p5=0;
                    $('#cover_note_msg').show();
                    var message=document.getElementById('cover_note_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#cover_note').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p5=1;
                    $('#cover_note_msg').hide();
                    $('#cover_note').attr('style','border-bottom: 1px solid #ccc');

                }


                if(sticker_no==""){
                    p6=0;
                    $('#sticker_no_msg').show();
                    var message=document.getElementById('sticker_no_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#sticker_no').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p6=1;
                    $('#sticker_no_msg').hide();
                    $('#sticker_no').attr('style','border-bottom: 1px solid #ccc');

                }



                if(receipt_no==""){
                    p7=0;
                    $('#receipt_no_msg').show();
                    var message=document.getElementById('receipt_no_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#receipt_no').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p7=1;
                    $('#receipt_no_msg').hide();
                    $('#receipt_no').attr('style','border-bottom: 1px solid #ccc');

                }


                if(value==""){
                    p8=0;
                    $('#value_msg').show();
                    var message=document.getElementById('value_msg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#value').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p8=1;
                    $('#value_msg').hide();
                    $('#value').attr('style','border-bottom: 1px solid #ccc');

                }




                const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"];
                const dateObj = new Date(commission_date);
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
                $("#insurance_class_confirm").html(insurance_class);
                $("#insurance_class_confirm").css('font-weight', 'bold');

                $("#insurance_company_confirm").html(insurance_company);
                $("#insurance_company_confirm").css('font-weight', 'bold');






                if(insurance_class=='MOTOR'){
                    $("#insurance_type_confirm").html(insurance_type);
                    $("#vehicle_registration_no_row_confirm").show();
                    $("#vehicle_use_row_confirm").show();
                    $("#sticker_no_row_confirm").show();
                    $("#cover_note_row_confirm").show();
                    $("#value_row_confirm").hide();

                }else{
                    $("#insurance_type_confirm").html(insurance_type_na);
                    $("#vehicle_registration_no_row_confirm").hide();
                    $("#vehicle_use_row_confirm").hide();
                    $("#sticker_no_row_confirm").hide();
                    $("#cover_note_row_confirm").hide();
                    $("#value_row_confirm").show();
                }


                if(mode_of_payment=='By installment'){
                    $('#mode_of_payment_row_confirm').show();
                    $('#first_installment_row_confirm').show();
                    $('#second_installment_row_confirm').show();

                }else{

                    $('#mode_of_payment_row_confirm').hide();
                    $('#first_installment_row_confirm').hide();
                    $('#second_installment_row_confirm').hide();
                }






                $("#insurance_type_confirm").css('font-weight', 'bold');

                $("#client_name_confirm").html(client_name);
                $("#client_name_confirm").css('font-weight', 'bold');

                $("#phone_number_confirm").html(phone_number);
                $("#phone_number_confirm").css('font-weight', 'bold');

                $("#email_confirm").html(email);
                $("#email_confirm").css('font-weight', 'bold');


                $("#vehicle_registration_no_confirm").html(vehicle_registration_no);
                $("#vehicle_registration_no_confirm").css('font-weight', 'bold');


                $("#vehicle_use_confirm").html(vehicle_use);
                $("#vehicle_use_confirm").css('font-weight', 'bold');


                $("#commission_date_confirm").html(output);
                $("#commission_date_confirm").css('font-weight', 'bold');

                $("#sum_insured_confirm").html(thousands_separators(sum_insured) +" "+currency);
                $("#sum_insured_confirm").css('font-weight', 'bold');


                $("#premium_confirm").html(thousands_separators(premium)+" "+currency);
                $("#premium_confirm").css('font-weight', 'bold');


                $("#actual_ex_vat_confirm").html(thousands_separators(actual_ex_vat)+" "+currency);
                $("#actual_ex_vat_confirm").css('font-weight', 'bold');




                if(insurance_class=='MOTOR'){

                    $("#cover_note_confirm").html(cover_note);
                    $("#cover_note_confirm").css('font-weight', 'bold');


                    $("#sticker_no_confirm").html(sticker_no);
                    $("#sticker_no_confirm").css('font-weight', 'bold');
                }else{
                    $("#value_confirm").html(thousands_separators(value)+" "+currency);
                    $("#value_confirm").css('font-weight', 'bold');


                }



                if(insurance_type=='COMPREHENSIVE'){

                    $("#mode_of_payment_confirm").html(mode_of_payment);
                    $("#mode_of_payment_confirm").css('font-weight', 'bold');


                    $("#first_installment_confirm").html(thousands_separators(first_installment)+" "+currency);
                    $("#first_installment_confirm").css('font-weight', 'bold');

                    $("#second_installment_confirm").html(thousands_separators(second_installment)+" "+currency);
                    $("#second_installment_confirm").css('font-weight', 'bold');


                }else{



                }




                $("#commission_percentage_confirm").html(commission_percentage+"%");
                $("#commission_percentage_confirm").css('font-weight', 'bold');


                $("#commission_confirm").html(thousands_separators(commission)+" "+currency);
                $("#commission_confirm").css('font-weight', 'bold');


                $("#receipt_no_confirm").html(receipt_no);
                $("#receipt_no_confirm").css('font-weight', 'bold');

                if(insurance_class=='MOTOR'){

                    if(insurance_type=='COMPREHENSIVE'){

                        if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1') {

                            gonext();

                        }else{



                        }



                    }

                    else{

                        if(p1=='1' & p2=='1'  & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' ) {

                            gonext();

                        }else{



                        }

                    }





                }else{

                    if(p1=='1' & p2=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p8=='1' ) {

                        gonext();

                    }else{



                    }


                }


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

                if(temp==1) {
                    previous_fs = $(this).parent().prev().prev();
                }else{
                    previous_fs = $(this).parent().prev();
                }


                current_fs = $(this).parent();


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

    $('#mode_of_payment').on('change',function(e){
        e.preventDefault();
        var mode_of_payment = $(this).val();
        var premium=$('#premium').val();


        if(mode_of_payment == 'By installment')
        {

            $('#first_installmentDiv').show();
            $('#second_installmentDiv').show();

            function thousands_separators(num)
            {
                var num_parts = num.toString().split(".");
                num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return num_parts.join(".");
            }


            var first_installment= Math.round(((0.60*premium) + Number.EPSILON) * 100) / 100;
            var second_installment=Math.round(((0.40*premium) + Number.EPSILON) * 100) / 100;


            $('#first_installment').val(first_installment);
            $('#second_installment').val(second_installment);


        }
        else if(mode_of_payment=='Full payment'){

            $('#first_installmentDiv').hide();
            $('#second_installmentDiv').hide();

            $('#first_installment').val("");
            $('#second_installment').val("");

        }

        else{
            $('#first_installmentDiv').hide();
            $('#second_installmentDiv').hide();
        }
    });

</script>


@endsection
