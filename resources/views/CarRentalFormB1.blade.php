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
    color: #212529;
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
    width: 100px;
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
    width: 100px;
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

#progressbar #account:before {
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
            	<h4><strong>UNIVERSITY OF DAR ES SALAAM - MAIN ADMINISTRATION</strong></h4>
                <h4><strong>CENTRAL POOL TRANSPORTATION UNIT<br>VEHICLE REQUISTION FORM</strong></h4>
                <br>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <h2 class="fs-title" style="margin-left: 10px;">  <a data-toggle="collapse" href="#collapse1">A. APPLICATION DETAILS</a></h2>
                        <div id="collapse1" class="collapse">
                        <form id="msform" method="post" action="#">
                            {{csrf_field()}}
                            <fieldset>
                                <div class="form-card">

                                   <div class="form-group">
					<div class="form-wrapper" id="areadiv">
          <label for="area">Area of Travel*</label>
            <input type="text" class="form-control" required="" id="area" name="area" value="{{$contract->area_of_travel}} Dar es Salaam/Kibaha" readonly="">
        </div>
    </div>

    <div class="form-group row" id="namediv">
                        <div class="form-wrapper col-2">
                            <label for="first_name">Designation</label>
                            <input type="text" id="designation" name="designation" class="form-control" value="{{$contract->designation}}" readonly>
                        </div>

                        <div class="form-wrapper col-5">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="{{$contract->first_name}}" readonly>
                        </div>
                        <div class="form-wrapper col-5">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="{{$contract->last_name}}" readonly="">
                        </div>
                    </div>

                    <div class="form-group">
                    <div class="form-wrapper">
                        <label for="email">Client Email</label>
                        <input type="text" name="email" id="email" class="form-control" readonly="" value="{{$contract->email}}">
                    </div>
                </div>

					<div class="form-group row" id="facultydiv">
						<div class="form-wrapper col-6">
							<label for="faculty_name">Faculty/Department/Unit</label>
							<input type="text" id="faculty_name" name="faculty_name" class="form-control"  value="{{$contract->faculty}}" readonly>
						</div>

						<div class="form-wrapper col-6">
							<label for="centre_name">Cost Centre No.</label>
							<input type="text" id="centre_name" name="centre_name" class="form-control" value="{{$contract->cost_centre}}" readonly>
						</div>
					</div>

					<div class="form-group row">
						<div class="form-wrapper col-6">
							<label for="start_date">Start Date</label>
							<input type="date" id="start_date" name="start_date" class="form-control" value="{{$contract->start_date}}" readonly="">
						</div>
						<div class="form-wrapper col-6">
							<label for="end_date">End Date</label>
							<input type="date" id="end_date" name="end_date" class="form-control" value="{{$contract->end_date}}" readonly="">
						</div>
					</div>

					<div class="form-group row">
						<div class="form-wrapper col-6">
							<label for="start_time">Start Time</label>
							<input type="time" id="start_time" name="start_time" class="form-control" readonly="" value="{{$contract->start_time}}">
						</div>
						<div class="form-wrapper col-6">
							<label for="end_time">End Time</label>
							<input type="time" id="end_time" name="end_time" class="form-control" readonly="" value="{{$contract->end_time}}">
						</div>
					</div>

					<div class="form-group">
					<div class="form-wrapper">
						<label for="overtime">Estimate Overtime</label>
					<input type="text" id="overtime" name="overtime" class="form-control" value="{{$contract->overtime}}" readonly="">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="destination">Destination</label>
						<input type="text" id="destination" name="destination" class="form-control" value="{{$contract->destination}}" readonly="">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="purpose">Purpose/reason of the trip</label>
						<input type="text" id="purpose" name="purpose" class="form-control" value="{{$contract->purpose}}" readonly="">
					</div>
				</div>

               <div class="form-group">
					<div class="form-wrapper" id="naturediv">
          <label for="trip_nature">Nature of the trip</label>
          <span id="trip_naturemsg"></span>
            <input type="text" class="form-control" required="" id="trip_nature" name="trip_nature" value="{{$contract->trip_nature}}" readonly="">
        </div>
    </div>

    <div class="form-group row" id="estimationdiv">
						<div class="form-wrapper col-6">
							<label for="estimated_distance">Estimated Distance in Kms</label>
							<input type="text" id="estimated_distance" name="estimated_distance" class="form-control" value="{{number_format($contract->estimated_distance)}}" readonly onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
						</div>
						<div class="form-wrapper col-6">
							<label for="estimated_cost">Estimated Cost in Tshs.</label>
                            <span id="estimated_costmsg"></span>
							<input type="text" id="estimated_cost" name="estimated_cost" class="form-control" value="{{number_format($contract->estimated_cost)}}"  readonly onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
						</div>
					</div>
    @if($nature =='Private')
        <div class="form-group" id="initial_amountdiv">
            <div class="form-wrapper" >
                <label for="initial_pay">Initial Amount<span style="color: red;">*</span></label>
                <span id="initialmsg"></span>
                <input type="text" id="initial_amount" name="initial_amount" class="form-control" autocomplete="off" value="{{number_format($contract->initial_payment)}}" readonly="">
            </div>
        </div>
    @endif

                                </div>
                            </fieldset>

                        </form>
                    </div>
                    <h2 class="fs-title" style="margin-left: 10px;">  <a data-toggle="collapse" href="#collapse2">B. AVAILABILITY OF FUNDS</a></h2>
                    <div id="collapse2" class="collapse show">
                        @if($contract->head_approval_status == 'Rejected')
                        <form id="msform" method="post" action="{{ route('newCarcontractB') }}">
                            {{csrf_field()}}
                            <fieldset>
                                <div class="form-card">
                        <p style="color: red; text-align: left;">This Application has been rejected by the accountant due to the following reason(s).</p>
                        <div class="form-group">
                    <div class="form-wrapper">
                        <textarea type="text" id="acc_remark" name="acc_remark" class="form-control" value="" readonly="" style="border: inset !important;">{{$contract->acc_remark}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="code_no">Travel/Transport Activity Code No.<span style="color: red;">*</span></label>
                        <input type="text" id="code_no" name="code_no" class="form-control" value="{{$contract->transport_code}}" required onkeypress="if((this.value.length<=5)){return true} else{return false}" onblur="javascript:this.value=this.value.toUpperCase();">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="fund_available">Funds Available for Further use in Tshs.<span style="color: red;">*</span></label>
                        <input type="text" id="fund_available" name="fund_available" class="form-control" value="{{$contract->funds_available}}" required autocomplete="off" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;" onblur="
                        var query=document.getElementById('fund_available').value;
                        query2={{$contract->estimated_cost}};
                        if(query<query2){
                            let element = document.getElementById('balance_status');
                            element.value = 'Not Sufficient';
                        }
                        else{
                          let element = document.getElementById('balance_status');
                            element.value = 'Sufficient';
                        }
                        ">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-wrapper" id="balance_statusdiv">
          <label for="balance_status">Balance Status<span style="color: red;">*</span></label>
          <span id="balance_statusmsg"></span>
            <select class="form-control" required="" id="balance_status" name="balance_status">
              <option value="" disabled selected hidden>Select balance status</option>
              <option value="Sufficient">Sufficient</option>
              <option value="Not Sufficient">Not Sufficient</option>
            </select>

        </div>
    </div>

                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="vote_holder">Vote Holder Title<span style="color: red;">*</span></label>
                        <input type="text" id="vote_holder" name="vote_holder" required="{{$contract->vote_title}}" class="form-control" value="{{$contract->vote_title}}" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="commited_fund">Fund to commit<span style="color: red;">*</span></label>
                         <input type="text" id="commited_fund" name="commited_fund" required class="form-control" value="{{$contract->fund_committed}}" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                    </div>
                </div>

                 <div class="form-group" id="vote_remarkdiv">
                    <div class="form-wrapper">
                        <label for="vote_remark">Remarks</label>
                         <textarea type="text" id="vote_remarks" name="vote_remarks" class="form-control" value="" style="border: inset !important;"></textarea>
                    </div>
                </div>

    <div class="form-group row" id="approvedbydiv">
                        <div class="form-wrapper col-6">
                            <label for="approve_name">Name<span style="color: red;">*</span></label>
                            <span id="approve_namemsg"></span>
                            <input type="text" id="approve_name" name="approve_name" class="form-control" value="{{ Auth::user()->name }}" readonly="">
                        </div>
                        <div class="form-wrapper col-6">
                            <label for="approve_date">Date<span style="color: red;">*</span></label>
                            <span id="approve_datemsg"></span>
                            <input type="date" id="approve_date" name="approve_date" class="form-control" value="{{$today}}" readonly="">
                        </div>
                    </div>
                    <input type="text" name="contract_id" value="{{$contract->id}}" hidden="">
            </div>
            <button class="btn btn-primary" type="submit">Forward</button>
        </fieldset>
                    </form>

                        @else
                        <form id="msform" method="post" action="{{ route('newCarcontractB') }}">
                            {{csrf_field()}}
                            <fieldset>
                                <div class="form-card">

                    <div class="form-group">
                    <div class="form-wrapper">
                        <label for="code_no">Travel/Transport Activity Code No.<span style="color: red;">*</span></label>
                        <input type="text" id="code_no" name="code_no" class="form-control" required onkeypress="if((this.value.length<=5)){return true} else{return false}" onblur="javascript:this.value=this.value.toUpperCase();">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="fund_available">Funds Available for Further use in Tshs.<span style="color: red;">*</span></label>
                        <input type="text" id="fund_available" name="fund_available" class="form-control" required autocomplete="off" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;" onblur="
                        var query=document.getElementById('fund_available').value;
                        query2={{$contract->estimated_cost}};
                        if(query<query2){
                            let element = document.getElementById('balance_status');
                            element.value = 'Not Sufficient';
                        }
                        else{
                          let element = document.getElementById('balance_status');
                            element.value = 'Sufficient';
                        }
                        ">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-wrapper" id="balance_statusdiv">
          <label for="balance_status">Balance Status<span style="color: red;">*</span></label>
          <span id="balance_statusmsg"></span>
            <select class="form-control" required="" id="balance_status" name="balance_status">
              <option value="" disabled selected hidden>Select balance status</option>
              <option value="Sufficient">Sufficient</option>
              <option value="Not Sufficient">Not Sufficient</option>
            </select>

        </div>
    </div>

                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="vote_holder">Vote Holder Title<span style="color: red;">*</span></label>
                        <input type="text" id="vote_holder" name="vote_holder" required="" class="form-control" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="commited_fund">Fund to commit<span style="color: red;">*</span></label>
                         <input type="text" id="commited_fund" name="commited_fund" required class="form-control" value="{{$contract->estimated_cost}}" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                    </div>
                </div>

    <div class="form-group row" id="approvedbydiv">
                        <div class="form-wrapper col-6">
                            <label for="approve_name">Name<span style="color: red;">*</span></label>
                            <span id="approve_namemsg"></span>
                            <input type="text" id="approve_name" name="approve_name" class="form-control" value="{{ Auth::user()->name }}" readonly="">
                        </div>
                        <div class="form-wrapper col-6">
                            <label for="approve_date">Date<span style="color: red;">*</span></label>
                            <span id="approve_datemsg"></span>
                            <input type="date" id="approve_date" name="approve_date" class="form-control" value="{{$today}}" readonly="">
                        </div>
                    </div>
                    <input type="text" name="contract_id" value="{{$contract->id}}" hidden="">

                                </div>
                                @if($nature =='Private')
                                     <button class="btn btn-primary" type="submit">Next</button>
                                @else
                                   <button class="btn btn-primary" type="submit">Forward</button>
                                @endif
                            </fieldset>

                        </form>
                        @endif
                    </div>


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
@endsection
