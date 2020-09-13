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
            <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>
            @if($category=='Real Estate only' OR $category=='All')
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            @else
            @endif
            <li><a href="#"><i class="fas fa-address-card"></i>Insurance</a></li>
            <li><a href="#"><i class="fas fa-car-side"></i>Car Rental</a></li>
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <li><a href="#"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="#"><i class="fas fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="#"><i class="fas fa-file-pdf"></i>Reports</a></li>
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

                        <form id="msform" METHOD="GET" action="{{ route('renew_space_contract',$contract_id)}}">

                            <!-- progressbar -->
                            <ul id="progressbar">
                            	<li class="active" id="personal"><strong>Client</strong></li>
                                <li  id="account"><strong>Renting Space</strong></li>
                                <li id="payment"><strong>Payment</strong></li>
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

    <div class="form-group">
					<div class="form-wrapper">
						<label for="email">Email</label>
						<input type="text" name="email" readonly value="{{$var->email}}" id="email" class="form-control" placeholder="someone@example.com" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="phone_number">Phone Number</label>
                        <span id="phone_msg"></span>
                        <input type="text" id="phone_number" required name="phone_number" class="form-control" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="address">Address</label>
						<input type="text" readonly id="address" name="address" value="{{$var->address}}" class="form-control">
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
                                            <input type="text" class="form-control"  name="major_industry" value="{{$var->major_industry}}" readonly  autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for=""  ><strong>Minor industry</strong></label>
                                            <input type="text" class="form-control" id="major_industry_description" name="minor_industry" value="{{$var->minor_industry}}" readonly  autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="space_location"  ><strong>Location</strong></label>
                                            <input type="text" class="form-control"  name="space_location" value="{{$var->location}}" readonly  autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="space_location"  ><strong>Sub location</strong></label>
                                            <input type="text" readonly class="form-control" id="" name="space_sub_location" value="{{$var->sub_location}}"  autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="" ><strong>Space Number</strong></label>
                                            <input type="text" class="form-control" id="" name="space_id_contract" value="{{$var->space_id}}" readonly Required autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for=""  ><strong>Size (SQM) <span style="color: red;"></span></strong></label>
                                            <input type="number" min="1" step="0.01" class="form-control" id="" name="space_size" value="{{$var->size}}" readonly autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="has_water_bill"  ><strong>Need to also pay Water bill</strong></label>
                                            <input type="text" readonly class="form-control" id="" name="has_water_bill" value="{{$var->has_water_bill_space}}"  autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="has_electricity_bill"  ><strong>Need to also pay Electricity bill</strong></label>
                                            <input type="text" readonly class="form-control" id="" name="has_electricity_bill" value="{{$var->has_electricity_bill_space}}"  autocomplete="off">
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
                                            <input type="date" id="start_date" name="start_date" class="form-control" required="" min="{{$today}}">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="duration">Duration <span style="color: red;"> *</span></label>
                                            <input type="number"  min="1" max="50" id="duration" name="duration" class="form-control" required="" >
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="currency">Period <span style="color: red;"> *</span></label>
                                            <select id="currency" class="form-control" name="duration_period" required>
                                                <option value="" ></option>
                                                <option value="Months" >Months</option>
                                                <option value="Years" >Years</option>
                                            </select>
                                        </div>
                                    </div>

					<div class="form-group row">

					<div class="form-wrapper col-6">
						<label for="amount">Amount <span style="color: red;"> *</span></label>
						<input type="number" min="1" id="amount" name="amount" value="" class="form-control" required="">
					</div>

                        <div class="form-wrapper col-6">
                            <label for="currency">Currency</label>
                            <select id="currency" class="form-control" name="currency" >
                                <option value="" ></option>
                                <option value="TZS" >TZS</option>
                                <option value="USD" >USD</option>

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
                                                    <option value=""></option>

                                                @foreach($payment_cycles as $payment_cycle)

                                                        <option value="{{$payment_cycle->cycle}}">{{$payment_cycle->cycle}}</option>

                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="escalation_rate">Escalation Rate <span style="color: red;"> *</span></label>
                                            <input type="text" id="escalation_rate" name="escalation_rate" value="" class="form-control" required>
                                        </div>


                                    </div>


                                    @endforeach
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="submit" name="make_payment" class="submit action-button" value="Confirm" />
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

    <script type="text/javascript">
        window.onload=function(){
            document.getElementById("client_type").click();
        };
    </script>

    <script type="text/javascript">
        $(document).ready(function(){

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
