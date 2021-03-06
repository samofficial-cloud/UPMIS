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
    width: 20%;
    float: left;
    position: relative
}

#progressbar #room:before {
    font-family: FontAwesome;
    content: "\f04d"
}

#progressbar #client:before {
    font-family: FontAwesome;
    content: "\f007"
}

#progressbar #contact:before {
    font-family: FontAwesome;
    content: "\f007"
}

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f09d"
}

#progressbar #invoice:before {
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
<li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
<div class="main_content">
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-12 col-sm-9 col-md-7 col-lg-9 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3" >
            	<h4 style="line-height: 1.5;"><strong>UNIVERSITY OF DAR ES SALAAM<br>
                DIRECTORATE OF PLANNING DEVELOPMENT AND INVESTMENT<br>P.O BOX 35091, DAR ES SALAAM TANZANIA.</strong></h4>
                <h5 style="line-height: 1.5;">RESEARCH FLATS ACCOMMODATION FACILITY<br>REGISTRATION FORM</h5>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" method="post" action="{{ route('sendeditResearchForm',$contract->id) }}">
                            {{csrf_field()}}
                               <ul id="progressbar">
                                    <li class="active" id="client"><strong>Client</strong></li>
                                    <li  id="contact"><strong>Contact Person</strong></li>
                                    <li  id="room"><strong>Room</strong></li>
                                    <li id="payment"><strong>Payment</strong></li>
                                    <li id="invoice"><strong>Invoice</strong></li>
                                </ul>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Client Information</h2>
                                <div class="form-group row" id="namediv">




                                    <div class="form-wrapper col-12" id="client_categoryDiv">
                                        <label for="client_category">Client Category<span style="color: red;">*</span></label>
                                        <span id="client_category_msg"></span>
                                        <input type="text" id="client_category" name="client_category" class="form-control" autocomplete="off" value="{{$contract->client_category}}"  readonly>
                                    </div>


                                    @if($contract->client_type!='')
                                    <div class="form-wrapper col-12 pt-4" id="client_typeDiv" >
                                        <label for="client_type">Client Type<span style="color: red;">*</span></label>
                                        <span id="client_type_msg"></span>
                                        <input type="text" id="client_type" name="client_type" class="form-control" autocomplete="off" value="{{$contract->client_type}}"  readonly>

                                    </div>
                                    @else
                                    @endif

                                    @if($contract->campus_individual!='')
                                    <div class="form-wrapper col-6 pt-4" id="campus_individualDiv" >
                                        <label for="campus_individual">Campus<span style="color: red;">*</span></label>
                                        <span id="campus_individual_msg"></span>
                                        <input type="text" id="campus_individual" name="campus_individual" class="form-control" autocomplete="off" value="{{$contract->campus_individual}}"  readonly>
                                    </div>
                                    @else
                                    @endif

                                    @if($contract->college_individual!='')
                                    <div class="form-wrapper col-6 pt-4" id="college_individualDiv" >
                                        <label for="college_individual">College<span style="color: red;">*</span></label>
                                        <span id="college_individual_msg"></span>
                                        <input type="text" id="college_individual" name="college_individual" class="form-control" autocomplete="off" value="{{$contract->college_individual}}"  readonly>
                                    </div>
                                    @else
                                    @endif


                                    @if($contract->department_individual!='')
                                    <div class="form-wrapper col-12 pt-4" id="department_individualDiv" >
                                        <label for="department_individual">Department<span style="color: red;">*</span></label>
                                        <span id="department_individual_msg"></span>
                                        <input type="text" id="department_individual" name="department_individual" class="form-control" autocomplete="off" value="{{$contract->department_individual}}"  readonly>
                                    </div>
                                    @else
                                    @endif







                                    <div class="form-wrapper col-4">
                                        <label for="first_name">First Name<span style="color: red;">*</span></label>
                                            <span id="firstnamemsg"></span>
                                        <input type="text" id="first_name" name="first_name" class="form-control" autocomplete="off" value="{{$contract->first_name}}"  readonly="" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;" >
                                        <span id="nameList"></span>
                                    </div>
                                    <div class="form-wrapper col-5">
                                        <label for="last_name">Last Name<span style="color: red;">*</span></label>
                                        <span id="lastnamemsg"></span>
                                        <input type="text" id="last_name" name="last_name" class="form-control"  readonly="" value="{{$contract->last_name}}" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                                    </div>

                                    <div class="form-wrapper col-3">
                                        <label for="gender">Gender<span style="color: red;">*</span></label>
                                            <span id="gendermsg"></span>
                                            <input type="text" id="gender" name="gender" class="form-control"  readonly="" value="{{$contract->gender}}">
                                        {{-- <select class="form-control"  id="gender" name="gender">
                                          <option value="{{$contract->gender}}">{{$contract->gender}}</option>
                                            @if($contract->gender!='Female')
                                                <option value="Female">Female</option>
                                            @endif
                                            @if($contract->gender!='Male')
                                                <option value="Male">Male</option>
                                            @endif
                                        </select> --}}
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <div class="form-wrapper">
                                            <label for="professional">Professional<span style="color: red;">*</span></label>
                                            <span id="profmsg"></span>
                                            <input type="text" id="professional" name="professional" class="form-control"  value="{{$contract->professional}}" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                                        </div>
                                    </div>

                                   <div class="form-group row">
                                        <div class="form-wrapper col-4">
                                            <label for="address">Address<span style="color: red;">*</span></label>
                                            <span id="addressmsg"></span>
                                            <input type="text" id="address" name="address" class="form-control"   value="{{$contract->address}}">
                                        </div>

                                        <div class="form-wrapper col-5">
                                            <label for="email">Email<span style="color: red;">*</span></label>
                                            <span id="emailmsg"></span>
                                            <input type="text" name="email" id="email" class="form-control"  placeholder="someone@example.com" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25" value="{{$contract->email}}">
                                        </div>

                                        <div class="form-wrapper col-3">
                                            <label for="phone_number">Phone Number <span style="color: red;"> *</span></label>
                                            <span id="phonemsg"></span>
                                            <input type="text" id="phone_number" name="phone_number" value="{{$contract->phone_number}}" class="form-control" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
                                        </div>

                                       @if($contract->tin!='')
                                       <div id="tinDiv" class="form-group col-12">
                                           <div class="form-wrapper">
                                               <label for="tin">TIN <span style="color: red;"> *</span></label>
                                               <span id="tin_msg"></span>
                                               <input type="number" id="tin" name="tin" class="form-control" value="{{$contract->tin}}" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minCharacters(this.value);" maxlength = "9">
                                               <p id="error_tin"></p>
                                           </div>
                                       </div>
                                       @else
                                       @endif



                                    </div>

                                    <div class="form-group">
                                        <div class="form-wrapper">
                                            <label for="nationality">Nationality<span style="color: red;">*</span></label>
                                            <span id="nationality_msg"></span>
                                            <input type="text" id="nationality" name="nationality" class="form-control"  value="{{$contract->nationality}}" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <div class="form-wrapper">
                                            <label for="purpose">Purpose of Visit<span style="color: red;">*</span></label>
                                            <span id="purposemsg"></span>
                                            <input type="text" id="purpose" name="purpose" class="form-control"  value="{{$contract->purpose}}" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <div class="form-wrapper col-4">
                                            <label for="passport_no">Passport No</label>
                                            <span id="pass_nomsg"></span>
                                            <input type="text" id="passport_no" name="passport_no" class="form-control"  value="{{$contract->passport_no}}">
                                        </div>

                                        <div class="form-wrapper col-4">
                                            <label for="issue_date">Date of Issue<span style="color: red;">*</span></label>
                                            <span id="issue_datemsg"></span>
                                            <input  id="issue_date"  class="form-control" autocomplete="off"  value="{{date("d/m/Y",strtotime($contract->issue_date))}}">
                                            <input type="hidden" id="issue_date_alternate" name="issue_date"  class="form-control">

                                            <?php
                                            $received_issue_date=$contract->issue_date;
                                            ?>

                                        </div>

                                         <div class="form-wrapper col-4">
                                            <label for="issue_place">Place of Issue<span style="color: red;">*</span></label>
                                            <span id="issue_placemsg"></span>
                                            <input type="text" id="issue_place" name="issue_place" class="form-control"  onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;" value="{{$contract->issue_place}}">
                                        </div>


                                         @if($contract->id_type!='')
                                         <div class="form-wrapper col-12" id="id_typeDiv" >
                                             <label for="id_type">Type of Identification Card<span style="color: red;">*</span></label>
                                             <span id="id_type_msg"></span>
                                             <select class="form-control id_type"  id="id_type" name="id_type">
                                                 <option value="{{$contract->id_type}}" selected>{{$contract->id_type}}</option>

                                                 @if($contract->id_type=='National Identity Card')
                                                     <option value="Driving License">Driving Licence</option>
                                                     <option value="Voters Card">Voters Card</option>
                                                     <option value="Workers Identity Card">Workers Identity Card</option>

                                                 @elseif($contract->id_type=='Driving License')
                                                     <option value="National Identity Card">National Identity Card</option>
                                                     <option value="Voters Card">Voters Card</option>
                                                     <option value="Workers Identity Card">Workers Identity Card</option>

                                                 @elseif($contract->id_type=='Voters Card')
                                                     <option value="National Identity Card">National Identity Card</option>
                                                     <option value="Driving License">Driving Licence</option>
                                                     <option value="Workers Identity Card">Workers Identity Card</option>

                                                 @elseif($contract->id_type=='Workers Identity Card')
                                                 <option value="National Identity Card">National Identity Card</option>
                                                 <option value="Driving License">Driving Licence</option>
                                                 <option value="Voters Card">Voters Card</option>
                                                 @else
                                                 @endif

                                             </select>
                                         </div>
                                         @else
                                         @endif

                                         @if($contract->id_number!='')
                                         <div class="form-wrapper col-12 pt-4" id="id_numberDiv" >
                                             <label for="id_number">ID Number<span style="color: red;">*</span></label>
                                             <span id="id_number_msg"></span>
                                             <input type="text" id="id_number" value="{{$contract->id_number}}" name="id_number" class="form-control">
                                         </div>
                                         @else
                                         @endif

                                         <div class="form-wrapper col-12">
                                             <label for="has_host">Has host/Contact person?<span style="color: red;">*</span></label>
                                             <span id="has_host_msg"></span>
                                             @if($contract->host_name=='')
                                                 <input type="text" id="has_host" name="has_host" value="No" class="form-control" readonly>
                                             @else
                                                 <input type="text" id="has_host" name="has_host" value="Yes" class="form-control" readonly>
                                             @endif

                                         </div>


                                    </div>
                                </div>
                                    <input type="button" name="next" id="next1" class="next action-button" value="Next Step" />
 <input type="button" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">
                                 </fieldset>
                            {{-- Second Form --}}
                            <fieldset>
                                <div class="form-card">
                                  <h2 class="fs-title">Contact person while in Tanzania</h2>
                                  <div class="form-group">
                                        <div class="form-wrapper">
                                            <label for="host_name">Host Name<span style="color: red;">*</span></label>
                                            <span id="host_namemsg"></span>
                                            <input type="text" id="host_name" name="host_name" class="form-control"  readonly="" value="{{$contract->host_name}}" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                                        </div>
                                </div>

                                    <div class="form-group row">
                                        <div class="form-wrapper col-6 pt-4" id="campus_hostDiv" >
                                            <label for="campus_host">Campus<span style="color: red;">*</span></label>
                                            <span id="campus_host_msg"></span>
                                            <input type="text" id="campus_host" name="campus_host" readonly class="form-control" value="{{$contract->campus_host}}">
                                        </div>


                                        <div class="form-wrapper col-6 pt-4" id="college_hostDiv" >
                                            <label for="college_host">College<span style="color: red;">*</span></label>
                                            <span id="college_host_msg"></span>
                                            <input type="text" id="college_host" name="college_host" readonly class="form-control" value="{{$contract->college_host}}">
                                        </div>



                                        <div class="form-wrapper col-12 pt-4" id="department_hostDiv" >
                                            <label for="department_host">Department<span style="color: red;">*</span></label>
                                            <span id="department_host_msg"></span>
                                            <input type="text" id="department_host" name="department_host" readonly class="form-control" value="{{$contract->department_host}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="form-wrapper col-4">
                                            <label for="host_address">Address<span style="color: red;">*</span></label>
                                            <span id="host_addressmsg"></span>
                                            <input type="text" id="host_address" name="host_address" class="form-control" value="{{$contract->host_address}}"  >
                                        </div>

                                        <div class="form-wrapper col-5">
                                            <label for="host_email">Email<span style="color: red;">*</span></label>
                                            <span id="host_emailmsg"></span>
                                            <input type="text" id="host_email" name="host_email" class="form-control"  value="{{$contract->host_email}}" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                                        </div>

                                        <div class="form-wrapper col-3">
                                            <label for="host_phone">Phone Number <span style="color: red;"> *</span></label>
                                            <span id="host_phonemsg"></span>
                                            <input type="text" id="host_phone"  name="host_phone" class="form-control" value="{{$contract->host_phone}}" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
                                        </div>





                                    </div>
                              </div>
                            <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                            <input type="button" id="next0" name="next" class="next action-button" value="Next Step" />
                            <input type="button" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">
                            </fieldset>

                            <fieldset>
                                <div class="form-card">
                                  <h2 class="fs-title">Room Information</h2>

                                    <div class="form-group">
                                      <div class="form-wrapper">
                                        <label for="room_no">Room No.<span style="color: red;">*</span></label>
                                        <span id="roommsg"></span>
                                        <input type="text" class="form-control"  id="room_no" name="room_no" value="{{$contract->room_no}}"  readonly="">

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                      <div class="form-wrapper col-6">
                                            <label for="arrival_date">Date of Arrival<span style="color: red;">*</span></label>
                                            <span id="arrival_datemsg"></span>
                                            <input type="date" id="arrival_date" name="arrival_date" class="form-control" value="{{$contract->arrival_date}}"  readonly="">
                                      </div>

                                      <div class="form-wrapper col-6">
                                            <label for="arrival_time">Time<span style="color: red;">*</span></label>
                                            <span id="arrival_timemsg"></span>
                                            <input  id="arrival_time" name="arrival_time" class="form-control"  value="{{$contract->arrival_time}}">
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <div class="form-wrapper">
                                            <label for="departure_date">Expected Date of Departure<span style="color: red;">*</span></label>
                                            <span id="departure_datemsg"></span>
                                            <input type="date" id="departure_date" name="departure_date" class="form-control"  value="{{$contract->departure_date}}" readonly="">
                                      </div>
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



                                @if($room_cat=='Shared Room')
                                    <div class="form-group" id="shared_roomDiv">
                                        <div class="form-wrapper">
                                            <p style="text-align: left !important; font-size: 0.9rem;">
                                                Rate: Shared Room: <input type="text" id="shared_room_usd" name="shared_price_usd" value="{{$contract->amount_usd}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;"> per day: Equivalent Tshs: <input type="text" id="shared_room" name="shared_price_tzs" value="{{$contract->amount_tzs}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">per day
                                                <br>
                                                Total amount USD:<input type="text" id="total_shared_usd" name="total_shared_usd" value="{{$contract->total_usd}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;"> Tshs: <input type="text" id="total_shared_tzs" name="total_price_tzs" value="{{$contract->total_tzs}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                            </p>
                                        </div>
                                    </div>
                                @elseif($room_cat=='Single Room')
                                    <div class="form-group" id="single_roomDiv">
                                        <div class="form-wrapper">
                                            <p style="text-align: left !important; font-size: 0.9rem;">
                                                Rate: Single Room: <input type="text" id="single_room_usd" name="single_price_usd" value="{{$contract->amount_usd}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;"> per day: Equivalent Tshs: <input type="text" id="single_room" name="single_price_tzs" value="{{$contract->amount_tzs}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">per day
                                                <br>
                                                 Total amount USD:<input type="text" id="total_single_usd" name="total_single_usd" value="{{$contract->total_usd}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;"> Equivalent to Tshs: <input type="text" id="total_single_tzs" name="total_single_tzs" value="{{$contract->total_tzs}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                            </p>
                                        </div>
                                    </div>
                                @elseif($room_cat=='Suit Room')
                                    <div class="form-group" id="suit_roomDiv">
                                        <div class="form-wrapper">
                                            <p style="text-align: left !important; font-size: 0.9rem;">
                                                Rate: Suit Room:<input type="text" id="suit_room_usd" name="suit_price_usd" value="{{$contract->amount_usd}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;"> per day: Equivalent Tshs: <input type="text" id="suit_room" name="suit_price_tzs" value="{{$contract->amount_tzs}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">per day
                                                <br>
                                                 Total amount USD:<input type="text" id="total_suit_usd" name="total_suit_usd" value="{{$contract->total_usd}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;"> Tshs: <input type="text" id="total_suit_tzs" name="total_suit_tzs" value="{{$contract->total_tzs}}" readonly="" style="padding: 0px; border: inset; margin: 10px;width: 15%;" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="text" name="room_cat" value="{{$room_cat}}" hidden="">
                                    <div class="form-group row">
                                      <div class="form-wrapper col-6">
                                            <label for="receipt_no">Receipt No<span style="color: red;">*</span></label>
                                          <span id="receipt_no_msg"></span>
                                          <input type="text" id="receipt_no" name="receipt_no" class="form-control"  value="{{$contract->receipt_no}}">
                                      </div>

                                      <div class="form-wrapper col-6">
                                            <label for="receipt_date">Of Date<span style="color: red;">*</span></label>
                                          <span id="receipt_date_msg"></span>
                                            <input  id="receipt_date"  class="form-control"  autocomplete="off" value="{{date("d/m/Y",strtotime($contract->receipt_date))}}">
                                          <input type="hidden" id="receipt_date_alternate" name="receipt_date"  class="form-control">

                                          <?php
                                          $received_receipt_date=$contract->receipt_date;
                                          ?>


                                      </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-wrapper">
                                            <label for="total_days">Total No. of days stayed at Research Flats <span style="color: red;">*</span></label>
                                            <span id="total_days_msg"></span>
                                            <input type="text" id="total_days" name="total_days" class="form-control"  readonly="" value="{{$contract->total_days}}" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                        </div>
                                    </div>

                                    <?php $cat = DB::table('research_flats_rooms')->select('category')->where('room_no', $contract->room_no)->value('category') ?>

                                    <input type="text" name="category" id="category" value="{{$cat}}" hidden="">

                                    {{-- <div class="form-group">
                                        <div class="form-wrapper">
                                            <label for="final_payment">Final Payment(if applicable USD/TZS)<span style="color: red;">*</span></label>
                                            <input type="text" id="final_payment" name="final_payment" class="form-control"  value="{{$contract->final_payment}}" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                        </div>
                                    </div> --}}
                                </div>
                               {{--  <button class="btn btn-primary" type="submit" id="forward">Save</button> --}}
                               <input type="button" name="previous" class="previous action-button-previous" value="Previous" />

                                <input type="button" id="next3" name="next" class="next action-button" value="Next Step" />
                                <input type="button" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">
                            </fieldset>

                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Invoice Details</h2>

                                    <div class="form-group">
                                      <div class="form-wrapper">
                                        <label for="debtor">Debtor<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control"  id="debtor" name="debtor" readonly="" value="{{ucfirst(strtolower($contract->invoice_debtor))}}">
                                        {{-- <select class="form-control" required="" id="debtor" name="debtor" required="">
                                          <option value="" disabled selected hidden>Select Debtor</option>
                                            <option value="individual">Individual</option>
                                            <option value="host">Host</option>
                                        </select> --}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-wrapper">
                                            <label for="currency">Currency<span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="currency" name="currency"  readonly="" value="{{$contract->invoice_currency}}">
                                            {{-- <select class="form-control" required="" id="currency" name="currency" required="">
                                              <option value=""disabled selected hidden>Select Currency</option>
                                              <option value="TZS">TZS</option>
                                              <option value="USD">USD</option>
                                            </select> --}}
                                        </div>
                                    </div>



{{--                                    <div class="form-group ">--}}
{{--                                        <div class="form-wrapper">--}}
{{--                                            <label for=""  >Inc Code<span style="color: red;">*</span></label>--}}
{{--                                            <input type="text" class="form-control"  name="inc_code" value="{{$contract->inc_code}}" required  autocomplete="off">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="submit" id="submit1" name="save" class="submit action-button" value="Save" />
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
<script type="text/javascript">
    $(document).ready(function(){
    var a;
var current_fs, next_fs, previous_fs; //fieldsets
var opacity;
var p1, p2;

    function gonext(){
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


$(".previous").click(function(){

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();



    var has_host=$('#has_host').val();

    if(has_host=='Yes'){



    }else{

        previous_fs = $(this).parent().prev().prev();

    }



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

        $("#next1").click(function(){
            var p1, p2, p3, p4, p5, p6, p7, p8, p9, p10,p11,p12,ptin;
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            var first = $('#first_name').val(),
                last = $('#last_name').val(),
                gender =$('#gender').val(),
                prof = $('#professional').val(),
                address = $('#address').val(),
                email = $('#email').val(),
                phone = $('#phone_number').val(),
                purpose = $('#purpose').val(),
                passport_no = $('#passport_no').val(),
                issue_date = $('#issue_date').val(),
                issue_place = $('#issue_place').val();
                nationality = $('#nationality').val();
                has_host=$('#has_host').val();
                tin=$('#tin').val();




            if(first==''){
                p1=0;
                $('#firstnamemsg').show();
                var message=document.getElementById('firstnamemsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#first_name').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p1=1;
                $('#firstnamemsg').hide();
                $('#first_name').attr('style','border-bottom: 1px solid #ccc');
            }

            if(last==''){
                p2=0;
                $('#lastnamemsg').show();
                var message=document.getElementById('lastnamemsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#last_name').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p2=1;
                $('#lastnamemsg').hide();
                $('#last_name').attr('style','border-bottom: 1px solid #ccc');
            }

            if(gender==null){
                p3=0;
                $('#gendermsg').show();
                var message=document.getElementById('gendermsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#gender').attr('style','border:1px solid #f00');
            }
            else{
                p3=1;
                $('#gendermsg').hide();
                $('#gender').attr('style','border: 1px solid #ccc');
            }

            if(prof==""){
                p4=0;
                $('#profmsg').show();
                var message=document.getElementById('profmsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#professional').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p4=1;
                $('#profmsg').hide();
                $('#professional').attr('style','border-bottom: 1px solid #ccc');
            }


            if(address==""){
                p5=0;
                $('#addressmsg').show();
                var message=document.getElementById('addressmsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#address').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p5=1;
                $('#addressmsg').hide();
                $('#address').attr('style','border-bottom: 1px solid #ccc');
            }

            if(email==""){
                p6=0;
                $('#emailmsg').show();
                var message=document.getElementById('emailmsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#email').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p6=1;
                $('#emailmsg').hide();
                $('#email').attr('style','border-bottom: 1px solid #ccc');
            }


            var phone_digits=$('#phone_number').val().length;

            if(phone_digits<10){
                p7=0;
                $('#phonemsg').show();
                var message = document.getElementById('phonemsg');
                message.style.color = 'red';
                message.innerHTML = "Digits cannot be less than 10";
                $('#phone_number').attr('style', 'border-bottom:1px solid #f00');

            }else{
                p7=1;
                $('#phonemsg').hide();
                $('#phone_number').attr('style','border-bottom: 1px solid #ccc');
            }




            if(purpose==""){
                p8=0;
                $('#purposemsg').show();
                var message=document.getElementById('purposemsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#purpose').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p8=1;
                $('#purposemsg').hide();
                $('#purpose').attr('style','border-bottom: 1px solid #ccc');
            }


            if(issue_date==""){
                p10=0;
                $('#issue_datemsg').show();
                var message=document.getElementById('issue_datemsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#issue_date').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p10=1;
                $('#issue_datemsg').hide();
                $('#issue_date').attr('style','border-bottom: 1px solid #ccc');
            }

            if(issue_place==""){
                p11=0;
                $('#issue_placemsg').show();
                var message=document.getElementById('issue_placemsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#issue_place').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p11=1;
                $('#issue_placemsg').hide();
                $('#issue_place').attr('style','border-bottom: 1px solid #ccc');
            }


            if(nationality==""){
                p12=0;
                $('#nationality_msg').show();
                var message=document.getElementById('nationality_msg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#nationality').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p12=1;
                $('#nationality_msg').hide();
                $('#nationality').attr('style','border-bottom: 1px solid #ccc');
            }




            if(tin==""){
                ptin=0;
                $('#tin_msg').show();
                var message=document.getElementById('tin_msg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#tin').attr('style','border-bottom:1px solid #f00');
            }
            else{
                ptin=1;
                $('#tin_msg').hide();
                $('#tin').attr('style','border-bottom: 1px solid #ccc');
            }




            if(nationality.toLowerCase()=='tanzanian'){

                if(p1==1 && p2==1 && p3==1 && p4==1 && p5==1 && p6==1 && p7==1 && p8==1 && p10==1 && p11==1 && p12==1 && ptin==1){


                    if(has_host=='Yes'){

                        next_fs = $(this).parent().next();
                    }else{

                        next_fs = $(this).parent().next().next();

                    }


                    gonext();
                }

            }else{

                if(passport_no==""){
                    p9=0;
                    $('#pass_nomsg').show();
                    var message=document.getElementById('pass_nomsg');
                    message.style.color='red';
                    message.innerHTML="Required";
                    $('#passport_no').attr('style','border-bottom:1px solid #f00');
                }
                else{
                    p9=1;
                    $('#pass_nomsg').hide();
                    $('#passport_no').attr('style','border-bottom: 1px solid #ccc');
                }

                if(p1==1 && p2==1 && p3==1 && p4==1 && p5==1 && p6==1 && p7==1 && p8==1 && p9==1 && p10==1 && p11==1 && p12==1 && ptin==1){

                    if(has_host=='Yes'){

                        next_fs = $(this).parent().next();
                    }else{

                        next_fs = $(this).parent().next().next();

                    }


                    gonext();
                }


            }
        });


        $("#next0").click(function(){
            var p1, p2, p3, p4, p5, p6;
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            var host_name = $('#host_name').val(),
                college = $('#college').val(),
                department = $('#department').val(),
                host_address = $('#host_address').val(),
                host_email= $('#host_email').val(),
                host_phone=$('#host_phone').val();
            if(host_name==""){
                p1=0;
                $('#host_namemsg').show();
                var message=document.getElementById('host_namemsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#host_name').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p1=1;
                $('#host_namemsg').hide();
                $('#host_name').attr('style','border-bottom: 1px solid #ccc');
            }

            if(college==""){
                p2=0;
                $('#collegemsg').show();
                var message=document.getElementById('collegemsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#college').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p2=1;
                $('#collegemsg').hide();
                $('#college').attr('style','border-bottom: 1px solid #ccc');
            }

            if(department==""){
                p3=0;
                $('#departmentmsg').show();
                var message=document.getElementById('departmentmsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#department').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p3=1;
                $('#departmentmsg').hide();
                $('#department').attr('style','border-bottom: 1px solid #ccc');
            }

            if(host_address==""){
                p4=0;
                $('#host_addressmsg').show();
                var message=document.getElementById('host_addressmsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#host_address').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p4=1;
                $('#host_addressmsg').hide();
                $('#host_address').attr('style','border-bottom: 1px solid #ccc');
            }

            if(host_email==""){
                p5=0;
                $('#host_emailmsg').show();
                var message=document.getElementById('host_emailmsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#host_email').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p5=1;
                $('#host_emailmsg').hide();
                $('#host_email').attr('style','border-bottom: 1px solid #ccc');
            }


            var phone_digits=$('#host_phone').val().length;

            if(phone_digits<10) {
                p6=0;
                $('#host_phonemsg').show();
                var message = document.getElementById('host_phonemsg');
                message.style.color = 'red';
                message.innerHTML = "Digits cannot be less than 10";
                $('#host_phone').attr('style', 'border-bottom:1px solid #f00');

            }else{
                p6=1;
                $('#host_phonemsg').hide();
                $('#host_phone').attr('style','border-bottom: 1px solid #ccc');
            }




            if(p1==1 && p2==1 && p3==1 && p4==1 && p5==1 && p6==1){
                gonext();
            }
        });

$("#next2").click(function(){
    var p1, p2, p3, p4;
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();
    var room = $('#room_no').val(),
        arrival_date = $('#arrival_date').val(),
        arrival_time = $('#arrival_time').val(),
        departure_date = $('#departure_date').val();

        if(room==null){
            p1=0;
             $('#roommsg').show();
             var message=document.getElementById('roommsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#room_no').attr('style','border:1px solid #f00');
        }
        else{
            p1=1;
            $('#roommsg').hide();
            $('#room_no').attr('style','border-bottom: 1px solid #ccc');
        }

        if(arrival_date==""){
            p2=0;
             $('#arrival_datemsg').show();
             var message=document.getElementById('arrival_datemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#arrival_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
            p2=1;
            $('#arrival_datemsg').hide();
            $('#arrival_date').attr('style','border-bottom: 1px solid #ccc');
        }

        if(arrival_time==""){
            p3=0;
             $('#arrival_timemsg').show();
             var message=document.getElementById('arrival_timemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#arrival_time').attr('style','border-bottom:1px solid #f00');
        }
        else{
            p3=1;
            $('#arrival_timemsg').hide();
            $('#arrival_time').attr('style','border-bottom: 1px solid #ccc');
        }

        if(departure_date==""){
            p4=0;
             $('#departure_datemsg').show();
             var message=document.getElementById('departure_datemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#departure_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
            p4=1;
            $('#departure_datemsg').hide();
            $('#departure_date').attr('style','border-bottom: 1px solid #ccc');
        }


        function diff_indays(date1, date2) {
                dt1 = new Date(date1);
                dt2 = new Date(date2);
                return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
        }

        var category= $('#category').val();

            if(arrival_date!="" && departure_date!=""){
                var start_date= $('#arrival_date').val(),
                    end_date = $('#departure_date').val();

                var days = diff_indays(start_date, end_date);

                    if(days==0){
                        days =1;
                    }
            }

            if(category=='Shared Room'){
                var price = $('#shared_room_usd').val().replace(/\D/g,''),
                    total = days*price;
                $('#total_shared_usd').val(total);
            }
            else if(category=='Single Room'){
                var price=$('#single_room_usd').val().replace(/\D/g,''),
                    total = days*price;
                $('#total_single_usd').val(total);
            }
            else if(category=='Suit Room'){
                var price = $('#suit_room_usd').val().replace(/\D/g,''),
                    total = days*price;
                $('#total_suit_usd').val(total);
            }


        if(p1==1 && p2==1 && p3==1 && p4==1){
            gonext();
        }

  });

        $("#next3").click(function(){
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            var category= $('#category').val();
            var p1, p2, p3, p4, p5, p6, p7;








            if(category=='Shared Room'){
                var usd = $('#shared_room_usd').val(),
                    tzs = $('#shared_room').val(),
                    total_usd = $('#total_shared_usd').val(),
                    total_tzs = $('#total_shared_tzs').val();

                if(usd==""){
                    p1=0;
                    $('#shared_room_usd').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p1=1;
                    $('#shared_room_usd').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }

                if(tzs==""){
                    p2=0;
                    $('#shared_room').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p2=1;
                    $('#shared_room').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }

                if(total_usd==""){
                    p3=0;
                    $('#total_shared_usd').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p3=1;
                    $('#total_shared_usd').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }

                if(total_tzs==""){
                    p4=0;
                    $('#total_shared_tzs').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p4=1;
                    $('#total_shared_tzs').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }

            }

            else if(category=='Single Room'){
                var usd = $('#single_room_usd').val(),
                    tzs = $('#single_room').val(),
                    total_usd = $('#total_single_usd').val(),
                    total_tzs = $('#total_single_tzs').val();

                if(usd==""){
                    p1=0;
                    $('#single_room_usd').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p1=1;
                    $('#single_room_usd').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }

                if(tzs==""){
                    p2=0;
                    $('#single_room').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p2=1;
                    $('#single_room').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }

                if(total_usd==""){
                    p3=0;
                    $('#total_single_usd').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p3=1;
                    $('#total_single_usd').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }

                if(total_tzs==""){
                    p4=0;
                    $('#total_single_tzs').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p4=1;
                    $('#total_single_tzs').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }
            }

            else if(category=='Suit Room'){
                var usd = $('#suit_room_usd').val(),
                    tzs = $('#suit_room').val(),
                    total_usd = $('#total_suit_usd').val(),
                    total_tzs = $('#total_suit_tzs').val();


                if(usd==""){
                    p1=0;
                    $('#suit_room_usd').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p1=1;
                    $('#suit_room_usd').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }

                if(tzs==""){
                    p2=0;
                    $('#suit_room').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p2=1;
                    $('#suit_room').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }

                if(total_usd==""){
                    p3=0;
                    $('#total_suit_usd').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p3=1;
                    $('#total_suit_usd').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }

                if(total_tzs==""){
                    p4=0;
                    $('#total_suit_tzs').attr('style','border:1px solid #f00; width: 15%; margin: 10px; padding: 3px;');
                }
                else{
                    p4=1;
                    $('#total_suit_tzs').attr('style','border:1px solid #ccc; width: 15%; margin: 10px; padding: 3px;');
                }
            }


            var receipt_no = $('#receipt_no').val();
            if(receipt_no==""){
                p5=0;
                $('#receipt_no_msg').show();
                var message=document.getElementById('receipt_no_msg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#receipt_no').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p5=1;
                $('#receipt_no_msg').hide();
                $('#receipt_no').attr('style','border-bottom: 1px solid #ccc');
            }


            var receipt_date = $('#receipt_date').val();
            if(receipt_date==""){
                p6=0;
                $('#receipt_date_msg').show();
                var message=document.getElementById('receipt_date_msg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#receipt_date').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p6=1;
                $('#receipt_date_msg').hide();
                $('#receipt_date').attr('style','border-bottom: 1px solid #ccc');
            }


            var total_days = $('#total_days').val();
            if(total_days==""){
                p7=0;
                $('#total_days_msg').show();
                var message=document.getElementById('total_days_msg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#total_days').attr('style','border-bottom:1px solid #f00');
            }
            else{
                p7=1;
                $('#total_days_msg').hide();
                $('#total_days').attr('style','border-bottom: 1px solid #ccc');
            }

            if(p1==1 && p2==1 && p3==1 && p4==1 && p5==1 && p6==1 && p7==1){
                gonext();
            }

        });
});
</script>




<script>

    function minCharacters(value){



        if(value.length<9){

            document.getElementById("next1").disabled = true;
            document.getElementById("error_tin").style.color = 'red';
            document.getElementById("error_tin").style.float = 'left';
            document.getElementById("error_tin").style.paddingTop = '1%';
            document.getElementById("error_tin").innerHTML ='TIN number cannot be less than 9 digits';

        }else{
            document.getElementById("error_tin").innerHTML ='';
            document.getElementById("next1").disabled = false;
        }

    }


</script>



<script>


        <?php
        $today_date=date('Y-m-d');

        ?>

    var today_date={!! json_encode($today_date) !!};


    $("#issue_date").datepicker({
        dateFormat: 'dd/mm/yy',
        autoclose: true,
        altField: "#issue_date_alternate",
        altFormat: "yy-mm-dd",
        todayHighlight: true,
        rtl: true,
        orientation:"auto"
    });


    $("#arrival_date").datepicker({
        dateFormat: 'dd/mm/yy',
        autoclose: true,
        altField: "#arrival_date_alternate",
        altFormat: "yy-mm-dd",
        todayHighlight: true,
        rtl: true,
        orientation:"auto"
    });


    $("#departure_date").datepicker({
        dateFormat: 'dd/mm/yy',
        autoclose: true,
        altField: "#departure_date_alternate",
        altFormat: "yy-mm-dd",
        todayHighlight: true,
        rtl: true,
        orientation:"auto"
    });


    $("#receipt_date").datepicker({
        dateFormat: 'dd/mm/yy',
        autoclose: true,
        altField: "#receipt_date_alternate",
        altFormat: "yy-mm-dd",
        todayHighlight: true,
        rtl: true,
        orientation:"auto"
    });




    $('#arrival_time').timepicker({
        timeFormat: 'HH:mm',
        interval: 60,
        dropdown: true,
        scrollbar: true
    });



        window.onload=function(){

  var received_issue_date={!! json_encode($received_issue_date) !!};


  $('#issue_date_alternate').val(received_issue_date);


  var received_receipt_date={!! json_encode($received_receipt_date) !!};

            $('#receipt_date_alternate').val(received_receipt_date);
        };



</script>



@endsection
