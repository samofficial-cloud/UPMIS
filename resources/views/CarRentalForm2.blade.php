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

            @if($category=='Real Estate only' OR $category=='All')
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            @else
            @endif

            @if($category=='Insurance only' OR $category=='All')
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
    @else
    @endif
            @if(($category=='CPTU only' OR $category=='All') && (Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
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
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" method="post" action="{{ route('newCarcontractA') }}">
                            {{csrf_field()}}
                            <fieldset>
                                <div class="form-card">
                                   <h2 class="fs-title">A. APPLICATION DETAILS</h2>
                                   <p>Fill all form field with (<span style="color: red;">*</span>)</p>
                                   <div class="form-group">
					<div class="form-wrapper" id="areadiv">
          <label for="area">Area of Travel<span style="color: red;">*</span></label>
          <span id="areamsg"></span>
            <select class="form-control" required="" id="area" name="area" required="">
              <option value="" disabled selected hidden>select area of travel</option>
              <option value="Within">Within Dar es Salaam/Kibaha</option>
              <option value="Outside">Outside Dar es Salaam/Kibaha</option>
            </select>

        </div>
    </div>

    <div class="form-group row" id="namediv">

        <div class="form-wrapper col-4">
                            <label for="first_name">First Name<span style="color: red;">*</span></label>
                            <span id="name1msg"></span>
                            <input type="text" id="first_name" name="first_name" class="form-control"  required="" autocomplete="off" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;" >
                            <span id="nameList"></span>
                        </div>
                        <div class="form-wrapper col-4">
                            <label for="last_name">Last Name<span style="color: red;">*</span></label>
                            <span id="name2msg"></span>
                            <input type="text" id="last_name" name="last_name" class="form-control" required="" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                        </div>

                        <div class="form-wrapper col-4">
                            <label for="designation">Designation<span style="color: red;">*</span></label>
                            <span id="designationmsg"></span>
                            <input type="text" id="designation" name="designation" class="form-control"  required="" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;" >
                            {{-- <select class="form-control" required="" id="designation" name="designation">
              <option value="" disabled selected hidden> </option>
              <option value="Prof.">Prof.</option>
              <option value="Dr.">Dr.</option>
              <option value="Eng.">Eng.</option>
              <option value="Mr.">Mr.</option>
              <option value="Mrs.">Mrs.</option>
              <option value="Miss">Miss</option>
            </select> --}}
                        </div>

						
					</div>

                    <div class="form-group">
                    <div class="form-wrapper">
                        <label for="email">Email<span style="color: red;">*</span></label>
                        <input type="text" name="email" id="email" class="form-control" required placeholder="someone@example.com" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
                    </div>
                </div>

					<div class="form-group row" id="facultydiv">
						<div class="form-wrapper col-6">
							<label for="centre_name">Cost Centre No.<span style="color: red;">*</span></label>
                            <span id="name2msg"></span>
                            <div id="myDropdown">
                            <select type="text" id="centre_name" name="centre_name" class="form-control" required="" onkeyup="filterFunction()">
							<option value="" disabled selected hidden> </option>
                            @foreach($cost_centres as $cost_centre)
                            <option value="{{$cost_centre->costcentre_id}}">{{$cost_centre->costcentre_id}}-{{$cost_centre->costcentre}}</option>
                            @endforeach
                        </select>
                    </div>
						</div>

                        <div class="form-wrapper col-6">
                            <label for="faculty_name">Faculty/Department/Unit<span style="color: red;">*</span></label>
                            <span id="name1msg"></span>
                            <input type="text" id="faculty_name" name="faculty_name" class="form-control"  required="" readonly="" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                        </div>
					</div>

					<div class="form-group row">
						<div class="form-wrapper col-6">
							<label for="start_date">Start Date<span style="color: red;">*</span></label>
							<input type="date" id="start_date" name="start_date" class="form-control" required="" min="{{$today}}">
						</div>
						<div class="form-wrapper col-6">
							<label for="end_date">End Date<span style="color: red;">*</span></label>
							<input type="date" id="end_date" name="end_date" class="form-control" required="" min="{{$today}}">
						</div>
					</div>

					<div class="form-group row">
						<div class="form-wrapper col-6">
							<label for="start_time">Start Time<span style="color: red;">*</span></label>
							<input type="time" id="start_time" name="start_time" class="form-control" required="">
						</div>
						<div class="form-wrapper col-6">
							<label for="end_time">End Time<span style="color: red;">*</span></label>
							<input type="time" id="end_time" name="end_time" class="form-control" required="">
						</div>
					</div>

					<div class="form-group">
					<div class="form-wrapper">
						<label for="overtime">Estimate Overtime in Hrs<span style="color: red;">*</span></label>
						<input type="text" id="overtime" name="overtime" class="form-control" required="" onkeypress="if((this.value.length<=2) && ((event.charCode >= 48 && event.charCode <= 57)||(event.charCode==46))){return true} else return false;">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="destination">Destination<span style="color: red;">*</span></label>
						<input type="text" id="destination" name="destination" class="form-control" required="" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="purpose">Purpose/reason of the trip<span style="color: red;">*</span></label>
						<input type="text" id="purpose" name="purpose" class="form-control" required="" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
					</div>
				</div>

               <div class="form-group">
					<div class="form-wrapper" id="naturediv">
          <label for="trip_nature">Nature of the trip<span style="color: red;">*</span></label>
          <span id="trip_naturemsg"></span>
            <select class="form-control" required="" id="trip_nature" name="trip_nature" required="">
              <option value="" disabled selected hidden>select nature of the trip</option>
              <option value="Departmental">Department/Unit Duty</option>
              <option value="Private">Private</option>
              <option value="Emergency">Emergency</option>
            </select>

        </div>
    </div>

    <div class="form-group row" id="estimationdiv">
						<div class="form-wrapper col-6">
							<label for="estimated_distance">Estimated Distance in Kms<span style="color: red;">*</span></label>
                            <span id="estimated_distancemsg"></span>
							<input type="text" id="estimated_distance" name="estimated_distance" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
						</div>
						<div class="form-wrapper col-6">
							<label for="estimated_cost">Estimated Cost in Tshs.<span style="color: red;">*</span></label>
                            <span id="estimated_costmsg"></span>
							<input type="text" id="estimated_cost" name="estimated_cost" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
						</div>
					</div>

                                </div>
                                    <button class="btn btn-primary" type="submit" id="forward">Forward</button>
                                    <button class="btn btn-primary" type="submit" id="next" style="display: none;">Next</button>
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
    function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("centre_name");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("option");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>
<script type="text/javascript">
     $(document).ready(function(){
        $('#trip_nature').click(function(e){
            var values = $(this).val();
            if(values == 'Private'){
                $('#next').show();
                $('#forward').hide();
            }
            else{
                $('#next').hide();
                $('#forward').show(); 
            }
        });
    $('#centre_name').click(function(e){
        $('#faculty_name').val("");
    var query = $('#centre_name').val();
        //console.log(query);
        if(query!=''){
       var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.faculty') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#faculty_name').val(data);
          }
          });

     }
         });

    $('#first_name').keyup(function(){
        // $('#last_name').val('');
        // $('#centre_name').val('');
        // $('#faculty_name').val('');
        // $('#email').val('');
        // $('#designation').val('');
        var query = $(this).val();
        if(query != ''){
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url:"{{ route('autocomplete.cptu') }}",
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
            if(data!='0'){
                $('#nameList').fadeIn();
                $('#nameList').html(data);
            }
            else{
                   
          }
            }
         });           
        }
            else if(query==''){
                
        }
    });

$(document).on('click', '#list', function(){
   az ='1';
   //$('#message2').hide();
  $('#first_name').attr('style','border-bottom:1px solid #ced4da');
        var name = $(this).text();
        var details=[]
        var details=name.split(' ');
        var first = details[0];
        var last = details[1];
        var _token = $('input[name="_token"]').val();
        //console.log(name);
        $.ajax({
            url:"{{ route('autocomplete.allcptu') }}",
            method:"GET",
            data:{first:first, last:last, _token:_token}
            //success:function(data){
            //console.log(data); 
        })

      .done(function(data){
        //console.log(data);
        $('#first_name').val(data.first);
        $('#last_name').val(data.last);
        $('#centre_name').val(data.centre);
        $('#faculty_name').val(data.dep);
        $('#email').val(data.email);
        $('#designation').val(data.designation);
      });      
       // $('#first_name').val($(this).text());
        //$('#nameList').fadeOut();

    });

   $(document).on('click', 'form', function(){
     $('#nameList').fadeOut();
    });

    $("#centre_name").change(function(){
         var query = $(this).val();  
        $("#centre_name option:selected").text(query);
    });
});
</script>
@endsection
