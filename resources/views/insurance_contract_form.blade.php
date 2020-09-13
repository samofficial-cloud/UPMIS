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

#progressbar #vehicle:before {
    font-family: FontAwesome;
    content: "\f1b9"
}

    #progressbar #insurance:before {
        font-family: FontAwesome;
        content: "\f15c"
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
            @if($category=='Insurance only' OR $category=='All')
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
    @else
    @endif
            @if($category=='CPTU only' OR $category=='All')
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
    @else
    @endif
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <div class="dropdown">
  <li class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <i class="fas fa-file-contract"></i> Contracts
  </li>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="/contracts/car_rental">Car Rental</a>
    <a class="dropdown-item" href="/insurance_contracts_management">Insurance</a>
    <a class="dropdown-item" href="/space_contracts_management">Space</a>
  </div>
</div>
            <li><a href="#"><i class="fas fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
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
                <h2><strong>Insurance Contract Information</strong></h2>
                <p>Fill all form field with (*) to go to the next step</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" METHOD="GET" action="{{ route('create_insurance_contract')}}">
                            <!-- progressbar -->
                            <ul id="progressbar">

                            	<li class="" id="insurance"><strong>Insurance</strong></li>
                                <li  id="vehicle"><strong>Vehicle</strong></li>
                                <li id="payment"><strong>Payment</strong></li>
                            </ul>


                             <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                   <h2 style="text-align: center" class="fs-title">Insurance Information</h2>
                                    <div class="form-group">






                                        <div class="form-group row">

                                            <div class="form-wrapper col-12">
                                                <br>
                                                <label for="space_location"  ><strong>Client Name</strong></label>
                                                <input type="text" id="full_name" name="full_name" class="form-control" required>
                                            </div>

                                            <div class="form-wrapper col-6">
                                                <br>
                                                <label for="client_type"><strong>Principal</strong></label>

                                                <select class="form-control"  id="principal" name="principal">

                                                    <?php

                                                    $tempOut = array();
                                                    foreach($insurance_data as $values){
                                                        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($values));
                                                        $val = (iterator_to_array($iterator,true));
                                                        $tempoIn=$val['insurance_company'];

                                                        if(!in_array($tempoIn, $tempOut))
                                                        {
                                                            print('<option value="'.$val['insurance_company'].'">'.$val['insurance_company'].'</option>');
                                                            array_push($tempOut,$tempoIn);
                                                        }

                                                    }
                                                    ?>

                                                </select>
                                            </div>

                                            <div class="form-wrapper col-6">
                                                <br>
                                                <label for="space_location"  ><strong>Insurance Type</strong></label>
                                                <select class="form-control" id="insurance_type" name="insurance_type" >
                                                    <option value="THIRD PARTY" id="Option" >THIRD PARTY</option>
                                                    <option value="COMPREHENSIVE" id="Option">COMPREHENSIVE</option>
                                                </select>
                                            </div>
                                        </div>


    </div>


                                    <br>
                                    <br>

                                </div>
 <input type="button" name="next" id="next1" class="next action-button" value="Next Step" />
                            </fieldset>
                            {{-- Second Form --}}
                            <fieldset>
                                <div class="form-card">
                                  <h2 style="text-align: center" class="fs-title">Vehicle Information</h2>




                                    <div class="form-group row">
                                        <div class="form-wrapper col-12">
                                            <br>
                                            <label for="client_type"><strong>Vehicle Registration Number</strong></label>

                                            <input type="text" id="vehicle_registration_no" name="vehicle_registration_no" class="form-control" required>
                                        </div>

                                        <br>
                                        <div class="form-wrapper col-12">
                                            <label for="vehicle_use"  ><strong>Vehicle Use</strong></label>
                                            <select class="form-control" id="vehicle_use" name="vehicle_use" >
                                                <option value="PRIVATE" id="Option" >PRIVATE</option>
                                                <option value="COMMERCIAL" id="Option">COMMERCIAL</option>
                                            </select>
                                        </div>
                                    </div>



                                    <br>
                                    <br>
                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="button" id="next2" name="next" class="next action-button" value="Next Step" />
                            </fieldset>
                            {{-- Third Form --}}
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Payment Information</h2>
				<div class="form-group row">
						<div class="form-wrapper col-6">
							<label for="start_date">Commission Date *</label>
							<input type="date" id="commission_date" name="commission_date" class="form-control" required="" min="{{$today}}">
						</div>
						<div class="form-wrapper col-6">
							<label for="end_date">End Date *</label>
							<input type="date" id="end_date" name="end_date" class="form-control" required="" min="{{$today}}">
						</div>
					</div>

					<div class="form-group row">

					<div class="form-wrapper col-6">
						<label for="amount">Sum Insured *</label>
						<input type="number" min="0" id="sum_insured" name="sum_insured" class="form-control" required="">
					</div>

                        <div class="form-wrapper col-6">
                            <label for="amount">Premium *</label>
                            <input type="number" min="0"  id="premium" name="premium" class="form-control" required="">
                        </div>





				</div>

                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="amount">Actual (Excluding VAT) *</label>
                                            <input type="number" min="0" id="actual_ex_vat" name="actual_ex_vat" class="form-control" required="">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="currency">Currency</label>
                                            <select id="currency" class="form-control" name="currency" >
                                                <option value="TZS" >TZS</option>
                                                <option value="USD" >USD</option>
                                            </select>
                                        </div>


                                    </div>

                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="amount">Commission * </label>
                                            <input type="number" min="0" id="commission" name="commission" class="form-control" required="">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="amount">Receipt Number * </label>
                                            <input type="text" id="receipt_no" name="receipt_no" class="form-control" required="">
                                        </div>


                                    </div>


                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="submit" name="make_payment" class="submit action-button" value="Confirm" />
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

var current_fs, next_fs, previous_fs; //fieldsets
var opacity;
var p1, p2;
$("#next1").click(function(){
current_fs = $(this).parent();
next_fs = $(this).parent().next();
    gonext();

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


{{--<script>--}}
{{--    $( document ).ready(function() {--}}


{{--        $('#space_id_contract').keyup(function(e){--}}
{{--            e.preventDefault();--}}
{{--            var query = $(this).val();--}}



{{--            if(query != '')--}}
{{--            {--}}
{{--                var _token = $('input[name="_token"]').val();--}}

{{--                var major_industry=document.getElementById("major_industry").value;--}}
{{--                var space_location=document.getElementById("space_location").value;--}}



{{--                $.ajax({--}}
{{--                    url:"{{ route('autocomplete.space_id') }}",--}}
{{--                    method:"GET",--}}
{{--                    data:{query:query,major_industry:major_industry,space_location:space_location, _token:_token},--}}
{{--                    success:function(data){--}}
{{--                        if(data=='0'){--}}
{{--                            $('#space_id_contract').attr('style','border:1px solid #f00');--}}

{{--                        }--}}
{{--                        else{--}}

{{--                            $('#space_id_contract').attr('style','border:1px solid #ced4da');--}}
{{--                            $('#nameListSpaceId').fadeIn();--}}
{{--                            $('#nameListSpaceId').html(data);--}}
{{--                        }--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}
{{--            else if(query==''){--}}

{{--                $('#space_id_contract').attr('style','border:1px solid #ced4da');--}}
{{--            }--}}
{{--        });--}}

{{--        $(document).on('click', '#listSpacePerTypeLocation', function(){--}}


{{--            $('#space_id_contract').attr('style','border:1px solid #ced4da');--}}

{{--            $('#space_id_contract').val($(this).text());--}}



{{--            $('#nameListSpaceId').fadeOut();--}}

{{--            //space already selected, fill size automatically--}}
{{--            var selected_space_id=$(this).text();--}}

{{--            $.ajax({--}}
{{--                url:"{{ route('autocomplete.space_size') }}",--}}
{{--                method:"get",--}}
{{--                data:{selected_space_id:selected_space_id},--}}
{{--                success:function(data){--}}
{{--                    if(data=='0'){--}}
{{--                        $('#space_size').attr('style','border:1px solid #f00');--}}


{{--                    }--}}
{{--                    else{--}}




{{--                        $('#space_size').attr('style','border:1px solid #ced4da');--}}
{{--                        $('#space_size').val(data);--}}

{{--                    }--}}
{{--                }--}}
{{--            });--}}




{{--        });--}}








{{--    });--}}


{{--</script>--}}

@endsection
